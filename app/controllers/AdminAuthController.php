<?php

class AdminAuthController extends \BaseController {

	// Formulario de login
	public function login()
	{
		if (Auth::check()) {
            // Si está autenticado lo mandamos a la raíz donde estara el mensaje de bienvenida.
            return Redirect::to('dashboard');
        }
		return View::make('common.login');
	}

	// Recepcion de informacion de loguero
	public function authLogin() {

		$data = [
			'username' 	=> Input::get('username'),
			'password' 	=> Input::get('password'),
			'status'	=> 1
		];

		$remember = Input::has('remember') && Input::get('remember') == 'on' ? true : false;

		if (Auth::attempt($data, $remember)) {
			 return Response::json(array('status'=>true,'message'=>'Inicio de sesion exitoso'),200);
		}

		return Response::json(array('status'=>false,'message'=>'Usuario o contraseña incorrecta'),200);
		
	}

	// Cierre de session
	public function logout() {
		Auth::logout();
		return Redirect::to('login')->with('message', 'Sesión cerrada correctamente');
	}

}