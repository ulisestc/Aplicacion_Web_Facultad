<?php
if (isset($_GET["id"])) {
    #Recuperar datos el ID dado
    $xml = simplexml_load_file("xmlgeneral.xml");
    $estancia = $xml->xpath("/facultad/posgrado/maestria/movilidad/estancia[@id=".$_GET["id"]."]");
}
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Movilidad</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"/>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/jquery-ui.min.css"/>
        <link rel="stylesheet" href="css/estilos.css"/>
        <script src="js/external/jquery/jquery.js"></script>
        <script src="js/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
    </head>
    <script type="text/javascript">
        function guardar() {
            var fecha_salida = new Date($("#fecha_salida").val());
            var fecha_regreso = new Date($("#fecha_regreso").val());

            if (fecha_salida > fecha_regreso) {
                $( "<div>La fecha de salida no puede ser mayor que la fecha de regreso.</div>" ).dialog({
                    title:"Error",
                    resizable: false,
                    height: "auto",
                    width: 400,
                    modal: true,
                    buttons: {
                        "Entendido": function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
                return;
            }
            
            $.ajax({
                //Guardar/Editar Registro
                url: "include/funciones.php",
                type: "post",
                data: $("#formulario").serialize(),
                success: function (response) {
                //console.log(response);
                if ( response == "0" ) {
                    //Error: El alumno no existe
                    $( "<div>Error: La matrícula ingresada no existe en los registros de alumnos.</div>" ).dialog({
                        title:"Error",
                        resizable: false,
                        height: "auto",
                        width: 400,
                        modal: true,
                        buttons: {
                        "Entendido": function() {
                            $( this ).dialog( "close" );
                        }
                        }
                    });
                } else {
                    $( "<div>Accion Completada.</div>" ).dialog({
                    title:"Acción Completada",
                    resizable: false,
                    height: "auto",
                    width: 400,
                    modal: true,
                    buttons: {
                        "Entendido": function() {
                        $( this ).dialog( "close" );
                        document.location='xmlgeneral.xml';
                        }
                    }
                    });
                }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                }
                });
            }
    </script>
    <body class="fondo_main">
        <br/><br/>
        <h2 align="center" class="titulo">Registrar Estancia</h2>
        <form role="form" id="formulario" name="formulario" action="javascript:guardar();">
            <div class="container" style="margin-top:50px;">
            <div class="card">
                <h5 class="card-header d-flex justify-content-center">Datos de la estancia</h5>
                <div class="card-body">
                <div class="container" style="width:80rem; margin-top:20px; margin-bottom:20px;">
                    <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Matricula del alumno:</label>
                        <input type="number" name="matricula" id="matricula" class="form-control" required
                        <?php if (isset($_GET["id"])) { echo "value='".htmlspecialchars($estancia[0]->matricula, ENT_QUOTES)."' disabled"; }?>>
                        <input type="hidden" name="id" id="id" value="<?php echo (isset($_GET["id"])?htmlspecialchars($_GET["id"], ENT_QUOTES):"") ?>" />
                        <input type="hidden" name="acc" id="acc" value="<?php echo (isset($_GET["id"])?"2":"1") ?>" />
                        <input type="hidden" name="tipo" id="tipo" value="4" />
                    </div>
                    <div class="form-group col-md-7">
                        <label>Universidad destino:</label>
                        <input type="text" name="universidad" id="universidad" class="form-control" required
                        <?php if (isset($_GET["id"])) { echo "value='".htmlspecialchars($estancia[0]->universidad, ENT_QUOTES)."'"; }?>>
                    </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>País:</label>
                        <select name="pais" id="pais" class="form-control" required <?php if (isset($_GET["id"])) { echo "disabled"; }?>>
                            <option value="">Selecciona un país...</option>
                            <option value="México">México</option>
                            <option value="Estados Unidos">Estados Unidos</option>
                            <option value="Canadá">Canadá</option>
                            <option value="España">España</option>
                            <option value="Colombia">Colombia</option>
                        </select>
                    </div>
                    <div class="form-group col-md-7">
                        <label>Ciudad:</label>
                        <input type="text" name="ciudad" id="ciudad" class="form-control" required
                        <?php if (isset($_GET["id"])) { echo "value='".htmlspecialchars($estancia[0]->ciudad, ENT_QUOTES)."'"; }?>>
                    </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Investigador anfitrión:</label>
                        <input type="text" name="investigador" id="investigador" class="form-control" required
                        <?php if (isset($_GET["id"])) { echo "value='".htmlspecialchars($estancia[0]->investigador, ENT_QUOTES)."'"; }?>>
                    </div>
                    <div class="form-group col-md-7">
                        <label>Fecha de salida:</label>
                        <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" required
                        <?php if (isset($_GET["id"])) { echo "value='".htmlspecialchars($estancia[0]->fecha_salida, ENT_QUOTES)."'"; }?>>
                    </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Fecha de regreso:</label>
                        <input type="date" name="fecha_regreso" id="fecha_regreso" class="form-control" required
                        <?php if (isset($_GET["id"])) { echo "value='".htmlspecialchars($estancia[0]->fecha_regreso, ENT_QUOTES)."'"; }?>>
                    </div>
                                        <div class="form-group col-md-7">
                                                <label>Fuente de financiamiento:</label>
                                                <select name="financiamiento" id="financiamiento" class="form-control">
                                                    <option value="Recurso Propio" <?php if (isset($_GET["id"]) && (string)$estancia[0]->financiamiento === 'Recurso Propio') { echo 'selected'; } ?>>Recurso Propio</option>
                                                    <option value="Beca Mixta" <?php if (isset($_GET["id"]) && (string)$estancia[0]->financiamiento === 'Beca Mixta') { echo 'selected'; } ?>>Beca Mixta</option>
                                                    <option value="Proyecto VIEP" <?php if (isset($_GET["id"]) && (string)$estancia[0]->financiamiento === 'Proyecto VIEP') { echo 'selected'; } ?>>Proyecto VIEP</option>
                                                </select>
                                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Monto de apoyo:</label>
                        <input type="number" name="monto_apoyo" id="monto_apoyo" class="form-control" step="0.01"
                        <?php if (isset($_GET["id"])) { echo "value='".htmlspecialchars($estancia[0]->monto_apoyo, ENT_QUOTES)."'"; }?>>
                    </div>
                    </div>
                    <?php if (!isset($_GET["id"])): ?>
                    <div align="center" style="margin-bottom: 20px;">
                        <button type="submit" class="btn btn-primary boton_guardar" style="width:350px;">Guardar</button>
                    </div>
                    <?php else: ?>
                    <div align="center" style="margin-bottom: 20px;">
                        <button type="submit" class="btn btn-primary boton_editar" style="width:350px;">Editar</button>
                    </div>
                    <?php endif; ?>
                </div>
                </div>
            </div>
            </div>
        </form>
    </body>
</html>
