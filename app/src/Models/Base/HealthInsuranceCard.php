<?php

namespace MocApi\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use MocApi\Models\HealthInsurance as ChildHealthInsurance;
use MocApi\Models\HealthInsuranceCardQuery as ChildHealthInsuranceCardQuery;
use MocApi\Models\HealthInsuranceQuery as ChildHealthInsuranceQuery;
use MocApi\Models\Patient as ChildPatient;
use MocApi\Models\PatientQuery as ChildPatientQuery;
use MocApi\Models\Map\HealthInsuranceCardTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'moc.health_insurance_card' table.
 *
 *
 *
* @package    propel.generator.MocApi.Models.Base
*/
abstract class HealthInsuranceCard implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MocApi\\Models\\Map\\HealthInsuranceCardTableMap';


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
     * The value for the patient_id field.
     *
     * @var        int
     */
    protected $patient_id;

    /**
     * The value for the health_insurance_id field.
     *
     * @var        int
     */
    protected $health_insurance_id;

    /**
     * The value for the number field.
     *
     * @var        string
     */
    protected $number;

    /**
     * The value for the expiration field.
     *
     * @var        \DateTime
     */
    protected $expiration;

    /**
     * @var        ChildPatient
     */
    protected $aPatient;

    /**
     * @var        ChildHealthInsurance
     */
    protected $aHealthInsurance;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of MocApi\Models\Base\HealthInsuranceCard object.
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
     * Compares this with another <code>HealthInsuranceCard</code> instance.  If
     * <code>obj</code> is an instance of <code>HealthInsuranceCard</code>, delegates to
     * <code>equals(HealthInsuranceCard)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|HealthInsuranceCard The current object, for fluid interface
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
     * Get the [patient_id] column value.
     *
     * @return int
     */
    public function getPatientId()
    {
        return $this->patient_id;
    }

    /**
     * Get the [health_insurance_id] column value.
     *
     * @return int
     */
    public function getHealthInsuranceId()
    {
        return $this->health_insurance_id;
    }

    /**
     * Get the [number] column value.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get the [optionally formatted] temporal [expiration] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getExpiration($format = NULL)
    {
        if ($format === null) {
            return $this->expiration;
        } else {
            return $this->expiration instanceof \DateTime ? $this->expiration->format($format) : null;
        }
    }

    /**
     * Set the value of [patient_id] column.
     *
     * @param int $v new value
     * @return $this|\MocApi\Models\HealthInsuranceCard The current object (for fluent API support)
     */
    public function setPatientId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->patient_id !== $v) {
            $this->patient_id = $v;
            $this->modifiedColumns[HealthInsuranceCardTableMap::COL_PATIENT_ID] = true;
        }

        if ($this->aPatient !== null && $this->aPatient->getPersonId() !== $v) {
            $this->aPatient = null;
        }

        return $this;
    } // setPatientId()

    /**
     * Set the value of [health_insurance_id] column.
     *
     * @param int $v new value
     * @return $this|\MocApi\Models\HealthInsuranceCard The current object (for fluent API support)
     */
    public function setHealthInsuranceId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->health_insurance_id !== $v) {
            $this->health_insurance_id = $v;
            $this->modifiedColumns[HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID] = true;
        }

        if ($this->aHealthInsurance !== null && $this->aHealthInsurance->getId() !== $v) {
            $this->aHealthInsurance = null;
        }

        return $this;
    } // setHealthInsuranceId()

    /**
     * Set the value of [number] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\HealthInsuranceCard The current object (for fluent API support)
     */
    public function setNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->number !== $v) {
            $this->number = $v;
            $this->modifiedColumns[HealthInsuranceCardTableMap::COL_NUMBER] = true;
        }

        return $this;
    } // setNumber()

    /**
     * Sets the value of [expiration] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\MocApi\Models\HealthInsuranceCard The current object (for fluent API support)
     */
    public function setExpiration($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->expiration !== null || $dt !== null) {
            if ($this->expiration === null || $dt === null || $dt->format("Y-m-d") !== $this->expiration->format("Y-m-d")) {
                $this->expiration = $dt === null ? null : clone $dt;
                $this->modifiedColumns[HealthInsuranceCardTableMap::COL_EXPIRATION] = true;
            }
        } // if either are not null

        return $this;
    } // setExpiration()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : HealthInsuranceCardTableMap::translateFieldName('PatientId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->patient_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : HealthInsuranceCardTableMap::translateFieldName('HealthInsuranceId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->health_insurance_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : HealthInsuranceCardTableMap::translateFieldName('Number', TableMap::TYPE_PHPNAME, $indexType)];
            $this->number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : HealthInsuranceCardTableMap::translateFieldName('Expiration', TableMap::TYPE_PHPNAME, $indexType)];
            $this->expiration = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = HealthInsuranceCardTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MocApi\\Models\\HealthInsuranceCard'), 0, $e);
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
        if ($this->aPatient !== null && $this->patient_id !== $this->aPatient->getPersonId()) {
            $this->aPatient = null;
        }
        if ($this->aHealthInsurance !== null && $this->health_insurance_id !== $this->aHealthInsurance->getId()) {
            $this->aHealthInsurance = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(HealthInsuranceCardTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildHealthInsuranceCardQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPatient = null;
            $this->aHealthInsurance = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see HealthInsuranceCard::setDeleted()
     * @see HealthInsuranceCard::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(HealthInsuranceCardTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildHealthInsuranceCardQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(HealthInsuranceCardTableMap::DATABASE_NAME);
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
                HealthInsuranceCardTableMap::addInstanceToPool($this);
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

            if ($this->aPatient !== null) {
                if ($this->aPatient->isModified() || $this->aPatient->isNew()) {
                    $affectedRows += $this->aPatient->save($con);
                }
                $this->setPatient($this->aPatient);
            }

            if ($this->aHealthInsurance !== null) {
                if ($this->aHealthInsurance->isModified() || $this->aHealthInsurance->isNew()) {
                    $affectedRows += $this->aHealthInsurance->save($con);
                }
                $this->setHealthInsurance($this->aHealthInsurance);
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
        if ($this->isColumnModified(HealthInsuranceCardTableMap::COL_PATIENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'patient_id';
        }
        if ($this->isColumnModified(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'health_insurance_id';
        }
        if ($this->isColumnModified(HealthInsuranceCardTableMap::COL_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'number';
        }
        if ($this->isColumnModified(HealthInsuranceCardTableMap::COL_EXPIRATION)) {
            $modifiedColumns[':p' . $index++]  = 'expiration';
        }

        $sql = sprintf(
            'INSERT INTO moc.health_insurance_card (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'patient_id':
                        $stmt->bindValue($identifier, $this->patient_id, PDO::PARAM_INT);
                        break;
                    case 'health_insurance_id':
                        $stmt->bindValue($identifier, $this->health_insurance_id, PDO::PARAM_INT);
                        break;
                    case 'number':
                        $stmt->bindValue($identifier, $this->number, PDO::PARAM_STR);
                        break;
                    case 'expiration':
                        $stmt->bindValue($identifier, $this->expiration ? $this->expiration->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $pos = HealthInsuranceCardTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPatientId();
                break;
            case 1:
                return $this->getHealthInsuranceId();
                break;
            case 2:
                return $this->getNumber();
                break;
            case 3:
                return $this->getExpiration();
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

        if (isset($alreadyDumpedObjects['HealthInsuranceCard'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['HealthInsuranceCard'][$this->hashCode()] = true;
        $keys = HealthInsuranceCardTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getPatientId(),
            $keys[1] => $this->getHealthInsuranceId(),
            $keys[2] => $this->getNumber(),
            $keys[3] => $this->getExpiration(),
        );
        if ($result[$keys[3]] instanceof \DateTime) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPatient) {

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

                $result[$key] = $this->aPatient->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aHealthInsurance) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'healthInsurance';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.health_insurance';
                        break;
                    default:
                        $key = 'HealthInsurance';
                }

                $result[$key] = $this->aHealthInsurance->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\MocApi\Models\HealthInsuranceCard
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = HealthInsuranceCardTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MocApi\Models\HealthInsuranceCard
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setPatientId($value);
                break;
            case 1:
                $this->setHealthInsuranceId($value);
                break;
            case 2:
                $this->setNumber($value);
                break;
            case 3:
                $this->setExpiration($value);
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
        $keys = HealthInsuranceCardTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setPatientId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setHealthInsuranceId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNumber($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setExpiration($arr[$keys[3]]);
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
     * @return $this|\MocApi\Models\HealthInsuranceCard The current object, for fluid interface
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
        $criteria = new Criteria(HealthInsuranceCardTableMap::DATABASE_NAME);

        if ($this->isColumnModified(HealthInsuranceCardTableMap::COL_PATIENT_ID)) {
            $criteria->add(HealthInsuranceCardTableMap::COL_PATIENT_ID, $this->patient_id);
        }
        if ($this->isColumnModified(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID)) {
            $criteria->add(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID, $this->health_insurance_id);
        }
        if ($this->isColumnModified(HealthInsuranceCardTableMap::COL_NUMBER)) {
            $criteria->add(HealthInsuranceCardTableMap::COL_NUMBER, $this->number);
        }
        if ($this->isColumnModified(HealthInsuranceCardTableMap::COL_EXPIRATION)) {
            $criteria->add(HealthInsuranceCardTableMap::COL_EXPIRATION, $this->expiration);
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
        $criteria = ChildHealthInsuranceCardQuery::create();
        $criteria->add(HealthInsuranceCardTableMap::COL_PATIENT_ID, $this->patient_id);
        $criteria->add(HealthInsuranceCardTableMap::COL_HEALTH_INSURANCE_ID, $this->health_insurance_id);

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
        $validPk = null !== $this->getPatientId() &&
            null !== $this->getHealthInsuranceId();

        $validPrimaryKeyFKs = 2;
        $primaryKeyFKs = [];

        //relation health_insurance_card_patient_id_fkey to table moc.patient
        if ($this->aPatient && $hash = spl_object_hash($this->aPatient)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        //relation health_insurance_card_health_insurance_id_fkey to table moc.health_insurance
        if ($this->aHealthInsurance && $hash = spl_object_hash($this->aHealthInsurance)) {
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
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getPatientId();
        $pks[1] = $this->getHealthInsuranceId();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setPatientId($keys[0]);
        $this->setHealthInsuranceId($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getPatientId()) && (null === $this->getHealthInsuranceId());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \MocApi\Models\HealthInsuranceCard (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPatientId($this->getPatientId());
        $copyObj->setHealthInsuranceId($this->getHealthInsuranceId());
        $copyObj->setNumber($this->getNumber());
        $copyObj->setExpiration($this->getExpiration());
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
     * @return \MocApi\Models\HealthInsuranceCard Clone of current object.
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
     * Declares an association between this object and a ChildPatient object.
     *
     * @param  ChildPatient $v
     * @return $this|\MocApi\Models\HealthInsuranceCard The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPatient(ChildPatient $v = null)
    {
        if ($v === null) {
            $this->setPatientId(NULL);
        } else {
            $this->setPatientId($v->getPersonId());
        }

        $this->aPatient = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPatient object, it will not be re-added.
        if ($v !== null) {
            $v->addHealthInsuranceCard($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPatient object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPatient The associated ChildPatient object.
     * @throws PropelException
     */
    public function getPatient(ConnectionInterface $con = null)
    {
        if ($this->aPatient === null && ($this->patient_id !== null)) {
            $this->aPatient = ChildPatientQuery::create()->findPk($this->patient_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPatient->addHealthInsuranceCards($this);
             */
        }

        return $this->aPatient;
    }

    /**
     * Declares an association between this object and a ChildHealthInsurance object.
     *
     * @param  ChildHealthInsurance $v
     * @return $this|\MocApi\Models\HealthInsuranceCard The current object (for fluent API support)
     * @throws PropelException
     */
    public function setHealthInsurance(ChildHealthInsurance $v = null)
    {
        if ($v === null) {
            $this->setHealthInsuranceId(NULL);
        } else {
            $this->setHealthInsuranceId($v->getId());
        }

        $this->aHealthInsurance = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildHealthInsurance object, it will not be re-added.
        if ($v !== null) {
            $v->addHealthInsuranceCard($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildHealthInsurance object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildHealthInsurance The associated ChildHealthInsurance object.
     * @throws PropelException
     */
    public function getHealthInsurance(ConnectionInterface $con = null)
    {
        if ($this->aHealthInsurance === null && ($this->health_insurance_id !== null)) {
            $this->aHealthInsurance = ChildHealthInsuranceQuery::create()->findPk($this->health_insurance_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aHealthInsurance->addHealthInsuranceCards($this);
             */
        }

        return $this->aHealthInsurance;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPatient) {
            $this->aPatient->removeHealthInsuranceCard($this);
        }
        if (null !== $this->aHealthInsurance) {
            $this->aHealthInsurance->removeHealthInsuranceCard($this);
        }
        $this->patient_id = null;
        $this->health_insurance_id = null;
        $this->number = null;
        $this->expiration = null;
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
        } // if ($deep)

        $this->aPatient = null;
        $this->aHealthInsurance = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(HealthInsuranceCardTableMap::DEFAULT_STRING_FORMAT);
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
