<?php
/**
 * Class ClientJobDataForm
 */
class ClientJobDataForm extends ClientFullForm
{
	/**
	 * @return array
	 */
	public function rules()
	{
		// всегда обязательные поля
		$aRequired = array(
			'job_company',
			'job_position',
			'job_phone',
			'job_time',
			'job_monthly_income',
			'job_monthly_outcome',
			//'have_past_credit',

			'status',
		);

		$aRules = $this->getRulesByFields(
			array(
				'job_company',
				'job_position',
				'job_phone',
				'job_time',
				'job_monthly_income',
				'job_monthly_outcome',
				//'have_past_credit',
				'status',

				'friends_phone',
				'relatives_one_phone',
				'phone',
				'status'
			),
			$aRequired
		);

		return $aRules;
	}

	/**
	 * @return array
	 */
	public function attributeNames()
	{
		return array(
			'job_company',
			'job_position',
			'job_phone',
			'job_time',
			'job_monthly_income',
			'job_monthly_outcome',
			//'have_past_credit',

			//обязательно требуется для валидации, берется из информации предыдущих форм
			'friends_phone',
			'phone',
			'relatives_one_phone',
			'status'
		);
	}
}
