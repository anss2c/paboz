<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Status;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $layout='mainLogin';
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    */
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //return $this->render('login');
         return $this->redirect(['login']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
	public function actionSignup()
    {
        $model = new User();
        $params = Yii::$app->request->post();
        if(!$params) {
            Yii::$app->response->statusCode = Status::STATUS_BAD_REQUEST;
            $status = [
                'status' => Status::STATUS_BAD_REQUEST,
                'message' => "Need username, password, and email.",
                'data' => ''
            ];
            Yii::$app->session->setFlash('error', 'Need username, password, and email');
        }

        if ($params) {
       // else{    
            $model->username = $params['username'];
            $model->email = $params['email'];
            $model->setPassword($params['password_hash']);
            $model->generateAuthKey();
            $model->status = User::STATUS_ACTIVE;
            Yii::$app->response->statusCode = Status::STATUS_CREATED;
            $response['isSuccess'] = 201;
            $response['message'] = 'You are now a member!';
            $response['user'] = \app\models\User::findByUsername($model->username);

            if($model->save()){
                $model->generateAccessToken();
                $status = [
                    'status' => Status::STATUS_CREATED,
                    'message' => 'You are now a member',
                    'data' => User::findByUsername($model->username),
                ];
               
                return $this->redirect(['login']);
                 //Yii::$app->session->setFlash('error', 'You are now a member');
            }
            else{
                Yii::$app->response->statusCode = Status::STATUS_BAD_REQUEST;
                $model->getErrors();
                $response['hasErrors'] = $model->hasErrors();
                $response['errors'] = $model->getErrors();
                $status = [
                'status' => Status::STATUS_BAD_REQUEST,
                'message' => 'Error saving data!',
                'data' => [
                    'hasErrors' => $model->hasErrors(),
                    'getErrors' => $model->getErrors(),
                ]
            ];
            //Yii::$app->session->setFlash('error', $response['errors']);
            return $status;
            //print_r($response['errors']);
            }
        //}     
     }
		return $this->render('/user/create', [
            'model' => $model,
        ]);
    }
    
    public function actionLogin()
    {
		$model = new User;
        $params = Yii::$app->request->post();
        if(empty($params['username']) || empty($params['password_hash'])) {
            $status = ['status' => Status::STATUS_BAD_REQUEST,
            'message' => "Need username and password.",
            'data' => ''];
             return $this->render('login', [
            'model' => $model, 'status'=>$status
        ]);
		}
		else{
            $model2 = new LoginForm();
			$user = User::findByUsername($params['username']);

			if ($user->validatePassword($params['password_hash'])) {
              //  if($model->login()){
				    if(isset($params['consumer'])) $user->consumer = $params['consumer'];
				    if(isset($params['access_given'])) $user->access_given = $params['access_given'];

				    Yii::$app->response->statusCode = Status::STATUS_FOUND;
				    $user->generateAuthKey();
				    $user->save();
                    $model->generateAccessToken();
				    $status =[
					    'status' => Status::STATUS_FOUND,
					    'message' => 'Login Succeed, save your token',
					    'data' => [
						    'id' => $user->username,
						    'token' => $user->auth_key,
						    'email' => $user['email'],
					    ]
				    ];
                   //print_r('yes');
                   //return 'sukses';
                   return $this->redirect(['sitea/index']);
               // }
			} else {
				Yii::$app->response->statusCode = Status::STATUS_UNAUTHORIZED;
				$status =[
					'status' => Status::STATUS_UNAUTHORIZED,
					'message' => 'Username and Password not found. Check Again!',
					'data' => ''
				];
                 return "gagal";
			}
		}
		
    } 
	/*
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['sitea/index']);
           // return $this->goBack();
        }

        $model->password_hash = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
	*/
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    
}
