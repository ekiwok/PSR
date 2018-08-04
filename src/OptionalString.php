<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

final class OptionalString
{
    /**
     * @var string|null
     */
    private $some;

    private function __construct(string $some = null)
    {
        $this->some = $some;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    static public function some(string $some): OptionalString
    {
        return new self($some);
    }

    static public function none(): OptionalString
    {
        return new self();
    }

    public function isPresent(): bool
    {
        return !is_null($this->some);
    }

    public function getOrElse(string $orElse): string
    {
        return $this->isPresent() ? $this->some : $orElse;
    }

    public function get(): string
    {
        return $this->some;
    }
}
