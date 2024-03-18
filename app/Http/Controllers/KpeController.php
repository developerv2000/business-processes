<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Models\ProcessStatus;
use Illuminate\Http\Request;

class KpeController extends Controller
{
    public function index(Request $request)
    {
        $monthes = [
            ['name' => 'January', 'number' => 1],
            ['name' => 'February', 'number' => 2],
            ['name' => 'March', 'number' => 3],
            ['name' => 'April', 'number' => 4],
            ['name' => 'May', 'number' => 5],
            ['name' => 'June', 'number' => 6],
            ['name' => 'July', 'number' => 7],
            ['name' => 'August', 'number' => 8],
            ['name' => 'September', 'number' => 9],
            ['name' => 'October', 'number' => 10],
            ['name' => 'November', 'number' => 11],
            ['name' => 'December', 'number' => 12],
        ];

        $statusses = ProcessStatus::whereNull('parent_id')->where('stage', '<=', 5)->get();
        $currentYear = date('Y');

        // calculate all 5 stages current status count by month (Table 1)
        foreach ($statusses as $status) {
            foreach ($monthes as &$month) {
                if ($status->stage <= 4) {
                    $month['stage_' . $status->stage . '_current_statusses_count'] =
                        Process::whereMonth('status_update_date', $month['number'])
                        ->whereYear('status_update_date', $currentYear)
                        ->whereHas('status.parent', function ($query) use ($status) {
                            $query->where('stage', $status->stage);
                        })
                        ->count();
                    // Stage 5 includes all other following stages
                } else {
                    $month['stage_' . $status->stage . '_current_statusses_count'] =
                        Process::whereMonth('status_update_date', $month['number'])
                        ->whereYear('status_update_date', $currentYear)
                        ->whereHas('status.parent', function ($query) {
                            $query->where('stage', '>=', 5);
                        })
                        ->count();
                }
            }
        }

        // add sum of all processes for each month (Table 1)
        foreach ($monthes as &$month) {
            $total = 0;

            foreach ($statusses as $status) {
                $total += $month['stage_' . $status->stage . '_current_statusses_count'];
            }

            $month['current_statusses_total_count'] = $total;
        }

        // add sum of all processes per year for each status (Table 1)
        foreach ($statusses as &$status) {
            $total = 0;

            foreach ($monthes as &$month) {
                $total += $month['stage_' . $status->stage . '_current_statusses_count'];
            }

            $status->total_per_year = $total;
        }

        // Calculate all processes count of current year stage 1 - 5. (Table 1)
        $yearTotalProcessesCount = 0;

        foreach ($monthes as $month) {
            $yearTotalProcessesCount += $month['current_statusses_total_count'];
        }

        return view('kpe.index', compact('monthes', 'statusses', 'yearTotalProcessesCount'));
    }
}
