<?php  //on rentre dans du php

include(dirname(__FILE__) . "/../../view/template/header.php");  //on inclut l'entête

// Si l'utilisateur à un profil actif (=1)
if ($_SESSION['userActive'] == 1) {
// Récupération des données POST du formulaire d'enregistrement des produits
    $postData = filter_input_array(INPUT_POST);

// Récupération des données GET dans l'URL
    $safeGet = filter_input_array(INPUT_GET);

// N'affiche pas de page si l'URL n'est pas complète
    if (!$safeGet)  //si safeget(recuperation des données dans l'url) est vide alors on affiche pas la page
        exit();

// Variable récupérée à partir de l'URL de la page
    $storagePlaceId = $safeGet["storagePlaceId"]; //on récupère les donées de get dans le storagePlaceId

    $type = $storagePlaceId === "1" ? "TMR" : "EPI"; // ID=1 correspond au lieu de stockage des TMRs
    //si storagePlaceId est égal à 1 alors il prendra la valeur "TMR" sinon il prendra la valeur "EPI"

    $storagePlace = dao\DaoFactory::getFactory()->getDAOStoragePlace()->findById($storagePlaceId);
    // Sa sert a aller cherche le lieu de stockage grace a son identifiant dans la base de donnée à l'aide d'une classe que nous avons développé(DaoFactory)

    $inventory = dao\DaoFactory::getFactory()->getDAOInventory()->findNotFinishedByStoragePlace($storagePlace); //Sa sert à aller chercher l'inventaire encore en cours grâce au lieu de stockage

    $csvData = [
        ["Code-barres", "Libellé", "Taille", ($type === "TMR" ? "Entrejambe" : "Packaging"), "Quantité"] //si type est égal a entre jambe alors on écrit entrejambe et si c'est pas egal alors on ecrit Packaging
    ];

// Au clic du bouton enregistrer sur la page d'enregistrement des produits
    if (!empty($postData["inventoryRecordingBtn"])) { //Si on a récu des infos du fromulaire de la page d'enregistrement des produits
        try {
// On boucle sur tous les produits enregistrés
            foreach ($postData as $key => $value) {  // pour tous les éléemnts du tableau postData on va prendre l'indice key et la valeur value
                $barcodeId = substr($key, 8); // Récupération de l'ID du champ. On récupère l'identifiant du code barre en supprimant les 8 premiers caractères de l'indice

                $barcode = dao\DaoFactory::getFactory()->{"getDAO" . $type . "Barcode"}()->findByBarcode($value);  // on récypère le code barre grâce a sa valeur dans la base de donée

// Si le code-barres existe
                if ($barcode) { // si on a trouver un barcode(on est bien dans une case du tableau postData ou il y'a un code barre)
                    $csvData[] = [  // on écrit le produit dans le tableau $csvData
                        $barcode->getBarcode(),
                        $barcode->getProduit()->getLabel(),
                        $barcode->getSize()->getValue(),
                        ($type === "TMR" ? ($barcode->getCrotch() !== NULL ? $barcode->getCrotch()->getValue() : "-") : $barcode->getProduit()->getPackaging()->getLabel()), // si type est egal a TMR alors on regarde si il y'a une taille d'entre jambe et si c'est le cas on prend sa valeur sinon on met un tirer et si ce n'es pas un tmr on prend le Packaging
                        $postData["quantity_" . $barcodeId] // on récupère la quantitée du formulaire
                    ];
                }
            }

// Réécriture du fichier CSV avec les nouveaux produits enregistrés
            writeInCsvFile($inventory->getCsvFile(), $csvData); // c'est une fonction qui va écire dans un fichier csv

            echo new commun\Alert('L\'inventaire a été enregistré avec succès<br/>', 'success'); // On affiche ue alarte poru dire que l'inventaire est enregistrer avec succès
        } catch (model\AgentException $exc) {  // on regarde si il y'a eut une Exception
            echo new commun\Alert($exc->getMessage(), 'error'); //et si c'est le cas on envoie un message d'erreur
        }
    }
// Au clic du bouton annuler sur la page de gestion des erreurs
    if ((!empty($postData["annuler"]))) { // si on a recuperer des infos du formulaire de la gestion des erreurs en annulant les Modification
        $ancien = [];
        $csvData = readCsvFile($inventory->getCsvFile(), $ancien); //on récupère les produits en lisant le fichier csv
    }
// Au clic du bouton enregistrer sur la page de gestion des erreurs
    else if (!empty($postData["reference_1"])) { // sinon si on a recuperer une reference sa veut dire qu'on a valider les modifications
        try {  // on essaye
            $i = 1;
            $tab = [];
            //On récupère les produits de la gestion des erreurs
            foreach ($postData as $key => $value) {// Récupération de l'ID du champ. POur toutes les donées du formulaire avec key l'indice et valeur value
                $barcode = dao\DaoFactory::getFactory()->{"getDAO" . $type . "Barcode"}()->findByBarcode($value); //on récupère le code barre avec la valeur

// Si le code-barres existe
                if ($barcode) {
                    $barcodeId = $barcode->getId(); //on récupere l'identifiant du code barre

// si on garde la quantitée scannée
                    if ($postData["customRadio_" . $i] === "1") {

                        $quantity = $postData["quantityScan_" . $i]; //alors on recupre la quantite scanne

                        $stockproduit = dao\DaoFactory::getFactory()->{"getDAO" . $type . "Stock"}()->findByBarAndStp($barcodeId, $storagePlaceId); //on recupere le stock acutelle du produit grace a l'identifiant du code barre et grace a celui du lieu de stockage

                        if ($stockproduit != null) { //si on a trouver  trouver un stock de ce produit la
                            $stockproduit->setQuantity($postData["quantityScan_" . $i]); // on modifie la quaité dans le stock
                            dao\DaoFactory::getFactory()->{"getDAO" . $type . "Stock"}()->update($stockproduit); // on met le stock a jour dans la base de donnée
                        } else { //si on a rien trouver
                            $stockproduit = ($type === "TMR" ? new model\TMRStock($barcode, $storagePlace, $quantity) : new model\EPIStock($barcode, $storagePlace, $quantity) );// on crée le stock du produit
                            dao\DaoFactory::getFactory()->{"getDAO" . $type . "Stock"}()->create($stockproduit); //  et on l'ajoute a la base de donnée
                        }
                    } else { //si on veut garder la quantite en stock
                        $quantity = $postData["quantityStock_" . $i]; // on garde la quantité en stock
                    }

                    // On rentre le produit dans le tableau
                    if ($quantity != 0) { // si la quantite est differente 0
                        $csvData[] = [ //on rentre le produit dans le tableau $csvData
                            $barcode->getBarcode(),
                            $barcode->getProduit()->getLabel(),
                            $barcode->getSize()->getValue(),
                            ($type === "TMR" ? ($barcode->getCrotch() !== NULL ? $barcode->getCrotch()->getValue() : "-") : $barcode->getProduit()->getPackaging()->getLabel()),
                            $quantity
                        ];
                    }
                    $tab[] = $barcode->getBarcode(); // c'est un tableau auxiliaire ou l'on met les codes barres qu'on a deja rentrer
                    $i++;
                }
            }
            //On récupère les anciens produits qui n'avaient pas d'erreur
            $ancien = [];
            $ancien = readCsvFile($inventory->getCsvFile(), $ancien); // en lisant le fichier csv

            for ($j = 1; $j < count($ancien); $j++)    // on parcours ces produits en les ajoutant au tableau csvData si ils ne sont pas dans le tableau tab des codes barres deja rentrer
                if (!in_array($ancien[$j][0], $tab)) {
                    $csvData[] = [
                        $ancien[$j][0],
                        $ancien[$j][1],
                        $ancien[$j][2],
                        $ancien[$j][3],
                        $ancien[$j][4]
                    ];
                }
            }

// Réécriture du fichier CSV avec les nouveaux produits enregistrés
            writeInCsvFile($inventory->getCsvFile(), $csvData);

            echo new commun\Alert('L\'inventaire a été enregistré avec succès<br/>', 'success'); // on met l'larte que c'est bien enregsitrer
        } catch (model\AgentException $exc) { // si il y'a une erreur on affcihe un message d'erreur
            echo new commun\Alert($exc->getMessage(), 'error');
        }
    }

    //Modification du bouton de cloture / gestion des erreurs
    if (existErreur($csvData, $storagePlaceId, $type)) { // si il ya des erreur entre l'inventaire et le stock
        $erreurOuClotureBtn = "Gestion des erreurs"; // l'intitulé du bouton devient gestion  des erreurs
        $btnValue = "erreur"; // la veleur du bouton devient erreur
        $btnDanger = "btn-danger"; // la classe du bouton devient btn danger pour qu'il soit rouge
    } else { // si il n'y a pas d'erreur on peut donc cloturer l'inventaire
        $erreurOuClotureBtn = "Clôturer l'inventaire"; //l'intitulé du bouton devient cloture de l'inventaire
        $btnValue = "cloture"; // La vleur du bouton devient cloture
        $btnDanger = "btn-primary"; // La classe du bouton devient btn primary pour que ce soit un bouton bleu
    }

    include(dirname(__FILE__) . '/../../view/inventory/v_inventoryVisu.php'); // on inclue le fichier de vue (html)
} else { // si on a pas les droits on affiche une page disant qu'on a pas l'accès
    header('Location:/view/template/accesKO.php');
}

