<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/app/Modules')
    ->in(__DIR__ . '/app/Helpers')
    ->in(__DIR__ . '/app/Libraries')
    ->in(__DIR__ . '/app/Validation');
    //->in(__DIR__ . '/system');

    // run fix: vendor/bin/php-cs-fixer fix
return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder);