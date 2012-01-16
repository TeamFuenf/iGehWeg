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
		$count = 0;
		
		if($groups != null) 
		{
			foreach($groups as $item) {
				if($count % 2 == 0) {
					$color_class = "green";
				} else {
					$color_class = "blue";
				}
				$format_groups = $format_groups." <li class='list_li button_long ".$color_class."'><span class='groups' id='".$item->id."'>".$item->name." > </span><span class='delete_group' id='".$item->id."'>löschen</span></li>";
				$count++;
			}
		}
		
		$script_string = "	<script>
								$('#new_group_field').hide();
								$('#friends_add_button').on('click', function() {
									if($('#friends_add_button>span').html() == '+') {
										$('#new_group_field').show();
										$('#friends_add_button>span').html('-');	
									} else {
										$('#new_group_field').hide();
										$('#friends_add_button>span').html('+');
									}
									
								});
								
								$('.groups').on('click', function() {
									var detail_id = $(this).attr('id');
									var windowwidth = $('#window').width();
									var offset = -1*windowwidth;
									$.ajax({
										url: '/friends/groups_control/get_group_members/' + detail_id,
										success: function(data)
										{
											$('#pages').animate({left : offset+'px'}, 1000);
											$('#group_members').html(data);
											$('#window').animate({ scrollTop: 0 }, 0);
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
		
		$string = "<div class='button_side'>
    				<div id='friends_add_button'>
    				 	<span href='' class='button_normal'>+</span>
    				 </div>
					<h1>Gruppen:</h1>
					<br/>
					<div id='new_group_field'>
					<span>Neue Gruppe:</span><br/>
					<form>
						<input type='text' id='group_name' />
						<input type='button' value='OK' id='add_group' class='button_normal'/>
					</form>
					</div>
					</div>
					<br/>
					<div class='contentbox contentbox_friends'>
    				 <ul>
					".$format_groups."
					</ul>
					</div>";
		
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
											$('#pages').animate({left: '0px'}, 1000);
											$('#groups_main').html(data);
											$('#window').animate({ scrollTop: 0 }, 0);
  										}
									});
								});
							</script>";
		
		$string = "<h1 class='button_side'>Mitglieder:</h1>
					<br/><br/>
					<ul id='members_list' class='list'>
					".$format_members."
					</ul>
					<br/>
					<span id='back_to_groups' class='button_normal button_side'>zurück</span>";
		
		return $script_string.$string;
    }
}