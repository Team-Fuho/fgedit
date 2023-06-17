<?php
ob_start();
$pluginpath = dirname(__FILE__);
require_once($pluginpath . '/../src/modify.php');
// echo json_encode($_POST);
// require ../src/modify.php;
function removeslashes($string)
{
    $string=implode("",explode("\\",$string));
    return stripslashes(trim($string));
}
// fields: gall-title, gall-cont,lang, mod (modify), del (delete), attatchment, etarid
// replace current gallitem[etarid] with new one

$mongoc = fuho_conn();
// execute modify
if (isset($_POST['mod'])) {
  $gallitem = $mongoc->findOne(['_id' => new MongoDB\BSON\ObjectId($_POST['gall-id'])]);
  // add to gallitem [lang] the title and content
  $gallitem[$_POST['lang']] = [
    'title' => $_POST['gall-title'],
    'content' => $_POST['gall-cont']
  ]; // should keep other languages
  //date is unix
  $gallitem['date'] = time();
  $gallitem['src'] = $_POST['attatchment'];
    // find using _id, remember id is ObjectID
    $mongoc->replaceOne(['_id' => new MongoDB\BSON\ObjectId($_POST['gall-id'])], $gallitem); // works!
  } elseif (isset($_POST['del'])) {
    $mongoc->deleteOne(['_id' => new MongoDB\BSON\ObjectId($_POST['gall-id'])]);
  }
header('Location: ' . $_SERVER['HTTP_REFERER']);
    ?>
