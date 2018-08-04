<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

final class ClassType
{
    const T_CLASS = 'class';
    const T_INTERFACE = 'interface';
    const T_TRAIT = 'trait';

    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        if (!in_array($value, [self::T_CLASS, self::T_INTERFACE, self::T_TRAIT])) {
            throw new \RuntimeException(sprintf('Not supported value: %s ', $value));
        }

        $this->value = $value;
    }

    static public function from(\ReflectionClass $reflection): ClassType
    {
        switch (true)
        {
            case $reflection->isInterface():
                return new self(self::T_INTERFACE);

            case $reflection->isTrait():
                return new self(self::T_TRAIT);

            default:
                return new self(self::T_CLASS);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
