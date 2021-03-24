<?php 

$data = ob_get_contents();
ob_clean();

echo preg_replace_callback('|.*</head>|',function()use($_js_header){
			
			return $_js_header.'</head>';
			
		}, $data);

 ?>
 <script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?d40047d384986f4a41d40cefc3d2e64b";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>