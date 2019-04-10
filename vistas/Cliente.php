<?php
require 'header.php';
?>   

<div class="content-wrapper"> 

    <section class="content-header">

        <h1 class="lead" id="listado">Administración de <strong>Cliente</strong></h1>
        <h1 class="lead" id="registro">Registro de <strong>Cliente</strong></h1>
        <h1 class="lead" id="actualizar">Modificar <strong>Cliente</strong></h1>
        <ol class="breadcrumb">
            <li><a href="escritorio.php"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Cliente</li>
        </ol>

    </section>     

    <section class="content">

        <div class="row">

            <div class="col-md-12">   

                <div class="box box-primary">

                    <div class="box-header">                                
                        <button class="btn btn-primary pull-right" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus"></i> <strong>Agregar</strong></button>                               
                    </div>   

                    <div class="panel-body" id="listadoregistros">

                        <table id="tbllistado" class="table table-condensed table-hover nowrap" style="width:100%">

                            <thead class="bg-gray">
                                
                                <tr>              
                                    
                                    <th class="text-center">Documento</th>                                           
                                    <th class="text-center">Nombre</th> 
                                    <th class="text-center">Email</th>  
                                    <th class="text-center">Rol</th>
                                    <th class="text-center">Cargo</th>                                                                                                              
                                    <th class="text-center">Estado</th>
                                    <th class="text-center" style="width: 100px; overflow: auto;">Opciones</th>
                                    
                                </tr>
                                
                            </thead>     

                        </table>

                    </div>

                    <div class="panel-body" id="formularioregistros">   

                        <form name="formulario" id="formulario" method="POST"> 

                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_documento">Documento(*):</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><strong>CC</strong></div>
                                    <input type="hidden" name="id_usuario" id="id_usuario">
                                    <input type="number" class="form-control" name="txt_documento" id="txt_documento" maxlength="20" pattern="[0-9]{7,20}" title="" placeholder="Documento identificación" autocomplete="off" required="" tabindex="1">
                                </div>                                                                                            
                            </div>
                            
                             <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_apellido1">Primer Apellidos(*):</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span></div>
                                    <input type="text" class="form-control" name="txt_apellido1" id="txt_apellido1" maxlength="100" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,100}" placeholder="Primer Apellidos" autocomplete="off" required="" tabindex="2">
                                </div>                                                                                                                
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_apellido2">Segundo Apellidos(*):</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span></div>
                                    <input type="text" class="form-control" name="txt_apellido2" id="txt_apellido2" maxlength="100" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,100}" placeholder="Segundo Apellidos" autocomplete="off" required="" tabindex="3">
                                </div>                                                                                                                
                            </div>

                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_nombre1">Primer Nombre(*):</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span></div>
                                    <input type="text" class="form-control" name="txt_nombre1" id="txt_nombre1" maxlength="100" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,100}" placeholder="Primer Nombre" autocomplete="off" required="" tabindex="4">
                                </div>                                                                                                                
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_nombre2">Segundo Nombre(*):</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span></div>
                                    <input type="text" class="form-control" name="txt_nombre2" id="txt_nombre2" maxlength="100" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,100}" placeholder="Segundo Nombre" autocomplete="off" required="" tabindex="5">
                                </div>                                                                                                                
                            </div>

                           
                            
                                   
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_Sexo">Sexo(*):</label>                                      
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-list"></span></div>
                                    <input type="text" class="form-control" name="txt_sexo" id="txt_sexo"  pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,100}" placeholder="Sexo (F o M)" autocomplete="off" required="" tabindex="6">
                                </div>                                                                                                               
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="dtm_FechaNacimiento">Fecha Nacimiento(*):</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span></div>
                                    <input type="date" class="form-control" name="dtm_FechaNacimiento" id="dtm_FechaNacimiento" maxlength="100"  placeholder="Segundo Apellidos" autocomplete="off" required="" tabindex="7">
                                </div>                                                                                                                
                            </div>
                            
                            
                               <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_rh">RH:</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span></div>
                                    <input type="text" class="form-control" name="txt_rh" id="txt_rh"  placeholder="RH" autocomplete="off" tabindex="8">
                                </div>                                                                                                       
                            </div> 
                            
                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_CadenaVerificacion1">Primera Cadena de Verificacion:</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span></div>
                                    <input type="text" class="form-control" name="txt_CadenaVerificacion1" id="txt_CadenaVerificacion1" maxlength="100" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,100}" placeholder="Primera cadena de Verifiación" autocomplete="off" required="" disabled="" tabindex="9">
                                </div>                                                                                                                
                            </div>
                            
                                  <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_CadenaVerificacion2">Segunda Cadena de Verificacion:</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-user"></span></div>
                                    <input type="text" class="form-control" name="txt_CadenaVerificacion2" id="txt_CadenaVerificacion2" maxlength="100" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,100}" placeholder="Segunda cadena de Verifiación" autocomplete="off" required="" disabled="" tabindex="10">
                                </div>                                                                                                                
                            </div>


                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_celular">Celular:</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-phone-square"></span></div>
                                    <input type="number" class="form-control" name="txt_celular" id="txt_celular" maxlength="7" pattern="[0-9]{10,10}" title="" placeholder="Ingrese un nùmero de celular" autocomplete="off" tabindex="11">
                                </div>                                                                                                       
                            </div>

                               
                            
                            
                                <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <label for="txt_email">Email(*):</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><strong>@</strong></span></div>
                                    <input type="email" class="form-control" name="txt_email" id="txt_email" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" placeholder="Ingrese un email" autocomplete="off" required="" tabindex="12">
                                </div>                                                                                                          
                            </div>


                            <div class="form-group col-lg-13 col-md-13 col-sm-13 col-xs-13 text-left">
                                
                                <div class="form-group  col-lg-13 col-md-13 col-sm-13 col-xs-12">
                                <label for="chek_avastdata" >Autorizo de manera libre, voluntaria,previa, explícita, informada e inequívoca a LAURA S.A.S, para que en los términos legalmente establecidos realice la recolección, almacenamiento, uso, circulación, supresión y en general, el tratamiento de los datos personales que he procedido a entregar o que entregaré, en virtud de las relaciones legales, contractuales, comerciales y/o de cualquier otra que surja, en desarrollo y ejecución de los fines descritos en el presente párrafo</label>
                                 <input type="checkbox" name="txt_avastdata" id="txt_avastdata" tabindex="13">
                                                                                                                                      
                            </div> 
                            
                                <hr>
                               
                                
                            <div class="form-group col-lg-13 col-md-13 col-sm-13 col-xs-13 text-right">
                                <button type="submit" class="btn btn-primary" id="btnGuardar" tabindex="12"><i class="fa fa-save"></i> Guardar</button>

                                <button type="button" class="btn btn-danger" onclick="cancelarform()" tabindex="13"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>     

        </div>

    </section>

</div>

<?php
require 'footer.php';
?>      
<script type="text/javascript" src="scripts/usuario.js"></script>    