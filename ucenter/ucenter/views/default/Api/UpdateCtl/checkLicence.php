var LsBody = document.body; 
var LsDiv = document.createElement("div");  
var LsContent = '<div id="toast-container" class="toast-top-right" aria-live="polite" role="alert"><div class="toast toast-error" style=""><div class="toast-message">系统未授权</div></div></div>';
LsContent+='<style>#toast-container {position: fixed;z-index: 999999;}.toast-top-right {top: 12px;    right: 12px;}#toast-container > .toast-error {  background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAHOSURBVEhLrZa/SgNBEMZzh0WKCClSCKaIYOED+AAKeQQLG8HWztLCImBrYadgIdY+gIKNYkBFSwu7CAoqCgkkoGBI/E28PdbLZmeDLgzZzcx83/zZ2SSXC1j9fr+I1Hq93g2yxH4iwM1vkoBWAdxCmpzTxfkN2RcyZNaHFIkSo10+8kgxkXIURV5HGxTmFuc75B2RfQkpxHG8aAgaAFa0tAHqYFfQ7Iwe2yhODk8+J4C7yAoRTWI3w/4klGRgR4lO7Rpn9+gvMyWp+uxFh8+H+ARlgN1nJuJuQAYvNkEnwGFck18Er4q3egEc/oO+mhLdKgRyhdNFiacC0rlOCbhNVz4H9FnAYgDBvU3QIioZlJFLJtsoHYRDfiZoUyIxqCtRpVlANq0EU4dApjrtgezPFad5S19Wgjkc0hNVnuF4HjVA6C7QrSIbylB+oZe3aHgBsqlNqKYH48jXyJKMuAbiyVJ8KzaB3eRc0pg9VwQ4niFryI68qiOi3AbjwdsfnAtk0bCjTLJKr6mrD9g8iq/S/B81hguOMlQTnVyG40wAcjnmgsCNESDrjme7wfftP4P7SP4N3CJZdvzoNyGq2c/HWOXJGsvVg+RA/k2MC/wN6I2YA2Pt8GkAAAAASUVORK5CYII=") !important}#toast-container > div {margin: 0 0 6px;padding: 15px 15px 15px 50px;width: 300px;-moz-border-radius: 3px 3px 3px 3px;-webkit-border-radius: 3px 3px 3px 3px;border-radius: 3px 3px 3px 3px;background-position: 15px center;background-repeat: no-repeat;-moz-box-shadow: 0 0 12px #999999;-webkit-box-shadow: 0 0 12px #999999;box-shadow: 0 0 12px #999999;color: #ffffff;opacity: 0.8;-ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);filter: alpha(opacity=80);}#toast-container * {-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;}.toast-message {-ms-word-wrap: break-word;word-wrap: break-word;}.toast-error {background-color: #bd362f;}toastr.css:139.toast {background-color: #030303;}</style>';
LsDiv.innerHTML = LsContent;
LsBody.appendChild(LsDiv);  