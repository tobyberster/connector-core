<?php

declare(strict_types=1);

namespace Jtl\Connector\Dbc\Query;

use Jtl\Connector\Dbc\Connection;

class QueryBuilder extends \Doctrine\DBAL\Query\QueryBuilder
{
    /** @var array{empty}|array<string, array<string, mixed>>|array<string, mixed> */
    protected array   $tableRestrictions = [];
    protected ?string $fromTable;
    protected ?string $fromAlias;

    private string $currentType = 'select';

    /** @var string[] */
    private array $usedTables = [];

    private bool $restrictionsApplied = false;

    /**
     * QueryBuilder constructor.
     *
     * @param Connection                                                            $connection
     * @param array{empty}|array<string, mixed>|array<string, array<string, mixed>> $tableRestrictions
     * @param string|null                                                           $fromTable
     * @param string|null                                                           $fromAlias
     */
    public function __construct(
        Connection $connection,
        array      $tableRestrictions = [],
        ?string    $fromTable = null,
        ?string    $fromAlias = null
    ) {
        parent::__construct($connection);
        $this->tableRestrictions = $tableRestrictions;
        $this->fromTable         = $fromTable;
        $this->fromAlias         = $fromAlias;
    }

    /**
     * @param string ...$expressions
     * @return $this
     */
    public function select(string ...$expressions): static
    {
        $this->currentType = 'select';
        return parent::select(...$expressions);
    }

    /**
     * @param string $table
     * @return $this
     */
    public function insert(string $table = ''): static
    {
        $this->currentType = 'insert';
        $actualTable       = $this->fromTable ?? $table;
        if ($actualTable !== '') {
            $this->usedTables[] = $actualTable;
        }
        return parent::insert($actualTable !== '' ? $actualTable : $table);
    }

    /**
     * @param string $table
     * @return $this
     */
    public function update(string $table = ''): static
    {
        $this->currentType = 'update';
        $actualTable       = $this->fromTable ?? $table;
        $tableExpression   = $actualTable;
        if ($this->fromTable !== null && $this->fromAlias !== null) {
            $tableExpression = $actualTable . ' ' . $this->fromAlias;
        }
        if ($actualTable !== '') {
            $this->usedTables[] = $actualTable;
        }
        return parent::update($tableExpression !== '' ? $tableExpression : $table);
    }

    /**
     * @param string $table
     * @return $this
     */
    public function delete(string $table = ''): static
    {
        $this->currentType = 'delete';
        $actualTable       = $this->fromTable ?? $table;
        $tableExpression   = $actualTable;
        if ($this->fromTable !== null && $this->fromAlias !== null) {
            $tableExpression = $actualTable . ' ' . $this->fromAlias;
        }
        if ($actualTable !== '') {
            $this->usedTables[] = $actualTable;
        }
        return parent::delete($tableExpression !== '' ? $tableExpression : $table);
    }

    /**
     * @param string      $table
     * @param string|null $alias
     * @return $this
     */
    public function from(string $table, ?string $alias = null): static
    {
        $actualTable = $this->fromTable ?? $table;
        $actualAlias = $this->fromTable !== null ? $this->fromAlias : $alias;
        $this->usedTables[] = $actualTable;
        return parent::from($actualTable, $actualAlias);
    }

    /**
     * @return string
     */
    public function getSQL(): string
    {
        if (!$this->restrictionsApplied) {
            // For select queries with a locked fromTable that hasn't been added via from() yet
            if ($this->fromTable !== null && $this->currentType === 'select' && empty($this->usedTables)) {
                $this->from($this->fromTable, $this->fromAlias);
            }

            foreach (\array_unique($this->usedTables) as $table) {
                $this->assignTableRestrictions($table);
            }
            $this->restrictionsApplied = true;
        }

        return parent::getSQL();
    }

    /**
     * @param string $table
     *
     * @return void
     */
    protected function assignTableRestrictions(string $table): void
    {
        if (isset($this->tableRestrictions[$table]) && \is_array($this->tableRestrictions[$table])) {
            foreach ($this->tableRestrictions[$table] as $column => $value) {
                $id = 'glob_id_' . $column;
                $this->setParameter($id, $value);
                $this->setValue($column, ':' . $id);
                $this->set($column, ':' . $id);
                $whereCondition = $column . ' = :' . $id;
                $this->andWhere($whereCondition);
            }
        }
    }
}
