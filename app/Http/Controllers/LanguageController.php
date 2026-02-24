<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     */
    public function switch(Request $request, $locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'ar'])) {
            abort(404);
        }

        // Store locale in session
        Session::put('locale', $locale);
        
        // Set application locale
        App::setLocale($locale);

        // Redirect back
        return redirect()->back();
    }
}
