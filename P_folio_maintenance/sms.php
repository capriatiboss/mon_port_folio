<?php 
session_start();
try{
    $connexion=new PDO("mysql:host=localhost;dbname=comments_gestion;charset=utf8",'root','');

    $connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['mail'])){
         $sql="SELECT * FROM users WHERE mail=:mail";
         $query= $connexion->prepare($sql);
         $query->execute([
             'mail'=>$_POST['mail']
         ]);
         $donne=$query->fetch();
         if($donne===false){
             header("location=index.php?pg=home");
             exit();
         }
         $_SESSION['donne']=$donne;
         if($_POST['pass']!=$donne['pass']){
             header("location:index.php?pg=cont");
             session_destroy();
             exit();
         }        
    }//verifier si les donnees de l'utilisateur sont bien presents
    if(!isset($_SESSION['donne'])){
        header("location:contact.html");
        exit();
    }
    
}catch(Exception $e){
    echo "Erreur SQL : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style_folder/style.css">
     <link rel="stylesheet" href="style_commentaire.css">
</head>
<body>
    <div class="fond_arriere"><div class="f_av"></div></div>
    <div class="logo_containner"><img src="image/logo-red.png" alt="" width="50%"></div>
         <header>
             <nav class="nav_bar">
                <ul class="nav_link">
                    <li class="liste"><a href="" target="_blank">Commentaires</a></li>
                    <li class="liste"><a href="espace.php" target="_blank">Vos commentaires</a></li>
                </ul>   
             </nav>
         </header>
         <main id="main_commentaire">
            <div></div>
            <h2>Commentaires disponibles</h2>
            <?php 
                $sql="SELECT COUNT(*)FROM comments";
                $nbr_lignes=$connexion->query($sql)->fetchColumn();

                $query =$connexion->query("SELECT u.nameUser AS nom ,c.contents 
                FROM comments AS c 
                INNER JOIN  users AS u
                ON userId =comments_users"); 
                $row =$query->fetchAll(PDO::FETCH_ASSOC);
                //echo "<pre>";
                //print_r($row); 
                //echo"</pre>";
            ?>

            <?php for($i=0;$i<$nbr_lignes;$i++):?>
                <div class="div_comments">
                    <?php echo $row[$i]['contents'];?> <span>par <?php echo $row[$i]['nom']; ?> </span>
                </div>
                <br><br>
            <?php endfor?>

         </main>
</body>
</html>