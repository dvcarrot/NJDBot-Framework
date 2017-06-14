<?php
	include 'app/autoload.php';
	include 'vendor/autoload.php';
	include 'strategies/strategies.php';
	include 'config.php';

	use app\Bot;

	$message = $_POST['message'];
    
    $params = [
    	'userID' => 'debug_user',
    	'userName' => '',
    ];

	$bot = new Bot($strategies, $config, $params);
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>NJDBotFramework Debug Console</title>

	<style>
		body {
			background: #333333;
		    color: #fff;
		    font-family: monospace;
		    /* text-align: center; */
		    padding-top: 10px;
		    padding-left: 10px;
		}

		.console-title {
		    font-size: 20px;
		    display: block;
		    margin-bottom: 10px;
		}

		textarea {
			background: transparent;
		    font-size: 18px;
		    padding-bottom: 5px;
		    border: 0px;
		    outline: none;
		    color: #d7d7d7;
		    margin-bottom: 20px;
		}
		
		.button,
		button {
		    background: #e74c3c;
		    color: #fff;
		    font-size: 17;
		    letter-spacing: 1px;
		    font-family: monospace;
		    padding-left: 15px;
		    padding-right: 15px;
		    padding-top: 5px;
		    padding-bottom: 5px;
		    border: 0px;
		    border-radius: 10px;
		    cursor: pointer;
		    outline: none;
		    text-decoration: none !important;
		    display: inline-block;
		}
		
		.button:hover,
		button:hover {
			background: #ff5644;
		}

		.response-wrapper {
			margin-bottom: 20px;
			background: #fff;
			padding: 10px;
		    color: #000;
		}
	</style>
</head>
<body>
	<b class="console-title">Bot Response</b>
	<div class="response-wrapper">
		<?php highlight_string("<?php\n".var_export($bot->reply($message), true).";\n?>"); ?>
	</div>
	<a href="index.php" class="button" type="submit">Back</a>
</body>
</html>