require(dirname(__FILE__) . "/../../view/template/footer.php"); // on inclue le footer(le bas de page)

// Fonction d'écriture dans le fichier CSV de nom "$filename" et avec les données "$csvData"
function writeInCsvFile($filename, $csvData) {
    try {
        $file = fopen(dirname(__FILE__) . "/../../fichiers_csv_inventaires/" . $filename, 'w'); //on ouvre le fichier csv

        if (!$file) { // si il n'existe pas on lance une exception
            throw new Exception('Erreur dans l\'ouverture du fichier CSV ' . dirname(__FILE__) . "/../../fichiers_csv_inventaires/" . $filename); // sa c'est l'exception
        }

        foreach ($csvData as $row) { // on parcours le tableau des choses à écrire dans le fichier csv
            fputcsv($file, array_map("utf8_decode", $row)); // c'est une fonction php qui ecrit automatiquement dans le fichier csv
        }
    } catch (\Throwable $e) { // on prend une exception
        echo $e->getMessage(); // on affcihe le message d'erreur
    } finally { // et a la fin on ferme le fichier csv
        if (!$file)
            fclose($file);
    }
}

//Fonction qui test si il existe au moins une erreur entre les produits scanné (tableau $csvData) et le stock actuellement enregistré dans le lieu de stockage $storagePlaceId pour le type de produit $type
function existErreur($csvData, $storagePlaceId, $type) {

    $tab = [];
    for ($i = 1; $i < count($csvData); $i++) { // on parcours tous le tableau des produits scannee
        $barcode = dao\DaoFactory::getFactory()->{"getDAO" . $type . "Barcode"}()->findByBarcode($csvData[$i][0]); // on récupère le code barre avec l'identifiant du taleau
        $stock = dao\DaoFactory::getFactory()->{"getDAO" . $type . "Stock"}()->findByBarAndStp($barcode->getId(), $storagePlaceId); // on récupère la ligne de stock qui correspond

        if ($stock == Null) { // si il n'y a pas de stock alors il y'a une erreur et on retourne vrai
            return true;
        } else if ($stock->getQuantity() != $csvData[$i][4]) { // sinon si la quantité en stock est différente de la quantité sacnnée il y'a une erreur et on retourne vrai
            return true;
        }

        $tab [] = $csvData[$i][0]; // on stock le code barre dans un tableau auxiliaire
    }

    $stocks = dao\DaoFactory::getFactory()->{"getDAO" . $type . "Stock"}()->findAllByStoragePlace($storagePlaceId); // on récupère tous les stock du liue de stockage

    for ($i = 0; $i < count($stocks); $i++) { // on parcrous tous les stocks
        if (!in_array($stocks[$i]->getBarcode()->getBarcode(), $tab) && ($stocks[$i]->getQuantity() != 0)) { // si il y'a une ligne de stock qui n'est pas dans le taleau auxiliaire il ya une erreur on retourne vrai
            return true;
        }
    }

    return false; // il n'y a pos eut d'erreur on retourne faux
}

// Fonction de lecture du fichier CSV de nom "$filename" et avec les données "$csvData"
function readCsvFile($filename, $csvData) {
    try {
        $file = fopen(dirname(__FILE__) . "/../../fichiers_csv_inventaires/" . $filename, 'r'); // on l'ouvre

        while ($row = fgetcsv($file)) // tant qu'on peut lire le fichier csv grace a la fonction fgetcsv
            $csvData[] = array_map("utf8_encode", $row); // on écrit la ligne du fichier csv dans le tableau csvData

        return $csvData; // on retourne le tableau
    } catch (\Throwable $e) { // on prend l"erreur et on affcihe le message d'erreur
        echo $e->getMessage();
    } finally { // a la fin on ferme le fichier
        if (!$file)
            fclose($file);
    }
}
