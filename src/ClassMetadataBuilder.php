<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

use Ekiwok\PCM\Registry\ImportsRegistry;

interface ClassMetadataBuilder
{
    public function setNamespace(string $namespace);

    public function setName(string $name);

    public function addProperty(PropertyMetadata $property);

    public function setIsFinal(bool $isFinal);

    public function setDockBlock(string $maybeDockBlock = null);

    public function setType(ClassType $type);

    public function build(): ClassMetadata;

    public function setImports(ImportsRegistry $importsRegistry);
}
