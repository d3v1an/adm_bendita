<?php
use Kinglozzer\TinyPng\Compressor;
use Kinglozzer\TinyPng\Exception\AuthorizationException;
use Kinglozzer\TinyPng\Exception\InputException;
use Kinglozzer\TinyPng\Exception\LogicException;

class MediaController extends \BaseController {

	// Vista principal de videos
	public function video()
	{
		$videos = Video::all();
		$params = array(
					'videos' => $videos,
					'active' => 'media/video'
				);

		return View::make('media.videos')->with($params);
	}

	// Funcion para actualizar el estatus del video
	public function videoStatus()
	{
		$id 	= Input::get('id');
		$status = Input::get('status');

		try {
			
			$video = Video::find($id);

			if(!$video) return Response::json(array('status' => false, 'message' => 'Video no localizado'),200);

			$video->status = $status;

			if(!$video->save()) return Response::json(array('status' => false, 'message' => 'El video no pudo ser actualizado'),200);

			 return Response::json(array('status' => true, 'message' => 'Video actualizado'),200);

		} catch (Exception $e) {
			 return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar el video [' . $e->getMessage() . ']'),200);
		}
	}

	// Funcion para eliminar un video
	public function videoDelete()
	{
		$id 	= Input::get('id');

		try {
			
			$video = Video::find($id);

			if(!$video) return Response::json(array('status' => false, 'message' => 'Video no localizado'),200);

			if(!$video->delete()) return Response::json(array('status' => false, 'message' => 'El video no pudo ser eliminado'),200);

			 return Response::json(array('status' => true, 'message' => 'Video eliminado'),200);

		} catch (Exception $e) {
			 return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al eliminar el video [' . $e->getMessage() . ']'),200);
		}
	}

