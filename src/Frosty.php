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
        $mode = config('frosty.mode', 'native');
        if (! is_string($mode) || ! in_array($mode, ['native', 'alpine'])) {
            $mode = 'native';
        }

        return $mode;
    }

    public static function scripts(): string
    {
        if (static::mode() === 'native') {
            $script = 'https://cdn.jsdelivr.net/npm/datafetcher.js@1.0.0/dist/data-fetcher.min.js';

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
            ]);
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
