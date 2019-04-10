<?php

session_start();
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$documento = isset($_POST["txt_documento"]) ? limpiarCadena($_POST["txt_documento"]) : "";
$nombre = isset($_POST["txt_nombres"]) ? limpiarCadena($_POST["txt_nombres"]) : "";
$apellido = isset($_POST["txt_apellidos"]) ? limpiarCadena($_POST["txt_apellidos"]) : "";
$telefono = isset($_POST["txt_telefono"]) ? limpiarCadena($_POST["txt_telefono"]) : "";
$celular = isset($_POST["txt_celular"]) ? limpiarCadena($_POST["txt_celular"]) : "";
$email = isset($_POST["txt_email"]) ? limpiarCadena($_POST["txt_email"]) : "";
$contraseña_actual = isset($_POST["txt_contraseña_actual"]) ? limpiarCadena($_POST["txt_contraseña_actual"]) : "";
$contraseña = isset($_POST["txt_contraseña"]) ? limpiarCadena($_POST["txt_contraseña"]) : "";
$rol = isset($_POST["cbo_rol"]) ? limpiarCadena($_POST["cbo_rol"]) : "";
$rol = isset($_POST["cbo_cargo"]) ? limpiarCadena($_POST["cbo_cargo"]) : "";


$valida_documento = isset($_POST["validar_documento"]) ? limpiarCadena($_POST["validar_documento"]) : "";
$valida_email = isset($_POST["validar_email"]) ? limpiarCadena($_POST["validar_email"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':

        if ($clave !== "") {
            //Hash SHA256 en la contraseña
            $clavehash = hash("SHA256", $clave);
        } else {
            $clavehash = $clave_actual;
        }

        if (empty($id_usuario)) {
            $rspta = $usuario->insertar($documento, $identificacion, $nombre, $apellido, $direccion, $ciudad, $barrio, $telefono, $cel_uno, $cel_dos, $correo, $grupo, $clavehash, $_POST['permiso']);
            echo $rspta ? "<div class='lead text-center'><strong class='text-success'>¡Bien Hecho!</strong><br><hr>El usuario ha sido registrado correctamente.</div>" :
                    "<div class='lead text-center'><strong class='text-danger'>¡Error!</strong><br><hr>No se pudieron registrar todos los datos del usuario.</div>";
        } else {
            $rspta = $usuario->editar($id_usuario, $documento, $identificacion, $nombre, $apellido, $direccion, $ciudad, $barrio, $telefono, $cel_uno, $cel_dos, $correo, $grupo, $clavehash, $_POST['permiso']);
            echo $rspta ? "<div class='lead text-center'><strong class='text-success'>¡Bien Hecho!</strong><br><hr>Información de usuario ha sido actualizada correctamente.</div>" :
                    "<div class='lead text-center'><strong class='text-danger'>¡Error!</strong><br><hr>No se pudieron actualizar todos los datos del usuario.</div>";
        }
        break;

    case 'desactivar':
        $rspta = $usuario->desactivar($id_usuario);
        echo $rspta ? "<div class='lead text-center'><strong class='text-success'>¡Bien Hecho!</strong><br><hr>El usuario ha sido desactivado correctamente.</div>" :
                "<div class='lead text-center'><strong class='text-danger'>¡Error!</strong><br><hr>Usuario no se puede desactivar.</div>";
        break;

    case 'activar':
        $rspta = $usuario->activar($id_usuario);
        echo $rspta ? "<div class='lead text-center'><strong class='text-success'>¡Bien Hecho!</strong><br><hr>El usuario ha sido activado correctamente.</div>" :
                "<div class='lead text-center'><strong class='text-danger'>¡Error!</strong><br><hr>Usuario no se puede activar.</div>";
        break;

    case 'mostrar':
        $rspta = $usuario->mostrar($id_usuario);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $usuario->listar();
        //Vamos a declarar un array
        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->usu_varDocumento,
                "1" => ucwords($reg->usu_varNombres . ' ' . $reg->usu_varApellidos),
                "2" => $reg->usu_strEmail,
                "3" => ucwords($reg->rol_varRol),
                "4" => ucwords($reg->car_varCargo),
                "5" => ($reg->usu_tinCondicion) ? "<strong><span class='fa fa-check text-success'></span> <span class='text-success'>Activo</span></strong>" : "<strong><span class='fa fa-close text-danger'></span> <span class='text-danger'>Inactivo</span></strong>",
                "6" => ($reg->usu_tinCondicion) ? "<button class='btn btn-warning btn-xs' onclick='mostrar(" . $reg->usu_intId . ")' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fa fa-pencil'></i></button>" .
                " <button class='btn btn-danger btn-xs' onclick='desactivar(" . $reg->usu_intId . ")' data-toggle='tooltip' data-placement='top' title='Desactivar'><i class='fa fa-close'></i></button>" :
                "<button class='btn btn-primary btn-xs' onclick='activar(" . $reg->usu_intId . ")' data-toggle='tooltip' data-placement='top' title='Activar'><i class='fa fa-check'></i></button>"
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);

        break;

    case 'permisos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listar();

        //Obtener los permisos asignados al usuario
        $id = $_GET['id'];
        $marcados = $usuario->listarmarcados($id);

        //Declaramos el array para almacenar todos los permisos marcados
        $valores = array();

        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object()) {
            array_push($valores, $per->per_intId);
        }

        //Mostramos la lista de permisos en la vista y si están o no marcados               
        echo'<tr>';
        $centinela = 1;
        while ($reg = $rspta->fetch_object()) {
            $sw = in_array($reg->per_intId, $valores) ? 'checked' : '';

            echo '<th width="10%"><input type="checkbox" ' . $sw . ' name="permiso[]" value="' . $reg->per_intId . '">  ' . $reg->per_strNombre . '</th>';

            if ($centinela == 3) {

                echo '<tr></tr>';

                $centinela = 0;
            }
            $centinela++;
        }
        echo'</tr>';

        break;

    case 'verificar':
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];

        //Hash SHA256 en la contraseña
        $clavehash = hash("SHA256", $clavea);

        $rspta = $usuario->verificar($logina, $clavehash);

        $fetch = $rspta->fetch_object();

        if (isset($fetch)) {
            //Declaramos las variables de sesión
            $_SESSION['idusuario'] = $fetch->usu_intId;
            $_SESSION['nombre'] = $fetch->usu_strNombres;
            $_SESSION['apellido'] = $fetch->usu_strApellidos;
            $_SESSION['identificacion'] = $fetch->usu_strIdentificacion;
            $_SESSION['grupo'] = $fetch->gru_strNombre;

            //Obtenemos los permisos del usuario
            $marcados = $usuario->listarmarcados($fetch->usu_intId);

            //Declaramos el array para almacenar todos los permisos marcados
            $valores = array();

            //Almacenamos los permisos marcados en el array
            while ($per = $marcados->fetch_object()) {
                array_push($valores, $per->per_intId);
            }

            //Determinamos los accesos del usuario
            in_array(1, $valores) ? $_SESSION['escritorio'] = 1 : $_SESSION['escritorio'] = 0;
            in_array(2, $valores) ? $_SESSION['cuenta'] = 1 : $_SESSION['cuenta'] = 0;
            in_array(3, $valores) ? $_SESSION['egreso'] = 1 : $_SESSION['egreso'] = 0;
            in_array(4, $valores) ? $_SESSION['ingreso'] = 1 : $_SESSION['ingreso'] = 0;
            in_array(5, $valores) ? $_SESSION['acceso'] = 1 : $_SESSION['acceso'] = 0;
            in_array(6, $valores) ? $_SESSION['reportes'] = 1 : $_SESSION['reportes'] = 0;
            in_array(7, $valores) ? $_SESSION['mantenimiento'] = 1 : $_SESSION['mantenimiento'] = 0;
        }
        echo json_encode($fetch);
        break;

    case "selectDocumento":
        require_once "../modelos/Documento.php";
        $documento = new Documento();

        $rspta = $documento->select();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->doc_intId . '>' . ucfirst($reg->doc_strNombre) . '</option>';
        }
        break;

    case "selectCiudad":
        require_once "../modelos/Ciudad.php";
        $ciudad = new Ciudad();

        $rspta = $ciudad->select();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->mun_intId . '>' . ucfirst($reg->mun_strNombre) . ' - ' . ucfirst($reg->dep_strNombre) . '</option>';
        }
        break;

    case "selectGrupo":
        require_once "../modelos/Grupo.php";
        $grupo = new Grupo();

        $rspta = $grupo->select();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->gru_intId . '>' . ucfirst($reg->gru_strNombre) . '</option>';
        }
        break;

    case "selectUsuario":
        require_once "../modelos/Usuario.php";
        $usu = new Usuario();

        $rspta = $usu->select();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->usu_intId . '>' . ucfirst($reg->usu_strNombres) . ' ' . ucfirst($reg->usu_strApellidos) . '</option>';
        }
        break;

    case 'existeIdentificacion':
        $rspta = $usuario->existeIdentificacion($val_Identificacion);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'existeCorreo':
        $rspta = $usuario->existeCorreo($val_correo);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'salir':
        //Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");

        break;
}