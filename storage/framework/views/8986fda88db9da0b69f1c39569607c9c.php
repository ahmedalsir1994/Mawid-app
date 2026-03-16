<?php
    $loginUrl = route('login');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Expired</title>
    <meta http-equiv="refresh" content="2;url=<?php echo e($loginUrl); ?>?expired=1&intended=<?php echo e(urlencode(url()->full())); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md text-center max-w-md">
        <h1 class="text-2xl font-bold text-red-600 mb-4">Session Expired</h1>
        <p class="mb-4">Your session expired. Please sign in again to continue.</p>
        <a href="<?php echo e($loginUrl); ?>?expired=1&intended=<?php echo e(urlencode(url()->full())); ?>" class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Go to Login</a>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "<?php echo e($loginUrl); ?>?expired=1&intended=<?php echo e(urlencode(url()->full())); ?>";
        }, 2000);
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\Mawid-app\resources\views/errors/419.blade.php ENDPATH**/ ?>