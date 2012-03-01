<?php
/**
 * Controller für die Freundeseite.
 */
class Friends_control extends CI_Controller {

	var $userid;

	function __construct() {
		parent::__construct();
		parent::is_logged_in();
		$this->userid = $this->session->userdata('userid');
	}

	/**
	 * Leitet auf die Freunde-Seite weiter.
	 */
	function index()
	{
		$this->load->model('friends/friends_model');
		$current_user = $this->friends_model->get_user($this->userid);
		
		$this->layout->view("friends/friends_view");
	}
	
	/*
	 * Lädt Freunde-Model, holt Freunde aus der Datenbank und gibt die Seite formatiert zurück beim Aufruf der
	 * Freunde-Seite. 
	 */
	function get_friends() 
	{
		$this->load->model('friends/friends_model');
		$current_user = $this->friends_model->get_user($this->userid);
		
		//Hier werden die Freunde des aktuellen Users geholt
		$friends = $this->friends_model->get_friends($this->userid);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->friends_format_model->format_friend_main($current_user, $friends);
		
		echo $detail_string;
		
	}
	
	/*
	 * Beim Aufruf einer Detailseite eines Freundes werden die Detail-Daten des Freundes geholt und die
	 * Seite formatiert zurückgegeben.
	 */
	function get_detail($detail_id) 
	{
		$this->load->model('friends/friends_model');
		//Hier werden die id, name und picture des Freundes geholt
		$details = $this->friends_model->get_user($detail_id);
		//Hier werden die Gruppen des Freundes geholt
		$groups = $this->friends_model->get_groups_with_friend($this->userid, $detail_id);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->friends_format_model->format_friend_details($details, $groups);

		echo $detail_string;
	}
	
	/*
	 * Wird beim Hinzufügen von Freunden zu einer Gruppe aufgerufen um die vorhandenen Gruppen anzuzeigen (Freund-zu-Gruppe-Seite).
	 */
	function get_groups($friend_id) 
	{
		$this->load->model('friends/friends_model');
		$groups_with_friend = $this->friends_model->get_groups_with_friend($this->userid, $friend_id);
		$groups_without_friend = $this->friends_model->get_groups_without_friend($this->userid, $friend_id);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->friends_format_model->format_add_to_group($groups_with_friend, $groups_without_friend, $friend_id);
		
		echo $detail_string;
	}

	/*
	 * Wird aufgerufen wenn ein Freund einer Gruppe hinzugefügt wird (Freund-zu-Gruppe-Seite).
	 */
	function add_groups($friend_id, $group_id) 
	{
		$this->load->model('friends/friends_model');
		$this->friends_model->add_to_group($group_id, $friend_id);
	}
		 
		
	/*
	 * Wird aufgerufen wenn ein Benutzer eine seiner Gruppen löscht (Freund-zu-Gruppe-Seite).
	 */
	function del_groups($friend_id, $group_id) 
	{
		$this->load->model('friends/friends_model');
		$this->friends_model->delete_from_group($group_id, $friend_id);
	}
	
	/*
	 * Wird aufgerufen wenn ein Benutzer einen seiner Freunde aus seiner Freundesliste löscht (Freund-Details-Seite).
	 */
	function del_friend($friend_id) 
	{
		$this->load->model('friends/friends_model');
		$this->friends_model->delete_friend($friend_id, $this->userid);
	}
	
	/*
	 * Wird aufgerufen wenn ein Benutzer die Freund-Hinzufügen-Seite aufruft.
	 */
	function add_friends_main() 
	{
		$this->load->model('friends/friends_model');
		$users = $this->friends_model->get_all_users_without_friends($this->userid);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert
		$data["detail_string"] = $this->friends_format_model->format_add_friends($users);
		
		$this->layout->view('friends/addfriend_view', $data);
	}
	
	/*
	 * Wird aufgerufen wenn ein Benutzer einen Freund zu seiner Freundesliste hinzufügt (Freund-Hinzufügen-Seite).
	 */
	function add_friend($friend_id) 
	{
		$this->load->model('friends/friends_model');
		$this->friends_model->add_friend($friend_id, $this->userid);
		
		$users = $this->friends_model->get_all_users_without_friends($this->userid);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert und zurückgegeben bei Klick auf "Benutzer hinzufügen"
		echo $this->friends_format_model->format_add_friends($users);
	}
	
	/*
	 * Wird aufgerufen wenn ein Benutzer die Freund-Suchen-Seite aufruft.
	 */
	function search_friend($input) 
	{
		$this->load->model('friends/friends_model');
		$users = $this->friends_model->search_users_without_friends($this->userid, $input);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert und zurückgegeben bei Eingabe einer Buchstabenfolge
		echo $this->friends_format_model->format_add_friends($users);
	}
}
?>