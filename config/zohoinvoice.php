<?php

	return [
		'authtoken' => env('ZOHO_AUTHTOKEN', ''),
		'organization_id' => env('ZOHO_ORGANIZATION', ''),
		'baseurl' => env('ZOHO_BASEURL', 'https://invoice.zoho.eu/api/v3'),
	];

?>
