<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invite Friends</title>
			<link rel="stylesheet" href="css/form.css" />

<style type="text/css">
 
.fb_frnds{
    list-style:none;
}
.fb_frnds li{
        padding:10px;
    float:left;
    width:30%;
}
.frnd_list{
    margin-top:-25px;
    margin-left:40px;
}
.fb_frnds a{
    text-decoration:none;
    background: #333;
        /* for IE */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#333', endColorstr='#D95858'); 
        /* for webkit browsers */
        background: -webkit-gradient(linear, left top, left bottom, from(#333), to(#D95858)); 
        /* for firefox 3.6+ */
        background: -moz-linear-gradient(top,  #333,  #D95858);
        color: #FFFFFF;
    float: right;
    font: bold 13px arial;
    margin-right:110px ;
}
</style>
</head>
<body>
<?php 

		$base_url='http://www.obysky.com/dev/timetopostit/facebook_automate2/';
require_once ('lib/facebook.php');
 
$facebook = new Facebook(array(
        'appId'     =>  "331422990223833",
        'secret'    => "ee4f4d09a85c2c69088bda885c8accd1",
        ));
//get the user facebook id  
 
$user = $facebook->getUser();
 
if($user){
    try{
        //get the facebook friends list
      $user_friends = $facebook->api('/me/friends');
    }catch(FacebookApiException $e){
        error_log($e);
        $user = NULL;
    }       
}
if(isset($user_friends)){  ?>
<h1> Facebook Friends List </h1>
<ul  class="fb_frnds">
<?php
    foreach($user_friends['data'] as $user_friend){
?>
<li ><img src="https://graph.facebook.com/<?php echo $user_friend['id']; ?>/picture" width="30" height="30"/>
<div  class="frnd_list"><?php echo $user_friend['name']; ?><a href="javascript:void(0);" onclick="send_invitation(<?php echo $user_friend['id']; ?>);"> Invite </a></div>
</li>
 
<?php  }  ?>
</ul>
<?php
}else{
 
header('Location: '.$base_url); 
}?>
   <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"> </script>
 
<script type="text/javascript">
FB.init({ 
       appId:'<?php echo "331422990223833"; ?>', cookie:true, 
       status:true, xfbml:true 
     });
 
function send_invitation(fb_frnd_id){
     FB.ui({ method: 'apprequests', 
       message: 'Allez...Vient !',
       to:fb_frnd_id
     });

}
function fb_logout(){
    FB.logout(function(response) {
          parent.location ='<?php echo $base_url; ?>';
});
 
}
</script>
</body>
</html>