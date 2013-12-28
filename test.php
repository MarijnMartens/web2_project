<?php
    /*@*/ require_once ('db_data.php');
    $connectionString=DB::getConnectionString();

    try{
        $pdo=new PDO($connectionString, DB::USERNAME, DB::PASSWORD);
        $pdo-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //PREPARED SELECT STATEMENT - VOORKEURSMETHODE TEGEN SQL INJECTION !!
        
        $sql = "SELECT username, email FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $naam = 'maarten'; //bestaat niet, geeft niets weer
        $stmt->bindParam(1, $naam, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach($result as $row)
        {
            print $row['username'] . '-' . $row['email'] . '<br/>';
        }
        
        //Alternatief op foreach als we willen controleren of er juist 1 antwoord is of 0.
	/*
	if($result !== false){
		echo "<p>Ingelogd als ". $result['naam']. ' ' . $result['voornaam'].  "</p>";
	 } else{
		echo "<p>Login gefaald</p>";
	}
         */
        //EINDE PREPARED SELECT STATEMENT
        
        
        //Klassieke select, display als onkneedbare list
        /*
        $query = 'SELECT naam, voornaam FROM werknemers LIMIT 0, 10';
        //Voer de query uit
        $stmt=$pdo->query($query);
        //aantal rijen in het result set
        echo "<p>aantal rijen = " . $stmt->rowCount() . "</p>";
        // setFetchMode: haal associatieve arrays op
        // key = kolomnaam, value = waarde in tabel
        $stmt->setFetchMode(PDO::FETCH_ASSOC); //FETCH_NUM
        //fetch: haal 1 rij op uit het result set
        //return = array of false (als er geen rijen meer zijn)
        $rij=$stmt->fetch();
        $index=0;
        while($rij !== false)
        {
            echo "<pre>[$index]";
            var_dump($rij);
            echo "</pre>";
            $index++;
            $rij=$stmt->fetch();
        }
        */
        //EINDE KLASSIEKE SELECT, display als onkneedbare list
        
        //KLASSIEKE SELECT, display netjes
        /*
        $sql = "SELECT * FROM werknemers WHERE naam = 'Martens'";
        foreach($pdo->query($sql) as $row)
        {
            print $row['voornaam'] . '-' . $row['naam'] . '<br/>';
        }
        */
        //EINDE KLASSIEKE SELECT, display netjes
        
        //Klassieke insert
        /*
        $query = 'INSERT INTO werknemers (naam, voornaam) VALUES ("Dawkins", "Richard")'; 
        $cnt = $pdo->exec($query);
        echo "$cnt rij(en) toegevoegd";
        */
        
        //INSERT data
        /*
        $count = $pdo->exec("INSERT INTO werknemers (naam, voornaam) VALUES ('Langkous', 'Pipi')");
        echo $count;
        */
        
        //UPDATE data
        /*$count = $pdo->exec("UPDATE werknemers SET voornaam='pipi' WHERE naam='langkous'");;
        echo $count;*/
        
        //DELETE data
        /*
        $count = $pdo->exec("DELETE FROM werknemers WHERE voornaam='pipi'");;
        echo $count;
        */
        
    }
    catch(PDOException $e)
    {
        /*echo "<pre>";
        echo $e->getMessage()."\n\n".$e->getTraceAsString();
        echo "</pre>";*/
        echo $e->getMessage();
    }
    finally //Wil netbeans precies niet herkennen
    {
       $pdo = null;
    }
   
?>