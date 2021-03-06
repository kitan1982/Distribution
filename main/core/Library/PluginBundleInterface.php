<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Library;

use Claroline\InstallationBundle\Bundle\InstallableInterface;
use Claroline\KernelBundle\Bundle\AutoConfigurableInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Interface of all the plugin bundles on the claroline platform.
 */
interface PluginBundleInterface extends BundleInterface, AutoConfigurableInterface, InstallableInterface
{
    function getVendorName();
    function getBundleName();
    function getConfigFile();
    function getImgFolder();
    function getAssetsFolder();
}
