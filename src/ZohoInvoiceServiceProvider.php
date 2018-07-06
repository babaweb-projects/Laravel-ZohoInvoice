<?php

	namespace Babaweb\ZohoInvoice;

	use Illuminate\Support\ServiceProvider;

	class ZohoInvoiceServiceProvider extends ServiceProvider
	{
		public function boot()
		{
			if($this->isLumen()) {
				return;
			}

			$this->publishes([
       				__DIR__.'/../config/zohoinvoice.php' => config_path('zohoinvoice.php'),
    			]);
		}

		public function register()
		{
            $this->app->bind('Babaweb\ZohoInvoice\ZohoInvoice', function($app){
                if($this->isLumen()){
                    $app->configure('zohoinvoice');
                }

                return new ZohoInvoiceClient();
            });
		}

		private function isLumen()
		{
			return is_a(\app(), 'Laravel\Lumen\Application');
		}
	}
?>
