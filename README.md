# Database

- Default tables (utilisateurs, groupes, logs, droits, plugins)
- Default views (droits_groupes)

# Basic usage
### Controller
link : https://example.com/users/1
$id : users
$arg : 1
```php
public function traitement($id,$arg){
  $submit = $_POST['submit'] ?? "";
  $post = $this->form->protectionFormulaire($_POST);
  
  if(_POST){
    if($submit == "add"){
      $donnees = array('nom','prenom');
      $required = array('nom','prenom');
      if($this->form->validate($donnees,$required)){
        $this->model->table = "utilisateurs";
        if($this->model->insertion(array('nom'=>$post['nom'],'prenom'=>$post['prenom'])){
          $this->success[] = "Success";
        }else{
          $this->errors[] = "Error";
        }
      }
    }
  }
  if (count($this->errors) >= 1) {
      $this->view('app/erreurs/erreurs', $this->errors);
  }

  if (count($this->form->errors) >= 1) {
      $this->view('app/erreurs/erreurs', $this->form->errors);
  }
}
public function indexForm(){
  $this->model->table = "utilisateurs";
  $data['user'] = $this->model->lecture();
  $this->view('utilisateurs/index',$data);
}
```
### View 
```php
<div>
  <?php
  foreach($data['user'] as $user){
    echo "<p>".$user['nom']." ".$user['prenom']."</p>";
  }
  ?>
</div>
```
  
# Generer une page

Generer automatiquement un controller avec une vue via le dossier "scripts/generate/run.php".<br/>
Lancer la commande sur un dos ou linux :
- php run.php arg1 arg2
- arg1 : nameController
- arg2 : public ou private view
