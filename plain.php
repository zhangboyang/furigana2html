<?php
/* furigana plain-text renderer by ZBY 2019.5.31 */

if (php_sapi_name() == "cli") {
    $fn = $argv[1];
} else {
    $fn = $_GET['f'];
}
if (!is_string($fn) || !preg_match('/^[A-Za-z0-9_]{1,40}\.txt$/', $fn)) {
    echo "illegal file name\n";
    die(0);
}
$f = file_get_contents($fn);
if (!$f) {
    echo "cannot open file\n";
    die(0);
}

$f = preg_replace("/\([^)]*\)/", "", $f);
$f = preg_replace("/<[^<]*>/", "", $f);
$f = preg_replace("/[{}\[\]\\\\]/", "", $f);

$f = preg_replace("/^[^\n]*\n/", "", $f);
$f = preg_replace("/^\n/", "", $f);


header('Content-Type: text/plain; charset=utf-8');
echo $f;
?>
