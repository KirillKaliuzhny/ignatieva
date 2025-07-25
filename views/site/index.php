<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Конкурс';
?>

<style>
    .minimal-frame {
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 0.5rem;
        padding: 2rem;
        margin: 2rem auto;
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .frame-title {
        border-bottom: 2px solid #ff6b6b;
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
        font-size: 2rem;
        color: #d63384;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    p {
        font-size: 1.25rem;
        line-height: 1.6;
    }
    .balloon {
        position: absolute;
        width: 40px;
        height: 50px;
        background-color: #ff6b6b;
        border-radius: 50%;
        opacity: 0.7;
        animation: float 4s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }
</style>


<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="balloon" style="left: 10%; top: 10%; background-color: #ff6b6b;"></div>
            <div class="balloon" style="left: 85%; top: 15%; background-color: #4dabf7; animation-delay: 1s;"></div>
            <div class="minimal-frame">
                <h3 class="frame-title">🎉 Итоги конкурса 🎊</h3>
                <p class="mb-3">Призерами стали:</p>
                <p class="mb-3">Сорокина Валерия Алексеевна (Группа: АИБ-2-048) и Рудик Валерия Леонидовна (Группа: АИБ-2-048).</p>
            </div>
            <h2 class="mb-4">Кафедральный конкурс компьютерной графики и дизайна!</h2>
            <p class="lead">Приглашаем принять участие в конкурсе компьютерной графики и дизайна!</p>
            <div class="container-fluid p-0 mb-5"> <!-- container-fluid для полной ширины, p-0 убирает padding -->
                <?= Html::tag('picture',
                    Html::tag('source', '', [
                        'media' => '(min-width: 1200px)',
                        'srcset' => Yii::getAlias('@web') . '/images/main.jpg'
                    ]) .
                    Html::img('@web/images/main-mob.jpg', [
                        'alt' => 'Картинка',
                        'class' => 'img-fluid'
                    ])
                ) ?>
            </div>
            <ol class="list-unstyled">
                <li class="mb-3">
                    <h5 class="fw-bold">1. Организация конкурса</h5>
                <li class="mb-2">1.1 Участниками конкурса являются обучающиеся общеобразовательных организаций,
                    профессиональных образовательных организаций и организаций высшего образования различных регионов
                    Российской Федерации.
                </li>
                <li class="mb-2">1.2 Жюри конкурса формируется Оргкомитетом из числа экспертов, преподавателей
                    кафедры Вычислительная техника и автоматизированные системы управления.
                </li>
                <li class="mb-2">1.3 Участие в конкурсе индивидуальное.</li>
                <li class="mb-2">1.4 Участники должны подать заявку на сайте конкурса (Прием заявок) до 27 апреля 2025
                    года (включительно).
                </li>
                <li class="mb-2">1.5 Конкурс проводится в один этап – заочный с ограничением времени окончания конкурса
                    до 31 мая 2025 г., в течение которого участники выполняют задание на одну из тем имеющихся
                    номинаций.
                </li>
                <li class="mb-2">1.6 Задания на конкурс будут открыты в онлайн доступе на сайте <a href="/">computer-graphics.ru</a> со
                    времени начала конкурса до времени его окончания на сайте конкурса.
                </li>
            </ol>
            <p>Работы необходимо отослать на проверку строго до времени окончания конкурса и разместить на сайте <a href="/">computer-graphics.ru</a> !</p>
            <ol class="list-unstyled">
                <li class="mb-3">
                    <h5 class="fw-bold">2. Условия конкурса</h5>
                    <li class="mb-2">2.1. В ходе конкурса участник должен показать свои знания, умения и навыки работы в <b>векторном графическом редакторе Corel Draw</b> (предпочтительно) или можно использовать подобные программы (Adobe Illustrator, Figma и других, доступных участникам). </li>
                    <li class="mb-2">2.2. Выполнить задание можно в одной из предложенных программ векторной графики, выбрав соответствующую номинацию.</li>
                    <li class="mb-2">2.3. Итоговое изображение, созданное в CorelDraw должно быть представлено в виде двух файлов – исходного в формате *.cdr и изображение в высоком качестве в формате *.jpg.</li>
            </ol>
            <ol class="list-unstyled">
                <li class="mb-3">
                    <h5 class="fw-bold">3. Критерии оценки конкурсных работ:</h5>
                    <li class="mb-2">3.1. Технологические навыки и аккуратность выполнения (в частности, рассматривается выбранная программная среда, профессионализм в использовании инструментария) (от 0 до 20 баллов);</li>
                    <li class="mb-2">3.2. Креативность и выразительность средств подачи, художественные достоинства работы (от 0 до 10 баллов);</li>
                    <li class="mb-2">3.3. Оригинальность сюжета (от 0 до 10 баллов);</li>
                    <li class="mb-2">3.4. Соответствие проекта теме (от 0 до 3 баллов – «0» — не соответствует, «1» — практически не соответствует, «2» — соответствует частично, «3» — полностью соответствует);</li>
                    <li class="mb-2">3.5. Соответствие требованиям к работе (от 0 до 2 баллов — «0» — не соответствует, «1» — соответствует частично, «2» — полностью соответствует).</li>

            </ol>
            <p>При этом стоит отметить, что основным критерием отбора работ является именно техническая составляющая, выражающаяся сложностью реализации.</p>
            <ol class="list-unstyled">
                <li class="mb-3">
                    <h5 class="fw-bold">4. Подведение итогов</h5>
                    <li class="mb-2">4.1. Жюри оценивает представленные работы после обсуждения. </li>
                    <li class="mb-2">4.2. Участники, занявшие призовые места, получают дипломы и подарки. </li>
            </ol>
            <p class="fw-bold">Награждение осуществляется на закрытии конкурса компьютерной графики и дизайна 2 июня 2025 года. </p>
        </div>
    </div>
</div>