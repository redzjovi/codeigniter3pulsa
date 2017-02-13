<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_marketplace_add') ?></h1>
                    
    <?php echo form_open('', array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('marketplace_label_name') ?> *</label>
            <div class="col-sm-10">
                <input autofocus class="form-control" name="marketplace_name" type="text" placeholder="<?php echo lang('marketplace_label_name') ?>" value="<?php echo set_value('marketplace_name') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('marketplace_label_active') ?></label>
            <div class="col-sm-10">
                <input <?php echo set_checkbox('marketplace_active', 1, true) ?> name="marketplace_active" type="checkbox" value="1">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-2" control-label">
				<a class="btn btn-default" href="<?php echo site_url('admin/marketplace/list_all') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-10">
                <input class="btn btn-default pull-left" type="submit" value="<?php echo lang('label_button_add') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>   
</div>