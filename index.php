<?php
$headerDefault = "Template/header.php";
$bodyDefault = "Template/body.php";
$footerDefault = "Template/footer.php";

if (isset($_REQUEST['page'])){
    // Redirection controler
}
else {
    include($headerDefault);
    include($bodyDefault);
    include ($footerDefault);
}
?>