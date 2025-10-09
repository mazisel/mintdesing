<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function mail_gonder($baslik,$mesaj,$alici,$yonetimAlicilari)
{	
	

	global $db;
	$smtp_ayar=$db->prepare("SELECT * FROM smtp_ayar WHERE SmtpID =?");
	$smtp_ayar->execute(array(1));
	$smtp_cek=$smtp_ayar->fetch(PDO::FETCH_ASSOC);
	$gonderen_host=$smtp_cek['SmtpHost'];
	$gonderen_mail=$smtp_cek['Smtpmail'];
	$gonderen_mail_sifre=$smtp_cek['Smtpsifre'];
	$gonderen_Adi=$smtp_cek['SmtpGondericiAdi'];
	$port=$smtp_cek['SmtpPort'];
	$siteUrl=$_SERVER['HTTP_HOST'];	
	$AliciMailler=explode(',', $smtp_cek['AliciMail1']);   
	$konu=$baslik;
	$icerik=$mesaj;		

	$mail = new PHPMailer(true);
	try {
	    //Server settings
	    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    // Enable verbose debug output
	    $mail->isSMTP();                                            // Send using SMTP
	    $mail->Host       = $gonderen_host;                    		// Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = $gonderen_mail;	                     	// SMTP username
	    $mail->Password   = $gonderen_mail_sifre;                   // SMTP password
	    $mail->CharSet = 'UTF-8';
	    if ($port==465) {
    	$mail->SMTPSecure = "ssl";         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
	    }else{
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    		// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
		}		    
	    $mail->Port       = $port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	    if ($port!=465) {
		    $mail->SMTPOptions = array(
					'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					)
			);
		}

	    //Recipients
	    $mail->setFrom($gonderen_mail, $gonderen_Adi);
	    if($alici!="0"){
		$mail->addAddress($alici);
		}
		if($yonetimAlicilari==1){
	        foreach ($AliciMailler as $alici_mail) {
	            if($alici_mail){$mail->addAddress($alici_mail);}
	        }
	    }
	    /*
	    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
	    $mail->addAddress('ellen@example.com');               // Name is optional
	    $mail->addReplyTo('info@example.com', 'Information');
	    $mail->addCC('cc@example.com');
	    $mail->addBCC('bcc@example.com');
	    */

	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $konu;
	    $mail->Body    = $icerik;
	    $mail->AltBody = '';

	    $mail->send();
	    return True;
	}catch (Exception $e) {
		return False;
	    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}

function sms_gonder($NEXMO_TO_NUMBER,$TEXT_SMS)
{
	
	global $db;
	$where=$db->prepare("SELECT * FROM sms_ayar WHERE SMSID =?");
	$where->execute(array(1));
	$sms_row=$where->fetch(PDO::FETCH_ASSOC);
	define('API_KEY', $sms_row['API_KEY']);
	define('API_SECRET', $sms_row['API_SECRET']);
	define('NEXMO_FROM_NUMBER', $sms_row['NEXMO_FROM_NUMBER']);
	$url = 'https://rest.nexmo.com/sms/json?' . http_build_query([
	    'api_key' => API_KEY,
	    'api_secret' => API_SECRET,
	    'to' => $NEXMO_TO_NUMBER,
	    'from' => NEXMO_FROM_NUMBER,
	    'text' => $TEXT_SMS
	]);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	return $response;
	// print_r($response);
}


function MailGonder($Baslik,$Mesaj,$Alicilar=[],$YonetimAlicilari=0)
{
	global $db;
	$smtp_ayar=$db->prepare("SELECT * FROM smtp_ayar WHERE SmtpID =?");
	$smtp_ayar->execute(array(1));
	$smtp_cek=$smtp_ayar->fetch(PDO::FETCH_ASSOC);
	$gonderen_host=$smtp_cek['SmtpHost'];
	$gonderen_mail=$smtp_cek['Smtpmail'];
	$gonderen_mail_sifre=$smtp_cek['Smtpsifre'];
	$gonderen_Adi=$smtp_cek['SmtpGondericiAdi'];
	$port=$smtp_cek['SmtpPort'];
	$siteUrl=$_SERVER['HTTP_HOST'];	
	$AliciMailler=explode(',', $smtp_cek['AliciMail1']);   
	$konu=$Baslik;
	$icerik=$Mesaj;		

	$mail = new PHPMailer(true);
	try {
	    //Server settings
	    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                    // Enable verbose debug output
	    $mail->isSMTP();                                            // Send using SMTP
	    $mail->Host       = $gonderen_host;                    		// Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = $gonderen_mail;	                     	// SMTP username
	    $mail->Password   = $gonderen_mail_sifre;                   // SMTP password
	    $mail->CharSet = 'UTF-8';
	    if ($port==465) {
    	$mail->SMTPSecure = "ssl";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
	    }else{
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    		// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
		}		    
	    $mail->Port       = $port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	    if ($port!=465) {
		    $mail->SMTPOptions = array(
					'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					)
			);
		}

	    //Recipients
	    $mail->setFrom($gonderen_mail, $gonderen_Adi);
	    if(count($Alicilar)){
	    	foreach ($Alicilar as $AliciMail) {
	            if($AliciMail){$mail->addAddress($AliciMail);}
	        }
		}
		if($YonetimAlicilari==1){
	        foreach ($AliciMailler as $alici_mail) {
	            if($alici_mail){$mail->addAddress($alici_mail);}
	        }
	    }
	    /*
	    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
	    $mail->addAddress('ellen@example.com');               // Name is optional
	    $mail->addReplyTo('info@example.com', 'Information');
	    $mail->addCC('cc@example.com');
	    $mail->addBCC('bcc@example.com');
	    */

	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $konu;
	    $mail->Body    = $icerik;
	    $mail->AltBody = '';

	    $mail->send();
	    return True;
	}catch (Exception $e) {
		return False;
	    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}