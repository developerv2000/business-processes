<?php

namespace App\Http\Controllers;

use App\Models\Kvpp;
use App\Http\Requests\StoreKvppRequest;
use App\Http\Requests\UpdateKvppRequest;
use App\Models\User;
use App\Support\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class KvppController extends Controller
{
    use Destroyable;

    public $model = Kvpp::class; // used in Destroyable Trait

    public function index(Request $request)
    {
        $params = self::getRequestParams();
        $items = Kvpp::getItemsFinalized($params);

        $allColumns = collect($request->user()->settings['kvppColumns']);
        $visibleColumns = User::filterVisibleColumns($allColumns);

        return view('kvpp.index', compact('params', 'items', 'allColumns', 'visibleColumns'));
    }

    public function trash(Request $request)
    {
        $params = self::getRequestParams();
        $trashedItems = Generic::onlyTrashed();
        $items = Generic::getItemsFinalized($params, $trashedItems);

        return view('generics.trash', compact('params', 'items'));
    }

    public function create()
    {
        return view('generics.create');
    }

    public function store(StoreGenericRequest $request)
    {
        Generic::createFromRequest($request);

        return to_route('generics.index');
    }

    public function edit(Generic $item)
    {
        return view('generics.edit', compact('item'));
    }

    public function update(UpdateGenericRequest $request, Generic $item)
    {
        $item->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }

    public function getSimilarProducts(Request $request)
    {
        $similarProducts = Generic::getSimilarProducts($request);

        return view('generics.similar-products', compact('similarProducts'));
    }

    public function export()
    {
        Helper::addExportParamsToRequest();
        $params = self::getRequestParams();
        $items = Generic::getItemsFinalized($params, null, 'query');

        return Generic::exportItems($items);
    }

    private function getRequestParams()
    {
        return Helper::getRequestParamsFor(Kvpp::class);
    }
}
