<?php

class Friends_format_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
	
	/**
	 * 
	 * 
	 * <- 
	 * -> 
	 */
    function format_friend_main($current_user, $friends) 
    {
    	$friends_list = "";
		
    	if(!is_null($friends)) {
			foreach($friends as $item) {
				$friends_list = $friends_list."<li class='friend_list_entry' id='".$item->id."'>
				<img src='".$item->picture."'/>
				".$item->name."
				".anchor('/mail/'.$item->id, 'Text', array( 'class' => 'button', 'style' => 'float: right;'))."
				</li>";
			}
		}
		
		$string_script = " <script>
						$('.friend_list_entry').on('click', function() {
							var detail_id = $(this).attr('id');
							var windowwidth = $('#friends').width();
							var offset = -1*windowwidth;
							$.ajax({
								url: '/friends/friends_control/get_detail/' + detail_id,
								success: function(data)
								{
									$('#friends_slide_list').animate({left : offset+'px'}, 1000);
									$('#friend_detail').html(data);
									$('#friends').animate({ scrollTop: 0 }, 0)
  								}
							});
						});
						</script>";
		
    	$string = 	"<div id='friends_current_user'>
    					<img class='big_user_image' src='".$current_user->picture."' />"
    					.$current_user->name."
    				 </div>
    				 <div id='friends_add_button'>
    				 	".anchor('/friends/friends_control/add_friends_main', '+', 'style="text-decoration: none;"')."
    				 </div>
    				 <ul id='friends_friend_list'>"
    				 	.$friends_list."
    				 </ul>
    				 <div id='friends_groups'>
    				 	".anchor('/friends/groups_control', 'Gruppen', 'class="button"')."
    				 </div>";
					
		return $string.$string_script;
    }
	
	/**
	 * 
	 * 
	 * <- 
	 * -> 
	 */
    function format_friend_details($details, $groups) 
    {
    	$gruppen = "";
		if($groups != null) 
		{
			foreach($groups as $item) {
				$gruppen = $gruppen." <a class='group_links' href=''>".$item->name."</a>";
			}
		}
		
		$script_string = "	<script>
								$('#back_button').on('click', function(){
									$('#friends_slide_list').animate({left : '0px'}, 1000);
									$('#friends').animate({ scrollTop: 0 }, 0)
								});
								$('#add_to_button').on('click', function() {
									var detail_id = '".$details->id."';
									var windowwidth = $('#friends').width();
									var offset = -2*windowwidth;
									$.ajax({
										url: '/friends/friends_control/get_groups/' + detail_id,
										success: function(data)
										{
												$('#add_to_group').html(data);
												$('#friends_slide_list').animate({left : offset+'px'}, 1000);
												$('#friends').animate({ scrollTop: 0 }, 0)
  										}
									});
								});
								
								$('#delete_user').on('click', function() {
									var detail_id = '".$details->id."';
									$.ajax({
										url: '/friends/friends_control/del_friend/' + detail_id,
										success: function(data)
										{
												$.ajax({
													url: '/friends/friends_control/get_friends',
													success: function(data)
													{
															$('#friends_main').html(data);
															$('#friends_slide_list').animate({left : '0px'}, 1000);
															$('#friends').animate({ scrollTop: 0 }, 0)
			  										}
												});
										}
									});
								});
							</script>";
		
		$string = "	<div id='current_detail'>
						<div class='imgbox' id='detail_image'>
							<img class='big_user_image' src='".$details->picture."' />
							".$details->name."
						</div>
					</div>
					<br/><br/>
					<span id='delete_user'>DELETE</span> ".anchor('/mail/'.$details->id, 'Text', array( 'class' => 'button', 'style' => ''))."
					<hr />
					<span>Groups:</span><br/>
					".$gruppen."
					<span id='add_to_button'>ADD GROUPS</span>
					<hr />
					<span id='back_button'>OK</span>";
		
		return $script_string.$string;
	}
	
		/**
	 * 
	 * 
	 * <- 
	 * -> 
	 */
    function format_add_to_group($groups_with_friend, $groups_without_friend, $friend_id) 
    {
    	$groups_with = "";
		if($groups_with_friend != null) 
		{
			foreach($groups_with_friend as $item) {
				$groups_with = $groups_with." <span class='group_with_links del_group' id='".$item->id."' href=''>".$item->name."</span>";	
			}
		}
		
		$groups_without = "";
		if($groups_without_friend != null) 
		{
			foreach($groups_without_friend as $item) {
				$groups_without = $groups_without." <span class='group_without_links add_group' id='".$item->id."'>".$item->name."</span>";	
			}
		}
		
		$script_string = "	<script>
								$('#to_details_button').on('click', function() {
									var detail_id = '".$friend_id."';
									var windowwidth = $('#friends').width();
									var offset = -1*windowwidth;
									$.ajax({
										url: '/friends/friends_control/get_detail/' + detail_id,
										success: function(data)
										{
											$('#friends_slide_list').animate({left : offset+'px'}, 1000);
											$('#friend_detail').html(data);
											$('#friends').animate({ scrollTop: 0 }, 0)
  										}
								});
								});
								
								$('.add_group').on('click', function() {
									var group_id = $(this).attr('id');
									$.ajax({
										url: '/friends/friends_control/add_groups/".$friend_id."/' + group_id,
										success: function(data)
										{
												$.ajax({
													url: '/friends/friends_control/get_groups/".$friend_id."',
													success: function(data)
													{
														$('#add_to_group').html(data);
  													}
  												})
										}
									});
								});
								
								$('.del_group').on('click', function() {
									var group_id = $(this).attr('id');
									$.ajax({
										url: '/friends/friends_control/del_groups/".$friend_id."/' + group_id,
										success: function(data)
										{
												$.ajax({
													url: '/friends/friends_control/get_groups/".$friend_id."',
													success: function(data)
													{
														$('#add_to_group').html(data);
  													}
  												})
										}
									});
								});
							</script>";
		
		$string = "	<h2>Add to group</h2><br/><br/>
					".$groups_without."
					<hr />
					<span>Groups:</span><br/>
					".$groups_with."
					<hr />
					<span id='to_details_button'>OK</span>";
		
		return $script_string.$string;
    }
	
	/**
	 * 
	 * 
	 * <- 
	 * -> 
	 */
    function format_add_friends($users) 
    {
    	$users_list = "";
		
    	if(!is_null($users)) {
			foreach($users as $item) {
				$users_list = $users_list."<li class='users_list_entry' id='".$item->id."'><img src='".$item->picture."'/>".$item->name."</li>";
			}
		}
		
		$string_script = " <script>
							$('.users_list_entry').on('click', function() {
								var detail_id = $(this).attr('id');
								console.log(detail_id);
								$.ajax({
									url: '/friends/friends_control/add_friend/' + detail_id,
									success: function(data)
									{
										$('#add_info').html('Freund hinzugefügt').hide();
										$('#add_info').fadeIn('slow', function() {
											$('#add_friend').html(data);											
										});
	  								}
								});
							});
							</script>";
		
		
    	$string = 	"<div id='add_info'></div>
    	<ul id='users_list'>"
    				 	.$users_list."
    				 </ul>";
					
		return $string.$string_script;
    }
	
	
}