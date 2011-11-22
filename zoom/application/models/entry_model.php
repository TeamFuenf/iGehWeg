<?php

class Entry_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function get_entries() {
		$query = $this->db->query("SELECT * FROM zoom WHERE NAME <> 'Studio' ORDER BY ID DESC");
		
		if($query->num_rows() > 0) 
		{
			foreach($query->result() as $item) 
			{
				$data[] = $item;
			}
			
			return $data;
		}
		
		
	}
	
	function get_latest() {
		$query = $this->db->query("SELECT * FROM zoom WHERE CURRENT = 1 ORDER BY GERAET ASC");
		
		if($query->num_rows() > 0) 
		{
			foreach($query->result() as $item) 
			{
				$data[] = $item;
			}
		}
		
		return $data;
	}
	
	function set_device($geraet, $name, $von, $bis) {
		
		$query = $this->db->query("SELECT * FROM zoom WHERE GERAET = '".$geraet."' AND CURRENT = 1");
		
		if($query->num_rows() > 0) 
		{
			foreach($query->result() as $id) {
				$old = $id->ID;
				$old_name = $id->NAME;
				$old_von = $id->VON;
				$old_bis = $id->BIS;
				$old_geraet = $id->GERAET;
			}
			
			if($old_name != $name || $old_von != $von || $old_bis != $bis || $old_geraet != $geraet) 
			{
				$this->db->query("UPDATE zoom SET CURRENT = 0 WHERE ID = '".$old."'");
			
				$this->db->query("INSERT INTO zoom (GERAET, NAME, VON, BIS, CURRENT) VALUES ('".$geraet."', '".$name."', '".$von."', '".$bis."', 1 )");
				
				$this->db->query("INSERT INTO zoom_backup (GERAET, NAME, VON, BIS, CURRENT) VALUES ('".$geraet."', '".$name."', '".$von."', '".$bis."', 1 )");
			}
		}
		
	}
	
	function reset_entry($geraet) {
		
		$query = $this->db->query("SELECT ID FROM zoom WHERE GERAET = '".$geraet."' AND CURRENT = 0 ORDER BY ID DESC LIMIT 0, 1");
		
		if($query->num_rows() > 0) 
		{
			foreach($query->result() as $id) 
			{
				$new = $id->ID;
			}
			
			$this->db->query("DELETE FROM zoom WHERE CURRENT = 1 AND GERAET = '".$geraet."'");
			
			$this->db->query("UPDATE zoom SET CURRENT = 1 WHERE ID = '".$new."'");
		}
	}
}