<script>
	
		$(function() {
			var windowwidth = $('#window').width();
			$('#pages>li').css('width', windowwidth);
			var ulwidth = 4*windowwidth;
			$('#pages').css('width', ulwidth);
			$.ajax({
					url: "/friends/friends_control/get_friends/",
					success: function(data)
					{
						$("#friends_main").html(data);
  					}
				});
		});
		
</script>


<div id="window">
		<ul id="pages">
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
					
				</div>
			</li>
		</ul>
</div>
