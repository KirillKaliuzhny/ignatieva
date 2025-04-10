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
        <div class="file-upload-container">
            <!-- Фото (JPG) -->
            <div class="upload-zone mb-5" id="upload-zone-photo">
                <div class="drop-area" data-type="<?= UserFile::TYPE_IMAGE ?>" data-accept="image/jpeg">
                    <div class="drop-content">
                        <i class="fas fa-camera"></i>
                        <h4>Фотография работы</h4>
                        <p class="text-muted small">Только JPG. Перетащите фото сюда или нажмите для выбора</p>
                        <input type="file" class="file-input"
                               data-type="<?= UserFile::TYPE_IMAGE ?>"
                               accept="image/jpeg"
                               style="display: none;">

                        <?php if ($photoFile): ?>
                            <div class="uploaded-file mt-3">
                                <div class="file-preview">
                                    <img src="<?= Yii::$app->s3->getUrl($photoFile->s3_key) ?>"
                                         class="img-thumbnail"
                                         style="max-height: 150px;">
                                </div>
                                <div class="file-info">
                                    <span class="file-name"><?= Html::encode($photoFile->original_name) ?></span>
                                    <span class="file-size">(<?= Yii::$app->formatter->asShortSize($photoFile->size) ?>)</span>
                                    <button class="btn btn-sm btn-outline-danger delete-file"
                                            data-id="<?= $photoFile->id ?>">
                                        Удалить
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="progress mt-2" style="display: none; height: 6px;">
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="error-message text-danger mt-2 small"></div>
                </div>
            </div>

            <!-- CDR файл -->
            <div class="upload-zone" id="upload-zone-cdr">
                <div class="drop-area" data-type="<?= UserFile::TYPE_CDR ?>" data-accept=".cdr">
                    <div class="drop-content">
                        <i class="fas fa-file-archive"></i>
                        <h4>Исходный файл (CDR)</h4>
                        <p class="text-muted small">Только CDR. Перетащите файл сюда или нажмите для выбора</p>
                        <input type="file" class="file-input"
                               data-type="<?= UserFile::TYPE_CDR ?>"
                               accept=".cdr"
                               style="display: none;">

                        <?php if ($cdrFile): ?>
                            <div class="uploaded-file mt-3">
                                <div class="file-preview">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="file-info">
                                    <span class="file-name"><?= Html::encode($cdrFile->original_name) ?></span>
                                    <span class="file-size">(<?= Yii::$app->formatter->asShortSize($cdrFile->size) ?>)</span>
                                    <button class="btn btn-sm btn-outline-danger delete-file"
                                            data-id="<?= $cdrFile->id ?>">
                                        Удалить
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="progress mt-2" style="display: none; height: 6px;">
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 0%"></div>
                    </div>
                    <div class="error-message text-danger mt-2 small"></div>
                </div>
            </div>
        </div>

        <?php
        $js = <<<JS
