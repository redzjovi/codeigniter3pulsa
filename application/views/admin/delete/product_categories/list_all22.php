<?php if ($this->session->flashdata('product_category_add_success')) : ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('product_category_add_success') ?>
    </div>
<?php endif ?>

<div class="col-lg-12">
    <h1 class="page-header"><?php echo lang('menu_nav_products') ?></h1>
                    
    <?php echo $product_categories['table_length']; ?>
    <?php echo $product_categories['table_pagination']; ?>
    <table class="table table-bordered table-hover table-striped" id="product_categories" style="margin-bottom: 0;">
        <tr>
            <th>No</th>
            <th><a href="<?php echo $product_categories['fields']['product_category_name']['link'] ?>">Product category</a></th>
            <th><a href="<?php echo $product_categories['fields']['active']['link'] ?>">Active</a></th>
        </tr>
        <?php if ($product_categories['result']) : ?>
            <?php $no = $product_categories['offset'] ?>
            <?php foreach($product_categories['result'] as $row) : ?>
            <?php $no++ ?>
            <tr>
                <td><?php echo $no ?></td>
                <td><?php echo $row->product_category_name ?></td>
                <td><?php echo $row->active ?></td>
            </tr>    
            <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td align="center" colspan="3">No results</td>
            </tr>
        <?php endif ?>
    </table>
    <div class="row">
        <div class="col-md-6">
            <?php echo $product_categories['table_pagination']; ?>
        </div>
        <div class="col-md-6" style="text-align: right;">
            <?php echo $product_categories['table_info']; ?>
        </div>
    </div>
    
</div>