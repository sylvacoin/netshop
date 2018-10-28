
<?= form_open('') ?>
<?php
if ($this->session->flashdata('error') != NULL) {
    echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;
}else if ($this->session->flashdata('success') != NULL) {
    echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;
}else{
    redirect('');
}
?>
<?= validation_errors(DIV_ERR, DIV_CLOSE) ?>
<?= form_close() ?>


