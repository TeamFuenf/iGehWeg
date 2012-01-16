<script>
	
		$(function() {
			var windowwidth = $('#window').width();
			$('#pages>li').css('width', windowwidth);
			var ulwidth = 4*windowwidth;
			$('#pages').css('width', ulwidth);
			$.ajax({
					url: "/friends/groups_control/get_groups/",
					success: function(data)
					{
						$("#groups_main").html(data);
  					}
				});
		});
		
</script>
<div id="window">
		<ul id="pages">
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
