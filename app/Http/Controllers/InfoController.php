<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Http\Requests\StoreInfoRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Support\Helper;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public $model = Info::class; // used in Destroyable Trait

    /**
     * Display a listing of the resource.
     */
    public function show()
    {
        $blocks = Info::defaultOrder()->get()->toTree();

        return view('info.show', compact('blocks'));
    }

    public function index(Request $request)
    {
        $params = self::getRequestParams();
        $items = Info::getItemsFinalized($params);

        return view('info.index', compact('params', 'items'));
    }

    public function create()
    {
        return view('info.create');
    }

    public function store(StoreInfoRequest $request)
    {
        Info::createFromRequest($request);

        return to_route('info.index');
    }

    public function edit(Info $item)
    {
        return view('info.edit', compact('item'));
    }

    public function update(UpdateInfoRequest $request, Info $item)
    {
        $item->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }

    public function destroy(Request $request)
    {
        $ids = (array) $request->input('ids');

        foreach ($ids as $id) {
            Info::find($id)->delete();
        }

        return redirect()->back();
    }

    public function editNestedset(Request $request)
    {
        $items = Info::defaultOrder()->get()->toTree();

        return view('info.edit-structure', compact('items'));
    }

    public function updateNestedset(Request $request)
    {
        // pluck all items id
        $itemIDs = collect($request->itemsArray)->pluck('id');

        // pluck all removed items id
        $removedIDs = Info::whereNotIn('id', $itemIDs)->pluck('id');

        // Delete items explicitly (for correct working of model events)
        // While deleting item, childs also deleted, so that Eloquent events wont work
        // Thats why first childs deleted, than parents
        $childs = array();
        $parents = array();

        foreach ($removedIDs as $id) {
            $item = Info::find($id);

            $item->parent_id ? array_push($parents, $item) : array_push($childs, $item);
        }

        foreach ($childs as $child) {
            $child->delete();
        }

        foreach ($parents as $parent) {
            $parent->delete();
        }

        Info::rebuildTree($request->itemsHierarchy, false);
    }

    private function getRequestParams()
    {
        return Helper::getRequestParamsFor(Info::class);
    }
}
