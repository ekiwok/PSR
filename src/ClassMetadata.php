<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

use Ekiwok\Option\OptionString;
use Ekiwok\PCM\Registry\ImportsRegistry;

interface ClassMetadata extends \JsonSerializable
{
    public function getType(): ClassType;

    public function getName(): string;

    public function getNamespace(): string;

    public function isFinal(): bool;

    public function getDockBlock(): OptionString;

    public function getImports(): ImportsRegistry;

    /**
     * @return PropertyMetadata[]
     */
    function getPropertiesMetadata(): array;
}
