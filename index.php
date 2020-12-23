<?php 
error_reporting(0);
require_once 'src/oploverzClass.php';
header('Content-type: application/json');
$op = new Oploverz;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$param = isset($_GET['param']) ? $_GET['param'] : null;
$query = isset($_GET['q']) ? $_GET['q'] : null;
$quality = isset($_GET['quality']) ? $_GET['quality'] : 360;
$link = isset($_GET['link']) ? urldecode($_GET['link']) : null;



// OnGoing
if ($param == "home" && is_integer($page)) {
	$details = $op->onGoing(urlencode($page));
	if (is_array($details)) {
		$output = array("response_code" => 200, "result" => $details);	
	}else {
		$output = array("response_code" => 404, "result" => $details);	
	}
	echo json_encode($output);
}


// Search Anime
if ($param == "search" && is_integer($page) && $query != null) {
	$details = $op->searchAnime(urlencode($query), $page);
	if (is_array($details)) {
		$output = array("response_code" => 200, "result" => $details);
	}else {
		$output = array("response_code" => 404, "result" => $details);
	}
	echo json_encode($output);
}


// MKV Download
if ($param == "mkv" && $link != null) {
	$details = $op->mkvDownload($link, $quality);
	if (is_array($details)) {
		$output = array("response_code" => 200, "result" => $details);
	}else{
		$output = array("response_code" => 404, "result" => $details);
	}
	echo json_encode($output);
}


// MP4 Download
if ($param == "mp4" && $link != null) {
	$details = $op->mp4Download($link, $quality);
	if (is_array($details)) {
		$output = array("response_code" => 200, "result" => $details);
	}else{
		$output = array("response_code" => 404, "result" => $details);
	}
	echo json_encode($output);
}




 ?>