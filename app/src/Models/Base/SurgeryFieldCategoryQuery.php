<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\SurgeryFieldCategory as ChildSurgeryFieldCategory;
use MocApi\Models\SurgeryFieldCategoryQuery as ChildSurgeryFieldCategoryQuery;
use MocApi\Models\Map\SurgeryFieldCategoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.surgery_field_category' table.
 *
 *
 *
 * @method     ChildSurgeryFieldCategoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSurgeryFieldCategoryQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildSurgeryFieldCategoryQuery orderBySurgeryTypeId($order = Criteria::ASC) Order by the surgery_type_id column
 * @method     ChildSurgeryFieldCategoryQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildSurgeryFieldCategoryQuery groupById() Group by the id column
 * @method     ChildSurgeryFieldCategoryQuery groupByName() Group by the name column
 * @method     ChildSurgeryFieldCategoryQuery groupBySurgeryTypeId() Group by the surgery_type_id column
 * @method     ChildSurgeryFieldCategoryQuery groupByCreated() Group by the created column
 *
 * @method     ChildSurgeryFieldCategoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSurgeryFieldCategoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSurgeryFieldCategoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSurgeryFieldCategoryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSurgeryFieldCategoryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSurgeryFieldCategoryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSurgeryFieldCategoryQuery leftJoinSurgeryType($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeryType relation
 * @method     ChildSurgeryFieldCategoryQuery rightJoinSurgeryType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeryType relation
 * @method     ChildSurgeryFieldCategoryQuery innerJoinSurgeryType($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeryType relation
 *
 * @method     ChildSurgeryFieldCategoryQuery joinWithSurgeryType($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeryType relation
 *
 * @method     ChildSurgeryFieldCategoryQuery leftJoinWithSurgeryType() Adds a LEFT JOIN clause and with to the query using the SurgeryType relation
 * @method     ChildSurgeryFieldCategoryQuery rightJoinWithSurgeryType() Adds a RIGHT JOIN clause and with to the query using the SurgeryType relation
 * @method     ChildSurgeryFieldCategoryQuery innerJoinWithSurgeryType() Adds a INNER JOIN clause and with to the query using the SurgeryType relation
 *
 * @method     ChildSurgeryFieldCategoryQuery leftJoinSurgeryField($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeryField relation
 * @method     ChildSurgeryFieldCategoryQuery rightJoinSurgeryField($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeryField relation
 * @method     ChildSurgeryFieldCategoryQuery innerJoinSurgeryField($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeryField relation
 *
 * @method     ChildSurgeryFieldCategoryQuery joinWithSurgeryField($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeryField relation
 *
 * @method     ChildSurgeryFieldCategoryQuery leftJoinWithSurgeryField() Adds a LEFT JOIN clause and with to the query using the SurgeryField relation
 * @method     ChildSurgeryFieldCategoryQuery rightJoinWithSurgeryField() Adds a RIGHT JOIN clause and with to the query using the SurgeryField relation
 * @method     ChildSurgeryFieldCategoryQuery innerJoinWithSurgeryField() Adds a INNER JOIN clause and with to the query using the SurgeryField relation
 *
 * @method     \MocApi\Models\SurgeryTypeQuery|\MocApi\Models\SurgeryFieldQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSurgeryFieldCategory findOne(ConnectionInterface $con = null) Return the first ChildSurgeryFieldCategory matching the query
 * @method     ChildSurgeryFieldCategory findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSurgeryFieldCategory matching the query, or a new ChildSurgeryFieldCategory object populated from the query conditions when no match is found
 *
 * @method     ChildSurgeryFieldCategory findOneById(int $id) Return the first ChildSurgeryFieldCategory filtered by the id column
 * @method     ChildSurgeryFieldCategory findOneByName(string $name) Return the first ChildSurgeryFieldCategory filtered by the name column
 * @method     ChildSurgeryFieldCategory findOneBySurgeryTypeId(int $surgery_type_id) Return the first ChildSurgeryFieldCategory filtered by the surgery_type_id column
 * @method     ChildSurgeryFieldCategory findOneByCreated(string $created) Return the first ChildSurgeryFieldCategory filtered by the created column *

 * @method     ChildSurgeryFieldCategory requirePk($key, ConnectionInterface $con = null) Return the ChildSurgeryFieldCategory by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeryFieldCategory requireOne(ConnectionInterface $con = null) Return the first ChildSurgeryFieldCategory matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSurgeryFieldCategory requireOneById(int $id) Return the first ChildSurgeryFieldCategory filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeryFieldCategory requireOneByName(string $name) Return the first ChildSurgeryFieldCategory filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeryFieldCategory requireOneBySurgeryTypeId(int $surgery_type_id) Return the first ChildSurgeryFieldCategory filtered by the surgery_type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeryFieldCategory requireOneByCreated(string $created) Return the first ChildSurgeryFieldCategory filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSurgeryFieldCategory[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSurgeryFieldCategory objects based on current ModelCriteria
 * @method     ChildSurgeryFieldCategory[]|ObjectCollection findById(int $id) Return ChildSurgeryFieldCategory objects filtered by the id column
 * @method     ChildSurgeryFieldCategory[]|ObjectCollection findByName(string $name) Return ChildSurgeryFieldCategory objects filtered by the name column
 * @method     ChildSurgeryFieldCategory[]|ObjectCollection findBySurgeryTypeId(int $surgery_type_id) Return ChildSurgeryFieldCategory objects filtered by the surgery_type_id column
 * @method     ChildSurgeryFieldCategory[]|ObjectCollection findByCreated(string $created) Return ChildSurgeryFieldCategory objects filtered by the created column
 * @method     ChildSurgeryFieldCategory[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SurgeryFieldCategoryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\SurgeryFieldCategoryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\SurgeryFieldCategory', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSurgeryFieldCategoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSurgeryFieldCategoryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSurgeryFieldCategoryQuery) {
            return $criteria;
        }
        $query = new ChildSurgeryFieldCategoryQuery();
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
     * @return ChildSurgeryFieldCategory|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SurgeryFieldCategoryTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SurgeryFieldCategoryTableMap::DATABASE_NAME);
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
     * @return ChildSurgeryFieldCategory A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, surgery_type_id, created FROM moc.surgery_field_category WHERE id = :p0';
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
            /** @var ChildSurgeryFieldCategory $obj */
            $obj = new ChildSurgeryFieldCategory();
            $obj->hydrate($row);
            SurgeryFieldCategoryTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSurgeryFieldCategory|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSurgeryFieldCategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSurgeryFieldCategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSurgeryFieldCategoryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSurgeryFieldCategoryQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the surgery_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySurgeryTypeId(1234); // WHERE surgery_type_id = 1234
     * $query->filterBySurgeryTypeId(array(12, 34)); // WHERE surgery_type_id IN (12, 34)
     * $query->filterBySurgeryTypeId(array('min' => 12)); // WHERE surgery_type_id > 12
     * </code>
     *
     * @see       filterBySurgeryType()
     *
     * @param     mixed $surgeryTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSurgeryFieldCategoryQuery The current query, for fluid interface
     */
    public function filterBySurgeryTypeId($surgeryTypeId = null, $comparison = null)
    {
        if (is_array($surgeryTypeId)) {
            $useMinMax = false;
            if (isset($surgeryTypeId['min'])) {
                $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_SURGERY_TYPE_ID, $surgeryTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($surgeryTypeId['max'])) {
                $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_SURGERY_TYPE_ID, $surgeryTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_SURGERY_TYPE_ID, $surgeryTypeId, $comparison);
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
     * @return $this|ChildSurgeryFieldCategoryQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\SurgeryType object
     *
     * @param \MocApi\Models\SurgeryType|ObjectCollection $surgeryType The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSurgeryFieldCategoryQuery The current query, for fluid interface
     */
    public function filterBySurgeryType($surgeryType, $comparison = null)
    {
        if ($surgeryType instanceof \MocApi\Models\SurgeryType) {
            return $this
                ->addUsingAlias(SurgeryFieldCategoryTableMap::COL_SURGERY_TYPE_ID, $surgeryType->getId(), $comparison);
        } elseif ($surgeryType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SurgeryFieldCategoryTableMap::COL_SURGERY_TYPE_ID, $surgeryType->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySurgeryType() only accepts arguments of type \MocApi\Models\SurgeryType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SurgeryType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSurgeryFieldCategoryQuery The current query, for fluid interface
     */
    public function joinSurgeryType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SurgeryType');

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
            $this->addJoinObject($join, 'SurgeryType');
        }

        return $this;
    }

    /**
     * Use the SurgeryType relation SurgeryType object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\SurgeryTypeQuery A secondary query class using the current class as primary query
     */
    public function useSurgeryTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSurgeryType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SurgeryType', '\MocApi\Models\SurgeryTypeQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\SurgeryField object
     *
     * @param \MocApi\Models\SurgeryField|ObjectCollection $surgeryField the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryFieldCategoryQuery The current query, for fluid interface
     */
    public function filterBySurgeryField($surgeryField, $comparison = null)
    {
        if ($surgeryField instanceof \MocApi\Models\SurgeryField) {
            return $this
                ->addUsingAlias(SurgeryFieldCategoryTableMap::COL_ID, $surgeryField->getSurgeryFieldCategoryId(), $comparison);
        } elseif ($surgeryField instanceof ObjectCollection) {
            return $this
                ->useSurgeryFieldQuery()
                ->filterByPrimaryKeys($surgeryField->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildSurgeryFieldCategoryQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildSurgeryFieldCategory $surgeryFieldCategory Object to remove from the list of results
     *
     * @return $this|ChildSurgeryFieldCategoryQuery The current query, for fluid interface
     */
    public function prune($surgeryFieldCategory = null)
    {
        if ($surgeryFieldCategory) {
            $this->addUsingAlias(SurgeryFieldCategoryTableMap::COL_ID, $surgeryFieldCategory->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.surgery_field_category table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryFieldCategoryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SurgeryFieldCategoryTableMap::clearInstancePool();
            SurgeryFieldCategoryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryFieldCategoryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SurgeryFieldCategoryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SurgeryFieldCategoryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SurgeryFieldCategoryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SurgeryFieldCategoryQuery
