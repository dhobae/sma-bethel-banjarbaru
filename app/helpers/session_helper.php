<?php

//session_set_cookie_params(0, '/', 'http://localhost/sip/dashboard');
session_name('ci_session');

session_start();

function setFlash($message, $type)
{
    $_SESSION['msg'] = [
        'message' => $message,
        'type' => $type
    ];
}

function flash()
{
    if (isset($_SESSION['msg'])) {
        echo '<div class="alert alert-' . $_SESSION['msg']['type'] . ' alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            ' . $_SESSION['msg']['message'] . '
        </div>';
    }
    unset($_SESSION['msg']);
}

function isLoggedIn()
{
    if (isset($_SESSION['id_user'])) {
        return true;
    } else {
        return false;
    }
}

function isAccountLocked()
{
    if (!isLoggedIn()) {
        return false;
    }

    require_once __DIR__ . '/../libraries/Database.php';
    $db = new Database();
    $db->query('SELECT pegawai.kunci FROM users LEFT JOIN pegawai ON users.nik_user = pegawai.nik WHERE users.id_user = :id');
    $db->bind(':id', $_SESSION['id_user']);
    $row = $db->single();

    return $row && isset($row->kunci) && $row->kunci === '1';
}

function forceLogoutIfLocked()
{
    if (isAccountLocked()) {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');

        if (!headers_sent()) {
            header('Location: ' . URLROOT . '/auth/login');
        }
        exit;
    }
}

forceLogoutIfLocked();

function sflash()
{
    if (isset($_SESSION['msg'])) {
        echo '<script>
            Swal.fire({
                icon: "' . $_SESSION['msg']['type'] . '",
                text: "' . $_SESSION['msg']['message'] . '"
            });
        </script>';
    }
    unset($_SESSION['msg']);
}

function sflash2()
{
    if (isset($_SESSION['msg'])) {
        echo '<script>
            Swal.fire({
                position: "top-end",
                timer: 2000,
                showConfirmButton: false,
                icon: "' . $_SESSION['msg']['type'] . '",
                title: "' . $_SESSION['msg']['message'] . '"
            });
        </script>';
    }
    unset($_SESSION['msg']);
}
