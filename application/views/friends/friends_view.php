<head>
	<link rel="stylesheet" type="text/css" href="../css/friends_view_style.css">
	
	<script src="../javascript/jquery.js" ></script>
	<script src="../javascript/jquery-ui.js" ></script>
	
	<script>
	
		$(function() {
			$(".friend_list_entry").on("click", function() {
				var detail_id = $(this).attr("id");
				$.ajax({
					url: "/friends/friends_control/get_detail/" + detail_id,
					success: function(data)
					{
						$("#friend_detail").html(data);
						$("#friends_slide_list").animate({left : "-320px"}, 500);
  					}
				});
			});
		});
		
	</script>
</head>
<body>
	<div id="friends">
		<ul id="friends_slide_list">
			<!-- FRIENDS MAIN -->
			<li>
				<div id="friends_main">
					<?php echo $friends_main; ?>
				</div>
			</li>
			<!-- FRIEND DETAIL -->
			<li>
				<div id="friend_detail">
					
				</div>
			</li>
			<!-- ADD TO GROUP -->
			<li>
				<div id="add_to_group">
					ADD TO GROUP
				</div>
			</li>
		</ul>
	</div>
	</body>