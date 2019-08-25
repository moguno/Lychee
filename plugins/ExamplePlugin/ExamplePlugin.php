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
			$takeTM = strptime($photo->get()['takedate'], '%d %B %Y - %H:%M');
			if ($takeTM == false) {
				$albumName = "撮影日情報なし";
			} else {
				$takeTime = mktime($takeTM['tm_hour'], $takeTM['tm_min'], $takeTM['tm_sec'], $takeTM['tm_mon'] + 1, $takeTM['tm_mday'], $takeTM['tm_year'] + 1900);

				$albumName = strftime("%Y/%m/%d", $takeTime);
			}

			Log::error(Database::get(), __METHOD__, __LINE__, $albumName);

			$newAlbumID = $album->add($albumName, true);
			$photo->setAlbum($newAlbumID);
		}

#		Log::error(Database::get(), __METHOD__, __LINE__, (string)var_export($album->get(), true));

		Log::error(Database::get(), __METHOD__, __LINE__, (string)$subject->action);



		Log::error(Database::get(), __METHOD__, __LINE__, (string)var_export(strptime($photo->get()['takedate'], '%d %B %Y - %H:%M'), true));
		#if ($album.get

		return true;

	}

}
?>
