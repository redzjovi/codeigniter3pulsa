<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_profile_edit') ?></h1>
                    
    <?php if ($edit) : ?>
	<?php echo form_open('admin/profile/edit/'.$edit->admin_id, array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('profile_label_old_password') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="profile_edit_old_password" placeholder="<?php echo lang('profile_label_old_password') ?>" type="password" value="<?php echo set_value('profile_edit_old_password') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('profile_label_new_password') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="profile_edit_new_password" placeholder="<?php echo lang('profile_label_new_password') ?>" type="password" value="<?php echo set_value('profile_edit_new_password') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('profile_label_retype_new_password') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="profile_edit_retype_new_password" placeholder="<?php echo lang('profile_label_retype_new_password') ?>" type="password" value="<?php echo set_value('profile_edit_retype_new_password') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <div class="col-sm-3">
                <a class="btn btn-default" href="<?php echo site_url('admin/home') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-9">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('label_button_edit') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>
	<?php else : echo lang('message_error_message') ?>
	<?php endif ?>
</div>