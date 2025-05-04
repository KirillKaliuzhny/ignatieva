<?php
namespace app\controllers;

use app\models\UserFile;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\Response;

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
        $files = $user->files;
        return $this->render('index', [
            'user' => $user,
            'nomination' => $nomination,
            'files' => $files,
        ]);
    }
    public function actionUploadJpg()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $file = UploadedFile::getInstanceByName('file');
        if (!$file || $file->extension !== 'jpg') {
            return ['error' => 'Только JPG'];
        }

        $stream = fopen($file->tempName, 'rb');
        $fileName = 'uploads/' . uniqid() . '.' . $file->extension;

        $s3 = \Yii::$app->s3;

        try {
            $s3->getClient()->putObject([
                'Bucket' => $s3->bucket,
                'Key'    => $fileName,
                'Body'   => fopen($file->tempName, 'rb'),
                'ACL'    => 'public-read',
                'ContentType' => $file->type,
            ]);

            fclose($stream);

            $url = $s3->getClient()->getObjectUrl($s3->bucket, $fileName);

            $currentFile = UserFile::find()
                ->where([
                    'user_id' => \Yii::$app->user->identity->getId(),
                    'file_type' => UserFile::TYPE_IMAGE,
                ])
                ->one();

            if ($currentFile) {
                $currentFile->updateAttributes([
                    'file_url' => $url,
                    'updated_at' => time(),
                ]);
            }
            else {
                $time = time();
                $model = new UserFile([
                    'user_id' => \Yii::$app->user->identity->getId(),
                    'file_type' => UserFile::TYPE_IMAGE,
                    'file_url' => $url,
                    'created_at' => $time,
                    'updated_at' => $time,
                ]);
                $model->save();
            }

            return ['success' => true];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function actionUploadCdr()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $file = UploadedFile::getInstanceByName('file');
        if (!$file || $file->extension !== 'cdr') {
            return ['error' => 'Только CDR'];
        }

        $stream = fopen($file->tempName, 'rb');
        $fileName = 'uploads/' . uniqid() . '.' . $file->extension;

        $s3 = \Yii::$app->s3;

        try {
            $s3->getClient()->putObject([
                'Bucket' => $s3->bucket,
                'Key'    => $fileName,
                'Body'   => fopen($file->tempName, 'rb'),
                'ACL'    => 'public-read',
                'ContentType' => $file->type,
            ]);

            fclose($stream);

            $url = $s3->getClient()->getObjectUrl($s3->bucket, $fileName);

            $currentFile = UserFile::find()
                ->where([
                    'user_id' => \Yii::$app->user->identity->getId(),
                    'file_type' => UserFile::TYPE_CDR,
                ])
                ->one();

            if ($currentFile) {
                $currentFile->updateAttributes([
                    'file_url' => $url,
                    'updated_at' => time(),
                ]);
            }
            else {
                $time = time();
                $model = new UserFile([
                    'user_id' => \Yii::$app->user->identity->getId(),
                    'file_type' => UserFile::TYPE_CDR,
                    'file_url' => $url,
                    'created_at' => $time,
                    'updated_at' => $time,
                ]);
                $model->save();
            }

            return ['success' => true];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}