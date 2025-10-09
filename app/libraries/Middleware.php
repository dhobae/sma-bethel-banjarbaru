<?php 
class Middleware extends Controller
{
   public static function admin($akses)
   {
      $controller = new Controller();
      $result = $controller->model('AdminModel')->cekAkses($akses);
      return $result;
   }

   public static function petugas()
   {
      $controller = new Controller();
      $result = $controller->model('PersediaanModel')->cekAkses();
      return $result;
   }

   public static function jabatan($akses)
   {
      $controller = new Controller();
      $result = $controller->model('JabatanModel')->cekAkses($akses);
      return $result;
   }
}
?>