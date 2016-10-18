<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php 

            // *** CSS *** //
            echo '<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';
            if(is_array($data['css'])){
                foreach($data['css'] as $css){
                    echo '<link rel="stylesheet" ';
                        echo 'type="text/css" ';
                        echo 'media="screen" ';
                        echo 'href="'.$data['base_url'].'template/bootstrap/css/'.$css.'" />';
                }
            }else{
                echo '<link rel="stylesheet" ';
                        echo 'type="text/css" ';
                        echo 'media="screen" ';
                        echo 'href="'.$data['base_url'].'template/bootstrap/css/'.$data['css'].'" />';
            }

            // *** JS *** //
            echo '<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>';
            if(is_array($data['js'])){
                foreach($data['js'] as $js){
                    echo '<script type="text/javascript" ';
                    echo 'src="'.$data['base_url'].'template/bootstrap/js/'.$js.'"></script>';
                }
            }else{
                echo '<script type="text/javascript" ';
                    echo 'src="'.$data['base_url'].'template/bootstrap/js/'.$data['js'].'"></script>';
            }
        ?>	
        <title><?php echo $this->nom_du_site;?></title>
    </head>
    <body>