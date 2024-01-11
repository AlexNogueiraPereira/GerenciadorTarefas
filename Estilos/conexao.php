<?php
function conexao($server,$username,$senha,$dbname) {
	global $link;
  	$link=mysqli_connect($server,$username,$senha,$dbname);
}

conexao("localhost","root","","bd_gerenciador");
?>