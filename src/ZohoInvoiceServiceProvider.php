<?php

	namespace Babaweb\ZohoInvoice;

	use Illuminate\Support\ServiceProvider;

	class ZohoInvoiceServiceProvider extends ServiceProvider
	{
		public function register()
        {
            $this->app->bind('zohoinvoice', 'Babaweb\ZohoInvoice\ZohoInvoice');

            $config = __DIR__ . '/../config/zohoinvoice.php';
            $this->mergeConfigFrom($config, 'zohoinvoice');

            $this->publishes([__DIR__ . '/../config/zohoinvoice.php' => config_path('zohoinvoice.php')], 'config');
        }
	}
?>
