<?php
/**
 * @var DefaultController $this
 * @var SMSPasswordForm   $form
 */

/*
 * Ввести пароль из SMS
 */
?>

<?php

// поле ввода кода и кнопку "далее" прячем, если не отправлено смс или исчерпаны все попытки ввода
$flagHideForm = (empty($flagSmsSent) || !empty($flagExceededTries));
?>

<div class="span10">
	<?php
	// если SMS на телефон ещё не отсылалось
	if (empty($flagSmsSent)) {
		?>
		<div id="send_sms">
			<?php
			$passForm = new SMSPasswordForm();

			$form2 = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
				'id'                     => get_class($passForm) . '_smsPassword',
				'enableClientValidation' => true,
				'clientOptions'          => array(
					'validateOnChange' => true,
					'validateOnSubmit' => true,
				),
				'action'                 => Yii::app()->createUrl('/account/ajaxsendsms'),
			));

			// поле ввода кода и кнопку "далее" прячем, если не отправлено смс или исчерпаны все попытки ввода
			$flagHideForm = (empty($flagSmsSent) || !empty($flagExceededTries));
			?>
			<? $this->widget('bootstrap.widgets.TbButton', array(
				'id'          => 'sendSms',
				'buttonType'  => 'ajaxSubmit',
				'url'         => Yii::app()->createUrl('/account/ajaxsendsms'),
				'size'        => 'small',
				'label'       => 'Отправить на +7' . Yii::app()->clientForm->getSessionPhone() . ' SMS с кодом подтверждения',
				'ajaxOptions' => array(
					'dataType' => "json",
					'type'     => "POST",
					'success'  => "function(data)
                                {
									$('#actionAnswer').html(data.text).hide();
                                	if(data.type==0)
                                	{
                                	    $('#send_sms').hide();
                                		$('#sms_pass_row').show();
                                		$('.form-actions').show();
                               			$('#alertsmssent').fadeIn();
                                	}
                                	else if(data.type==1)
                                	{
                                	    $('#send_sms').hide();
                                		$('#sms_pass_row').show();
                                		$('.form-actions').show();
                               			$('#actionAnswer').html(data.text).show();
                                	}
                                	else if(data.type==2)
                                	{
                                	    $('#send_sms').hide();
                                		$('#actionAnswer').html(data.text).show();
                               		}
                               		else if(data.type==3)
                                	{
                                        $('#actionAnswer').html(data.text).show();
                                	}
                                } ",
				),
			)); ?>
			<?

			$this->endWidget();
			?>
		</div>
	<?php } ?>
</div>

<?php

$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
	'id'                     => get_class($passForm),
	'enableClientValidation' => true,
	'clientOptions'          => array(
		'validateOnChange' => true,
		'validateOnSubmit' => true,
	),
	'action'                 => Yii::app()->createUrl('/account/checksmspass'),
));

// поле ввода кода и кнопку "далее" прячем, если не отправлено смс или исчерпаны все попытки ввода
$flagHideForm = (empty($flagSmsSent) || !empty($flagExceededTries));
?>

<div class="span10<?php if ($flagHideForm) {
	echo ' hide';
} ?>" id="sms_pass_row">
	<?php Yii::app()->user->setFlash('success', Dictionaries::C_SMS_SUCCESS); ?>
	<?php $this->widget('bootstrap.widgets.TbAlert', array(
		'block'       => true, // display a larger alert block?
		'fade'        => false, // use transitions?
		'closeText'   => '&times;', // close link text - if set to false, no close link is displayed
		'htmlOptions' => array('style' => 'display:none;', 'id' => 'alertsmssent'),
	)); ?>
	<label>Введите код из SMS:</label>
	<?php echo $form->textField($passForm, 'smsPassword', array('class' => 'span4')); ?>
	<?php echo $form->error($passForm, 'smsPassword'); ?>
</div>        <span class="span10 help-block error<?php if (empty($actionAnswer)) {
	echo " hide";
} ?>" id="actionAnswer">
			<?php if (!empty($actionAnswer)) {
				echo $actionAnswer;
			} ?>
		</span>


<div class="clearfix"></div>
<div class="row span11">
	<div class="form-actions<?php if ($flagHideForm) {
		echo ' hide';
	} ?>">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'       => 'primary',
			'label'      => 'Далее →',
		)); ?>
	</div>
</div>
<?

$this->endWidget();
?>

<?php $this->widget('YaMetrikaGoalsWidget', array(
	'iDoneSteps'    => Yii::app()->clientForm->getCurrentStep(),
	'iSkippedSteps' => 2,
)); ?>
