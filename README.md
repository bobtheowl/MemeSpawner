# MemeSpawner #
Simple meme generator meant for intranet usage.

## Features ##
* **Generating memes**<br />Obviously.
* **Instant search**<br />Search checks the query against the tags which are entered when the meme is added.
* **Template text**<br />Add text which is auto-populated when that meme is selected, to reduce the amount of mis-used memes.
* **Black/white text**<br />Because nobody likes a hard-to-read meme.
* **Management**<br />Add/edit/delete available memes, and delete generated memes.
* **Hidden memes**<br />Mark memes which you only want to pull out on a special occasion as "hidden", and they will only be available after the user enters the Konami code.

## System Requirements ##
* **PHP** >= 5.4
* A **SQL server** of some type (any supported by a base Laravel install).
* **php-gd package** &mdash; This is used to generate the thumbnails for and limit the size of the memes.
* **Memes** &mdash; This doesn't come with any images, you must upload them yourself using the Manage page.

## Potential Future Features ##
* Ability to change font/size/style of text.
* Ability to drag and move text on the image.
* Support for animated GIFs.

## Special Thanks ##
* http://laravel.com/
* http://getbootstrap.com/
* http://fontawesome.io/
* http://bootboxjs.com/
* https://github.com/snaptortoise/konami-js
