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
	<div class="button_side">
	<h1>Freunde hinzufügen:</h1>
	<?php 
		$attr = array( 'name' => 'searchname', 'id' => 'search_field', 'placeholder' => 'Name...');
		echo form_input($attr); 
	?>
	</div>
	<br/>
	<div id="add_friend">
		<?php echo $detail_string; ?>
	</div>
</body>