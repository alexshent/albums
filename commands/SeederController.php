<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command seeds the database.
 *
 */
class SeederController extends Controller
{
    /**
     * This command seeds all entities.
     * @param string $users_number how many users to seed.
     * @return int Exit code
     */
    public function actionIndex($users_number=10, $albums_number=10, $photos_number=10)
    {
        // seed users
        $users = [];
        $user_passwords = require __DIR__ . '/../config/user_passwords_seed.php';
        
		foreach ($user_passwords as $key => $password) {
			$index = $key + 1;
			
			$user = new \app\models\User();
			$user->firstName = "First Name $index";
			$user->lastName = "Last Name $index";
			$user->username = "user$index";
			$user->password = password_hash($password, PASSWORD_DEFAULT);
			$user->save();
			$users[] = $user;
			
			if ($index === $users_number) {
				break;
			}
		}
        
        // seed albums
        $albums = [];
        for ($i=1; $i <= $albums_number; $i++) {
			$random_user =  $users[array_rand($users)];
			$album = new \app\models\Album();
			$album->user_id = $random_user->getPrimaryKey();
			$album->title = "Title $i";
			$album->save();
			$albums[] = $album;
		}
        
        // seed photos
        for ($i=1; $i <= $photos_number; $i++) {
			$random_album = $albums[array_rand($albums)];
			$photo = new \app\models\Photo();
			$photo->album_id = $random_album->getPrimaryKey();
			$photo->title = "Title $i";
			$photo->url = \yii\helpers\Url::base('http') . "/images/image$i.jpg";
			$photo->save();
		}

        return ExitCode::OK;
    }
}
