<?php

namespace Ekiwok\PCM\tests;

use Ekiwok\PCM\ImportsRegistryProvider;
use Ekiwok\PCM\Registry\ImportsRegistry;
use Ekiwok\PCM\tests\fixtures\Foo;
use Ekiwok\PCM\TokenParsingImportsRegistryProvider;
use PHPUnit\Framework\TestCase;

class TokenParsingImportsRegistryProviderTest extends TestCase
{
    /**
     * @var ImportsRegistryProvider
     */
    private $importsRegistryProvider;

    static public function setUpBeforeClass()
    {
        require_once(__DIR__.'/fixtures/resources/namespaces.php');
    }

    public function setUp()
    {
        $this->importsRegistryProvider = new TokenParsingImportsRegistryProvider();
    }


    public function testGenerate()
    {
        // given
        $className = \Outer\Space\Bizz::class;
        $reflection = new \ReflectionClass($className);
        $fileName = $reflection->getFileName();
        $namespace = $reflection->getNamespaceName();

        $expectedRegistry = new ImportsRegistry([
            'Foo' => Foo::class,
        ]);

        // do
        $importsRegistry = $this->importsRegistryProvider->generate($fileName, $className, $namespace);

        // expect
        $this->assertEquals($expectedRegistry, $importsRegistry);
    }
}

