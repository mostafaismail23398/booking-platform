<?php $__env->startSection('title', 'My Bookings'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="text-2xl font-bold mb-6">My bookings</h1>

    <div class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="border rounded-lg p-4 bg-white flex justify-between items-center">
                <div>
                    <p class="font-semibold"><?php echo e($booking->service->title); ?></p>
                    <p class="text-sm text-gray-500">
                        with <?php echo e($booking->service->provider->name); ?> ·
                        <?php echo e($booking->scheduled_at?->format('M d, Y H:i')); ?>

                    </p>
                </div>
                <span class="text-xs px-2 py-1 rounded
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'bg-yellow-100 text-yellow-800' => $booking->status === 'pending',
                        'bg-blue-100 text-blue-800' => $booking->status === 'accepted',
                        'bg-green-100 text-green-800' => $booking->status === 'completed',
                        'bg-red-100 text-red-800' => $booking->status === 'cancelled',
                    ]); ?>"">
                    <?php echo e(ucfirst($booking->status)); ?>

                </span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-gray-500">You haven't booked anything yet. <a href="<?php echo e(route('home')); ?>" class="text-blue-600">Browse services</a>.</p>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mostafa/Downloads/booking-platform/resources/views/dashboard/client.blade.php ENDPATH**/ ?>