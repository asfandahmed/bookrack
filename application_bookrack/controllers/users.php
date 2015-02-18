<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user');
		$this->load->helper(array('url','form'));
		$this->load->library(array('common_functions','session','form_validation'));
	}
	public function index($id="")
	{
		if(!$this->common_functions->is_logged_in())
			redirect(site_url());
		
		if(intval($id)>0)
		{
			$is_profile_owner=$this->has_current_profile($id);
			$this->load_user_profile($id,$is_profile_owner);
		}else
			$this->load_user_profile($this->session->userdata['user_id'],TRUE);
	}
	public function edit()
	{
		if(!$this->common_functions->is_logged_in())
			redirect(site_url());

		$data['title'] = "Edit profile";
		$id=$this->session->userdata['user_id'];
		$data['user_info']=$this->user->get_basic_info($id);
		$data['user']=$this->user->get($id);
		$data['owner']=TRUE;
		$this->load->view('templates/header.php',$data);
		$this->load->view('user/profile_upper_section.php',$data);
		$this->load->view('user/edit.php');
		$this->load->view('templates/footer.php');
	}
	public function follow($follower,$leader)
	{
		$data=array(
			'date_time'=>'val'
			);
		$this->user->add_user_relation($follower,$leader,"FOLLOWS");
	}
	public function unfollow($follower,$leader)
	{
		$this->user->remove_user_relation($id);
	}
	public function followers($id="")
	{
		if(!$this->common_functions->is_logged_in())
			redirect(site_url());
		
		if(intval($id)>0)
		{
			$is_profile_owner=$this->has_current_profile($id);
			$this->load_user_followers($id,$is_profile_owner);
		}else
			$this->load_user_followers($this->session->userdata['user_id'],TRUE);
	}
	public function following($id="")
	{
		if(!$this->common_functions->is_logged_in())
			redirect(site_url());
		
		if(intval($id)>0)
		{
			$is_profile_owner=$this->has_current_profile($id);
			$this->load_user_following($id,$is_profile_owner);
		}else
			$this->load_user_following($this->session->userdata['user_id'],TRUE);
	}
	public function shelf($id="")
	{
		if(!$this->common_functions->is_logged_in())
			redirect(site_url());
		
		if(intval($id)>0)
		{
			$is_profile_owner=$this->has_current_profile($id);
			$this->load_user_shelf($id,$is_profile_owner);
		}else
			$this->load_user_shelf($this->session->userdata['user_id'],TRUE);
	}
	public function wishlist($id="")
	{
		if(!$this->common_functions->is_logged_in())
			redirect(site_url());

		if(intval($id)>0)
		{
			$is_profile_owner=$this->has_current_profile($id);
			$this->load_user_wishlist($id,$is_profile_owner);
		}else
			$this->load_user_wishlist($this->session->userdata['user_id'],TRUE);
	}
	public function forgot()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[3]|max_length[60]|valid_email|xss_clean');

		if($this->form_validation->run() === FALSE)
		{
			$data['title']='Forgot Password - Bookrack';
			$this->load->view('templates/header.php',$data);
			$this->load->view('user/forgot.php');
			$this->load->view('templates/footer.php');
		}
		else
		{
			$user = $this->user->check_user_exists($email);
			$this->send_password();
		}
	}
	public function edit_information()
	{
		$id=$this->session->userdata['user_id'];
		$data['user']=$this->user->get($id);
		$this->load->view('user/edit_information.php',$data);
	}	
	public function edit_contact()
	{
		$id=$this->session->userdata['user_id'];
		$data['user']=$this->user->get($id);
		$this->load->view('user/edit_contact.php',$data);	
	}
	public function load_user_pic_uploader()
	{
		$this->load->view('dialogs/image_uploader.php');
	}
	private function load_user_profile($id,$owner)
	{
		$this->load->library('pagination');
		$data['title']='Profile - Bookrack';
		$data['user_info']=$this->user->get_basic_info($id);
		$data['user']=$this->user->get($id);
		$data['owner']=$owner;

		$count=$this->user->get_feed_count($id)->offsetGet(0);

		$config['base_url']=site_url('profile');
		$config['total_rows']=$count['total'];
		$config["per_page"]=2;
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(1)) ? $this->uri->segment(1) : 0;
		
		$data['posts']=$this->user->get_feed($id,$config["per_page"],$page);
		$data['links']=$this->pagination->create_links();

		$this->load->view('templates/header.php',$data);
		$this->load->view('user/profile_upper_section.php',$data);
		$this->load->view('user/index.php',$data);
		$this->load->view('templates/footer.php');
	}
	private function load_user_shelf($id,$owner)
	{
		$data['title']='Shelf - Bookrack';
		$data['user_info']=$this->user->get_basic_info($id);
		$data['user']=$this->user->get($id);
		$data['books']=$this->user->get_books($id,1);
		$data['owner']=$owner;

		$this->form_validation->set_rules('add_shelf', 'Shelf', 'trim|required|xss_clean');
		
		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header.php',$data);
			$this->load->view('user/profile_upper_section.php',$data);
			$this->load->view('user/shelf.php');
			$this->load->view('templates/footer.php');
		}
		else
		{
			$data=$this->user->add_to_shelf($id);
			echo json_encode($data);
		}
	}
	private function load_user_wishlist($id,$owner)
	{
		$data['title']='Wishlist - Bookrack';
		$data['user_info']=$this->user->get_basic_info($id);
		$data['user']=$this->user->get($id);
		$data['books']=$this->user->get_books($id,2);
		$data['owner']=$owner;

		$this->form_validation->set_rules('add_wishlist', 'Wishlist', 'trim|required|xss_clean');
		
		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header.php',$data);
			$this->load->view('user/profile_upper_section.php',$data);
			$this->load->view('user/wishlist.php');
			$this->load->view('templates/footer.php');	
		}
		else
		{
			$data=$this->user->add_to_wishlist($id);
			echo json_encode($data);
		}
	}
	private function load_user_followers($id,$owner)
	{
		$data['title']='Followers - Bookrack';
		$data['user_info']=$this->user->get_basic_info($id);
		$data['followers']=$this->user->get_followers($id);
		$data['user']=$this->user->get($id);
		$data['owner']=$owner;

		$this->load->view('templates/header.php',$data);
		$this->load->view('user/followers_following.php',$data);
		$this->load->view('templates/footer.php');
	}
	private function load_user_following($id,$owner)
	{
		$data['title']='Following - Bookrack';
		$data['user_info']=$this->user->get_basic_info($id);
		$data['followings']=$this->user->get_following($id);
		$data['user']=$this->user->get($id);
		$data['owner']=$owner;

		$this->load->view('templates/header.php',$data);
		$this->load->view('user/followers_following.php',$data);
		$this->load->view('templates/footer.php');
	}
	public function update_profile_picture()
	{
		$this->load->library(array('upload','image_lib'));
		$data=array();
		$error=array();
		$config['upload_path'] = './assets/uploads/profile_images';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '5000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['remove_spaces'] = TRUE;
		$this->upload->initialize($config);
		
		if ( ! $this->upload->do_upload())
			$error = array('error' => $this->upload->display_errors());
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$error = $this->resize_image($data['upload_data']['full_path']);
			$id=$this->session->userdata['user_id'];
			$this->user->update_user_properties($id,array('profile_image'=>$data['upload_data']['file_name']));
		}
		echo json_encode($error);
	}
	private function resize_image($path)
	{	
		$config=array();
		$config['image_library'] = 'gd';
		$config['source_image'] = $path;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 50;
		$config['height'] = 43;
		$config['new_image']=str_replace('profile_images', 'thumbs', $path);

		$this->image_lib->initialize($config);
		$this->image_lib->clear();
		if ( ! $this->image_lib->resize())
		{
		    return $data = array('error'=>$this->image_lib->display_errors());
		}
	}
	private function send_password()
	{

	}
	private function has_current_profile($id)
	{
		$id=intval($id);
		$user_id=intval($this->session->userdata['user_id']);
		if($user_id===$id)
			return TRUE;
		return FALSE;
	}
}
