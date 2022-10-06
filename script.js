function cocheDecoche(nb) {
    let checkbox = document.querySelector("#titre_tache" + nb.toString());
    let classes = checkbox.classList;
    classes.toggle("barrer");
}