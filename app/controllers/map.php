<?php
class Map extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('map_model');
	}

	public function index()
	{
		$data['recycle_types'] = $this->map_model->get_recycle_types();
		$data['title'] = 'Map!';

		$this->load->view('templates/header', $data);
		$this->load->view('map/index', $data);
		$this->load->view('templates/footer');
	}

	public function view($slug)
	{
		$data['slug'] = $slug;
		$this->load->view('map/slug', $data);
	}
}
?>