<?php
include("../res/x5engine.php");
$nameList = array("hf5","wfr","g37","8yd","5ah","e7c","6x6","8hf","jrn","vhf");
$charList = array("U","H","M","L","F","4","2","6","Y","3");
$cpt = new X5Captcha($nameList, $charList);
//Check Captcha
if ($_GET["action"] == "check")
	echo $cpt->check($_GET["code"], $_GET["ans"]);
//Show Captcha chars
else if ($_GET["action"] == "show")
	echo $cpt->show($_GET['code']);
// End of file x5captcha.php
