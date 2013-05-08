<?php
/**
 * @copyright 2010-2013 JTL-Software GmbH
 * @package jtl\Connector\Model
 */

namespace jtl\Connector\Model;

use \jtl\Core\Model\DataModel;

/**
 * ProductPrice Model
 * @access public
 */
abstract class ProductPrice extends DataModel
{
    /**
     * @var int
     */
    protected $_customerGroupId;
    
    /**
     * @var int
     */
    protected $_productId;
    
    /**
     * @var double
     */
    protected $_netPrice;
    
    /**
     * @var int
     */
    protected $_quantity;
    
    /**
     * ProductPrice Setter
     *
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value)
    {
        switch ($name) {
            case "_customerGroupId":
            case "_productId":
            case "_quantity":
            
                $this->$name = (int)$value;
                break;
        
            case "_netPrice":
            
                $this->$name = (double)$value;
                break;
        
        }
    }
    
    /**
     * ProductPrice Getter
     *
     * @param string $name
     */
    public function __get($name)
    {
        return $this->$name;
    }
}
?>