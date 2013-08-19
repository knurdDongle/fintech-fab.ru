<?php
/**
 * @var ClientCreateFormAbstract $oClientCreateForm
 * @var IkTbActiveForm           $form
 */
?>
<div class="span5">
	<?php // echo $form->fieldPassportOneFieldRow($oClientCreateForm, array('passport_series','passport_number'), array('passport_number'=>array('class' => 'span2', 'mask' => '999999', 'size'=>'6', 'maxlength'=>'6'),'passport_series'=>array('class' => 'span1', 'mask' => '9999', 'size'=>'4', 'maxlength'=>'4')));?>
	<div class="control-group">
		<div class="row">
			<div class="span3">
				<?= $form->labelEx($oClientCreateForm, 'passport_number', array('class' => 'control-label')); ?>
				<div class="controls"><?= $form->maskedTextField($oClientCreateForm, 'passport_series', '9999', array('style' => 'width: 40px;', 'size' => '4', 'maxlength' => '4')); ?></div>
			</div>
			<div class="span2">
				<span>/</span>
				<?= $form->maskedTextField($oClientCreateForm, 'passport_number', '999999', array('style' => 'width: 60px;', 'size' => '6', 'maxlength' => '6')); ?>
			</div>
		</div>
		<div class="row">
			<div class="span5">
				<div style="margin-left: 180px;"><?= $form->error($oClientCreateForm, 'passport_series'); ?>
					<?= $form->error($oClientCreateForm, 'passport_number'); ?></div>
			</div>
		</div>
	</div>



	<?= $form->dateMaskedRow($oClientCreateForm, 'passport_date'); ?>

	<?= $form->fieldMaskedRow($oClientCreateForm, 'passport_code', array('mask' => '999-999', 'size' => '7', 'maxlength' => '7',)); ?>
	<?= $form->textFieldRow($oClientCreateForm, 'passport_issued'); ?>
</div>

<div class="span5">
	<?= $form->dropDownListRow($oClientCreateForm, 'document', Dictionaries::$aDocuments, array('class' => 'span3', 'empty' => '')); ?>
</div>

<div class="span3">
	<?= $form->textFieldRow($oClientCreateForm, 'document_number', array('class' => 'span3')); ?>
</div>

<?php
//при изменении типа документа заново валидировать поле с номером документа.

Yii::app()->clientScript->registerScript('validate_document_number', '
	jQuery("#' . get_class($oClientCreateForm) . '_document").change(function()
	{
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

?>
