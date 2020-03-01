<?php
try {
                $bdd = new PDO('mysql:host=sqletud.u-pem.fr;dbname=dmu01_db',"dmu01", "pU4aigey7m");
                $bdd->exec("SET CHARACTER SET utf8");
            } catch (Exception $e){
                die('Connexion failed, '.$e->getMessage());
            }?>
