<?php

namespace App\Http\Controllers;

use App\Models\Mnn;
use App\Http\Requests\StoreMnnRequest;
use App\Http\Requests\UpdateMnnRequest;
use App\Support\Helper;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class MnnController extends Controller
{
    use Destroyable;

    public $model = Mnn::class; // used in Destroyable Trait

    public function index(Request $request)
    {
        $params = self::getRequestParams();
        $items = Mnn::getItemsFinalized($params);

        return view('mnns.index', compact('params', 'items'));
    }

    public function create()
    {
        return view('mnns.create');
    }

    public function store(StoreMnnRequest $request)
    {
        Mnn::createFromRequest($request);

        return to_route('mnns.index');
    }

    public function edit(Mnn $item)
    {
        return view('mnns.edit', compact('item'));
    }

    public function update(UpdateMnnRequest $request, Mnn $item)
    {
        $item->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }

    private function getRequestParams()
    {
        return Helper::getRequestParamsFor(Mnn::class);
    }
}
