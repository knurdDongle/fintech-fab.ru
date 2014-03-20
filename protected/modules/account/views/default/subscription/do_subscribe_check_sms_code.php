<?php
/* @var DefaultController $this */
/* @var SMSCodeForm $model */
/* @var IkTbActiveForm $form */

$this->pageTitle = Yii::app()->name . " - Подключение Пакета";
?>
<h4>Подключение Пакета</h4>
<?php
$this->widget('bootstrap.widgets.TbBox', array(
	'title'   => 'Информация о подключении',
	'content' => $this->renderPartial('subscription/_product', array(), true)
));
?>
<div class="alert in alert-block alert-success">
	Код подтверждения операции успешно отправлен по SMS на номер +7<?= Yii::app()->user->getMaskedId() ?>
</div>
<div class="alert in alert-block alert-info">
	Для подтверждения операции введите код, отправленный Вам по SMS
</div>
<div class="form" id="activeForm">
	<?php
	$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
		'id'          => 'products-form',
		'action'      => Yii::app()->createUrl('/account/doSubscribeCheckSmsCode'),
		'htmlOptions' => array(
			'class'        => "span4",
			'autocomplete' => 'off',
		),
	));

	?>
	<?= $form->textFieldRow($model, 'smsCode') ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'submit',
		'type'       => 'primary',
		'size'       => 'small',
		'label'      => 'Подтвердить',
	)); ?>

	<?php
	$this->endWidget();
	?>
</div>
