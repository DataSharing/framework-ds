<?php
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
    </body>
</html>
