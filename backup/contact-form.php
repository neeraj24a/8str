<?php
	$name = $_POST['name'];
        $msg = $_POST['message'] .'<br/>'. 'From<br/>'. $name;

	$subject = "Homepage Query";
	$to = "support@8thwonderpromos.com";
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: 8thwonderpromos@gmail.com";
	if(mail($to,$subject,$msg,$headers)){
		echo "Meesage Sent Successfully.";
	}
?>
