/* global bootbox */

var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e)
    {
        guardaryeditar(e);
    });

    //Cargamos los items al select rol
    $.post("../ajax/usuario.php?op=selectRol", function (r) {
        $("#cbo_rol").html(r);
        $("#cbo_rol").selectpicker('refresh');

    });

    //Cargamos los items al select cargo
    $.post("../ajax/usuario.php?op=selectCargo", function (r) {
        $("#cbo_cargo").html(r);
        $("#cbo_cargo").selectpicker('refresh');

    });

    //Mostramos los permisos
    $.post("../ajax/usuario.php?op=permisos&id=", function (r) {
        $("#permisos").html(r);
    });
}

//Función limpiar
function limpiar()
{
    $("#id_usuario").val("");
    $("#txt_documento").val("");
    $("#txt_nombres").val("");
    $("#txt_apellidos").val("");
    $("#txt_telefono").val("");
    $("#txt_celular").val("");
    $("#txt_email").val("");
    $("#txt_contraseña_actual").val("");
    $("#txt_contraseña").val("");
    $("#txt_conf_contraseña").val("");
    $("#cbo_rol").val("");
    $("#cbo_rol").selectpicker('refresh');
    $("#cbo_cargo").val("");
    $("#cbo_cargo").selectpicker('refresh');
    $("input:checkbox").prop("checked", false);
}

//Función mostrar formulario
function mostrarform(flag)
{    
    if (flag)
    {
        $("#listado").hide();
        $("#registro").show();
        $("#actualizar").hide();
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else
    {
        $("#listado").show();
        $("#registro").hide();
        $("#actualizar").hide();
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Función cancelar formulario
function cancelarform()
{
    limpiar();
    mostrarform(false);
}

//Función Listar
function listar()
{
    tabla = $('#tbllistado').dataTable(
            {
                "aProcessing": true, //Activamos el procesamiento del datatables
                "aServerSide": true, //Paginación y filtrado realizados por el servidor
                dom: 'Bfrtip', //Definimos los elementos del control de tabla
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
                "ajax":
                        {
                            url: '../ajax/usuario.php?op=listar',
                            type: "get",
                            dataType: "json",
                            error: function (e) {
                                console.log(e.responseText);
                            }
                        },
                "responsive": true,
                "bDestroy": true,
                "iDisplayLength": 10, //Paginación
                "order": [[0, "desc"]]//Ordenar (columna,orden)
            }).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e)
{
    if ($('input[type=checkbox]:checked').length === 0) {
        e.preventDefault();
        bootbox.alert("<div class='lead text-center'><strong class='text-warning'>¡Cuidado!</strong><br><hr>Debe asiganar al menos un permiso para el usuario</div>");
    } else {
        e.preventDefault(); //No se activará la acción predeterminada del evento
        $("#btnGuardar").prop("disabled", true);
        var formData = new FormData($("#formulario")[0]);

        $.ajax({
            url: "../ajax/usuario.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function (datos)
            {
                bootbox.alert(datos);
                mostrarform(false);
                tabla.ajax.reload();
            }

        });
        limpiar();
    }
}

function mostrar(id_usuario)
{
    $.post("../ajax/usuario.php?op=mostrar", {id_usuario: id_usuario}, function (data, status)
    {
        data = JSON.parse(data);
        mostrarform(true);
        $("#registro").hide();
        $("#actualizar").show();

        $("#id_usuario").val(data.usu_intId);
        $("#txt_documento").val(data.usu_varDocumento).prop("readonly", true);
        $("#txt_nombres").val(data.usu_varNombres);
        $("#txt_apellidos").val(data.usu_varApellidos);
        $("#txt_telefono").val(data.usu_varTelefono);
        $("#txt_celular").val(data.usu_varCelular);
        $("#txt_email").val(data.usu_varEmail);
        $("#txt_contraseña_actual").val(data.usu_varContraseña);
        $("#txt_contraseña").val('');
        $("#txt_conf_contraseña").val('');
        $("#cbo_rol").val(data.rol_intId);
        $("#cbo_rol").selectpicker('refresh');
        $("#cbo_cargo").val(data.car_intId);
        $("#cbo_cargo").selectpicker('refresh');

    });
    $.post("../ajax/usuario.php?op=permisos&id=" + id_usuario, function (r) {
        $("#permisos").html(r);
    });
}

//Función para desactivar registros
function desactivar(id_usuario)
{
    bootbox.confirm("<div class='lead text-center'><strong class='text-warning'>¡Cuidado!</strong><br><hr>¿Está Seguro de desactivar el usuario?</div>", function (result) {
        if (result)
        {
            $.post("../ajax/usuario.php?op=desactivar", {id_usuario: id_usuario}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

//Función para activar registros
function activar(id_usuario)
{
    bootbox.confirm("<div class='lead text-center'><strong class='text-warning'>¡Cuidado!</strong><br><hr>¿Está Seguro de activar el usuario?</div>", function (result) {
        if (result)
        {
            $.post("../ajax/usuario.php?op=activar", {id_usuario: id_usuario}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

//Revisar si documento de usuario esta registrado
$("#txt_documento").change(function () {

    $(".alert").remove();

    var documento = $(this).val();

    var datos = new FormData();
    datos.append("validar_documento", documento);

    $.ajax({
        url: "../ajax/usuario.php?op=existeIdentificacion",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            if (respuesta) {
                bootbox.alert("<div class='lead text-center'><strong class='text-danger'>¡Error!</strong><br><hr>El número de documento ya existe en la base de datos.</div>");
                $("#txt_documento").val("");
                $("#txt_documento").focus();
            }

        }

    });
});

//Revisar si email de proveedor esta registrado
$("#txt_email").change(function () {

    $(".alert").remove();

    var email = $(this).val();

    var datos = new FormData();
    datos.append("validar_email", email);

    $.ajax({
        url: "../ajax/usuario.php?op=existeEmail",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            if (respuesta) {
                bootbox.alert("<div class='lead text-center'><strong class='text-danger'>¡Error!</strong><br><hr>Este email ya existe en la base de datos.</div>");
                $("#txt_email").val("");
                $("#txt_email").focus();
            }

        }

    });
});

//Valida que las claves ingresadas sean iguales
var txt_contraseña = document.getElementById("txt_contraseña"), txt_conf_contraseña = document.getElementById("txt_conf_contraseña");
function validatePassword() {
    if (txt_contraseña.value !== txt_conf_contraseña.value) {
        txt_conf_contraseña.setCustomValidity("Las contraseñas ingresadas no coinciden");
    } else {
        txt_conf_contraseña.setCustomValidity('');
    }
}
txt_contraseña.onchange = validatePassword;
txt_conf_contraseña.onkeyup = validatePassword;

init();