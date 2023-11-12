<?php

namespace App\Support\Traits;

use Illuminate\Http\Request;

trait Destroyable
{
    public function destroy(Request $request)
    {
        $ids = (array) $request->input('ids');

        // Permanent delete
        if ($request->has('permanently')) {
            foreach ($ids as $id) {
                $this->model::withTrashed()->find($id)->forceDelete();
            }
        }
        // Trash
        else {
            foreach ($ids as $id) {
                $this->model::find($id)->delete();
            }
        }

        return redirect()->back();
    }

    public function restore(Request $request)
    {
        $ids = (array) $request->input('ids');

        foreach ($ids as $id) {
            $this->model::onlyTrashed()->find($id)->restore();
        }

        return redirect()->back();
    }
}
