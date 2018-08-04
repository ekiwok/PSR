<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

final class Visibility
{
    const PUBLIC    = 'public';
    const PRIVATE   = 'private';
    const PROTECTED = 'protected';

    /**
     * @var string $value
     */
    private $value;

    public function __construct(string $value)
    {
        if (!in_array($value, [self::PUBLIC, self::PRIVATE, self::PROTECTED])) {
            throw new \RuntimeException(sprintf('Not supported value: %s ', $value));
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
