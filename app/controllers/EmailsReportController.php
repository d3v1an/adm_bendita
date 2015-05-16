<?php

class EmailsReportController extends \BaseController {

	// Vista principal de reportes de envio de emails
	public function index()
	{
		$params = array(
					'active' => 'email/report'
				);

		return View::make('emails.report')->with($params);
	}

	// Funcion para buscar los correos enviados
	public function search()
	{

		// DataTable params
		$pagina		= Input::get('sEcho');
		$start  	= Input::get('iDisplayStart');
		$limit		= Input::get('iDisplayLength');

		//Rows config
		$dic 		= array();

		$dic[0] 	= "full_name";
		$dic[1] 	= "email";
		$dic[2] 	= "status";
		$dic[3] 	= "order_id";
		$dic[4]		= "created_at";

		// Order
		$order 		= $dic[Input::get('iSortCol_0')]; 
		$by 		= strtoupper(Input::get('sSortDir_0'));

		// Search critelial
		$condition 	= Input::has('sSearch') && Input::get('sSearch') !="" ? Input::get('sSearch') : null;

		// Total items
		$total 		= 0;
		if(is_null($condition)) $total = EmailsReport::All()->count();
		else {

			$total 	= EmailsReport::where('full_name','LIKE',"%{$condition}%")
								   ->orWhere('email','LIKE',"%{$condition}%")
								   ->count();
		}

		// Full result
		$dbEmails 	= array();

		if(!is_null($condition)) {

			$dbEmails = EmailsReport::where('full_name','LIKE',"%{$condition}%")
									  ->orWhere('email','LIKE',"%{$condition}%")
									  ->take($limit)
									  ->skip($start)
									  ->orderBy($order,$by)
									  ->get();
		} else {

			$dbEmails = EmailsReport::where('id','>','0')
									  ->take($limit)
									  ->skip($start)
									  ->orderBy($order,$by)
									  ->get();
		}

		// Emails to display
		$emails 	= array();

		foreach ($dbEmails as $_email) {
			
			$email 					= array();
			$email['id']			= $_email->id;
			$email['full_name']		= $_email->full_name;
			$email['email']			= $_email->email;
			$email['status']		= $_email->status;
			$email['order_id'] 		= $_email->order_id;
			$email['created_at']	= $_email->created_at->format('Y-m-d H:i:s');

			$emails[] 				= $email;
		}

		/*
		 * Output
		 */
		$output = array(
			"sEcho" => $pagina,
			"iTotalRecords" => count($emails),
			"iTotalDisplayRecords" => $total,
			"aaData" => $emails
		);

		return Response::json($output, 200);
	}

	// Obtenemos el html de la notificacion
	public function getNotify()
	{
		$id = Input::get('id');

		try {
			
			$email = EmailsReport::find($id);

			if(!$email) return Response::json(array('status' => false, 'message' => 'No se encontro la notificacion'),200);

			return Response::json(array('status' => true, 'message' => 'Notificacion localizada', 'plantilla' => $email->email_doc),200);

		} catch (Exception $e) {
			return Response::json(array('status' => false, 'message' => 'Ocurrio un problema al obtener la notificacion [' . $e->getMessage() . ']'),200);
		}
	}
}