<?php
/**
 * @var $this DefaultController
 * @var $sPassFormRender
 * @var $history
 * @var $historyProvider
 */

$this->breadcrumbs = array(
	$this->module->id,
);

$this->pageTitle = Yii::app()->name . ' - История операций';

?>
<h4>История операций</h4>

<?= $sPassFormRender // отображаем форму запроса SMS-пароля ?>
