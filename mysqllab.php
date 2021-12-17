<?php

require "vendor/autoload.php";

class HandleSql extends refunct
{
    public $conn_str;
    public $select;

    /**
     *this method connectes to the database
     */

    public function __construct($host, $username, $password, $db_name)
    {
        $this->conn_str = new mysqli($host, $username, $password, $db_name) or die(mysqli_connect_error());
        // echo $this->conn_str?"yes":"no";
    }

    private function runQuery($sql)
    {
        $query = $this->conn_str->query($sql) or die($this->conn_str->error . ' my query ' . $sql);
        return $query;
        //$this->select = $this->conn_str->query("SELECT * FROM user_table");
        //echo $this->select->num_rows<1?"nothing found":"something found";
    }

    public function selectQuery($table, $column, $where = "")
    {
        $this->select = $this->runQuery("SELECT  $column FROM $table $where ") or die($this->conn_str->error);
        //echo $this->select->num_rows<1?"nothing found":"something found";
    }
    public function selectQueryL($table, $column, $where = "", $id, $limit)
    {
        $this->select = $this->runQuery("SELECT $column FROM $table $where ORDER BY $id DESC limit $limit") or die($this->conn_str->error);
        //echo $this->select->num_rows<1?"nothing found":"something found";
    }
    public function selectQueryLM($table, $column, $where = "", $id, $limit)
    {
        $this->select = $this->runQuery("SELECT $column FROM $table $where ORDER BY $id  limit $limit") or die($this->conn_str->error);
        //echo $this->select->num_rows<1?"nothing found":"something found";
    }

    public function selectQueryDESC($table, $column, $where = "", $id)
    {
        $this->select = $this->runQuery("SELECT $column FROM $table $where  ORDER BY $id DESC") or die($this->conn_str->error);
        //echo $this->select->num_rows<1?"nothing found":"something found";
    }

    public function naturalJoin($table, $column, $table2, $where, $where2, $id, $limit)
    {
        $this->select = $this->runQuery("SELECT $column FROM $table inner join  $table2  on $where $where2   ORDER BY $id LIMIT $limit") or die($this->conn_str->error);
    }

    public function selectJoin($column, $table, $table2, $where, $where2)
    {
        $this->select = $this->runQuery("SELECT $column FROM $table inner join $table2 on $where where $where2") or die($this->conn_str->error);
    }

    public function selectOrder($table, $column, $where = "", $id)
    {
        $this->select = $this->runQuery("SELECT $column FROM $table $where ORDER BY $id") or die($this->conn_str->error);
        //echo $this->select->num_rows<1?"nothing found":"something found";
    }

    public function countQuery($table, $where)
    {
        $this->select = $this->runQuery("SELECT COUNT(*) FROM $table $where ") or die($this->conn_str->error);
    }

    /**
     * THIS METHOD INSERTS DATA INTO THE DATABASE
     */

    public function insertQuery($table, $column, $inserts)
    {
        $query = $this->runQuery("INSERT INTO  $table ($column) VALUES ($inserts)") or die($this->conn_str->error);
        return $query ? true : false;
    }
/**
 *   THIS METHOD UPDATES INFO INTO THE DATABASE
 */
    public function update($table, $set, $where)
    {
        return $this->runQuery("UPDATE $table SET $set $where");
    }

    /*
     *this method replaces value in th database
     */
    public function replace($table, $column, $inserts)
    {
        $query = $this->runQuery("REPLACE INTO  $table ($column) VALUES ($inserts)") or die($this->conn_str->error);
        return $query ? true : false;
    }

    public function delete($table, $where)
    {
        return $this->runQuery("DELETE FROM $table $where");
    }
    /**
     *THIS METHOD COUNTS THE TOTAL NUMBER OF ROWS FOUND IN THE DATABASE
     */
    public function checkrow()
    {
        return $this->select->num_rows;
    }

/**
 *this method adds quotation mareks around my input
 */
    public function addQuote($recieve)
    {
        $arr = [];
        for ($i = 0; $i < count($recieve); $i++) {
            $arr[] = "'" . $recieve[$i] . "'";
        }
        return $arr;
    }

/**
 *this method converts an array to a string
 *by using the imbuilt implode key word
 */

    public function convertMeToString($glue, $arr)
    {
        return implode($glue, $arr);
    }

    public function between($column, $table, $where)
    {
        $this->select = $this->runQuery("SELECT $column FROM $table $where ") or die($this->conn_str->error);
    }

/**
 * THIS METHOD FETCHES DATA FROM THE DATA BASE
 */

    public function fetchQuery()
    {
        $bag = array();
        while ($row = $this->select->fetch_assoc()) {
            array_push($bag, $row);
            // or $bag[]=$row
        }
        return $bag;
    }

    public function selJoin($column, $table, $table2, $where, $where2, $id)
    {
        $this->select = $this->runQuery("SELECT $column FROM $table inner join  $table2 on $where where $where2 ORDER BY $id ASC") or die($this->conn_str->error);
    }

    public function firstAsc($table, $column, $where = "", $id)
    {
        $this->select = $this->runQuery("SELECT $column FROM $table $where  ORDER BY $id ASC") or die($this->conn_str->error);
    }

    public function firstAscc($table, $column, $where = "", $id, $limit = "")
    {
        $this->select = $this->runQuery("SELECT $column FROM $table $where  ORDER BY $id ASC LIMIT $limit") or die($this->conn_str->error);
    }

