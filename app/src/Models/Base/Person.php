<?php

namespace MocApi\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use MocApi\Models\LegalGuardian as ChildLegalGuardian;
use MocApi\Models\LegalGuardianQuery as ChildLegalGuardianQuery;
use MocApi\Models\MedicalStaff as ChildMedicalStaff;
use MocApi\Models\MedicalStaffQuery as ChildMedicalStaffQuery;
use MocApi\Models\Patient as ChildPatient;
use MocApi\Models\PatientQuery as ChildPatientQuery;
use MocApi\Models\Person as ChildPerson;
use MocApi\Models\PersonQuery as ChildPersonQuery;
use MocApi\Models\PhoneNumber as ChildPhoneNumber;
use MocApi\Models\PhoneNumberQuery as ChildPhoneNumberQuery;
use MocApi\Models\Surgeon as ChildSurgeon;
use MocApi\Models\SurgeonQuery as ChildSurgeonQuery;
use MocApi\Models\Surgery as ChildSurgery;
use MocApi\Models\SurgeryQuery as ChildSurgeryQuery;
use MocApi\Models\User as ChildUser;
use MocApi\Models\UserQuery as ChildUserQuery;
use MocApi\Models\Map\PersonTableMap;
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
 * Base class that represents a row from the 'moc.person' table.
 *
 *
 *
