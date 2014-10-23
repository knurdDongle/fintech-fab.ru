<?php
/**
 * @var DocumentComponent $this
 * @var array             $aParams
 */

$aConditionInfo = $aParams['aConditionInfo'];

list($sSubscriptionRub, $sSubscriptionKop) = explode('.', number_format($aConditionInfo['subscription_amount'], 2, '.', ''));

$this->getMPDF()->setHTMLHeader('
	<div style="text-align: center;font-size: 12px;">
			Индивидуальные условия договора потребительского займа № ' . $aConditionInfo['contract_number'] . '<br>
			от ' . SiteParams::formatRusDate($aConditionInfo['dt_contract'], false) . '
	</div>
');

$this->getMPDF()->setHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');

$aData = array(
	'1'   => array(
		'condition'     => "Сумма займа или лимит кредитования и порядок его изменения",
		'conditionText' => "Сумма займа - {$aConditionInfo['loan_amount']} руб. " . Num2Words::doConvert($aConditionInfo['loan_amount'], Num2Words::C_RUB),
	),
	'2'   => array(
		'condition'     => "Срок действия договора, срок возврата займа",
		'conditionText' => "Договор действует до полного исполнения Сторонами своих обязательств.<br>
							Срок возврата займа – {$aConditionInfo['loan_lifetime']} дней со дня принятия Индивидуальных условий",
	),
	'3'   => array(
		'condition'     => "Валюта, в которой предоставляется заем",
		'conditionText' => "Рубли РФ",
	),
	'4'   => array(
		'condition'     => "Процентная ставка (процентные ставки) (в процентах годовых) или порядок ее (их) определения",
		'conditionText' => "{$aConditionInfo['percent_year']} (" . Num2Words::doConvert($aConditionInfo['percent_year'], Num2Words::C_INT) . ") % годовых",
	),
	'5'   => array(
		'condition'     => "Порядок определения курса иностранной валюты при переводе денежных средств
			                кредитором третьему лицу, указанному заемщиком",
		'conditionText' => "Не применимо",
	),
	'6'   => array(
		'condition'     => "Количество, размер и периодичность (сроки) платежей заемщика по договору или порядок определения этих платежей",
		'conditionText' => "Количество платежей – 1<br>
							Размер платежа – {$aConditionInfo['pay_amount']} руб.<br>
							Срок платежа – через {$aConditionInfo['loan_lifetime']} дней с даты заключения Договора.",
	),
	'7'   => array(
		'condition'     => "Порядок изменения количества, размера и периодичности (сроков) платежей заемщика
			                при частичном досрочном возврате займа",
		'conditionText' => "Порядок изменения количества, размера и периодичности платежей Заемщика при частичном
		                    досрочном возврате займа отражается в Графике платежей, который формируется
		                    в личном кабинете Заемщика на сайте www.kreddy.ru",
	),
	'8'   => array(
		'condition'     => "Способы исполнения заемщиком обязательств по договору по месту нахождения заемщика",
		'conditionText' => "1) Со счета банковской карты международной платежной системы Visa или MasterCard<br>
							2) Со счета мобильного телефона, указанного в Заявлении на предоставление займа<br>
							3) С использованием электронного средства платежа Яндекс.Деньги<br>
							4) С использованием электронного средства платежа через Qiwi-кошелек<br>
							5) Через терминалы Элекснет<br>
							6) Через терминалы МКБ",
	),
	'8.1' => array(
		'condition'     => "Бесплатный способ исполнения заемщиком обязательств по договору",
		'conditionText' => "1) Со счета банковской карты международной платежной системы Visa или MasterCard<br>
							2) С использованием электронного средства платежа через Яндекс.Деньги<br>
							3) С использованием электронного средства платежа через Qiwi-кошелек<br>
							4) Через терминалы Элекснет <br>
							5) Через терминалы МКБ",
	),
	'9'   => array(
		'condition'     => "Обязанность заемщика заключить иные договоры",
		'conditionText' => 'Договор займа заключен под условием заключения
		                    <span style="text-decoration: underline">Договора</span>
		                    (<span style="text-decoration: underline">Оферты</span>) о предоставлении
		                    Сервиса КРЕДДИ',
	),
	'10'  => array(
		'condition'     => "Обязанность заемщика по предоставлению обеспечения исполнения обязательств по договору и требования к такому обеспечению",
		'conditionText' => "Не применимо",
	),
	'11'  => array(
		'condition'     => "Цели использования заемщиком потребительского займа",
		'conditionText' => "Не применимо",
	),
	'12'  => array(
		'condition'     => "Ответственность заемщика за ненадлежащее исполнение условий договора, размер неустойки
			                (штрафа, пени) или порядок их определения",
		'conditionText' => "В случае невозврата Заемщиком Суммы микрозайма, подлежит уплате неустойка
		                    в виде пени за каждый день просрочки в размере {$aConditionInfo['fine_percent']} % в день
		                    до даты полного возврата, но не более 1 года.",
	),
	'13'  => array(
		'condition'     => "Условие об уступке кредитором третьим лицам прав (требований) по договору",
		'conditionText' => "Заемщик дает согласие на уступку кредитором третьим лицам прав требований.",
	),
	'14'  => array(
		'condition'     => "Согласие заемщика с общими условиями договора",
		'conditionText' => "Заемщик подтверждает, что им прочитаны и поняты Общие условия.
		                    Заемщик согласен с Общими условиями Договора.",
	),
	'15'  => array(
		'condition'     => "Услуги, оказываемые кредитором заемщику за отдельную плату и необходимые
			                для заключения договора, их цена или порядок ее определения, а также согласие
			                заемщика на оказание таких услуг",
		'conditionText' => "Заемщик дает согласие на подключение Сервиса «Кредди» сроком на
							{$aConditionInfo['subscription_lifetime']} дней, стоимость услуги $sSubscriptionRub руб.
							$sSubscriptionKop коп. Заемщик ознакомлен с условиями оказания услуг,
							указанных в Оферте на подключение Сервиса и принимает их.",
	),
	'16'  => array(
		'condition'     => "Способы обмена информацией между кредитором и заемщиком",
		'conditionText' => "- Заемщик обязан уведомлять Займодавца об изменении данных, указанных в Заявлении
		                    о предоставление займа путем внесения новых данных в такое Заявление;<br>
		                    - Займодавец имеет право в одностороннем порядке изменять Общие условия и
		                    уведомлять об изменении Общих условий путем опубликования их на официальном сайте
		                    Займодавца (www.kreddy.ru). Заемщик обязуется ежедневно посещать
		                    официальный сайт Займодавца.<br>
		                    - Заемщик обязуется уведомить Займодавца об отказе от получения займа в
		                    соответствии с настоящими Индивидуальными условиями в течение 5 (пяти) рабочих дней
		                    путем нажатия кнопки «Отказаться» в личном кабинете на официальном сайте Займодавца;<br>
		                    - Займодавец обязан уведомить Заемщика о наличии задолженности в течение 7
		                    (семи) дней с даты ее возникновения путем непосредственного взаимодействия с заемщиком
		                    и (или) используя текстовые, голосовые и иные сообщения по выбору Займодавца.",
	),
	'17'  => array(
		'condition'     => "Порядок уплаты процентов ",
		'conditionText' => "Проценты уплачиваются заемщиком путем внесения денежных средств на расчетный счет
							Займодавца единовременным платежом в день выдачи займа (или в день возврата суммы займа)",
	),
	'18'  => array(
		'condition'     => "Канал выдачи суммы займа ",
		'conditionText' => "Сумма займа перечисляется заемщику " . Dictionaries::$aConditionsTransferChannels[$aConditionInfo['transfer_channel']],
	),
	'19'  => array(
		'condition'     => "Порядок разрешения споров и определение подсудности",
		'conditionText' => "Все споры Стороны договорились решать путем переговоров и путем направления
							претензий. Срок рассмотрения претензий – 10 дней. При отсутствии согласия споры,
							истцом по которым является Займодавец, подлежат разрешению в суде по месту нахождения
							Займодавца, территориальная подсудность которого относится к Таганскому районному
							суду г. Москвы и судебному участку мирового судьи №422 города Москвы.
							В случае, если заемщик выступает истцом, дела рассматриваются в соответствии с подсудностью,
							установленной законодательством РФ о защите прав потребителей",
	),
	'20'  => array(
		'condition'     => "Услуги, оказываемые Займодавцем заемщику без внесения дополнительной платы и согласие
							заемщика на оказание таких услуг",
		'conditionText' => "Заемщик дает согласие на подключение услуги автосписания денежных средств
							со счета банковской карты заемщика после окончания срока пользования суммой
							займа в случае, если сумма займа и (или) проценты за пользование суммой займа не возвращены.",
	),
);

