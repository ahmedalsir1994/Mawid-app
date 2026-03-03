<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paymob Configuration  (Oman — Intention API)
    |--------------------------------------------------------------------------
    | Dashboard: https://oman.paymob.com/portal
    | Docs:      https://developers.paymob.com/paymob-docs
    |
    | Required env vars:
    |   PAYMOB_SECRET_KEY     — Token used in Authorization header
    |   PAYMOB_PUBLIC_KEY     — Used in the Unified Checkout URL
    |   PAYMOB_INTEGRATION_ID — Card integration ID from the dashboard
    |   PAYMOB_HMAC_SECRET    — For callback signature verification
    */

    // ── Credentials ──────────────────────────────────────────────────────
    'secret_key'     => env('PAYMOB_SECRET_KEY', ''),
    'public_key'     => env('PAYMOB_PUBLIC_KEY', ''),
    'integration_id' => env('PAYMOB_INTEGRATION_ID', ''),
    'hmac_secret'    => env('PAYMOB_HMAC_SECRET', ''),

    // ── Base URL (region-specific) ────────────────────────────────────────
    // Egypt: https://accept.paymob.com
    // Oman:  https://oman.paymob.com
    // KSA:   https://ksa.paymob.com
    // UAE:   https://uae.paymob.com
    'base_url' => env('PAYMOB_BASE_URL', 'https://oman.paymob.com'),

    // ── Endpoints (relative to base_url) ─────────────────────────────────
    'intention_path'  => '/v1/intention/',
    'checkout_path'   => '/unifiedcheckout/',

    // ── Payment settings ─────────────────────────────────────────────────
    'currency'   => 'OMR',      // 1 OMR = 1000 baisa (smallest unit)
    'expiration' => 3600,       // payment intention TTL in seconds

    // ── SSL verification ─────────────────────────────────────────────────
    // Set PAYMOB_VERIFY_SSL=false in .env on Windows/Laragon local dev where
    // PHP lacks a proper CA bundle. Always true in production.
    'verify_ssl' => env('PAYMOB_VERIFY_SSL', true),
];
