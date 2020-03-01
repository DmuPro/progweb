
<?php require_once('connexion.php');
$req = "Select * FROM Clic WHERE `nomEtab` ='Université Paris Descartes'";
$sql = $bdd->query($req);
$data = $sql->fetch();
	if (empty($data)){
		echo 'lol';
	}
echo $req;?>  
<p><a onclick = "popup('a','b','c')" href = "#">a</a></p>

<script>
function popup(a,b,c) {
  w=open("",'popup','width=400,height=200,toolbar=no,scrollbars=no,resizable=yes');	
  w.document.write("<body><p>Nom établissement:"+a+"</p>");
  w.document.write("Ce popup n'est pas un fichier HTML, "+b);
  w.document.write("il est écrit directement par la fenêtre appelante"+c);
  w.document.write("<p><input type = 'submit' value = '"+c+"'></p>");
  w.document.write("</body>");
  w.document.close();
}</script>
