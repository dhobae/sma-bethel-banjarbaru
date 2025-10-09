<?php

class HelpModel {
    private $table = 'help';
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function get(){
        $this->db->query('SELECT help.*,users.nama FROM '.$this->table.' LEFT JOIN users ON users.nip=help.user ORDER BY id DESC');
        $this->db->bind(':user', $_SESSION['nip']);
        $result = $this->db->resultSet();

        return $result;
    }

    public function getByNIP(){
        $this->db->query('SELECT * FROM '.$this->table.' WHERE user=:user ORDER BY id DESC');
        $this->db->bind(':user', $_SESSION['nip']);
        $result = $this->db->resultSet();

        return $result;
    }

    public function add($data){
        $waktu = date('Y-m-d').', '.date('H:i');

        $this->db->query('INSERT INTO '.$this->table.' (waktu,user,subjek,laporan) VALUES (:waktu,:user,:subjek,:laporan)');
        $this->db->bind(':waktu', $waktu);
        $this->db->bind(':user', $_SESSION['nip']);
        $this->db->bind(':subjek', $data['subjek']);
        $this->db->bind(':laporan', $data['laporan']);

        //execute 
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getById($id){
        $this->db->query('SELECT help.*,users.nama FROM '.$this->table.' LEFT JOIN users ON users.nip=help.user WHERE help.id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }

    public function tanggapan($data){
        $this->db->query('UPDATE '.$this->table.' SET tanggapan = :tanggapan WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':tanggapan', $data['tanggapan']);
        
        //execute 
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function delete($id){
        $this->db->query('DELETE FROM '.$this->table.' WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}