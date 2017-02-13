<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_product_edit') ?></h1>
                    
    <?php echo form_open('admin/products/edit/'.$data_edit->product_id, array('class' => 'form-horizontal')) ?>
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('product_label_product_code') ?></label>
            <div class="col-sm-10">
                <input autofocus class="form-control" name="product_code" type="text" placeholder="<?php echo lang('product_label_product_code') ?>" value="<?php echo set_value('product_code', $data_edit->product_code) ?>">
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('product_label_product_name') ?> *</label>
            <div class="col-sm-10">
                <input class="form-control" name="product_name" type="text" placeholder="<?php echo lang('product_label_product_name') ?>" value="<?php echo set_value('product_name', $data_edit->product_name) ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('product_label_product_type') ?></label>
            <div class="col-sm-10">
				<div class="checkbox">
					<label>
						<input <?php echo set_checkbox('buy_product', 1, ($data_edit->buy_product ? true : false)) ?> id="buy_product" name="buy_product" type="checkbox" value="1"><?php echo lang('product_label_product_type_buy') ?>
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input <?php echo set_checkbox('produce_product', 1, ($data_edit->produce_product ? true : false)) ?> name="produce_product" type="checkbox" value="1"><?php echo lang('product_label_product_type_produce') ?>
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input <?php echo set_checkbox('sell_product', 1, ($data_edit->sell_product ? true : false)) ?> id="sell_product" name="sell_product" type="checkbox" value="1"><?php echo lang('product_label_product_type_sell') ?>
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input <?php echo set_checkbox('stock_product', 1, ($data_edit->stock_product ? true : false)) ?> name="stock_product" type="checkbox" value="1"><?php echo lang('product_label_product_type_stock') ?>
					</label>
				</div>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('product_label_product_category') ?></label>
            <div class="col-sm-10" style="border: 1px solid #ccc; height: 200px; overflow: auto;">
                <?php $product_category = ($data_edit->product_category) ? explode(',', $data_edit->product_category) : array() ?>
				<?php foreach($product_categories as $row) : ?>
                <div class="checkbox">
					<label>
                        <input <?php echo set_checkbox('product_category', $row->product_category_id, (in_array($row->product_category_id, $product_category) ? true : false) ) ?> name="product_category[]" type="checkbox" value="<?php echo $row->product_category_id ?>"><?php echo $row->product_category_name ?>
                    </label>
                </div>
                <?php endforeach ?>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('product_label_product_description') ?></label>
            <div class="col-sm-10">
				<textarea class="form-control" name="product_description" placeholder="<?php echo lang('product_label_product_description') ?>" rows="5"><?php echo set_value('product_description', $data_edit->product_description) ?></textarea>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('product_label_weight') ?></label>
            <div class="col-sm-10">
                <input class="form-control" name="product_weight" type="text" placeholder="<?php echo lang('product_label_weight') ?>" value="<?php echo set_value('product_weight', $data_edit->weight) ?>">
            </div>
        </div>
		
		<div id="product_list_all_buy_div" class="form-group form-inline" style="<?php echo (set_value('buy_product', $data_edit->buy_product) == 1) ? '' : 'display: none;' ?>">
            <label class="col-sm-2 control-label"><?php echo lang('product_label_buy_price') ?></label>
            <div class="col-sm-10">
                <?php if ($suppliers) : ?>
				<select class="form-control" id="products_list_all_suppliers" style="width: auto;">
					<option value=""></option>
					<?php foreach ($suppliers as $k => $v) : ?>
					<option value="<?php echo $v->user_id ?>"><?php echo $v->name ?></option>
					<?php endforeach ?>
				</select>
				<?php endif ?>
				<a id="products_list_all_button_suppliers_add" class="btn btn-default" role="button">
					<i class="glyphicon glyphicon-plus"></i>
				</a>
				<?php 
					if (set_value('product_supplier_id')) 
					{
						foreach (set_value('product_supplier_id') as $k => $v)
						{
							
							$html = '<div id="supplier_'.$v.'">';
							$html .= 	'<input name="product_supplier_id[]" type="hidden" value="'.$v.'" />';
							$html .= 	'<input name="product_supplier_name[]" type="hidden" value="'.set_value('product_supplier_name')[$k].'" />';
							$html .= 	'<label class="col-sm-2">'.set_value('product_supplier_name')[$k].'</label>';
							$html .= 	'<input class="form-control" name="product_buy_price[]" type="text" value="'.set_value('product_buy_price')[$k].'" />';
							$html .= 	'<a class="btn btn-default" role="button" onclick="$(\'#supplier_'.$v.'\').remove()">';
							$html .=			'<i class="glyphicon glyphicon-remove"></i>';
							$html .=		'</a>';
							$html .= '</div>';
							echo $html;
						}
					}
					else if ($product_users_supplier) 
					{
						foreach ($product_users_supplier as $k => $v)
						{
							
							$html = '<div id="supplier_'.$v->user_id.'">';
							$html .= 	'<input name="product_supplier_id[]" type="hidden" value="'.$v->user_id.'" />';
							$html .= 	'<input name="product_supplier_name[]" type="hidden" value="'.$v->name.'" />';
							$html .= 	'<label class="col-sm-2">'.$v->name.'</label>';
							$html .= 	'<input class="form-control" name="product_buy_price[]" type="text" value="'.$v->buy_price.'" />';
							$html .= 	'<a class="btn btn-default" role="button" onclick="$(\'#supplier_'.$v->user_id.'\').remove()">';
							$html .=			'<i class="glyphicon glyphicon-remove"></i>';
							$html .=		'</a>';
							$html .= '</div>';
							echo $html;
						}
					}
				?>
            </div>
        </div>
		
		<div id="product_list_all_sell_div" class="form-group form-inline" style="<?php echo (set_value('sell_product', $data_edit->sell_product) == 1) ? '' : 'display: none;' ?>">
            <label class="col-sm-2 control-label"><?php echo lang('product_label_sell_price') ?></label>
            <div class="col-sm-10">
                <?php if ($marketplace) : ?>
				<select class="form-control" id="products_list_all_marketplace" style="width: auto;">
					<option value=""></option>
					<?php foreach ($marketplace as $k => $v) : ?>
					<option value="<?php echo $v->user_id ?>"><?php echo $v->name ?></option>
					<?php endforeach ?>
				</select>
				<?php endif ?>
				<a id="products_list_all_button_marketplace_add" class="btn btn-default" role="button">
					<i class="glyphicon glyphicon-plus"></i>
				</a>
				<?php 
					if (set_value('product_marketplace_id')) 
					{
						foreach (set_value('product_marketplace_id') as $k => $v)
						{
							
							$html = '<div id="marketplace_'.$v.'">';
							$html .= 	'<input name="product_marketplace_id[]" type="hidden" value="'.$v.'" />';
							$html .= 	'<input name="product_marketplace_name[]" type="hidden" value="'.set_value('product_marketplace_name')[$k].'" />';
							$html .= 	'<label class="col-sm-2">'.set_value('product_marketplace_name')[$k].'</label>';
							$html .= 	'<input class="form-control" name="product_sell_price[]" type="text" value="'.set_value('product_sell_price')[$k].'" />';
							$html .= 	'<a class="btn btn-default" role="button" onclick="$(\'#marketplace_'.$v.'\').remove()">';
							$html .=			'<i class="glyphicon glyphicon-remove"></i>';
							$html .=		'</a>';
							$html .= '</div>';
							echo $html;
						}
					}
					else if ($product_users_marketplace) 
					{
						foreach ($product_users_marketplace as $k => $v)
						{
							
							$html = '<div id="marketplace_'.$v->user_id.'">';
							$html .= 	'<input name="product_marketplace_id[]" type="hidden" value="'.$v->user_id.'" />';
							$html .= 	'<input name="product_marketplace_name[]" type="hidden" value="'.$v->email.'" />';
							$html .= 	'<label class="col-sm-2">'.$v->email.'</label>';
							$html .= 	'<input class="form-control" name="product_sell_price[]" type="text" value="'.$v->sell_price.'" />';
							$html .= 	'<a class="btn btn-default" role="button" onclick="$(\'#marketplace_'.$v->user_id.'\').remove()">';
							$html .=			'<i class="glyphicon glyphicon-remove"></i>';
							$html .=		'</a>';
							$html .= '</div>';
							echo $html;
						}
					}
				?>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('product_label_active') ?></label>
            <div class="col-sm-10">
                <input <?php echo set_checkbox('product_active', 1, ($data_edit->active == 0 ? false : true) ) ?> name="product_active" type="checkbox" value="1">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-2">
                <a class="btn btn-default" href="<?php echo site_url('admin/products/list_all') ?>" role="button"><?php echo lang('label_button_back') ?></a>
            </div>
            <div class="col-sm-10">
                <input class="btn btn-default" type="submit" value="<?php echo lang('label_button_edit') ?>" />
                <input class="btn btn-danger pull-right" onclick="return confirm('<?php echo lang('message_delete_confirm') ?>') == false ? '' : window.location='<?php echo site_url('admin/products/remove/'.$data_edit->product_id) ?>'" type="button" value="<?php echo lang('label_button_remove') ?>" />
            </div>
        </div>
    <?php echo form_close() ?>   
