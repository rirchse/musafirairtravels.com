<style type="text/css">
	.alert{max-width:800px; width: 100%; z-index:9999;display: block;margin-top: 10px;margin-bottom: 0}
	.alert ul{list-style:none;padding-left: 15px}
</style>

<?php if(Session::has('success')): ?>
	<div class="alert alert-success alert-dismissible">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="this.parentNode.style.display='none';">&times;</button>
	  <h4><i class="icon fa fa-check"></i> Success:</h4>
	  <?php echo Session::get('success'); ?>

	</div>
<?php endif; ?>

<?php if(Session::has('error')): ?>

	<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="this.parentNode.style.display='none';">&times;</button>
    <h4><i class="icon fa fa-warning"></i> Error:</h4>
    <?php echo Session::get('error'); ?>

  </div>

<?php endif; ?>

<?php if(count($errors) > 0): ?>

	<div class="alert alert-danger alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="this.parentNode.style.display='none';">&times;</button>
		<h4><i class="icon fa fa-danger"></i> Errors:</h4>
		<ul>
			<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li><?php echo $error; ?></li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
	</div>

<?php endif; ?><?php /**PATH /srv/www/musafir/resources/views/partials/messages.blade.php ENDPATH**/ ?>