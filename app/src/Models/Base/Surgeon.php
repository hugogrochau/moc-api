<?php

namespace MocApi\Models\Base;

use \Exception;
use \PDO;
use MocApi\Models\Address as ChildAddress;
use MocApi\Models\AddressQuery as ChildAddressQuery;
use MocApi\Models\MedicalStaff as ChildMedicalStaff;
use MocApi\Models\MedicalStaffQuery as ChildMedicalStaffQuery;
use MocApi\Models\Person as ChildPerson;
use MocApi\Models\PersonQuery as ChildPersonQuery;
use MocApi\Models\Surgeon as ChildSurgeon;
use MocApi\Models\SurgeonQuery as ChildSurgeonQuery;
use MocApi\Models\SurgeonSurgery as ChildSurgeonSurgery;
use MocApi\Models\SurgeonSurgeryQuery as ChildSurgeonSurgeryQuery;
use MocApi\Models\Surgery as ChildSurgery;
use MocApi\Models\SurgeryQuery as ChildSurgeryQuery;
use MocApi\Models\Map\SurgeonTableMap;
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
 * Base class that represents a row from the 'moc.surgeon' table.
 *
 *
 *
* @package    propel.generator.MocApi.Models.Base
*/
abstract class Surgeon implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\MocApi\\Models\\Map\\SurgeonTableMap';


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
     * The value for the specialty field.
     *
     * @var        string
     */
    protected $specialty;

    /**
     * The value for the crm field.
     *
     * @var        string
     */
    protected $crm;

    /**
     * The value for the crmuf field.
     *
     * @var        string
     */
    protected $crmuf;

    /**
     * @var        ChildPerson
     */
    protected $aPerson;

    /**
     * @var        ObjectCollection|ChildAddress[] Collection to store aggregation of ChildAddress objects.
     */
    protected $collAddresses;
    protected $collAddressesPartial;

    /**
     * @var        ObjectCollection|ChildSurgeonSurgery[] Collection to store aggregation of ChildSurgeonSurgery objects.
     */
    protected $collSurgeonSurgeries;
    protected $collSurgeonSurgeriesPartial;

    /**
     * @var        ObjectCollection|ChildMedicalStaff[] Collection to store aggregation of ChildMedicalStaff objects.
     */
    protected $collMedicalStaffs;
    protected $collMedicalStaffsPartial;

    /**
     * @var        ObjectCollection|ChildSurgery[] Cross Collection to store aggregation of ChildSurgery objects.
     */
    protected $collSurgeries;

    /**
     * @var bool
     */
    protected $collSurgeriesPartial;

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
     * @var ObjectCollection|ChildAddress[]
     */
    protected $addressesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSurgeonSurgery[]
     */
    protected $surgeonSurgeriesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMedicalStaff[]
     */
    protected $medicalStaffsScheduledForDeletion = null;

    /**
     * Initializes internal state of MocApi\Models\Base\Surgeon object.
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
     * Compares this with another <code>Surgeon</code> instance.  If
     * <code>obj</code> is an instance of <code>Surgeon</code>, delegates to
     * <code>equals(Surgeon)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Surgeon The current object, for fluid interface
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
     * Get the [specialty] column value.
     *
     * @return string
     */
    public function getSpecialty()
    {
        return $this->specialty;
    }

    /**
     * Get the [crm] column value.
     *
     * @return string
     */
    public function getCRM()
    {
        return $this->crm;
    }

    /**
     * Get the [crmuf] column value.
     *
     * @return string
     */
    public function getCRMUF()
    {
        return $this->crmuf;
    }

    /**
     * Set the value of [person_id] column.
     *
     * @param int $v new value
     * @return $this|\MocApi\Models\Surgeon The current object (for fluent API support)
     */
    public function setPersonId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->person_id !== $v) {
            $this->person_id = $v;
            $this->modifiedColumns[SurgeonTableMap::COL_PERSON_ID] = true;
        }

        if ($this->aPerson !== null && $this->aPerson->getId() !== $v) {
            $this->aPerson = null;
        }

        return $this;
    } // setPersonId()

    /**
     * Set the value of [specialty] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Surgeon The current object (for fluent API support)
     */
    public function setSpecialty($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->specialty !== $v) {
            $this->specialty = $v;
            $this->modifiedColumns[SurgeonTableMap::COL_SPECIALTY] = true;
        }

        return $this;
    } // setSpecialty()

    /**
     * Set the value of [crm] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Surgeon The current object (for fluent API support)
     */
    public function setCRM($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->crm !== $v) {
            $this->crm = $v;
            $this->modifiedColumns[SurgeonTableMap::COL_CRM] = true;
        }

        return $this;
    } // setCRM()

    /**
     * Set the value of [crmuf] column.
     *
     * @param string $v new value
     * @return $this|\MocApi\Models\Surgeon The current object (for fluent API support)
     */
    public function setCRMUF($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->crmuf !== $v) {
            $this->crmuf = $v;
            $this->modifiedColumns[SurgeonTableMap::COL_CRMUF] = true;
        }

        return $this;
    } // setCRMUF()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SurgeonTableMap::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->person_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SurgeonTableMap::translateFieldName('Specialty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->specialty = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SurgeonTableMap::translateFieldName('CRM', TableMap::TYPE_PHPNAME, $indexType)];
            $this->crm = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SurgeonTableMap::translateFieldName('CRMUF', TableMap::TYPE_PHPNAME, $indexType)];
            $this->crmuf = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = SurgeonTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\MocApi\\Models\\Surgeon'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(SurgeonTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSurgeonQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPerson = null;
            $this->collAddresses = null;

            $this->collSurgeonSurgeries = null;

            $this->collMedicalStaffs = null;

            $this->collSurgeries = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Surgeon::setDeleted()
     * @see Surgeon::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeonTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSurgeonQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SurgeonTableMap::DATABASE_NAME);
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
                SurgeonTableMap::addInstanceToPool($this);
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

                        $entryPk[0] = $this->getPersonId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \MocApi\Models\SurgeonSurgeryQuery::create()
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


            if ($this->addressesScheduledForDeletion !== null) {
                if (!$this->addressesScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\AddressQuery::create()
                        ->filterByPrimaryKeys($this->addressesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->addressesScheduledForDeletion = null;
                }
            }

            if ($this->collAddresses !== null) {
                foreach ($this->collAddresses as $referrerFK) {
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

            if ($this->medicalStaffsScheduledForDeletion !== null) {
                if (!$this->medicalStaffsScheduledForDeletion->isEmpty()) {
                    \MocApi\Models\MedicalStaffQuery::create()
                        ->filterByPrimaryKeys($this->medicalStaffsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->medicalStaffsScheduledForDeletion = null;
                }
            }

            if ($this->collMedicalStaffs !== null) {
                foreach ($this->collMedicalStaffs as $referrerFK) {
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
        if ($this->isColumnModified(SurgeonTableMap::COL_PERSON_ID)) {
            $modifiedColumns[':p' . $index++]  = 'person_id';
        }
        if ($this->isColumnModified(SurgeonTableMap::COL_SPECIALTY)) {
            $modifiedColumns[':p' . $index++]  = 'specialty';
        }
        if ($this->isColumnModified(SurgeonTableMap::COL_CRM)) {
            $modifiedColumns[':p' . $index++]  = 'CRM';
        }
        if ($this->isColumnModified(SurgeonTableMap::COL_CRMUF)) {
            $modifiedColumns[':p' . $index++]  = 'CRMUF';
        }

        $sql = sprintf(
            'INSERT INTO moc.surgeon (%s) VALUES (%s)',
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
                    case 'specialty':
                        $stmt->bindValue($identifier, $this->specialty, PDO::PARAM_STR);
                        break;
                    case 'CRM':
                        $stmt->bindValue($identifier, $this->crm, PDO::PARAM_STR);
                        break;
                    case 'CRMUF':
                        $stmt->bindValue($identifier, $this->crmuf, PDO::PARAM_STR);
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
        $pos = SurgeonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getSpecialty();
                break;
            case 2:
                return $this->getCRM();
                break;
            case 3:
                return $this->getCRMUF();
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

        if (isset($alreadyDumpedObjects['Surgeon'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Surgeon'][$this->hashCode()] = true;
        $keys = SurgeonTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getPersonId(),
            $keys[1] => $this->getSpecialty(),
            $keys[2] => $this->getCRM(),
            $keys[3] => $this->getCRMUF(),
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
            if (null !== $this->collAddresses) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'addresses';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.addresses';
                        break;
                    default:
                        $key = 'Addresses';
                }

                $result[$key] = $this->collAddresses->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collMedicalStaffs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'medicalStaffs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'moc.medical_staffs';
                        break;
                    default:
                        $key = 'MedicalStaffs';
                }

                $result[$key] = $this->collMedicalStaffs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\MocApi\Models\Surgeon
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SurgeonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\MocApi\Models\Surgeon
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setPersonId($value);
                break;
            case 1:
                $this->setSpecialty($value);
                break;
            case 2:
                $this->setCRM($value);
                break;
            case 3:
                $this->setCRMUF($value);
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
        $keys = SurgeonTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setPersonId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setSpecialty($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCRM($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCRMUF($arr[$keys[3]]);
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
     * @return $this|\MocApi\Models\Surgeon The current object, for fluid interface
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
        $criteria = new Criteria(SurgeonTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SurgeonTableMap::COL_PERSON_ID)) {
            $criteria->add(SurgeonTableMap::COL_PERSON_ID, $this->person_id);
        }
        if ($this->isColumnModified(SurgeonTableMap::COL_SPECIALTY)) {
            $criteria->add(SurgeonTableMap::COL_SPECIALTY, $this->specialty);
        }
        if ($this->isColumnModified(SurgeonTableMap::COL_CRM)) {
            $criteria->add(SurgeonTableMap::COL_CRM, $this->crm);
        }
        if ($this->isColumnModified(SurgeonTableMap::COL_CRMUF)) {
            $criteria->add(SurgeonTableMap::COL_CRMUF, $this->crmuf);
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
        $criteria = ChildSurgeonQuery::create();
        $criteria->add(SurgeonTableMap::COL_PERSON_ID, $this->person_id);

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

        //relation surgeon_person_id_fkey to table moc.person
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
     * @param      object $copyObj An object of \MocApi\Models\Surgeon (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPersonId($this->getPersonId());
        $copyObj->setSpecialty($this->getSpecialty());
        $copyObj->setCRM($this->getCRM());
        $copyObj->setCRMUF($this->getCRMUF());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAddresses() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAddress($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSurgeonSurgeries() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSurgeonSurgery($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMedicalStaffs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMedicalStaff($relObj->copy($deepCopy));
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
     * @return \MocApi\Models\Surgeon Clone of current object.
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
     * @return $this|\MocApi\Models\Surgeon The current object (for fluent API support)
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
            $v->setSurgeon($this);
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
            $this->aPerson->setSurgeon($this);
        }

        return $this->aPerson;
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
        if ('Address' == $relationName) {
            return $this->initAddresses();
        }
        if ('SurgeonSurgery' == $relationName) {
            return $this->initSurgeonSurgeries();
        }
        if ('MedicalStaff' == $relationName) {
            return $this->initMedicalStaffs();
        }
    }

    /**
     * Clears out the collAddresses collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAddresses()
     */
    public function clearAddresses()
    {
        $this->collAddresses = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAddresses collection loaded partially.
     */
    public function resetPartialAddresses($v = true)
    {
        $this->collAddressesPartial = $v;
    }

    /**
     * Initializes the collAddresses collection.
     *
     * By default this just sets the collAddresses collection to an empty array (like clearcollAddresses());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAddresses($overrideExisting = true)
    {
        if (null !== $this->collAddresses && !$overrideExisting) {
            return;
        }
        $this->collAddresses = new ObjectCollection();
        $this->collAddresses->setModel('\MocApi\Models\Address');
    }

    /**
     * Gets an array of ChildAddress objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgeon is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAddress[] List of ChildAddress objects
     * @throws PropelException
     */
    public function getAddresses(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAddressesPartial && !$this->isNew();
        if (null === $this->collAddresses || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAddresses) {
                // return empty collection
                $this->initAddresses();
            } else {
                $collAddresses = ChildAddressQuery::create(null, $criteria)
                    ->filterBySurgeon($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAddressesPartial && count($collAddresses)) {
                        $this->initAddresses(false);

                        foreach ($collAddresses as $obj) {
                            if (false == $this->collAddresses->contains($obj)) {
                                $this->collAddresses->append($obj);
                            }
                        }

                        $this->collAddressesPartial = true;
                    }

                    return $collAddresses;
                }

                if ($partial && $this->collAddresses) {
                    foreach ($this->collAddresses as $obj) {
                        if ($obj->isNew()) {
                            $collAddresses[] = $obj;
                        }
                    }
                }

                $this->collAddresses = $collAddresses;
                $this->collAddressesPartial = false;
            }
        }

        return $this->collAddresses;
    }

    /**
     * Sets a collection of ChildAddress objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $addresses A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgeon The current object (for fluent API support)
     */
    public function setAddresses(Collection $addresses, ConnectionInterface $con = null)
    {
        /** @var ChildAddress[] $addressesToDelete */
        $addressesToDelete = $this->getAddresses(new Criteria(), $con)->diff($addresses);


        $this->addressesScheduledForDeletion = $addressesToDelete;

        foreach ($addressesToDelete as $addressRemoved) {
            $addressRemoved->setSurgeon(null);
        }

        $this->collAddresses = null;
        foreach ($addresses as $address) {
            $this->addAddress($address);
        }

        $this->collAddresses = $addresses;
        $this->collAddressesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Address objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Address objects.
     * @throws PropelException
     */
    public function countAddresses(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAddressesPartial && !$this->isNew();
        if (null === $this->collAddresses || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAddresses) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAddresses());
            }

            $query = ChildAddressQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySurgeon($this)
                ->count($con);
        }

        return count($this->collAddresses);
    }

    /**
     * Method called to associate a ChildAddress object to this object
     * through the ChildAddress foreign key attribute.
     *
     * @param  ChildAddress $l ChildAddress
     * @return $this|\MocApi\Models\Surgeon The current object (for fluent API support)
     */
    public function addAddress(ChildAddress $l)
    {
        if ($this->collAddresses === null) {
            $this->initAddresses();
            $this->collAddressesPartial = true;
        }

        if (!$this->collAddresses->contains($l)) {
            $this->doAddAddress($l);
        }

        return $this;
    }

    /**
     * @param ChildAddress $address The ChildAddress object to add.
     */
    protected function doAddAddress(ChildAddress $address)
    {
        $this->collAddresses[]= $address;
        $address->setSurgeon($this);
    }

    /**
     * @param  ChildAddress $address The ChildAddress object to remove.
     * @return $this|ChildSurgeon The current object (for fluent API support)
     */
    public function removeAddress(ChildAddress $address)
    {
        if ($this->getAddresses()->contains($address)) {
            $pos = $this->collAddresses->search($address);
            $this->collAddresses->remove($pos);
            if (null === $this->addressesScheduledForDeletion) {
                $this->addressesScheduledForDeletion = clone $this->collAddresses;
                $this->addressesScheduledForDeletion->clear();
            }
            $this->addressesScheduledForDeletion[]= clone $address;
            $address->setSurgeon(null);
        }

        return $this;
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
     * If this ChildSurgeon is new, it will return
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
                    ->filterBySurgeon($this)
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
     * @return $this|ChildSurgeon The current object (for fluent API support)
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
            $surgeonSurgeryRemoved->setSurgeon(null);
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
                ->filterBySurgeon($this)
                ->count($con);
        }

        return count($this->collSurgeonSurgeries);
    }

    /**
     * Method called to associate a ChildSurgeonSurgery object to this object
     * through the ChildSurgeonSurgery foreign key attribute.
     *
     * @param  ChildSurgeonSurgery $l ChildSurgeonSurgery
     * @return $this|\MocApi\Models\Surgeon The current object (for fluent API support)
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
        $surgeonSurgery->setSurgeon($this);
    }

    /**
     * @param  ChildSurgeonSurgery $surgeonSurgery The ChildSurgeonSurgery object to remove.
     * @return $this|ChildSurgeon The current object (for fluent API support)
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
            $surgeonSurgery->setSurgeon(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Surgeon is new, it will return
     * an empty collection; or if this Surgeon has previously
     * been saved, it will retrieve related SurgeonSurgeries from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Surgeon.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSurgeonSurgery[] List of ChildSurgeonSurgery objects
     */
    public function getSurgeonSurgeriesJoinSurgery(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSurgeonSurgeryQuery::create(null, $criteria);
        $query->joinWith('Surgery', $joinBehavior);

        return $this->getSurgeonSurgeries($query, $con);
    }

    /**
     * Clears out the collMedicalStaffs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMedicalStaffs()
     */
    public function clearMedicalStaffs()
    {
        $this->collMedicalStaffs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMedicalStaffs collection loaded partially.
     */
    public function resetPartialMedicalStaffs($v = true)
    {
        $this->collMedicalStaffsPartial = $v;
    }

    /**
     * Initializes the collMedicalStaffs collection.
     *
     * By default this just sets the collMedicalStaffs collection to an empty array (like clearcollMedicalStaffs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMedicalStaffs($overrideExisting = true)
    {
        if (null !== $this->collMedicalStaffs && !$overrideExisting) {
            return;
        }
        $this->collMedicalStaffs = new ObjectCollection();
        $this->collMedicalStaffs->setModel('\MocApi\Models\MedicalStaff');
    }

    /**
     * Gets an array of ChildMedicalStaff objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgeon is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMedicalStaff[] List of ChildMedicalStaff objects
     * @throws PropelException
     */
    public function getMedicalStaffs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMedicalStaffsPartial && !$this->isNew();
        if (null === $this->collMedicalStaffs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMedicalStaffs) {
                // return empty collection
                $this->initMedicalStaffs();
            } else {
                $collMedicalStaffs = ChildMedicalStaffQuery::create(null, $criteria)
                    ->filterBySurgeon($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMedicalStaffsPartial && count($collMedicalStaffs)) {
                        $this->initMedicalStaffs(false);

                        foreach ($collMedicalStaffs as $obj) {
                            if (false == $this->collMedicalStaffs->contains($obj)) {
                                $this->collMedicalStaffs->append($obj);
                            }
                        }

                        $this->collMedicalStaffsPartial = true;
                    }

                    return $collMedicalStaffs;
                }

                if ($partial && $this->collMedicalStaffs) {
                    foreach ($this->collMedicalStaffs as $obj) {
                        if ($obj->isNew()) {
                            $collMedicalStaffs[] = $obj;
                        }
                    }
                }

                $this->collMedicalStaffs = $collMedicalStaffs;
                $this->collMedicalStaffsPartial = false;
            }
        }

        return $this->collMedicalStaffs;
    }

    /**
     * Sets a collection of ChildMedicalStaff objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $medicalStaffs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgeon The current object (for fluent API support)
     */
    public function setMedicalStaffs(Collection $medicalStaffs, ConnectionInterface $con = null)
    {
        /** @var ChildMedicalStaff[] $medicalStaffsToDelete */
        $medicalStaffsToDelete = $this->getMedicalStaffs(new Criteria(), $con)->diff($medicalStaffs);


        $this->medicalStaffsScheduledForDeletion = $medicalStaffsToDelete;

        foreach ($medicalStaffsToDelete as $medicalStaffRemoved) {
            $medicalStaffRemoved->setSurgeon(null);
        }

        $this->collMedicalStaffs = null;
        foreach ($medicalStaffs as $medicalStaff) {
            $this->addMedicalStaff($medicalStaff);
        }

        $this->collMedicalStaffs = $medicalStaffs;
        $this->collMedicalStaffsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MedicalStaff objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related MedicalStaff objects.
     * @throws PropelException
     */
    public function countMedicalStaffs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMedicalStaffsPartial && !$this->isNew();
        if (null === $this->collMedicalStaffs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMedicalStaffs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMedicalStaffs());
            }

            $query = ChildMedicalStaffQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySurgeon($this)
                ->count($con);
        }

        return count($this->collMedicalStaffs);
    }

    /**
     * Method called to associate a ChildMedicalStaff object to this object
     * through the ChildMedicalStaff foreign key attribute.
     *
     * @param  ChildMedicalStaff $l ChildMedicalStaff
     * @return $this|\MocApi\Models\Surgeon The current object (for fluent API support)
     */
    public function addMedicalStaff(ChildMedicalStaff $l)
    {
        if ($this->collMedicalStaffs === null) {
            $this->initMedicalStaffs();
            $this->collMedicalStaffsPartial = true;
        }

        if (!$this->collMedicalStaffs->contains($l)) {
            $this->doAddMedicalStaff($l);
        }

        return $this;
    }

    /**
     * @param ChildMedicalStaff $medicalStaff The ChildMedicalStaff object to add.
     */
    protected function doAddMedicalStaff(ChildMedicalStaff $medicalStaff)
    {
        $this->collMedicalStaffs[]= $medicalStaff;
        $medicalStaff->setSurgeon($this);
    }

    /**
     * @param  ChildMedicalStaff $medicalStaff The ChildMedicalStaff object to remove.
     * @return $this|ChildSurgeon The current object (for fluent API support)
     */
    public function removeMedicalStaff(ChildMedicalStaff $medicalStaff)
    {
        if ($this->getMedicalStaffs()->contains($medicalStaff)) {
            $pos = $this->collMedicalStaffs->search($medicalStaff);
            $this->collMedicalStaffs->remove($pos);
            if (null === $this->medicalStaffsScheduledForDeletion) {
                $this->medicalStaffsScheduledForDeletion = clone $this->collMedicalStaffs;
                $this->medicalStaffsScheduledForDeletion->clear();
            }
            $this->medicalStaffsScheduledForDeletion[]= clone $medicalStaff;
            $medicalStaff->setSurgeon(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Surgeon is new, it will return
     * an empty collection; or if this Surgeon has previously
     * been saved, it will retrieve related MedicalStaffs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Surgeon.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMedicalStaff[] List of ChildMedicalStaff objects
     */
    public function getMedicalStaffsJoinPerson(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMedicalStaffQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getMedicalStaffs($query, $con);
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
     * to the current object by way of the moc.surgeon_surgery cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSurgeon is new, it will return
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
                    ->filterBySurgeon($this);
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
     * to the current object by way of the moc.surgeon_surgery cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $surgeries A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildSurgeon The current object (for fluent API support)
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
     * to the current object by way of the moc.surgeon_surgery cross-reference table.
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
                    ->filterBySurgeon($this)
                    ->count($con);
            }
        } else {
            return count($this->collSurgeries);
        }
    }

    /**
     * Associate a ChildSurgery to this object
     * through the moc.surgeon_surgery cross reference table.
     *
     * @param ChildSurgery $surgery
     * @return ChildSurgeon The current object (for fluent API support)
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
        $surgeonSurgery = new ChildSurgeonSurgery();

        $surgeonSurgery->setSurgery($surgery);

        $surgeonSurgery->setSurgeon($this);

        $this->addSurgeonSurgery($surgeonSurgery);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$surgery->isSurgeonsLoaded()) {
            $surgery->initSurgeons();
            $surgery->getSurgeons()->push($this);
        } elseif (!$surgery->getSurgeons()->contains($this)) {
            $surgery->getSurgeons()->push($this);
        }

    }

    /**
     * Remove surgery of this object
     * through the moc.surgeon_surgery cross reference table.
     *
     * @param ChildSurgery $surgery
     * @return ChildSurgeon The current object (for fluent API support)
     */
    public function removeSurgery(ChildSurgery $surgery)
    {
        if ($this->getSurgeries()->contains($surgery)) { $surgeonSurgery = new ChildSurgeonSurgery();

            $surgeonSurgery->setSurgery($surgery);
            if ($surgery->isSurgeonsLoaded()) {
                //remove the back reference if available
                $surgery->getSurgeons()->removeObject($this);
            }

            $surgeonSurgery->setSurgeon($this);
            $this->removeSurgeonSurgery(clone $surgeonSurgery);
            $surgeonSurgery->clear();

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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPerson) {
            $this->aPerson->removeSurgeon($this);
        }
        $this->person_id = null;
        $this->specialty = null;
        $this->crm = null;
        $this->crmuf = null;
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
            if ($this->collAddresses) {
                foreach ($this->collAddresses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSurgeonSurgeries) {
                foreach ($this->collSurgeonSurgeries as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMedicalStaffs) {
                foreach ($this->collMedicalStaffs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSurgeries) {
                foreach ($this->collSurgeries as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAddresses = null;
        $this->collSurgeonSurgeries = null;
        $this->collMedicalStaffs = null;
        $this->collSurgeries = null;
        $this->aPerson = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SurgeonTableMap::DEFAULT_STRING_FORMAT);
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
