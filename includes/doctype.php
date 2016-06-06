<?php include './config/config.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <!-- CSS -->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $config['base_url']; ?>template/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $config['base_url']; ?>template/bootstrap/css/jquery-ui.css" />		
        <!-- JS -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="<?php echo $config['base_url']; ?>template/bootstrap/js/jquery.nicescroll.min.js"></script>
        <script type="text/javascript" src="<?php echo $config['base_url']; ?>template/bootstrap/js/jquery-ui.js"></script>
        <!-- Style perso app -->
        <script type="text/javascript" src="<?php echo $config['base_url']; ?>template/bootstrap/js/app.js" ></script>
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $config['base_url']; ?>template/bootstrap/css/app.css" />	
        <title><?php echo $config['nom_du_site'];?></title>
    </head>
    <body>