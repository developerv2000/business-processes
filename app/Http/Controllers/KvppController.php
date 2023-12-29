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
        $trashedItems = Kvpp::onlyTrashed();
        $items = Kvpp::getItemsFinalized($params, $trashedItems);

        return view('kvpp.trash', compact('params', 'items'));
    }

    public function create()
    {
        return view('kvpp.create');
    }

    public function store(StoreKvppRequest $request)
    {
        Kvpp::createFromRequest($request);

        return to_route('kvpp.index');
    }

    public function edit(Kvpp $item)
    {
        return view('kvpp.edit', compact('item'));
    }

    public function update(UpdateKvppRequest $request, Kvpp $item)
    {
        $item->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }

    public function export()
    {
        Helper::addExportParamsToRequest();
        $params = self::getRequestParams();
        $items = Kvpp::getItemsFinalized($params, null, 'query');

        return Kvpp::exportItems($items);
    }

    private function getRequestParams()
    {
        return Helper::getRequestParamsFor(Kvpp::class);
    }
}
