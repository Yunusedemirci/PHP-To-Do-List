<?php
require_once 'backend.php';

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$db = new database();
$todoController = new todosController($db);


if (isset($_POST['addTodo'])) {
    if (empty($_POST['todo'])) {
        echo 'Todo boş olamaz';
        header('Location: todos.php');
        exit;
    } else {
        $todo = $_POST['todo'];
        $tod = new todos($id = null, $todo, $_SESSION['id']);
        $todoController->add($tod);
        header('Location: todos.php');
        exit;
    }
}

if (isset($_POST['deleteTodo'])) {
    $id = $_POST['id'];
    $tod = new todos($id, $todos = null, $userid = null);
    $todoController->delete($tod);
    header('Location: todos.php');
    exit;
}

if (isset($_POST['deleteAll'])) {
    $tod = new todos($id = null, $todos = null, $_SESSION['id']);
    $todoController->deleteAll($tod);
    header('Location: todos.php');
    exit;
}

if (isset($_POST['editTodo'])) {
    if (empty($_POST['newTodoText'])) {
        echo 'Todo boş olamaz';
        header('Location: todos.php');
        exit;
    } else {
        $id = $_POST['id'];
        $newTodoText = $_POST['newTodoText'];
        $todoToUpdate = new todos($id, $newTodoText, $_SESSION['id']);
        $todoController->update($todoToUpdate);
        header('Location: todos.php');
        exit;
    }
}


if (isset($_POST['logout'])) {
    $userController = new userController($db);

    $userController->logout();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO-DO LİST APPLİCATİON</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="logout">
        <form action="#" method="post">
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="logout" value="logout">Logout</button>
        </form>
    </div>


    <div class="container">
        <h1>Yavuzlar Todo List Uygulaması</h1>
        <form action="#" method="post">

            <div class="add-todo">
                <input type="text" id="todoInput" name="todo" placeholder="Yeni bir todo ekleyin">
                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="addTodo" value="addTodo">Add To-do</button>
            </div>
        </form>

        <form action="#" method="post">
            <div class="search-todo">
                <input type="text" id="filterInput" name="searchWord" placeholder="Arama yapın">
                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="searchTodo" value="searchTodo">Ara</button>
            </div>
        </form>

        </form>
        <form action="#" method="post">
            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="showAllTodos" value="showAllTodos">Show All Todos</button>
        </form>



        <ul id="todoList">
            <?php
            // if (isset($_POST['searchTodo'])) {
            //     if (!empty($_POST['searchWord'])) {
            //         $searchWord = $_POST['searchWord'];
            //         $todos = $todoController->selectAll(new todos($id = null, $todos = null, $_SESSION['id']));

            //         foreach ($todos as $key => $value) {
            //             if (stripos($value['todos'], $searchWord) !== false) {
            //                 echo '<li data-id="' . $value['id'] . '">
            //         <input type="checkbox" name="selectedTodos" value="' . $value['id'] . '">
            //         <p class="text">' . $value['todos'] . '</p>
            //         <form action="#" method="post">
            //             <input type="hidden" name="id" value="' . $value['id'] . '">
            //             <button class="delete" name="deleteTodo" value="deleteTodo">Delete</button>
            //         </form>
            //         <form action="#" method="post">
            //             <input type="hidden" name="id" value="' . $value['id'] . '">
            //             <input type="text" name="newTodoText" placeholder="Edit your to-do list item">
            //             <button class="edit" name="editTodo" value="editTodo">Edit</button>
            //         </form>
            //     </li>';
            //             }
            //         }
            //     } else {
            //         echo 'Arama yapmak için bir kelime giriniz';
            //     }
            // }

            if (isset($_POST['searchTodo'])) {
                if (!empty($_POST['searchWord'])) {
                    $searchWord = $_POST['searchWord'];
                    $todos = $todoController->search(new todos($id = null, $searchWord, $_SESSION['id']));
                    foreach ($todos as $key => $value) {
                        echo '<li data-id="' . $value['id'] . '">
                    <input type="checkbox" name="selectedTodos" value="' . $value['id'] . '">
                    <p class="text">' . $value['todos'] . '</p>
                    <form action="#" method="post">
                        <input type="hidden" name="id" value="' . $value['id'] . '">
                        <button class="delete" name="deleteTodo" value="deleteTodo">Delete</button>
                    </form>
                    <form action="#" method="post">
                        <input type="hidden" name="id" value="' . $value['id'] . '">
                        <input type="text" name="newTodoText" placeholder="Edit your to-do list item">
                        <button class="edit" name="editTodo" value="editTodo">Edit</button>
                    </form>
                </li>';
                    }
                } else {
                    echo 'Arama yapmak için bir kelime giriniz';
                }
            }






            if (isset($_POST['showAllTodos'])) {
                $todos = $todoController->selectAll(new todos($id = null, $todos = null, $_SESSION['id']));
                foreach ($todos as $key => $value) {
                    echo '<li data-id="' . $value['id'] . '">
                    <input type="checkbox" name="selectedTodos" value="' . $value['id'] . '">
                    <p class="text">' . $value['todos'] . '</p>
                    <form action="#" method="post">
                        <input type="hidden" name="id" value="' . $value['id'] . '">
                        <button class="delete" name="deleteTodo" value="deleteTodo">Delete</button>
                    </form>
                    <form action="#" method="post">
                        <input type="hidden" name="id" value="' . $value['id'] . '">
                        <input type="text" name="newTodoText" placeholder="Edit your to-do list item">
                        <button class="edit" name="editTodo" value="editTodo">Edit</button>
                    </form>
                </li>';
                }
            }

            if (!isset($_POST['searchTodo']) && !isset($_POST['showAllTodos'])) {
                $todos = $todoController->selectAll(new todos($id = null, $todos = null, $_SESSION['id']));
                foreach ($todos as $key => $value) {
                    echo '<li data-id="' . $value['id'] . '">
                    <input type="checkbox" name="selectedTodos" value="' . $value['id'] . '">
                    <p class="text">' . $value['todos'] . '</p>
                    <form action="#" method="post">
                        <input type="hidden" name="id" value="' . $value['id'] . '">
                        <button class="delete" name="deleteTodo" value="deleteTodo">Delete</button>
                    </form>
                    <form action="#" method="post">
                        <input type="hidden" name="id" value="' . $value['id'] . '">
                        <input type="text" name="newTodoText" placeholder="Edit your to-do list item">
                        <button class="edit" name="editTodo" value="editTodo">Edit</button>
                    </form>
                </li>';
                }
            }


            ?>

        </ul>


        <div class="buttons">

            <form action="#" method="post">
                <button id="deleteAll" name="deleteAll" value="deleteAll">Tümünü Sil</button>

            </form>
        </div>
    </div>

</body>

</html>