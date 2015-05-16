<?php

class InventoryController extends \BaseController {

	// Vista principal deinventario
	public function index()
	{
		$params = array(
					'active' => 'products/inventory'
				);

		return View::make('products.list')->with($params);
	}

	// Funcion para busqueda de articulos en la base de datos
	public function search()
	{

		// DataTable params
		$pagina		= Input::get('sEcho');
		$start  	= Input::get('iDisplayStart');
		$limit		= Input::get('iDisplayLength');

		//Rows config
		$dic 		= array();

		$dic[0] 	= "id";
		$dic[1] 	= "pic";
		$dic[2] 	= "code";
		$dic[3] 	= "category_id";
		$dic[4] 	= "sub_category_id";
		$dic[5]		= "description";
		$dic[6]		= "price_public";
		$dic[7]		= "price_half_wholesale";
		$dic[8]		= "price_wholesale";
		$dic[9]		= "price_dealer";
		$dic[10]	= "status";

		// Order
		$order 		= $dic[Input::get('iSortCol_0')]; 
		$by 		= strtoupper(Input::get('sSortDir_0'));

		// Search critelial
		$condition 	= Input::has('sSearch') && Input::get('sSearch') !="" ? Input::get('sSearch') : null;

		// Total items
		$total 		= 0;
		if(is_null($condition)) $total = Product::all()->count();
		else {

			$total 	= Product::with('category','sub_category')
								  ->whereHas('category', function($query) use ($condition) {
								  	$query->whereNested(function($query) use ($condition) {
								  		$query->where('name','LIKE',"%{$condition}%");
								  	});
								  })
								  ->orWhereHas('sub_category', function($query) use ($condition) {
								  	$query->whereNested(function($query) use ($condition) {
								  		$query->where('name','LIKE',"%{$condition}%");
								  	});
								  })
								  ->orWhere('description','LIKE',"%{$condition}%")
								  ->orWhere('code','LIKE',"%{$condition}%")
								  ->get()
								  ->count();
		}

		// Full result
		$dbProducts 	= array();

		if(!is_null($condition)) {

			$dbProducts = Product::with('category','sub_category')
									->whereHas('category', function($query) use ($condition,$order,$by) {
									  	$query->whereNested(function($query) use ($condition,$order,$by) {
									  		$query->where('name','LIKE',"%{$condition}%");
									  	});
									  })
									->orWhereHas('sub_category', function($query) use ($condition) {
									  	$query->whereNested(function($query) use ($condition) {
									  		$query->where('name','LIKE',"%{$condition}%");
									  	});
									  })
									->orWhere('description','LIKE',"%{$condition}%")
									->orWhere('code','LIKE',"%{$condition}%")
									->take($limit)
									->skip($start)
									->orderBy($order,$by)
									->get();
		} else {

			$dbProducts = Product::with('category','sub_category')
									->take($limit)
									->skip($start)
									->orderBy($order,$by)
									->get();
		}

		// Orders to display
		$products 	= array();

		foreach ($dbProducts as $_p) {
			
			$product 								= array();
			$product['id']							= $_p->id;
			$product['code']						= $_p->code;
			$product['category_id']					= $_p->category_id;
			$product['category_name']				= $_p->category->name;
			$product['sub_category_id']				= $_p->sub_category_id;
			$product['sub_category_name']			= $_p->sub_category->name;
			$product['description']					= $_p->description;
			$product['price_public']				= number_format($_p->price_public,2);
			$product['price_public_usd']			= number_format($_p->price_public_usd,2);
			$product['price_half_wholesale']		= number_format($_p->price_half_wholesale,2);
			$product['price_half_wholesale_usd']	= number_format($_p->price_half_wholesale_usd,2);
			$product['price_wholesale']				= number_format($_p->price_wholesale,2);
			$product['price_wholesale_usd']			= number_format($_p->price_wholesale_usd,2);
			$product['price_dealer']				= number_format($_p->price_dealer,2);
			$product['price_dealer_usd']			= number_format($_p->price_dealer_usd,2);
			$product['status']						= $_p->status;
			$product['url']							= Config::get('btsite.url') . Config::get('btsite.img_catalog');

			$products[] 							= $product;
		}

		/*
		 * Output
		 */
		$output = array(
			"sEcho" 				=> $pagina,
			"iTotalRecords" 		=> count($products),
			"iTotalDisplayRecords" 	=> $total,
			"aaData" 				=> $products
		);

		return Response::json($output, 200);
	}

	// Actualizamos el estatus de un producto
	public function itemStatus()
	{
		$id 	= Input::get('id');
		$status = Input::get('status');

		try {
			
			$product = Product::find($id);

			if(!$product) return Response::json(array('status' => false, 'message' => 'El articulo no pudo ser localizado'));

			$product->status = $status;

			if(!$product->save()) return Response::json(array('status' => false, 'message' => 'El articulo no pudo ser actualizado'));

			return Response::json(array('status' => true, 'message' => 'Articulo actualizado'));

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar el articulo [' . $e->getMessage() . ']'));
		}
	}

	// Obtenemos informacion de un producto
	public function itemInfo()
	{
		$id 	= Input::get('id');

		try {
			
			$product = Product::with(array(
							'category',
							'sub_category',
							'sub_categories',
							'colors',
							'materials',
							'image',
							'galery',
							'sizes',
							'products',
							'link')
						)
						->where('id',$id)
						->first();

			if(!$product) return Response::json(array('status' => false, 'message' => 'El articulo no pudo ser localizado'));

			return Response::json(array('status' => true, 'message' => 'Articulo localizado', 'product' => $product));

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar el articulo [' . $e->getMessage() . ']'));
		}
	}

}