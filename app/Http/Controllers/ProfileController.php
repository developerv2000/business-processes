<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $item = $request->user();

        return view('profile.edit', compact('item'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->updateFromRequest($request, false);

        return redirect()->back();
    }
}
