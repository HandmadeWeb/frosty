<div x-data 
    x-init="fetch('{{ $frosty->endpoint() }}')
        .then(response => response.text())
        .then(html => $el.innerHTML = html)"
>{{ $frosty->content() }}</div>