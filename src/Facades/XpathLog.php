<?php

namespace AlenDev\XpathLog\Facades;

use Illuminate\Support\Facades\Facade;

class XpathLog extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'xpathlog';
    }
}
