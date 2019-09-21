<?php
/* furigana renderer by ZBY 2019.4.26 */

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
$e = explode("\n", $f, 2);
$s = preg_split('//u', $e[1], -1, PREG_SPLIT_NO_EMPTY);

?><!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="content-language" content="ja">
<meta name="viewport" content="width=device-width">
<title><?php echo $e[0]; ?></title>
<style>
@media print
{
    #toolbar {
        display: none !important;
    }
    #pagehead {
        display: none !important;
    }
    #pagetail {
        display: none !important;
    }
}

html {
    overflow-y: scroll;
}

* {
    margin: 0;
    padding: 0;
}

.gothic {
    font-family: "ヒラギノ角ゴ ProN", "Hiragino Kaku Gothic ProN", "游ゴシック", "游ゴシック体", YuGothic, "Yu Gothic", "メイリオ", Meiryo, "ＭＳ ゴシック", "MS Gothic", HiraKakuProN-W3, "TakaoExゴシック", TakaoExGothic, "MotoyaLCedar", "Droid Sans Japanese", sans-serif;
}

.mincho {
    font-family: "ヒラギノ明朝 ProN", "Hiragino Mincho ProN", "游明朝", "游明朝体", YuMincho, "Yu Mincho", "ＭＳ 明朝", "MS Mincho", HiraMinProN-W3, "TakaoEx明朝", TakaoExMincho, "MotoyaLCedar", "Droid Sans Japanese", serif;
}


#toolbar {
    font-size: 16px;
    line-height: 16px;
    padding-bottom: 6px;
    border-bottom: 1px solid black;
}

#toolbar a {
    color: #0000EE;
    text-decoration: none;
}

.sqen #toolbar #sqen {
    text-decoration: underline;
}
.nosq #toolbar #nosq {
    text-decoration: underline;
}
.gothic #toolbar #gothic {
    text-decoration: underline;
}
.mincho #toolbar #mincho {
    text-decoration: underline;
}

#pagehead {
    margin-bottom: 12px;
}

#pagetail {
    margin-top: 12px;
}


<?php
    for ($i = 1; $i <= 5; $i++) {
        for ($j = 1; $j <= $i * 5; $j++) {
            $r = 2.0 * $i / $j;
            if ($r > 1.0) {
                $r = 1.0;
            }
            echo ".sqen div.ja.t${j}b${i} > div.b2 > div > div { transform: translateX(-50%) scaleX(${r}); }\n";
            echo ".nosq div.ja.t${j}b${i} > div.b2 > div > div { transform: translateX(0) scaleX(1); }\n";
            echo ".mfsfix .sqen div.ja.t${j}b${i} > div.b2 > div > div { font-size: 20px; transform: translateX(-50%) scaleX(${r}) scale(0.5); }\n";
            echo ".mfsfix .nosq div.ja.t${j}b${i} > div.b2 > div > div { font-size: 20px; transform: translateX(-50%) scaleX(1) scale(0.5); }\n";
            $jw = $j * 10;
            echo ".mfsfix .nosq div.ja.t${j}b${i} > div.b2 { min-width: ${jw}px; }\n";
            $mw = $j * 20 * 2;
            echo ".mfsfix .nosq .ja.t${j}b${i} > .b2 > div > div { width: ${mw}px; white-space: nowrap; }\n";
            echo ".mfsfix .nosq .ja.t${j}b${i} > .b2 > div { width: 0; margin-left: 50%; float: left; }\n";
            echo ".sqen .ja.t${j}b${i} > .b2 > div > div { width: ${mw}px; white-space: nowrap; }\n";
            echo ".sqen .ja.t${j}b${i} > .b2 > div { width: 0; margin-left: 50%; }\n";
        }
    }
?>


.b2 {
    width: 100%;
    display: block;
    font-size: 10px;
    height: 10px;
    line-height: 10px;
    text-align: center;
    margin-bottom: 1px;
}
.b1 {
    display: block;
    font-size: 20px;
    height: 20px;
    line-height: 20px;
    text-align: center;
}
.bx { /* outer box */
    display: inline-block;
    height: 31px;
}
.ln { /* line */
    margin: 6px 0;
    min-height: 28px;
    position: relative;
}
.nofb .ln {
    max-height: 31px;
}

.debug #text div {
    outline: 1px solid green;
}

#text {
    font-size: 20px;
    white-space: nowrap;
}

#main {
    display: table;
    text-align: left;
    min-width: 720px;
    margin: 0 auto;
    padding: 25px;
    overflow: hidden;
}

#mfstest {
    font-size: 10px;
}

.fben #box {
    display: none;
}
.fben #ruby {
    display: block;
}
.fben #sqcfg {
    display: none;
}

#ruby {
    display: none;
}
ruby {
    font-size: 20px;
}


/* style for user data */
.r { /* right align, for <div> */
    position: absolute;
    bottom: 0;
    right: 0;
}
.c { /* center align, for <div> */
    text-align: center;
}
.s { /* small direct text, for <span> */
    font-size: 16px;
}
.fben .u { /* under line, for <div> */
    display: inline;
    border-bottom: 1px solid black;
    padding-bottom: 1px;
    margin-bottom: -2px;
}
.nofb .u { /* under line, for <div> */
    border-bottom: 1px solid black;
    padding-bottom: 1px;
    margin-bottom: -2px;
    display: inline-block;
    height: 31px;
}
</style>
<!--[if lt IE 8]>
<style>
#main {
    display: block;
    width: 720px;
}
.ln { /* line */
    height: 40px;
}
</style>
<![endif]-->
</head>
<body>
<script>
function setcfg(t, v) {
    document.getElementById(t).className = v;
    document.cookie = t + "=" + v + ";max-age=31536000";
}
</script>
<div id="main">

