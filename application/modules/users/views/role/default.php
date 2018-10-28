<div class="row">

    <div class="col-sm-3">
	<!-- popular-news -->
	<div class="popular-news">
	    <?php echo $this->load->view('add') ?>
	</div> <!-- //popular-news -->
    </div> <!-- //col-sm-3 -->

    <div class="col-sm-9">
	<?php
	if ($this->session->flashdata('error') != NULL) {
	    echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;
	}

	if ($this->session->flashdata('success') != NULL) {
	    echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;
	}
	?>
	<?= validation_errors(DIV_ERR, DIV_CLOSE) ?>
	<!-- Latest News -->
	<div class="newedge-latest-news">
	    <div class="row">
		<div class="col-md-12">
		    <?php echo Modules::run('users/role/view') ?>
		</div> <!-- //col-md-8 -->
	    </div> <!-- //row -->
	</div>
	<!-- //Latest News -->
    </div> <!-- //col-sm-9 -->	
</div> <!-- //row -->
