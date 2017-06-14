<?php
	use app\Bot;

	include 'app/autoload.php';
	include 'vendor/autoload.php';
	include 'strategies/strategies.php';
	include 'config.php';


	$apiKey = $config['viber-config']['api-key'];
	$viberBotSender = new Viber\Api\Sender([
	    'name' => 'NJDPizzaBot',
	    'avatar' => 'https://developers.viber.com/img/favicon.ico',
	]);

	try {
	    $viberBot = new Viber\Bot(['token' => $apiKey]);
	    $viberBot->onText('(.*)', function ($event) use ($viberBot, $viberBotSender, $config, $strategies) {
			$message = $event->getMessage()->getText();
			    
		    $params = [
		   		'userID' => $event->getSender()->getId(),
			    // 'userID' => '666',
		   		'userName' => '',
		    ];

			$bot = new Bot($strategies, $config, $params);
			$replies = $bot->reply($message);

			foreach ($replies as $reply) {
				if (isset($reply->image)) {
					$content = (new \Viber\Api\Message\Picture())
		                ->setSender($viberBotSender)
		                ->setReceiver($event->getSender()->getId())
		                ->setText($reply->textViber)
		                ->setMedia($reply->image);

				} else if (isset($reply->textViber)) {
			        $content = (new Viber\Api\Message\Text())
			            ->setSender($viberBotSender)
			            ->setReceiver($event->getSender()->getId())
			            ->setText($reply->textViber);
				}

				if (isset($content)) {
					if (count($reply->keyboard['keyboard'])) {
						$buttons = toUsualArray($reply->keyboard['keyboard']);
						$buttonsFormatted = [];

						foreach ($buttons as $button) {
							$buttonsFormatted[] = (new \Viber\Api\Keyboard\Button())
		                        ->setActionType('reply')
		                        ->setActionBody($button)
		                        ->setText($button);
						}

						$content->setKeyboard(
		                    (new \Viber\Api\Keyboard())
		                    ->setButtons($buttonsFormatted)
		                );
					}

			        $viberBot->getClient()->sendMessage($content);
				}
			}
	    })
	    ->run();
	} catch (Exception $e) {
	    file_put_contents('logs/viber.txt', date('d.m.Y H:i')."\t".$e->getMessage()."\t".$e->getFile()."\t".$e->getLine()."\n", FILE_APPEND | LOCK_EX);
	}

	function toUsualArray($multiarray)
	{
		$iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($multiarray));

		$result = array();
		foreach($iterator as $value) {
			$result[] = $value; 
		}

		return $result;
	}