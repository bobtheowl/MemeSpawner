<?php
namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class
 * @author Jacob Stair
 * @brief _____
 * @description _____
 */
class MemeTag extends Model
{
    protected $table = 'meme_tag';

    protected $guarded = ['id'];

    public static $rules = [];

    /**
     * @brief Defines the one-to-many relationship to memes.
     * @retval App::Data::Models::MemeTag
     */
    public function memes()
    {
        return $this->hasMany('App\Data\Models\Meme');
    }//end memes()

    /**
     * @brief Defines the one-to-many relationship to tags.
     * @retval App::Data::Models::MemeTag
     */
    public function tags()
    {
        return $this->hasMany('App\Data\Models\Tag');
    }//end tags()
}//end class MemeTag

//end file: ./app/Data/Models/MemeTag.php
