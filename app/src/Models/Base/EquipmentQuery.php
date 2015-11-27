<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\Equipment as ChildEquipment;
use MocApi\Models\EquipmentQuery as ChildEquipmentQuery;
use MocApi\Models\Map\EquipmentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.equipment' table.
 *
 *
 *
 * @method     ChildEquipmentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildEquipmentQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildEquipmentQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildEquipmentQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 * @method     ChildEquipmentQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildEquipmentQuery groupById() Group by the id column
 * @method     ChildEquipmentQuery groupByName() Group by the name column
 * @method     ChildEquipmentQuery groupByDescription() Group by the description column
 * @method     ChildEquipmentQuery groupByQuantity() Group by the quantity column
 * @method     ChildEquipmentQuery groupByCreated() Group by the created column
 *
 * @method     ChildEquipmentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEquipmentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEquipmentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEquipmentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEquipmentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEquipmentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEquipmentQuery leftJoinSurgeryEquipment($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeryEquipment relation
 * @method     ChildEquipmentQuery rightJoinSurgeryEquipment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeryEquipment relation
 * @method     ChildEquipmentQuery innerJoinSurgeryEquipment($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeryEquipment relation
 *
 * @method     ChildEquipmentQuery joinWithSurgeryEquipment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeryEquipment relation
 *
 * @method     ChildEquipmentQuery leftJoinWithSurgeryEquipment() Adds a LEFT JOIN clause and with to the query using the SurgeryEquipment relation
 * @method     ChildEquipmentQuery rightJoinWithSurgeryEquipment() Adds a RIGHT JOIN clause and with to the query using the SurgeryEquipment relation
 * @method     ChildEquipmentQuery innerJoinWithSurgeryEquipment() Adds a INNER JOIN clause and with to the query using the SurgeryEquipment relation
 *
 * @method     \MocApi\Models\SurgeryEquipmentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEquipment findOne(ConnectionInterface $con = null) Return the first ChildEquipment matching the query
 * @method     ChildEquipment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEquipment matching the query, or a new ChildEquipment object populated from the query conditions when no match is found
 *
 * @method     ChildEquipment findOneById(int $id) Return the first ChildEquipment filtered by the id column
 * @method     ChildEquipment findOneByName(string $name) Return the first ChildEquipment filtered by the name column
 * @method     ChildEquipment findOneByDescription(string $description) Return the first ChildEquipment filtered by the description column
 * @method     ChildEquipment findOneByQuantity(int $quantity) Return the first ChildEquipment filtered by the quantity column
 * @method     ChildEquipment findOneByCreated(string $created) Return the first ChildEquipment filtered by the created column *

 * @method     ChildEquipment requirePk($key, ConnectionInterface $con = null) Return the ChildEquipment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEquipment requireOne(ConnectionInterface $con = null) Return the first ChildEquipment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEquipment requireOneById(int $id) Return the first ChildEquipment filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEquipment requireOneByName(string $name) Return the first ChildEquipment filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEquipment requireOneByDescription(string $description) Return the first ChildEquipment filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEquipment requireOneByQuantity(int $quantity) Return the first ChildEquipment filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEquipment requireOneByCreated(string $created) Return the first ChildEquipment filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEquipment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEquipment objects based on current ModelCriteria
 * @method     ChildEquipment[]|ObjectCollection findById(int $id) Return ChildEquipment objects filtered by the id column
 * @method     ChildEquipment[]|ObjectCollection findByName(string $name) Return ChildEquipment objects filtered by the name column
 * @method     ChildEquipment[]|ObjectCollection findByDescription(string $description) Return ChildEquipment objects filtered by the description column
 * @method     ChildEquipment[]|ObjectCollection findByQuantity(int $quantity) Return ChildEquipment objects filtered by the quantity column
 * @method     ChildEquipment[]|ObjectCollection findByCreated(string $created) Return ChildEquipment objects filtered by the created column
 * @method     ChildEquipment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EquipmentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\EquipmentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\Equipment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEquipmentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEquipmentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEquipmentQuery) {
            return $criteria;
        }
        $query = new ChildEquipmentQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildEquipment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = EquipmentTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EquipmentTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEquipment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, description, quantity, created FROM moc.equipment WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildEquipment $obj */
            $obj = new ChildEquipment();
            $obj->hydrate($row);
            EquipmentTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildEquipment|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildEquipmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EquipmentTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEquipmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EquipmentTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEquipmentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(EquipmentTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(EquipmentTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EquipmentTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEquipmentQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EquipmentTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEquipmentQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EquipmentTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity > 12
     * </code>
     *
     * @param     mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEquipmentQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(EquipmentTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(EquipmentTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EquipmentTableMap::COL_QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query on the created column
     *
     * Example usage:
     * <code>
     * $query->filterByCreated('2011-03-14'); // WHERE created = '2011-03-14'
     * $query->filterByCreated('now'); // WHERE created = '2011-03-14'
     * $query->filterByCreated(array('max' => 'yesterday')); // WHERE created > '2011-03-13'
     * </code>
     *
     * @param     mixed $created The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEquipmentQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(EquipmentTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(EquipmentTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EquipmentTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\SurgeryEquipment object
     *
     * @param \MocApi\Models\SurgeryEquipment|ObjectCollection $surgeryEquipment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEquipmentQuery The current query, for fluid interface
     */
    public function filterBySurgeryEquipment($surgeryEquipment, $comparison = null)
    {
        if ($surgeryEquipment instanceof \MocApi\Models\SurgeryEquipment) {
            return $this
                ->addUsingAlias(EquipmentTableMap::COL_ID, $surgeryEquipment->getEquipmentId(), $comparison);
        } elseif ($surgeryEquipment instanceof ObjectCollection) {
            return $this
                ->useSurgeryEquipmentQuery()
                ->filterByPrimaryKeys($surgeryEquipment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySurgeryEquipment() only accepts arguments of type \MocApi\Models\SurgeryEquipment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SurgeryEquipment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEquipmentQuery The current query, for fluid interface
     */
    public function joinSurgeryEquipment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SurgeryEquipment');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'SurgeryEquipment');
        }

        return $this;
    }

    /**
     * Use the SurgeryEquipment relation SurgeryEquipment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\SurgeryEquipmentQuery A secondary query class using the current class as primary query
     */
    public function useSurgeryEquipmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSurgeryEquipment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SurgeryEquipment', '\MocApi\Models\SurgeryEquipmentQuery');
    }

    /**
     * Filter the query by a related Surgery object
     * using the moc.surgery_equipment table as cross reference
     *
     * @param Surgery $surgery the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEquipmentQuery The current query, for fluid interface
     */
    public function filterBySurgery($surgery, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useSurgeryEquipmentQuery()
            ->filterBySurgery($surgery, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEquipment $equipment Object to remove from the list of results
     *
     * @return $this|ChildEquipmentQuery The current query, for fluid interface
     */
    public function prune($equipment = null)
    {
        if ($equipment) {
            $this->addUsingAlias(EquipmentTableMap::COL_ID, $equipment->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.equipment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EquipmentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EquipmentTableMap::clearInstancePool();
            EquipmentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EquipmentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EquipmentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EquipmentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EquipmentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EquipmentQuery
