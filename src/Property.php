<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

/**
 * @package Ekiwok\PCM
 * @internal
 */
final class Property implements PropertyMetadata
{
    /**
     * @var Visibility
     */
    private $visibility;

    /**
     * @var string
     */
    private $name;

    public function __construct(Visibility $visibility, string $name)
    {
        $this->visibility = $visibility;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getVisibility(): Visibility
    {
        return $this->visibility;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @throw \RuntimeException
     */
    static public function from(\ReflectionProperty $reflectionProperty): PropertyMetadata
    {
        switch (true)
        {
            case $reflectionProperty->isPrivate():
                return new self(new Visibility(Visibility::PRIVATE), $reflectionProperty->name);

            case $reflectionProperty->isProtected():
                return new self(new Visibility(Visibility::PROTECTED), $reflectionProperty->name);

            case $reflectionProperty->isPublic():
                return new self(new Visibility(Visibility::PUBLIC), $reflectionProperty->name);

            default:
                throw new \RuntimeException(sprintf('Unexpected property not public/private/protected'));
        }
    }
}
