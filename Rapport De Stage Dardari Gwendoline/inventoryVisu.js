// Au clic pour afficher la gestion des erreurs
$("#erreurOuCloture").on("click", function () {  //au click du bouton du gestion des erreurs ou de cloture de l'inventaire sa lance la fcontion
    if ($("#erreurOuCloture").val() === "erreur") {  //si val est égale a erreur (le bouton et gestion des erreurs) alors on change l'action du formulaire pour la page des gestions des erreurs en précisant l'identifiant du lieu de stockage
        document.inventoryVisuForm.action = "inventoryErreurs.php?storagePlaceId=" + $('#storagePlaceId').text();
    } else {  // sinon on cloture l'inventaire donc on va sur la page d'acceuil de gestion des inventaires
        document.inventoryVisuForm.action = "inventory.php";
    }

});

// Au clic pour poursuivre l'inventaire
$("#poursuivre").on("click", function () {  //au clic sur le bouton pour poursuivre l'inventaire on retourne sur la page d'enregistrement de ;'inventairesen precisant l'indentifiant du lieu de stockage et en precisant que ce n'es pas un nouvel inventaires
    window.location.href = "../../controller/inventory/inventoryRecording.php?storagePlaceId=" + $('#storagePlaceId').text() + "&newInventory=false";
});
