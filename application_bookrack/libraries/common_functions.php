<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class common_functions
{
	protected $CI;
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library(array('session'));
		$this->CI->load->helper('url');
	}
	public function is_logged_in()
	{
		$logged_in=$this->CI->session->userdata('logged_in');
		if(isset($logged_in))
			if($logged_in===true)
				return true;
		return false;
	}
	public function is_admin(){
		$admin=$this->CI->session->userdata('admin');
		if(isset($admin))
			if($admin==1)
				return true;
		return false;
	}
	public function convert_distance($dist, $unit="M")
	{
		$miles=$dist * 60 * 1.1515;
		if ($unit == "K") {
		    return ($miles * 1.609344);
		  } else if ($unit == "N") {
		      return ($miles * 0.8684);
		    } else {
		        return round($miles,2,PHP_ROUND_HALF_UP);
		      }

	}
	public function time_ago($time_ago)
	{

	    $time_ago = strtotime($time_ago);
	    $cur_time   = time();
	    $time_elapsed   = $cur_time - $time_ago;
	    $seconds    = $time_elapsed ;
	    $minutes    = round($time_elapsed / 60 );
	    $hours      = round($time_elapsed / 3600);
	    $days       = round($time_elapsed / 86400 );
	    $weeks      = round($time_elapsed / 604800);
	    $months     = round($time_elapsed / 2600640 );
	    $years      = round($time_elapsed / 31207680 );
	    // Seconds
	    if($seconds <= 60){
	        return "just now";
	    }
	    //Minutes
	    else if($minutes <=60){
	        if($minutes==1){
	            return "one minute ago";
	        }
	        else{
	            return "$minutes minutes ago";
	        }
	    }
	    //Hours
	    else if($hours <=24){
	        if($hours==1){
	            return "an hour ago";
	        }else{
	            return "$hours hrs ago";
	        }
	    }
	    //Days
	    else if($days <= 7){
	        if($days==1){
	            return "yesterday";
	        }else{
	            return "$days days ago";
	        }
	    }
	    //Weeks
	    else if($weeks <= 4.3){
	        if($weeks==1){
	            return "a week ago";
	        }else{
	            return "$weeks weeks ago";
	        }
	    }
	    //Months
	    else if($months <=12){
	        if($months==1){
	            return "a month ago";
	        }else{
	            return "$months months ago";
	        }
	    }
	    //Years
	    else{
	        if($years==1){
	            return "one year ago";
	        }else{
	            return "$years years ago";
	        }
	    }
		}
}