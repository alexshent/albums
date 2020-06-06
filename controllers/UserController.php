<?php

namespace app\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
    
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
	             ->from('User')
	             ->select("id,firstName,lastName");
	    
	    $command = $query->createCommand();
	    $users = $command->queryAll();
		
		header('Content-type: application/json; charset=utf-8');
		
		echo json_encode($users, JSON_PRETTY_PRINT);
	}
	
	public function actionView($id) {
		
		$query = new \yii\db\Query;
        $query->from('Album')
	          ->select("id,title")
	          ->where("user_id=$id");
	    $command = $query->createCommand();
	    $albums = $command->queryAll();
	    
	    $query = new \yii\db\Query;
        $query->from('User')
	          ->select("id,firstName,lastName")
	          ->where("id=$id");
	    $command = $query->createCommand();
	    $user = $command->queryOne();
		
		if ($user !== null) {
			$user['albums'] = $albums;
			echo json_encode($user, JSON_PRETTY_PRINT);
		}
		else {
			echo json_encode(['status'=>0, 'error_code'=>400, 'message'=>'Bad request'], JSON_PRETTY_PRINT);
		}
	}
}
