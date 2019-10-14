<?php
/**
 * @copyright 2010-2015 JTL-Software GmbH
 * @package jtl\Connector\Model
 * @subpackage Product
 */

namespace jtl\Connector\Model;

use DateTime;
use JMS\Serializer\Annotation as Serializer;

/**
 * Config group holds several configItems and settings
 *
 * @access public
 * @package jtl\Connector\Model
 * @subpackage Product
 * @Serializer\AccessType("public_method")
 */
class ConfigGroup extends DataModel
{
    /**
     * @var Identity Unique configGroup id
     * @Serializer\Type("jtl\Connector\Model\Identity")
     * @Serializer\SerializedName("id")
     * @Serializer\Accessor(getter="getId",setter="setId")
     */
    protected $id = null;
    
    /**
     * @var string Optional internal comment to differantiate config groups by comment name
     * @Serializer\Type("string")
     * @Serializer\SerializedName("comment")
     * @Serializer\Accessor(getter="getComment",setter="setComment")
     */
    protected $comment = '';
    
    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("imagePath")
     * @Serializer\Accessor(getter="getImagePath",setter="setImagePath")
     */
    protected $imagePath = '';
    
    /**
     * @var integer Optional maximum number allowed selections. Default 0 for no maximum limitation.
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("maximumSelection")
     * @Serializer\Accessor(getter="getMaximumSelection",setter="setMaximumSelection")
     */
    protected $maximumSelection = 0;
    
    /**
     * @var integer Optional minimum number required selections. Default 0 for no minimum requirement.
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("minimumSelection")
     * @Serializer\Accessor(getter="getMinimumSelection",setter="setMinimumSelection")
     */
    protected $minimumSelection = 0;
    
    /**
     * @var integer Optional sort order number
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("sort")
     * @Serializer\Accessor(getter="getSort",setter="setSort")
     */
    protected $sort = 0;
    
    /**
     * @var integer Config group item type. 0: Checkbox, 1:Radio, 2, Dropdown, 3: Multiselect
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("type")
     * @Serializer\Accessor(getter="getType",setter="setType")
     */
    protected $type = 0;
    
    /**
     * @var \jtl\Connector\Model\ConfigGroupI18n[]
     * @Serializer\Type("array<jtl\Connector\Model\ConfigGroupI18n>")
     * @Serializer\SerializedName("i18ns")
     * @Serializer\AccessType("reflection")
     */
    protected $i18ns = [];
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = new Identity();
    }
    
    /**
     * @param Identity $id Unique configGroup id
     * @return \jtl\Connector\Model\ConfigGroup
     * @throws \InvalidArgumentException if the provided argument is not of type 'Identity'.
     */
    public function setId(Identity $id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return Identity Unique configGroup id
     */
    public function getId(): Identity
    {
        return $this->id;
    }
    
    /**
     * @param string $comment Optional internal comment to differantiate config groups by comment name
     * @return \jtl\Connector\Model\ConfigGroup
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        
        return $this;
    }
    
    /**
     * @return string Optional internal comment to differantiate config groups by comment name
     */
    public function getComment()
    {
        return $this->comment;
    }
    
    /**
     * @param string $imagePath
     * @return \jtl\Connector\Model\ConfigGroup
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }
    
    /**
     * @param integer $maximumSelection Optional maximum number allowed selections. Default 0 for no maximum limitation.
     * @return \jtl\Connector\Model\ConfigGroup
     */
    public function setMaximumSelection($maximumSelection)
    {
        $this->maximumSelection = $maximumSelection;
        
        return $this;
    }
    
    /**
     * @return integer Optional maximum number allowed selections. Default 0 for no maximum limitation.
     */
    public function getMaximumSelection()
    {
        return $this->maximumSelection;
    }
    
    /**
     * @param integer $minimumSelection Optional minimum number required selections. Default 0 for no minimum requirement.
     * @return \jtl\Connector\Model\ConfigGroup
     */
    public function setMinimumSelection($minimumSelection)
    {
        $this->minimumSelection = $minimumSelection;
        
        return $this;
    }
    
    /**
     * @return integer Optional minimum number required selections. Default 0 for no minimum requirement.
     */
    public function getMinimumSelection()
    {
        return $this->minimumSelection;
    }
    
    /**
     * @param integer $sort Optional sort order number
     * @return \jtl\Connector\Model\ConfigGroup
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        
        return $this;
    }
    
    /**
     * @return integer Optional sort order number
     */
    public function getSort()
    {
        return $this->sort;
    }
    
    /**
     * @param integer $type Config group item type. 0: Checkbox, 1:Radio, 2, Dropdown, 3: Multiselect
     * @return \jtl\Connector\Model\ConfigGroup
     */
    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return integer Config group item type. 0: Checkbox, 1:Radio, 2, Dropdown, 3: Multiselect
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @param \jtl\Connector\Model\ConfigGroupI18n $i18n
     * @return \jtl\Connector\Model\ConfigGroup
     */
    public function addI18n(\jtl\Connector\Model\ConfigGroupI18n $i18n)
    {
        $this->i18ns[] = $i18n;
        
        return $this;
    }
    
    /**
     * @param array $i18ns
     * @return \jtl\Connector\Model\ConfigGroup
     */
    public function setI18ns(array $i18ns)
    {
        $this->i18ns = $i18ns;
        
        return $this;
    }
    
    /**
     * @return \jtl\Connector\Model\ConfigGroupI18n[]
     */
    public function getI18ns()
    {
        return $this->i18ns;
    }
    
    /**
     * @return \jtl\Connector\Model\ConfigGroup
     */
    public function clearI18ns()
    {
        $this->i18ns = [];
        
        return $this;
    }
}
