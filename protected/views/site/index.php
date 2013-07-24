<?php
/* @var $this SiteController */
/* @var $model ClientJoinForm */
/* @var $form CActiveForm */


$this->pageTitle=Yii::app()->name;
$this->breadcrumbs=array(
	'123','456'
);
?>
    <?php
    $this->widget('TopPageWidget');
    ?>
<style type="text/css">

    .main_row label
    {
        margin-top:5pt;
        margin-right: 5pt;
        float:left;
    }

    .required span
    {
        float:none;
    }


</style>

<div class="container container_12">
<div class="grid_12">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink' => CHtml::link('HOME - My Way', Yii::app()->homeUrl),
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<div class="form">
        <?php $model=new ClientJoinForm;
        ?>
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'client-join',
            'action' => array('site/join'),
            'enableAjaxValidation'=>true,
        )); ?>
        <!--?php echo $form->errorSummary($model); ?-->

        <div class="row main_row">
            <?php echo $form->labelEx($model,'phone'); ?>+7
            <?php echo $form->textField($model,'phone'); ?>
            <?php echo $form->error($model,'phone'); ?>
        </div>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Присоединиться'); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div>
</div>