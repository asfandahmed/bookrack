<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define("GOOGLE_API_KEY", "AIzaSyDxKm-UgZuspRnaIx2pJ6otz0sKYIDkOwc");
Class GCM {
	public function __construct()
	{
	}

	public function send_notification($registatoin_ids, $message) 
	{

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        //echo $result;
    }
    public function storeUser($email, $gcm_regid) 
    {
        // insert user into database
        $cypher="MATCH (n:User {email: {email} }) SET n.device_gcm_id = {device_gcm_id} RETURN ID(n) as id";
        $result = $this->db->execute_query($cypher,array("email"=>$email,"device_gcm_id"=>$gcm_regid));
        // check for successful store
        if (isset($result[0])) {
            return $result[0]['id'];
        } else {
            return false;
        }
    }
}