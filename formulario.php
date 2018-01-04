<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<h1>Formulario</h1>
<h3><?= $mensaje ?></h3>
<?=   Html::beginForm(
		  Url::toRoute("site/request"),// para las aciones 
		  "get",// el metodo o method
		  ['class'=>'form-inline']//para incluir clase de bootstrap son las opciones	
	); 
// con el div agregamos o incluimos el campo de texto con los stilos de bootstrap
?>

<div class="form-group">
	<?= Html::label("Introduce tu nombre", "nombre")?>
	<?= Html::textInput("nombre",null,["class" => "form-control"]) ?>
</div>

<?= Html::SubmitInput("Enviar Nombre",["class"=>"btn btn-primary"])   ?>
<?= Html::endForm() ?>
