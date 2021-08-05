<?php

namespace HandmadeWeb\Frosty;

use Statamic\Facades\Antlers;

class FrostyFetcher
{
    protected $content;
    protected $endpoint;
    protected $shouldUseAntlers;

    public static function make(string $content = null, string $endpoint = null, bool $shouldUseAntlers = false): static
    {
        return new static($content, $endpoint, $shouldUseAntlers);
    }

    public function __construct(string $content = null, string $endpoint = null, bool $shouldUseAntlers = false)
    {
        $this->content = $content;
        $this->endpoint = $endpoint;
        $this->shouldUseAntlers = $shouldUseAntlers;
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

    public function content(): ?string
    {
        return $this->shouldUseAntlers() ? Antlers::parse($this->content) : $this->content;
    }

    public function withContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function endpoint(): ?string
    {
        return $this->endpoint;
    }

    public function withEndpoint(string $endpoint): static
    {
        $this->endpoint = $endpoint;

        return $this;
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
}
