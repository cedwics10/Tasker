<?php
if(isset($_POST['btsubmit']))
{
    if(isset($_POST['pseudo']) and isset($_POST['mot_de_passe']) and isset($_POST['c_mot_de_passe']))
    {
        if(mb_strlen($_POST['pseudo']) >= 3 AND mb_strlen($_POST['pseudo']) <= 20)
        {
            $QUERY = 'SELECT mdp FROM membres WHERE pseudo = ?';
            $stmt = $pdo->prepare($QUERY);
            $stmt->execute([$_POST['pseudo']]);
            $nb_pseudos = $stmt->rowCount();

            if($nb_pseudos == 0)
            {
                $donnees_compte = $stmt->fetchColumn();

                if($nb_pseudos == 0)
                {
                    
                }
                else
                {
                    $m_erreur = '';
                }
            }
            else
            {
                $m_erreur = 'Le pseudo n\'existe pas.';
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