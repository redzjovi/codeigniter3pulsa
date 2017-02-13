<?php if ($this->session->flashdata('settings_label_add_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('settings_label_add_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('settings_label_edit_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('settings_label_edit_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>
<?php if ($this->session->flashdata('settings_label_remove_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('settings_label_remove_success') ?>
		<button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
<?php endif ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo lang('menu_nav_settings_list_all') ?>
    </div> 
    <div class="panel-body">
        <div id="settings_list_all_table_toolbar" class="btn-group">
            <a class="btn btn-default" href="<?php echo site_url('admin/settings/add') ?>" role="button">
                <i class="glyphicon glyphicon-plus"></i> <?php echo lang('menu_nav_settings_add') ?>
            </a>
            <a class="btn btn-default" onclick="settings_remove()" role="button">
                <i class="glyphicon glyphicon-trash"></i> <?php echo lang('menu_nav_settings_remove') ?>
				<i id="settings_list_all_button_remove_spinner" class="fa fa-refresh fa-spin" style="display: none"></i>
            </a>
        </div>
        <table 
            <?php echo $my_table_options ?>
            data-click-to-select="true"
            data-checkbox-header="true"
			data-cookie="true"
			data-cookie-id-table="settings_list_all_table_cookie"
            data-detail-formatter="detailFormatter"
            data-detail-view="true"
            data-resizable="false"
			data-sort-name="setting_code"
            data-sort-order="asc"
			data-toolbar="#settings_list_all_table_toolbar"
			data-url="<?php echo site_url('admin/settings/list_all_ajax') ?>"
        id="settings_list_all_table">
            <thead>
                <tr>
                    <th data-field="setting_code" data-sortable="true"><?php echo lang('settings_label_setting_code') ?></th>
                    <th data-field="setting_value" data-sortable="true"><?php echo lang('settings_label_setting_value') ?></th>
                    <th data-field="setting_description" data-sortable="true" data-visible="false"><?php echo lang('settings_label_setting_description') ?></th>
                    <th class="table-td-active" data-field="active" data-sortable="true"><?php echo lang('settings_label_setting_active') ?></th>
                    <th class="table-td-action" data-field="action"><?php echo lang('settings_label_setting_action') ?></th>
					<th data-checkbox="true" data-field="state"></th>
                </tr>
            </thead>
        </table>
	</div>
</div>

<script>
    var $table = $('#settings_list_all_table')

    function detailFormatter(index, row) {
        var html = [];
        // $.each(row, function (key, value) {
            // html.push('<p><b>' + key + ':</b> ' + value + '</p>');
        // });
		html.push('<p><b><?php echo lang('settings_label_setting_description') ?> :</b><br>' + nl2br(row.setting_description) + '</p>');
        return html.join('');
    }
	
	function settings_remove()
	{
		// alert('getSelections: ' + JSON.stringify($table.bootstrapTable('getSelections')));
		var selections = $table.bootstrapTable('getSelections');
		if (selections.length > 0)
		{
			var setting_id = [];
			for (var row in selections) { setting_id.push(selections[row].setting_id); }
						
			$.ajax({
				beforeSend: function() { $('#settings_list_all_button_remove_spinner').show(); },
				data: { setting_id : setting_id },
				error: function() { alert('<?php echo lang('message_error_message') ?>') },
				success: function(data) {
					 $table.bootstrapTable('refresh', { silent: true });
					 $('#settings_list_all_button_remove_spinner').hide()
				},
				type: 'POST',
				url: '<?php echo site_url('admin/settings/list_all_ajax_remove') ?>'
			});
		}
		else
		{
			alert('<?php echo lang('message_select_error') ?>');
		}
	}
</script>