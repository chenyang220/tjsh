<?php

$sms_config = array();

$sms_config['sms_account'] = '尚赫国际';
$sms_config['sms_pass'] = '123456';

Yf_Registry::set('sms_config', $sms_config);

return $sms_config;
?>