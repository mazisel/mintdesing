<?php

 require_once("config/SimpleImage.php");
    // Allowed extentions.
    $allowedExts = array("gif", "jpeg", "jpg", "png");

    // Get filename.
    $temp = explode(".", $_FILES["file"]["name"]);

    // Get extension.
    $extension = end($temp);

    // An image check is being done in the editor but it is best to
    // check that again on the server side.
    // Do not use $_FILES["file"]["type"] as it can be easily forged.
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

    if ((($mime == "image/gif")
    || ($mime == "image/jpeg")
    || ($mime == "image/pjpeg")
    || ($mime == "image/x-png")
    || ($mime == "image/png"))
    && in_array($extension, $allowedExts)) {
        // Generate new random name.
        $name = sha1(microtime()) . "." . $extension;

        // Save file in the uploads folder.
        try {
          // Create a new SimpleImage object
          $image = new \claviska\SimpleImage();

          // Manipulate it
          $image
            ->fromFile($_FILES["file"]["tmp_name"])              // load parrot.jpg
            ->autoOrient()                        // adjust orientation based on exif data
            ->bestFit(1200,1000)
            ->toFile(dirname(__DIR__)."/".SitePath."images/img/".$name);                         // output to the screen

        } catch(Exception $err) {
          // Handle errors
          echo $err->getMessage();
        }
        #move_uploaded_file($_FILES["file"]["tmp_name"], getcwd() . "./resimler/konu/" . $name);

        // Generate response.
        $response = new StdClass;
        $response->link = BASE_URL.SitePath."images/img/" . $name;
        echo stripslashes(json_encode($response));
    }
?>