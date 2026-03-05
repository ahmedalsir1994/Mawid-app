<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?php echo e($invoice->invoice_number); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <!-- Actions bar -->
    <div class="max-w-3xl mx-auto mb-4 flex justify-between items-center no-print">
        <button onclick="window.close()" class="text-sm text-gray-600 hover:text-gray-800">← Close</button>
        <div class="flex gap-3">
            <button id="btn-download" onclick="downloadPdf()"
               class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                <span id="btn-label">↓ Download PDF</span>
            </button>
            <button onclick="window.print()"
                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                🖨 Print
            </button>
        </div>
    </div>

    <script>
    function downloadPdf() {
        var btn   = document.getElementById('btn-download');
        var label = document.getElementById('btn-label');
        btn.disabled = true;
        label.textContent = 'Generating...';

        var element = document.getElementById('invoice-paper');
        var opt = {
            margin:      [10, 10, 10, 10],
            filename:    'invoice-<?php echo e($invoice->invoice_number); ?>.pdf',
            image:       { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, logging: false },
            jsPDF:       { unit: 'mm', format: 'a4', orientation: 'portrait' },
            pagebreak:   { mode: ['avoid-all'] }
        };

        html2pdf().set(opt).from(element).save().then(function() {
            btn.disabled = false;
            label.textContent = '↓ Download PDF';
        });
    }

    // Auto-download when opened with ?download=1
    window.addEventListener('load', function() {
        if (new URLSearchParams(window.location.search).get('download') === '1') {
            setTimeout(downloadPdf, 600);
        }
    });
    </script>

    <!-- Invoice Paper -->
    <div id="invoice-paper" class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-10">

        <!-- Header -->
        <div class="flex justify-between items-start mb-10">
            <div>
                <img src="/images/Mawid.png" alt="Mawid" class="h-12 mb-2">
                <p class="text-sm text-gray-500">mawid.app</p>
                <p class="text-sm text-gray-500">support@mawid.app</p>
            </div>
            <div class="text-right">
                <h1 class="text-3xl font-bold text-gray-900">INVOICE</h1>
                <p class="text-lg font-mono font-semibold text-gray-600 mt-1"><?php echo e($invoice->invoice_number); ?></p>
                <?php
                    $statusClass = match($invoice->status) {
                        'paid'    => 'bg-green-100 text-green-800',
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'failed'  => 'bg-red-100 text-red-800',
                        default   => 'bg-gray-100 text-gray-700',
                    };
                ?>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-bold <?php echo e($statusClass); ?>">
                    <?php echo e(ucfirst($invoice->status)); ?>

                </span>
            </div>
        </div>

        <!-- Billed To / Invoice Details -->
        <div class="grid grid-cols-2 gap-8 mb-10">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Billed To</p>
                <p class="font-bold text-gray-900 text-lg"><?php echo e($invoice->business_name); ?></p>
                <?php if($invoice->business_email): ?>
                    <p class="text-gray-500 text-sm"><?php echo e($invoice->business_email); ?></p>
                <?php endif; ?>
            </div>
            <div class="text-right">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Invoice Details</p>
                <div class="space-y-1 text-sm">
                    <?php if($invoice->paid_at): ?>
                        <div class="flex justify-end gap-4">
                            <span class="text-gray-500">Date:</span>
                            <span class="font-medium text-gray-800"><?php echo e($invoice->paid_at->format('d M Y')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($invoice->billing_period_start && $invoice->billing_period_end): ?>
                        <div class="flex justify-end gap-4">
                            <span class="text-gray-500">Period:</span>
                            <span class="font-medium text-gray-800">
                                <?php echo e($invoice->billing_period_start->format('d M Y')); ?> –
                                <?php echo e($invoice->billing_period_end->format('d M Y')); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if($invoice->paymob_transaction_id): ?>
                        <div class="flex justify-end gap-4">
                            <span class="text-gray-500">Tx ID:</span>
                            <span class="font-mono text-xs text-gray-600"><?php echo e($invoice->paymob_transaction_id); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Line Items Table -->
        <table class="w-full mb-8 text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="pb-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="pb-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Billing Cycle</th>
                    <th class="pb-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $planEmoji = match($invoice->plan) { 'pro' => '💼', 'plus' => '🚀', default => '🆓' }; ?>
                <tr class="border-b border-gray-100">
                    <td class="py-4">
                        <p class="font-semibold text-gray-800">
                            <?php echo e($planEmoji); ?> Mawid <?php echo e(ucfirst($invoice->plan)); ?> Plan
                        </p>
                        <?php if($invoice->billing_period_start && $invoice->billing_period_end): ?>
                            <p class="text-xs text-gray-400 mt-0.5">
                                <?php echo e($invoice->billing_period_start->format('d M Y')); ?> –
                                <?php echo e($invoice->billing_period_end->format('d M Y')); ?>

                            </p>
                        <?php endif; ?>
                    </td>
                    <td class="py-4 text-center text-gray-600"><?php echo e(ucfirst($invoice->billing_cycle ?? '—')); ?></td>
                    <td class="py-4 text-right font-semibold text-gray-800">
                        <?php echo e(number_format($invoice->amount, 3)); ?> <?php echo e($invoice->currency ?? 'OMR'); ?>

                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="flex justify-end mb-10">
            <div class="w-64 space-y-2 text-sm">
                <div class="flex justify-between text-gray-500">
                    <span>Subtotal</span>
                    <span><?php echo e(number_format($invoice->amount, 3)); ?> <?php echo e($invoice->currency ?? 'OMR'); ?></span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>VAT (0%)</span>
                    <span>0.000 <?php echo e($invoice->currency ?? 'OMR'); ?></span>
                </div>
                <div class="flex justify-between font-bold text-gray-900 text-base border-t border-gray-200 pt-2">
                    <span>Total</span>
                    <span><?php echo e(number_format($invoice->amount, 3)); ?> <?php echo e($invoice->currency ?? 'OMR'); ?></span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-100 pt-6 text-center text-xs text-gray-400">
            <p>Thank you for your business! Questions? Contact us at <span class="text-gray-600">support@mawid.app</span></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\booking-app\resources\views/admin/billing/invoice.blade.php ENDPATH**/ ?>