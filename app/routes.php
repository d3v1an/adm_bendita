<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Test
Route::get('/test', function()
{

    //$categories = Category::with(array('subs' => function($query){ $query->orderBy('order', 'ASC'); }))->get();

    //return Input::all();//$categories;
    //$site_config = ProductProduct::where('product_id',672)->get();
    //return $site_config->count();
    
    // $pid = 1437;
    // $rel_products = ProductProduct::where('product_id',$pid)->get();

    // if($rel_products->count() > 0) {
    //     $ids_to_delete = array();
    //     foreach ($rel_products as $r) {
    //         array_push($ids_to_delete, $r->id);
    //     }
    //     ProductProduct::destroy($ids_to_delete);
    // }

    // return "Done";
    
    //$pp = Product::find(1430);
    //$pp->link_colors()->sync(array(20,21));

    $p = Product::with(array('link_colors' => function($query) { $query->with('Color', 'Product'); }))->where('id', 1443)->get();
    return $p;
});

// Test
Route::post('/test', function()
{
    return Input::all();
});


// Session
    
    // Formulario de inicio de sesion
    Route::get('login', 'AdminAuthController@login');
    
    // Inicio de session
    Route::post('login', 'AdminAuthController@authLogin');
    
    // Cierre de session
    Route::get('logout', 'AdminAuthController@logout');

