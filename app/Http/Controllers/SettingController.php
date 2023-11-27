<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function updateManufacturers(Request $request)
    {
        $this->updateColumns($request, 'manufacturerColumns');

        return true;
    }

    public function updateMeetings(Request $request)
    {
        $this->updateColumns($request, 'meetingColumns');

        return true;
    }

    public function updateGenerics(Request $request)
    {
        $this->updateColumns($request, 'genericColumns');

        return true;
    }

    public function updateProcesses(Request $request)
    {
        $this->updateColumns($request, 'processColumns');

        return true;
    }

    public function updateFullWidth(Request $request)
    {
        $user = $request->user();
        $userSettings = $user->settings;

        // Inverse Full Width
        $userSettings['fullWidth'] = !$userSettings['fullWidth'];
        $user->update(['settings' => $userSettings]);

        return true;
    }

    public function updateLocale(Request $request)
    {
        $user = $request->user();
        $userSettings = $user->settings;

        // Update locale
        $userSettings['locale'] = $request->locale;
        $user->update(['settings' => $userSettings]);

        return redirect()->back();
    }

    private function updateColumns($request, $key)
    {
        $user = $request->user();
        $settings = $user->settings;
        $columns = collect($settings[$key]);

        // Update column only if it exists on users settings
        foreach ($request->columns as $requestColumn) {
            $columns->transform(function ($column) use ($requestColumn) {
                if ($column['name'] == $requestColumn['name']) {
                    $column['order'] = $requestColumn['order'];
                    $column['width'] = $requestColumn['width'];
                    $column['visible'] = $requestColumn['visible'];
                }
                return $column;
            });
        }

        $settings[$key] = $columns->sortBy('order')->values()->all();
        $user->update(['settings' => $settings]);
    }
}
