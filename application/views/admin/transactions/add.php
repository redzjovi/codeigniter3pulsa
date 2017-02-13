<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_transactions_add') ?></h1>
                    
    <?php echo form_open('', array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_transaction_date') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" id="transactions_add_transaction_date" name="transactions_add_transaction_date" placeholder="<?php echo lang('transactions_label_transaction_date') ?>" type="text" value="<?php echo set_value('transactions_add_transaction_date', date('d-m-Y H:i:s') )?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_name') ?></label>
            <div class="col-sm-9">
                <input class="form-control" name="transactions_add_name" placeholder="<?php echo lang('transactions_label_name') ?>" type="text" value="<?php echo set_value('transactions_add_name') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_phone_number') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" name="transactions_add_phone_number" placeholder="<?php echo lang('transactions_label_phone_number') ?>" type="text" value="<?php echo set_value('transactions_add_phone_number') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_operator') ?> *</label>
            <div class="col-sm-9">
				<?php if ($operators) : ?>
					<select class="form-control" id="transactions_add_operator_id" name="transactions_add_operator_id">
						<option value=""></option>
						<?php foreach ($operators as $k => $v) : ?>
							<option <?php echo set_select('transactions_add_operator_id', $v->operator_id) ?> value="<?php echo $v->operator_id ?>"><?php echo $v->operator_name ?></option>
						<?php endforeach ?>
					</select>
				<?php endif ?>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_price') ?> *</label>
            <div class="col-sm-9">
                <select class="form-control" disabled="disabled" id="transactions_add_price_id" name="transactions_add_price_id"></select>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_sell_price') ?> *</label>
            <div class="col-sm-9">
                <input class="form-control" id="transactions_add_sell_price" name="transactions_add_sell_price" placeholder="<?php echo lang('transactions_label_sell_price') ?>" type="text" value="<?php echo set_value('transactions_add_sell_price') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-3 control-label"><?php echo lang('transactions_label_status') ?> *</label>
            <div class="col-sm-9">
				<?php if ($transaction_status) : ?>
					<select class="form-control select2" id="transactions_add_status" name="transactions_add_status">
						<?php foreach ($transaction_status as $k => $v) : ?>
							<option <?php echo set_select('transactions_add_status', $v->setting_value) ?> value="<?php echo $v->setting_value ?>"><?php echo lang($v->setting_code) ?></option>
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
                <input class="btn btn-primary" type="submit" value="<?php echo lang('label_button_add') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>
</div>

<script>
	var $transactions_add_transaction_date = $('#transactions_add_transaction_date');
	var $transactions_add_operator_id = $('#transactions_add_operator_id');
	var $transactions_add_price_id = $('#transactions_add_price_id');
	var $transactions_add_sell_price = $('#transactions_add_sell_price');
	var $transactions_add_status = $('#transactions_add_status');
	
	function transactions_add_operator_id_change(operator_id)
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
				
				$transactions_add_price_id.html('').select2({
					allowClear: true,
					data: new_data,
					placeholder: "<?php echo lang('label_select') ?> <?php echo lang('transactions_label_price') ?>"
				});
				$transactions_add_price_id.prop('disabled', false);
			},
			type: 'POST',
			url: '<?php echo site_url('admin/prices/prices_by_operator_id') ?>'
		});
	}
	
	$(document).ready(function() {
		$transactions_add_transaction_date.daterangepicker({
			autoApply: true,
			autoUpdateInput: true,
			locale: {
				format: '<?php echo $format_datetime_js ?>'
			},
			showDropdowns: true,
			singleDatePicker: true,
			timePicker: true,
			timePicker24Hour: true,
			timePickerIncrement: 1
		});
		
		$transactions_add_operator_id.select2({
			allowClear: true,
			placeholder: "<?php echo lang('label_select') ?> <?php echo lang('transactions_label_operator') ?>"
		});
		$transactions_add_operator_id.on("change", function () { 
			var operator_id = $(this).val();
			if (operator_id == '')
			{
				$transactions_add_price_id.html('');
				$transactions_add_price_id.prop("disabled", true);
			}
			else
			{
				transactions_add_operator_id_change(operator_id);
			}
		});
		$transactions_add_price_id.select2({
			allowClear: true,
			placeholder: "<?php echo lang('label_select') ?> <?php echo lang('transactions_label_price') ?>"
		});
		$transactions_add_price_id.on("change", function () { 
			var price_id = $(this).val();
			if (price_id == '')
			{
				$transactions_add_sell_price.val('');
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
						$transactions_add_sell_price.val(sell_price);
					},
					type: 'POST',
					url: '<?php echo site_url('admin/prices/prices_by_price_id') ?>'
				});
			}
		});
		$transactions_add_status.select2({
			placeholder: "<?php echo lang('label_select') ?> <?php echo lang('transactions_label_status') ?>"
		});
		
		transactions_add_operator_id_change( <?php echo set_value('transactions_add_operator_id') ?> );
		$transactions_add_price_id.val( <?php echo (set_value('transactions_add_price_id') ? set_value('transactions_add_price_id') : '""') ?> ).trigger("change");
		<?php if (set_value('transactions_add_sell_price')) : ?>
			$transactions_add_sell_price.val('<?php echo set_value('transactions_add_sell_price') ?>');
		<?php endif ?>
	});
</script>