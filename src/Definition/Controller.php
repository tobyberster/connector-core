<?php

declare(strict_types=1);

namespace Jtl\Connector\Core\Definition;

final class Controller
{
    public const
        CATEGORY            = 'Category',
        CONNECTOR           = 'Connector',
        CROSSSELLING        = 'CrossSelling',
        CUSTOMER            = 'Customer',
        CUSTOMER_ORDER      = 'CustomerOrder',
        DELIVERY_NOTE       = 'DeliveryNote',
        GLOBAL_DATA         = 'GlobalData',
        IMAGE               = 'Image',
        MANUFACTURER        = 'Manufacturer',
        PAYMENT             = 'Payment',
        PRODUCT             = 'Product',
        PRODUCT_PRICE       = 'ProductPrice',
        PRODUCT_STOCK_LEVEL = 'ProductStockLevel',
        SPECIFIC            = 'Specific',
        STATUS_CHANGE       = 'StatusChange';

    /**
     * @var string[]|null
     */
    protected static ?array $controllers = null;

    /**
     * @param string $controllerName
     *
     * @return boolean
     */
    public static function isController(string $controllerName): bool
    {
        return \in_array($controllerName, self::getControllers(), true);
    }

    /**
     * @return integer[]
     */
    public static function getControllers(): array
    {
        if (\is_null(self::$controllers)) {
            self::$controllers = (new \ReflectionClass(self::class))->getConstants();
        }

        return self::$controllers;
    }
}
