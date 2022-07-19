<?php
namespace application\models;
use PDO;

class TodoModel extends Model {
    public function insTodo(&$param) {
        $sql =
        "INSERT INTO t_todo (todo)
        VALUES (:todo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":todo", $param["todo"]);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
        // return $stmt->rowCount();
    }

    public function selTodoList() {
        $sql ="SELECT * FROM t_todo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function delTodo(&$param) {
        $sql = "DELETE FROM t_todo";
        if(isset($param["itodo"])) {
            $sql .= " WHERE itodo = {$param["itodo"]}";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
}