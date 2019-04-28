<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <meta name="AdsBot-Google" content="noindex">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/app.css')); ?>">
        <title><?php echo e($title); ?></title>        
    </head>

    <body>
        <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </body>
</html>
<?php /**PATH C:\Program Files (x86)\Server\apache\htdocs\abc.wework.com\resources\views/layouts/app.blade.php ENDPATH**/ ?>