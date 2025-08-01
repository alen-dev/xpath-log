<?php

namespace AlenDev\XpathLog\Facades;

use Illuminate\Support\Facades\Facade;

//class XpathLog extends Facade
//{
//    protected static function getFacadeAccessor(): string
//    {
//        return \AlenDev\XpathLog\XpathLog::class;
//    }
//}

class XpathLog extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'xpathlog';
    }
}
