<?php

namespace app\controllers;
namespace app\modules\v1\controllers;
use Yii;
use app\helpers\BehaviorsFromParamsHelper;
use yii\rest\ActiveController;

/**
 * KaryawanController implements the CRUD actions for Karyawan model.
 */
class KaryawanController extends ActiveController
{
    public $modelClass = 'app\models\Karyawan';
	public function beforeAction($action)
	{
		$auth_bearer = "token";
		$headers = Yii::$app->request->headers;
		$authorization_header = $headers->get("Authorization");
		if($authorization_header!="" && substr($authorization_header,0,6)=="Bearer"){
			$bearer = substr($authorization_header,7);
			if($bearer==$auth_bearer){
				return parent::beforeAction($action);
			}else{
				throw new \yii\web\UnauthorizedHttpException();
			}
		}
		
		throw new \yii\web\ForbiddenHttpException();
	}
    
     
}
