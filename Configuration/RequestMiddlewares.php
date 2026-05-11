<?php

use Kitzberger\DoktypeTypolink\Middleware\PageUrlResolver;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if ($GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['doktype_typolink']['enableMiddleware'] ?? false) {
    $before = ['typo3/cms-frontend/shortcut-and-mountpoint-redirect'];
    if (ExtensionManagementUtility::isLoaded('headless')) {
        $before[] = 'headless/cms-frontend/shortcut-and-mountpoint-redirect';
    }

    return [
        'frontend' => [
            'kitzberger/doktype-typolink/page-url-resolved' => [
                'target' => PageUrlResolver::class,
                'after' => [
                    'typo3/cms-frontend/prepare-tsfe-rendering',
                ],
                'before' => $before,
            ],
        ],
    ];
}

return [];
