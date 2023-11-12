<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Doktype Link => Typolink',
    'description' => 'Enhance doktype 3 ("Link to External URL") to support typolinks',
    'category' => 'system',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Philipp Kitzberger',
    'author_email' => 'typo3@kitze.net',
    'author_company' => '',
    'version' => '2.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
