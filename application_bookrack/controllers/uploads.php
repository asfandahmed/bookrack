<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Uploads extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('image_lib','upload'));
	}
	public function profile_image()
	{
		$config['upload_path'] = './assets/uploads/profile_images';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '5000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['remove_spaces'] = TRUE;
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload())
			$data = array('error' => $this->upload->display_errors());
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$path=$data['upload_data']['full_path'];
			$config=array();
			$config['image_library'] = 'gd2';
			$config['source_image'] = 
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 50;
			$config['height'] = 43;
			$config['new_image']=str_replace('profile_images', 'thumbs', $path);
			$this->image_lib->initialize($config);
			if ( ! $this->image_lib->resize())
			{
			    $data = array('error'=>$this->image_lib->display_errors());
			}
		}

		echo json_encode($data);
	}
	public function cover_image()
	{
		$config['upload_path'] = './assets/uploads/cover_images';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '5000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['remove_spaces'] = TRUE;
		$this->upload->initialize($config);

		if ( ! $this->upload->do_upload())
			$data = array('error' => $this->upload->display_errors());
		else
			$data = array('upload_data' => $this->upload->data());

		echo json_encode($data);
	}
}