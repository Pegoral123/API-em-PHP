<?php

class UsuarioController
{
    public function getAll()
    {
        try {
            $dao = new DAO;
            $sql = "select * from usuario";
            $conn = $dao->conecta();
            $stman = $conn->prepare($sql);
            //$stman = $dao->conecta()->prepare($sql);
            $stman->execute();
            $result = $stman->fetchAll();
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar os usuarios: " . $e->getMessage());
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
            $result = $stman->fetchALL();
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erro ao pegar o usuario: " . $e->getMessage());
        }
    }

    public function add(Usuario $user)
    {
        try {
            $sql = "INSERT INTO usuario 
                    (id, nome, senha, data_nasc, email, fotoPerfil, tel, cpf, ativo) 
                    VALUES
                    (null, :nome, md5(:senha), :data_nasc, :email, :foto_perfil, :tel, :cpf, :ativo)";
            //$senhaCryp = md5($user->senha);
            $senhaCryp = crypt($user->senha, '$5$rounds=5000$' . $user->email . '$');
            $dataBanco = $this->formatDateBD($user->data_nasc);

            $dao = new DAO;
            $stman = $dao->conecta()->prepare($sql);
            $stman->bindParam(":nome", $user->nome);
            $stman->bindParam(":senha", $senhaCryp);
            $stman->bindParam(":data_nasc", $dataBanco);
            $stman->bindParam(":email", $user->email);
            $stman->bindParam(":foto_perfil", $user->foto_perfil);
            $stman->bindParam(":tel", $user->tel);
            $stman->bindParam(":cpf", $user->cpf);
            $stman->bindParam(":ativo", $user->ativo);
            return $stman->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastra o usuario: " . $e->getMessage());
        }
    }

    public function update(Usuario $user)
    {
        try {
            $sql = "UPDATE  usuario 
                    SET nome = :nome,
                    senha = md5(:senha),
                    data_nasc = :data_nasc,
                    email = :email,
                    fotoPerfil = :foto_perfil,
                    tel = :tel,
                    cpf = :cpf, 
                    ativo = :ativo
                    WHERE usuario.id = :id";
            //$senhaCryp = md5($user->senha);
            $senhaCryp = crypt($user->senha, '$5$rounds=5000$' . $user->email . '$');
            $dataBanco = $this->formatDateBD($user->data_nasc);

            $dao = new DAO;
            $stman = $dao->conecta()->prepare($sql);
            $stman->bindParam(":id", $user->id);
            $stman->bindParam(":nome", $user->nome);
            $stman->bindParam(":senha", $senhaCryp);
            $stman->bindParam(":data_nasc", $dataBanco);
            $stman->bindParam(":email", $user->email);
            $stman->bindParam(":foto_perfil", $user->foto_perfil);
            $stman->bindParam(":tel", $user->tel);
            $stman->bindParam(":cpf", $user->cpf);
            $stman->bindParam(":ativo", $user->ativo);
            return $stman->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizado o usuario: " . $e->getMessage());
        }
    }


    private  function  formatDateBD($date)
    { // Entrada: DD/MM/YYYY -> YYYY/MM/DD
        $partDate = explode("/", $date);
        return ($partDate[2] . "-" . $partDate[1] . "-" . $partDate[0]);
    }
}