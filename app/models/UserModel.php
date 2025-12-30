<?php
class UserModel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function ip()
    {
        $sql = "SELECT * from ip_address";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    //register new user
    public function register($data)
    {
        $this->db->query('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //find user by email
    public function findUserByUsernameOrNIP($username)
    {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        //check the row 
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password)
    {
        $this->db->query('SELECT * FROM users 
        left join pegawai on users.nik_user=pegawai.nik 
        left join siswa on users.nik_user=siswa.nis
        WHERE users.username = :username
        ');
        $this->db->bind(':username', $username);

        $row = $this->db->single();
        $hash_password = $row->password;

        $tes =  password_verify($password, $hash_password);

        if (password_verify($password, $hash_password)) {
            return $row;
        } else {
            return false;
        }
    }

    public function login_portal($username, $password)
    {
        $this->db->query('SELECT * FROM user WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        $hash_password = $row->password;

        if ($password == $hash_password) {
            return $row;
        } else {
            return false;
        }
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM user WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function getByLogin()
    {
        $query = "SELECT * FROM user WHERE nip = :nip";
        $this->db->query($query);
        $this->db->bind(':nip', $_SESSION['nip']);

        $row = $this->db->single();

        return $row;
    }

    public function changePassword($data)
    {
        $query = "SELECT * FROM user WHERE nip = :nip";
        $this->db->query($query);
        $this->db->bind(':nip', $_SESSION['nip']);

        $user = $this->db->single();
        if ($user) {
            if (password_verify($data['password'], $user->password)) {
                $query = "UPDATE users SET password=:password WHERE nip=:nip";
                $this->db->query($query);
                $this->db->bind(':nip', $_SESSION['nip']);
                $this->db->bind(':password', password_hash($data['password_baru'], PASSWORD_DEFAULT));

                $this->db->execute();
                return $this->db->rowCount();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function changeProfile($data, $files)
    {
        $newAvatarName = $_SESSION['avatar'];
        if ($files['avatar']['size'] > 0) {
            $file_extension = pathinfo($files['avatar']['name'], PATHINFO_EXTENSION);
            $allowed_extension = array(
                "png",
                "jpg",
                "jpeg"
            );

            if (!in_array($file_extension, $allowed_extension)) {
                return false;
            }

            $newAvatarName = $_SESSION['nip'] . '.' . $file_extension;

            if ($files['avatar']['size'] < 2000 * 1000) {
                if ($_SESSION['avatar'] == NULL) {
                    move_uploaded_file($files['avatar']['tmp_name'], "../public/img/avatar/" . $newAvatarName);
                } else {
                    if (unlink("../public/img/avatar/" . $_SESSION['avatar'])) {
                        move_uploaded_file($files['avatar']['tmp_name'], "../public/img/avatar/" . $newAvatarName);
                    } else {
                        move_uploaded_file($files['avatar']['tmp_name'], "../public/img/avatar/" . $newAvatarName);
                    }
                }
            } else {
                return false;
            }
        }

        $query = "UPDATE users SET username=:username,nama=:nama,no_telp=:no_telp,email=:email,golongan=:golongan,jabatan=:jabatan,avatar=:avatar WHERE nip=:nip";
        $this->db->query($query);
        $this->db->bind(':nip', $_SESSION['nip']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':nama', $data['nama']);
        $this->db->bind(':no_telp', $data['no_telp']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':golongan', $data['golongan']);
        $this->db->bind(':jabatan', $data['jabatan']);
        $this->db->bind(':avatar', $newAvatarName);

        if ($this->db->execute()) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['jabatan'] = $data['jabatan'];
            $_SESSION['avatar'] = $newAvatarName;
            return true;
        } else {
            return false;
        }
    }



    public function simpan_ip_address_sementara($ip)
    {
        $sql = "INSERT INTO ip_address (id, ip_address, keterangan) values (:id, :ip_address, :keterangan)";
        $this->db->query($sql);
        $this->db->bind('id', NULL);
        $this->db->bind('ip_address', $ip);
        $this->db->bind('keterangan', 'otomatis');
        $this->db->execute();
        return true;
    }

    public function isBruteForce($ip_address)
    {
        $this->db->query("SELECT COUNT(*) as attempt_count FROM login_attempts WHERE ip_address = :ip AND timestamp > (NOW() - INTERVAL 15 MINUTE)");
        $this->db->bind(':ip', $ip_address);
        $result = $this->db->single();

        return ($result->attempt_count >= 5); // Batasi maksimal 5 percobaan dalam 15 menit
    }

    public function recordLoginAttempt($ip_address)
    {
        $this->db->query("INSERT INTO login_attempts (ip_address, timestamp) VALUES (:ip, NOW())");
        $this->db->bind(':ip', $ip_address);
        $this->db->execute();
    }

    public function resetLoginAttempts($ip_address)
    {
        $this->db->query("DELETE FROM login_attempts WHERE ip_address = :ip");
        $this->db->bind(':ip', $ip_address);
        $this->db->execute();
    }
}
