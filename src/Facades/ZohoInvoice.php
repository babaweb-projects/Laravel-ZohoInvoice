<?php

namespace Babaweb\ZohoInvoice\Facades;

use Illuminate\Support\Facades\Facade;

class ZohoInvoice extends Facade {
	
    protected static function getFacadeAccessor() {
        return 'zohoinvoice';
    }
}
