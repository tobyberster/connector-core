<?php

/**
 * @copyright 2010-2015 JTL-Software GmbH
 * @package Jtl\Connector\Core\Model
 * @subpackage Product
 */

namespace Jtl\Connector\Core\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Shipping classes are usually defined in JTL-Wawi ERP.
 *
 * @access public
 * @package Jtl\Connector\Core\Model
 * @subpackage Product
 * @Serializer\AccessType("public_method")
 */
class ShippingClass extends AbstractIdentity
{
    /**
     * @var string Optional (internal) Shipping class name
     * @Serializer\Type("string")
     * @Serializer\SerializedName("name")
     * @Serializer\Accessor(getter="getName",setter="setName")
     */
    protected $name = '';

    /**
     * @param string $name Optional (internal) Shipping class name
     * @return ShippingClass
     */
    public function setName(string $name): ShippingClass
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string Optional (internal) Shipping class name
     */
    public function getName(): string
    {
        return $this->name;
    }
}
