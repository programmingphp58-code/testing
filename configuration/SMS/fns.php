<?php

use PHPMailer\PHPMailer\PHPMailer;

function get_setting($value){
    global $conn;
    $sql = $conn->query("SELECT * FROM sms_api WHERE id=1");
    $rs = $sql->fetch(PDO::FETCH_ASSOC);
    return $rs[$value];
}


function send_bulk_sms($data){

    set_time_limit(0);// to infinity for example
    $data['transaction_pin'] = get_setting('transaction_pin');
    $params = '';
    foreach ($data as $key => $value)
        $params .= $key . '=' . $value . '&';
    $params = trim($params, '&');
    // echo "<pre>". var_export($data,ture) . "</pre>";
    // var_dump($data['sender_name']);
    // die;

    $token = get_setting('access_token');
    $url = "https://padiwise.com/api/v1/bulk-sms";
    
    try{
        
 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //Url together with parameters
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7); //Timeout after 7 seconds
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in seconds
    
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo curl_error($ch);exit;
        } else {
            $content = json_decode($result, true);
        }
        curl_close($ch);
        
        // var_dump($content);
        // die;
        return $content;
    }catch (Exception $e) {
        var_dump($e->getMessage());
        die;
        echo "An error occurred: " . $e->getMessage();
    }


}


function set_flash ($msg,$type){
         $_SESSION['flash'] = '<div class="alert alert-'.$type.' alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>'.$msg.'</div>';
    }

    function flash(){
        if (isset($_SESSION['flash'])) {
            echo $_SESSION['flash'];
            unset($_SESSION['flash']);
        }
    }