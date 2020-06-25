<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php

    // *** CSS *** //
    echo '<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';

    if (is_array($data['css'])) {
        foreach ($data['css'] as $css) {
            echo '<link rel="stylesheet" ';
            echo 'type="text/css" ';
            echo 'media="screen" ';
            echo 'href="' . $data['base_url'] . 'template/bootstrap/css/' . $css . '" />';
        }
    } else {
        echo '<link rel="stylesheet" ';
        echo 'type="text/css" ';
        echo 'media="screen" ';
        echo 'href="' . $data['base_url'] . 'template/bootstrap/css/' . $data['css'] . '" />';
    }
    // *** OTHERS **** //
    if (count($data['others']) >= 1) {
        foreach ($data['others'] as $other) {
            echo '<link rel="stylesheet" ';
            echo 'type="text/css" ';
            echo 'media="screen" ';
            echo 'href="' . $data['base_url'] . 'template/' . $other . '" />';
        }
    }

    //CSS Plugins
    if (!empty($data['cssPlugins'])) {
        foreach ($data['cssPlugins'] as $cssPlugin) {
            echo '<link rel="stylesheet" ';
            echo 'type="text/css" ';
            echo 'media="screen" ';
            echo 'href="' . $data['base_url'] . $cssPlugin . '" />';
        }
    }
    // *** JS *** //
    echo '<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>';
    if (is_array($data['js'])) {
        foreach ($data['js'] as $js) {
            echo '<script type="text/javascript" ';
            echo 'src="' . $data['base_url'] . 'template/bootstrap/js/' . $js . '"></script>';
        }
    } else {
        echo '<script type="text/javascript" ';
        echo 'src="' . $data['base_url'] . 'template/bootstrap/js/' . $data['js'] . '"></script>';
    }
    //JS Plugins
    if (!empty($data['jsPlugins'])) {
        foreach ($data['jsPlugins'] as $jsPlugin) {
            echo '<script type="text/javascript" ';
            echo 'src="' . $data['base_url'] . $jsPlugin . '"></script>';
        }
    }
    ?>
    <title><?php echo $data['nom_du_site']; ?></title>
</head>

<body>