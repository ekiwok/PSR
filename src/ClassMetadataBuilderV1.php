<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

use Ekiwok\Option\OptionString;

/**
 * @package Ekiwok\PCM
 * @internal
 */
final class ClassMetadataBuilderV1 implements ClassMetadataBuilder
{
    const VERSION = '1';

    /**
     * @var ImportsRegistryProvider
     */
    private $importsRegistryProvider;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var ClassType
     */
    private $type;

    /**
     * @var string|null
     */
    private $maybeDockBlock;

    /**
     * @var bool
     */
    private $isFinal;

    /**
     * @var PropertyMetadata[]
     */
    private $propertiesMetadata = [];

    private function __construct(ImportsRegistryProvider $importsRegistryProvider)
    {
        $this->importsRegistryProvider = $importsRegistryProvider;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    static public function create(ImportsRegistryProvider $importsRegistryProvider): ClassMetadataBuilderV1
    {
        return new ClassMetadataBuilderV1($importsRegistryProvider);
    }

    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setIsFinal(bool $isFinal)
    {
        $this->isFinal = $isFinal;
    }

    public function addProperty(PropertyMetadata $property)
    {
        $this->propertiesMetadata[] = $property;
    }

    public function setType(ClassType $type)
    {
        $this->type = $type;
    }

    public function setDockBlock(string $maybeDockBlock = null)
    {
        $this->maybeDockBlock = $maybeDockBlock;
    }

    public function build(): ClassMetadata
    {
        return new class(
            $this->name,
            $this->namespace,
            $this->isFinal,
            $this->type,
            $this->maybeDockBlock,
            ...$this->propertiesMetadata
        ) implements ClassMetadata {

            /**
             * @var string
             */
            private $name;

            /**
             * @var string
             */
            private $namespace;

            /**
             * @var bool
             */
            private $isFinal;

            /**
             * @var string|null
             */
            private $maybeDockBlock;

            /**
             * @var ClassType
             */
            private $type;

            /**
             * @var PropertyMetadata[]
             */
            private $propertiesMetadata;

            public function __construct(
                string $name,
                string $namespace,
                bool $isFinal,
                ClassType $type,
                string $maybeDockBlock = null,
                PropertyMetadata ...$propertiesMetadata
            ) {
                $this->name = $name;
                $this->namespace = $namespace;
                $this->isFinal = $isFinal;
                $this->maybeDockBlock = $maybeDockBlock;
                $this->type = $type;
                $this->propertiesMetadata = $propertiesMetadata;
            }

            /**
             * {@inheritdoc}
             */
            function getName(): string
            {
                return $this->name;
            }

            /**
             * {@inheritdoc}
             */
            public function jsonSerialize()
            {
                return get_object_vars($this);
            }

            function getNamespace(): string
            {
                return $this->namespace;
            }

            /**
             * @return PropertyMetadata[]
             */
            function getPropertiesMetadata(): array
            {
                return $this->propertiesMetadata;
            }

            public function isFinal(): bool
            {
                return $this->isFinal;
            }

            public function getDockBlock(): OptionString
            {
                return OptionString::of($this->maybeDockBlock);
            }

            public function getType(): ClassType
            {
                return $this->type;
            }
        };
    }
}
