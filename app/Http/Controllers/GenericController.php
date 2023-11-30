<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenericRequest;
use App\Http\Requests\UpdateGenericRequest;
use App\Models\Generic;
use App\Models\User;
use App\Support\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class GenericController extends Controller
{
    use Destroyable;

    public $model = Generic::class; // used in Destroyable Trait

    public function index(Request $request)
    {
        $params = self::getRequestParams();
        $items = Generic::getItemsFinalized($params);

        $allColumns = collect($request->user()->settings['genericColumns']);
        $visibleColumns = User::filterVisibleColumns($allColumns);

        return view('generics.index', compact('params', 'items', 'allColumns', 'visibleColumns'));
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
        return Helper::getRequestParamsFor(Generic::class);
    }
}
