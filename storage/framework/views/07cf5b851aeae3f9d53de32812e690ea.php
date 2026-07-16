<?php $__env->startSection('title', 'Browse Services'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="text-2xl font-bold mb-6">Find a service</h1>

    <form method="GET" class="flex flex-wrap gap-3 mb-8">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search services..."
               class="border rounded px-3 py-2 flex-1 min-w-[200px]">
        <select name="category" class="border rounded px-3 py-2">
            <option value="">All categories</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->slug); ?>" <?php if(request('category') === $category->slug): echo 'selected'; endif; ?>>
                    <?php echo e($category->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Search</button>
    </form>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('services.show', $service)); ?>" class="block border rounded-lg p-4 bg-white hover:shadow-md transition">
                <span class="text-xs text-blue-600 font-medium"><?php echo e($service->category->name); ?></span>
                <h2 class="font-semibold text-lg mt-1"><?php echo e($service->title); ?></h2>
                <p class="text-sm text-gray-600 mt-1 line-clamp-2"><?php echo e($service->description); ?></p>
                <div class="flex justify-between items-center mt-4 text-sm">
                    <span class="text-gray-500">by <?php echo e($service->provider->name); ?></span>
                    <span class="font-bold text-gray-900">$<?php echo e(number_format($service->price, 2)); ?></span>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-gray-500">No services found.</p>
        <?php endif; ?>
    </div>

    <div class="mt-8">
        <?php echo e($services->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mostafa/Downloads/booking-platform/resources/views/services/index.blade.php ENDPATH**/ ?>