Route::group(array('before' => 'auth.cp'), function()
{
	// Dashboard

        // Vista general de usuario
        Route::get('/', 'HomeController@dashboard');

    // Admin

        // Formulario de actualizacion de informacion de administrador
        Route::get('system/admins', 'AdminController@index');

        // Actualizacion de informacion de administrador
        Route::post('system/admins/update', 'AdminController@update');

        // Actualizacion de nivel de administrador
        Route::post('system/admins/update/level', 'AdminController@updateLevel');

        // Actualizacion de estatus de administrador
        Route::post('system/admins/update/status', 'AdminController@updateStatus');

        // Eliminacion de un usuairo en el sistema
        Route::post('system/admins/delete', 'AdminController@delete');

        // Se agrega un usuairo en el sistema
        Route::post('system/admins/add', 'AdminController@add');

    // Funciones communes

        // Tipo de cambio
        Route::get('system/tipocambio', 'AdminController@tipocambio');

        // Actualizacion de tipo de cambio
        Route::post('system/tipocambio/update', 'AdminController@tcupdate');

    // Administracion de media (carrusel/video)

        // Vista principal de videos
        Route::get('media/video', 'MediaController@video');

        // Cambiamos el estatus de un video
        Route::post('media/video', 'MediaController@videoStatus');

        // Eliminamos un video
        Route::post('media/video/delete', 'MediaController@videoDelete');

        // Obtenemos informacion del video
        Route::post('media/video/info', 'MediaController@videoInfo');

        // Editamos un video
        Route::post('media/video/edit', 'MediaController@videoEdit');

        // agregamos un video
        Route::post('media/video/add', 'MediaController@videoAdd');

        // Vista principal de carrusel
        Route::get('media/carrousel', 'MediaController@carrousel');

        // Actualizacion de estado de linkable
        Route::post('media/carrousel/linkable', 'MediaController@carrouselLinkable');

        // Actualizacion de categoria de un item
        Route::post('media/carrousel/category', 'MediaController@carrouselCategory');

        // Actualizacion de estado de un item
        Route::post('media/carrousel/status', 'MediaController@carrouselStatus');

        // Eliminamos el item seleccionado
        Route::post('media/carrousel/delete', 'MediaController@carrouselDelete');

        // Obtenemos la informacion del carrusel
        Route::post('media/carrousel/info', 'MediaController@carrouselInfo');

        // Edicion de la informacion del carrusel
        Route::post('media/carrousel/edit', 'MediaController@carrouselEdit');

        /// Agregamos un nuevo item al carrusel
        Route::post('media/carrousel/add', 'MediaController@carrouselAdd');

        // Subimos la posicion de un item de carrusel
        Route::post('media/carrousel/principal/up', 'MediaController@carrouselPrincipalUp');

        // Bajamos la posicion de un item de carrusel
        Route::post('media/carrousel/principal/down', 'MediaController@carrouselPrincipalDown');

        // Carga de imagen
        Route::post('media/image/upload', 'MediaController@imageUpload');


    // Reporte de email's enviados a los clientes

        // Vista principal de videos
        Route::get('email/report', 'EmailsReportController@index');

        // Vista principal de videos
        Route::get('email/report/search', 'EmailsReportController@search');

        // Obtenemos la notificacion enviada
        Route::post('email/report/notify', 'EmailsReportController@getNotify');

    // Clientes Ordenes

        // Vista principal de ordenes
        Route::get('customer/orders/report', 'UserController@index');

        // Busqueda de ordenes
        Route::get('customer/orders/report/search', 'UserController@search');

        // Actualizacion de paqueteria de una orden
        Route::post('customer/orders/parcel/update', 'UserController@parcelUpdate');

        // Actualizacion de estatus de una orden
        Route::post('customer/orders/status/update', 'UserController@statusUpdate');

        // Actualizacion de estatus de pado en una orden
        Route::post('customer/orders/payed/update', 'UserController@payedUpdate');

        // Actualizacion de numero de guia de una orden
        Route::post('customer/orders/num_guide', 'UserController@numGuide');

        // Actualizacion de costo de envio de una orden
        Route::post('customer/orders/shipping_cost', 'UserController@shippingCost');

        // Detalle de orden
        Route::post('customer/orders/detail', 'UserController@orderDetail');

        // Actualizacion de surtido de un item de una orden
        Route::post('customer/orders/detail/item', 'UserController@orderItemDone');

        // Eliminar un item de la orden seleccionada
        Route::post('customer/orders/detail/item/del', 'UserController@orderItemDel');

        // Busqueda de un item en una orden
        Route::post('customer/orders/detail/item/search', 'UserController@orderItemSearch');

        // Remplazo de un item en una orden
        Route::post('customer/orders/detail/item/replace', 'UserController@orderItemReplace');

        // Informacion adicional a la orden de pago
        Route::post('customer/orders/aditional', 'UserController@orderAditional');

        // responder una pregunta de un articulo
        Route::post('customer/orders/note/reply', 'UserController@orderNoteReply');

        // Remplazo de un item en una orden
        Route::post('customer/orders/notify', 'UserController@orderNotify');

        // Vista principal de carritos
        Route::get('customer/carts/report', 'UserController@carts');

        // Busqueda de carritos
        Route::get('customer/carts/search', 'UserController@cartSearch');

        // Detalle de carritos
        Route::post('customer/carts/detail', 'UserController@cartDetail');

        // Listado de clientes
        Route::get('customer', 'UserController@show');

        // Listado de clientes
        Route::get('customer/list', 'UserController@customerList');

        // Eliminacion logica de un usuario
        Route::post('customer/info', 'UserController@customerInfo');

        // Eliminacion logica de un usuario
        Route::post('customer/del', 'UserController@customerDel');

    // Productos

        // inventarios
        Route::get('products/inventory', 'InventoryController@index');

        // inventarios busqueda
        Route::get('products/inventory/search', 'InventoryController@search');

        // Actualizacion de estatus de un item
        Route::post('products/inventory/item/status', 'InventoryController@itemStatus');

        // Obtenemos informacion de un articulo
        Route::post('products/inventory/item/info', 'InventoryController@itemInfo');

        // Buscamos si existe un codigo
        Route::post('products/code/search', 'InventoryController@codeSearch');

        // Cargamos el listado de categoria disponibles
        Route::post('products/category/load', 'InventoryController@categoryLoad');

        // Cargamos el listado de sub-categoria disponibles
        Route::post('products/sub_categories/load', 'InventoryController@subCategoriesLoad');

        // Cargamos el listado de multi categoria disponibles
        Route::post('products/complex_categories/load', 'InventoryController@complexCategoriesLoad');

        // Cargamos el listado materiales
        Route::post('products/materials/load', 'InventoryController@materialsLoad');

        // Cargamos el listado de tallas
        Route::post('products/sizes/load', 'InventoryController@sizesLoad');

        // Cargamos el listado colores
        Route::post('products/colors/load', 'InventoryController@colorsLoad');

        // Agregamos un producto nuevo
        Route::post('products/inventory/add', 'InventoryController@productAdd');

        // Obtenemos el tipo de cambio
        Route::post('products/inventory/type_change', 'InventoryController@typeCgange');
});

// Printables
Route::group(['prefix' => 'print'], function () {

    // Ordenes
    Route::get('order/{id}', 'PrintController@order');

});