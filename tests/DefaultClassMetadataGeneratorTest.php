<?php
declare(strict_types=1);

namespace Ekiwok\PCM\tests;

use Ekiwok\PCM\ClassMetadata;
use Ekiwok\PCM\ClassMetadataGenerator;
use Ekiwok\PCM\ClassType;
use Ekiwok\PCM\Property;
use Ekiwok\PCM\PropertyMetadata;
use Ekiwok\PCM\tests\fixtures\EmptyInterface;
use Ekiwok\PCM\tests\fixtures\FinalBar;
use Ekiwok\PCM\tests\fixtures\Foo;
use Ekiwok\PCM\tests\fixtures\FooTrait;
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

    /**
     * @dataProvider generate_shouldReturnClassMetadata_dataProvider
     */
    public function testGenerate_shouldReturnClassMetadata($className, array $expectedClassMetadata)
    {
        // given
        list($name, $namespace, $isFinal, $dockBlock, $type, $properties) = $expectedClassMetadata;

        // do
        $classMetadata = self::$defaultClassMetadataGenerator->generate($className);

        // expect
        $this->assertClassMetadata(
            $classMetadata,
            $name,
            $namespace,
            $isFinal,
            $dockBlock,
            $type,
            $properties
        );
    }

    public function generate_shouldReturnClassMetadata_dataProvider(): array
    {
        return [
            'simple one property Foo class' => [
                Foo::class,
                [
                    $name = 'Foo',
                    $namespace = 'Ekiwok\PCM\tests\fixtures',
                    $isFinal = false,
                    $dockBlock = "/**\n * Class Foo\n */",
                    $type = new ClassType(ClassType::T_CLASS),
                    $properties = [
                        'foo' => [new Visibility(Visibility::PRIVATE), null]
                    ]
                ]
            ],
            'simple one final Bar class extending Foo' => [
                FinalBar::class,
                [
                    $name = 'FinalBar',
                    $namespace = 'Ekiwok\PCM\tests\fixtures',
                    $isFinal = true,
                    $dockBlock = null,
                    new ClassType(ClassType::T_CLASS),
                    $properties = [
                        'test' => [new Visibility(Visibility::PROTECTED), '/** Comment */']
                    ]
                ]
            ],
            'simple EmptyInterface with not methods and properties' => [
                EmptyInterface::class,
                [
                    $name = 'EmptyInterface',
                    $namespace = 'Ekiwok\PCM\tests\fixtures',
                    $isFinal = false,
                    $dockBlock = null,
                    $type = new ClassType(ClassType::T_INTERFACE),
                    $properties = []
                ]
            ],
            'simple FooTrait with single property' => [
                FooTrait::class,
                [
                    $name = 'FooTrait',
                    $namespace = 'Ekiwok\PCM\tests\fixtures',
                    $isFinal = false,
                    $dockBlock = null,
                    $type = new ClassType(ClassType::T_TRAIT),
                    $properties = [
                        'foo' => [new Visibility(Visibility::PRIVATE), null],
                    ]
                ]
            ],
        ];
    }

    private function assertClassMetadata(
        ClassMetadata $classMetadata,
        string $name,
        string $namespace,
        bool $isFinal,
        string $dockBlock = null,
        ClassType $type,
        array $properties = []
    ) {
        $this->assertEquals($name, $classMetadata->getName());
        $this->assertEquals($namespace, $classMetadata->getNamespace());
        $this->assertEquals($isFinal, $classMetadata->isFinal());
        $this->assertEquals($dockBlock, $classMetadata->getDockBlock()->isPresent() ? $classMetadata->getDockBlock()->get() : null);
        $this->assertEquals($type, $classMetadata->getType());
        $this->assertEquals(count($properties), count($classMetadata->getPropertiesMetadata()));

        foreach ($properties as $name => list($visibility, $dockBlock)) {

            $maybePropertyToAssert = array_filter(
                $classMetadata->getPropertiesMetadata(),
                function (PropertyMetadata $property) use ($name) {
                    return $property->getName() == $name;
                });

            // property is expected to exist
            $this->assertEquals(1, count($maybePropertyToAssert));

            /** @var PropertyMetadata $property */
            $property = reset($maybePropertyToAssert);

            $this->assertEquals(
                new Property($visibility, $name, $dockBlock),
                $property
            );
        }
    }
}
