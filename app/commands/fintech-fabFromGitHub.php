<?php

use FintechFab\Components\GitHubAPI;
use FintechFab\Models\GitHubComments;
use FintechFab\Models\IGitHubModel;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class FintechFabFromGitHub extends Command {
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fintech-fab:git-hub';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command for receiving of news from GitHub API.';

	/**
	 * Зппросы к API GitHub и ответы
	 * @var GitHubAPI
	 */
	private $gitHubAPI;



	/**
	 * Create a new command instance.
	 */
	public function __construct()
	{
		parent::__construct();
		$owner = Config::get("github.owner");
		$repo = Config::get("github.trainingRepo");

		// лучше: new GitHubAPI($owner, $repo)
		// потому что setRepo здесь только один раз вызывается
		// при создании класса

		// еще может быть стоит, Config::get убрать в класс GitHubAPI
		// т.е. пусть сам настройки читает из конфига
		// но это зависит от того, насколько класс сильно связан с контекстом проекта.
		// если может использоваться отдельно - то не надо в него убирать чтение конфига.

		$this->gitHubAPI = new GitHubAPI();
		$this->gitHubAPI->setRepo($owner, $repo);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$helpOption = $this->option('helpArg');
		if(! empty($helpOption))
		{
			$this->showHelp($helpOption);
			return;
		}

		$this->info("It's OK. Begin...");

		switch($this->argument('Category')) {
			case "comments":
				$maxDate = GitHubComments::max('updated');
				// комментарий бы... что такое $maxDate, зачем - непонятно
				$param = empty($maxDate) ? "" : "since='" . str_replace(" ", "T", $maxDate) . "Z'";

				$this->gitHubAPI->setNewRepoQuery('issues/comments', $param);
				$this->processTheData(GitHubComments::class);
				break;
			case "commits":
				break;
			case "events":
				break;
			case "issues":
				break;
			case "issuesEvents":
				break;
			case "users":
				break;
			default:

		}




	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('Category', InputArgument::OPTIONAL, 'Category of data for request to GitHub API.'),
		);
	}

	/**
	 * Get the console command options.
	 * (help занят, он показывает аргументы и опци, которые здесь есть)
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// честно не понимаю, что значит *|all|:value_of_argument
			array('helpArg', null, InputOption::VALUE_OPTIONAL, 'The help about used argument. --helpArg=*|all|:value_of_argument', null),
		);
	}

	/**
	 * Выводит на экран список используемых значений аргумента или детально по указанному значению
	 * @param string $option
	 */
	private function showHelp($option)
	{
		//
	}


	/**
	 * Загрузка всех данных и вывод сообщений
	 * Объект $this->gitHubAPI должен быть заранее подготовлен к запросам.
	 *
	 * @param Eloquent $dataModel
	 */
	private function processTheData($dataModel)
	{
		while($this->gitHubAPI->doNextRequest())
		{
			$this->info("\nLimit remaining: " . $this->gitHubAPI->getLimitRemaining());
			$this->info("Результат запроса: " . $this->gitHubAPI->messageOfResponse);
			$this->saveInDB($this->gitHubAPI->response, $dataModel);
		}
		if(! $this->gitHubAPI->isDoneRequest())
		{
			$this->info("Результат запроса: " . $this->gitHubAPI->messageOfResponse);
		}
	}

	/**
	 * @param array $inData
	 * @param Eloquent $classDB
	 *
	 * Сохранение или обновление данных в БД,
	 * вывод сообщений на экран по каждой отдельной записи данных (при добавлении в БД, при обновлении).
	 *
	 * $inData  — данные, полученные из GitHub'а
	 * $classDB — имя класса таблицы БД (модель). Заполение и контроль полученных данных выполняется в этой модели.
	 *      Методы, принимающие данные ("dataGitHub($inItem)", "updateFromGitHub($inItem)")
	 *      дают положительный ответ "true", если разрешено сохранять.
	 *
	 * $item->getKeyName() — имя ключевого поля (может быть 'id' или иным). Задается в модели данных.
	 * $item->getMyName()  — нужно для вывода на экран (показать, какие данные сохраняются).
	 */
	private function saveInDB($inData, $classDB)
	{
		$this->info(sprintf("\nAddition to DataBase: %u records...", count($inData)));

		/** @var Eloquent|IGitHubModel $item */
		$item = new $classDB;
		$keyName = $item->getKeyName();
		$myName = $item->getMyName();
		foreach($inData as $inItem)
		{
			$item = $classDB::where($keyName, $inItem->$keyName)->first();
			if(isset($item->$keyName))
			{
				$this->info("Found $myName:" . $item->$keyName);
				if($item->updateFromGitHub($inItem))
				{
					$this->info("Update: " . $item->$keyName);
					$item->save();
				}
			} else
			{
				$item = new $classDB;
				if($item->dataGitHub($inItem))
				{
					$this->info("Addition $myName: " . $inItem->$keyName);
					$item->save();
				}
			}
		}
	}


}
