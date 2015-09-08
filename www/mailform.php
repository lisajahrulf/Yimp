<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$glass1 = trim($_POST["inputGlass1"]);
	$glass2 = trim($_POST["inputGlass2"]);
	$glass3 = trim($_POST["inputGlass3"]);
	$name = trim($_POST["inputName"]);		//required
	$address = trim($_POST["inputAddress"]);	//required
	$email = trim($_POST["inputEmail"]);	//required
	$telephone = trim($_POST["inputTelephone"]);	//required
	$how = trim($_POST["inputHow"]);
	$comments = trim($_POST["inputComments"]);


	if ($name == "" OR $address == "" OR $email == "" OR $telephone == "") {
		echo "<h3>Det blev ett fel vid beställning.</h3>";
		echo "<h3>Tänk på att följande måste anges: Namn, Adress, E-post och Telefonnummer.</h3>";
		echo "<h3>Tryck back-knappen i webbläsaren och försök igen!</h3>";
		exit; 
	} 

    require_once("class.phpmailer.php");
    require_once("class.smtp.php");
    $mail = new PHPMailer();

    if (!$mail->ValidateAddress($email)){
    	echo "<h3>Din epostadress du angav är felaktig.</h3>";
		echo "<h3>Tryck back-knappen i webbläsaren och försök igen!</h3>";
		exit;
    }

	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->SMTPSecure = "tsl";
	$mail->Username = "glasskyssen@gmail.com";
	$mail->Password = "gelado123";
	$mail->SMTPDebug  = 1;

	$email_body = $email_body . "Glass1: " . $glass1 . "<br>";
	$email_body = $email_body . "Glass2: " . $glass2 . "<br>";
	$email_body = $email_body . "Glass3: " . $glass3 . "<br>";
	$email_body = $email_body . "Namn: " . $name . "<br>";
	$email_body = $email_body . "Adress: " . $address . "<br>";
	$email_body = $email_body . "Email: " . $email . "<br>";
	$email_body = $email_body . "Telefon: " . $telephone . "<br>";
	$email_body = $email_body . "Hur fick kunden reda på denna?: " . $how . "<br>";
	$email_body = $email_body . "Övriga kommentarer: " . $comments . "<br>";

	$mail->SetFrom($email, $name);

	$address = "glasskyssen@gmail.com";

	$mail->AddAddress($address, "Glasskyssen");

	$mail->Subject = "Beställning | " . $name;

	$mail->MsgHTML($email_body);

	echo $email_body;

	if(!$mail->Send()) {
	  echo "Tyvärr, det blev ett fel vid beställningen: " . $mail->ErrorInfo;
	  exit;
	}   

	header("Location: success.html");
}
