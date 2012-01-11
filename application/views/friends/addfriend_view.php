<head>
	<link rel="stylesheet" type="text/css" href="../../css/friends_view_style.css">
	
	<script src="../javascript/jquery.js" ></script>
	<script src="../javascript/jquery-ui.js" ></script>
	
	<script>
	
		$(function() {
							$('#search_field').on('keyup', function() {
								var input = $('#search_field').val();
								if(input != '') {
									$.ajax({
										url: '/friends/friends_control/search_friend/' + input,
										success: function(data)
										{
											$('#add_friend').html(data);
		  								}
									});									
								}
							});
		});
		
	</script>
</head>
<body>
	<?php 
		echo form_input('searchname', 'Type in name...', 'id="search_field"'); 
		//echo anchor('/friends', 'BACK TO FRIENDS', 'id="back_to_friends_button"');
	?>
	<div id="add_friend">
		<?php echo $detail_string; ?>
	</div>
</body>