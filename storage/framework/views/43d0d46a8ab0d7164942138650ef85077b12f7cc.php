<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="<?php echo e(\Laravel\Nova\Nova::rtlEnabled() ? 'rtl' : 'ltr'); ?>" class="h-full font-sans antialiased">
<head>
    <meta name="theme-color" content="#fff">
    <meta charset="utf-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width"/>
    <meta name="locale" content="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"/>

    <?php echo $__env->make('nova::partials.meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(mix('app.css', 'vendor/nova')); ?>">

    <?php if($styles = \Laravel\Nova\Nova::availableStyles(request())): ?>
    <!-- Tool Styles -->
        <?php $__currentLoopData = $styles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <link rel="stylesheet" href="<?php echo $asset->url(); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <script>
        if (localStorage.novaTheme === 'dark' || (!('novaTheme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="min-w-site text-sm font-medium min-h-full text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-900">
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
    <div class="relative z-50">
      <div id="notifications" name="notifications"></div>
    </div>
    <div>
      <div id="dropdowns" name="dropdowns"></div>
      <div id="modals" name="modals"></div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(mix('manifest.js', 'vendor/nova')); ?>"></script>
    <script src="<?php echo e(mix('vendor.js', 'vendor/nova')); ?>"></script>
    <script src="<?php echo e(mix('app.js', 'vendor/nova')); ?>"></script>

    <!-- Build Nova Instance -->
    <script>
        const config = <?php echo json_encode(\Laravel\Nova\Nova::jsonVariables(request()), 15, 512) ?>;
        window.Nova = createNovaApp(config)
        Nova.countdown()
    </script>

    <?php if($scripts = \Laravel\Nova\Nova::availableScripts(request())): ?>
        <!-- Tool Scripts -->
        <?php $__currentLoopData = $scripts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <script src="<?php echo $asset->url(); ?>"></script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <!-- Start Nova -->
    <script defer>
        Nova.liftOff()
    </script>
</body>
</html>
<?php /**PATH /var/www/vendor/laravel/nova/src/../resources/views/layout.blade.php ENDPATH**/ ?>