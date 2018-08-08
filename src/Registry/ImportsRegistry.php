<?php
declare(strict_types=1);

namespace Ekiwok\PCM\Registry;

final class ImportsRegistry
{
    private $registry = [];

    public function __construct(array $imports = [])
    {
        $this->registry = $imports;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function has(string $alias): bool
    {
        return array_key_exists($alias, $this->registry);
    }

    public function get(string $alias): string
    {
        return $this->registry[$alias];
    }
}
