<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\Address as ChildAddress;
use MocApi\Models\AddressQuery as ChildAddressQuery;
use MocApi\Models\Map\AddressTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'moc.address' table.
 *
 *
 *
 * @method     ChildAddressQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAddressQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildAddressQuery orderByComplement($order = Criteria::ASC) Order by the complement column
 * @method     ChildAddressQuery orderByNeighborhood($order = Criteria::ASC) Order by the neighborhood column
 * @method     ChildAddressQuery orderByNumber($order = Criteria::ASC) Order by the number column
 * @method     ChildAddressQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildAddressQuery orderByStreet($order = Criteria::ASC) Order by the street column
 * @method     ChildAddressQuery orderByCEP($order = Criteria::ASC) Order by the CEP column
 * @method     ChildAddressQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildAddressQuery orderBySurgeonId($order = Criteria::ASC) Order by the surgeon_id column
 * @method     ChildAddressQuery orderByCreated($order = Criteria::ASC) Order by the created column
 *
 * @method     ChildAddressQuery groupById() Group by the id column
 * @method     ChildAddressQuery groupByCity() Group by the city column
 * @method     ChildAddressQuery groupByComplement() Group by the complement column
 * @method     ChildAddressQuery groupByNeighborhood() Group by the neighborhood column
 * @method     ChildAddressQuery groupByNumber() Group by the number column
 * @method     ChildAddressQuery groupByState() Group by the state column
 * @method     ChildAddressQuery groupByStreet() Group by the street column
 * @method     ChildAddressQuery groupByCEP() Group by the CEP column
 * @method     ChildAddressQuery groupByType() Group by the type column
 * @method     ChildAddressQuery groupBySurgeonId() Group by the surgeon_id column
 * @method     ChildAddressQuery groupByCreated() Group by the created column
 *
 * @method     ChildAddressQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAddressQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAddressQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAddressQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAddressQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAddressQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAddressQuery leftJoinSurgeon($relationAlias = null) Adds a LEFT JOIN clause to the query using the Surgeon relation
 * @method     ChildAddressQuery rightJoinSurgeon($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Surgeon relation
 * @method     ChildAddressQuery innerJoinSurgeon($relationAlias = null) Adds a INNER JOIN clause to the query using the Surgeon relation
 *
 * @method     ChildAddressQuery joinWithSurgeon($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Surgeon relation
 *
 * @method     ChildAddressQuery leftJoinWithSurgeon() Adds a LEFT JOIN clause and with to the query using the Surgeon relation
 * @method     ChildAddressQuery rightJoinWithSurgeon() Adds a RIGHT JOIN clause and with to the query using the Surgeon relation
 * @method     ChildAddressQuery innerJoinWithSurgeon() Adds a INNER JOIN clause and with to the query using the Surgeon relation
 *
 * @method     \MocApi\Models\SurgeonQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAddress findOne(ConnectionInterface $con = null) Return the first ChildAddress matching the query
 * @method     ChildAddress findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAddress matching the query, or a new ChildAddress object populated from the query conditions when no match is found
 *
 * @method     ChildAddress findOneById(string $id) Return the first ChildAddress filtered by the id column
 * @method     ChildAddress findOneByCity(string $city) Return the first ChildAddress filtered by the city column
 * @method     ChildAddress findOneByComplement(string $complement) Return the first ChildAddress filtered by the complement column
 * @method     ChildAddress findOneByNeighborhood(string $neighborhood) Return the first ChildAddress filtered by the neighborhood column
 * @method     ChildAddress findOneByNumber(int $number) Return the first ChildAddress filtered by the number column
 * @method     ChildAddress findOneByState(string $state) Return the first ChildAddress filtered by the state column
 * @method     ChildAddress findOneByStreet(string $street) Return the first ChildAddress filtered by the street column
 * @method     ChildAddress findOneByCEP(string $CEP) Return the first ChildAddress filtered by the CEP column
 * @method     ChildAddress findOneByType(int $type) Return the first ChildAddress filtered by the type column
 * @method     ChildAddress findOneBySurgeonId(int $surgeon_id) Return the first ChildAddress filtered by the surgeon_id column
 * @method     ChildAddress findOneByCreated(string $created) Return the first ChildAddress filtered by the created column *

 * @method     ChildAddress requirePk($key, ConnectionInterface $con = null) Return the ChildAddress by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOne(ConnectionInterface $con = null) Return the first ChildAddress matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAddress requireOneById(string $id) Return the first ChildAddress filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByCity(string $city) Return the first ChildAddress filtered by the city column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByComplement(string $complement) Return the first ChildAddress filtered by the complement column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByNeighborhood(string $neighborhood) Return the first ChildAddress filtered by the neighborhood column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByNumber(int $number) Return the first ChildAddress filtered by the number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByState(string $state) Return the first ChildAddress filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByStreet(string $street) Return the first ChildAddress filtered by the street column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByCEP(string $CEP) Return the first ChildAddress filtered by the CEP column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByType(int $type) Return the first ChildAddress filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneBySurgeonId(int $surgeon_id) Return the first ChildAddress filtered by the surgeon_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAddress requireOneByCreated(string $created) Return the first ChildAddress filtered by the created column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAddress[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAddress objects based on current ModelCriteria
 * @method     ChildAddress[]|ObjectCollection findById(string $id) Return ChildAddress objects filtered by the id column
 * @method     ChildAddress[]|ObjectCollection findByCity(string $city) Return ChildAddress objects filtered by the city column
 * @method     ChildAddress[]|ObjectCollection findByComplement(string $complement) Return ChildAddress objects filtered by the complement column
 * @method     ChildAddress[]|ObjectCollection findByNeighborhood(string $neighborhood) Return ChildAddress objects filtered by the neighborhood column
 * @method     ChildAddress[]|ObjectCollection findByNumber(int $number) Return ChildAddress objects filtered by the number column
 * @method     ChildAddress[]|ObjectCollection findByState(string $state) Return ChildAddress objects filtered by the state column
 * @method     ChildAddress[]|ObjectCollection findByStreet(string $street) Return ChildAddress objects filtered by the street column
 * @method     ChildAddress[]|ObjectCollection findByCEP(string $CEP) Return ChildAddress objects filtered by the CEP column
 * @method     ChildAddress[]|ObjectCollection findByType(int $type) Return ChildAddress objects filtered by the type column
 * @method     ChildAddress[]|ObjectCollection findBySurgeonId(int $surgeon_id) Return ChildAddress objects filtered by the surgeon_id column
 * @method     ChildAddress[]|ObjectCollection findByCreated(string $created) Return ChildAddress objects filtered by the created column
 * @method     ChildAddress[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AddressQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MocApi\Models\Base\AddressQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\MocApi\\Models\\Address', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAddressQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAddressQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAddressQuery) {
            return $criteria;
        }
        $query = new ChildAddressQuery();
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
     * @return ChildAddress|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AddressTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AddressTableMap::DATABASE_NAME);
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
     * @return ChildAddress A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, city, complement, neighborhood, number, state, street, CEP, type, surgeon_id, created FROM moc.address WHERE id = :p0';
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
            /** @var ChildAddress $obj */
            $obj = new ChildAddress();
            $obj->hydrate($row);
            AddressTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAddress|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AddressTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AddressTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AddressTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AddressTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the city column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue');   // WHERE city = 'fooValue'
     * $query->filterByCity('%fooValue%'); // WHERE city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $city The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByCity($city = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $city)) {
                $city = str_replace('*', '%', $city);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_CITY, $city, $comparison);
    }

    /**
     * Filter the query on the complement column
     *
     * Example usage:
     * <code>
     * $query->filterByComplement('fooValue');   // WHERE complement = 'fooValue'
     * $query->filterByComplement('%fooValue%'); // WHERE complement LIKE '%fooValue%'
     * </code>
     *
     * @param     string $complement The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByComplement($complement = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($complement)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $complement)) {
                $complement = str_replace('*', '%', $complement);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_COMPLEMENT, $complement, $comparison);
    }

    /**
     * Filter the query on the neighborhood column
     *
     * Example usage:
     * <code>
     * $query->filterByNeighborhood('fooValue');   // WHERE neighborhood = 'fooValue'
     * $query->filterByNeighborhood('%fooValue%'); // WHERE neighborhood LIKE '%fooValue%'
     * </code>
     *
     * @param     string $neighborhood The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByNeighborhood($neighborhood = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($neighborhood)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $neighborhood)) {
                $neighborhood = str_replace('*', '%', $neighborhood);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_NEIGHBORHOOD, $neighborhood, $comparison);
    }

    /**
     * Filter the query on the number column
     *
     * Example usage:
     * <code>
     * $query->filterByNumber(1234); // WHERE number = 1234
     * $query->filterByNumber(array(12, 34)); // WHERE number IN (12, 34)
     * $query->filterByNumber(array('min' => 12)); // WHERE number > 12
     * </code>
     *
     * @param     mixed $number The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByNumber($number = null, $comparison = null)
    {
        if (is_array($number)) {
            $useMinMax = false;
            if (isset($number['min'])) {
                $this->addUsingAlias(AddressTableMap::COL_NUMBER, $number['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($number['max'])) {
                $this->addUsingAlias(AddressTableMap::COL_NUMBER, $number['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_NUMBER, $number, $comparison);
    }

    /**
     * Filter the query on the state column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue');   // WHERE state = 'fooValue'
     * $query->filterByState('%fooValue%'); // WHERE state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $state The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByState($state = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $state)) {
                $state = str_replace('*', '%', $state);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_STATE, $state, $comparison);
    }

    /**
     * Filter the query on the street column
     *
     * Example usage:
     * <code>
     * $query->filterByStreet('fooValue');   // WHERE street = 'fooValue'
     * $query->filterByStreet('%fooValue%'); // WHERE street LIKE '%fooValue%'
     * </code>
     *
     * @param     string $street The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByStreet($street = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($street)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $street)) {
                $street = str_replace('*', '%', $street);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_STREET, $street, $comparison);
    }

    /**
     * Filter the query on the CEP column
     *
     * Example usage:
     * <code>
     * $query->filterByCEP('fooValue');   // WHERE CEP = 'fooValue'
     * $query->filterByCEP('%fooValue%'); // WHERE CEP LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cEP The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByCEP($cEP = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cEP)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $cEP)) {
                $cEP = str_replace('*', '%', $cEP);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_CEP, $cEP, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        $valueSet = AddressTableMap::getValueSet(AddressTableMap::COL_TYPE);
        if (is_scalar($type)) {
            if (!in_array($type, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $type));
            }
            $type = array_search($type, $valueSet);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_TYPE, $type, $comparison);
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
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterBySurgeonId($surgeonId = null, $comparison = null)
    {
        if (is_array($surgeonId)) {
            $useMinMax = false;
            if (isset($surgeonId['min'])) {
                $this->addUsingAlias(AddressTableMap::COL_SURGEON_ID, $surgeonId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($surgeonId['max'])) {
                $this->addUsingAlias(AddressTableMap::COL_SURGEON_ID, $surgeonId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_SURGEON_ID, $surgeonId, $comparison);
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
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function filterByCreated($created = null, $comparison = null)
    {
        if (is_array($created)) {
            $useMinMax = false;
            if (isset($created['min'])) {
                $this->addUsingAlias(AddressTableMap::COL_CREATED, $created['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($created['max'])) {
                $this->addUsingAlias(AddressTableMap::COL_CREATED, $created['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AddressTableMap::COL_CREATED, $created, $comparison);
    }

    /**
     * Filter the query by a related \MocApi\Models\Surgeon object
     *
     * @param \MocApi\Models\Surgeon|ObjectCollection $surgeon The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAddressQuery The current query, for fluid interface
     */
    public function filterBySurgeon($surgeon, $comparison = null)
    {
        if ($surgeon instanceof \MocApi\Models\Surgeon) {
            return $this
                ->addUsingAlias(AddressTableMap::COL_SURGEON_ID, $surgeon->getPersonId(), $comparison);
        } elseif ($surgeon instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AddressTableMap::COL_SURGEON_ID, $surgeon->toKeyValue('PrimaryKey', 'PersonId'), $comparison);
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
     * @return $this|ChildAddressQuery The current query, for fluid interface
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
     * @param   ChildAddress $address Object to remove from the list of results
     *
     * @return $this|ChildAddressQuery The current query, for fluid interface
     */
    public function prune($address = null)
    {
        if ($address) {
            $this->addUsingAlias(AddressTableMap::COL_ID, $address->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the moc.address table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AddressTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AddressTableMap::clearInstancePool();
            AddressTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AddressTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AddressTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AddressTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AddressTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AddressQuery
