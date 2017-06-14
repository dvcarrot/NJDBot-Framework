<?php
namespace models\email;

require_once 'vendor/swiftmailer/swiftmailer/lib/swift_required.php';

class Mailer
{
	private static $host = 'ssl://smtp.yandex.com';
	private static $port = 465;
	private static $username = 'support@lime-office.com';
	private static $password = 'g7_9dHr533';

	public static function sendEmail($subject, $body)
	{
		$transport = \Swift_SmtpTransport::newInstance(static::$host, static::$port)
										  ->setUsername(static::$username)
										  ->setPassword(static::$password);

		$mailer = \Swift_Mailer::newInstance($transport);

		$message = \Swift_Message::newInstance($subject)
						  ->setFrom(static::$username)
						  ->setTo('pianorockcover@gmail.com')
						  ->setBody($body);

		return $mailer->send($message);
	}
}

