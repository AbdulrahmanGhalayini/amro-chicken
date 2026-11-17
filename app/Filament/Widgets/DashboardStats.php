<?php

namespace App\Filament\Widgets;

use App\Models\Business;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Visit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $stats = [];

        if ($user->hasRole('super_admin')) {
            // Super admin stats
            $stats[] = Stat::make(
                'Total Businesses',
                Business::count()
            )
            ->description('All businesses in the system')
            ->color('success');

            $stats[] = Stat::make(
                'Total Products',
                Product::count()
            )
            ->description('All products in the system')
            ->color('info');

            $stats[] = Stat::make(
                'Total Customers',
                Customer::count()
            )
            ->description('All registered customers')
            ->color('warning');

            $stats[] = Stat::make(
                'Total Visits',
                Visit::count()
            )
            ->description('Total menu visits')
            ->color('danger');
        } 
        elseif ($user->hasRole('admin')) {
            // Business admin stats - businesses created by this user
            $businesses = Business::join('businesses_users', 'businesses.id', '=', 'businesses_users.business_id')
                ->where('businesses_users.created_by', $user->id)
                ->select('businesses.id')
                ->get();
            $businessCount = count($businesses);
            
            $stats[] = Stat::make(
                'Businesses Created',
                $businessCount
            )
            ->description('Businesses created by me')
            ->color('success');

            $totalVisits = Visit::whereIn('business_id', $businesses)->count();
            
            $stats[] = Stat::make(
                'Total Visits',
                $totalVisits
            )
            ->description('Visits to my businesses')
            ->color('danger');
        } 
        elseif ($user->hasRole('business_admin')) {
            // Business manager stats
            $business = $user->businesses()->first();
            
            if ($business) {
                $productCount = Product::where('business_id', $business->id)->count();
                
                $stats[] = Stat::make(
                    'Products',
                    $productCount
                )
                ->description('Products in my business')
                ->color('info');

                $visitCount = Visit::where('business_id', $business->id)->count();
                
                $stats[] = Stat::make(
                    'Total Visits',
                    $visitCount
                )
                ->description('Visits to my business')
                ->color('danger');
            }
        }

        return $stats;
    }
}
