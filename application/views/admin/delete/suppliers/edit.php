<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_suppliers_edit') ?></h1>
                    
    <?php if ($suppliers_edit) : ?>
	<?php echo form_open('admin/suppliers/edit/'.$suppliers_edit->user_id, array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_name') ?> *</label>
            <div class="col-sm-10">
                <input autofocus class="form-control" name="suppliers_name" type="text" placeholder="<?php echo lang('suppliers_label_name') ?>" value="<?php echo set_value('suppliers_name', $suppliers_edit->name) ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_address') ?> </label>
            <div class="col-sm-10">
				<textarea class="form-control" name="suppliers_address" placeholder="<?php echo lang('suppliers_label_address') ?>" rows="3"><?php echo set_value('suppliers_address', $suppliers_edit->address) ?></textarea>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_sub_district') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_sub_district" type="text" placeholder="<?php echo lang('suppliers_label_sub_district') ?>" value="<?php echo set_value('suppliers_sub_district', $suppliers_edit->sub_district) ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_regency') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_regency" type="text" placeholder="<?php echo lang('suppliers_label_regency') ?>" value="<?php echo set_value('suppliers_regency', $suppliers_edit->regency) ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_province') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_province" type="text" placeholder="<?php echo lang('suppliers_label_province') ?>" value="<?php echo set_value('suppliers_province', $suppliers_edit->province) ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_post_code') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_post_code" type="text" placeholder="<?php echo lang('suppliers_label_post_code') ?>" value="<?php echo set_value('suppliers_post_code', $suppliers_edit->post_code) ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_phone') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_phone" type="text" placeholder="<?php echo lang('suppliers_label_phone') ?>" value="<?php echo set_value('suppliers_phone', $suppliers_edit->phone) ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_email') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_email" type="text" placeholder="<?php echo lang('suppliers_label_email') ?>" value="<?php echo set_value('suppliers_email', $suppliers_edit->email) ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_active') ?></label>
            <div class="col-sm-10">
                <input <?php echo set_checkbox('suppliers_active', 1, ($suppliers_edit->active == 0 ? false : true) ) ?> name="suppliers_active" type="checkbox" value="1">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-2">
                <a class="btn btn-default" href="<?php echo site_url('admin/suppliers') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-10">
                <input class="btn btn-default" type="submit" value="<?php echo lang('label_button_edit') ?>" />
                <input class="btn btn-danger pull-right" onclick="return confirm('<?php echo lang('message_delete_confirm') ?>') == false ? '' : window.location='<?php echo site_url('admin/suppliers/remove/'.$suppliers_edit->user_id) ?>'" type="button" value="<?php echo lang('label_button_remove') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>
	<?php else : echo lang('message_error_message') ?>
	<?php endif ?>
</div>