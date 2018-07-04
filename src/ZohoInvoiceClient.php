<?php 
	
	namespace Babaweb\ZohoInvoice;

	use GuzzleHttp\Client;
	use Exception;

	class ZohoInvoiceClient{
		protected $baseUrl;
		protected $client;
		protected $url;
		protected $httpMethod = 'POST';

		public function __construct($config){
			$this->baseUrl = $config['baseurl'] . '/';
			$this->organization_id = $config['organization_id'];
			$this->authtoken = $config['authtoken'];
			$this->client = new Client(['base_uri' => $this->baseUrl]);
		}

		public function setClient($client)
		{
			$this->client = $client;
		}

		public function getClient()
		{
			return $this->client;
		}

		public function setOrganization($organization_id)
		{
			$this->organization_id = $organization_id;
		}

		public function getOrganization()
		{
			return $this->organization_id;
		}

		public function setBaseUrl($baseUrl)
		{
			$this->baseUrl = $baseUrl;
		}

		public function getBaseUrl()
		{
			return $this->baseUrl;
		}

		public function buildUrl($resource){
			if(!isset($resource['id'])){
				return $this->baseUrl . $resource['resource'] ;
			} if(isset($resource['id']) && isset($resource['additional'])) {
				return $this->baseUrl . $resource['resource'] . '/' . $resource['id'] . '/' . $resource['additional'];
			} else {
				return $this->baseUrl . $resource['resource'] . '/' . $resource['id'];
			}		
		}

		public function getContactList(){
			$this->method = 'GET';
			$resource['resource'] = 'contacts';
			return $this->call($resource);
		}

		public function getInvoiceList($customer_id){
			$this->method = 'GET';
			$resource['resource'] = 'invoices';
			$params['customer_id'] = $customer_id;
			return $this->call($resource, $params);
		}

		public function getInvoiceByID($invoice_id){
			$this->method = 'GET';
			$resource['resource'] = 'invoices';
			$resource['id'] = $invoice_id;
			$params['customer_id'] = $customer_id;
			return $this->call($resource, $params);
		}

		public function getInvoicePaymentsByID($invoice_id){
			$this->method = 'GET';
			$resource['resource'] = 'invoices';
			$resource['id'] = $invoice_id;
			$resource['additional'] = 'payments';
			$params['customer_id'] = $customer_id;
			return $this->call($resource, $params);
		}

		public function createItem($parameters){
			$this->method = 'POST';
			$resource['resource'] = 'items';
			$params['JSONString'] = json_encode($parameters);
			return $this->call($resource, $params);
		}

		public function createInvoice($parameters){
			$this->method = 'POST';
			$resource['resource'] = 'invoices';
			$params['JSONString'] = json_encode($parameters);
			return $this->call($resource, $params);
		}

		public function createContact($parameters){
			$this->method = 'POST';
			$resource['resource'] = 'contacts';
			$params['JSONString'] = json_encode($parameters);
			return $this->call($resource, $params);
		}

		public function updateItem($item_id, $parameters){
			$this->method = 'PUT';
			$resource['resource'] = 'items';
			$resource['id'] = $item_id;
			$params['JSONString'] = json_encode($parameters);
			return $this->call($resource, $params);
		}

		public function get($resource, $params = []) {
			$this->method = 'GET';
			return $this->call($resource, $params);
		}

		public function post($resource, $params = [])
		{
			$this->method = 'POST';
			return $this->call($resource, $params);
		}

		public function put($resource, $params = [])
		{
			if(!isset($resource['id'])){
				throw new Exception('id is required');
			}
			$this->method = 'PUT';
			return $this->call($resource, $params);
		}

		public function call($resource, $params = [], $rawResponse = false)
		{
			$url = $this->buildUrl($resource);

			if(!isset($params['authtoken'])){
				$params['authtoken'] = $this->authtoken;
			}

			if(!isset($params['organization_id'])){
				$params['organization_id'] = $this->organization_id;
			}
			$finalUrl = $url . '?' . $this->parseParams($params);
			$response = $this->client->request($this->method, $finalUrl);

			if(!isset($response)) {
				throw new Exception('No response.');
			}

			if($rawResponse){
				return $response->getBody();
			}
			$response = \GuzzleHttp\json_decode($response->getBody());
			return $response;
		}

		public function getResponse($response)
		{
			$result = json_decode($response);

			if(!isset($result)){
				throw new Exception('No response.');
			}

			return $response;
		}

		public function parseParams($params){
			if(!$params || count($params) < 1){
				throw new Exception ('No params specified.');
			}

			$query = '';

			foreach($params as $key => $value){
				if($query === '' || strlen($query) == 0){
					$query = $key . '=' . $value;
				} else {
					$query .= '&' . $key . '=' . $value;
				}
			}
			return $query;
		}

	}

?>