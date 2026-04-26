
<?php
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['nameUser'])  && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['tel']) && !empty($_POST['nameUser']) && !empty($_POST['pass']) && !empty($_POST['tel'])){ 
        try{
            $connexion = new PDO("mysql:host=localhost;dbname=comments_gestion;charset=utf8",'root','');
            $connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $sql ="SELECT mail FROM users WHERE mail=:mail";
            $query= $connexion->prepare($sql);
            $query->execute(['mail'=>$_POST['mail']]);

            if($query->fetch()===false){
                $sql="INSERT INTO users(nameUser,mail,pass,tel) VALUES(?,?,?,?)";
                $query= $connexion->prepare($sql);
                $query->execute([
                   $_POST['nameUser'],
                   $_POST['mail'],
                   $_POST['pass'],
                   $_POST['tel']
                ]);
                
            echo "<script>console.log('marche')</script>";
            header("location:contact.html");
            exit();

            }else{    
                $erreur="Cet adresse email a ete deja associé a un compte";          
            }


        }catch(Exception $e){
            die("Connexion echoué ".$e->getMessage());
        }
    }else{
        die("Tous les champs doivent etre remplis");
    }   
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="style_creation.css">
</head>
<body>
    <section>
        <?php if(isset($erreur)):?>     
        <h2>Adresse email deja utilisé</h2>
        <?php else: ?>
        <h2>Veillez remplir les champs suivants</h2>
        <?php endif; ?>
        <form action="#" method="post">
            <div>
                <label for="nom">Entrez votre nom et prenom</label>
                <input type="text" name="nameUser" id="nom" required>
            </div>
            <div>
                <label for="mail">Veillez entrer votre adresse email</label>
                <input type="email" required name="mail" id="tel">
            </div>
            <div>
                <label for="pass">Veillez entrer Votre mot de passe </label>
                <input type="password" required name="pass" id="tel">
            </div>
            <div  >
                <label for="tel">Veillez entrer votre numéro de téléphone</label>
                <input type="tel" name="tel" id="tel">
            </div>
            <div id="div_submit" >
                <input type="submit" value="Créer" id="createBouton" required>
            </div>
        </form>
    </section>
</body>
</html>