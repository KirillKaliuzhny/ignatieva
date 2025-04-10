<?php

// controllers/ProfileController.php
namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Только для авторизованных
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = \Yii::$app->user->identity;
        $nomination = $user->nomination;

        return $this->render('index', [
            'user' => $user,
            'nomination' => $nomination
        ]);
    }
}