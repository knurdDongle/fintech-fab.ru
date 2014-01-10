<?php
/* @var DefaultController $this */
/* @var ClientLoanForm $model */
/* @var IkTbActiveForm $form */

$this->pageTitle = Yii::app()->name . " - Оформление займа";
?>
	<h4>Оформление займа</h4>

<?php

$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
	'id'     => 'loan-form',
	'action' => Yii::app()->createUrl('/account/doLoan'),
));
?>

	<div class="alert alert-info">Размер займа: <b><?= Yii::app()->adminKreddyApi->getSubscriptionLoanAmount(); ?>
			рублей</b></div>

<?php

$this->widget('application.modules.account.components.ShowChannelsWidget',
	array(
		'sFormName'             => get_class($model),
		'aAllChannels'          => Yii::app()->adminKreddyApi->getProductsChannels(),
		'aAvailableChannelKeys' => Yii::app()->adminKreddyApi->getClientSubscriptionChannels(),
	)
);

$this->endWidget();

/*

$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
	'id'     => 'loan-form',
	'action' => Yii::app()->createUrl('/account/doLoan'),
));

//получаем список каналов
$aClientProductsChannelsList = Yii::app()->adminKreddyApi->getClientProductsChannelListWithAmounts();

//если есть доступные каналы
if (!empty($aClientProductsChannelsList)) {

	$model->channel_id = Yii::app()->adminKreddyApi->getLoanSelectedChannel();

	// если канада в сессии нет
	if ($model->channel_id === false) {
		//устанавливаем в качестве выбранного пакета первый из массива доступных
		$model->channel_id = reset(array_keys($aClientProductsChannelsList));
	}

	echo $form->radioButtonList($model, 'channel_id', $aClientProductsChannelsList, array("class" => "all"));
	echo $form->error($model, 'channel_id');

	?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'       => 'primary',
			'size'       => 'small',
			'label'      => 'Оформить займ',
		)); ?>
	</div>

<?php

} else { // если доступных пакетов нет - выводим соответствующее сообщение
	?>
	<div class="alert alert-info"><?= Yii::app()->adminKreddyApi->getNoAvailableProductsMessage() ?></div>

<?php
}

$this->endWidget();
*/
