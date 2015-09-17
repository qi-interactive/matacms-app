<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="/images/layout/favicon.ico"/>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <?= $this->render('_header.php'); ?>

    <div id="main">
        <?= $content ?>
    </div>

    <?= $this->render('_footer.php'); ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
