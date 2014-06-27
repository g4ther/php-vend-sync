<?php
	// ------------------------------------------------------------ 
	// Copyright (c) 2014 Nick Clark
	// ------------------------------------------------------------ 
	
	// ------------------------------------------------------------
	// Constants
	// ------------------------------------------------------------
		// Database Information
			// Enter your hostname, username, password and the
			// database you wish data to be inserted into here.
	define("DB_HOST", "localhost"); // Database Hostname
	define("DB_USER", "root");		// Database Username
	define("DB_PASS", "pass");		// Database Password
	define("DB_DB", "database");	// Which Database?
			// Also, specify a table prefix here if one exists
	define("TABLE_PREFIX", "");
	
		// Vend information
			// Enter your vend username and password here
	define("VEND_USER", "username"); // Vend Username
	define("VEND_PASS", "password"); // Vend Password
			// Change YOURSUBDOMAINHERE to your store's subdomain
			// (the bit before .vendhq.com)
	define("VEND_BASE_URL", "http://YOURSUBDOMAINHERE.vendhq.com/api/");
	define("VEND_AUTH", VEND_USER . ":" . VEND_PASS);

	// ------------------------------------------------------------
	// Functions
	// ------------------------------------------------------------
	
		// Get Request is the function that "GETs" information
		// (such as products).
		
		// $vend_url is the URL you wish to get (e.g. products)
		// $parameters is a single dimension array
		//		(e.g. array('order_by=id', 'order_direction=DESC'))
	function get_request($vend_url, $parameters = null) {
		// Append the URL to the base 
		$vend_url = VEND_BASE_URL . $vend_url;
		
		// Detect if there are parameters
		if (!empty($parameters)) {
			// Begin parameters using standard get encoding
			$vend_url .= "?"; 
			// Append each parameter
			foreach ($parameters as $parameter) {
				$vend_url .= $parameter;
				$vend_url .= "&";
			}
			
			// Remove the last character (an Ampersand)
			$vend_url = substr_replace($vend_url, "", -1);
		}
		
		// Begin the cURL call
		$curl = curl_init($vend_url);
		
		// Authenticate the user
		curl_setopt($curl, CURLOPT_USERPWD, VEND_AUTH);
		// Request JSON data (currently only JSON is supported)
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/json', 'Content-Type: application/json'));
		// Return the data rathern than output it
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
		// Get the response
		$response = curl_exec($curl);
		
		// Close the cURL call
		curl_close($curl);
		
		// return the response
		return $response;
	}
?>