<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Generic;
use App\Models\Manufacturer;
use App\Support\Traits\Destroyable;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use Destroyable;

    public $model = Comment::class; // used in Destroyable Trait

    public function manufacturer(Request $request, Manufacturer $manufacturer)
    {
        $item = $manufacturer;
        $item->loadComments();

        return view('comments.manufacturer', compact('item'));
    }

    public function generic(Request $request, Generic $generic)
    {
        $item = $generic;
        $item->loadComments();

        return view('comments.generic', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $model = $request->input('commentable_type');
        $instance = $model::find($request->id);

        $instance->comments()->save(
            new Comment(['body' => $request->body, 'user_id' => $request->user()->id, 'created_at' => now()])
        );

        return redirect()->back();
    }

    public function edit(Comment $item)
    {
        return view('comments.edit', compact('item'));
    }

    public function update(UpdateCommentRequest $request, Comment $item)
    {
        $item->updateFromRequest($request);

        return redirect($request->input('previous_url'));
    }
}
