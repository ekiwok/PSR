<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

interface ClassMetadataBuilder
{
    public function setNamespace(string $namespace);

    public function setName(string $name);

    public function addProperty(PropertyMetadata $property);

    public function build(): ClassMetadata;
}