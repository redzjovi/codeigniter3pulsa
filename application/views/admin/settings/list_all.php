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
        <div class="panel panel-default">
			<div class="panel-heading"><?php echo lang('label_button_filter') ?></div>
			<div class="panel-body">
				<form>
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('settings_label_setting_code') ?></label>
						<div class="col-sm-9">
							<input class="form-control" id="settings_list_all_setting_code" placeholder="<?php echo lang('settings_label_setting_code') ?>" type="text">
						</div>
					</div>
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('settings_label_setting_value') ?></label>
						<div class="col-sm-9">
							<input class="form-control" id="settings_list_all_setting_value" placeholder="<?php echo lang('settings_label_setting_value') ?>" type="text">
						</div>
					</div>
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('settings_label_setting_description') ?></label>
						<div class="col-sm-9">
							<input class="form-control" id="settings_list_all_setting_description" placeholder="<?php echo lang('settings_label_setting_description') ?>" type="text">
						</div>
					</div>
					<div class="row">
						<label class="col-sm-3 control-label"><?php echo lang('settings_label_active') ?></label>
						<div class="col-sm-9">
							<?php if ($status_active) : ?>
								<select class="form-control" id="settings_list_all_active">
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
							<button class="btn btn-default" onclick="return settings_list_all_reset()" type="button">
								<i class="fa fa-refresh"></i> <?php echo lang('label_button_reset') ?>
							</button>
						</label>
						<div class="col-sm-9">
							<button class="btn btn-success" onclick="return settings_list_all_filter()" type="submit">
								<i class="fa fa-search"></i> <?php echo lang('label_button_filter') ?>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<div id="settings_list_all_table_toolbar" class="btn-group">
            <a class="btn btn-primary" href="<?php echo site_url('admin/settings/add') ?>" role="button">
                <i class="glyphicon glyphicon-plus"></i> <?php echo lang('menu_nav_settings_add') ?>
            </a>
            <a class="btn btn-danger" onclick="settings_list_all_remove()" role="button">
                <i class="glyphicon glyphicon-trash"></i> <?php echo lang('menu_nav_settings_remove') ?>
				<i id="settings_list_all_button_remove_spinner" class="fa fa-refresh fa-spin" style="display: none"></i>
            </a>
        </div>
        <table 
            data-search="false"
			<?php echo $my_table_options ?>
            data-click-to-select="true"
            data-checkbox-header="true"
			data-cookie="true"
			data-cookie-id-table="settings_list_all_table_cookie"
            data-detail-formatter="detailFormatter"
            data-detail-view="true"
			data-query-params="queryParams"
            data-resizable="false"
			data-sort-name="setting_code"
            data-sort-order="asc"
			data-toolbar="#settings_list_all_table_toolbar"
			data-url="<?php echo site_url('admin/settings/list_all_ajax') ?>"
        id="settings_list_all_table">
            <thead>
                <tr>
                    <th class="table-th-no" data-align="center" data-formatter="indexFormatter"><?php echo lang('label_no') ?></th>
					<th data-field="setting_code" data-halign="center" data-sortable="true"><?php echo lang('settings_label_setting_code') ?></th>
                    <th data-field="setting_value" data-halign="center" data-sortable="true"><?php echo lang('settings_label_setting_value') ?></th>
                    <th data-field="setting_description" data-halign="center" data-sortable="true" data-visible="false"><?php echo lang('settings_label_setting_description') ?></th>
                    <th class="table-td-active" data-align="center" data-field="active" data-sortable="true"><?php echo lang('settings_label_active') ?></th>
                    <th class="table-td-action" data-align="center" data-field="action"><?php echo lang('settings_label_action') ?></th>
					<th data-checkbox="true" data-field="state"></th>
                </tr>
            </thead>
        </table>
	</div>
</div>

<script>
    var $settings_list_all_setting_code = $('#settings_list_all_setting_code');
	var $settings_list_all_setting_value = $('#settings_list_all_setting_value');
	var $settings_list_all_setting_description = $('#settings_list_all_setting_description');
	var $settings_list_all_active = $('#settings_list_all_active');
	var $spinner = $('#settings_list_all_button_remove_spinner');
	var $table = $('#settings_list_all_table')

    function detailFormatter(index, row)
	{
        var html = [];
        // $.each(row, function (key, value) {
            // html.push('<p><b>' + key + ':</b> ' + value + '</p>');
        // });
		html.push('<p><b><?php echo lang('settings_label_setting_description') ?> :</b><br>' + nl2br(row.setting_description) + '</p>');
        return html.join('');
    }
	
	function settings_list_all_filter()
	{
		$.jStorage.set( $settings_list_all_setting_code.attr('id'), $settings_list_all_setting_code.val() );
		$.jStorage.set( $settings_list_all_setting_value.attr('id'), $settings_list_all_setting_value.val() );
		$.jStorage.set( $settings_list_all_setting_description.attr('id'), $settings_list_all_setting_description.val() );
		$.jStorage.set( $settings_list_all_active.attr('id'), $settings_list_all_active.val() );
		
		$table.bootstrapTable('refresh', {query: queryParams});
		return false;
	}
	
	function settings_list_all_remove()
	{
		// alert('getSelections: ' + JSON.stringify($table.bootstrapTable('getSelections')));
		var selections = $table.bootstrapTable('getSelections');
		if (selections.length > 0)
		{
			var primary_key = [];
			for (var row in selections) { primary_key.push(selections[row].setting_id); }
						
			$.ajax({
				beforeSend: function() { $spinner.show(); },
				data: { primary_key : primary_key },
				error: function() { alert('<?php echo lang('message_error_message') ?>') },
				success: function(data) {
					$table.bootstrapTable('refresh', { silent: true });
					$spinner.hide()
				},
				type: 'POST',
				url: '<?php echo site_url('admin/settings/remove_ajax') ?>'
			});
		}
		else
		{
			alert('<?php echo lang('message_select_error') ?>');
		}
	}

	function settings_list_all_reset()
	{
		$settings_list_all_setting_code.val('');
		$settings_list_all_setting_value.val('');
		$settings_list_all_setting_description.val('');
		$settings_list_all_active.val('');
		
		return settings_list_all_filter();
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
            
			setting_code: $.jStorage.get( $settings_list_all_setting_code.attr('id') ),
			setting_value: $.jStorage.get( $settings_list_all_setting_value.attr('id') ),
			setting_description: $.jStorage.get( $settings_list_all_setting_description.attr('id') ),
			active: $.jStorage.get( $settings_list_all_active.attr('id') )			
        };
    }
	
	$(function () {
		$settings_list_all_setting_code.val( $.jStorage.get( $settings_list_all_setting_code.attr('id') ) );
		$settings_list_all_setting_value.val( $.jStorage.get( $settings_list_all_setting_value.attr('id') ) );
		$settings_list_all_setting_description.val( $.jStorage.get( $settings_list_all_setting_description.attr('id') ) );
		$settings_list_all_active.val( $.jStorage.get( $settings_list_all_active.attr('id') ) );
	});
</script>