<?php

namespace FintechFab\ActionsCalc\Controllers;

use Config;
use FintechFab\ActionsCalc\Components\AuthHandler;
use FintechFab\ActionsCalc\Components\Validators;
use FintechFab\ActionsCalc\Models\Terminal;
use Hash;
use Input;
use Redirect;
use Request;
use Session;
use Validator;
use View;

/**
 * Class AuthController
 *
 * @author Ulashev Roman <truetamtam@gmail.com>
 */
class AuthController extends BaseController
{
	/**
	 * @var string
	 */
	protected $layout = 'main';

	/**
	 * Registering new client terminal.
	 *
	 * @return \Illuminate\Http\RedirectResponse|View
	 */
	public function registration()
	{
		if (AuthHandler::isClientRegistered()) {
			return Redirect::route('calc.manage');
		}

		$iTerminalId = Config::get('ff-actions-calc::terminal_id');

		// view form on GET
		if (Request::isMethod('GET')) {
			return $this->make('auth.registration', ['terminal_id' => $iTerminalId]);
		}

		// data
		$aRequestData = Input::all();

		// validation
		$validator = Validator::make($aRequestData, Validators::getTerminalValidators());

		if ($validator->fails()) {
			// копипаст (выше уже есть)
			$iTerminalId = Config::get('ff-actions-calc::terminal_id');
			$aRequestData['id'] = $iTerminalId; // зачем?
			return Redirect::to(route('auth.registration'))->withInput($aRequestData)->withErrors($validator);
		}

		// data valid
		// это не задача контроллера, т.к. относится чисто к созданию терминала
		// хорошо убирать либо в модель терминала, либо в компонент (если он есть)
		$aRequestData['password'] = Hash::make($aRequestData['password']);
		$aRequestData['key'] = (strlen($aRequestData['key']) < 1) ?
			sha1($aRequestData['name'] . microtime(true) . rand(10000, 90000)) : $aRequestData['key'];

		Terminal::create($aRequestData);

		return Redirect::route('calc.manage');
	}

	/**
	 * Updating terminal profile information.
	 *
	 * @return $this|array|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function profile() // TODO: Too fat. To several methods.
	{
		$iTerminalId = Config::get('ff-actions-calc::terminal_id');
		$aRequestData = Input::all();
		/** @var Terminal $oTerminal */
		$oTerminal = Terminal::find($iTerminalId);

		// on GET only opening, and fill in
		// ай-яй-яй. GET/POST это делать роутингом! и больше никак.
		if (Request::isMethod('GET')) {
			return View::make('ff-actions-calc::auth.profile', ['terminal' => $oTerminal]);
		}

		$validator = Validator::make($aRequestData, Validators::getProfileValidators());

		// validation fails
		if ($validator->fails()) {
			// было бы лучше
			// $this->error('auth.profile', $aRequestData, $validator)
			// т.к. оч. часто повтоярется
			$oErrors = $validator->errors();

			return Redirect::to(route('auth.profile'))->withInput($aRequestData)->withErrors($oErrors);
		}

		// а смену пароля вообще лучше всегда делать отдельным разделом "изменить пароль"
		// а не смешивать вместе с редактированием профиля
		// password change
		if (isset($aRequestData['change_password']) && $aRequestData['change_password'] == 1) {

			$validator = Validator::make($aRequestData, Validators::getProfileChangePassValidators());

			if ($validator->fails()) {
				// мелкий, но копипаст
				$oErrors = $validator->errors();

				return Redirect::to(route('auth.profile'))->withInput($aRequestData)->withErrors($oErrors);
			}

			// current password check
			if (Hash::check($aRequestData['current_password'], $oTerminal->password) === false) {
				// мелкий, но копипаст
				$oErrors = $validator->errors();
				$oErrors->add('current_password', 'Текущий пароль и введённый, не совпадают.');

				return Redirect::to(route('auth.profile'))->withInput($aRequestData)->withErrors($oErrors);
			}

			// valid and saving
			$aRequestData['password'] = Hash::make(trim($aRequestData['password']));
			$oTerminal->password = $aRequestData['password'];
		} else {
			unset($aRequestData['password']);
		}

		$oTerminal->fill($aRequestData);

		if ($oTerminal->save()) {
			Session::flash('auth.profile.success', 'Данные успешно обновлены.');

			return Redirect::to(route('auth.profile'))->withInput($aRequestData);
		}

		// чуть выше такая же строка
		return Redirect::to(route('auth.profile'))->withInput($aRequestData);
	}

}