# TYPO3 Extension doktype_typolink

Enhances doktype 3 ("Link to External URL") to support typolinks. So there's no need for hard coded absolute URLs in menus anymore.

It's a tiny change in TCA but enables to BE users to use the power of the typolink link browser.

| Before | After |
| ------ | ----- |
| ![Before](./Resources/Public/Images/Before.png "Before") | ![After](./Resources/Public/Images/After.png "After") |

## Resolving the typolink

### Frontend rendering

Since [7.6](https://docs.typo3.org/c/typo3/cms-core/master/en-us/Changelog/7.6/Breaking-62812-ResolveMenuUrlsToLinkToExternalPagesDirectly.html) when rendering typolinks (and menus) during the FE rendering process the URLs of pages of doktype 3 are being automatically replaced by their (external) URL target.

This core mechanism also resolves any typolink that might by used as `url` property.

### Accessing the page URL

When accessing the page's URL directly (e.g. via save+show button in BE) the 303 redirect is still in place though.

To resolve any typolink within the `url` property in this case there's an experimental middleware that can be activated in the extension settings.
