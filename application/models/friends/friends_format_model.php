<?php

class Friends_format_model extends CI_Model
{

	/*
	 * Da die Seiten dynamisch erstellt werden muss hier die JS-Funktion für
	 * den Ajax-Aufruf von Links seperat hinzugefügt werden.
	 */  
	var $ajax_link = "$('a.ajaxlinks').on('click', function(event){
						event.preventDefault();
						var url = $(this).attr('href');
						console.log(url);
						$.ajax({
						url: url,
						success: function(data) {
						$('body').html(data);
						}
						})
					 });";

    function __construct()
    {
        parent::__construct();
    }
	
	/**
	 * Formatiert die erste Seite der "Freunde-Anzeigen-Seite" inkl. html und js.
	 * Gibt eine Liste der Freunde eines Users zurück. 
	 */
    function format_friend_main($current_user, $friends) 
    {
    	//Formatierung aller Freunde als Liste.
    	$friends_list = "";
		$count = 0;
		
    	if(!is_null($friends)) {
			foreach($friends as $item) {
				if($count % 2 == 0) {
					$color_class = "green";
				} else {
					$color_class = "blue";
				}
				$friends_list = $friends_list."<li class='button_long ".$color_class."' >
				<span class='friend_list_entry list_entry' id='".$item->id."'>
				<img src='".$item->picture."'/>
				".$item->name." 
				<span class='arrow'>></span>
				</span>
				".anchor('/mail/'.$item->id, '<img src="../../images/message_'.$color_class.'.png" />', array( 'class' => 'button_small '.$color_class))."
				</li>";
				$count++;
			}
		}
		
		//JS-Skriptcode der Seite
		$string_script = " <script>
						$('.friend_list_entry').on('click', function() {
							var detail_id = $(this).attr('id');
							var windowwidth = $('#window').width();
							var offset = -1*windowwidth;
							console.log(offset);
							$.ajax({
								url: '/friends/friends_control/get_detail/' + detail_id,
								success: function(data)
								{
									console.log('geht schon');
									$('#pages').animate({left : offset+'px'}, 1000);
									$('#friend_detail').html(data);
									$('#window').animate({ scrollTop: 0 }, 0)
  								}
							});
						});
						".$this->ajax_link."						
						</script>";

		//HTML-Code der Seite.
    	$string = 	"<div class='button_side'>
    				<h1>Freunde:</h1>
    				<div id='friends_add_button'>
    				 	<a href='/friends/friends_control/add_friends_main' class='button_normal ajaxlinks'>+</a>
    				 </div>
    				 <div id='friends_groups_button'>
    				 	".anchor('/friends/groups_control', 'Gruppen', 'class="button_normal ajaxlinks"')."
    				 </div>
    				 </div>
    				 <br />
    				<div class='contentbox contentbox_friends'>
    				 <ul>"
    				 	.$friends_list."
    				 </ul></div>";
					
		//Rückgabestring mit HTML- und JS-Code.
		return $string.$string_script;
    }
	
	/**
	 * Formatiert die Detail-Seite eines Freundes inkl. html und js.
	 */
    function format_friend_details($details, $groups) 
    {
    	//Formatierung aller Gruppen als Links.
    	$gruppen = "";
		if($groups != null) 
		{
			foreach($groups as $item) {
				$gruppen = $gruppen." <a class='group_links button_normal red ajaxlinks' href=''>".$item->name."</a>";
			}
		}
		
		//JS-Skriptcode der Seite
		$script_string = "	<script>
								$('#back_button').on('click', function(){
									$('#pages').animate({left : '0px'}, 1000);
									$('#window').animate({ scrollTop: 0 }, 0)
								});
								$('#add_to_button').on('click', function() {
									var detail_id = '".$details->id."';
									var windowwidth = $('#window').width();
									var offset = -2*windowwidth;
									$.ajax({
										url: '/friends/friends_control/get_groups/' + detail_id,
										success: function(data)
										{
												$('#add_to_group').html(data);
												$('#pages').animate({left : offset+'px'}, 1000);
												$('#window').animate({ scrollTop: 0 }, 0)
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
															$('#pages').animate({left : '0px'}, 1000);
															$('#window').animate({ scrollTop: 0 }, 0)
			  										}
												});
										}
									});
								});
								".$this->ajax_link."
							</script>";
		
		//HTML-Code der Seite.
		$string = "	<div id='friend_details'>
						<div id='friend_detail_image'>
							<img class='big_user_image' src='".$details->picture."' />
							".$details->name."
						</div>
					</div>
					<hr />
					<div class='button_side'>
					<span id='delete_user' class='button_normal'>Löschen</span> ".anchor('/mail/'.$details->id, '<img src="../../images/message.png" />', array( 'class' => 'button_normal', 'style' => ''))."
					</div>
					<hr />
					<div class='button_side'>
					<span>Gruppen:</span><br/>
					".$gruppen."
					<span id='add_to_button' class='button_normal'>+</span>
					</div>
					<hr />
					<div class='button_side'>
					<span id='back_button' class='button_normal'>zurück</span></div>";
		
		//Rückgabestring mit HTML- und JS-Code.
		return $script_string.$string;
	}
	
	/**
	 * Formatiert die Seite zum Zuordnen der Freunde zu einer Gruppe hinzufügen inkl. hmtl und js.  
	 * 
	 */
    function format_add_to_group($groups_with_friend, $groups_without_friend, $friend_id) 
    {
    	// Formatierung aller Gruppen mit bestimmtem Freund als Links.
    	$groups_with = "";
		if($groups_with_friend != null) 
		{
			foreach($groups_with_friend as $item) {
				$groups_with = $groups_with." <span class='button_normal red del_group' id='".$item->id."' href=''>".$item->name."</span>";	
			}
		}
		// Formatierung aller Gruppen ohne bestimmtem Freund als Links.
		$groups_without = "";
		if($groups_without_friend != null) 
		{
			foreach($groups_without_friend as $item) {
				$groups_without = $groups_without." <span class='button_normal blue add_group' id='".$item->id."'>".$item->name."</span>";	
			}
		}
		
		//JS-Skriptcode der Seite.
		$script_string = "	<script>
								$('#to_details_button').on('click', function() {
									var detail_id = '".$friend_id."';
									var windowwidth = $('#window').width();
									var offset = -1*windowwidth;
									$.ajax({
										url: '/friends/friends_control/get_detail/' + detail_id,
										success: function(data)
										{
											$('#pages').animate({left : offset+'px'}, 1000);
											$('#friend_detail').html(data);
											$('#window').animate({ scrollTop: 0 }, 0)
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
								".$this->ajax_link."
							</script>";
							
		//HTML-Code der Seite.
		$string = "	<h1 class='button_side'>Gruppen hinzufügen:</h1>
					<span class='group_list button_side'>Gruppen ohne Benutzer:</span><br/>
					<div class='button_side'>".$groups_without."</div>
					<hr />
					<span class='group_list button_side'>Gruppen mit Benutzer:</span><br/>
					<div class='button_side'>".$groups_with."</div>
					<hr />
					<div class='button_side'>
					<span id='to_details_button' class='button_normal'>zurück</span>
					</div>";
		
		//Rückgabestring mit HTML- und JS-Code.
		return $script_string.$string;
    }
	
	/**
	 * Formatiert die Seite zum Hinzufügen von Freunden inkl. hmtl und js
	 * 
	 */
    function format_add_friends($users) 
    {
    	// Formatierung der noch nicht als Freunde hinzugefügten Benutzer als Liste.
    	$users_list = "";
    	$color_class = "";
		$count = 0;
    	if(!is_null($users)) {
			foreach($users as $item) {
				if($count % 2 == 0) {
					$color_class = "green";
				} else {
					$color_class = "blue";
				}
				
				$users_list = $users_list."<li class='users_list_entry button_long ".$color_class."' id='".$item->id."'>
				<span class='friend_list_entry list_entry'>
				<img src='".$item->picture."'/>
				".$item->name." 
				</span>
				</li>";
				$count++;
			}
		}
		
		//JS-Skriptcode der Seite.
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
							".$this->ajax_link."
							</script>";
		
		//HTML-Code der Seite.
    	$string = 	"<div id='add_info'></div>
    				 <div class='contentbox contentbox_friends'>
    				 <ul>"
    				 	.$users_list."
    				 </ul>
    				 </div>";
					
		//Rückgabestring mit HTML- und JS-Code.
		return $string.$string_script;
    }
	
	
}