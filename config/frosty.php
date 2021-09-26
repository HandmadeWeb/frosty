<?php

return [
    /*
    * Mode
    *
    * Which mode to use?
    *
    * native: uses https://github.com/handmadeweb/datafetcher.js
    * - If you aren't using Alpine Js in your application then you'll need to load handmadeweb/datafetcher.js in your footer.
    * - You can either do this manually, or via the provided helpers for Alpine: `{{ frosty:scripts }}`
    * - Blade: `@frostyScripts` or PHP: `\HandmadeWeb\Frosty\Frosty::scripts();`
    *
    * alpine: uses Alpine.Js, be sure to load it.
    *
    * You are also free to define your own modes or override existing ones by creating a corresponding view file at `resources/vendor/frosty/`
    * And updating the mode below to match the name of the view.
    */
    'mode' => 'native',
];
