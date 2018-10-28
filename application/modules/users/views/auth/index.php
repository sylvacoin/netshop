<div class="sign-in-form">
    <div class="sign-in-form-top">
        <h1>Log in</h1>
    </div>
    <div class="signin">
    <?php
if ($this->session->flashdata('error') != null) {
    echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;
}

if ($this->session->flashdata('success') != null) {
    echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;
}
?>
<?=validation_errors(DIV_ERR, DIV_CLOSE)?>
<div class="clearfix"></div>
        <div class="signin-rit">

		    
            <span class="checkbox1">
                    <label class="checkbox"><input type="checkbox" name="checkbox" checked="">Forgot Password ?</label>
            </span>
            <p><a href="<?=site_url('signup')?>">Create an account</a> </p>
            <div class="clearfix"> </div>
        </div>
        <?=form_open('', array('method' => 'post', 'id' => 'login-form'))?>
        <div class="log-input">
            <div class="log-input-left">
                <input type="text" name="email" class="user" placeholder="Your Email" />
            </div>

            <div class="clearfix"> </div>
        </div>
        <div class="log-input">
            <div class="log-input-left">
                <input type="password" name="pswd" class="lock" placeholder="Your password"/>
            </div>

            <div class="clearfix"> </div>
        </div>
        <input type="submit" value="Log in">
		<?=form_close()?>
    </div>
    <div class="new_people">
        <h2>For New People</h2>
        <p>Login with your social media account</p>
		<a href="register.html">Facebook</a>
		<a href="register.html">Google</a>
    </div>
</div>