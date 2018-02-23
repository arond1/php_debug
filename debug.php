<?php
class debuggueur
{
private $sgbd = "mysql";
private $host_name = "localhost";
private $database = "test";
private $user_name = "root";
private $password = "";
private $connection_database = null;

public function __construct()
{
	try
	{
    $connect = new PDO($this->sgbd .':host='.$this->host_name .';dbname='.$this->database .';charset=utf8', $this->user_name, $this->password);
	$this->connection_database = $connect;
	}
	catch(Exception $e)
	{
			die('Erreur : '.$e->getMessage());
	}
	
	if(!$this->mysql_table_exists("log"))
	{
	$this->connection_database->query('CREATE TABLE IF NOT EXISTS `log` (`idlog` int(11) NOT NULL,`text` text NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;COMMIT');
	}
	
}

public function debug($deb)
{
	$deb = $this->grab_dump($deb);
	$id = $this->get_id();
	$req = $this->connection_database->prepare('INSERT INTO log(idlog, text) VALUES( :id, :value)');
	$req->execute(array(
    'id' => $id,
    'value' => $deb,
    ));
}

public function get_id()
{
	$i = $this->connection_database->query('SELECT MAX(`idlog`)+1 FROM `log` WHERE 1');
	$i = $i->fetch();
	$i = $i['0'];
	if($i == null)
	{
	$i = 1;	
	}
	return $i;
}

public function grab_dump($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

public function mysql_table_exists($table){
      $query = "SELECT COUNT(*) FROM $table";
      $result = $this->connection_database->query($query);
	  //$result = false if the table doesn't exist (tested one Mysql)
      if($result)
      return TRUE;
      else
      return FALSE;
      }

}
?>