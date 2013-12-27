<?php
/**
 * @var ClientCreateFormAbstract $oClientCreateForm
 * @var IkTbActiveForm           $form
 */

$form = $this->beginWidget('application.components.utils.IkTbActiveForm', array(
	'id'                   => get_class($oClientCreateForm),
	'enableAjaxValidation' => true,
	'type'                 => 'horizontal',
	'clientOptions'        => array(
		'hideErrorMessage' => true,
		'validateOnChange' => true,
		'validateOnSubmit' => true,
	),
	'action'               => Yii::app()->createUrl('/form'),
));

//снимаем все эвенты с кнопки, т.к. после загрузки ajax-ом содержимого эвент снова повесится на кнопку
//сделано во избежание навешивания кучи эвентов
Yii::app()->clientScript->registerScript('ajaxForm', '
		updateAjaxForm();
		');

?>

<?php $this->widget('YaMetrikaGoalsWidget'); ?>

<?php
$this->widget('FormProgressBarWidget', array('aSteps' => Yii::app()->clientForm->getFormWidgetSteps(), 'iCurrentStep' => Yii::app()->clientForm->getCurrentStep()));
?>
<div class="clearfix"></div>

<h4>Паспортные данные</h4>
<div class="row">
	<div class="span6">
		<h5>Паспорт</h5>

		<div class="row">


			<?= $form->maskedTextFieldRow($oClientCreateForm, 'passport_full_number', '9999 / 999999', SiteParams::getHintHtmlOptions($oClientCreateForm, 'passport_number')); ?>

			<?= $form->dateMaskedRow($oClientCreateForm, 'passport_date', SiteParams::getHintHtmlOptions($oClientCreateForm, 'passport_date')); ?>

			<?= $form->fieldMaskedRow($oClientCreateForm, 'passport_code', SiteParams::getHintHtmlOptions($oClientCreateForm, 'passport_code') + array('mask' => '999-999', 'size' => '7', 'maxlength' => '7',)); ?>
			<?= $form->textFieldRow($oClientCreateForm, 'passport_issued', SiteParams::getHintHtmlOptions($oClientCreateForm, 'passport_issued')); ?>

			<?= $form->textFieldRow($oClientCreateForm, 'birthplace', SiteParams::getHintHtmlOptions($oClientCreateForm, 'birthplace')); ?>
		</div>
	</div>

	<div class="span6">
		<h5>Второй документ</h5>

		<div class="row">

			<?= $form->dropDownListRow2($oClientCreateForm, 'document', Dictionaries::$aDocuments, SiteParams::getHintHtmlOptions($oClientCreateForm, 'document') + array('class' => 'span3', 'empty' => '')); ?>
			<?= $form->textFieldRow($oClientCreateForm, 'document_number', SiteParams::getHintHtmlOptions($oClientCreateForm, 'document_number') + array('class' => 'span3')); ?>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="span12">
	<div class="form-actions row">
		<div class="span2">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'          => 'backButton',
				'buttonType'  => 'ajaxButton',
				'ajaxOptions' => array(
					'update' => '#formBody',
				),
				'url'         => Yii::app()
						->createUrl('/form/ajaxForm/' . Yii::app()->clientForm->getCurrentStep()),
				'label'       => SiteParams::C_BUTTON_LABEL_BACK,
			)); ?>
		</div>
		<div class="span2 offset2">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'          => 'submitButton',
				'buttonType'  => 'ajaxSubmit',
				'ajaxOptions' => array(
					'type'   => 'POST',
					'update' => '#formBody',
				),
				'url'         => Yii::app()->createUrl('/form/ajaxForm'),
				'type'        => 'primary',
				'label'       => SiteParams::C_BUTTON_LABEL_NEXT,
			)); ?>
		</div>
	</div>
</div>
<?php $this->endWidget();
//при изменении типа документа заново валидировать поле с номером документа.

Yii::app()->clientScript->registerScript('validate_document_number', '
	documentsArray = ' . CJSON::encode(SiteParams::getSecondDocumentPopovers()) . ';
	documentsArrayLabel = ' . CJSON::encode(SiteParams::getSecondDocumentPopoversLabel($oClientCreateForm)) . ';

	jQuery("#' . get_class($oClientCreateForm) . '_document").change(function()
	{
		docVal = $("#' . get_class($oClientCreateForm) . '_document").attr("value");
		if(docVal=="")
		{
			docVal = 0;
		}

		docVal = parseInt(docVal);

		options = {"content":documentsArrayLabel[docVal]}
		jQuery("#' . get_class($oClientCreateForm) . '_document_number").popover("destroy");
		jQuery("#' . get_class($oClientCreateForm) . '_document_number").popover(options);

		options = {"content":documentsArray[docVal]}
		jQuery("#' . get_class($oClientCreateForm) . '_document_number").next("span").find("i").popover("destroy");
		jQuery("#' . get_class($oClientCreateForm) . '_document_number").next("span").find("i").popover(options);

		var form=$("#' . get_class($oClientCreateForm) . '");
        var settings = form.data("settings");
        $.each(settings.attributes, function () {
	        if(this.name == "' . get_class($oClientCreateForm) . '[document_number]"){
	            this.status = 2; // force ajax validation
	        }
	    });
	    form.data("settings", settings);

	    // trigger ajax validation
	    $.fn.yiiactiveform.validate(form, function (data) {
	        $.each(settings.attributes, function () {

				if(this.name == "' . get_class($oClientCreateForm) . '[document_number]"){
	                $.fn.yiiactiveform.updateInput(this, data, form);
	            }
	        });
	    });
	});
');

Yii::app()->clientScript->registerScript('validate_document_force', '
documentsArray = ' . CJSON::encode(SiteParams::getSecondDocumentPopovers()) . ';
documentsArrayLabel = ' . CJSON::encode(SiteParams::getSecondDocumentPopoversLabel($oClientCreateForm)) . ';
docVal = $("#' . get_class($oClientCreateForm) . '_document").attr("value");
if(docVal=="")
{
	docVal = 0;
}
docVal = parseInt(docVal);

options = {"content":documentsArrayLabel[docVal]}
jQuery("#' . get_class($oClientCreateForm) . '_document_number").popover("destroy");
jQuery("#' . get_class($oClientCreateForm) . '_document_number").popover(options);

options = {"content":+documentsArray[docVal]}
jQuery("#' . get_class($oClientCreateForm) . '_document_number").next("span").find("i").popover("destroy");
jQuery("#' . get_class($oClientCreateForm) . '_document_number").next("span").find("i").popover(options);

', CClientScript::POS_LOAD);

?>
