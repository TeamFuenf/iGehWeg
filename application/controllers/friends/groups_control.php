<?php
class Groups_control extends CI_Controller {

	function index()
	{
		$current_user = "123";
		
		$this->load->model('friends/friends_model');
		$current_user = $this->friends_model->get_user($current_user);
		
		$this->session->set_userdata('current_user', $current_user);
				
		$this->layout->view("friends/groups_view");
	}
	
	function get_groups() {
		$current_user = $this->session->userdata('current_user');
		
		$this->load->model('friends/friends_model');
		//Daten werden geladen (Alle Gruppen des Users)
		$groups = $this->friends_model->get_groups($current_user->id);
		
		$this->load->model('friends/group_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->group_format_model->format_group_main($groups);
		
		echo $detail_string;
	}
	
	function add_group($new_group_name) {
		$current_user = $this->session->userdata('current_user');
		
		$this->load->model('friends/friends_model');
		//Neue Gruppe wird generiert
		$this->friends_model->create_group($new_group_name, $current_user->id);
		//Daten werden geladen (Alle Gruppen des Users)
		$groups = $this->friends_model->get_groups($current_user->id);
		
		$this->load->model('friends/group_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->group_format_model->format_group_main($groups);
		
		echo $detail_string;
	}
	
	function delete_group($group_id) {
		$current_user = $this->session->userdata('current_user');
		
		$this->load->model('friends/friends_model');
		//Neue Gruppe wird generiert
		$this->friends_model->delete_group($group_id);
		//Daten werden geladen (Alle Gruppen des Users)
		$groups = $this->friends_model->get_groups($current_user->id);
		
		$this->load->model('friends/group_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->group_format_model->format_group_main($groups);
		
		echo $detail_string;
	}
	
	function get_group_members($group_id) {
		$this->load->model('friends/friends_model');
		//Daten werden geladen (Alle Mitglieder einer Gruppe)
		$group_members = $this->friends_model->get_group_members($group_id);
		
		$this->load->model('friends/group_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->group_format_model->format_group_members($group_members);
		
		echo $detail_string;
	}
}