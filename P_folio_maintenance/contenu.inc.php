<?php
if(isset($_GET['pg'])){
    switch($_GET['pg']){
        case "home":
            include(__DIR__."/onglet1/accueil.inc.html");
            break;
        case "about":
            include(__DIR__."/onglet1/about.inc.html");
            break;
        case "proj":
            include(__DIR__."/onglet1/projet.inc.html");        
            break;
        case "cont":
            include(__DIR__."/onglet1/contact.inc.html");
            
            break;
        case "comp":
            include(__DIR__."/onglet1/competence.inc.html");
            break;
        default:
        include(__DIR__."/onglet1/accueil.inc.html");            
    }
}else{
    include(__DIR__."/onglet1/accueil.inc.html");
}
?>