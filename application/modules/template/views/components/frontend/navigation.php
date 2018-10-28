<div class="header">
	<div class="container">
		<div class="logo">
			<a href="<?=site_url()?>"><span>Re</span>sale</a>
		</div>
		<div class="header-right">
		<a class="link" href="<?= site_url('') ?>">Categories</a>
		<a class="link" href="<?= site_url('') ?>">Trending</a>
		<?php if ($this->session->user_id != NULL ): ?>
		<a class="link account" href="<?= site_url('dashboard') ?>">My Account</a>
		<?php else: ?>
		<a class="link" href="<?= site_url('users/login') ?>">Sign In</a>
		<a class="link" href="<?= site_url('users/signup') ?>">Sign Up</a>
		<?php endif; ?>
	</div>
	</div>
</div>
