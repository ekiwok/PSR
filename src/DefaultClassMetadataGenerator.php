<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

/**
 * @package Ekiwok\PCM
 * @internal
 */
final class DefaultClassMetadataGenerator extends ClassMetadataGenerator
{
    /**
     * @var ClassMetadataBuilderProvider
     */
    private $classMetadataBuilderProvider;

    /**
     * @param ClassMetadataBuilderProvider $classMetadataBuilderProvider
     */
    public function __construct(ClassMetadataBuilderProvider $classMetadataBuilderProvider)
    {
        $this->classMetadataBuilderProvider = $classMetadataBuilderProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(string $className): ClassMetadata
    {
        $reflection = new \ReflectionClass($className);
        $builder = $this->classMetadataBuilderProvider->provideBuilder();

        $docComment = $reflection->getDocComment();

        $builder->setName($reflection->getShortName());
        $builder->setNamespace($reflection->getNamespaceName());
        $builder->setIsFinal($reflection->isFinal());
        $builder->setDockBlock($docComment !== false ? $docComment : null);
        $builder->setType(ClassType::from($reflection));

        foreach ($reflection->getProperties() as $reflectionProperty) {
            $builder->addProperty(Property::from($reflectionProperty));
        }

        return $builder->build();
    }
}
