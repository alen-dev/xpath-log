<?php

if (!function_exists('log_channel_name')) {
    function xpath_channel_name(): string
    {
        return config('xpath-log.channel', 'dynamic');
    }
}
