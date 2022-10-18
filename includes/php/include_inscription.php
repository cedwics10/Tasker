<?php
$pseudo = '';
$m_erreur = '';

if(isset($_POST['btsubmit']))
{
    if(mb_strlen($_POST['pseudo']) >= 3 AND mb_strlen($_POST['pseudo']) <= 20)
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
        $m_erreur = 'Votre pseudo doit faire entre 3 et 20 caractères.';
    }

    $pseudo = $_POST['pseudo'];
    $mot_de_passe = $_POST['mot_de_passe'];
}
?>