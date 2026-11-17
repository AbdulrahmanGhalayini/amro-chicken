<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Visit;
use App;
use Illuminate\Routing\Controller;

class MenuController extends Controller
{
  public function show($slug)
    {
        $business = Business::where('slug', $slug)->firstOrFail();
        
        if (!$business->active) {
            abort(404);
        }
        
        $categories = Category::where('business_id', $business->id)
            ->where('active', true)
            ->whereHas('products', function ($query) {
                $query->where('active', true);
            })
            ->with(['products' => function ($query) {
                $query->where('active', true)
                    ->orderBy('sort_order', 'asc')
                    ->with(['garnishes' => function ($garnishQuery) {
                        $garnishQuery->orderBy('sort_order', 'asc');
                    }]);
            }])
            ->orderBy('sort_order', 'asc')
            ->get();
        
        
            // Determine locale
            
        $locale = $this->getLocaleForBusiness($business);
        // dd($locale);
        app()->setLocale($locale);
        
        // Apply localized content
        $this->applyLocalization($business, $locale);
        $categories->each(fn($category) => 
            $this->applyLocalization($category, $locale)
                ->products->each(fn($product) => 
                    $this->applyLocalization($product, $locale)
                        ->garnishes->each(fn($garnish) => 
                            $this->applyLocalization($garnish, $locale)
                        )
                )
        );
        
        // Get active offers for this business
        $offers = Offer::where('business_id', $business->id)
            ->where('active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
        
        // Apply localization to offers
        $offers->each(fn($offer) => $this->applyLocalization($offer, $locale));
        Visit::create(['business_id' => $business->id]);
        return view('menu', ['business' => $business, 'categories' => $categories, 'offers' => $offers]);
    }
    
    private function getLocaleForBusiness(Business $business): string
    {   
        // Get locale from session first, otherwise use app default
        $currentLocale = session()->has('locale') 
            ? session()->get('locale')[0] 
            : app()->getLocale();
        
        if ($business->language == 'ar') {
            return 'ar';
        } elseif ($business->language == 'en') {
            return 'en';
        } elseif ($business->language == 'both') {
            return $currentLocale;
        }
        return $currentLocale;
    }
    
    private function applyLocalization($model, string $locale)
    {
        $suffix = $locale == 'ar' ? '_ar' : '_en';
        $fields = ['name', 'slogan', 'location', 'recipe'];
        
        foreach ($fields as $field) {
            $localizedField = $field . $suffix;
            if (isset($model->$localizedField)) {
                $model->$field = $model->$localizedField;
            }
        }
        
        return $model;
    }
}


