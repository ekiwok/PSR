<?php
declare(strict_types=1);

namespace Ekiwok\PCM\tests;

use Ekiwok\PCM\ClassMetadata;
use Ekiwok\PCM\ClassMetadataGenerator;
use Ekiwok\PCM\Property;
use Ekiwok\PCM\PropertyMetadata;
use Ekiwok\PCM\tests\fixtures\Foo;
use Ekiwok\PCM\Visibility;
use PHPUnit\Framework\TestCase;

class DefaultClassMetadataGeneratorTest extends TestCase
{
    /**
     * @var ClassMetadataGenerator
     */
    static private $defaultClassMetadataGenerator;

    static public function setUpBeforeClass()
    {
        self::$defaultClassMetadataGenerator = ClassMetadataGenerator::createDefaultGenerator();
    }

    public function testGenerate_shouldReturnClassMetadata()
    {
        // do
        $classMetadata = self::$defaultClassMetadataGenerator->generate(Foo::class);

        // expect
        $this->assertClassMetadata(
            $classMetadata,
            'Foo',
            'Ekiwok\PCM\tests\fixtures',
            [
                'foo' => [new Visibility(Visibility::PRIVATE)]
            ]
        );
    }

    private function assertClassMetadata(
        ClassMetadata $classMetadata,
        string $name,
        string $namespace,
        array $properties = []
    ) {
        $this->assertEquals($name, $classMetadata->getName());
        $this->assertEquals($namespace, $classMetadata->getNamespace());
        foreach ($properties as $name => list($visibility)) {
            $maybePropertyToAssert = array_filter(
                $classMetadata->getPropertiesMetadata(),
                function (PropertyMetadata $property) use ($name) {
                    return $property->getName() == $name;
                });
            // property is expected to exist
            $this->assertEquals(1, count($maybePropertyToAssert));
            /** @var PropertyMetadata $property */
            list($property) = $maybePropertyToAssert;
            $this->assertEquals($visibility, $property->getVisibility());
        }
    }
}
