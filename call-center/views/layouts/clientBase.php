<?php
use yii\helpers\Html;
use common\components\Role;

?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>

    <div class="row">
        <div class="col-sm-12">
            <?php
            $url = Yii::$app->request->url;
            echo \yii\bootstrap\Nav::widget([
                'id'           => 'clientBaseTabs',
                'encodeLabels' => false,
                'items'        => [
                    [
                        'label'  => 'Данные',
                        'url'    => ['/clientBase/index/index'],
                        'active' => (bool)strstr($url, 'clientBase/index/')
                    ],
                    [
                        'label'  => 'Файлы',
                        'url'    => ['/clientBase/file/index'],
                        'active' => (bool)strstr($url, 'clientBase/file/index'),
                        'view'   => Yii::$app->user->can(Role::ADMIN)
                    ],
                    [
                        'label'  => 'Загрузить новый файл',
                        'url'    => ['/clientBase/file/create'],
                        'active' => (bool)strstr($url, 'clientBase/file/create'),
                        'view'   => Yii::$app->user->can(Role::ADMIN)
                    ],
                ],
                'options'      => [
                    'class' => 'nav nav-pills'
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-sm-12">
            <?php if (!empty($this->title)) : ?>
                <legend><?= Html::encode($this->title); ?></legend>
            <?php endif; ?>

            <?php
            if (!empty($this->context->breadCrumbs)) {
                echo \yii\widgets\Breadcrumbs::widget([
                    'links' => $this->context->breadCrumbs,
                ]);
            }
            ?>

            <?= \common\components\widgets\Alert::widget(); ?>
            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>