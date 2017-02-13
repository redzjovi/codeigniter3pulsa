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
			<p class="login-box-msg"><?php echo lang('auth_reset_password') ?></p>
			<form action="" method="post">
				<input name="auth_email" type="hidden" value="<?php echo $email ?>" />
				<input name="auth_password" type="hidden" value="<?php echo $password ?>" />
				<div class="form-group has-feedback">
					<input autofocus class="form-control" name="auth_new_password" placeholder="<?php echo lang('profile_label_new_password') ?>" type="password" value="<?php echo set_value('auth_new_password') ?>">
					<span class="form-control-feedback glyphicon glyphicon-lock"></span>
				</div>
				<div class="form-group has-feedback">
					<input autofocus class="form-control" name="auth_retype_new_password" placeholder="<?php echo lang('profile_label_retype_new_password') ?>" type="password" value="<?php echo set_value('auth_retype_new_password') ?>">
					<span class="form-control-feedback glyphicon glyphicon-lock"></span>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<a class="btn btn-danger btn-block btn-flat" href="<?php echo site_url('admin/auth') ?>" role="button"><?php echo lang('label_button_back') ?></a>
					</div><!-- /.col -->
					<div class="col-xs-4"></div><!-- /.col -->
					<div class="col-xs-4">
						<button class="btn btn-primary btn-block btn-flat" name="auth_send" type="submit" value="auth_send"><?php echo lang('label_button_send') ?></button>
					</div><!-- /.col -->
				</div>
			</form>
		</div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
</div>