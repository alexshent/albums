<?php

namespace tests\unit\models;

use app\models\Photo;

class PhotoTest extends \Codeception\Test\Unit
{
	public function testFindPhotoById()
    {
        expect_that($photo = Photo::findIdentity(1));
        expect($photo->title)->equals('Title 1');

        expect_not(Photo::findIdentity(999));
    }
    
    public function testFindPhotoByTitle()
    {
        expect_that($photo = Photo::findByTitle('Title 10'));
        expect_not(Photo::findByTitle('Title999'));
    }
}
