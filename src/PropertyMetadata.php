<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

use Ekiwok\Option\OptionString;

interface PropertyMetadata
{
    public function getVisibility(): Visibility;

    public function getName(): string;

    public function getDockBlock(): OptionString;
}
