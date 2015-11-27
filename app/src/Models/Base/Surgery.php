<?php

namespace MocApi\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use MocApi\Models\Equipment as ChildEquipment;
use MocApi\Models\EquipmentQuery as ChildEquipmentQuery;
use MocApi\Models\Material as ChildMaterial;
use MocApi\Models\MaterialQuery as ChildMaterialQuery;
use MocApi\Models\Patient as ChildPatient;
use MocApi\Models\PatientQuery as ChildPatientQuery;
use MocApi\Models\Person as ChildPerson;
use MocApi\Models\PersonQuery as ChildPersonQuery;
use MocApi\Models\Surgeon as ChildSurgeon;
use MocApi\Models\SurgeonQuery as ChildSurgeonQuery;
use MocApi\Models\SurgeonSurgery as ChildSurgeonSurgery;
use MocApi\Models\SurgeonSurgeryQuery as ChildSurgeonSurgeryQuery;
use MocApi\Models\Surgery as ChildSurgery;
use MocApi\Models\SurgeryEquipment as ChildSurgeryEquipment;
use MocApi\Models\SurgeryEquipmentQuery as ChildSurgeryEquipmentQuery;
use MocApi\Models\SurgeryFieldValue as ChildSurgeryFieldValue;
use MocApi\Models\SurgeryFieldValueQuery as ChildSurgeryFieldValueQuery;
use MocApi\Models\SurgeryMaterial as ChildSurgeryMaterial;
use MocApi\Models\SurgeryMaterialQuery as ChildSurgeryMaterialQuery;
use MocApi\Models\SurgeryQuery as ChildSurgeryQuery;
use MocApi\Models\SurgeryTUSS as ChildSurgeryTUSS;
use MocApi\Models\SurgeryTUSSQuery as ChildSurgeryTUSSQuery;
use MocApi\Models\SurgeryType as ChildSurgeryType;
use MocApi\Models\SurgeryTypeQuery as ChildSurgeryTypeQuery;
use MocApi\Models\TUSS as ChildTUSS;
use MocApi\Models\TUSSQuery as ChildTUSSQuery;
use MocApi\Models\Map\SurgeryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'moc.surgery' table.
 *
 *
 *
