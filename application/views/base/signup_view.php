<h2>Create Account</h2>

	<?php
	
		echo form_open('base/login_control/create_user');
		echo "Username:";
		echo form_input('username', set_value('username', ''));
		echo "Password:";
		echo form_password('password', '');
		echo form_submit('submit', 'Create Account');
	
	?>

	<?php 
		echo validation_errors('<p id="validation_error">');
	?>