<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\SurgeryFieldValue as ChildSurgeryFieldValue;
use MocApi\Models\SurgeryFieldValueQuery as ChildSurgeryFieldValueQuery;
use MocApi\Models\Map\SurgeryFieldValueTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.surgery_field_value' table.
 *
 *
 *
 * @method     ChildSurgeryFieldValueQuery orderBySurgeryFieldId($order = Criteria::ASC) Order by the surgery_field_id column
 * @method     ChildSurgeryFieldValueQuery orderBySurgeryId($order = Criteria::ASC) Order by the surgery_id column
 * @method     ChildSurgeryFieldValueQuery orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method     ChildSurgeryFieldValueQuery groupBySurgeryFieldId() Group by the surgery_field_id column
 * @method     ChildSurgeryFieldValueQuery groupBySurgeryId() Group by the surgery_id column
 * @method     ChildSurgeryFieldValueQuery groupByValue() Group by the value column
 *
 * @method     ChildSurgeryFieldValueQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSurgeryFieldValueQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSurgeryFieldValueQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSurgeryFieldValueQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSurgeryFieldValueQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSurgeryFieldValueQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSurgeryFieldValueQuery leftJoinSurgeryField($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeryField relation
 * @method     ChildSurgeryFieldValueQuery rightJoinSurgeryField($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeryField relation
 * @method     ChildSurgeryFieldValueQuery innerJoinSurgeryField($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeryField relation
 *
 * @method     ChildSurgeryFieldValueQuery joinWithSurgeryField($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeryField relation
 *
 * @method     ChildSurgeryFieldValueQuery leftJoinWithSurgeryField() Adds a LEFT JOIN clause and with to the query using the SurgeryField relation
 * @method     ChildSurgeryFieldValueQuery rightJoinWithSurgeryField() Adds a RIGHT JOIN clause and with to the query using the SurgeryField relation
 * @method     ChildSurgeryFieldValueQuery innerJoinWithSurgeryField() Adds a INNER JOIN clause and with to the query using the SurgeryField relation
 *
 * @method     ChildSurgeryFieldValueQuery leftJoinSurgery($relationAlias = null) Adds a LEFT JOIN clause to the query using the Surgery relation
 * @method     ChildSurgeryFieldValueQuery rightJoinSurgery($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Surgery relation
 * @method     ChildSurgeryFieldValueQuery innerJoinSurgery($relationAlias = null) Adds a INNER JOIN clause to the query using the Surgery relation
 *
 * @method     ChildSurgeryFieldValueQuery joinWithSurgery($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Surgery relation
 *
 * @method     ChildSurgeryFieldValueQuery leftJoinWithSurgery() Adds a LEFT JOIN clause and with to the query using the Surgery relation
 * @method     ChildSurgeryFieldValueQuery rightJoinWithSurgery() Adds a RIGHT JOIN clause and with to the query using the Surgery relation
 * @method     ChildSurgeryFieldValueQuery innerJoinWithSurgery() Adds a INNER JOIN clause and with to the query using the Surgery relation
 *
 * @method     \MocApi\Models\SurgeryFieldQuery|\MocApi\Models\SurgeryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSurgeryFieldValue findOne(ConnectionInterface $con = null) Return the first ChildSurgeryFieldValue matching the query
 * @method     ChildSurgeryFieldValue findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSurgeryFieldValue matching the query, or a new ChildSurgeryFieldValue object populated from the query conditions when no match is found
 *
 * @method     ChildSurgeryFieldValue findOneBySurgeryFieldId(int $surgery_field_id) Return the first ChildSurgeryFieldValue filtered by the surgery_field_id column
 * @method     ChildSurgeryFieldValue findOneBySurgeryId(int $surgery_id) Return the first ChildSurgeryFieldValue filtered by the surgery_id column
 * @method     ChildSurgeryFieldValue findOneByValue(string $value) Return the first ChildSurgeryFieldValue filtered by the value column *

 * @method     ChildSurgeryFieldValue requirePk($key, ConnectionInterface $con = null) Return the ChildSurgeryFieldValue by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeryFieldValue requireOne(ConnectionInterface $con = null) Return the first ChildSurgeryFieldValue matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSurgeryFieldValue requireOneBySurgeryFieldId(int $surgery_field_id) Return the first ChildSurgeryFieldValue filtered by the surgery_field_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeryFieldValue requireOneBySurgeryId(int $surgery_id) Return the first ChildSurgeryFieldValue filtered by the surgery_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeryFieldValue requireOneByValue(string $value) Return the first ChildSurgeryFieldValue filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSurgeryFieldValue[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSurgeryFieldValue objects based on current ModelCriteria
 * @method     ChildSurgeryFieldValue[]|ObjectCollection findBySurgeryFieldId(int $surgery_field_id) Return ChildSurgeryFieldValue objects filtered by the surgery_field_id column
 * @method     ChildSurgeryFieldValue[]|ObjectCollection findBySurgeryId(int $surgery_id) Return ChildSurgeryFieldValue objects filtered by the surgery_id column
 * @method     ChildSurgeryFieldValue[]|ObjectCollection findByValue(string $value) Return ChildSurgeryFieldValue objects filtered by the value column
 * @method     ChildSurgeryFieldValue[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SurgeryFieldValueQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\SurgeryFieldValueQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\SurgeryFieldValue', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSurgeryFieldValueQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSurgeryFieldValueQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSurgeryFieldValueQuery) {
            return $criteria;
        }
        $query = new ChildSurgeryFieldValueQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$surgery_field_id, $surgery_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSurgeryFieldValue|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SurgeryFieldValueTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SurgeryFieldValueTableMap::DATABASE_NAME);
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
     * @return ChildSurgeryFieldValue A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT surgery_field_id, surgery_id, value FROM moc.surgery_field_value WHERE surgery_field_id = :p0 AND surgery_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSurgeryFieldValue $obj */
            $obj = new ChildSurgeryFieldValue();
            $obj->hydrate($row);
            SurgeryFieldValueTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildSurgeryFieldValue|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildSurgeryFieldValueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_FIELD_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSurgeryFieldValueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SurgeryFieldValueTableMap::COL_SURGERY_FIELD_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SurgeryFieldValueTableMap::COL_SURGERY_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the surgery_field_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySurgeryFieldId(1234); // WHERE surgery_field_id = 1234
     * $query->filterBySurgeryFieldId(array(12, 34)); // WHERE surgery_field_id IN (12, 34)
     * $query->filterBySurgeryFieldId(array('min' => 12)); // WHERE surgery_field_id > 12
     * </code>
     *
     * @see       filterBySurgeryField()
     *
     * @param     mixed $surgeryFieldId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSurgeryFieldValueQuery The current query, for fluid interface
     */
    public function filterBySurgeryFieldId($surgeryFieldId = null, $comparison = null)
    {
        if (is_array($surgeryFieldId)) {
            $useMinMax = false;
            if (isset($surgeryFieldId['min'])) {
                $this->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_FIELD_ID, $surgeryFieldId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($surgeryFieldId['max'])) {
                $this->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_FIELD_ID, $surgeryFieldId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_FIELD_ID, $surgeryFieldId, $comparison);
    }

    /**
     * Filter the query on the surgery_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySurgeryId(1234); // WHERE surgery_id = 1234
     * $query->filterBySurgeryId(array(12, 34)); // WHERE surgery_id IN (12, 34)
     * $query->filterBySurgeryId(array('min' => 12)); // WHERE surgery_id > 12
     * </code>
     *
     * @see       filterBySurgery()
     *
     * @param     mixed $surgeryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSurgeryFieldValueQuery The current query, for fluid interface
     */
    public function filterBySurgeryId($surgeryId = null, $comparison = null)
    {
        if (is_array($surgeryId)) {
            $useMinMax = false;
            if (isset($surgeryId['min'])) {
                $this->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_ID, $surgeryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($surgeryId['max'])) {
                $this->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_ID, $surgeryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_ID, $surgeryId, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSurgeryFieldValueQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SurgeryFieldValueTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\SurgeryField object
     *
     * @param \MocApi\Models\SurgeryField|ObjectCollection $surgeryField The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSurgeryFieldValueQuery The current query, for fluid interface
     */
    public function filterBySurgeryField($surgeryField, $comparison = null)
    {
        if ($surgeryField instanceof \MocApi\Models\SurgeryField) {
            return $this
                ->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_FIELD_ID, $surgeryField->getId(), $comparison);
        } elseif ($surgeryField instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_FIELD_ID, $surgeryField->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySurgeryField() only accepts arguments of type \MocApi\Models\SurgeryField or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SurgeryField relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSurgeryFieldValueQuery The current query, for fluid interface
     */
    public function joinSurgeryField($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SurgeryField');

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
            $this->addJoinObject($join, 'SurgeryField');
        }

        return $this;
    }

    /**
     * Use the SurgeryField relation SurgeryField object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\SurgeryFieldQuery A secondary query class using the current class as primary query
     */
    public function useSurgeryFieldQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSurgeryField($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SurgeryField', '\MocApi\Models\SurgeryFieldQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\Surgery object
     *
     * @param \MocApi\Models\Surgery|ObjectCollection $surgery The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSurgeryFieldValueQuery The current query, for fluid interface
     */
    public function filterBySurgery($surgery, $comparison = null)
    {
        if ($surgery instanceof \MocApi\Models\Surgery) {
            return $this
                ->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_ID, $surgery->getId(), $comparison);
        } elseif ($surgery instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SurgeryFieldValueTableMap::COL_SURGERY_ID, $surgery->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySurgery() only accepts arguments of type \MocApi\Models\Surgery or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Surgery relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSurgeryFieldValueQuery The current query, for fluid interface
     */
    public function joinSurgery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Surgery');

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
            $this->addJoinObject($join, 'Surgery');
        }

        return $this;
    }

    /**
     * Use the Surgery relation Surgery object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\SurgeryQuery A secondary query class using the current class as primary query
     */
    public function useSurgeryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSurgery($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Surgery', '\MocApi\Models\SurgeryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSurgeryFieldValue $surgeryFieldValue Object to remove from the list of results
     *
     * @return $this|ChildSurgeryFieldValueQuery The current query, for fluid interface
     */
    public function prune($surgeryFieldValue = null)
    {
        if ($surgeryFieldValue) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SurgeryFieldValueTableMap::COL_SURGERY_FIELD_ID), $surgeryFieldValue->getSurgeryFieldId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SurgeryFieldValueTableMap::COL_SURGERY_ID), $surgeryFieldValue->getSurgeryId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.surgery_field_value table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryFieldValueTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SurgeryFieldValueTableMap::clearInstancePool();
            SurgeryFieldValueTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryFieldValueTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SurgeryFieldValueTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SurgeryFieldValueTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SurgeryFieldValueTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SurgeryFieldValueQuery
