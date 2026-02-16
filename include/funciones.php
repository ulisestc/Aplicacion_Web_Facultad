<?php
switch ($_POST["acc"]) {
  case '1': #nuevo Registro del XML
    foreach($_POST as $nombre_campo => $valor) {
      eval("\$" . $nombre_campo . " = \$_POST[\"".$nombre_campo."\"];");
    }
    $xml = simplexml_load_file("../xmlgeneral.xml");
    switch ($tipo) {
      case 1:
        #Insertar Alumno
        $dato = $xml->xpath("/facultad/posgrado/maestria/areas/area[@clave='".$area."']/alumnos/alumno[matricula='".$matricula."']");
        if ( count($dato) > 0 ) {
          echo "0";
        } else {
          switch ( $area ) {
            case "BD": $areaIndice = 0; break;
            case "SD": $areaIndice = 1; break;
            case "ISI": $areaIndice = 2; break;
            case "CM": $areaIndice = 3; break;
          }
          $alumno = $xml->posgrado->maestria->areas->area[$areaIndice]->alumnos->addChild('alumno');
          $alumno->addChild('matricula', $matricula);
          $alumno->addChild('nombre', $nombre);
          $alumno->addChild('fecha_nac', $fecha_nac);
          $alumno->addChild('edad', $edad);
          $alumno->addChild('tutor', $tutor);
          $alumno->addChild('prom_actual', $promedio);
          $alumno->addChild('creditos', $creditos);
          $alumno->addChild('email', $correo);
          $alumno->addChild('telefono', $telefono);
          $alumno->addChild('genero', $genero);
          $alumno->addChild('no_cvu', $no_cvu);
          $alumno->addChild('curp', $curp);
          $alumno->addChild('rfc', $rfc);
          $grados_academicos = $alumno->addChild('grados_academicos');
          $grado = $grados_academicos->addChild('grado');
          $grado->addChild('titulo', $titulo);
          $grado->addChild('promedio', $promedio);
          $grado->addChild('escuela', $escuela);
          $materias_imp = $alumno->addChild('materias');
          foreach ($materias as $clave_mat) {
            $materia = $materias_imp->addChild('materia');
            $materia->addAttribute('clave_mat', $clave_mat);
          }
          echo $xml->asXML("../xmlgeneral.xml");
        }
        break;
      case 2:
        #Insertar Profesor
        $dato = $xml->xpath("/facultad/posgrado/maestria/personal/profesores/profesor[@id_profesor=".$id_profesor."]");
        if ( count($dato) > 0 ) { echo "0"; } else {
          $profesor = $xml->posgrado->maestria->personal->profesores->addChild('profesor');
          $profesor->addAttribute('id_profesor', $id_profesor);
          $profesor->addChild('nombre', $nombre);
          $profesor->addChild('ubicacion', $cubiculo);
          $profesor->addChild('correo_electronico', $correo);
          $publicaciones = $profesor->addChild('publicaciones');
          $publicacion = $publicaciones->addChild('publicacion');
          $publicacion->addChild('autores', $autores);
          $publicacion->addChild('titulo', $titulo_pub);
          $publicacion->addChild('anio', $anio);
          $materias_imp = $profesor->addChild('materias_imp');
          foreach ($materias as $clave_mat) {
            $materia = $materias_imp->addChild('materia');
            $materia->addAttribute('clave_mat', $clave_mat);
          }
          echo $xml->asXML("../xmlgeneral.xml");
        }
        break;
      case 3:
        #Insertar Materia
        $dato = $xml->xpath("/facultad/posgrado/maestria/materias/materia[clave_mat=".$clave_mat."]");
        if ( count($dato) > 0 ) { echo "0"; } else {
          $materia = $xml->posgrado->maestria->materias->addChild('materia');
          $materia->addAttribute('es', "MA");
          $materia->addChild('clave_mat', $clave_mat);
          $materia->addChild('nombre', $nombre);
          $materia->addChild('creditos', $creditos);
          $materia->addChild('horario', $horario);
          $materia->addChild('salon', $salon);
          $materia->addChild('periodo', $periodo);
          echo $xml->asXML("../xmlgeneral.xml");
        }
        break;
      case 4:
        #Insertar Estancia de Movilidad
        $existeAlumno = $xml->xpath("/facultad/posgrado/maestria/areas/area/alumnos/alumno[matricula='".$matricula."']");
        if ( count($existeAlumno) == 0 ) { echo "0"; } else {
          $estancias = $xml->xpath("/facultad/posgrado/maestria/movilidad/estancia");
          $nuevoID = count($estancias) + 1; 
          $estancia = $xml->posgrado->maestria->movilidad->addChild('estancia');
          $estancia->addAttribute('id', $nuevoID);
          $estancia->addChild('matricula', $matricula);
          $estancia->addChild('universidad', $universidad);
          $estancia->addChild('pais', $pais);
          $estancia->addChild('ciudad', $ciudad);
          $estancia->addChild('investigador', $investigador);
          $estancia->addChild('fecha_salida', $fecha_salida);
          $estancia->addChild('fecha_regreso', $fecha_regreso);
          $estancia->addChild('financiamiento', $financiamiento);
          $estancia->addChild('monto_apoyo', $monto_apoyo);
          echo $xml->asXML("../xmlgeneral.xml");
        }
        break;
    }
    break;

  case '2': #editar Registro del XML
    foreach($_POST as $nombre_campo => $valor) {
      eval("\$" . $nombre_campo . " = \$_POST[\"".$nombre_campo."\"];");
    }
    $xml = simplexml_load_file("../xmlgeneral.xml");
    switch ($tipo) {
      case 1:
        #Editar Estudiante
        $dato = $xml->xpath("/facultad/posgrado/maestria/areas/area/alumnos/alumno[matricula='".$id."']");
        unset($dato[0][0]);
        switch ( $area ) {
          case "BD": $areaIndice = 0; break;
          case "SD": $areaIndice = 1; break;
          case "ISI": $areaIndice = 2; break;
          case "CM": $areaIndice = 3; break;
        }
        $alumno = $xml->posgrado->maestria->areas->area[$areaIndice]->alumnos->addChild('alumno');
        $alumno->addChild('matricula', $id);
        $alumno->addChild('nombre', $nombre);
        $alumno->addChild('fecha_nac', $fecha_nac);
        $alumno->addChild('edad', $edad);
        $alumno->addChild('tutor', $tutor);
        $alumno->addChild('prom_actual', $promedio);
        $alumno->addChild('creditos', $creditos);
        $alumno->addChild('email', $correo);
        $alumno->addChild('telefono', $telefono);
        $alumno->addChild('genero', $genero);
        $alumno->addChild('no_cvu', $no_cvu);
        $alumno->addChild('curp', $curp);
        $alumno->addChild('rfc', $rfc);
        $grados_academicos = $alumno->addChild('grados_academicos');
        $grado = $grados_academicos->addChild('grado');
        $grado->addChild('titulo', $titulo);
        $grado->addChild('promedio', $promedio);
        $grado->addChild('escuela', $escuela);
        $materias_imp = $alumno->addChild('materias');
        foreach ($materias as $clave_mat) {
          $materia = $materias_imp->addChild('materia');
          $materia->addAttribute('clave_mat', $clave_mat);
        }
        echo $xml->asXML("../xmlgeneral.xml");
        break;
      case 2:
        #Editar Profesor
        $dato = $xml->xpath("/facultad/posgrado/maestria/personal/profesores/profesor[@id_profesor=".$id."]");
        unset($dato[0][0]);
        $profesor = $xml->posgrado->maestria->personal->profesores->addChild('profesor');
        $profesor->addAttribute('id_profesor', $id);
        $profesor->addChild('nombre', $nombre);
        $profesor->addChild('ubicacion', $cubiculo);
        $profesor->addChild('correo_electronico', $correo);
        $publicaciones = $profesor->addChild('publicaciones');
        $publicacion = $publicaciones->addChild('publicacion');
        $publicacion->addChild('autores', $autores);
        $publicacion->addChild('titulo', $titulo_pub);
        $publicacion->addChild('anio', $anio);
        $materias_imp = $profesor->addChild('materias_imp');
        foreach ($materias as $clave_mat) {
          $materia = $materias_imp->addChild('materia');
          $materia->addAttribute('clave_mat', $clave_mat);
        }
        echo $xml->asXML("../xmlgeneral.xml");
        break;
      case 3:
        #Editar Materia
        $dato = $xml->xpath("/facultad/posgrado/maestria/materias/materia[clave_mat=".$id."]");
        unset($dato[0][0]);
        $materia = $xml->posgrado->maestria->materias->addChild('materia');
        $materia->addAttribute('es', "MA");
        $materia->addChild('clave_mat', $id);
        $materia->addChild('nombre', $nombre);
        $materia->addChild('creditos', $creditos);
        $materia->addChild('horario', $horario);
        $materia->addChild('salon', $salon);
        $materia->addChild('periodo', $periodo);
        echo $xml->asXML("../xmlgeneral.xml");
        break;
      case 4:
        #Editar Movilidad
        $dato = $xml->xpath("/facultad/posgrado/maestria/movilidad/estancia[@id='".$id."']");
        if (count($dato) > 0) {
          unset($dato[0][0]);
        }
        $estancia = $xml->posgrado->maestria->movilidad->addChild('estancia');
        $estancia->addAttribute('id', $id);
        $estancia->addChild('matricula', $matricula);
        $estancia->addChild('universidad', $universidad);
        $estancia->addChild('pais', $pais);
        $estancia->addChild('ciudad', $ciudad);
        $estancia->addChild('investigador', $investigador);
        $estancia->addChild('fecha_salida', $fecha_salida);
        $estancia->addChild('fecha_regreso', $fecha_regreso);
        $estancia->addChild('financiamiento', $financiamiento);
        $estancia->addChild('monto_apoyo', $monto_apoyo);

        echo $xml->asXML("../xmlgeneral.xml");
        break;
    } // Fin switch tipo
    break; // Fin case '2'

  case '3': #eliminar Registro del XML
    $id=$_POST["id"];
    $tipo=$_POST["tipo"];
    $xml = simplexml_load_file("../xmlgeneral.xml");
    switch ($tipo) {
      case 1:
        $dato = $xml->xpath("/facultad/posgrado/maestria/areas/area/alumnos/alumno[matricula='".$id."']");
        unset($dato[0][0]);
        $xml->asXML("../xmlgeneral.xml");
        break;
      case 2:
        $dato = $xml->xpath("/facultad/posgrado/maestria/personal/profesores/profesor[@id_profesor=".$id."]");
        unset($dato[0][0]);
        $xml->asXML("../xmlgeneral.xml");
        break;
      case 3:
        $dato = $xml->xpath("/facultad/posgrado/maestria/materias/materia[clave_mat=".$id."]");
        unset($dato[0][0]);
        $dato = $xml->xpath("/facultad/posgrado/maestria/personal/profesores/profesor/materias_imp/materia[@clave_mat=".$id."]");
        for ($i=0; $i < count($dato); $i++) { unset($dato[$i][0]); }
        $dato = $xml->xpath("/facultad/posgrado/maestria/areas/area/alumnos/alumno/materias/materia[@clave_mat=".$id."]");
        for ($i=0; $i < count($dato); $i++) { unset($dato[$i][0]); }
        $xml->asXML("../xmlgeneral.xml");
        break;
      case 4:
        #Eliminar Estancia de Movilidad
        $dato = $xml->xpath("/facultad/posgrado/maestria/movilidad/estancia[@id='".$id."']");
        if (count($dato) > 0) {
          unset($dato[0][0]);
        }
        $xml->asXML("../xmlgeneral.xml");
        break;
    }
    break;
  default:
    break;
}
?>