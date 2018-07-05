<?php

	namespace Babaweb\ZohoInvoice;

	use Illuminate\Support\ServiceProvider;

	class ZohoInvoiceServiceProvider extends ServiceProvider
	{
		public function boot()
		{
			if($this->isLumen()){
				return;
			}

      		$this->mergeConfigFrom(
        		__DIR__.'/../config/zohoinvoice.php', 'zohoinvoice'
    		);
		}

		public function register()
		{
			$this->registerZoho();
		}

		private function registerZoho()
		{
			$this->app->bind('Babaweb\ZohoInvoice\ZohoInvoiceClient', function($app){
				if($this->isLumen()){
					$app->configure('zohoinvoice');
				} 

				$config = [];
				$config['authtoken'] = config('zohoinvoice.authtoken');
				$config['organization_id'] = config('zohoinvoice.organization_id');
				$config['baseurl'] = config('zohoinvoice.baseurl', 'https://invoice.zoho.eu/api/v3');
				return new ZohoInvoiceClient($config);
			});
		}

		private function isLumen()
		{
			return is_a(\app(), 'Laravel\Lumen\Application');
		}
	}
?>
