<?php
//Falta verificar se o user existe
//Identificar e fornecer creds da DB e prevenir mais que uma query numa linha
try{
$db = new PDO('mysql:host=localhost;dbname=Exercicio8', 'root', 'academia',[PDO::MYSQL_ATTR_MULTI_STATEMENTS => false] );
}catch(PDOException $e){
die("Connection Error: No database in host or creds are wrong");
}
//Create the command
$sql="Select ID,Nome,email,morada,telefone,nascimento from alunos";
$sql2=$db->prepare($sql);
$sql2->execute();
$sql2->setFetchMode(PDO::FETCH_NUM);
//Check if there is no users
$count = $sql2->rowCount();
//output data of each row
if($count!=0){
while($row=$sql2->fetch()){	
	echo "id: ".$row[0]." - Nome: ".$row[1]." - email: ".$row[2]." - morada: ".$row[3]." - telefone: ".$row[4]." - Data de Nascimento: ".$row[5]."<br>";
}
}else{
echo "0 results found";
}
$db = null;
?>
