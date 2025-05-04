<?php

/** @var yii\web\View $this */
/** @var \app\models\Nomination $nomination */
/** @var \app\models\User $user */
/** @var \app\models\UserFile[] $files */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Мой профиль';
?>
<!--<pre>-->
<!--    --><?php //var_dump($files);?>
<!--</pre>-->
<div class="profile-index">
    <div class="profile-header text-center mb-5">
        <div class="avatar-circle mb-3">
            <?= Html::encode(mb_substr($user->first_name, 0, 1) . mb_substr($user->last_name, 0, 1)) ?>
        </div>
        <h1 class="profile-name"><?= Html::encode($user->first_name . ' ' . $user->last_name) ?></h1>
    </div>

    <div class="profile-details">
        <div class="detail-item">
            <span class="detail-label">Группа</span>
            <span class="detail-value"><?= Html::encode($user->group) ?></span>
        </div>

        <?php if ($user->middle_name): ?>
            <div class="detail-item">
                <span class="detail-label">Отчество</span>
                <span class="detail-value"><?= Html::encode($user->middle_name) ?></span>
            </div>
        <?php endif; ?>

        <div class="detail-item">
            <span class="detail-label">Номинация</span>
            <span class="detail-value">
                <?= $nomination ? Html::encode($nomination->title) : '<span class="text-muted">Не указана</span>' ?>
            </span>
        </div>

        <div class="detail-item">
            <span class="detail-label">Дата регистрации</span>
            <span class="detail-value">
                <?= Yii::$app->formatter->asDate($user->created_at, 'long') ?>
            </span>
        </div>
    </div>

    <div class="profile-actions mt-5">
        <h2>Загрузка работ</h2>
        <p>При загрузке файлов дождитесь окончания загрузки. Если нужно обновить уже загруженный файл, то просто добавьте ваш новый файл - ранее загруженный файл будет удален.</p>
        <div class="mb-5">
            <h5>Файл JPG</h5>
            <?php if (isset($files[\app\models\UserFile::TYPE_IMAGE])):?>
                <span>Файл загружен:</span>
                <image class="file_preview" src="<?= $files[\app\models\UserFile::TYPE_IMAGE]->file_url ?>" alt="jpg" />
            <?php endif;?>
            <form action="<?= Url::to(['profile/upload-jpg']) ?>"
                  class="dropzone"
                  id="jpg-dropzone"
                  enctype="multipart/form-data">
            </form>
        </div>

        <div class="mb-5">
            <h5>Файл CDR</h5>
            <?php if (isset($files[\app\models\UserFile::TYPE_IMAGE])):?>
                <span>Файл загружен</span>
            <?php endif;?>
            <form action="<?= Url::to(['profile/upload-cdr']) ?>"
                  class="dropzone"
                  id="cdr-dropzone2"
                  enctype="multipart/form-data">
            </form>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    Dropzone.autoDiscover = false;

    new Dropzone("#jpg-dropzone", {
        paramName: "file",
        maxFiles: 1,
        acceptedFiles: ".jpg",
        headers: {
            'X-CSRF-Token': csrfToken
        },
        maxFilesize: 6000,
        timeout:600000,
        dictDefaultMessage: "Перетащите JPG сюда или нажмите для выбора",
        init: function () {
            this.on("success", function(file, response) {
                console.log("JPG загружен", response);
            });
            this.on("error", function(file, response) {
                console.error("Ошибка JPG:", response);
            });
        }
    });

    new Dropzone("#cdr-dropzone2", {
        paramName: "file",
        maxFiles: 1,
        acceptedFiles: ".cdr",
        headers: {
            'X-CSRF-Token': csrfToken
        },
        maxFilesize: 6000,
        timeout:600000,
        dictDefaultMessage: "Перетащите CDR сюда или нажмите для выбора",
        init: function () {
            this.on("success", function(file, response) {
                console.log("CDR загружен", response);
            });
            this.on("error", function(file, response) {
                console.error("Ошибка CDR:", response);
            });
        }
    });
</script>

<style>
    .profile-index {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem;
    }

    .avatar-circle {
        width: 80px;
        height: 80px;
        background-color: #4a6fa5;
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
    }

    .profile-name {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .profile-details {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 0.8rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 500;
        color: #6c757d;
    }

    .detail-value {
        font-weight: 400;
        text-align: right;
    }

    .profile-actions .btn {
        min-width: 180px;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 576px) {
        .profile-actions .btn {
            display: block;
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
    .file_preview {
        max-width: 200px;
        object-fit: contain;
        margin-bottom: 24px;
    }
</style>