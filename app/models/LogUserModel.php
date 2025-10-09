<?php

class LogUserModel
{
    private $table = 'log_user';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function get()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER by id DESC";
        $this->db->query($query);

        return $this->db->resultSet();
    }

    public function add()
    {
        $this->db->query('INSERT INTO ' . $this->table . ' (nama_user,nip_user,waktu_login,waktu_logout) VALUES (:nama_user,:nip_user,:waktu_login,:waktu_logout)');
        $this->db->bind(':nama_user', $_SESSION['nama']);
        $this->db->bind(':nip_user', $_SESSION['nip']);
        $this->db->bind(':waktu_login', $_SESSION['waktu_login']);
        $this->db->bind(':waktu_logout', date('Y-m-d H:i:s'));

        //execute 
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function pengunjung($username)
    {
        $ip      = $_SERVER['REMOTE_ADDR'];
        $tanggal = date("y-m-d");
        $sql = "SELECT * from pengunjung where ip=:ip AND tanggal=:tanggal AND npk=:username";
        $this->db->query($sql);
        $this->db->bind('ip', $ip);
        $this->db->bind('tanggal', $tanggal);
        $this->db->bind('username', $username);
        return $this->db->resultSet();
    }

    public function simpan_pengunjung($data)
    {
        $ip      = $_SERVER['REMOTE_ADDR'];
        $tanggal = date("y-m-d");
        $waktu = time();
        $sql = "INSERT into pengunjung(id, ip, npk, dari, tanggal, hits, online) VALUES (:id, :ip, :npk, :dari, :tanggal, :hits, :online)";
        $this->db->query($sql);
        $this->db->bind('id', NULL);
        $this->db->bind('ip', $ip);
        $this->db->bind('npk', $data['username']);
        $this->db->bind('dari', $data['dari']);
        $this->db->bind('tanggal', $tanggal);
        $this->db->bind('hits', '1');
        $this->db->bind('online', $waktu);
        $this->db->execute();
        return true;
    }
}
