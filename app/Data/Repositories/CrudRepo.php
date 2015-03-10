<?php
namespace App\Data\Repositories;

/**
 * @interface
 * @author Jacob Stair
 * @brief Classes implementing this interface contain methods used for basic CRUD operations.
 */
interface CrudRepo
{
    /**
     * @brief Returns all rows from the table.
     * @retval array Record data for the table
     */
    public function all();

    /**
     * @brief Retrieves data for the row with the given ID.
     * @param integer $id ID of record to retrieve
     * @retval array Record data for the given ID
     * @throws App::Data::Repositories::NotFoundException
     */
    public function get($id);

    /**
     * @brief Retrieves all rows which match the given cases.
     * @param array $where WHERE clauses in this form: [['column', '>/>=/=/etc', 'value], ...]
     * @param array $orderBy ORDER BY clauses in this form: [['column', 'asc/desc'], ...]
     * @retval array Array of record data arrays
     */
    public function getWhere(array $where, array $orderBy = []);

    /**
     * @brief Creates a new record in the table containing the given data.
     * @param array $input Array of data to insert into the database
     * @retval integer ID of row which was inserted
     * @throws App::Data::Repositories::DatabaseUpdateException
     */
    public function insert(array $input);

    /**
     * @brief Updates an existing record in the table using the given data.
     * @note Only columns specified in the $input array should be updated
     * @param integer $id ID of record to update
     * @param array $input Array of data to update the record with
     * @retval null
     * @throws App::Data::Repositories::DatabaseUpdateException
     * @see App::Data::Repositories::CrudRepo::get()
     */
    public function update($id, array $input);

    /**
     * @brief Deletes an existing record matching the given ID.
     * @param integer $id ID of record to delete
     * @retval null
     * @throws App::Data::Repositories::DatabaseUpdateException
     * @see App::Data::Repositories::CrudRepo::get()
     */
    public function delete($id);
}//end interface CrudRepo

//end file: ./app/Data/Repositories/CrudRepo.php
