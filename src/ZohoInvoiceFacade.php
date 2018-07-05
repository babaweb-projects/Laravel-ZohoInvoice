<?php

namespace Babaweb\ZohoInvoice;

use Illuminate\Support\Facades\Facade;

class ZohoInvoiceFacade extends Facade {
	
    protected static function getFacadeAccessor() {
        return 'zohoinvoice';
    }
}