</div>
<!-- /.col-lg-12 -->

<script>
	$(function () {
		$('#buy_product').change(function() {
			if ($(this).is(":checked")) 
				$("#product_list_all_buy_div").show();
			else
				$("#product_list_all_buy_div").hide();
		});
		$("#products_list_all_button_suppliers_add").click(function() {
			var id ='products_list_all_suppliers';
			if ($('#'+id).val() != '')
			{
				var id_2 = 'supplier_'+$('#'+id).val();
				if ($('#'+id_2).length == 0)
				{
					var html = '';
					html += '<div id="'+id_2+'">';
					html += 	'<input name="product_supplier_id[]" type="hidden" value="'+$('#'+id).val()+'" />';
					html += 	'<input name="product_supplier_name[]" type="hidden" value="'+$('#'+id+' option:selected').text()+'" />';
					html += 	'<label class="col-sm-2">'+$('#'+id+' option:selected').text()+'</label>';
					html += 	'<input class="form-control" name="product_buy_price[]" type="text" />';
					html += 	'<a class="btn btn-default" role="button" onclick="$(\'#'+id_2+'\').remove()">';
					html +=			'<i class="glyphicon glyphicon-remove"></i>';
					html +=		'</a>';
					html += '</div>';
					$(html).insertAfter( $(this) );
				}
			}
		});
		$('#sell_product').change(function() {
			if ($(this).is(":checked")) 
				$("#product_list_all_sell_div").show();
			else
				$("#product_list_all_sell_div").hide();
		});
		$("#products_list_all_button_marketplace_add").click(function() {
			var id ='products_list_all_marketplace';
			if ($('#'+id).val() != '')
			{
				var id_2 = 'marketplace_'+$('#'+id).val();
				if ($('#'+id_2).length == 0)
				{
					var html = '';
					html += '<div id="'+id_2+'">';
					html += 	'<input name="product_marketplace_id[]" type="hidden" value="'+$('#'+id).val()+'" />';
					html += 	'<input name="product_marketplace_name[]" type="hidden" value="'+$('#'+id+' option:selected').text()+'" />';
					html += 	'<label class="col-sm-2">'+$('#'+id+' option:selected').text()+'</label>';
					html += 	'<input class="form-control" name="product_sell_price[]" type="text" />';
					html += 	'<a class="btn btn-default" role="button" onclick="$(\'#'+id_2+'\').remove()">';
					html +=			'<i class="glyphicon glyphicon-remove"></i>';
					html +=		'</a>';
					html += '</div>';
					$(html).insertAfter( $(this) );
				}
			}
		});
	});
</script>