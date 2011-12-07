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
				$friends_list = $friends_list."<li class='friend_list_entry' id='".$item->id."'><img src='".$item->picture."'/>".$item->name."</li>";
			}
		}
		
    	$string = 	"<div id='friends_current_user'>
						<img class='big_user_image' src='".$current_user->picture."' />
						".$current_user->name." 
					</div>
					<div id='friends_add_button'>
						<a href=''>+</a>
					</div>
					<ul id='friends_friend_list'>"
					.$friends_list.			
					"</ul>
					<div id='friends_groups'>
						<a href=''>groups</a>
					</div>";
					
		return $string;
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
									$('#friends_slide_list').animate({left : '0px'}, 500);
								});
								$('#add_to_button').on('click', function() {
									var detail_id = ".$details->id."
									$.ajax({
										url: '/friends/friends_control/get_groups/' + detail_id,
										success: function(data)
										{
												$('#add_to_group').html(data);
												$('#friends_slide_list').animate({left : '-640px'}, 500);
  										}
									});
								});
								
								$('#delete_user').on('click', function() {
									var detail_id = ".$details->id."
									$.ajax({
										url: '/friends/friends_control/get_friends_main',
										success: function(data)
										{
												$.ajax({
													url: '/friends/friends_control/get_friends_main',
													success: function(data)
													{
															$('#friends_main').html(data);
															$('#friends_slide_list').animate({left : '0px'}, 500);
			  										}
												});
										}
									});
								});
							</script>";
		
		$string = "	<div id='current_detail'>
						<div class='imgbox' id='detail_image'>
							<img class='big_user_image' src='".$details->picture."' />
						</div>"
						.$details->name."
					</div>
					<br/><br/>
					<span id='delete_user'>DELETE</span>
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
				$groups_with = $groups_with." <span class='group_links del_group' id='".$item->id."' href=''>".$item->name."</span>";	
			}
		}
		
		$groups_without = "";
		if($groups_without_friend != null) 
		{
			foreach($groups_without_friend as $item) {
				$groups_without = $groups_without." <span class='group_links add_group' id='".$item->id."'>".$item->name."</span>";	
			}
		}
		
		$script_string = "	<script>
								$('#to_details_button').on('click', function() {
									var detail_id = ".$friend_id."
									$.ajax({
										url: '/friends/friends_control/get_detail/' + detail_id,
										success: function(data)
										{
											$('#friends_slide_list').animate({left : '-320px'}, 500);
											$('#friend_detail').html(data);
  										}
								});
								});
								
								$('.add_group').on('click', function() {
									var group_id = $(this).attr('id');
									$.ajax({
										url: '/friends/friends_control/add_groups/' + ".$friend_id." + '/' + group_id,
										success: function(data)
										{
												$.ajax({
													url: '/friends/friends_control/get_groups/' + ".$friend_id.",
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
										url: '/friends/friends_control/del_groups/' + ".$friend_id." + '/' + group_id,
										success: function(data)
										{
												$.ajax({
													url: '/friends/friends_control/get_groups/' + ".$friend_id.",
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
	
}