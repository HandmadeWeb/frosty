<?php

namespace HandmadeWeb\Frosty\Tags;

use HandmadeWeb\Frosty\Frosty;
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
        $frosty = Frosty::make()
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
