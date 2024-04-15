<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/tests',
    ])
     ->withPhpSets(
         php81: true,
    )
    ->withPreparedSets(
        deadCode: true,
        typeDeclarations: true,
        privatization: true,
        strictBooleans: true,
    )
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
    ]);
