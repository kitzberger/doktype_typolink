<?php

namespace Kitzberger\DoktypeTypolink\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Resolve the URL of a typolinked page url
 */
class PageUrlResolver implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $pageInformation = $request->getAttribute('frontend.page.information');
        $pageRecord = $pageInformation->getPageRecord();

        if ((int)$pageRecord['doktype'] === PageRepository::DOKTYPE_LINK) {
            $url = $pageRecord['url'] ?? '';
            $urlParts = parse_url($url);
            if (($urlParts['scheme'] ?? false) === 't3') {
                // It's a typolink that needs to be resolved.
                // TypoScript is available since this middleware runs after prepare-tsfe-rendering.
                $cObj = GeneralUtility::makeInstance(ContentObjectRenderer::class);
                $cObj->setRequest($request);

                if ($uri = $cObj->typoLink_URL(['parameter' => $url])) {
                    $pageRecord['url'] = $uri;
                    $pageInformation->setPageRecord($pageRecord);
                }
            }
        }

        return $handler->handle($request);
    }
}
