<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}//end boot()

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'App\Data\Repositories\MemeRepository',
			'App\Data\Repositories\Eloquent\Memes'
		);
        $this->app->bind(
			'App\Data\Repositories\TagRepository',
			'App\Data\Repositories\Eloquent\Tags'
		);
        $this->app->bind(
			'App\Data\Repositories\GeneratedMemeRepository',
			'App\Data\Repositories\Eloquent\GeneratedMemes'
		);
	}//end register()
}//end class RepoServiceProvider

//end file ./app/Providers/RepoServiceProviders.php
