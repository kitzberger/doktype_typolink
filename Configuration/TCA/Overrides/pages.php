<?php

\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
    $GLOBALS['TCA']['pages'],
    [
        'columns' => [
            'url' => [
                'config' => [
                    'type' => 'link',
                    'size' => 50,
                    'max' => 1024,
                    'eval' => 'trim',
                    'softref' => 'typolink'
                ],
            ],
        ],
    ],
);
