<?php

namespace MocApi\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use MocApi\Models\Material as ChildMaterial;
use MocApi\Models\MaterialQuery as ChildMaterialQuery;
use MocApi\Models\MaterialSupplier as ChildMaterialSupplier;
use MocApi\Models\MaterialSupplierQuery as ChildMaterialSupplierQuery;
use MocApi\Models\Supplier as ChildSupplier;
use MocApi\Models\SupplierQuery as ChildSupplierQuery;
use MocApi\Models\Surgery as ChildSurgery;
use MocApi\Models\SurgeryMaterial as ChildSurgeryMaterial;
use MocApi\Models\SurgeryMaterialQuery as ChildSurgeryMaterialQuery;
use MocApi\Models\SurgeryQuery as ChildSurgeryQuery;
use MocApi\Models\Map\MaterialTableMap;
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
 * Base class that represents a row from the 'moc.material' table.
 *
 *
 *
* @package    propel.generator.MocApi.Models.Base
*/
abstract class Material implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MocApi\\Models\\Map\\MaterialTableMap';


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
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * The value for the quantity field.
     *
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $quantity;

    /**
     * The value for the created field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        \DateTime
     */
    protected $created;

    /**
     * @var        ObjectCollection|ChildSurgeryMaterial[] Collection to store aggregation of ChildSurgeryMaterial objects.
     */
    protected $collSurgeryMaterials;
    protected $collSurgeryMaterialsPartial;

    /**
     * @var        ObjectCollection|ChildMaterialSupplier[] Collection to store aggregation of ChildMaterialSupplier objects.
     */
    protected $collMaterialSuppliers;
    protected $collMaterialSuppliersPartial;

    /**
     * @var        ObjectCollection|ChildSurgery[] Cross Collection to store aggregation of ChildSurgery objects.
     */
    protected $collSurgeries;

    /**
     * @var bool
     */
    protected $collSurgeriesPartial;

    /**
     * @var        ObjectCollection|ChildSupplier[] Cross Collection to store aggregation of ChildSupplier objects.
     */
    protected $collSuppliers;

    /**
     * @var bool
     */
    protected $collSuppliersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSurgery[]
     */
    protected $surgeriesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSupplier[]
     */
    protected $suppliersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSurgeryMaterial[]
     */
    protected $surgeryMaterialsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMaterialSupplier[]
     */
    protected $materialSuppliersScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->quantity = 1;
    }

    /**
     * Initializes internal state of MocApi\Models\Base\Material object.
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
     * Compares this with another <code>Material</code> instance.  If
     * <code>obj</code> is an instance of <code>Material</code>, delegates to
     * <code>equals(Material)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Material The current object, for fluid interface
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [quantity] column value.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
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
     * @return $this|\MocApi\Models\Material The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[MaterialTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Material The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[MaterialTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Material The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[MaterialTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [quantity] column.
     *
     * @param int $v new value
     * @return $this|\MocApi\Models\Material The current object (for fluent API support)
     */
    public function setQuantity($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->quantity !== $v) {
            $this->quantity = $v;
            $this->modifiedColumns[MaterialTableMap::COL_QUANTITY] = true;
        }

        return $this;
    } // setQuantity()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\MocApi\Models\Material The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($this->created === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created->format("Y-m-d H:i:s")) {
                $this->created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[MaterialTableMap::COL_CREATED] = true;
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
            if ($this->quantity !== 1) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MaterialTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MaterialTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : MaterialTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : MaterialTableMap::translateFieldName('Quantity', TableMap::TYPE_PHPNAME, $indexType)];
            $this->quantity = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : MaterialTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = MaterialTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MocApi\\Models\\Material'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(MaterialTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMaterialQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSurgeryMaterials = null;

            $this->collMaterialSuppliers = null;

            $this->collSurgeries = null;
            $this->collSuppliers = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Material::setDeleted()
     * @see Material::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MaterialTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildMaterialQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(MaterialTableMap::DATABASE_NAME);
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
                MaterialTableMap::addInstanceToPool($this);
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

            if ($this->surgeriesScheduledForDeletion !== null) {
                if (!$this->surgeriesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->surgeriesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \MocApi\Models\SurgeryMaterialQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->surgeriesScheduledForDeletion = null;
                }

            }

            if ($this->collSurgeries) {
                foreach ($this->collSurgeries as $surgery) {
                    if (!$surgery->isDeleted() && ($surgery->isNew() || $surgery->isModified())) {
                        $surgery->save($con);
                    }
                }
            }


            if ($this->suppliersScheduledForDeletion !== null) {
                if (!$this->suppliersScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->suppliersScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \MocApi\Models\MaterialSupplierQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->suppliersScheduledForDeletion = null;
                }

            }

            if ($this->collSuppliers) {
                foreach ($this->collSuppliers as $supplier) {
                    if (!$supplier->isDeleted() && ($supplier->isNew() || $supplier->isModified())) {
                        $supplier->save($con);
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

            if ($this->materialSuppliersScheduledForDeletion !== null) {
                if (!$this->materialSuppliersScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\MaterialSupplierQuery::create()
                        ->filterByPrimaryKeys($this->materialSuppliersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->materialSuppliersScheduledForDeletion = null;
                }
            }

            if ($this->collMaterialSuppliers !== null) {
                foreach ($this->collMaterialSuppliers as $referrerFK) {
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

        $this->modifiedColumns[MaterialTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MaterialTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('moc.material_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MaterialTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(MaterialTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(MaterialTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(MaterialTableMap::COL_QUANTITY)) {
            $modifiedColumns[':p' . $index++]  = 'quantity';
        }
        if ($this->isColumnModified(MaterialTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }

        $sql = sprintf(
            'INSERT INTO moc.material (%s) VALUES (%s)',
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
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'quantity':
                        $stmt->bindValue($identifier, $this->quantity, PDO::PARAM_INT);
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
        $pos = MaterialTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getDescription();
                break;
            case 3:
                return $this->getQuantity();
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

        if (isset($alreadyDumpedObjects['Material'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Material'][$this->hashCode()] = true;
        $keys = MaterialTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDescription(),
            $keys[3] => $this->getQuantity(),
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
            if (null !== $this->collMaterialSuppliers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'materialSuppliers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.material_suppliers';
                        break;
                    default:
                        $key = 'MaterialSuppliers';
                }

                $result[$key] = $this->collMaterialSuppliers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\MocApi\Models\Material
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MaterialTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MocApi\Models\Material
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setDescription($value);
                break;
            case 3:
                $this->setQuantity($value);
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
        $keys = MaterialTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDescription($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setQuantity($arr[$keys[3]]);
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
     * @return $this|\MocApi\Models\Material The current object, for fluid interface
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
        $criteria = new Criteria(MaterialTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MaterialTableMap::COL_ID)) {
            $criteria->add(MaterialTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(MaterialTableMap::COL_NAME)) {
            $criteria->add(MaterialTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(MaterialTableMap::COL_DESCRIPTION)) {
            $criteria->add(MaterialTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(MaterialTableMap::COL_QUANTITY)) {
            $criteria->add(MaterialTableMap::COL_QUANTITY, $this->quantity);
        }
        if ($this->isColumnModified(MaterialTableMap::COL_CREATED)) {
            $criteria->add(MaterialTableMap::COL_CREATED, $this->created);
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
        $criteria = ChildMaterialQuery::create();
        $criteria->add(MaterialTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \MocApi\Models\Material (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setQuantity($this->getQuantity());
        $copyObj->setCreated($this->getCreated());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSurgeryMaterials() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSurgeryMaterial($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMaterialSuppliers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMaterialSupplier($relObj->copy($deepCopy));
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
     * @return \MocApi\Models\Material Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('SurgeryMaterial' == $relationName) {
            return $this->initSurgeryMaterials();
        }
        if ('MaterialSupplier' == $relationName) {
            return $this->initMaterialSuppliers();
        }
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
     * If this ChildMaterial is new, it will return
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
                    ->filterByMaterial($this)
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
     * @return $this|ChildMaterial The current object (for fluent API support)
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
            $surgeryMaterialRemoved->setMaterial(null);
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
                ->filterByMaterial($this)
                ->count($con);
        }

        return count($this->collSurgeryMaterials);
    }

    /**
     * Method called to associate a ChildSurgeryMaterial object to this object
     * through the ChildSurgeryMaterial foreign key attribute.
     *
     * @param  ChildSurgeryMaterial $l ChildSurgeryMaterial
     * @return $this|\MocApi\Models\Material The current object (for fluent API support)
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
        $surgeryMaterial->setMaterial($this);
    }

    /**
     * @param  ChildSurgeryMaterial $surgeryMaterial The ChildSurgeryMaterial object to remove.
     * @return $this|ChildMaterial The current object (for fluent API support)
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
            $surgeryMaterial->setMaterial(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Material is new, it will return
     * an empty collection; or if this Material has previously
     * been saved, it will retrieve related SurgeryMaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Material.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSurgeryMaterial[] List of ChildSurgeryMaterial objects
     */
    public function getSurgeryMaterialsJoinSurgery(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSurgeryMaterialQuery::create(null, $criteria);
        $query->joinWith('Surgery', $joinBehavior);

        return $this->getSurgeryMaterials($query, $con);
    }

    /**
     * Clears out the collMaterialSuppliers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMaterialSuppliers()
     */
    public function clearMaterialSuppliers()
    {
        $this->collMaterialSuppliers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMaterialSuppliers collection loaded partially.
     */
    public function resetPartialMaterialSuppliers($v = true)
    {
        $this->collMaterialSuppliersPartial = $v;
    }

    /**
     * Initializes the collMaterialSuppliers collection.
     *
     * By default this just sets the collMaterialSuppliers collection to an empty array (like clearcollMaterialSuppliers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMaterialSuppliers($overrideExisting = true)
    {
        if (null !== $this->collMaterialSuppliers && !$overrideExisting) {
            return;
        }
        $this->collMaterialSuppliers = new ObjectCollection();
        $this->collMaterialSuppliers->setModel('\MocApi\Models\MaterialSupplier');
    }

    /**
     * Gets an array of ChildMaterialSupplier objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMaterial is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMaterialSupplier[] List of ChildMaterialSupplier objects
     * @throws PropelException
     */
    public function getMaterialSuppliers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMaterialSuppliersPartial && !$this->isNew();
        if (null === $this->collMaterialSuppliers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMaterialSuppliers) {
                // return empty collection
                $this->initMaterialSuppliers();
            } else {
                $collMaterialSuppliers = ChildMaterialSupplierQuery::create(null, $criteria)
                    ->filterByMaterial($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMaterialSuppliersPartial && count($collMaterialSuppliers)) {
                        $this->initMaterialSuppliers(false);

                        foreach ($collMaterialSuppliers as $obj) {
                            if (false == $this->collMaterialSuppliers->contains($obj)) {
                                $this->collMaterialSuppliers->append($obj);
                            }
                        }

                        $this->collMaterialSuppliersPartial = true;
                    }

                    return $collMaterialSuppliers;
                }

                if ($partial && $this->collMaterialSuppliers) {
                    foreach ($this->collMaterialSuppliers as $obj) {
                        if ($obj->isNew()) {
                            $collMaterialSuppliers[] = $obj;
                        }
                    }
                }

                $this->collMaterialSuppliers = $collMaterialSuppliers;
                $this->collMaterialSuppliersPartial = false;
            }
        }

        return $this->collMaterialSuppliers;
    }

    /**
     * Sets a collection of ChildMaterialSupplier objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $materialSuppliers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMaterial The current object (for fluent API support)
     */
    public function setMaterialSuppliers(Collection $materialSuppliers, ConnectionInterface $con = null)
    {
        /** @var ChildMaterialSupplier[] $materialSuppliersToDelete */
        $materialSuppliersToDelete = $this->getMaterialSuppliers(new Criteria(), $con)->diff($materialSuppliers);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->materialSuppliersScheduledForDeletion = clone $materialSuppliersToDelete;

        foreach ($materialSuppliersToDelete as $materialSupplierRemoved) {
            $materialSupplierRemoved->setMaterial(null);
        }

        $this->collMaterialSuppliers = null;
        foreach ($materialSuppliers as $materialSupplier) {
            $this->addMaterialSupplier($materialSupplier);
        }

        $this->collMaterialSuppliers = $materialSuppliers;
        $this->collMaterialSuppliersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MaterialSupplier objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related MaterialSupplier objects.
     * @throws PropelException
     */
    public function countMaterialSuppliers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMaterialSuppliersPartial && !$this->isNew();
        if (null === $this->collMaterialSuppliers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMaterialSuppliers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMaterialSuppliers());
            }

            $query = ChildMaterialSupplierQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMaterial($this)
                ->count($con);
        }

        return count($this->collMaterialSuppliers);
    }

    /**
     * Method called to associate a ChildMaterialSupplier object to this object
     * through the ChildMaterialSupplier foreign key attribute.
     *
     * @param  ChildMaterialSupplier $l ChildMaterialSupplier
     * @return $this|\MocApi\Models\Material The current object (for fluent API support)
     */
    public function addMaterialSupplier(ChildMaterialSupplier $l)
    {
        if ($this->collMaterialSuppliers === null) {
            $this->initMaterialSuppliers();
            $this->collMaterialSuppliersPartial = true;
        }

        if (!$this->collMaterialSuppliers->contains($l)) {
            $this->doAddMaterialSupplier($l);
        }

        return $this;
    }

    /**
     * @param ChildMaterialSupplier $materialSupplier The ChildMaterialSupplier object to add.
     */
    protected function doAddMaterialSupplier(ChildMaterialSupplier $materialSupplier)
    {
        $this->collMaterialSuppliers[]= $materialSupplier;
        $materialSupplier->setMaterial($this);
    }

    /**
     * @param  ChildMaterialSupplier $materialSupplier The ChildMaterialSupplier object to remove.
     * @return $this|ChildMaterial The current object (for fluent API support)
     */
    public function removeMaterialSupplier(ChildMaterialSupplier $materialSupplier)
    {
        if ($this->getMaterialSuppliers()->contains($materialSupplier)) {
            $pos = $this->collMaterialSuppliers->search($materialSupplier);
            $this->collMaterialSuppliers->remove($pos);
            if (null === $this->materialSuppliersScheduledForDeletion) {
                $this->materialSuppliersScheduledForDeletion = clone $this->collMaterialSuppliers;
                $this->materialSuppliersScheduledForDeletion->clear();
            }
            $this->materialSuppliersScheduledForDeletion[]= clone $materialSupplier;
            $materialSupplier->setMaterial(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Material is new, it will return
     * an empty collection; or if this Material has previously
     * been saved, it will retrieve related MaterialSuppliers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Material.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMaterialSupplier[] List of ChildMaterialSupplier objects
     */
    public function getMaterialSuppliersJoinSupplier(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMaterialSupplierQuery::create(null, $criteria);
        $query->joinWith('Supplier', $joinBehavior);

        return $this->getMaterialSuppliers($query, $con);
    }

    /**
     * Clears out the collSurgeries collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSurgeries()
     */
    public function clearSurgeries()
    {
        $this->collSurgeries = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collSurgeries crossRef collection.
     *
     * By default this just sets the collSurgeries collection to an empty collection (like clearSurgeries());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initSurgeries()
    {
        $this->collSurgeries = new ObjectCollection();
        $this->collSurgeriesPartial = true;

        $this->collSurgeries->setModel('\MocApi\Models\Surgery');
    }

    /**
     * Checks if the collSurgeries collection is loaded.
     *
     * @return bool
     */
    public function isSurgeriesLoaded()
    {
        return null !== $this->collSurgeries;
    }

    /**
     * Gets a collection of ChildSurgery objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_material cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMaterial is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildSurgery[] List of ChildSurgery objects
     */
    public function getSurgeries(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeriesPartial && !$this->isNew();
        if (null === $this->collSurgeries || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collSurgeries) {
                    $this->initSurgeries();
                }
            } else {

                $query = ChildSurgeryQuery::create(null, $criteria)
                    ->filterByMaterial($this);
                $collSurgeries = $query->find($con);
                if (null !== $criteria) {
                    return $collSurgeries;
                }

                if ($partial && $this->collSurgeries) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collSurgeries as $obj) {
                        if (!$collSurgeries->contains($obj)) {
                            $collSurgeries[] = $obj;
                        }
                    }
                }

                $this->collSurgeries = $collSurgeries;
                $this->collSurgeriesPartial = false;
            }
        }

        return $this->collSurgeries;
    }

    /**
     * Sets a collection of Surgery objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_material cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $surgeries A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildMaterial The current object (for fluent API support)
     */
    public function setSurgeries(Collection $surgeries, ConnectionInterface $con = null)
    {
        $this->clearSurgeries();
        $currentSurgeries = $this->getSurgeries();

        $surgeriesScheduledForDeletion = $currentSurgeries->diff($surgeries);

        foreach ($surgeriesScheduledForDeletion as $toDelete) {
            $this->removeSurgery($toDelete);
        }

        foreach ($surgeries as $surgery) {
            if (!$currentSurgeries->contains($surgery)) {
                $this->doAddSurgery($surgery);
            }
        }

        $this->collSurgeriesPartial = false;
        $this->collSurgeries = $surgeries;

        return $this;
    }

    /**
     * Gets the number of Surgery objects related by a many-to-many relationship
     * to the current object by way of the moc.surgery_material cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Surgery objects
     */
    public function countSurgeries(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeriesPartial && !$this->isNew();
        if (null === $this->collSurgeries || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSurgeries) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getSurgeries());
                }

                $query = ChildSurgeryQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByMaterial($this)
                    ->count($con);
            }
        } else {
            return count($this->collSurgeries);
        }
    }

    /**
     * Associate a ChildSurgery to this object
     * through the moc.surgery_material cross reference table.
     *
     * @param ChildSurgery $surgery
     * @return ChildMaterial The current object (for fluent API support)
     */
    public function addSurgery(ChildSurgery $surgery)
    {
        if ($this->collSurgeries === null) {
            $this->initSurgeries();
        }

        if (!$this->getSurgeries()->contains($surgery)) {
            // only add it if the **same** object is not already associated
            $this->collSurgeries->push($surgery);
            $this->doAddSurgery($surgery);
        }

        return $this;
    }

    /**
     *
     * @param ChildSurgery $surgery
     */
    protected function doAddSurgery(ChildSurgery $surgery)
    {
        $surgeryMaterial = new ChildSurgeryMaterial();

        $surgeryMaterial->setSurgery($surgery);

        $surgeryMaterial->setMaterial($this);

        $this->addSurgeryMaterial($surgeryMaterial);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$surgery->isMaterialsLoaded()) {
            $surgery->initMaterials();
            $surgery->getMaterials()->push($this);
        } elseif (!$surgery->getMaterials()->contains($this)) {
            $surgery->getMaterials()->push($this);
        }

    }

    /**
     * Remove surgery of this object
     * through the moc.surgery_material cross reference table.
     *
     * @param ChildSurgery $surgery
     * @return ChildMaterial The current object (for fluent API support)
     */
    public function removeSurgery(ChildSurgery $surgery)
    {
        if ($this->getSurgeries()->contains($surgery)) { $surgeryMaterial = new ChildSurgeryMaterial();

            $surgeryMaterial->setSurgery($surgery);
            if ($surgery->isMaterialsLoaded()) {
                //remove the back reference if available
                $surgery->getMaterials()->removeObject($this);
            }

            $surgeryMaterial->setMaterial($this);
            $this->removeSurgeryMaterial(clone $surgeryMaterial);
            $surgeryMaterial->clear();

            $this->collSurgeries->remove($this->collSurgeries->search($surgery));

            if (null === $this->surgeriesScheduledForDeletion) {
                $this->surgeriesScheduledForDeletion = clone $this->collSurgeries;
                $this->surgeriesScheduledForDeletion->clear();
            }

            $this->surgeriesScheduledForDeletion->push($surgery);
        }


        return $this;
    }

    /**
     * Clears out the collSuppliers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSuppliers()
     */
    public function clearSuppliers()
    {
        $this->collSuppliers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collSuppliers crossRef collection.
     *
     * By default this just sets the collSuppliers collection to an empty collection (like clearSuppliers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initSuppliers()
    {
        $this->collSuppliers = new ObjectCollection();
        $this->collSuppliersPartial = true;

        $this->collSuppliers->setModel('\MocApi\Models\Supplier');
    }

    /**
     * Checks if the collSuppliers collection is loaded.
     *
     * @return bool
     */
    public function isSuppliersLoaded()
    {
        return null !== $this->collSuppliers;
    }

    /**
     * Gets a collection of ChildSupplier objects related by a many-to-many relationship
     * to the current object by way of the moc.material_supplier cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMaterial is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildSupplier[] List of ChildSupplier objects
     */
    public function getSuppliers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSuppliersPartial && !$this->isNew();
        if (null === $this->collSuppliers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collSuppliers) {
                    $this->initSuppliers();
                }
            } else {

                $query = ChildSupplierQuery::create(null, $criteria)
                    ->filterByMaterial($this);
                $collSuppliers = $query->find($con);
                if (null !== $criteria) {
                    return $collSuppliers;
                }

                if ($partial && $this->collSuppliers) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collSuppliers as $obj) {
                        if (!$collSuppliers->contains($obj)) {
                            $collSuppliers[] = $obj;
                        }
                    }
                }

                $this->collSuppliers = $collSuppliers;
                $this->collSuppliersPartial = false;
            }
        }

        return $this->collSuppliers;
    }

    /**
     * Sets a collection of Supplier objects related by a many-to-many relationship
     * to the current object by way of the moc.material_supplier cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $suppliers A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildMaterial The current object (for fluent API support)
     */
    public function setSuppliers(Collection $suppliers, ConnectionInterface $con = null)
    {
        $this->clearSuppliers();
        $currentSuppliers = $this->getSuppliers();

        $suppliersScheduledForDeletion = $currentSuppliers->diff($suppliers);

        foreach ($suppliersScheduledForDeletion as $toDelete) {
            $this->removeSupplier($toDelete);
        }

        foreach ($suppliers as $supplier) {
            if (!$currentSuppliers->contains($supplier)) {
                $this->doAddSupplier($supplier);
            }
        }

        $this->collSuppliersPartial = false;
        $this->collSuppliers = $suppliers;

        return $this;
    }

    /**
     * Gets the number of Supplier objects related by a many-to-many relationship
     * to the current object by way of the moc.material_supplier cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Supplier objects
     */
    public function countSuppliers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSuppliersPartial && !$this->isNew();
        if (null === $this->collSuppliers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSuppliers) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getSuppliers());
                }

                $query = ChildSupplierQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByMaterial($this)
                    ->count($con);
            }
        } else {
            return count($this->collSuppliers);
        }
    }

    /**
     * Associate a ChildSupplier to this object
     * through the moc.material_supplier cross reference table.
     *
     * @param ChildSupplier $supplier
     * @return ChildMaterial The current object (for fluent API support)
     */
    public function addSupplier(ChildSupplier $supplier)
    {
        if ($this->collSuppliers === null) {
            $this->initSuppliers();
        }

        if (!$this->getSuppliers()->contains($supplier)) {
            // only add it if the **same** object is not already associated
            $this->collSuppliers->push($supplier);
            $this->doAddSupplier($supplier);
        }

        return $this;
    }

    /**
     *
     * @param ChildSupplier $supplier
     */
    protected function doAddSupplier(ChildSupplier $supplier)
    {
        $materialSupplier = new ChildMaterialSupplier();

        $materialSupplier->setSupplier($supplier);

        $materialSupplier->setMaterial($this);

        $this->addMaterialSupplier($materialSupplier);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$supplier->isMaterialsLoaded()) {
            $supplier->initMaterials();
            $supplier->getMaterials()->push($this);
        } elseif (!$supplier->getMaterials()->contains($this)) {
            $supplier->getMaterials()->push($this);
        }

    }

    /**
     * Remove supplier of this object
     * through the moc.material_supplier cross reference table.
     *
     * @param ChildSupplier $supplier
     * @return ChildMaterial The current object (for fluent API support)
     */
    public function removeSupplier(ChildSupplier $supplier)
    {
        if ($this->getSuppliers()->contains($supplier)) { $materialSupplier = new ChildMaterialSupplier();

            $materialSupplier->setSupplier($supplier);
            if ($supplier->isMaterialsLoaded()) {
                //remove the back reference if available
                $supplier->getMaterials()->removeObject($this);
            }

            $materialSupplier->setMaterial($this);
            $this->removeMaterialSupplier(clone $materialSupplier);
            $materialSupplier->clear();

            $this->collSuppliers->remove($this->collSuppliers->search($supplier));

            if (null === $this->suppliersScheduledForDeletion) {
                $this->suppliersScheduledForDeletion = clone $this->collSuppliers;
                $this->suppliersScheduledForDeletion->clear();
            }

            $this->suppliersScheduledForDeletion->push($supplier);
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
        $this->id = null;
        $this->name = null;
        $this->description = null;
        $this->quantity = null;
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
            if ($this->collSurgeryMaterials) {
                foreach ($this->collSurgeryMaterials as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMaterialSuppliers) {
                foreach ($this->collMaterialSuppliers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSurgeries) {
                foreach ($this->collSurgeries as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSuppliers) {
                foreach ($this->collSuppliers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSurgeryMaterials = null;
        $this->collMaterialSuppliers = null;
        $this->collSurgeries = null;
        $this->collSuppliers = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MaterialTableMap::DEFAULT_STRING_FORMAT);
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
