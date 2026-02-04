<?php

namespace App\Console\Commands;

use App\Models\Collection;
use App\Models\Project;
use App\Models\SubCollection as ModelsSubCollection;
use App\Traits\Common;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class subcollection extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:subcollection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subcollection uploaded successfully';

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

            $subCollections = DB::select("
            SELECT 
                crwcolcode,
                crwsubcolcode,
                project
            FROM localproducts
            WHERE project = 'SIL SOLID IDOL'
              AND crwcolcode IS NOT NULL
              AND crwcolcode != ''
              AND crwsubcolcode IS NOT NULL
              AND crwsubcolcode != ''
            GROUP BY crwcolcode, crwsubcolcode, project
            ORDER BY crwcolcode ASC, crwsubcolcode ASC
        ");

            $this->output->progressStart(count($subCollections));

            foreach ($subCollections as $item) {

                $projectId = Project::where('project_name', $item->project)->value('id');

                if (!$projectId) {
                    $this->output->progressAdvance();
                    continue;
                }

                $collectionId = Collection::where('project_id', $projectId)
                    ->where('collection_name', $item->crwcolcode)
                    ->value('id');

                if (!$collectionId) {
                    $this->output->progressAdvance();
                    continue;
                }

                ModelsSubCollection::firstOrCreate(
                    [
                        'project_id' => $projectId,
                        'collection_id' => $collectionId,
                        'sub_collection_name' => $item->crwsubcolcode,
                    ]
                );

                $this->output->progressAdvance();
            }

            DB::commit();
            $this->output->progressFinish();
            $this->info('✅ Subcollections updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            $this->error('❌ Subcollections update failed: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            $this->error('❌ Subcollections update failed: ' . $e->getMessage());
        }
    }
}
