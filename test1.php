<!DOCTYPE html>
<html>
	<head>
		<title>Esercizio 1</title>
                <link href="nuovo.css" rel="stylesheet" type="text/css" media="screen" />
	</head>
	<body>
		<h2>Eserzicio 1 - PHP</h2>
		<h4>Form che esegue le quattro operazioni elementari</h4>
		<?php		  	
                    
                    if(isset($_REQUEST["a"]) && isset($_REQUEST["b"])){
                        $a = filter_var($_REQUEST["a"], FILTER_VALIDATE_INT);
		  	$b = filter_var($_REQUEST["b"], FILTER_VALIDATE_INT);
		  	$op= $_REQUEST["operatore"];
                    }
                    else {
                        $a="";
                        $b="";
                        $op='+';
                    }
		  	
                    if($op !='+' && $op !='-' && $op !='*' && $op !='/'){
		  	$op='+';
                    }
		  	
                    if ($a && $b){
                        switch ($op) {
                                case "+": $ris=$a+$b; break;
                                case "-": $ris=$a-$b; break;
                                case "*": $ris=$a*$b; break;
                                case "/": $ris=$a/$b; break;
                        }
                    }
		?>	
		  
	  <form	 method="post" action="test1.php">	
	  	<p>
		  	<label for="a">A</label>	
		  	<input type="text" name="a" id="a" value="<?= $a ?>"/>
		  	<select name="operatore">
		  		<option value="+" <?= $op == "+" ?  'selected="true"' : "" ?> >Addizione</option>
		  		<option value="-" <?= $op == "-" ?  'selected="true"' : "" ?> >Sottrazione</option>
		  		<option value="*" <?= $op == "*" ?  'selected="true"' : "" ?> >Moltiplicazione</option>
		  		<option value="/" <?= $op == "/" ?  'selected="true"' : "" ?> >Divisione</option>
		  	</select>
		  	<label for="b">B</label>	
		 	<input type="text" name="b" id="b" value="<?= $b ?>"/>	
		  	<input type="submit" value="Calcola"/>	
	  	</p>
	  </form>	
	  
	  <p>
	  	<? 
		  	if(isset($ris)){
		  		echo "$a $op $b = $ris";
		  	}
		?> 
	  </p>	
	</body>
</html>  	
  	
  
  
  
