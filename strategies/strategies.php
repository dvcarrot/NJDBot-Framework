<?php

$strategies = [
	[
		'message' => ['/start', 'Hello', 'Hey', 'Hi', 'Say hello'], 
		'memory-conditions' => [],
		'handler' => [
			'controller' => 'Main',
			'action' => 'sayHello', 
		],
	],

	[
		'message' => '', 
		'memory-conditions' => [
			'$memory->wait_for_name == 1',
		],
		'handler' => [
			'controller' => 'Main',
			'action' => 'addNewUserName', 
		],
	],
];
