<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_prices_add') ?></h1>
                    
    <?php echo form_open('', array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('prices_label_operator_name') ?> *</label>
            <div class="col-sm-9">
				<?php if ($operators) : ?>
					<select autofocus class="form-control" id="prices_add_operator_id" name="prices_add_operator_id">
						<?php foreach ($operators as $k => $v) : ?>
							<option <?php echo set_select('prices_add_operator_id', $v->operator_id) ?> value="<?php echo $v->operator_id ?>"><?php echo $v->operator_name ?></option>
						<?php endforeach ?>
					</select>
				<?php endif ?>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('prices_label_price') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="prices_add_price" placeholder="<?php echo lang('prices_label_price') ?>" type="text" value="<?php echo set_value('prices_add_price')?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('prices_label_buy_price') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="prices_add_buy_price" placeholder="<?php echo lang('prices_label_buy_price') ?>" type="text" value="<?php echo set_value('prices_add_buy_price')?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('prices_label_sell_price') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="prices_add_sell_price" placeholder="<?php echo lang('prices_label_sell_price') ?>" type="text" value="<?php echo set_value('prices_add_sell_price')?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('prices_label_active') ?></label>
            <div class="col-sm-9">
                <input class='iCheck' <?php echo set_checkbox('prices_add_active', 1, true) ?> name="prices_add_active" type="checkbox" value="1">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3">
                <a class="btn btn-default" href="<?php echo site_url('admin/prices/list_all') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-9">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('label_button_add') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>
</div>

<script>
	var $prices_add_operator_id = $('#prices_add_operator_id');
	
	$(document).ready(function() {
		$prices_add_operator_id.select2();
	});
</script>