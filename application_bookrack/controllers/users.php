<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('user','status','notification'));
		$this->load->helper(array('url','form'));
		$this->load->library(array('common_functions','session','form_validation','pagination'));
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
		$data['page']='edit_information';
		$data['post_url']="profile/save";

		$this->load->view('templates/header.php',$data);
		$this->load->view('user/profile_upper_section.php',$data);
		$this->load->view('user/edit.php',$data);
		$this->load->view('templates/footer.php');
	}
	public function follow()
	{
		$this->load->model('notification');
		$userToBeFollowed=intval($this->input->post('usertobefollowed'));
		$id=intval($this->session->userdata['user_id']);
		//
		$response=$this->user->follow($id,$userToBeFollowed);
		// sending notification
		$email="";
		$n = new Notification();
		$n->notificationText="";
		$this->notification->setNotification($email,$n);
		echo json_encode($response);
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
			$data['title']='Forgot Password - '.APP_NAME;
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
	/*public function view_information()
	{
		$id=$this->session->userdata['user_id'];
		$data['user']=$this->user->get($id);
		$this->load->view('user/view_information.php',$data);
	}	
	public function view_contact()
	{
		$id=$this->session->userdata['user_id'];
		$data['user']=$this->user->get($id);
		$this->load->view('user/view_contact.php',$data);	
	}*/
	public function edit_information()
	{
		$data['title'] = "Edit profile";
		$data['post_url']="profile/save";
		$data['page']='edit_information';

		$id=$this->session->userdata['user_id'];
		$data['user_info']=$this->user->get_basic_info($id);
		$data['user']=$this->user->get($id);
		$data['owner']=TRUE;
		
		$this->load->view('templates/header.php',$data);
		$this->load->view('user/profile_upper_section.php',$data);
		$this->load->view('user/edit.php',$data);
		$this->load->view('templates/footer.php');
	}	
	public function edit_contact()
	{
		$data['title'] = "Edit profile";
		$data['post_url']="profile/save";
		$data['page']='edit_contact';

		$id=$this->session->userdata['user_id'];
		$data['user_info']=$this->user->get_basic_info($id);
		$data['user']=$this->user->get($id);
		$data['owner']=TRUE;
		
		$this->load->view('templates/header.php',$data);
		$this->load->view('user/profile_upper_section.php',$data);
		$this->load->view('user/edit.php',$data);
		$this->load->view('templates/footer.php');
	}
	public function save()
	{
		$this->load->library('user_agent');
		$id=$this->session->userdata['user_id'];
		$data=$this->input->post('user');
		$this->user->update_user_properties($id,$data);
		$this->session->set_flashdata('success_msg', 'Profile updated successfully!');
	    if ($this->agent->is_referral())
	    {
	    	redirect($this->agent->referrer());
	    }
	}
	public function load_user_pic_uploader()
	{
		$this->load->view('dialogs/image_uploader.php');
	}
	private function load_user_profile($id,$owner)
	{
		$data['title']='Profile - '.APP_NAME;
		$data['user_info']=$this->user->get_basic_info($id);
		$data['user']=$this->user->get($id);
		$data['owner']=$owner;
		/*
		// change this to username in future instead of email
		$this->session->set_userdata(array(
			'load_profile_email'=>$data['user']->email
			));
		$email=$this->session->userdata('load_profile_email');
		$count=$this->status->getContentCount($email)->offsetGet(0);

		$config['base_url']=site_url('profile');
		$config['total_rows']=$count['total'];
		$config["per_page"]=15;
		
		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$skip=$page*$config["per_page"];
		$this->pagination->initialize($config); 

		$data['posts']=$this->status->getContent($email,$skip,$config["per_page"],true);
		//die(print_r($data['posts']));
		*/
		$this->load->view('templates/header.php',$data);
		$this->load->view('user/profile_upper_section.php',$data);
		$this->load->view('user/index.php',$data);
		$this->load->view('templates/footer.php');
	}
	private function load_user_shelf($id,$owner)
	{
		$data['title']='Shelf - '.APP_NAME;
		$data['user_info']=$this->user->get_basic_info($id);
		$data['user']=$this->user->get($id);
		$data['books']=$this->user->get_books($id,"OWNS");
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
			$this->load->model('Status');
			$data=$this->user->add_to_shelf($id);
			// post status on timeline
			$status = new Status();
			$email = $this->session->userdata('email');
			$status->title=$data[0]['m']->title;
			$status::add($email,$status);
			echo json_encode($data);
		}
	}
	private function load_user_wishlist($id,$owner)
	{
		$data['title']='Wishlist - '.APP_NAME;
		$data['user_info']=$this->user->get_basic_info($id);
		$data['user']=$this->user->get($id);
		$data['books']=$this->user->get_books($id,"WISHES");
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
		$data['title']='Followers - '.APP_NAME;
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
		$data['title']='Following - '.APP_NAME;
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
		$thumb_height=32;
		$thumb_width=32;
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
			$error = $this->resize_image($data['upload_data']['full_path'],$thumb_height,$thumb_width);
			$id=$this->session->userdata['user_id'];
			$this->user->update_user_properties($id,array('profile_image'=>$data['upload_data']['file_name']));
			$error = array('error' => 'success', 'msg' => 'Picture updated', 'path'=>base_url('assets/uploads/profile_images').'/'.$data['upload_data']['file_name']);
		}
		echo json_encode($error);
	}
	public function save_lat_lon()
	{
		$data=array(
			'lat'=>doubleval($this->input->post('lat')),
			'lon'=>doubleval($this->input->post('lon'))
			);
		$id=$this->session->userdata['user_id'];
		$this->user->update_user_properties($id,$data);
	}
	private function resize_image($path,$height,$width)
	{	
		$config=array();
		$config['image_library'] = 'gd2';
		$config['source_image'] = $path;
		//$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = $width;
		$config['height'] = $height;
		$config['new_image']=str_replace('profile_images', 'thumbs', $path);

		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->resize())
		    return $data = array('error'=>$this->image_lib->display_errors());
		else
			$this->image_lib->clear();	
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
