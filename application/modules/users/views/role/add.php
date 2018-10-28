
<?= form_open( (is_numeric($this->uri->segment(3))?'role/edit/'.$id:'role/add'), 'class="form-horizontal form-label-left"') ?>
<div class="form-group">
    <label class="control-label col-sm-3 col-xs-12">Role: </label>
    <div class="col-sm-9 col-xs-12">
	<input type="text" class="form-control" placeholder="Role name" 
	       value="<?= isset($role) ? $role : set_value('role'); ?>" name="role">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-12 col-xs-12 text-left">Privileges: </label>
    <div class="col-sm-3 col-xs-12"></div>
    <div class="col-sm-9">
	<div class="checkbox checkbox-primary">
	    <input value="1" type="checkbox" name="priv[cm_users]" id="cm_users"
		   <?= isset($priv['cm_users']) && $priv['cm_users'] == 1 ? 'checked' : set_value('priv[cm_users]'); ?>> 
	    <label for="role">can manage users</label>
	</div>
	<div class="checkbox checkbox-primary">
	    <input value="1" type="checkbox" name="priv[cm_roles]" id="cm_roles"
		   <?= isset($priv['cm_roles']) && $priv['cm_roles'] == 1 ? 'checked' : set_value('priv[cm_roles]'); ?>> 
	    <label for="role">can manage roles</label>
	</div>
	<div class="checkbox checkbox-primary">
	    <input value="1" type="checkbox" name="priv[cm_site]" id="cm_site"
		   <?= isset($priv['cm_site']) && $priv['cm_site'] == 1 ? 'checked' : set_value('priv[cm_site]'); ?>> 
	    <label for="role">can manage site</label>
	</div>
	<div class="checkbox checkbox-primary">
	    <input value="1" type="checkbox" name="priv[cm_posts]" id="cm_posts"
		   <?= isset($priv['cm_posts']) && $priv['cm_posts'] == 1 ? 'checked' : set_value('priv[cm_posts]'); ?>> 
	    <label for="role">can manage posts</label>
	</div>
	<div class="checkbox checkbox-primary">
	    <input value="1" type="checkbox" name="priv[cs_sms]" id="cs_sms"
		   <?= isset($priv['cs_sms']) && $priv['cs_sms'] == 1 ? 'checked' : set_value('priv[cs_sms]'); ?>> 
	    <label for="role">can send sms</label>
	</div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 col-xs-12">
	<div class="checkbox checkbox-primary">
	    <input value="1" type="checkbox" name="default" id="default"
		   <?= isset($default) && $default == 1 ? 'checked' : set_value('default'); ?>> 
	    <label for="role">click to set role as default role for new users
	    </label>
	</div>

    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-3 col-xs-12">
	<button type="submit" class="btn btn-primary pull-right-md">Add Role <i class="fa fa-check-circle"></i></button>
    </div>
</div>

<?= form_close() ?>
	    