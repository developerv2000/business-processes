<?php

/**
 * Custom Helper class
 *
 * @author Bobur Nuridinov <bobnuridinov@gmail.com>
 */

namespace App\Support;

use App\Models\ProductForm;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Image;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Helper
{
    /**
     * Used in generating sort links & quering eloquent models
     */
    public static function getRequestParamsFor($model): array
    {
        $request = request();

        $params = [
            'orderBy' => $request->orderBy ?: $model::DEFAULT_ORDER_BY,
            'orderType' => $request->orderType ?: $model::DEFAULT_ORDER_TYPE,
            'paginationLimit' => $request->paginationLimit ?: $model::DEFAULT_PAGINATION_LIMIT,
            'currentPage' => LengthAwarePaginator::resolveCurrentPage(),
        ];

        $params['newOrderUrl'] = self::setupNewOrderUrl($params['orderType']);

        return $params;
    }

    /**
     * Add previous url query params to request,
     * because model items are filtered due to request params
     */
    public static function addExportParamsToRequest()
    {
        $request = request();
        $url = url()->previous();
        $queryString = parse_url($url, PHP_URL_QUERY);
        parse_str($queryString, $queryParams);

        foreach ($queryParams as $key => $value) {
            $request->{$key} = $value;
        }
    }

    public static function filterWhereColumns($items, $columns)
    {
        $request = request();

        foreach ($columns as $column) {
            if (!isset($request->{$column})) continue;
            $items = $items->where($column, $request->{$column});
        }

        return $items;
    }

    public static function filterWhereDateColumns($items, $columns)
    {
        $request = request();

        foreach ($columns as $column) {
            if (!isset($request->{$column})) continue;
            $items = $items->whereDate($column, $request->{$column});
        }

        return $items;
    }

    public static function filterWhereLikeColumns($items, $columns)
    {
        $request = request();

        foreach ($columns as $column) {
            if (!isset($request->{$column})) continue;
            $items = $items->where($column, 'LIKE', '%' . $request->{$column} . '%');
        }

        return $items;
    }

    public static function filterWhereDateRangeColumns($items, $columns)
    {
        $request = request();

        foreach ($columns as $column) {
            $dates = $request->{$column};
            if (!$dates) continue;

            // Split from & to dates
            $splitted = explode(' - ', $dates);
            $fromDate = Carbon::createFromFormat('d/m/Y', $splitted[0])->format('Y-m-d');
            $toDate = Carbon::createFromFormat('d/m/Y', $splitted[1])->format('Y-m-d');

            $items = $items
                ->whereDate($column, '>=', $fromDate)
                ->whereDate($column, '<', $toDate);
        }

        return $items;
    }

    public static function filterBelongsToManyRelations($items, $columns)
    {
        $request = request();

        foreach ($columns as $column) {
            if (!isset($request->{$column})) continue;

            $IDs = $request->{$column};

            $items = $items->whereHas($column, function ($query) use ($IDs) {
                $query->whereIn('id', $IDs);
            });
        }

        return $items;
    }

    public static function filterWhereRelationColumns($items, $columns)
    {
        $request = request();

        foreach ($columns as $column) {
            if (!isset($request->{$column['name']})) continue;

            $items = $items->whereHas($column['relationName'], function ($query) use ($column, $request) {
                $query->where($column['name'], $request->{$column['name']});
            });
        }

        return $items;
    }

    public static function filterWhereRelationLikeColumns($items, $columns)
    {
        $request = request();

        foreach ($columns as $column) {
            if (!isset($request->{$column['name']})) continue;

            $items = $items->whereHas($column['relationName'], function ($query) use ($column, $request) {
                $query->where($column['name'], 'LIKE', '%' . $request->{$column['name']} . '%');
            });
        }

        return $items;
    }

    /**
     * Sometimes there may be ambigious situations
     * For example, while filtering process,
     * both process and its manufacturer relation has got ID`s,
     * but we need to filter manufacturers.id
     * While filtering id can cause ambigious where clause
     */
    public static function filterWhereRelationAmbigiousColumns($items, $columns)
    {
        $request = request();

        foreach ($columns as $column) {
            if (!isset($request->{$column['name']})) continue;

            $items = $items->whereHas($column['relationName'], function ($query) use ($column, $request) {
                $query->where($column['ambigiousNme'], $request->{$column['name']});
            });
        }

        return $items;
    }

    public static function generateSlug($string): string
    {
        $transilation = self::transliterateIntoLatin($string);

        // remove unwanted characters
        $transilation = preg_replace('~[^-\w]+~', '', $transilation);

        // remove duplicate dividers
        $transilation = preg_replace('~-+~', '-', $transilation);

        $transilation = trim($transilation, '-');
        $slug = strtolower($transilation);

        return $slug;
    }

    public static function deleteArrayKeyIfExists(&$array, $key)
    {
        if (array_key_exists($key, $array)) {
            unset($array[$key]);
        }
    }

    /**
     * Upload models file
     *
     * @param \Eloquent\Model $model
     * @param string $attribute - input & models attribute name
     * @param string $filename
     * @param string $storePath
     * @return string uploaded file path
     */
    public static function uploadModelFile($model, $attribute, $fileName, $storePath): string
    {
        $file = request()->file($attribute);
        $name = self::cutAndTrimString($fileName, 80);
        $fullName = $name . '.' . $file->getClientOriginalExtension();
        $fullName = self::escapeDuplicateFilename($fullName, $storePath);

        $file->move($storePath, $fullName);
        $model->{$attribute} = $fullName;
        $model->save();

        return $storePath . '/' . $fullName;
    }

    public static function resizeImage($path, $width, $height): void
    {
        $image = Image::make($path);

        // fit
        if ($width && $height) {
            $image->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            }, 'center');

            // aspect ratio
        } else {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $image->save($path);
    }

    public static function parseFormsFromExcel()
    {
        $file = storage_path('app/excel/data/forms.xlsx');

        $spreadsheet = IOFactory::load($file);
        $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
        $forms = [];

        for ($i = 2; $i <= $highestRow; $i++) {
            $parentName = $spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue();
            $parent = ProductForm::where('name', $parentName)->first();

            $forms[] = [
                'name' => $spreadsheet->getActiveSheet()->getCell('B' . $i)->getValue(),
                'parent_id' => $parent->id,
            ];
        }

        $arrayString = var_export($forms, true);
        dd($arrayString);
    }

    public static function parseMnnsFromExcel()
    {
        $file = storage_path('app/excel/data/mnn.xlsx');

        $spreadsheet = IOFactory::load($file);
        $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
        $mnns = [];

        for ($i = 3; $i <= $highestRow; $i++) {
            $mnns[] = $spreadsheet->getActiveSheet()->getCell('B' . $i)->getValue();
        }

        return $mnns;
    }

    /**
     * Rename file, if file with a given name is already exists in the givven path
     * Renaming style name(i++)
     *
     * @param string $filename
     * @param string $path
     */
    public static function escapeDuplicateFilename($filename, $path): string
    {
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $path = $path . '/';

        $originalName = $name;
        $counter = 1;

        while (file_exists($path . $filename)) {
            $name = $originalName . '(' . $counter . ')';
            $filename = $name . '.' . $extension;
            $counter++;
        }

        return $filename;
    }

    public static function formatPriceNumber($price)
    {
        return number_format(intval($price), 0, ',', ' ');
    }

    private static function reverseOrderType($orderType): string
    {
        return $orderType == 'asc' ? 'desc' : 'asc';
    }

    private static function setupNewOrderUrl($currentOrderType)
    {
        $url = url()->current();
        $queryParams = request()->query();

        // remove orderBy
        self::deleteArrayKeyIfExists($queryParams, 'orderBy');

        // reverse orderType
        $queryParams['orderType'] = self::reverseOrderType($currentOrderType);

        $fullUrl = $url . '?' . http_build_query($queryParams);

        return $fullUrl;
    }

    private static function cutAndTrimString($string, $length): string
    {
        if (mb_strlen($string) < $length) {
            $string = mb_substr($string, 0, $length);
        }

        $string = trim($string);

        return $string;
    }

    private static function transliterateIntoLatin($string): string
    {
        $search = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
            'ӣ', 'ӯ', 'ҳ', 'қ', 'ҷ', 'ғ', 'Ғ', 'Ӣ', 'Ӯ', 'Ҳ', 'Қ', 'Ҷ',
            ' ', '_'
        ];


        $replace = [
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'shb', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'shb', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'i', 'u', 'h', 'q', 'j', 'g', 'g', 'i', 'u', 'h', 'q', 'j',
            '-', '-'
        ];

        // manual transilation
        $transilation = str_replace($search, $replace, $string);

        // auto transilation
        $transilation = Str::ascii($transilation);

        return $transilation;
    }
}
