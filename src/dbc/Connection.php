<?php

declare(strict_types=1);

namespace Jtl\Connector\Dbc;

use Doctrine\DBAL\Exception;
use Jtl\Connector\Dbc\Query\QueryBuilder;
use Jtl\Connector\Dbc\Schema\TableRestriction;
use RuntimeException;

class Connection extends \Doctrine\DBAL\Connection
{
    /** @var array<string, array<string, mixed>> */
    protected array $tableRestrictions = [];

    /**
     * @return void
     */
    public function clearTableRestrictions(): void
    {
        $this->tableRestrictions = [];
    }

    /**
     * @param TableRestriction $restriction
     *
     * @return $this
     */
    public function restrictTable(TableRestriction $restriction): self
    {
        $this->tableRestrictions[$restriction->getTable()->getName()][$restriction->getColumnName()] =
            $restriction->getColumnValue();

        return $this;
    }

    /**
     * @param string $tableExpression
     * @param string $column
     *
     * @return bool
     */
    public function hasTableRestriction(string $tableExpression, string $column): bool
    {
        return isset($this->tableRestrictions[$tableExpression][$column]);
    }

    /**
     * @return QueryBuilder
     */
    public function createQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this, $this->getTableRestrictions());
    }

    /**
     * @param string|null $tableExpression
     *
     * @return array<string, mixed>|array<string, array<string, mixed>>
     */
    public function getTableRestrictions(?string $tableExpression = null): array
    {
        if ($tableExpression === null) {
            return $this->tableRestrictions;
        }

        if (!isset($this->tableRestrictions[$tableExpression])) {
            $this->tableRestrictions[$tableExpression] = [];
        }

        return $this->tableRestrictions[$tableExpression];
    }

    /**
     * @param string                                                   $tableExpression
     * @param array<int, array<int|string, scalar|\DateTimeInterface>> $data
     * @param string[]                                                 $types
     *
     * @return int
     * @throws \Exception
     */
    public function multiInsert(string $tableExpression, array $data, array $types = []): int
    {
        $affectedRows = 0;
        $this->beginTransaction();
        try {
            foreach ($data as $row) {
                $affectedRows += $this->insert($tableExpression, $row, $types);
            }
            $this->commit();
        } catch (\Exception $e) {
            $this->rollback();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * @param string   $table
     * @param mixed[]  $data
     * @param string[] $types
     *
     * @return int|string
     * @throws Exception
     * @throws DbcRuntimeException|\RuntimeException
     */
    public function insert(string $table, array $data, array $types = []): int|string
    {
        return parent::insert(
            $table,
            \array_merge($data, $this->getTableRestrictions($table)),
            $types
        );
    }

    /**
     * @param string   $table
     * @param mixed[]  $data
     * @param mixed[]  $criteria
     * @param string[] $types
     *
     * @return int|string
     * @throws Exception
     * @throws DbcRuntimeException|\RuntimeException
     */
    public function update(string $table, array $data, array $criteria = [], array $types = []): int|string
    {
        $restrictions = $this->getTableRestrictions($table);
        $data         = \array_merge($data, $restrictions);
        $criteria     = \array_merge($criteria, $restrictions);

        return parent::update($table, $data, $criteria, $types);
    }

    /**
     * @param string   $table
     * @param mixed[]  $criteria
     * @param string[] $types
     *
     * @return int|string
     * @throws Exception
     * @throws DbcRuntimeException|\RuntimeException
     */
    public function delete(string $table, array $criteria = [], array $types = []): int|string
    {
        $restrictions = $this->getTableRestrictions($table);
        $criteria     = \array_merge($criteria, $restrictions);

        return parent::delete($table, $criteria, $types);
    }
}
