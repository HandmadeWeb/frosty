<?php

namespace HandmadeWeb\Frosty;

use HandmadeWeb\Frosty\FieldTypes\FrostyFieldType;
use HandmadeWeb\Frosty\Tags\FrostyTag;
use Illuminate\Support\Facades\Blade;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $fieldtypes = [
        FrostyFieldType::class,
    ];

    protected $scripts = [
        __DIR__.'/../public/js/frosty.cp.js',
    ];

    protected $tags = [
        FrostyTag::class,
    ];

    public function boot()
    {
        parent::boot();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/frosty.php' => config_path('frosty.php'),
            ], 'config');
        }

        $this->bootDirectives();
    }

    public function bootDirectives()
    {
        Blade::directive('frostyScripts', function () {
            return "<?php echo \HandmadeWeb\Frosty\Frosty::scripts(); ?>";
        });

        Blade::directive('frosty', function ($expression) {
            return "<?php echo \HandmadeWeb\Frosty\Frosty::make({$expression})->render(); ?>";
        });
    }
}
