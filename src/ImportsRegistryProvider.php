<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

use Ekiwok\PCM\Registry\ImportsRegistry;

interface ImportsRegistryProvider
{
    public function generate(string $filePath, string $className, string $namespace): ImportsRegistry;
}
