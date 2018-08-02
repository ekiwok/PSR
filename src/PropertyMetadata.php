<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

interface PropertyMetadata
{
    public function getVisibility(): Visibility;

    public function getName(): string;
}