* @package    propel.generator.MocApi.Models.Base
*/
abstract class Surgery implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MocApi\\Models\\Map\\SurgeryTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the status field.
     *
     * @var        string
     */
    protected $status;

    /**
     * The value for the creator_id field.
     *
     * @var        int
     */
    protected $creator_id;

    /**
     * The value for the surgery_type_id field.
     *
     * @var        int
     */
    protected $surgery_type_id;

    /**
     * The value for the created field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        \DateTime
     */
    protected $created;

    /**
     * @var        ChildPerson
     */
    protected $aCreator;

    /**
     * @var        ChildSurgeryType
     */
    protected $aSurgeryType;

    /**
     * @var        ObjectCollection|ChildPatient[] Collection to store aggregation of ChildPatient objects.
     */
    protected $collPatients;
    protected $collPatientsPartial;

    /**
     * @var        ObjectCollection|ChildSurgeonSurgery[] Collection to store aggregation of ChildSurgeonSurgery objects.
     */
    protected $collSurgeonSurgeries;
    protected $collSurgeonSurgeriesPartial;

    /**
     * @var        ObjectCollection|ChildSurgeryEquipment[] Collection to store aggregation of ChildSurgeryEquipment objects.
     */
    protected $collSurgeryEquipments;
    protected $collSurgeryEquipmentsPartial;

    /**
     * @var        ObjectCollection|ChildSurgeryFieldValue[] Collection to store aggregation of ChildSurgeryFieldValue objects.
     */
    protected $collSurgeryFieldValues;
    protected $collSurgeryFieldValuesPartial;

    /**
     * @var        ObjectCollection|ChildSurgeryMaterial[] Collection to store aggregation of ChildSurgeryMaterial objects.
     */
    protected $collSurgeryMaterials;
    protected $collSurgeryMaterialsPartial;

    /**
     * @var        ObjectCollection|ChildSurgeryTUSS[] Collection to store aggregation of ChildSurgeryTUSS objects.
     */
    protected $collSurgeryTUsses;
    protected $collSurgeryTUssesPartial;

    /**
     * @var        ObjectCollection|ChildSurgeon[] Cross Collection to store aggregation of ChildSurgeon objects.
     */
    protected $collSurgeons;

    /**
     * @var bool
     */
    protected $collSurgeonsPartial;

    /**
     * @var        ObjectCollection|ChildEquipment[] Cross Collection to store aggregation of ChildEquipment objects.
     */
    protected $collEquipment;

    /**
     * @var bool
     */
    protected $collEquipmentPartial;

    /**
     * @var        ObjectCollection|ChildMaterial[] Cross Collection to store aggregation of ChildMaterial objects.
     */
    protected $collMaterials;

    /**
     * @var bool
     */
    protected $collMaterialsPartial;

    /**
     * @var        ObjectCollection|ChildTUSS[] Cross Collection to store aggregation of ChildTUSS objects.
     */
    protected $collTUsses;

    /**
     * @var bool
     */
    protected $collTUssesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSurgeon[]
     */
    protected $surgeonsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEquipment[]
     */
    protected $equipmentScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMaterial[]
     */
    protected $materialsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTUSS[]
     */
    protected $tUssesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPatient[]
     */
    protected $patientsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSurgeonSurgery[]
     */
    protected $surgeonSurgeriesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSurgeryEquipment[]
     */
    protected $surgeryEquipmentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSurgeryFieldValue[]
     */
    protected $surgeryFieldValuesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSurgeryMaterial[]
     */
    protected $surgeryMaterialsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSurgeryTUSS[]
     */
    protected $surgeryTUssesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
    }

    /**
     * Initializes internal state of MocApi\Models\Base\Surgery object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Surgery</code> instance.  If
     * <code>obj</code> is an instance of <code>Surgery</code>, delegates to
     * <code>equals(Surgery)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Surgery The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [creator_id] column value.
     *
     * @return int
     */
    public function getCreatorId()
    {
        return $this->creator_id;
    }

    /**
     * Get the [surgery_type_id] column value.
     *
     * @return int
     */
    public function getSurgeryTypeId()
    {
        return $this->surgery_type_id;
    }

    /**
     * Get the [optionally formatted] temporal [created] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreated($format = NULL)
    {
        if ($format === null) {
            return $this->created;
        } else {
            return $this->created instanceof \DateTime ? $this->created->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SurgeryTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [status] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[SurgeryTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [creator_id] column.
     *
     * @param int $v new value
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function setCreatorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->creator_id !== $v) {
            $this->creator_id = $v;
            $this->modifiedColumns[SurgeryTableMap::COL_CREATOR_ID] = true;
        }

        if ($this->aCreator !== null && $this->aCreator->getId() !== $v) {
            $this->aCreator = null;
        }

        return $this;
    } // setCreatorId()

    /**
     * Set the value of [surgery_type_id] column.
     *
     * @param int $v new value
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function setSurgeryTypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->surgery_type_id !== $v) {
            $this->surgery_type_id = $v;
            $this->modifiedColumns[SurgeryTableMap::COL_SURGERY_TYPE_ID] = true;
        }

        if ($this->aSurgeryType !== null && $this->aSurgeryType->getId() !== $v) {
            $this->aSurgeryType = null;
        }

        return $this;
    } // setSurgeryTypeId()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($this->created === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created->format("Y-m-d H:i:s")) {
                $this->created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SurgeryTableMap::COL_CREATED] = true;
            }
        } // if either are not null

        return $this;
    } // setCreated()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SurgeryTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SurgeryTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SurgeryTableMap::translateFieldName('CreatorId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->creator_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SurgeryTableMap::translateFieldName('SurgeryTypeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->surgery_type_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SurgeryTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = SurgeryTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MocApi\\Models\\Surgery'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aCreator !== null && $this->creator_id !== $this->aCreator->getId()) {
            $this->aCreator = null;
        }
        if ($this->aSurgeryType !== null && $this->surgery_type_id !== $this->aSurgeryType->getId()) {
            $this->aSurgeryType = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SurgeryTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSurgeryQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCreator = null;
            $this->aSurgeryType = null;
            $this->collPatients = null;

            $this->collSurgeonSurgeries = null;

            $this->collSurgeryEquipments = null;

            $this->collSurgeryFieldValues = null;

            $this->collSurgeryMaterials = null;

            $this->collSurgeryTUsses = null;

            $this->collSurgeons = null;
            $this->collEquipment = null;
            $this->collMaterials = null;
            $this->collTUsses = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Surgery::setDeleted()
     * @see Surgery::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSurgeryQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeryTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                SurgeryTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCreator !== null) {
                if ($this->aCreator->isModified() || $this->aCreator->isNew()) {
                    $affectedRows += $this->aCreator->save($con);
                }
                $this->setCreator($this->aCreator);
            }

            if ($this->aSurgeryType !== null) {
                if ($this->aSurgeryType->isModified() || $this->aSurgeryType->isNew()) {
                    $affectedRows += $this->aSurgeryType->save($con);
                }
                $this->setSurgeryType($this->aSurgeryType);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->surgeonsScheduledForDeletion !== null) {
                if (!$this->surgeonsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->surgeonsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getPersonId();
                        $pks[] = $entryPk;
                    }

                    \MocApi\Models\SurgeonSurgeryQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->surgeonsScheduledForDeletion = null;
                }

            }

            if ($this->collSurgeons) {
                foreach ($this->collSurgeons as $surgeon) {
                    if (!$surgeon->isDeleted() && ($surgeon->isNew() || $surgeon->isModified())) {
                        $surgeon->save($con);
                    }
                }
            }


            if ($this->equipmentScheduledForDeletion !== null) {
                if (!$this->equipmentScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->equipmentScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \MocApi\Models\SurgeryEquipmentQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->equipmentScheduledForDeletion = null;
                }

            }

            if ($this->collEquipment) {
                foreach ($this->collEquipment as $equipment) {
                    if (!$equipment->isDeleted() && ($equipment->isNew() || $equipment->isModified())) {
                        $equipment->save($con);
                    }
                }
            }


            if ($this->materialsScheduledForDeletion !== null) {
                if (!$this->materialsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->materialsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \MocApi\Models\SurgeryMaterialQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->materialsScheduledForDeletion = null;
                }

            }

            if ($this->collMaterials) {
                foreach ($this->collMaterials as $material) {
                    if (!$material->isDeleted() && ($material->isNew() || $material->isModified())) {
                        $material->save($con);
                    }
                }
            }


            if ($this->tUssesScheduledForDeletion !== null) {
                if (!$this->tUssesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->tUssesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \MocApi\Models\SurgeryTUSSQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->tUssesScheduledForDeletion = null;
                }

            }

            if ($this->collTUsses) {
                foreach ($this->collTUsses as $tUSS) {
                    if (!$tUSS->isDeleted() && ($tUSS->isNew() || $tUSS->isModified())) {
                        $tUSS->save($con);
                    }
                }
            }


            if ($this->patientsScheduledForDeletion !== null) {
                if (!$this->patientsScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\PatientQuery::create()
                        ->filterByPrimaryKeys($this->patientsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->patientsScheduledForDeletion = null;
                }
            }

            if ($this->collPatients !== null) {
                foreach ($this->collPatients as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->surgeonSurgeriesScheduledForDeletion !== null) {
                if (!$this->surgeonSurgeriesScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\SurgeonSurgeryQuery::create()
                        ->filterByPrimaryKeys($this->surgeonSurgeriesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->surgeonSurgeriesScheduledForDeletion = null;
                }
            }

            if ($this->collSurgeonSurgeries !== null) {
                foreach ($this->collSurgeonSurgeries as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->surgeryEquipmentsScheduledForDeletion !== null) {
                if (!$this->surgeryEquipmentsScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\SurgeryEquipmentQuery::create()
                        ->filterByPrimaryKeys($this->surgeryEquipmentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->surgeryEquipmentsScheduledForDeletion = null;
                }
            }

            if ($this->collSurgeryEquipments !== null) {
                foreach ($this->collSurgeryEquipments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->surgeryFieldValuesScheduledForDeletion !== null) {
                if (!$this->surgeryFieldValuesScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\SurgeryFieldValueQuery::create()
                        ->filterByPrimaryKeys($this->surgeryFieldValuesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->surgeryFieldValuesScheduledForDeletion = null;
                }
            }

            if ($this->collSurgeryFieldValues !== null) {
                foreach ($this->collSurgeryFieldValues as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->surgeryMaterialsScheduledForDeletion !== null) {
                if (!$this->surgeryMaterialsScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\SurgeryMaterialQuery::create()
                        ->filterByPrimaryKeys($this->surgeryMaterialsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->surgeryMaterialsScheduledForDeletion = null;
                }
            }

            if ($this->collSurgeryMaterials !== null) {
                foreach ($this->collSurgeryMaterials as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->surgeryTUssesScheduledForDeletion !== null) {
                if (!$this->surgeryTUssesScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\SurgeryTUSSQuery::create()
                        ->filterByPrimaryKeys($this->surgeryTUssesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->surgeryTUssesScheduledForDeletion = null;
                }
            }

            if ($this->collSurgeryTUsses !== null) {
                foreach ($this->collSurgeryTUsses as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[SurgeryTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SurgeryTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('moc.surgery_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SurgeryTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SurgeryTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(SurgeryTableMap::COL_CREATOR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'creator_id';
        }
        if ($this->isColumnModified(SurgeryTableMap::COL_SURGERY_TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'surgery_type_id';
        }
        if ($this->isColumnModified(SurgeryTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }

        $sql = sprintf(
            'INSERT INTO moc.surgery (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case 'creator_id':
                        $stmt->bindValue($identifier, $this->creator_id, PDO::PARAM_INT);
                        break;
                    case 'surgery_type_id':
                        $stmt->bindValue($identifier, $this->surgery_type_id, PDO::PARAM_INT);
                        break;
                    case 'created':
                        $stmt->bindValue($identifier, $this->created ? $this->created->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SurgeryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getStatus();
                break;
            case 2:
                return $this->getCreatorId();
                break;
            case 3:
                return $this->getSurgeryTypeId();
                break;
            case 4:
                return $this->getCreated();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Surgery'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Surgery'][$this->hashCode()] = true;
        $keys = SurgeryTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getStatus(),
            $keys[2] => $this->getCreatorId(),
            $keys[3] => $this->getSurgeryTypeId(),
            $keys[4] => $this->getCreated(),
        );
        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCreator) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'person';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.person';
                        break;
                    default:
                        $key = 'Person';
                }

                $result[$key] = $this->aCreator->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSurgeryType) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'surgeryType';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.surgery_type';
                        break;
                    default:
                        $key = 'SurgeryType';
                }

                $result[$key] = $this->aSurgeryType->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPatients) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'patients';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.patients';
                        break;
                    default:
                        $key = 'Patients';
                }

                $result[$key] = $this->collPatients->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSurgeonSurgeries) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'surgeonSurgeries';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.surgeon_surgeries';
                        break;
                    default:
                        $key = 'SurgeonSurgeries';
                }

                $result[$key] = $this->collSurgeonSurgeries->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSurgeryEquipments) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'surgeryEquipments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.surgery_equipments';
                        break;
                    default:
                        $key = 'SurgeryEquipments';
                }

                $result[$key] = $this->collSurgeryEquipments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSurgeryFieldValues) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'surgeryFieldValues';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.surgery_field_values';
                        break;
                    default:
                        $key = 'SurgeryFieldValues';
                }

                $result[$key] = $this->collSurgeryFieldValues->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSurgeryMaterials) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'surgeryMaterials';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.surgery_materials';
                        break;
                    default:
                        $key = 'SurgeryMaterials';
                }

                $result[$key] = $this->collSurgeryMaterials->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSurgeryTUsses) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'surgeryTUsses';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.surgery_TUsses';
                        break;
                    default:
                        $key = 'SurgeryTUsses';
                }

                $result[$key] = $this->collSurgeryTUsses->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\MocApi\Models\Surgery
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SurgeryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MocApi\Models\Surgery
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setStatus($value);
                break;
            case 2:
                $this->setCreatorId($value);
                break;
            case 3:
                $this->setSurgeryTypeId($value);
                break;
            case 4:
                $this->setCreated($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = SurgeryTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setStatus($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCreatorId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSurgeryTypeId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCreated($arr[$keys[4]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\MocApi\Models\Surgery The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(SurgeryTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SurgeryTableMap::COL_ID)) {
            $criteria->add(SurgeryTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SurgeryTableMap::COL_STATUS)) {
            $criteria->add(SurgeryTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(SurgeryTableMap::COL_CREATOR_ID)) {
            $criteria->add(SurgeryTableMap::COL_CREATOR_ID, $this->creator_id);
        }
        if ($this->isColumnModified(SurgeryTableMap::COL_SURGERY_TYPE_ID)) {
            $criteria->add(SurgeryTableMap::COL_SURGERY_TYPE_ID, $this->surgery_type_id);
        }
        if ($this->isColumnModified(SurgeryTableMap::COL_CREATED)) {
            $criteria->add(SurgeryTableMap::COL_CREATED, $this->created);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildSurgeryQuery::create();
        $criteria->add(SurgeryTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \MocApi\Models\Surgery (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setStatus($this->getStatus());
        $copyObj->setCreatorId($this->getCreatorId());
        $copyObj->setSurgeryTypeId($this->getSurgeryTypeId());
        $copyObj->setCreated($this->getCreated());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPatients() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPatient($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSurgeonSurgeries() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSurgeonSurgery($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSurgeryEquipments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSurgeryEquipment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSurgeryFieldValues() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSurgeryFieldValue($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSurgeryMaterials() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSurgeryMaterial($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSurgeryTUsses() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSurgeryTUSS($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \MocApi\Models\Surgery Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildPerson object.
     *
     * @param  ChildPerson $v
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCreator(ChildPerson $v = null)
    {
        if ($v === null) {
            $this->setCreatorId(NULL);
        } else {
            $this->setCreatorId($v->getId());
        }

        $this->aCreator = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPerson object, it will not be re-added.
        if ($v !== null) {
            $v->addSurgery($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPerson object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPerson The associated ChildPerson object.
     * @throws PropelException
     */
    public function getCreator(ConnectionInterface $con = null)
    {
        if ($this->aCreator === null && ($this->creator_id !== null)) {
            $this->aCreator = ChildPersonQuery::create()->findPk($this->creator_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCreator->addSurgeries($this);
             */
        }

        return $this->aCreator;
    }

    /**
     * Declares an association between this object and a ChildSurgeryType object.
     *
     * @param  ChildSurgeryType $v
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSurgeryType(ChildSurgeryType $v = null)
    {
        if ($v === null) {
            $this->setSurgeryTypeId(NULL);
        } else {
            $this->setSurgeryTypeId($v->getId());
        }

        $this->aSurgeryType = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSurgeryType object, it will not be re-added.
        if ($v !== null) {
            $v->addSurgery($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSurgeryType object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSurgeryType The associated ChildSurgeryType object.
     * @throws PropelException
     */
    public function getSurgeryType(ConnectionInterface $con = null)
    {
        if ($this->aSurgeryType === null && ($this->surgery_type_id !== null)) {
            $this->aSurgeryType = ChildSurgeryTypeQuery::create()->findPk($this->surgery_type_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSurgeryType->addSurgeries($this);
             */
        }

        return $this->aSurgeryType;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Patient' == $relationName) {
            return $this->initPatients();
        }
        if ('SurgeonSurgery' == $relationName) {
            return $this->initSurgeonSurgeries();
        }
        if ('SurgeryEquipment' == $relationName) {
            return $this->initSurgeryEquipments();
        }
        if ('SurgeryFieldValue' == $relationName) {
            return $this->initSurgeryFieldValues();
        }
        if ('SurgeryMaterial' == $relationName) {
            return $this->initSurgeryMaterials();
        }
        if ('SurgeryTUSS' == $relationName) {
            return $this->initSurgeryTUsses();
        }
    }

    /**
     * Clears out the collPatients collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPatients()
     */
    public function clearPatients()
    {
        $this->collPatients = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPatients collection loaded partially.
     */
    public function resetPartialPatients($v = true)
    {
        $this->collPatientsPartial = $v;
    }

    /**
     * Initializes the collPatients collection.
     *
     * By default this just sets the collPatients collection to an empty array (like clearcollPatients());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPatients($overrideExisting = true)
    {
        if (null !== $this->collPatients && !$overrideExisting) {
            return;
        }
        $this->collPatients = new ObjectCollection();
        $this->collPatients->setModel('\MocApi\Models\Patient');
    }

    /**
     * Gets an array of ChildPatient objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgery is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPatient[] List of ChildPatient objects
     * @throws PropelException
     */
    public function getPatients(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPatientsPartial && !$this->isNew();
        if (null === $this->collPatients || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPatients) {
                // return empty collection
                $this->initPatients();
            } else {
                $collPatients = ChildPatientQuery::create(null, $criteria)
                    ->filterBySurgery($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPatientsPartial && count($collPatients)) {
                        $this->initPatients(false);

                        foreach ($collPatients as $obj) {
                            if (false == $this->collPatients->contains($obj)) {
                                $this->collPatients->append($obj);
                            }
                        }

                        $this->collPatientsPartial = true;
                    }

                    return $collPatients;
                }

                if ($partial && $this->collPatients) {
                    foreach ($this->collPatients as $obj) {
                        if ($obj->isNew()) {
                            $collPatients[] = $obj;
                        }
                    }
                }

                $this->collPatients = $collPatients;
                $this->collPatientsPartial = false;
            }
        }

        return $this->collPatients;
    }

    /**
     * Sets a collection of ChildPatient objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $patients A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function setPatients(Collection $patients, ConnectionInterface $con = null)
    {
        /** @var ChildPatient[] $patientsToDelete */
        $patientsToDelete = $this->getPatients(new Criteria(), $con)->diff($patients);


        $this->patientsScheduledForDeletion = $patientsToDelete;

        foreach ($patientsToDelete as $patientRemoved) {
            $patientRemoved->setSurgery(null);
        }

        $this->collPatients = null;
        foreach ($patients as $patient) {
            $this->addPatient($patient);
        }

        $this->collPatients = $patients;
        $this->collPatientsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Patient objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Patient objects.
     * @throws PropelException
     */
    public function countPatients(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPatientsPartial && !$this->isNew();
        if (null === $this->collPatients || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPatients) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPatients());
            }

            $query = ChildPatientQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySurgery($this)
                ->count($con);
        }

        return count($this->collPatients);
    }

    /**
     * Method called to associate a ChildPatient object to this object
     * through the ChildPatient foreign key attribute.
     *
     * @param  ChildPatient $l ChildPatient
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function addPatient(ChildPatient $l)
    {
        if ($this->collPatients === null) {
            $this->initPatients();
            $this->collPatientsPartial = true;
        }

        if (!$this->collPatients->contains($l)) {
            $this->doAddPatient($l);
        }

        return $this;
    }

    /**
     * @param ChildPatient $patient The ChildPatient object to add.
     */
    protected function doAddPatient(ChildPatient $patient)
    {
        $this->collPatients[]= $patient;
        $patient->setSurgery($this);
    }

    /**
     * @param  ChildPatient $patient The ChildPatient object to remove.
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function removePatient(ChildPatient $patient)
    {
        if ($this->getPatients()->contains($patient)) {
            $pos = $this->collPatients->search($patient);
            $this->collPatients->remove($pos);
            if (null === $this->patientsScheduledForDeletion) {
                $this->patientsScheduledForDeletion = clone $this->collPatients;
                $this->patientsScheduledForDeletion->clear();
            }
            $this->patientsScheduledForDeletion[]= clone $patient;
            $patient->setSurgery(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Surgery is new, it will return
     * an empty collection; or if this Surgery has previously
     * been saved, it will retrieve related Patients from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Surgery.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPatient[] List of ChildPatient objects
     */
    public function getPatientsJoinPerson(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPatientQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getPatients($query, $con);
    }

    /**
     * Clears out the collSurgeonSurgeries collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSurgeonSurgeries()
     */
    public function clearSurgeonSurgeries()
    {
        $this->collSurgeonSurgeries = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSurgeonSurgeries collection loaded partially.
     */
    public function resetPartialSurgeonSurgeries($v = true)
    {
        $this->collSurgeonSurgeriesPartial = $v;
    }

    /**
     * Initializes the collSurgeonSurgeries collection.
     *
     * By default this just sets the collSurgeonSurgeries collection to an empty array (like clearcollSurgeonSurgeries());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSurgeonSurgeries($overrideExisting = true)
    {
        if (null !== $this->collSurgeonSurgeries && !$overrideExisting) {
            return;
        }
        $this->collSurgeonSurgeries = new ObjectCollection();
        $this->collSurgeonSurgeries->setModel('\MocApi\Models\SurgeonSurgery');
    }

    /**
     * Gets an array of ChildSurgeonSurgery objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgery is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSurgeonSurgery[] List of ChildSurgeonSurgery objects
     * @throws PropelException
     */
    public function getSurgeonSurgeries(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeonSurgeriesPartial && !$this->isNew();
        if (null === $this->collSurgeonSurgeries || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSurgeonSurgeries) {
                // return empty collection
                $this->initSurgeonSurgeries();
            } else {
                $collSurgeonSurgeries = ChildSurgeonSurgeryQuery::create(null, $criteria)
                    ->filterBySurgery($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSurgeonSurgeriesPartial && count($collSurgeonSurgeries)) {
                        $this->initSurgeonSurgeries(false);

                        foreach ($collSurgeonSurgeries as $obj) {
                            if (false == $this->collSurgeonSurgeries->contains($obj)) {
                                $this->collSurgeonSurgeries->append($obj);
                            }
                        }

                        $this->collSurgeonSurgeriesPartial = true;
                    }

                    return $collSurgeonSurgeries;
                }

                if ($partial && $this->collSurgeonSurgeries) {
                    foreach ($this->collSurgeonSurgeries as $obj) {
                        if ($obj->isNew()) {
                            $collSurgeonSurgeries[] = $obj;
                        }
                    }
                }

                $this->collSurgeonSurgeries = $collSurgeonSurgeries;
                $this->collSurgeonSurgeriesPartial = false;
            }
        }

        return $this->collSurgeonSurgeries;
    }

    /**
     * Sets a collection of ChildSurgeonSurgery objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $surgeonSurgeries A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function setSurgeonSurgeries(Collection $surgeonSurgeries, ConnectionInterface $con = null)
    {
        /** @var ChildSurgeonSurgery[] $surgeonSurgeriesToDelete */
        $surgeonSurgeriesToDelete = $this->getSurgeonSurgeries(new Criteria(), $con)->diff($surgeonSurgeries);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->surgeonSurgeriesScheduledForDeletion = clone $surgeonSurgeriesToDelete;

        foreach ($surgeonSurgeriesToDelete as $surgeonSurgeryRemoved) {
            $surgeonSurgeryRemoved->setSurgery(null);
        }

        $this->collSurgeonSurgeries = null;
        foreach ($surgeonSurgeries as $surgeonSurgery) {
            $this->addSurgeonSurgery($surgeonSurgery);
        }

        $this->collSurgeonSurgeries = $surgeonSurgeries;
        $this->collSurgeonSurgeriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SurgeonSurgery objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SurgeonSurgery objects.
     * @throws PropelException
     */
    public function countSurgeonSurgeries(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeonSurgeriesPartial && !$this->isNew();
        if (null === $this->collSurgeonSurgeries || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSurgeonSurgeries) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSurgeonSurgeries());
            }

            $query = ChildSurgeonSurgeryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySurgery($this)
                ->count($con);
        }

        return count($this->collSurgeonSurgeries);
    }

    /**
     * Method called to associate a ChildSurgeonSurgery object to this object
     * through the ChildSurgeonSurgery foreign key attribute.
     *
     * @param  ChildSurgeonSurgery $l ChildSurgeonSurgery
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function addSurgeonSurgery(ChildSurgeonSurgery $l)
    {
        if ($this->collSurgeonSurgeries === null) {
            $this->initSurgeonSurgeries();
            $this->collSurgeonSurgeriesPartial = true;
        }

        if (!$this->collSurgeonSurgeries->contains($l)) {
            $this->doAddSurgeonSurgery($l);
        }

        return $this;
    }

    /**
     * @param ChildSurgeonSurgery $surgeonSurgery The ChildSurgeonSurgery object to add.
     */
    protected function doAddSurgeonSurgery(ChildSurgeonSurgery $surgeonSurgery)
    {
        $this->collSurgeonSurgeries[]= $surgeonSurgery;
        $surgeonSurgery->setSurgery($this);
    }

    /**
     * @param  ChildSurgeonSurgery $surgeonSurgery The ChildSurgeonSurgery object to remove.
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function removeSurgeonSurgery(ChildSurgeonSurgery $surgeonSurgery)
    {
        if ($this->getSurgeonSurgeries()->contains($surgeonSurgery)) {
            $pos = $this->collSurgeonSurgeries->search($surgeonSurgery);
            $this->collSurgeonSurgeries->remove($pos);
            if (null === $this->surgeonSurgeriesScheduledForDeletion) {
                $this->surgeonSurgeriesScheduledForDeletion = clone $this->collSurgeonSurgeries;
                $this->surgeonSurgeriesScheduledForDeletion->clear();
            }
            $this->surgeonSurgeriesScheduledForDeletion[]= clone $surgeonSurgery;
            $surgeonSurgery->setSurgery(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Surgery is new, it will return
     * an empty collection; or if this Surgery has previously
     * been saved, it will retrieve related SurgeonSurgeries from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Surgery.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSurgeonSurgery[] List of ChildSurgeonSurgery objects
     */
    public function getSurgeonSurgeriesJoinSurgeon(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSurgeonSurgeryQuery::create(null, $criteria);
        $query->joinWith('Surgeon', $joinBehavior);

        return $this->getSurgeonSurgeries($query, $con);
    }

    /**
     * Clears out the collSurgeryEquipments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSurgeryEquipments()
     */
    public function clearSurgeryEquipments()
    {
        $this->collSurgeryEquipments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSurgeryEquipments collection loaded partially.
     */
    public function resetPartialSurgeryEquipments($v = true)
    {
        $this->collSurgeryEquipmentsPartial = $v;
    }

    /**
     * Initializes the collSurgeryEquipments collection.
     *
     * By default this just sets the collSurgeryEquipments collection to an empty array (like clearcollSurgeryEquipments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSurgeryEquipments($overrideExisting = true)
    {
        if (null !== $this->collSurgeryEquipments && !$overrideExisting) {
            return;
        }
        $this->collSurgeryEquipments = new ObjectCollection();
        $this->collSurgeryEquipments->setModel('\MocApi\Models\SurgeryEquipment');
    }

    /**
     * Gets an array of ChildSurgeryEquipment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgery is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSurgeryEquipment[] List of ChildSurgeryEquipment objects
     * @throws PropelException
     */
    public function getSurgeryEquipments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeryEquipmentsPartial && !$this->isNew();
        if (null === $this->collSurgeryEquipments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSurgeryEquipments) {
                // return empty collection
                $this->initSurgeryEquipments();
            } else {
                $collSurgeryEquipments = ChildSurgeryEquipmentQuery::create(null, $criteria)
                    ->filterBySurgery($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSurgeryEquipmentsPartial && count($collSurgeryEquipments)) {
                        $this->initSurgeryEquipments(false);

                        foreach ($collSurgeryEquipments as $obj) {
                            if (false == $this->collSurgeryEquipments->contains($obj)) {
                                $this->collSurgeryEquipments->append($obj);
                            }
                        }

                        $this->collSurgeryEquipmentsPartial = true;
                    }

                    return $collSurgeryEquipments;
                }

                if ($partial && $this->collSurgeryEquipments) {
                    foreach ($this->collSurgeryEquipments as $obj) {
                        if ($obj->isNew()) {
                            $collSurgeryEquipments[] = $obj;
                        }
                    }
                }

                $this->collSurgeryEquipments = $collSurgeryEquipments;
                $this->collSurgeryEquipmentsPartial = false;
            }
        }

        return $this->collSurgeryEquipments;
    }

    /**
     * Sets a collection of ChildSurgeryEquipment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $surgeryEquipments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function setSurgeryEquipments(Collection $surgeryEquipments, ConnectionInterface $con = null)
    {
        /** @var ChildSurgeryEquipment[] $surgeryEquipmentsToDelete */
        $surgeryEquipmentsToDelete = $this->getSurgeryEquipments(new Criteria(), $con)->diff($surgeryEquipments);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->surgeryEquipmentsScheduledForDeletion = clone $surgeryEquipmentsToDelete;

        foreach ($surgeryEquipmentsToDelete as $surgeryEquipmentRemoved) {
            $surgeryEquipmentRemoved->setSurgery(null);
        }

        $this->collSurgeryEquipments = null;
        foreach ($surgeryEquipments as $surgeryEquipment) {
            $this->addSurgeryEquipment($surgeryEquipment);
        }

        $this->collSurgeryEquipments = $surgeryEquipments;
        $this->collSurgeryEquipmentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SurgeryEquipment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SurgeryEquipment objects.
     * @throws PropelException
     */
    public function countSurgeryEquipments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeryEquipmentsPartial && !$this->isNew();
        if (null === $this->collSurgeryEquipments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSurgeryEquipments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSurgeryEquipments());
            }

            $query = ChildSurgeryEquipmentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySurgery($this)
                ->count($con);
        }

        return count($this->collSurgeryEquipments);
    }

    /**
     * Method called to associate a ChildSurgeryEquipment object to this object
     * through the ChildSurgeryEquipment foreign key attribute.
     *
     * @param  ChildSurgeryEquipment $l ChildSurgeryEquipment
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function addSurgeryEquipment(ChildSurgeryEquipment $l)
    {
        if ($this->collSurgeryEquipments === null) {
            $this->initSurgeryEquipments();
            $this->collSurgeryEquipmentsPartial = true;
        }

        if (!$this->collSurgeryEquipments->contains($l)) {
            $this->doAddSurgeryEquipment($l);
        }

        return $this;
    }

    /**
     * @param ChildSurgeryEquipment $surgeryEquipment The ChildSurgeryEquipment object to add.
     */
    protected function doAddSurgeryEquipment(ChildSurgeryEquipment $surgeryEquipment)
    {
        $this->collSurgeryEquipments[]= $surgeryEquipment;
        $surgeryEquipment->setSurgery($this);
    }

    /**
     * @param  ChildSurgeryEquipment $surgeryEquipment The ChildSurgeryEquipment object to remove.
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function removeSurgeryEquipment(ChildSurgeryEquipment $surgeryEquipment)
    {
        if ($this->getSurgeryEquipments()->contains($surgeryEquipment)) {
            $pos = $this->collSurgeryEquipments->search($surgeryEquipment);
            $this->collSurgeryEquipments->remove($pos);
            if (null === $this->surgeryEquipmentsScheduledForDeletion) {
                $this->surgeryEquipmentsScheduledForDeletion = clone $this->collSurgeryEquipments;
                $this->surgeryEquipmentsScheduledForDeletion->clear();
            }
            $this->surgeryEquipmentsScheduledForDeletion[]= clone $surgeryEquipment;
            $surgeryEquipment->setSurgery(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Surgery is new, it will return
     * an empty collection; or if this Surgery has previously
     * been saved, it will retrieve related SurgeryEquipments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Surgery.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSurgeryEquipment[] List of ChildSurgeryEquipment objects
     */
    public function getSurgeryEquipmentsJoinEquipment(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSurgeryEquipmentQuery::create(null, $criteria);
        $query->joinWith('Equipment', $joinBehavior);

        return $this->getSurgeryEquipments($query, $con);
    }

    /**
     * Clears out the collSurgeryFieldValues collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSurgeryFieldValues()
     */
    public function clearSurgeryFieldValues()
    {
        $this->collSurgeryFieldValues = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSurgeryFieldValues collection loaded partially.
     */
    public function resetPartialSurgeryFieldValues($v = true)
    {
        $this->collSurgeryFieldValuesPartial = $v;
    }

    /**
     * Initializes the collSurgeryFieldValues collection.
     *
     * By default this just sets the collSurgeryFieldValues collection to an empty array (like clearcollSurgeryFieldValues());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSurgeryFieldValues($overrideExisting = true)
    {
        if (null !== $this->collSurgeryFieldValues && !$overrideExisting) {
            return;
        }
        $this->collSurgeryFieldValues = new ObjectCollection();
        $this->collSurgeryFieldValues->setModel('\MocApi\Models\SurgeryFieldValue');
    }

    /**
     * Gets an array of ChildSurgeryFieldValue objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgery is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSurgeryFieldValue[] List of ChildSurgeryFieldValue objects
     * @throws PropelException
     */
    public function getSurgeryFieldValues(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeryFieldValuesPartial && !$this->isNew();
        if (null === $this->collSurgeryFieldValues || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSurgeryFieldValues) {
                // return empty collection
                $this->initSurgeryFieldValues();
            } else {
                $collSurgeryFieldValues = ChildSurgeryFieldValueQuery::create(null, $criteria)
                    ->filterBySurgery($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSurgeryFieldValuesPartial && count($collSurgeryFieldValues)) {
                        $this->initSurgeryFieldValues(false);

                        foreach ($collSurgeryFieldValues as $obj) {
                            if (false == $this->collSurgeryFieldValues->contains($obj)) {
                                $this->collSurgeryFieldValues->append($obj);
                            }
                        }

                        $this->collSurgeryFieldValuesPartial = true;
                    }

                    return $collSurgeryFieldValues;
                }

                if ($partial && $this->collSurgeryFieldValues) {
                    foreach ($this->collSurgeryFieldValues as $obj) {
                        if ($obj->isNew()) {
                            $collSurgeryFieldValues[] = $obj;
                        }
                    }
                }

                $this->collSurgeryFieldValues = $collSurgeryFieldValues;
                $this->collSurgeryFieldValuesPartial = false;
            }
        }

        return $this->collSurgeryFieldValues;
    }

    /**
     * Sets a collection of ChildSurgeryFieldValue objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $surgeryFieldValues A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function setSurgeryFieldValues(Collection $surgeryFieldValues, ConnectionInterface $con = null)
    {
        /** @var ChildSurgeryFieldValue[] $surgeryFieldValuesToDelete */
        $surgeryFieldValuesToDelete = $this->getSurgeryFieldValues(new Criteria(), $con)->diff($surgeryFieldValues);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->surgeryFieldValuesScheduledForDeletion = clone $surgeryFieldValuesToDelete;

        foreach ($surgeryFieldValuesToDelete as $surgeryFieldValueRemoved) {
            $surgeryFieldValueRemoved->setSurgery(null);
        }

        $this->collSurgeryFieldValues = null;
        foreach ($surgeryFieldValues as $surgeryFieldValue) {
            $this->addSurgeryFieldValue($surgeryFieldValue);
        }

        $this->collSurgeryFieldValues = $surgeryFieldValues;
        $this->collSurgeryFieldValuesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SurgeryFieldValue objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SurgeryFieldValue objects.
     * @throws PropelException
     */
    public function countSurgeryFieldValues(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeryFieldValuesPartial && !$this->isNew();
        if (null === $this->collSurgeryFieldValues || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSurgeryFieldValues) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSurgeryFieldValues());
            }

            $query = ChildSurgeryFieldValueQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySurgery($this)
                ->count($con);
        }

        return count($this->collSurgeryFieldValues);
    }

    /**
     * Method called to associate a ChildSurgeryFieldValue object to this object
     * through the ChildSurgeryFieldValue foreign key attribute.
     *
     * @param  ChildSurgeryFieldValue $l ChildSurgeryFieldValue
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function addSurgeryFieldValue(ChildSurgeryFieldValue $l)
    {
        if ($this->collSurgeryFieldValues === null) {
            $this->initSurgeryFieldValues();
            $this->collSurgeryFieldValuesPartial = true;
        }

        if (!$this->collSurgeryFieldValues->contains($l)) {
            $this->doAddSurgeryFieldValue($l);
        }

        return $this;
    }

    /**
     * @param ChildSurgeryFieldValue $surgeryFieldValue The ChildSurgeryFieldValue object to add.
     */
    protected function doAddSurgeryFieldValue(ChildSurgeryFieldValue $surgeryFieldValue)
    {
        $this->collSurgeryFieldValues[]= $surgeryFieldValue;
        $surgeryFieldValue->setSurgery($this);
    }

    /**
     * @param  ChildSurgeryFieldValue $surgeryFieldValue The ChildSurgeryFieldValue object to remove.
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function removeSurgeryFieldValue(ChildSurgeryFieldValue $surgeryFieldValue)
    {
        if ($this->getSurgeryFieldValues()->contains($surgeryFieldValue)) {
            $pos = $this->collSurgeryFieldValues->search($surgeryFieldValue);
            $this->collSurgeryFieldValues->remove($pos);
            if (null === $this->surgeryFieldValuesScheduledForDeletion) {
                $this->surgeryFieldValuesScheduledForDeletion = clone $this->collSurgeryFieldValues;
                $this->surgeryFieldValuesScheduledForDeletion->clear();
            }
            $this->surgeryFieldValuesScheduledForDeletion[]= clone $surgeryFieldValue;
            $surgeryFieldValue->setSurgery(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Surgery is new, it will return
     * an empty collection; or if this Surgery has previously
     * been saved, it will retrieve related SurgeryFieldValues from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Surgery.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSurgeryFieldValue[] List of ChildSurgeryFieldValue objects
     */
    public function getSurgeryFieldValuesJoinSurgeryField(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSurgeryFieldValueQuery::create(null, $criteria);
        $query->joinWith('SurgeryField', $joinBehavior);

        return $this->getSurgeryFieldValues($query, $con);
    }

    /**
     * Clears out the collSurgeryMaterials collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSurgeryMaterials()
     */
    public function clearSurgeryMaterials()
    {
        $this->collSurgeryMaterials = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSurgeryMaterials collection loaded partially.
     */
    public function resetPartialSurgeryMaterials($v = true)
    {
        $this->collSurgeryMaterialsPartial = $v;
    }

    /**
     * Initializes the collSurgeryMaterials collection.
     *
     * By default this just sets the collSurgeryMaterials collection to an empty array (like clearcollSurgeryMaterials());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSurgeryMaterials($overrideExisting = true)
    {
        if (null !== $this->collSurgeryMaterials && !$overrideExisting) {
            return;
        }
        $this->collSurgeryMaterials = new ObjectCollection();
        $this->collSurgeryMaterials->setModel('\MocApi\Models\SurgeryMaterial');
    }

    /**
     * Gets an array of ChildSurgeryMaterial objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgery is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSurgeryMaterial[] List of ChildSurgeryMaterial objects
     * @throws PropelException
     */
    public function getSurgeryMaterials(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeryMaterialsPartial && !$this->isNew();
        if (null === $this->collSurgeryMaterials || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSurgeryMaterials) {
                // return empty collection
                $this->initSurgeryMaterials();
            } else {
                $collSurgeryMaterials = ChildSurgeryMaterialQuery::create(null, $criteria)
                    ->filterBySurgery($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSurgeryMaterialsPartial && count($collSurgeryMaterials)) {
                        $this->initSurgeryMaterials(false);

                        foreach ($collSurgeryMaterials as $obj) {
                            if (false == $this->collSurgeryMaterials->contains($obj)) {
                                $this->collSurgeryMaterials->append($obj);
                            }
                        }

                        $this->collSurgeryMaterialsPartial = true;
                    }

                    return $collSurgeryMaterials;
                }

                if ($partial && $this->collSurgeryMaterials) {
                    foreach ($this->collSurgeryMaterials as $obj) {
                        if ($obj->isNew()) {
                            $collSurgeryMaterials[] = $obj;
                        }
                    }
                }

                $this->collSurgeryMaterials = $collSurgeryMaterials;
                $this->collSurgeryMaterialsPartial = false;
            }
        }

        return $this->collSurgeryMaterials;
    }

    /**
     * Sets a collection of ChildSurgeryMaterial objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $surgeryMaterials A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function setSurgeryMaterials(Collection $surgeryMaterials, ConnectionInterface $con = null)
    {
        /** @var ChildSurgeryMaterial[] $surgeryMaterialsToDelete */
        $surgeryMaterialsToDelete = $this->getSurgeryMaterials(new Criteria(), $con)->diff($surgeryMaterials);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->surgeryMaterialsScheduledForDeletion = clone $surgeryMaterialsToDelete;

        foreach ($surgeryMaterialsToDelete as $surgeryMaterialRemoved) {
            $surgeryMaterialRemoved->setSurgery(null);
        }

        $this->collSurgeryMaterials = null;
        foreach ($surgeryMaterials as $surgeryMaterial) {
            $this->addSurgeryMaterial($surgeryMaterial);
        }

        $this->collSurgeryMaterials = $surgeryMaterials;
        $this->collSurgeryMaterialsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SurgeryMaterial objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SurgeryMaterial objects.
     * @throws PropelException
     */
    public function countSurgeryMaterials(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeryMaterialsPartial && !$this->isNew();
        if (null === $this->collSurgeryMaterials || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSurgeryMaterials) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSurgeryMaterials());
            }

            $query = ChildSurgeryMaterialQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySurgery($this)
                ->count($con);
        }

        return count($this->collSurgeryMaterials);
    }

    /**
     * Method called to associate a ChildSurgeryMaterial object to this object
     * through the ChildSurgeryMaterial foreign key attribute.
     *
     * @param  ChildSurgeryMaterial $l ChildSurgeryMaterial
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function addSurgeryMaterial(ChildSurgeryMaterial $l)
    {
        if ($this->collSurgeryMaterials === null) {
            $this->initSurgeryMaterials();
            $this->collSurgeryMaterialsPartial = true;
        }

        if (!$this->collSurgeryMaterials->contains($l)) {
            $this->doAddSurgeryMaterial($l);
        }

        return $this;
    }

    /**
     * @param ChildSurgeryMaterial $surgeryMaterial The ChildSurgeryMaterial object to add.
     */
    protected function doAddSurgeryMaterial(ChildSurgeryMaterial $surgeryMaterial)
    {
        $this->collSurgeryMaterials[]= $surgeryMaterial;
        $surgeryMaterial->setSurgery($this);
    }

    /**
     * @param  ChildSurgeryMaterial $surgeryMaterial The ChildSurgeryMaterial object to remove.
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function removeSurgeryMaterial(ChildSurgeryMaterial $surgeryMaterial)
    {
        if ($this->getSurgeryMaterials()->contains($surgeryMaterial)) {
            $pos = $this->collSurgeryMaterials->search($surgeryMaterial);
            $this->collSurgeryMaterials->remove($pos);
            if (null === $this->surgeryMaterialsScheduledForDeletion) {
                $this->surgeryMaterialsScheduledForDeletion = clone $this->collSurgeryMaterials;
                $this->surgeryMaterialsScheduledForDeletion->clear();
            }
            $this->surgeryMaterialsScheduledForDeletion[]= clone $surgeryMaterial;
            $surgeryMaterial->setSurgery(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Surgery is new, it will return
     * an empty collection; or if this Surgery has previously
     * been saved, it will retrieve related SurgeryMaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Surgery.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSurgeryMaterial[] List of ChildSurgeryMaterial objects
     */
    public function getSurgeryMaterialsJoinMaterial(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSurgeryMaterialQuery::create(null, $criteria);
        $query->joinWith('Material', $joinBehavior);

        return $this->getSurgeryMaterials($query, $con);
    }

    /**
     * Clears out the collSurgeryTUsses collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSurgeryTUsses()
     */
    public function clearSurgeryTUsses()
    {
        $this->collSurgeryTUsses = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSurgeryTUsses collection loaded partially.
     */
    public function resetPartialSurgeryTUsses($v = true)
    {
        $this->collSurgeryTUssesPartial = $v;
    }

    /**
     * Initializes the collSurgeryTUsses collection.
     *
     * By default this just sets the collSurgeryTUsses collection to an empty array (like clearcollSurgeryTUsses());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSurgeryTUsses($overrideExisting = true)
    {
        if (null !== $this->collSurgeryTUsses && !$overrideExisting) {
            return;
        }
        $this->collSurgeryTUsses = new ObjectCollection();
        $this->collSurgeryTUsses->setModel('\MocApi\Models\SurgeryTUSS');
    }

    /**
     * Gets an array of ChildSurgeryTUSS objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgery is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSurgeryTUSS[] List of ChildSurgeryTUSS objects
     * @throws PropelException
     */
    public function getSurgeryTUsses(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeryTUssesPartial && !$this->isNew();
        if (null === $this->collSurgeryTUsses || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSurgeryTUsses) {
                // return empty collection
                $this->initSurgeryTUsses();
            } else {
                $collSurgeryTUsses = ChildSurgeryTUSSQuery::create(null, $criteria)
                    ->filterBySurgery($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSurgeryTUssesPartial && count($collSurgeryTUsses)) {
                        $this->initSurgeryTUsses(false);

                        foreach ($collSurgeryTUsses as $obj) {
                            if (false == $this->collSurgeryTUsses->contains($obj)) {
                                $this->collSurgeryTUsses->append($obj);
                            }
                        }

                        $this->collSurgeryTUssesPartial = true;
                    }

                    return $collSurgeryTUsses;
                }

                if ($partial && $this->collSurgeryTUsses) {
                    foreach ($this->collSurgeryTUsses as $obj) {
                        if ($obj->isNew()) {
                            $collSurgeryTUsses[] = $obj;
                        }
                    }
                }

                $this->collSurgeryTUsses = $collSurgeryTUsses;
                $this->collSurgeryTUssesPartial = false;
            }
        }

        return $this->collSurgeryTUsses;
    }

    /**
     * Sets a collection of ChildSurgeryTUSS objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $surgeryTUsses A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function setSurgeryTUsses(Collection $surgeryTUsses, ConnectionInterface $con = null)
    {
        /** @var ChildSurgeryTUSS[] $surgeryTUssesToDelete */
        $surgeryTUssesToDelete = $this->getSurgeryTUsses(new Criteria(), $con)->diff($surgeryTUsses);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->surgeryTUssesScheduledForDeletion = clone $surgeryTUssesToDelete;

        foreach ($surgeryTUssesToDelete as $surgeryTUSSRemoved) {
            $surgeryTUSSRemoved->setSurgery(null);
        }

        $this->collSurgeryTUsses = null;
        foreach ($surgeryTUsses as $surgeryTUSS) {
            $this->addSurgeryTUSS($surgeryTUSS);
        }

        $this->collSurgeryTUsses = $surgeryTUsses;
        $this->collSurgeryTUssesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SurgeryTUSS objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SurgeryTUSS objects.
     * @throws PropelException
     */
    public function countSurgeryTUsses(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeryTUssesPartial && !$this->isNew();
        if (null === $this->collSurgeryTUsses || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSurgeryTUsses) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSurgeryTUsses());
            }

            $query = ChildSurgeryTUSSQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySurgery($this)
                ->count($con);
        }

        return count($this->collSurgeryTUsses);
    }

    /**
     * Method called to associate a ChildSurgeryTUSS object to this object
     * through the ChildSurgeryTUSS foreign key attribute.
     *
     * @param  ChildSurgeryTUSS $l ChildSurgeryTUSS
     * @return $this|\MocApi\Models\Surgery The current object (for fluent API support)
     */
    public function addSurgeryTUSS(ChildSurgeryTUSS $l)
    {
        if ($this->collSurgeryTUsses === null) {
            $this->initSurgeryTUsses();
            $this->collSurgeryTUssesPartial = true;
        }

        if (!$this->collSurgeryTUsses->contains($l)) {
            $this->doAddSurgeryTUSS($l);
        }

        return $this;
    }

    /**
     * @param ChildSurgeryTUSS $surgeryTUSS The ChildSurgeryTUSS object to add.
     */
    protected function doAddSurgeryTUSS(ChildSurgeryTUSS $surgeryTUSS)
    {
        $this->collSurgeryTUsses[]= $surgeryTUSS;
        $surgeryTUSS->setSurgery($this);
    }

    /**
     * @param  ChildSurgeryTUSS $surgeryTUSS The ChildSurgeryTUSS object to remove.
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function removeSurgeryTUSS(ChildSurgeryTUSS $surgeryTUSS)
    {
        if ($this->getSurgeryTUsses()->contains($surgeryTUSS)) {
            $pos = $this->collSurgeryTUsses->search($surgeryTUSS);
            $this->collSurgeryTUsses->remove($pos);
            if (null === $this->surgeryTUssesScheduledForDeletion) {
                $this->surgeryTUssesScheduledForDeletion = clone $this->collSurgeryTUsses;
                $this->surgeryTUssesScheduledForDeletion->clear();
            }
            $this->surgeryTUssesScheduledForDeletion[]= clone $surgeryTUSS;
            $surgeryTUSS->setSurgery(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Surgery is new, it will return
     * an empty collection; or if this Surgery has previously
     * been saved, it will retrieve related SurgeryTUsses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Surgery.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSurgeryTUSS[] List of ChildSurgeryTUSS objects
     */
    public function getSurgeryTUssesJoinTUSS(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSurgeryTUSSQuery::create(null, $criteria);
        $query->joinWith('TUSS', $joinBehavior);

        return $this->getSurgeryTUsses($query, $con);
    }

    /**
     * Clears out the collSurgeons collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSurgeons()
     */
    public function clearSurgeons()
    {
        $this->collSurgeons = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collSurgeons crossRef collection.
     *
     * By default this just sets the collSurgeons collection to an empty collection (like clearSurgeons());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initSurgeons()
    {
        $this->collSurgeons = new ObjectCollection();
        $this->collSurgeonsPartial = true;

        $this->collSurgeons->setModel('\MocApi\Models\Surgeon');
    }

    /**
     * Checks if the collSurgeons collection is loaded.
     *
     * @return bool
     */
    public function isSurgeonsLoaded()
    {
        return null !== $this->collSurgeons;
    }

    /**
     * Gets a collection of ChildSurgeon objects related by a many-to-many relationship
     * to the current object by way of the moc.surgeon_surgery cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgery is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildSurgeon[] List of ChildSurgeon objects
     */
    public function getSurgeons(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeonsPartial && !$this->isNew();
        if (null === $this->collSurgeons || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collSurgeons) {
                    $this->initSurgeons();
                }
            } else {

                $query = ChildSurgeonQuery::create(null, $criteria)
                    ->filterBySurgery($this);
                $collSurgeons = $query->find($con);
                if (null !== $criteria) {
                    return $collSurgeons;
                }

                if ($partial && $this->collSurgeons) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collSurgeons as $obj) {
                        if (!$collSurgeons->contains($obj)) {
                            $collSurgeons[] = $obj;
                        }
                    }
                }

                $this->collSurgeons = $collSurgeons;
                $this->collSurgeonsPartial = false;
            }
        }

        return $this->collSurgeons;
    }

    /**
     * Sets a collection of Surgeon objects related by a many-to-many relationship
     * to the current object by way of the moc.surgeon_surgery cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $surgeons A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function setSurgeons(Collection $surgeons, ConnectionInterface $con = null)
    {
        $this->clearSurgeons();
        $currentSurgeons = $this->getSurgeons();

        $surgeonsScheduledForDeletion = $currentSurgeons->diff($surgeons);

        foreach ($surgeonsScheduledForDeletion as $toDelete) {
            $this->removeSurgeon($toDelete);
        }

        foreach ($surgeons as $surgeon) {
            if (!$currentSurgeons->contains($surgeon)) {
                $this->doAddSurgeon($surgeon);
            }
        }

        $this->collSurgeonsPartial = false;
        $this->collSurgeons = $surgeons;

        return $this;
    }

    /**
     * Gets the number of Surgeon objects related by a many-to-many relationship
     * to the current object by way of the moc.surgeon_surgery cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Surgeon objects
     */
    public function countSurgeons(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeonsPartial && !$this->isNew();
        if (null === $this->collSurgeons || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSurgeons) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getSurgeons());
                }

                $query = ChildSurgeonQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySurgery($this)
                    ->count($con);
            }
        } else {
            return count($this->collSurgeons);
        }
    }

    /**
     * Associate a ChildSurgeon to this object
     * through the moc.surgeon_surgery cross reference table.
     *
     * @param ChildSurgeon $surgeon
     * @return ChildSurgery The current object (for fluent API support)
     */
    public function addSurgeon(ChildSurgeon $surgeon)
    {
        if ($this->collSurgeons === null) {
            $this->initSurgeons();
        }

        if (!$this->getSurgeons()->contains($surgeon)) {
            // only add it if the **same** object is not already associated
            $this->collSurgeons->push($surgeon);
            $this->doAddSurgeon($surgeon);
        }

        return $this;
    }

    /**
     *
     * @param ChildSurgeon $surgeon
     */
    protected function doAddSurgeon(ChildSurgeon $surgeon)
    {
        $surgeonSurgery = new ChildSurgeonSurgery();

        $surgeonSurgery->setSurgeon($surgeon);

        $surgeonSurgery->setSurgery($this);

        $this->addSurgeonSurgery($surgeonSurgery);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$surgeon->isSurgeriesLoaded()) {
            $surgeon->initSurgeries();
            $surgeon->getSurgeries()->push($this);
        } elseif (!$surgeon->getSurgeries()->contains($this)) {
            $surgeon->getSurgeries()->push($this);
        }

    }

    /**
     * Remove surgeon of this object
     * through the moc.surgeon_surgery cross reference table.
     *
     * @param ChildSurgeon $surgeon
     * @return ChildSurgery The current object (for fluent API support)
     */
    public function removeSurgeon(ChildSurgeon $surgeon)
    {
        if ($this->getSurgeons()->contains($surgeon)) { $surgeonSurgery = new ChildSurgeonSurgery();

            $surgeonSurgery->setSurgeon($surgeon);
            if ($surgeon->isSurgeriesLoaded()) {
                //remove the back reference if available
                $surgeon->getSurgeries()->removeObject($this);
            }

            $surgeonSurgery->setSurgery($this);
            $this->removeSurgeonSurgery(clone $surgeonSurgery);
            $surgeonSurgery->clear();

            $this->collSurgeons->remove($this->collSurgeons->search($surgeon));

            if (null === $this->surgeonsScheduledForDeletion) {
                $this->surgeonsScheduledForDeletion = clone $this->collSurgeons;
                $this->surgeonsScheduledForDeletion->clear();
            }

            $this->surgeonsScheduledForDeletion->push($surgeon);
        }


        return $this;
    }

    /**
     * Clears out the collEquipment collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEquipment()
     */
    public function clearEquipment()
    {
        $this->collEquipment = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collEquipment crossRef collection.
     *
     * By default this just sets the collEquipment collection to an empty collection (like clearEquipment());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initEquipment()
    {
        $this->collEquipment = new ObjectCollection();
        $this->collEquipmentPartial = true;

        $this->collEquipment->setModel('\MocApi\Models\Equipment');
    }

    /**
     * Checks if the collEquipment collection is loaded.
     *
     * @return bool
     */
    public function isEquipmentLoaded()
    {
        return null !== $this->collEquipment;
    }

    /**
     * Gets a collection of ChildEquipment objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_equipment cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgery is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildEquipment[] List of ChildEquipment objects
     */
    public function getEquipment(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEquipmentPartial && !$this->isNew();
        if (null === $this->collEquipment || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collEquipment) {
                    $this->initEquipment();
                }
            } else {

                $query = ChildEquipmentQuery::create(null, $criteria)
                    ->filterBySurgery($this);
                $collEquipment = $query->find($con);
                if (null !== $criteria) {
                    return $collEquipment;
                }

                if ($partial && $this->collEquipment) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collEquipment as $obj) {
                        if (!$collEquipment->contains($obj)) {
                            $collEquipment[] = $obj;
                        }
                    }
                }

                $this->collEquipment = $collEquipment;
                $this->collEquipmentPartial = false;
            }
        }

        return $this->collEquipment;
    }

    /**
     * Sets a collection of Equipment objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_equipment cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $equipment A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function setEquipment(Collection $equipment, ConnectionInterface $con = null)
    {
        $this->clearEquipment();
        $currentEquipment = $this->getEquipment();

        $equipmentScheduledForDeletion = $currentEquipment->diff($equipment);

        foreach ($equipmentScheduledForDeletion as $toDelete) {
            $this->removeEquipment($toDelete);
        }

        foreach ($equipment as $equipment) {
            if (!$currentEquipment->contains($equipment)) {
                $this->doAddEquipment($equipment);
            }
        }

        $this->collEquipmentPartial = false;
        $this->collEquipment = $equipment;

        return $this;
    }

    /**
     * Gets the number of Equipment objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_equipment cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Equipment objects
     */
    public function countEquipment(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEquipmentPartial && !$this->isNew();
        if (null === $this->collEquipment || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEquipment) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getEquipment());
                }

                $query = ChildEquipmentQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySurgery($this)
                    ->count($con);
            }
        } else {
            return count($this->collEquipment);
        }
    }

    /**
     * Associate a ChildEquipment to this object
     * through the moc.surgery_equipment cross reference table.
     *
     * @param ChildEquipment $equipment
     * @return ChildSurgery The current object (for fluent API support)
     */
    public function addEquipment(ChildEquipment $equipment)
    {
        if ($this->collEquipment === null) {
            $this->initEquipment();
        }

        if (!$this->getEquipment()->contains($equipment)) {
            // only add it if the **same** object is not already associated
            $this->collEquipment->push($equipment);
            $this->doAddEquipment($equipment);
        }

        return $this;
    }

    /**
     *
     * @param ChildEquipment $equipment
     */
    protected function doAddEquipment(ChildEquipment $equipment)
    {
        $surgeryEquipment = new ChildSurgeryEquipment();

        $surgeryEquipment->setEquipment($equipment);

        $surgeryEquipment->setSurgery($this);

        $this->addSurgeryEquipment($surgeryEquipment);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$equipment->isSurgeriesLoaded()) {
            $equipment->initSurgeries();
            $equipment->getSurgeries()->push($this);
        } elseif (!$equipment->getSurgeries()->contains($this)) {
            $equipment->getSurgeries()->push($this);
        }

    }

    /**
     * Remove equipment of this object
     * through the moc.surgery_equipment cross reference table.
     *
     * @param ChildEquipment $equipment
     * @return ChildSurgery The current object (for fluent API support)
     */
    public function removeEquipment(ChildEquipment $equipment)
    {
        if ($this->getEquipment()->contains($equipment)) { $surgeryEquipment = new ChildSurgeryEquipment();

            $surgeryEquipment->setEquipment($equipment);
            if ($equipment->isSurgeriesLoaded()) {
                //remove the back reference if available
                $equipment->getSurgeries()->removeObject($this);
            }

            $surgeryEquipment->setSurgery($this);
            $this->removeSurgeryEquipment(clone $surgeryEquipment);
            $surgeryEquipment->clear();

            $this->collEquipment->remove($this->collEquipment->search($equipment));

            if (null === $this->equipmentScheduledForDeletion) {
                $this->equipmentScheduledForDeletion = clone $this->collEquipment;
                $this->equipmentScheduledForDeletion->clear();
            }

            $this->equipmentScheduledForDeletion->push($equipment);
        }


        return $this;
    }

    /**
     * Clears out the collMaterials collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMaterials()
     */
    public function clearMaterials()
    {
        $this->collMaterials = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collMaterials crossRef collection.
     *
     * By default this just sets the collMaterials collection to an empty collection (like clearMaterials());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initMaterials()
    {
        $this->collMaterials = new ObjectCollection();
        $this->collMaterialsPartial = true;

        $this->collMaterials->setModel('\MocApi\Models\Material');
    }

    /**
     * Checks if the collMaterials collection is loaded.
     *
     * @return bool
     */
    public function isMaterialsLoaded()
    {
        return null !== $this->collMaterials;
    }

    /**
     * Gets a collection of ChildMaterial objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_material cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgery is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildMaterial[] List of ChildMaterial objects
     */
    public function getMaterials(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMaterialsPartial && !$this->isNew();
        if (null === $this->collMaterials || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collMaterials) {
                    $this->initMaterials();
                }
            } else {

                $query = ChildMaterialQuery::create(null, $criteria)
                    ->filterBySurgery($this);
                $collMaterials = $query->find($con);
                if (null !== $criteria) {
                    return $collMaterials;
                }

                if ($partial && $this->collMaterials) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collMaterials as $obj) {
                        if (!$collMaterials->contains($obj)) {
                            $collMaterials[] = $obj;
                        }
                    }
                }

                $this->collMaterials = $collMaterials;
                $this->collMaterialsPartial = false;
            }
        }

        return $this->collMaterials;
    }

    /**
     * Sets a collection of Material objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_material cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $materials A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function setMaterials(Collection $materials, ConnectionInterface $con = null)
    {
        $this->clearMaterials();
        $currentMaterials = $this->getMaterials();

        $materialsScheduledForDeletion = $currentMaterials->diff($materials);

        foreach ($materialsScheduledForDeletion as $toDelete) {
            $this->removeMaterial($toDelete);
        }

        foreach ($materials as $material) {
            if (!$currentMaterials->contains($material)) {
                $this->doAddMaterial($material);
            }
        }

        $this->collMaterialsPartial = false;
        $this->collMaterials = $materials;

        return $this;
    }

    /**
     * Gets the number of Material objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_material cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Material objects
     */
    public function countMaterials(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMaterialsPartial && !$this->isNew();
        if (null === $this->collMaterials || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMaterials) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getMaterials());
                }

                $query = ChildMaterialQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySurgery($this)
                    ->count($con);
            }
        } else {
            return count($this->collMaterials);
        }
    }

    /**
     * Associate a ChildMaterial to this object
     * through the moc.surgery_material cross reference table.
     *
     * @param ChildMaterial $material
     * @return ChildSurgery The current object (for fluent API support)
     */
    public function addMaterial(ChildMaterial $material)
    {
        if ($this->collMaterials === null) {
            $this->initMaterials();
        }

        if (!$this->getMaterials()->contains($material)) {
            // only add it if the **same** object is not already associated
            $this->collMaterials->push($material);
            $this->doAddMaterial($material);
        }

        return $this;
    }

    /**
     *
     * @param ChildMaterial $material
     */
    protected function doAddMaterial(ChildMaterial $material)
    {
        $surgeryMaterial = new ChildSurgeryMaterial();

        $surgeryMaterial->setMaterial($material);

        $surgeryMaterial->setSurgery($this);

        $this->addSurgeryMaterial($surgeryMaterial);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$material->isSurgeriesLoaded()) {
            $material->initSurgeries();
            $material->getSurgeries()->push($this);
        } elseif (!$material->getSurgeries()->contains($this)) {
            $material->getSurgeries()->push($this);
        }

    }

    /**
     * Remove material of this object
     * through the moc.surgery_material cross reference table.
     *
     * @param ChildMaterial $material
     * @return ChildSurgery The current object (for fluent API support)
     */
    public function removeMaterial(ChildMaterial $material)
    {
        if ($this->getMaterials()->contains($material)) { $surgeryMaterial = new ChildSurgeryMaterial();

            $surgeryMaterial->setMaterial($material);
            if ($material->isSurgeriesLoaded()) {
                //remove the back reference if available
                $material->getSurgeries()->removeObject($this);
            }

            $surgeryMaterial->setSurgery($this);
            $this->removeSurgeryMaterial(clone $surgeryMaterial);
            $surgeryMaterial->clear();

            $this->collMaterials->remove($this->collMaterials->search($material));

            if (null === $this->materialsScheduledForDeletion) {
                $this->materialsScheduledForDeletion = clone $this->collMaterials;
                $this->materialsScheduledForDeletion->clear();
            }

            $this->materialsScheduledForDeletion->push($material);
        }


        return $this;
    }

    /**
     * Clears out the collTUsses collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTUsses()
     */
    public function clearTUsses()
    {
        $this->collTUsses = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collTUsses crossRef collection.
     *
     * By default this just sets the collTUsses collection to an empty collection (like clearTUsses());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initTUsses()
    {
        $this->collTUsses = new ObjectCollection();
        $this->collTUssesPartial = true;

        $this->collTUsses->setModel('\MocApi\Models\TUSS');
    }

    /**
     * Checks if the collTUsses collection is loaded.
     *
     * @return bool
     */
    public function isTUssesLoaded()
    {
        return null !== $this->collTUsses;
    }

    /**
     * Gets a collection of ChildTUSS objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_TUSS cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgery is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildTUSS[] List of ChildTUSS objects
     */
    public function getTUsses(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTUssesPartial && !$this->isNew();
        if (null === $this->collTUsses || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTUsses) {
                    $this->initTUsses();
                }
            } else {

                $query = ChildTUSSQuery::create(null, $criteria)
                    ->filterBySurgery($this);
                $collTUsses = $query->find($con);
                if (null !== $criteria) {
                    return $collTUsses;
                }

                if ($partial && $this->collTUsses) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collTUsses as $obj) {
                        if (!$collTUsses->contains($obj)) {
                            $collTUsses[] = $obj;
                        }
                    }
                }

                $this->collTUsses = $collTUsses;
                $this->collTUssesPartial = false;
            }
        }

        return $this->collTUsses;
    }

    /**
     * Sets a collection of TUSS objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_TUSS cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $tUsses A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgery The current object (for fluent API support)
     */
    public function setTUsses(Collection $tUsses, ConnectionInterface $con = null)
    {
        $this->clearTUsses();
        $currentTUsses = $this->getTUsses();

        $tUssesScheduledForDeletion = $currentTUsses->diff($tUsses);

        foreach ($tUssesScheduledForDeletion as $toDelete) {
            $this->removeTUSS($toDelete);
        }

        foreach ($tUsses as $tUSS) {
            if (!$currentTUsses->contains($tUSS)) {
                $this->doAddTUSS($tUSS);
            }
        }

        $this->collTUssesPartial = false;
        $this->collTUsses = $tUsses;

        return $this;
    }

    /**
     * Gets the number of TUSS objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_TUSS cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related TUSS objects
     */
    public function countTUsses(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTUssesPartial && !$this->isNew();
        if (null === $this->collTUsses || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTUsses) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getTUsses());
                }

                $query = ChildTUSSQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySurgery($this)
                    ->count($con);
            }
        } else {
            return count($this->collTUsses);
        }
    }

    /**
     * Associate a ChildTUSS to this object
     * through the moc.surgery_TUSS cross reference table.
     *
     * @param ChildTUSS $tUSS
     * @return ChildSurgery The current object (for fluent API support)
     */
    public function addTUSS(ChildTUSS $tUSS)
    {
        if ($this->collTUsses === null) {
            $this->initTUsses();
        }

        if (!$this->getTUsses()->contains($tUSS)) {
            // only add it if the **same** object is not already associated
            $this->collTUsses->push($tUSS);
            $this->doAddTUSS($tUSS);
        }

        return $this;
    }

    /**
     *
     * @param ChildTUSS $tUSS
     */
    protected function doAddTUSS(ChildTUSS $tUSS)
    {
        $surgeryTUSS = new ChildSurgeryTUSS();

        $surgeryTUSS->setTUSS($tUSS);

        $surgeryTUSS->setSurgery($this);

        $this->addSurgeryTUSS($surgeryTUSS);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$tUSS->isSurgeriesLoaded()) {
            $tUSS->initSurgeries();
            $tUSS->getSurgeries()->push($this);
        } elseif (!$tUSS->getSurgeries()->contains($this)) {
            $tUSS->getSurgeries()->push($this);
        }

    }

    /**
     * Remove tUSS of this object
     * through the moc.surgery_TUSS cross reference table.
     *
     * @param ChildTUSS $tUSS
     * @return ChildSurgery The current object (for fluent API support)
     */
    public function removeTUSS(ChildTUSS $tUSS)
    {
        if ($this->getTUsses()->contains($tUSS)) { $surgeryTUSS = new ChildSurgeryTUSS();

            $surgeryTUSS->setTUSS($tUSS);
            if ($tUSS->isSurgeriesLoaded()) {
                //remove the back reference if available
                $tUSS->getSurgeries()->removeObject($this);
            }

            $surgeryTUSS->setSurgery($this);
            $this->removeSurgeryTUSS(clone $surgeryTUSS);
            $surgeryTUSS->clear();

            $this->collTUsses->remove($this->collTUsses->search($tUSS));

            if (null === $this->tUssesScheduledForDeletion) {
                $this->tUssesScheduledForDeletion = clone $this->collTUsses;
                $this->tUssesScheduledForDeletion->clear();
            }

            $this->tUssesScheduledForDeletion->push($tUSS);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCreator) {
            $this->aCreator->removeSurgery($this);
        }
        if (null !== $this->aSurgeryType) {
            $this->aSurgeryType->removeSurgery($this);
        }
        $this->id = null;
        $this->status = null;
        $this->creator_id = null;
        $this->surgery_type_id = null;
        $this->created = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collPatients) {
                foreach ($this->collPatients as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSurgeonSurgeries) {
                foreach ($this->collSurgeonSurgeries as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSurgeryEquipments) {
                foreach ($this->collSurgeryEquipments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSurgeryFieldValues) {
                foreach ($this->collSurgeryFieldValues as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSurgeryMaterials) {
                foreach ($this->collSurgeryMaterials as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSurgeryTUsses) {
                foreach ($this->collSurgeryTUsses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSurgeons) {
                foreach ($this->collSurgeons as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEquipment) {
                foreach ($this->collEquipment as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMaterials) {
                foreach ($this->collMaterials as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTUsses) {
                foreach ($this->collTUsses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPatients = null;
        $this->collSurgeonSurgeries = null;
        $this->collSurgeryEquipments = null;
        $this->collSurgeryFieldValues = null;
        $this->collSurgeryMaterials = null;
        $this->collSurgeryTUsses = null;
        $this->collSurgeons = null;
        $this->collEquipment = null;
        $this->collMaterials = null;
        $this->collTUsses = null;
        $this->aCreator = null;
        $this->aSurgeryType = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SurgeryTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
