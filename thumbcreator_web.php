<?php

    require_once 'thumblib.php';

    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $imagedir = isset($_POST['imagedir']) ? $_POST['imagedir'] : '';
    $thumbdir = isset($_POST['thumbdir']) ? $_POST['thumbdir'] : '';
    $imagewidth = isset($_POST['imagewidth']) ? $_POST['imagewidth'] : '1024';

    if($action == 'Create')
    {
        // make sure the dir names end with a slash
        if(preg_match("/\/$/", $imagedir) == 0) { $imagedir .= "/"; }
        if(preg_match("/\/$/", $thumbdir) == 0) { $thumbdir .= "/"; }

        $thumbprefix = "tn_";

        createThumbs($imagedir, $thumbdir, $imagewidth, $thumbprefix);

        createGallery($imagedir, $thumbdir, $thumbprefix);
    }

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PHP - Thumbnail Creator</title>
</head>
<body bgcolor="#f0f0f0">

<?php

    if($action == 'Create')
    {
        print "<script type=\"text/javascript\" language=\"javascript\">";
        print "window.location.href = \"gallery.html\";";
        print "</script>";
    }

?>


<center><b><font style="font-family: Verdana, Arial; font-size: 18px;" color="#800080">Thumbnail Creator</font></b></center>
<br />
<hr>
<form action="thumbcreator_web.php" method="post">

<table>
    <tr>
        <td>Path to images:</td>
        <td><input type="text" name="imagedir" size="32" /></td>
        <td>Example: images</td>
    </tr>
    <tr>
        <td>Path to thumbnails:</td>
        <td><input type="text" name="thumbdir" size="32" /></td>
        <td>Example: images/thumbs</td>
    </tr>
    <tr>
        <td>Image width:</td>
        <td><input type="text" name="imagewidth" size="8" /></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center"><input type="submit" name="action" value="Create" /></td>
    </tr>
</table>

</form>

</body>
</html>
