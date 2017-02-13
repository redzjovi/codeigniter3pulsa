<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php echo $menu_nav; ?>
		<div class="content-wrapper">
			<?php if (validation_errors()) : ?>
				<div class="alert alert-danger">
					<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
					<?php echo validation_errors() ?>
				</div>
			<?php endif ?>
			<section class="content">
				<?php echo $page ?>
			</section>
        </div>
    </div><!-- /#wrapper -->
</body>