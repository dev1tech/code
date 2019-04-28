<?php $__env->startSection('content'); ?>
    <div class="text-center lead p-5">
        <?php echo e($title); ?>

    </div>

    <?php if(isset($data) && !empty($data) && count($data) > 0): ?> 
        <ul class="list-group">
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <a href="/locations/<?php echo e($id); ?>"><?php echo e($name); ?></a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php elseif(isset($list) && !empty($list) && count($list) > 0): ?> 
        <ul class="list-group">
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <a href="/locations/<?php echo e($locationid); ?>/floors/<?php echo e($id); ?>"><?php echo e($name); ?></a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php elseif(isset($info) && !empty($info) && count($info) > 0): ?>
        <ul class="list-group">
            <li class="list-group-item"><b>Number:</b> <?php echo e($info['number']); ?></li>
            <li class="list-group-item"><b>Desks:</b> <?php echo e($info['desks']); ?></li>
            <li class="list-group-item"><b>Description:</b> <?php echo e($info['description']); ?></li>
        </ul>
    <?php elseif(isset($details) && !empty($details) && count($details) > 0): ?>
        <ul class="list-group">
            <li class="list-group-item"><b>Name:</b> <?php echo e($details['name']); ?></li>
            <li class="list-group-item"><b>Address:</b> <?php echo e($details['address']); ?></li>
            <li class="list-group-item"><a href="/locations/<?php echo e($locationid); ?>/floors">List Floors</a></li>
        </ul>
    <?php else: ?>
        <ul class="list-group">
            <li class="list-group-item"><?php echo e($message); ?></li>
        </ul>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Program Files (x86)\Server\apache\htdocs\abc.wework.com\resources\views/pages/locations.blade.php ENDPATH**/ ?>