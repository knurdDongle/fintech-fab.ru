<?php
/* @var DefaultController $this */
/* @var AddCardForm $model */
/* @var IkTbActiveForm $form */

$this->pageTitle = Yii::app()->name . " - Привязка банковской карты";
?>
	<h4>Привязка банковской карты</h4>

<?php
$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
	'id'     => 'add-card',
	'action' => Yii::app()->createUrl('/account/verifyCard'),
	'htmlOptions'          => array(
		'autocomplete' => 'off',
	)
));
?>

<?= $form->textFieldRow($model, 'sCardVerifyAmount'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'       => 'primary',
			'size'       => 'small',
			'label'      => 'Потдвердить',
		)); ?>
	</div>

<?php

$this->endWidget();

Yii::app()->clientScript->registerScript('pageReload', '
	$(document).ready(function(){

            setInterval("window.location.href=\''.Yii::app()->createAbsoluteUrl(Yii::app()->request->requestUri).'\'",10000);
        });
', CClientScript::POS_HEAD);
