<?php
function pre($arr) {
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}
function isIphone() {
    return strstr($_SERVER['HTTP_USER_AGENT'],'iPhone');
}
function esDateTime($strTime) {

	$dias 	= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$meses 	= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	return $dias[date('w',$strTime)]." ".date('d',$strTime)." de ".$meses[date('n',$strTime)-1]. " del ".date('Y',$strTime) ;
}

function fix_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    // Original
    // $string = str_replace(
    //     array("\\", "¨", "º", "-", "~",
    //          "#", "@", "|", "!", "\"",
    //          "·", "$", "%", "&", "/",
    //          "(", ")", "?", "'", "¡",
    //          "¿", "[", "^", "`", "]",
    //          "+", "}", "{", "¨", "´",
    //          ">", "< ", ";", ",", ":",
    //          ".", " "),
    //     '',
    //     $string
    // );

    $string = str_replace(
        array("\\", "¨", "º", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             "."),
        '',
        $string
    );

    return $string;
}
?>