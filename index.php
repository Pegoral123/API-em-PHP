<?php
include_once "./config/config.php";
require_once "./controler/usuarioControler.php";
require_once "./app/services/DAO.php";
require_once "./app/models/usuario.php";

//phpinfo();
try {
    if (count($_REQUEST) == 0) throw new Exception();

    $method = $_SERVER["REQUEST_METHOD"];

    $url = explode("/", $_GET["url"]);

    if ($method == "GET") { //Pesquisa
        header("Content-Type: application/json; charset=UTF-8");
        //localhost/api/usuario/list

        //var_dump($url);
        $result = null;

        switch ($url[0]) {
            case "usuario":
                switch ($url[1]) {
                    case "get": {
                            if (!isset($url{
                                2})) throw new Exception();
                            $user = new Usuario;
                            $result = $user->get($url[2]);
                        }
                        break;

                    case "list": {
                            $user = new Usuario;
                            $result = $user->getAll();
                        }
                        break;

                    default:
                        throw new Exception();
                        break;
                }
                break;

            case "produto":
                break;

            default:
                throw new Exception();
                break;
        }

        http_response_code(200);
        echo json_encode($result);
    }

    if ($method == "POST") { //Cadastros e Atualizações
        header("Content-Type: application/json; charset=UTF-8");
        switch ($url[0]) {
            case "usuario":
                switch ($url[1]) {
                    case "add": {
                            $dadosUser = json_decode(file_get_contents('php://input'));
                            $user = new Usuario;
                            $user = $dadosUser;
                            $usuarioControl = new UsuarioControler;
                            $result = $usuarioControl->add($user);
                            //$result = $user->add();
                        }
                        break;

                    default:
                        throw new Exception();
                        break;
                }
                break;

            default:
                throw new Exception();
                break;
        }

        http_response_code(200);
        echo "Entra de um POST";
    }
} catch (Exception $e) {
    http_response_code(404);
    echo json_encode(array("mensagem" => "Pagina não encontrada!"));
}
