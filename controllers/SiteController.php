<?php

namespace app\controllers;

use app\models\Nomination;
use app\models\User;
use DateTime;
use Yii;
use yii\bootstrap5\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
        if (!yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $nominations = Nomination::find()
            ->select(['id', 'title'])
            ->where(['active' => 1])
            ->all();

        $currentDate = new DateTime();
        $targetDate = DateTime::createFromFormat('d.m.Y', '28.04.2025');

//        if (empty($nominations) || ($currentDate > $targetDate)) {
//            return $this->render('unregistration', []);
//        }

        $model = new User(['scenario' => 'register']);

        if ($model->load(Yii::$app->request->post())) {
            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            $model->created_at = time();
            $model->updated_at = time();

            if ($model->save()) {
                Yii::$app->user->login($model);
                Yii::$app->session->setFlash('success', 'Регистрация прошла успешно!');
                return $this->redirect(['profile/index']);
            }
        }

        return $this->render('registration', [
            'model' => $model,
            'nominations' => $nominations,
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

    public function actionNomination()
    {
        $model = new Nomination();
        $items = Nomination::find()->all();

        return $this->render('nomination', [
            'items' => $items,
        ]);
    }
}
