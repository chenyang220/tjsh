<?php

class Sms
{
	public static function send($mob, $content, $tple_id = null)
	{
		if (is_array($content))
		{
			$content = encode_json($content);
		}

		$name     = Web_ConfigModel::value('sms_account');
		$password = md5(Web_ConfigModel::value('sms_pass'));

		$mob     = $mob;

		$postData = array
		    (
		    'type'=>'send',
		    'username'=>$name,   
		    'password'=>$password,   
		    'gwid'=>'b53f523', 
		    'mobile'=>$mob,
		    'message'=>$content
		    );
		 
		$url="http://jk.106api.cn/smsUTF8.aspx";
		
//发送并把结果赋给$result,返回一个XML信息,解析xml 信息判断
	          
		$result= Sms::postSMS($url,$postData);
		Yf_Log::log('测试url='.$url.'数据'.$content.$result,INFO,'sms');
		return true;
	}

	public static function postSMS($url,$postData)
	{
	    $row = parse_url($url);
	    $host = $row['host'];
	    $port = isset($row['port']) ? $row['port']:80;
	    $file = $row['path'];
	    $post = "";
	    while (list($k,$v) = each($postData)) 
	    {
	        $post .= rawurlencode($k)."=".rawurlencode($v)."&"; 
	    }
	    $post = substr( $post , 0 , -1 );
	    $len = strlen($post);
	    $fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
	    if (!$fp) 
	    {
	        return "$errstr ($errno)\n";
	    }
	    else 
	    {
	        $receive = '';
	        $out = "POST $file HTTP/1.1\r\n";
	        $out .= "Host: $host\r\n";
	        $out .= "Content-type: application/x-www-form-urlencoded\r\n";
	        $out .= "Connection: Close\r\n";
	        $out .= "Content-Length: $len\r\n\r\n";
	        $out .= $post;      
	        fwrite($fp, $out);
	        while (!feof($fp)) {
	            $receive .= fgets($fp, 128);
	        }
	        fclose($fp);
	        $receive = explode("\r\n\r\n",$receive);
	        unset($receive[0]);
	        return implode("",$receive);
	    }
	}
}

?>