<?php

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PhpCsFixer' => true,
    '@PHP83Migration' => true,
])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
