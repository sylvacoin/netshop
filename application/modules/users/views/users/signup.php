<div class="sign-up">
						<h1>Create an account</h1>
						<?php
if ($this->session->flashdata('error') != null) {
    echo DIV_ERR . $this->session->flashdata('error') . DIV_CLOSE;
}

if ($this->session->flashdata('success') != null) {
    echo DIV_SUCCESS . $this->session->flashdata('success') . DIV_CLOSE;
}
?>
						<p class="creating">Having hands on experience in creating innovative designs,I do offer design
							solutions which harness.</p>
						<h2>Personal Information</h2>
						<?=form_open('', array('method' => 'post', 'id' => 'login-form'))?>

			<?=validation_errors(DIV_ERR, DIV_CLOSE)?>
						<div class="sign-u">
							<div class="sign-up1">
								<h5>Full Name* :</h5>
							</div>
							<div class="sign-up2">
								<input type="text" required placeholder="FirstName LastName" name="fname" required class="form-control1" value="<?=isset($fname) ? $fname : set_value('fname')?>"/>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h5>Email Address* :</h5>
							</div>
							<div class="sign-up2">
								<input type="email" required placeholder="username@account.com" name="email" required class="form-control1" value="<?=isset($email) ? $email : set_value('email')?>"/>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h5>Phone Number* :</h5>
							</div>
							<div class="sign-up2">
								<input type="number" placeholder="08010000001" name="phone" required class="form-control1" value="<?=isset($phone) ? $phone : set_value('phone')?>"/>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h5>Password* :</h5>
							</div>
							<div class="sign-up2">
									<input type="password" placeholder="Enter password" name="pswd"  required class="form-control1" value=""/>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sign-u">
							<div class="sign-up1">
								<h5>Confirm Password* :</h5>
							</div>
							<div class="sign-up2">
									<input type="password" placeholder="Confirm Password" name="pswd2" required class="form-control1"/>
							</div>
							<div class="clearfix"> </div>
						</div>
						<div class="sub_home">
							<div class="sub_home_left">
									<input type="submit" value="Create">
							</div>
							<div class="sub_home_right">
								<p>Go Back to <a href="index.html">Home</a></p>
							</div>
							<div class="clearfix"> </div>
						</div>
					</div>
<?=form_close()?>
<!-- Login card -->

<script type="text/javascript">
    function toggle( event )
    {
	if ( event.checked === true )
	{
	    document.getElementById('submit').disabled = false;
	}else{
	    document.getElementById('submit').disabled = true;
	}
    }
</script>