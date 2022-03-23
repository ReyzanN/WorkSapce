<?php
session_start();
$headerDefault = "Template/header.php";
$bodyDefault = "Template/body.php";
$footerDefault = "Template/footer.php";

include($headerDefault);
if (isset($_REQUEST['page'])){
    $page = $_REQUEST['page'];
    include ('pages/'.$page.'.php');
}
else {
    include($bodyDefault);
}

include ($footerDefault);
?>