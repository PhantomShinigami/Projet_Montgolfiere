let nb1 = "";
let nbstock = 0;
let operateur = "";
let chiffreappuyer = "";

function ajouter1() {
    nb1 += "1";
    console.log(nb1);
    document.getElementById("calcul").innerHTML = nb1;
}
function ajouter2() {
    nb1 += "2";
    console.log(nb1);
    document.getElementById("calcul").innerHTML = nb1;
}
function ajouter3() {
    nb1 += "3";
    console.log(nb1);
    document.getElementById("calcul").innerHTML = nb1;
}
function ajouter4() {
    nb1 += "4";
    console.log(nb1);
    document.getElementById("calcul").innerHTML = nb1;
}
function ajouter5() {
    nb1 += "5";
    console.log(nb1);
    document.getElementById("calcul").innerHTML = nb1;
}
function ajouter6() {
    nb1 += "6";
    console.log(nb1);
    document.getElementById("calcul").innerHTML = nb1;
}
function ajouter7() {
    nb1 += "7";
    console.log(nb1);
    document.getElementById("calcul").innerHTML = nb1;
}
function ajouter8() {
    nb1 += "8";
    console.log(nb1);
    document.getElementById("calcul").innerHTML = nb1;
}
function ajouter9() {
    nb1 += "9";
    console.log(nb1);
    document.getElementById("calcul").innerHTML = nb1;
}
function ajouter0() {
    nb1 += "0";
    console.log(nb1);
    document.getElementById("calcul").innerHTML = nb1;
}


function ajouterfois() {
    nbstock = parseInt(nb1);
    console.log(nbstock);
    nb1 = "";
    operateur = "*";
}
function plus()
{
    nbstock= parseInt(nb1);
    console.log(nbstock);
    nb1="";
    operateur="+";
}
function moins()
{
    nbstock=parseInt(nb1);
    console.log(nbstock);
    nb1="";
    operateur="-";
}
function diviser()
{
    nbstock=parseInt(nb1);
    console.log(nbstock);
    nb1="";
    operateur="/";
}
function egal() {
    switch (operateur) {
        case '*':
            resultat = nbstock * nb1;
            break;
        case '+':
            resultat = nbstock + parseInt(nb1);
            break
        case '-':
            resultat = nbstock - parseInt(nb1);
            break;
        case '/':
            resultat = nbstock / nb1;
            break;
    }
    document.getElementById("calcul").innerHTML = resultat;
}