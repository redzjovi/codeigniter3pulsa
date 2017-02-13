<body class="hold-transition login-page">
    <?php if (validation_errors()) : ?>
		<div class="alert alert-danger">
			<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
			<?php echo validation_errors() ?>
		</div>
	<?php endif ?>
	<?php echo $page ?>
</body>