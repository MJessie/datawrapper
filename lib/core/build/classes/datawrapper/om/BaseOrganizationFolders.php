<?php


/**
 * Base class that represents a row from the 'organization_folders' table.
 *
 *
 *
 * @package    propel.generator.datawrapper.om
 */
abstract class BaseOrganizationFolders extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'OrganizationFoldersPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        OrganizationFoldersPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the of_id field.
     * @var        int
     */
    protected $of_id;

    /**
     * The value for the org_id field.
     * @var        string
     */
    protected $org_id;

    /**
     * The value for the folder_name field.
     * @var        string
     */
    protected $folder_name;

    /**
     * The value for the parent_id field.
     * @var        int
     */
    protected $parent_id;

    /**
     * @var        Organization
     */
    protected $aOrganization;

    /**
     * @var        PropelObjectCollection|ChartFolders[] Collection to store aggregation of ChartFolders objects.
     */
    protected $collChartFolderss;
    protected $collChartFolderssPartial;

    /**
     * @var        PropelObjectCollection|Chart[] Collection to store aggregation of Chart objects.
     */
    protected $collCharts;

    /**
     * @var        PropelObjectCollection|UserFolders[] Collection to store aggregation of UserFolders objects.
     */
    protected $collUserFolderss;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $chartsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $userFolderssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $chartFolderssScheduledForDeletion = null;

    /**
     * Get the [of_id] column value.
     *
     * @return int
     */
    public function getOfId()
    {
        return $this->of_id;
    }

    /**
     * Get the [org_id] column value.
     *
     * @return string
     */
    public function getOrgId()
    {
        return $this->org_id;
    }

    /**
     * Get the [folder_name] column value.
     *
     * @return string
     */
    public function getFolderName()
    {
        return $this->folder_name;
    }

    /**
     * Get the [parent_id] column value.
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * Set the value of [of_id] column.
     *
     * @param int $v new value
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function setOfId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->of_id !== $v) {
            $this->of_id = $v;
            $this->modifiedColumns[] = OrganizationFoldersPeer::OF_ID;
        }


        return $this;
    } // setOfId()

    /**
     * Set the value of [org_id] column.
     *
     * @param string $v new value
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function setOrgId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->org_id !== $v) {
            $this->org_id = $v;
            $this->modifiedColumns[] = OrganizationFoldersPeer::ORG_ID;
        }

        if ($this->aOrganization !== null && $this->aOrganization->getId() !== $v) {
            $this->aOrganization = null;
        }


        return $this;
    } // setOrgId()

    /**
     * Set the value of [folder_name] column.
     *
     * @param string $v new value
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function setFolderName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->folder_name !== $v) {
            $this->folder_name = $v;
            $this->modifiedColumns[] = OrganizationFoldersPeer::FOLDER_NAME;
        }


        return $this;
    } // setFolderName()

    /**
     * Set the value of [parent_id] column.
     *
     * @param int $v new value
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function setParentId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->parent_id !== $v) {
            $this->parent_id = $v;
            $this->modifiedColumns[] = OrganizationFoldersPeer::PARENT_ID;
        }


        return $this;
    } // setParentId()

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
        // otherwise, everything was equal, so return true
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
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->of_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->org_id = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->folder_name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->parent_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 4; // 4 = OrganizationFoldersPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating OrganizationFolders object", $e);
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

        if ($this->aOrganization !== null && $this->org_id !== $this->aOrganization->getId()) {
            $this->aOrganization = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(OrganizationFoldersPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = OrganizationFoldersPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aOrganization = null;
            $this->collChartFolderss = null;

            $this->collCharts = null;
            $this->collUserFolderss = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(OrganizationFoldersPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = OrganizationFoldersQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(OrganizationFoldersPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
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
                OrganizationFoldersPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aOrganization !== null) {
                if ($this->aOrganization->isModified() || $this->aOrganization->isNew()) {
                    $affectedRows += $this->aOrganization->save($con);
                }
                $this->setOrganization($this->aOrganization);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->chartsScheduledForDeletion !== null) {
                if (!$this->chartsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->chartsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ChartFoldersQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->chartsScheduledForDeletion = null;
                }

                foreach ($this->getCharts() as $chart) {
                    if ($chart->isModified()) {
                        $chart->save($con);
                    }
                }
            } elseif ($this->collCharts) {
                foreach ($this->collCharts as $chart) {
                    if ($chart->isModified()) {
                        $chart->save($con);
                    }
                }
            }

            if ($this->userFolderssScheduledForDeletion !== null) {
                if (!$this->userFolderssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->userFolderssScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ChartFoldersQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->userFolderssScheduledForDeletion = null;
                }

                foreach ($this->getUserFolderss() as $userFolders) {
                    if ($userFolders->isModified()) {
                        $userFolders->save($con);
                    }
                }
            } elseif ($this->collUserFolderss) {
                foreach ($this->collUserFolderss as $userFolders) {
                    if ($userFolders->isModified()) {
                        $userFolders->save($con);
                    }
                }
            }

            if ($this->chartFolderssScheduledForDeletion !== null) {
                if (!$this->chartFolderssScheduledForDeletion->isEmpty()) {
                    foreach ($this->chartFolderssScheduledForDeletion as $chartFolders) {
                        // need to save related object because we set the relation to null
                        $chartFolders->save($con);
                    }
                    $this->chartFolderssScheduledForDeletion = null;
                }
            }

            if ($this->collChartFolderss !== null) {
                foreach ($this->collChartFolderss as $referrerFK) {
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
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = OrganizationFoldersPeer::OF_ID;
        if (null !== $this->of_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . OrganizationFoldersPeer::OF_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(OrganizationFoldersPeer::OF_ID)) {
            $modifiedColumns[':p' . $index++]  = '`of_id`';
        }
        if ($this->isColumnModified(OrganizationFoldersPeer::ORG_ID)) {
            $modifiedColumns[':p' . $index++]  = '`org_id`';
        }
        if ($this->isColumnModified(OrganizationFoldersPeer::FOLDER_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`folder_name`';
        }
        if ($this->isColumnModified(OrganizationFoldersPeer::PARENT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`parent_id`';
        }

        $sql = sprintf(
            'INSERT INTO `organization_folders` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`of_id`':
                        $stmt->bindValue($identifier, $this->of_id, PDO::PARAM_INT);
                        break;
                    case '`org_id`':
                        $stmt->bindValue($identifier, $this->org_id, PDO::PARAM_STR);
                        break;
                    case '`folder_name`':
                        $stmt->bindValue($identifier, $this->folder_name, PDO::PARAM_STR);
                        break;
                    case '`parent_id`':
                        $stmt->bindValue($identifier, $this->parent_id, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setOfId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aOrganization !== null) {
                if (!$this->aOrganization->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aOrganization->getValidationFailures());
                }
            }


            if (($retval = OrganizationFoldersPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collChartFolderss !== null) {
                    foreach ($this->collChartFolderss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = OrganizationFoldersPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getOfId();
                break;
            case 1:
                return $this->getOrgId();
                break;
            case 2:
                return $this->getFolderName();
                break;
            case 3:
                return $this->getParentId();
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
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['OrganizationFolders'][serialize($this->getPrimaryKey())])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['OrganizationFolders'][serialize($this->getPrimaryKey())] = true;
        $keys = OrganizationFoldersPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getOfId(),
            $keys[1] => $this->getOrgId(),
            $keys[2] => $this->getFolderName(),
            $keys[3] => $this->getParentId(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aOrganization) {
                $result['Organization'] = $this->aOrganization->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collChartFolderss) {
                $result['ChartFolderss'] = $this->collChartFolderss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = OrganizationFoldersPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setOfId($value);
                break;
            case 1:
                $this->setOrgId($value);
                break;
            case 2:
                $this->setFolderName($value);
                break;
            case 3:
                $this->setParentId($value);
                break;
        } // switch()
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
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = OrganizationFoldersPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setOfId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setOrgId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setFolderName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setParentId($arr[$keys[3]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(OrganizationFoldersPeer::DATABASE_NAME);

        if ($this->isColumnModified(OrganizationFoldersPeer::OF_ID)) $criteria->add(OrganizationFoldersPeer::OF_ID, $this->of_id);
        if ($this->isColumnModified(OrganizationFoldersPeer::ORG_ID)) $criteria->add(OrganizationFoldersPeer::ORG_ID, $this->org_id);
        if ($this->isColumnModified(OrganizationFoldersPeer::FOLDER_NAME)) $criteria->add(OrganizationFoldersPeer::FOLDER_NAME, $this->folder_name);
        if ($this->isColumnModified(OrganizationFoldersPeer::PARENT_ID)) $criteria->add(OrganizationFoldersPeer::PARENT_ID, $this->parent_id);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(OrganizationFoldersPeer::DATABASE_NAME);
        $criteria->add(OrganizationFoldersPeer::OF_ID, $this->of_id);
        $criteria->add(OrganizationFoldersPeer::PARENT_ID, $this->parent_id);

        return $criteria;
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getOfId();
        $pks[1] = $this->getParentId();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setOfId($keys[0]);
        $this->setParentId($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return (null === $this->getOfId()) && (null === $this->getParentId());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of OrganizationFolders (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setOrgId($this->getOrgId());
        $copyObj->setFolderName($this->getFolderName());
        $copyObj->setParentId($this->getParentId());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getChartFolderss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addChartFolders($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setOfId(NULL); // this is a auto-increment column, so set to default value
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
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return OrganizationFolders Clone of current object.
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
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return OrganizationFoldersPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new OrganizationFoldersPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Organization object.
     *
     * @param             Organization $v
     * @return OrganizationFolders The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrganization(Organization $v = null)
    {
        if ($v === null) {
            $this->setOrgId(NULL);
        } else {
            $this->setOrgId($v->getId());
        }

        $this->aOrganization = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Organization object, it will not be re-added.
        if ($v !== null) {
            $v->addOrganizationFolders($this);
        }


        return $this;
    }


    /**
     * Get the associated Organization object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Organization The associated Organization object.
     * @throws PropelException
     */
    public function getOrganization(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aOrganization === null && (($this->org_id !== "" && $this->org_id !== null)) && $doQuery) {
            $this->aOrganization = OrganizationQuery::create()->findPk($this->org_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrganization->addOrganizationFolderss($this);
             */
        }

        return $this->aOrganization;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ChartFolders' == $relationName) {
            $this->initChartFolderss();
        }
    }

    /**
     * Clears out the collChartFolderss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return OrganizationFolders The current object (for fluent API support)
     * @see        addChartFolderss()
     */
    public function clearChartFolderss()
    {
        $this->collChartFolderss = null; // important to set this to null since that means it is uninitialized
        $this->collChartFolderssPartial = null;

        return $this;
    }

    /**
     * reset is the collChartFolderss collection loaded partially
     *
     * @return void
     */
    public function resetPartialChartFolderss($v = true)
    {
        $this->collChartFolderssPartial = $v;
    }

    /**
     * Initializes the collChartFolderss collection.
     *
     * By default this just sets the collChartFolderss collection to an empty array (like clearcollChartFolderss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initChartFolderss($overrideExisting = true)
    {
        if (null !== $this->collChartFolderss && !$overrideExisting) {
            return;
        }
        $this->collChartFolderss = new PropelObjectCollection();
        $this->collChartFolderss->setModel('ChartFolders');
    }

    /**
     * Gets an array of ChartFolders objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this OrganizationFolders is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ChartFolders[] List of ChartFolders objects
     * @throws PropelException
     */
    public function getChartFolderss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collChartFolderssPartial && !$this->isNew();
        if (null === $this->collChartFolderss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collChartFolderss) {
                // return empty collection
                $this->initChartFolderss();
            } else {
                $collChartFolderss = ChartFoldersQuery::create(null, $criteria)
                    ->filterByOrganizationFolders($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collChartFolderssPartial && count($collChartFolderss)) {
                      $this->initChartFolderss(false);

                      foreach($collChartFolderss as $obj) {
                        if (false == $this->collChartFolderss->contains($obj)) {
                          $this->collChartFolderss->append($obj);
                        }
                      }

                      $this->collChartFolderssPartial = true;
                    }

                    $collChartFolderss->getInternalIterator()->rewind();
                    return $collChartFolderss;
                }

                if($partial && $this->collChartFolderss) {
                    foreach($this->collChartFolderss as $obj) {
                        if($obj->isNew()) {
                            $collChartFolderss[] = $obj;
                        }
                    }
                }

                $this->collChartFolderss = $collChartFolderss;
                $this->collChartFolderssPartial = false;
            }
        }

        return $this->collChartFolderss;
    }

    /**
     * Sets a collection of ChartFolders objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $chartFolderss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function setChartFolderss(PropelCollection $chartFolderss, PropelPDO $con = null)
    {
        $chartFolderssToDelete = $this->getChartFolderss(new Criteria(), $con)->diff($chartFolderss);

        $this->chartFolderssScheduledForDeletion = unserialize(serialize($chartFolderssToDelete));

        foreach ($chartFolderssToDelete as $chartFoldersRemoved) {
            $chartFoldersRemoved->setOrganizationFolders(null);
        }

        $this->collChartFolderss = null;
        foreach ($chartFolderss as $chartFolders) {
            $this->addChartFolders($chartFolders);
        }

        $this->collChartFolderss = $chartFolderss;
        $this->collChartFolderssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ChartFolders objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ChartFolders objects.
     * @throws PropelException
     */
    public function countChartFolderss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collChartFolderssPartial && !$this->isNew();
        if (null === $this->collChartFolderss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collChartFolderss) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getChartFolderss());
            }
            $query = ChartFoldersQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrganizationFolders($this)
                ->count($con);
        }

        return count($this->collChartFolderss);
    }

    /**
     * Method called to associate a ChartFolders object to this object
     * through the ChartFolders foreign key attribute.
     *
     * @param    ChartFolders $l ChartFolders
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function addChartFolders(ChartFolders $l)
    {
        if ($this->collChartFolderss === null) {
            $this->initChartFolderss();
            $this->collChartFolderssPartial = true;
        }
        if (!in_array($l, $this->collChartFolderss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddChartFolders($l);
        }

        return $this;
    }

    /**
     * @param	ChartFolders $chartFolders The chartFolders object to add.
     */
    protected function doAddChartFolders($chartFolders)
    {
        $this->collChartFolderss[]= $chartFolders;
        $chartFolders->setOrganizationFolders($this);
    }

    /**
     * @param	ChartFolders $chartFolders The chartFolders object to remove.
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function removeChartFolders($chartFolders)
    {
        if ($this->getChartFolderss()->contains($chartFolders)) {
            $this->collChartFolderss->remove($this->collChartFolderss->search($chartFolders));
            if (null === $this->chartFolderssScheduledForDeletion) {
                $this->chartFolderssScheduledForDeletion = clone $this->collChartFolderss;
                $this->chartFolderssScheduledForDeletion->clear();
            }
            $this->chartFolderssScheduledForDeletion[]= $chartFolders;
            $chartFolders->setOrganizationFolders(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this OrganizationFolders is new, it will return
     * an empty collection; or if this OrganizationFolders has previously
     * been saved, it will retrieve related ChartFolderss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in OrganizationFolders.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ChartFolders[] List of ChartFolders objects
     */
    public function getChartFolderssJoinChart($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ChartFoldersQuery::create(null, $criteria);
        $query->joinWith('Chart', $join_behavior);

        return $this->getChartFolderss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this OrganizationFolders is new, it will return
     * an empty collection; or if this OrganizationFolders has previously
     * been saved, it will retrieve related ChartFolderss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in OrganizationFolders.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ChartFolders[] List of ChartFolders objects
     */
    public function getChartFolderssJoinUserFolders($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ChartFoldersQuery::create(null, $criteria);
        $query->joinWith('UserFolders', $join_behavior);

        return $this->getChartFolderss($query, $con);
    }

    /**
     * Clears out the collCharts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return OrganizationFolders The current object (for fluent API support)
     * @see        addCharts()
     */
    public function clearCharts()
    {
        $this->collCharts = null; // important to set this to null since that means it is uninitialized
        $this->collChartsPartial = null;

        return $this;
    }

    /**
     * Initializes the collCharts collection.
     *
     * By default this just sets the collCharts collection to an empty collection (like clearCharts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initCharts()
    {
        $this->collCharts = new PropelObjectCollection();
        $this->collCharts->setModel('Chart');
    }

    /**
     * Gets a collection of Chart objects related by a many-to-many relationship
     * to the current object by way of the chart_folders cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this OrganizationFolders is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|Chart[] List of Chart objects
     */
    public function getCharts($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collCharts || null !== $criteria) {
            if ($this->isNew() && null === $this->collCharts) {
                // return empty collection
                $this->initCharts();
            } else {
                $collCharts = ChartQuery::create(null, $criteria)
                    ->filterByOrganizationFolders($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collCharts;
                }
                $this->collCharts = $collCharts;
            }
        }

        return $this->collCharts;
    }

    /**
     * Sets a collection of Chart objects related by a many-to-many relationship
     * to the current object by way of the chart_folders cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $charts A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function setCharts(PropelCollection $charts, PropelPDO $con = null)
    {
        $this->clearCharts();
        $currentCharts = $this->getCharts();

        $this->chartsScheduledForDeletion = $currentCharts->diff($charts);

        foreach ($charts as $chart) {
            if (!$currentCharts->contains($chart)) {
                $this->doAddChart($chart);
            }
        }

        $this->collCharts = $charts;

        return $this;
    }

    /**
     * Gets the number of Chart objects related by a many-to-many relationship
     * to the current object by way of the chart_folders cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related Chart objects
     */
    public function countCharts($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collCharts || null !== $criteria) {
            if ($this->isNew() && null === $this->collCharts) {
                return 0;
            } else {
                $query = ChartQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByOrganizationFolders($this)
                    ->count($con);
            }
        } else {
            return count($this->collCharts);
        }
    }

    /**
     * Associate a Chart object to this object
     * through the chart_folders cross reference table.
     *
     * @param  Chart $chart The ChartFolders object to relate
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function addChart(Chart $chart)
    {
        if ($this->collCharts === null) {
            $this->initCharts();
        }
        if (!$this->collCharts->contains($chart)) { // only add it if the **same** object is not already associated
            $this->doAddChart($chart);

            $this->collCharts[]= $chart;
        }

        return $this;
    }

    /**
     * @param	Chart $chart The chart object to add.
     */
    protected function doAddChart($chart)
    {
        $chartFolders = new ChartFolders();
        $chartFolders->setChart($chart);
        $this->addChartFolders($chartFolders);
    }

    /**
     * Remove a Chart object to this object
     * through the chart_folders cross reference table.
     *
     * @param Chart $chart The ChartFolders object to relate
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function removeChart(Chart $chart)
    {
        if ($this->getCharts()->contains($chart)) {
            $this->collCharts->remove($this->collCharts->search($chart));
            if (null === $this->chartsScheduledForDeletion) {
                $this->chartsScheduledForDeletion = clone $this->collCharts;
                $this->chartsScheduledForDeletion->clear();
            }
            $this->chartsScheduledForDeletion[]= $chart;
        }

        return $this;
    }

    /**
     * Clears out the collUserFolderss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return OrganizationFolders The current object (for fluent API support)
     * @see        addUserFolderss()
     */
    public function clearUserFolderss()
    {
        $this->collUserFolderss = null; // important to set this to null since that means it is uninitialized
        $this->collUserFolderssPartial = null;

        return $this;
    }

    /**
     * Initializes the collUserFolderss collection.
     *
     * By default this just sets the collUserFolderss collection to an empty collection (like clearUserFolderss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initUserFolderss()
    {
        $this->collUserFolderss = new PropelObjectCollection();
        $this->collUserFolderss->setModel('UserFolders');
    }

    /**
     * Gets a collection of UserFolders objects related by a many-to-many relationship
     * to the current object by way of the chart_folders cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this OrganizationFolders is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|UserFolders[] List of UserFolders objects
     */
    public function getUserFolderss($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collUserFolderss || null !== $criteria) {
            if ($this->isNew() && null === $this->collUserFolderss) {
                // return empty collection
                $this->initUserFolderss();
            } else {
                $collUserFolderss = UserFoldersQuery::create(null, $criteria)
                    ->filterByOrganizationFolders($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collUserFolderss;
                }
                $this->collUserFolderss = $collUserFolderss;
            }
        }

        return $this->collUserFolderss;
    }

    /**
     * Sets a collection of UserFolders objects related by a many-to-many relationship
     * to the current object by way of the chart_folders cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $userFolderss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function setUserFolderss(PropelCollection $userFolderss, PropelPDO $con = null)
    {
        $this->clearUserFolderss();
        $currentUserFolderss = $this->getUserFolderss();

        $this->userFolderssScheduledForDeletion = $currentUserFolderss->diff($userFolderss);

        foreach ($userFolderss as $userFolders) {
            if (!$currentUserFolderss->contains($userFolders)) {
                $this->doAddUserFolders($userFolders);
            }
        }

        $this->collUserFolderss = $userFolderss;

        return $this;
    }

    /**
     * Gets the number of UserFolders objects related by a many-to-many relationship
     * to the current object by way of the chart_folders cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related UserFolders objects
     */
    public function countUserFolderss($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collUserFolderss || null !== $criteria) {
            if ($this->isNew() && null === $this->collUserFolderss) {
                return 0;
            } else {
                $query = UserFoldersQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByOrganizationFolders($this)
                    ->count($con);
            }
        } else {
            return count($this->collUserFolderss);
        }
    }

    /**
     * Associate a UserFolders object to this object
     * through the chart_folders cross reference table.
     *
     * @param  UserFolders $userFolders The ChartFolders object to relate
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function addUserFolders(UserFolders $userFolders)
    {
        if ($this->collUserFolderss === null) {
            $this->initUserFolderss();
        }
        if (!$this->collUserFolderss->contains($userFolders)) { // only add it if the **same** object is not already associated
            $this->doAddUserFolders($userFolders);

            $this->collUserFolderss[]= $userFolders;
        }

        return $this;
    }

    /**
     * @param	UserFolders $userFolders The userFolders object to add.
     */
    protected function doAddUserFolders($userFolders)
    {
        $chartFolders = new ChartFolders();
        $chartFolders->setUserFolders($userFolders);
        $this->addChartFolders($chartFolders);
    }

    /**
     * Remove a UserFolders object to this object
     * through the chart_folders cross reference table.
     *
     * @param UserFolders $userFolders The ChartFolders object to relate
     * @return OrganizationFolders The current object (for fluent API support)
     */
    public function removeUserFolders(UserFolders $userFolders)
    {
        if ($this->getUserFolderss()->contains($userFolders)) {
            $this->collUserFolderss->remove($this->collUserFolderss->search($userFolders));
            if (null === $this->userFolderssScheduledForDeletion) {
                $this->userFolderssScheduledForDeletion = clone $this->collUserFolderss;
                $this->userFolderssScheduledForDeletion->clear();
            }
            $this->userFolderssScheduledForDeletion[]= $userFolders;
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->of_id = null;
        $this->org_id = null;
        $this->folder_name = null;
        $this->parent_id = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collChartFolderss) {
                foreach ($this->collChartFolderss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCharts) {
                foreach ($this->collCharts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserFolderss) {
                foreach ($this->collUserFolderss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aOrganization instanceof Persistent) {
              $this->aOrganization->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collChartFolderss instanceof PropelCollection) {
            $this->collChartFolderss->clearIterator();
        }
        $this->collChartFolderss = null;
        if ($this->collCharts instanceof PropelCollection) {
            $this->collCharts->clearIterator();
        }
        $this->collCharts = null;
        if ($this->collUserFolderss instanceof PropelCollection) {
            $this->collUserFolderss->clearIterator();
        }
        $this->collUserFolderss = null;
        $this->aOrganization = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(OrganizationFoldersPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}