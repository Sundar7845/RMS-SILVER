<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Product;
use App\Models\Project;
use App\Models\Style;
use App\Models\SubCategory;
use App\Models\SubCollection;
use App\Models\Unit;
use App\Traits\Common;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Products extends Command
{
    use Common;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

            /* ---------------------------------
             | Cache lookup tables (PERFORMANCE)
             ---------------------------------*/
            $projects = Project::pluck('id', 'project_name')->toArray();
            $colors = Color::pluck('id', 'color_name')->toArray();
            $styles = Style::pluck('id', 'style_name')->toArray();
            $units = Unit::pluck('id', 'unit_name')->toArray();

            $categories = Category::select('id', 'category_name', 'project_id')->get();
            $subCategories = SubCategory::select('id', 'sub_category_name', 'project_id')->get();
            $collections = Collection::select('id', 'collection_name', 'project_id')->get();
            $subCollections = SubCollection::select('id', 'sub_collection_name', 'project_id')->get();

            /* ---------------------------------
             | Fetch source data
             ---------------------------------*/
            $items = DB::select("
                SELECT *
                FROM localproducts
                WHERE project = 'SIL SOLID IDOL'
                ORDER BY id ASC
            ");

            $this->output->progressStart(count($items));

            foreach ($items as $item) {

                /* ---------------------------
                 | Resolve Project
                 ---------------------------*/
                $projectId = $projects[$item->project] ?? null;

                if (!$projectId) {
                    $this->output->progressAdvance();
                    continue;
                }

                /* ---------------------------
                 | Lookups (SAFE)
                 ---------------------------*/
                $colorId = !empty($item->default_color)
                    ? ($colors[$item->default_color] ?? null)
                    : null;

                $styleId = !empty($item->default_style)
                    ? ($styles[$item->default_style] ?? null)
                    : null;

                $categoryId = optional(
                    $categories
                        ->where('project_id', $projectId)
                        ->firstWhere('category_name', $item->category_id ?? null)
                )->id;

                $subCategoryId = optional(
                    $subCategories
                        ->where('project_id', $projectId)
                        ->firstWhere('sub_category_name', $item->sub_category ?? null)
                )->id;

                $collectionId = optional(
                    $collections
                        ->where('project_id', $projectId)
                        ->firstWhere('collection_name', $item->crwcolcode ?? null)
                )->id;

                $subCollectionId = optional(
                    $subCollections
                        ->where('project_id', $projectId)
                        ->firstWhere('sub_collection_name', $item->crwsubcolcode ?? null)
                )->id;

                $unitId = !empty($item->unit_id)
                    ? ($units[$item->unit_id] ?? null)
                    : null;

                /* ---------------------------
                 | Finish fallback logic
                 ---------------------------*/
                $finishId = ($projectId == 2) ? 7 : 1;

                /* ---------------------------
                 | UPSERT PRODUCT (CORRECT)
                 ---------------------------*/
                Product::updateOrCreate(
                    [
                        'product_unique_id' => $item->product_unique_id,
                    ],
                    [
                        'product_image' => $item->product_unique_id . '.jpg',
                        'product_name' => $item->product_name,

                        'height' => $item->height ?? null,
                        'width' => $item->width ?? null,
                        'weight' => $item->weight ?? null,
                        'net_weight' => $item->net_weight ?? null,

                        'product_carat' => $item->default_carat ?? null,

                        'color_id' => $colorId,
                        'style_id' => $styleId,
                        'finish_id' => $finishId,
                        'project_id' => $projectId,

                        'category_id' => $categoryId,
                        'sub_category_id' => $subCategoryId,
                        'collection_id' => $collectionId,
                        'sub_collection_id' => $subCollectionId,

                        'metal_type_id' => $item->metal_type ?? null,
                        'plating_id' => 1,

                        'making_percent' => $item->making_percent ?? null,
                        'moq' => 1,

                        'crwcolcode' => $item->crwcolcode ?? null,
                        'crwsubcolcode' => $item->crwsubcolcode ?? null,

                        'gender' => $item->gender ?? null,
                        'cwqty' => $item->cw_qty ?? null,
                        'unit_id' => $unitId,

                        'keywordtags' => $item->keyword_tag ?? null,
                        'otherrate' => $item->other_rate ?? 0.00,

                        'created_by' => 1,
                    ]
                );

                $this->output->progressAdvance();
            }

            DB::commit();
            $this->output->progressFinish();
            $this->info('✅ Products imported successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            $this->error('❌ DB Error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            $this->error('❌ Error: ' . $e->getMessage());
        }
    }
}
