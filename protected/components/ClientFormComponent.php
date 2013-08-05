<?php
/*
 * Компонент ClientForm
 * занимается обработкой данных сессии и cookies
 * и передачей результата по запросу контроллера форм.
 * Также выполняет команды контроллера по обработке форм.
 *
 * Соответствие шага в сессии обрабатываемой форме и отображаемому представлению
 * Шаг - Модель (отображение)     - Представление
 * 0 - ClientSelectProductForm  - client_select_product
 * 1 - ClientGetWayForm         - client_get_way
 * 2 - ClientPersonalDataForm   - client_personal_data
 * 3 - ClientAddressForm        - client_address
 * 4 - ClientJobInfoForm        - client_job_info client
 * 5 - ClientSendForm           - client_send
 * 6 - ______________           - /pages/view/form_sent
 */
class ClientFormComponent
{
	private $client_id;
	private $current_step;
	private $identification_step;
	private $form_complete;
	private $done_steps;


	public function init()
	{
		if (!$this->client_id = Yii::app()->session['client_id']) {
			$this->client_id = false;
		}

		if (!$this->current_step = Yii::app()->session['current_step']) {
			Yii::app()->session['current_step'] = 0;
			$this->current_step = 0;
		}

		if (!$this->done_steps = Yii::app()->session['done_steps']) {
			Yii::app()->session['done_steps'] = 0;
			$this->done_steps = 0;
		}

		if (!$this->form_complete = Yii::app()->session['form_complete']) {
			Yii::app()->session['form_complete'] = false;
			$this->form_complete = false;
		}

		if (!$this->identification_step = Yii::app()->session['identification_step']) {
			Yii::app()->session['identification_step'] = 0;
			$this->identification_step = 0;
		}
	}

	/**
	 * Проверяет, отправлены ли данные с помощью ajax.
	 * НЕ выполняет валидацию модели.
	 *
	 * @return bool
	 */
	public function ajaxValidation()
	{
		$bIsAjax = Yii::app()->request->getIsAjaxRequest();
		$sAjaxClass = Yii::app()->request->getParam('ajax');

		return ($bIsAjax && $sAjaxClass === get_class($this->getFormModel()));
	}

	/**
	 * Функция занимается сохранением данных,
	 * полученных при ajax-валидации,
	 * в сессию, куки и БД
	 *
	 * @param ClientCreateFormAbstract $oClientForm
	 */
	public function saveAjaxData(ClientCreateFormAbstract $oClientForm)
	{


		$aValidFormData = $oClientForm->getValidAttributes();

		if (get_class($oClientForm) === 'ClientPersonalDataForm') {
			if (isset($aValidFormData['phone'])) {
				/**
				 * проверяем, есть ли в куках информация о клиенте
				 * и сравниваем введенный телефон с телефоном в куках.
				 * в случае успешности восстанавливаем client_id из куки.
				 * иначе создаем нового клиента и сохраняем информацию
				 * о нем в сессию и куку.
				 */

				$aCookieData = Cookie::getDataFromCookie('client');

				if (
					$aCookieData &&
					Cookie::compareDataInCookie('client', 'phone', $aValidFormData['phone']) &&
					!empty($aCookieData['client_id'])
				) {
					Yii::app()->session['client_id'] = $aCookieData['client_id'];
					$this->client_id = Yii::app()->session['client_id'];
				} else {
					/**
					 * функция addClient()ищет клиента в базе по телефону,
					 * и если находит - возвращает запись с указанным телефоном как результат,
					 * либо создает новую запись
					 */
					$oClientData = ClientData::addClient($aValidFormData['phone']);
					Yii::app()->session['client_id'] = $oClientData->client_id;

					$this->client_id = $oClientData->client_id;

					$aCookieData = array('client_id' => $oClientData->client_id, 'phone' => $aValidFormData['phone']);
					Cookie::saveDataToCookie('client', $aCookieData);
				}
			}

			if ($this->client_id) {



				$aValidFormData['product'] = Yii::app()->session['ClientSelectProductForm']['product'];
				$aValidFormData['get_way'] = Yii::app()->session['ClientSelectGetWayForm']['get_way'];
				ClientData::saveClientDataById($aValidFormData, $this->client_id);

			}
		} else {
			if ($this->client_id) {
				ClientData::saveClientDataById($aValidFormData, $this->client_id);
				$aValidFormData['client_id'] = $this->client_id;
			}
		}

		Yii::app()->session[get_class($oClientForm)] = $aValidFormData;
		return;
	}

