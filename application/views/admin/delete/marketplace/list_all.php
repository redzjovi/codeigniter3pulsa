<?php if ($this->session->flashdata('marketplace_label_add_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('marketplace_label_add_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('marketplace_label_edit_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('marketplace_label_edit_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('marketplace_label_remove_success')) : ?>
    <div class="alert alert-success">
		<?php echo $this->session->flashdata('marketplace_label_remove_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo lang('menu_nav_marketplace_list_all') ?>
    </div> 
    <div class="panel-body">
        <div id="marketplace_list_all_table_toolbar" class="btn-group">
            <a class="btn btn-default" href="<?php echo site_url('admin/marketplace/add') ?>" role="button">
                <i class="glyphicon glyphicon-plus"></i> <?php echo lang('menu_nav_marketplace_add') ?>
            </a>
            <a class="btn btn-default" onclick="marketplace_remove()" role="button">
                <i class="glyphicon glyphicon-trash"></i> <?php echo lang('menu_nav_marketplace_remove') ?>
				<i id="marketplace_list_all_button_remove_spinner" class="fa fa-refresh fa-spin" style="display: none"></i>
            </a>
        </div>
        <table 
            data-search="false"
			<?php echo $my_table_options ?>
            data-click-to-select="true"
            data-checkbox-header="true"
			data-cookie="true"
			data-cookie-id-table="marketplace_list_all_table_cookie"
			data-filter-control="true"
            data-resizable="false"
			data-sort-name="email"
            data-sort-order="asc"
			data-toolbar="#marketplace_list_all_table_toolbar"
			data-url="<?php echo site_url('admin/marketplace/list_all_ajax') ?>"
        id="marketplace_list_all_table">
			<thead>
				<tr>
					<th data-field="email" data-filter-control="input" data-sortable="true"><?php echo lang('marketplace_label_name') ?></th>
					<th data-field="active" data-filter-control="input" data-sortable="true"><?php echo lang('marketplace_label_active') ?></th>
					<th class="table-td-action" data-field="action"><?php echo lang('marketplace_label_action') ?></th>
					<th data-checkbox="true" data-field="state"></th>
				</tr>
			</thead>
        </table>
	</div>
</div>

<script>
    var $spinner = $('#marketplace_list_all_button_remove_spinner'),
		$table = $('#marketplace_list_all_table');
	
	function marketplace_remove()
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
				url: '<?php echo site_url('admin/marketplace/remove_ajax') ?>'
			});
		}
		else
		{
			alert('<?php echo lang('message_select_error') ?>');
		}
	}
</script>