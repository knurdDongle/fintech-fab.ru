<?php
/* @var DefaultController $this */
/* @var VideoIdentifyForm $model */
/* @var IkTbActiveForm $form */

$this->pageTitle = Yii::app()->name . " - Идентификация на сайте";
?>
	<h4>Идентификация на сайте</h4>

	<div class="alert in alert-block alert-warning">
		<h4>Для идентификации тебе потребуется веб-камера.
			<?php if (!Yii::app()->adminKreddyApi->isFirstIdentification()): ?>
				После идентификации потребуется ввести
				данные документов, использованных при идентификации.
			<?php endif; ?>
		</h4>
	</div>
<?
$this->widget("CheckBrowserWidget");

Yii::app()->clientScript->registerScript('goIdentify', '
	//по нажатию кнопки отправляем эвент ajax-ом, затем сабмитим форму
	function goIdentify()
	{
		$.ajax({url: "/account/goIdentify"}).done(function() {
			$("#identify-form").submit();
		});
	}
	', CClientScript::POS_HEAD);

$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
	'id'                   => 'identify-form',
	'action'               => $model->video_url,
	'method'               => 'post',
	'enableAjaxValidation' => false,
	'clientOptions'        => array(
		'validateOnSubmit' => false,
	),
));
?>

<?= $form->hiddenField($model, 'type', array('name' => 'type')); ?>
<?= $form->hiddenField($model, 'client_code', array('name' => 'client_code')); ?>
<?= $form->hiddenField($model, 'service', array('name' => 'service')); ?>
<?= $form->hiddenField($model, 'signature', array('name' => 'signature')); ?>
<?= $form->hiddenField($model, 'documents', array('name' => 'documents')); ?>
<?= $form->hiddenField($model, 'documents_sign', array('name' => 'documents_sign')); ?>
<?= $form->hiddenField($model, 'timestamp', array('name' => 'timestamp')); ?>
<?= $form->hiddenField($model, 'redirect_back_url', array('name' => 'redirect_back_url')); ?>
	<div class="center">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'id'          => 'submitButton',
			'type'        => 'primary',
			'size'        => 'large',
			'label'       => 'Пройти идентификацию',
			'htmlOptions' => array(
				'onclick' => 'js: goIdentify()'
			)
		));
		?>
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'size'        => 'large',
			'label'       => 'Инструкция',
			'htmlOptions' => array(
				'class'   => 'btn-warning',
				'onClick' => 'return doOpenModalFrame(\'/pages/viewPartial/videoInstruction\', \'Инструкция\')',
			)
		));

		?>
	</div>
<?
$this->endWidget();

?>
	<br />
<?
$this->widget('application.modules.account.components.AppInfoWidget');
