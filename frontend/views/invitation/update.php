<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Invitation */

$this->title = 'Update Invitation: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Invitations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="invitation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userRole' => $userRole,
    ]) ?>

</div>
