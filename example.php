<?php

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use MySportsFeeds\MySportsFeeds;

$data_query = new MySportsFeeds('1.2', true);
$data_query->authenticate('<YOUR_API_KEY>', '<YOUR_ACCOUNT_PASSWORD>');
$data = $data_query->getData(
	'nba',               // league

	'2016-2017-regular', // season identifier

	'player_gamelogs',   // feed name

	'json',              // format (must be one of: "csv", "json", or "xml")

	// add any number of additional valid parameters, with "name=value" format
	'player=stephen-curry'
);

var_dump($data);

$data_query = new MySportsFeeds('2.0', true);
$data_query->authenticate('<YOUR_API_KEY>', 'MYSPORTSFEEDS');
$data = $data_query->getData(
	'nba',               // league

	'2016-2017-regular', // season identifier

	'seasonal_player_gamelogs',   // feed name

	'json',              // format (must be one of: "csv", "json", or "xml")

	// add any number of additional valid parameters, with "name=value" format
	'player=stephen-curry'
);

var_dump($data);
