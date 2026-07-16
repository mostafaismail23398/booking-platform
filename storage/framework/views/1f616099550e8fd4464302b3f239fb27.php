<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-md mx-auto bg-white border rounded-lg p-6">
        <h1 class="text-xl font-bold mb-4">Log in</h1>

        <?php if($errors->any()): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-3">
            <?php echo csrf_field(); ?>
            <div>
                <label class="text-sm font-medium block mb-1">Email</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                       class="border rounded px-3 py-2 w-full">
            </div>
            <div>
                <label class="text-sm font-medium block mb-1">Password</label>
                <input type="password" name="password" required class="border rounded px-3 py-2 w-full">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <button class="bg-blue-600 text-white w-full py-2 rounded hover:bg-blue-700">Log in</button>
        </form>
        <p class="text-sm text-gray-500 mt-4">No account? <a href="<?php echo e(route('register')); ?>" class="text-blue-600">Sign up</a></p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mostafa/Downloads/booking-platform/resources/views/auth/login.blade.php ENDPATH**/ ?>