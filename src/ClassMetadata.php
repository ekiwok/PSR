<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

use Ekiwok\Option\OptionString;

interface ClassMetadata extends \JsonSerializable
{
    public function getType(): ClassType;

    public function getName(): string;

    public function getNamespace(): string;

    public function isFinal(): bool;

    public function getDockBlock(): OptionString;

    /**
     * @return PropertyMetadata[]
     */
    function getPropertiesMetadata(): array;
}
