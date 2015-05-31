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

	// Guardamos un producto nuevo
	public function productAdd()
	{

		$category_id 				= Input::get('d_category_id');
		$sub_category_id 			= Input::get('d_sub_category_id');
		$code 						= Input::get('d_code');
		$price_public 				= Input::get('d_price_public');
		$price_public_usd 			= Input::get('d_price_public_usd');
		$price_half_wholesale 		= Input::get('d_price_half_wholesale');
		$price_half_wholesale_usd 	= Input::get('d_price_half_wholesale_usd');
		$price_wholesale 			= Input::get('d_price_wholesale');
		$price_wholesale_usd 		= Input::get('d_price_wholesale_usd');
		$price_dealer 				= Input::get('d_price_dealer');
		$price_dealer_usd 			= Input::get('d_price_dealer_usd');
		$description 				= Input::get('d_title');
		$description_eng 			= Input::get('d_title_eng');
		$detail 					= Input::get('d_description');
		$detail_eng 				= Input::get('d_description_eng');
		$gender 					= Input::get('d_gender');
		$stock 						= Input::get('d_stock');
		$minimal_stock 				= 0;
		$multi_sub_categories 		= explode(',',Input::get('d_multi_category'));
		$products_related 			= explode(',',Input::get('r_products'));
		$materials 					= explode(',',Input::get('e_materials'));
		$sizes 						= explode(',',Input::get('e_sizes'));
		$item_colors 				= explode(',',Input::get('e_item_color'));

		try {

			DB::beginTransaction();
			
			$product = new Product();

			$product->category_id 				= $category_id;
			$product->sub_category_id 			= $sub_category_id;
			$product->code 						= $code;
			$product->price_public 				= $price_public;
			$product->price_public_usd 			= $price_public_usd;
			$product->price_half_wholesale 		= $price_half_wholesale;
			$product->price_half_wholesale_usd 	= $price_half_wholesale_usd;
			$product->price_wholesale 			= $price_wholesale;
			$product->price_wholesale_usd 		= $price_wholesale_usd;
			$product->price_dealer 				= $price_dealer;
			$product->price_dealer_usd 			= $price_dealer_usd;
			$product->description 				= $description;
			$product->description_en 			= $description_eng;
			$product->detail 					= $detail;
			$product->detail_en 				= $detail_eng;
			$product->gender 					= $gender;
			$product->stock 					= $stock;
			$product->minimal_stock 			= $minimal_stock;

			if(!$product->save()) return Response::json(array('status' => false, 'message' => 'El producto no pudo ser guardado en el sistema, intentelo nuevamente.'));

			// Se agregan multiples sub-categorias cuendo estas existen
			if(count($multi_sub_categories) > 0) $product->sub_categories()->sync($multi_sub_categories);

			// Relacion con otros productos
			// Buscamos si existen ya productos relacionados a este
			$pid 								= $product->id;
			$rel_products 						= ProductProduct::where('product_id',$pid)->get();

			if($rel_products->count() > 0) {
				$ids_to_delete = array();
				foreach ($rel_products as $r) {
					array_push($ids_to_delete, $r->id);
				}
				ProductProduct::destroy($ids_to_delete);
			}

			if(count($products_related) > 0) {

				for ($i=0; $i < count($products_related); $i++) { 
					$p 							= new ProductProduct();
					$p->product_id 				= $pid;
					$p->relational_product_id 	= $products_related[$i];
					$p->save();
				}
			}

			// Materiales relacionados al prdoducto insertado
			if(count($materials) > 0) $product->materials()->sync($materials);

			// Tallas relacionadas al prdoducto insertado
			if(count($sizes) > 0) $product->sizes()->sync($sizes);

			// Aqui agregamos la relacion de Color/Producto a Producto
			$pcolors_ids = array();

			if(count($item_colors) > 0) {
				for ($i=0; $i < count($item_colors); $i++) { 
					$pc 				= explode('|',$item_colors[$i]);
					$_color 			= $pc[0];
					$_product 			= $pc[1];
					$pcolor 			= new Pcolor();
					$pcolor->color_id 	= $_color;
					$pcolor->product_id = $_product;
					if($pcolor->save()) array_push($pcolors_ids, $pcolor->id);
				}
			}

			if(count($pcolors_ids) > 0) $product->link_colors()->sync($pcolors_ids);

			// Generamos el link del producto
			$str_link = $code . '-' . preg_replace('/\s+/','-',fix_string($description));

			$link 				= new Link();
			$link->product_id 	= $pid;
			$link->url 			= $str_link;

			$link->save();

			DB::commit();
			return Response::json(array('status' => true, 'message' => 'El producto fue agregado en el sistema correctamente.', 'pid' => $pid));

		} catch (Exception $e) {
			DB::rollback();
			return Response::json(array('status' => false, 'message' => 'Ocurrio un error al guardar el producto en el sistema [' . $e->getMessage() . ']'));
		}

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

	// Buscamos is existe un codigo en la db
	public function codeSearch()
	{
		$code = Input::get('code');

		try {

			$code = Product::where('code', "{$code}")->first();

			if($code) return Response::json(array('status' => true, 'message' => 'El articula ya existe en la base de datos con el codigo proporcionado'));
			else return Response::json(array('status' => false, 'message' => 'El articulo no existe en la base de datos'));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema en la busqueda del codigo seleccionado'));
		}
	}

	// Cargamos el listado de categorias
	public function categoryLoad()
	{

		try {

			$categories = Category::where('status', 1)->orderBy('order', 'ASC')->get();

			if(count($categories) < 1) return Response::json(array('status' => true, 'message' => 'No hay categorias disponibles'));

			return Response::json(array('status' => true, 'message' => 'Categorias encontradas', 'categories' => $categories));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al cargar las categorias [' . $e->getMessage() . ']'));
		}
	}

	// Cargamos el listado de sub-categorias
	public function subCategoriesLoad()
	{

		try {

			$id = Input::get('id');

			$sub_categories = SubCategory::where('category_id', $id)
							->orderBy('order', 'ASC')
							->get();

			if(count($sub_categories) < 1) return Response::json(array('status' => true, 'message' => 'No hay sub categorias disponibles'));

			return Response::json(array('status' => true, 'message' => 'Sub categorias encontradas', 'sub_categories' => $sub_categories));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al cargar las sub categorias [' . $e->getMessage() . ']'));
		}
	}

	// Cargamos el listado de multi-categorias
	public function complexCategoriesLoad()
	{

		try {

			$complex_categories = Category::with(array('subs' => function($query){ $query->orderBy('order', 'ASC'); }))->get();

			if(count($complex_categories) < 1) return Response::json(array('status' => true, 'message' => 'No hay sub categorias disponibles'));

			return Response::json(array('status' => true, 'message' => 'Sub categorias encontradas', 'complex_categories' => $complex_categories));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al cargar las sub categorias [' . $e->getMessage() . ']'));
		}
	}

	// Cargamos el listado de materiales
	public function materialsLoad()
	{

		try {

			$items = Material::all();

			if(count($items) < 1) return Response::json(array('status' => true, 'message' => 'No hay items disponibles'));

			return Response::json(array('status' => true, 'message' => 'Items encontrados', 'items' => $items));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al cargar los items [' . $e->getMessage() . ']'));
		}
	}

	// Cargamos el listado de tallas
	public function sizesLoad()
	{

		try {

			$items = Size::all();

			if(count($items) < 1) return Response::json(array('status' => true, 'message' => 'No hay items disponibles'));

			return Response::json(array('status' => true, 'message' => 'Items encontrados', 'items' => $items));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al cargar los items [' . $e->getMessage() . ']'));
		}
	}

	// Cargamos el listado de tallas
	public function colorsLoad()
	{

		try {

			$items = Color::all();

			if(count($items) < 1) return Response::json(array('status' => true, 'message' => 'No hay items disponibles'));

			return Response::json(array('status' => true, 'message' => 'Items encontrados', 'items' => $items));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al cargar los items [' . $e->getMessage() . ']'));
		}
	}

	// Obtenemos el tupo de cambio actual
	public function typeCgange()
	{
		try {
			
			$site_config = SiteConfiguration::where('id', 1)->first();

			if(!$site_config) return Respose::json(array('status' => false, 'message' => 'No se encontro el tipo de cambio actual'));

			$exchange = $site_config->exchange_rate;

			return Response::json(array('status' => true, 'message' => 'Tipo de cambio localizado', 'exchange' => $exchange));

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al obtener la informacion de la base de datos [' . $e->getMessage() . ']'));
		}
	}
}