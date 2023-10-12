<?php

session_start();

class users
{
    
    public $id;
    public $username;
    public $email;
    public $password;
    public $rpassword;

    public function __construct($id, $username, $email, $password, $rpassword)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->rpassword = $rpassword;
        $this->id = $id;
    }


    public function validate()
    {
        if ($this->password === $this->rpassword) {
            return true;
        } else {
            return false;
        }
    }
}
class database
{

    public $database;
    public function __construct()
    {
        $pdo = new PDO('sqlite:users.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->database = $pdo;
    }

    public function connect()
    {
        return $this->database;
    }
}



class userController
{
    public database $db;
    public function __construct(database $db)
    {
        $this->db = $db;
    }
    public function  register(users $user)
    {

        $pdo = $this->db->connect();
        $sqlCheck = "SELECT * FROM userss WHERE username = :username OR email = :email";
        $queryCheck = $pdo->prepare($sqlCheck);
        $queryCheck->execute(['username' => $user->username, 'email' => $user->email]);
        $userCount = $queryCheck->fetchColumn();

        if ($userCount > 0) {
            echo 'User not registered (username or email already exists)';
        } else {
            $sql = "INSERT INTO userss (username, email, password, rpassword) VALUES (:username, :email, :password, :rpassword)";
            $query = $pdo->prepare($sql);
            $query->execute(['username' => $user->username, 'email' => $user->email, 'password' => $user->password, 'rpassword' => $user->rpassword]);
            echo 'User registered';
        }
    }




    public function login(users $user)
    {
        $pdo = $this->db->connect();
        $sql = "SELECT * FROM userss WHERE (username = :username OR email = :email) AND password = :password";
        $query = $pdo->prepare($sql);
        $query->execute(['username' => $user->username, 'email' => $user->username, 'password' => $user->password]);
        $userCount = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($userCount) > 0) {
            $_SESSION['username'] = $userCount[0]['username'];
            $_SESSION['id'] = $userCount[0]['id'];
            header('Location: todos.php');
            exit;
        } else {
            echo 'User not found';
        }
    }
    
    public function logout()
    {
        session_destroy();
        echo "Logged out";
        header('Location: index.php');
        exit;
    }

}


class todos
{


    public $id;

    public $userid;

    public $todos;

    public function __construct($id, $todos, $userid)
    {
        $this->id = $id;
        $this->todos = $todos;
        $this->userid = $userid;
    }
}

class todosController
{
    public database $db;
    public function __construct(database $db)
    {
        $this->db = $db;
    }

    public function add(todos $todo)
    {
        $pdo = $this->db->connect();
        $sql = "INSERT INTO todos (todos, userid) VALUES (:todos, :userid)";
        $query = $pdo->prepare($sql);
        $query->execute(['todos' => $todo->todos, 'userid' => $todo->userid]);
        echo 'Todo added';
    }

    public function delete(todos $todo)
    {
        $pdo = $this->db->connect();
        $sql = "DELETE FROM todos WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->execute(['id' => $todo->id]);
        echo 'Todo deleted';
    }

    public function selectAll(todos $todo)
    {
        $pdo = $this->db->connect();
        $sql = "SELECT * FROM todos WHERE userid = :userid";
        $query = $pdo->prepare($sql);
        $query->execute(['userid' => $todo->userid]);
        $todos = $query->fetchAll(PDO::FETCH_ASSOC);
        return $todos;
    }

    public function deleteAll(todos $todo)
    {
        $pdo = $this->db->connect();
        $sql = "DELETE FROM todos WHERE userid = :userid";
        $query = $pdo->prepare($sql);
        $query->execute(['userid' => $todo->userid]);
        echo 'All todos deleted';
    }

    public function update(todos $todo)
    {
        $pdo = $this->db->connect();
        $sql = "UPDATE todos SET todos = :todos WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->execute(['todos' => $todo->todos, 'id' => $todo->id]);
        echo 'Todo updated';
    }


    public function search(todos $todo)
    {
        $pdo = $this->db->connect();
        $sql = "SELECT * FROM todos WHERE todos LIKE :todos AND userid = :userid";
        $query = $pdo->prepare($sql);
        $query->execute(['todos' => '%' . $todo->todos . '%', 'userid' => $todo->userid]);
        $todos = $query->fetchAll(PDO::FETCH_ASSOC);
        return $todos;
    }




    
}
