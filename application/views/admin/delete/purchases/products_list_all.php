<div aria-labelledby="myModalLabel" class="modal fade" id="myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document" style="width: 95%">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo lang('menu_nav_product_list_all') ?></h4>
			</div>
			<div class="modal-body">
				<table 
					data-search="false"
					data-side-pagination="server"
					<?php echo $my_table_options ?>
					data-click-to-select="true"
					data-checkbox-header="true"
					data-cookie="true"
					data-cookie-id-table="purchases_products_list_all_table_cookie"
					data-detail-formatter="detailFormatter"
					data-detail-view="true"
					data-filter-control="true"
					data-resizable="false"
					data-sort-name="product_name"
					data-sort-order="asc"
					data-toolbar="#products_list_all_table_toolbar"
				id="purchases_products_list_all_table">
					<thead>
						<tr>
							<th data-field="product_name" data-filter-control="input" data-sortable="true"><?php echo lang('product_label_product_name') ?></th>
							<th data-field="product_code" data-filter-control="input" data-sortable="true" data-visible="false"><?php echo lang('product_label_product_code') ?></th>
							<th data-align="right" data-field="weight" data-filter-control="input" data-sortable="true"><?php echo lang('product_label_weight') ?></th>
							<th data-align="right" data-field="buy_price" data-filter-control="input" data-sortable="true"><?php echo lang('product_label_buy_price') ?></th>
							<th data-field="quantity"><?php echo lang('purchases_label_detail_quantity') ?></th>
						</tr>
					</thead>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('label_button_close') ?></button>
				<button type="button" class="btn btn-default" onclick="purchases_products_list_all_add()"><?php echo lang('label_button_add') ?></button>
				<i id="purchases_products_list_all_add_spinner" class="fa fa-refresh fa-spin" style="display: none"></i>
			</div>
		</div>
	</div>
</div>

<script>
	var $table = 'purchases_products_list_all_table';
	var $purchases_detail = 'purchases_detail';
	var $spinner = 'purchases_products_list_all_add_spinner';
	
	function detailFormatter(index, row)
	{
        var html = [];
        html.push('<b><?php echo lang('product_label_product_code') ?> : </b>' + row.product_code + '<br />');
		html.push('<b><?php echo lang('product_label_product_name') ?> : </b>' + row.product_name + '<br />');
		html.push('<b><?php echo lang('product_label_product_category') ?> : </b>' + row.product_category_name + '<br />');
		html.push('<b><?php echo lang('product_label_product_description') ?> : </b>' + nl2br(row.product_description) + '<br />');
		html.push('<b><?php echo lang('product_label_weight') ?> : </b>' + row.weight + '<br />');
		html.push('<b><?php echo lang('product_label_buy_price') ?> : </b>' + number_format_bootstrap_table(row.buy_price) + '<br />');
		return html.join('');
    }
	
	function purchases_calculation(id)
	{
		var price = $('#purchases_buy_price_'+id).val();
		var quantity = $('#purchases_quantity_'+id).val();
		var sub_total = Number(price) * Number(quantity);
		$('#purchases_sub_total_'+id).html( number_format_bootstrap_table(sub_total) );
		
		var total = 0;
		$('.purchases_detail_id').each(function(){
			var id = $(this).val();
			var price = $('#purchases_buy_price_'+id).val();
			var quantity = $('#purchases_quantity_'+id).val();
			
			total += Number(price) * Number(quantity);
		});
		$('#purchases_total').html( number_format_bootstrap_table(total) );
	}

	function purchases_detail_remove(id)
	{
		// $('#'+$purchases_detail).bootstrapTable('remove', {field: 'id', values: id});
		$('#'+$purchases_detail).bootstrapTable('removeByUniqueId', id);
		purchases_calculation(id);
	}

	function purchases_products_list_all_add()
	{
		var data = $('#'+$table).bootstrapTable('getData');
		console.log(data);
		for (var k in data)
		{
			var product_id = data[k].product_id;
			var product_code = data[k].product_code;
			var product_name = data[k].product_name;
			var weight = data[k].weight;
			var buy_price = data[k].buy_price;
			var quantity = Number( $('#products_list_all_quantity_'+product_id).val() );
			
			if (quantity > 0)
			{
				$.ajax({
					async: false,
					beforeSend: function() { $('#'+$spinner).show(); },
					data: { 
						product_id : product_id,
						product_code : product_code,
						product_name: product_name,
						weight : weight,
						buy_price : buy_price,
						quantity : quantity
					},
					error: function() { alert('<?php echo lang('message_error_message') ?>') },
					success: function(data) {
						var data = JSON.parse(data);
						$('#products_list_all_quantity_'+product_id).val('');
						$('#'+$spinner).hide();
						$('#'+$purchases_detail).bootstrapTable('insertRow', {
							index: 0,
							row: data
						});
						purchases_calculation( data.id );
					},
					type: 'POST',
					url: '<?php echo site_url('admin/purchases/purchases_products_list_all_add') ?>'
				});
			}
		}
	}
	
	function purchases_products_list_js(id)
	{
		$('#'+$table).bootstrapTable('refreshOptions', {
			silent: true,
			url: '<?php echo site_url('admin/products/list_all_ajax_by_user_id') ?>/'+id
		});
	}	
</script>