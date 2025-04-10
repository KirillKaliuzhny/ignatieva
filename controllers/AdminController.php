<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Nomination;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isAdmin();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $nominations = Nomination::find()
            ->with([
                'users' => function($query) {
                    $query->with(['files']);
                }
            ])
            ->all();

        return $this->render('index', [
            'nominations' => $nominations
        ]);
    }
    public function actionDownload($id)
    {
        $file = UserFile::findOne($id);
        if (!$file) {
            throw new \yii\web\NotFoundHttpException('Файл не найден');
        }

        $s3 = Yii::$app->s3;
        $fileUrl = $s3->getPresignedUrl($file->s3_key, '+5 minutes');

        return $this->redirect($fileUrl);
    }
}