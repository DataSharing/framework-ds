<?php

/**
 * Class Formulaire : regroupe quelque fonctionnalité pour l'utilisation de formulaire
 */
class Formulaire extends Controller
{

    public $errors = array();

    function __construct()
    {
        parent::__construct();
        $this->load('core/Model', 'model');
    }

    /* Validation des données */
    public function validate($donnees, $valueRequired = array())
    {
        $valid = true;
        foreach ($donnees as $donnee) {
            /* Valeur post non défini */
            if (!isset($_POST[$donnee])) {
                $valid = false;
                $this->errors[] = "Variable <b>$donnee</b> non défini";
            } else {
                /* Valeur null ou vide non acceptée */
                if (in_array($donnee, $valueRequired)) {
                    if ($_POST[$donnee] == "" || $_POST[$donnee] == null) {
                        $valid = false;
                        $this->errors[] = "Champ obligatoire - <b>$donnee</b>";
                    }
                }
            }
        }
        return $valid;
    }

    /**
     * Protection du formulaire
     * Requête préparée ou cette fonction
     * 
     * @param array $data
     * @return array
     */
    public function ProtectionFormulaire($data = array(), $default = array())
    {
        if (is_array($data)) {
            foreach ($data as $cle => $valeur) {
                if (is_array($data[$cle])) {
                    $data[$cle] = $this->ProtectionFormulaire($data[$cle]);
                } else {
                    if (is_numeric($valeur)) {
                        //cast pour les nombres
                        $data[$cle] = intval($valeur);
                    } else {
                        //protection des chaines
                        $data[$cle] = htmlspecialchars($valeur);
                    }
                }
            }
        } else {
            $data = htmlspecialchars($data);
        }

        //Valeur par defaut
        if (count($default) >= 1) {
            foreach ($default as $key => $value) {
                if (!isset($data[$key])) {
                    $data[$key] = $value;
                }
            }
        }
        return $data;
    }

    /**
     * Création d'un INPUT HTML
     * @param string $name
     * @param string $type
     * @param string $placeholder
     * @param string $error
     * @param string $value
     * @param string $pattern
     * @param string $option
     */
    public function input($name, $type, $placeholder, $error = '', $value = '', $pattern = "[A-Za-z0-9]*", $option = 'required')
    {
        $input2 = '';
        $input3 = '';
        if (!$pattern == '') {
            $input2 = 'pattern="' . $pattern . '" ';
        }
        if (!$error == '') {
            $input3 = 'x-moz-errormessage="' . $error . '" ';
        }
        $input1 = '<input '
            . 'type="' . $type . '" '
            . 'id="' . $name . '" '
            . 'name="' . $name . '" '
            . 'placeholder="' . $placeholder . '" '
            . 'class="form-control" '
            . 'value="' . $value . '" '
            . $input2
            . $input3
            . $option
            . '/>';
        echo $input1;
    }

    /**
     * Création d'un INPUT GROUP HTML
     * @param string $name
     * @param string $type
     * @param string $placeholder
     * @param string $error
     * @param string $value
     * @param string $class
     * @param string $pattern
     * @param string $option
    [A-Za-z0-9 ]*
     */
    public function inputGroup($name, $type, $placeholder, $error = '', $value = '', $class = "form-control", $pattern = "", $option = '')
    {
        $input2 = '';
        $input3 = '';
        if (!$pattern == '') {
            $input2 = 'pattern="' . $pattern . '" ';
        }
        if (!$error == '') {
            $input3 = 'x-moz-errormessage="' . $error . '" ';
        }
        $data['input'] = '<input '
            . 'type="' . $type . '" '
            . 'id="' . $name . '" '
            . 'name="' . $name . '" '
            . 'placeholder="' . $placeholder . '" '
            . 'class="' . $class . '" '
            . 'value="' . $value . '" '
            . $input2
            . $input3
            . $option
            . '/>';
        $data['titre'] = $placeholder;
        $this->view('app/inputs/input.group', $data);
    }

    /**
     * Création d'un INPUT HTML
     * Version améliorée de $this->input(...)
     * @param array $options
     */
    public function inputTab($options = array())
    {
        $optionsInput = '';
        $openInput = '<input ';
        foreach ($options as $key => $option) {
            $opt = $key . "='" . $option . "' ";
            $optionsInput = $optionsInput . $opt;
        }
        $closeInput = ' />';
        $input = $openInput . $optionsInput . $closeInput;
        echo $input;
    }

    /**
     * Création d'un BUTTON HTML
     * @param string $name
     * @param string $text
     * @param string $value
     * @param string $class
     * @param string $option
    [A-Za-z0-9 ]*
     */
    public function btn($name, $text, $class = "btn btn-default", $option = '')
    {
        $btn = '<button '
            . 'type="submit" '
            . 'id="' . $name . '" '
            . 'name="submit" '
            . 'class="' . $class . '" '
            . 'value="' . $name . '" '
            . $option
            . '>' . $text . '</button>';
        echo $btn;
    }

