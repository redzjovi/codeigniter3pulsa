<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_transactions_edit') ?></h1>
                    
    <?php if ($edit) : ?>
	<?php echo form_open('admin/transactions/edit/'.$edit->transaction_id, array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_transaction_date') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" id="transactions_edit_transaction_date" name="transactions_edit_transaction_date" placeholder="<?php echo lang('transactions_label_transaction_date') ?>" type="text" value="<?php echo set_value('transactions_edit_transaction_date', date('d-m-Y H:i:s', strtotime($edit->transaction_date)) ) ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_name') ?></label>
            <div class="col-sm-9">
                <input class="form-control" name="transactions_edit_name" placeholder="<?php echo lang('transactions_label_name') ?>" type="text" value="<?php echo set_value('transactions_edit_name', $edit->name) ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_phone_number') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="transactions_edit_phone_number" placeholder="<?php echo lang('transactions_label_phone_number') ?>" type="text" value="<?php echo set_value('transactions_edit_phone_number', $edit->phone_number) ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_operator') ?> *</label>
            <div class="col-sm-9">
				<?php if ($operators) : ?>
					<select class="form-control" id="transactions_edit_operator_id" name="transactions_edit_operator_id">
						<option value=""></option>
						<?php foreach ($operators as $k => $v) : ?>
							<option <?php echo set_select('transactions_edit_operator_id', $v->operator_id, $v->operator_id == $edit->operator_id ? true : false) ?> value="<?php echo $v->operator_id ?>"><?php echo $v->operator_name ?></option>
						<?php endforeach ?>
					</select>
				<?php endif ?>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_price') ?> *</label>
            <div class="col-sm-9">
                <select class="form-control" disabled="disabled" id="transactions_edit_price_id" name="transactions_edit_price_id"></select>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_sell_price') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" id="transactions_edit_sell_price" name="transactions_edit_sell_price" placeholder="<?php echo lang('transactions_label_sell_price') ?>" type="text" value="<?php echo set_value('transactions_sell_price', $edit->sell_price)?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_status') ?> *</label>
            <div class="col-sm-9">
				<?php if ($transaction_status) : ?>
					<select class="form-control select2" id="transactions_edit_status" name="transactions_edit_status">
						<?php foreach ($transaction_status as $k => $v) : ?>
							<option <?php echo set_select('transactions_edit_status', $v->setting_value, $v->setting_value == $edit->status ? true : false) ?> value="<?php echo $v->setting_value ?>"><?php echo lang($v->setting_code) ?></option>
						<?php endforeach ?>
					</select>
				<?php endif ?>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-3">
                <a class="btn btn-default" href="<?php echo site_url('admin/transactions/list_all') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-9">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('label_button_edit') ?>" />
                <input class="btn btn-danger pull-right" onclick="return confirm('<?php echo lang('message_delete_confirm') ?>') == false ? '' : window.location='<?php echo site_url('admin/transactions/remove/'.$edit->transaction_id) ?>'" type="button" value="<?php echo lang('label_button_remove') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>
	<?php else : echo lang('message_error_message') ?>
	<?php endif ?>
</div>

<script>
	var $transactions_edit_transaction_date = $('#transactions_edit_transaction_date');
	var $transactions_edit_operator_id = $('#transactions_edit_operator_id');
	var $transactions_edit_price_id = $('#transactions_edit_price_id');
	var $transactions_edit_sell_price = $('#transactions_edit_sell_price');
	var $transactions_edit_status = $('#transactions_edit_status');
	
	function transactions_operator_id_change(operator_id)
	{
		$.ajax({
			async: false,
			data: { 
				id : operator_id
			},
			dataType: 'json',
			error: function() { alert('<?php echo lang('message_error_message') ?>') },
			success: function(data) {
				var new_data = [];
				new_data.push( { id: '', text: '' } );
				for (var k in data.rows)
				{
					var operator_id = data.rows[k]['price_id'];
					var price = data.rows[k]['price'];
					new_data.push( { id: operator_id, text: price } );
				}
				
				$transactions_edit_price_id.html('').select2({
					allowClear: true,
					data: new_data,
					placeholder: "<?php echo lang('label_select') ?> <?php echo lang('transactions_label_price') ?>"
				});
				$transactions_edit_price_id.prop('disabled', false);
			},
			type: 'POST',
			url: '<?php echo site_url('admin/prices/prices_by_operator_id') ?>'
		});
	}
	
	$(document).ready(function() {
		$transactions_edit_transaction_date.daterangepicker({
			autoApply: true,
			autoUpdateInput: true,
			showDropdowns: true,
			locale: {
				format: '<?php echo $format_datetime_js ?>'
			},
			singleDatePicker: true,
			timePicker: true,
			timePicker24Hour: true,
			timePickerIncrement: 1
		});
		
		$transactions_edit_operator_id.select2({
			allowClear: true,
			placeholder: "<?php echo lang('label_select') ?> <?php echo lang('transactions_label_operator') ?>"
		});
		$transactions_edit_operator_id.on("change", function () { 
			var operator_id = $(this).val();
			if (operator_id == '')
			{
				$transactions_edit_price_id.html('');
				$transactions_edit_price_id.prop("disabled", true);
			}
			else
			{
				transactions_operator_id_change(operator_id);
			}
		});
		$transactions_edit_price_id.select2({
			allowClear: true,
			placeholder: "<?php echo lang('label_select') ?> <?php echo lang('transactions_label_price') ?>"
		});
		$transactions_edit_price_id.on("change", function () { 
			var price_id = $(this).val();
			if (price_id == '')
			{
				$transactions_edit_sell_price.val('');
			}
			else
			{
				$.ajax({
					async: false,
					data: { 
						id : price_id
					},
					dataType: 'json',
					error: function() { alert('<?php echo lang('message_error_message') ?>') },
					success: function(data) {
						var sell_price = data.rows['sell_price'];
						$transactions_edit_sell_price.val(sell_price);
					},
					type: 'POST',
					url: '<?php echo site_url('admin/prices/prices_by_price_id') ?>'
				});
			}
		});
		$transactions_edit_status.select2({
			placeholder: "<?php echo lang('label_select') ?> <?php echo lang('transactions_label_status') ?>"
		});
		
		transactions_operator_id_change( <?php echo set_value('transactions_operator_id', $edit->operator_id) ?> );
		$transactions_edit_price_id.val( <?php echo set_value('transactions_price_id', $edit->price_id) ?> ).trigger("change");
		<?php if (set_value('transactions_edit_sell_price')) : ?>
			$transactions_add_sell_price.val('<?php echo set_value('transactions_edit_sell_price') ?>');
		<?php endif ?>
	});
</script>