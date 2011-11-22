<?php

class Entry_control extends CI_Controller {

	function index()
	{
		$this->load->model("entry_model");
		
		$geraet = $this->input->post("geraet");
		$name = $this->input->post("name");
		$von = $this->input->post("von");
		$bis = $this->input->post("bis");
		
		if($geraet != null && $name != null && $von != null && $bis != null) 
		{
			$this->entry_model->set_device($geraet, $name, $von, $bis);	
		}
		
		$this->load_page();
	}
	
	public function reset_entry($geraet) 
	{
		$this->load->model("entry_model");
		$this->entry_model->reset_entry($geraet);
		
		$this->load_page();
	}
	
	public function studio($geraet) 
	{
		$this->load->model("entry_model");
		$this->entry_model->set_device($geraet, "Studio", "", "");
		
		$this->load_page();
	}
	
	public function load_page() 
	{
		$data["entries"] = $this->entry_model->get_entries();
		$data["latest"] = $this->entry_model->get_latest();
		$this->load->view('main_view', $data);
	}
}