    /**
     * Création d'un BUTTON HTML MODAL
     * @param string $name
     * @param string $text
     * @param string $value
     * @param string $class
     * @param string $option
    [A-Za-z0-9 ]*
     */
    public function btnModal($name, $text, $class = "btn btn-default", $target = '', $option = "")
    {
        $btn = '<button '
            . 'type="button" '
            . 'id="' . $name . '" '
            . 'name="submit" '
            . 'class="' . $class . '" '
            . 'value="' . $name . '" '
            . 'data-toggle="modal" '
            . 'data-target ="' . $target . '" '
            . $option
            . '>' . $text . '</button>';
        echo $btn;
    }

    /**
     * Afficher la date au format FR
     * @param date $date
     * @param string $affichage
     * @return string
     */
    public function afficher_date($date, $affichage = 'date')
    {
        $date_sans_time = explode(' ', $date);
        if ($affichage == 'date') {
            if ($date == '0000-00-00') {
                return '0000-00-00';
            } else {
                $datetimeformat = new DateTime($date_sans_time[0]);
                return $datetimeformat->format('d-m-Y');
            }
        } elseif ($affichage == 'dateheure') {
            $datetimeformat = new DateTime($date);
            return $datetimeformat->format('d-m-Y H:i');
        }
    }

    /**
     * Retourne une pagination (CSS Bootstrap)
     * 
     * @param string $table
     * @param int $page
     * @param int $par_page
     * @param array $where
     * @param string $operateur
     * @return string
     */
    public function pagination($total_records, $page, $par_page, $where = array(), $operateur = NULL, $section = "")
    {
        $pagination = "";
        $tri = "";
        $filtre = "";
        $recherche = "";
        $pagination .= "<span class='btn btn-sm btn-secondary'>" . $total_records . " résultat(s)</span>";
        if ($total_records <= $par_page) { } else {
            if (isset($_GET['filtre'])) {
                $filtre = "&filtre=" . $_GET['filtre'];
            }
            if (isset($_GET['select-recherche'])) {
                $recherche = "&select-recherche=" . htmlentities($_GET['select-recherche']);
            }
            if (isset($_GET['recherche'])) {
                $recherche .= "&recherche=" . htmlentities($_GET['recherche']);
            }
            if (isset($_GET['old_value'])) {
                $recherche .= "&old_value=" . htmlentities($_GET['old_value']);
            }
            if (isset($_GET['mode']) && isset($_GET['orderby'])) {
                $tri = $recherche . "&orderby=" . $_GET['orderby'] . "&mode=" . $_GET['mode'] . $filtre;
            } else {
                $tri = $filtre . $recherche;
            }
            $texte_page = "Pages";
            if (isset($_GET['page'])) {
                $texte_page = "Page n° " . htmlentities($_GET['page']);
            }
            $pagination .= '<a id="dropdownPagination" class="btn btn-sm btn-secondary dropdown-toggle" href="#tickets" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $texte_page . '</a>';

            $pagination .=   "<div class='dropdown-menu' aria-labelledby='dropdownPagination'>";
            $pagination .=   "<a href='" . $this->echoRedirect($section . $tri . '&page=all') . "' class='dropdown-item'>All</a>";
            $total_pages = ceil($total_records / $par_page);
            if ($total_records <= $par_page) {
                return '';
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                $pagination .=   "<a href='" . $this->echoRedirect($section . $tri . '&page=' . $i) . "' class='dropdown-item'>" . $i . "</a>";
            }
            $pagination .=   "</div>";
        }
        return $pagination;
    }

    public function searchOrderBy($colonne, $section)
    {
        $mode = "asc";
        $page = "";
        $filtre = "";
        $recherche = "";

        if (isset($_GET['mode'])) {
            if ($_GET['mode'] == "asc") {
                $mode = "desc";
            } else {
                $mode = "asc";
            }
        }

        if (isset($_GET['page'])) {
            $page = "&page=" . $_GET['page'];
        }

        if (isset($_GET['filtre'])) {
            $filtre = "&filtre=" . $_GET['filtre'];
        }

        if (isset($_GET['select-recherche'])) {
            $recherche = "&select-recherche=" . htmlentities($_GET['select-recherche']);
        }

        if (isset($_GET['recherche'])) {
            $recherche .= "&recherche=" . htmlentities($_GET['recherche']);
        }
        
        if (isset($_GET['old_value'])) {
            $recherche .= "&old_value=" . htmlentities($_GET['old_value']);
        }
        
        return $this->echoRedirect($section . $recherche . "&orderby=" . $colonne . "&mode=" . $mode . $page . $filtre);
    }
}
