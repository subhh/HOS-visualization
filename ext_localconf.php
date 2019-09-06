<?php


$EXTPATH = (defined('TYPO3_MODE')) 
    ? \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY)
    : './';

if (strpos(TYPO3\CMS\Core\Utility\GeneralUtility::getHostname(), 'hosdev') == false && !defined('TYPO3_MODE')) {
    die('wrong hostname');
}

$count = 1907;
$ts = '';    
$FOO = "/home/mirko/.web/raw/";
$DISCOVERY_PATH = '/suchergebnis/';
$BAR = "Resources/Public/";
$R =   "EXT:hosvisualization/$BAR";

//    copy($FOO."data/resources.json", $EXTPATH . $BAR. "resources.json");
//    copy($FOO."data/languages.json", $EXTPATH . $BAR . "languages.json");
    $doc = new DOMDocument();
    $doc->loadHTMLFile($FOO . "index.html");
    $xpath = new DOMXPath($doc);
    foreach ($xpath->evaluate("//link[contains(@href, 'css')]") as $node) {
        $href = $node->getAttribute("href");
        $basename = basename($href);
        $ts .= "//ext. CSS\n";
        $foo = getFile($href,$FOO);
        if (file_exists($foo)) copy($foo, $EXTPATH.$BAR.$basename);
            else throw($foo . " not found");
        $ts .= "page.includeCSS.$count = $R$basename\n";
        $count+=5; 
    }
    foreach ($xpath->evaluate("//script") as $node) {
        $src = $node->getAttribute("src");
        if ($src == "") {
            $ts .= "page.jsFooterInline.$count = COA\n";
            $ts .= "page.jsFooterInline.$count {\n";
            $ts .= "    10 = TEXT\n";
            $ts .= "    10.value = $node->textContent\n";
            $ts .= "}\n";
//            file_put_contents("Resources/Public/$count.js",$node->textContent);
//            $ts .= "page.includeJS.$count = $R/$count.js\n";
        } else {
            $src = $node->getAttribute('src');
            $ts .= "//ext JS code:\n";
            $basename = basename($src);
            $foo = getFile($src,$FOO);
            if (file_exists($foo)) {
                $code = file_get_contents($foo);
                file_put_contents($EXTPATH.$BAR.$basename,str_replace('/discovery/',$DISCOVERY_PATH, $code));
            } 
              else echo($foo . " not found");
            $ts .= "page.includeJSFooter.$count  = $R$basename\n";
        }
        $count+=5;
    }
    file_put_contents($EXTPATH ."/Configuration/TypoScript/setup.txt",$ts);


    function getFile($foo,$FOO) {
        $bar = str_replace('./','', $FOO .$foo);
        return $bar;
    }
    function getFileContent($foo,$FOO) {
        return file_get_contents(getFile($foo,$FOO));
    }