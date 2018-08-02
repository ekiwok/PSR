<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

interface ClassMetadata extends \JsonSerializable
{
    function getName(): string;

    function getNamespace(): string;

    /**
     * @return PropertyMetadata[]
     */
    function getPropertiesMetadata(): array;
}
