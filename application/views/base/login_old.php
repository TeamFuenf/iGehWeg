      	<script>
	      	$(function() {
	      		$('#login_info').hide();
	      		$('#login_button').on('click', function() {
	      			var username = $('#username').val();
	      			var password = $('#password').val();
					console.log(username);
					console.log(password);
					$.ajax({
						url: '/base/login/login_user/' + username + '/' + password,
						success: function(data) {
							$('#login_content').html(data);
							$('#login_info').show();
						}
					});
				});
				
				$('#logout_button').on('click', function() {
					$.ajax({
						url: '/base/login/logout_user/',
						success: function(data) {
							$('#login_content').html("user logged out");
						}
					});
				});
				
				$('#session_test').on('click', function() {
					$.ajax({
						url: '/base/login/session_test/',
						success: function(data) {
							$('#login_info').html(data);
							$('#login_info').show();
						}
					});
				});
			});
      	</script>
      	<div id="login_content">
      	<form id="form">
      		<p>Username:</p>
      		<input type="text" name="username" id="username"/>
      		<p>Password:</p>
      		<input type="password" name="password" id="password"/>
      	</form>
      	<div id="login_buttons">
	      	<span id="login_button">LOGIN</span>
	      	<span id="logout_button">LOGOUT</span>
      	</div>
      	<span id="session_test">Session</span>
		<div id="login_info"></div>
		</div>