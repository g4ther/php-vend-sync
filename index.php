<?php
	// notes:
	
	// constants
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "pass");
	define("DB_DB", "database");
	
	define("TABLE_PREFIX", "");
	
	define("VEND_USER", "username");
	define("VEND_PASS", "password");
	
	define("VEND_BASE_URL", "http://YOURSUBDOMAINHERE.vendhq.com/api/");
	define("VEND_AUTH", VEND_USER . ":" . VEND_PASS);

	function get_request($vend_url, $parameters = null) {
		$vend_url = VEND_BASE_URL . $vend_url;
		if (!empty($parameters)) {
			$vend_url .= "?";
			foreach ($parameters as $parameter) {
				$vend_url .= $parameter;
				$vend_url .= "&";
			}
			
			$vend_url = substr_replace($vend_url, "", -1);
		}
		
		$curl = curl_init($vend_url);
		
		curl_setopt($curl, CURLOPT_USERPWD, VEND_AUTH);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/json', 'Content-Type: application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($curl);
		
		curl_close($curl);
		
		return $response;
	}
?>