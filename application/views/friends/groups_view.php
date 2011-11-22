<head>
	<link rel="stylesheet" type="text/css" href="../css/friends_view_style.css">
	
	<script src="../javascript/jquery.js" ></script>
	<script src="../javascript/jquery-ui.js" ></script>
	
	<script>
	
		$(function() {
			$( "#sortable" ).sortable();
			$( "#sortable" ).disableSelection();
		});
		
	</script>
</head>
<body>
	<div id="groups">
		<ul id="list_groups">
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