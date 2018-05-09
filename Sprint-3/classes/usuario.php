<?php

class Usuario {
  private $id;
  private $name;
  private $apellidos;
  private $correo;
  private $usuario;
  private $telefono;
  private $clave;
  private $foto;

public function __construct($name, $apellidos, $correo, $usuario, $telefono, $clave, $foto) {
  $this->name = $name;
  $this->name = $apellidos;
  $this->name = $correo;
  $this->name = $usuario;
  $this->name = $telefono;
  $this->name = $clave;
  $this->name = $clave;

  public function crearUsuario(DB $db) {
    $usuario = [
      'id' => $db->traerUltimoID(),
      'name' => $data['name'],
      'apellidos' => $data['apellidos'],
      'correo' => $data['correo'],
      'usuario' => $data['usuario'],
      'telefono' => $data['telefono'],
      'clave' => password_hash($data['clave'], PASSWORD_DEFAULT),
      'rclave' => password_hash($data['rclave'], PASSWORD_DEFAULT),
      'foto' => 'img/' . $data['correo'] . '.' . pathinfo($_FILES[$imagen]['name'], PATHINFO_EXTENSION)
    ];

 public function setName($name) {
   $this->name = $name;
 }

 public function getName($name) {
   return $this->name;
 }

 public function setApellidos($apellidos) {
   $this->apellidos = $apellidos;
 }

 public function getApellidos($apellidos) {
   return $this->apellidos;
 }

 public function setCorreo($correo) {
   $this->correo = $correo;
 }

 public function getCorreo($correo) {
   return $this->correo;
 }

 public function setUsuario($usuario) {
   $this->usuario = $usuario;
 }

 public function getUsuario($usuario) {
   return $this->usuario;
 }

 public function setTelefono($telefono) {
   $this->telefono = $telefono;
 }

 public function getTelefono($telefono) {
   return $this->telefono;
 }

 public function setClave($clave) {
   $this->clave = $clave;
 }

 public function getClave($clave) {
   return $this->clave;
 }

 public function setFoto($foto) {
   $this->foto = $foto;
 }

 public function getFoto($foto) {
   return $this->foto;
 }


}

 ?>
