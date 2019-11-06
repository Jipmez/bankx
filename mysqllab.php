<?php
class HandleSql{
    public $conn_str;
    public $select;

    /**
    *this method connectes to the database
    */

    public function __construct($host,$username,$password,$db_name){
        $this->conn_str = new mysqli($host,$username,$password,$db_name) or die(mysqli_connect_error());
       // echo $this->conn_str?"yes":"no";
    }

    private function runQuery($sql){
        $query = $this->conn_str->query($sql) or die($this->conn_str->error.' my query '.$sql );
        return $query;
        //$this->select = $this->conn_str->query("SELECT * FROM user_table");
        //echo $this->select->num_rows<1?"nothing found":"something found";
    }

    public function selectQuery($table, $column,$where=""){
        $this->select = $this->runQuery("SELECT $column FROM $table $where ") or die($this->conn_str->error);
        //echo $this->select->num_rows<1?"nothing found":"something found";
    }
    public function selectQueryL($table, $column,$where="",$limit){
        $this->select = $this->runQuery("SELECT $column FROM $table $where limit $limit") or die($this->conn_str->error);
        //echo $this->select->num_rows<1?"nothing found":"something found";
    }


    public function countQuery($table,$where){
        $this->select = $this->runQuery("SELECT COUNT(*) FROM $table $where ") or die($this->conn_str->error);
    }

    /**
    * THIS METHOD INSERTS DATA INTO THE DATABASE
    */

    public function insertQuery($table,$column,$inserts){
       $query=$this->runQuery("INSERT INTO  $table ($column) VALUES ($inserts)")or die($this->conn_str->error);
       return $query?true:false;
    }
/**
*   THIS METHOD UPDATES INFO INTO THE DATABASE
*/
    public function update($table,$set,$where){
      return  $this->runQuery("UPDATE $table SET $set $where");
    }

    /**
    *THIS METHOD COUNTS THE TOTAL NUMBER OF ROWS FOUND IN THE DATABASE
    */
    public function checkrow(){
       return $this->select->num_rows;
    }

/**
*this method adds quotation mareks around my input
*/
public function addQuote($recieve){
    $arr=[];
    for($i=0; $i<count($recieve);$i++){
       $arr[]="'".$recieve[$i]."'";
    }
    return $arr;
}

/**
*this method converts an array to a string
*by using the imbuilt implode key word
*/

public function convertMeToString($glue,$arr){
    return implode($glue , $arr);
}


public function between($column,$table,$where){
    $this->select = $this->runQuery("SELECT $column FROM $table $where") or die($this->conn_str->error);
}

/**
* THIS METHOD FETCHES DATA FROM THE DATA BASE
*/

    public function fetchQuery(){
        $bag=array();
        while($row=$this->select->fetch_assoc()){
            array_push($bag,$row);
           // or $bag[]=$row
        }
      return $bag;
    }


    public function firstAsc($table, $column,$where="",$id,$limit){
        $this->select = $this->runQuery("SELECT $column FROM $table $where ORDER BY $id ASC LIMIT $limit") or die($this->conn_str->error);
    }

    public function lastDsc($table, $column,$where,$id,$limit){
        $this->select = $this->runQuery("SELECT $column FROM $table $where ORDER BY $id DESC LIMIT $limit") or die($this->conn_str->error);
    }


    public function sum($table,$column,$name,$where){
        $this->select = $this->runQuery("SELECT SUM($column) AS $name FROM $table $where") or die($this->conn_str->error);
    }



/*
*this method hashes user password
* the argument i recieve should be a string 
*/
public function hash_pword($hashme){
   return  password_hash($hashme, PASSWORD_BCRYPT);/* md5(sha1($hashme)) */;

}





/**
*this method takes an assoc array as an argument
* it is used to clean userinputs/hash password
*/
    public function clean($dirty){
     $cleaned_output=array();
     foreach($dirty as $key=>$value){
         if($key=='password'){
             $cleaned_output[]=$this->conn_str->real_escape_string($this->hash_pword($value));
         }else{
         $clean_me=$this->conn_str->real_escape_string($value);
         $cleaned_output[]=$clean_me; }

     }
         return $cleaned_output;
     
    }


    public function pregmatch($value){

       if(preg_match('/^[A-Z \'.-]{2,40}$/i', $value)){
     return $value;
      }

    }

    public function ValidatePass($value){
        if(preg_match ('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/',$value)){
           return $value;
        }
    }


    public function ValidateEmail($email){

        if (filter_var($email,FILTER_VALIDATE_EMAIL)){
     return $email;
        }
}
  
    
}
/**$instance = new HandleSql("localhost", "root","","classical_bank");
$columns="email,password,phoneno";
$instance -> insertQuery("user_table",$columns,"'patience@gmail.com','uuuuuuuuu','1223334'");
$username='king.gmail.com';
$col="email='$username', password='oman' ";
$instance->update("user_table",$col,"WHERE sn=1");
$instance->selectQuery('user_table','*','');
$instance->fetchQuery();
*/

 /*  $instance=new HandleSql("localhost","root","","bloodbase");
$columns="fullname,email,phonenumber,password,man";
//$instance->insertQuery("blood_table",$columns,"'rolins','rolins@gmail.com','08167951424','rolins','2'");
$instance->update("blood_table",$columns,"WHERE sn=6"); */ 
?>