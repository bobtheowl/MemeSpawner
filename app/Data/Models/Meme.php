<?php
namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class
 * @author Jacob Stair
 * @brief _____
 * @description _____
 */
class Meme extends Model
{
    protected $table = 'memes';

    protected $guarded = ['id'];

    public static $rules = [];

    /**
     * @brief Defines the many-to-many relationship between memes and tags.
     * @retval App::Data::Models::Meme
     */
    public function tags()
    {
        return $this->belongsToMany('App\Data\Models\Tag');
    }//end tags()
}//end class Meme

//end file: ./app/Data/Models/Meme.php
