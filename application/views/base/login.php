<div id="login_form">

	<?php
		echo form_open('/base/login_control/validate_credentials');
		
		echo form_input('username', 'Username'); // (Name, Value)
		echo form_password('password', 'Password');
		echo form_submit('submit', 'Login');
		echo anchor('/base/login_control/fb_login', 'Login with Facebook'); //Das ist n Link
		echo anchor('/base/login_control/signup', 'Create Account'); //Das ist n Link
		echo anchor('/base/login_control/logout', 'Logout'); //Das ist n Link
	?>
	
</div>
