<?php

namespace Remdan\EasysysConnectorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Remdan\EasysysConnectorBundle\DependencyInjection\Configuration;
use EasysysConnector\EasysysConnector;

class RemdanEasysysConnectorExtension extends Extension
{
    /**
     * @param ContainerBuilder
     */
    protected $container;

    /**
     * @param Array
     */
    protected $config;

    /**
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerBuilder $container
     * @return $this
     */
    public function setContainer(ContainerBuilder $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config = array())
    {
        $this->config = $config;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->setContainer($container);

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $this->setConfig($config);

        $loader = new Loader\XmlFileLoader($this->getContainer(), new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('easysys_connector.xml');
        $loader->load('services.xml');

        $this->getContainer()->setParameter('remdan_easysys_connector.auth.token.company', $config['auth']['token']['company']);
        $this->getContainer()->setParameter('remdan_easysys_connector.auth.token.public_key', $config['auth']['token']['public_key']);
        $this->getContainer()->setParameter('remdan_easysys_connector.auth.token.signature_key', $config['auth']['token']['signature_key']);
        $this->getContainer()->setParameter('remdan_easysys_connector.auth.token.user_id', $config['auth']['token']['user_id']);

        $this->getContainer()->setAlias('remdan.easysysconnector.http_adapter', $config['http_adapter']);
        $this->getContainer()->setAlias('remdan.easysysconnector.auth_adapter', $config['auth_adapter']);

        foreach ($config['resource_manager'] as $key => $manager) {
            $this->createResourceManager($key, $manager);
        }
    }

    /**
     * @param $authAdapter
     * @param $httpAdapter
     */
    public function createEasysysConnector($authAdapter, $httpAdapter)
    {
        $this->getContainer()->get('remdan.easysysconnector')
            ->addArgument(new Reference($httpAdapter))
            ->addArgument(new Reference($authAdapter));
    }

    /**
     *
     */
    public function createResourceManager($key, $manager)
    {
        $this->getContainer()
            ->register('remdan.easysysconnector.resource_manager.' . $key, $manager['class'])
            ->addArgument(new Reference($manager['converter']))
            ->addTag('remdan.easysysconnector.resource_manager', array('type' => 'service'));
    }
}
