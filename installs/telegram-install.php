<?php
	require_once("./config.php");
	
	echo file_get_contents("https://api.telegram.org/bot{$config['telegram-config']['token']}/setWebhook?url={$config['telegram-config']['webhook-url']}");