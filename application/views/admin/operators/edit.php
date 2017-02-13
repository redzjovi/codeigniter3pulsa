<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_operators_edit') ?></h1>
                    
    <?php if ($edit) : ?>
	<?php echo form_open('admin/operators/edit/'.$edit->operator_id, array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('operators_label_operator_name') ?> *</label>
            <div class="col-sm-9">
                <input autofocus class="form-control" name="operators_edit_operator_name" placeholder="<?php echo lang('operators_label_operator_name') ?>" type="text" value="<?php echo set_value('operators_edit_operator_name', $edit->operator_name) ?>" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('operators_label_active') ?></label>
            <div class="col-sm-9">
                <input class="iCheck" <?php echo set_checkbox('operators_edit_active', 1, ($edit->active == 0 ? false : true) ) ?> name="operators_edit_active" type="checkbox" value="1">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3">
                <a class="btn btn-default" href="<?php echo site_url('admin/operators_list_all') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-9">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('label_button_edit') ?>" />
                <input class="btn btn-danger pull-right" onclick="return confirm('<?php echo lang('message_delete_confirm') ?>') == false ? '' : window.location='<?php echo site_url('admin/operators/remove/'.$edit->operator_id) ?>'" type="button" value="<?php echo lang('label_button_remove') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>
	<?php else : echo lang('message_error_message') ?>
	<?php endif ?>
</div>