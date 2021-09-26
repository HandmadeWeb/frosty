<!-- Frosty could not be rendered, Mode not found -->
@if(optional(Auth::user())->isSuper())
<!-- Mode: {{ $mode }} -->
<!-- Endpoint: {{ $endpoint }} -->
@endif