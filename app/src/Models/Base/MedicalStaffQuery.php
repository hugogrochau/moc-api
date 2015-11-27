<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\MedicalStaff as ChildMedicalStaff;
use MocApi\Models\MedicalStaffQuery as ChildMedicalStaffQuery;
use MocApi\Models\Map\MedicalStaffTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.medical_staff' table.
 *
 *
 *
 * @method     ChildMedicalStaffQuery orderByPersonId($order = Criteria::ASC) Order by the person_id column
 * @method     ChildMedicalStaffQuery orderByOccupation($order = Criteria::ASC) Order by the occupation column
 * @method     ChildMedicalStaffQuery orderBySpecialty($order = Criteria::ASC) Order by the specialty column
 * @method     ChildMedicalStaffQuery orderBySurgeonId($order = Criteria::ASC) Order by the surgeon_id column
 *
 * @method     ChildMedicalStaffQuery groupByPersonId() Group by the person_id column
 * @method     ChildMedicalStaffQuery groupByOccupation() Group by the occupation column
 * @method     ChildMedicalStaffQuery groupBySpecialty() Group by the specialty column
 * @method     ChildMedicalStaffQuery groupBySurgeonId() Group by the surgeon_id column
 *
 * @method     ChildMedicalStaffQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMedicalStaffQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMedicalStaffQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMedicalStaffQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMedicalStaffQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMedicalStaffQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMedicalStaffQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     ChildMedicalStaffQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     ChildMedicalStaffQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     ChildMedicalStaffQuery joinWithPerson($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method     ChildMedicalStaffQuery leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method     ChildMedicalStaffQuery rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method     ChildMedicalStaffQuery innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method     ChildMedicalStaffQuery leftJoinSurgeon($relationAlias = null) Adds a LEFT JOIN clause to the query using the Surgeon relation
 * @method     ChildMedicalStaffQuery rightJoinSurgeon($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Surgeon relation
 * @method     ChildMedicalStaffQuery innerJoinSurgeon($relationAlias = null) Adds a INNER JOIN clause to the query using the Surgeon relation
 *
 * @method     ChildMedicalStaffQuery joinWithSurgeon($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Surgeon relation
 *
 * @method     ChildMedicalStaffQuery leftJoinWithSurgeon() Adds a LEFT JOIN clause and with to the query using the Surgeon relation
 * @method     ChildMedicalStaffQuery rightJoinWithSurgeon() Adds a RIGHT JOIN clause and with to the query using the Surgeon relation
 * @method     ChildMedicalStaffQuery innerJoinWithSurgeon() Adds a INNER JOIN clause and with to the query using the Surgeon relation
 *
 * @method     \MocApi\Models\PersonQuery|\MocApi\Models\SurgeonQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMedicalStaff findOne(ConnectionInterface $con = null) Return the first ChildMedicalStaff matching the query
 * @method     ChildMedicalStaff findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMedicalStaff matching the query, or a new ChildMedicalStaff object populated from the query conditions when no match is found
 *
 * @method     ChildMedicalStaff findOneByPersonId(int $person_id) Return the first ChildMedicalStaff filtered by the person_id column
 * @method     ChildMedicalStaff findOneByOccupation(string $occupation) Return the first ChildMedicalStaff filtered by the occupation column
 * @method     ChildMedicalStaff findOneBySpecialty(string $specialty) Return the first ChildMedicalStaff filtered by the specialty column
 * @method     ChildMedicalStaff findOneBySurgeonId(int $surgeon_id) Return the first ChildMedicalStaff filtered by the surgeon_id column *

 * @method     ChildMedicalStaff requirePk($key, ConnectionInterface $con = null) Return the ChildMedicalStaff by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedicalStaff requireOne(ConnectionInterface $con = null) Return the first ChildMedicalStaff matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMedicalStaff requireOneByPersonId(int $person_id) Return the first ChildMedicalStaff filtered by the person_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedicalStaff requireOneByOccupation(string $occupation) Return the first ChildMedicalStaff filtered by the occupation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedicalStaff requireOneBySpecialty(string $specialty) Return the first ChildMedicalStaff filtered by the specialty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMedicalStaff requireOneBySurgeonId(int $surgeon_id) Return the first ChildMedicalStaff filtered by the surgeon_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMedicalStaff[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMedicalStaff objects based on current ModelCriteria
 * @method     ChildMedicalStaff[]|ObjectCollection findByPersonId(int $person_id) Return ChildMedicalStaff objects filtered by the person_id column
 * @method     ChildMedicalStaff[]|ObjectCollection findByOccupation(string $occupation) Return ChildMedicalStaff objects filtered by the occupation column
 * @method     ChildMedicalStaff[]|ObjectCollection findBySpecialty(string $specialty) Return ChildMedicalStaff objects filtered by the specialty column
 * @method     ChildMedicalStaff[]|ObjectCollection findBySurgeonId(int $surgeon_id) Return ChildMedicalStaff objects filtered by the surgeon_id column
 * @method     ChildMedicalStaff[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MedicalStaffQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\MedicalStaffQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\MedicalStaff', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMedicalStaffQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMedicalStaffQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMedicalStaffQuery) {
            return $criteria;
        }
        $query = new ChildMedicalStaffQuery();
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
     * @return ChildMedicalStaff|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MedicalStaffTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MedicalStaffTableMap::DATABASE_NAME);
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
     * @return ChildMedicalStaff A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT person_id, occupation, specialty, surgeon_id FROM moc.medical_staff WHERE person_id = :p0';
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
            /** @var ChildMedicalStaff $obj */
            $obj = new ChildMedicalStaff();
            $obj->hydrate($row);
            MedicalStaffTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMedicalStaff|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MedicalStaffTableMap::COL_PERSON_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MedicalStaffTableMap::COL_PERSON_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the person_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPersonId(1234); // WHERE person_id = 1234
     * $query->filterByPersonId(array(12, 34)); // WHERE person_id IN (12, 34)
     * $query->filterByPersonId(array('min' => 12)); // WHERE person_id > 12
     * </code>
     *
     * @see       filterByPerson()
     *
     * @param     mixed $personId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function filterByPersonId($personId = null, $comparison = null)
    {
        if (is_array($personId)) {
            $useMinMax = false;
            if (isset($personId['min'])) {
                $this->addUsingAlias(MedicalStaffTableMap::COL_PERSON_ID, $personId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personId['max'])) {
                $this->addUsingAlias(MedicalStaffTableMap::COL_PERSON_ID, $personId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MedicalStaffTableMap::COL_PERSON_ID, $personId, $comparison);
    }

    /**
     * Filter the query on the occupation column
     *
     * Example usage:
     * <code>
     * $query->filterByOccupation('fooValue');   // WHERE occupation = 'fooValue'
     * $query->filterByOccupation('%fooValue%'); // WHERE occupation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $occupation The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function filterByOccupation($occupation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($occupation)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $occupation)) {
                $occupation = str_replace('*', '%', $occupation);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MedicalStaffTableMap::COL_OCCUPATION, $occupation, $comparison);
    }

    /**
     * Filter the query on the specialty column
     *
     * Example usage:
     * <code>
     * $query->filterBySpecialty('fooValue');   // WHERE specialty = 'fooValue'
     * $query->filterBySpecialty('%fooValue%'); // WHERE specialty LIKE '%fooValue%'
     * </code>
     *
     * @param     string $specialty The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function filterBySpecialty($specialty = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($specialty)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $specialty)) {
                $specialty = str_replace('*', '%', $specialty);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MedicalStaffTableMap::COL_SPECIALTY, $specialty, $comparison);
    }

    /**
     * Filter the query on the surgeon_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySurgeonId(1234); // WHERE surgeon_id = 1234
     * $query->filterBySurgeonId(array(12, 34)); // WHERE surgeon_id IN (12, 34)
     * $query->filterBySurgeonId(array('min' => 12)); // WHERE surgeon_id > 12
     * </code>
     *
     * @see       filterBySurgeon()
     *
     * @param     mixed $surgeonId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function filterBySurgeonId($surgeonId = null, $comparison = null)
    {
        if (is_array($surgeonId)) {
            $useMinMax = false;
            if (isset($surgeonId['min'])) {
                $this->addUsingAlias(MedicalStaffTableMap::COL_SURGEON_ID, $surgeonId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($surgeonId['max'])) {
                $this->addUsingAlias(MedicalStaffTableMap::COL_SURGEON_ID, $surgeonId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MedicalStaffTableMap::COL_SURGEON_ID, $surgeonId, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\Person object
     *
     * @param \MocApi\Models\Person|ObjectCollection $person The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function filterByPerson($person, $comparison = null)
    {
        if ($person instanceof \MocApi\Models\Person) {
            return $this
                ->addUsingAlias(MedicalStaffTableMap::COL_PERSON_ID, $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MedicalStaffTableMap::COL_PERSON_ID, $person->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPerson() only accepts arguments of type \MocApi\Models\Person or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Person relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function joinPerson($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Person');

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
            $this->addJoinObject($join, 'Person');
        }

        return $this;
    }

    /**
     * Use the Person relation Person object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\PersonQuery A secondary query class using the current class as primary query
     */
    public function usePersonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPerson($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Person', '\MocApi\Models\PersonQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\Surgeon object
     *
     * @param \MocApi\Models\Surgeon|ObjectCollection $surgeon The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function filterBySurgeon($surgeon, $comparison = null)
    {
        if ($surgeon instanceof \MocApi\Models\Surgeon) {
            return $this
                ->addUsingAlias(MedicalStaffTableMap::COL_SURGEON_ID, $surgeon->getPersonId(), $comparison);
        } elseif ($surgeon instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MedicalStaffTableMap::COL_SURGEON_ID, $surgeon->toKeyValue('PrimaryKey', 'PersonId'), $comparison);
        } else {
            throw new PropelException('filterBySurgeon() only accepts arguments of type \MocApi\Models\Surgeon or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Surgeon relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function joinSurgeon($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Surgeon');

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
            $this->addJoinObject($join, 'Surgeon');
        }

        return $this;
    }

    /**
     * Use the Surgeon relation Surgeon object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\SurgeonQuery A secondary query class using the current class as primary query
     */
    public function useSurgeonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSurgeon($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Surgeon', '\MocApi\Models\SurgeonQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMedicalStaff $medicalStaff Object to remove from the list of results
     *
     * @return $this|ChildMedicalStaffQuery The current query, for fluid interface
     */
    public function prune($medicalStaff = null)
    {
        if ($medicalStaff) {
            $this->addUsingAlias(MedicalStaffTableMap::COL_PERSON_ID, $medicalStaff->getPersonId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.medical_staff table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MedicalStaffTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MedicalStaffTableMap::clearInstancePool();
            MedicalStaffTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MedicalStaffTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MedicalStaffTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MedicalStaffTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MedicalStaffTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MedicalStaffQuery
