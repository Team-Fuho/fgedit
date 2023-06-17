<?php
ob_start();
$pluginpath = dirname(__FILE__);
require_once($pluginpath . '/../src/modify.php');

function removeslashes($string)
{
    $string=implode("",explode("\\",$string));
    return stripslashes(trim($string));
}

$mongoc = fuho_conn();

// fields: gall-title, gall-cont,lang, mod (modify), del (delete), attatchment, etarid
$langs = [
  "vi" => "Tiếng Việt",
  "en" => "English",
  "ru" => "Русский",
  "cn" => "中文",
  "jp" => "日本語",
  "kr" => "한국어",
  "fr" => "Français"
];
$item = [];
// for each key in langs, add to item[lang] the title and content, and add to other lang empty title and description
foreach ($langs as $key => $value) {
  if ($key == $_POST['lang']) {
    $item[$key] = [
      'title' => $_POST['gall-title'],
      'content' => $_POST['gall-cont']
    ];
  } else {
    $item[$key] = [
      'title' => "",
      'content' => ""
    ];
  }
}
//date is unix
$item['date'] = time();
//if no attatchment, redirect back with param alert, and say Cần thêm hình ảnh
if ($_POST['attatchment'] == "") { // (!)=={null||0||""}
  header('Location: ' . $_SERVER['HTTP_REFERER'] . '&alert='.urlencode("Cần thêm hình ảnh"));
} else {
  $item['src'] = $_POST['attatchment'];
  // do add item into database begin or end?
  $mongoc->insertOne($item);
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
