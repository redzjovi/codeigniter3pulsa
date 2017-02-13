<?php if ($this->session->flashdata('auth_register_label_success')) : ?>
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('auth_register_label_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>

<?php if ($this->session->flashdata('auth_failed')) : ?>
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('auth_failed') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>

<div class="hold-transition login-page">
    <div class="login-box">
		<div class="login-logo">
			<b>Pulsa</b>
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg"><?php echo lang('auth_register') ?></p>
			<form action="" method="post">
				<div class="form-group has-feedback">
					<input autofocus class="form-control" name="auth_register_email" placeholder="<?php echo lang('auth_email') ?>" type="email" value="<?php echo set_value('auth_register_email') ?>">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input class="form-control" name="auth_register_password" placeholder="<?php echo lang('auth_password') ?>" type="password">
					<span class="form-control-feedback glyphicon glyphicon-lock"></span>
				</div>
				<div class="row">
					<div class="col-xs-8">
						<label>
							<input <?php echo set_checkbox('auth_register_agree', '1') ?> class="iCheck" name="auth_register_agree" type="checkbox" value="1"> <?php echo lang('auth_register_label_agree') ?><a href="#"><?php echo lang('auth_register_label_terms') ?></a>
						</label>
					</div><!-- /.col -->
					<div class="col-xs-4">
						<button class="btn btn-primary btn-block btn-flat" type="submit" value="auth_sign_in"><?php echo lang('auth_register') ?></button>
					</div><!-- /.col -->
				</div>
				<div class="row">
					<div class="col-xs-4">
						<a class="btn btn-danger btn-block btn-flat" href="<?php echo site_url('admin/auth') ?>" role="button"><?php echo lang('label_button_back') ?></a>
					</div><!-- /.col -->
				</div>
			</form>
		</div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
</div>

<script>
	$(function () {
		$('.iCheck').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
	});
</script>