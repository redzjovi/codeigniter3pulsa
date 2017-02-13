<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_prices_edit') ?></h1>
                    
    <?php if ($edit) : ?>
	<?php echo form_open('admin/prices/edit/'.$edit->price_id, array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('prices_label_operator_name') ?> *</label>
            <div class="col-sm-9">
				<?php if ($operators) : ?>
					<select autofocus class="form-control" id="prices_edit_operator_id" name="prices_edit_operator_id">
						<?php foreach ($operators as $k => $v) : ?>
							<option <?php echo set_select('prices_edit_operator_id', $v->operator_id, ($v->operator_id == $edit->operator_id ? true : false) ) ?> value="<?php echo $v->operator_id ?>"><?php echo $v->operator_name ?></option>
						<?php endforeach ?>
					</select>
				<?php endif ?>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('prices_label_price') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="prices_edit_price" placeholder="<?php echo lang('prices_label_price') ?>" type="text" value="<?php echo set_value('prices_edit_price', $edit->price)?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('prices_label_buy_price') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="prices_edit_buy_price" placeholder="<?php echo lang('prices_label_buy_price') ?>" type="text" value="<?php echo set_value('prices_edit_buy_price', $edit->buy_price)?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('prices_label_sell_price') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="prices_edit_sell_price" placeholder="<?php echo lang('prices_label_sell_price') ?>" type="text" value="<?php echo set_value('prices_edit_sell_price', $edit->sell_price)?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('prices_label_active') ?></label>
            <div class="col-sm-9">
                <input class="iCheck" <?php echo set_checkbox('prices_edit_active', 1, ($edit->active == 0 ? false : true) ) ?> name="prices_edit_active" type="checkbox" value="1">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3">
                <a class="btn btn-default" href="<?php echo site_url('admin/prices/list_all') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-9">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('label_button_edit') ?>" />
                <input class="btn btn-danger pull-right" onclick="return confirm('<?php echo lang('message_delete_confirm') ?>') == false ? '' : window.location='<?php echo site_url('admin/prices/remove/'.$edit->price_id) ?>'" type="button" value="<?php echo lang('label_button_remove') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>
	<?php else : echo lang('message_error_message') ?>
	<?php endif ?>
</div>

<script>
	var $prices_edit_operator_id = $('#prices_edit_operator_id');
	
	$(document).ready(function() {
		$prices_edit_operator_id.select2();
	});
</script>