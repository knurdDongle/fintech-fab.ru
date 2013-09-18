<?php
class m130918_092500_RenameField extends CDbMigration
{
	public function up()
	{

		$this->execute("ALTER TABLE `tbl_client` CHANGE `get_way` `channel_type` TINYINT NOT NULL COMMENT 'Способ получения'");

		if (Yii::app()->hasComponent('cache')) {
			Yii::app()->getComponent('cache')->flush();
			echo "Cache flushed\n";
		}
	}

	public function down()
	{
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
