<?php

namespace HandmadeWeb\Frosty\Tags;

use HandmadeWeb\Frosty\Frosty;
use Illuminate\Support\Facades\Route;
use Statamic\Support\Arr;
use Statamic\Tags\Tags;

class FrostyTag extends Tags
{
    protected static $handle = 'frosty';

    protected $endpoint;

    /**
     * The {{ frosty }} tag.
     *
     * @return string
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * The {{ frosty:fetch }} tag.
     *
     * @return string
     */
    public function fetch()
    {
        $frosty = Frosty::make(mode: Arr::get($this->params, 'mode'))
            ->withContent($this->content)
            ->withContext($this->context);

        if (Arr::get($this->params, 'endpoint')) {
            $this->endpoint = Arr::get($this->params, 'endpoint');
        } elseif (Arr::get($this->params, 'url')) {
            $this->endpoint = Arr::get($this->params, 'url');
        } elseif (Arr::get($this->params, 'route') && Route::has(Arr::get($this->params, 'route'))) {
            $this->endpoint = route(Arr::get($this->params, 'route'));
        }

        if ($this->endpoint) {
            $frosty->withEndpoint($this->endpoint);
        }

        return $frosty->render();
    }

    /**
     * The {{ frosty:scripts }} tag.
     *
     * @return string
     */
    public function scripts()
    {
        return Frosty::scripts();
    }
}