<div id="fb" class="nofb"><div id="ff" class="mincho"><div id="sq" class="sqen">
<div id="mfstest"></div>
<script>
var ffsv = document.cookie.replace(/(?:(?:^|.*;\s*)ff\s*\=\s*([^;]*).*$)|^.*$/, "$1");
var sqsv = document.cookie.replace(/(?:(?:^|.*;\s*)sq\s*\=\s*([^;]*).*$)|^.*$/, "$1");
if (ffsv != "") setcfg("ff", ffsv);
if (sqsv != "") setcfg("sq", sqsv);

var ua = window.navigator.userAgent;
if (ua.indexOf('MSIE ') > 0 || ua.indexOf('Trident/') > 0) {
    if (window.console) console.log("IE detected, using fallback");
    document.getElementById("fb").className = "fben";
} else if (document.createElement("div").style["transform"] === undefined) {
    document.getElementById("fb").className = "fben";
}

if (window.getComputedStyle && window.getComputedStyle(document.getElementById("mfstest")).fontSize != "10px") {
    if (window.console) console.log("min font-size problem dectected, applying fix");
    document.getElementById("main").classList.add("mfsfix");
}
</script>
<div id="toolbar" class="gothic"><a href="javascript:;" onclick="window.print()">印刷</a><span id="ffcfg">　<a href="javascript:;" onclick="setcfg('ff','mincho')" id="mincho">明朝</a>/<a href="javascript:;" onclick="setcfg('ff','gothic')" id="gothic">ゴシック</a></span><span id="sqcfg">　<a href="javascript:;" onclick="setcfg('sq','sqen')" id="sqen">ｶﾅ</a>/<a href="javascript:;" onclick="setcfg('sq','nosq')" id="nosq">カナ</a></span></div>
<div id="pagehead"></div>
<div id="text"><?php

    if (end($s) !== "\n") array_push($s, "\n");

    for ($type = 0; $type < 2; $type++) {
    
        if ($type == 0) echo "<div id=\"box\">";
        if ($type == 1) echo "<div id=\"ruby\">";
    
        $buf = ["", ""]; $buflen = [0, 0];
        $tch = ""; $tchlen = 0;
        $p = -1;
        $skip = 0;
        $tag = 0;
        
        $nl = 0;
        $linehead = "<div class=\"ln\">";
        $linetail = "</div>";
        
        echo "$linehead";
        
        foreach ($s as $ch) {
            if ($skip) {
                $skip = 0;
                continue;
            }
            if ($tag) {
                if ($ch === ">" || $ch === "}") {
                    $tag = 0;
                }
                if ($ch !== "}") {
                    echo $ch;
                }
                continue;
            }
            if ($nl) {
                echo "${linehead}";
                $nl = 0;
            }
            
            $boxflag = 0;
            $box2 = "";
            $box1 = "";
            $box2len = 0;
            $box1len = 0;
            
            if ($ch === "\\") {
                $skip = 1;
            } else if ($ch === "<" || $ch === "{") {
                $boxflag = 1; $box1 = $tch; $box1len = $tchlen;
                $tch = ""; $tchlen = 0;
                $tag = 1;
            } else if ($ch === "[") {
                $boxflag = 1; $box1 = $tch; $box1len = $tchlen;
                $tch = ""; $tchlen = 0;
                $p = 0;
            } else if ($ch === "]") {
                $p = -1;
            } else if ($ch === "(") {
                $p = 1;
            } else if ($ch === ")") {
                $boxflag = 1;
                $box1 = $tch . $buf[0];
                $box1len = $tchlen + $buflen[0];
                $box2 = $buf[1];
                $box2len = $buflen[1];
                
                $p = -1;
                $buf[0] = ""; $buflen[0] = 0;
                $buf[1] = ""; $buflen[1] = 0;
                $tch = ""; $tchlen = 0;
            } else if ($p < 0) {
                if ($ch === "\n") {
                    $boxflag = 1; $box1 = $tch; $box1len = $tchlen;
                    $tch = ""; $tchlen = 0;
                } else if (ord($ch) < 128) {
                    if ($tch === "" || ord($tch) < 128) {
                        $tch .= $ch; $tchlen += 1;
                    } else {
                        $boxflag = 1; $box1 = $tch; $box1len = $tchlen;
                        $tch = $ch; $tchlen = 0;
                    }
                } else {
                    $boxflag = 1; $box1 = $tch; $box1len = $tchlen;
                    $tch = $ch; $tchlen = 1;
                }
            } else {
                $buf[$p] .= $ch;
                $buflen[$p] += 1;
            }
            
            if ($boxflag && $box1 !== "") {
                if ($type == 0) {
                    $boxtype = ord($box1) < 128 ? "en" : "ja";
                    echo "<div class=\"bx ${boxtype} t${box2len}b${box1len}\"><div class=\"b2\"><div><div>${box2}</div></div></div><div class=\"b1\">${box1}</div></div>";
                }
                if ($type == 1) {
                    if ($box2 == "") $box2 = "　";
                    echo "<ruby>${box1}<rt>${box2}</rt></ruby>";
                }
            }
            if ($ch === "\n") {
                echo "${linetail}";
                $nl = 1;
            }
            if ($ch === "<") {
                echo "<";
            }
        }
        
        echo "</div>\n";
    }
?></div>
<div id="pagetail"></div>
</div></div></div>

</div>
</body></html>
