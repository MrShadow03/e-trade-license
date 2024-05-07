<?php

namespace App\Traits;

trait MessageHandling {
    public function sendSMS($phone, $message){
        $post_url = "http://api.smsinbd.com/sms-api/sendsms" ;  
        $post_values = array(
            'api_token' => 'V4Fbl2ANcZnLg78hz5ThHHo8af0EetRtKylgAHDv',
            'senderid' => '8801969908462',
            'message' => $message,
            'contact_number' => '88'.$phone,
        );
        $post_string = "";
        foreach( $post_values as $key => $value )
            { $post_string .= "$key=" . urlencode( $value ) . "&"; }
        $post_string = rtrim( $post_string, "& " );
        
        $request = curl_init($post_url);
            curl_setopt($request, CURLOPT_HEADER, 0);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);  
            curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); 
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);  
            $post_response = curl_exec($request);
        curl_close ($request);

        $array =  json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $post_response), true );

        $status = array_key_exists('status', $array) && $array['status'] == 'success' ? true : false;
        return $status;
    }
}

// {"status":"success","message":"SMS sent successfully","smsid":"23022782466330756062","SmsCount":1}