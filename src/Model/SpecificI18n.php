<?php

/**
 * @copyright 2010-2015 JTL-Software GmbH
 * @package Jtl\Connector\Core\Model
 * @subpackage Product
 */

namespace Jtl\Connector\Core\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Localized name for specific.
 *
 * @access public
 * @package Jtl\Connector\Core\Model
 * @subpackage Product
 * @Serializer\AccessType("public_method")
 */
class SpecificI18n extends AbstractI18n
{
    /**
     * @var string Localized name
     * @Serializer\Type("string")
     * @Serializer\SerializedName("name")
     * @Serializer\Accessor(getter="getName",setter="setName")
     */
    protected $name = '';

    /**
     * @param string $name Localized name
     * @return SpecificI18n
     */
    public function setName(string $name): SpecificI18n
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string Localized name
     */
    public function getName(): string
    {
        return $this->name;
    }
}
