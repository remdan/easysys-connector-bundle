<?php

namespace Remdan\EasysysConnectorBundle\Traits\Entity\Resource\Kb;

use EasysysConnector\Model\Resource\Kb\ResourcePositionCustomInterface;

trait ResourcePositionCustomTrait
{
    /**
     * @var float
     * @ORM\Column(name="es_amount", type="decimal", nullable=true)
     */
    protected $esAmount;

    /**
     * @var float
     * @ORM\Column(name="es_unit_price", type="decimal", nullable=true)
     */
    protected $esUnitPrice;

    /**
     * @var int
     * @ORM\Column(name="es_tax_id", type="decimal", nullable=true)
     */
    protected $esTaxId;


    /**
     * @return string
     */
    public static function getEsResource()
    {
        return ResourcePositionCustomInterface::RESOURCE;
    }

    /**
     * @return int
     */
    public function getEsAmount()
    {
        return $this->esAmount;
    }

    /**
     * @param null $amount
     * @return $this
     */
    public function setEsAmount($amount = null)
    {
        $this->esAmount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getEsUnitPrice()
    {
        return $this->esUnitPrice;
    }

    /**
     * @param null $unitPrice
     * @return $this
     */
    public function setEsUnitPrice($unitPrice = null)
    {
        $this->esUnitPrice = $unitPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getEsTaxId()
    {
        return $this->esTaxId;
    }

    /**
     * @param null $taxId
     * @return $this
     */
    public function setEsTaxId($taxId = null)
    {
        $this->esTaxId = $taxId;

        return $this;
    }
}