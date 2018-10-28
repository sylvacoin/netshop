<div class="btn-group pull-right">
    <a href="<?= site_url('exlocations/new-location') ?>" class="btn btn-info waves-effect waves-light">New location</a>
</div>
<div class="clearfix"></div>
<?php if ($this->session->flashdata('success') != null) {echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;}?>
<?php if ($this->session->flashdata('error') != null) {echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;}?>

<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th width="40px">S/N</th>
                <th>Exchange Location</th>
                <th>Approved</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php if (isset($exlocations) && !empty($exlocations)): foreach ($exlocations as $exl):?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $exl->location ?></td>
                <td class="text-center"><?= $exl->is_approved == true ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>' ?></td>
                <td class="text-center">
                    <a href="<?= site_url('exlocations/edit/'.$exl->id) ?>" class="btn btn-circle"><i class="ti-pencil"></i></a>
                    <a href="<?= site_url('exlocations/delete/'.$exl->id) ?>" class="btn btn-circle text-danger"><i class="ti-close"></i></a>
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
