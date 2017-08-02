<?php
namespace Flowpack\CacheBuster\Aspects;

/*
 * This file is part of the Flowpack.CacheBuster package.
 *
 * (c) Contributors of the Flowpack Team - flowpack.org
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Aop\JoinPointInterface;

/**
 * @Flow\Aspect
 */
class CacheBusterAspect
{
    /**
     * @Flow\Around("method(Neos\Flow\ResourceManagement\ResourceManager->getPublicPackageResourceUri())")
     *
     * @param JoinPointInterface $joinPoint The current joinpoint
     *
     * @return string The modified public resource uri with appended sha1 hash as parameter
     */
    public function addCacheHash(JoinPointInterface $joinPoint)
    {
        $result = $joinPoint->getAdviceChain()->proceed($joinPoint);

        $packageKey = $joinPoint->getMethodArgument('packageKey');
        $relativePathAndFilename = $joinPoint->getMethodArgument('relativePathAndFilename');

        return $this->getModifiedResourceUri($result, $relativePathAndFilename, $packageKey);
    }

    /**
     * @param string $uri
     * @param string $path
     * @param string $package
     * @return string
     */
    protected function getModifiedResourceUri($uri, $path, $package)
    {
        if (strpos($path, 'resource://') === 0) {
            $resourcePath = $path;
        } elseif ($package !== null) {
            $resourcePath = 'resource://' . $package . '/Public/' . $path;
        } else {
            return $uri;
        }

        if (!is_dir($resourcePath) && strpos($uri, 'bust') === false) {
            try {
                $hash = 'bust=' . substr(sha1_file($resourcePath), 0, 8);

                if (strpos($uri, '?') === false) {
                    return $uri . '?' . $hash;
                } else {
                    return $uri . '&' . $hash;
                }
            } catch (\Exception $e) {
            }
        }
        return $uri;
    }
}
