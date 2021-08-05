<?php

namespace HandmadeWeb\Frosty;

use Illuminate\Support\Collection;
use Statamic\Facades\Antlers;

class FrostyFetcher
{
    protected $content;
    protected $context;
    protected $endpoint;
    protected $shouldUseAntlers;

    public static function make(string $content = null, ?Collection $context = null, string $endpoint = null, bool $shouldUseAntlers = false): static
    {
        return new static($content, $context, $endpoint, $shouldUseAntlers);
    }

    public function __construct(string $content = null, ?Collection $context = null, string $endpoint = null, bool $shouldUseAntlers = false)
    {
        $this->content = $content;
        $this->context = $context;
        $this->endpoint = $endpoint;
        $this->shouldUseAntlers = $shouldUseAntlers;
    }

    public function content(): ?string
    {
        return $this->shouldUseAntlers() ? Antlers::parse($this->content, $this->context()) : $this->content;
    }

    public function context(): Collection
    {
        if (is_null($this->context)) {
            $this->context = collect([]);
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

    public function shouldUseAntlers(): bool
    {
        return $this->shouldUseAntlers;
    }

    public function withAntlers(bool $shouldUseAntlers = true): static
    {
        $this->shouldUseAntlers = $shouldUseAntlers;

        return $this;
    }

    public function withContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function withContext(Collection $context): static
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
