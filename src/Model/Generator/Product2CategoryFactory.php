<?php

namespace Jtl\Connector\Core\Model\Generator;

use Jtl\Connector\Core\Definition\IdentityType;
use Jtl\Connector\Core\Model\Product2Category;

class Product2CategoryFactory extends AbstractModelFactory
{
    /**
     * @return array
     * @throws \Exception
     */
    protected function makeFakeArray(): array
    {
        return [
            'id' => $this->makeIdentityArray(IdentityType::PRODUCT_TO_CATEGORY),
            'categoryId' => $this->makeIdentityArray(IdentityType::CATEGORY)
        ];
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Product2Category::class;
    }
}
