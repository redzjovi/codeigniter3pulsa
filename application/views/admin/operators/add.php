<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_operators_add') ?></h1>
                    
    <?php echo form_open('', array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('operators_label_operator_name') ?> *</label>
            <div class="col-sm-9">
                <input autofocus class="form-control" name="operators_add_operator_name" placeholder="<?php echo lang('operators_label_operator_name') ?>" type="text" value="<?php echo set_value('operators_add_name')?>">
            </div>
        </div>
        
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('operators_label_active') ?></label>
            <div class="col-sm-9">
                <input class='iCheck' <?php echo set_checkbox('operators_add_active', 1, true) ?> name="operators_add_active" type="checkbox" value="1">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3">
                <a class="btn btn-default" href="<?php echo site_url('admin/operators/list_all') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-9">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('label_button_add') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>
</div>