<?php

/**
 * @var string        $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\bootstrap\Modal;

\common\assets\AppAsset::register($this);

?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="nav-md">
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="/" class="site_title"><i class="fa fa-bomb"></i> <span><?= Yii::$app->name; ?></span></a>
                </div>
                <div class="clearfix"></div>

                <br/>

                <?php if (!empty($menuItems)) : ?>
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <?= \yiister\gentelella\widgets\Menu::widget(
                                [
                                    "items" => $menuItems,
                                ]
                            )
                            ?>
                        </div>

                    </div>
                    <!-- /sidebar menu -->
                <?php endif; ?>
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="<?= 'http://' . Yii::$app->params['baseUrl'] . '/auth/logout'; ?>"
                               title="Выход из системы">
                                <i class="fa fa-sign-out pull-right"></i>&nbsp;
                            </a>
                        </li>

                        <?php if (Yii::$app->id != 'app-frontend' && Yii::$app->user->isAdmin()) : ?>
                            <li>
                                <a href="<?= 'http://' . Yii::$app->params['baseUrl']; ?>">Выход из раздела</a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <?php
                            $userLabel = Yii::$app->user->getEmail();
                            $workPlace = Yii::$app->user->getWorkPlace();
                            if (!empty($workPlace)) {
                                $userLabel .= ' (' . $workPlace . ')';
                            }
                            ?>

                            <a href="#"><?= $userLabel; ?></a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="row">
                <div class="col-sm-12">
                    <?php if (!empty($this->title) && $this->context->showTitleLegend) : ?>
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

        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">&nbsp;</div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>

<?php
Modal::begin([
    'header'        => '<div id="modalHeaderTitle"></div>',
    'id'            => 'modalForm',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
]);
Modal::end();
?>

<div id="bigPreLoader" class="text-center">
    <img src="http://<?= Yii::$app->params['baseUrl']; ?>/source/images/bigPreLoader.gif"
         alt="Пожалуйста, подождите..."/>
</div>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
