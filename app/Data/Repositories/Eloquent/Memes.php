<?php
namespace App\Data\Repositories\Eloquent;

use App\Data\Repositories\CrudRepo;
use App\Data\Repositories\MemeRepository;
use App\Data\Repositories\NotFoundException;
use App\Data\Repositories\DatabaseUpdateException;
use App\Data\Models\Meme;
use \Exception;

/**
 * @class _____
 * @author Jacob Stair
 * @brief _____
 * @description _____
 */
class Memes implements CrudRepo, MemeRepository
{
    /** Primary table which is handled by this repository */
    const REPO_TABLE = 'memes';

    /**
     * @brief Returns all rows from the table.
     * @retval array Record data for the table
     */
    public function all()
    {
        return $this->getWhere([], [['name', 'asc']]);
    }//end all()

    /**
     * @brief Retrieves all non-hidden memes.
     * @retval array Array of memes
     */
    public function allNonHidden()
    {
        return $this->getWhere(
            [['is_hidden', '=', false]],
            [['name', 'asc']]
        );
    }//end allNonHidden()

    /**
     * @brief Retrieves all hidden memes.
     * @retval array Array of memes
     */
    public function allHidden()
    {
        return $this->getWhere(
            [['is_hidden', '=', true]],
            [['name', 'asc']]
        );
    }//end allHidden()

    /**
     * @brief Retrieves data for the row with the given ID.
     * @param integer $id ID of record to retrieve
     * @retval array Record data for the given ID
     * @see App::Data::Repositories::Eloquent::Memes::getModelObjectById()
     */
    public function get($id)
    {
        $model = $this->getModelObjectById($id);
        $model->load('tags');
        return $model->toArray();
    }//end get()

    /**
     * @brief Retrieves data for the row with the given ID.
     * @param integer $id ID of record to retrieve
     * @retval App::Data::Models::Meme Model object containing the requested record
     * @throws App::Data::Repositories::NotFoundException
     */
    private function getModelObjectById($id)
    {
        try {
            return Meme::findOrFail($id);
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
        $query = Meme::with('tags');
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
        $meme = Meme::create($input);
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
     * @see App::Data::Repositories::CrudRepo::get()
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
     * @see App::Data::Repositories::CrudRepo::get()
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
}//end class Memes

//end file: ./app/Data/Repositories/Eloquent/Memes.php
