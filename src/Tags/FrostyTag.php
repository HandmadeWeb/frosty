<?php

namespace HandmadeWeb\Frosty\Tags;

use HandmadeWeb\Frosty\FrostyFetcher;
use Illuminate\Support\Facades\Route;
use Statamic\Tags\Tags;

class FrostyTag extends Tags
{
    protected static $handle = 'frosty';

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
        $frosty = FrostyFetcher::make()
            ->withAntlers()
            ->withContent($this->content);

        if ($this->params['url'] ?? false) {
            $frosty->withEndpoint($this->params['url']);
        } elseif ($this->params['route'] ?? false && Route::has($this->params['route'])) {
            $frosty->withEndpoint(route($this->params['route']));
        }

        return $frosty->render();
    }
}
