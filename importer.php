<?php
    $count = 1907;
    $ts =  "page.headerData.$count = TEXT\n";
    $ts .= "page.headerData.$count.value=document.getElementById('main').innerHTML='<div id=\"root\"></div>'\n";
    $ts .= "page.headerData.$count.wrap = \n<script>|</script>\n";
    $R = 'EXT:hosvisualization/Resources/Public';
    $EP = "/home/mirko/.web/raw";
    $doc = new DOMDocument();
    $doc->loadHTMLFile($EP . "/index.html");
    $xpath = new DOMXPath($doc);
    foreach ($xpath->evaluate("//link[contains(@href, 'css')]") as $node) {
        $href = $node->getAttribute("href");
        $basename = basename($href);

        $ts .= "//ext. CSS\n";
        file_put_contents("Resources/Public/$basename",getFile($href,$EP));
        $ts .= "page.includeCSS.$count = $R/$basename\n";
        $count+=5; 
    }
    foreach ($xpath->evaluate("//script") as $node) {
        $src = $node->getAttribute("src");
        if ($src == "") {
            $ts .= "page.jsFooterInline.$count = COA\n";
            $ts .= "page.jsFooterInline.$count {\n";
            $ts .= "	10 = TEXT\n";
            $ts .= "    10.value = $node->textContent\n";
            $ts .= "}\n";
//            file_put_contents("Resources/Public/$count.js",$node->textContent);
//            $ts .= "page.includeJS.$count = $R/$count.js\n";
        } else {
            $src = $node->getAttribute('src');
            $basename = basename($src);
            echo "$basename\n";
            file_put_contents("Resources/Public/$basename",getFile($src,$EP));
            $ts .= "page.includeJSFooter.$count  = $R/$basename\n";
        }
        $count+=5;
    }
    file_put_contents("./Configuration/TypoScript/setup.txt",$ts);
    
    
    function getFile($foo,$EP) {
        $bar = str_replace('./','/', $EP .$foo);
        return file_get_contents($bar);
    }