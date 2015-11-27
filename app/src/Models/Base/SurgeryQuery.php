<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\Surgery as ChildSurgery;
use MocApi\Models\SurgeryQuery as ChildSurgeryQuery;
use MocApi\Models\Map\SurgeryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.surgery' table.
 *
 *
 *
 * @method     ChildSurgeryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSurgeryQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildSurgeryQuery orderByCreatorId($order = Criteria::ASC) Order by the creator_id column
 * @method     ChildSurgeryQuery orderBySurgeryTypeId($order = Criteria::ASC) Order by the surgery_type_id column
 * @method     ChildSurgeryQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildSurgeryQuery groupById() Group by the id column
 * @method     ChildSurgeryQuery groupByStatus() Group by the status column
 * @method     ChildSurgeryQuery groupByCreatorId() Group by the creator_id column
 * @method     ChildSurgeryQuery groupBySurgeryTypeId() Group by the surgery_type_id column
 * @method     ChildSurgeryQuery groupByCreated() Group by the created column
 *
 * @method     ChildSurgeryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSurgeryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSurgeryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSurgeryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSurgeryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSurgeryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSurgeryQuery leftJoinCreator($relationAlias = null) Adds a LEFT JOIN clause to the query using the Creator relation
 * @method     ChildSurgeryQuery rightJoinCreator($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Creator relation
 * @method     ChildSurgeryQuery innerJoinCreator($relationAlias = null) Adds a INNER JOIN clause to the query using the Creator relation
 *
 * @method     ChildSurgeryQuery joinWithCreator($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Creator relation
 *
 * @method     ChildSurgeryQuery leftJoinWithCreator() Adds a LEFT JOIN clause and with to the query using the Creator relation
 * @method     ChildSurgeryQuery rightJoinWithCreator() Adds a RIGHT JOIN clause and with to the query using the Creator relation
 * @method     ChildSurgeryQuery innerJoinWithCreator() Adds a INNER JOIN clause and with to the query using the Creator relation
 *
 * @method     ChildSurgeryQuery leftJoinSurgeryType($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeryType relation
 * @method     ChildSurgeryQuery rightJoinSurgeryType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeryType relation
 * @method     ChildSurgeryQuery innerJoinSurgeryType($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeryType relation
 *
 * @method     ChildSurgeryQuery joinWithSurgeryType($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeryType relation
 *
 * @method     ChildSurgeryQuery leftJoinWithSurgeryType() Adds a LEFT JOIN clause and with to the query using the SurgeryType relation
 * @method     ChildSurgeryQuery rightJoinWithSurgeryType() Adds a RIGHT JOIN clause and with to the query using the SurgeryType relation
 * @method     ChildSurgeryQuery innerJoinWithSurgeryType() Adds a INNER JOIN clause and with to the query using the SurgeryType relation
 *
 * @method     ChildSurgeryQuery leftJoinPatient($relationAlias = null) Adds a LEFT JOIN clause to the query using the Patient relation
 * @method     ChildSurgeryQuery rightJoinPatient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Patient relation
 * @method     ChildSurgeryQuery innerJoinPatient($relationAlias = null) Adds a INNER JOIN clause to the query using the Patient relation
 *
 * @method     ChildSurgeryQuery joinWithPatient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Patient relation
 *
 * @method     ChildSurgeryQuery leftJoinWithPatient() Adds a LEFT JOIN clause and with to the query using the Patient relation
 * @method     ChildSurgeryQuery rightJoinWithPatient() Adds a RIGHT JOIN clause and with to the query using the Patient relation
 * @method     ChildSurgeryQuery innerJoinWithPatient() Adds a INNER JOIN clause and with to the query using the Patient relation
 *
 * @method     ChildSurgeryQuery leftJoinSurgeonSurgery($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeonSurgery relation
 * @method     ChildSurgeryQuery rightJoinSurgeonSurgery($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeonSurgery relation
 * @method     ChildSurgeryQuery innerJoinSurgeonSurgery($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeonSurgery relation
 *
 * @method     ChildSurgeryQuery joinWithSurgeonSurgery($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeonSurgery relation
 *
 * @method     ChildSurgeryQuery leftJoinWithSurgeonSurgery() Adds a LEFT JOIN clause and with to the query using the SurgeonSurgery relation
 * @method     ChildSurgeryQuery rightJoinWithSurgeonSurgery() Adds a RIGHT JOIN clause and with to the query using the SurgeonSurgery relation
 * @method     ChildSurgeryQuery innerJoinWithSurgeonSurgery() Adds a INNER JOIN clause and with to the query using the SurgeonSurgery relation
 *
 * @method     ChildSurgeryQuery leftJoinSurgeryEquipment($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeryEquipment relation
 * @method     ChildSurgeryQuery rightJoinSurgeryEquipment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeryEquipment relation
 * @method     ChildSurgeryQuery innerJoinSurgeryEquipment($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeryEquipment relation
 *
 * @method     ChildSurgeryQuery joinWithSurgeryEquipment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeryEquipment relation
 *
 * @method     ChildSurgeryQuery leftJoinWithSurgeryEquipment() Adds a LEFT JOIN clause and with to the query using the SurgeryEquipment relation
 * @method     ChildSurgeryQuery rightJoinWithSurgeryEquipment() Adds a RIGHT JOIN clause and with to the query using the SurgeryEquipment relation
 * @method     ChildSurgeryQuery innerJoinWithSurgeryEquipment() Adds a INNER JOIN clause and with to the query using the SurgeryEquipment relation
 *
 * @method     ChildSurgeryQuery leftJoinSurgeryFieldValue($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeryFieldValue relation
 * @method     ChildSurgeryQuery rightJoinSurgeryFieldValue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeryFieldValue relation
 * @method     ChildSurgeryQuery innerJoinSurgeryFieldValue($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeryFieldValue relation
 *
 * @method     ChildSurgeryQuery joinWithSurgeryFieldValue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeryFieldValue relation
 *
 * @method     ChildSurgeryQuery leftJoinWithSurgeryFieldValue() Adds a LEFT JOIN clause and with to the query using the SurgeryFieldValue relation
 * @method     ChildSurgeryQuery rightJoinWithSurgeryFieldValue() Adds a RIGHT JOIN clause and with to the query using the SurgeryFieldValue relation
 * @method     ChildSurgeryQuery innerJoinWithSurgeryFieldValue() Adds a INNER JOIN clause and with to the query using the SurgeryFieldValue relation
 *
 * @method     ChildSurgeryQuery leftJoinSurgeryMaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeryMaterial relation
 * @method     ChildSurgeryQuery rightJoinSurgeryMaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeryMaterial relation
 * @method     ChildSurgeryQuery innerJoinSurgeryMaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeryMaterial relation
 *
 * @method     ChildSurgeryQuery joinWithSurgeryMaterial($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeryMaterial relation
 *
 * @method     ChildSurgeryQuery leftJoinWithSurgeryMaterial() Adds a LEFT JOIN clause and with to the query using the SurgeryMaterial relation
 * @method     ChildSurgeryQuery rightJoinWithSurgeryMaterial() Adds a RIGHT JOIN clause and with to the query using the SurgeryMaterial relation
 * @method     ChildSurgeryQuery innerJoinWithSurgeryMaterial() Adds a INNER JOIN clause and with to the query using the SurgeryMaterial relation
 *
 * @method     ChildSurgeryQuery leftJoinSurgeryTUSS($relationAlias = null) Adds a LEFT JOIN clause to the query using the SurgeryTUSS relation
 * @method     ChildSurgeryQuery rightJoinSurgeryTUSS($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SurgeryTUSS relation
 * @method     ChildSurgeryQuery innerJoinSurgeryTUSS($relationAlias = null) Adds a INNER JOIN clause to the query using the SurgeryTUSS relation
 *
 * @method     ChildSurgeryQuery joinWithSurgeryTUSS($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SurgeryTUSS relation
 *
 * @method     ChildSurgeryQuery leftJoinWithSurgeryTUSS() Adds a LEFT JOIN clause and with to the query using the SurgeryTUSS relation
 * @method     ChildSurgeryQuery rightJoinWithSurgeryTUSS() Adds a RIGHT JOIN clause and with to the query using the SurgeryTUSS relation
 * @method     ChildSurgeryQuery innerJoinWithSurgeryTUSS() Adds a INNER JOIN clause and with to the query using the SurgeryTUSS relation
 *
 * @method     \MocApi\Models\PersonQuery|\MocApi\Models\SurgeryTypeQuery|\MocApi\Models\PatientQuery|\MocApi\Models\SurgeonSurgeryQuery|\MocApi\Models\SurgeryEquipmentQuery|\MocApi\Models\SurgeryFieldValueQuery|\MocApi\Models\SurgeryMaterialQuery|\MocApi\Models\SurgeryTUSSQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSurgery findOne(ConnectionInterface $con = null) Return the first ChildSurgery matching the query
 * @method     ChildSurgery findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSurgery matching the query, or a new ChildSurgery object populated from the query conditions when no match is found
 *
 * @method     ChildSurgery findOneById(int $id) Return the first ChildSurgery filtered by the id column
 * @method     ChildSurgery findOneByStatus(string $status) Return the first ChildSurgery filtered by the status column
 * @method     ChildSurgery findOneByCreatorId(int $creator_id) Return the first ChildSurgery filtered by the creator_id column
 * @method     ChildSurgery findOneBySurgeryTypeId(int $surgery_type_id) Return the first ChildSurgery filtered by the surgery_type_id column
 * @method     ChildSurgery findOneByCreated(string $created) Return the first ChildSurgery filtered by the created column *

 * @method     ChildSurgery requirePk($key, ConnectionInterface $con = null) Return the ChildSurgery by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgery requireOne(ConnectionInterface $con = null) Return the first ChildSurgery matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSurgery requireOneById(int $id) Return the first ChildSurgery filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgery requireOneByStatus(string $status) Return the first ChildSurgery filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgery requireOneByCreatorId(int $creator_id) Return the first ChildSurgery filtered by the creator_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgery requireOneBySurgeryTypeId(int $surgery_type_id) Return the first ChildSurgery filtered by the surgery_type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSurgery requireOneByCreated(string $created) Return the first ChildSurgery filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSurgery[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSurgery objects based on current ModelCriteria
 * @method     ChildSurgery[]|ObjectCollection findById(int $id) Return ChildSurgery objects filtered by the id column
 * @method     ChildSurgery[]|ObjectCollection findByStatus(string $status) Return ChildSurgery objects filtered by the status column
 * @method     ChildSurgery[]|ObjectCollection findByCreatorId(int $creator_id) Return ChildSurgery objects filtered by the creator_id column
 * @method     ChildSurgery[]|ObjectCollection findBySurgeryTypeId(int $surgery_type_id) Return ChildSurgery objects filtered by the surgery_type_id column
 * @method     ChildSurgery[]|ObjectCollection findByCreated(string $created) Return ChildSurgery objects filtered by the created column
 * @method     ChildSurgery[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SurgeryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\SurgeryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\Surgery', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSurgeryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSurgeryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSurgeryQuery) {
            return $criteria;
        }
        $query = new ChildSurgeryQuery();
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
     * @return ChildSurgery|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SurgeryTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SurgeryTableMap::DATABASE_NAME);
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
     * @return ChildSurgery A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, status, creator_id, surgery_type_id, created FROM moc.surgery WHERE id = :p0';
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
            /** @var ChildSurgery $obj */
            $obj = new ChildSurgery();
            $obj->hydrate($row);
            SurgeryTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSurgery|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SurgeryTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SurgeryTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SurgeryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SurgeryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SurgeryTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SurgeryTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the creator_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatorId(1234); // WHERE creator_id = 1234
     * $query->filterByCreatorId(array(12, 34)); // WHERE creator_id IN (12, 34)
     * $query->filterByCreatorId(array('min' => 12)); // WHERE creator_id > 12
     * </code>
     *
     * @see       filterByCreator()
     *
     * @param     mixed $creatorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterByCreatorId($creatorId = null, $comparison = null)
    {
        if (is_array($creatorId)) {
            $useMinMax = false;
            if (isset($creatorId['min'])) {
                $this->addUsingAlias(SurgeryTableMap::COL_CREATOR_ID, $creatorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($creatorId['max'])) {
                $this->addUsingAlias(SurgeryTableMap::COL_CREATOR_ID, $creatorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SurgeryTableMap::COL_CREATOR_ID, $creatorId, $comparison);
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
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterBySurgeryTypeId($surgeryTypeId = null, $comparison = null)
    {
        if (is_array($surgeryTypeId)) {
            $useMinMax = false;
            if (isset($surgeryTypeId['min'])) {
                $this->addUsingAlias(SurgeryTableMap::COL_SURGERY_TYPE_ID, $surgeryTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($surgeryTypeId['max'])) {
                $this->addUsingAlias(SurgeryTableMap::COL_SURGERY_TYPE_ID, $surgeryTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SurgeryTableMap::COL_SURGERY_TYPE_ID, $surgeryTypeId, $comparison);
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
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(SurgeryTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(SurgeryTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SurgeryTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\Person object
     *
     * @param \MocApi\Models\Person|ObjectCollection $person The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterByCreator($person, $comparison = null)
    {
        if ($person instanceof \MocApi\Models\Person) {
            return $this
                ->addUsingAlias(SurgeryTableMap::COL_CREATOR_ID, $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SurgeryTableMap::COL_CREATOR_ID, $person->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCreator() only accepts arguments of type \MocApi\Models\Person or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Creator relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function joinCreator($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Creator');

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
            $this->addJoinObject($join, 'Creator');
        }

        return $this;
    }

    /**
     * Use the Creator relation Person object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\PersonQuery A secondary query class using the current class as primary query
     */
    public function useCreatorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCreator($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Creator', '\MocApi\Models\PersonQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\SurgeryType object
     *
     * @param \MocApi\Models\SurgeryType|ObjectCollection $surgeryType The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterBySurgeryType($surgeryType, $comparison = null)
    {
        if ($surgeryType instanceof \MocApi\Models\SurgeryType) {
            return $this
                ->addUsingAlias(SurgeryTableMap::COL_SURGERY_TYPE_ID, $surgeryType->getId(), $comparison);
        } elseif ($surgeryType instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SurgeryTableMap::COL_SURGERY_TYPE_ID, $surgeryType->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\Patient object
     *
     * @param \MocApi\Models\Patient|ObjectCollection $patient the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterByPatient($patient, $comparison = null)
    {
        if ($patient instanceof \MocApi\Models\Patient) {
            return $this
                ->addUsingAlias(SurgeryTableMap::COL_ID, $patient->getSurgeryId(), $comparison);
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
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\SurgeonSurgery object
     *
     * @param \MocApi\Models\SurgeonSurgery|ObjectCollection $surgeonSurgery the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterBySurgeonSurgery($surgeonSurgery, $comparison = null)
    {
        if ($surgeonSurgery instanceof \MocApi\Models\SurgeonSurgery) {
            return $this
                ->addUsingAlias(SurgeryTableMap::COL_ID, $surgeonSurgery->getSurgeryId(), $comparison);
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
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\SurgeryEquipment object
     *
     * @param \MocApi\Models\SurgeryEquipment|ObjectCollection $surgeryEquipment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterBySurgeryEquipment($surgeryEquipment, $comparison = null)
    {
        if ($surgeryEquipment instanceof \MocApi\Models\SurgeryEquipment) {
            return $this
                ->addUsingAlias(SurgeryTableMap::COL_ID, $surgeryEquipment->getSurgeryId(), $comparison);
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
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
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
     * Filter the query by a related \MocApi\Models\SurgeryFieldValue object
     *
     * @param \MocApi\Models\SurgeryFieldValue|ObjectCollection $surgeryFieldValue the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterBySurgeryFieldValue($surgeryFieldValue, $comparison = null)
    {
        if ($surgeryFieldValue instanceof \MocApi\Models\SurgeryFieldValue) {
            return $this
                ->addUsingAlias(SurgeryTableMap::COL_ID, $surgeryFieldValue->getSurgeryId(), $comparison);
        } elseif ($surgeryFieldValue instanceof ObjectCollection) {
            return $this
                ->useSurgeryFieldValueQuery()
                ->filterByPrimaryKeys($surgeryFieldValue->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySurgeryFieldValue() only accepts arguments of type \MocApi\Models\SurgeryFieldValue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SurgeryFieldValue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function joinSurgeryFieldValue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SurgeryFieldValue');

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
            $this->addJoinObject($join, 'SurgeryFieldValue');
        }

        return $this;
    }

    /**
     * Use the SurgeryFieldValue relation SurgeryFieldValue object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\SurgeryFieldValueQuery A secondary query class using the current class as primary query
     */
    public function useSurgeryFieldValueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSurgeryFieldValue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SurgeryFieldValue', '\MocApi\Models\SurgeryFieldValueQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\SurgeryMaterial object
     *
     * @param \MocApi\Models\SurgeryMaterial|ObjectCollection $surgeryMaterial the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterBySurgeryMaterial($surgeryMaterial, $comparison = null)
    {
        if ($surgeryMaterial instanceof \MocApi\Models\SurgeryMaterial) {
            return $this
                ->addUsingAlias(SurgeryTableMap::COL_ID, $surgeryMaterial->getSurgeryId(), $comparison);
        } elseif ($surgeryMaterial instanceof ObjectCollection) {
            return $this
                ->useSurgeryMaterialQuery()
                ->filterByPrimaryKeys($surgeryMaterial->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySurgeryMaterial() only accepts arguments of type \MocApi\Models\SurgeryMaterial or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SurgeryMaterial relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function joinSurgeryMaterial($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SurgeryMaterial');

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
            $this->addJoinObject($join, 'SurgeryMaterial');
        }

        return $this;
    }

    /**
     * Use the SurgeryMaterial relation SurgeryMaterial object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\SurgeryMaterialQuery A secondary query class using the current class as primary query
     */
    public function useSurgeryMaterialQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSurgeryMaterial($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SurgeryMaterial', '\MocApi\Models\SurgeryMaterialQuery');
    }

    /**
     * Filter the query by a related \MocApi\Models\SurgeryTUSS object
     *
     * @param \MocApi\Models\SurgeryTUSS|ObjectCollection $surgeryTUSS the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterBySurgeryTUSS($surgeryTUSS, $comparison = null)
    {
        if ($surgeryTUSS instanceof \MocApi\Models\SurgeryTUSS) {
            return $this
                ->addUsingAlias(SurgeryTableMap::COL_ID, $surgeryTUSS->getSurgeryId(), $comparison);
        } elseif ($surgeryTUSS instanceof ObjectCollection) {
            return $this
                ->useSurgeryTUSSQuery()
                ->filterByPrimaryKeys($surgeryTUSS->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySurgeryTUSS() only accepts arguments of type \MocApi\Models\SurgeryTUSS or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SurgeryTUSS relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function joinSurgeryTUSS($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SurgeryTUSS');

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
            $this->addJoinObject($join, 'SurgeryTUSS');
        }

        return $this;
    }

    /**
     * Use the SurgeryTUSS relation SurgeryTUSS object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MocApi\Models\SurgeryTUSSQuery A secondary query class using the current class as primary query
     */
    public function useSurgeryTUSSQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSurgeryTUSS($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SurgeryTUSS', '\MocApi\Models\SurgeryTUSSQuery');
    }

    /**
     * Filter the query by a related Surgeon object
     * using the moc.surgeon_surgery table as cross reference
     *
     * @param Surgeon $surgeon the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterBySurgeon($surgeon, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useSurgeonSurgeryQuery()
            ->filterBySurgeon($surgeon, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Equipment object
     * using the moc.surgery_equipment table as cross reference
     *
     * @param Equipment $equipment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterByEquipment($equipment, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useSurgeryEquipmentQuery()
            ->filterByEquipment($equipment, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Material object
     * using the moc.surgery_material table as cross reference
     *
     * @param Material $material the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterByMaterial($material, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useSurgeryMaterialQuery()
            ->filterByMaterial($material, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related TUSS object
     * using the moc.surgery_TUSS table as cross reference
     *
     * @param TUSS $tUSS the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSurgeryQuery The current query, for fluid interface
     */
    public function filterByTUSS($tUSS, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useSurgeryTUSSQuery()
            ->filterByTUSS($tUSS, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSurgery $surgery Object to remove from the list of results
     *
     * @return $this|ChildSurgeryQuery The current query, for fluid interface
     */
    public function prune($surgery = null)
    {
        if ($surgery) {
            $this->addUsingAlias(SurgeryTableMap::COL_ID, $surgery->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.surgery table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SurgeryTableMap::clearInstancePool();
            SurgeryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SurgeryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SurgeryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SurgeryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SurgeryQuery
