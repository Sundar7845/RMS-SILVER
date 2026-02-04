<?php

namespace App\Console\Commands;

use App\Models\Category as ModelsCategory;
use App\Models\Project;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Traits\Common;

class Category extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Category uploaded successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            $categories = DB::select("
            SELECT category_id, project
            FROM localproducts
            WHERE project = 'SIL SOLID IDOL'
            GROUP BY category_id, project
            ORDER BY category_id ASC
        ");

            $this->output->progressStart(count($categories));

            foreach ($categories as $item) {

                $projectId = Project::where('project_name', $item->project)->value('id');

                if (!$projectId || empty($item->category_id)) {
                    $this->output->progressAdvance();
                    continue;
                }

                ModelsCategory::firstOrCreate(
                    [
                        'project_id' => $projectId,
                        'category_name' => $item->category_id
                    ]
                );

                $this->output->progressAdvance();
            }

            DB::commit();
            $this->output->progressFinish();
            $this->info('✅ Category updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            $this->error('❌ Category update failed: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            $this->error('❌ Category update failed: ' . $e->getMessage());
        }
    }
}
