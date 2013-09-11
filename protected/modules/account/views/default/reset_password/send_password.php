<?php
/**
 * @var AccountResetPasswordForm $model
 * @var DefaultController        $this
 * @var IkTbActiveForm           $form
 */

/*
 * Ввести пароль из SMS
 */

$this->pageTitle = Yii::app()->name . " - Восстановление пароля";
?>
<h2 class='pay_legend' style="margin-left: 20px;">Восстановить пароль</h2>
<div class="form" id="activeForm">
	<div class="row">

		<div id="alertSmsSent" class="alert in alert-success span10"><?php echo Dictionaries::C_SMS_SUCCESS; ?></div>

		<?php
		$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
			'id'                     => 'ajaxResendSms',
			'enableClientValidation' => true,
			'clientOptions'          => array(
				'validateOnChange' => true,
				'validateOnSubmit' => true,
			),
			'htmlOptions'            => array(
				'class' => "span4",
			),
			'action'                 => Yii::app()
				->createUrl('/account/resetPasswordResendSmsCode'),
		));
		?>

		<div class="well">
			Ваш телефон: +7<?php echo Yii::app()->adminKreddyApi->getResetPassPhone(); ?>
		</div>

		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'id'         => 'btnResend',
			'buttonType' => 'submit',
			'icon'       => 'icon-refresh',
			'size'       => 'small',
			'label'      => 'Выслать код на телефон повторно',
			'disabled'   => true,
		));
		?>
		<div id="textUntilResend" class="hide">Повторно запросить SMS можно через: <span id="untilResend"></span></div>
		<div id="actionAnswerResend" class="help-block error"></div>
		<?php
		$this->endWidget();
		?>

	</div>

	<?php
	$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
		'id'                     => "checkSmsPass",
		'enableClientValidation' => true,
		'htmlOptions'            => array(
			'class' => "span4",
		),
		'clientOptions'          => array(
			'validateOnChange' => true,
			'validateOnSubmit' => true,
		),
		'action'                 => Yii::app()->createUrl('/account/resetPassSendPass'),
	));
	?>

	<label>Введите код из SMS:</label>
	<?php echo $form->textField($model, 'smsCode', array('class' => 'span4')); ?>
	<?php echo $form->error($model, 'smsCode'); ?>

	<div class="help-block error hide" id="actionAnswer"></div>

	<div class="clearfix"></div>

	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'submit',
		'type'       => 'primary',
		'size'       => 'small',
		'label'      => 'Получить пароль',
	));
	/**
	 * конец формы проверки пароля
	 */
	$this->endWidget();
	?>

</div>

<?php
//подключаем JS с таймером для кнопки
$sPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.myExt.assets') . '/') . '/js/sms_countdown.js';
Yii::app()->clientScript->registerScriptFile($sPath, CClientScript::POS_HEAD);
//передаем данные для JS-таймера
Yii::app()->clientScript->registerScript('showUntilResend2', '
	leftTime = new Date();
	leftTime.setTime(leftTime.getTime() + ' . Yii::app()->adminKreddyApi->getResetPassSmsCodeLeftTime() . '*1000);
	showUntilResend();'
	, CClientScript::POS_LOAD);
?>
