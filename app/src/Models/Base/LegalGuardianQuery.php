<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\LegalGuardian as ChildLegalGuardian;
use MocApi\Models\LegalGuardianQuery as ChildLegalGuardianQuery;
use MocApi\Models\Map\LegalGuardianTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.legal_guardian' table.
 *
 *
 *
 * @method     ChildLegalGuardianQuery orderByPersonId($order = Criteria::ASC) Order by the person_id column
 * @method     ChildLegalGuardianQuery orderByRelationship($order = Criteria::ASC) Order by the relationship column
 * @method     ChildLegalGuardianQuery orderByCPF($order = Criteria::ASC) Order by the CPF column
 * @method     ChildLegalGuardianQuery orderByPatientId($order = Criteria::ASC) Order by the patient_id column
 *
 * @method     ChildLegalGuardianQuery groupByPersonId() Group by the person_id column
 * @method     ChildLegalGuardianQuery groupByRelationship() Group by the relationship column
 * @method     ChildLegalGuardianQuery groupByCPF() Group by the CPF column
 * @method     ChildLegalGuardianQuery groupByPatientId() Group by the patient_id column
 *
 * @method     ChildLegalGuardianQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLegalGuardianQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLegalGuardianQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLegalGuardianQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildLegalGuardianQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildLegalGuardianQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildLegalGuardianQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     ChildLegalGuardianQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     ChildLegalGuardianQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     ChildLegalGuardianQuery joinWithPerson($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method     ChildLegalGuardianQuery leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method     ChildLegalGuardianQuery rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method     ChildLegalGuardianQuery innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method     ChildLegalGuardianQuery leftJoinPatient($relationAlias = null) Adds a LEFT JOIN clause to the query using the Patient relation
 * @method     ChildLegalGuardianQuery rightJoinPatient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Patient relation
 * @method     ChildLegalGuardianQuery innerJoinPatient($relationAlias = null) Adds a INNER JOIN clause to the query using the Patient relation
 *
 * @method     ChildLegalGuardianQuery joinWithPatient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Patient relation
 *
 * @method     ChildLegalGuardianQuery leftJoinWithPatient() Adds a LEFT JOIN clause and with to the query using the Patient relation
 * @method     ChildLegalGuardianQuery rightJoinWithPatient() Adds a RIGHT JOIN clause and with to the query using the Patient relation
 * @method     ChildLegalGuardianQuery innerJoinWithPatient() Adds a INNER JOIN clause and with to the query using the Patient relation
 *
 * @method     \MocApi\Models\PersonQuery|\MocApi\Models\PatientQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildLegalGuardian findOne(ConnectionInterface $con = null) Return the first ChildLegalGuardian matching the query
 * @method     ChildLegalGuardian findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLegalGuardian matching the query, or a new ChildLegalGuardian object populated from the query conditions when no match is found
 *
 * @method     ChildLegalGuardian findOneByPersonId(int $person_id) Return the first ChildLegalGuardian filtered by the person_id column
 * @method     ChildLegalGuardian findOneByRelationship(string $relationship) Return the first ChildLegalGuardian filtered by the relationship column
 * @method     ChildLegalGuardian findOneByCPF(string $CPF) Return the first ChildLegalGuardian filtered by the CPF column
 * @method     ChildLegalGuardian findOneByPatientId(int $patient_id) Return the first ChildLegalGuardian filtered by the patient_id column *

 * @method     ChildLegalGuardian requirePk($key, ConnectionInterface $con = null) Return the ChildLegalGuardian by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLegalGuardian requireOne(ConnectionInterface $con = null) Return the first ChildLegalGuardian matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLegalGuardian requireOneByPersonId(int $person_id) Return the first ChildLegalGuardian filtered by the person_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLegalGuardian requireOneByRelationship(string $relationship) Return the first ChildLegalGuardian filtered by the relationship column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLegalGuardian requireOneByCPF(string $CPF) Return the first ChildLegalGuardian filtered by the CPF column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLegalGuardian requireOneByPatientId(int $patient_id) Return the first ChildLegalGuardian filtered by the patient_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLegalGuardian[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLegalGuardian objects based on current ModelCriteria
 * @method     ChildLegalGuardian[]|ObjectCollection findByPersonId(int $person_id) Return ChildLegalGuardian objects filtered by the person_id column
 * @method     ChildLegalGuardian[]|ObjectCollection findByRelationship(string $relationship) Return ChildLegalGuardian objects filtered by the relationship column
 * @method     ChildLegalGuardian[]|ObjectCollection findByCPF(string $CPF) Return ChildLegalGuardian objects filtered by the CPF column
 * @method     ChildLegalGuardian[]|ObjectCollection findByPatientId(int $patient_id) Return ChildLegalGuardian objects filtered by the patient_id column
 * @method     ChildLegalGuardian[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LegalGuardianQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\LegalGuardianQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\LegalGuardian', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLegalGuardianQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLegalGuardianQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLegalGuardianQuery) {
            return $criteria;
        }
        $query = new ChildLegalGuardianQuery();
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
     * @return ChildLegalGuardian|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LegalGuardianTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LegalGuardianTableMap::DATABASE_NAME);
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
     * @return ChildLegalGuardian A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT person_id, relationship, CPF, patient_id FROM moc.legal_guardian WHERE person_id = :p0';
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
            /** @var ChildLegalGuardian $obj */
            $obj = new ChildLegalGuardian();
            $obj->hydrate($row);
            LegalGuardianTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildLegalGuardian|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildLegalGuardianQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LegalGuardianTableMap::COL_PERSON_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLegalGuardianQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LegalGuardianTableMap::COL_PERSON_ID, $keys, Criteria::IN);
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
     * @return $this|ChildLegalGuardianQuery The current query, for fluid interface
     */
    public function filterByPersonId($personId = null, $comparison = null)
    {
        if (is_array($personId)) {
            $useMinMax = false;
            if (isset($personId['min'])) {
                $this->addUsingAlias(LegalGuardianTableMap::COL_PERSON_ID, $personId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personId['max'])) {
                $this->addUsingAlias(LegalGuardianTableMap::COL_PERSON_ID, $personId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LegalGuardianTableMap::COL_PERSON_ID, $personId, $comparison);
    }

    /**
     * Filter the query on the relationship column
     *
     * Example usage:
     * <code>
     * $query->filterByRelationship('fooValue');   // WHERE relationship = 'fooValue'
     * $query->filterByRelationship('%fooValue%'); // WHERE relationship LIKE '%fooValue%'
     * </code>
     *
     * @param     string $relationship The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLegalGuardianQuery The current query, for fluid interface
     */
    public function filterByRelationship($relationship = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($relationship)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $relationship)) {
                $relationship = str_replace('*', '%', $relationship);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LegalGuardianTableMap::COL_RELATIONSHIP, $relationship, $comparison);
    }

    /**
     * Filter the query on the CPF column
     *
     * Example usage:
     * <code>
     * $query->filterByCPF('fooValue');   // WHERE CPF = 'fooValue'
     * $query->filterByCPF('%fooValue%'); // WHERE CPF LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cPF The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLegalGuardianQuery The current query, for fluid interface
     */
    public function filterByCPF($cPF = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cPF)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cPF)) {
                $cPF = str_replace('*', '%', $cPF);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(LegalGuardianTableMap::COL_CPF, $cPF, $comparison);
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
     * @return $this|ChildLegalGuardianQuery The current query, for fluid interface
     */
    public function filterByPatientId($patientId = null, $comparison = null)
    {
        if (is_array($patientId)) {
            $useMinMax = false;
            if (isset($patientId['min'])) {
                $this->addUsingAlias(LegalGuardianTableMap::COL_PATIENT_ID, $patientId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($patientId['max'])) {
                $this->addUsingAlias(LegalGuardianTableMap::COL_PATIENT_ID, $patientId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LegalGuardianTableMap::COL_PATIENT_ID, $patientId, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\Person object
     *
     * @param \MocApi\Models\Person|ObjectCollection $person The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildLegalGuardianQuery The current query, for fluid interface
     */
    public function filterByPerson($person, $comparison = null)
    {
        if ($person instanceof \MocApi\Models\Person) {
            return $this
                ->addUsingAlias(LegalGuardianTableMap::COL_PERSON_ID, $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(LegalGuardianTableMap::COL_PERSON_ID, $person->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildLegalGuardianQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\Patient object
     *
     * @param \MocApi\Models\Patient|ObjectCollection $patient The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildLegalGuardianQuery The current query, for fluid interface
     */
    public function filterByPatient($patient, $comparison = null)
    {
        if ($patient instanceof \MocApi\Models\Patient) {
            return $this
                ->addUsingAlias(LegalGuardianTableMap::COL_PATIENT_ID, $patient->getPersonId(), $comparison);
        } elseif ($patient instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(LegalGuardianTableMap::COL_PATIENT_ID, $patient->toKeyValue('PrimaryKey', 'PersonId'), $comparison);
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
     * @return $this|ChildLegalGuardianQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildLegalGuardian $legalGuardian Object to remove from the list of results
     *
     * @return $this|ChildLegalGuardianQuery The current query, for fluid interface
     */
    public function prune($legalGuardian = null)
    {
        if ($legalGuardian) {
            $this->addUsingAlias(LegalGuardianTableMap::COL_PERSON_ID, $legalGuardian->getPersonId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.legal_guardian table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LegalGuardianTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LegalGuardianTableMap::clearInstancePool();
            LegalGuardianTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(LegalGuardianTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LegalGuardianTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            LegalGuardianTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LegalGuardianTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // LegalGuardianQuery
