# mysportsfeeds-php

MySportsFeeds PHP Wrapper brought to you by [@MySportsFeeds](https://twitter.com/MySportsFeeds).

Makes use of the [MySportsFeeds API](https://www.mysportsfeeds.com) - a flexible, developer-friendly Sports Data API.

Free for Non-Commercial Use.

##Install

Using composer, simply add it to the "require" section of your composer.json:
    
    "require": {
        "mysportsfeeds\mysportsfeeds-php": ">=0.1.0"
    }

If you haven't signed up for API access, do so here [https://www.mysportsfeeds.com/index.php/register/](https://www.mysportsfeeds.com/index.php/register/)

##Usage

Create main MySportsFeeds object with API version as input parameter

    use MySportsFeeds\MySportsFeeds;

    $msf = new MySportsFeeds("1.0");

Authenticate (v1.0 uses your MySportsFeeds account credentials)

    $msf->authenticate("YOUR_USERNAME", "YOUR_PASSWORD");

Start making requests, specifying in this order: $league, $season, $feed, $format, and any other applicable params for the feed.  See example.php for sample usage.

Get all NBA 2016-2017 regular season gamelogs for Stephen Curry, in JSON format

```
    $data = $msf->getData('nba', '2016-2017-regular', 'player_gamelogs', 'json', 'player=stephen-curry');
```

Get all NFL 2015-2016 regular season seasonal stats totals for all Dallas Cowboys players, in XML format

```
    output = msf.msf_get_data(league='nfl',season='2015-2016-regular',feed='cumulative_player_stats',format='xml',team='dallas-cowboys')
```

Get full game schedule for the MLB 2016 playoff season, in CSV format

```
    output = msf.msf_get_data(league='mlb',season='2016-playoff',feed='full_game_schedule',format='csv')
```

That's it!  Returned data is also stored locally under "results/" by default, in appropriately named files.
