<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Collection as ModelsCollection;
use App\Models\Project;
use App\Traits\Common;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Collection extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:collection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collection Uploaded Successfully';

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

            $collections = DB::select("
            SELECT 
                crwcolcode,
                project,
                MAX(category_id) AS category_id
            FROM localproducts
            WHERE project = 'SIL SOLID IDOL'
              AND crwcolcode IS NOT NULL
              AND crwcolcode != ''
            GROUP BY crwcolcode, project
            ORDER BY crwcolcode ASC
        ");

            $this->output->progressStart(count($collections));

            foreach ($collections as $item) {

                $projectId = Project::where('project_name', $item->project)->value('id');

                if (!$projectId || empty($item->crwcolcode)) {
                    $this->output->progressAdvance();
                    continue;
                }

                $categoryId = Category::where('project_id', $projectId)
                    ->where('category_name', $item->category_id)
                    ->value('id');

                ModelsCollection::firstOrCreate(
                    [
                        'project_id' => $projectId,
                        'collection_name' => $item->crwcolcode,
                    ],
                    [
                        'category_id' => $categoryId,
                    ]
                );

                $this->output->progressAdvance();
            }

            DB::commit();
            $this->output->progressFinish();
            $this->info('✅ Collections updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            $this->error('❌ Collections update failed: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            $this->error('❌ Collections update failed: ' . $e->getMessage());
        }
    }
}
