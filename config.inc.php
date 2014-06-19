<?php
date_default_timezone_set("Europe/Paris");
$pathClangToLog="logs/2012-01-12/";
$pathGCCToLog="rebuild.lsid64-amd64.2011-09-11";
$suffix="lsid64b";
$ext="buildlog";

$currentVersion="3.4.2";

$clangVersions=Array("2.9" => 16398, "3.0" => 15658, "3.1" => 17710, "3.2" => 18264, "3.3" => 18854, "3.4" => 21204, "3.4.2" => 21383);

switch ($_SERVER['HTTP_HOST']){
 case 'clang.debian.net':
 case 'manchot.ecranbleu.org':
        include("clang.debian.net.php");
	define("BASEPATH","/www/clang.debian.net/");
        $pathSite="/www/clang.debian.net/";
        $pathToBaseDocumentations="{$pathSite}docs/";
        $base="/";
        define("_DEBUG_MAIL_","sylvestre@ledru.info");
        $nom_emetteur="Site Sylvestre";
        $adr_emetteur="sylvestre.ledru@scilab.org";
        $type="MYSQL";
        $ATOMSdbAvailable=true;

        break;

 case 'localhost':
	define("_DB_","clang");
	define("_DB_HOST_","localhost");
	define("_DB_USER_","clang");
	define("_DB_PASS_","aze");
	$pathSite="/var/www/clang/";
	$pathToBaseDocumentations="{$pathSite}docs/";
	$base="/";
	define("_DEBUG_MAIL_","sly@hitomi.ecranbleu.org");
	$nom_emetteur="Site Sylvestre";
	$adr_emetteur="sylvestre.ledru@scilab.org";
	$type="MYSQL";

	break;

	default:
	define("_DB_","Unknow");
	define("_DB_HOST_","Unknow");
	define("_DB_USER_","Unknow");
	define("_DB_PASS_","Unknow");
	print "Le fichier config.inc.php n'est pas configure ";
	print "($HTTP_HOST)";
	exit;
}

$secureMode = false;
if ($_SERVER['REMOTE_ADDR']== "X.Y.Z.W") {
   $secureMode = true;
}

$host_db = _DB_HOST_;
$user_db = _DB_USER_;
$pass_db = _DB_PASS_;
//$port_db = _DB_PORT_;
$db_db = _DB_;



switch ($type) {
	case "POSTGRESQL" :
	$chaine_connexion="host=$host_db port=$port_db dbname=$db_db user=$user_db password=$pass_db";
	$conn = pg_pconnect($chaine_connexion);
	echo pg_errormessage($conn);
	break;
	case "MYSQL" :
	$conn_db = @mysql_connect("$host_db","$user_db","$pass_db");
	if( !@mysql_select_db("$db_db",$conn_db) ){
		//		echo ("Erreur dans la selection de la base de données $db_db -> $user_db@$host_db.\n");
		echo mysql_error();
	}
	break;
}

function db_query ($req)
{
	// Fonction "surcouche" e mysql_query () qui ajoute la gestion d'erreur
	global $type;
	global $conn;
	switch ($type) {
		case "POSTGRESQL" :
		if ( $sth=pg_exec($conn,$req) ) {
			return $sth;
		} else {
		  echo pg_errormessage($conn);
		  error_req($req);
		}
		break;
		case "MYSQL" :
		if ( $sth=mysql_query("$req") )
		{
			// la requete s'est bien passé
			// affichage de la requete si le verbose est activé
			return $sth;
		}
		else
		{
			// Erreur dans la requete, donc génération du mail.
		  echo mysql_error();
		  error_req($req);
		}
	}
}

