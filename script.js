function BarrerTexte(id)
{
  if(document.getElementById('termine' + id).checked) 
  {
    document.getElementById('titre_tache' + id).classList.add("barrer");
  } 
  else
  {
    document.getElementById('titre_tache' + id).classList.remove("barrer");
  }
}