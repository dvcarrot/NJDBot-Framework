<?php
	use app\Bot;

	include 'app/autoload.php';
	include 'vendor/autoload.php';
	include 'strategies/strategies.php';
	include 'config.php';
	
    $confirmationToken = $config['vk-config']['confirmation-token'];
    $groupAccessToken = $config['vk-config']['group-access-token'];

    $data = json_decode(file_get_contents('php://input')); 
    
    try {
	    if ($data->type == 'confirmation') {
	    	echo $confirmationToken; 

	    	return;
	    }

		$message = $data->object->body;
	    
	    $params = [
	    	'userID' => $data->object->user_id,
	    	'userName' => '',
	    ];

		$bot = new Bot($strategies, $config, $params);
		$replies = $bot->reply($message);	

		foreach ($replies as $reply) {
			if (isset($reply->textVk)) {
			    $get_params = [
			    		'message' => $reply->textVk, 
				        'user_id' => $params['userID'],
				        'access_token' => $groupAccessToken, 
				        'v' => '5.0',
			    	]; 

			    if ($reply->vkAttachment) {
			    	$get_params['attachment'] = $reply->vkAttachment;
			    }

			    $get_params = http_build_query($get_params);

			    file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 

			}
		}
		
		echo 'ok';
    } catch (\Exception $e) {

    	file_put_contents('logs/vk.txt', date('d.m.Y H:i')."\t".$e->getMessage()."\t".$e->getFile()."\t".$e->getLine()."\n", FILE_APPEND | LOCK_EX);
		
		echo 'ok';
		return;    	
    }
