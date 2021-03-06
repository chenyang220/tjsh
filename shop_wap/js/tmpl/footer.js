$(function () {
  if (getQueryString('key') != '') {
    var key = getQueryString('key');
    var username = getQueryString('username');
    addCookie('key', key);
    addCookie('username', username);
  }
  else {
    var key = getCookie('key');
  }
  
  var html = '<div class="nctouch-footer-wrap posr">'
      + '<div class="nav-text">';
  var navtext = '';
  if (key) {
    html += navtext = '<a href="' + WapSiteUrl + '/tmpl/member/member.html">我的商城</a>'
        + '<a id="logoutbtn" href="javascript:void(0);">注销</a>'
        + '<a href="' + WapSiteUrl + '/tmpl/member/member_feedback.html">反馈</a>';
    
  }
  else {
    html += navtext = '<a class="logbtn"  href="javascript:void(0);">登录</a>'
        + '<a id="regbtn" href="javascript:void(0);">注册</a>'
        + '<a href="' + WapSiteUrl + '/tmpl/member/login.html">反馈</a>';
  }
  
  if (typeof copyright == 'undefined') {
    copyright = '';
  }
  
  var key = getCookie('key');
  
  $('#footer .nav-text').html(navtext);
  
  $.getJSON(SiteUrl + '/index.php?ctl=Api_Wap&met=version&typ=json', function (r) {
    
    html += '<a href="javascript:void(0);" class="gotop">返回顶部</a>'
        + '</div>'
        + '<div class="nav-pic">'
        + '</div>'  
        + '<div class="copyright">'
        + r.data.copyright
        + '</div>'
        + '<div class="copyright">'
        + r.data.icp_number
        + '</div>'
        + '<div class="copyright">'
        + r.data.statistics_code
        + '</div>';
    $.post(ShopWapUrl + "/cache.php", {html: html}, function () {
    });
    $("#zhiboshipin").attr("src",r.data.shipin);

      if(r.data.image1){
        $('#buy1').css('display','block');
        $("#images1").attr("src",r.data.image1);
      }
      if(r.data.image2){
        $('#buy2').css('display','block');
        $("#images2").attr("src",r.data.image2);
      }
      if(r.data.image3){
        $('#buy3').css('display','block');
        $("#images3").attr("src",r.data.image3);
      }
      
      if(r.data.url1)
      {
        $("#url1").attr("href",r.data.url1);
      }
      if(r.data.url2)
      {
        $("#url2").attr("href",r.data.url2);
      }
      if(r.data.url3)
      {
        $("#url3").attr("href",r.data.url3);
      }
      if(r.data.mp4&&typeof videojs === "function"){
        // document.getElementById("source").src=r.data.mp4;
        var myPlayer = videojs('my-video');
        myPlayer.src(r.data.mp4);  //重置video的src
        myPlayer.load(r.data.mp4);  //使video重新加载    
       	// $("#my-video").attr("poster",r.data.mp4);
      }
    });
  $(document).on('click', '#regbtn', function () {
    callback = WapSiteUrl + '/tmpl/member/member.html';
    login_url = UCenterApiUrl + '?ctl=Login&met=regist&typ=e';
    callback = ApiUrl + '?ctl=Login&met=check&typ=e&redirect=' + encodeURIComponent(callback);
    login_url = login_url + '&from=wap&callback=' + encodeURIComponent(callback);
    window.location.href = login_url;
  });
  
  $(document).on('click', '.logbtn', function () {
    // wap端我的商城登录用户，成功后返回商城页
    callback = WapSiteUrl + '/tmpl/member/member.html';
    // callback = WapSiteUrl;
    login_url = UCenterApiUrl + '?ctl=Login&met=index&typ=e';
    callback = ApiUrl + '?ctl=Login&met=check&typ=e&redirect=' + encodeURIComponent(callback);
    login_url = login_url + '&from=wap&callback=' + encodeURIComponent(callback);
    window.location.href = login_url;
  });
  
  $(document).on('click', '#logoutbtn', function () {
    var username = getCookie('username');
    var key = getCookie('key');
    var client = 'wap';
    
    login_url = UCenterApiUrl + '?ctl=Login&met=logout&typ=e';
    var para = '';
    if (getCookie('is_app_guest')) {
      var para = '&qr=1';
      addCookie('is_app_guest', 1);
    }
    callback = WapSiteUrl + '?redirect=' + encodeURIComponent(WapSiteUrl) + para;
    login_url = login_url + '&from=wap&callback=' + encodeURIComponent(callback);
    window.location.href = login_url;
    delCookie('username');
    delCookie('user_account');
    delCookie('id');
    delCookie('key');
  });
});
