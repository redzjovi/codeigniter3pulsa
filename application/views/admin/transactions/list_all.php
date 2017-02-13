<?php if ($this->session->flashdata('transactions_label_add_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('transactions_label_add_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('transactions_label_edit_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('transactions_label_edit_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('transactions_label_remove_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('transactions_label_remove_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo lang('menu_nav_transactions_list_all') ?>
    </div> 
    <div class="panel-body">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo lang('label_button_filter') ?></div>
			<div class="panel-body">
				<form>
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('transactions_label_transaction_date') ?></label>
						<div class="col-sm-9">
							<input class="form-control" id="transactions_list_all_transaction_date" placeholder="<?php echo lang('transactions_label_transaction_date') ?>" type="text">
						</div>
					</div>
					
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('transactions_label_name') ?></label>
						<div class="col-sm-9">
							<input class="form-control" id="transactions_list_all_name" placeholder="<?php echo lang('transactions_label_name') ?>" type="text">
						</div>
					</div>
					
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('transactions_label_operator') ?></label>
						<div class="col-sm-9">
							<input class="form-control" id="transactions_list_all_operator_name" placeholder="<?php echo lang('transactions_label_operator') ?>" type="text">
						</div>
					</div>
					
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('transactions_label_price') ?></label>
						<div class="col-sm-9">
							<input autofocus class="form-control" id="transactions_list_all_price" placeholder="<?php echo lang('transactions_label_price') ?>" type="text">
						</div>
					</div>
					
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('transactions_label_status') ?></label>
						<div class="col-sm-9">
							<?php if ($transaction_status) : ?>
								<select class="form-control" id="transactions_list_all_status">
									<option value=""><?php echo lang('label_all') ?></option>
									<?php foreach ($transaction_status as $k => $v) : ?>
										<option value="<?php echo $v->setting_value ?>"><?php echo lang($v->setting_code) ?></option>
									<?php endforeach ?>
								</select>
							<?php endif ?>
						</div>
					</div>
				
					<div class="row">
						<label class="col-sm-3 control-label">
							<button class="btn btn-default" onclick="return transactions_list_all_reset()" type="button">
								<i class="fa fa-refresh"></i> <?php echo lang('label_button_reset') ?>
							</button>
						</label>
						<div class="col-sm-9">
							<button class="btn btn-success" onclick="return transactions_list_all_filter()" type="submit">
								<i class="fa fa-search"></i> <?php echo lang('label_button_filter') ?>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
        <div id="transactions_list_all_table_toolbar" class="btn-group">
            <a class="btn btn-primary" href="<?php echo site_url('admin/transactions/add') ?>" role="button">
                <i class="glyphicon glyphicon-plus"></i> <?php echo lang('menu_nav_transactions_add') ?>
            </a>
            <a class="btn btn-danger" onclick="transactions_remove()" role="button">
                <i class="glyphicon glyphicon-trash"></i> <?php echo lang('menu_nav_transactions_remove') ?>
				<i id="transactions_list_all_button_remove_spinner" class="fa fa-refresh fa-spin" style="display: none"></i>
            </a>
        </div>
        <table 
			data-search="false"
            <?php echo $my_table_options ?>
            data-click-to-select="true"
            data-checkbox-header="true"
			data-cookie="true"
			data-cookie-id-table="transactions_list_all_table_cookie"
			data-page-number="true"
			data-query-params="queryParams"
            data-resizable="false"
			data-show-export="true"
			data-show-multi-sort="true" 
			data-sort-name="transaction_date"
            data-sort-order="desc"
			data-striped="true"
			data-toolbar="#transactions_list_all_table_toolbar"
			data-url="<?php echo site_url('admin/transactions/list_all_ajax') ?>"
        id="transactions_list_all_table">
            <thead>
                <tr>
					<th data-align="center" class="table-th-no" data-formatter="indexFormatter"><?php echo lang('label_no') ?></th>
					<th data-halign="center" data-field="transaction_date" data-sortable="true"><?php echo lang('transactions_label_transaction_date') ?></th>
					<th data-halign="center" data-field="name" data-sortable="true"><?php echo lang('transactions_label_name') ?></th>
					<th data-halign="center" data-field="operator_name" data-sortable="true"><?php echo lang('transactions_label_operator') ?></th>
					<th data-align="right" data-halign="center" data-field="price" data-sortable="true"><?php echo lang('transactions_label_price') ?></th>
					<th data-align="right" data-halign="center" data-field="buy_price" data-sortable="true" data-visible="false"><?php echo lang('transactions_label_buy_price') ?></th>
					<th data-align="right" data-halign="center" data-field="sell_price" data-sortable="true"><?php echo lang('transactions_label_sell_price') ?></th>
                    <th class="table-td-active" data-align="center" data-field="status" data-sortable="true"><?php echo lang('transactions_label_status') ?></th>
                    <th class="table-td-action" data-align="center" data-field="action"><?php echo lang('transactions_label_action') ?></th>
					<th data-checkbox="true" data-field="state"></th>
                </tr>
            </thead>
        </table>
	</div>
</div>

<script>
    var $transactions_list_all_transaction_date = $('#transactions_list_all_transaction_date');
	var $transactions_list_all_name = $('#transactions_list_all_name');
	var $transactions_list_all_operator_name = $('#transactions_list_all_operator_name');
	var $transactions_list_all_price = $('#transactions_list_all_price');
	var $transactions_list_all_status = $('#transactions_list_all_status');
	var $spinner = $('#transactions_list_all_button_remove_spinner');
	var $table = $('#transactions_list_all_table');

    function transactions_list_all_filter()
	{
		$.jStorage.set( $transactions_list_all_transaction_date.attr('id'), $transactions_list_all_transaction_date.val() );
		$.jStorage.set( $transactions_list_all_name.attr('id'), $transactions_list_all_name.val() );
		$.jStorage.set( $transactions_list_all_operator_name.attr('id'), $transactions_list_all_operator_name.val() );
		$.jStorage.set( $transactions_list_all_price.attr('id'), $transactions_list_all_price.val() );
		$.jStorage.set( $transactions_list_all_status.attr('id'), $transactions_list_all_status.val() );
		
		$table.bootstrapTable('refresh', {query: queryParams});
		return false;
	}
	
	function transactions_list_all_remove()
	{
		var selections = $table.bootstrapTable('getSelections');
		if (selections.length > 0)
		{
			var id = [];
			for (var row in selections) { id.push(selections[row].transaction_id); }
						
			$.ajax({
				beforeSend: function() { $spinner.show(); },
				data: { id : id },
				error: function() { alert('<?php echo lang('message_error_message') ?>') },
				success: function(data) {
					$table.bootstrapTable('refresh', { silent: true });
					$spinner.hide();
				},
				type: 'POST',
				url: '<?php echo site_url('admin/transactions/list_all_ajax_remove') ?>'
			});
		}
		else
		{
			alert('<?php echo lang('message_select_error') ?>');
		}
	}
	
	function transactions_list_all_reset()
	{
		$transactions_list_all_transaction_date.val('');
		$transactions_list_all_name.val('');
		$transactions_list_all_operator_name.val('');
		$transactions_list_all_price.val('');
		$transactions_list_all_status.val('');
		
		return transactions_list_all_filter();
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
            
			transaction_date: $.jStorage.get( $transactions_list_all_transaction_date.attr('id') ),
			name: $.jStorage.get( $transactions_list_all_name.attr('id') ),
			operator_name: $.jStorage.get( $transactions_list_all_operator_name.attr('id') ),
			price: $.jStorage.get( $transactions_list_all_price.attr('id') ),
			status: $.jStorage.get( $transactions_list_all_status.attr('id') )			
        };
    }
	
	$(function () {
		$transactions_list_all_transaction_date.daterangepicker({
			locale: {
				cancelLabel: 'Clear',
				format: '<?php echo $format_datetime_js ?>'
			},
			ranges: {
			   'Today': [moment(), moment()],
			   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			   'This Month': [moment().startOf('month'), moment().endOf('month')],
			   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			},
			timePicker: true,
			timePickerIncrement: 1
		});
		$transactions_list_all_transaction_date.val( $.jStorage.get( $transactions_list_all_transaction_date.attr('id') ) );
		$transactions_list_all_name.val( $.jStorage.get( $transactions_list_all_name.attr('id') ) );
		$transactions_list_all_operator_name.val( $.jStorage.get( $transactions_list_all_operator_name.attr('id') ) );
		$transactions_list_all_price.val( $.jStorage.get( $transactions_list_all_price.attr('id') ) );
		$transactions_list_all_status.val( $.jStorage.get( $transactions_list_all_status.attr('id') ) );
		$table.bootstrapTable('refreshOptions', {
			exportTypes: ['csv', 'excel']
		});
	});
</script>