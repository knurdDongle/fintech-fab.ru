<?php
/**
 * @var ClientCreateFormAbstract $oClientCreateForm
 * @var IkTbActiveForm           $form
 */
?>
<?php
$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
	'id'                   => get_class($oClientCreateForm),
	'enableAjaxValidation' => true,
	'type'                 => 'horizontal',
	'clientOptions'        => array(
		'validateOnChange' => true,
		'validateOnSubmit' => true,
	),
	'action' => Yii::app()->createUrl('/form'),
));

//todo: past credit?
?>

<h4 id="jobInfoHeading">Место работы</h4>

<div class="span10">
	<?= $form->dropDownListRow($oClientCreateForm, 'status', Dictionaries::$aStatuses, array('empty' => '')); ?>
</div>

<div id="employee" class="statusfields hide">
	<div class="span10">
		<?= $form->textFieldRow($oClientCreateForm, 'job_company', array('class' => 'span3')); ?>
		<?= $form->textFieldRow($oClientCreateForm, 'job_position', array('class' => 'span3')); ?>
		<?= $form->phoneMaskedRow($oClientCreateForm, 'job_phone', array('class' => 'span3')) ?>
		<?= $form->dropDownListRow($oClientCreateForm, 'job_time', Dictionaries::$aJobTimes, array('class' => 'span2')); ?>
	</div>
</div>

<div id="student" class="statusfields hide">
	<div class="span10"><?= $form->textFieldRow($oClientCreateForm, 'educational_institution_name', array('class' => 'span3')); ?>
		<?= $form->phoneMaskedRow($oClientCreateForm, 'educational_institution_phone', array('class' => 'span3')); ?></div>
</div>

<div id="jobless" class="statusfields hide">
	<div class="span10"><?= $form->textFieldRow($oClientCreateForm, 'income_source', array('class' => 'span3')); ?></div>
</div>

<div class="span10">
	<?= $form->dropDownListRow($oClientCreateForm, 'job_monthly_income', Dictionaries::$aMonthlyMoney, array('empty' => '')); ?>
	<?= $form->dropDownListRow($oClientCreateForm, 'job_monthly_outcome', Dictionaries::$aMonthlyMoney, array('empty' => '')); ?>
</div>

<div class="clearfix"></div>
<div class="row span10">
	<div class="form-actions">
		<div class="row">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'          => get_class($oClientCreateForm) . '_submitButton',
				'buttonType'  => 'ajaxSubmit',
				'ajaxOptions' => array(
					'type'     => 'POST',
					'update'   => '#formBody',
					//снимаем все эвенты с кнопки, т.к. после загрузки ajax-ом содержимого эвент снова повесится на кнопку
					//сделано во избежание навешивания кучи эвентов
					'complete' => 'jQuery("body").off("click","#' . get_class($oClientCreateForm) . '_submitButton")',
				),
				'url'         => Yii::app()->createUrl('/form/ajaxForm'),
				'type'       => 'primary',
				'label'      => 'Далее',
			)); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

<?php
//todo: место работы для предпринимателя по-другому называется
//при изменении статуса выводим дополнительные поля, если нужно.
Yii::app()->clientScript->registerScript('loadExtraFields', '
    var statusField = jQuery("#' . get_class($oClientCreateForm) . '_status");
	statusField.change(function()	{
	    status = statusField.val();
	    if(status == "") {
		   jQuery("#student").hide();
		   jQuery("#jobless").hide();
		   jQuery("#employee").hide();
		} else if((status == 1) || (status == 2)) {
		   jQuery("#student").hide();
		   jQuery("#jobless").hide();
		   jQuery("#employee").show();
		} else if(status == 3) {
		   jQuery("#student").show();
		   jQuery("#jobless").hide();
		   jQuery("#employee").hide();
		} else if(status == 4) {
		   jQuery("#student").hide();
		   jQuery("#jobless").hide();
		   jQuery("#employee").hide();
		} else if((status == 5) || (status == 6)) {
		   jQuery("#jobless").show();
		   jQuery("#student").hide();
		   jQuery("#employee").hide();
		}
	});

	statusField.change();
');

?>

