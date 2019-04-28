<?php $__env->startSection('content'); ?>
    <div class="text-center lead p-5">
        <?php echo e($title); ?>

    </div>

    <?php if(isset($data) && !empty($data) && count($data) > 0): ?> 
        <ul class="list-group">
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <a href="/<?php echo e($page); ?>/<?php echo e($code); ?>"><?php echo e($name); ?></a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <ul class="list-group">
            <li class="list-group-item"><?php echo e($message); ?></li>
        </ul>
    <?php endif; ?>   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Program Files (x86)\Server\apache\htdocs\abc.wework.com\resources\views/pages/countries.blade.php ENDPATH**/ ?>