<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_settings_add') ?></h1>
                    
    <?php echo form_open('', array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('settings_label_setting_code') ?> *</label>
            <div class="col-sm-9">
                <input autofocus class="form-control" name="setting_code" placeholder="<?php echo lang('settings_label_setting_code') ?>" type="text" value="<?php echo set_value('setting_code')?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('settings_label_setting_value') ?></label>
            <div class="col-sm-9">
                <input class="form-control" name="setting_value" placeholder="<?php echo lang('settings_label_setting_value') ?>" type="text" value="<?php echo set_value('setting_value')?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('settings_label_setting_description') ?></label>
            <div class="col-sm-9">
                <textarea class="form-control" name="setting_description" placeholder="<?php echo lang('settings_label_setting_description') ?>" rows="5"><?php echo set_value('setting_description')?></textarea>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('settings_label_setting_active') ?></label>
            <div class="col-sm-9">
                <input <?php echo set_checkbox('setting_active', 1, true) ?> name="setting_active" type="checkbox" value="1">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3">
                <a class="btn btn-default" href="<?php echo site_url('admin/settings') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-9">
                <input class="btn btn-default" name="setting_add" type="submit" value="<?php echo lang('label_button_add') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>   
</div>