<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LicenseController extends Controller
{
    public function suspended()
    {
        $user = auth()->user();
        $business = $user->business;
        $license = $business?->license;

        return view('admin.license.suspended', compact('business', 'license'));
    }
}
