<?php
declare(strict_types=1);

namespace Ekiwok\PCM;
use Ekiwok\Option\OptionString;

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

    /**
     * @var OptionString
     */
    private $dockBlock;

    public function __construct(Visibility $visibility, string $name, string $dockBlock = null)
    {
        $this->visibility = $visibility;
        $this->name = $name;
        $this->dockBlock = OptionString::of($dockBlock);
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
        $dockBlock = $reflectionProperty->getDocComment() ?: null;
        switch (true)
        {
            case $reflectionProperty->isPrivate():
                return new self(new Visibility(Visibility::PRIVATE), $reflectionProperty->name, $dockBlock);

            case $reflectionProperty->isProtected():
                return new self(new Visibility(Visibility::PROTECTED), $reflectionProperty->name, $dockBlock);

            case $reflectionProperty->isPublic():
                return new self(new Visibility(Visibility::PUBLIC), $reflectionProperty->name, $dockBlock);

            default:
                throw new \RuntimeException(sprintf('Unexpected property not public/private/protected'));
        }
    }

    public function getDockBlock(): OptionString
    {
        return $this->dockBlock;
    }
}
