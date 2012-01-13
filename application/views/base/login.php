<div id="login_form">
	
	<div id="login_header">
		<p>Willkommen bei</p>
		<p id="login_logo">meetapp</p>
	</div>

	<?php
		echo form_open('/base/login_control/validate_credentials');
		
		echo form_input('username', '', 'placeholder="Benutzername"'); // (Name, Value)
		echo form_password('password', '', 'placeholder="Passwort"');
		echo form_submit('submit', 'Login');
		echo anchor('/base/login_control/fb_login', 'Login mit Facebook'); //Das ist n Link
		echo anchor('/base/login_control/signup', 'Registrieren'); //Das ist n Link
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
