<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

/**
 * @package Ekiwok\PCM
 */
abstract class ClassMetadataGenerator
{
    abstract public function generate(string $className): ClassMetadata;

    static public function createDefaultGenerator(): ClassMetadataGenerator
    {
        return new DefaultClassMetadataGenerator(new class() implements ClassMetadataBuilderProvider {

            /**
             * {@inheritdoc}
             */
            public function provideBuilder(string $version = self::LATEST_VERSION): ClassMetadataBuilder
            {
                switch ($version)
                {
                    case ClassMetadataBuilderProvider::LATEST_VERSION:
                        return ClassMetadataBuilderV1::create(new TokenParsingImportsRegistryProvider());

                    default:
                        throw new \RuntimeException(sprintf("%s is not supported version.", $version));
                }
            }
        });
    }
}
