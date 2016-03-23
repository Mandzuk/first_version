<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\rbac\ManagerInterface;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'sex[]')->dropDownList(['Man' => 'man', 'woman' => 'woman'])  ?>

    <?= $form->field($model, 'location')->textInput() ?>

    <!--Додати перевірку-->
    <?php if(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id) == 'admin'):?>

    <?= $form->field($model, 'status')->textInput() ?>

	<?php endif;?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
