<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

use Ekiwok\Option\OptionString;

interface MaybeHavingDockBlock
{
    public function getDockBlock(): OptionString;
}
