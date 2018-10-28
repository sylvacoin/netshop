<div class="w3-container">
    <div class="w3-col l6">
	<div class="w3-card-2 w3-white analytics-info">
	    <div class="w3-container w3-border-bottom">
		<h2><small class="w3-opacity-max">Change password</small></h2>
	    </div>
	    <div class="w3-container">
		<?= form_open('', 'class="w3-section" method="post"') ?>
		<?php
		if ($this->session->flashdata('error') != NULL) {
		    echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;
		}

		if ($this->session->flashdata('success') != NULL) {
		    echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;
		}
		?>
		<?= validation_errors(DIV_ERR, DIV_CLOSE) ?>
		<div class="w3-section">
		    <label class="w3-label w3-text-grey"><b>password</b></label>
		    <input type="text" class="w3-input w3-border" id="email" name="pswd">

		</div>
		<div class="w3-section">
		    <label class="w3-label w3-text-grey"><b>Confirm Password</b></label>
		    <input class="w3-input w3-border" type="text" id="password" name="pswd1">
		</div>
		<button class="w3-button w3-green w3-hover-teal">update password</button>

		<?= form_close() ?>
	    </div>
	</div>

    </div>
</div>
