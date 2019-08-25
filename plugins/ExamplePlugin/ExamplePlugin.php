<?php
namespace ExamplePlugin;

use SplObserver;
use SplSubject;
use \Lychee\Modules\Log;
use \Lychee\Modules\Database;

class ExamplePlugin implements SplObserver {

	public function __construct() {

		/**
		 * Add code here if wanted
		 * __construct() will be called every time Lychee gets called
		 * Make sure this part is performant
		 */

		return true;

	}

	public function update(SplSubject $subject) {

		/**
		 * Check if the called hook is the hook you are waiting for
		 * A list of all hooks is available online
		 */
		Log::error(Database::get(), __METHOD__, __LINE__, (string)$subject->action);

		if ($subject->action!=='Lychee\Modules\Photo::setAlbum:after') return false;

		$photo = $subject->args["src"];
		$album = $subject->args["dest"];

		Log::error(Database::get(), __METHOD__, __LINE__, (string)$album->get()["title"]);
		
		if ($album->get()['title'] === '自動分類') {
			$newAlbumID = $album->add("もぐの", true);
			$photo->setAlbum($newAlbumID);
		}

		Log::error(Database::get(), __METHOD__, __LINE__, (string)var_export($album->get(), true));

		Log::error(Database::get(), __METHOD__, __LINE__, (string)$subject->action);


		#if ($album.get
		


		return true;

	}

}
?>
