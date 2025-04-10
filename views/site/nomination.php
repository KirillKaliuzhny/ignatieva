<?php

/** @var yii\web\View $this */
/** @var \app\models\Nomination[] $items */

use yii\helpers\Html;

$this->title = 'Номинации';
?>

<style>
    .list-item {
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .list-item:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    .list-item.active {
        background-color: #e8f4fd;
        border-left: 4px solid #0d6efd;
    }

    .list-item.inactive {
        opacity: 0.7;
        background-color: #f8f9fa;
    }

    .item-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .item-description {
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .item-requirement {
        font-size: 0.9rem;
        color: #dc3545;
    }

    .new-badge {
        position: absolute;
        top: -10px;
        right: -10px;
</style>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <?php foreach ($items as $item):?>
                    <?php if ($item->active):?>
                        <div class="list-item active position-relative">
                            <div class="item-title"><?=$item->title?></div>
                            <div class="item-description"><?=$item->description?></div>
                            <div class="item-description"><?=$item->format?></div>
                            <div class="item-requirement"><?=$item->requirements?></div>
                        </div>
                    <?php else: ?>
                        <div class="list-item inactive position-relative">
                            <span class="badge bg-danger new-badge">Регистрация закрыта</span>
                            <div class="item-title"><?=$item->title?></div>
                            <div class="item-description"><?=$item->description?></div>
                            <div class="item-description"><?=$item->format?></div>
                            <div class="item-requirement"><?=$item->requirements?></div>
                        </div>
                    <?php endif?>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
