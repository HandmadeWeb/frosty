<?php

namespace HandmadeWeb\Frosty;

use HandmadeWeb\Frosty\Tags\FrostyTag;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        FrostyTag::class,
    ];
}
