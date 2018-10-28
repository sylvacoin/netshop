<div class="mtb70">
    <h2 class="title">Profile</h2>
    <div class="row">
        <div class="col-sm-8">
            <form>
            <div class="form-group">
                <input class="form-control" readonly  value="<?= !empty($user->name)?$user->name:'' ?>" type="text">
                <br>
                <input class="form-control" readonly  value="<?= !empty($user->email)?$user->email:'' ?>" type="text">
                <br>
                <input class="form-control" readonly  value="<?= !empty($user->phone)?$user->phone:'' ?>" type="text">
                <br>
                <input type="text" class="form-control" readonly  value="<?= Modules::run('users/role/get_role_name', $user->role_id) ?>">
            </div>
            </form>
            <?= anchor('users/profile/edit', 'Edit Profile', 'class="btn btn-primary"') ?>
        </div>
        <div class="col-sm-4">
            <h3>Office</h3> <br>  
            <p>
                828 L St NW #906, <br>
                Washington, DC 20036, United States <br>
                hello@domain.com <br>
                Tel.: +1234 567 8910 <br> <br>
            </p>
            <p>
                828 L St NW #906, <br>
                Washington, DC 20036, United States <br>
                hello@domain.com <br>
                Tel.: +1234 567 8910 <br>
            </p>
        </div>
    </div> <!-- //row -->
</div>