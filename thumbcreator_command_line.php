<?php

    require_once 'thumblib.php';


    $imagedir = isset($argv[1]) ? $argv[1] : '';
    $thumbdir = isset($argv[2]) ? $argv[2] : ''; 
    $imgwidth = isset($argv[3]) ? $argv[3] : '1024'; 

    if($imagedir == '' || $thumbdir == '')
    { 
        print "\nUsage:  thumbcreator.php [imagedir] [thumbdir] [imgwidth]\n\n";
        die();
    }

    //print "imagedir: $imagedir\n";
    //print "thumbdir: $thumbdir\n";
    //print "imgwidth: $imgwidth\n";


    if($imagedir != '' && $thumbdir != '')
    {
        // make sure the dir names end with a slash if not append
        if(preg_match("/\/$/", $imagedir) == 0) { $imagedir .= "/"; }
        if(preg_match("/\/$/", $thumbdir) == 0) { $thumbdir .= "/"; }

        $thumbprefix = "tn_";

        createThumbs($imagedir, $thumbdir, $imgwidth, $thumbprefix);

        createGallery($imagedir, $thumbdir, $thumbprefix);
    }

?>
