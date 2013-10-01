<?php
/**
 * Class DbCleanerCommand
 *
 * SELECT `t1`.`country`,`t2`.`city` FROM `tbl_geo__base` AS `t1`, `tbl_geo__cities` AS `t2` WHERE `t1`.`long_ip1`<='39655352' AND `t1`.`long_ip2`>='39655352' AND `t1`.`city_id`=`t2`.`city_id`
 */
class IpGeoBaseUpdateCommand extends CConsoleCommand
{
	public function actionDownloadDb()
	{
		$ch = curl_init();
		$fp = fopen('geo_files.tar.gz', 'w');

		curl_setopt($ch, CURLOPT_URL,'http://ipgeobase.ru/files/db/Main/geo_files.tar.gz');
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		exec('tar xvfz geo_files.tar.gz');
		unlink('geo_files.tar.gz');
	}

	public function actionUpdateDb()
	{


		set_time_limit(0); // указываем, чтобы скрипт не ограничивался временем по умолчанию
		ignore_user_abort(1); // указываем, чтобы скрипт продолжал работать даже при разрыве

		// проверяем наличие файла cities.txt в папке рядом с этим скриптом
		if(file_exists('cities.txt'))
		{
			$sSqlQuery = "TRUNCATE TABLE `tbl_geo__cities`;";
			Yii::app()->db->createCommand($sSqlQuery)->execute();

			$file = file('cities.txt');
			$pattern = '#(\d+)\s+(.*?)\t+(.*?)\t+(.*?)\t+(.*?)\s+(.*)#';
			foreach ($file as $row)
			{
				$row = iconv('windows-1251', 'utf-8', $row);
				if(preg_match($pattern, $row, $out))
				{
					$sSqlQuery = "INSERT INTO `tbl_geo__cities` (`city_id`, `city`, `region`, `district`, `lat`, `lng`) VALUES('$out[1]', '$out[2]', '$out[3]', '$out[4]', '$out[5]', '$out[6]');";
					Yii::app()->db->createCommand($sSqlQuery)->execute();
				}

			}
		}else
		{
			echo 'Ошибка! Файл cities.txt должен лежать рядом с этим файлом!';
		}

// проверяем наличие файла cidr_optim.txt в папке рядом с этим скриптом
		if(file_exists('cidr_optim.txt'))
		{
			$sSqlQuery = "TRUNCATE TABLE `tbl_geo__base`;";
			Yii::app()->db->createCommand($sSqlQuery)->execute();

			$file = file('cidr_optim.txt');
			$pattern = '#(\d+)\s+(\d+)\s+(\d+\.\d+\.\d+\.\d+)\s+-\s+(\d+\.\d+\.\d+\.\d+)\s+(\w+)\s+(\d+|-)#';
			foreach ($file as $row)
			{
				if(preg_match($pattern, $row, $out))
				{
					$sSqlQuery = "INSERT INTO `tbl_geo__base` (`long_ip1`, `long_ip2`, `ip1`, `ip2`, `country`, `city_id`) VALUES('$out[1]', '$out[2]', '$out[3]', '$out[4]', '$out[5]', '$out[6]');";
					Yii::app()->db->createCommand($sSqlQuery)->execute();
				}
			}

		}else
		{
			echo 'Ошибка! Файл cidr_optim.txt должен лежать рядом с этим файлом!';
		}


		unlink('cidr_optim.txt');
		unlink('cities.txt');

	}
}