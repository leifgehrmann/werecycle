<?php
class Pages extends CI_Controller {

	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('map_model');
	}

	public function view($page = 'home')
	{				
		if ( ! file_exists('app/views/pages/'.$page.'.php'))
		{
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		$data['title'] = "RecycleFinder: ".ucfirst($page); // Capitalize the first letter
		$data['page'] = $page;
		
		if($page == 'select') {
			if ($this->uri->segment(2) !== FALSE) {
				$sessiondata['home_latitude'] = $this->uri->segment(2, 0);
				$sessiondata['home_longitude'] = $this->uri->segment(3, 0);
				$sessiondata['user_state'] = 2;
				$this->session->set_userdata($sessiondata);
			}
			$data['categories'] = $this->map_model->get_categories();
		}
		
		if($page == 'map') {
			$segarray = $this->uri->segment_array();
			unset($segarray[1]);
			$sessiondata = array('types_selected' => $segarray);
			$this->session->set_userdata($sessiondata);
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);

	}
	
	public function data()
	{
		$userdata = $this->session->all_userdata();
		$types  = implode($userdata['types_selected'],',');
		$latitude = $userdata['latitude'];
		$longitude = $userdata['longitude'];
		$distance = $userdata['distance'];
		$data['outlets'] = $this->map_model->get_outlets($types,$latitude,$longitude,$distance);
		$this->load->view('pages/data', $data);
	}
	
	public function print_session() 
	{
		$data['outlets'] = print_r($this->session->all_userdata(),1);
		$this->load->view('pages/data', $data);
	}
	
	public function get_session() 
	{
		$data['outlets'] = json_encode($this->session->all_userdata());
		$this->load->view('pages/data', $data);
	}
	
	public function set_session() 
	{
		if ($this->uri->segment(2) !== FALSE) {
			$data['urlseg2'] = urldecode($this->uri->segment(2));
			$session_data = json_decode(urldecode($this->uri->segment(2)),1);
			$data['jsondecoded'] = $session_data;
			$this->session->set_userdata($session_data);
			$this->load->view('pages/data', $data);
		}
	}
}

?>