<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Data\Repositories\GeneratedMemeRepository;

class GeneratedMemeResource extends Controller
{
    public function __construct(Request $request, GeneratedMemeRepository $repo)
    {
        $this->request = $request;
        $this->repo = $repo;
    }//end __construct()

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->repo->all();
    }//end index()

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }//end create()

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $data = [
            'image_data' => $this->request->input('base64data'),
            'thumbnail_data' => null,
            'mime_type' => null
        ];
        // Begin splitting image data to get mime type and generate thumbnail
        $imageData = explode(';', $data['image_data']);
        $imageData[0] = explode(':', $imageData[0]);
        $imageData[1] = explode(',', $imageData[1]);
        // Store mime type from data URI
        $data['mime_type'] = $imageData[0][1];
        // Convert image to thumbnail
        $base64 = str_replace(' ', '+', $imageData[1][1]);
        $image = \imagecreatefromstring(base64_decode($base64));
        $width = \imagesx($image);
        $height = \imagesy($image);
        $newHeight = \floor($height * (128 / $width));
        $thumbnail = \imagecreatetruecolor(128, $newHeight);
        \imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, 128, $newHeight, $width, $height);
        ob_start();
        \imagejpeg($thumbnail);
        $thumbnailRaw = ob_get_clean();
        $thumbnailData = 'data: ' . $data['mime_type'] . ';base64,' . base64_encode($thumbnailRaw);
        $data['thumbnail_data'] = $thumbnailData;
        // Store in database
        return $this->repo->insert($data);
    }//end store()

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->repo->get($id);
    }//end show()
    
    /**
     * @brief _____
     * @param type $name _____
     * @retval type _____
     */
    public function display($id)
    {
        $meme = $this->repo->get($id);
        return '<img src="' . $meme['image_data'] . '" />';
    }//end display()

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }//end edit()

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }//end update()

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->repo->delete($id);
    }//end destroy()
    
    /**
     * @brief Removes all generated memes older than $minutes.
     * @param integer $minutes Number of minutes to limit generated memes to
     * @retval null
     */
    public function destroyOldMemes($minutes)
    {
        $this->repo->deleteOlderThan($minutes);
    }//end destroyOldMemes()
}//end class GeneratedMemeResource

//end file ./app/Http/Controllers/GeneratedMemeResource.php
