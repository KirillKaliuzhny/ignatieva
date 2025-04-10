<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\UserFile;

$this->title = 'Админка';
?>

<div class="admin-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="nominations-list">
        <?php foreach ($nominations as $nomination): ?>
            <div class="nomination-card mb-5">
                <h2 class="nomination-title">
                    <?= Html::encode($nomination->title) ?>
                </h2>

                <div class="users-list">
                    <?php foreach ($nomination->users as $user): ?>
                        <?php
                        $photoFile = $user->getFiles()->where(['type' => UserFile::TYPE_IMAGE])->one();
                        $cdrFile = $user->getFiles()->where(['type' => UserFile::TYPE_CDR])->one();
                        ?>
                        <div class="user-card mb-3 p-3 border rounded">
                            <div class="user-info mb-2">
                                <strong><?= Html::encode($user->last_name . ' ' . $user->first_name . ' ' . $user->middle_name) ?></strong>
                                <span class="text-muted">(Группа: <?= Html::encode($user->group) ?>)</span>
                            </div>

                            <div class="user-files">
                                <?php if ($photoFile): ?>
                                    <div class="file-item mb-1">
                                        <i class="fas fa-image"></i>
                                        <?= Html::a(
                                            'Скачать фото',
                                            ['/admin/download', 'id' => $photoFile->id],
                                            ['class' => 'file-link']
                                        ) ?>
                                        <span class="file-size">(<?= Yii::$app->formatter->asShortSize($photoFile->size) ?>)</span>
                                    </div>
                                <?php else: ?>
                                    <span>Фото не загружено</span>
                                <?php endif; ?>

                                <?php if ($cdrFile): ?>
                                    <div class="file-item">
                                        <i class="fas fa-file-archive"></i>
                                        <?= Html::a(
                                           'Скачать файл',
                                            ['/admin/download', 'id' => $cdrFile->id],
                                            ['class' => 'file-link']
                                        ) ?>
                                        <span class="file-size">(<?= Yii::$app->formatter->asShortSize($cdrFile->size) ?>)</span>
                                    </div>
                                <?php else: ?>
                                    <span>Файл не загружен</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .nomination-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    .nomination-title {
        color: #2c3e50;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .user-card {
        background: white;
    }

    .user-info {
        font-size: 1.1rem;
    }

    .file-item {
        padding: 5px 0;
    }

    .file-link {
        color: #3498db;
        margin-left: 5px;
    }

    .file-link:hover {
        text-decoration: none;
        color: #2874a6;
    }

    .file-size {
        color: #7f8c8d;
        font-size: 0.9em;
        margin-left: 5px;
    }

    .fa-image, .fa-file-archive {
        color: #95a5a6;
        width: 20px;
    }
</style>