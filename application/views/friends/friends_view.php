<script>
	
		$(function() {
			var windowwidth = $('#friends').width();
			$('#friends_slide_list>li').css('width', windowwidth);
			var ulwidth = 4*windowwidth;
			$('#friends_slide_list').css('width', ulwidth);
			$.ajax({
					url: "/friends/friends_control/get_friends/",
					success: function(data)
					{
						$("#friends_main").html(data);
  					}
				});
		});
		
</script>

<div id="friends">
		<ul id="friends_slide_list">
			<!-- FRIENDS MAIN -->
			<li>
				<div id="friends_main">
					
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
