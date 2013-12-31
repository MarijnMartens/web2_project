<img src="<?php echo base_url('assets/images/facebook.png');?>" id="facebook_login">
<script type="text/javascript">
window.fbAsyncInit = function() {
//Initiallize the facebook using the facebook javascript sdk
FB.init({
appId:'<?php $this->config->load('facebook'); echo $this->config->item('appID');?>',
cookie:true, // enable cookies to allow the server to access the session
status:true, // check login status
xfbml:true, // parse XFBML
oauth : true //enable Oauth
});
};
//Read the baseurl from the config.php file
(function(d){
var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
if (d.getElementById(id)) {return;}
js = d.createElement('script'); js.id = id; js.async = true;
js.src = "//connect.facebook.net/en_US/all.js";
ref.parentNode.insertBefore(js, ref);
}(document));
//Onclick for fb login
$('#facebook_login').click(function(e) {
 
FB.login(function(response) {
if(response.authResponse) {
parent.location ='<?php echo base_url('fb/fblogin'); ?>'; //redirect uri after closing the facebook popup
}
},{scope: 'email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos'}); //permissions for facebook
});
</script>