?>

<html>
<head>
	<style>
		body {
			line-height: 1.5;
			letter-spacing: 0;
		}

		table td {
			border: 1px solid #000000;
			padding: 3px;
		}

		table {
			border-collapse: collapse;
			font-size: 16px;
			line-height: 1.5;
		}

		table tbody tr td {
			vertical-align: top;
		}
	</style>
</head>
<body>

<div style="float:left; width: 55%; text-align: justify;">
	<small>г. Москва</small>
	<br> Настоящие Индивидуальные условия являются частью Договора потребительского займа и заключаются между
	микрофинансовой организацией обществом с ограниченной ответственностью «Финансовые Решения», регистрационный номер
	записи в государственном реестре микрофинансовых организаций 2110177000213 от 19 июля 2011 года, в лице генерального
	директора Балашовой А.А. (далее – Займодавец или кредитор) и <?= $aConditionInfo['short_fio'] ?> (далее – заемщик)
</div>
<div style="float: right;font-size: 120%;width: 35%;text-align: justify;border:1px solid #000000;padding: 5px;height: 210px;">
	ПСК <br>
	<?= SiteParams::mb_ucfirst(Num2Words::doConvert($aConditionInfo['xirr'], Num2Words::C_INT)); ?>
	процентов годовых
</div>
<div style="clear: both;"></div>
<table style="width: 100%;margin-top: 40px;">
	<!--Шапка таблицы - повторяется на каждой странице-->
	<thead style="font-weight: normal;text-align: center;vertical-align: middle;">
	<tr>
		<td style="width: 3%;">№<br>п/п</td>
		<td>Условие</td>
		<td>Содержание условия</td>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($aData as $iKey => $aText) { ?>
		<tr>
			<td style="text-align: center;"><?= $iKey; ?>.</td>
			<td><?= $aText['condition']; ?></td>
			<td><?= $aText['conditionText']; ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
</body>
</html>