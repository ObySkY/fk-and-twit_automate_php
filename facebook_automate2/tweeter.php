<?php



// POST ON TWEETER
if(isset($_POST['submit']))
{
$msg = $_REQUEST['tweet'];

$twitterObj->setToken($_SESSION['ot'], $_SESSION['ots']);
$update_status = $twitterObj->post_statusesUpdate(array('status' => $msg));
$temp = $update_status->response;

echo "<div align='center'>Updated your Timeline Successfully .</div>";

}
// FIN POST ON TWEETER
?>