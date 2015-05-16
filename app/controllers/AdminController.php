<?php

class AdminController extends \BaseController {

	// Funcion inicial
	public function index()
	{
		$admins = Admin::with('level')->get();
		$params = array(
					'admins' => $admins,
					'active' => 'system/admins'
				);
		return View::make('system.admins')->with($params);
	}

	// Funcion para actualizar la informacion del administrador
	public function update()
	{
		$uid 	= Input::get('id');
		$name 	= Input::get('name');
		$pass	= Input::get('password');

		try {

			$admin = Admin::find($uid);

			if(!$admin) return Response::json(array('status' => false, 'message' => 'El administrador no fue localizado'),200);

			$admin->name = $name;
			if($pass!=='') $admin->password = Hash::make($pass);

			if($admin->save()) return Response::json(array('status' => true, 'message' => 'Administrador actualizado'),200);
			else return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar al administrador'),200);
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar al administrador [' . $e->getMessage() . ']'),200);
		}
	}

	// Funcion para actualizar el nivel del usuario en el sistema
	public function updateLevel()
	{
		$uid 	= Input::get('id');
		$level 	= Input::get('level');

		try {

			$admin = Admin::find($uid);

			if(!$admin) return Response::json(array('status' => false, 'message' => 'El administrador no fue localizado'),200);

			$admin->admins_level_id = $level;

			if($admin->save()) return Response::json(array('status' => true, 'message' => 'Administrador actualizado'),200);
			else return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar al administrador'),200);
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar al administrador [' . $e->getMessage() . ']'),200);
		}
	}

	// Funcion para actualizar el estatus del usuario en el sistema
	public function updateStatus()
	{
		$uid 		= Input::get('id');
		$status 	= Input::get('status');

		try {

			$admin = Admin::find($uid);

			if(!$admin) return Response::json(array('status' => false, 'message' => 'El administrador no fue localizado'),200);

			$admin->status = $status;

			if($admin->save()) return Response::json(array('status' => true, 'message' => 'Administrador actualizado'),200);
			else return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar al administrador'),200);
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar al administrador [' . $e->getMessage() . ']'),200);
		}
	}

	// Funcion para eliminar un usuario en el sistema
	public function delete()
	{
		$uid 		= Input::get('id');

		try {

			$admin = Admin::find($uid);

			if(!$admin) return Response::json(array('status' => false, 'message' => 'El administrador no fue localizado'),200);

			if($admin->delete()) return Response::json(array('status' => true, 'message' => 'Administrador eliminado'),200);
			else return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al eliminar al administrador'),200);
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al eliminar al administrador [' . $e->getMessage() . ']'),200);
		}
	}

	// Funcion para agregar un usuairo al sistema
	public function add()
	{
		$username 	= Input::get('username');
		$name 		= Input::get('name');
		$level 		= Input::get('level');
		$password	= Input::get('password');

		try {

			$admin = Admin::where('username',"{$username}")->first();

			if($admin) return Response::json(array('status' => true, 'message' => 'El administrador ya existe en el sistema'),200);

			$admin = new Admin();

			$admin->username 			= $username;
			$admin->name 				= $name;
			$admin->admins_level_id 	= $level;
			$admin->password 			= Hash::make($password);

			if($admin->save()) return Response::json(array('status' => true, 'message' => 'Usuario agregado al sistema'),200);
			else return Response::json(array('status' => false, 'message' => 'El usuario no pudo ser agregado al sistema'),200);
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un erro al agregar al usuario al sistema [' . $e->getMessage() . ']'),200);
		}
	}

	// Tipo cambio
	public function tipocambio()
	{

		try {
			$tipocambio = SiteConfiguration::first();
			if(!$tipocambio) return Response::json(array('status' => false, 'message' => 'No se pudo localizar la informacion de tipo de cambio'),200);
			else return Response::json(array('status' => true, 'message' => 'Tipo de cambio localizado', 'tc' => $tipocambio->exchange_rate),200);
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al recuperar el tipo de cambio [' . $e->getMessage() . ']'),200);
		}
	}

	// Actualizacion del tipo de cambio
	public function tcupdate()
	{
		$tc = Input::get('tc');

		try {
			
			$tipocambio = SiteConfiguration::first();

			if(!$tipocambio) return Response::json(array('status' => false, 'message' => 'No se encontro ningun valor existente'),200);

			$tipocambio->exchange_rate = $tc;
			
			if(!$tipocambio->save()) return Response::json(array('status' => false, 'message' => 'No pudo ser actualizado el tipo de cambio'),200);

			return Response::json(array('status' => true, 'message' => 'Tipo de cambio actualizado'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Erro al actualizar el tipo de cambio [' . $e->getMessage() . ']'),200);
		}
	}

}