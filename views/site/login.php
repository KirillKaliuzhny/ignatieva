<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \app\models\User $model */
/** @var \app\models\Nomination[] $nominations */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Вход';
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'errorCssClass' => 'has-error',
        'successCssClass' => 'has-success',
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Регистрация', ['registration'], ['class' => 'btn btn-link']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>