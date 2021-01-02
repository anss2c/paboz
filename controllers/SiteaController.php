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

class SiteaController extends Controller
{
    /**
     * {@inheritdoc}
     */
     /*
     public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                        [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function () {
                          // Yii::$app->session->setFlash('error', 'This section is only for registered users.');
                           Yii::$app->user->loginRequired();
                        }
                    ],
                        [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
     }
     */
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
        return $this->render('/site/index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
	
}
