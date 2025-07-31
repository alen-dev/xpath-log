<?php

namespace AlenDev\XpathLog\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AlenDev\XpathLog\XpathLog
 */
class XpathLog extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AlenDev\XpathLog\XpathLog::class;
    }
}