function error_req ($req) {
	global $PHP_SELF;
	global $REQUEST_URI;
	global $REMOTE_ADDR;
	global $type;
	global $HTTP_REFERER;
	global $HTTP_USER_AGENT;
	$to=_DEBUG_MAIL_;
	switch ($type) {
		case "POSTGRESQL" :
		global $conn;
		$sgbd=pg_errormessage($conn);
		break;
		case "MYSQL" :
		$sgbd=mysql_error();
		break;
	}
	$subject="SQL query - Error";
	$body="Query : $req \nPage : $PHP_SELF \nError : ".$sgbd;
	$body.="\nRequested Url : $REQUEST_URI";
	$body.="\nGet :\n".parray($_GET)."\nPost :\n".parray($_POST)."\nSession :\n".parray($_SESSION);
	$body.="\nReferent : $HTTP_REFERER\nUser Agent : $HTTP_USER_AGENT\nAdresse distante : $REMOTE_ADDR ( ".gethostbyaddr($REMOTE_ADDR)." )\n";
	mail($to,$subject,$body);
}

/*
 * Retour une représentation des éléments d'un tableau 
 * $array : le tableau à afficher
 * $prep : le séparateur à utiliser
 * return : le tableau ainsi généré
 */
if (!function_exists("parray")){
function parray($array , $prep=''){
	$ret="";
        $prep = "$prep|";
		if (is_array($array) || is_object($array)) {
			if (is_object($array)) 
				$array=get_object_vars($array);
					
			while(list($key, $val) = each($array)) {
                $type = gettype($val);
                if(is_array($val)) {
					$line = "-+ $key ($type)\n";
					$line .= parray($val, "$prep ");
                } else {
					if (is_object($val)) { // C'est un object
                        $line = "-+ $key ($type)\n";
						$line .= parray(get_object_vars($val),"$prep ");
					}else {
                        $line = "=> $key = \"$val\" ($type)\n";
					}
                }
                $ret .= $prep.$line;
			}
		}
        return $ret;
}
}


function SendMail($adr_destinataire,$sujet,$corps) {

	// l'émetteur
  global $nom_emetteur;
  global $adr_emetteur;
	$tete = "From: ".$nom_emetteur." <".$adr_emetteur.">\n";
	$tete .= "Reply-To: ".$adr_emetteur."\n";
	// false si erreur d'émission
	return mail($adr_destinataire,$sujet,$corps,$tete);
}

function formatsql($chaine) {
	return trim(nl2br(htmlspecialchars($chaine)));
}

function intervertir_date_EN_FR($date)
{
	// Interverti les dates FR -> En et FR -> En
	// Utiliser pour les traitements sur les dates
	$sep="-";
	$d=explode($sep , $date);
	$date=$d[2].$sep.$d[1].$sep.$d[0];
	if($date=="00-00-0000" || $date=="0000-00-00" || count($d)<3)
		return "";
	return $date;
}

function add_comment ($id_author, $comment, $page, $lang, $id="") {
	$commentl=strtolower(trim($comment));
		$sql="INSERT INTO comment (id_author, comment, page, insertdate, lang, ";
        if (strlen($id)>0) {
            $sql.="idparent,";
        }
	$sql.=" hostname, ip) VALUES ('$id_author', '$comment', '$page', UNIX_TIMESTAMP(),'$lang',";
	if (strlen($id)>0) {
		$sql.="{$id},";
	}
	$sql.="'".gethostbyaddr($_SERVER['REMOTE_ADDR'])."','{$_SERVER['REMOTE_ADDR']})";
	db_query($sql);
		//		SendMail("sylvestre@ecranbleu.org","Howto linux","-----------Ajout d'un commentaire------------\nAuteur : $author\nEmail : $email\nCommentaire : $comment\nPage concernee : $page\nUrl de suppression : http://{$_SERVER['HTTP_HOST']}/howto/commentaire2.php?action=delete_sly&password=plop&id=".mysql_insert_id())."\n".parray($_SERVER);

}

function makeSummary($text, $nbchar) {
        if (strlen($text)>$nbchar) {
                return substr($text,0,$nbchar)." (...)";
        }else{
                return $text;
        }
}

?>
