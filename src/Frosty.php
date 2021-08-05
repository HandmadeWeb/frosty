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
    protected $antlers;

    public static function make(string $content = null, array | Collection $context = [], string $endpoint = null, bool $antlers = false): static
    {
        return new static($content, $context, $endpoint, $antlers);
    }

    public function __construct(string $content = null, array | Collection $context = [], string $endpoint = null, bool $antlers = false)
    {
        $this->content = $content;
        $this->context = $context;
        $this->endpoint = $endpoint;
        $this->antlers = $antlers;
    }

    public function content(): ?string
    {
        return $this->antlers() ? Antlers::parse($this->content, $this->context()) : $this->content;
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
            return view('frosty::fetcher', [
                'frosty' => $this,
            ]);
        }

        return $this->content();
    }

    public function antlers(): bool
    {
        return $this->antlers;
    }

    public function withAntlers(bool $antlers = true): static
    {
        $this->antlers = $antlers;

        return $this;
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
