<?php
$pseudo = '';
$m_erreur = '';

if(isset($_POST['btsubmit']))
{
    if(isset($_POST['pseudo']) and isset($_POST['mot_de_passe']))
    {
        if(mb_strlen($_POST['pseudo']) >= 3 AND mb_strlen($_POST['pseudo']) <= 20)
        {
            $QUERY = 'SELECT COUNT(*) FROM membres WHERE pseudo = ?';
            $stmt = $pdo->prepare();
            $res = $stmt->execute($_POST['pseudo']);
            $nb_pseudos = $res->fetchColumn();

            if($nb_pseudos == 0)
            {
                if(ctype_alnum($_POST['pseudo']))
                {
                    if(mb_strlen($_POST['mot_de_passe']) >= 8 AND mb_strlen($_POST['mot_de_passe']) <= 20)
                    {
                        $bdd_pseudo = $_POST['pseudo'];
                        $bdd_mdp = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

                        $QUERY = 'INSERT INTO membres (id,pseudo,mdp) VALUES (?,?,?);';
                        $stmt = $pdo->prepare($QUERY);
                        $stmt->execute(['', $bdd_pseudo, $bdd_mdp]); // check if bcrypt is stored correctly
                        // header('Location: ');
                        print('ok');
                        exit();  
                    }
                    else
                    {
                        $m_erreur = 'Votre mot de passe doit faire entre 8 et 20 caractères.';
                    }
                }
                else
                {
                    $m_erreur = 'Votre pseudo contient des caractères non-alphanumériques.';
                }
            }
            else
            {
                $m_erreur = 'Votre pseudo existé déjà dans la base de données.';
            }
        }
        else
        {
            $m_erreur = 'Votre pseudo doit faire entre 3 et 20 caractères.';
        }
    }
    else
    {
        $m_erreur = 'Vous n\'avez pas spécifié votre pseudo ou votre mot de passe.';
    }
    $pseudo = $_POST['pseudo'];
    $mot_de_passe = $_POST['mot_de_passe'];
}
?>