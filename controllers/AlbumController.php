<?php

namespace app\controllers;

use yii\rest\ActiveController;

class AlbumController extends ActiveController
{
    public $modelClass = 'app\models\Album';
    
    public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		unset($actions['view']);
		return $actions;
	}
	
	public function actionIndex() {
		
		$params=$_REQUEST;
        
        $page = 1;
        $limit = 10;
             
        if (isset($params['page'])) {
             $page = $params['page'];
		 }
               
        if (isset($params['limit'])) {
              $limit = $params['limit'];
		}
               
        $offset = $limit * ($page-1);
        
        $query = new \yii\db\Query;
        
        $query->offset($offset)
	             ->limit($limit)
	             ->from('Album')
	             ->select("id,title");
	    
	    $command = $query->createCommand();
	    $albums = $command->queryAll();
		
		header('Content-type: application/json; charset=utf-8');
		
		echo json_encode($albums, JSON_PRETTY_PRINT);
	}
	
	public function actionView($id) {
			    
	    $query = new \yii\db\Query;
        $query->from('Album')
	          ->select("id,user_id,title")
	          ->where("id=$id");
	    $command = $query->createCommand();
	    $album = $command->queryOne();
	    $user_id = $album['user_id'];
	    
	    $query = new \yii\db\Query;
        $query->from('User')
	          ->select("id,firstName,lastName")
	          ->where("id=$user_id");
	    $command = $query->createCommand();
	    $user = $command->queryOne();
	    
	    $query = new \yii\db\Query;
        $query->from('Photo')
	          ->select("id,title")
	          ->where("album_id=$id");
	    $command = $query->createCommand();
	    $photos = $command->queryAll();
		
		if ($album !== null) {
			unset($album['user_id']);
			$album['firstName'] = $user['firstName'];
			$album['lastName'] = $user['firstName'];
			$album['photos'] = $photos;
			echo json_encode($album, JSON_PRETTY_PRINT);
		}
		else {
			echo json_encode(['status'=>0, 'error_code'=>400, 'message'=>'Bad request'], JSON_PRETTY_PRINT);
		}
	}
}
