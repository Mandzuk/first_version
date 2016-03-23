<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form ActiveForm */
?>
<div class="main-profile">
	<h1><?= $model->name ?></h1>
	<h1><?= $model->last_name ?></h1>
	<h1><?= $model->sex ?></h1>
	<div class="col-md-12"><div class="categoty_butt"><?= Html::a('Редактировать',['site/updateprofile'] , ['class' => 'btn btn-primary'] ) ?></div></div>

</div><!-- main-profile -->
