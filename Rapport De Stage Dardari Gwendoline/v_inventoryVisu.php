<!-- Page title with an add button -->
//tout ce qui est en vert à était donner par la sncf (le bootsraps e=de la scncf) toutes les classes donc tout ce qui est css
<div class="bg-white ml-auto mr-auto rounded p-3 col-xl-3 col-lg-4 col-md-5 col-12 m-0 mt-2"> <!--sa permet d'avoir un fond déja fait avec bootsraps-->
    <h1 id="titre" class="text-center mb-0">Inventaire du local : <?= $storagePlace->getLabel() ?></h1>
</div>

<!-- Waiting spinner -->
<div class="d-flex justify-content-center mt-5" id="tabWait">  <!-- sa permet d'avoir une roue quand il y'a des choses à charger-->
    <div class="spinner-border text-primary" role="status" >
        <span class="sr-only">Loading...</span>
    </div>
</div>


<form method="POST" id="inventoryVisuForm" name="inventoryVisuForm" action="inventory.php"><!--sa permet d'avoir un formulaire qui envoie vers la page principale de l'inventaire en passant des informations-->
    <div class="ml-auto mr-auto rounded p-3 col-xl-10 col-lg-11 col-md-5 col-12 m-0 mt-2"> <!--mise en page déja faites-->
        <div class=" bg-white p-3" >   <!--permet d'avoir un fond plan et d'avoir une marge intérieur déja faite-->
            <h1 class="text-center mb-0" >Matériel déjà enregistré</h1>  <!--titre qui est mit au centre avec une marge en haut-->

            <br>
            <div class="customScroll"> <!-- quand il y'a trop d'lément dans le tableau sa permet d'avoir une barre pour scroller-->
                <table id="table" class="table table-bordered table-hover table-striped">
                    <thead class="thead-custom"> <!--c'est le css de l'entête. C'est le début de l'entête-->
                        <tr> <!-- permet de rester sur la même ligne -->
                            <th><div class="cell-inner text-xs">Code-Barres</div></th>
                            <th><div class="cell-inner text-xs">Libellé</div></th>
                            <th><div class="cell-inner text-xs">Taille</div></th>
                            <th><div class="cell-inner text-xs"><?= $csvData[0][3] ?></div></th>
                            <th><div class="cell-inner text-xs">Quantité</div></th>
                        </tr>
                    </thead> <!--fin de l'entête-->
                    <tbody> <!-- début du copr du tableau-->
                        <?php // ça introduit le PHP
                        // Affichage des info des produits déjà enregistrés
                        for ($i = 1; $i < count($csvData); $i++) { //dollars représenetent une variable, donc i va de 1 à nombre d'élément du tableau du csvdata(produit dans l'inventaire)
                            echo '<tr>
                                <td class="align-middle text-center" >' . $csvData[$i][0] . ' </td>
                                <td class="align-middle text-center" >' . $csvData[$i][1] . ' </td>
                                <td class="align-middle text-center" >' . $csvData[$i][2] . '</td>
                                <td class="align-middle text-center" >' . $csvData[$i][3] . '</td>
                                <td class="align-middle text-center">' . $csvData[$i][4] . '</td>
                              </tr>';
                              //on affiche les éléments du tableau csvdata dans notre tableau
                        }
                        ?> <!-- on ferme le php -->
                    </tbody><!-- on ferme le corp du teablea-->
                  </table><!-- on ferme le tavleau -->
            </div>
        </div>


        <div class="bg-white p-3" >
            <div class="row"> <!-- permet d'afficher en lignes les 2 boutons-->
                <div class="col-6 d-flex align-items-center flex-column bd-highlight mb-3">
                    <button type="button" id="poursuivre" name="poursuivre" class="btn btn-primary btn-sm" >Poursuivre la saisie</button>
                </div> <!-- bouton qui permet de retourner à l'écran d'enregistrement des produits-->
                <div class="col-6 d-flex align-items-center flex-column bd-highlight mb-3">
                    <button  id="erreurOuCloture" name="erreurOuCloture" value="<?= $btnValue; ?>" class="btn <?= $btnDanger ?> btn-sm " ><?= $erreurOuClotureBtn; ?></button>
                    <!-- c'est le bouton qui permet de gérer les erreurs si il y'en a soit de cloturer l'inventaire-->
                </div>
            </div>

        </div>

        <div id="storagePlaceId" hidden><?= $storagePlace->getId() ?></div> <!-- ce sont 2 éléments cachées, le 1er permet de récupurer l'id du lieu de stockage-->
        <input id="inventory" name="inventory" value="<?= $inventory->getId(); ?>" hidden /> <!--permet de récuperer l'i de l'inventaire-->


    </div>
</form>
