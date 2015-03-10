<?php
namespace App\Data\Repositories;

use \Exception;

/**
 * @class
 * @author Jacob Stair
 * @brief Exception type thrown when a repository was unable to update the database.
 */
class DatabaseUpdateException extends Exception
{
    /**
     * @brief Takes the table and ID requested and generates the exception message.
     * @param string $table Table on which the update was being performed
     * @param string $action Action (insert/update/etc.) being performed on the table
     * @param array $data (optional) Array of data used to update the table
     * @param integer $id (optional) ID of record which was being updated
     * @retval null
     */
    public function __construct($table, $action, array $data = [], $id = null)
    {
        parent::__construct('Unable to update the database. ' . json_encode([
            'Table' => $table,
            'Action' => $action,
            'Data' => $data,
            'ID' => $id
        ]));
    }//end __construct()
}//end class DatabaseUpdateException

//end file: ./app/Data/Repositories/DatabaseUpdateException.php
