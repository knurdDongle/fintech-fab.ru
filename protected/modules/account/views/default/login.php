<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form IkTbActiveForm */

$this->pageTitle = Yii::app()->name . ' - Вход';
$this->breadcrumbs = array(
	'Вход',
);
?>
<h2 class='pay_legend'>Вход в личный кабинет</h2>
<div class="form">
	<?php $form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
		'id'                   => 'login-form',
		'enableAjaxValidation' => false,
		'clientOptions'        => array(
			'validateOnSubmit' => false,
		),
		'htmlOptions'          => array(
			'autocomplete' => 'off',
		)
	)); ?>

	<?php if (Yii::app()->adminKreddyApi->getIsUserSessionExpired()): ?>
		<div class="alert alert-info"><?= AdminKreddyApiComponent::C_SESSION_EXPIRED; ?></div>
	<?php endif; ?>

	<p class="note">Для входа в личный кабинет введи номер телефона, указанный в Анкете, и пароль</p>

	<div class="row">
		<?= $form->phoneMaskedRow($model, 'username'); ?>
	</div>

	<div class="row">
		<?= $form->passwordFieldRow($model, 'password', array('autocomplete' => 'off')); ?>
	</div>

	<div class="row buttons">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'         => 'submitButton',
			'buttonType' => 'submit',
			'type'       => 'primary',
			'size'       => 'small',
			'label'      => 'Войти',
		)); ?>
		<?=
		CHtml::link('Получить пароль', Yii::app()
			->createUrl('/account/resetPassword'), array("style" => "margin-left: 50px;")); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->
