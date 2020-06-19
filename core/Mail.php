<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/**
 * Classe utilisée pour envoyer des mails, notamment les mails de confirmation pour vérifier les adresses emails.
 * La classe utilise la bibliothèque PHPMailer qui est fortment utile et nécessaire pour envoyer des mails via PHP
 * PHPMailer se connecte au serveur SMTP d'OVH pour envoyer les mails
 * PHPMailer : https://github.com/PHPMailer/PHPMailer
 */

class Mail {

	/** @var PHPMailer Instance de PHPMailer à utiliser */
	private $mail;


	/**
	 * Construit l'instance de PHPMailer qui va être utilisée pour envoyer les mails 
	 */

	public function __construct(){
		/**
		 * Commentaires en anglais issues de la documentation officielle de PHPMailer
		 */

		// Instantiation and passing `true` enables exceptions
		$this->mail = new PHPMailer(true);

		//Server settings
		$this->mail->SMTPDebug = 0;                      // Enable verbose debug output
		$this->mail->isSMTP();                                            // Send using SMTP
		$this->mail->Host       = 'ssl0.ovh.net';                    // Set the SMTP server to send through
		$this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$this->mail->Username   = 'vanessa@toudou.xyz';                     // SMTP username

		// Pour des raisons évidentes de sécurité le mot de passe a été modifié !
		$this->mail->Password   = 'XXXXXXXXXXXXXXXXXXXX';                               // SMTP password
		$this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        
		$this->mail->Port       = 587;                                

		//Recipients
		$this->mail->setFrom('vanessa@toudou.xyz', 'Vanessa de Toudou');
		$this->mail->CharSet = 'UTF-8';
	}

	/**
	 * Envoyer un email de confirmation à un utilisateur
	 * @param User $user L'instance de l'utilisateur dont on veut envoyer l'email
	 * @param string $key La clé qui est à vérifier
	 * @return void
	 */

	public function sendConfirmationEmail($user, $key){
		$url = 'https://toudou.xyz/actions/confirm.php?key=' . $key ;
		try {
		    $this->mail->addAddress($user->email());     // Add a recipient

		    // Content
		    $this->mail->isHTML(true);                                  // Set email format to HTML
			$this->mail->Subject = "Confirmez votre email";
		    $this->mail->Body    = "Bonjour " . $user->username() . ", 
		    <br /><br />
		    Merci de vérifier votre adresse email en cliquant ici : <a href=\"$url\">$url</a>
		    <br /><br />
		    Cordialement,
		    <br /><br />
		    Vanessa, votre assistante toudou.xyz";
		    $this->mail->AltBody = "Bonjour " . $user->username() . ", merci de vérifier votre adresse email en suivant le lien : $url";

		    $this->mail->send();
		    echo 'Message has been sent';
		} 

		catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$e}";
		}

	}

}