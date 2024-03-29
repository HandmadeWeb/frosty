<?php

namespace HandmadeWeb\Frosty;

use Illuminate\Support\Collection;
use Statamic\Facades\Antlers;
use Statamic\Tags\Context;
use Statamic\View\View;

class Frosty
{
    protected $content;
    protected $context;
    protected $endpoint;
    protected $mode;

    public static function make(string $endpoint = null, ?string $mode = null): static
    {
        $mode = $mode ? $mode : static::mode();

        return new static($endpoint, static::mode($mode));
    }

    public static function mode(?string $mode = null): string
    {
        return $mode ? $mode : config('frosty.mode', 'native');
    }

    public static function scripts(): string
    {
        if (static::mode() === 'native') {
            $version = '1.1.2';
            $script = "https://cdn.jsdelivr.net/gh/handmadeweb/datafetcher.js@{$version}/dist/data-fetcher.min.js";

            return "<script src='{$script}'></script>";
        }

        return '';
    }

    public function __construct(string $endpoint = null, ?string $mode = null)
    {
        $this->endpoint = $endpoint;
        $this->mode = static::mode($mode);
    }

    public function content(): string
    {
        return empty($this->content) ? '' : Antlers::parse($this->content, $this->context());
    }

    public function context(): Context
    {
        if (! $this->context) {
            $this->withContext([]);
        }

        if (! $this->context instanceof Context) {
            $this->context = new Context($this->context->all());
        }

        return $this->context;
    }

    public function endpoint(): ?string
    {
        return $this->endpoint;
    }

    public function render(): string
    {
        if ($this->endpoint()) {
            return View::first(["frosty::{$this->mode}", 'frosty::not-found'], [
                'content' => $this->content(),
                'endpoint' => $this->endpoint(),
                'mode' => $this->mode,
            ])->render();
        }

        return $this->content();
    }

    public function withContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function withContext(array | Collection $context): static
    {
        if (is_array($context)) {
            $context = collect($context);
        }

        $this->context = $context;

        return $this;
    }

    public function withEndpoint(string $endpoint): static
    {
        $this->endpoint = $endpoint;

        return $this;
    }
}
