<?php if ($this->session->flashdata('product_label_add_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('product_label_add_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('product_label_edit_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('product_label_edit_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('product_label_remove_success')) : ?>
    <div class="alert alert-success">
		<?php echo $this->session->flashdata('product_label_remove_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo lang('menu_nav_product_list_all') ?>
	</div> 
    <div class="panel-body">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo lang('label_button_filter') ?></div>
			<div class="panel-body">
				<div class="form-group" style="display: none;">
					<label class="col-sm-2 control-label"><?php echo lang('product_label_product_type') ?></label>
					<div class="col-sm-10">
						<div class="checkbox">
							<label class="checkbox-inline">
								<input id="products_list_all_buy_product" type="checkbox" value="1"><?php echo lang('product_label_product_type_buy') ?>
							</label>
							<label class="checkbox-inline">
								<input id="products_list_all_produce_product" type="checkbox" value="1"><?php echo lang('product_label_product_type_produce') ?>
							</label>
							<label class="checkbox-inline">
								<input id="products_list_all_sell_product" type="checkbox" value="1"><?php echo lang('product_label_product_type_sell') ?>
							</label>
							<label class="checkbox-inline">
								<input id="products_list_all_stock_product" type="checkbox" value="1"><?php echo lang('product_label_product_type_stock') ?>
							</label>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo lang('product_label_product_category') ?></label>
					<div class="col-sm-10">
						<?php if ($product_categories) : ?>
						<select class="form-control" id="products_list_all_product_category" style="width: auto;">
							<option value=""><?php echo lang('label_all') ?></option>
							<?php foreach ($product_categories as $k => $v) : ?>
							<option value="<?php echo $v->product_category_id ?>"><?php echo $v->product_category_name ?></option>
							<?php endforeach ?>
						</select>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
        
		<div id="products_list_all_table_toolbar" class="btn-group">
            <a class="btn btn-default" href="<?php echo site_url('admin/products/add') ?>" role="button">
                <i class="glyphicon glyphicon-plus"></i> <?php echo lang('menu_nav_product_add') ?>
            </a>
            <a class="btn btn-default" onclick="products_remove()" role="button">
                <i class="glyphicon glyphicon-trash"></i> <?php echo lang('menu_nav_product_remove') ?>
				<i id="products_list_all_button_remove_spinner" class="fa fa-refresh fa-spin" style="display: none"></i>
            </a>
        </div>
        <table 
            data-search="false"
			data-side-pagination="server"
			<?php echo $my_table_options ?>
			data-click-to-select="true"
			data-checkbox-header="true"
			data-cookie="true"
			data-cookie-id-table="products_list_all_table_cookie"
			data-detail-formatter="detailFormatter"
            data-detail-view="true"
			data-filter-control="true"
			data-query-params="queryParams"
			data-resizable="false"
			data-sort-name="product_name"
            data-sort-order="asc"
			data-toolbar="#products_list_all_table_toolbar"
			data-url="<?php echo site_url('admin/products/list_all_ajax') ?>"
        id="products_list_all_table">
			<thead>
				<tr>
					<th data-field="product_name" data-filter-control="input" data-sortable="true"><?php echo lang('product_label_product_name') ?></th>
					<th data-field="product_code" data-filter-control="input" data-sortable="true" data-visible="false"><?php echo lang('product_label_product_code') ?></th>
					<th data-alignment-Select-Control-Options="right" data-align="right" data-field="weight" data-filter-control="input" data-sortable="true"><?php echo lang('product_label_weight') ?></th>
					<!-- <th data-field="buy_price" data-filter-control="input" data-formatter="number_format_bootstrap_table" data-search-formatter="false" data-sortable="true"><?php // echo lang('product_label_buy_price') ?></th> -->
					<?php
						if ($suppliers)
						{
							$html = ''; foreach ($suppliers as $k => $v)
							{
								$html .= '<th data-align="right" data-field="buy_price_'.$v->user_id.'" data-filter-control="input" data-formatter="number_format_bootstrap_table" data-search-formatter="false" data-sortable="true" data-visible="false">'.lang('label_button_buy').' '.$v->name.'</th>';
							}
							echo $html;
						}
					?>
					<!-- <th data-field="sell_price" data-filter-control="input" data-formatter="number_format_bootstrap_table" data-search-formatter="false" data-sortable="true"><?php // echo lang('product_label_sell_price') ?></th> -->
					<?php
						if ($marketplace)
						{
							$html = ''; foreach ($marketplace as $k => $v)
							{
								$html .= '<th data-align="right" data-field="sell_price_'.$v->user_id.'" data-filter-control="input" data-formatter="number_format_bootstrap_table" data-search-formatter="false" data-sortable="true" data-visible="false">'.lang('label_button_sell').' '.$v->name.'</th>';
							}
							echo $html;
						}
					?>
					<th data-field="active" data-filter-control="input" data-sortable="true"><?php echo lang('product_label_active') ?></th>
					<th class="table-td-action" data-field="action"><?php echo lang('product_label_action') ?></th>
					<th data-checkbox="true" data-field="state"></th>
				</tr>
			</thead>
        </table>
	</div>
</div>

<script>
    var $products_list_all_product_category = $('#products_list_all_product_category'),
		$products_list_all_buy_product = $('#products_list_all_buy_product'),
		$products_list_all_produce_product = $('#products_list_all_produce_product'),
		$products_list_all_sell_product = $('#products_list_all_sell_product'),
		$products_list_all_stock_product = $('#products_list_all_stock_product'),
		$spinner = $('#products_list_all_button_remove_spinner'),
		$table = $('#products_list_all_table');
	
	function detailFormatter(index, row)
	{
        var html = [];
        html.push('<b><?php echo lang('product_label_product_code') ?> : </b>' + row.product_code + '<br />');
		html.push('<b><?php echo lang('product_label_product_name') ?> : </b>' + row.product_name + '<br />');
		html.push('<b><?php echo lang('product_label_product_category') ?> : </b>' + row.product_category_name + '<br />');
		html.push('<b><?php echo lang('product_label_product_description') ?> : </b>' + nl2br(row.product_description) + '<br />');
		html.push('<b><?php echo lang('product_label_weight') ?> : </b>' + row.weight + '<br />');
		// html.push('<b><?php echo lang('product_label_buy_price') ?> : </b>' + number_format_bootstrap_table(row.buy_price) + '<br />');
		<?php 
			if ($suppliers) 
			{
				$html = '';
				$html .= 'html.push("<table>");';
				foreach ($suppliers as $k => $v)
				{
					$html .= 'html.push("<tr>");';
					$html .= 'if (row.buy_price_'.$v->user_id.' > 0) ';
					$html .= 'html.push("<td width=20%><b>'.lang('label_button_buy').' '.$v->name.' : </b></td><td>" + number_format_bootstrap_table(row.buy_price_'.$v->user_id.') + "</td>");
					';
					$html .= 'html.push("</tr>");';
				}
				$html .= 'html.push("</table>");';
				echo $html;
			}
			if ($marketplace) 
			{
				$html = '';
				$html .= 'html.push("<table>");';
				foreach ($marketplace as $k => $v)
				{
					$html .= 'html.push("<tr>");';
					$html .= 'if (row.sell_price_'.$v->user_id.' > 0) ';
					$html .= 'html.push("<td width=20%><b>'.lang('label_button_sell').' '.$v->name.' : </b></td><td>" + number_format_bootstrap_table(row.sell_price_'.$v->user_id.') + "</td>");
					';
					$html .= 'html.push("</tr>");';
				}
				$html .= 'html.push("</table>");';
				echo $html;
			}
		?>
		
		return html.join('');
    }
	
	function products_remove()
	{
		// alert('getSelections: ' + JSON.stringify($table.bootstrapTable('getSelections')));
		var selections = $table.bootstrapTable('getSelections');
		if (selections.length > 0)
		{
			var primary_key = [];
			for (var row in selections) { primary_key.push(selections[row].product_id); }
						
			$.ajax({
				beforeSend: function() { $spinner.show(); },
				data: { primary_key : primary_key },
				error: function() { alert('<?php echo lang('message_error_message') ?>') },
				success: function(data) {
					$table.bootstrapTable('refresh', { silent: true });
					$spinner.hide()
				},
				type: 'POST',
				url: '<?php echo site_url('admin/products/remove_ajax') ?>'
			});
		}
		else
		{
			alert('<?php echo lang('message_select_error') ?>');
		}
	}
	
	function queryParams(params) {
		return {
            filter: params.filter,
			limit: ($table.bootstrapTable('getOptions').pagination == true ? $table.bootstrapTable('getOptions').pageSize : params.limit),
            offset: params.offset,
            search: params.search,
            sort: params.sort,
			order: params.order,
            
			buy_product: $.jStorage.get('products_list_all_buy_product'),
			produce_product: $.jStorage.get('products_list_all_produce_product'),
			sell_product: $.jStorage.get('products_list_all_sell_product'),
			stock_product: $.jStorage.get('products_list_all_stock_product'),
			product_category: $.jStorage.get('products_list_all_product_category')
        };
    }
	
	$(function () {
        $products_list_all_buy_product.change(function() {
			$.jStorage.set( $(this).attr('id'), Number($(this).is(":checked")) );
			$table.bootstrapTable('refresh', {query: queryParams});
		}); 
		$products_list_all_produce_product.change(function() {
			$.jStorage.set( $(this).attr('id'), Number($(this).is(":checked")) );
			$table.bootstrapTable('refresh', {query: queryParams});
		}); 
		$products_list_all_sell_product.change(function() {
			$.jStorage.set( $(this).attr('id'), Number($(this).is(":checked")) );
			$table.bootstrapTable('refresh', {query: queryParams});
		}); 
		$products_list_all_stock_product.change(function() {
			$.jStorage.set( $(this).attr('id'), Number($(this).is(":checked")) );
			$table.bootstrapTable('refresh', {query: queryParams});
		}); 
		$products_list_all_product_category.change(function () {
			$.jStorage.set( $(this).attr('id'), $(this).val() );
			$table.bootstrapTable('refresh', {query: queryParams});
        });
    });
</script>