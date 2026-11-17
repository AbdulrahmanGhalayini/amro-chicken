<?php

namespace App\Filament\Widgets;

use App\Models\Visit;
use App\Models\Business;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VisitsChart extends ChartWidget
{
    protected ?string $heading = 'Visits Trend (Last 12 Months)';
    protected string $color = 'info';

    protected function getData(): array
    {
        $user = Auth::user();
        
        // Get data for last 12 months
        $months = [];
        $data = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
        }

        if ($user->hasRole('super_admin')) {
            // All visits
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $count = Visit::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
                $data[] = $count;
            }
        } 
        elseif ($user->hasRole('admin')) {
            // Visits to businesses created by me
            $businesses = Business::join('businesses_users', 'businesses.id', '=', 'businesses_users.business_id')
                ->where('businesses_users.created_by', $user->id)
                ->select('businesses.id')
                ->get();
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $count = Visit::whereIn('business_id', $businesses)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
                $data[] = $count;
            }
        } 
        elseif ($user->hasRole('business_admin')) {
            // Visits to my business
            $business = $user->businesses()->first();
            if ($business) {
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $count = Visit::where('business_id', $business->id)
                        ->whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->count();
                    $data[] = $count;
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Visits',
                    'data' => $data,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
