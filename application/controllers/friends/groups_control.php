<?php
/**
 * Controller für die Gruppenseite.
 */
class Groups_control extends CI_Controller {

	var $userid;

	function __construct() {
		parent::__construct();
		parent::is_logged_in();
		$this->userid = $this->session->userdata('userid');
	}

    /**
	 * Leitet auf die Gruppen-Seite weiter.
	 */
	function index()
	{
		$this->load->model('friends/friends_model');
		$current_user = $this->friends_model->get_user($this->userid);
		
		$this->layout->view("friends/groups_view");
	}
	
	/**
	 * Holt alle Gruppen eines Benutzers, formatiert die Seite und gibt sie zurück.
	 */
	function get_groups() {
		$this->load->model('friends/friends_model');
		//Daten werden geladen (Alle Gruppen des Users)
		$groups = $this->friends_model->get_groups($this->userid);
		
		$this->load->model('friends/group_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->group_format_model->format_group_main($groups);
		
		echo $detail_string;
	}
	
	/*
	 * Wird aufgerufen wenn neue Gruppe erstellt wird.
	 */
	function add_group($new_group_name) {
		$this->load->model('friends/friends_model');
		//Neue Gruppe wird generiert
		$this->friends_model->create_group($new_group_name, $this->userid);
		//Daten werden geladen (Alle Gruppen des Users)
		$groups = $this->friends_model->get_groups($this->userid);
		
		$this->load->model('friends/group_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->group_format_model->format_group_main($groups);
		
		echo $detail_string;
	}
	
	/**
	 * Wird aufgerufen wenn eine Gruppe gelöscht wird.
	 */
	function delete_group($group_id) {
		
		$this->load->model('friends/friends_model');
		//Neue Gruppe wird generiert
		$this->friends_model->delete_group($group_id);
		//Daten werden geladen (Alle Gruppen des Users)
		$groups = $this->friends_model->get_groups($this->userid);
		
		$this->load->model('friends/group_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->group_format_model->format_group_main($groups);
		
		echo $detail_string;
	}
	
	/**
	 * Holt alle Mitglieder einer Gruppe, foramtiert die Seite und gibt sie zurück.
	 */
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