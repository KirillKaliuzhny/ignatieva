<?php

/** @var yii\web\View $this */
/** @var \app\models\Nomination $nomination */

/** @var \app\models\User $user */

use yii\helpers\Html;
use app\models\UserFile;
use yii\helpers\Url;

$photoFile = $user->getFiles()->where(['type' => UserFile::TYPE_IMAGE])->one();
$cdrFile = $user->getFiles()->where(['type' => UserFile::TYPE_CDR])->one();
$this->title = 'Мой профиль';
?>

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

    <div class="profile-actions mt-5 text-center">

    </div>
</div>

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
</style>