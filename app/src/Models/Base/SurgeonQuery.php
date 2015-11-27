<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\Surgeon as ChildSurgeon;
use MocApi\Models\SurgeonQuery as ChildSurgeonQuery;
use MocApi\Models\Map\SurgeonTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.surgeon' table.
 *
 *
 *
 * @method     ChildSurgeonQuery orderByPersonId($order = Criteria::ASC) Order by the person_id column
 * @method     ChildSurgeonQuery orderBySpecialty($order = Criteria::ASC) Order by the specialty column
 * @method     ChildSurgeonQuery orderByCRM($order = Criteria::ASC) Order by the CRM column
 * @method     ChildSurgeonQuery orderByCRMUF($order = Criteria::ASC) Order by the CRMUF column
 *
 * @method     ChildSurgeonQuery groupByPersonId() Group by the person_id column
 * @method     ChildSurgeonQuery groupBySpecialty() Group by the specialty column
 * @method     ChildSurgeonQuery groupByCRM() Group by the CRM column
 * @method     ChildSurgeonQuery groupByCRMUF() Group by the CRMUF column
 *
 * @method     ChildSurgeonQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSurgeonQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSurgeonQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSurgeonQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSurgeonQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSurgeonQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSurgeonQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     ChildSurgeonQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     ChildSurgeonQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     ChildSurgeonQuery joinWithPerson($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method     ChildSurgeonQuery leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method     ChildSurgeonQuery rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method     ChildSurgeonQuery innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method     ChildSurgeonQuery leftJoinAddress($relationAlias = null) Adds a LEFT JOIN clause to the query using the Address relation
 * @method     ChildSurgeonQuery rightJoinAddress($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Address relation
 * @method     ChildSurgeonQuery innerJoinAddress($relationAlias = null) Adds a INNER JOIN clause to the query using the Address relation
 *
 * @method     ChildSurgeonQuery joinWithAddress($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Address relation
 *
 * @method     ChildSurgeonQuery leftJoinWithAddress() Adds a LEFT JOIN clause and with to the query using the Address relation
 * @method     ChildSurgeonQuery rightJoinWithAddress() Adds a RIGHT JOIN clause and with to the query using the Address relation
 * @method     ChildSurgeonQuery innerJoinWithAddress() Adds a INNER JOIN clause and with to the query using the Address relation
 *
 * @method     ChildSurgeonQuery leftJoinSurgeonSurgery($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeonSurgery relation
 * @method     ChildSurgeonQuery rightJoinSurgeonSurgery($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeonSurgery relation
 * @method     ChildSurgeonQuery innerJoinSurgeonSurgery($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeonSurgery relation
 *
 * @method     ChildSurgeonQuery joinWithSurgeonSurgery($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeonSurgery relation
 *
 * @method     ChildSurgeonQuery leftJoinWithSurgeonSurgery() Adds a LEFT JOIN clause and with to the query using the SurgeonSurgery relation
 * @method     ChildSurgeonQuery rightJoinWithSurgeonSurgery() Adds a RIGHT JOIN clause and with to the query using the SurgeonSurgery relation
 * @method     ChildSurgeonQuery innerJoinWithSurgeonSurgery() Adds a INNER JOIN clause and with to the query using the SurgeonSurgery relation
 *
 * @method     ChildSurgeonQuery leftJoinMedicalStaff($relationAlias = null) Adds a LEFT JOIN clause to the query using the MedicalStaff relation
 * @method     ChildSurgeonQuery rightJoinMedicalStaff($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MedicalStaff relation
 * @method     ChildSurgeonQuery innerJoinMedicalStaff($relationAlias = null) Adds a INNER JOIN clause to the query using the MedicalStaff relation
 *
 * @method     ChildSurgeonQuery joinWithMedicalStaff($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MedicalStaff relation
 *
 * @method     ChildSurgeonQuery leftJoinWithMedicalStaff() Adds a LEFT JOIN clause and with to the query using the MedicalStaff relation
 * @method     ChildSurgeonQuery rightJoinWithMedicalStaff() Adds a RIGHT JOIN clause and with to the query using the MedicalStaff relation
 * @method     ChildSurgeonQuery innerJoinWithMedicalStaff() Adds a INNER JOIN clause and with to the query using the MedicalStaff relation
 *
 * @method     \MocApi\Models\PersonQuery|\MocApi\Models\AddressQuery|\MocApi\Models\SurgeonSurgeryQuery|\MocApi\Models\MedicalStaffQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSurgeon findOne(ConnectionInterface $con = null) Return the first ChildSurgeon matching the query
 * @method     ChildSurgeon findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSurgeon matching the query, or a new ChildSurgeon object populated from the query conditions when no match is found
 *
 * @method     ChildSurgeon findOneByPersonId(int $person_id) Return the first ChildSurgeon filtered by the person_id column
 * @method     ChildSurgeon findOneBySpecialty(string $specialty) Return the first ChildSurgeon filtered by the specialty column
 * @method     ChildSurgeon findOneByCRM(string $CRM) Return the first ChildSurgeon filtered by the CRM column
 * @method     ChildSurgeon findOneByCRMUF(string $CRMUF) Return the first ChildSurgeon filtered by the CRMUF column *

 * @method     ChildSurgeon requirePk($key, ConnectionInterface $con = null) Return the ChildSurgeon by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeon requireOne(ConnectionInterface $con = null) Return the first ChildSurgeon matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSurgeon requireOneByPersonId(int $person_id) Return the first ChildSurgeon filtered by the person_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeon requireOneBySpecialty(string $specialty) Return the first ChildSurgeon filtered by the specialty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeon requireOneByCRM(string $CRM) Return the first ChildSurgeon filtered by the CRM column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgeon requireOneByCRMUF(string $CRMUF) Return the first ChildSurgeon filtered by the CRMUF column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSurgeon[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSurgeon objects based on current ModelCriteria
 * @method     ChildSurgeon[]|ObjectCollection findByPersonId(int $person_id) Return ChildSurgeon objects filtered by the person_id column
 * @method     ChildSurgeon[]|ObjectCollection findBySpecialty(string $specialty) Return ChildSurgeon objects filtered by the specialty column
 * @method     ChildSurgeon[]|ObjectCollection findByCRM(string $CRM) Return ChildSurgeon objects filtered by the CRM column
 * @method     ChildSurgeon[]|ObjectCollection findByCRMUF(string $CRMUF) Return ChildSurgeon objects filtered by the CRMUF column
 * @method     ChildSurgeon[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SurgeonQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\SurgeonQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\Surgeon', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSurgeonQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSurgeonQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSurgeonQuery) {
            return $criteria;
        }
        $query = new ChildSurgeonQuery();
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
     * @return ChildSurgeon|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SurgeonTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SurgeonTableMap::DATABASE_NAME);
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
     * @return ChildSurgeon A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT person_id, specialty, CRM, CRMUF FROM moc.surgeon WHERE person_id = :p0';
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
            /** @var ChildSurgeon $obj */
            $obj = new ChildSurgeon();
            $obj->hydrate($row);
            SurgeonTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSurgeon|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
     */
    public function filterByPersonId($personId = null, $comparison = null)
    {
        if (is_array($personId)) {
            $useMinMax = false;
            if (isset($personId['min'])) {
                $this->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $personId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personId['max'])) {
                $this->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $personId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $personId, $comparison);
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
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SurgeonTableMap::COL_SPECIALTY, $specialty, $comparison);
    }

    /**
     * Filter the query on the CRM column
     *
     * Example usage:
     * <code>
     * $query->filterByCRM('fooValue');   // WHERE CRM = 'fooValue'
     * $query->filterByCRM('%fooValue%'); // WHERE CRM LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cRM The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
     */
    public function filterByCRM($cRM = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cRM)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cRM)) {
                $cRM = str_replace('*', '%', $cRM);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SurgeonTableMap::COL_CRM, $cRM, $comparison);
    }

    /**
     * Filter the query on the CRMUF column
     *
     * Example usage:
     * <code>
     * $query->filterByCRMUF('fooValue');   // WHERE CRMUF = 'fooValue'
     * $query->filterByCRMUF('%fooValue%'); // WHERE CRMUF LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cRMUF The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
     */
    public function filterByCRMUF($cRMUF = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cRMUF)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cRMUF)) {
                $cRMUF = str_replace('*', '%', $cRMUF);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SurgeonTableMap::COL_CRMUF, $cRMUF, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\Person object
     *
     * @param \MocApi\Models\Person|ObjectCollection $person The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSurgeonQuery The current query, for fluid interface
     */
    public function filterByPerson($person, $comparison = null)
    {
        if ($person instanceof \MocApi\Models\Person) {
            return $this
                ->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $person->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\Address object
     *
     * @param \MocApi\Models\Address|ObjectCollection $address the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeonQuery The current query, for fluid interface
     */
    public function filterByAddress($address, $comparison = null)
    {
        if ($address instanceof \MocApi\Models\Address) {
            return $this
                ->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $address->getSurgeonId(), $comparison);
        } elseif ($address instanceof ObjectCollection) {
            return $this
                ->useAddressQuery()
                ->filterByPrimaryKeys($address->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAddress() only accepts arguments of type \MocApi\Models\Address or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Address relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
     */
    public function joinAddress($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Address');

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
            $this->addJoinObject($join, 'Address');
        }

        return $this;
    }

    /**
     * Use the Address relation Address object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\AddressQuery A secondary query class using the current class as primary query
     */
    public function useAddressQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAddress($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Address', '\MocApi\Models\AddressQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\SurgeonSurgery object
     *
     * @param \MocApi\Models\SurgeonSurgery|ObjectCollection $surgeonSurgery the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeonQuery The current query, for fluid interface
     */
    public function filterBySurgeonSurgery($surgeonSurgery, $comparison = null)
    {
        if ($surgeonSurgery instanceof \MocApi\Models\SurgeonSurgery) {
            return $this
                ->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $surgeonSurgery->getSurgeonId(), $comparison);
        } elseif ($surgeonSurgery instanceof ObjectCollection) {
            return $this
                ->useSurgeonSurgeryQuery()
                ->filterByPrimaryKeys($surgeonSurgery->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySurgeonSurgery() only accepts arguments of type \MocApi\Models\SurgeonSurgery or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SurgeonSurgery relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
     */
    public function joinSurgeonSurgery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SurgeonSurgery');

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
            $this->addJoinObject($join, 'SurgeonSurgery');
        }

        return $this;
    }

    /**
     * Use the SurgeonSurgery relation SurgeonSurgery object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\SurgeonSurgeryQuery A secondary query class using the current class as primary query
     */
    public function useSurgeonSurgeryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSurgeonSurgery($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SurgeonSurgery', '\MocApi\Models\SurgeonSurgeryQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\MedicalStaff object
     *
     * @param \MocApi\Models\MedicalStaff|ObjectCollection $medicalStaff the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeonQuery The current query, for fluid interface
     */
    public function filterByMedicalStaff($medicalStaff, $comparison = null)
    {
        if ($medicalStaff instanceof \MocApi\Models\MedicalStaff) {
            return $this
                ->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $medicalStaff->getSurgeonId(), $comparison);
        } elseif ($medicalStaff instanceof ObjectCollection) {
            return $this
                ->useMedicalStaffQuery()
                ->filterByPrimaryKeys($medicalStaff->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMedicalStaff() only accepts arguments of type \MocApi\Models\MedicalStaff or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MedicalStaff relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
     */
    public function joinMedicalStaff($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MedicalStaff');

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
            $this->addJoinObject($join, 'MedicalStaff');
        }

        return $this;
    }

    /**
     * Use the MedicalStaff relation MedicalStaff object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\MedicalStaffQuery A secondary query class using the current class as primary query
     */
    public function useMedicalStaffQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMedicalStaff($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MedicalStaff', '\MocApi\Models\MedicalStaffQuery');
    }

    /**
     * Filter the query by a related Surgery object
     * using the moc.surgeon_surgery table as cross reference
     *
     * @param Surgery $surgery the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeonQuery The current query, for fluid interface
     */
    public function filterBySurgery($surgery, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useSurgeonSurgeryQuery()
            ->filterBySurgery($surgery, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSurgeon $surgeon Object to remove from the list of results
     *
     * @return $this|ChildSurgeonQuery The current query, for fluid interface
     */
    public function prune($surgeon = null)
    {
        if ($surgeon) {
            $this->addUsingAlias(SurgeonTableMap::COL_PERSON_ID, $surgeon->getPersonId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.surgeon table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeonTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SurgeonTableMap::clearInstancePool();
            SurgeonTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeonTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SurgeonTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SurgeonTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SurgeonTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SurgeonQuery