	// Obtenemos la infromacion de un video
	public function videoInfo()
	{
		$id = Input::get('id');

		try {
			
			$video = Video::find($id);

			if(!$video) return Response::json(array('status' => false, 'message' => 'Video no localizado'),200);

			return Response::json(array('status' => true, 'message' => 'Video localizado', 'info' => $video),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al obtener la informacion del video [' . $e->getMessage() . ']'),200);
		}
	}

	// Actualizamos la infromacion de un video
	public function videoEdit()
	{
		$id 	= Input::get('id');
		$name 	= Input::get('name');
		$label 	= Input::get('label');
		$link 	= Input::get('link');

		try {
			
			$video = Video::find($id);

			if(!$video) return Response::json(array('status' => false, 'message' => 'Video no localizado'),200);

			$video->name 	= $name;
			$video->label 	= $label;
			$video->link 	= $link;

			if(!$video->save()) return Response::json(array('status' => false, 'message' => 'La informacion del video no pudo ser actualizada'),200);

			return Response::json(array('status' => true, 'message' => 'Video actualizado'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar la informacion del video [' . $e->getMessage() . ']'),200);
		}
	}

	// Agregamos la infromacion de un video
	public function videoAdd()
	{
		$name 	= Input::get('name');
		$label 	= Input::get('label');
		$link 	= Input::get('link');
		$status = Input::get('status');

		try {
			
			$video = new Video();

			$video->name 	= $name;
			$video->label 	= $label;
			$video->link 	= $link;
			$video->status 	= $status;

			if(!$video->save()) return Response::json(array('status' => false, 'message' => 'La informacion del video no pudo ser agregada'),200);

			return Response::json(array('status' => true, 'message' => 'Video agregado'),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al agregar la informacion del video [' . $e->getMessage() . ']'),200);
		}
	}

	// Vusta principal del carrusel
	public function carrousel()
	{
		$carrousel 			= Carrousel::with('Category')
							  ->orderBy('order','ASC')
							  ->get();

		$product_categories = Category::all();

		$params 			= array(
								'carrousel' 			=> $carrousel,
								'product_categories' 	=> $product_categories,
								'active' 				=> 'media/carrousel'
							);

		return View::make('media.carrousel')->with($params);
	}

	// Funcion para actualizar el estatus del carrusel
	public function carrouselLinkable()
	{
		$id 	= Input::get('id');
		$state 	= Input::get('state');

		try {
			
			$slider = Carrousel::find($id);

			if(!$slider) return Response::json(array('status' => false, 'message' => 'Item no localizado'),200);

			$slider->linkable = $state;

			if(!$slider->save()) return Response::json(array('status' => false, 'message' => 'El item no pudo ser actualizado'),200);

			return Response::json(array('status' => true, 'message' => 'Item actualizado'),200);

		} catch (Exception $e) {
			 return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar el item [' . $e->getMessage() . ']'),200);
		}
	}

	// Funcion para actualizar una categoria del carrusel
	public function carrouselCategory()
	{
		$id 		= Input::get('id');
		$category 	= Input::get('category');

		try {
			
			$slider = Carrousel::find($id);

			if(!$slider) return Response::json(array('status' => false, 'message' => 'Item no localizado'),200);

			$slider->category_id = $category;

			if(!$slider->save()) return Response::json(array('status' => false, 'message' => 'El item no pudo ser actualizado'),200);

			return Response::json(array('status' => true, 'message' => 'Item actualizado'),200);

		} catch (Exception $e) {
			 return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar el item [' . $e->getMessage() . ']'),200);
		}
	}

	// Funcion para actualizar una categoria del carrusel
	public function carrouselStatus()
	{
		$id 		= Input::get('id');
		$status 	= Input::get('status');

		try {
			
			$slider = Carrousel::find($id);

			if(!$slider) return Response::json(array('status' => false, 'message' => 'Item no localizado'),200);

			$slider->status = $status;

			if(!$slider->save()) return Response::json(array('status' => false, 'message' => 'El item no pudo ser actualizado'),200);

			return Response::json(array('status' => true, 'message' => 'Item actualizado'),200);

		} catch (Exception $e) {
			 return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar el item [' . $e->getMessage() . ']'),200);
		}
	}

	// Funcion para remover un item del carrusel
	public function carrouselDelete()
	{
		$id 		= Input::get('id');

		try {
			
			$slider = Carrousel::find($id);

			if(!$slider) return Response::json(array('status' => false, 'message' => 'Item no localizado'),200);

			if(!$slider->delete()) return Response::json(array('status' => false, 'message' => 'El item no pudo ser eliminado'),200);

			return Response::json(array('status' => true, 'message' => 'Item eliminado'),200);

		} catch (Exception $e) {
			 return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al eliminar el item [' . $e->getMessage() . ']'),200);
		}
	}

	// Subimos de posicion un item del carrusel principal
	public function carrouselPrincipalUp()
	{
		$id 	= Input::get('id');
		$order 	= Input::get('order');

		try {

			// Item a reordenar en una posicion superior
			$item_origin 		= Carrousel::where('order',$order)->first();

			// Si no existe el item retornamos error
			if(!$item_origin) return Response::json(array('status' => false, 'message' => 'Item de origen no localizado'));

			// Caracteristicas del item seleccionado
			$current_id 		= $item_origin->id;
			$current_order		= $item_origin->order;

			// Obtenemos la informacion del item a re ordenar en posicion inferior
			$item_target 		= Carrousel::where('order',((int)$order-1))->first();

			// Si no existe el item retornamos error
			if(!$item_target) return Response::json(array('status' => false, 'message' => 'Item inferior no localizado'));

			// Caracteristicas del item a degradar
			$target_id 			= $item_target->id;
			$target_order 		= $item_target->order;

			// Actualizamos el orden del item de origen
			$item_origin->order = ((int)$current_order-1);
			if(!$item_origin->save()) return Response::json(array('status' => false, 'message' => 'El item de origen no pudo ser actualizado'));

			// Actualizamos el orden del item a degradar
			$item_target->order = $current_order;
			if(!$item_target->save()) return Response::json(array('status' => false, 'message' => 'El item a degradar no pudo ser actualizado'));

			$output = array();

			$output["current"]["id"] 		= (int)$current_id;
			$output["current"]["old_order"] = (int)$current_order;
			$output["current"]["new_order"] = (int)$current_order-1;
			$output["target"]["id"] 		= (int)$target_id;
			$output["target"]["old_order"] 	= (int)$current_order-1;
			$output["target"]["new_order"] 	= (int)$current_order;

			return Response::json(array('status' => true, 'message' => 'Items actualizados', 're_order' => $output),200);
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al tratar de actualizar los items [' . $e->getMessage() . ']'));
		}
	}

	// Subimos de posicion un item del carrusel principal
	public function carrouselPrincipalDown()
	{
		$id 	= Input::get('id');
		$order 	= Input::get('order');

		try {

			// Item a reordenar en una posicion superior
			$item_origin 		= Carrousel::where('order',$order)->first();

			// Si no existe el item retornamos error
			if(!$item_origin) return Response::json(array('status' => false, 'message' => 'Item de origen no localizado'));

			// Caracteristicas del item seleccionado
			$current_id 		= $item_origin->id;
			$current_order		= $item_origin->order;

			// Obtenemos la informacion del item a re ordenar en posicion inferior
			$item_target 		= Carrousel::where('order',((int)$order+1))->first();

			// Si no existe el item retornamos error
			if(!$item_target) return Response::json(array('status' => false, 'message' => 'Item inferior no localizado'));

			// Caracteristicas del item a degradar
			$target_id 			= $item_target->id;
			$target_order 		= $item_target->order;

			// Actualizamos el orden del item de origen
			$item_origin->order = ((int)$current_order+1);
			if(!$item_origin->save()) return Response::json(array('status' => false, 'message' => 'El item de origen no pudo ser actualizado'));

			// Actualizamos el orden del item a degradar
			$item_target->order = $current_order;
			if(!$item_target->save()) return Response::json(array('status' => false, 'message' => 'El item a degradar no pudo ser actualizado'));

			$output = array();

			$output["current"]["id"] 		= (int)$current_id;
			$output["current"]["old_order"] = (int)$current_order;
			$output["current"]["new_order"] = (int)$current_order+1;
			$output["target"]["id"] 		= (int)$target_id;
			$output["target"]["old_order"] 	= (int)$current_order+1;
			$output["target"]["new_order"] 	= (int)$current_order;

			return Response::json(array('status' => true, 'message' => 'Items actualizados', 're_order' => $output),200);
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al tratar de actualizar los items [' . $e->getMessage() . ']'));
		}
	}

	// Obtenemos la informacion del item seleccionado
	public function carrouselInfo()
	{
		$id = Input::get('id');

		try {
			
			$slider = Carrousel::find($id);

			if(!$slider) return Response::json(array('status' => false, 'message' => 'El item no pudo ser localizado'));

			return Response::json(array('status' => true, 'message' => 'Item localizado', 'info' => $slider),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al obtener la informacion del item seleccionado [' .  $e->getMessage() . ']'),200);
		}
	}

	// Actualizacion de informacion de un item del carrusel
	public function carrouselEdit()
	{
		$id 		= Input::get('id');
		$link 		= Input::get('link');
		$withImage 	= filter_var(Input::get('image'), FILTER_VALIDATE_BOOLEAN);
		$file 		= Input::file('file');

		try {

			if($link=='' || empty($link)) return Response::json(array('status' => false, 'Link invalido'),200);

			$slider 	= Carrousel::find($id);

			if(!$slider) return Response::json(array('status' => false, 'message' => 'Item no localizado'),200);

			if($withImage) {

				// Directorio destino de carga de la imagen
				$destinationPath 	= Config::get('btsite.path') . Config::get('btsite.img_slider');

				// Nombre original del archivo
				$OriginalFileName	= $file->getClientOriginalName();

				// Extension de imagen
				$extension 			= $file->getClientOriginalExtension();

				// Mime Type
				$mimeType	 		= $file->getMimeType();

				// Tamaño original del archivo
				$OriginalFileSize 	= $file->getSize();
				
				// Validacion de extension
				$extAllowed 		= array('jpg','jpeg');
				if(!in_array($extension,$extAllowed)) return Response::json(array('status' => false, 'message' => 'Imagen invalida'));

				// Validacion de mimetype
				$mimeAllowed 		= array('image/jpeg','image/jpg');
				if(!in_array($mimeType,$mimeAllowed)) {
					return Response::json(array('status' => false, 'message' => 'Imagen invalida'));
				}

				// Validacion de tamaño de archivo
				$maxFileSize 		= (1024 * 1024 * 100); // 100MB 
				if($OriginalFileSize > $maxFileSize) {
					return Response::json(array('status' => false, 'message' => 'La imagen es demasiado grande'));
				}

				// Carga de imagenes al servidor
				$uploadSuccess 	= $file->move($destinationPath, $OriginalFileName);

				if(!$uploadSuccess) return Response::json(array('status' => false, 'message' => 'Ocurrio un problema en la carga de la imagen'),200);

				$slider->pic 	= $OriginalFileName;
				$slider->link 	= $link;

				if(!$slider->save()) return Response::json(array('status' => true, 'message' => 'El item no pudo ser actualizado'),200);
				return Response::json(array('status' => true, 'message' => 'Item actualizado', 'image' => $withImage, 'file' => $destinationPath . $OriginalFileName, 'url' => Config::get('btsite.url') . Config::get('btsite.img_slider') . $OriginalFileName, 'link' => $link, 'id' => $slider->id),200);

			} else {
				$slider->link = $link;
				if(!$slider->save()) return Response::json(array('status' => true, 'message' => 'El item no pudo ser actualizado'),200);
				return Response::json(array('status' => true, 'message' => 'Item actualizado', 'image' => $withImage),200);
			}

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al actualizar el item seleccionado [' . $e->getMessage() . ']'),200);
		}

	}

	// Funcion para agregar un nuevo item al carrusel principal
	public function carrouselAdd()
	{
		$title 		= Input::get('title');
		$linkable 	= Input::get('linkable');
		$link 		= Input::get('link');
		$category 	= Input::get('category');
		$status 	= Input::get('status');
		$file 		= Input::file('file');

		try {

			// Primero cargamos la imagen

			// Directorio destino de carga de la imagen
			$destinationPath 	= Config::get('btsite.path') . Config::get('btsite.img_slider');

			// Nombre original del archivo
			$OriginalFileName	= $file->getClientOriginalName();

			// Extension de imagen
			$extension 			= $file->getClientOriginalExtension();

			// Mime Type
			$mimeType	 		= $file->getMimeType();

			// Tamaño original del archivo
			$OriginalFileSize 	= $file->getSize();

			// Validacion de extension
			$extAllowed 		= array('jpg','jpeg');
			if(!in_array($extension,$extAllowed)) return Response::json(array('status' => false, 'message' => 'Imagen invalida'));

			// Validacion de mimetype
			$mimeAllowed 		= array('image/jpeg','image/jpg');
			if(!in_array($mimeType,$mimeAllowed)) {
				return Response::json(array('status' => false, 'message' => 'Imagen invalida'));
			}

			// Validacion de tamaño de archivo
			$maxFileSize 		= (1024 * 1024 * 100); // 100MB 
			if($OriginalFileSize > $maxFileSize) {
				return Response::json(array('status' => false, 'message' => 'La imagen es demasiado grande'));
			}

			// Carga de imagenes al servidor
			$uploadSuccess 	= $file->move($destinationPath, $OriginalFileName);

			if(!$uploadSuccess) return Response::json(array('status' => false, 'message' => 'Ocurrio un problema en la carga de la imagen'),200);

			// Obtenemos el numero maximo de orden
			$slOrd 				= Carrousel::max('order') +1;
			if(!$slOrd) $slOrd = 0;

			// Agregamos el item al slider
			$slider 						= new Carrousel();

			$slider->pic 			= $OriginalFileName;
			$slider->title 			= $title;
			$slider->linkable 		= $linkable;
			$slider->link 			= $link;
			$slider->category_id 	= $category;
			$slider->status 		= $status;
			$slider->order 			= $slOrd;

			if(!$slider->save()) return Response::json(array('status' => true, 'message' => 'El item no pudo ser guardado'),200);

			$output = array(
						'status' 	=> true,
						'message' 	=> 'Item agregado exitosamente',
						'id'		=> $slider->id,
						'title'		=> $title,
						'image' 	=> Config::get('btsite.url') . Config::get('btsite.img_slider') . $OriginalFileName,
						'linkable'	=> $linkable,
						'link' 		=> $link,
						'category' 	=> $category,
						'active' 	=> $status,
						'order' 	=> $slOrd
					);

			return Response::json($output,200);

			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al guardar el item [' . $e->getMessage() . ']'),200);
		}

	}

	// Funcion para cargar las imagenes del producto
	public function imageUpload()
	{
		// Configuracion de compresion
		$compress_enabled 	= filter_var(Config::get('compress.enable'), FILTER_VALIDATE_BOOLEAN);

		// Configuracion del producto
		$code 				= Input::get('code');
		$pid 				= Input::get('pid');
		$pcat 				= (int)Input::get('category');
		$hashName 			= Input::get('hash');
		$isMain 			= filter_var(Input::get('is_main'), FILTER_VALIDATE_BOOLEAN);

		// Archivo e informacion a cargar
		$file 				= Input::file('file');
		$extension 			= File::extension($file->getClientOriginalName());

		// Directorios
		$temp_dir 			= storage_path() . '/tmp/';
		$public_dir 		= Config::get('btsite.path') . Config::get('btsite.img_catalog');//public_path() . '/tmp/';

	    if($isMain) {
	    	
	    	$tmp_filename 	=  $code . '_tmp.' . $extension;
	    	$new_filename 	=  $code . '.' . $extension;

	    	$cat_filename 	=  $code . '_cat.' . $extension;
	    	$thb_filename 	=  $code . '_tumb.' . $extension;
	    	$fb_filename 	=  $code . '_fb.' . $extension;

	    } else {
	    	
	    	$tmp_filename 	=  $code .'_' . $hashName . '_tmp.' . $extension;
	    	$new_filename 	=  $code .'_' . $hashName . '.' . $extension;
	    	
	    	$sml_filename 	=  $code .'_' . $hashName . '_small.' . $extension;
	    	$tag_filename 	=  $code .'_' . $hashName . '_tag.' . $extension;

	    }

	    $upload_success = Input::file('file')->move($temp_dir, $tmp_filename);

	    if($upload_success) {

	    	$message_output = "";

	    	if($compress_enabled) {

	    		$compressor = new Compressor(Config::get('compress.api_key'));

	    		try {
			        
			        // Comprimimos la imagen cuando el compresos esta activado
			        $result = $compressor->compress($temp_dir . $tmp_filename);
			        $result->writeTo($public_dir . $new_filename);

			        if($isMain) {

			        	if($pcat==1) iImage::make($public_dir . $new_filename)->resize(190, 285)->save($public_dir . $cat_filename);
			        	else iImage::make($public_dir . $new_filename)->resize(190, 210)->save($public_dir . $cat_filename);

			        	iImage::make($public_dir . $new_filename)->resize(50, 50)->save($public_dir . $thb_filename);
			        	iImage::make($public_dir . $new_filename)->resize(100, 100)->save($public_dir . $fb_filename);

			        } else {

			        	iImage::make($public_dir . $new_filename)->resize(100, 150)->save($public_dir . $sml_filename);
			        	iImage::make($public_dir . $new_filename)->resize(33, 50)->save($public_dir . $tag_filename);
			        }

			        File::delete($temp_dir . $tmp_filename);

			        $message_output = 'Imagen cargada y comprimida';
			    }
			    catch (AuthorizationException $e) {
			        return Response::json(array('status' => false, 'message' => '[AuthorizationException] Error de compresion de imagen, Archivo [' . $filename . '], Error [' . $e->getMessage() . ']'));
			    }
			    catch (InputException $e) {
			        return Response::json(array('status' => false, 'message' => '[InputException] Error de compresion de imagen, Archivo [' . $filename . '], Error [' . $e->getMessage() . ']'));
			    }
			    catch (Exception $e) {
			        return Response::json(array('status' => false, 'message' => '[Exception] Error de compresion de imagen, Archivo [' . $filename . '], Error [' . $e->getMessage() . ']'));
			    }

	    	} else {

	    		if(File::move($temp_dir . $tmp_filename, $public_dir . $new_filename)) {

	    			if($isMain) {

	    				if($pcat==1) iImage::make($public_dir . $new_filename)->resize(190, 285)->save($public_dir . $cat_filename);
				        else iImage::make($public_dir . $new_filename)->resize(190, 210)->save($public_dir . $cat_filename);

				        iImage::make($public_dir . $new_filename)->resize(50, 50)->save($public_dir . $thb_filename);
				        iImage::make($public_dir . $new_filename)->resize(100, 100)->save($public_dir . $fb_filename);

	    			} else {

	    				iImage::make($public_dir . $new_filename)->resize(100, 150)->save($public_dir . $sml_filename);
			        	iImage::make($public_dir . $new_filename)->resize(33, 50)->save($public_dir . $tag_filename);
	    			}

	    			$message_output = 'Imagen cargada y renombrada';
	    		} else {
	    			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al cargar y renombrar la imagen'));
	    		}

	    	}

	    	DB::beginTransaction();

	    	if($isMain) {

	    		$image 				= new Image();
	    		$image->product_id 	= $pid;
	    		$image->full 		= $new_filename;
	    		$image->catalog 	= $cat_filename;
	    		$image->fb_share 	= $fb_filename;
	    		$image->thumbnail 	= $thb_filename;
	    		$image->save();

	    	} else {

	    		$galery 				= new Galery();
	    		$galery->product_id		= $pid;
	    		$galery->image 			= $new_filename;
	    		$galery->image_small 	= $sml_filename;
	    		$galery->image_tag 		= $tag_filename;
	    		$galery->save();
	    	}

	    	DB::commit();
	    	return Response::json(array('status' => true, 'message' => $message_output));

	    } else {
	    	DB::rollback();
	    	return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al cargar la imagen'));
	    }
	}

	// Funcion para cargar imarenes de un producto existente
	public function imageUploadEdit()
	{
		//return Input::all();
		// Configuracion de compresion
		$compress_enabled 	= filter_var(Config::get('compress.enable'), FILTER_VALIDATE_BOOLEAN);

		// Configuracion del producto
		$code 				= Input::get('code');
		$pid 				= Input::get('pid');
		$pcat 				= (int)Input::get('category');
		$hashName 			= Input::get('hash');
		$isMain 			= filter_var(Input::get('is_main'), FILTER_VALIDATE_BOOLEAN);

		// Archivo e informacion a cargar
		$file 				= Input::file('file');
		$extension 			= File::extension($file->getClientOriginalName());

		// Directorios
		$temp_dir 			= storage_path() . '/tmp/';
		$public_dir 		= Config::get('btsite.path') . Config::get('btsite.img_catalog');

	    if($isMain) {
	    	
	    	$tmp_filename 	=  $code . '_tmp.' . $extension;
	    	$new_filename 	=  $code . '.' . $extension;

	    	$cat_filename 	=  $code . '_cat.' . $extension;
	    	$thb_filename 	=  $code . '_tumb.' . $extension;
	    	$fb_filename 	=  $code . '_fb.' . $extension;

	    } else {
	    	
	    	$tmp_filename 	=  $code .'_' . $hashName . '_tmp.' . $extension;
	    	$new_filename 	=  $code .'_' . $hashName . '.' . $extension;
	    	
	    	$sml_filename 	=  $code .'_' . $hashName . '_small.' . $extension;
	    	$tag_filename 	=  $code .'_' . $hashName . '_tag.' . $extension;

	    }

	    $upload_success = Input::file('file')->move($temp_dir, $tmp_filename);

	    if($upload_success) {

	    	$message_output = "";

	    	if($compress_enabled) {

	    		$compressor = new Compressor(Config::get('compress.api_key'));

	    		try {
			        
			        // Comprimimos la imagen cuando el compresos esta activado
			        $result = $compressor->compress($temp_dir . $tmp_filename);
			        $result->writeTo($public_dir . $new_filename);

			        if($isMain) {

			        	if($pcat==1) iImage::make($public_dir . $new_filename)->resize(190, 285)->save($public_dir . $cat_filename);
			        	else iImage::make($public_dir . $new_filename)->resize(190, 210)->save($public_dir . $cat_filename);

			        	iImage::make($public_dir . $new_filename)->resize(50, 50)->save($public_dir . $thb_filename);
			        	iImage::make($public_dir . $new_filename)->resize(100, 100)->save($public_dir . $fb_filename);

			        } else {

			        	iImage::make($public_dir . $new_filename)->resize(100, 150)->save($public_dir . $sml_filename);
			        	iImage::make($public_dir . $new_filename)->resize(33, 50)->save($public_dir . $tag_filename);
			        }

			        File::delete($temp_dir . $tmp_filename);

			        $message_output = 'Imagen cargada y comprimida';
			    }
			    catch (AuthorizationException $e) {
			        return Response::json(array('status' => false, 'message' => '[AuthorizationException] Error de compresion de imagen, Archivo [' . $filename . '], Error [' . $e->getMessage() . ']'));
			    }
			    catch (InputException $e) {
			        return Response::json(array('status' => false, 'message' => '[InputException] Error de compresion de imagen, Archivo [' . $filename . '], Error [' . $e->getMessage() . ']'));
			    }
			    catch (Exception $e) {
			        return Response::json(array('status' => false, 'message' => '[Exception] Error de compresion de imagen, Archivo [' . $filename . '], Error [' . $e->getMessage() . ']'));
			    }

	    	} else {

	    		if(File::move($temp_dir . $tmp_filename, $public_dir . $new_filename)) {

	    			if($isMain) {

	    				if($pcat==1) iImage::make($public_dir . $new_filename)->resize(190, 285)->save($public_dir . $cat_filename);
				        else iImage::make($public_dir . $new_filename)->resize(190, 210)->save($public_dir . $cat_filename);

				        iImage::make($public_dir . $new_filename)->resize(50, 50)->save($public_dir . $thb_filename);
				        iImage::make($public_dir . $new_filename)->resize(100, 100)->save($public_dir . $fb_filename);

	    			} else {

	    				iImage::make($public_dir . $new_filename)->resize(100, 150)->save($public_dir . $sml_filename);
			        	iImage::make($public_dir . $new_filename)->resize(33, 50)->save($public_dir . $tag_filename);
	    			}

	    			$message_output = 'Imagen cargada y renombrada';
	    		} else {
	    			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al cargar y renombrar la imagen'));
	    		}

	    	}

	    	DB::beginTransaction();

	    	if($isMain) {

	    		$image 				= new Image();
	    		$image->product_id 	= $pid;
	    		$image->full 		= $new_filename;
	    		$image->catalog 	= $cat_filename;
	    		$image->fb_share 	= $fb_filename;
	    		$image->thumbnail 	= $thb_filename;
	    		$image->save();

	    	} else {

	    		$galery 				= new Galery();
	    		$galery->product_id		= $pid;
	    		$galery->image 			= $new_filename;
	    		$galery->image_small 	= $sml_filename;
	    		$galery->image_tag 		= $tag_filename;
	    		$galery->save();
	    	}

	    	DB::commit();
	    	return Response::json(array('status' => true, 'message' => $message_output));

	    } else {
	    	DB::rollback();
	    	return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al cargar la imagen'));
	    }
	}

	// Eliminamos la imagen principal y el juego de la misma del producto seleccionado
	public function imageMainDelete()
	{

		$product_id 		= Input::get('pid');
		$img_cat_dir 		= Config::get('btsite.path') . Config::get('btsite.img_catalog');

		// Variables de imagenes
		$full_image 		= null;
		$catalog_image 		= null;
		$fb_image 			= null;
		$thumbnail_image 	= null;

		try {

			$image 		= Image::where('product_id', $product_id)->first();
			$product 	= Product::find($product_id);

			if(!$image) {

				if(!$product) return Response::json(array('status' => false, 'message' => 'El codigo de producto no existe'));

				$full_image 		= $img_cat_dir . $product->code . '.jpg';
				$catalog_image 		= $img_cat_dir . $product->code . '_cat.jpg';
				$fb_image 			= $img_cat_dir . $product->code . '_tumb.jpg';
				$thumbnail_image 	= $img_cat_dir . $product->code . '_fb.jpg';

				if(File::exists($full_image)) File::delete($full_image);
				if(File::exists($catalog_image)) File::delete($catalog_image);
				if(File::exists($fb_image)) File::delete($fb_image);
				if(File::exists($thumbnail_image)) File::delete($thumbnail_image);

				return Response::json(array('status' => true, 'message' => 'Imagenes eliminadas'));

			} else {

				// Eliminamos las imagenes en el directorio de catalogo
				$full_image 		= $img_cat_dir . $image->full;
				$catalog_image 		= $img_cat_dir . $image->catalog;
				$fb_image 			= $img_cat_dir . $image->fb_share;
				$thumbnail_image 	= $img_cat_dir . $image->thumbnail;

				if(File::exists($full_image)) File::delete($full_image);
				if(File::exists($catalog_image)) File::delete($catalog_image);
				if(File::exists($fb_image)) File::delete($fb_image);
				if(File::exists($thumbnail_image)) File::delete($thumbnail_image);

				if(!$image->delete()) return Response::json(array('status' => false, 'message' => 'La imagen no pudo ser eliminada de la base de datos, sin embargo las imagenes ya no existen'));

			}

			$product->status = 0;

			$product->save();

			return Response::json(array('status' => true, 'message' => 'Imagen localizada', 'image' => $image));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al eliminar la imagen del sistema [' . $e->getMessage() . ']'));
		}

	}

	// Eliminamos una imaen de la galeria
	public function imageGaleryDelete()
	{
		$gid 			= Input::get('gid');
		$img_cat_dir 	= Config::get('btsite.path') . Config::get('btsite.img_catalog');

		try {

			$galery = Galery::find($gid);

			if(!$galery) return Response::json(array('status' => false, 'message' => 'La galeria no gue encontrada'));

			// Imagenes de galeria adicional
			$full_image 		= $img_cat_dir . $galery->image;
			$small_image 		= $img_cat_dir . $galery->image_small;
			$tag_image 			= $img_cat_dir . $galery->image_tag;

			if(File::exists($full_image)) File::delete($full_image);
			if(File::exists($small_image)) File::delete($small_image);
			if(File::exists($tag_image)) File::delete($tag_image);

			if(!$galery->delete()) return Response::json(array('status' => false, 'message' => 'La imagen de galeria, sin embargo la imagen si fue eliminada del sistema.'));

			return Response::json(array('status' => true, 'message' => 'La imagen de galeria fue eliminada del sistema'));
			
		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al tratar de eliminar la imagen de la galeria [ ' . $e->getMessage() . ']'));
		}
	}

	// Remplazamos una imagen de la galeria a la imagen main
	public function imageGaleryReplace()
	{
		$gid 				= Input::get('gid');
		$pid 				= Input::get('pid');
		$img_cat_dir 		= Config::get('btsite.path') . Config::get('btsite.img_catalog');
		$seed 				= rand(100, 999);
		
		try {
			
			$galery 		= Galery::find($gid);
			$image 			= Image::where('product_id',$pid)->first();

			if(!$galery) return Response::json(array('status' => false, 'message' => 'Imagen de galeria no encontrada'));

			$product 		= Product::find($pid);
			$code 			= $product->code;
			$cat 			= $product->category_id;

			// Imagenes de galeria adicional
			$full_image 	= $img_cat_dir . $galery->image;
			$small_image 	= $img_cat_dir . $galery->image_small;
			$tag_image 		= $img_cat_dir . $galery->image_tag;

			// Nuevo juego de imagenes
			$new_image 		= $img_cat_dir . $code . '.jpg';
			$new_cat_image 	= $img_cat_dir . $code . '_cat.jpg';
			$new_tumb_image = $img_cat_dir . $code . '_tumb.jpg';
			$new_fb_image 	= $img_cat_dir . $code . '_fb.jpg';

			// Si existe la imagen la re-acomodamos
			$mainImage 		= $img_cat_dir . $code . '.jpg';

			$gi_name 		= $code . '_' . md5($code . $seed) . '.jpg';
			$gi_small		= $code . '_' . md5($code . $seed) . '_small.jpg';
			$gi_tag 		= $code . '_' . md5($code . $seed) . '_tag.jpg';

			$toGaleryImage 	= $img_cat_dir . $gi_name;
			$toGaleryImageS = $img_cat_dir . $gi_small;
			$toGaleryImageT = $img_cat_dir . $gi_tag;
			
			if(File::exists($mainImage)) {

				File::move($mainImage, $toGaleryImage);
				iImage::make($toGaleryImage)->resize(100, 150)->save($toGaleryImageS);
		        iImage::make($toGaleryImage)->resize(33, 50)->save($toGaleryImageT);
			}

			// Renombramos la imagen con el codigo del producto
			if(!File::move($full_image, $new_image)) return Response::json(array('status' => false, 'message' => 'No fue posible generar la nueva imagen main'));

			if($cat==1) iImage::make($new_image)->resize(190, 285)->save($new_cat_image);
	        else iImage::make($new_image)->resize(190, 210)->save($new_cat_image);

	        iImage::make($new_image)->resize(50, 50)->save($new_tumb_image);
	        iImage::make($new_image)->resize(100, 100)->save($new_fb_image);

	        // Eliminamos las viejas imagenes de la galeria
	        File::delete($small_image);
	        File::delete($tag_image);

	        if($image) {

	        	$galery->image 			= $gi_name;
		        $galery->image_small 	= $gi_small;
		        $galery->image_tag 		= $gi_tag;

		        if(!$galery->save()) return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al remplazar la imagen de la galeria'));
	        
	        } else $galery->delete();

	        if($image) $image->touch();
	        else {

	        	$image 				= new Image();
	        	$image->product_id 	= $pid;
	        	$image->full 		= $code . '.jpg';
	        	$image->catalog 	= $code . '_cat.jpg';
	        	$image->fb_share 	= $code . '_fb.jpg';
	        	$image->thumbnail 	= $code . '_tumb.jpg';

	        	if(!$image->save()) return Response::json(array('status' => false, 'message' => 'La imagen no pudo ser guardada, pero las imagenes se han remplazado'));

	        }

	        return Response::json(array('status' => true, 'message' => 'Imagen remplazada'));

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al remplazar la imagen [' . $e->getMessage() . ']'));
		}
	}

}









