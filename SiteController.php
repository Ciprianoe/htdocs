<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
public function actionSaludo($get ="Estamos Preparando todo")//$get = "Vamos")    
    {
        $mensaje= "Bienvenidos al APP.CP";
        $numeros =[0,1,2,3,4,5];
        return $this->render("saludo",[
                    "mensaje"=>$mensaje,
                    "numeros"=>$numeros,
                    "get"=>$get,
                ]);

    }
    public function actionFormulario($mensaje = null)
    {
        return $this->render("formulario",["mensaje"=>$mensaje]);
    }
    public function actionRequest()
    {
        $mensaje = null;
        if (isset($_REQUEST["nombre"]))
        {
            $mensaje =  "Gracias por enviar tu nombre de forma correcta: " . $_REQUEST["nombre"];        }   
         $this->redirect(["site/formulario","mensaje"=>$mensaje]);        
    }

    public function actionValidarFormulario()
    {
        $model = new ValidarFormulario;
        if ($model->load(Yii::$app->request->post()))
            {
                if ($model->validate())
                {
                    // Ejemplo:consultar bd 
                }
                else
                {
                    $model->getErrors();
                    }
                 }
        return $this->render("validarformulario",["model"=>$model]);
    }     
    
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

    /**
     * @inheritdoc
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

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
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
