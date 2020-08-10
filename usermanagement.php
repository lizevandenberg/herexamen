<?php

class UserManagement extends MysqlDB
{
    
    public function CheckDuplicateUser($username, $email)
    {
        
        $Duplicatequery = $this->pdo->prepare("SELECT 1 AS flag FROM users WHERE username = ? OR email = ?"); // kolom flag 1
        $Duplicatequery->bindParam(1, $username);
        $Duplicatequery->bindParam(2, $email);
        $Duplicatequery->execute();
        $result = $Duplicatequery->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    public function RegisterNewUser($username, $email, $password, $firstname, $lastname)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->pdo->beginTransaction();
        try {
            $UserCreationquery = $this->pdo->prepare("INSERT INTO users(username, email, PASSWORD, firstname, lastname ) VALUES(?,?,?,?,?)");
            $UserCreationquery->bindParam(1, $username);
            $UserCreationquery->bindParam(2, $email);
            $UserCreationquery->bindParam(3, $password);
            $UserCreationquery->bindParam(4, $firstname);
            $UserCreationquery->bindParam(5, $lastname);
            $UserCreationquery->execute();
        }
        catch (\Throwable $e) {
            $this->pdo->rollBack();
            error_log($e);
            return -1;
        }
        
        $this->pdo->commit();
        
    }
    public function InitialWalletFill($firstname, $lastname)
    {
        $this->pdo->beginTransaction();
        try {
            $kaching = $this->pdo->prepare("INSERT INTO transactions(sender, receiver,amount,comment) SELECT  0, userid, 10, 'Welkom bij de Kaching familie!' FROM userlookup WHERE firstname=? AND lastname=?");
            $kaching->bindParam(1, $firstname);
            $kaching->bindParam(2, $lastname);
            $kaching->execute();
        }
        catch (\Throwable $e) {
            $this->pdo->rollBack();
            error_log($e);
            return -1;
        }
        $this->pdo->commit();
        
        
    }
    
    public function Login($username, $password)
    {
        $loginquery = $this->pdo->prepare("SELECT PASSWORD AS password FROM users WHERE  username = ?");
        $loginquery->bindParam(1, $username);
        $loginquery->execute();
        $result = $loginquery->fetch(PDO::FETCH_ASSOC);
        $result = $result['password'];
        
        
        
        
        if ($loginquery->rowCount() > 0) {
            if (password_verify($password, $result)) {
                $_SESSION['message']  = "Je bent ingelogd";
                $_SESSION['username'] = $username;
                header("location:home.php");
            } else {
                $_SESSION['message'] = "password incorrect";
                header("location:login.php");
            }
        } else {
            $_SESSION['message'] = "user not found";
            header("location:login.php");
        }
        
        return $result;
    }
    
}

?>