<?php
	
	use App\SenatorNetwork;

	require_once(base_path('\vendor\j7mbo\twitter-api-php\TwitterAPIExchange.php'));

	function getSenateList() {
		$settings = array(
			'oauth_access_token' => "829935495593332737-qf9JtT1z47TQUNTgy9IO8b4g3f78KbX",
	    	'oauth_access_token_secret' => "gu2sa6lwf2U4XJ6Oj8jredMwK7CXZRI4UYDHrw2u5sTvc",
	    	'consumer_key' => "eUYznBeSep4aPUvHiHQlYUs7b",
	    	'consumer_secret' => "nEWUeVcL5Hi8hgq7ztxpApy5apawIR9sWzm15Ww3YW3RVbYnXa"
		);

		$url = "https://api.twitter.com/1.1/lists/members.json";

		$requestMethod = 'GET';

		$getfields = '?owner_screen_name=gov&slug=us-senate&count=100';

		$twitter = new TwitterAPIExchange($settings);
		$data = $twitter->setGetfield($getfields)
				->buildOauth($url, $requestMethod)
				->performRequest();

		$data = json_decode($data);

		$users = $data->users;
		$senators = [];
		foreach ($users as $user) {
			$senators[] = ['id' => $user->id_str, 'name' => $user->name, 'screen_name' => $user->screen_name];
		}

		return $senators;
	}

	function getFollowingList($source) {
		
		$settings = array(
			'oauth_access_token' => "829935495593332737-qf9JtT1z47TQUNTgy9IO8b4g3f78KbX",
	    	'oauth_access_token_secret' => "gu2sa6lwf2U4XJ6Oj8jredMwK7CXZRI4UYDHrw2u5sTvc",
	    	'consumer_key' => "eUYznBeSep4aPUvHiHQlYUs7b",
	    	'consumer_secret' => "nEWUeVcL5Hi8hgq7ztxpApy5apawIR9sWzm15Ww3YW3RVbYnXa"
		);

		$url = "https://api.twitter.com/1.1/friends/ids.json";

		$requestMethod = 'GET';

		$getfields = '?stringify_ids=true&user_id='.$source['id'];

		$twitter = new TwitterAPIExchange($settings);
		$data = $twitter->setGetfield($getfields)
			->buildOauth($url, $requestMethod)
			->performRequest();

		$data = json_decode($data);
		return $data->ids;
	}

	function export() {
		$table = SenatorNetwork::all();
		$file = fopen('senators.csv', 'w');
		foreach ($table as $row) {
			fputcsv($file, array(
				$row['source_id'],
				$row['source_name'],
				$row['source_handle'],
				$row['target_id'],
				$row['target_name'],
				$row['target_handle']
			));
		}
		fclose($file);
		return;
	}

	function import() {
		
		set_time_limit(240);

		$file = fopen('senators.csv', 'r');
		while ($row = fgetcsv($file)) {
			$edge = new SenatorNetwork ([
                'source_id' => $row[0],
                'source_name' => $row[1],
                'source_party' => $row[2],
                'source_state' => $row[3],
                'source_handle' => $row[4],
                'target_id' => $row[5],
                'target_name' => $row[6],
                'target_party' => $row[7],
                'target_state' => $row[8],
                'target_handle' => $row[9]
            ]);

            $edge->save();
		}
		fclose($file);
		return;
	}

	function saveSenators($senators) {
		for ($i = 95; $i < 100; $i++) { 
		
			$source = $senators[$i];
			$followers = getFollowingList($source);

			foreach ($senators as $target) {
				if (in_array($target['id'], $followers)) {
					$edge = new SenatorNetwork ([
		                'source_id' => $source['id'],
		                'source_name' => $source['name'],
		                'source_handle' => $source['screen_name'],
		                'target_id' => $target['id'],
		                'target_name' => $target['name'],
		                'target_handle' => $target['screen_name']
	            	]);

	            	$edge->save();
				}
			}
		}
	}

	//$senators = getSenateList();
	//saveSenators($senators);
	return;
?>