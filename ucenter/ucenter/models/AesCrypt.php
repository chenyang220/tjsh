<?php   
/**
ios andriod php通用加密解密
$cr = new ECrypt(); 
echo $cr->decode("UTVYz6PgS6sCztmVhLAV6g==");
如果string是 a=1&b=1可通过以下变为数组 
parse_str($s,$arr); 
 */
class AesCrypt {

 	public $iv = 'w7IGvmon7ckO1aP2';
    public $screct_key = 'w7IGvmon7ckO1aP2';

    /**
	 * 加密方法
	 * @param string $str
	 * @return string
	 */
	 function encrypt($str){
		//AES, 128 模式加密数据 CBC
		$str = trim($str);
		$str = $this->addPKCS7Padding($str);
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_CBC),1);
		$encrypt_str =  mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->screct_key, $str, MCRYPT_MODE_CBC, $this->iv);
		return base64_encode($encrypt_str);
	}

	/**
	 * 解密方法
	 * @param string $str
	 * @return string
	 */
	 function decrypt($str){
	 	if(!$str){
	 		return;
	 	}
		//AES, 128 模式加密数据 CBC
		$str = base64_decode($str);
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_CBC),1);
		$encrypt_str =  mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->screct_key, $str, MCRYPT_MODE_CBC, $this->iv);
		$encrypt_str = trim($encrypt_str);
		$encrypt_str = $this->stripPKSC7Padding($encrypt_str);

		return $encrypt_str;

	}
	
	/**
	 * 移去填充算法
	 * @param string $source
	 * @return string
	 */
	function stripPKSC7Padding($source){
        //$block = mcrypt_get_block_size('tripledes', 'cbc');
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
     	$char = substr($source, -1, 1);
     	$num = ord($char);
	    if($num > 8){
	        return $source;
	    }
    	$len = strlen($source);
	    for($i = $len - 1; $i >= $len - $num; $i--){
	        if(ord(substr($source, $i, 1)) != $num){
	            return $source;
	        }
	    }
     	$source = substr($source, 0, -$num);
     	return $source;
     }
     /**
	 * 填充算法
	 * @param string $source
	 * @return string
	 */
	function addPKCS7Padding($source){
		$source = trim($source);
		$block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

		$pad = $block - (strlen($source) % $block);
		if ($pad <= $block) {
			$char = chr($pad);
			$source .= str_repeat($char, $pad);
		}
		return $source;
	}
	


}