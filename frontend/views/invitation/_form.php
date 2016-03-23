<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\rbac\ManagerInterface;

date_default_timezone_set('UTC');
$today = date("Y-m-d");

/* @var $this yii\web\View */
/* @var $model app\models\Invitation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invitation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <!-- треба додати перевірку на адміна-->

    <?= $form->field($model, 'status[]')->dropDownList(['1' => 'В ожидании ответа', '2' => 'Заблокирован', '3' => 'Подтвержден']) ?>

    <?= $form->field($model, 'sent_date')->hiddenInput(['value' => $today])->label('') ?>

    <?= $form->field($model, 'id_user')->hiddenInput(['value' => Yii::$app->user->id])->label('') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
