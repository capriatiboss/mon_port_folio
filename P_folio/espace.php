<?php
session_start();
try{
$connexion=new PDO("mysql:host=localhost;dbname=comments_gestion;charset=utf8",'root','');
$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
die("Erreur ".$e->getMessage());
}

//echo $_SERVER['REQUEST_METHOD'];
//echo $_SESSION['donne']['userId'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['new_comments'])&& !empty(trim($_POST['new_comments']))){
         $query = $connexion->prepare("INSERT INTO comments(contents,comments_users) VALUES(?, ?)");
         $query->execute([
            $_POST['new_comments'],
            $_SESSION['donne']['userId']  
         ]);
        echo"<script>alert('ok')</script>";
        header("location:espace.php");
        exit();
    }
}
//pour la modification 
if(isset($_POST['com_id'])&& isset($_POST['texte_modifie'])&& !empty($_POST['com_id'] && $_POST['texte_modifie'])){
    $query = $connexion->prepare("UPDATE comments SET contents =:contents WHERE comments_id=:comments_id");
    $query-> execute([
        'contents'=>$_POST['texte_modifie'],
        'comments_id'=>$_POST['com_id']
    ]);
    echo "<script>alert('ok')</script>";

    header("location:espace.php");
    exit();
}
//pour la suppression
if(isset($_POST['suppOui'])&&!empty($_POST['suppOui']) && isset($_POST['com_id']) && !empty($_POST['com_id'])){
    $query = $connexion ->prepare("DELETE FROM comments WHERE comments_id =? LIMIT 1");
    $query-> execute([$_POST['com_id']]);
    echo "<script>alert('ok pour la suppression')</script>";   
    header("location:espace.php");
    exit();
}
if(isset($_POST['dcnx'])&& !empty($_POST['dcnx'])){
  session_destroy();
  header("location:contact.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style_folder/style.css">
    <link rel="stylesheet" href="style_folder/style_espace.css">
</head>
<body>
        <div class="fond_arriere"><div class="f_av"></div></div>
        <div class="logo_containner"><img src="image/logo-red.png" alt="" width="50%"></div>
         <header>
             <nav class="nav_bar">
                <ul class="nav_link">
                    <li class="liste"><a href="sms.php" target="_blank">Commentaires</a></li>
                    <li class="liste"><a href="espace.php" target="_blank">Vos commentaires</a></li>
                </ul>   
             </nav>
         </header>
         <main>
            <section>
                <h1> Bienvenue <?php echo $_SESSION['donne']['nameUser'];?></h1>
                <div id="div_1">
                    <h2>Vos commentaires :</h2>
                    <?php 
                        $query=$connexion->prepare("SELECT * FROM comments WHERE comments_users =?");
                        $query->execute([$_SESSION['donne']['userId']]);
                        $my_comments=$query->fetchAll();
                        
                        //print_r($my_comments);
                        for($i=0;$i<count($my_comments);$i++):?>
                        <div id="div_2">
                         <?php echo htmlspecialchars($my_comments[$i]['contents']); ?>
                          <button class="update" data-msg="<?php echo htmlspecialchars($my_comments[$i]['contents'])?>" data-cmt_id="<?php echo htmlspecialchars($my_comments[$i]['comments_id'])?>">Modifier</button>
                          <button class="delete" data-cmt_id="<?php echo htmlspecialchars($my_comments[$i]['comments_id'])?>">Supprimer</button>
                        </div>
                       <?php endfor?> 
                </div>
                <div id="div_dialogue">
                    <dialog id="dialogue">
                       <form action="" method="post">
                             <input type="hidden" name="com_id" id="com_id">
                             <textarea name="texte_modifie" id="texte_modifie"></textarea>
                             <input type="submit" value="Modifier" id="conf_modif">
                             <button id="btn_anl">Annuler</button>
                       </form>
                    </dialog>
                    <dialog id="dialogue_sup">
                        <p>Desirez vous supprimer ce commentaire?</p>
                        <form action="" method="post">
                            <input type="hidden" name="com_id" id="com_id_sup">
                            <button value="oui" id="suppOui" name="suppOui" type="submit">Oui</button>
                            <button type="button" onclick="dialogue_sup.close()" id="suppNon">Non</button>
                        </form>
    
                    </dialog>
                </div>    
                    <script>
                        let boutons_modif= document.querySelectorAll(".update");
                        //Champs du dialogue
                        const dialogue =document.getElementById("dialogue"); 
                        const dialogue_sup = document.getElementById("dialogue_sup"); 
                        //Pour le dialogue de modification
                        let id_com = document.getElementById("com_id");    
                        let texte_modifie = document.getElementById("texte_modifie");

                        //Pour le dialogue de suppression
                        let com_id_sup = document.getElementById("com_id_sup");


                        boutons_modif.forEach((mod_btn)=>{
                            mod_btn.addEventListener("click",()=>{
                                dialogue.showModal();
                                id_com.value= mod_btn.getAttribute("data-cmt_id");
                                texte_modifie.value =mod_btn.getAttribute("data-msg");
                            });
                        });
                        
                        let boutons_sup=document.querySelectorAll(".delete");
                        boutons_sup.forEach((sup_btn)=>{
                            sup_btn.addEventListener("click",()=>{
                                dialogue_sup.showModal();
                                com_id_sup.value= sup_btn.getAttribute("data-cmt_id");
                            });
                        }) 
                    </script>
                <div id="div_comments">
                    <form action="" method="post" >
                       <label for="comments_add">Désirez vous ajouter un nouveau commentaire ?</label>
                       <textarea name="new_comments" id="new_com" required ></textarea>
                       <button type="submit"id="btn_env" disabled>Envoyez</button> 
                    </form>    
                </div>

            </section>
         </main>
         <script>
                  var champ = document.getElementById("new_com");
                  var btn_env = document.getElementById('btn_env');
                  champ.addEventListener("input",()=>{
                    if(champ.validity.valueMissing){

                        btn_env.disabled=true;
                    }else{
                        btn_env.disabled=false;
                    }
                  }); 
        </script>
        <?php include( __DIR__."/footer.inc.php") ?>
</body>
</html>