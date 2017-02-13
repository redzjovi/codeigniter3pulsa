<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_purchases_add') ?></h1>
                    
    <?php echo form_open_multipart('', array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('purchases_label_purchase_id') ?></label>
            <div class="col-sm-10">
                <input class="form-control" disabled="disabled" type="text" value="<?php echo $last_purchase_id ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('purchases_label_purchase_number') ?> *</label>
            <div class="col-sm-10">
                <input class="form-control" name="purchases_purchase_number" type="text" placeholder="<?php echo lang('purchases_label_purchase_number') ?>" value="<?php echo set_value('purchases_purchase_number') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('purchases_label_purchase_date') ?> *</label>
            <div class="col-sm-10">
                <input class="form-control" id="purchases_purchase_date" name="purchases_purchase_date" type="text" placeholder="<?php echo lang('purchases_label_purchase_date') ?>" value="<?php echo set_value('purchases_purchase_date') ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('purchases_label_purchase_status') ?> *</label>
            <div class="col-sm-10">
				<select class="form-control" id="purchases_purchase_status" name="purchases_purchase_status" style="width: auto">
					<?php if ($purchase_order_status) : ?>
						<?php foreach ($purchase_order_status as $k => $v) : ?>
							<option value="<?php echo $v->setting_value ?>"><?php echo lang($v->setting_code) ?></option>
						<?php endforeach ?>
					<?php endif ?>
				</select>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('purchases_label_supplier') ?> *</label>
            <div class="col-sm-10">
				<select class="form-control" id="purchases_supplier_id" name="purchases_supplier_id" style="width: auto">
					<?php if ($suppliers) : ?>
						<?php foreach ($suppliers as $k => $v) : ?>
							<option value="<?php echo $v->user_id ?>"><?php echo $v->name ?></option>
						<?php endforeach ?>
					<?php endif ?>
				</select>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('purchases_label_reference_number') ?></label>
            <div class="col-sm-10">
                <input class="form-control" name="purchases_reference_number" type="text" placeholder="<?php echo lang('purchases_label_reference_number') ?>" value="<?php echo set_value('purchases_reference_number') ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('purchases_label_note') ?></label>
            <div class="col-sm-10">
                <textarea class="form-control" name="purchases_note" placeholder="<?php echo lang('purchases_label_note') ?>" rows="3"><?php echo set_value('purchases_note') ?></textarea>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('purchases_label_document') ?></label>
            <div class="col-sm-10">
				<input multiple name="purchases_document[]" type="file" />
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('purchases_label_detail') ?></label>
            <div class="col-sm-10">
				<input class="btn btn-default" data-target="#myModal" data-toggle="modal" role="button" value="<?php echo lang('menu_nav_product_list_all') ?>" />
				<a class="btn btn-default" href="<?php echo site_url('admin/products/add') ?>" role="button" target="_blank"><?php echo lang('menu_nav_product_add') ?></a>
            </div>
        </div>
		
		<div class="form-group">
            <div class="col-sm-12">
				<table
					data-unique-id="id"
					data-reorderable-rows="true"
					data-smart-display ="true"
					data-show-toggle ="true"
					data-striped="true"
					data-use-row-attr-func="true"
					id="purchases_detail"
				>
					<thead>
						<th data-field="id" data-visible="false">ID</th>
						<th data-field="product_id" data-visible="false">Product Id</th>
						<th data-field="product_name">Product Name</th>
						<th data-align="right" data-field="weight">Weight</th>
						<th data-align="right" data-field="buy_price">Buy Price</th>
						<th data-align="right" data-field="quantity">Quantity</th>
						<th data-align="right" data-field="sub_total">Sub Total</th>
						<th data-field="action">Action</th>
					</thead>
					<tfoot>
						<th></th>
						<th></th>
						<th></th>
						<th class="text-right">Total</th>
						<th class="text-right"><span id="purchases_total"></span></th>
						<th></th>
					</tfoot>
				</table>
            </div>
        </div>
		
		<div class="form-group">
            <div class="col-sm-2">
				<a class="btn btn-default" href="<?php echo site_url('admin/products/list_all') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-10">
                <input class="btn btn-default pull-left" type="submit" value="<?php echo lang('label_button_add') ?>" />
            </div>
        </div>
    </form>    
</div>
<!-- /.col-lg-12 -->

<!-- Modal -->
<?php echo $products_list_all ?>

<script>
	$(function () {
		$("#purchases_purchase_date").daterangepicker({
			autoApply: true,
			autoUpdateInput: true,
			showDropdowns: true,
			locale: {
				format: 'DD/MM/YYYY HH:mm:ss'
			},
			singleDatePicker: true,
			timePicker: true,
			timePicker24Hour: true,
			timePickerIncrement: 1
		});
		$('#purchases_purchase_status').select2({
			placeholder: "Select Status"
		});
		$('#purchases_supplier_id').select2({
			placeholder: "Select Status"
		}).on("change", function() { 
			purchases_products_list_js( $(this).val() )
		} );
		$('#purchases_detail').bootstrapTable();
		
		purchases_products_list_js( $('#purchases_supplier_id').val() );
	});
</script>