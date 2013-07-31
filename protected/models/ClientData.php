<?php

/**
 * This is the model class for table "tbl_client".
 *
 * The followings are the available columns in table 'tbl_client':
 * @property string $client_id
 * @property string $phone
 * @property string $job_phone
 * @property integer $telecoms_operator
 * @property string $first_name
 * @property string $last_name
 * @property string $third_name
 * @property integer $sex
 * @property string $birthday
 * @property string $email
 * @property string $description
 * @property string $passport_series
 * @property string $passport_number
 * @property string $passport_issued
 * @property string $passport_code
 * @property string $passport_date
 * @property string $document
 * @property string $document_number
 * @property string $address_reg_region
 * @property string $address_reg_city
 * @property string $address_reg_address
 * @property string $relatives_one_fio
 * @property string $relatives_one_phone
 * @property string $job_company
 * @property string $job_position
 * @property string $job_time
 * @property string $job_monthly_income
 * @property string $job_monthly_outcome
 * @property integer $have_past_credit
 * @property integer $numeric_code
 * @property integer $product
 * @property integer $get_way
 * @property string $options
 * @property integer $complete
 * @property int $flag_processed
 * @property string $dt_add
 * @property string $dt_update
 * @var $model ClientForm1
 *
 * @method ClientData[] findAll()
 * @method ClientData[] findAllByAttributes()
 */
class ClientData extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ClientData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return array(
            /*
			array('description, passport_code, passport_date, document, document_number, address_reg_region, address_reg_city, address_reg_address, options', 'required'),
			array('telecoms_operator, sex', 'numerical', 'integerOnly'=>true),
			array('client_id', 'length', 'max'=>11),
			array('phone', 'length', 'max'=>10),
			array('first_name, last_name, third_name, email, address_reg_address', 'length', 'max'=>255),
			array('passport_series', 'length', 'max'=>4),
			array('passport_number', 'length', 'max'=>6),
			array('passport_code', 'length', 'max'=>7),
			array('document, address_reg_region, address_reg_city', 'length', 'max'=>100),
			array('document_number', 'length', 'max'=>30),
			array('birthday, dt_add, dt_update', 'safe'),*/
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('client_id, phone, job_phone, telecoms_operator, first_name, last_name, third_name, sex, birthday, email, description, passport_series, passport_number, passport_issued, passport_code, passport_date, document, document_number, address_reg_region, address_reg_city, address_reg_address, relatives_one_fio, relatives_one_phone, job_company, job_position, job_time, job_monthly_income, job_monthly_outcome, have_past_credit, numeric_code, product, get_way, options, complete, dt_add, dt_update, flag_processed', 'safe'),
	
         );
	}

	public function checkClientByPhone($phone)  //проверяем, если ли клиент с таким же номером телефона и заполненной анкетой
	{
		if(($client=$this->find('phone=:phone',array(':phone'=>$phone)))&&($client->complete==1)) //$client->complete - флаг заполненности анкеты
		{
			return true;
		}
		return false;
	}

	public function addClient($model)
	{
		if($client=$this->find('phone=:phone',array(':phone'=>$model->phone)))
		{
			$client->phone=$model->phone;
			$client->dt_add=date('Y-m-d H:i:s', time());//пишем timestamp создания записи
			$client->flag_processed = 0;
			$client->save();
			return $client;
		}
		else
		{
			$this->phone=$model->phone;
			$this->dt_add=date('Y-m-d H:i:s', time());
			$this->flag_processed = 0;
			$this->save();
			return $this;
		}
	}

	public function getClientIdByPhone($phone) //получаем ID клиента по номеру телефона
	{
		if($client=$this->find('phone=:phone',array(':phone'=>$phone)))
		{
			return $client->client_id;
		}
		return false;
	}


	public function getClientDataById($client_id) //получаем данные клиента по ID
	{
		if($client=$this->find('client_id=:client_id',array(':client_id'=>$client_id)))
		{
			return $client->getAttributes();
		}
		return false;
	}

	public function saveClientDataById($clientData,$client_id) //сохраняем данные в запись клиента с ID
	{
		if($client=$this->find('client_id=:client_id',array(':client_id'=>$client_id)))
		{
			$client->setAttributes($clientData);
			$client->save();
			return true;
		} return false;
	}

	public function beforeSave() //перед сохранением создаем timestamp
	{
		$this->dt_update=date('Y-m-d H:i:s', time());
		return parent::beforeSave();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'client_id' => 'Client',
			'phone' => 'Phone',
			'job_phone' => 'Job Phone',
			'telecoms_operator' => 'Telecoms Operator',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'third_name' => 'Third Name',
			'sex' => 'Sex',
			'birthday' => 'Birthday',
			'email' => 'Email',
			'description' => 'Description',
			'passport_series' => 'Passport Series',
			'passport_number' => 'Passport Number',
			'passport_issued' => 'Passport Issued',
			'passport_code' => 'Passport Code',
			'passport_date' => 'Passport Date',
			'document' => 'Document',
			'document_number' => 'Document Number',
			'address_reg_region' => 'Address Reg Region',
			'address_reg_city' => 'Address Reg City',
			'address_reg_address' => 'Address Reg Address',
			'relatives_one_fio' => 'Relatives One Fio',
			'relatives_one_phone' => 'Relatives One Phone',
			'job_company' => 'Job Company',
			'job_position' => 'Job Position',
			'job_time' => 'Job Time',
			'job_monthly_income' => 'Job Monthly Income',
			'job_monthly_outcome' => 'Job Monthly Outcome',
			'have_past_credit' => 'Have Past Credit',
			'numeric_code' => 'Numeric Code',
			'product' => 'Product',
			'get_way' => 'Get Way',
			'options' => 'Options',
			'complete' => 'Complete',
			'dt_add' => 'Dt Add',
			'dt_update' => 'Dt Update',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('client_id',$this->client_id,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('job_phone',$this->job_phone,true);
		$criteria->compare('telecoms_operator',$this->telecoms_operator);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('third_name',$this->third_name,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('passport_series',$this->passport_series,true);
		$criteria->compare('passport_number',$this->passport_number,true);
		$criteria->compare('passport_issued',$this->passport_issued,true);
		$criteria->compare('passport_code',$this->passport_code,true);
		$criteria->compare('passport_date',$this->passport_date,true);
		$criteria->compare('document',$this->document,true);
		$criteria->compare('document_number',$this->document_number,true);
		$criteria->compare('address_reg_region',$this->address_reg_region,true);
		$criteria->compare('address_reg_city',$this->address_reg_city,true);
		$criteria->compare('address_reg_address',$this->address_reg_address,true);
		$criteria->compare('relatives_one_fio',$this->relatives_one_fio,true);
		$criteria->compare('relatives_one_phone',$this->relatives_one_phone,true);
		$criteria->compare('job_company',$this->job_company,true);
		$criteria->compare('job_position',$this->job_position,true);
		$criteria->compare('job_time',$this->job_time,true);
		$criteria->compare('job_monthly_income',$this->job_monthly_income,true);
		$criteria->compare('job_monthly_outcome',$this->job_monthly_outcome,true);
		$criteria->compare('have_past_credit',$this->have_past_credit);
		$criteria->compare('numeric_code',$this->numeric_code);
		$criteria->compare('product',$this->product);
		$criteria->compare('get_way',$this->get_way);
		$criteria->compare('options',$this->options,true);
		$criteria->compare('complete',$this->complete);
		$criteria->compare('dt_add',$this->dt_add,true);
		$criteria->compare('dt_update',$this->dt_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
} 