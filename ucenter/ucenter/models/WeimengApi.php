<?php

class WeimengApi
{

        //加密key
        // private static $key = 'CmqD6kpCBq7b7ypB';
        private static $key = 'w7IGvmon7ckO1aP2';
        //测试地址
        //private static $url = 'https://apisltest.sunhope.cn/api/';
        //正式地址
        private static $url = 'https://apiB2C.sunhope.cn/api/';

        public static function api($interface,$param = array())
        {
        // //拼接链接和接口名称
        $url = self::$url.$interface;

        //AES加密
        $aes        = new AesCrypt();
        $headers = array(
            'x-Authority-Identity:B2C'
        );
        $aes->iv = self::$key;  //传入iv值
        $encrypted  = $aes->encrypt(json_encode($param,320),self::$key); //320防止中文转译乱码或日期多反斜杠
        $encrypted  = '='.urlencode($encrypted); //转码并在前面连接"="
       
        $result = get_url($url,$encrypted,'JSON','POST','','10',$headers); //请求接口并推送数据

        Yf_Log::log('伟盟接口'.$interface.'接受数据='.$result,INFO,'WeimengSend');
        $result = $aes->decrypt($result,self::$key); //解密,无需转码,返回json数据
        Yf_Log::log('伟盟接口'.$interface.'返回数据='.$result,INFO,'Weimeng1');
        Yf_Log::log('伟盟接口'.$interface.'请求数据='.json_encode($param,320),INFO,'Weimeng1');
        Yf_Log::log('伟盟接口'.$interface.'请求数据='.$encrypted,INFO,'WeimengSend2');
        $result=rtrim($result,'');
        $result=rtrim($result,'');
        $result=rtrim($result,'');
        $result=rtrim($result,'');
        $result=rtrim($result,'');
        $result=rtrim($result,'');
        

        return $result;

        } 
}

?>