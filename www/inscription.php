<?php
require_once('../includes/php/include_base.php');
require_once('../includes/php/include_inscription.php');

if(isset($_POST['btsubmit']) and isset($_SESSION['id']))
{
    $donnees_membre = select_member_data();
    $member_avatar = $donnees_membre['photo'];
    $member_hash_mdp = $donnees_membre['mdp'];

    $error_message_password = error_form_password();
    if($error_message_password === false)
    {
        $member_hash_mdp = password_hash($_POST['n_mot_de_passe'], PASSWORD_DEFAULT);
        $error_message_password = 'Le mot de passe a bien été modifié !';
    }

    $error_message_avatar = error_form_avatar();
    if($error_message_avatar  === false)
    {
        $member_avatar = 'avatars/./' . changebasename($_FILES['avatar']['name'], $_SESSION['pseudo']);

        move_uploaded_file($_FILES['avatar']['tmp_name'], $member_avatar);
        $error_message_avatar = 'L\'avatar a bien été modifié !';
    }
    
    $error_message = $error_message_password . 
    '<br />' . $error_message_avatar;

    update_photo_avatar($member_hash_mdp,  $member_avatar);
}

require_once('../includes/html/include_head.html');
require_once('../includes/html/include_header.html');
?>
<h1>Inscription</h1>
<h3 id="erreur"><?=$error_message?></h3>
<?php if ($show_form) { ?>
<form method="post" action="inscription.php#erreur" enctype="multipart/form-data">>
    <label for="pseudo">Pseudo :</label> <input type="text" name="pseudo" value="<?=$pseudo;?>"><br />
    <label for="mot_de_passe">Mot de passe :</label> <input type="password" name="mot_de_passe"><br />
    <label for="c_mot_de_passe">Confirmer le mot de passe :</label> <input type="password" name="c_mot_de_passe"><br />
    <label for="image">Choisir un avatar :</label> <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg" title="<?=$value?>"> <?=$value?><br />
    <input type="submit" name="btsubmit" value="Envoyer" />
</form>
<?php
}
require_once('../includes/html/include_footer.php');
?>