
<?= form_open('', array('method' => 'post', 'id' => 'login-form')) ?>
<?php
if ($this->session->flashdata('error') != NULL) {
    echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;
}

if ($this->session->flashdata('success') != NULL) {
    echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;
}
?>
<?= validation_errors(DIV_ERR, DIV_CLOSE) ?>
<fieldset class="userdata">
    <ul class="ul-list">
	<li class=""> <b>Name</b> <?= $name ?> </li>
    </ul>
</fieldset>
<?= form_close() ?>
	    