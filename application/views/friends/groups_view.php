<script>
	
		$(function() {
			var windowwidth = $('#groups').width();
			$('#groups_slide_list>li').css('width', windowwidth);
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
