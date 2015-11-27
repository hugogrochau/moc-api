<?php

namespace MocApi\Models\Map;

use MocApi\Models\Surgery;
use MocApi\Models\SurgeryQuery;
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
 * This class defines the structure of the 'moc.surgery' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SurgeryTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MocApi.Models.Map.SurgeryTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'moc.surgery';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MocApi\\Models\\Surgery';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MocApi.Models.Surgery';

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
    const COL_ID = 'moc.surgery.id';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'moc.surgery.status';

    /**
     * the column name for the creator_id field
     */
    const COL_CREATOR_ID = 'moc.surgery.creator_id';

    /**
     * the column name for the surgery_type_id field
     */
    const COL_SURGERY_TYPE_ID = 'moc.surgery.surgery_type_id';

    /**
     * the column name for the created field
     */
    const COL_CREATED = 'moc.surgery.created';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Status', 'CreatorId', 'SurgeryTypeId', 'Created', ),
        self::TYPE_CAMELNAME     => array('id', 'status', 'creatorId', 'surgeryTypeId', 'created', ),
        self::TYPE_COLNAME       => array(SurgeryTableMap::COL_ID, SurgeryTableMap::COL_STATUS, SurgeryTableMap::COL_CREATOR_ID, SurgeryTableMap::COL_SURGERY_TYPE_ID, SurgeryTableMap::COL_CREATED, ),
        self::TYPE_FIELDNAME     => array('id', 'status', 'creator_id', 'surgery_type_id', 'created', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Status' => 1, 'CreatorId' => 2, 'SurgeryTypeId' => 3, 'Created' => 4, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'status' => 1, 'creatorId' => 2, 'surgeryTypeId' => 3, 'created' => 4, ),
        self::TYPE_COLNAME       => array(SurgeryTableMap::COL_ID => 0, SurgeryTableMap::COL_STATUS => 1, SurgeryTableMap::COL_CREATOR_ID => 2, SurgeryTableMap::COL_SURGERY_TYPE_ID => 3, SurgeryTableMap::COL_CREATED => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'status' => 1, 'creator_id' => 2, 'surgery_type_id' => 3, 'created' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

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
        $this->setName('moc.surgery');
        $this->setPhpName('Surgery');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\MocApi\\Models\\Surgery');
        $this->setPackage('MocApi.Models');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('moc.surgery_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('status', 'Status', 'VARCHAR', true, 100, null);
        $this->addForeignKey('creator_id', 'CreatorId', 'INTEGER', 'moc.person', 'id', true, null, null);
        $this->addForeignKey('surgery_type_id', 'SurgeryTypeId', 'INTEGER', 'moc.surgery_type', 'id', true, null, null);
        $this->addColumn('created', 'Created', 'TIMESTAMP', false, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Creator', '\\MocApi\\Models\\Person', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':creator_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('SurgeryType', '\\MocApi\\Models\\SurgeryType', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':surgery_type_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Patient', '\\MocApi\\Models\\Patient', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':surgery_id',
    1 => ':id',
  ),
), null, null, 'Patients', false);
        $this->addRelation('SurgeonSurgery', '\\MocApi\\Models\\SurgeonSurgery', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':surgery_id',
    1 => ':id',
  ),
), null, null, 'SurgeonSurgeries', false);
        $this->addRelation('SurgeryEquipment', '\\MocApi\\Models\\SurgeryEquipment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':surgery_id',
    1 => ':id',
  ),
), null, null, 'SurgeryEquipments', false);
        $this->addRelation('SurgeryFieldValue', '\\MocApi\\Models\\SurgeryFieldValue', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':surgery_id',
    1 => ':id',
  ),
), null, null, 'SurgeryFieldValues', false);
        $this->addRelation('SurgeryMaterial', '\\MocApi\\Models\\SurgeryMaterial', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':surgery_id',
    1 => ':id',
  ),
), null, null, 'SurgeryMaterials', false);
        $this->addRelation('SurgeryTUSS', '\\MocApi\\Models\\SurgeryTUSS', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':surgery_id',
    1 => ':id',
  ),
), null, null, 'SurgeryTUsses', false);
        $this->addRelation('Surgeon', '\\MocApi\\Models\\Surgeon', RelationMap::MANY_TO_MANY, array(), null, null, 'Surgeons');
        $this->addRelation('Equipment', '\\MocApi\\Models\\Equipment', RelationMap::MANY_TO_MANY, array(), null, null, 'Equipment');
        $this->addRelation('Material', '\\MocApi\\Models\\Material', RelationMap::MANY_TO_MANY, array(), null, null, 'Materials');
        $this->addRelation('TUSS', '\\MocApi\\Models\\TUSS', RelationMap::MANY_TO_MANY, array(), null, null, 'TUsses');
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
        return $withPrefix ? SurgeryTableMap::CLASS_DEFAULT : SurgeryTableMap::OM_CLASS;
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
     * @return array           (Surgery object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SurgeryTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SurgeryTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SurgeryTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SurgeryTableMap::OM_CLASS;
            /** @var Surgery $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SurgeryTableMap::addInstanceToPool($obj, $key);
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
            $key = SurgeryTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SurgeryTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Surgery $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SurgeryTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SurgeryTableMap::COL_ID);
            $criteria->addSelectColumn(SurgeryTableMap::COL_STATUS);
            $criteria->addSelectColumn(SurgeryTableMap::COL_CREATOR_ID);
            $criteria->addSelectColumn(SurgeryTableMap::COL_SURGERY_TYPE_ID);
            $criteria->addSelectColumn(SurgeryTableMap::COL_CREATED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.creator_id');
            $criteria->addSelectColumn($alias . '.surgery_type_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(SurgeryTableMap::DATABASE_NAME)->getTable(SurgeryTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SurgeryTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SurgeryTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SurgeryTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Surgery or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Surgery object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MocApi\Models\Surgery) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SurgeryTableMap::DATABASE_NAME);
            $criteria->add(SurgeryTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SurgeryQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SurgeryTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SurgeryTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the moc.surgery table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SurgeryQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Surgery or Criteria object.
     *
     * @param mixed               $criteria Criteria or Surgery object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Surgery object
        }

        if ($criteria->containsKey(SurgeryTableMap::COL_ID) && $criteria->keyContainsValue(SurgeryTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SurgeryTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SurgeryQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SurgeryTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SurgeryTableMap::buildTableMap();
