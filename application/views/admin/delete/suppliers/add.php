<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_suppliers_add') ?></h1>
                    
    <?php echo form_open('', array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_name') ?> *</label>
            <div class="col-sm-10">
                <input autofocus class="form-control" name="suppliers_name" type="text" placeholder="<?php echo lang('suppliers_label_name') ?>" value="<?php echo set_value('suppliers_name') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_address') ?> </label>
            <div class="col-sm-10">
				<textarea class="form-control" name="suppliers_address" placeholder="<?php echo lang('suppliers_label_address') ?>" rows="3"><?php echo set_value('suppliers_address') ?></textarea>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_sub_district') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_sub_district" type="text" placeholder="<?php echo lang('suppliers_label_sub_district') ?>" value="<?php echo set_value('suppliers_sub_district') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_regency') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_regency" type="text" placeholder="<?php echo lang('suppliers_label_regency') ?>" value="<?php echo set_value('suppliers_regency') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_province') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_province" type="text" placeholder="<?php echo lang('suppliers_label_province') ?>" value="<?php echo set_value('suppliers_province') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_post_code') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_post_code" type="text" placeholder="<?php echo lang('suppliers_label_post_code') ?>" value="<?php echo set_value('suppliers_post_code') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_phone') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_phone" type="text" placeholder="<?php echo lang('suppliers_label_phone') ?>" value="<?php echo set_value('suppliers_phone') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_email') ?> </label>
            <div class="col-sm-10">
                <input class="form-control" name="suppliers_email" type="text" placeholder="<?php echo lang('suppliers_label_email') ?>" value="<?php echo set_value('suppliers_email') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('suppliers_label_active') ?></label>
            <div class="col-sm-10">
                <input <?php echo set_checkbox('suppliers_active', 1, true) ?> name="suppliers_active" type="checkbox" value="1">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-2" control-label">
				<a class="btn btn-default" href="<?php echo site_url('admin/suppliers/list_all') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-10">
                <input class="btn btn-default pull-left" type="submit" value="<?php echo lang('label_button_add') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>   
</div>