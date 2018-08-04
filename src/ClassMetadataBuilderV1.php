<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

/**
 * @package Ekiwok\PCM
 * @internal
 */
final class ClassMetadataBuilderV1 implements ClassMetadataBuilder
{
    const VERSION = '1';

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
     * @var OptionalString
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

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    static public function create(): ClassMetadataBuilderV1
    {
        return new ClassMetadataBuilderV1();
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

    public function setDockBlock(OptionalString $maybeDockBlock)
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
             * @var OptionalString
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
                OptionalString $maybeDockBlock,
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

            public function getDockBlock(): OptionalString
            {
                return $this->maybeDockBlock;
            }

            public function getType(): ClassType
            {
                return $this->type;
            }
        };
    }
}
