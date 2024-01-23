<?php

namespace App\Http\Controllers;

/**
 * Controller used to handle CRUID methods
 * of models with identical fields (ID, name)
 *
 * Listed models must have usageCount attribute defined
 */

use Illuminate\Http\Request;

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
        $modelFullName = 'App\Models\\' . $model;
        $items = $modelFullName::orderBy('name')->paginate('50');

        return view('identical-models.index', compact('model', 'items'));
    }
}
