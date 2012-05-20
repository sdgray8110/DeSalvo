<?php
require_once('/home/desalvo/public_html/dev/php/config.php');

function bikeDimensions($size) {
    $file = $rootContext . 'data/bikeDimensions.json';
    $json = handleFile($file);
    $tableEls = array('size', 'ttl', 'htl', 'hsa', 'csl', 'bbd', 'soh');
    $headers = buildHeaders($json, $size, $tableEls);
    $content = buildTables($json, $tableEls, $size);

    return '<ul class="bikeGeometry">' . $headers . $content . '</ul>';
}

function handleFile($file) {
    $handle = fopen($file, "r");
    $contents = fread($handle, filesize($file));
    fclose($handle);
    $json = json_decode($contents, true);

    return $json;
}

function buildHeaders($json, $size, $tableEls) {
    $header = '<li class="title">'.$size.' Wheel Size Specification</li>';
    $items = $json['items'][0]['headers'];
    $headerCount = count($items);

    for ($i=0; $i<$headerCount; $i++) {
        $n = $tableEls[$i];

        $header .= '<li class="'.$tableEls[$i].' header">' . $items[$n] . '</li>';
    }

    return $header;
}

function buildTables($json, $tableEls, $size) {
    $items = $json['items'][0][$size];
    $content = buildContent($items, $tableEls);

    return $content;
}

function buildContent($items, $tableEls) {
    $content = '';
    $rows = count($items);

    for($i=0;$i<$rows;$i++) {
        $x = $i + 1;
        $n = 'size' . $x;
        $row = $items[$n];
        $rowClass = is_odd($i) ? ' oddRow' : '';
        $content .= buildRow($row, $tableEls, $rowClass);
    }
    return $content;
}

function buildRow($row, $tableEls, $rowClass) {
    $item = '';
    $len = count($row);

    for ($i=0;$i<$len;$i++) {
        $n = $tableEls[$i];
        $type = measureType($n);

        $item .= '<li class="'.$n.$rowClass.'">' . $row[$n] . $type . '</li>';
    }

    return $item;
}

function measureType($el) {
    $type = ' mm';

    if ($el == 'ttl' || $el == 'htl' || $el == 'size') {
        $type = ' cm';
    } else if ($el == 'hsa') {
        $type = '';
    }

    return $type;
}

?>