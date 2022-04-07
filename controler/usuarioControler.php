<?php
class UsuarioControler
{
    public function getALL()
    {
        try {
            $dao = new DAO;
            $conn = $dao->conecta();
            $sql = "select * from usuario";
            $stman = $conn->prepare($sql);
            $stman->execute();
            $result = $stman->fetchAll();
            return $result;
        } catch (Exception $e) {

            throw new Exception("erro ao buscar usuario" . $e->getMessage());
        }
    }

    public function get($id)
    {
        try {
            $sql = "select * from usuario where id = :id";
            $dao = new DAO;
            $stman = $dao->conecta()->prepare($sql);
            $stman->bindParam(":id", $id);
            $stman->execute();
            $result = $stman->fetchAll();
            return $result;
        } catch (Exception $e) {

            throw new Exception("erro ao buscar usuario" . $e->getMessage());
        }
    }
    public function add(Usuario $user)
    {
        try {
            $sql = "INSERT INTO usuario 
                    (id, nome, senha, data_nasc, email, fotoPerfil, tel, cpf, ativo) 
                    VALUES
                    (null, :nome, :senha, :data_nasc, :email, :foto_perfil, :tel, :cpf, :ativo)";
            $dao = new DAO;
            $stman = $dao->conecta()->prepare($sql);
            $stman->bindParam(":nome", $user->nome);
            $stman->bindParam(":senha", md5($user->senha));
            $stman->bindParam(":data_nasc", $this->formatDateBD($user->data_nasc));
            $stman->bindParam(":email", $user->email);
            $stman->bindParam(":foto_perfil", $user->foto_perfil);
            $stman->bindParam(":tel", $user->tel);
            $stman->bindParam(":cpf", $user->cpf);
            $stman->bindParam(":ativo", $user->ativo);
            $stman->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o usuario: " . $e->getMessage());
        }
    }

    private  function  formatDateBD($date)
    { // Entrada: DD/MM/YYYY -> YYYY/MM/DD
        $partDate = explode("/", $date);
        return new DateTime($partDate[2] . "-" . $partDate[1] . "-" . $partDate[0]);
    }
}
