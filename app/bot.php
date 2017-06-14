<?php
/**
* Основной класс - Бот
*/
namespace app;

class Bot
{
	private $strategies;
	private $memory;
	private $params;

	function __construct($strategies, $config, $params)
	{
		$this->strategies = $strategies;
		$this->params = $params;

		$this->memory = (new Memory($config))->getMemory($params);
	}

	function reply($message)
	{
		$memory = $this->memory;

		$controller = 'Error';
		$action = 'cantIdentify';

		foreach ($this->strategies as $strategy) {
			foreach ($strategy['memory-conditions'] as $condition) {
				$condition = "return $condition ?>";
				
				if (eval($condition)) {
					$controller = $strategy['handler']['controller'];
					$action = $strategy['handler']['action'];
				} else {
					$controller = 'Error';
					$action = 'cantIdentify';
				}
			}

			// var_dump($condition);
			if ($controller != 'Error' && $action != 'cantIdentify') {
				break;
			}
		}
		
		foreach ($this->strategies as $strategy) {
			if ($strategy['message']) {

				if (is_array($strategy['message'])) {
					$found = false;
					foreach ($strategy['message'] as $strategyMess) {
						if (substr_count(mb_strtolower($message,'UTF-8'), mb_strtolower($strategyMess,'UTF-8'))) {
							$controller = $strategy['handler']['controller'];
							$action = $strategy['handler']['action'];
							$found = true;

							break;
						}
					}

					if ($found) {
						break;
					}
				} else {
					if (substr_count(mb_strtolower($message,'UTF-8'), mb_strtolower($strategy['message'],'UTF-8'))) {
						$controller = $strategy['handler']['controller'];
						$action = $strategy['handler']['action'];

						break;
					}
				}
			}
		}

		$controller = "controllers\\".$controller;

		return $controller::$action($message, $memory);
	}
}