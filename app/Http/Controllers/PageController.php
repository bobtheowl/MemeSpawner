<?php
namespace App\Http\Controllers;

use \View;

use App\Data\Repositories\MemeRepository;
use App\Data\Repositories\TagRepository;
use App\Data\Repositories\GeneratedMemeRepository;

class PageController extends Controller
{
    public function generator(MemeRepository $repo)
	{
		return View::make('generator', ['memes' => $repo->allNonHidden(), 'hidden' => $repo->allHidden()]);
	}//end generator()

    public function viewer(GeneratedMemeRepository $repo)
    {
        return View::make('viewer', ['memes' => $repo->all()]);
    }//end viewer()

    public function manage(MemeRepository $memeRepo, GeneratedMemeRepository $generatedRepo)
    {
        return View::make('manage');
    }//end manage()
}//end class PageController

//end file ./app/Http/Controllers/PageController.php
