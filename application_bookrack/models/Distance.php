<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Distance extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}
	public function get_distance($currentUserId, $destinedUserId)
	{
		$currentUser=self::get_coordinates($currentUserId);
		$destinedUser=self::get_coordinates($destinedUserId);
		return self::calculate_distance($currentUser['latitude'],$currentUser['longitude'],$destinedUser['latitude'],$destinedUser['longitude']);
	}
	public static function convert_distance($dist, $unit="M")
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
	/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	/*::                                                                         :*/
	/*::  This routine calculates the distance between two points (given the     :*/
	/*::  latitude/longitude of those points). It is being used to calculate     :*/
	/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
	/*::                                                                         :*/
	/*::  Definitions:                                                           :*/
	/*::    South latitudes are negative, east longitudes are positive           :*/
	/*::                                                                         :*/
	/*::  Passed to function:                                                    :*/
	/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
	/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
	/*::    unit = the unit you desire for results                               :*/
	/*::           where: 'M' is statute miles (default)                         :*/
	/*::                  'K' is kilometers                                      :*/
	/*::                  'N' is nautical miles                                  :*/
	/*::  Worldwide cities and other features databases with latitude longitude  :*/
	/*::  are available at http://www.geodatasource.com                          :*/
	/*::                                                                         :*/
	/*::  For enquiries, please contact sales@geodatasource.com                  :*/
	/*::                                                                         :*/
	/*::  Official Web site: http://www.geodatasource.com                        :*/
	/*::                                                                         :*/
	/*::         GeoDataSource.com (C) All Rights Reserved 2015		   		     :*/
	/*::                                                                         :*/
	/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	protected static function calculate_distance($lat1, $lon1, $lat2, $lon2, $unit="K")
	{
		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;
		  $unit = strtoupper($unit);

		  if ($unit == "K") {
		    return ($miles * 1.609344);
		  } else if ($unit == "N") {
		      return ($miles * 0.8684);
		    } else {
		        return $miles;
		      }

		//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
		//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
		//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";

	}
	protected static function get_coordinates($userId)
	{
		$cypher="MATCH (n:User) WHERE ID(n)={id} RETURN n.latitude as latitude, n.longitude as longitude LIMIT 1";
		$result=$this->neo->execute_query($cypher, array('id'=>intval($id)));
		if(isset($result[0]))
			return $result[0];
		return array('latitude'=>0,'longitude'=>0);
	}
}