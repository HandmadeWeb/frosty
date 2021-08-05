<?php

namespace HandmadeWeb\Frosty;

use HandmadeWeb\Frosty\Tags\FrostyTag;
use Illuminate\Support\Facades\Blade;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        FrostyTag::class,
    ];

    public function boot()
    {
        parent::boot();

        Blade::directive('frosty', function ($expression) {
            return "<?php echo \HandmadeWeb\Frosty\Frosty::make({$expression})->render(); ?>";
        });
    }
}
