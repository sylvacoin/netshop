<div class="table-responsive">
    <table class="table" id="dataTable">
	<thead>
	    <tr>
		<th>#</th>
		<th>Role</th>
		<th>Default</th>
		<th>Privileges</th>
		<th>&nbsp;</th>
	    </tr>
	</thead>
	<tbody>
	    <?php if ($roles->num_rows() > 0): foreach ( $roles->result() as $row ): ?>
		    <tr>
			<th scope="row"><?= @ ++$i ?></th>
			<td><?php echo $row->role; ?></td>
			<td><?php echo $row->is_default ? 'YES' : 'NO'; ?></td>
			<td>
			    <ul>

			    <?php if( isset($row->priv) && count(unserialize($row->priv)) > 0 ): foreach(unserialize($row->priv) as $priv => $stat): ?>
				<li><?= Modules::run('users/role/get_priv', $priv) ?>: <?= $stat==1?'Yes':'NO' ?></li>
			    <?php endforeach; endif; ?>
			    </ul>
			</td>
			<td>
			    
			    <div class="btn-group  btn-group-sm">
				<?php if ( $row->is_deletable ): ?>
	                        <a href="<?= site_url('role/delete/'.$row->role_id) ?>" class="btn btn-danger" type="button"><i class="fa fa-trash"></i> Delete</a>
				<a href="<?= site_url('role/edit/'.$row->role_id) ?>" class="btn btn-default" type="button"><i class="fa fa-pencil"></i> Edit</a>
				<?php endif; ?>
				<?php if ( $row->is_default === NULL): ?>
				<a href="<?= site_url('role/default/'.$row->role_id) ?>" class="btn btn-default" type="button"><i class="fa fa-bullseye"></i> Make default</a>
				<?php endif; ?>
			    </div>
			   
			</td>
		    </tr>
		<?php endforeach;
	    else:
		?>
    	    <tr>
    		<th colspan="5">no role available at the moment</th>
    	    </tr>
<?php endif; ?>
	</tbody>
    </table>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->  
<!--<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $(document).ready(function () {
            var handleDataTableButtons = function () {
                if ($("#dataTable").length > 0) {
                    $("#dataTable").DataTable();

                    $(".dataTables_wrapper select").select2({
                        minimumResultsForSearch: -1
                    });
                }
            };

            TableManageButtons = function () {
                "use strict";
                return {
                    init: function () {
                        handleDataTableButtons();
                    }
                };
            }();

            TableManageButtons.init();

        });
    });

</script>-->
