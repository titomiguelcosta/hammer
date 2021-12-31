<?php

$fixer = new PhpCsFixer\Config();

return $fixer
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
    ]);
