
<?php
/* @var $this yii\web\View */
$this->title = 'WE';

?>
<?php use yii\helpers\Html; ?>
<div class="col-md-12"><div class="categoty_butt"><?= Html::a('Создать',['site/createinvitation'] , ['class' => 'btn btn-primary'] ) ?></div></div>
<br><br><br>
<?php 
	foreach ($dataProvider as $image ) {echo $this->render('_invitation.php',$image->attributes); };
?>
