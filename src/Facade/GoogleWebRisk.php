<?php

namespace Harrisonratcliffe\LaravelGoogleWebRisk\Facade;

use Illuminate\Support\Facades\Facade;

class GoogleWebRisk extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'googlewebrisk';
    }
}
