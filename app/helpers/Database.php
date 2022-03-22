<?php


class Database {
    private $serverName;
    private $userName;
    private $dbName;
    private $password;
    private $conn;

    public function __construct()
    {
        require_once 'EnvReader.php';
        (new EnvReader(__DIR__ . '/../../.env'))->load();
        $this->serverName = getenv('DATABASE_HOST');
        $this->dbName = getenv('DATABASE_NAME');
        $this->userName = getenv('DATABASE_USER');
        $this->password = getenv('DATABASE_PASSWORD');
        $this->conn = new mysqli($this->serverName, $this->userName, $this->password);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $dbSetupFile = __DIR__.'/dbSetup.php';
        if (file_exists($dbSetupFile)){
            require_once $dbSetupFile;
            rename($dbSetupFile,$dbSetupFile.'.tmp');
        } else {
            $this->conn->select_db($this->dbName);
        }
    }

    private function createDatabase($dbName)
    {
        if (!$this->conn->select_db($dbName)) {
            $createDbSql = "CREATE Database $dbName";
            if (!$this->conn->query($createDbSql)) {
                die("Error message: \n" . $this->conn->error);
            }
            $this->conn->select_db($dbName);
        }
    }

    private function createTable($tableName, $createTableSql){
        $tableExists = $this->conn->query("SHOW TABLES LIKE '$tableName'");
        if (!$tableExists || !$tableExists->num_rows) {

            if (!$this->conn->query($createTableSql)) {
                die("Error message: \n". $this->conn->error);
            }
        }
    }

    public function insertData($insertLogsSql) {
        if(!$this->conn->query($insertLogsSql)){
            die("Error message: \n Data Not Saved \n". $this->conn->error);
        }

    }

    public function checkIfUsersExists($email){
        $query = $this->conn->query("SELECT id FROM users WHERE email ='$email'");

        return (bool)$query->num_rows;

    }

    public function getResults(){
        return $this->conn->query("SELECT count(id) AS clicks, YEAR(time) AS Y, MONTH(time) AS M, user_ip, button_id FROM `logs` GROUP BY button_id, user_ip, Y, M;");

    }

    public function authUser($email,$password){
        $loginSql = "SELECT * FROM users WHERE email = '$email'";
        $user = $this->conn->query($loginSql)->fetch_assoc();

        if(!empty($user) && password_verify($password,$user['password'])) {
            return $user;
        }
    }

    public function isUserLogged(){
        if (empty($_SESSION['user_id']) || empty($_SESSION['user_auth'])) {
            return false;
        }
        $user_id = (int) $_SESSION['user_id'];
        $user_password =  $this->conn->escape_string($_SESSION['user_auth']);
        $loginSql = "SELECT id FROM users WHERE id = $user_id and SHA1(password) = '$user_password'";
        $user = $this->conn->query($loginSql)->fetch_assoc();

        return !empty($user);
    }

}

