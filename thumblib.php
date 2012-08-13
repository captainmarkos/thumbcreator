<?php

// Hey dude!
function createThumbs($pathToImages, $pathToThumbs, $thumbWidth, $thumbprefix)
{
    $dir = opendir($pathToImages);
    if($dir == false)
    {
        print "Failed to open image dir: $pathToImages \n";
        return;
    }
    $tn_dir = opendir($pathToThumbs);
    if($tn_dir == false)
    {
        print "Failed to open thumbnail dir: $pathToThumbs \n";
        return;
    }
    closedir($tn_dir);


    // loop through it, looking for any/all JPG files:
    while(false !== ($fname = readdir($dir)))
    {
        // parse path for the extension
        $info = pathinfo($pathToImages . $fname);

        // continue only if this is a JPEG image
        //if(strtolower($info['extension']) == 'jpg')
        if(preg_match("/\.jpg$/i", $fname))
        {
            // load image and get image size
            $img = imagecreatefromjpeg("{$pathToImages}{$fname}");
            $width = imagesx($img);
            $height = imagesy($img);

            // calculate thumbnail size
            $new_width = $thumbWidth;
            $new_height = floor( $height * ( $thumbWidth / $width ) );

            // create a new temporary image
            $tmp_img = imagecreatetruecolor($new_width, $new_height);

            // copy and resize old image into new image
            imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            // save thumbnail into a file - make thumb file name lowercase
      $fname = strtolower($fname);
            imagejpeg($tmp_img, "{$pathToThumbs}{$thumbprefix}{$fname}", 100);

            echo "Created thumbnail: {$pathToThumbs}{$thumbprefix}{$fname}\n";
        }
    }
    closedir($dir);
}
// Call createThumb() function and pass to it as parameters the path
// to the directory that contains images, the path to the directory
// in which thumbnails will be placed and the thumbnail width.  We
// are assuming that the path will be a relative path working both
// in the filesystem, and through the web for links
// createThumbs("upload/", "upload/thumbs/", 100, "tn_");


function createGallery($pathToImages, $pathToThumbs, $thumbprefix)
{
    $output  = "<html>\n";
    $output .= "<head><title>Thumbnails</title></head>\n";
    $output .= "<body>\n";
    $output .= "<table cellspacing=\"0\" cellpadding=\"2\" width=\"500\">\n";
    $output .= "<tr>\n";

    // open the directory
    $dir = opendir($pathToThumbs);

    $counter = 0;

    while (false !== ($fname = readdir($dir)))
    {
        $info = pathinfo($pathToThumbs . $fname);

        // continue only if this is a JPEG image
        if(strtolower($info['extension']) == 'jpg')
        {
            $realfname = preg_replace("/^{$thumbprefix}/", "", $fname);
            $output .= "<td valign=\"middle\" align=\"center\"><a href=\"{$pathToImages}{$realfname}\">";
            $output .= "<img src=\"{$pathToThumbs}{$fname}\" border=\"0\" />";
            $output .= "</a></td>\n";

            $counter += 1;
            if($counter % 4 == 0) { $output .= "</tr><tr>\n"; }
        }
    }

    closedir( $dir );

    $output .= "</tr>\n";
    $output .= "</table>\n";
    $output .= "</body>\n";
    $output .= "</html>\n";

    $fhandle = fopen("gallery.html", "w");
    fwrite($fhandle, $output);
    fclose($fhandle);
}
// Call createGallery() function and pass to it as parameters the path
// to the directory that contains images and the path to the directory
// in which thumbnails will be placed. We are assuming that the path
// will be a relative path working both in the filesystem, and through
// the web for links.
//createGallery("upload/", "upload/thumbs/", "tn_");


?>
