<?php

namespace HeimrichHannot\CodeGeneratorBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * Class Plugin
 *
 * @package HeimrichHannot\CodeGeneratorBundle\ContaoManager
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create('HeimrichHannot\CodeGeneratorBundle\HeimrichHannotContaoCodeGeneratorBundle')
                ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}
