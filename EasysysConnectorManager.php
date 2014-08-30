<?php

namespace Remdan\EasysysConnectorBundle;

use Doctrine\Common\Persistence\ObjectManager;
use EasysysConnector\Model\Resource\Kb\ResourceOrderInterface;
use EasysysConnector\Model\Resource\Kb\ResourcePositionCustomInterface;
use Ibrows\SyliusShopBundle\Model\Cart\CartInterface;
use EasysysConnector\EasysysConnector;
use EasysysConnector\Manager\Resource\ResourceManagerInterface;
use EasysysConnector\HttpAdapter\HttpParameterBag;
use EasysysConnector\HttpAdapter\HttpAdapterInterface;

class EasysysConnectorManager
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var EasysysConnector
     */
    protected $easysysConnector;

    /**
     * @param EasysysConnector $easysysConnector
     * @param ObjectManager $objectManager
     */
    function __construct(EasysysConnector $easysysConnector, ObjectManager $objectManager)
    {
        $this->easysysConnector = $easysysConnector;
        $this->objectManager = $objectManager;
    }

    /**
     * @param $resource
     * @return ResourceManagerInterface
     */
    public function get($resource)
    {
        return $this->easysysConnector->get($resource);
    }

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }
}