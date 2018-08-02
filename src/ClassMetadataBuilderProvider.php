<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

interface ClassMetadataBuilderProvider
{
    const LATEST_VERSION = 'latest';

    public function provideBuilder(string $version = self::LATEST_VERSION): ClassMetadataBuilder;
}
