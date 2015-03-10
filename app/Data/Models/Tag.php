<?php
namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class
 * @author Jacob Stair
 * @brief _____
 * @description _____
 */
class Tag extends Model
{
    protected $table = 'tags';

    protected $guarded = ['id'];

    public static $rules = [];

    /**
     * @brief Defines the many-to-many relationship between memes and tags.
     * @retval App::Data::Models::Tag
     */
    public function memes()
    {
        return $this->belongsToMany('App\Data\Models\Meme');
    }//end memes()
}//end class Tag

//end file: ./app/Data/Models/Tag.php
