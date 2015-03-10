<?php
namespace App\Data\Repositories;

/**
 * @interface
 * @author Jacob Stair
 * @brief Repository used for working with the 'memes' table.
 */
interface MemeRepository
{
    /**
     * @brief Retrieves all non-hidden memes.
     * @retval array Array of memes
     */
    public function allNonHidden();

    /**
     * @brief Retrieves all hidden memes.
     * @retval array Array of memes
     */
    public function allHidden();
}//end interface MemeRepository

//end file: ./app/Data/Repositories/MemeRepository.php
