<?php

class PrintController extends \BaseController {

	public function order($id)
	{
		try {

			$order = Order::with(array(
						'user' => function($query){ $query->with('type'); },
						'items' => function($query){ $query->with('Product'); },
						'status')
					)
		            ->where('id',$id)
		            ->first();

		    if(!$order) return Response::json(array('status' => false, 'message' => 'No se encontraron articulos para esta orden'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al obtener la informacion de la orden [' . $e->getMessage() . ']'),200);
		}

		$params = array(
					'active'	=> 'customer/orders/report',
					'order'		=> $order
				);
		return View::make('common.print')->with($params);
	}

}