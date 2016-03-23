<?php use yii\helpers\Html; ?>



	<div class="thumbnail catpump">
		<div id="product" class="textBox" >
        	<div class="container textBoxIn">
				<div class="category">
					<div class="caption">
						<div><h2>ID: <?= $id ?></h2></div>
						<div class="row"><h2 class="boxtitle"><?= $name ?></h2></div>
						<div class="column2"><?= $email ?></div>
						<div class="col-md-12"><div class="categoty_butt"><?= Html::a('Редактировать',['site/updateinvitation'] , ['class' => 'btn btn-primary'] ) ?></div></div>
					
					</div>
				</div>
			</div>
	    </div>
    </div>