	/**
	 * Выполняет обработку данных формы после проверки.
	 *
	 * @param ClientCreateFormAbstract|ClientSelectProductForm|ClientSelectGetWayForm|ClientPersonalDataForm $oClientForm
	 */
	public function formDataProcess(ClientCreateFormAbstract $oClientForm)
	{
		if (get_class($oClientForm) === 'ClientPersonalDataForm') {

			/**
			 * проверяем, есть ли в куках информация о клиенте
			 * и сравниваем введенный телефон с телефоном в куках.
			 * в случае успешности восстанавливаем client_id из куки.
			 * иначе создаем нового клиента и сохраняем информацию
			 * о нем в сессию и куку.
			 */

			$aCookieData = Cookie::getDataFromCookie('client');

			if (
				$aCookieData &&
				Cookie::compareDataInCookie('client', 'phone', $oClientForm->phone) &&
				!empty($aCookieData['client_id'])
			) {
				Yii::app()->session['client_id'] = $aCookieData['client_id'];
				$this->client_id = Yii::app()->session['client_id'];
			} else {
				/**
				 * функция addClient()ищет клиента в базе по телефону,
				 * и если находит - возвращает запись с указанным телефоном как результат
				 */
				$oClientData = ClientData::addClient($oClientForm);
				Yii::app()->session['client_id'] = $oClientData->client_id;

				$this->client_id = $oClientData->client_id;

				$aCookieData = array('client_id' => $oClientData->client_id, 'phone' => $oClientData->phone);
				Cookie::saveDataToCookie('client', $aCookieData);
			}
			if ($this->client_id) {
				$aClientFormData = $oClientForm->getAttributes();
				$aClientFormData['product'] = Yii::app()->session['ClientSelectProductForm']['product'];
				$aClientFormData['get_way'] = Yii::app()->session['ClientSelectGetWayForm']['get_way'];
				ClientData::saveClientDataById($aClientFormData, $this->client_id);
			}
		} else {
			if ($this->client_id) {
				$aClientFormData = $oClientForm->getAttributes();
				ClientData::saveClientDataById($aClientFormData, $this->client_id);
			}
		}
		$aClientFormData = $oClientForm->getAttributes();
		Yii::app()->session[get_class($oClientForm)] = $aClientFormData;
		return;
	}

	/**
	 * Возвращает номер текущего шага (нумерация с нуля)
	 *
	 * @return int
	 */
	public function getCurrentStep()
	{
		$this->current_step = Yii::app()->session['current_step'];

		return $this->current_step;
	}

	/**
	 * Возвращает число пройденных шагов (нумерация с нуля)
	 *
	 * @return int
	 */
	public function getDoneSteps()
	{
		$this->done_steps = Yii::app()->session['done_steps'];

		return $this->done_steps;
	}

	private function formComplete()
	{
		Yii::app()->session['current_step']=0;
		Yii::app()->session['done_steps']=0;
		Yii::app()->session['form_complete']=true;
		Yii::app()->session['identification_step']=0;

		/*
		Yii::app()->session['ClientSelectProductForm']=null;
		Yii::app()->session['ClientSelectGetWayForm']=null;
		Yii::app()->session['ClientPersonalDataForm']=null;
		Yii::app()->session['ClientAddressForm']=null;
		Yii::app()->session['ClientJobInfoForm']=null;
		Yii::app()->session['ClientSendForm']=null;
		*/
	}

	private function startNewForm()
	{
		Yii::app()->session['form_complete']=false;
		Yii::app()->session['identification_step']=0;
	}

	/**
	 * Возвращает модель текущей формы.
	 *
	 * @return ClientCreateFormAbstract|null
	 */

