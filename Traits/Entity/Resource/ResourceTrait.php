<?php

namespace Remdan\EasysysConnectorBundle\Traits\Entity\Resource;

use Doctrine\ORM\Mapping as ORM;
use EasysysConnector\Model\Resource\ResourceInterface;

trait ResourceTrait
{
    /**
     * @var int
     * @ORM\Column(name="es_id", type="integer", nullable=true)
     */
    protected $esId;

    /**
     * @return int
     */
    public function getEsId()
    {
        return $this->esId;
    }

    /**
     * @param null $id
     * @return $this
     */
    public function setEsId($id = null)
    {
        $this->esId = $id;

        return $this;
    }

    /**
     * @return ResourceInterface
     */
    public function getResourceParent()
    {
        return null;
    }
}