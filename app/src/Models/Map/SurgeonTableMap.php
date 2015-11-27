<?php

namespace MocApi\Models\Map;

use MocApi\Models\Surgeon;
use MocApi\Models\SurgeonQuery;
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
 * This class defines the structure of the 'moc.surgeon' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SurgeonTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'MocApi.Models.Map.SurgeonTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'moc.surgeon';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MocApi\\Models\\Surgeon';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MocApi.Models.Surgeon';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the person_id field
     */
    const COL_PERSON_ID = 'moc.surgeon.person_id';

    /**
     * the column name for the specialty field
     */
    const COL_SPECIALTY = 'moc.surgeon.specialty';

    /**
     * the column name for the CRM field
     */
    const COL_CRM = 'moc.surgeon.CRM';

    /**
     * the column name for the CRMUF field
     */
    const COL_CRMUF = 'moc.surgeon.CRMUF';

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
        self::TYPE_PHPNAME       => array('PersonId', 'Specialty', 'CRM', 'CRMUF', ),
        self::TYPE_CAMELNAME     => array('personId', 'specialty', 'cRM', 'cRMUF', ),
        self::TYPE_COLNAME       => array(SurgeonTableMap::COL_PERSON_ID, SurgeonTableMap::COL_SPECIALTY, SurgeonTableMap::COL_CRM, SurgeonTableMap::COL_CRMUF, ),
        self::TYPE_FIELDNAME     => array('person_id', 'specialty', 'CRM', 'CRMUF', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PersonId' => 0, 'Specialty' => 1, 'CRM' => 2, 'CRMUF' => 3, ),
        self::TYPE_CAMELNAME     => array('personId' => 0, 'specialty' => 1, 'cRM' => 2, 'cRMUF' => 3, ),
        self::TYPE_COLNAME       => array(SurgeonTableMap::COL_PERSON_ID => 0, SurgeonTableMap::COL_SPECIALTY => 1, SurgeonTableMap::COL_CRM => 2, SurgeonTableMap::COL_CRMUF => 3, ),
        self::TYPE_FIELDNAME     => array('person_id' => 0, 'specialty' => 1, 'CRM' => 2, 'CRMUF' => 3, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, )
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
        $this->setName('moc.surgeon');
        $this->setPhpName('Surgeon');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\MocApi\\Models\\Surgeon');
        $this->setPackage('MocApi.Models');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('person_id', 'PersonId', 'INTEGER' , 'moc.person', 'id', true, null, null);
        $this->addColumn('specialty', 'Specialty', 'VARCHAR', true, 100, null);
        $this->addColumn('CRM', 'CRM', 'VARCHAR', true, 12, null);
        $this->addColumn('CRMUF', 'CRMUF', 'VARCHAR', true, 3, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Person', '\\MocApi\\Models\\Person', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':person_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Address', '\\MocApi\\Models\\Address', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':surgeon_id',
    1 => ':person_id',
  ),
), null, null, 'Addresses', false);
        $this->addRelation('SurgeonSurgery', '\\MocApi\\Models\\SurgeonSurgery', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':surgeon_id',
    1 => ':person_id',
  ),
), null, null, 'SurgeonSurgeries', false);
        $this->addRelation('MedicalStaff', '\\MocApi\\Models\\MedicalStaff', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':surgeon_id',
    1 => ':person_id',
  ),
), null, null, 'MedicalStaffs', false);
        $this->addRelation('Surgery', '\\MocApi\\Models\\Surgery', RelationMap::MANY_TO_MANY, array(), null, null, 'Surgeries');
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? SurgeonTableMap::CLASS_DEFAULT : SurgeonTableMap::OM_CLASS;
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
     * @return array           (Surgeon object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SurgeonTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SurgeonTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SurgeonTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SurgeonTableMap::OM_CLASS;
            /** @var Surgeon $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SurgeonTableMap::addInstanceToPool($obj, $key);
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
            $key = SurgeonTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SurgeonTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Surgeon $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SurgeonTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SurgeonTableMap::COL_PERSON_ID);
            $criteria->addSelectColumn(SurgeonTableMap::COL_SPECIALTY);
            $criteria->addSelectColumn(SurgeonTableMap::COL_CRM);
            $criteria->addSelectColumn(SurgeonTableMap::COL_CRMUF);
        } else {
            $criteria->addSelectColumn($alias . '.person_id');
            $criteria->addSelectColumn($alias . '.specialty');
            $criteria->addSelectColumn($alias . '.CRM');
            $criteria->addSelectColumn($alias . '.CRMUF');
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
        return Propel::getServiceContainer()->getDatabaseMap(SurgeonTableMap::DATABASE_NAME)->getTable(SurgeonTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SurgeonTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SurgeonTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SurgeonTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Surgeon or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Surgeon object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeonTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MocApi\Models\Surgeon) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SurgeonTableMap::DATABASE_NAME);
            $criteria->add(SurgeonTableMap::COL_PERSON_ID, (array) $values, Criteria::IN);
        }

        $query = SurgeonQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SurgeonTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SurgeonTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the moc.surgeon table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SurgeonQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Surgeon or Criteria object.
     *
     * @param mixed               $criteria Criteria or Surgeon object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeonTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Surgeon object
        }


        // Set the correct dbName
        $query = SurgeonQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SurgeonTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SurgeonTableMap::buildTableMap();
