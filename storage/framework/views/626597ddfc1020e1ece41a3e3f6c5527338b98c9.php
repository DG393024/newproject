<!DOCTYPE html>
<html lang="en">
<head>
  <title>User form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>
<body>

<div class="container">
  <h2>User form</h2>
  <form id="user-form" method="POST" autocomplete="off" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Name<span class="required_mark">*</span></label>
            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email<span class="required_mark">*</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="phone" class="form-label">Phone<span class="required_mark">*</span></label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone">
        </div>					
        <div class="col-md-6">
            <label for="known_as" class="form-label">Role id<span class="required_mark">*</span></label>            
            <select name="role_id" class="form-control" id="role_id" name="role_id">
                <option value="">Select Role</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleKey => $roleValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($roleKey); ?>"><?php echo e($roleValue); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select><br>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12 mb-3">
            <label for="description" class="form-label">Description<span class="required_mark">*</span></label>
            <textarea type="text" class="form-control" id="description" name="description" placeholder="Description"></textarea>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-6 mb-3">
            <label  for="profile_image" class="form-label">Profile Image<span class="required_mark">*</span></label>
            <input type="file" name="profile_image" id="profile_image" class="form-control">
        </div>
    </div>
    <br/>
    <div class="row mb-3">
        <div class="col-lg-12 mb-3 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
  </form>

  <div id="user_table">
 
  </div>
</div>


<script>
    var USER_SAVE_URL   = "<?php echo route('Home.save') ?>";
    var CSRF_TOKEN      = "<?php echo e(csrf_token()); ?>";
</script>
<script src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/user_form.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\dreamcast\resources\views/welcome.blade.php ENDPATH**/ ?>