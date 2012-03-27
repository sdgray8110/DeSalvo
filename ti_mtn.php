<?php
include("php/head.php");

////////////////////////////////////////////////////////////
// This code needs to be added to any page with a gallery //
////////////////////////////////////////////////////////////
$alt = 'DeSalvo Custom Cycles | Titanium Mountain Bikes';
$pageName = 'tiMtn';
$filePath = $imagePath . 'bikeGalleries/' . $pageName;
$activeClass = 'active';
$carouselView = 6;

/* Variable definitions - See Above
 * $alt -- // Alt Tag For Images
 * $pageName -- // Page Name - the directory within images where the images are kept
 * $filePath -- // Path to images in gallery -- currently bikeGalleries
 * $activeClass -- // Class assigned to the currently active thumbnail
 * $carouselView -- // Number of visible items on one page of carousel
 */

/////////////////////////////////////
// END IMAGE GALLERY REQUIRED CODE //
/////////////////////////////////////

?>

<body>
<div id="page">

<?php
include("php/header.php");
include("php/lists/topnav.php");
include("php/pagetitles/ti_mtn.php");

// This function call builds the gallery on the page //
// declaring shuffle randomizes the order of the images //
// if you don't want the gallery to shuffle - change 'shuffle' to 'false' //
buildPhotoGallery($filePath, $activeClass, $alt, $carouselView, 'shuffle');

include("php/descriptions/timtn_description.php");
include("php/features/timtn_features.php");
include("php/tubing/timtn_tubing.php");
include("php/faq.php");
include("php/geometry/timtn_geometry.php");
include("php/footer.php");

// We'll want to improve this later, but this contains the javascript
// Always required for the image gallery
include("php/javascript.php");
include("php/galleryJS.php");


?>

</div>

</body>
</html>
