<?php
namespace Core\Libraries\Mail;
/**
* Class for sending e-mails, uses SwiftMailer library.
* @author Milos Kajnaco <miloskajnaco@gmail.com>
* @see http://swiftmailer.org/
*/
require 'lib/swift_required.php';
class Mail
{
	/**
	* Swift mailer object instance
	* @var Swift_Mailer
	*/
	private $mailer = null;

	/**
	* @var string
	*/
	private $protocol = 'smtp';

	/**
	* @var string
	*/
	private $server = 'smtp.gmail.com';

	/**
	* @var string
	*/
	private $username = 'miloskajnaco';

	/**
	* @var string
	*/
	private $password = 'njuh1926';

	/**
	* @var int
	*/
	private $port = 465;

	/**
	* Class constructor.
	* @var array
	*/
	public function __construct($params = [])
	{
		$transport = null;
		// Take parameters from passed array
        foreach ($params as $key => $val) {
            $this->$key = $val;
        }
    	// Create the Transport according to chosen parametar value
        switch($this->protocol) {
        	case 'smtp':
					$transport = \Swift_SmtpTransport::newInstance($this->server, $this->port, 'ssl')
					  ->setUsername($this->username)
					  ->setPassword($this->password);
			  		break;
        	case 'sendmail':
					$transport = \Swift_SendmailTransport::newInstance($this->server, $this->port, 'ssl')
					  ->setUsername($this->username)
					  ->setPassword($this->password);
					break;
        	case 'mail':				
        			$transport = \Swift_MailTransport::newInstance($this->server, $this->port, 'ssl')
					  ->setUsername($this->username)
					  ->setPassword($this->password);
					break;
        }
        // Make instance of Swift Mailer
        $this->mailer = \Swift_Mailer::newInstance($transport);
    }

	/**
	* Send mail.
	* @var string subject
	* @var string message
	* @var string from
	* @var string name from
	* @var string to
	* @var string name to
	* @return bool
	*/
	public function send($subject, $body, $from, $nameFrom, $to, $toName)
	{

        // Create message instance	
		$message = \Swift_Message::newInstance($subject)
	  				->setFrom(array($from => $nameFrom))
	  				->setTo(array($to => $toName))
	  				->setBody($body);

		// Send the message
		$result = $this->mailer->send($message);
		// Check result
		if($result) {
			return true;
		} else {
			return false;
		}
	}
}