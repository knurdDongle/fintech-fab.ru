<?php /* @var $this Controller */
//TODO перенести общие блоки лэйаутов в отдельные файлы
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="КРЕДДИ - ты всегда при деньгах. Как просто получить и вернуть заём? Простая и удобная услуга займов. Сколько взял – столько вернул!" />
	<meta name="keywords" content="" />
	<meta name="author" content="деньги, наличные, электронные деньги, срочно нужны, где взять, взаймы, займу, быстрые, в займы, займ, заём, займы, микрофинансовая организация, кредит, долг, вдолг, потребительские, денежный, частный, беспроцентный, ссуда, за час, кредитование, без справок, доход, срочный, экспресс, проценты, до зарплаты, неотложные, по паспорту, под расписку, выгодный, кредитные карты, кредитные системы, кредитные организации, кредитные истории, занять, краткосрочные, физическим лицам" />

	<title><?= CHtml::encode($this->pageTitle); ?></title>

	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/static/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/static/css/bootstrap-overload.css" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/static/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/static/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/static/css/payment.css" />

	<script type="text/javascript" src="<?= Yii::app()->request->baseUrl; ?>/static/js/main.js"></script>

	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<?php //Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
	<?php Yii::app()->bootstrap->registerCoreCss();
	Yii::app()->bootstrap->registerYiiCss();
	Yii::app()->bootstrap->registerCoreScripts();
	?>


	<link rel="shortcut icon" href="<?= Yii::app()->request->baseUrl; ?>/static/img/favicon.ico" />
</head>

<body class="home">

<nav class="navbar navbar-top">
	<div class="navbar-inner navbar-inner-main">
		<div class="container">

			<!-- Special image
			<div class="new-year-left" style="margin: 5px 0px -145px -120px; float: left; background: url('<= Yii::app()->request->baseUrl; ?>/static/img/lenta9may.png') no-repeat; height: 140px; width: 112px"></div>
			-->

			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"></a>
			<a href="<?= Yii::app()->request->baseUrl; ?>/" class="brand">
				<img src="<?= Yii::app()->request->baseUrl; ?>/static/img/logo-slogan.png" alt="Kreddy" /> </a>

			<span class="hotline pull-right">
				<small>
					Горячая линия
				</small>
				8 800 555-75-78
				<small>
					(бесплатно по России)
				</small>
			</span>
		</div>
	</div>
</nav>

<?php
$this->widget('TopPageWidget', array("show" => $this->showTopPageWidget));
?>
<?= $content; ?>
<br />

<div class="page-divider"></div>

<div class="container">
	<div class="row">
		<div class="span12 footer">
			<div class="footer">
				<?php
				$this->widget('FooterLinksWidget', array(
					'links' => FooterLinks::model()->findAll(array('order' => 'link_order')),
				));
				?>
				<p>&copy; <?= SiteParams::copyrightYear() ?> ООО "Финансовые Решения"</p>
			</div>
		</div>
	</div>
</div>

</body>
</html>
