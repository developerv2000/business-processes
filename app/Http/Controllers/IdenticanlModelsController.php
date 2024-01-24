<?php

namespace App\Http\Controllers;

/**
 * Controller used to handle CRUID methods
 * of models with identical fields (ID, name)
 *
 * Listed models must have usageCount attribute defined
 */

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class IdenticanlModelsController extends Controller
{
    // List of models that can use this feature
    const LIST = [
        'Blacklist',
        'Country',
        'CountryCode',
        'ExpirationDate',
        'KvppPriority',
        'KvppSource',
        'KvppStatus',
        'ManufacturerCategory',
        'Mnn',
        'PortfolioManager',
        'ProcessOwner',
        'ProductCategory',
        'PromoCompany',
        'Zone',
    ];

    public function list()
    {
        $models = self::LIST;
        $items = [];

        // Add items count
        foreach ($models as $model) {
            $modelFullName = 'App\Models\\' . $model;

            $items[] = [
                'name' => $model,
                'count' => $modelFullName::count(),
            ];
        }

        return view('identical-models.list', compact('items'));
    }

    public function index(Request $request)
    {
        $model = $request->model;
        $modelFullName = self::getModelFullName();
        $items = $modelFullName::orderBy('name')->paginate('50');

        return view('identical-models.index', compact('model', 'items'));
    }

    public function create(Request $request)
    {
        $model = $request->model;

        return view('identical-models.create', compact('model'));
    }

    public function store(Request $request)
    {
        $model = $request->model;
        $modelFullName = self::getModelFullName();
        $name = $request->name;

        // Escape uniqness error
        $alreadyExists = $modelFullName::where('name', $name)->first();
        if ($alreadyExists) {
            throw ValidationException::withMessages([
                'name' => trans('validation.unique'),
            ]);
        }

        $item = new $modelFullName;
        $item->name = $name;
        $item->save();

        return to_route('identical-models.index', $model);
    }

    public function edit(Request $request)
    {
        $model = $request->model;
        $modelFullName = self::getModelFullName();
        $item = $modelFullName::find($request->id);

        return view('identical-models.edit', compact('model', 'item'));
    }

    public function update(Request $request, $id)
    {
        $model = $request->model;
        $modelFullName = self::getModelFullName();
        $name = $request->name;

        // Escape uniqness error
        $alreadyExists = $modelFullName::where('name', $name)->whereNot('id', $id)->first();
        if ($alreadyExists) {
            throw ValidationException::withMessages([
                'name' => trans('validation.unique'),
            ]);
        }

        $item = $modelFullName::find($id);
        $item->name = $name;
        $item->save();

        return to_route('identical-models.index', $model);
    }

    public function destroy(Request $request)
    {
        $ids = (array) $request->input('ids');
        $modelFullName = self::getModelFullName();

        foreach ($ids as $id) {
            $item = $modelFullName::find($id);

            // Escape deleting is being used items
            if ($item->usage_count) {
                return redirect()->back()->withErrors([
                    trans('validation.is-being-used', ['name' => $item->name])
                ]);
            }

            $item->delete();
        }

        return redirect()->back();
    }

    private static function getModelFullName()
    {
        return 'App\Models\\' . request()->model;
    }
}