    public function lastDsc($table, $column, $where = "", $id, $limit)
    {
        $this->select = $this->runQuery("SELECT $column FROM $table $where ORDER BY $id DESC LIMIT $limit") or die($this->conn_str->error);
    }

    public function sum($table, $column, $name, $where)
    {
        $this->select = $this->runQuery("SELECT SUM($column) AS $name FROM $table $where") or die($this->conn_str->error);
    }

/*
 *this method hashes user password
 * the argument i recieve should be a string
 */
    public function hash_pword($hashme)
    {
        return password_hash($hashme, PASSWORD_BCRYPT); /* md5(sha1($hashme)) */;

    }

/**
 *this method takes an assoc array as an argument
 * it is used to clean userinputs/hash password
 */
    public function clean($dirty)
    {
        $cleaned_output = array();
        foreach ($dirty as $key => $value) {
            if ($key == 'password') {
                $cleaned_output[] = $this->conn_str->real_escape_string($this->hash_pword($value));
            } else {
                $clean_me = $this->conn_str->real_escape_string($value);
                $cleaned_output[] = $clean_me;}

        }
        return $cleaned_output;

    }

    public function neat($dirty)
    {
        $cleaned_output = array();
        foreach ($dirty as $key => $value) {
            if ($key == 'password') {
                $cleaned_output[$key] = $this->conn_str->real_escape_string($this->hash_pword($value));

            } else {
                $clean_me = $this->conn_str->real_escape_string($value);
                $cleaned_output[$key] = $clean_me;
            }

        }
        return $cleaned_output;

    }

    public function pregmatch($value)
    {

        if (preg_match('/^[A-Z \'.-]{2,40}$/i', $value)) {
            return $value;
        }

    }

    public function ValidatePass($value)
    {
        if (preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,20}$/', $value)) {
            return $value;
        }
    }

    public function ValidateEmail($email)
    {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }
    }
}

/**
 *handelsql ends


 *  class refunct (reusable functions)
 */

class refunct
{
    public function random_alphanumeric($length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ012345689';
        $my_string = '';
        for ($i = 0; $i < $length; $i++) {
            $pos = mt_rand(0, strlen($chars) - 1);
            $my_string .= substr($chars, $pos, 1);
        }
        return $my_string;
    }

    public function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    public function Verifypix($file)
    {
        $errors = [];
        $file_name = $file['name'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];
        $file_type = $file['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $extension = array("jpeg", "jpg", "png", "gif");
        $bytes = 1024;
        $allowedKB = 100;
        $totalBytes = $allowedKB * $bytes;
        $path = 'c:\xampp\htdocs\lodges\images/';

        if (!in_array($file_ext, $extension)) {
            array_push($errors, "File type is invalid, Please select image only.");
            return 2;
        }

        /*  if($file_size > $totalBytes){
        array_push($errors, "File size must be less than 100KB!!!");
        return 4;
        }  */
        if (file_exists("$path" . $file_name)) {
            array_push($errors, "File is already exist!!!");
            return 3;
        }

        $count = count($errors);

        if ($count == 0) {
            $uplod = move_uploaded_file($file_tmp, $path . $file_name);
            if ($uplod) {
                echo $file_name;
            } else {
                echo 'failed';
            }
        }

    }

    public function PrepareUploadedFile($FieldName, $MaxSize, $dir = "", $id)
    {

        $f = $FieldName;
        $FileTypes = ["jpeg", "jpg", "png", "JPG", "PNG", "JPEG", "gif"];
        $NoRename = false;

        //$last = strtolower($php_upload_size_limit[strlen($php_upload_size_limit) - 1]);

        if ($f['size'] > $MaxSize) {
            return str_replace('<MaxSize>', intval($MaxSize / 1024), 'file too large');
        }

        $ft = (explode('.', $f['name']));
        $ft = $ft[1];
        if (!in_array($ft, $FileTypes)) {
            return str_replace('<FileTypes>', $FileTypes, 'invalid file type');
        }

        if ($NoRename) {
            $n = str_replace(' ', '_', $f['name']);
        } else {
            $n = microtime();
            $n = str_replace(' ', '_', $n);
            $n = str_replace('0.', '', $n);
            $n .= '_' . $id;
            $n .= '.' . $ft;
        }

        if (!move_uploaded_file($f['tmp_name'], $dir . $n)) {
            return "Couldn't save the uploaded file. Try chmoding the upload folder '{$dir}' to 777.";
            exit;
        } else {
            @chmod($dir . $n, 0666);

            define("PATHTOUPLOADURL", "https://stcbnk.com/bank/uploads/");

            $pixx = PATHTOUPLOADURL . $n;

            return ['code' => 1, 'picture_url' => $pixx, 'picture' => $n];
        }

    }

    public function replaceKey(&$array, $curkey, $newkey)
    {
        if (array_key_exists($curkey, $array)) {
            $array[$newkey] = $array[$curkey];
            /*  unset($array[$curkey]); */
            return true;
        }
        return false;

    }

    public function getLoggedAdmin()
    {
        // checks session variables to see whether the admin is logged or not
        // if not, it returns FALSE
        // if logged, it returns the user id

        $adminConfig = config('adminConfig');

        if ($_SESSION['adminUsername'] != '') {
            return $_SESSION['adminUsername'];
        } elseif ($_SESSION['memberID'] == $adminConfig['adminUsername']) {
            $_SESSION['adminUsername'] = $_SESSION['memberID'];
            return $_SESSION['adminUsername'];
        } else {
            return false;
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
