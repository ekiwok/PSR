<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

interface ClassMetadata extends \JsonSerializable, MaybeHavingDockBlock
{
    public function getType(): ClassType;

    public function getName(): string;

    public function getNamespace(): string;

    public function isFinal(): bool;

    /**
     * @return PropertyMetadata[]
     */
    function getPropertiesMetadata(): array;
}
