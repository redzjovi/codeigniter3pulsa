<?php if ($this->session->flashdata('suppliers_label_add_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('suppliers_label_add_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('suppliers_label_edit_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('suppliers_label_edit_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('suppliers_label_remove_success')) : ?>
    <div class="alert alert-success">
		<?php echo $this->session->flashdata('suppliers_label_remove_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo lang('menu_nav_suppliers_list_all') ?>
    </div> 
    <div class="panel-body">
        <div id="suppliers_list_all_table_toolbar" class="btn-group">
            <a class="btn btn-default" href="<?php echo site_url('admin/suppliers/add') ?>" role="button">
                <i class="glyphicon glyphicon-plus"></i> <?php echo lang('menu_nav_suppliers_add') ?>
            </a>
            <a class="btn btn-default" onclick="suppliers_remove()" role="button">
                <i class="glyphicon glyphicon-trash"></i> <?php echo lang('menu_nav_suppliers_remove') ?>
				<i id="suppliers_list_all_button_remove_spinner" class="fa fa-refresh fa-spin" style="display: none"></i>
            </a>
        </div>
        <table 
            data-search="false"
			<?php echo $my_table_options ?>
            data-click-to-select="true"
            data-checkbox-header="true"
			data-cookie="true"
			data-cookie-id-table="suppliers_list_all_table_cookie"
			data-detail-formatter="detailFormatter"
            data-detail-view="true"
			data-filter-control="true"
            data-resizable="false"
			data-sort-name="name"
            data-sort-order="asc"
			data-toolbar="#suppliers_list_all_table_toolbar"
			data-url="<?php echo site_url('admin/suppliers/list_all_ajax') ?>"
        id="suppliers_list_all_table">
			<thead>
				<tr>
					<th data-field="name" data-filter-control="input" data-sortable="true"><?php echo lang('suppliers_label_name') ?></th>
					<th data-field="address" data-filter-control="input" data-sortable="true" data-visible="false"><?php echo lang('suppliers_label_address') ?></th>
					<th data-field="sub_district" data-filter-control="input" data-sortable="true" data-visible="false"><?php echo lang('suppliers_label_sub_district') ?></th>
					<th data-field="regency" data-filter-control="input" data-sortable="true" data-visible="false"><?php echo lang('suppliers_label_regency') ?></th>
					<th data-field="province" data-filter-control="input" data-sortable="true"><?php echo lang('suppliers_label_province') ?></th>
					<th data-field="post_code" data-filter-control="input" data-sortable="true"><?php echo lang('suppliers_label_post_code') ?></th>
					<th data-field="phone" data-filter-control="input" data-sortable="true"><?php echo lang('suppliers_label_phone') ?></th>
					<th data-field="email" data-filter-control="input" data-sortable="true" data-visible="false"><?php echo lang('suppliers_label_email') ?></th>
					<th data-field="active" data-filter-control="input" data-sortable="true"><?php echo lang('suppliers_label_active') ?></th>
					<th class="table-td-action" data-field="action"><?php echo lang('suppliers_label_action') ?></th>
					<th data-checkbox="true" data-field="state"></th>
				</tr>
			</thead>
        </table>
	</div>
</div>

<script>
    var $spinner = $('#suppliers_list_all_button_remove_spinner'),
		$table = $('#suppliers_list_all_table');
	
	function detailFormatter(index, row)
	{
        var html = [];
        html.push('<b><?php echo lang('suppliers_label_name') ?> : </b>' + nl2br(row.name) + '<br>');
		html.push('<b><?php echo lang('suppliers_label_address') ?> : </b>' + nl2br(row.address) + '<br>');
		html.push('<b><?php echo lang('suppliers_label_sub_district') ?> : </b>' + nl2br(row.sub_district) + '<br>');
        html.push('<b><?php echo lang('suppliers_label_regency') ?> : </b>' + nl2br(row.regency) + '<br>');
		html.push('<b><?php echo lang('suppliers_label_province') ?> : </b>' + nl2br(row.province) + '<br>');
		html.push('<b><?php echo lang('suppliers_label_post_code') ?> : </b>' + nl2br(row.post_code) + '<br>');
		html.push('<b><?php echo lang('suppliers_label_phone') ?> : </b>' + nl2br(row.phone) + '<br>');
		html.push('<b><?php echo lang('suppliers_label_email') ?> : </b>' + nl2br(row.email) + '<br>');
		return html.join('');
    }
	
	function suppliers_remove()
	{
		// alert('getSelections: ' + JSON.stringify($table.bootstrapTable('getSelections')));
		var selections = $table.bootstrapTable('getSelections');
		if (selections.length > 0)
		{
			var primary_key = [];
			for (var row in selections) { primary_key.push(selections[row].user_id); }
						
			$.ajax({
				beforeSend: function() { $spinner.show(); },
				data: { primary_key : primary_key },
				error: function() { alert('<?php echo lang('message_error_message') ?>') },
				success: function(data) {
					$table.bootstrapTable('refresh', { silent: true });
					$spinner.hide()
				},
				type: 'POST',
				url: '<?php echo site_url('admin/suppliers/remove_ajax') ?>'
			});
		}
		else
		{
			alert('<?php echo lang('message_select_error') ?>');
		}
	}
</script>