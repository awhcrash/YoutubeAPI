<?php


require_once ('TranslatorAPI/vendor/autoload.php');
use \Statickidz\GoogleTranslate;

if (isset($_GET['from']) && isset($_GET['to']) && isset($_GET['text'])) {
    $trans = new GoogleTranslate();
    print $trans->translate($_GET['from'], $_GET['to'], $_GET['text']);
}


?>