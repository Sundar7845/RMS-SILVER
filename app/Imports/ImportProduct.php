<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Classification;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Finish;
use App\Models\Product;
use App\Models\Project;
use App\Models\SilverPurity;
use App\Models\Size;
use App\Models\Style;
use App\Models\SubCategory;
use App\Models\SubCollection;
use App\Models\Unit;
use App\Traits\Common;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportProduct implements ToModel, WithHeadingRow
{
    use Common;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {

            // ✅ Validation
            $validator = Validator::make($row, [
                'product_unique_id' =>  'required',
                'product_name' => 'required|string'
            ]);

            if ($validator->fails()) {
                throw new Exception(
                    'Validation failed for product_unique_id: ' . ($row['product_unique_id'] ?? 'N/A')
                );
            }

            // Lookups
            $projectName = str_replace('SIL ', '', $row['project'] ?? '');
            $projectId = Project::where('project_name', 'like', '%' . $projectName . '%')->value('id');

            $colorId = !empty($row['default_color'] ?? null)
                ? Color::where('color_name', 'like', '%' . $row['default_color'] . '%')->value('id')
                : null;

            $styleId = !empty($row['default_style'] ?? null)
                ? Style::where('style_name', $row['default_style'])
                ->where('project_id', $projectId)
                ->value('id')
                : null;

            $finishId = Finish::where('finish_name', 'like', '%' . ($row['finish'] ?? '') . '%')
                ->where('project_id', $projectId)
                ->value('id')
                ?? (($projectId == 2) ? 7 : 1);

            $purityId = !empty($row['purity'] ?? null)
                ? SilverPurity::where('silver_purity_percentage', $row['purity'])->value('id')
                : null;

            $categoryId = !empty($row['category_id'] ?? null)
                ? Category::where('category_name', $row['category_id'])
                ->where('project_id', $projectId)
                ->value('id')
                : null;

            $subCategoryId = !empty($row['sub_category_id'] ?? null)
                ? SubCategory::where('sub_category_name', $row['sub_category_id'])
                ->where('project_id', $projectId)
                ->value('id')
                : null;

            $collectionId = !empty($row['crwcolcode'] ?? null)
                ? Collection::where('collection_name', $row['crwcolcode'])
                ->where('project_id', $projectId)
                ->value('id')
                : null;

            $subcollectionId = !empty($row['crwsubcolcode'] ?? null)
                ? SubCollection::where('sub_collection_name', $row['crwsubcolcode'])
                ->where('project_id', $projectId)
                ->value('id')
                : null;

            $classificationId = !empty($row['classification'] ?? null)
                ? Classification::where('classification_name', $row['classification'])->value('id')
                : null;

            $sizeId = !empty($row['size'] ?? null)
                ? Size::where('size_name', $row['size'])
                ->where('project_id', $projectId)
                ->value('id')
                : null;

            $unitId = !empty($row['unit_id'] ?? null)
                ? Unit::where('unit_name', $row['unit_id'])->value('id')
                : null;

            return new Product([
                'product_unique_id' => $row['product_unique_id'],
                'classification_id' => $classificationId,
                'product_name' => $row['product_name'],
                'product_image' => $row['product_unique_id'] . '.jpg',
                'height' => $row['height'],
                'width' => $row['width'],
                'weight' => $row['weight'],
                'product_carat' => $row['product_carat'],
                'color_id' => $colorId,
                'style_id' => $styleId,
                'finish_id' => $finishId,
                'size_id' => $sizeId,
                'project_id' => $projectId,
                'category_id' => $categoryId,
                'sub_category_id' => $subCategoryId,
                'collection_id' => $collectionId,
                'sub_collection_id' => $subcollectionId,
                'metal_type_id' => $row['metal_type_id'],
                'jewel_type_id' => $row['jewel_type_id'],
                'purity_id' => $purityId ?? null,
                'plating_id' => 1,
                'making_percent' => $row['making_percent'],
                'moq' => $row['moq'],
                'crwcolcode' => $row['crwcolcode'] == '' ? null : $row['crwcolcode'],
                'crwsubcolcode' => $row['crwsubcolcode'] == '' ? null : $row['crwsubcolcode'],
                'gender' => $row['gender'],
                'cwqty' => $row['cwqty'],
                'qty' => $row['qty'],
                'unit_id' => $unitId,
                'net_weight' => $row['net_weight'],
                'keywordtags' => $row['keywordtags'] == '' ? null : $row['keywordtags'],
                'otherrate' => $row['otherrate'],
                'created_by' => Auth::id() ?? 1
            ]);
        } catch (Exception $e) {

            // ✅ Log error & skip row
            $this->Log(
                __FUNCTION__,
                "POST",
                $e->getMessage(),
                Auth::id() ?? 1,
                request()->ip(),
                gethostname()
            );

            return null;
        }
    }
}
