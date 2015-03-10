<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Data\Repositories\MemeRepository;
use App\Data\Repositories\TagRepository;
use App\Image\Resize;

class MemeResource extends Controller
{
    public function __construct(Request $request, MemeRepository $repo)
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
    
    public function search()
    {
        $tags = $this->request->input('q');
        // TODO: This
    }

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
    public function store(TagRepository $tagRepo, Resize $resizer)
    {
        $input = $this->request->all();
        $data = [
            'name' => $input['name'],
            'image_data' => $input['image_data'],
            'thumbnail_data' => '',
            'mime_type' => '',
            'top_text_template' => $input['top_text_template'],
            'bottom_text_template' => $input['bottom_text_template'],
            'is_hidden' => ($input['is_hidden'] === 't')
        ];
        // Begin splitting image data to get mime type and generate thumbnail
        $imageData = explode(';', $input['image_data']);
        $imageData[0] = explode(':', $imageData[0]);
        $imageData[1] = explode(',', $imageData[1]);
        // Store mime type from data URI
        $data['mime_type'] = $imageData[0][1];
        // Size image to 550px width
        $imageDataUri = $resizer->source($imageData[1][1])->width(550)->getSizedImage();
        $data['image_data'] = 'data: ' . $data['mime_type'] . ';base64,' . $imageDataUri;
        // Convert image to thumbnail
        $thumbnailDataUri = $resizer->source($imageData[1][1])->width(128)->getSizedImage();
        $data['thumbnail_data'] = 'data: ' . $data['mime_type'] . ';base64,' . $thumbnailDataUri;
        // Store in database
        $memeId = $this->repo->insert($data);
        // Link tags to meme
        foreach ($input['tags'] as $tag) {
            $tagRepo->linkTagToMeme(\strtolower($tag), $memeId);
        }//end foreach
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
    public function update($id, TagRepository $tagRepo)
    {
        $input = $this->request->all();
        $data = [
            'name' => $input['name'],
            'top_text_template' => $input['top_text_template'],
            'bottom_text_template' => $input['bottom_text_template'],
            'is_hidden' => ($input['is_hidden'] === 't')
        ];
        $this->repo->update($id, $data);
        foreach ($input['tags'] as $tag) {
            $tagRepo->linkTagToMeme($tag, $id);
        }//end foreach
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
}//end class MemeResource

//end file ./app/Http/Controllers/MemeResource.php
