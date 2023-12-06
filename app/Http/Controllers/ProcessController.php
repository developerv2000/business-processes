<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Http\Requests\StoreProcessRequest;
use App\Http\Requests\UpdateProcessRequest;
use App\Models\Generic;
use App\Models\ProcessStatus;
use App\Models\User;
use App\Support\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    use Destroyable;

    public $model = Process::class; // used in Destroyable Trait

    public function index(Request $request)
    {
        $params = self::getRequestParams();
        $items = Process::getItemsFinalized($params);

        $allColumns = collect($request->user()->settings['processColumns']);
        $visibleColumns = User::filterVisibleColumns($allColumns);

        return view('processes.index', compact('params', 'items', 'allColumns', 'visibleColumns'));
    }

    public function trash(Request $request)
    {
        $params = self::getRequestParams();
        $trashedItems = Generic::onlyTrashed();
        $items = Generic::getItemsFinalized($params, $trashedItems);

        return view('generics.trash', compact('params', 'items'));
    }

    public function create(Request $request)
    {
        $generic = Generic::find($request->generic_id);
        $generic->load('manufacturer');

        $proposedChildStatus = $generic->getProposedProcessStatus();
        $processStage = $proposedChildStatus->parent->stage;

        return view('processes.create', compact('generic', 'proposedChildStatus', 'processStage'));
    }

    public function getCreateInputs(Request $request)
    {
        $generic = Generic::find($request->generic_id);
        $childStatus = ProcessStatus::find($request->status_id);
        $processStage = $childStatus->parent->id;

        return view('processes.create-stage-inputs', compact('generic', 'processStage'));
    }

    public function store(StoreProcessRequest $request)
    {
        return redirect()->back();
        Process::createFromRequest($request);

        return to_route('processes.index');
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
        $items = Generic::getItemsFinalized($params, null, 'get');

        return Generic::exportItems($items);
    }

    private function getRequestParams()
    {
        return Helper::getRequestParamsFor(Process::class);
    }
}
