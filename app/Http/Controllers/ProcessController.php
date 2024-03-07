<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Http\Requests\StoreProcessRequest;
use App\Http\Requests\UpdateProcessRequest;
use App\Models\CountryCode;
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

        if ($request->user()->isAdmin()) {
            $items->each(function ($item) {
                $item->loadStatusStagePeriods();
            });
        }

        $allColumns = collect($request->user()->settings['processColumns']);
        $visibleColumns = User::filterVisibleColumns($allColumns);

        return view('processes.index', compact('params', 'items', 'allColumns', 'visibleColumns'));
    }

    public function trash(Request $request)
    {
        $params = self::getRequestParams();
        $trashedItems = Process::onlyTrashed();
        $items = Process::getItemsFinalized($params, $trashedItems);

        return view('processes.trash', compact('params', 'items'));
    }

    public function create(Request $request)
    {
        $generic = Generic::find($request->generic_id);
        $generic->load('manufacturer');

        $proposedChildStatus = $generic->getProposedProcessStatus();
        $processStage = $proposedChildStatus->parent->stage; // used in stage inputs & year inputs views

        $countryCodesIDs = $request->input('country_code_ids', []);
        $selectedCountryCodes = CountryCode::whereIn('id', $countryCodesIDs)->get(); // used in year inputs view

        return view('processes.create.index', compact('generic', 'proposedChildStatus', 'processStage', 'selectedCountryCodes'));
    }

    /**
     * Return required stage inputs for each stage
     * on status select change
     */
    public function getCreateFormStageInputs(Request $request)
    {
        $generic = Generic::find($request->generic_id);
        $childStatus = ProcessStatus::find($request->status_id);
        $processStage = $childStatus->parent->stage;

        return view('processes.create.stage-inputs', compact('generic', 'processStage'));
    }

    /**
     * Return Year1 - Year3 inputs for each countries separately
     */
    public function getCreateFormYearInputs(Request $request)
    {
        $childStatus = ProcessStatus::find($request->status_id);
        $processStage = $childStatus->parent->stage;

        $countryCodesIDs = $request->input('country_code_ids', []);
        $selectedCountryCodes = CountryCode::whereIn('id', $countryCodesIDs)->get();

        return view('processes.create.year-inputs', compact('processStage', 'selectedCountryCodes'));
    }

    public function store(StoreProcessRequest $request)
    {
        Process::createFromRequest($request);

        return redirect($request->previous_url);
    }

    /**
     * Set process status_id for analysts
     * as stage fifth ('Кк') responsible child ID,
     * because only statusses with stage <= 5 are available for analysts
     *
     * its is used to select status 'Кк' on status_id select
     */
    public function edit(Process $item)
    {
        $stage = $item->status->parent->stage;

        if (!request()->user()->isAdmin() && $stage > 5) {
            $item->status->id = ProcessStatus::STAGE_FIVE_RESPONSIBLE_CHILD_ID;
        }

        return view('processes.edit.index', compact('item'));
    }

    /**
     * Return required stage inputs for each stage
     * on status select change
     */
    public function getEditFormStageInputs(Request $request)
    {
        $item = Process::find($request->process_id);
        $childStatus = ProcessStatus::find($request->status_id);
        $processStage = $childStatus->parent->stage;

        return view('processes.edit.stage-inputs', compact('item', 'processStage'));
    }

    public function update(UpdateProcessRequest $request, Process $item)
    {
        $item->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }

    public function export()
    {
        Helper::addExportParamsToRequest();
        $params = self::getRequestParams();
        $items = Process::getItemsFinalized($params, null, 'query');

        return Process::exportItems($items);
    }

    private function getRequestParams()
    {
        return Helper::getRequestParamsFor(Process::class);
    }
}
