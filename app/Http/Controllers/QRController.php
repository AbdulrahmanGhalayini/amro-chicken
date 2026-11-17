<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
    public function generate($slug)
    {
        $business = Business::where('slug', $slug)->firstOrFail();
        
        $menuUrl = route('menu.show', ['slug' => $business->slug]);
//        dd($menuUrl);
        
        $qr = QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->generate($menuUrl);
        
        return response($qr, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'inline; filename="qr-'.$slug.'.svg"');
    }
}