<?php

namespace Handmadeweb\Frosty\Fieldtypes;

use HandmadeWeb\Frosty\Frosty;
use Statamic\Fields\Fieldtype;

class FrostyFieldType extends Fieldtype
{
    protected static $handle = 'frosty';

    public function augment($value)
    {
        return $this->performAugmentation($value, false);
    }

    public function shallowAugment($value)
    {
        return $this->performAugmentation($value, true);
    }

    protected function performAugmentation($value, bool $shallow = false)
    {
        return Frosty::make(endpoint: $value['endpoint'])->render();
    }
}
