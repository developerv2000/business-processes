<?php

namespace App\Models;

use App\Support\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Kvpp extends Model
{
    use HasFactory, SoftDeletes;

    const DEFAULT_ORDER_BY = 'created_at';
    const DEFAULT_ORDER_TYPE = 'desc';
    const DEFAULT_PAGINATION_LIMIT = 50;

    const STORAGE_EXCEL_TEMPLATE_PATH = 'app/excel/templates/kvpp.xlsx';
    const STORAGE_EXCEL_EXPORT_PATH = 'app/excel/exports/kvpp';

    protected $guarded = ['id'];

    protected $with = [
        'status',
        'countryCode',
        'priority',
        'source',
        'mnn',
        'form',
        'promoCompany',
        'portfolioManager',
        'analyst',
        'lastComment',
    ];

    // ********** Events **********
    protected static function booted(): void
    {
        static::forceDeleting(function ($item) {
            foreach ($item->comments as $comment) {
                $comment->delete();
            }
        });
    }

    // ********** Relations **********
    public function status()
    {
        return $this->belongsTo(KvppStatus::class, 'status_id');
    }

    public function countryCode()
    {
        return $this->belongsTo(CountryCode::class);
    }

    public function priority()
    {
        return $this->belongsTo(KvppPriority::class, 'priority_id');
    }

    public function source()
    {
        return $this->belongsTo(KvppSource::class, 'source_id');
    }

    public function mnn()
    {
        return $this->belongsTo(Mnn::class);
    }

    public function form()
    {
        return $this->belongsTo(ProductForm::class, 'form_id');
    }

    public function portfolioManager()
    {
        return $this->belongsTo(PortfolioManager::class);
    }

    public function promoCompany()
    {
        return $this->belongsTo(PromoCompany::class);
    }

    public function analyst()
    {
        return $this->belongsTo(User::class, 'analyst_user_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function lastComment()
    {
        return $this->morphOne(Comment::class, 'commentable')->latestOfMany();
    }

    // ********** Querying **********
    public static function getItemsFinalized($params, $items = null, $finaly = 'paginate')
    {
        $items = $items ?: self::query();
        $items = self::filter($items);
        $items = self::finalize($params, $items, $finaly);

        return $items;
    }

    private static function filter($items)
    {
        $whereColumns = [
            'country_code_id',
            'priority_id',
            'source_id',
            'mnn_id',
            'form_id',
            'portfolio_manager_id',
            'analyst_user_id',
            'promo_company_id',
        ];

        $whereLikeColumns = [
            'dose',
            'pack',
        ];

        $whereDateRangeColumns = [
            'created_at',
            'updated_at',
        ];

        $items = Helper::filterWhereColumns($items, $whereColumns);
        $items = Helper::filterWhereLikeColumns($items, $whereLikeColumns);
        $items = Helper::filterWhereDateRangeColumns($items, $whereDateRangeColumns);

        return $items;
    }

    private static function finalize($params, $items, $finaly)
    {
        $items = $items
            ->orderBy($params['orderBy'], $params['orderType'])
            ->orderBy('id', $params['orderType']);

        switch ($finaly) {
            case 'paginate':
                return $items->paginate($params['paginationLimit'], ['*'], 'page', $params['currentPage'])
                    ->appends(request()->except('page'));

            case 'get':
                return $items->get();

            case 'query':
                break;
        }

        return $items;
    }

    public static function getSimilarProducts($request)
    {
        // combine all available forms (parent and childs) in array
        $formFamilyIDs = ProductForm::find($request->form_id)->getFamilyIDs();

        return Kvpp::where('mnn_id', $request->mnn_id)
            ->whereIn('form_id', $formFamilyIDs)
            ->where('dose', $request->dose)
            ->where('pack', $request->pack)
            ->where('country_code_id', $request->country_code_id)
            ->get();
    }

    // ********** Miscellaneous **********
    public function getAllComments()
    {
        return $this->comments()->latest()->get();
    }

    public function loadComments()
    {
        return $this->load(['comments' => function ($query) {
            $query->orderBy('id', 'desc');
        }]);
    }

    public static function createFromRequest($request)
    {
        $promoCompanyIDs = $request->input('promo_company_ids');

        foreach ($promoCompanyIDs as $promoCompanyID) {
            $item = new self($request->all());
            $item->promo_company_id = $promoCompanyID;
            $item->save();

            // HasMany relations
            $item->storeComment($request->comment);
        }
    }

    public function updateFromRequest($request)
    {
        $this->update($request->all());

        // HasMany relations
        $this->storeComment($request->comment);
    }

    private function storeComment($comment)
    {
        if (!$comment) return;

        $this->comments()->save(
            new Comment(['body' => $comment, 'user_id' => request()->user()->id, 'created_at' => now()]),
        );
    }

    public static function exportItems($items)
    {
        $template = storage_path(self::STORAGE_EXCEL_TEMPLATE_PATH);
        $spreadsheet = IOFactory::load($template);
        $worksheet = $spreadsheet->getActiveSheet();
        $row = 2;

        // fill excel cells
        $items->chunk(400, function ($items) use (&$worksheet, &$row) {
            foreach ($items as $item) {
                $worksheet->setCellValue('A' . $row, $item->status->name);
                $worksheet->setCellValue('B' . $row, $item->countryCode->name);
                $worksheet->setCellValue('C' . $row, $item->priority->name);
                $worksheet->setCellValue('D' . $row, $item->source->name);
                $worksheet->setCellValue('E' . $row, $item->mnn->name);
                $worksheet->setCellValue('F' . $row, $item->form->name);
                $worksheet->setCellValue('G' . $row, $item->form->parent ? $item->form->parent->name : $item->form->name);
                $worksheet->setCellValue('H' . $row, $item->dose);
                $worksheet->setCellValue('I' . $row, $item->pack);
                $worksheet->setCellValue('J' . $row, $item->promoCompany->name);
                $worksheet->setCellValue('K' . $row, $item->info);

                $comments = $item->comments->pluck('body')->implode(' / ');
                $worksheet->setCellValue('L' . $row, $comments);

                $worksheet->setCellValue('M' . $row, $item->lastComment?->created_at);
                $worksheet->setCellValue('N' . $row, $item->date_of_forecast);
                $worksheet->setCellValue('O' . $row, $item->forecast_year_1);
                $worksheet->setCellValue('P' . $row, $item->forecast_year_2);
                $worksheet->setCellValue('Q' . $row, $item->forecast_year_3);
                $worksheet->setCellValue('R' . $row, $item->portfolioManager?->name);
                $worksheet->setCellValue('S' . $row, $item->analyst?->name);
                $worksheet->setCellValue('T' . $row, $item->created_at);
                $worksheet->setCellValue('U' . $row, $item->updated_at);
                $worksheet->setCellValue('V' . $row, $item->id);

                $row++;
            }
        });

        // save file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = date('Y-m-d H-i-s') . '.xlsx';
        $filename = Helper::escapeDuplicateFilename($filename, storage_path(self::STORAGE_EXCEL_EXPORT_PATH));
        $filePath = storage_path(self::STORAGE_EXCEL_EXPORT_PATH  . '/' . $filename);
        $writer->save($filePath);

        return response()->download($filePath);
    }

    /**
     * Used to highlight inactive table items <tr> background
     */
    public function notActive()
    {
        return $this->status->id != KvppStatus::getActiveItemID();
    }

    public function getCoincidentProcesses()
    {
        return Process::whereHas('generic', function ($query) {
            $query->where([
                'mnn_id' => $this->mnn_id,
                'form_id' => $this->form_id,
                'dose' => $this->dose,
                'pack' => $this->pack,
            ]);
        })
            ->where('country_code_id', $this->country_code_id)
            ->select('id', 'status_id')
            ->withOnly('status')
            ->get();
    }

    public function getCoincidentGenericsCount()
    {
        return Generic::where([
            'mnn_id' => $this->mnn_id,
            'form_id' => $this->form_id,
        ])->count();
    }

    public static function getAllUsedMnns()
    {
        $IDs = self::distinct()->pluck('mnn_id');
        $mnns = Mnn::whereIn('id', $IDs)->orderBy('name')->get();

        return $mnns;
    }

    public static function getAllUsedForms()
    {
        $IDs = self::distinct()->pluck('form_id');
        $forms = ProductForm::whereIn('id', $IDs)->orderBy('name')->get();

        return $forms;
    }

    public static function validatePromoCompanies()
    {
        self::onlyTrashed()->each(function ($item) {
            $item->delete();
        });

        self::withTrashed()->get()->each(function ($item) {
            $item->promo_company_id = DB::table('kvpp_promocompany')->where('kvpp_id', $item->id)->first()->promo_company_id;
            $item->save();
        });
    }
}
