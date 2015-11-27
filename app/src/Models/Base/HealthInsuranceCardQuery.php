<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\HealthInsuranceCard as ChildHealthInsuranceCard;
use MocApi\Models\HealthInsuranceCardQuery as ChildHealthInsuranceCardQuery;
use MocApi\Models\Map\HealthInsuranceCardTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.health_insurance_card' table.
 *
 *
 *
 * @method     ChildHealthInsuranceCardQuery orderByPatientId($order = Criteria::ASC) Order by the patient_id column
 * @method     ChildHealthInsuranceCardQuery orderByHealthInsuranceId($order = Criteria::ASC) Order by the health_insurance_id column
 * @method     ChildHealthInsuranceCardQuery orderByNumber($order = Criteria::ASC) Order by the number column
 * @method     ChildHealthInsuranceCardQuery orderByExpiration($order = Criteria::ASC) Order by the expiration column
 *
 * @method     ChildHealthInsuranceCardQuery groupByPatientId() Group by the patient_id column
 * @method     ChildHealthInsuranceCardQuery groupByHealthInsuranceId() Group by the health_insurance_id column
 * @method     ChildHealthInsuranceCardQuery groupByNumber() Group by the number column
 * @method     ChildHealthInsuranceCardQuery groupByExpiration() Group by the expiration column
 *
 * @method     ChildHealthInsuranceCardQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildHealthInsuranceCardQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildHealthInsuranceCardQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildHealthInsuranceCardQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildHealthInsuranceCardQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildHealthInsuranceCardQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildHealthInsuranceCardQuery leftJoinPatient($relationAlias = null) Adds a LEFT JOIN clause to the query using the Patient relation
 * @method     ChildHealthInsuranceCardQuery rightJoinPatient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Patient relation
 * @method     ChildHealthInsuranceCardQuery innerJoinPatient($relationAlias = null) Adds a INNER JOIN clause to the query using the Patient relation
 *
 * @method     ChildHealthInsuranceCardQuery joinWithPatient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Patient relation
 *
 * @method     ChildHealthInsuranceCardQuery leftJoinWithPatient() Adds a LEFT JOIN clause and with to the query using the Patient relation
 * @method     ChildHealthInsuranceCardQuery rightJoinWithPatient() Adds a RIGHT JOIN clause and with to the query using the Patient relation
 * @method     ChildHealthInsuranceCardQuery innerJoinWithPatient() Adds a INNER JOIN clause and with to the query using the Patient relation
 *
 * @method     ChildHealthInsuranceCardQuery leftJoinHealthInsurance($relationAlias = null) Adds a LEFT JOIN clause to the query using the HealthInsurance relation
 * @method     ChildHealthInsuranceCardQuery rightJoinHealthInsurance($relationAlias = null) Adds a RIGHT JOIN clause to the query using the HealthInsurance relation
 * @method     ChildHealthInsuranceCardQuery innerJoinHealthInsurance($relationAlias = null) Adds a INNER JOIN clause to the query using the HealthInsurance relation
 *
 * @method     ChildHealthInsuranceCardQuery joinWithHealthInsurance($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the HealthInsurance relation
 *
 * @method     ChildHealthInsuranceCardQuery leftJoinWithHealthInsurance() Adds a LEFT JOIN clause and with to the query using the HealthInsurance relation
 * @method     ChildHealthInsuranceCardQuery rightJoinWithHealthInsurance() Adds a RIGHT JOIN clause and with to the query using the HealthInsurance relation
 * @method     ChildHealthInsuranceCardQuery innerJoinWithHealthInsurance() Adds a INNER JOIN clause and with to the query using the HealthInsurance relation
 *
 * @method     \MocApi\Models\PatientQuery|\MocApi\Models\HealthInsuranceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildHealthInsuranceCard findOne(ConnectionInterface $con = null) Return the first ChildHealthInsuranceCard matching the query
 * @method     ChildHealthInsuranceCard findOneOrCreate(ConnectionInterface $con = null) Return the first ChildHealthInsuranceCard matching the query, or a new ChildHealthInsuranceCard object populated from the query conditions when no match is found
 *
 * @method     ChildHealthInsuranceCard findOneByPatientId(int $patient_id) Return the first ChildHealthInsuranceCard filtered by the patient_id column
 * @method     ChildHealthInsuranceCard findOneByHealthInsuranceId(int $health_insurance_id) Return the first ChildHealthInsuranceCard filtered by the health_insurance_id column
 * @method     ChildHealthInsuranceCard findOneByNumber(string $number) Return the first ChildHealthInsuranceCard filtered by the number column
 * @method     ChildHealthInsuranceCard findOneByExpiration(string $expiration) Return the first ChildHealthInsuranceCard filtered by the expiration column *

 * @method     ChildHealthInsuranceCard requirePk($key, ConnectionInterface $con = null) Return the ChildHealthInsuranceCard by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHealthInsuranceCard requireOne(ConnectionInterface $con = null) Return the first ChildHealthInsuranceCard matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHealthInsuranceCard requireOneByPatientId(int $patient_id) Return the first ChildHealthInsuranceCard filtered by the patient_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHealthInsuranceCard requireOneByHealthInsuranceId(int $health_insurance_id) Return the first ChildHealthInsuranceCard filtered by the health_insurance_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHealthInsuranceCard requireOneByNumber(string $number) Return the first ChildHealthInsuranceCard filtered by the number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHealthInsuranceCard requireOneByExpiration(string $expiration) Return the first ChildHealthInsuranceCard filtered by the expiration column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHealthInsuranceCard[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildHealthInsuranceCard objects based on current ModelCriteria
 * @method     ChildHealthInsuranceCard[]|ObjectCollection findByPatientId(int $patient_id) Return ChildHealthInsuranceCard objects filtered by the patient_id column
 * @method     ChildHealthInsuranceCard[]|ObjectCollection findByHealthInsuranceId(int $health_insurance_id) Return ChildHealthInsuranceCard objects filtered by the health_insurance_id column
 * @method     ChildHealthInsuranceCard[]|ObjectCollection findByNumber(string $number) Return ChildHealthInsuranceCard objects filtered by the number column
 * @method     ChildHealthInsuranceCard[]|ObjectCollection findByExpiration(string $expiration) Return ChildHealthInsuranceCard objects filtered by the expiration column
 * @method     ChildHealthInsuranceCard[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class HealthInsuranceCardQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\HealthInsuranceCardQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\HealthInsuranceCard', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildHealthInsuranceCardQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildHealthInsuranceCardQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildHealthInsuranceCardQuery) {
            return $criteria;
        }
        $query = new ChildHealthInsuranceCardQuery();
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
     * @param array[$patient_id, $health_insurance_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildHealthInsuranceCard|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = HealthInsuranceCardTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(HealthInsuranceCardTableMap::DATABASE_NAME);
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
     * @return ChildHealthInsuranceCard A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT patient_id, health_insurance_id, number, expiration FROM moc.health_insurance_card WHERE patient_id = :p0 AND health_insurance_id = :p1';
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
            /** @var ChildHealthInsuranceCard $obj */
            $obj = new ChildHealthInsuranceCard();
            $obj->hydrate($row);
            HealthInsuranceCardTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildHealthInsuranceCard|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(HealthInsuranceCardTableMap::COL_PATIENT_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(HealthInsuranceCardTableMap::COL_PATIENT_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the patient_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPatientId(1234); // WHERE patient_id = 1234
     * $query->filterByPatientId(array(12, 34)); // WHERE patient_id IN (12, 34)
     * $query->filterByPatientId(array('min' => 12)); // WHERE patient_id > 12
     * </code>
     *
     * @see       filterByPatient()
     *
     * @param     mixed $patientId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function filterByPatientId($patientId = null, $comparison = null)
    {
        if (is_array($patientId)) {
            $useMinMax = false;
            if (isset($patientId['min'])) {
                $this->addUsingAlias(HealthInsuranceCardTableMap::COL_PATIENT_ID, $patientId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($patientId['max'])) {
                $this->addUsingAlias(HealthInsuranceCardTableMap::COL_PATIENT_ID, $patientId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HealthInsuranceCardTableMap::COL_PATIENT_ID, $patientId, $comparison);
    }

    /**
     * Filter the query on the health_insurance_id column
     *
     * Example usage:
     * <code>
     * $query->filterByHealthInsuranceId(1234); // WHERE health_insurance_id = 1234
     * $query->filterByHealthInsuranceId(array(12, 34)); // WHERE health_insurance_id IN (12, 34)
     * $query->filterByHealthInsuranceId(array('min' => 12)); // WHERE health_insurance_id > 12
     * </code>
     *
     * @see       filterByHealthInsurance()
     *
     * @param     mixed $healthInsuranceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function filterByHealthInsuranceId($healthInsuranceId = null, $comparison = null)
    {
        if (is_array($healthInsuranceId)) {
            $useMinMax = false;
            if (isset($healthInsuranceId['min'])) {
                $this->addUsingAlias(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID, $healthInsuranceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($healthInsuranceId['max'])) {
                $this->addUsingAlias(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID, $healthInsuranceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID, $healthInsuranceId, $comparison);
    }

    /**
     * Filter the query on the number column
     *
     * Example usage:
     * <code>
     * $query->filterByNumber('fooValue');   // WHERE number = 'fooValue'
     * $query->filterByNumber('%fooValue%'); // WHERE number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $number The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function filterByNumber($number = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($number)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $number)) {
                $number = str_replace('*', '%', $number);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HealthInsuranceCardTableMap::COL_NUMBER, $number, $comparison);
    }

    /**
     * Filter the query on the expiration column
     *
     * Example usage:
     * <code>
     * $query->filterByExpiration('2011-03-14'); // WHERE expiration = '2011-03-14'
     * $query->filterByExpiration('now'); // WHERE expiration = '2011-03-14'
     * $query->filterByExpiration(array('max' => 'yesterday')); // WHERE expiration > '2011-03-13'
     * </code>
     *
     * @param     mixed $expiration The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function filterByExpiration($expiration = null, $comparison = null)
    {
        if (is_array($expiration)) {
            $useMinMax = false;
            if (isset($expiration['min'])) {
                $this->addUsingAlias(HealthInsuranceCardTableMap::COL_EXPIRATION, $expiration['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expiration['max'])) {
                $this->addUsingAlias(HealthInsuranceCardTableMap::COL_EXPIRATION, $expiration['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HealthInsuranceCardTableMap::COL_EXPIRATION, $expiration, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\Patient object
     *
     * @param \MocApi\Models\Patient|ObjectCollection $patient The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function filterByPatient($patient, $comparison = null)
    {
        if ($patient instanceof \MocApi\Models\Patient) {
            return $this
                ->addUsingAlias(HealthInsuranceCardTableMap::COL_PATIENT_ID, $patient->getPersonId(), $comparison);
        } elseif ($patient instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(HealthInsuranceCardTableMap::COL_PATIENT_ID, $patient->toKeyValue('PrimaryKey', 'PersonId'), $comparison);
        } else {
            throw new PropelException('filterByPatient() only accepts arguments of type \MocApi\Models\Patient or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Patient relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function joinPatient($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Patient');

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
            $this->addJoinObject($join, 'Patient');
        }

        return $this;
    }

    /**
     * Use the Patient relation Patient object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\PatientQuery A secondary query class using the current class as primary query
     */
    public function usePatientQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPatient($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Patient', '\MocApi\Models\PatientQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\HealthInsurance object
     *
     * @param \MocApi\Models\HealthInsurance|ObjectCollection $healthInsurance The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function filterByHealthInsurance($healthInsurance, $comparison = null)
    {
        if ($healthInsurance instanceof \MocApi\Models\HealthInsurance) {
            return $this
                ->addUsingAlias(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID, $healthInsurance->getId(), $comparison);
        } elseif ($healthInsurance instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID, $healthInsurance->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByHealthInsurance() only accepts arguments of type \MocApi\Models\HealthInsurance or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the HealthInsurance relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function joinHealthInsurance($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('HealthInsurance');

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
            $this->addJoinObject($join, 'HealthInsurance');
        }

        return $this;
    }

    /**
     * Use the HealthInsurance relation HealthInsurance object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\HealthInsuranceQuery A secondary query class using the current class as primary query
     */
    public function useHealthInsuranceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinHealthInsurance($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'HealthInsurance', '\MocApi\Models\HealthInsuranceQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildHealthInsuranceCard $healthInsuranceCard Object to remove from the list of results
     *
     * @return $this|ChildHealthInsuranceCardQuery The current query, for fluid interface
     */
    public function prune($healthInsuranceCard = null)
    {
        if ($healthInsuranceCard) {
            $this->addCond('pruneCond0', $this->getAliasedColName(HealthInsuranceCardTableMap::COL_PATIENT_ID), $healthInsuranceCard->getPatientId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID), $healthInsuranceCard->getHealthInsuranceId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.health_insurance_card table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HealthInsuranceCardTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            HealthInsuranceCardTableMap::clearInstancePool();
            HealthInsuranceCardTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(HealthInsuranceCardTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(HealthInsuranceCardTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            HealthInsuranceCardTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            HealthInsuranceCardTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // HealthInsuranceCardQuery
