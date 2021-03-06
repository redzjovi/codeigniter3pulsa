<?php if ($this->session->flashdata('product_category_label_add_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('product_category_label_add_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('product_category_label_edit_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('product_category_label_edit_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('product_category_label_remove_success')) : ?>
    <div class="alert alert-success">
		<?php echo $this->session->flashdata('product_category_label_remove_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo lang('menu_nav_product_category_list_all') ?>
    </div> 
    <div class="panel-body">
        <div id="product_category_list_all_table_toolbar" class="btn-group">
            <a class="btn btn-default" href="<?php echo site_url('admin/product_categories/add') ?>" role="button">
                <i class="glyphicon glyphicon-plus"></i> <?php echo lang('menu_nav_product_category_add') ?>
            </a>
            <a class="btn btn-default" onclick="settings_remove()" role="button">
                <i class="glyphicon glyphicon-trash"></i> <?php echo lang('menu_nav_product_category_remove') ?>
				<i id="product_category_list_all_button_remove_spinner" class="fa fa-refresh fa-spin" style="display: none"></i>
            </a>
        </div>
        <table 
			data-search="false"
            <?php echo $my_table_options ?>
            data-click-to-select="true"
            data-checkbox-header="true"
			data-cookie="true"
			data-cookie-id-table="product_category_list_all_table_cookie"
			data-filter-control="true"
            data-resizable="false"
			data-sort-name="product_category_name"
            data-sort-order="asc"
			data-toolbar="#product_category_list_all_table_toolbar"
			data-url="<?php echo site_url('admin/product_categories/list_all_ajax') ?>"
        id="product_category_list_all_table">
			<thead>
				<tr>
					<th data-field="product_category_name" data-filter-control="input" data-sortable="true"><?php echo lang('product_category_label_product_category_name') ?></th>
					<th data-field="product_category_parent_name" data-filter-control="input" data-sortable="true"><?php echo lang('product_category_label_product_category_parent') ?></th>
					<th class="table-td-active" data-field="active" data-filter-control="input" data-sortable="true"><?php echo lang('product_category_label_active') ?></th>
					<th class="table-td-action" data-field="action"><?php echo lang('product_category_label_action') ?></th>
					<th data-checkbox="true" data-field="state"></th>
				</tr>
			</thead>
        </table>
	</div>
</div>

<script>
    var $table = $('#product_category_list_all_table')
	
	function settings_remove()
	{
		// alert('getSelections: ' + JSON.stringify($table.bootstrapTable('getSelections')));
		var selections = $table.bootstrapTable('getSelections');
		if (selections.length > 0)
		{
			var product_category_id = [];
			for (var row in selections) { product_category_id.push(selections[row].product_category_id); }
						
			$.ajax({
				beforeSend: function() { $('#product_category_list_all_button_remove_spinner').show(); },
				data: { product_category_id : product_category_id },
				error: function() { alert('<?php echo lang('message_error_message') ?>') },
				success: function(data) {
					 $table.bootstrapTable('refresh', { silent: true });
					 $('#product_category_list_all_button_remove_spinner').hide()
				},
				type: 'POST',
				url: '<?php echo site_url('admin/product_categories/list_all_ajax_remove') ?>'
			});
		}
		else
		{
			alert('<?php echo lang('message_select_error') ?>');
		}
	}
</script>