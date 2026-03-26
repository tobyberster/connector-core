<?php

declare(strict_types=1);

namespace Jtl\Connector\Dbc\Types;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class Uuid4Type extends Type
{
    public const
        NAME = 'uuid4';

    /**
     * @param mixed[]          $column
     * @param AbstractPlatform $platform
     *
     * @return string
     * @throws Exception
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        $column['length'] = 16;
        $column['fixed']  = true;

        return $platform->getBinaryTypeDeclarationSQL($column);
    }

    /**
     * @phpstan-param string   $value
     *
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): string
    {
        return \ctype_xdigit(\str_replace('-', '', $value)) ? $value : \bin2hex($value);
    }

    /**
     * @phpstan-param string   $value
     *
     * @param mixed            $value
     * @param AbstractPlatform $platform
     *
     * @return string
     * @throws ConversionException
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        $converted = \hex2bin(\str_replace('-', '', $value));
        if ($converted === false) {
            throw new ConversionException(\sprintf('Could not convert value "%s" to type "%s". Expected UUIDv4 string.', (string)$value, self::NAME));
        }

        return $converted;
    }

    /**
     * @param string           $sqlExpr
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToPHPValueSQL(string $sqlExpr, AbstractPlatform $platform): string
    {
        if ($platform instanceof AbstractMySQLPlatform || $platform instanceof SQLitePlatform) {
            return \sprintf('LOWER(HEX(%s))', $sqlExpr);
        }

        return $sqlExpr;
    }

}
