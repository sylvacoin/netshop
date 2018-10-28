<!-- Latest News -->
<div class="row">
    <div class="col-sm-12">
	<div class="newedge-latest-news default">
	    <div class="row">
		<div class="col-sm-12">
		    <?php
		    if ($this->session->flashdata('error') != NULL) {
			echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;
		    }

		    if ($this->session->flashdata('success') != NULL) {
			echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;
		    }
		    ?>
		    <?= validation_errors(DIV_ERR, DIV_CLOSE) ?>
		    <div class="table-responsive">
			<table class="table table-hover table-striped table-condensed table-bordered">
			    <thead>
				<tr>
				    <th>#</th>
				    <th>Full Name</th>
				    <th>Email</th>
				    <th>Phone</th>
				    <th>units</th>
				    <th>Status</th>
				    <th>Last seen</th>
				    <th>Registration date</th>
				    <th>&nbsp;</th>
				</tr>
			    </thead>
			    <tbody>
				<?php if (isset($users) && count($users) > 0): $i = 1;
				    foreach ( $users as $c ):
					?>
					<tr>
					    <td><?= $i++ ?></td>
					    <td><?= isset($c->name) ? $c->name : '' ?></td>
					    <td><?= isset($c->email) ? $c->email : '' ?></td>
					    <td><?= isset($c->phone) ? $c->phone : ''; ?></td>
					    <td><?= isset($c->units) ? $c->units : 0; ?></td>
					    <td><?= isset($c->token) && $c->token == 1 ? 'Active' : 'pending'; ?></td>
					    <td><?= isset($c->last_seen) ? date('jS F Y', $c->last_seen) : ''; ?></td>
					     <td><?= isset($c->reg_date) ? date('jS F Y', $c->regdate) : ''; ?></td>
					    <td>
						<div class="btn-group">
						    <a href="javascript:void();" class="btn btn-default" onclick="showAjaxModal('<?= base_url() ?>modal/modal_view_user/<?= $c->user_id ?>');" ><i class="fa fa-eye"></i></a>
						    <a href="javascript:void();" class="btn btn-default" onclick="showAjaxModal('<?= base_url() ?>modal/modal_fund_user/<?= rawurlencode($c->name) ?>/<?= $c->user_id ?>');" ><i class="fa fa-money"></i></a>
						    
						    <a href="javascript:void();" class="btn btn-danger" onclick="confirm_modal('<?= site_url('users/delete/'.$c->user_id ) ?>')" ><i class="fa fa-trash"></i></a>
						</div>
					    </td>
					</tr>
    <?php endforeach;
else: ?>
    				<tr>
    				    <td colspan="5"> no message history </td>
    				</tr>
<?php endif; ?>
			    </tbody>
			</table>
		    </div>
		</div>
	    </div> <!-- //row -->

	</div>
	<!-- //Latest News -->
    </div>
</div>
<?= Modules::run('modal/init_modal') ?>