$(document).ready(function() {
    // Инициализация зон загрузки
    initUploadZone('#upload-zone-photo', {
        allowedTypes: ['image/jpeg', 'image/jpg']
    });
    
    initUploadZone('#upload-zone-cdr', {
        allowedExtensions: ['.cdr']
    });
    
    // Функция инициализации зоны загрузки
    function initUploadZone(selector, options) {
        const zone = $(selector);
        const dropArea = zone.find('.drop-area');
        const fileInput = zone.find('.file-input');
        const progressBar = zone.find('.progress');
        const progressBarInner = zone.find('.progress-bar');
        const errorMessage = zone.find('.error-message');
        
        // Обработчики событий для drag & drop
        dropArea.on('dragenter', function(e) {
            e.preventDefault();
            dropArea.addClass('highlight');
        });
        
        dropArea.on('dragover', function(e) {
            e.preventDefault();
            dropArea.addClass('highlight');
        });
        
        dropArea.on('dragleave', function(e) {
            e.preventDefault();
            dropArea.removeClass('highlight');
        });
        
        dropArea.on('drop', function(e) {
            e.preventDefault();
            dropArea.removeClass('highlight');
            const files = e.originalEvent.dataTransfer.files;
            if (files.length) {
                validateAndUpload(files[0], dropArea.data('type'));
            }
        });
        
        // Клик по области загрузки
        dropArea.on('click', function() {
            fileInput.click();
        });
        
        // Обработка выбора файла через диалог
        fileInput.on('change', function() {
            if (this.files.length) {
                validateAndUpload(this.files[0], $(this).data('type'));
            }
        });
        
        // Функция валидации и загрузки файла
        function validateAndUpload(file, type) {
            errorMessage.text('').hide();
            
            // Валидация типа файла
            if (options.allowedTypes && !options.allowedTypes.includes(file.type)) {
                errorMessage.text('Недопустимый тип файла. Разрешены только JPG изображения.').show();
                return;
            }
            
            // Валидация расширения для CDR
            if (options.allowedExtensions) {
                const fileName = file.name.toLowerCase();
                const isValid = options.allowedExtensions.some(ext => fileName.endsWith(ext));
                
                if (!isValid) {
                    errorMessage.text('Недопустимое расширение файла. Разрешены только .cdr файлы.').show();
                    return;
                }
            }
            
            // Загрузка файла
            uploadFile(file, type);
        }
        
        // Функция загрузки файла
        function uploadFile(file, type) {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', type);
            
            progressBar.show();
            errorMessage.text('').hide();
            
            $.ajax({
                url: '/profile/upload',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    const xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            const percent = Math.round((e.loaded / e.total) * 100);
                            progressBarInner.css('width', percent + '%').text(percent + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        errorMessage.text(response.error || 'Ошибка при загрузке файла').show();
                    }
                },
                error: function() {
                    errorMessage.text('Ошибка соединения с сервером').show();
                },
                complete: function() {
                    progressBar.hide();
                    progressBarInner.css('width', '0%').text('');
                }
            });
        }
    }
    
    // Удаление файла
    $('.delete-file').on('click', function(e) {
        e.stopPropagation();
        const fileId = $(this).data('id');
        if (confirm('Вы уверены, что хотите удалить этот файл?')) {
            $.post('/profile/delete-file', {id: fileId}, function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Ошибка при удалении файла: ' + (response.error || ''));
                }
            });
        }
    });
});
JS;

        $this->registerJs($js);
        ?>

        <style>
            /* Стили остаются такими же, как в предыдущем примере */
            .file-upload-container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }

            .upload-zone {
                margin-bottom: 30px;
            }

            .drop-area {
                border: 2px dashed #ced4da;
                border-radius: 10px;
                padding: 30px;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s;
                background-color: #f8f9fa;
            }

            .drop-area.highlight {
                border-color: #4a6fa5;
                background-color: #e9f0f7;
            }

            .drop-content i {
                font-size: 40px;
                color: #4a6fa5;
                margin-bottom: 15px;
            }

            .drop-content h4 {
                margin-bottom: 10px;
                color: #343a40;
                font-weight: 500;
            }

            .drop-content p {
                color: #6c757d;
                margin-bottom: 5px;
            }

            .uploaded-file {
                display: flex;
                align-items: center;
                margin-top: 15px;
                padding: 10px;
                background: white;
                border-radius: 5px;
                border: 1px solid #dee2e6;
            }

            .file-preview {
                margin-right: 15px;
            }

            .file-preview img {
                max-width: 100px;
                max-height: 100px;
            }

            .file-preview i {
                font-size: 40px;
                color: #6c757d;
            }

            .file-info {
                flex-grow: 1;
                text-align: left;
            }

            .file-name {
                display: block;
                font-weight: 500;
                margin-bottom: 3px;
            }

            .file-size {
                color: #6c757d;
                font-size: 0.9em;
            }

            .delete-file {
                margin-top: 5px;
            }

            .progress-bar {
                transition: width 0.3s;
                font-size: 0.7em;
            }

            .error-message {
                display: none;
            }
        </style>
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