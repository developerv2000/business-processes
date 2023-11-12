<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Meeting;
use App\Models\User;
use App\Support\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    use Destroyable;

    public $model = Meeting::class; // used in Destroyable Trait

    public function index(Request $request)
    {
        $params = self::getRequestParams();
        $items = Meeting::getItemsFinalized($params);

        $allColumns = collect($request->user()->settings['meetingColumns']);
        $visibleColumns = User::filterVisibleColumns($allColumns);

        return view('meetings.index', compact('params', 'items', 'allColumns', 'visibleColumns'));
    }

    public function trash(Request $request)
    {
        $params = self::getRequestParams();
        $trashedItems = Meeting::onlyTrashed();
        $items = Meeting::getItemsFinalized($params, $trashedItems);

        return view('meetings.trash', compact('params', 'items'));
    }

    public function create()
    {
        return view('meetings.create');
    }

    public function store(StoreMeetingRequest $request)
    {
        Meeting::createFromRequest($request);

        return to_route('meetings.index');
    }

    public function edit(Meeting $item)
    {
        return view('meetings.edit', compact('item'));
    }

    public function update(UpdateMeetingRequest $request, Meeting $item)
    {
        $item->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }

    private function getRequestParams()
    {
        return Helper::getRequestParamsFor(Meeting::class);
    }
}
