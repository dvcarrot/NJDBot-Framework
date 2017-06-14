<?php
	spl_autoload_register(function($class) {
		$class = str_replace('\\', '/', $class);
		
		if (file_exists(strtolower($class).'.php'))
		{
			require(strtolower($class).'.php');
		}
		return;
	});