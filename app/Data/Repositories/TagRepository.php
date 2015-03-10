<?php
namespace App\Data\Repositories;

/**
 * @interface
 * @author Jacob Stair
 * @brief Repository used for working with the 'tags' table.
 */
interface TagRepository
{
    /**
     *  @brief Return the model object for the given tag.
     *  
     *  @param string $tag Tag to get model object for
     *  @retval App::Data::Models::Tag Eloquent object containing tag
     */
    public function getByTag($tag);
    
    /**
     * @brief Links a tag to a meme
     * @param string $tag Tag to link
     * @param integer $memeId ID of meme to link tag to
     * @retval null
     */
    public function linkTagToMeme($tag, $memeId);
}//end interface TagRepository

//end file: ./app/Data/Repositories/TagRepository.php
