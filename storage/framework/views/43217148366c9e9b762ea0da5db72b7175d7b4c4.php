<!DOCTYPE html>
<html lang="en">
<head>
    
    <?php echo $__env->make('partials.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('stylesheets'); ?>

</head>

<body class="hold-transition skin-blue sidebar-mini">	
		
		<div class="wrapper">

			<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

				<?php echo $__env->yieldContent('content'); ?>

			</div>
      <!-- /.content-wrapper -->

			<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		</div><!-- /wrapper -->	

	<!--   Core JS Files   -->
	<?php echo $__env->make('partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<?php echo $__env->yieldContent('scripts'); ?>

	<script type="text/javascript">
		$(document).ready(function() {
			// Javascript method's body can be found in assets/js/demos.js
			// demo.initDashboardPageCharts();
			// demo.initVectorMap();
		});

    $(document).ready(function() {
        // md.initSliders()
        // demo.initFormExtendedDatetimepickers();
    });

    $('.datepicker').attr('placeholder', 'MM/DD/YYYY');
    $('.datepicker').datepicker({
    	format: 'mm/dd/yyyy',
	    autoclose: true
	  })
  </script>
</body>
</html><?php /**PATH /srv/www/musafir/resources/views/dashboard.blade.php ENDPATH**/ ?>