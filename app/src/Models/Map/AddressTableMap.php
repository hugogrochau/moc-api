<?php

namespace MocApi\Models\Map;

use MocApi\Models\Address;
use MocApi\Models\AddressQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'moc.address' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AddressTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MocApi.Models.Map.AddressTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'moc.address';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MocApi\\Models\\Address';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MocApi.Models.Address';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id field
     */
    const COL_ID = 'moc.address.id';

    /**
     * the column name for the city field
     */
    const COL_CITY = 'moc.address.city';

    /**
     * the column name for the complement field
     */
    const COL_COMPLEMENT = 'moc.address.complement';

    /**
     * the column name for the neighborhood field
     */
    const COL_NEIGHBORHOOD = 'moc.address.neighborhood';

    /**
     * the column name for the number field
     */
    const COL_NUMBER = 'moc.address.number';

    /**
     * the column name for the state field
     */
    const COL_STATE = 'moc.address.state';

    /**
     * the column name for the street field
     */
    const COL_STREET = 'moc.address.street';

    /**
     * the column name for the CEP field
     */
    const COL_CEP = 'moc.address.CEP';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'moc.address.type';

    /**
     * the column name for the surgeon_id field
     */
    const COL_SURGEON_ID = 'moc.address.surgeon_id';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'moc.address.created';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the type field */
    const COL_TYPE_HOME = 'home';
    const COL_TYPE_WORK = 'work';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'City', 'Complement', 'Neighborhood', 'Number', 'State', 'Street', 'CEP', 'Type', 'SurgeonId', 'Created', ),
        self::TYPE_CAMELNAME     => array('id', 'city', 'complement', 'neighborhood', 'number', 'state', 'street', 'cEP', 'type', 'surgeonId', 'created', ),
        self::TYPE_COLNAME       => array(AddressTableMap::COL_ID, AddressTableMap::COL_CITY, AddressTableMap::COL_COMPLEMENT, AddressTableMap::COL_NEIGHBORHOOD, AddressTableMap::COL_NUMBER, AddressTableMap::COL_STATE, AddressTableMap::COL_STREET, AddressTableMap::COL_CEP, AddressTableMap::COL_TYPE, AddressTableMap::COL_SURGEON_ID, AddressTableMap::COL_CREATED, ),
        self::TYPE_FIELDNAME     => array('id', 'city', 'complement', 'neighborhood', 'number', 'state', 'street', 'CEP', 'type', 'surgeon_id', 'created', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'City' => 1, 'Complement' => 2, 'Neighborhood' => 3, 'Number' => 4, 'State' => 5, 'Street' => 6, 'CEP' => 7, 'Type' => 8, 'SurgeonId' => 9, 'Created' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'city' => 1, 'complement' => 2, 'neighborhood' => 3, 'number' => 4, 'state' => 5, 'street' => 6, 'cEP' => 7, 'type' => 8, 'surgeonId' => 9, 'created' => 10, ),
        self::TYPE_COLNAME       => array(AddressTableMap::COL_ID => 0, AddressTableMap::COL_CITY => 1, AddressTableMap::COL_COMPLEMENT => 2, AddressTableMap::COL_NEIGHBORHOOD => 3, AddressTableMap::COL_NUMBER => 4, AddressTableMap::COL_STATE => 5, AddressTableMap::COL_STREET => 6, AddressTableMap::COL_CEP => 7, AddressTableMap::COL_TYPE => 8, AddressTableMap::COL_SURGEON_ID => 9, AddressTableMap::COL_CREATED => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'city' => 1, 'complement' => 2, 'neighborhood' => 3, 'number' => 4, 'state' => 5, 'street' => 6, 'CEP' => 7, 'type' => 8, 'surgeon_id' => 9, 'created' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                AddressTableMap::COL_TYPE => array(
                            self::COL_TYPE_HOME,
            self::COL_TYPE_WORK,
        ),
    );

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return static::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM column
     * @param string $colname
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = self::getValueSets();

        return $valueSets[$colname];
    }

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('moc.address');
        $this->setPhpName('Address');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\MocApi\\Models\\Address');
        $this->setPackage('MocApi.Models');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('moc.address_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addColumn('city', 'City', 'VARCHAR', true, 100, null);
        $this->addColumn('complement', 'Complement', 'VARCHAR', false, 50, null);
        $this->addColumn('neighborhood', 'Neighborhood', 'VARCHAR', true, 100, null);
        $this->addColumn('number', 'Number', 'INTEGER', true, null, null);
        $this->addColumn('state', 'State', 'VARCHAR', true, 50, null);
        $this->addColumn('street', 'Street', 'VARCHAR', true, 100, null);
        $this->addColumn('CEP', 'CEP', 'VARCHAR', true, 9, null);
        $this->addColumn('type', 'Type', 'ENUM', false, null, 'home');
        $this->getColumn('type')->setValueSet(array (
  0 => 'home',
  1 => 'work',
));
        $this->addForeignKey('surgeon_id', 'SurgeonId', 'INTEGER', 'moc.surgeon', 'person_id', true, null, null);
        $this->addColumn('created', 'Created', 'TIMESTAMP', false, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Surgeon', '\\MocApi\\Models\\Surgeon', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':surgeon_id',
    1 => ':person_id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? AddressTableMap::CLASS_DEFAULT : AddressTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Address object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AddressTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AddressTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AddressTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AddressTableMap::OM_CLASS;
            /** @var Address $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AddressTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = AddressTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AddressTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Address $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AddressTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AddressTableMap::COL_ID);
            $criteria->addSelectColumn(AddressTableMap::COL_CITY);
            $criteria->addSelectColumn(AddressTableMap::COL_COMPLEMENT);
            $criteria->addSelectColumn(AddressTableMap::COL_NEIGHBORHOOD);
            $criteria->addSelectColumn(AddressTableMap::COL_NUMBER);
            $criteria->addSelectColumn(AddressTableMap::COL_STATE);
            $criteria->addSelectColumn(AddressTableMap::COL_STREET);
            $criteria->addSelectColumn(AddressTableMap::COL_CEP);
            $criteria->addSelectColumn(AddressTableMap::COL_TYPE);
            $criteria->addSelectColumn(AddressTableMap::COL_SURGEON_ID);
            $criteria->addSelectColumn(AddressTableMap::COL_CREATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.city');
            $criteria->addSelectColumn($alias . '.complement');
            $criteria->addSelectColumn($alias . '.neighborhood');
            $criteria->addSelectColumn($alias . '.number');
            $criteria->addSelectColumn($alias . '.state');
            $criteria->addSelectColumn($alias . '.street');
            $criteria->addSelectColumn($alias . '.CEP');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.surgeon_id');
            $criteria->addSelectColumn($alias . '.created');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(AddressTableMap::DATABASE_NAME)->getTable(AddressTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AddressTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AddressTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AddressTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Address or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Address object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AddressTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MocApi\Models\Address) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AddressTableMap::DATABASE_NAME);
            $criteria->add(AddressTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = AddressQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AddressTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AddressTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the moc.address table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AddressQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Address or Criteria object.
     *
     * @param mixed               $criteria Criteria or Address object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AddressTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Address object
        }

        if ($criteria->containsKey(AddressTableMap::COL_ID) && $criteria->keyContainsValue(AddressTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AddressTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AddressQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AddressTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AddressTableMap::buildTableMap();
