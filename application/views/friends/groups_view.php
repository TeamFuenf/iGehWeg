<head>
	<link rel="stylesheet" type="text/css" href="../css/groups_view_style.css">
	
	<script src="../javascript/jquery.js" ></script>
	<script src="../javascript/jquery-ui.js" ></script>
	
	<script>
	
		$(function() {
			var windowwidth = $('#groups').width();
			$('li').css('width', windowwidth);
			var ulwidth = 4*windowwidth;
			$('#groups_slide_list').css('width', ulwidth);
			$.ajax({
					url: "/friends/groups_control/get_groups/",
					success: function(data)
					{
						$("#groups_main").html(data);
  					}
				});
		});
		
	</script>
</head>
<body>
	<div id="groups">
		<ul id="groups_slide_list">
			<!-- GROUPS MAIN -->
			<li>
				<div id="groups_main">
					
				</div>
			</li>
			<!-- GROUP MEMBERS -->
			<li>
				<div id="group_members">
					
				</div>
			</li>
			<!-- ADD MEMBER TO GROUP -->
			<li>
				<div id="add_member_to_group">
					
				</div>
			</li>
		</ul>
	</div>
</body>