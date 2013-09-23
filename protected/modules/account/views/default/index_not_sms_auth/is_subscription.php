<?php
/**
 * @var $this DefaultController
 * @var $smsState
 * @var $passFormRender
 */

$this->breadcrumbs = array(
	$this->module->id,
);

$this->pageTitle = Yii::app()->name . ' - Личный кабинет - Состояние подключения';

//подписка есть
?>

<h4>Ваш пакет займов</h4>

<strong>Баланс:</strong>  <?= Yii::app()->adminKreddyApi->getBalance(); ?> руб. <br />
<strong>Продукт:</strong> <?= Yii::app()->adminKreddyApi->getSubscriptionProduct() ?><br />
<strong>Статус:</strong> <?= Yii::app()->adminKreddyApi->getStatusMessage() ?><br />    <strong>Пакет активен
	до:</strong>  <?=
(Yii::app()->adminKreddyApi->getSubscriptionActivity()) ?
	Yii::app()->adminKreddyApi->getSubscriptionActivity()
	: "&mdash;"; ?>
<br /><strong>Доступно займов:</strong> <?= Yii::app()->adminKreddyApi->getSubscriptionAvailableLoans(); ?><br />
<?php
// если есть мораторий на займ и ещё есть доступные займы, выводим соответствующее сообщение
if (Yii::app()->adminKreddyApi->getMoratoriumLoan() && Yii::app()->adminKreddyApi->getSubscriptionAvailableLoans() > 0) {
	?>
	<strong>Новый займ Вы можете оформить после:</strong> <?= Yii::app()->adminKreddyApi->getMoratoriumLoan() ?>
	<br />
<?php
}
?>
<br />
<?= $passFormRender // отображаем форму запроса SMS-пароля?>

