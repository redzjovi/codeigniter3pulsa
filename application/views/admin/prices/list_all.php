<?php if ($this->session->flashdata('prices_label_add_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('prices_label_add_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('prices_label_edit_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('prices_label_edit_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('prices_label_remove_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('prices_label_remove_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo lang('menu_nav_prices_list_all') ?>
    </div> 
    <div class="panel-body">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo lang('label_button_filter') ?></div>
			<div class="panel-body">
				<form>
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('prices_label_operator_name') ?></label>
						<div class="col-sm-9">
							<input class="form-control" id="prices_list_all_operator_name" placeholder="<?php echo lang('prices_label_operator_name') ?>" type="text">
						</div>
					</div>
					
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('prices_label_price') ?></label>
						<div class="col-sm-9">
							<input class="form-control" id="prices_list_all_price" placeholder="<?php echo lang('prices_label_price') ?>" type="text">
						</div>
					</div>
					
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('prices_label_active') ?></label>
						<div class="col-sm-9">
							<?php if ($status_active) : ?>
								<select class="form-control" id="prices_list_all_active">
									<option value=""><?php echo lang('label_all') ?></option>
									<?php foreach ($status_active as $k => $v) : ?>
										<option value="<?php echo $v->setting_value ?>"><?php echo lang($v->setting_code) ?></option>
									<?php endforeach ?>
								</select>
							<?php endif ?>
						</div>
					</div>
				
					<div class="row">
						<label class="col-sm-3 control-label">
							<button class="btn btn-default" onclick="return prices_list_all_reset()" type="button">
								<i class="fa fa-refresh"></i> <?php echo lang('label_button_reset') ?>
							</button>
						</label>
						<div class="col-sm-9">
							<button class="btn btn-success" onclick="return prices_list_all_filter()" type="submit">
								<i class="fa fa-search"></i> <?php echo lang('label_button_filter') ?>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
        <div id="prices_list_all_table_toolbar" class="btn-group">
            <a class="btn btn-primary" href="<?php echo site_url('admin/prices/add') ?>" role="button">
                <i class="glyphicon glyphicon-plus"></i> <?php echo lang('menu_nav_prices_add') ?>
            </a>
            <a class="btn btn-danger" onclick="prices_remove()" role="button">
                <i class="glyphicon glyphicon-trash"></i> <?php echo lang('menu_nav_prices_remove') ?>
				<i id="prices_list_all_button_remove_spinner" class="fa fa-refresh fa-spin" style="display: none"></i>
            </a>
        </div>
        <table 
			data-search="false"
            <?php echo $my_table_options ?>
            data-click-to-select="true"
            data-checkbox-header="true"
			data-cookie="true"
			data-cookie-id-table="prices_list_all_table_cookie"
			data-page-number="true"
			data-query-params="queryParams"
            data-resizable="false"
			data-show-multi-sort="true" 
			data-sort-name="operator_name"
			
            data-sort-order="asc"
			data-striped="true"
			data-toolbar="#prices_list_all_table_toolbar"
			data-url="<?php echo site_url('admin/prices/list_all_ajax') ?>"
        id="prices_list_all_table">
            <thead>
                <tr>
					<th data-align="center" class="table-th-no" data-formatter="indexFormatter"><?php echo lang('label_no') ?></th>
					<th data-halign="center" data-field="operator_name" data-sortable="true"><?php echo lang('prices_label_operator_name') ?></th>
					<th data-align="right" data-halign="center" data-field="price" data-sortable="true"><?php echo lang('prices_label_price') ?></th>
					<th data-align="right" data-halign="center" data-field="buy_price" data-sortable="true"><?php echo lang('prices_label_buy_price') ?></th>
					<th data-align="right" data-halign="center" data-field="sell_price" data-sortable="true"><?php echo lang('prices_label_sell_price') ?></th>
                    <th class="table-td-active" data-align="center" data-field="active" data-sortable="true"><?php echo lang('prices_label_active') ?></th>
                    <th class="table-td-action" data-align="center" data-field="action"><?php echo lang('prices_label_action') ?></th>
					<th data-checkbox="true" data-field="state"></th>
                </tr>
            </thead>
        </table>
	</div>
</div>

<script>
    var $prices_list_all_operator_name = $('#prices_list_all_operator_name');
	var $prices_list_all_price = $('#prices_list_all_price');
	var $prices_list_all_active = $('#prices_list_all_active');
	var $spinner = $('#prices_list_all_button_remove_spinner');
	var $table = $('#prices_list_all_table');

    function prices_list_all_filter()
	{
		$.jStorage.set( $prices_list_all_operator_name.attr('id'), $prices_list_all_operator_name.val() );
		$.jStorage.set( $prices_list_all_price.attr('id'), $prices_list_all_price.val() );
		$.jStorage.set( $prices_list_all_active.attr('id'), $prices_list_all_active.val() );
		
		$table.bootstrapTable('refresh', {query: queryParams});
		return false;
	}
	
	function prices_list_all_remove()
	{
		var selections = $table.bootstrapTable('getSelections');
		if (selections.length > 0)
		{
			var id = [];
			for (var row in selections) { id.push(selections[row].price_id); }
						
			$.ajax({
				beforeSend: function() { $spinner.show(); },
				data: { id : id },
				error: function() { alert('<?php echo lang('message_error_message') ?>') },
				success: function(data) {
					$table.bootstrapTable('refresh', { silent: true });
					$spinner.hide();
				},
				type: 'POST',
				url: '<?php echo site_url('admin/prices/list_all_ajax_remove') ?>'
			});
		}
		else
		{
			alert('<?php echo lang('message_select_error') ?>');
		}
	}
	
	function prices_list_all_reset()
	{
		$prices_list_all_operator_name.val('');
		$prices_list_all_price.val('');
		$prices_list_all_active.val('');
		
		return prices_list_all_filter();
	}
	
	function queryParams(params)
	{
		return {
            filter: params.filter,
			limit: ($table.bootstrapTable('getOptions').pagination == true ? $table.bootstrapTable('getOptions').pageSize : params.limit),
            offset: params.offset,
            search: params.search,
            sort: params.sort,
			order: params.order,
            
			operator_name: $.jStorage.get( $prices_list_all_operator_name.attr('id') ),
			price: $.jStorage.get( $prices_list_all_price.attr('id') ),
			active: $.jStorage.get( $prices_list_all_active.attr('id') )			
        };
    }
	
	$(function () {
		$prices_list_all_operator_name.val( $.jStorage.get( $prices_list_all_operator_name.attr('id') ) );
		$prices_list_all_price.val( $.jStorage.get( $prices_list_all_price.attr('id') ) );
		$prices_list_all_active.val( $.jStorage.get( $prices_list_all_active.attr('id') ) );
	});
</script>