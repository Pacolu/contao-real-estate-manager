<?php
/**
 * Refer to LICENSE.txt distributed with the Real Estate bundle for notice of license
 */

namespace Pacolu\RealEstateBundle;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;

/**
 * Connects the bundle with the Contao Manager Plugin
 *
 * @author Benjamin Heuer <https://github.com/Pacolu>
 */
class ContaoManagerPlugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(PacoluRealEstateBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['real-estate-manager']),
        ];
    }
}
