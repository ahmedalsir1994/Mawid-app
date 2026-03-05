<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class SuperAdminBillingController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('business')
            ->latest();

        // Search by invoice number, business name, or plan
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%")
                  ->orWhere('business_email', 'like', "%{$search}%");
            });
        }

        if ($plan = $request->input('plan')) {
            $query->where('plan', $plan);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($cycle = $request->input('cycle')) {
            $query->where('billing_cycle', $cycle);
        }

        $invoices = $query->paginate(20)->withQueryString();

        // Summary stats
        $totalRevenue     = Invoice::where('status', 'paid')->sum('amount');
        $monthRevenue     = Invoice::where('status', 'paid')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');
        $totalInvoices    = Invoice::count();
        $pendingInvoices  = Invoice::where('status', 'pending')->count();

        return view('admin.super.billing.index', compact(
            'invoices', 'totalRevenue', 'monthRevenue', 'totalInvoices', 'pendingInvoices'
        ));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('business');
        return view('admin.billing.invoice', compact('invoice'));
    }
}
