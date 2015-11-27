<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\Patient as ChildPatient;
use MocApi\Models\PatientQuery as ChildPatientQuery;
use MocApi\Models\Map\PatientTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.patient' table.
 *
 *
 *
 * @method     ChildPatientQuery orderByPersonId($order = Criteria::ASC) Order by the person_id column
 * @method     ChildPatientQuery orderByWeight($order = Criteria::ASC) Order by the weight column
 * @method     ChildPatientQuery orderByHeight($order = Criteria::ASC) Order by the height column
 * @method     ChildPatientQuery orderByBloodType($order = Criteria::ASC) Order by the blood_type column
 * @method     ChildPatientQuery orderByNotes($order = Criteria::ASC) Order by the notes column
 * @method     ChildPatientQuery orderBySurgeryId($order = Criteria::ASC) Order by the surgery_id column
 *
 * @method     ChildPatientQuery groupByPersonId() Group by the person_id column
 * @method     ChildPatientQuery groupByWeight() Group by the weight column
 * @method     ChildPatientQuery groupByHeight() Group by the height column
 * @method     ChildPatientQuery groupByBloodType() Group by the blood_type column
 * @method     ChildPatientQuery groupByNotes() Group by the notes column
 * @method     ChildPatientQuery groupBySurgeryId() Group by the surgery_id column
 *
 * @method     ChildPatientQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPatientQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPatientQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPatientQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPatientQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPatientQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPatientQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     ChildPatientQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     ChildPatientQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     ChildPatientQuery joinWithPerson($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method     ChildPatientQuery leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method     ChildPatientQuery rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method     ChildPatientQuery innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method     ChildPatientQuery leftJoinSurgery($relationAlias = null) Adds a LEFT JOIN clause to the query using the Surgery relation
 * @method     ChildPatientQuery rightJoinSurgery($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Surgery relation
 * @method     ChildPatientQuery innerJoinSurgery($relationAlias = null) Adds a INNER JOIN clause to the query using the Surgery relation
 *
 * @method     ChildPatientQuery joinWithSurgery($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Surgery relation
 *
 * @method     ChildPatientQuery leftJoinWithSurgery() Adds a LEFT JOIN clause and with to the query using the Surgery relation
 * @method     ChildPatientQuery rightJoinWithSurgery() Adds a RIGHT JOIN clause and with to the query using the Surgery relation
 * @method     ChildPatientQuery innerJoinWithSurgery() Adds a INNER JOIN clause and with to the query using the Surgery relation
 *
 * @method     ChildPatientQuery leftJoinHealthInsuranceCard($relationAlias = null) Adds a LEFT JOIN clause to the query using the HealthInsuranceCard relation
 * @method     ChildPatientQuery rightJoinHealthInsuranceCard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the HealthInsuranceCard relation
 * @method     ChildPatientQuery innerJoinHealthInsuranceCard($relationAlias = null) Adds a INNER JOIN clause to the query using the HealthInsuranceCard relation
 *
 * @method     ChildPatientQuery joinWithHealthInsuranceCard($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the HealthInsuranceCard relation
 *
 * @method     ChildPatientQuery leftJoinWithHealthInsuranceCard() Adds a LEFT JOIN clause and with to the query using the HealthInsuranceCard relation
 * @method     ChildPatientQuery rightJoinWithHealthInsuranceCard() Adds a RIGHT JOIN clause and with to the query using the HealthInsuranceCard relation
 * @method     ChildPatientQuery innerJoinWithHealthInsuranceCard() Adds a INNER JOIN clause and with to the query using the HealthInsuranceCard relation
 *
 * @method     ChildPatientQuery leftJoinLegalGuardian($relationAlias = null) Adds a LEFT JOIN clause to the query using the LegalGuardian relation
 * @method     ChildPatientQuery rightJoinLegalGuardian($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LegalGuardian relation
 * @method     ChildPatientQuery innerJoinLegalGuardian($relationAlias = null) Adds a INNER JOIN clause to the query using the LegalGuardian relation
 *
 * @method     ChildPatientQuery joinWithLegalGuardian($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the LegalGuardian relation
 *
 * @method     ChildPatientQuery leftJoinWithLegalGuardian() Adds a LEFT JOIN clause and with to the query using the LegalGuardian relation
 * @method     ChildPatientQuery rightJoinWithLegalGuardian() Adds a RIGHT JOIN clause and with to the query using the LegalGuardian relation
 * @method     ChildPatientQuery innerJoinWithLegalGuardian() Adds a INNER JOIN clause and with to the query using the LegalGuardian relation
 *
 * @method     \MocApi\Models\PersonQuery|\MocApi\Models\SurgeryQuery|\MocApi\Models\HealthInsuranceCardQuery|\MocApi\Models\LegalGuardianQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPatient findOne(ConnectionInterface $con = null) Return the first ChildPatient matching the query
 * @method     ChildPatient findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPatient matching the query, or a new ChildPatient object populated from the query conditions when no match is found
 *
 * @method     ChildPatient findOneByPersonId(int $person_id) Return the first ChildPatient filtered by the person_id column
 * @method     ChildPatient findOneByWeight(double $weight) Return the first ChildPatient filtered by the weight column
 * @method     ChildPatient findOneByHeight(double $height) Return the first ChildPatient filtered by the height column
 * @method     ChildPatient findOneByBloodType(string $blood_type) Return the first ChildPatient filtered by the blood_type column
 * @method     ChildPatient findOneByNotes(string $notes) Return the first ChildPatient filtered by the notes column
 * @method     ChildPatient findOneBySurgeryId(int $surgery_id) Return the first ChildPatient filtered by the surgery_id column *

 * @method     ChildPatient requirePk($key, ConnectionInterface $con = null) Return the ChildPatient by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOne(ConnectionInterface $con = null) Return the first ChildPatient matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPatient requireOneByPersonId(int $person_id) Return the first ChildPatient filtered by the person_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOneByWeight(double $weight) Return the first ChildPatient filtered by the weight column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOneByHeight(double $height) Return the first ChildPatient filtered by the height column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOneByBloodType(string $blood_type) Return the first ChildPatient filtered by the blood_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOneByNotes(string $notes) Return the first ChildPatient filtered by the notes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPatient requireOneBySurgeryId(int $surgery_id) Return the first ChildPatient filtered by the surgery_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPatient[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPatient objects based on current ModelCriteria
 * @method     ChildPatient[]|ObjectCollection findByPersonId(int $person_id) Return ChildPatient objects filtered by the person_id column
 * @method     ChildPatient[]|ObjectCollection findByWeight(double $weight) Return ChildPatient objects filtered by the weight column
 * @method     ChildPatient[]|ObjectCollection findByHeight(double $height) Return ChildPatient objects filtered by the height column
 * @method     ChildPatient[]|ObjectCollection findByBloodType(string $blood_type) Return ChildPatient objects filtered by the blood_type column
 * @method     ChildPatient[]|ObjectCollection findByNotes(string $notes) Return ChildPatient objects filtered by the notes column
 * @method     ChildPatient[]|ObjectCollection findBySurgeryId(int $surgery_id) Return ChildPatient objects filtered by the surgery_id column
 * @method     ChildPatient[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PatientQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\PatientQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\Patient', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPatientQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPatientQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPatientQuery) {
            return $criteria;
        }
        $query = new ChildPatientQuery();
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
     * @return ChildPatient|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PatientTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PatientTableMap::DATABASE_NAME);
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
     * @return ChildPatient A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT person_id, weight, height, blood_type, notes, surgery_id FROM moc.patient WHERE person_id = :p0';
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
            /** @var ChildPatient $obj */
            $obj = new ChildPatient();
            $obj->hydrate($row);
            PatientTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPatient|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PatientTableMap::COL_PERSON_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PatientTableMap::COL_PERSON_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByPersonId($personId = null, $comparison = null)
    {
        if (is_array($personId)) {
            $useMinMax = false;
            if (isset($personId['min'])) {
                $this->addUsingAlias(PatientTableMap::COL_PERSON_ID, $personId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personId['max'])) {
                $this->addUsingAlias(PatientTableMap::COL_PERSON_ID, $personId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_PERSON_ID, $personId, $comparison);
    }

    /**
     * Filter the query on the weight column
     *
     * Example usage:
     * <code>
     * $query->filterByWeight(1234); // WHERE weight = 1234
     * $query->filterByWeight(array(12, 34)); // WHERE weight IN (12, 34)
     * $query->filterByWeight(array('min' => 12)); // WHERE weight > 12
     * </code>
     *
     * @param     mixed $weight The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByWeight($weight = null, $comparison = null)
    {
        if (is_array($weight)) {
            $useMinMax = false;
            if (isset($weight['min'])) {
                $this->addUsingAlias(PatientTableMap::COL_WEIGHT, $weight['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weight['max'])) {
                $this->addUsingAlias(PatientTableMap::COL_WEIGHT, $weight['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_WEIGHT, $weight, $comparison);
    }

    /**
     * Filter the query on the height column
     *
     * Example usage:
     * <code>
     * $query->filterByHeight(1234); // WHERE height = 1234
     * $query->filterByHeight(array(12, 34)); // WHERE height IN (12, 34)
     * $query->filterByHeight(array('min' => 12)); // WHERE height > 12
     * </code>
     *
     * @param     mixed $height The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByHeight($height = null, $comparison = null)
    {
        if (is_array($height)) {
            $useMinMax = false;
            if (isset($height['min'])) {
                $this->addUsingAlias(PatientTableMap::COL_HEIGHT, $height['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($height['max'])) {
                $this->addUsingAlias(PatientTableMap::COL_HEIGHT, $height['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_HEIGHT, $height, $comparison);
    }

    /**
     * Filter the query on the blood_type column
     *
     * Example usage:
     * <code>
     * $query->filterByBloodType('fooValue');   // WHERE blood_type = 'fooValue'
     * $query->filterByBloodType('%fooValue%'); // WHERE blood_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bloodType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByBloodType($bloodType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bloodType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bloodType)) {
                $bloodType = str_replace('*', '%', $bloodType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_BLOOD_TYPE, $bloodType, $comparison);
    }

    /**
     * Filter the query on the notes column
     *
     * Example usage:
     * <code>
     * $query->filterByNotes('fooValue');   // WHERE notes = 'fooValue'
     * $query->filterByNotes('%fooValue%'); // WHERE notes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notes The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterByNotes($notes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notes)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notes)) {
                $notes = str_replace('*', '%', $notes);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_NOTES, $notes, $comparison);
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
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function filterBySurgeryId($surgeryId = null, $comparison = null)
    {
        if (is_array($surgeryId)) {
            $useMinMax = false;
            if (isset($surgeryId['min'])) {
                $this->addUsingAlias(PatientTableMap::COL_SURGERY_ID, $surgeryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($surgeryId['max'])) {
                $this->addUsingAlias(PatientTableMap::COL_SURGERY_ID, $surgeryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PatientTableMap::COL_SURGERY_ID, $surgeryId, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\Person object
     *
     * @param \MocApi\Models\Person|ObjectCollection $person The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPatientQuery The current query, for fluid interface
     */
    public function filterByPerson($person, $comparison = null)
    {
        if ($person instanceof \MocApi\Models\Person) {
            return $this
                ->addUsingAlias(PatientTableMap::COL_PERSON_ID, $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PatientTableMap::COL_PERSON_ID, $person->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPatientQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\Surgery object
     *
     * @param \MocApi\Models\Surgery|ObjectCollection $surgery The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPatientQuery The current query, for fluid interface
     */
    public function filterBySurgery($surgery, $comparison = null)
    {
        if ($surgery instanceof \MocApi\Models\Surgery) {
            return $this
                ->addUsingAlias(PatientTableMap::COL_SURGERY_ID, $surgery->getId(), $comparison);
        } elseif ($surgery instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PatientTableMap::COL_SURGERY_ID, $surgery->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPatientQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\HealthInsuranceCard object
     *
     * @param \MocApi\Models\HealthInsuranceCard|ObjectCollection $healthInsuranceCard the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPatientQuery The current query, for fluid interface
     */
    public function filterByHealthInsuranceCard($healthInsuranceCard, $comparison = null)
    {
        if ($healthInsuranceCard instanceof \MocApi\Models\HealthInsuranceCard) {
            return $this
                ->addUsingAlias(PatientTableMap::COL_PERSON_ID, $healthInsuranceCard->getPatientId(), $comparison);
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
     * @return $this|ChildPatientQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\LegalGuardian object
     *
     * @param \MocApi\Models\LegalGuardian|ObjectCollection $legalGuardian the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPatientQuery The current query, for fluid interface
     */
    public function filterByLegalGuardian($legalGuardian, $comparison = null)
    {
        if ($legalGuardian instanceof \MocApi\Models\LegalGuardian) {
            return $this
                ->addUsingAlias(PatientTableMap::COL_PERSON_ID, $legalGuardian->getPatientId(), $comparison);
        } elseif ($legalGuardian instanceof ObjectCollection) {
            return $this
                ->useLegalGuardianQuery()
                ->filterByPrimaryKeys($legalGuardian->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLegalGuardian() only accepts arguments of type \MocApi\Models\LegalGuardian or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LegalGuardian relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function joinLegalGuardian($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LegalGuardian');

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
            $this->addJoinObject($join, 'LegalGuardian');
        }

        return $this;
    }

    /**
     * Use the LegalGuardian relation LegalGuardian object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\LegalGuardianQuery A secondary query class using the current class as primary query
     */
    public function useLegalGuardianQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLegalGuardian($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LegalGuardian', '\MocApi\Models\LegalGuardianQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPatient $patient Object to remove from the list of results
     *
     * @return $this|ChildPatientQuery The current query, for fluid interface
     */
    public function prune($patient = null)
    {
        if ($patient) {
            $this->addUsingAlias(PatientTableMap::COL_PERSON_ID, $patient->getPersonId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.patient table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PatientTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PatientTableMap::clearInstancePool();
            PatientTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PatientTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PatientTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PatientTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PatientTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PatientQuery
