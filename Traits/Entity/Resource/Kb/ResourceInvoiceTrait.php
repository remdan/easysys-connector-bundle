<?php

namespace Remdan\EasysysConnectorBundle\Traits\Entity\Resource\Kb;

use Doctrine\ORM\Mapping as ORM;
use EasysysConnector\Model\Resource\Kb\ResourceInvoiceInterface;

trait ResourceInvoiceTrait
{
    /**
     * @var int
     * @ORM\Column(name="es_user_id", type="integer", nullable=true)
     */
    protected $esUserId;

    /**
     * @var int
     * @ORM\Column(name="es_contact_id", type="integer", nullable=true)
     */
    protected $esContactId;

    /**
     * @return string
     */
    public static function getEsResource()
    {
        return ResourceInvoiceInterface::RESOURCE;
    }

    /**
     * @return int
     */
    public function getEsUserId()
    {
        return $this->esUserId;
    }

    /**
     * @param null $userId
     * @return $this
     */
    public function setEsUserId($userId = null)
    {
        $this->esUserId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getEsContactId()
    {
        return $this->esContactId;
    }

    /**
     * @param null $esContactId
     * @return $this
     */
    public function setEsContactId($esContactId = null)
    {
        $this->esContactId = $esContactId;

        return $this;
    }
}