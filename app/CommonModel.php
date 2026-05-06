<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommonModel extends Model
{
    public function CheckMails($email) {
        $mails = array("gmail", "yahoo", "rediffmail", "hotmail", "aol", "zoho");

        list($user, $domain) = explode('@', $email);

        if ($domain) {
            list($email_domain, $main_domain) = explode('.', $domain);
        }

        if (in_array($email_domain, $mails)) {
            return "Yes";
        } else {
            return "No";
        }
    }

    public function gj_random($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function PostRequest($url, $referer, $_data, $mobile, $msg) {
        $data = array(
            'user' => "neural2019",
            'password' => "!@#neural789",
            'msisdn' => $mobile,
            'sid' => "NEUPRN",
            'msg' => $msg,
            'fl' =>"0",
            'gwid' =>"2",
        );

        // convert variables array to string:
        /*$data = array();
        while(list($n,$v) = each($_data)){
            $data[] = "$n=$v";
        }*/

        $data = implode('&', $data);
        // format --> test1=a&test2=b etc.
        // parse the given URL
        $url = parse_url($url);
        /*if ($url['scheme'] != 'http') {
            die('Only HTTP request are supported !');
        }*/
        
        // extract host and path:
        $host = $url['host'];
        $path = $url['path'];

        // open a socket connection on port 80
        $fp = fsockopen($host, 80);
        // send the request headers:
        fputs($fp, "POST $path HTTP/1.1\r\n");
        fputs($fp, "Host: $host\r\n");
        fputs($fp, "Referer: $referer\r\n");
        fputs($fp, "Content-type: application/x-www-form
        -urlencoded\r\n");
        fputs($fp, "Content-length: ". strlen($data) ."
        \r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $data);
        $result = '';

        while(!feof($fp)) {
            // receive the results of the request
            $result .= fgets($fp, 128);
        }
        
        // close the socket connection:
        fclose($fp);
        
        // split the result header from the content
        $result = explode("\r\n\r\n", $result, 2);
        $header = isset($result[0]) ? $result[0] : '';
        $content = isset($result[1]) ? $result[1] : '';
        
        // return as array:
        return array($header, $content);
    }

    public function SMS($mobile, $msg) {
        // echo $mobile;
        // echo $msg;
        // die();

        // Replace with your username
        $user = "neural2019";
        // Replace with your API KEY (We have sent API KEY on activation email, also available on panel)
        $password = "GJNEURAL123";
        // Replace with the destination mobile Number to which you want to send sms
        $msisdn = $mobile; // client no
        // Replace if you have your own Six character Sender ID, or check with our support team.
        // $sid = "GJNEUL";
        // $sid = "NEURAL";
        $sid = "NEUPRN";
        // Replace with client name
        $name = "Godwin Joe"; //optional
        // Replace if you have OTP in your template.
        $OTP = "6765R";  //optional
        // Replace with your Message content
        $msg = $msg;
        $msg = urlencode($msg);

        $fl = "0";

        // if you are using transaction sms api then keep gwid = 2 or if promotional then remove this parameter
        $gwid = "2";

        // For Plain Text, use "txt" ; for Unicode symbols or regional Languages like hindi/tamil/kannada use "uni"
        $type = "txt";

        // echo "http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=neural2019&password=GJNEURAL123&msisdn=".$msisdn."&sid=NEUPRN&msg=".$msg."&fl=0&gwid=2";die();

        //--------------------------------------
        //step1
        $cSession = curl_init(); 
        //step2
        /*curl_setopt($cSession,CURLOPT_URL,"http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?
        user=".$user."&password=".$password."&msisdn=".$msisdn."&sid=".$sid."&msg=".$msg."&fl=0&gwid=2");*/

        // curl_setopt($cSession,CURLOPT_URL,"http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=".$user."&password=".$password."&msisdn=".$msisdn."&sid=".$sid."&msg=".$msg."&fl=0");

        // http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=neural2019&password=GJNEURAL123&msisdn=7845782780&sid=NEUPRN&msg=Dear%20ABC,%20your%20password%20is%2034534.&fl=0&gwid=2

        // curl_setopt($cSession,CURLOPT_URL,"http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=".$user."&password=".$password."&msisdn=".$msisdn."&sid=".$sid."&msg=".$msg."&fl=0&gwid=2");
        // curl_setopt($cSession,CURLOPT_URL,"http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=".$user."&password=".$password."&msisdn=".$msisdn."&sid=".$sid."&msg=".$msg."&fl=0&gwid=2");
        curl_setopt($cSession,CURLOPT_URL,"http://cloud.smsindiahub.in/vendorsms/pushsms.aspx?user=neural2019&password=GJNEURAL123&msisdn=".$msisdn."&sid=NEUPRN&msg=".$msg."&fl=0&gwid=2");
        curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($cSession,CURLOPT_HEADER, false); 
        //step3
        $result=curl_exec($cSession);
        //step4
        curl_close($cSession);
        //step5
        // echo $result;
        // die();
        return $result;
    }

    public function change_date_format($date, $format) {
        if($date) {
            if($format == 2) {
                $date = date('F j, Y', strtotime($date));
            } else {
                $date = date('d-m-Y', strtotime($date));
            }
        }

        return $date;
    }
}
