//Ceci est a colle au debut de creation 
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
            header("location:msm.php");
            }else{
                echo 'Un compte a deja été crée via ce mail';
            }

        }catch(Exception $e){
            die("Connexion echoué ".$e->getMessage());
        }
    }else{
        die("Tous les champs doivent etre remplis");
    }   
}
?>