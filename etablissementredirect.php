<?php
require_once("connexion.php");
$req = "SELECT * FROM Clic WHERE urlEtab =\"".$_POST['submit']."\"";
echo $req;
$sql = $bdd->query($req);
$data = $sql->fetch();
if (empty($data)){
	$newreq = "INSERT INTO `Clic` (`compteurEtab`, `nomEtab`, `urlEtab`) VALUES ('1', '".$_POST['nomEtab']."', '".$_POST['submit']."')";
	$bdd->query($newreq);
	echo "success";
}
else{
 $compteur = $data['compteurEtab']+1;
 $newreq = "UPDATE `Clic` SET `compteurEtab` = '".$compteur."' WHERE `Clic`.`urlEtab` = '".$_POST['submit']."'";
 $bdd->query($newreq);
 echo "success";

 
}
 header("Location: ".$_POST['submit']."");

?>