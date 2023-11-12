<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Support\Helper;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $params = self::getRequestParams();
        $items = User::getItemsFinalized($params);

        return view('users.index', compact('params', 'items'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        User::createFromRequest($request);

        return to_route('users.index');
    }

    public function edit(User $item)
    {
        return view('users.edit', compact('item'));
    }

    public function update(UpdateUserRequest $request, User $item)
    {
        $item->updateFromRequest($request, true);

        return redirect($request->input('previous_url'));
    }

    public function destroy(Request $request)
    {
        User::find($request->ids[0])->deleteByAdmin();

        return to_route('users.index');
    }

    private function getRequestParams()
    {
        return Helper::getRequestParamsFor(User::class);
    }
}
