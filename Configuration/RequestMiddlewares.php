<?php

if ($GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['doktype_typolink']['enableMiddleware'] ?? false) {
    return [
        'frontend' => [
            'kitzberger/cms-redirects/page-url-resolved' => [
                'target' => \Kitzberger\DoktypeTypolink\Middleware\PageUrlResolver::class,
                'after' => [
                    'typo3/cms-frontend/tsfe',
                ],
                'before' => [
                    'typo3/cms-frontend/prepare-tsfe-rendering',
                ],
            ],
        ],
    ];
} else {
    return [];
}
