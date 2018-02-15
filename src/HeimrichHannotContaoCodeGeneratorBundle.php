<?php

namespace HeimrichHannot\CodeGeneratorBundle;

use HeimrichHannot\CodeGeneratorBundle\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotContaoCodeGeneratorBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new Extension();
    }
}
