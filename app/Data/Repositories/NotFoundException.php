<?php
namespace App\Data\Repositories;

use \Exception;

/**
 * @class
 * @author Jacob Stair
 * @brief Exception type thrown when a repository was unable to find a row with the given ID.
 */
class NotFoundException extends Exception
{
    /**
     * @brief Takes the table and ID requested and generates the exception message.
     * @param string $table Table which record was requested from
     * @param integer $id ID of record which was requested
     * @retval null
     */
    public function __construct($table, $id)
    {
        parent::__construct('Unable to find record ID ' . $id . ' in table ' . $table);
    }//end __construct()
}//end class NotFoundException

//end file: ./app/Data/Repositories/NotFoundException.php
