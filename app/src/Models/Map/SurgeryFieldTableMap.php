<?php

namespace MocApi\Models\Map;

use MocApi\Models\SurgeryField;
use MocApi\Models\SurgeryFieldQuery;
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
 * This class defines the structure of the 'moc.surgery_field' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SurgeryFieldTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MocApi.Models.Map.SurgeryFieldTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'moc.surgery_field';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MocApi\\Models\\SurgeryField';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MocApi.Models.SurgeryField';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    const COL_ID = 'moc.surgery_field.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'moc.surgery_field.name';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'moc.surgery_field.type';

    /**
     * the column name for the surgery_field_category_id field
     */
    const COL_SURGERY_FIELD_CATEGORY_ID = 'moc.surgery_field.surgery_field_category_id';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'moc.surgery_field.created';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the type field */
    const COL_TYPE_CHECKBOX = 'checkbox';
    const COL_TYPE_DATE = 'date';
    const COL_TYPE_NUMBER = 'number';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Type', 'SurgeryFieldCategoryId', 'Created', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'type', 'surgeryFieldCategoryId', 'created', ),
        self::TYPE_COLNAME       => array(SurgeryFieldTableMap::COL_ID, SurgeryFieldTableMap::COL_NAME, SurgeryFieldTableMap::COL_TYPE, SurgeryFieldTableMap::COL_SURGERY_FIELD_CATEGORY_ID, SurgeryFieldTableMap::COL_CREATED, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'type', 'surgery_field_category_id', 'created', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Type' => 2, 'SurgeryFieldCategoryId' => 3, 'Created' => 4, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'type' => 2, 'surgeryFieldCategoryId' => 3, 'created' => 4, ),
        self::TYPE_COLNAME       => array(SurgeryFieldTableMap::COL_ID => 0, SurgeryFieldTableMap::COL_NAME => 1, SurgeryFieldTableMap::COL_TYPE => 2, SurgeryFieldTableMap::COL_SURGERY_FIELD_CATEGORY_ID => 3, SurgeryFieldTableMap::COL_CREATED => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'type' => 2, 'surgery_field_category_id' => 3, 'created' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                SurgeryFieldTableMap::COL_TYPE => array(
                            self::COL_TYPE_CHECKBOX,
            self::COL_TYPE_DATE,
            self::COL_TYPE_NUMBER,
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
        $this->setName('moc.surgery_field');
        $this->setPhpName('SurgeryField');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\MocApi\\Models\\SurgeryField');
        $this->setPackage('MocApi.Models');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('moc.surgery_field_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 100, null);
        $this->addColumn('type', 'Type', 'ENUM', true, null, null);
        $this->getColumn('type')->setValueSet(array (
  0 => 'checkbox',
  1 => 'date',
  2 => 'number',
));
        $this->addForeignKey('surgery_field_category_id', 'SurgeryFieldCategoryId', 'INTEGER', 'moc.surgery_field_category', 'id', true, null, null);
        $this->addColumn('created', 'Created', 'TIMESTAMP', false, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SurgeryFieldCategory', '\\MocApi\\Models\\SurgeryFieldCategory', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':surgery_field_category_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('SurgeryFieldValue', '\\MocApi\\Models\\SurgeryFieldValue', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':surgery_field_id',
    1 => ':id',
  ),
), null, null, 'SurgeryFieldValues', false);
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
        return (int) $row[
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
        return $withPrefix ? SurgeryFieldTableMap::CLASS_DEFAULT : SurgeryFieldTableMap::OM_CLASS;
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
     * @return array           (SurgeryField object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SurgeryFieldTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SurgeryFieldTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SurgeryFieldTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SurgeryFieldTableMap::OM_CLASS;
            /** @var SurgeryField $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SurgeryFieldTableMap::addInstanceToPool($obj, $key);
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
            $key = SurgeryFieldTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SurgeryFieldTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SurgeryField $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SurgeryFieldTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SurgeryFieldTableMap::COL_ID);
            $criteria->addSelectColumn(SurgeryFieldTableMap::COL_NAME);
            $criteria->addSelectColumn(SurgeryFieldTableMap::COL_TYPE);
            $criteria->addSelectColumn(SurgeryFieldTableMap::COL_SURGERY_FIELD_CATEGORY_ID);
            $criteria->addSelectColumn(SurgeryFieldTableMap::COL_CREATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.surgery_field_category_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(SurgeryFieldTableMap::DATABASE_NAME)->getTable(SurgeryFieldTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SurgeryFieldTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SurgeryFieldTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SurgeryFieldTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SurgeryField or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SurgeryField object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryFieldTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MocApi\Models\SurgeryField) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SurgeryFieldTableMap::DATABASE_NAME);
            $criteria->add(SurgeryFieldTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SurgeryFieldQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SurgeryFieldTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SurgeryFieldTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the moc.surgery_field table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SurgeryFieldQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SurgeryField or Criteria object.
     *
     * @param mixed               $criteria Criteria or SurgeryField object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryFieldTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SurgeryField object
        }

        if ($criteria->containsKey(SurgeryFieldTableMap::COL_ID) && $criteria->keyContainsValue(SurgeryFieldTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SurgeryFieldTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SurgeryFieldQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SurgeryFieldTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SurgeryFieldTableMap::buildTableMap();