	public function getFormModel() //возвращает модель, соответствующую текущему шагу заполнения формы
	{
		/**
		 * Выбор модели формы для уже заполненой анкеты
		 * (по флагу в сессии form_complete)
		 */

		if ($this->current_step == 0
			&& $this->form_complete == true
		) {
			return new InviteToIdentification();
		}

		/**
		 * Выбор модели формы для основных шагов заполнения анкеты
		 */

		switch ($this->current_step) {
			case 0:
				return new ClientSelectProductForm();
				break;
			case 1:
				return new ClientSelectGetWayForm();
				break;
			case 2:
				return new ClientPersonalDataForm();
				break;
			case 3:
				return new ClientAddressForm();
				break;
			case 4:
				return new ClientJobInfoForm();
				break;
			case 5:
				return new ClientSendForm();
				break;
			case 6:
				return new InviteToIdentification();
				break;
			default:
				return new ClientSelectProductForm();
				break;
		}

	}

	/**
	 * Возвращает название необходимого для генерации представления.
	 *
	 * @return string
	 */
	public function getView()
	{
		/**
		 * Выбор представления для уже заполненой анкеты
		 * (по флагу в сессии form_complete)
		 */

		if ($this->current_step == 0 && $this->form_complete==true) {
			switch ($this->identification_step) {
				case 1:
					return 'identification';
					break;
				case 2:
					return 'documents';
					break;
				default:
					return 'invite_to_identification';
					break;
			}
		}

		/**
		 * Выбор представления для основных шагов заполнения анкеты
		 */

		switch ($this->current_step) {
			case 0:
				return 'client_select_product';
				break;
			case 1:
				return 'client_select_get_way';
				break;
			case 2:
				return 'client_personal_data';
				break;
			case 3:
				return 'client_address';
				break;
			case 4:
				return 'client_job_info';
				break;
			case 5:
				return 'client_send';
				break;
			case 6:
			{
				$this->formComplete();
				return 'invite_to_identification';
			}
				break;
			default:
				return 'client_select_product';
				break;
		}
	}

	/**
	 * Возвращает массив отправленных данных, если был выполнен POST-запрос, либо null.
	 *
	 * @return array|bool
	 */
	public function getPostData()
	{
		/**
		 * Выбор данных из POST-запроса для уже заполненой анкеты
		 * (по флагу в сессии form_complete)
		 */

		if ($this->current_step == 0
			&& $this->form_complete == true
			&& $this->identification_step == 0
		) {
			if (isset($_POST['InviteToIdentification'])) {
				return $_POST['InviteToIdentification'];
			}
			return null;
		}

		/**
		 * Выбор данных из POST-запроса для основных шагов заполнения анкеты
		 */
		switch ($this->current_step) {
			case 0:
			{

				if (isset($_POST['ClientSelectProductForm'])) {
					/**
					 * Если получены данные для первой формы, то начинаем новую анкету
					 * (сброс флагов заполненности формы)
					 */
					$this->startNewForm();
					return $_POST['ClientSelectProductForm'];
				}
				return null;
			}
				break;
			case 1:
			{
				if (isset($_POST['ClientSelectGetWayForm'])) {
					return $_POST['ClientSelectGetWayForm'];
				}
				return null;
			}
				break;
			case 2:
			{
				if (isset($_POST['ClientPersonalDataForm'])) {
					return $_POST['ClientPersonalDataForm'];
				}
				return null;
			}
				break;
			case 3:
			{
				if (isset($_POST['ClientAddressForm'])) {
					return $_POST['ClientAddressForm'];
				}
				return null;
			}
				break;
			case 4:
			{
				if (isset($_POST['ClientJobInfoForm'])) {
					return $_POST['ClientJobInfoForm'];
				}
				return null;
				break;
			}
			case 5:
			{
				if (isset($_POST['ClientSendForm'])) {
					return $_POST['ClientSendForm'];
				}
				return null;
			}
				break;
			case 6:
			{
				if (isset($_POST['InviteToIdentification'])) {
					return $_POST['InviteToIdentification'];
				}
				return null;
				break;
			}
			default:
				return null;
				break;

		}
	}

	/*
	 * Переводит обработку форм на следующий шаг
	 *
	 */
	public function nextStep()
	{

		$this->current_step++;
		Yii::app()->session['current_step'] = $this->current_step;
		if ($this->done_steps < Yii::app()->session['current_step']) {
			Yii::app()->session['done_steps'] = $this->done_steps = Yii::app()->session['current_step'];
		}

	}
}
