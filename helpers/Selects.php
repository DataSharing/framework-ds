<?php

class Selects extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load('core/Model');
        $this->load('core/Session');
    }

    public function groupes($id_selected = '', $show = 0)
    {
        $this->model->table = "groupes";
        $groupes = $this->model->lecture(['id', 'nom'], [], '', ['nom' => 'asc']);

        if ($show == 1) {
            return $this->model->onerow('nom', ['id' => $id_selected]);
        }

        echo "<select name='groupes' class='custom-select w-100' required>";
        echo "<option value=''>>>> Groupes</option>";
        foreach ($groupes as $groupe) {
            $selected = "";
            if ($groupe['id'] == $id_selected) {
                $selected = "selected";
            }
            echo "<option value='" . $groupe['id'] . "' " . $selected . ">";
            echo $groupe['nom'] . "</option>";
        }
        echo "</select>";
    }
}
