<div id="signup_form">
	
	<div id="signup_header">
		<p>Registrieren</p>
	</div>
	<?php
	
		echo form_open('base/login_control/create_user');
		// echo "Username:";
		echo form_input('username', set_value('username', ''), 'placeholder="Benutzername"');
		// echo "Password:";
		echo form_password('password','', 'placeholder="Passwort"');
		echo form_submit('submit', 'Registrieren');
		echo anchor('/base/login_control/', 'zurück'); //Das ist n Link
	?>

	<?php 
		echo validation_errors('<p id="validation_error">');
	?>
	
</div>

<style>
	div#dropshadow_controls {
		display: none;
	}

	div#controls {
		display: none;
	}
</style>