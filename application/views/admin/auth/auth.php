<?php if ($this->session->flashdata('auth_register_label_success')) : ?>
    <div class="alert alert-success">
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
			<p class="login-box-msg"><?php echo lang('auth_label') ?></p>
            <form action="" method="post">
				<div class="form-group has-feedback">
                    <?php echo lang('auth_email') ?> : admin@admin.com<br />
                    <?php echo lang('auth_password') ?> : password
                </div>
                <div class="form-group has-feedback">
					<input autofocus class="form-control" name="auth_email" placeholder="<?php echo lang('auth_email') ?>" type="email" value="<?php echo set_value('auth_email') ?>">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input class="form-control" name="auth_password" placeholder="<?php echo lang('auth_password') ?>" type="password">
					<span class="form-control-feedback glyphicon glyphicon-lock"></span>
				</div>
				<div class="row">
					<div class="col-xs-8">
						<div class="checkbox icheck" style="display: none;">
							<label>
								<input type="checkbox"> Remember Me
							</label>
						</div>
					</div><!-- /.col -->
					<div class="col-xs-4">
						<button class="btn btn-primary btn-block btn-flat" name="auth_sign_in" type="submit" value="auth_sign_in"><?php echo lang('auth_sign_in') ?></button>
					</div><!-- /.col -->
				</div>
			</form>

			<a href="<?php echo site_url('admin/auth/forget_password') ?>"><?php echo lang('auth_forgot_password') ?></a><br>
			<a href="<?php echo site_url('admin/auth/register') ?>" class="text-center"><?php echo lang('auth_register') ?></a>

		</div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
</div>