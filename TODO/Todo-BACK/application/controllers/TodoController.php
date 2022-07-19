<?php
namespace application\controllers;

class TodoController extends Controller {
    public function main() {
        return "index.html";
    }
    public function index() {
        switch(getMethod()) {
            case _GET:
                return $this->model->selTodoList();
            case _POST:
                $json = getJson();
                if(preg_replace('/\s+/', '', $json["todo"])) {
                    return ["result" => $this->model->insTodo($json)];
                }
            case _DELETE:
                $urlPaths = getUrlPaths();
                $itodo = isset($urlPaths[2]) ? $urlPaths[2] : null;
                $param = ["itodo" => $itodo];
                return ["result" => $this->model->delTodo($param)];
        }
    }
}