<div class="btn-group pull-right">
    <a href="<?= site_url('categories/new-category') ?>" class="btn btn-info waves-effect waves-light">New Category</a>
</div>
<div class="clearfix"></div>
<?php if ($this->session->flashdata('success') != null) {echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;}?>
<?php if ($this->session->flashdata('error') != null) {echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;}?>

<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th width="40px">S/N</th>
                <th width="40px">icon</th>
                <th>Category</th>
                <th>Parent Category</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php if (isset($categories) && !empty($categories)): foreach ($categories as $cat):?>
            <tr>
                <td><?= $i++ ?></td>
                <td><i class="<?= $cat->icon ?>"></i></td>
                <td><?= $cat->category ?></td>
                <td><?= $cat->parent ? $cat->parent : '-' ?></td>
                <td class="text-center">
                    <a href="<?= site_url('categories/edit/'.$cat->id) ?>" class="btn btn-circle"><i class="ti-pencil"></i></a>
                    <a href="<?= site_url('categories/delete/'.$cat->id) ?>" class="btn btn-circle text-danger"><i class="ti-close"></i></a>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="6"></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
