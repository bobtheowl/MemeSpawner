<?php
namespace App\Data\Repositories\Eloquent;

use App\Data\Repositories\CrudRepo;
use App\Data\Repositories\TagRepository;
use App\Data\Repositories\NotFoundException;
use App\Data\Repositories\DatabaseUpdateException;

use App\Data\Models\Tag;
use App\Data\Models\MemeTag;

/**
 * @class _____
 * @author Jacob Stair
 * @brief _____
 * @description _____
 */
class Tags implements CrudRepo, TagRepository
{
    /**
     * @brief Returns all rows from the table.
     * @retval array Record data for the table
     */
    public function all()
    {
        //
    }//end all()

    /**
     * @brief Retrieves data for the row with the given ID.
     * @param integer $id ID of record to retrieve
     * @retval array Record data for the given ID
     * @throws App::Data::Repositories::NotFoundException
     */
    public function get($id)
    {
        //
    }//end get()

    /**
     * @brief Retrieves all rows which match the given cases.
     * @param array $where WHERE clauses in this form: [['column', '>/>=/=/etc', 'value], ...]
     * @param array $orderBy ORDER BY clauses in this form: [['column', 'asc/desc'], ...]
     * @retval array Array of record data arrays
     */
    public function getWhere(array $where, array $orderBy = [])
    {
        //
    }//end getWhere()
    
    /**
     *  @brief Return the model object for the given tag.
     *  
     *  @param string $tag Tag to get model object for
     *  @retval App::Data::Models::Tag Eloquent object containing tag
     */
    public function getByTag($tag)
    {
        $tag = \strtolower($tag);
        return Tag::firstOrCreate(['name' => $tag]);
    }

    /**
     * @brief Creates a new record in the table containing the given data.
     * @param array $input Array of data to insert into the database
     * @retval integer ID of row which was inserted
     * @throws App::Data::Repositories::DatabaseUpdateException
     */
    public function insert(array $input)
    {
        //
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
        //
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
        //
    }//end delete()
    
    /**
     * @brief Links a tag to a meme
     * @param string $tag Tag to link
     * @param integer $memeId ID of meme to link tag to
     * @retval null
     */
    public function linkTagToMeme($tag, $memeId)
    {
        $tagModel = $this->getByTag($tag);
        MemeTag::firstOrCreate(['meme_id' => $memeId, 'tag_id' => $tagModel->id]);
    }
}//end class Tags

//end file: ./app/Data/Repositories/Eloquent/Tags.php
