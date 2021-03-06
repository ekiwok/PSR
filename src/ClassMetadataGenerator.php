<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

use Ekiwok\PCM\ClassMetadataBuilder\V1;

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
                        return V1::create();

                    default:
                        throw new \RuntimeException(sprintf("%s is not supported version.", $version));
                }
            }
        }, new TokenParsingImportsRegistryProvider());
    }
}
