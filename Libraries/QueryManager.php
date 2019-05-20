<?php
class QueryManager
{
    private $pdo;
    function __construct($SERVER,$USER,$PASS,$DB)
    {
        try
        {
            $dsn='mysql:host='.$SERVER.';dbname='.$DB.';charset=utf8';
            $this->pdo= new PDO($dsn,$USER,$PASS,
            [
                PDO::ATTR_EMULATE_PREPARES=>false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }
        catch(PDOException $e)
        {
            print "¡ERROR!: ".$e->getMessage();
            die();
        }
    }

    function select1($attr,$table,$where,$param)
    { 
        try
        {
            $where = $where ?? "";
            $query="SELECT ".$attr." FROM ".$table.$where;
            $sth = $this->pdo->prepare($query);
            $sth->execute($param);
            $response = $sth->fetchALL(PDO::FETCH_ASSOC);
            $pdo=null;
            return array("result"=>$response);
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    }

    function select2($attr,$table,$_pagi_inicial,$_pagi_cuantos,$where, $param)
    {
        try 
        {
            $query = "SELECT ".$attr." FROM ".$table.$where." LIMIT $_pagi_inicial,$_pagi_cuantos";
            $sth = $this->pdo->prepare($query);
            $sth->execute($param);
            $response = $sth->fetchALL(PDO::FETCH_ASSOC);
            $pdo=null;
            return array("result"=>$response);
        } 
        catch (PDOException $e) 
        {
            return $e->getMessage();
        }
    }

    function insert1($table,$param,$value)
    {
        try 
        {
          $query="INSERT INTO ".$table.$value;
          $sth = $this->pdo->prepare($query);
          $sth->execute((array)$param);
          $pdo=null;
          if($sth)
          {
              return true;
          }  
        } 
        catch (PDOException $e) 
        {
            return $e->getMessage();
        }
    }

    function update($table,$param,$values,$where)
    {
        try 
        {
            $query = "UPDATE ".$table." SET ".$values.$where;
            $sth = $this->pdo->prepare($query);
            $sth->execute((array)$param);
            $pdo =null;
            if($sth)
            {
                return true;
            }
        } catch (PDOException $e) 
        {
            return $e->getMessage();
        }
    }

    function delete($table,$param,$where)
    {
        try 
        {
            $query = "DELETE FROM ".$table.$where;
            $sth = $this->pdo->prepare($query);
            $sth->execute((array)$param);
            $pdo=null;
            if($sth)
            {
                return true;
            }
        } catch (PDOException $e) 
        {
            //throw $th;
        }
    }

    function backup2()
    { 
        $s="db5000080023.hosting-data.io";
        $u="dbu36365";
        $p ="CH2019.ig*";
        $db="dbs74769";
        $rutamd="C:\\Users\\jhon\\Desktop>mysqldump";
        $dir = "tmp/".date("ymd-hi").".sql";

        exec("mysqldump -u $u -p'$p' $db > $dir --hex-blob",$output);
        if(is_null(@$output[0]))
        {

            // Save the SQL script to a backup file
            $backup_file_name= basename($dir);
            $filePath=$dir;
            if(!empty($backup_file_name) && file_exists($filePath)){
                // Define headers
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$backup_file_name");
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: binary");
                
                // Read the file
                readfile($filePath);

                //delete file
                unlink($dir);
                exit;
            }else{
                return 'The file does not exist.';
            }
        }

    }

    function backup()
    {
        $s="db5000080023.hosting-data.io";
        $u="dbu36365";
        $p ="CH2019.ig*";
        $db="dbs74769";
        $rutamd="C:\\Users\\jhon\\Desktop>mysqldump";
        $dir = "tmp/".date("ymd-hi").".sql";
        
        $dbname=$hoy."_".$time;

        //make db connection
		$conn = new mysqli($s, $u, $p, $db);
		if ($conn->connect_error) {
		    die("La conexión falló: " . $conn->connect_error);
		}
 
		//get all of the tables
		if($tables == '*'){
			$tables = array();
			$sql = "SHOW TABLES";
			$query = $conn->query($sql);
			while($row = $query->fetch_row()){
				$tables[] = $row[0];
			}
		}
		else{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
 
		//getting table structures
		$outsql = '';
		foreach ($tables as $table) {
    
		    // Prepare SQLscript for creating table structure
		    $sql = "SHOW CREATE TABLE $table";
		    $query = $conn->query($sql);
		    $row = $query->fetch_row();
		    
		    $outsql .= "\n\n" . $row[1] . ";\n\n";
		    
		    $sql = "SELECT * FROM $table";
		    $query = $conn->query($sql);
		    
		    $columnCount = $query->field_count;
 
		    // Prepare SQLscript for dumping data for each table
		    for ($i = 0; $i < $columnCount; $i ++) {
		        while ($row = $query->fetch_row()) {
		            $outsql .= "INSERT INTO $table VALUES(";
		            for ($j = 0; $j < $columnCount; $j ++) {
		                $row[$j] = $row[$j];
		                
		                if (isset($row[$j])) {
		                    $outsql .= "'" . $row[$j] . "'";
		                } else {
		                    $outsql .= '""';
		                }
		                if ($j < ($columnCount - 1)) {
		                    $outsql .= ',';
		                }
		            }
		            $outsql .= ");\n";
		        }
		    }
		    
		    $outsql .= "\n"; 
		}
 
		// Save the SQL script to a backup file
	    $backup_file_name = $dbname . '_backup.sql';
	    $fileHandler = fopen($backup_file_name, 'w+');
	    fwrite($fileHandler, $outsql);
	    fclose($fileHandler);
 
	    // Download the SQL backup file to the browser
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($backup_file_name));
	    ob_clean();
	    flush();
	    readfile($backup_file_name);
	    exec('rm ' . $backup_file_name);
    }

    function restore($location)
    {
        $s="db5000080023.hosting-data.io";
        $u="dbu36365";
        $p ="CH2019.ig*";
        $db="dbs74769";
        
        //connection
        $conn = new mysqli($s, $u, $p, $db); 
        
        $tables = array();
		$sql = "SHOW TABLES";
		$query = $conn->query($sql);
		while($row = $query->fetch_row()){
			$tables[] = $row[0];
        }
        foreach ($tables as $table)
        {
            // Prepare SQLscript for droping table structure
		    $sql = "DROP TABLE $table";
            $query = $conn->query($sql);
            if(!$query)
            {
                $output2=true;
            }
        }
        //variable use to store queries from our sql file
        $sql = '';

        //$f=fopen($location,'r+');
        //get our sql file
        $lines = file($location);
 
        //return message
        $output = array('error'=>false);
        if($output2)
        {
            $output['error2']=$output2;
        } 
        //loop each line of our sql file
        foreach ($lines as $line){
 
        //skip comments
        if(substr($line, 0, 2) == '--' || $line == ''){
            continue;
        }
 
        //add each line to our query
        $sql .= $line;
 
        //check if its the end of the line due to semicolon
        if (substr(trim($line), -1, 1) == ';'){
            //perform our query
            $query = $conn->query($sql);
            if(!$query){
            	$output['error'] = true;
                $output['message'] = $conn->error;
            }
            else{
            	$output['message'] = 'Base de datos restaurada con éxito';
            }
 
            //reset our query variable
            $sql = '';
            
            }
        }
 
        return $output;
    }
}
?>