<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\HealthInsurance as ChildHealthInsurance;
use MocApi\Models\HealthInsuranceQuery as ChildHealthInsuranceQuery;
use MocApi\Models\Map\HealthInsuranceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.health_insurance' table.
 *
 *
 *
 * @method     ChildHealthInsuranceQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildHealthInsuranceQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildHealthInsuranceQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildHealthInsuranceQuery groupById() Group by the id column
 * @method     ChildHealthInsuranceQuery groupByName() Group by the name column
 * @method     ChildHealthInsuranceQuery groupByCreated() Group by the created column
 *
 * @method     ChildHealthInsuranceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildHealthInsuranceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildHealthInsuranceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildHealthInsuranceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildHealthInsuranceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildHealthInsuranceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildHealthInsuranceQuery leftJoinHealthInsuranceCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the HealthInsuranceCard relation
 * @method     ChildHealthInsuranceQuery rightJoinHealthInsuranceCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the HealthInsuranceCard relation
 * @method     ChildHealthInsuranceQuery innerJoinHealthInsuranceCard($relationAlias = null) Adds a INNER JOIN clause to the query using the HealthInsuranceCard relation
 *
 * @method     ChildHealthInsuranceQuery joinWithHealthInsuranceCard($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the HealthInsuranceCard relation
 *
 * @method     ChildHealthInsuranceQuery leftJoinWithHealthInsuranceCard() Adds a LEFT JOIN clause and with to the query using the HealthInsuranceCard relation
 * @method     ChildHealthInsuranceQuery rightJoinWithHealthInsuranceCard() Adds a RIGHT JOIN clause and with to the query using the HealthInsuranceCard relation
 * @method     ChildHealthInsuranceQuery innerJoinWithHealthInsuranceCard() Adds a INNER JOIN clause and with to the query using the HealthInsuranceCard relation
 *
 * @method     \MocApi\Models\HealthInsuranceCardQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildHealthInsurance findOne(ConnectionInterface $con = null) Return the first ChildHealthInsurance matching the query
 * @method     ChildHealthInsurance findOneOrCreate(ConnectionInterface $con = null) Return the first ChildHealthInsurance matching the query, or a new ChildHealthInsurance object populated from the query conditions when no match is found
 *
 * @method     ChildHealthInsurance findOneById(int $id) Return the first ChildHealthInsurance filtered by the id column
 * @method     ChildHealthInsurance findOneByName(string $name) Return the first ChildHealthInsurance filtered by the name column
 * @method     ChildHealthInsurance findOneByCreated(string $created) Return the first ChildHealthInsurance filtered by the created column *

 * @method     ChildHealthInsurance requirePk($key, ConnectionInterface $con = null) Return the ChildHealthInsurance by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHealthInsurance requireOne(ConnectionInterface $con = null) Return the first ChildHealthInsurance matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHealthInsurance requireOneById(int $id) Return the first ChildHealthInsurance filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHealthInsurance requireOneByName(string $name) Return the first ChildHealthInsurance filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHealthInsurance requireOneByCreated(string $created) Return the first ChildHealthInsurance filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHealthInsurance[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildHealthInsurance objects based on current ModelCriteria
 * @method     ChildHealthInsurance[]|ObjectCollection findById(int $id) Return ChildHealthInsurance objects filtered by the id column
 * @method     ChildHealthInsurance[]|ObjectCollection findByName(string $name) Return ChildHealthInsurance objects filtered by the name column
 * @method     ChildHealthInsurance[]|ObjectCollection findByCreated(string $created) Return ChildHealthInsurance objects filtered by the created column
 * @method     ChildHealthInsurance[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class HealthInsuranceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\HealthInsuranceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\HealthInsurance', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildHealthInsuranceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildHealthInsuranceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildHealthInsuranceQuery) {
            return $criteria;
        }
        $query = new ChildHealthInsuranceQuery();
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
     * @return ChildHealthInsurance|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = HealthInsuranceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(HealthInsuranceTableMap::DATABASE_NAME);
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
     * @return ChildHealthInsurance A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, created FROM moc.health_insurance WHERE id = :p0';
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
            /** @var ChildHealthInsurance $obj */
            $obj = new ChildHealthInsurance();
            $obj->hydrate($row);
            HealthInsuranceTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildHealthInsurance|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildHealthInsuranceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(HealthInsuranceTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildHealthInsuranceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(HealthInsuranceTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildHealthInsuranceQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(HealthInsuranceTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(HealthInsuranceTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HealthInsuranceTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildHealthInsuranceQuery The current query, for fluid interface
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

        return $this->addUsingAlias(HealthInsuranceTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildHealthInsuranceQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(HealthInsuranceTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(HealthInsuranceTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HealthInsuranceTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\HealthInsuranceCard object
     *
     * @param \MocApi\Models\HealthInsuranceCard|ObjectCollection $healthInsuranceCard the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHealthInsuranceQuery The current query, for fluid interface
     */
    public function filterByHealthInsuranceCard($healthInsuranceCard, $comparison = null)
    {
        if ($healthInsuranceCard instanceof \MocApi\Models\HealthInsuranceCard) {
            return $this
                ->addUsingAlias(HealthInsuranceTableMap::COL_ID, $healthInsuranceCard->getHealthInsuranceId(), $comparison);
        } elseif ($healthInsuranceCard instanceof ObjectCollection) {
            return $this
                ->useHealthInsuranceCardQuery()
                ->filterByPrimaryKeys($healthInsuranceCard->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByHealthInsuranceCard() only accepts arguments of type \MocApi\Models\HealthInsuranceCard or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the HealthInsuranceCard relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildHealthInsuranceQuery The current query, for fluid interface
     */
    public function joinHealthInsuranceCard($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('HealthInsuranceCard');

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
            $this->addJoinObject($join, 'HealthInsuranceCard');
        }

        return $this;
    }

    /**
     * Use the HealthInsuranceCard relation HealthInsuranceCard object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\HealthInsuranceCardQuery A secondary query class using the current class as primary query
     */
    public function useHealthInsuranceCardQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinHealthInsuranceCard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'HealthInsuranceCard', '\MocApi\Models\HealthInsuranceCardQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildHealthInsurance $healthInsurance Object to remove from the list of results
     *
     * @return $this|ChildHealthInsuranceQuery The current query, for fluid interface
     */
    public function prune($healthInsurance = null)
    {
        if ($healthInsurance) {
            $this->addUsingAlias(HealthInsuranceTableMap::COL_ID, $healthInsurance->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.health_insurance table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HealthInsuranceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            HealthInsuranceTableMap::clearInstancePool();
            HealthInsuranceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(HealthInsuranceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(HealthInsuranceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            HealthInsuranceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            HealthInsuranceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // HealthInsuranceQuery
