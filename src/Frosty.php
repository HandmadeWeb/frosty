<?php

namespace HandmadeWeb\Frosty;

use Illuminate\Support\Collection;
use Statamic\Facades\Antlers;
use Statamic\Tags\Context;

class Frosty
{
    protected $content;
    protected $context;
    protected $endpoint;
    protected $mode;

    public static function make(string $endpoint = null): static
    {
        return new static($endpoint);
    }

    public static function mode(): string
    {
        $defaultMode = 'native';

        if ($mode = config('frosty.mode')) {
            if (! in_array($mode, ['native', 'alpine'])) {
                $mode = $defaultMode;
            }
        }

        return $mode ?? $defaultMode;
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

    public function __construct(string $endpoint = null)
    {
        $this->endpoint = $endpoint;
        $this->mode = static::mode();
    }

    public function content(): string
    {
        return empty($this->content) ? '' : Antlers::parse($this->content, $this->context());
    }

    public function context(): Context
    {
        if (! $this->context) {
            $this->context = [];
        }

        if (is_array($this->context)) {
            $this->context = new Context($this->context);
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
            return view("frosty::{$this->mode}", [
                'frosty' => $this,
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
        $this->context = $context;

        return $this;
    }

    public function withEndpoint(string $endpoint): static
    {
        $this->endpoint = $endpoint;

        return $this;
    }
}
