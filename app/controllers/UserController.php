<?php

class UserController extends \BaseController {

	// Vista principal de ordenes
	public function index()
	{
		$params = array(
					'active' => 'customer/orders/report'
				);
		return View::make('users.orders')->with($params);
	}

	// Funcion para realizar la busqueda de ordenes
	public function search()
	{
		// DataTable params
		$pagina		= Input::get('sEcho');
		$start  	= Input::get('iDisplayStart');
		$limit		= Input::get('iDisplayLength');

		//Rows config
		$dic 		= array();

		$dic[0] 	= "id";
		$dic[1] 	= "full_name";
		$dic[2] 	= "created_at";
		$dic[3] 	= "updated_at";
		$dic[4] 	= "parcel_id";
		$dic[5]		= "parcel_number";
		$dic[6]		= "shipping_cost";
		$dic[7]		= "sub_total";
		$dic[8]		= "total";
		$dic[9]		= "status_id";
		$dic[10]	= "payed";

		// Order
		$order 		= $dic[Input::get('iSortCol_0')]; 
		$by 		= strtoupper(Input::get('sSortDir_0'));

		// Search critelial
		$condition 	= Input::has('sSearch') && Input::get('sSearch') !="" ? Input::get('sSearch') : null;

		// Total items
		$total 		= 0;
		if(is_null($condition)) $total = Order::all()->count();
		else {

			$total 	= Order::with('user','parcel','payment_type')
								  ->whereHas('user', function($query) use ($condition) {
								  	$query->whereNested(function($query) use ($condition) {
								  		$query->where('name','LIKE',"%{$condition}%")
								  			  ->orWhere('first_name','LIKE',"%{$condition}%")
								  			  ->orWhere('last_name','LIKE',"%{$condition}%")
								  			  ->orWhere(DB::raw('CONCAT(name," ",first_name," ",last_name)'),'LIKE',"%{$condition}%")
								  			  ->orWhere('email','LIKE',"%{$condition}%");
								  	});
								  })
								  ->orWhereHas('parcel', function($query) use ($condition) {
								  	$query->whereNested(function($query) use ($condition) {
								  		$query->where('label','LIKE',"%{$condition}%");
								  	});
								  })
								  ->orWhereHas('payment_type', function($query) use ($condition) {
								  	$query->whereNested(function($query) use ($condition) {
								  		$query->where('label','LIKE',"%{$condition}%");
								  	});
								  })
								  ->orWhere('parcel_number','LIKE',"%{$condition}%")
								  ->orWhere('id','=',"{$condition}")
								  ->count();
		}

		// Full result
		$dbOrders 	= array();

		if(!is_null($condition)) {

			$dbOrders = Order::with('user','items','status','parcel','payment_type','admin')
									->whereHas('user', function($query) use ($condition,$order,$by) {
									  	$query->whereNested(function($query) use ($condition,$order,$by) {
									  		$query->where('name','LIKE',"%{$condition}%")
									  			  ->orWhere('first_name','LIKE',"%{$condition}%")
									  			  ->orWhere('last_name','LIKE',"%{$condition}%")
									  			  ->orWhere(DB::raw('CONCAT(name," ",first_name," ",last_name)'),'LIKE',"%{$condition}%")
									  			  ->orWhere('email','LIKE',"%{$condition}%")
									  			  ->orderBy($order,$by);
									  	});
									  })
									->orWhereHas('parcel', function($query) use ($condition) {
									  	$query->whereNested(function($query) use ($condition) {
									  		$query->where('label','LIKE',"%{$condition}%");
									  	});
									  })
									->orWhereHas('payment_type', function($query) use ($condition) {
									  	$query->whereNested(function($query) use ($condition) {
									  		$query->where('label','LIKE',"%{$condition}%");
									  	});
									  })
									->orWhere('parcel_number','LIKE',"%{$condition}%")
									->orWhere('id','=',"{$condition}")
									//->whereNotNull($order)
									->take($limit)
									->skip($start)
									->orderBy($order,$by)
									->get();
		} else {

			$dbOrders = Order::with('user','items','status','parcel','payment_type','admin')
									->whereHas('user', function($query) use ($order,$by) {
									  	$query->whereNested(function($query) use ($order,$by) {
									  		$query->orderBy($order,$by);
									  	});
									  })
									->take($limit)
									->skip($start)
									//->whereNotNull($order)
									->orderBy($order,$by)
									->get();
		}

		// Paqueterias
		$parcels = Parcel::all();

		// Orders to display
		$orders 	= array();

		foreach ($dbOrders as $_order) {
			
			$order 					= array();
			$order['id']			= $_order->id;
			$order['full_name']		= $_order->user->name . ' ' . $_order->user->first_name . ' ' . $_order->user->last_name;
			$order['created_at']	= $_order->created_at->toDateTimeString();
			$order['updated_at']	= $_order->updated_at->toDateTimeString();
			$order['parcel_id']		= $_order->parcel_id;
			$order['parcel_number']	= $_order->parcel_number;
			$order['shipping_cost']	= (int)$_order->shipping_cost;
			$order['sub_total']		= $_order->items->sum('total');
			$order['total']			= ((int)$_order->items->sum('total')+(int)$_order->shipping_cost);
			$order['status_id']		= $_order->status_id;
			$order['payed']			= $_order->payed;
			$order['parcels'] 		= $parcels;

			$orders[]				= $order;
		}

		/*
		 * Output
		 */
		$output = array(
			"sEcho" 				=> $pagina,
			"iTotalRecords" 		=> count($orders),
			"iTotalDisplayRecords" 	=> $total,
			"aaData" 				=> $orders
		);

		return Response::json($output, 200);
	}

