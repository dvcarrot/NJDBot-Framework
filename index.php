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
		}

		button:hover {
			background: #ff5644;
		}
	</style>
</head>
<body>
	<b class="console-title">NJDBot Framework Debug Console</b>
	<form action="bot-debug.php" method="POST">
		<textarea name="message" cols="100" placeholder="Type your message here"></textarea>
		<br>
		<button type="submit">Send</button>
	</form>
</body>
</html>