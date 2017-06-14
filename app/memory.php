<?php
/**
* Класс память - работа с БД
*/
namespace app;

class Memory
{
	public static $memoryTable;
	public static $userID;
	public static $userName;

	private $dataMapper;

	function __construct($config)
	{
		static::$memoryTable = $config['memory-table']['name'];
		
		$dbConfig = [
            'driver'    => 'mysql', 
            'host'      => $config['db']['host'],
            'database'  => $config['db']['name'],
            'username'  => $config['db']['user'],
            'password'  => $config['db']['password'],
            'charset'   => 'utf8',
        ];

		new \Pixie\Connection('mysql', $dbConfig, 'QB');
	}

	public function getMemory($params)
	{
		static::$userID = $params['userID'];
		static::$userName = $params['userName'];

		$query = \QB::table(static::$memoryTable)
							->where('user_id', '=', static::$userID);
		$results = $query->get();

		if ($results && count($results)) {
			return $results[0];
		} else {
			\QB::table(static::$memoryTable)
						->insert([
							'user_id' => static::$userID,
						]);

			$query = \QB::table(static::$memoryTable)->where('user_id', '=', static::$userID);
			$results = $query->get();

			if ($results && count($results)) {
				return $results[0];
			} else {
				return null;
			}
		}
	}
}