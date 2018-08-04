<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

interface MaybeHavingDockBlock
{
    public function getDockBlock(): OptionalString;
}
