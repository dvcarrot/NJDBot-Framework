<?php
namespace controllers;

use app\Controller;
use app\Memory;
use app\Reply;

use models\UserNameManager;
use controllers\Error;

class Main extends Controller
{
	/**
	  * Return a hello message
	  * @param $message string
	  * @param $memory object
	  *
	  */

	public static function sayHello($message, $memory) 
	{
		$replyMessage = '';

		if ($memory->user_name) {
			$replyMessage = "Hello, {$memory->user_name}! I'm your first bot!";
		} else {
			$replyMessage = "Hello! Type your name please!";

			$model = new UserNameManager();
			$model->user_name = $message;
			$model->user_id = $memory->user_id;

			if (!$model->activateWaitForUserNameFlag()) {
				return Error::unidentifiedError($message, $memory);
			}
		}

		$reply = new Reply();
		/* Generating messages for different apps */
		$reply->textTelegram = $replyMessage;
		$reply->textViber = $reply->textTelegram;
		$reply->textVk = $reply->textTelegram;

		if ($memory->user_name) {
			/* Attaching an image for Vibet and Telegram  */
			$reply->image = "https://njdstudio.com/bot_image.png";
			/* Attaching an image for Vk */
			$reply->vkAttachment = 'photo-146421446_456239023';
		}

		/* Setting up a keyboard for Telegram and Viber */
		$reply->keyboard['keyboard'] = [
			['Say hello']
		];

		return [$reply];
	}

	/**
	  * Saves a new username into database
	  * @param $message string
	  * @param $memory object
	  *
	  */ 
	public static function addNewUserName($message, $memory)
	{
		/* Initializing a model which updates a database */
		$model = new UserNameManager();
		$model->user_name = $message;
		$model->user_id = $memory->user_id;

		if ($model->save()) 
		{
			$reply = new Reply();
			$reply->textTelegram = "New username was saved! Please, type hello again!";
			$reply->textViber = $reply->textTelegram;
			$reply->textVk = $reply->textTelegram;

			$reply->keyboard['keyboard'] = [
				['Say hello']
			];

			return [$reply];	
		}

		return Error::unidentifiedError($message, $memory);

	}
}	