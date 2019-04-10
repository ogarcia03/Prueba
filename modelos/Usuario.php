<?php

//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Usuario {

    //Implementamos nuestro constructor
    public function __construct() {
        
    }

    //Implementamos un método para insertar registros
    public function insertar($documento, $identificacion, $nombre, $apellido, $direccion, $ciudad, $barrio, $telefono, $cel_uno, $cel_dos, $correo, $grupo, $clavehash, $permisos) {
        $sql = "INSERT INTO tbl_usuario (doc_intId,usu_strIdentificacion,usu_strNombres,usu_strApellidos,usu_strDireccion,mun_intId,usu_strBarrio,usu_strTelefono,usu_strCel_uno,usu_strCel_dos,
                                         usu_strCorreo,gru_intId,usu_strPassword,usu_tinCondicion)
		VALUES ('$documento','$identificacion','$nombre','$apellido','$direccion','$ciudad','$barrio','$telefono','$cel_uno','$cel_dos','$correo','$grupo','$clavehash','1')";
        //return ejecutarConsulta($sql);
        $id_usuarionew = ejecutarConsulta_retornarID($sql);

        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO tbl_usuario_permiso(usu_intId, per_intId) VALUES('$id_usuarionew', '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos = $num_elementos + 1;
        }

        return $sw;
    }

    //Implementamos un método para editar registros
    public function editar($id_usuario, $documento, $identificacion, $nombre, $apellido, $direccion, $ciudad, $barrio, $telefono, $cel_uno, $cel_dos, $correo, $grupo, $clavehash, $permisos) {
        $sql = "UPDATE tbl_usuario SET doc_intId='$documento',usu_strIdentificacion='$identificacion',usu_strNombres='$nombre',usu_strApellidos='$apellido',usu_strDireccion='$direccion',
                mun_intId='$ciudad',usu_strBarrio='$barrio',usu_strTelefono='$telefono',usu_strCel_uno='$cel_uno',usu_strCel_dos='$cel_dos',usu_strCorreo='$correo',gru_intId='$grupo',
                usu_strPassword='$clavehash'
                WHERE usu_intId='$id_usuario'";
        ejecutarConsulta($sql);

        //Eliminamos todos los permisos asignados para volverlos a registrar
        $sqldel = "DELETE FROM tbl_usuario_permiso WHERE usu_intId='$id_usuario'";
        ejecutarConsulta($sqldel);

        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($permisos)) {
            $sql_detalle = "INSERT INTO tbl_usuario_permiso(usu_intId, per_intId) VALUES('$id_usuario', '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos = $num_elementos + 1;
        }

        return $sw;
    }

    //Implementamos un método para desactivar categorías
    public function desactivar($id_usuario) {
        $sql = "UPDATE tbl_usuario SET usu_tinCondicion='0' WHERE usu_intId='$id_usuario'";
        return ejecutarConsulta($sql);
    }

    //Implementamos un método para activar categorías
    public function activar($id_usuario) {
        $sql = "UPDATE tbl_usuario SET usu_tinCondicion='1' WHERE usu_intId='$id_usuario'";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($id_usuario) {
        $sql = "SELECT * FROM tbl_usuario WHERE usu_intId='$id_usuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para listar los registros
    public function listar() {
        $sql = "SELECT * FROM tbl_usuario                               
                INNER JOIN tbl_rol on tbl_usuario.rol_intId = tbl_rol.rol_intId
                INNER JOIN tbl_cargo on tbl_usuario.car_intId = tbl_cargo.car_intId
                ORDER BY usu_intId DESC";

        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los permisos marcados
    public function listarmarcados($id_usuario) {
        $sql = "SELECT * FROM tbl_usuario_permiso WHERE usu_intId='$id_usuario'";
        return ejecutarConsulta($sql);
    }

    //Función para verificar el acceso al sistema
    public function verificar($login, $clave) {
        $sql = "SELECT * FROM tbl_usuario
                INNER JOIN tbl_grupo on tbl_usuario.gru_intId = tbl_grupo.gru_intId
                WHERE usu_strIdentificacion='$login' AND usu_strPassword='$clave' AND usu_tinCondicion='1'";

        return ejecutarConsulta($sql);
    }

    //Implementar un método para validar no repetir identificación
    public function existeIdentificacion($val_Identificacion) {
        $sql = "SELECT usu_strIdentificacion FROM tbl_usuario
                WHERE usu_strIdentificacion='$val_Identificacion'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para validar no repetir correo
    public function existeCorreo($val_Correo) {
        $sql = "SELECT usu_strCorreo FROM tbl_usuario
                WHERE usu_strCorreo='$val_Correo'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //Implementar un método para listar los registros y mostrar en el select
    public function select() {
        $sql = "SELECT * FROM tbl_usuario WHERE usu_tinCondicion='1'";
        return ejecutarConsulta($sql);
    }

}
