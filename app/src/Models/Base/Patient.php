<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\HealthInsuranceCard as ChildHealthInsuranceCard;
use MocApi\Models\HealthInsuranceCardQuery as ChildHealthInsuranceCardQuery;
use MocApi\Models\LegalGuardian as ChildLegalGuardian;
use MocApi\Models\LegalGuardianQuery as ChildLegalGuardianQuery;
use MocApi\Models\Patient as ChildPatient;
use MocApi\Models\PatientQuery as ChildPatientQuery;
use MocApi\Models\Person as ChildPerson;
use MocApi\Models\PersonQuery as ChildPersonQuery;
use MocApi\Models\Surgery as ChildSurgery;
use MocApi\Models\SurgeryQuery as ChildSurgeryQuery;
use MocApi\Models\Map\PatientTableMap;
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

/**
 * Base class that represents a row from the 'moc.patient' table.
 *
 *
 *
* @package    propel.generator.MocApi.Models.Base
*/
abstract class Patient implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MocApi\\Models\\Map\\PatientTableMap';


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
     * The value for the person_id field.
     *
     * @var        int
     */
    protected $person_id;

    /**
     * The value for the weight field.
     *
     * @var        double
     */
    protected $weight;

    /**
     * The value for the height field.
     *
     * @var        double
     */
    protected $height;

    /**
     * The value for the blood_type field.
     *
     * @var        string
     */
    protected $blood_type;

    /**
     * The value for the notes field.
     *
     * @var        string
     */
    protected $notes;

    /**
     * The value for the surgery_id field.
     *
     * @var        int
     */
    protected $surgery_id;

    /**
     * @var        ChildPerson
     */
    protected $aPerson;

    /**
     * @var        ChildSurgery
     */
    protected $aSurgery;

    /**
     * @var        ObjectCollection|ChildHealthInsuranceCard[] Collection to store aggregation of ChildHealthInsuranceCard objects.
     */
    protected $collHealthInsuranceCards;
    protected $collHealthInsuranceCardsPartial;

    /**
     * @var        ObjectCollection|ChildLegalGuardian[] Collection to store aggregation of ChildLegalGuardian objects.
     */
    protected $collLegalGuardians;
    protected $collLegalGuardiansPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildHealthInsuranceCard[]
     */
    protected $healthInsuranceCardsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildLegalGuardian[]
     */
    protected $legalGuardiansScheduledForDeletion = null;

    /**
     * Initializes internal state of MocApi\Models\Base\Patient object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Patient</code> instance.  If
     * <code>obj</code> is an instance of <code>Patient</code>, delegates to
     * <code>equals(Patient)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Patient The current object, for fluid interface
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
     * Get the [person_id] column value.
     *
     * @return int
     */
    public function getPersonId()
    {
        return $this->person_id;
    }

    /**
     * Get the [weight] column value.
     *
     * @return double
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Get the [height] column value.
     *
     * @return double
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Get the [blood_type] column value.
     *
     * @return string
     */
    public function getBloodType()
    {
        return $this->blood_type;
    }

    /**
     * Get the [notes] column value.
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Get the [surgery_id] column value.
     *
     * @return int
     */
    public function getSurgeryId()
    {
        return $this->surgery_id;
    }

    /**
     * Set the value of [person_id] column.
     *
     * @param int $v new value
     * @return $this|\MocApi\Models\Patient The current object (for fluent API support)
     */
    public function setPersonId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->person_id !== $v) {
            $this->person_id = $v;
            $this->modifiedColumns[PatientTableMap::COL_PERSON_ID] = true;
        }

        if ($this->aPerson !== null && $this->aPerson->getId() !== $v) {
            $this->aPerson = null;
        }

        return $this;
    } // setPersonId()

    /**
     * Set the value of [weight] column.
     *
     * @param double $v new value
     * @return $this|\MocApi\Models\Patient The current object (for fluent API support)
     */
    public function setWeight($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->weight !== $v) {
            $this->weight = $v;
            $this->modifiedColumns[PatientTableMap::COL_WEIGHT] = true;
        }

        return $this;
    } // setWeight()

    /**
     * Set the value of [height] column.
     *
     * @param double $v new value
     * @return $this|\MocApi\Models\Patient The current object (for fluent API support)
     */
    public function setHeight($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->height !== $v) {
            $this->height = $v;
            $this->modifiedColumns[PatientTableMap::COL_HEIGHT] = true;
        }

        return $this;
    } // setHeight()

    /**
     * Set the value of [blood_type] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Patient The current object (for fluent API support)
     */
    public function setBloodType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->blood_type !== $v) {
            $this->blood_type = $v;
            $this->modifiedColumns[PatientTableMap::COL_BLOOD_TYPE] = true;
        }

        return $this;
    } // setBloodType()

    /**
     * Set the value of [notes] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Patient The current object (for fluent API support)
     */
    public function setNotes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->notes !== $v) {
            $this->notes = $v;
            $this->modifiedColumns[PatientTableMap::COL_NOTES] = true;
        }

        return $this;
    } // setNotes()

    /**
     * Set the value of [surgery_id] column.
     *
     * @param int $v new value
     * @return $this|\MocApi\Models\Patient The current object (for fluent API support)
     */
    public function setSurgeryId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->surgery_id !== $v) {
            $this->surgery_id = $v;
            $this->modifiedColumns[PatientTableMap::COL_SURGERY_ID] = true;
        }

        if ($this->aSurgery !== null && $this->aSurgery->getId() !== $v) {
            $this->aSurgery = null;
        }

        return $this;
    } // setSurgeryId()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PatientTableMap::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->person_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PatientTableMap::translateFieldName('Weight', TableMap::TYPE_PHPNAME, $indexType)];
            $this->weight = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PatientTableMap::translateFieldName('Height', TableMap::TYPE_PHPNAME, $indexType)];
            $this->height = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PatientTableMap::translateFieldName('BloodType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->blood_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PatientTableMap::translateFieldName('Notes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->notes = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PatientTableMap::translateFieldName('SurgeryId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->surgery_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = PatientTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MocApi\\Models\\Patient'), 0, $e);
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
        if ($this->aPerson !== null && $this->person_id !== $this->aPerson->getId()) {
            $this->aPerson = null;
        }
        if ($this->aSurgery !== null && $this->surgery_id !== $this->aSurgery->getId()) {
            $this->aSurgery = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PatientTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPatientQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPerson = null;
            $this->aSurgery = null;
            $this->collHealthInsuranceCards = null;

            $this->collLegalGuardians = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Patient::setDeleted()
     * @see Patient::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PatientTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPatientQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PatientTableMap::DATABASE_NAME);
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
                PatientTableMap::addInstanceToPool($this);
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

            if ($this->aPerson !== null) {
                if ($this->aPerson->isModified() || $this->aPerson->isNew()) {
                    $affectedRows += $this->aPerson->save($con);
                }
                $this->setPerson($this->aPerson);
            }

            if ($this->aSurgery !== null) {
                if ($this->aSurgery->isModified() || $this->aSurgery->isNew()) {
                    $affectedRows += $this->aSurgery->save($con);
                }
                $this->setSurgery($this->aSurgery);
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

            if ($this->healthInsuranceCardsScheduledForDeletion !== null) {
                if (!$this->healthInsuranceCardsScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\HealthInsuranceCardQuery::create()
                        ->filterByPrimaryKeys($this->healthInsuranceCardsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->healthInsuranceCardsScheduledForDeletion = null;
                }
            }

            if ($this->collHealthInsuranceCards !== null) {
                foreach ($this->collHealthInsuranceCards as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->legalGuardiansScheduledForDeletion !== null) {
                if (!$this->legalGuardiansScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\LegalGuardianQuery::create()
                        ->filterByPrimaryKeys($this->legalGuardiansScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->legalGuardiansScheduledForDeletion = null;
                }
            }

            if ($this->collLegalGuardians !== null) {
                foreach ($this->collLegalGuardians as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PatientTableMap::COL_PERSON_ID)) {
            $modifiedColumns[':p' . $index++]  = 'person_id';
        }
        if ($this->isColumnModified(PatientTableMap::COL_WEIGHT)) {
            $modifiedColumns[':p' . $index++]  = 'weight';
        }
        if ($this->isColumnModified(PatientTableMap::COL_HEIGHT)) {
            $modifiedColumns[':p' . $index++]  = 'height';
        }
        if ($this->isColumnModified(PatientTableMap::COL_BLOOD_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'blood_type';
        }
        if ($this->isColumnModified(PatientTableMap::COL_NOTES)) {
            $modifiedColumns[':p' . $index++]  = 'notes';
        }
        if ($this->isColumnModified(PatientTableMap::COL_SURGERY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'surgery_id';
        }

        $sql = sprintf(
            'INSERT INTO moc.patient (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'person_id':
                        $stmt->bindValue($identifier, $this->person_id, PDO::PARAM_INT);
                        break;
                    case 'weight':
                        $stmt->bindValue($identifier, $this->weight, PDO::PARAM_STR);
                        break;
                    case 'height':
                        $stmt->bindValue($identifier, $this->height, PDO::PARAM_STR);
                        break;
                    case 'blood_type':
                        $stmt->bindValue($identifier, $this->blood_type, PDO::PARAM_STR);
                        break;
                    case 'notes':
                        $stmt->bindValue($identifier, $this->notes, PDO::PARAM_STR);
                        break;
                    case 'surgery_id':
                        $stmt->bindValue($identifier, $this->surgery_id, PDO::PARAM_INT);
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
        $pos = PatientTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPersonId();
                break;
            case 1:
                return $this->getWeight();
                break;
            case 2:
                return $this->getHeight();
                break;
            case 3:
                return $this->getBloodType();
                break;
            case 4:
                return $this->getNotes();
                break;
            case 5:
                return $this->getSurgeryId();
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

        if (isset($alreadyDumpedObjects['Patient'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Patient'][$this->hashCode()] = true;
        $keys = PatientTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getPersonId(),
            $keys[1] => $this->getWeight(),
            $keys[2] => $this->getHeight(),
            $keys[3] => $this->getBloodType(),
            $keys[4] => $this->getNotes(),
            $keys[5] => $this->getSurgeryId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPerson) {

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

                $result[$key] = $this->aPerson->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSurgery) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'surgery';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.surgery';
                        break;
                    default:
                        $key = 'Surgery';
                }

                $result[$key] = $this->aSurgery->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collHealthInsuranceCards) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'healthInsuranceCards';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.health_insurance_cards';
                        break;
                    default:
                        $key = 'HealthInsuranceCards';
                }

                $result[$key] = $this->collHealthInsuranceCards->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collLegalGuardians) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'legalGuardians';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.legal_guardians';
                        break;
                    default:
                        $key = 'LegalGuardians';
                }

                $result[$key] = $this->collLegalGuardians->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\MocApi\Models\Patient
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PatientTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MocApi\Models\Patient
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setPersonId($value);
                break;
            case 1:
                $this->setWeight($value);
                break;
            case 2:
                $this->setHeight($value);
                break;
            case 3:
                $this->setBloodType($value);
                break;
            case 4:
                $this->setNotes($value);
                break;
            case 5:
                $this->setSurgeryId($value);
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
        $keys = PatientTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setPersonId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setWeight($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setHeight($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setBloodType($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setNotes($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSurgeryId($arr[$keys[5]]);
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
     * @return $this|\MocApi\Models\Patient The current object, for fluid interface
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
        $criteria = new Criteria(PatientTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PatientTableMap::COL_PERSON_ID)) {
            $criteria->add(PatientTableMap::COL_PERSON_ID, $this->person_id);
        }
        if ($this->isColumnModified(PatientTableMap::COL_WEIGHT)) {
            $criteria->add(PatientTableMap::COL_WEIGHT, $this->weight);
        }
        if ($this->isColumnModified(PatientTableMap::COL_HEIGHT)) {
            $criteria->add(PatientTableMap::COL_HEIGHT, $this->height);
        }
        if ($this->isColumnModified(PatientTableMap::COL_BLOOD_TYPE)) {
            $criteria->add(PatientTableMap::COL_BLOOD_TYPE, $this->blood_type);
        }
        if ($this->isColumnModified(PatientTableMap::COL_NOTES)) {
            $criteria->add(PatientTableMap::COL_NOTES, $this->notes);
        }
        if ($this->isColumnModified(PatientTableMap::COL_SURGERY_ID)) {
            $criteria->add(PatientTableMap::COL_SURGERY_ID, $this->surgery_id);
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
        $criteria = ChildPatientQuery::create();
        $criteria->add(PatientTableMap::COL_PERSON_ID, $this->person_id);

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
        $validPk = null !== $this->getPersonId();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation patient_person_id_fkey to table moc.person
        if ($this->aPerson && $hash = spl_object_hash($this->aPerson)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

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
        return $this->getPersonId();
    }

    /**
     * Generic method to set the primary key (person_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setPersonId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getPersonId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \MocApi\Models\Patient (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPersonId($this->getPersonId());
        $copyObj->setWeight($this->getWeight());
        $copyObj->setHeight($this->getHeight());
        $copyObj->setBloodType($this->getBloodType());
        $copyObj->setNotes($this->getNotes());
        $copyObj->setSurgeryId($this->getSurgeryId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getHealthInsuranceCards() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addHealthInsuranceCard($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getLegalGuardians() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addLegalGuardian($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \MocApi\Models\Patient Clone of current object.
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
     * @return $this|\MocApi\Models\Patient The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPerson(ChildPerson $v = null)
    {
        if ($v === null) {
            $this->setPersonId(NULL);
        } else {
            $this->setPersonId($v->getId());
        }

        $this->aPerson = $v;

        // Add binding for other direction of this 1:1 relationship.
        if ($v !== null) {
            $v->setPatient($this);
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
    public function getPerson(ConnectionInterface $con = null)
    {
        if ($this->aPerson === null && ($this->person_id !== null)) {
            $this->aPerson = ChildPersonQuery::create()->findPk($this->person_id, $con);
            // Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
            $this->aPerson->setPatient($this);
        }

        return $this->aPerson;
    }

    /**
     * Declares an association between this object and a ChildSurgery object.
     *
     * @param  ChildSurgery $v
     * @return $this|\MocApi\Models\Patient The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSurgery(ChildSurgery $v = null)
    {
        if ($v === null) {
            $this->setSurgeryId(NULL);
        } else {
            $this->setSurgeryId($v->getId());
        }

        $this->aSurgery = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSurgery object, it will not be re-added.
        if ($v !== null) {
            $v->addPatient($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSurgery object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSurgery The associated ChildSurgery object.
     * @throws PropelException
     */
    public function getSurgery(ConnectionInterface $con = null)
    {
        if ($this->aSurgery === null && ($this->surgery_id !== null)) {
            $this->aSurgery = ChildSurgeryQuery::create()->findPk($this->surgery_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSurgery->addPatients($this);
             */
        }

        return $this->aSurgery;
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
        if ('HealthInsuranceCard' == $relationName) {
            return $this->initHealthInsuranceCards();
        }
        if ('LegalGuardian' == $relationName) {
            return $this->initLegalGuardians();
        }
    }

    /**
     * Clears out the collHealthInsuranceCards collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addHealthInsuranceCards()
     */
    public function clearHealthInsuranceCards()
    {
        $this->collHealthInsuranceCards = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collHealthInsuranceCards collection loaded partially.
     */
    public function resetPartialHealthInsuranceCards($v = true)
    {
        $this->collHealthInsuranceCardsPartial = $v;
    }

    /**
     * Initializes the collHealthInsuranceCards collection.
     *
     * By default this just sets the collHealthInsuranceCards collection to an empty array (like clearcollHealthInsuranceCards());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initHealthInsuranceCards($overrideExisting = true)
    {
        if (null !== $this->collHealthInsuranceCards && !$overrideExisting) {
            return;
        }
        $this->collHealthInsuranceCards = new ObjectCollection();
        $this->collHealthInsuranceCards->setModel('\MocApi\Models\HealthInsuranceCard');
    }

    /**
     * Gets an array of ChildHealthInsuranceCard objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPatient is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildHealthInsuranceCard[] List of ChildHealthInsuranceCard objects
     * @throws PropelException
     */
    public function getHealthInsuranceCards(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collHealthInsuranceCardsPartial && !$this->isNew();
        if (null === $this->collHealthInsuranceCards || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collHealthInsuranceCards) {
                // return empty collection
                $this->initHealthInsuranceCards();
            } else {
                $collHealthInsuranceCards = ChildHealthInsuranceCardQuery::create(null, $criteria)
                    ->filterByPatient($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collHealthInsuranceCardsPartial && count($collHealthInsuranceCards)) {
                        $this->initHealthInsuranceCards(false);

                        foreach ($collHealthInsuranceCards as $obj) {
                            if (false == $this->collHealthInsuranceCards->contains($obj)) {
                                $this->collHealthInsuranceCards->append($obj);
                            }
                        }

                        $this->collHealthInsuranceCardsPartial = true;
                    }

                    return $collHealthInsuranceCards;
                }

                if ($partial && $this->collHealthInsuranceCards) {
                    foreach ($this->collHealthInsuranceCards as $obj) {
                        if ($obj->isNew()) {
                            $collHealthInsuranceCards[] = $obj;
                        }
                    }
                }

                $this->collHealthInsuranceCards = $collHealthInsuranceCards;
                $this->collHealthInsuranceCardsPartial = false;
            }
        }

        return $this->collHealthInsuranceCards;
    }

    /**
     * Sets a collection of ChildHealthInsuranceCard objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $healthInsuranceCards A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function setHealthInsuranceCards(Collection $healthInsuranceCards, ConnectionInterface $con = null)
    {
        /** @var ChildHealthInsuranceCard[] $healthInsuranceCardsToDelete */
        $healthInsuranceCardsToDelete = $this->getHealthInsuranceCards(new Criteria(), $con)->diff($healthInsuranceCards);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->healthInsuranceCardsScheduledForDeletion = clone $healthInsuranceCardsToDelete;

        foreach ($healthInsuranceCardsToDelete as $healthInsuranceCardRemoved) {
            $healthInsuranceCardRemoved->setPatient(null);
        }

        $this->collHealthInsuranceCards = null;
        foreach ($healthInsuranceCards as $healthInsuranceCard) {
            $this->addHealthInsuranceCard($healthInsuranceCard);
        }

        $this->collHealthInsuranceCards = $healthInsuranceCards;
        $this->collHealthInsuranceCardsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related HealthInsuranceCard objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related HealthInsuranceCard objects.
     * @throws PropelException
     */
    public function countHealthInsuranceCards(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collHealthInsuranceCardsPartial && !$this->isNew();
        if (null === $this->collHealthInsuranceCards || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collHealthInsuranceCards) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getHealthInsuranceCards());
            }

            $query = ChildHealthInsuranceCardQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPatient($this)
                ->count($con);
        }

        return count($this->collHealthInsuranceCards);
    }

    /**
     * Method called to associate a ChildHealthInsuranceCard object to this object
     * through the ChildHealthInsuranceCard foreign key attribute.
     *
     * @param  ChildHealthInsuranceCard $l ChildHealthInsuranceCard
     * @return $this|\MocApi\Models\Patient The current object (for fluent API support)
     */
    public function addHealthInsuranceCard(ChildHealthInsuranceCard $l)
    {
        if ($this->collHealthInsuranceCards === null) {
            $this->initHealthInsuranceCards();
            $this->collHealthInsuranceCardsPartial = true;
        }

        if (!$this->collHealthInsuranceCards->contains($l)) {
            $this->doAddHealthInsuranceCard($l);
        }

        return $this;
    }

    /**
     * @param ChildHealthInsuranceCard $healthInsuranceCard The ChildHealthInsuranceCard object to add.
     */
    protected function doAddHealthInsuranceCard(ChildHealthInsuranceCard $healthInsuranceCard)
    {
        $this->collHealthInsuranceCards[]= $healthInsuranceCard;
        $healthInsuranceCard->setPatient($this);
    }

    /**
     * @param  ChildHealthInsuranceCard $healthInsuranceCard The ChildHealthInsuranceCard object to remove.
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function removeHealthInsuranceCard(ChildHealthInsuranceCard $healthInsuranceCard)
    {
        if ($this->getHealthInsuranceCards()->contains($healthInsuranceCard)) {
            $pos = $this->collHealthInsuranceCards->search($healthInsuranceCard);
            $this->collHealthInsuranceCards->remove($pos);
            if (null === $this->healthInsuranceCardsScheduledForDeletion) {
                $this->healthInsuranceCardsScheduledForDeletion = clone $this->collHealthInsuranceCards;
                $this->healthInsuranceCardsScheduledForDeletion->clear();
            }
            $this->healthInsuranceCardsScheduledForDeletion[]= clone $healthInsuranceCard;
            $healthInsuranceCard->setPatient(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Patient is new, it will return
     * an empty collection; or if this Patient has previously
     * been saved, it will retrieve related HealthInsuranceCards from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Patient.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildHealthInsuranceCard[] List of ChildHealthInsuranceCard objects
     */
    public function getHealthInsuranceCardsJoinHealthInsurance(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildHealthInsuranceCardQuery::create(null, $criteria);
        $query->joinWith('HealthInsurance', $joinBehavior);

        return $this->getHealthInsuranceCards($query, $con);
    }

    /**
     * Clears out the collLegalGuardians collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addLegalGuardians()
     */
    public function clearLegalGuardians()
    {
        $this->collLegalGuardians = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collLegalGuardians collection loaded partially.
     */
    public function resetPartialLegalGuardians($v = true)
    {
        $this->collLegalGuardiansPartial = $v;
    }

    /**
     * Initializes the collLegalGuardians collection.
     *
     * By default this just sets the collLegalGuardians collection to an empty array (like clearcollLegalGuardians());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initLegalGuardians($overrideExisting = true)
    {
        if (null !== $this->collLegalGuardians && !$overrideExisting) {
            return;
        }
        $this->collLegalGuardians = new ObjectCollection();
        $this->collLegalGuardians->setModel('\MocApi\Models\LegalGuardian');
    }

    /**
     * Gets an array of ChildLegalGuardian objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPatient is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildLegalGuardian[] List of ChildLegalGuardian objects
     * @throws PropelException
     */
    public function getLegalGuardians(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collLegalGuardiansPartial && !$this->isNew();
        if (null === $this->collLegalGuardians || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collLegalGuardians) {
                // return empty collection
                $this->initLegalGuardians();
            } else {
                $collLegalGuardians = ChildLegalGuardianQuery::create(null, $criteria)
                    ->filterByPatient($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collLegalGuardiansPartial && count($collLegalGuardians)) {
                        $this->initLegalGuardians(false);

                        foreach ($collLegalGuardians as $obj) {
                            if (false == $this->collLegalGuardians->contains($obj)) {
                                $this->collLegalGuardians->append($obj);
                            }
                        }

                        $this->collLegalGuardiansPartial = true;
                    }

                    return $collLegalGuardians;
                }

                if ($partial && $this->collLegalGuardians) {
                    foreach ($this->collLegalGuardians as $obj) {
                        if ($obj->isNew()) {
                            $collLegalGuardians[] = $obj;
                        }
                    }
                }

                $this->collLegalGuardians = $collLegalGuardians;
                $this->collLegalGuardiansPartial = false;
            }
        }

        return $this->collLegalGuardians;
    }

    /**
     * Sets a collection of ChildLegalGuardian objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $legalGuardians A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function setLegalGuardians(Collection $legalGuardians, ConnectionInterface $con = null)
    {
        /** @var ChildLegalGuardian[] $legalGuardiansToDelete */
        $legalGuardiansToDelete = $this->getLegalGuardians(new Criteria(), $con)->diff($legalGuardians);


        $this->legalGuardiansScheduledForDeletion = $legalGuardiansToDelete;

        foreach ($legalGuardiansToDelete as $legalGuardianRemoved) {
            $legalGuardianRemoved->setPatient(null);
        }

        $this->collLegalGuardians = null;
        foreach ($legalGuardians as $legalGuardian) {
            $this->addLegalGuardian($legalGuardian);
        }

        $this->collLegalGuardians = $legalGuardians;
        $this->collLegalGuardiansPartial = false;

        return $this;
    }

    /**
     * Returns the number of related LegalGuardian objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related LegalGuardian objects.
     * @throws PropelException
     */
    public function countLegalGuardians(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collLegalGuardiansPartial && !$this->isNew();
        if (null === $this->collLegalGuardians || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collLegalGuardians) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getLegalGuardians());
            }

            $query = ChildLegalGuardianQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPatient($this)
                ->count($con);
        }

        return count($this->collLegalGuardians);
    }

    /**
     * Method called to associate a ChildLegalGuardian object to this object
     * through the ChildLegalGuardian foreign key attribute.
     *
     * @param  ChildLegalGuardian $l ChildLegalGuardian
     * @return $this|\MocApi\Models\Patient The current object (for fluent API support)
     */
    public function addLegalGuardian(ChildLegalGuardian $l)
    {
        if ($this->collLegalGuardians === null) {
            $this->initLegalGuardians();
            $this->collLegalGuardiansPartial = true;
        }

        if (!$this->collLegalGuardians->contains($l)) {
            $this->doAddLegalGuardian($l);
        }

        return $this;
    }

    /**
     * @param ChildLegalGuardian $legalGuardian The ChildLegalGuardian object to add.
     */
    protected function doAddLegalGuardian(ChildLegalGuardian $legalGuardian)
    {
        $this->collLegalGuardians[]= $legalGuardian;
        $legalGuardian->setPatient($this);
    }

    /**
     * @param  ChildLegalGuardian $legalGuardian The ChildLegalGuardian object to remove.
     * @return $this|ChildPatient The current object (for fluent API support)
     */
    public function removeLegalGuardian(ChildLegalGuardian $legalGuardian)
    {
        if ($this->getLegalGuardians()->contains($legalGuardian)) {
            $pos = $this->collLegalGuardians->search($legalGuardian);
            $this->collLegalGuardians->remove($pos);
            if (null === $this->legalGuardiansScheduledForDeletion) {
                $this->legalGuardiansScheduledForDeletion = clone $this->collLegalGuardians;
                $this->legalGuardiansScheduledForDeletion->clear();
            }
            $this->legalGuardiansScheduledForDeletion[]= clone $legalGuardian;
            $legalGuardian->setPatient(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Patient is new, it will return
     * an empty collection; or if this Patient has previously
     * been saved, it will retrieve related LegalGuardians from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Patient.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildLegalGuardian[] List of ChildLegalGuardian objects
     */
    public function getLegalGuardiansJoinPerson(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildLegalGuardianQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getLegalGuardians($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPerson) {
            $this->aPerson->removePatient($this);
        }
        if (null !== $this->aSurgery) {
            $this->aSurgery->removePatient($this);
        }
        $this->person_id = null;
        $this->weight = null;
        $this->height = null;
        $this->blood_type = null;
        $this->notes = null;
        $this->surgery_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collHealthInsuranceCards) {
                foreach ($this->collHealthInsuranceCards as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collLegalGuardians) {
                foreach ($this->collLegalGuardians as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collHealthInsuranceCards = null;
        $this->collLegalGuardians = null;
        $this->aPerson = null;
        $this->aSurgery = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PatientTableMap::DEFAULT_STRING_FORMAT);
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
