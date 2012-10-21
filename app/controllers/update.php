<?php
class Update extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index($source)
	{		
		print `echo /usr/bin/php -q /home/recycle/public_html/app/libraries/$source.php | at now`;
		
		$data['title'] = 'Update ('.$source.')';
		$data['page'] = 'update';
		$data['outputPath'] = '/home/recycle/public_html/tmp/$source.html';
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/update', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function getLog($source)
	{		
		echo file_get_contents("/home/recycle/public_html/tmp/recycleForScotland.html");
	}
	
}
?>
