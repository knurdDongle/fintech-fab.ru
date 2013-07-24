<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Payments - QIWI';
$this->breadcrumbs=array(
	'QIWI',
);
?>
<?php
$this->widget('TopPageWidget');
?>

<div class="container container_12">
	<div class="grid_12">

		<article class="container">
			<section class="row">

				<div class="span12">
					<div class="row">
						<fieldset>
							<legend class="pay_legend">Инструкция по оплате через QIWI Кошелек</legend>
							<div class="span12 pay_faq">
								<p>С помощью QIWI Кошелька вы можете совершить оплату наличными в терминалах QIWI, на сайте <a href="https://w.qiwi.ru/features.action" target="_blank">QIWI Кошелька</a> или с помощью приложений для социальных сетей и <a href="https://w.qiwi.ru/mobile.action" target="_blank">мобильных телефонов</a>. Оплата через QIWI Кошелек осуществляется <strong>моментально</strong> и <strong>без комиссии!</strong></p>

								<p class="pay_attention">Для оплаты через QIWI Кошелек:</p>
								<ol>
									<li>Выберите в качестве способа оплаты "QIWI Кошелек".</li>
									<li>Далее укажите номер своего мобильного телефона и, если требуется, дополнительную информацию. Нажмите кнопку "Выставить счет за покупку".</li>
									<li>В системе автоматически сформируется счет на оплату, и откроется дополнительное окно, в котором вы можете сразу же его оплатить, достаточно только ввести пароль от своего QIWI Кошелька. При моментальной оплате счета доступна оплата из QIWI Кошелька, с баланса мобильного телефона или с баланса кредитной карты.</li>
									<img src="./static/img/pay_faq_qiwi_1.jpg" alt="1">
									<p><strong>Важно:</strong> в случае, если у вас недостаточно средств для оплаты или вы не хотите оплачивать счет сразу, то это можно сделать позже в терминалах QIWI (можно без регистрации в QIWI Кошельке), на сайте w.qiwi.ru или в приложениях QIWI Кошелек для мобильных телефонов и социальных сетей.</p>
								</ol>

								<p class="pay_attention">Как оплатить счет через терминал QIWI:</p>
								<ol>
									<li>Выберите платежный терминал QIWI. Терминалы QIWI выглядит следующим образом:</li>
									<img src="./static/img/pay_faq_qiwi_2.jpg" alt="2">
									<li>На главном экране терминала QIWI нажмите среднюю кнопку "QIWI КОШЕЛЕК":</li>
									<img src="./static/img/pay_faq_qiwi_3.jpg" alt="3">
									<li>На появившемся экране введите номер своего мобильного телефона, который вы указали при выставлении счета, и нажмите кнопку "ВПЕРЕД".</li>
									<img src="./static/img/pay_faq_qiwi_4.jpg" alt="4">
									<li>На следующем экране введите ПИН код (высылается при регистрации), после этого откроется главная страница QIWI Кошелька в терминале.</li>
									<p><strong>Внимание!</strong> Экран с ПИН кодом появляется только для пользователей, зарегистрированных в QIWI Кошельке. Если вы не зарегистрированы в QIWI Кошельке, то сразу попадете на главную страницу.</p>
									<img src="./static/img/pay_faq_qiwi_5.jpg" alt="5">
									<li>На главной странице будут мерцать две кнопки – "ПОПОЛНИТЬ QIWI КОШЕЛЕК" и "СЧЕТА К ОПЛАТЕ". Для оплаты счета перейдите в раздел счетов, нажав кнопку "СЧЕТА К ОПЛАТЕ".</li>
									<img src="./static/img/pay_faq_qiwi_6.jpg" alt="6">
									<li> В разделе "СЧЕТА К ОПЛАТЕ" выберите счет, который вы хотите оплатить (выбранный счет выделяется зеленым цветом) и нажмите кнопку "ОПЛАТИТЬ". После этого останется только внести деньги в терминал и подтвердить оплату счета. Вы можете оплатить счет в терминалах QIWI наличными, даже если не зарегистрированы в QIWI Кошельке. Зарегистрированным пользователям дополнительно доступна оплата из QIWI Кошелька, если на нем достаточно средств.</li>
									<p><strong>Внимание!</strong> Терминал не выдает сдачу. Если сумма оплачиваемого счета "неровная", то сдачу можно положить на баланс мобильного телефона или пополнить QIWI Кошелек.</p>
									<img src="./static/img/pay_faq_qiwi_7.jpg" alt="7">
								</ol>

								<p class="pay_attention">Как оплатить счет на сайте QIWI Кошелька:</p>
								<ol>
									<li>Войдите в <a href="https://w.qiwi.ru/features.action" target="_blank">QIWI Кошелек</a>, используя в качестве логина номер вашего мобильного телефона, который Вы указали при выставлении счета. Если Вы еще не были зарегистрированы в QIWI Кошельке, то сначала необходимо пройти регистрацию.</li>
									<li>В главном меню перейдите в раздел "Счета", нажмите "Оплатить" напротив счета, который вы хотите оплатить и выберите способ оплаты: из QIWI Кошелька, с лицевого счета сотового оператора или с баланса кредитной карты.</li>
									<img src="./static/img/pay_faq_qiwi_8.jpg" alt="8">
									<p><strong>Важно:</strong> Для оплаты из QIWI Кошелька необходимо, чтобы в нем было достаточно средств для оплаты выставленного счета. QIWI Кошелек легко пополнить в терминалах QIWI и терминалах партнеров, в салонах сотовой связи, в супермаркетах, в банкоматах и через интернет-банк. <a href="https://w.qiwi.ru/fill.action" target="_blank">Посмотреть все способы пополнения</a>.</p>
								</ol>

								<p class="pay_attention">Как оплатить счет через мобильные телефоны и социальные сети:</p>
								<p>Оплата через приложения для мобильных телефонов и социальных сетей принципиально не отличается от оплаты через сайт QIWI Кошелька. Для оплаты через мобильный телефон предварительно установите мобильное приложение QIWI Кошелек для своего телефона. <a href="https://w.qiwi.ru/mobile.action" target="_blank">Установить приложение</a>.</p>
								<p>Для оплаты через социальные сети установите на свою страницу приложение QIWI Кошелек. Приложение QIWI Кошелек доступно в социальных сетях ВКонтакте, Одноклассники и Facebook. Во всех приложениях также можно пройти регистрацию в QIWI Кошельке.</p>

								<p class="pay_attention">Видео-инструкция по оплате счета через QIWI Кошелек:</p>
								<object style="height: 390px; width: 640px; text-align:center;"><param name="movie" value="http://www.youtube.com/v/kbsSHtOl3G8?version=3"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="http://www.youtube.com/v/kbsSHtOl3G8?version=3" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" height="390" width="640"></object>
							</div>
							<div class="offset5 pay_back_btn">
								<a href="index.php?r=site/page&view=payments" class="btn btn-info btn-large nxt">← Назад</a>
							</div>

						</fieldset>
					</div>
				</div>

			</section>
		</article>

	</div>
</div>