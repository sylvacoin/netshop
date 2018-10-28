
<?= form_open('', 'class="w3-section" method="post" id="login-form"') ?>
	    <?php
	    if ($this->session->flashdata('error') != NULL) {
		echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;
	    }

	    if ($this->session->flashdata('success') != NULL) {
		echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;
	    }
	    ?>
<?= validation_errors(DIV_ERR, DIV_CLOSE) ?>
    <div class="form-group">
	<input id="email" type="email" name="email" required class="input-material">
	<label for="email" class="label-material">Email</label>
    </div>
    <button type="submit" name="btnSubmit" class="btn btn-primary">Recover password</button>
    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
<?= form_close() ?>
<a href="<?= site_url('recovery') ?>" class="forgot-pass">log in</a><br>
<a href="<?= site_url('signup') ?>" class="signup">Signup</a>




