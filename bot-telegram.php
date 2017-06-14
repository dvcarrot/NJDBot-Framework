<?php
	use app\Bot;
	use Telegram\Bot\Api; 

	include 'app/autoload.php';
	include 'vendor/autoload.php';
	include 'strategies/strategies.php';
	include 'config.php';

	try {
	    $telegram = new Api($config['telegram-config']['token']); 
	    $result = $telegram->getWebhookUpdates();

		$message = $result["message"]["text"];
	    
	    $params = [
	    	'userName' => $result["message"]["from"]["username"],
	    	'userID' => $result["message"]["chat"]["id"],
	    ];

	    if (isset($result['callback_query'])) {
	    	$message = $result["callback_query"]["data"];

	    	$params = [
		    	'userName' => $result["callback_query"]["from"]["first_name"],
		    	'userID' => $result["callback_query"]["from"]["id"],
		    ];
	    }

		$bot = new Bot($strategies, $config, $params);
		$replies = $bot->reply($message);
		

		foreach ($replies as $reply) {
			file_put_contents("log.txt", json_encode($reply));

			if (count($reply->keyboard['inline_keyboard'])) {
				$reply_markup = $telegram->replyKeyboardMarkup([
					'inline_keyboard' => $reply->keyboard['inline_keyboard'], 
				]);
			} else {
				$reply_markup = $telegram->replyKeyboardMarkup([
					'keyboard' => $reply->keyboard['keyboard'], 
					'resize_keyboard' => $reply->keyboard['resize_keyboard'], 
					'one_time_keyboard' => $reply->keyboard['one_time_keyboard'],
				]);
			}

			if (isset($reply->image)) {
				$telegram->sendPhoto([
					'chat_id' => $params['userID'], 
					'photo' => $reply->image, 
					'caption' => $reply->textTelegram,
					'reply_markup' => $reply_markup,
				]);	

				continue;
			}

			if (isset($reply->audio)) {
				$telegram->sendAudio([
				  'chat_id' => $params['userID'], 
				  'audio' => $reply->audio,
				  'reply_markup' => $reply_markup,
				]);

				continue;
			}

			if (isset($reply->video)) {
				$telegram->sendVideo([
				  'chat_id' => $params['userID'], 
				  'video' => $reply->video,
				  'reply_markup' => $reply_markup,
				]);

				continue;
			}

			if (isset($reply->location)) {
				$telegram->sendLocation([
				  'chat_id' => $params['userID'], 
				  'latitude' => $reply->location['latitude'],
				  'longitude' => $reply->location['longitude'],
				  'reply_markup' => $reply_markup,
				]);
			}

			if (isset($reply->document)) {
				$telegram->sendDocument([
				  'chat_id' => $params['userID'], 
				  'document' => $reply->document,
				  'caption' => $reply->textTelegram,
				  'reply_markup' => $reply_markup,
				]);
			}

			if (isset($reply->textTelegram)) {
				$telegram->sendMessage([
				  'chat_id' => $params['userID'], 
				  'text' => $reply->textTelegram,
				  'reply_markup' => $reply_markup,
				  'parse_mode' => 'HTML',
				]);
			}	
		}
	} catch (\Exception $e) {
		file_put_contents('logs/telegram.txt', date('d.m.Y H:i')."\t".$e->getMessage()."\t".$e->getFile()."\t".$e->getLine()."\n", FILE_APPEND | LOCK_EX);
	}

