<?php
	require_once("./config.php");
	require_once("./vendor/autoload.php");

	use Viber\Client;
	
	try {
	    $client = new Client(['token' => $config['viber-config']['api-key']]);
	    $result = $client->setWebhook($config['viber-config']['webhook-url']);
	
	    echo "Success!\n";
	} catch (\Exception $e) {
	    echo "Error: ". $e->getMessage()."\t".$e->getFile()."\t".$e->getLine() ."\n";
	}
