<?php
function genererListe($nomTable, $prefixe)
{
    $chaine = file_get_contents("../generateur/gene_list.php");
    $chaine = str_replace("[table]", $nomTable, $chaine);
    $chaine = str_replace("[prefixe]", $prefixe, $chaine);
    $chaine = str_replace("[ListeChampsTH]", getListeChampsTH($nomTable), $chaine);
    $chaine = str_replace("[ListeValeursTD]", getListeValeursTD($nomTable), $chaine);
    file_put_contents("../www/" . $nomTable . "_list.php", $chaine);
    return $nomTable . "_list.php a été généré.<br>";
}

function genererDelete($nomTable, $prefixe)
{
    $chaine = file_get_contents("../generateur/gene_delete.php");
    $chaine = str_replace("[table]", $nomTable, $chaine);
    $chaine = str_replace("[prefixe]", $prefixe, $chaine);
    file_put_contents("../www/" . $nomTable . "_delete.php", $chaine);
    return $nomTable . "_delete.php a été généré.<br>";
}

function genererUpdate($nomTable, $prefixe)
{
    $chaine = file_get_contents("../generateur/gene_edit.php");
    $chaine = str_replace("[table]", $nomTable, $chaine);
    $chaine = str_replace("[prefixe]", $prefixe, $chaine);
    $chaine = str_replace("[listeChamps]", "(". implode(",",getListeChamps($nomTable)) . ")", $chaine);
    $chaine = str_replace("[listeValeurs]", getListeValeurs($nomTable), $chaine);
    $chaine = str_replace("[listeChampsaVide]", getListeChampsaVide($nomTable), $chaine);
    $chaine = str_replace("[listeChampsValeurs]", getListeChampsValeurs($nomTable), $chaine);
    $chaine = str_replace("[listeChampsInput]", getlisteChampsInput($nomTable), $chaine);
    file_put_contents("../www/" . $nomTable . "_edit.php", $chaine);
    return $nomTable . "_edit.php a été généré.<br>";
}

function genererAllListe($lp)
{
    global $link;
    $sql = "show tables";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result);
    $message = "";
    foreach ($data as $valeur)
        $message .= genererListe($valeur[0], substr($valeur[0], 0, $lp));

    return $message;
}

function genererAllUpdate($lp)
{
    global $link;
    $sql = "show tables";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result);
    $message = "";
    foreach ($data as $valeur)
        $message .= genererUpdate($valeur[0], substr($valeur[0], 0, $lp));

    return $message;
}

function genererAllDelete($lp)
{
    global $link;
    $sql = "show tables";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result);
    $message = "";
    foreach ($data as $valeur)
        $message .= genererDelete($valeur[0], substr($valeur[0], 0, $lp));

    return $message;
}

//return array nom des champs de $nomtable
function getListeChamps($nomtable)
{
    global $link;
    $sql = "show columns from $nomtable";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result);
    $tab = [];
    foreach ($data as $valeur)
        $tab[] = $valeur[0];

    return $tab;
}

function getListeChampsTH($nomtable)
{
    $tab=[];
    $data = getListeChamps($nomtable);
    foreach ($data as $valeur)
        $tab[] = "<th>$valeur</th>\n";

    return implode("", $tab);
}

function getListeValeursTD($nomtable)
{
    $tab=[];
    $data = getListeChamps($nomtable);
    foreach ($data as $valeur)
        $tab[] = "<td><?=$$valeur?></td>\n";

    return implode("", $tab);
}

//return string pour requete insert
function getListeValeurs($nomtable)
{
    $tab=[];
    $data = getListeChamps($nomtable);
    foreach ($data as $valeur)
        $tab[] = "'" . '$' . $valeur . "'";

    $tab[0] = "null";
    $chaine = "(" . implode(",", $tab) . ")";

    return $chaine;
}

//return string pour requete update
function getListeChampsValeurs($nomtable)
{
    $data = getListeChamps($nomtable);
    $tab = [];
    foreach ($data as $valeur)
        $tab[] = $valeur . "=" . "'" . '$' . $valeur . "'";

    unset($tab[0]);
    $chaine = implode(",", $tab);

    return $chaine;
}

//return string pour init formulaire 
function getListeChampsaVide($nomtable)
{
    $data = getListeChamps($nomtable);
    $tab = [];
    foreach ($data as $valeur)
        $tab[] = '$' .  $valeur . "=" . "''";

    unset($tab[0]);
    $chaine = implode(";", $tab) . ";";

    return $chaine;
}

//return string pour load formulaire
function getlisteChampsInput($nomtable)
{
    $data = getListeChamps($nomtable);
    $chaine = "";
    foreach ($data as $i => $valeur) {
        if ($i > 0) {
            $chaine .= "<p>\n";
            $chaine .= "<label for='$valeur'>$valeur</label>\n";
            $chaine .= "<input type='text' name='$valeur' id='$valeur' value='<?= $$valeur ?>'>\n";
            $chaine .= "</p>\n\n";
        }
    }

    return $chaine;
}

function generateur($lp)
{
    $message = "";
    $message .= genererAllListe($lp);
    $message .= genererAllDelete($lp);
    $message .= genererAllUpdate($lp);

    return $message;
}

function getMenu()
{
    global $link;
    $sql = "show tables";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_all($result);
    $chaine = "";
    foreach ($data as $valeur) {
        $chaine .= "<li><a href='{$valeur[0]}_list.php'>{$valeur[0]}</a></li>";
    }
    return $chaine;
}

//affiche la liste des bases de données sous forme de liste déroulante
function HTML_SELECT_Databases($selDbname)
{
    global $link;
    $db = getDatabases($link);
    foreach ($db as $nom) {
        $sel = ($nom == $selDbname ? " selected " : "");
        echo "<option $sel>$nom</option>";
    }
}

//Retourne la liste des bases de données (non système) du serveur mysql
function getDatabases(): array
{
    global $link;
    $exclure = ["information_schema", "mysql", "performance_schema", "sys"];
    $db = [];
    $result = mysqli_query($link, "show databases;");
    while ($row = $result->fetch_assoc())
        if (!in_array($row["Database"], $exclure))
            $db[] = $row["Database"];

    return $db;
}