* @package    propel.generator.MocApi.Models.Base
*/
abstract class Person implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MocApi\\Models\\Map\\PersonTableMap';


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
     * The value for the cpf field.
     *
     * @var        string
     */
    protected $cpf;

    /**
     * The value for the rg field.
     *
     * @var        string
     */
    protected $rg;

    /**
     * The value for the birth_date field.
     *
     * @var        \DateTime
     */
    protected $birth_date;

    /**
     * The value for the gender field.
     *
     * @var        int
     */
    protected $gender;

    /**
     * The value for the created field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        \DateTime
     */
    protected $created;

    /**
     * @var        ChildUser one-to-one related ChildUser object
     */
    protected $singleUser;

    /**
     * @var        ChildPatient one-to-one related ChildPatient object
     */
    protected $singlePatient;

    /**
     * @var        ObjectCollection|ChildPhoneNumber[] Collection to store aggregation of ChildPhoneNumber objects.
     */
    protected $collPhoneNumbers;
    protected $collPhoneNumbersPartial;

    /**
     * @var        ChildSurgeon one-to-one related ChildSurgeon object
     */
    protected $singleSurgeon;

    /**
     * @var        ObjectCollection|ChildSurgery[] Collection to store aggregation of ChildSurgery objects.
     */
    protected $collSurgeries;
    protected $collSurgeriesPartial;

    /**
     * @var        ChildLegalGuardian one-to-one related ChildLegalGuardian object
     */
    protected $singleLegalGuardian;

    /**
     * @var        ChildMedicalStaff one-to-one related ChildMedicalStaff object
     */
    protected $singleMedicalStaff;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPhoneNumber[]
     */
    protected $phoneNumbersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSurgery[]
     */
    protected $surgeriesScheduledForDeletion = null;

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
     * Initializes internal state of MocApi\Models\Base\Person object.
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
     * Compares this with another <code>Person</code> instance.  If
     * <code>obj</code> is an instance of <code>Person</code>, delegates to
     * <code>equals(Person)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Person The current object, for fluid interface
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
     * Get the [cpf] column value.
     *
     * @return string
     */
    public function getCPF()
    {
        return $this->cpf;
    }

    /**
     * Get the [rg] column value.
     *
     * @return string
     */
    public function getRG()
    {
        return $this->rg;
    }

    /**
     * Get the [optionally formatted] temporal [birth_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getBirthDate($format = NULL)
    {
        if ($format === null) {
            return $this->birth_date;
        } else {
            return $this->birth_date instanceof \DateTime ? $this->birth_date->format($format) : null;
        }
    }

    /**
     * Get the [gender] column value.
     *
     * @return string
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getGender()
    {
        if (null === $this->gender) {
            return null;
        }
        $valueSet = PersonTableMap::getValueSet(PersonTableMap::COL_GENDER);
        if (!isset($valueSet[$this->gender])) {
            throw new PropelException('Unknown stored enum key: ' . $this->gender);
        }

        return $valueSet[$this->gender];
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
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PersonTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[PersonTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [cpf] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     */
    public function setCPF($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cpf !== $v) {
            $this->cpf = $v;
            $this->modifiedColumns[PersonTableMap::COL_CPF] = true;
        }

        return $this;
    } // setCPF()

    /**
     * Set the value of [rg] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     */
    public function setRG($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rg !== $v) {
            $this->rg = $v;
            $this->modifiedColumns[PersonTableMap::COL_RG] = true;
        }

        return $this;
    } // setRG()

    /**
     * Sets the value of [birth_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     */
    public function setBirthDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->birth_date !== null || $dt !== null) {
            if ($this->birth_date === null || $dt === null || $dt->format("Y-m-d") !== $this->birth_date->format("Y-m-d")) {
                $this->birth_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PersonTableMap::COL_BIRTH_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setBirthDate()

    /**
     * Set the value of [gender] column.
     *
     * @param  string $v new value
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setGender($v)
    {
        if ($v !== null) {
            $valueSet = PersonTableMap::getValueSet(PersonTableMap::COL_GENDER);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->gender !== $v) {
            $this->gender = $v;
            $this->modifiedColumns[PersonTableMap::COL_GENDER] = true;
        }

        return $this;
    } // setGender()

    /**
     * Sets the value of [created] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     */
    public function setCreated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created !== null || $dt !== null) {
            if ($this->created === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created->format("Y-m-d H:i:s")) {
                $this->created = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PersonTableMap::COL_CREATED] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PersonTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PersonTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PersonTableMap::translateFieldName('CPF', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cpf = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PersonTableMap::translateFieldName('RG', TableMap::TYPE_PHPNAME, $indexType)];
            $this->rg = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PersonTableMap::translateFieldName('BirthDate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->birth_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PersonTableMap::translateFieldName('Gender', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gender = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PersonTableMap::translateFieldName('Created', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = PersonTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MocApi\\Models\\Person'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PersonTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPersonQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->singleUser = null;

            $this->singlePatient = null;

            $this->collPhoneNumbers = null;

            $this->singleSurgeon = null;

            $this->collSurgeries = null;

            $this->singleLegalGuardian = null;

            $this->singleMedicalStaff = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Person::setDeleted()
     * @see Person::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPersonQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
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
                PersonTableMap::addInstanceToPool($this);
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

            if ($this->singleUser !== null) {
                if (!$this->singleUser->isDeleted() && ($this->singleUser->isNew() || $this->singleUser->isModified())) {
                    $affectedRows += $this->singleUser->save($con);
                }
            }

            if ($this->singlePatient !== null) {
                if (!$this->singlePatient->isDeleted() && ($this->singlePatient->isNew() || $this->singlePatient->isModified())) {
                    $affectedRows += $this->singlePatient->save($con);
                }
            }

            if ($this->phoneNumbersScheduledForDeletion !== null) {
                if (!$this->phoneNumbersScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\PhoneNumberQuery::create()
                        ->filterByPrimaryKeys($this->phoneNumbersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->phoneNumbersScheduledForDeletion = null;
                }
            }

            if ($this->collPhoneNumbers !== null) {
                foreach ($this->collPhoneNumbers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->singleSurgeon !== null) {
                if (!$this->singleSurgeon->isDeleted() && ($this->singleSurgeon->isNew() || $this->singleSurgeon->isModified())) {
                    $affectedRows += $this->singleSurgeon->save($con);
                }
            }

            if ($this->surgeriesScheduledForDeletion !== null) {
                if (!$this->surgeriesScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\SurgeryQuery::create()
                        ->filterByPrimaryKeys($this->surgeriesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->surgeriesScheduledForDeletion = null;
                }
            }

            if ($this->collSurgeries !== null) {
                foreach ($this->collSurgeries as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->singleLegalGuardian !== null) {
                if (!$this->singleLegalGuardian->isDeleted() && ($this->singleLegalGuardian->isNew() || $this->singleLegalGuardian->isModified())) {
                    $affectedRows += $this->singleLegalGuardian->save($con);
                }
            }

            if ($this->singleMedicalStaff !== null) {
                if (!$this->singleMedicalStaff->isDeleted() && ($this->singleMedicalStaff->isNew() || $this->singleMedicalStaff->isModified())) {
                    $affectedRows += $this->singleMedicalStaff->save($con);
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

        $this->modifiedColumns[PersonTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PersonTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('moc.person_id_seq')");
                $this->id = $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PersonTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PersonTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(PersonTableMap::COL_CPF)) {
            $modifiedColumns[':p' . $index++]  = 'CPF';
        }
        if ($this->isColumnModified(PersonTableMap::COL_RG)) {
            $modifiedColumns[':p' . $index++]  = 'RG';
        }
        if ($this->isColumnModified(PersonTableMap::COL_BIRTH_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'birth_date';
        }
        if ($this->isColumnModified(PersonTableMap::COL_GENDER)) {
            $modifiedColumns[':p' . $index++]  = 'gender';
        }
        if ($this->isColumnModified(PersonTableMap::COL_CREATED)) {
            $modifiedColumns[':p' . $index++]  = 'created';
        }

        $sql = sprintf(
            'INSERT INTO moc.person (%s) VALUES (%s)',
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
                    case 'CPF':
                        $stmt->bindValue($identifier, $this->cpf, PDO::PARAM_STR);
                        break;
                    case 'RG':
                        $stmt->bindValue($identifier, $this->rg, PDO::PARAM_STR);
                        break;
                    case 'birth_date':
                        $stmt->bindValue($identifier, $this->birth_date ? $this->birth_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'gender':
                        $stmt->bindValue($identifier, $this->gender, PDO::PARAM_INT);
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
        $pos = PersonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCPF();
                break;
            case 3:
                return $this->getRG();
                break;
            case 4:
                return $this->getBirthDate();
                break;
            case 5:
                return $this->getGender();
                break;
            case 6:
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

        if (isset($alreadyDumpedObjects['Person'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Person'][$this->hashCode()] = true;
        $keys = PersonTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getCPF(),
            $keys[3] => $this->getRG(),
            $keys[4] => $this->getBirthDate(),
            $keys[5] => $this->getGender(),
            $keys[6] => $this->getCreated(),
        );
        if ($result[$keys[4]] instanceof \DateTime) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        if ($result[$keys[6]] instanceof \DateTime) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->singleUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->singleUser->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->singlePatient) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'patient';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.patient';
                        break;
                    default:
                        $key = 'Patient';
                }

                $result[$key] = $this->singlePatient->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPhoneNumbers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'phoneNumbers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.phone_numbers';
                        break;
                    default:
                        $key = 'PhoneNumbers';
                }

                $result[$key] = $this->collPhoneNumbers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->singleSurgeon) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'surgeon';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.surgeon';
                        break;
                    default:
                        $key = 'Surgeon';
                }

                $result[$key] = $this->singleSurgeon->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSurgeries) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'surgeries';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.surgeries';
                        break;
                    default:
                        $key = 'Surgeries';
                }

                $result[$key] = $this->collSurgeries->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->singleLegalGuardian) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'legalGuardian';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.legal_guardian';
                        break;
                    default:
                        $key = 'LegalGuardian';
                }

                $result[$key] = $this->singleLegalGuardian->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if (null !== $this->singleMedicalStaff) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'medicalStaff';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.medical_staff';
                        break;
                    default:
                        $key = 'MedicalStaff';
                }

                $result[$key] = $this->singleMedicalStaff->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
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
     * @return $this|\MocApi\Models\Person
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PersonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MocApi\Models\Person
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
                $this->setCPF($value);
                break;
            case 3:
                $this->setRG($value);
                break;
            case 4:
                $this->setBirthDate($value);
                break;
            case 5:
                $valueSet = PersonTableMap::getValueSet(PersonTableMap::COL_GENDER);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setGender($value);
                break;
            case 6:
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
        $keys = PersonTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCPF($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setRG($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setBirthDate($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setGender($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCreated($arr[$keys[6]]);
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
     * @return $this|\MocApi\Models\Person The current object, for fluid interface
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
        $criteria = new Criteria(PersonTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PersonTableMap::COL_ID)) {
            $criteria->add(PersonTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PersonTableMap::COL_NAME)) {
            $criteria->add(PersonTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(PersonTableMap::COL_CPF)) {
            $criteria->add(PersonTableMap::COL_CPF, $this->cpf);
        }
        if ($this->isColumnModified(PersonTableMap::COL_RG)) {
            $criteria->add(PersonTableMap::COL_RG, $this->rg);
        }
        if ($this->isColumnModified(PersonTableMap::COL_BIRTH_DATE)) {
            $criteria->add(PersonTableMap::COL_BIRTH_DATE, $this->birth_date);
        }
        if ($this->isColumnModified(PersonTableMap::COL_GENDER)) {
            $criteria->add(PersonTableMap::COL_GENDER, $this->gender);
        }
        if ($this->isColumnModified(PersonTableMap::COL_CREATED)) {
            $criteria->add(PersonTableMap::COL_CREATED, $this->created);
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
        $criteria = ChildPersonQuery::create();
        $criteria->add(PersonTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \MocApi\Models\Person (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setCPF($this->getCPF());
        $copyObj->setRG($this->getRG());
        $copyObj->setBirthDate($this->getBirthDate());
        $copyObj->setGender($this->getGender());
        $copyObj->setCreated($this->getCreated());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            $relObj = $this->getUser();
            if ($relObj) {
                $copyObj->setUser($relObj->copy($deepCopy));
            }

            $relObj = $this->getPatient();
            if ($relObj) {
                $copyObj->setPatient($relObj->copy($deepCopy));
            }

            foreach ($this->getPhoneNumbers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPhoneNumber($relObj->copy($deepCopy));
                }
            }

            $relObj = $this->getSurgeon();
            if ($relObj) {
                $copyObj->setSurgeon($relObj->copy($deepCopy));
            }

            foreach ($this->getSurgeries() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSurgery($relObj->copy($deepCopy));
                }
            }

            $relObj = $this->getLegalGuardian();
            if ($relObj) {
                $copyObj->setLegalGuardian($relObj->copy($deepCopy));
            }

            $relObj = $this->getMedicalStaff();
            if ($relObj) {
                $copyObj->setMedicalStaff($relObj->copy($deepCopy));
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
     * @return \MocApi\Models\Person Clone of current object.
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
        if ('PhoneNumber' == $relationName) {
            return $this->initPhoneNumbers();
        }
        if ('Surgery' == $relationName) {
            return $this->initSurgeries();
        }
    }

    /**
     * Gets a single ChildUser object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildUser
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {

        if ($this->singleUser === null && !$this->isNew()) {
            $this->singleUser = ChildUserQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleUser;
    }

    /**
     * Sets a single ChildUser object as related to this object by a one-to-one relationship.
     *
     * @param  ChildUser $v ChildUser
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        $this->singleUser = $v;

        // Make sure that that the passed-in ChildUser isn't already associated with this object
        if ($v !== null && $v->getPerson(null, false) === null) {
            $v->setPerson($this);
        }

        return $this;
    }

    /**
     * Gets a single ChildPatient object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildPatient
     * @throws PropelException
     */
    public function getPatient(ConnectionInterface $con = null)
    {

        if ($this->singlePatient === null && !$this->isNew()) {
            $this->singlePatient = ChildPatientQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singlePatient;
    }

    /**
     * Sets a single ChildPatient object as related to this object by a one-to-one relationship.
     *
     * @param  ChildPatient $v ChildPatient
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPatient(ChildPatient $v = null)
    {
        $this->singlePatient = $v;

        // Make sure that that the passed-in ChildPatient isn't already associated with this object
        if ($v !== null && $v->getPerson(null, false) === null) {
            $v->setPerson($this);
        }

        return $this;
    }

    /**
     * Clears out the collPhoneNumbers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPhoneNumbers()
     */
    public function clearPhoneNumbers()
    {
        $this->collPhoneNumbers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPhoneNumbers collection loaded partially.
     */
    public function resetPartialPhoneNumbers($v = true)
    {
        $this->collPhoneNumbersPartial = $v;
    }

    /**
     * Initializes the collPhoneNumbers collection.
     *
     * By default this just sets the collPhoneNumbers collection to an empty array (like clearcollPhoneNumbers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPhoneNumbers($overrideExisting = true)
    {
        if (null !== $this->collPhoneNumbers && !$overrideExisting) {
            return;
        }
        $this->collPhoneNumbers = new ObjectCollection();
        $this->collPhoneNumbers->setModel('\MocApi\Models\PhoneNumber');
    }

    /**
     * Gets an array of ChildPhoneNumber objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerson is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPhoneNumber[] List of ChildPhoneNumber objects
     * @throws PropelException
     */
    public function getPhoneNumbers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPhoneNumbersPartial && !$this->isNew();
        if (null === $this->collPhoneNumbers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPhoneNumbers) {
                // return empty collection
                $this->initPhoneNumbers();
            } else {
                $collPhoneNumbers = ChildPhoneNumberQuery::create(null, $criteria)
                    ->filterByPerson($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPhoneNumbersPartial && count($collPhoneNumbers)) {
                        $this->initPhoneNumbers(false);

                        foreach ($collPhoneNumbers as $obj) {
                            if (false == $this->collPhoneNumbers->contains($obj)) {
                                $this->collPhoneNumbers->append($obj);
                            }
                        }

                        $this->collPhoneNumbersPartial = true;
                    }

                    return $collPhoneNumbers;
                }

                if ($partial && $this->collPhoneNumbers) {
                    foreach ($this->collPhoneNumbers as $obj) {
                        if ($obj->isNew()) {
                            $collPhoneNumbers[] = $obj;
                        }
                    }
                }

                $this->collPhoneNumbers = $collPhoneNumbers;
                $this->collPhoneNumbersPartial = false;
            }
        }

        return $this->collPhoneNumbers;
    }

    /**
     * Sets a collection of ChildPhoneNumber objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $phoneNumbers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function setPhoneNumbers(Collection $phoneNumbers, ConnectionInterface $con = null)
    {
        /** @var ChildPhoneNumber[] $phoneNumbersToDelete */
        $phoneNumbersToDelete = $this->getPhoneNumbers(new Criteria(), $con)->diff($phoneNumbers);


        $this->phoneNumbersScheduledForDeletion = $phoneNumbersToDelete;

        foreach ($phoneNumbersToDelete as $phoneNumberRemoved) {
            $phoneNumberRemoved->setPerson(null);
        }

        $this->collPhoneNumbers = null;
        foreach ($phoneNumbers as $phoneNumber) {
            $this->addPhoneNumber($phoneNumber);
        }

        $this->collPhoneNumbers = $phoneNumbers;
        $this->collPhoneNumbersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PhoneNumber objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PhoneNumber objects.
     * @throws PropelException
     */
    public function countPhoneNumbers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPhoneNumbersPartial && !$this->isNew();
        if (null === $this->collPhoneNumbers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPhoneNumbers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPhoneNumbers());
            }

            $query = ChildPhoneNumberQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerson($this)
                ->count($con);
        }

        return count($this->collPhoneNumbers);
    }

    /**
     * Method called to associate a ChildPhoneNumber object to this object
     * through the ChildPhoneNumber foreign key attribute.
     *
     * @param  ChildPhoneNumber $l ChildPhoneNumber
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     */
    public function addPhoneNumber(ChildPhoneNumber $l)
    {
        if ($this->collPhoneNumbers === null) {
            $this->initPhoneNumbers();
            $this->collPhoneNumbersPartial = true;
        }

        if (!$this->collPhoneNumbers->contains($l)) {
            $this->doAddPhoneNumber($l);
        }

        return $this;
    }

    /**
     * @param ChildPhoneNumber $phoneNumber The ChildPhoneNumber object to add.
     */
    protected function doAddPhoneNumber(ChildPhoneNumber $phoneNumber)
    {
        $this->collPhoneNumbers[]= $phoneNumber;
        $phoneNumber->setPerson($this);
    }

    /**
     * @param  ChildPhoneNumber $phoneNumber The ChildPhoneNumber object to remove.
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function removePhoneNumber(ChildPhoneNumber $phoneNumber)
    {
        if ($this->getPhoneNumbers()->contains($phoneNumber)) {
            $pos = $this->collPhoneNumbers->search($phoneNumber);
            $this->collPhoneNumbers->remove($pos);
            if (null === $this->phoneNumbersScheduledForDeletion) {
                $this->phoneNumbersScheduledForDeletion = clone $this->collPhoneNumbers;
                $this->phoneNumbersScheduledForDeletion->clear();
            }
            $this->phoneNumbersScheduledForDeletion[]= clone $phoneNumber;
            $phoneNumber->setPerson(null);
        }

        return $this;
    }

    /**
     * Gets a single ChildSurgeon object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildSurgeon
     * @throws PropelException
     */
    public function getSurgeon(ConnectionInterface $con = null)
    {

        if ($this->singleSurgeon === null && !$this->isNew()) {
            $this->singleSurgeon = ChildSurgeonQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleSurgeon;
    }

    /**
     * Sets a single ChildSurgeon object as related to this object by a one-to-one relationship.
     *
     * @param  ChildSurgeon $v ChildSurgeon
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSurgeon(ChildSurgeon $v = null)
    {
        $this->singleSurgeon = $v;

        // Make sure that that the passed-in ChildSurgeon isn't already associated with this object
        if ($v !== null && $v->getPerson(null, false) === null) {
            $v->setPerson($this);
        }

        return $this;
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
     * Reset is the collSurgeries collection loaded partially.
     */
    public function resetPartialSurgeries($v = true)
    {
        $this->collSurgeriesPartial = $v;
    }

    /**
     * Initializes the collSurgeries collection.
     *
     * By default this just sets the collSurgeries collection to an empty array (like clearcollSurgeries());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSurgeries($overrideExisting = true)
    {
        if (null !== $this->collSurgeries && !$overrideExisting) {
            return;
        }
        $this->collSurgeries = new ObjectCollection();
        $this->collSurgeries->setModel('\MocApi\Models\Surgery');
    }

    /**
     * Gets an array of ChildSurgery objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPerson is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSurgery[] List of ChildSurgery objects
     * @throws PropelException
     */
    public function getSurgeries(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeriesPartial && !$this->isNew();
        if (null === $this->collSurgeries || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSurgeries) {
                // return empty collection
                $this->initSurgeries();
            } else {
                $collSurgeries = ChildSurgeryQuery::create(null, $criteria)
                    ->filterByCreator($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSurgeriesPartial && count($collSurgeries)) {
                        $this->initSurgeries(false);

                        foreach ($collSurgeries as $obj) {
                            if (false == $this->collSurgeries->contains($obj)) {
                                $this->collSurgeries->append($obj);
                            }
                        }

                        $this->collSurgeriesPartial = true;
                    }

                    return $collSurgeries;
                }

                if ($partial && $this->collSurgeries) {
                    foreach ($this->collSurgeries as $obj) {
                        if ($obj->isNew()) {
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
     * Sets a collection of ChildSurgery objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $surgeries A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function setSurgeries(Collection $surgeries, ConnectionInterface $con = null)
    {
        /** @var ChildSurgery[] $surgeriesToDelete */
        $surgeriesToDelete = $this->getSurgeries(new Criteria(), $con)->diff($surgeries);


        $this->surgeriesScheduledForDeletion = $surgeriesToDelete;

        foreach ($surgeriesToDelete as $surgeryRemoved) {
            $surgeryRemoved->setCreator(null);
        }

        $this->collSurgeries = null;
        foreach ($surgeries as $surgery) {
            $this->addSurgery($surgery);
        }

        $this->collSurgeries = $surgeries;
        $this->collSurgeriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Surgery objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Surgery objects.
     * @throws PropelException
     */
    public function countSurgeries(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSurgeriesPartial && !$this->isNew();
        if (null === $this->collSurgeries || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSurgeries) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSurgeries());
            }

            $query = ChildSurgeryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCreator($this)
                ->count($con);
        }

        return count($this->collSurgeries);
    }

    /**
     * Method called to associate a ChildSurgery object to this object
     * through the ChildSurgery foreign key attribute.
     *
     * @param  ChildSurgery $l ChildSurgery
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     */
    public function addSurgery(ChildSurgery $l)
    {
        if ($this->collSurgeries === null) {
            $this->initSurgeries();
            $this->collSurgeriesPartial = true;
        }

        if (!$this->collSurgeries->contains($l)) {
            $this->doAddSurgery($l);
        }

        return $this;
    }

    /**
     * @param ChildSurgery $surgery The ChildSurgery object to add.
     */
    protected function doAddSurgery(ChildSurgery $surgery)
    {
        $this->collSurgeries[]= $surgery;
        $surgery->setCreator($this);
    }

    /**
     * @param  ChildSurgery $surgery The ChildSurgery object to remove.
     * @return $this|ChildPerson The current object (for fluent API support)
     */
    public function removeSurgery(ChildSurgery $surgery)
    {
        if ($this->getSurgeries()->contains($surgery)) {
            $pos = $this->collSurgeries->search($surgery);
            $this->collSurgeries->remove($pos);
            if (null === $this->surgeriesScheduledForDeletion) {
                $this->surgeriesScheduledForDeletion = clone $this->collSurgeries;
                $this->surgeriesScheduledForDeletion->clear();
            }
            $this->surgeriesScheduledForDeletion[]= clone $surgery;
            $surgery->setCreator(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Person is new, it will return
     * an empty collection; or if this Person has previously
     * been saved, it will retrieve related Surgeries from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Person.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSurgery[] List of ChildSurgery objects
     */
    public function getSurgeriesJoinSurgeryType(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSurgeryQuery::create(null, $criteria);
        $query->joinWith('SurgeryType', $joinBehavior);

        return $this->getSurgeries($query, $con);
    }

    /**
     * Gets a single ChildLegalGuardian object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildLegalGuardian
     * @throws PropelException
     */
    public function getLegalGuardian(ConnectionInterface $con = null)
    {

        if ($this->singleLegalGuardian === null && !$this->isNew()) {
            $this->singleLegalGuardian = ChildLegalGuardianQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleLegalGuardian;
    }

    /**
     * Sets a single ChildLegalGuardian object as related to this object by a one-to-one relationship.
     *
     * @param  ChildLegalGuardian $v ChildLegalGuardian
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     * @throws PropelException
     */
    public function setLegalGuardian(ChildLegalGuardian $v = null)
    {
        $this->singleLegalGuardian = $v;

        // Make sure that that the passed-in ChildLegalGuardian isn't already associated with this object
        if ($v !== null && $v->getPerson(null, false) === null) {
            $v->setPerson($this);
        }

        return $this;
    }

    /**
     * Gets a single ChildMedicalStaff object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildMedicalStaff
     * @throws PropelException
     */
    public function getMedicalStaff(ConnectionInterface $con = null)
    {

        if ($this->singleMedicalStaff === null && !$this->isNew()) {
            $this->singleMedicalStaff = ChildMedicalStaffQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleMedicalStaff;
    }

    /**
     * Sets a single ChildMedicalStaff object as related to this object by a one-to-one relationship.
     *
     * @param  ChildMedicalStaff $v ChildMedicalStaff
     * @return $this|\MocApi\Models\Person The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMedicalStaff(ChildMedicalStaff $v = null)
    {
        $this->singleMedicalStaff = $v;

        // Make sure that that the passed-in ChildMedicalStaff isn't already associated with this object
        if ($v !== null && $v->getPerson(null, false) === null) {
            $v->setPerson($this);
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
        $this->cpf = null;
        $this->rg = null;
        $this->birth_date = null;
        $this->gender = null;
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
            if ($this->singleUser) {
                $this->singleUser->clearAllReferences($deep);
            }
            if ($this->singlePatient) {
                $this->singlePatient->clearAllReferences($deep);
            }
            if ($this->collPhoneNumbers) {
                foreach ($this->collPhoneNumbers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singleSurgeon) {
                $this->singleSurgeon->clearAllReferences($deep);
            }
            if ($this->collSurgeries) {
                foreach ($this->collSurgeries as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singleLegalGuardian) {
                $this->singleLegalGuardian->clearAllReferences($deep);
            }
            if ($this->singleMedicalStaff) {
                $this->singleMedicalStaff->clearAllReferences($deep);
            }
        } // if ($deep)

        $this->singleUser = null;
        $this->singlePatient = null;
        $this->collPhoneNumbers = null;
        $this->singleSurgeon = null;
        $this->collSurgeries = null;
        $this->singleLegalGuardian = null;
        $this->singleMedicalStaff = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PersonTableMap::DEFAULT_STRING_FORMAT);
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
