<?php
// GLOBAL VARIABLES
$rootContext = '/home/desalvo/public_html/';
$phpContext = $rootContext . 'php/';
$imagePath = $rootContext . 'images/';
$infoEmail = 'DeSalvo Custom Cycles <info@desalvocycles>';
$contactEmail = 'DeSalvo Custom Cycles <mike@desalvocycles.com>';
$webEmail = 'DeSalvo Custom Cycles | Webmaster <trav.caldwell@gmail.com>';

// GLOBAL FUNCTIONS
function is_odd($number) {
  return $number & 1;
}

/////////////////////////
// BEGIN PHOTO GALLERY //
/////////////////////////
function buildPhotoGallery($filePath, $activeClass, $alt, $carouselView, $method) {
    $files = buildPhotoArray($filePath, $activeClass, $alt);
    $imgPath = explode('public_html', $filePath);

    if ($method == 'shuffle') {
        shuffle($files);
    }

    echo '
    <div id="bikeGallery">
        <div class="bigImg">
            <img src="'.$imgPath[1] . '/' . $files[0].'" alt = "'.$alt.'" />
        </div>

        <div class="carouselContainer">
            <div class="carousel view'.$carouselView.'">
                <ul class="thumbnailGallery">
    ';


    // Thumbnails
    $i = 0;
    $len = count($files) - 1;
    foreach ($files as $file) {
        $className = ($i == 0) ? ' class="'.$activeClass.'"' : (($i == $len) ? ' class="lastChild"' : '');
        $bigImg = $imgPath[1] . '/' . $files[$i].'" alt = "'.$alt;
        $thumb = $imgPath[1]."/thumbs/".$file;
        echo "\t<li".$className."><a href=\"".$bigImg."\"><img src=\"".$thumb."\" alt=\"".$alt."\" /></a></li>\n";
        $i ++;
    }

    echo '
                </ul>
            </div>
        </div>
    </div>    
    ';
}

function buildPhotoArray($filePath, $activeClass, $alt) {
    if ($handle = opendir($filePath)) {

        $files = array();
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "thumbs") {
                $files[] = $file;
            }
        }
        closedir($handle);
        return $files;
    }
}
/*********************/
/* END PHOTO GALLERY */
/*********************/

?>