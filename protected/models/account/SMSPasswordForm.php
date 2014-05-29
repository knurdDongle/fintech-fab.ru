<?php

/**
 * Class SMSPasswordForm
 */
class SMSPasswordForm extends CFormModel
{
	/**
	 * @var boolean заполненность формы
	 */
	public $smsPassword;
	public $sendSmsPassword;

	/**
	 * @return array
	 */
	public function rules()
	{
		$aRules = array();

		$aRules[] = array('smsPassword', 'required', 'message' => 'Поле обязательно к заполнению', 'on' => 'passRequired');
		$aRules[] = array('smsPassword', 'safe', 'on' => 'sendRequired');
		$aRules[] = array('sendSmsPassword', 'required', 'requiredValue' => 1, 'on' => 'sendRequired');
		$aRules[] = array('sendSmsPassword', 'safe', 'on' => 'passRequired');

		//$aRules[] = array('smsPassword', 'match', 'message' => 'SMS-код состоит из '.SiteParams::C_SMS_CODE_LENGTH.' цифр',
		//	'pattern' => '/^\d{'.SiteParams::C_SMS_CODE_LENGTH.'}$/');

		return $aRules;

	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return array('smsPassword' => 'Пароль из SMS');
	}
}
