<?php
/* @var FormController $this */
/* @var ClientSendForm $model */
/* @var IkTbActiveForm $form */
/* @var ClientCreateFormAbstract $oClientCreateForm */

/*
 * Цифровой код
 * Согласие с условиями и передачей данных
 */

$this->pageTitle = Yii::app()->name;

?>

<div class="row">

	<?php $this->widget('YaMetrikaGoalsWidget', array(
		'iDoneSteps' => 'sms',
	)); ?>

	<div class="span12">
		<h3>Ваша заявка принята!</h3>

		<p>
			Ожидайте результата по SMS. Если у Вас есть вопросы - позвоните нам 8-800-555-75-78! </p>
	</div>

</div>


