<?php
	namespace Babaweb\ZohoInvoice\Tests;

	use Babaweb\ZohoInvoice\ZohoInvoiceClient;

	class ZohoClientTest extends \PHPUnit_Framework_TestCase
	{
		public function setUp(){

		}
		public function testCanCreateInstance()
	    {
	        $this->assertInstanceOf('Babaweb\ZohoInvoice\ZohoInvoiceClient', new ZohoInvoiceClient());
	    }
	    public function testIsHttpClientCreated()
	    {
	        $client = new ZohoInvoiceClient();
	        $this->assertNotNull($client->getClient());
	    }
	    
	}
?>