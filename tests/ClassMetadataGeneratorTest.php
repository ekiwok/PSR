<?php
declare(strict_types=1);

namespace Ekiwok\PCM\tests;

use Ekiwok\PCM\ClassMetadataGenerator;
use PHPUnit\Framework\TestCase;

class ClassMetadataGeneratorTest extends TestCase
{
    public function testCreateDefaultClassMetadataGenerator()
    {
        // do
        $defaultGenerator = ClassMetadataGenerator::createDefaultGenerator();

        // expect
        $this->assertInstanceOf(ClassMetadataGenerator::class, $defaultGenerator);
    }
}
