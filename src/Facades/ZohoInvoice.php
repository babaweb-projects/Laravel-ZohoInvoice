<?php

namespace Babaweb\ZohoInvoice\Facades;

use Illuminate\Support\Facades\Facade;

class ZohoInvoiceFacade extends Facade {
	
    protected static function getFacadeAccessor() {
        return 'zohoinvoice';
    }
}
