<?php
namespace App\Data\Repositories;

/**
 * @interface
 * @author Jacob Stair
 * @brief Repository used for working with the 'generatedmemes' table.
 */
interface GeneratedMemeRepository
{
    /**
     * @brief Removes all generated memes older than $minutes.
     * @param integer $minutes Number of minutes to limit memes to
     * @retval null
     * @throws App::Data::Repositories::DatabaseUpdateException
     */
    public function deleteOlderThan($minutes);
}//end interface GeneratedMemeRepository

//end file: ./app/Data/Repositories/GeneratedMemeRepository.php
