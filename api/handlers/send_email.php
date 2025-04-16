<?php 
	function SendEmail($to, $subject, $body){
		//EMail configuration
		 $mail_host='mail.pools777.com';
		 $mail_port=587;
		 $mail_username='noreply@pools777.com';
		 $mail_password='bk3U7aIu';
		 $mail_from='noreply@pools777.com';
		 //EMail configuration-END
		 
        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: ". $from . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
         
        //mail($to,$subject,$body,$headers);
		require("handlers/class.phpmailer.php");
		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		//$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		//$mail->Host = "smtp.gmail.com";
		$mail->Host = $mail_host;
		$mail->Port = $mail_port;
		$mail->IsHTML(true);
		$mail->Username = $mail_username;
		$mail->Password = $mail_password;
		$mail->SetFrom($mail_from,"Pools777");
		//$mail->AddReplyTo($mail_from,"Pools777");
		$mail->Subject = $subject;
		$mail->Body = $body."<br>
							Pools777<br>
							www.pools777.com";
		$mail->AddAddress($to);
		if(!$mail->Send())
			{
			$message = "Mailer Error: " . $mail->ErrorInfo;
			$isMailSent=false;
			}else{	
			$message="Success";
			$isMailSent=true;
			//$query = "update usermaster set PwdChgReq='Y' where userid='".$userId."'";
				//error_reporting(0);
				//mysql_query($query);
			}
		return $isMailSent;
	}
?>