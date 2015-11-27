<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\Person as ChildPerson;
use MocApi\Models\PersonQuery as ChildPersonQuery;
use MocApi\Models\Map\PersonTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.person' table.
 *
 *
 *
 * @method     ChildPersonQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPersonQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildPersonQuery orderByCPF($order = Criteria::ASC) Order by the CPF column
 * @method     ChildPersonQuery orderByRG($order = Criteria::ASC) Order by the RG column
 * @method     ChildPersonQuery orderByBirthDate($order = Criteria::ASC) Order by the birth_date column
 * @method     ChildPersonQuery orderByGender($order = Criteria::ASC) Order by the gender column
 * @method     ChildPersonQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildPersonQuery groupById() Group by the id column
 * @method     ChildPersonQuery groupByName() Group by the name column
 * @method     ChildPersonQuery groupByCPF() Group by the CPF column
 * @method     ChildPersonQuery groupByRG() Group by the RG column
 * @method     ChildPersonQuery groupByBirthDate() Group by the birth_date column
 * @method     ChildPersonQuery groupByGender() Group by the gender column
 * @method     ChildPersonQuery groupByCreated() Group by the created column
 *
 * @method     ChildPersonQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPersonQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPersonQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPersonQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPersonQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPersonQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPersonQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildPersonQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildPersonQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildPersonQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildPersonQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildPersonQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildPersonQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildPersonQuery leftJoinPatient($relationAlias = null) Adds a LEFT JOIN clause to the query using the Patient relation
 * @method     ChildPersonQuery rightJoinPatient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Patient relation
 * @method     ChildPersonQuery innerJoinPatient($relationAlias = null) Adds a INNER JOIN clause to the query using the Patient relation
 *
 * @method     ChildPersonQuery joinWithPatient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Patient relation
 *
 * @method     ChildPersonQuery leftJoinWithPatient() Adds a LEFT JOIN clause and with to the query using the Patient relation
 * @method     ChildPersonQuery rightJoinWithPatient() Adds a RIGHT JOIN clause and with to the query using the Patient relation
 * @method     ChildPersonQuery innerJoinWithPatient() Adds a INNER JOIN clause and with to the query using the Patient relation
 *
 * @method     ChildPersonQuery leftJoinPhoneNumber($relationAlias = null) Adds a LEFT JOIN clause to the query using the PhoneNumber relation
 * @method     ChildPersonQuery rightJoinPhoneNumber($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PhoneNumber relation
 * @method     ChildPersonQuery innerJoinPhoneNumber($relationAlias = null) Adds a INNER JOIN clause to the query using the PhoneNumber relation
 *
 * @method     ChildPersonQuery joinWithPhoneNumber($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PhoneNumber relation
 *
 * @method     ChildPersonQuery leftJoinWithPhoneNumber() Adds a LEFT JOIN clause and with to the query using the PhoneNumber relation
 * @method     ChildPersonQuery rightJoinWithPhoneNumber() Adds a RIGHT JOIN clause and with to the query using the PhoneNumber relation
 * @method     ChildPersonQuery innerJoinWithPhoneNumber() Adds a INNER JOIN clause and with to the query using the PhoneNumber relation
 *
 * @method     ChildPersonQuery leftJoinSurgeon($relationAlias = null) Adds a LEFT JOIN clause to the query using the Surgeon relation
 * @method     ChildPersonQuery rightJoinSurgeon($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Surgeon relation
 * @method     ChildPersonQuery innerJoinSurgeon($relationAlias = null) Adds a INNER JOIN clause to the query using the Surgeon relation
 *
 * @method     ChildPersonQuery joinWithSurgeon($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Surgeon relation
 *
 * @method     ChildPersonQuery leftJoinWithSurgeon() Adds a LEFT JOIN clause and with to the query using the Surgeon relation
 * @method     ChildPersonQuery rightJoinWithSurgeon() Adds a RIGHT JOIN clause and with to the query using the Surgeon relation
 * @method     ChildPersonQuery innerJoinWithSurgeon() Adds a INNER JOIN clause and with to the query using the Surgeon relation
 *
 * @method     ChildPersonQuery leftJoinSurgery($relationAlias = null) Adds a LEFT JOIN clause to the query using the Surgery relation
 * @method     ChildPersonQuery rightJoinSurgery($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Surgery relation
 * @method     ChildPersonQuery innerJoinSurgery($relationAlias = null) Adds a INNER JOIN clause to the query using the Surgery relation
 *
 * @method     ChildPersonQuery joinWithSurgery($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Surgery relation
 *
 * @method     ChildPersonQuery leftJoinWithSurgery() Adds a LEFT JOIN clause and with to the query using the Surgery relation
 * @method     ChildPersonQuery rightJoinWithSurgery() Adds a RIGHT JOIN clause and with to the query using the Surgery relation
 * @method     ChildPersonQuery innerJoinWithSurgery() Adds a INNER JOIN clause and with to the query using the Surgery relation
 *
 * @method     ChildPersonQuery leftJoinLegalGuardian($relationAlias = null) Adds a LEFT JOIN clause to the query using the LegalGuardian relation
 * @method     ChildPersonQuery rightJoinLegalGuardian($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LegalGuardian relation
 * @method     ChildPersonQuery innerJoinLegalGuardian($relationAlias = null) Adds a INNER JOIN clause to the query using the LegalGuardian relation
 *
 * @method     ChildPersonQuery joinWithLegalGuardian($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the LegalGuardian relation
 *
 * @method     ChildPersonQuery leftJoinWithLegalGuardian() Adds a LEFT JOIN clause and with to the query using the LegalGuardian relation
 * @method     ChildPersonQuery rightJoinWithLegalGuardian() Adds a RIGHT JOIN clause and with to the query using the LegalGuardian relation
 * @method     ChildPersonQuery innerJoinWithLegalGuardian() Adds a INNER JOIN clause and with to the query using the LegalGuardian relation
 *
 * @method     ChildPersonQuery leftJoinMedicalStaff($relationAlias = null) Adds a LEFT JOIN clause to the query using the MedicalStaff relation
 * @method     ChildPersonQuery rightJoinMedicalStaff($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MedicalStaff relation
 * @method     ChildPersonQuery innerJoinMedicalStaff($relationAlias = null) Adds a INNER JOIN clause to the query using the MedicalStaff relation
 *
 * @method     ChildPersonQuery joinWithMedicalStaff($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MedicalStaff relation
 *
 * @method     ChildPersonQuery leftJoinWithMedicalStaff() Adds a LEFT JOIN clause and with to the query using the MedicalStaff relation
 * @method     ChildPersonQuery rightJoinWithMedicalStaff() Adds a RIGHT JOIN clause and with to the query using the MedicalStaff relation
 * @method     ChildPersonQuery innerJoinWithMedicalStaff() Adds a INNER JOIN clause and with to the query using the MedicalStaff relation
 *
 * @method     \MocApi\Models\UserQuery|\MocApi\Models\PatientQuery|\MocApi\Models\PhoneNumberQuery|\MocApi\Models\SurgeonQuery|\MocApi\Models\SurgeryQuery|\MocApi\Models\LegalGuardianQuery|\MocApi\Models\MedicalStaffQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPerson findOne(ConnectionInterface $con = null) Return the first ChildPerson matching the query
 * @method     ChildPerson findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPerson matching the query, or a new ChildPerson object populated from the query conditions when no match is found
 *
 * @method     ChildPerson findOneById(int $id) Return the first ChildPerson filtered by the id column
 * @method     ChildPerson findOneByName(string $name) Return the first ChildPerson filtered by the name column
 * @method     ChildPerson findOneByCPF(string $CPF) Return the first ChildPerson filtered by the CPF column
 * @method     ChildPerson findOneByRG(string $RG) Return the first ChildPerson filtered by the RG column
 * @method     ChildPerson findOneByBirthDate(string $birth_date) Return the first ChildPerson filtered by the birth_date column
 * @method     ChildPerson findOneByGender(int $gender) Return the first ChildPerson filtered by the gender column
 * @method     ChildPerson findOneByCreated(string $created) Return the first ChildPerson filtered by the created column *

 * @method     ChildPerson requirePk($key, ConnectionInterface $con = null) Return the ChildPerson by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOne(ConnectionInterface $con = null) Return the first ChildPerson matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPerson requireOneById(int $id) Return the first ChildPerson filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByName(string $name) Return the first ChildPerson filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByCPF(string $CPF) Return the first ChildPerson filtered by the CPF column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByRG(string $RG) Return the first ChildPerson filtered by the RG column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByBirthDate(string $birth_date) Return the first ChildPerson filtered by the birth_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByGender(int $gender) Return the first ChildPerson filtered by the gender column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPerson requireOneByCreated(string $created) Return the first ChildPerson filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPerson[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPerson objects based on current ModelCriteria
 * @method     ChildPerson[]|ObjectCollection findById(int $id) Return ChildPerson objects filtered by the id column
 * @method     ChildPerson[]|ObjectCollection findByName(string $name) Return ChildPerson objects filtered by the name column
 * @method     ChildPerson[]|ObjectCollection findByCPF(string $CPF) Return ChildPerson objects filtered by the CPF column
 * @method     ChildPerson[]|ObjectCollection findByRG(string $RG) Return ChildPerson objects filtered by the RG column
 * @method     ChildPerson[]|ObjectCollection findByBirthDate(string $birth_date) Return ChildPerson objects filtered by the birth_date column
 * @method     ChildPerson[]|ObjectCollection findByGender(int $gender) Return ChildPerson objects filtered by the gender column
 * @method     ChildPerson[]|ObjectCollection findByCreated(string $created) Return ChildPerson objects filtered by the created column
 * @method     ChildPerson[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PersonQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\PersonQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\Person', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPersonQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPersonQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPersonQuery) {
            return $criteria;
        }
        $query = new ChildPersonQuery();
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
     * @return ChildPerson|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PersonTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PersonTableMap::DATABASE_NAME);
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
     * @return ChildPerson A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, CPF, RG, birth_date, gender, created FROM moc.person WHERE id = :p0';
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
            /** @var ChildPerson $obj */
            $obj = new ChildPerson();
            $obj->hydrate($row);
            PersonTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPerson|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PersonTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PersonTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PersonTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PersonTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PersonTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PersonTableMap::COL_CPF, $cPF, $comparison);
    }

    /**
     * Filter the query on the RG column
     *
     * Example usage:
     * <code>
     * $query->filterByRG('fooValue');   // WHERE RG = 'fooValue'
     * $query->filterByRG('%fooValue%'); // WHERE RG LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rG The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByRG($rG = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rG)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rG)) {
                $rG = str_replace('*', '%', $rG);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_RG, $rG, $comparison);
    }

    /**
     * Filter the query on the birth_date column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthDate('2011-03-14'); // WHERE birth_date = '2011-03-14'
     * $query->filterByBirthDate('now'); // WHERE birth_date = '2011-03-14'
     * $query->filterByBirthDate(array('max' => 'yesterday')); // WHERE birth_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $birthDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByBirthDate($birthDate = null, $comparison = null)
    {
        if (is_array($birthDate)) {
            $useMinMax = false;
            if (isset($birthDate['min'])) {
                $this->addUsingAlias(PersonTableMap::COL_BIRTH_DATE, $birthDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthDate['max'])) {
                $this->addUsingAlias(PersonTableMap::COL_BIRTH_DATE, $birthDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_BIRTH_DATE, $birthDate, $comparison);
    }

    /**
     * Filter the query on the gender column
     *
     * @param     mixed $gender The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByGender($gender = null, $comparison = null)
    {
        $valueSet = PersonTableMap::getValueSet(PersonTableMap::COL_GENDER);
        if (is_scalar($gender)) {
            if (!in_array($gender, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $gender));
            }
            $gender = array_search($gender, $valueSet);
        } elseif (is_array($gender)) {
            $convertedValues = array();
            foreach ($gender as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $gender = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_GENDER, $gender, $comparison);
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(PersonTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(PersonTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PersonTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\User object
     *
     * @param \MocApi\Models\User|ObjectCollection $user the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \MocApi\Models\User) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $user->getPersonId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            return $this
                ->useUserQuery()
                ->filterByPrimaryKeys($user->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \MocApi\Models\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\MocApi\Models\UserQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\Patient object
     *
     * @param \MocApi\Models\Patient|ObjectCollection $patient the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterByPatient($patient, $comparison = null)
    {
        if ($patient instanceof \MocApi\Models\Patient) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $patient->getPersonId(), $comparison);
        } elseif ($patient instanceof ObjectCollection) {
            return $this
                ->usePatientQuery()
                ->filterByPrimaryKeys($patient->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\PhoneNumber object
     *
     * @param \MocApi\Models\PhoneNumber|ObjectCollection $phoneNumber the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterByPhoneNumber($phoneNumber, $comparison = null)
    {
        if ($phoneNumber instanceof \MocApi\Models\PhoneNumber) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $phoneNumber->getPersonId(), $comparison);
        } elseif ($phoneNumber instanceof ObjectCollection) {
            return $this
                ->usePhoneNumberQuery()
                ->filterByPrimaryKeys($phoneNumber->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPhoneNumber() only accepts arguments of type \MocApi\Models\PhoneNumber or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PhoneNumber relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function joinPhoneNumber($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PhoneNumber');

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
            $this->addJoinObject($join, 'PhoneNumber');
        }

        return $this;
    }

    /**
     * Use the PhoneNumber relation PhoneNumber object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\PhoneNumberQuery A secondary query class using the current class as primary query
     */
    public function usePhoneNumberQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPhoneNumber($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PhoneNumber', '\MocApi\Models\PhoneNumberQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\Surgeon object
     *
     * @param \MocApi\Models\Surgeon|ObjectCollection $surgeon the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterBySurgeon($surgeon, $comparison = null)
    {
        if ($surgeon instanceof \MocApi\Models\Surgeon) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $surgeon->getPersonId(), $comparison);
        } elseif ($surgeon instanceof ObjectCollection) {
            return $this
                ->useSurgeonQuery()
                ->filterByPrimaryKeys($surgeon->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\Surgery object
     *
     * @param \MocApi\Models\Surgery|ObjectCollection $surgery the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterBySurgery($surgery, $comparison = null)
    {
        if ($surgery instanceof \MocApi\Models\Surgery) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $surgery->getCreatorId(), $comparison);
        } elseif ($surgery instanceof ObjectCollection) {
            return $this
                ->useSurgeryQuery()
                ->filterByPrimaryKeys($surgery->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\LegalGuardian object
     *
     * @param \MocApi\Models\LegalGuardian|ObjectCollection $legalGuardian the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterByLegalGuardian($legalGuardian, $comparison = null)
    {
        if ($legalGuardian instanceof \MocApi\Models\LegalGuardian) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $legalGuardian->getPersonId(), $comparison);
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\MedicalStaff object
     *
     * @param \MocApi\Models\MedicalStaff|ObjectCollection $medicalStaff the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPersonQuery The current query, for fluid interface
     */
    public function filterByMedicalStaff($medicalStaff, $comparison = null)
    {
        if ($medicalStaff instanceof \MocApi\Models\MedicalStaff) {
            return $this
                ->addUsingAlias(PersonTableMap::COL_ID, $medicalStaff->getPersonId(), $comparison);
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
     * @return $this|ChildPersonQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildPerson $person Object to remove from the list of results
     *
     * @return $this|ChildPersonQuery The current query, for fluid interface
     */
    public function prune($person = null)
    {
        if ($person) {
            $this->addUsingAlias(PersonTableMap::COL_ID, $person->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.person table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PersonTableMap::clearInstancePool();
            PersonTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PersonTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PersonTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PersonTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PersonQuery
