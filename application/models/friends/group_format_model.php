<?php

class Group_format_model extends CI_Model
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
    function format_group_main($groups) 
    {
    	$format_groups = "";
		if($groups != null) 
		{
			foreach($groups as $item) {
				$format_groups = $format_groups." <li class='list_li'><span class='groups' id='".$item->id."'>".$item->name."</span><span class='delete_group' id='".$item->id."'>löschen</span></li>";	
			}
		}
		
		$script_string = "	<script>
								$('.groups').on('click', function() {
									var detail_id = $(this).attr('id');
									var windowwidth = $('#groups').width();
									var offset = -1*windowwidth;
									$.ajax({
										url: '/friends/groups_control/get_group_members/' + detail_id,
										success: function(data)
										{
											$('#groups_slide_list').animate({left : offset+'px'}, 1000);
											$('#group_members').html(data);
											$('#groups').animate({ scrollTop: 0 }, 0);
  										}
									});
								});
								
								$('#add_group').on('click', function() {
									var new_group_name = $('#group_name').val();
									console.log(new_group_name);
									$.ajax({
										url: '/friends/groups_control/add_group/' + new_group_name,
										success: function(data)
										{
											$('#groups_main').html(data);
										}
									});
								});
								
								$('.delete_group').on('click', function() {
									var group_id = $(this).attr('id');
									$.ajax({
										url: '/friends/groups_control/delete_group/' + group_id,
										success: function(data)
										{
											$('#groups_main').html(data);
										}
									});
								});
							</script>";
		
		$string = "<span>Groups:</span>
					<br/><br/>
					<ul id='groups_list'>
					".$format_groups."
					</ul>
					<br/>
					<hr/>
					<span>NEW GROUP:</span><br/>
					<form>
						<input type='text' id='group_name' />
						<input type='button' value='OK' id='add_group' class='button'/>
					</form>
					<br/>
					<br/>
					<a href='/friends/friends_control' class='button'>BACK TO FRIENDS</a>";
		
		return $script_string.$string;
    }
	
	
	/**
	 * 
	 * 
	 * <- 
	 * -> 
	 */
    function format_group_members($members) 
    {
    	$format_members = "";
		if($members != null) 
		{
			foreach($members as $item) {
				$format_members = $format_members." <li class='group_members'>".$item->name."</li>";	
			}
		}
		
		$script_string = "<script>
								$('#back_to_groups').on('click', function() {
									$.ajax({
										url: '/friends/groups_control/get_groups/',
										success: function(data)
										{
											$('#groups_slide_list').animate({left: '0px'}, 1000);
											$('#groups_main').html(data);
											$('#groups').animate({ scrollTop: 0 }, 0);
  										}
									});
								});
							</script>";
		
		$string = "<span id='new_group'>+</span>
					<span>Members:</span>
					<br/><br/>
					<ul id='members_list' class='list'>
					".$format_members."
					</ul>
					<br/>
					<span id='back_to_groups' class='button'>OK</span>";
		
		return $script_string.$string;
    }
}