		// Actualizacion de paqueteria de una orden
	public function parcelUpdate()
	{
		$id 	= Input::get('id');
		$parcel = Input::get('parcel');

		try {
			
			$order = Order::find($id);

			if(!$order) return Response::json(array('status' => false, 'message' => 'Orden no localizada'),200);

			$order->parcel_id = $parcel;

			if(!$order->save()) return Response::json(array('status' => false, 'message' => 'La orden no puso ser actualizada'),200);

			return Response::json(array('status' => true, 'message' => 'Orden actualizada'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema la actualizar la orden [' . $e->getMessage() . ']'),200);
		}
	}

	// Asignacion de un numero de guia
	public function numGuide()
	{
		$id 	= Input::get('id');
		$guide 	= Input::get('guide');

		try {
			
			$order = Order::find($id);

			if(!$order) return Response::json(array('status' => false, 'message' => 'Orden no localizada'),200);

			$order->parcel_number = $guide;

			if(!$order->save()) return Response::json(array('status' => false, 'message' => 'La orden no puso ser actualizada'),200);

			return Response::json(array('status' => true, 'message' => 'Orden actualizada'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema la actualizar la orden [' . $e->getMessage() . ']'),200);
		}
	}

	// Asignacion de un numero de guia
	public function shippingCost()
	{
		$id 	= Input::get('id');
		$cost 	= Input::get('cost');

		try {
			
			$order = Order::find($id);

			if(!$order) return Response::json(array('status' => false, 'message' => 'Orden no localizada'),200);

			$order->shipping_cost 	= $cost;

			if(!$order->save()) return Response::json(array('status' => false, 'message' => 'La orden no puso ser actualizada'),200);

			return Response::json(array('status' => true, 'message' => 'Orden actualizada'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema la actualizar la orden [' . $e->getMessage() . ']'),200);
		}
	}

	// Actualizacion de estatus de una orden
	public function statusUpdate()
	{
		$id 	= Input::get('id');
		$status = Input::get('status');

		try {
			
			$order = Order::find($id);

			if(!$order) return Response::json(array('status' => false, 'message' => 'Orden no localizada'),200);

			$order->status_id = $status;

			if(!$order->save()) return Response::json(array('status' => false, 'message' => 'La orden no puso ser actualizada'),200);

			return Response::json(array('status' => true, 'message' => 'Orden actualizada'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema la actualizar la orden [' . $e->getMessage() . ']'),200);
		}
	}

	// Actualizacion de estatus de pago en una orden
	public function payedUpdate()
	{
		$id 	= Input::get('id');
		$status = Input::get('status');

		try {
			
			$order = Order::find($id);

			if(!$order) return Response::json(array('status' => false, 'message' => 'Orden no localizada'),200);

			$order->payed = $status;

			if(!$order->save()) return Response::json(array('status' => false, 'message' => 'La orden no puso ser actualizada'),200);

			return Response::json(array('status' => true, 'message' => 'Orden actualizada'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema la actualizar la orden [' . $e->getMessage() . ']'),200);
		}
	}

	// Funcion para obtener el detalle de la orden
	public function orderDetail()
	{
		$id 	= Input::get('id');
		$url 	= Config::get('btsite.url') . Config::get('btsite.img_catalog'); 

		try {

			$order = Order::with(array(
						'user' 	=> function($query){ $query->with('type'); },
						'items' => function($query){ $query->with('Product'); },
						'notes' => function($query){ $query->with(array('User','Reply' => function($query) { $query->with('Admin'); })); }
					))
		            ->where('id',$id)
		            ->first();

		    if(!$order) return Response::json(array('status' => false, 'message' => 'No se encontraron articulos para esta orden'),200);

		    return Response::json(array('status' => true, 'message' => 'Articulos localizados', 'order' => $order,'url' => $url),200);
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al obtener la informacion de la orden [' . $e->getMessage() . ']'),200);
		}
	}

	// Funcion para actualizar el stado de surtido de un item de una orden
	public function orderItemDone()
	{
		$item_id 	= Input::get('item_id');

		try {

			$item = Item::find($item_id);

			if(!$item) return Response::json(array('status' => false, 'message' => 'No se localizo el articulo seleccionado'));

			$item->done = 1;

			if(!$item->save()) return Response::json(array('status' => false, 'message' => 'El articulo no pudo ser actualizado'));

			return Response::json(array('status' => true, 'message' => 'Articulo actualizado correctamente'));

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar el articulo en la orden [' . $e->getMessage() . ']'));
		}
	}

	// Funcion para actualizar el stado de surtido de un item de una orden
	public function orderItemDel()
	{
		$order_id 	= Input::get('order_id');
		$item_id 	= Input::get('item_id');

		try {

			DB::beginTransaction();

			$item = Item::find($item_id);
			$order = Order::find($order_id);

			if(!$item || !$order) return Response::json(array('status' => false, 'message' => 'La orden o el articulo no pudieron ser encontrados'));

			if(!$order->items()->detach($item_id)) return Response::json(array('status' => false, 'message' => 'El item no puso ser eliminado de la orden seleccionada'));

			if(!$item->delete()) {
				DB::rollback();
				return Response::json(array('status' => false, 'message' => 'El item no puso ser eliminado de la orden seleccionada'));
			}

			DB::commit();

			return Response::json(array('status' => true, 'message' => 'Item eliminado correctamente'));

		} catch (Exception $e) {
			DB::rollback();
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al eliminar el item en la orden [' . $e->getMessage() . ']'));
		}
	}

	// Remplazo de item
	public function orderItemReplace()
	{
		$user_id 			= Input::get('uid');
		$order_id 			= Input::get('order_id');
		$original_item_id 	= Input::get('original_item_id');
		$user_type_id 		= Input::get('user_type');
		$price 				= Input::get('price');
		$quanty 			= Input::get('quanty');
		$total 				= Input::get('sub_total');
		$lang 				= Input::get('lang');
		$currency			= Input::get('currency');

		$new_item_id 		= Input::get('new_item_id');
		$code 				= Input::get('code');


		try {

			DB::beginTransaction();

			// Verificamos si la orden existe
			$order 			= Order::find($order_id);

			if(!$order) return Response::json(array('status' => false, 'message' => 'La orden no pudo ser localizada'));

			// Verificamos si el item original existe
			$item 			= Item::find($original_item_id);

			if(!$item) return Response::json(array('status' => false, 'message' => 'El item seleccionado no pudo ser localizado'));

			// Verificamos si el articulo nueva ya existe en la base de datos
			$order_items	= Order::with(array('items' => function($query) use ($new_item_id) { $query->where('product_id',$new_item_id); }))->where('id',$order_id)->first();

			if($order_items->items->count()>0) return Response::json(array('status' => false, 'message' => 'El articulo de remplazo ya existe en la base de datos'));

			// Obtenemos el tipo de cambio establesido
			$exchange_rate = SiteConfiguration::first();

			if(!$exchange_rate) return Response::json(array('status' => false, 'message' => 'No pudo ser localizado el tipo de cambio actual'));

			// Agregamos el nuevo articulo a la orden seleccionaa
			$new_item 					= new Item();
			$new_item->product_id 		= $new_item_id;
			$new_item->price 			= $price;
			$new_item->quanty 			= $quanty;
			$new_item->total 			= $total;
			$new_item->languaje			= $lang;
			$new_item->currency			= $currency;
			$new_item->exchange_rate	= $exchange_rate->exchange_rate;

			if(!$new_item->save()) return Response::json(array('status' => false, 'message' => 'El item no pudo ser remplazado de la orden seleccionada'));

			// Eliminamos el item seleccionado
			if(!$item->delete()) return Response::json(array('status' => false, 'message' => 'El item no pudo ser remplazado de la orden seleccionada'));

			// Adjuntamos el nuevo articulo a la ordern
			$order->items()->attach($new_item->id);
			//if(!$order->items()->attach($new_item->id)) {
			//	DB::rollback();
			//	return Response::json(array('status' => false, 'message' => 'El item no pudo ser remplazado de la orden seleccionada'));
			//}

			DB::commit();
			return Response::json(array('status' => true, 'message' => 'Item remplazado correctamente','oi' => $order->id));

		} catch (Exception $e) {
			DB::rollback();
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al eliminar el item en la orden [' . $e->getMessage() . ']'));
		}

	}

	// Autocomplet
	public function orderItemSearch()
	{
		$term = Input::get('term');

		try {

			$product = Product::where('code','LIKE',"%{$term}%")->get();

			if(!$product) return Response::json(array('status' => false, 'message' => 'No se encontraron productos con ese criterio de busqueda'));

			return $product;

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al realizar la busqueda del producto [' . $e->getMessage() . ']'));
		}

	}

	// Envio de notificacion a un cliente
	public function orderNotify()
	{
		$order_id 	= Input::get('order');
		$notify 	= Input::get('message');

		try {
			
			$order = Order::with(array('status','user' => function($query){
						$query->with('utype');
					},'order_items' => function($query){
						$query->with('Product');
					}))
					->where('id',$order_id)
					->first();

			if(!$order) return Response::json(array('status' => false, 'message' => 'Informacion de orden no localizada'));

			$params = array(
                'customer_name' => $order->user->name.' '.$order->user->first_name.' '.$order->user->last_name,
                'order_id'      => $order_id,
                'status'        => $order->status->label,
                'parcel'        => ($order->parcel_id==0?'Ninguna':$order->parcel->label),
                'guide'         => $order->parcel_number,
                'shipping_cost' => "$".number_format($order->shipping_cost,2),
                'sub_total'     => "$".number_format($order->items->sum('total'),2),
                'total'         => "$".number_format(($order->items->sum('total')+$order->shipping_cost),2),
                'note'          => $notify//$order->notes
            );

            $user_email = $order->user->email;
            $user_name 	= $order->user->name.' '.$order->user->first_name.' '.$order->user->last_name;

            $view 		= View::make('emails.notify', $params);
            $contents 	= (string) $view;

            $notify = new NotifyReport();
            $notify->full_name = $user_name;
            $notify->email = $user_email;
            $notify->estatus = $order->status->nombre;
            $notify->order_number = $order_id;
            $notify->email_doc = $contents;
            
            if(!$notify->save()) return Response::json(array('status' => false, 'message' => 'La notificacion no pudo ser guardada en el sistema'));

            Mail::send('emails.notify', $params, function($message) use ($user_email,$user_name) {
		        $message->to($user_email, $user_name)->subject('Su orden ha sido actualizada');
		    });

		    return Response::json(array('status' => true, 'message' => 'Notificacion enviada con exito'));

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un error en el envio de la notificacion'));
		}
	}

	// Funcion para agregar informacion adicional a la orden
	public function orderAditional()
	{
		$order_id 	= Input::get('order_id');
		$p_type 	= Input::get('payment_type');
		$p_data 	= Input::get('payment_data');

		try {

			DB::beginTransaction();

			$order = Order::find($order_id);

			if(!$order) return Response::json(array('status' => false, 'message' => 'La orden no pudo ser localizada'));

			$order->payment_type_id = $p_type;
			$order->payment_detail = $p_data;

			if(!$order->save()) return Response::json(array('status' => false, 'message' => 'La orden no pudo ser actualizada'));

			DB::commit();

			return Response::json(array('status' => true, 'message' => 'Orden actualizada correctamente'));

		} catch (Exception $e) {
			DB::rollback();
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar la orden [' . $e->getMessage() . ']'));
		}
	}

	// Funcion para responder una pregunta de un articulo
	public function orderNoteReply()
	{
		$note_id 	= Input::get('note_id');
		$reply 		= Input::get('reply');

		try {

			$note = Note::find($note_id);

			if(!$note) return Response::json(array('status' => false, 'message' => 'No se localizo la nota seleccionada'));

			$rpl 			= new Reply();
			$rpl->note_id 	= $note_id;
			$rpl->admin_id 	= Auth::user()->id;
			$rpl->text 		= $reply;

			if(!$rpl->save()) return Response::json(array('status' => false, 'message' => 'La respuesta no pudo ser guardada'));

			$order = Order::with(array('user','notes' => function($query) { $query->with(array('User','Reply' => function($query) { $query->with('admin'); })); }))->where('id',$note->order_id)->first();

			return Response::json(array('status' => true, 'message' => 'Nota respondida exitosamente', 'notes' => $order->notes));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al guardar la respuesta [' . $e->getMessage() . ']'));
		}

	}

	// Funcion para obtener el carrito de un usuario
	public function carts()
	{
		$params = array(
					'active' => 'customer/carts/report'
				);

		return View::make('users.carts')->with($params);
	}

	// Funcion para buscar en la coleccion de carritos
	public function cartSearch()
	{
		// DataTable params
		$pagina		= Input::get('sEcho');
		$start  	= Input::get('iDisplayStart');
		$limit		= Input::get('iDisplayLength');

		//Rows config
		$dic 		= array();

		$dic[0] 	= "user_id";
		$dic[1] 	= "full_name";
		$dic[2] 	= "email";
		$dic[3] 	= "type";
		$dic[4] 	= "total";

		// Order
		$order 		= $dic[Input::get('iSortCol_0')]; 
		$by 		= strtoupper(Input::get('sSortDir_0'));

		// Search critelial
		$condition 	= Input::has('sSearch') && Input::get('sSearch') !="" ? Input::get('sSearch') : null;

		// Total items
		$total 		= 0; //$total = VirtualBasket::groupBy('users_id')->count();
		if(is_null($condition)) $total = Cart::groupBy('user_id')->get()->count();
		else {

			$total = Cart::with(array('user' => function($query) { $query->with('type'); }))
					->groupBy('user_id')
		            ->whereHas('user', function($query) use ($condition) {
					  	$query->whereNested(function($query) use ($condition) {
					  		$query->where('name','LIKE',"%{$condition}%")
					  			  ->orWhere('first_name','LIKE',"%{$condition}%")
					  			  ->orWhere('last_name','LIKE',"%{$condition}%")
					  			  ->orWhere(DB::raw('CONCAT(name," ",first_name," ",last_name)'),'LIKE',"%{$condition}%")
					  			  ->orWhere('email','LIKE',"%{$condition}%");
					  	});
					})
					->get()
		            ->count();
		}

		// Full result
		$dbCarts 	= array();

		if(!is_null($condition)) {

			$dbCarts 	= Cart::with(array('user' => function($query) { $query->with('type'); }))
						->groupBy('user_id')
			            ->whereHas('user', function($query) use ($condition) {
						  	$query->whereNested(function($query) use ($condition) {
						  		$query->where('name','LIKE',"%{$condition}%")
						  			  ->orWhere('first_name','LIKE',"%{$condition}%")
						  			  ->orWhere('last_name','LIKE',"%{$condition}%")
						  			  ->orWhere(DB::raw('CONCAT(name," ",first_name," ",last_name)'),'LIKE',"%{$condition}%")
						  			  ->orWhere('email','LIKE',"%{$condition}%");
						  	});
						})
			            ->take($limit)
						->skip($start)
						->orderBy($order,$by)
						->get(array(DB::raw('SUM(total) as grand_total,user_id')));

		} else {

			$dbCarts 	= Cart::with(array('user' => function($query) { $query->with('type'); }))
						->groupBy('user_id')
			            ->whereHas('user', function($query) use ($order,$by) {
						  	$query->whereNested(function($query) use ($order,$by) {
						  		$query->orderBy($order,$by);
						  	});
						})
			            ->take($limit)
						->skip($start)
						->orderBy($order,$by)
						->get(array(DB::raw('SUM(total) as grand_total,user_id')));

		}

		// Orders to display
		$carts 	= array();

		foreach ($dbCarts as $_cart) {
			
			$cart 				= array();
			$cart['user_id']	= $_cart->user_id;
			$cart['full_name']	= $_cart->user->name . ' ' . $_cart->user->first_name . ' ' . $_cart->user->last_name;
			$cart['email']		= $_cart->user->email;
			$cart['type']		= $_cart->user->type->label;
			$cart['total']		= "$".number_format($_cart->grand_total,2);

			$carts[] 			= $cart;
		}

		/*
		 * Output
		 */
		$output = array(
			"sEcho" 				=> $pagina,
			"iTotalRecords" 		=> count($carts),
			"iTotalDisplayRecords" 	=> $total,
			"aaData" 				=> $carts
		);

		return Response::json($output, 200);
	}

	// Funcionp para obtener el detalle de un carrito de un usuario
	public function cartDetail()
	{
		$uid = Input::get('id');
		$url = Config::get('btsite.url') . Config::get('btsite.img_catalog'); 

		try {
			
			$basket = Cart::with(array('user' => function($query) { $query->with('type'); }))->where('user_id',$uid)->get();

			if(!$basket) return Response::json(array('status' => true, 'message' => 'No se pudo obtener la informacion del carrito seleccionado'));

			$total = $basket->sum('total');

			return Response::json(array('status' => true, 'message' => 'Informacion de carrito localizada', 'total' => "$".number_format($total,2), 'basket' => $basket, 'url' => $url));

		} catch (Exception $e) {
			return Response::json(array('status' => true, 'message' => 'Ocurrio un porblema al obtener la informacion del carrito [' . $e->getMessage() . ']'));
		}
	}

	// Funcion para obtener el listado de clientes del sistema
	public function show()
	{
		$countries 	= Country::all();
		$states 	= State::all();

		$params 	= array(
						'active' => 'customer',
						'countries' => $countries,
						'states' => $states
					);
		return View::make('users.list')->with($params);
	}

	// Listado y busqueda de clientes
	public function customerList()
	{
		// DataTable params
		$pagina		= Input::get('sEcho');
		$start  	= Input::get('iDisplayStart');
		$limit		= Input::get('iDisplayLength');

		//Rows config
		$dic 		= array();

		$dic[0] 	= "id";
		$dic[1] 	= "full_name";
		$dic[2] 	= "email";
		$dic[3] 	= "city";
		$dic[4] 	= "state_id";
		$dic[5]		= "address";
		$dic[6]		= "phone";
		$dic[7]		= "interest";
		$dic[8]		= "type";
		$dic[9]		= "status";

		// Order
		$order 		= $dic[Input::get('iSortCol_0')]; 
		$by 		= strtoupper(Input::get('sSortDir_0'));

		// Search critelial
		$condition 	= Input::has('sSearch') && Input::get('sSearch') !="" ? Input::get('sSearch') : null;

		// Total items
		$total 		= 0;
		if(is_null($condition)) $total = User::all()->count();
		else
		{
			$total 	= User::with('state','interest','type')
									  ->whereHas('state', function($query) use ($condition) {
									  	$query->whereNested(function($query) use ($condition) {
									  		$query->where('name','LIKE',"%{$condition}%");
									  	});
									  })
									  ->orWhereHas('interest', function($query) use ($condition) {
									  	$query->whereNested(function($query) use ($condition) {
									  		$query->where('label','LIKE',"%{$condition}%");
									  	});
									  })
									  ->orWhereHas('type', function($query) use ($condition) {
									  	$query->whereNested(function($query) use ($condition) {
									  		$query->where('label','LIKE',"%{$condition}%");
									  	});
									  })
									  ->orWhere('name','LIKE',"%{$condition}%")
									  ->orWhere('first_name','LIKE',"%{$condition}%")
									  ->orWhere('last_name','LIKE',"%{$condition}%")
									  ->orWhere(DB::raw('CONCAT(name," ",first_name," ",last_name)'),'LIKE',"%{$condition}%")
									  ->orWhere('city','LIKE',"%{$condition}%")
									  ->orWhere('company','LIKE',"%{$condition}%")
									  ->orWhere('email','LIKE',"%{$condition}%")
									  ->orWhere('phone','LIKE',"%{$condition}%")
									  ->orWhere('id','=',"{$condition}")
									  ->get()
									  ->count();
		}

		// Full result
		$dbUsers 	= array();

		if(!is_null($condition)) {

			$dbUsers = User::with('state','interest','type')
						->whereHas('state', function($query) use ($condition) {
							$query->whereNested(function($query) use ($condition) {
								$query->where('name','LIKE',"%{$condition}%");
							});
						})
						->orWhereHas('interest', function($query) use ($condition) {
							$query->whereNested(function($query) use ($condition) {
								$query->where('label','LIKE',"%{$condition}%");
							});
						})
						->orWhereHas('type', function($query) use ($condition) {
							$query->whereNested(function($query) use ($condition) {
								$query->where('label','LIKE',"%{$condition}%");
							});
						})
						->orWhere('name','LIKE',"%{$condition}%")
						->orWhere('first_name','LIKE',"%{$condition}%")
						->orWhere('last_name','LIKE',"%{$condition}%")
						->orWhere(DB::raw('CONCAT(name," ",first_name," ",last_name)'),'LIKE',"%{$condition}%")
						->orWhere('city','LIKE',"%{$condition}%")
						->orWhere('company','LIKE',"%{$condition}%")
						->orWhere('email','LIKE',"%{$condition}%")
						->orWhere('phone','LIKE',"%{$condition}%")
						->orWhere('id','=',"{$condition}")
						->take($limit)
						->skip($start)
						->orderBy($order,$by)
						->get();
		} else {

			$dbUsers = User::with('state','interest','type')
						->whereHas('state', function($query) use ($order,$by) {
						  	$query->whereNested(function($query) use ($order,$by) {
						  		$query->orderBy($order,$by);
						  	});
						})
						->whereHas('interest', function($query) use ($order,$by) {
						  	$query->whereNested(function($query) use ($order,$by) {
						  		$query->orderBy($order,$by);
						  	});
						})
						->whereHas('type', function($query) use ($order,$by) {
						  	$query->whereNested(function($query) use ($order,$by) {
						  		$query->orderBy($order,$by);
						  	});
						})
						->take($limit)
						->skip($start)
						->orderBy($order,$by)
						->get();
		}

		// Users to display
		$users 	= array();

		foreach ($dbUsers as $_user) {
			
			$user 					= array();
			$user['id']				= $_user->id;
			$user['name']			= $_user->name;
			$user['fist_name']		= $_user->first_name;
			$user['last_name']		= $_user->last_name;
			$user['full_name']		= $_user->name . ' ' . $_user->first_name . ' ' . $_user->last_name;
			$user['email']			= $_user->email;
			$user['lada']			= $_user->lada;
			$user['phone_number']	= $_user->phone;
			$user['phone']			= '(' . $_user->lada . ') ' . $_user->phone;
			$user['city']			= $_user->city;
			$user['state_id']		= $_user->state_id;
			$user['state']			= $_user->state->name;
			$user['address']		= $_user->address;
			$user['interest']		= $_user->interest->label;
			$user['type_id']		= $_user->type_id;
			$user['type']			= $_user->type->label;
			$user['status']			= $_user->status;
			$user['deleted']		= $_user->deleted;

			$users[]				= $user;
		}

		/*
		 * Output
		 */
		$output = array(
			"sEcho" 				=> $pagina,
			"iTotalRecords" 		=> count($users),
			"iTotalDisplayRecords" 	=> $total,
			"aaData" 				=> $users
		);

		return Response::json($output, 200);
	}

	// Eliminacion logica de un usuario
	public function customerDel()
	{
		$id = Input::get('id');

		try {
			
			$user = User::find($id);

			if(!$user) return Response::json(array('status' => false, 'message' => 'El usuario no fue localizado'));

			$user->status = 0;
			$user->deleted = 1;

			if(!$user->save()) return Response::json(array('status' => false, 'message' => 'El usuario no puso ser eliminado'));

			return Response::json(array('status' => true, 'message' => 'Usuario eliminado logicamente de la base de datos'));

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al elimnar al usuario [' . $e->getMessage() . ']'));
		}
	}

	// Traemos la infromacion del usuario seleccionado
	public function customerInfo()
	{
		$id = Input::get('id');

		try {

			$user = User::with('interest')->find($id);

			if(!$user) return Response::json(array('status' => false, 'message' => 'Usuario no localizado'));

			return Response::json(array('status' => true, 'message' => 'Usuario localizado','user' => $user));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al localizar al usuario [' . $e->getMessage() . ']'));
		}
	}

}