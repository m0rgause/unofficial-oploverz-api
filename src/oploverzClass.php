<?php
include_once 'simple_html_dom.php';
/**
* Oploverz v1.0
*/
class Oploverz
{
private $uri = "https://www.oploverz.in";

public function onGoing(int $page = 1)	
{
	$output = array();
	$html = file_get_html("{$this->uri}/page/{$page}");
	if ($html == '') {
		return "Something was wrong";
	}
	$html = $html->find('div.postbody', 0);
	$c = substr_count($html, "<li>");
	$i = 0;
	while ($i < $c) {
		$temp = $html->find('li', $i);
		$data['link'] = $this->getBetween($temp, 'a href="https://www.oploverz.in/','/"');
		$data['title'] = $this->getBetween($temp, 'title="', '"');
		$data['image'] = $this->getBetween($temp, 'src="','-140x78').".jpg";
		array_push($output, $data);

		$i++;
	}
	return $output;

}
public function searchAnime(string $query = null, int $page = 1)
{
	$output = array();
	$html = file_get_html("{$this->uri}/page/{$page}/?s={$query}");
	if ($html == '') {
		return "Something was wrong";
	}
	$html = $html->find('div.postbody', 0);
	$c = substr_count($html, "<li>");
	$i = 0;
	while ($i < $c) {
		$temp = $html->find('li', $i);
		$data['link'] = $this->getBetween($temp, 'a href="https://www.oploverz.in/','/"');
		$data['title'] = $this->getBetween($temp, 'title="', '"');
		$data['image'] = $this->getBetween($temp, 'src="','-140x78').".jpg";
		array_push($output, $data);

		$i++;
	}
	return $output;
}

public function mkvDownload($link, $quality)
{
	$output = array();
	$html = file_get_html("{$this->uri}/{$link}");
	if ($html == '') {
		return "Something Was Wrong";
	}
	$html = $html->find('div.op-download', 0);
	switch ($quality) {
		case '480':
			$list = $html->find('div.list-download', 1);
			break;
		case '720':
			$list = $html->find('div.list-download', 2);
			break;
		case '1080':
			$list = $html->find('div.list-download', 4);
			break;
		default:
			$list = $html->find('div.list-download', 0);
			break;
	}

	$c = substr_count($list, '</a>');
	$i = 0;
	while ($i < $c) {
		$temp = $list->find('a', $i);
		$data['title'] = $this->getBetween($temp, '">','</a>');
		$data['server'] = $this->getBetween($temp, 'href="', '"');
		array_push($output, $data);
		$i++;
	}
	return $output;
}

public function mp4Download($link, $quality)
{
	$output = array();
	$html = file_get_html("{$this->uri}/{$link}");
	if ($html == false) {
		return "Something was wrong";
	}
	$html = $html->find('div.op-download', 1);
	switch ($quality) {
		case '480':
			$list = $html->find('div.list-download', 1);
			break;
		case '720':
			$list = $html->find('div.list-download', 2);
			break;
		default:
			$list = $html->find('div.list-download', 0);
			break;
	}

	$c = substr_count($list, '</a>');
	$i = 0;
	while ($i < $c) {
		$temp = $list->find('a', $i);
		$data['title'] = $this->getBetween($temp, '">','</a>');
		$data['server'] = $this->getBetween($temp, 'href="', '"');
		array_push($output, $data);
		$i++;
	}
	return $output;
}

private function getBetween($content, $start, $end)
	{
		$r = explode($start, $content);
		if (isset($r[1])){
			$r = explode($end, $r[1]);
			return $r[0];
		}
		return '';
	}
}
