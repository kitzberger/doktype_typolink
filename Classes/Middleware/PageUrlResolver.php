<?php

namespace Kitzberger\DoktypeTypolink\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
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
        if ($GLOBALS['TSFE']->page['doktype'] == PageRepository::DOKTYPE_LINK) {
            if ($url = $GLOBALS['TSFE']->page['url']) {
                $urlParts = parse_url($url);
                if (($urlParts['scheme'] ?? false) === 't3') {
                    // it's a typolink that needs to be resolved!

                    // Initialize configuration
                    // (stolen from PrepareTypoScriptFrontendRendering)
                    $controller = $request->getAttribute('frontend.controller');
                    $GLOBALS['TYPO3_REQUEST'] = $request;
                    $request = $controller->getFromCache($request);
                    $GLOBALS['TYPO3_REQUEST'] = $request;

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
        }

        return $handler->handle($request);
    }
}
