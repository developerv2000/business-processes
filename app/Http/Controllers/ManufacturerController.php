<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManufacturerRequest;
use App\Http\Requests\UpdateManufacturerRequest;
use App\Models\Kvpp;
use App\Models\Manufacturer;
use App\Models\User;
use App\Support\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    use Destroyable;

    public $model = Manufacturer::class; // used in Destroyable Trait

    public function glb()
    {
        return view('glb');
    }

    public function index(Request $request)
    {
        $params = self::getRequestParams();
        $items = Manufacturer::getItemsFinalized($params);

        $allColumns = collect($request->user()->settings['manufacturerColumns']);
        $visibleColumns = User::filterVisibleColumns($allColumns);

        return view('manufacturers.index', compact('params', 'items', 'allColumns', 'visibleColumns'));
    }

    public function trash(Request $request)
    {
        $params = self::getRequestParams();
        $trashedItems = Manufacturer::onlyTrashed();
        $items = Manufacturer::getItemsFinalized($params, $trashedItems);

        return view('manufacturers.trash', compact('params', 'items'));
    }

    public function create()
    {
        return view('manufacturers.create');
    }

    public function store(StoreManufacturerRequest $request)
    {
        Manufacturer::createFromRequest($request);

        return to_route('manufacturers.index');
    }

    public function edit(Manufacturer $item)
    {
        return view('manufacturers.edit', compact('item'));
    }

    public function update(UpdateManufacturerRequest $request, Manufacturer $item)
    {
        $item->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }

    public function export()
    {
        Helper::addExportParamsToRequest();
        $params = self::getRequestParams();
        $items = Manufacturer::getItemsFinalized($params, null, 'query');

        return Manufacturer::exportItems($items);
    }

    private function getRequestParams()
    {
        return Helper::getRequestParamsFor(Manufacturer::class);
    }
}
