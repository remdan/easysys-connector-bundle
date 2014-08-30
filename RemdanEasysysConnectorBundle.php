<?php

namespace Remdan\EasysysConnectorBundle;

use Remdan\EasysysConnectorBundle\CompilerPass\ResourceManagerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RemdanEasysysConnectorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ResourceManagerCompilerPass());
    }
}