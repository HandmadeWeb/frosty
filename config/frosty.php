<?php

return [
    /*
    * Javascript Mode
    *
    * Which Javascript mode to use?
    *
    * native: uses https://github.com/handmadeweb/datafetcher.js
    * - If you aren't using Alpine Js in your application then you'll need to load handmadeweb/datafetcher.js in your footer.
    * - You can either do this manually, or via the provided helpers for Alpine: `{{ frosty:scripts }}`
    * - Blade: `@frostyScripts` or PHP: `\HandmadeWeb\Frosty\Frosty::scripts();`
    *
    * alpine: uses Alpine.Js, be sure to load it.
    */
    'mode' => 'native',
];
