<?php
namespace App\Data\Repositories\Eloquent;

use App\Data\Repositories\CrudRepo;
use App\Data\Repositories\GeneratedMemeRepository;
use App\Data\Repositories\NotFoundException;
use App\Data\Repositories\DatabaseUpdateException;
use App\Data\Models\GeneratedMeme;

/**
 * @class _____
 * @author Jacob Stair
 * @brief _____
 * @description _____
 */
class GeneratedMemes implements CrudRepo, GeneratedMemeRepository
{
    /** Primary table which is handled by this repository */
    const REPO_TABLE = 'generatedmemes';
    
    /**
     * @brief Returns all rows from the table.
     * @retval array Record data for the table
     */
    public function all()
    {
        return $this->getWhere([], [['id', 'asc']]);
    }//end all()

    /**
     * @brief Retrieves data for the row with the given ID.
     * @param integer $id ID of record to retrieve
     * @retval array Record data for the given ID
     * @see App::Data::Repositories::Eloquent::Memes::getModelObjectById()
     */
    public function get($id)
    {
        $meme = $this->getModelObjectById($id);
        return $meme->toArray();
    }//end get()
    
    /**
     * @brief Retrieves data for the row with the given ID.
     * @param integer $id ID of record to retrieve
     * @retval App::Data::Models::GeneratedMeme Model object containing the requested record
     * @throws App::Data::Repositories::NotFoundException
     */
    private function getModelObjectById($id)
    {
        try {
            return GeneratedMeme::findOrFail($id);
        } catch (Exception $e) {
            throw new NotFoundException(self::REPO_TABLE, $id);
        }//end try/catch
    }//end getModelObjectById()

    /**
     * @brief Retrieves all rows which match the given cases.
     * @param array $where WHERE clauses in this form: [['column', '>/>=/=/etc', 'value], ...]
     * @param array $orderBy ORDER BY clauses in this form: [['column', 'asc/desc'], ...]
     * @retval array Array of record data arrays
     */
    public function getWhere(array $where, array $orderBy = [])
    {
        $query = new GeneratedMeme;
        foreach ($where as list($column, $operator, $value)) {
            $query = $query->where($column, $operator, $value);
        }//end foreach
        foreach ($orderBy as list($column, $order)) {
            $query = $query->orderBy($column, $order);
        }//end foreach
        return $query->get()->toArray();
    }//end getWhere()

    /**
     * @brief Creates a new record in the table containing the given data.
     * @param array $input Array of data to insert into the database
     * @retval integer ID of row which was inserted
     * @throws App::Data::Repositories::DatabaseUpdateException
     */
    public function insert(array $input)
    {
        $meme = GeneratedMeme::create($input);
        if (empty($meme)) {
            throw new DatabaseUpdateException(self::REPO_TABLE, 'INSERT', $input);
        }//end if
        return $meme->id;
    }//end insert()

    /**
     * @brief Updates an existing record in the table using the given data.
     * @note Only columns specified in the $input array should be updated
     * @param integer $id ID of record to update
     * @param array $input Array of data to update the record with
     * @retval null
     * @throws App::Data::Repositories::DatabaseUpdateException
     * @see App::Data::Repositories::Eloquent::Memes::getModelObjectById()
     */
    public function update($id, array $input)
    {
        $meme = $this->getModelObjectById($id);
        try {
            $meme->fill($input);
            $meme->save();
        } catch (Exception $e) {
            throw new DatabaseUpdateException(self::REPO_TABLE, 'UPDATE', $input, $id);
        }//end try/catch
    }//end update()

    /**
     * @brief Deletes an existing record matching the given ID.
     * @param integer $id ID of record to delete
     * @retval null
     * @throws App::Data::Repositories::DatabaseUpdateException
     * @see App::Data::Repositories::Eloquent::Memes::getModelObjectById()
     */
    public function delete($id)
    {
        $meme = $this->getModelObjectById($id);
        try {
            $meme->delete();
        } catch (Exception $e) {
            throw new DatabaseUpdateException(self::REPO_TABLE, 'DELETE', [], $id);
        }//end try/catch
    }//end delete()
    
    /**
     * @brief Removes all generated memes older than $minutes.
     * @param integer $minutes Number of minutes to limit memes to
     * @retval null
     * @throws App::Data::Repositories::DatabaseUpdateException
     */
    public function deleteOlderThan($minutes)
    {
        $limitTimestamp = \date(DATE_ISO8601, \strtotime('-' . $minutes . ' minutes'));
        $memes = GeneratedMeme::where('created_at', '<', $limitTimestamp);
        try {
            $memes->delete();
        } catch (Exception $e) {
            throw new DatabaseUpdateException(self::REPO_TABLE, 'DELETE', ['created_at' => '< ' . $limitTimestamp]);
        }//end try/catch
    }//end deleteOlderThan()
}//end class GeneratedMemes

//end file: ./app/Data/Repositories/Eloquent/GeneratedMemes.php
