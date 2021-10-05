<?php

namespace Kitzberger\DoktypeTypolink\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\LinkHandling\LinkService;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class PageUrlResolver implements MiddlewareInterface
{
    /**
     * Resolve the URL of a typolinked page url
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($url = $GLOBALS['TSFE']->page['url']) {
            $urlParts = parse_url($url);
            if ($urlParts['scheme'] === 't3') {
                // it's a typolink that needs to be resolved!

                // Initialize configuration
                // (stolen from PrepareTypoScriptFrontendRendering)
                $GLOBALS['TSFE']->getConfigArray($request);

                // Get instance of ContentObjectRenderer
                $cObj = GeneralUtility::makeInstance(
                    ContentObjectRenderer::class,
                    $GLOBALS['TSFE']
                );

                // Create URL from typolink syntax
                if ($uri = $cObj->typolink_URL(['parameter' => $url])) {
                    $GLOBALS['TSFE']->page['url'] = $uri;
                }
            }
        }

        return $handler->handle($request);
    }
}
