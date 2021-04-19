<?php
$servername = "localhost";
$username = "root";
$password = "greencore";
$conn = new mysqli($servername, $username, $password);
mysqli_query($conn, "ALTER TABLE basededatos.unidades_descriptivas_h2 RENAME COLUMN `Descrip. Onomasticos` TO DescripOnomasticos;");
mysqli_query($conn, "ALTER TABLE basededatos.unidades_descriptivas_h2 RENAME COLUMN `Descrip. Asuntos` TO DescripAsuntos;");
mysqli_query($conn, "ALTER TABLE basededatos.unidades_descriptivas_h2 RENAME COLUMN `Descrip. Geograficos` TO DescripGeograficos;");
$result = mysqli_query($conn, "SELECT * from basedetdatos.unidades_descriptivas_h2");
sqlToXml($result);

function sqlToXml($queryResult){
	
	$CSVData = "Id_Registro,Titulo,Nombre_Productor_1,Nombre_Productor_2,Codigo,Signatura_Inicial,Signatura_Final,Tomo_Folio,Folio,Escritura,Fecha_Extrema_1,Fecha_Extrema_2,Fechas_Adicionales,Alcance_Contenido,Soporte,Cantidad_Tipo,Formato,Tamano,Dimensiones,Escala,Resolucion,Escala_Color,         Modo_Color,Disposicion,Velocidad,Duracion,Notas,Notas_Archivero,Nivel_Descripcion,Volumen,Forma_Ingreso,Originales_Copias,Acceso,Reproduccion,serie,Seccion,Caja,caracteristicas_fisicas,Fecha_Descripcion,Responsable,Lengua,Migracion_Soporte,Mfn,Formato_Ingreso,Existencia_Localizacion,Enlace,Signatura_Ultima,Signatura_Negativo,Album_Positivo,Fotografo,Ruta_Visual,Ruta_Impresa,Imagen_Inicial,Imagen_Asociada_1,Imagen_Asociada_2,Tipo_Ingreso,Fondo_Ingreso,Fotometrica,Simbologia,Genero_Instrumental,Arreglista,Fondo_Coleccion,DescripGeograficos,DescripOnomasticos,DescripAsuntos,Lugar,DescripInstOrgan,TituloTransferencia,Siglas,Folios\n";
	$CSVData2 = "Id_Registro,Titulo,Nombre_Productor_1,Nombre_Productor_2,Codigo,Signatura_Inicial,Signatura_Final,Tomo_Folio,Folio,Escritura,Fecha_Extrema_1,Fecha_Extrema_2,Fechas_Adicionales,Alcance_Contenido,Soporte,Cantidad_Tipo,Formato,Tamano,Dimensiones,Escala,Resolucion,Escala_Color, 	Modo_Color,Disposicion,Velocidad,Duracion,Notas,Notas_Archivero,Nivel_Descripcion,Volumen,Forma_Ingreso,Originales_Copias,Acceso,Reproduccion,serie,Seccion,Caja,caracteristicas_fisicas,Fecha_Descripcion,Responsable,Lengua,Migracion_Soporte,Mfn,Formato_Ingreso,Existencia_Localizacion,Enlace,Signatura_Ultima,Signatura_Negativo,Album_Positivo,Fotografo,Ruta_Visual,Ruta_Impresa,Imagen_Inicial,Imagen_Asociada_1,Imagen_Asociada_2,Tipo_Ingreso,Fondo_Ingreso,Fotometrica,Simbologia,Genero_Instrumental,Arreglista,Fondo_Coleccion,DescripGeograficos,DescripOnomasticos,DescripAsuntos,Lugar,DescripInstOrgan,TituloTransferencia,Siglas,Folios\n";
	$archivos = 0;
	while($record = mysqli_fetch_object($queryResult)){ 

			$xmlData = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n"; 
			$xmlData .= "<!DOCTYPE ead PUBLIC \"+//ISBN 1-931666-00-8//DTD ead.dtd (Encoded Archival Description (EAD) Version 2002)//EN\" \"http://lcweb2.loc.gov/xmlcommon/dtds/ead2002/ead.dtd\">\n";
			$xmlData .= "<ead>\n";
			$xmlData .= "<eadheader langencoding=\"iso639-2b\" countryencoding=\"iso3166-1\" dateencoding=\"iso8601\" repositoryencoding=\"iso15511\" scriptencoding=\"iso15924\" relatedencoding=\"DC\">\n";
			$xmlData .= "<eadid></eadid>\n";
			$xmlData .= "<filedesc>\n";
			$xmlData .= "<titlestmt>\n";
			$xmlData .= "<titleproper></titleproper>\n";
			$xmlData .= "</titlestmt>\n";
			$xmlData .= "<publicationstmt>\n";
			$xmlData .= "<publisher></publisher>\n";
			$xmlData .= "<address>\n";
			$xmlData .= "<addressline></addressline>\n";
			$xmlData .= "</address>\n";
			$xmlData .= "<date></date>\n";
			$xmlData .= "</publicationstmt>\n";
			$xmlData .= "</filedesc>\n";
			$xmlData .= "<profiledesc></profiledesc>\n";
			$xmlData .= "</eadheader>\n";
			$xmlData .= "<archdesc level=\"item\" relatedencoding=\"ISAD(G)v2\">\n";
			$xmlData .= "<did>\n";

			//Titulo
			$invalid3 = "";
			$titu = $record->Titulo;
			$titu = str_replace('&', '&amp;', $titu); 
			if(!empty($titu) && !ctype_space($titu))
				$xmlData .= "<unittitle encodinganalog=\"3.1.2\">$titu</unittitle>\n";
			else{
				$xmlData .= "<unittitle encodinganalog=\"3.1.2\"></unittitle>\n";
				$invalid3 = "fallo";
			}

			//Identificador
			$identificador = "";      
			if(!empty($record->Codigo) && $record->Codigo!="NULL")
				$identificador .= "$record->Codigo";				
			else
				$identificador .= "";
                        if(!empty($record->Signatura_Inicial))
				$identificador .= "-$record->Signatura_Inicial"; 
			else
				$identificador .= "";
                        if(!empty($record->Signatura_Final))
				$identificador .= "-$record->Signatura_Final";
			else
				$identificador .= "";
                        if(!empty($record->Tomo_Folio))
				$identificador .= "-$record->Tomo_Folio";
                        else
				$identificador .= "";
                        if(!empty($record->Folio))
				$identificador .= "-$record->Folio";
                        else
				$identificador .= "";
                        if(!empty($record->Escritura))
				$identificador .= "-$record->Escritura";
                        else
				$identificador .= "";	
			
			$xmlData .= "<unitid encodinganalog=\"3.1.1\" countrycode=\"CR\" repositorycode=\"AN\">$identificador</unitid>\n";
			$identificador = "";
			$fecha1 = "";
			$fecha2 = "";

			//Fecha Inicio / Fin
			$fechas = "";
			$invalid1 = "";
			$invalid2 = "";
			$date_regex = '/^(\d)\d\d\d[\-\/.](\d\d)[\-\/.](\d\d)$/';
			$date_regex2 = '/^(\d)\d\d\d[\-\/.](\d\d)$/';
			$date_regex3 = '/^(\d)\d\d\d$/';
			$date_regex4 = '/^(\d\d)[\-\/.](\d\d)[\-\/.](\d)\d\d\d$/';
			$date_regex5 = '/^(\d\d)[\-\/.](\d)\d\d\d$/';

			$fecha1 = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','',trim($record->Fecha_Extrema_1));
			$fecha2 = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','',trim($record->Fecha_Extrema_2));
			$fecha1 = str_replace('/', '-', $fecha1);
			$fecha2 = str_replace('/', '-', $fecha2); 
			if(!empty($fecha1)) {
				if (preg_match($date_regex, $fecha1) || preg_match($date_regex2, $fecha1) || preg_match($date_regex3, $fecha1) || preg_match($date_regex4, $fecha1) || preg_match($date_regex5, $fecha1)) {
					$fechas .= "$fecha1/";
				}else {
					$invalid1 = "fallo";	
				}
			}else{
				$fechas .= "/";
			}

			if(!empty($fecha2)) {
				if (preg_match($date_regex, $fecha2) || preg_match($date_regex2, $fecha2) || preg_match($date_regex3, $fecha2) || preg_match($date_regex4, $fecha2) || preg_match($date_regex5, $fecha2)) {
					$fechas .= "$fecha2";
				}else{
	                                $invalid2 = "fallo";

				}
			}else{
				$fechas .= "";
			}	
			$xmlData .= "<unitdate normal=\"$fechas\" encodinganalog=\"3.1.3\"></unitdate>\n";
                        $fechas = "";

			//Volumen y Soporte
			$volumen_soporte = "";			
			if(!empty($record->Soporte))
                                $volumen_soporte .= "$record->Soporte";
                        else
                                $volumen_soporte .= "";
		    	if(!empty($record->Cantidad_Tipo) && !empty($record->Soporte)){
				$volumen_soporte .= " - $record->Cantidad_Tipo";
			}elseif(!empty($record->Cantidad_Tipo) && empty($record->Soporte)){
				$volumen_soporte .= "$record->Cantidad_Tipo";
			}else
				$volumen_soporte .= "";
			if(!empty($record->Volumen) && !empty($record->Soporte) || !empty($record->Cantidad_Tipo)){
				$volumen_soporte .= " - $record->Volumen";
			}elseif(!empty($record->Volumen) && empty($record->Soporte) && empty($record->Cantidad_Tipo)){
                                $volumen_soporte .= "$record->Volumen";
			}else
				$volumen_soporte .= "";

			$xmlData .= "<physdesc encodinganalog=\"3.1.5\">$volumen_soporte</physdesc>\n";
			$volumen_soporte = "";

			//Repositorio AN
			$xmlData .= "<repository>\n";
			$xmlData .= "<corpname>Archivo Nacional</corpname>\n";
			$xmlData .= "<address>\n";
			$xmlData .= "<addressline>Costa Rica 506 Telephone: 2283-14-00 https://www.archivonacional.go.cr</addressline>\n";
			$xmlData .= "<addressline>Costa Rica</addressline>\n";
			$xmlData .= "<addressline>506</addressline>\n";
			$xmlData .= "<addressline>Telephone: 2283-14-00</addressline>\n";
			$xmlData .= "<addressline>https://www.archivonacional.go.cr</addressline>\n";
			$xmlData .= "</address>\n";
			$xmlData .= "</repository>\n";
			
			
			//Notas Generales	
			if(!empty($record->Formato) && $record->Formato != "NULL" && !ctype_space($record->Formato)){
				$xmlData .= "<note type=\"generalNote\">\n";
	                        $xmlData .= "<p>Formato: $record->Formato</p>\n";
				$xmlData .= "</note>\n";
			}
                        if(!empty($record->Tamano) && $record->Tamano != "NULL" && !ctype_space($record->Tamano)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Tamaño: $record->Tamano</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Dimensiones) && $record->Dimensiones != "NULL" && !ctype_space($record->Dimensiones)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Dimensiones: $record->Dimensiones</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Escala) && $record->Escala != "NULL" && !ctype_space($record->Escala)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Escala: $record->Escala</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Resolucion) && $record->Resolucion != "NULL" && !ctype_space($record->Resolucion)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Resolución: $record->Resolucion</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Escala_Color) && $record->Escala_Color != "NULL" && !ctype_space($record->Escala_Color)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Escala-Color: $record->Escala_Color</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Modo_Color) && $record->Modo_Color != "NULL" && !ctype_space($record->Modo_Color)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Modo-Color: $record->Modo_Color</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Disposicion) && $record->Disposicion != "NULL" && !ctype_space($record->Disposicion)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Disposición: $record->Disposicion</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Velocidad) && $record->Velocidad != "NULL" && !ctype_space($record->Velocidad)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Velocidad: $record->Velocidad</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Duracion) && $record->Duracion != "NULL" && !ctype_space($record->Duracion)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Duración: $record->Duracion</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Notas) && $record->Notas != "NULL" && !ctype_space($record->Notas)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Notas: $record->Notas</p>\n";
                                $xmlData .= "</note>\n";
			}
			if(!empty($record->Fotografo) && $record->Fotografo != "NULL" && !ctype_space($record->Fotografo)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Fotógrafo: $record->Fotografo</p>\n";
                                $xmlData .= "</note>\n";
                        }
                        if(!empty($record->Fotometrica) && $record->Fotometrica != "NULL" && !ctype_space($record->Fotometrica)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Fotométrica: $record->Fotometrica</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Simbologia) && $record->Simbologia != "NULL" && !ctype_space($record->Simbologia)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Simbología: $record->Simbologia</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Genero_Instrumental) && $record->Genero_Instrumental != "NULL" && !ctype_space($record->Genero_Instrumental)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Genero Instrumental: $record->Genero_Instrumental</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Arreglista) && $record->Arreglista != "NULL" && !ctype_space($record->Arreglista)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Arreglista: $record->Arreglista</p>\n";
                                $xmlData .= "</note>\n";
			}
                        if(!empty($record->Folios) && $record->Folios != "NULL" && !ctype_space($record->Folios)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Folios: $record->Folios</p>\n";
                                $xmlData .= "</note>\n";
                        }
                        if(!empty($record->Fechas_Adicionales) && $record->Fechas_Adicionales != "NULL" && !ctype_space($record->Fechas_Adicionales)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Fechas Adicionales: $record->Fechas_Adicionales</p>\n";
                                $xmlData .= "</note>\n";
                        }
                        if(!empty($record->Lengua) && $record->Lengua != "NULL" && !ctype_space($record->Lengua)){
                                $xmlData .= "<note type=\"generalNote\">\n";
                                $xmlData .= "<p>Lengua: $record->Lengua</p>\n";
                                $xmlData .= "</note>\n";
                        }
			
			//Nombre de los creadores
			$xmlData .= "<origination encodinganalog=\"3.2.1\">\n";
			if(!empty($record->Nombre_Productor_1))
				$xmlData .= "<persname>$record->Nombre_Productor_1</persname>\n";
			else
				$xmlData .= "\n";
			if(!empty($record->Nombre_Productor_2))
                                $xmlData .= "<persname>$record->Nombre_Productor_2</persname>\n";
                        else
                                $xmlData .= "\n";
			$xmlData .= "</origination>\n";
			$xmlData .= "</did>\n";

			//Estado de Publicacion
			$xmlData .= "<odd type=\"publicationStatus\">\n";
			$xmlData .= "<p>Published</p>\n";
			$xmlData .= "</odd>\n";

			//Alcance y Contenido
			$alcance = $record->Alcance_Contenido;
			$alcance = str_replace('&', '&amp;', $alcance); 
                        if(!empty($alcance) || strlen($titu) > 800){
				if(!empty($alcance) && strlen($titu) < 800){
					$xmlData .= "<scopecontent encodinganalog=\"3.3.1\"><p>$alcance</p></scopecontent>\n";
				}
				if(!empty($alcance) && strlen($titu) > 800){
					$xmlData .= "<scopecontent encodinganalog=\"3.3.1\"><p>$alcance;&#xA;Título: $titu</p></scopecontent>\n";
				}
				if(empty($alcance) && strlen($titu) > 800){
					$xmlData .= "<scopecontent encodinganalog=\"3.3.1\"><p>Título: $titu</p></scopecontent>\n";
				}
			}else
                                $xmlData .= "\n";

			//Control de Acceso
			if(!empty($record->DescripGeograficos) || $record->DescripOnomasticos || $record->DescripAsuntos || $record->Lugar){
				$xmlData .= "<controlaccess>\n";
				if(!empty($record->DescripGeograficos) && $record->DescripGeograficos != "#¿NOMBRE?")
                                        $xmlData .= "<geogname>$record->DescripGeograficos</geogname>\n";
                                else
					$xmlData .= "";	
                                if(!empty($record->Lugar))
                                        $xmlData .= "<geogname>$record->Lugar</geogname>\n";
                                else
					$xmlData .= "";		
                                if(!empty($record->DescripOnomasticos) && $record->DescripOnomasticos != "#¿NOMBRE?")
                                        $xmlData .= "<name role=\"subject\">$record->DescripOnomasticos</name>\n";
                                else
                                        $xmlData .= "";	
                                if(!empty($record->DescripAsuntos))
                                        $xmlData .= "<subject>$record->DescripAsuntos</subject>\n";
                                else
					$xmlData .= "";

				$xmlData .= "</controlaccess>\n";
			
			}else
				$xmlData .= "\n";

			//Características físicas y requisitos técnicos
			$caracteristicas_requisitos = "";
                        if(!empty($record->caracteristicas_fisicas))
                                $caracteristicas_requisitos .= "$record->caracteristicas_fisicas";
                        else
                                $caracteristicas_requisitos .= "";
                        if(!empty($record->Migracion_Soporte) && !empty($record->caracteristicas_fisicas)){
                                $caracteristicas_requisitos .= "; $record->Migracion_Soporte";
                        }elseif(!empty($record->Migracion_Soporte) && empty($record->caracteristicas_fisicas)){
                                $caracteristicas_requisitos .= "$record->Migracion_Soporte";
                        }else
                                $caracteristicas_requisitos .= "";


                        if($caracteristicas_requisitos != ""){
                        $xmlData .= "<phystech encodinganalog=\"3.4.3\"><p>$caracteristicas_requisitos</p></phystech>\n";
                        $caracteristicas_requisitos = "";
                        }
	
			//Origen del ingreso o transferencia
      			$origen_ingreso_transfer = "";
                        if(!empty($record->Forma_Ingreso))
                                $origen_ingreso_transfer .= "$record->Forma_Ingreso";
                        else
                                $origen_ingreso_transfer .= "";
                        if(!empty($record->Tipo_Ingreso) && !empty($record->Forma_Ingreso)){
                                $origen_ingreso_transfer .= " - $record->Tipo_Ingreso";
                        }elseif(!empty($record->Tipo_Ingreso) && empty($record->Forma_Ingreso)){
                                $origen_ingreso_transfer .= "$record->Tipo_Ingreso";
                        }else
                                $origen_ingreso_transfer .= "";


                        if($origen_ingreso_transfer != ""){
                        $xmlData .= "<acqinfo encodinganalog=\"3.2.4\"><p>$origen_ingreso_transfer</p></acqinfo>\n";
                        $origen_ingreso_transfer = "";
                        }

			//Notas del Archivero y Fechas de creación, revisión o eliminación		
			if(!empty($record->Notas_Archivero) || !empty($record->Fecha_Descripcion) || !empty($record->Responsable)){
				$xmlData .= "<processinfo>\n";
				if(!empty($record->Notas_Archivero))
					$xmlData .= "<p>$record->Notas_Archivero</p>\n";
				else
					$xmlData .= "";
				if(!empty($record->Fecha_Descripcion))
					$xmlData .= "<p><date>$record->Fecha_Descripcion</date></p>\n";
				else
					$xmlData .= "";
				if(!empty($record->Responsable))
                                        $xmlData .= "<p>$record->Responsable</p>\n";
                                else
					$xmlData .= "";

				$xmlData .= "</processinfo>\n";
			}
                        else
				$xmlData .= "\n";

			//Existencia y localización de originales
			if(!empty($record->Originales_Copias)) /*preguntar al cliente bien por este campo.*/
                                $xmlData .= "<originalsloc encodinganalog=\"3.5.1\"><p>$record->Originales_Copias</p></originalsloc>\n";
                        else
                                $xmlData .= "\n";

			//Condiciones de Acceso
			$condiciones_acceso = "";
                        if(!empty($record->Acceso))
                                $condiciones_acceso .= "$record->Acceso";
                        else
                                $condiciones_acceso .= "";
                        if(!empty($record->Reproduccion) && !empty($record->Acceso)){
                                $condiciones_acceso .= "; $record->Reproduccion";
                        }elseif(!empty($record->Reproduccion) && empty($record->Acceso)){
                                $condiciones_acceso .= "$record->Reproduccion";
                        }else
                                $condiciones_acceso .= "";


			if($condiciones_acceso != ""){
			$xmlData .= "<accessrestrict encodinganalog=\"3.4.1\"><p>$condiciones_acceso</p></accessrestrict>\n";
			$condiciones_acceso = "";
			}

			$xmlData .= "<dsc type=\"combined\"></dsc>\n";
			$xmlData .= "</archdesc>\n";
			$xmlData .= "</ead>";

		if($archivos <= 500000){
			if($invalid1 != "fallo" && $invalid2 != "fallo" && $invalid3 != "fallo"){
				$myfile = fopen('files1/file-'.$archivos.'.xml', 'w') or die('Unable to open file!');
				fwrite($myfile, $xmlData);
				fclose($myfile);
			}elseif($invalid3 == "fallo") {
				$CSVData2 .= "$record->Id_Registro,$record->Titulo,$record->Nombre_Productor_1,$record->Nombre_Productor_2,$record->Codigo,$record->Signatura_Inicial,$record->Signatura_Final,$record->Tomo_Folio,$record->Folio,$record->Escritura,$record->Fecha_Extrema_1,$record->Fecha_Extrema_2,$record->Fechas_Adicionales,$record->Alcance_Contenido,$record->Soporte,$record->Cantidad_Tipo,$record->Formato,$record->Tamano,$record->Dimensiones,$record->Escala,$record->Resolucion,$record->Escala_Color,$record->Modo_Color,$record->Disposicion,$record->Velocidad,$record->Duracion,$record->Notas,$record->Notas_Archivero,$record->Nivel_Descripcion,$record->Volumen,$record->Forma_Ingreso,$record->Originales_Copias,$record->Acceso,$record->Reproduccion,$record->serie,$record->Seccion,$record->Caja,$record->caracteristicas_fisicas,$record->Fecha_Descripcion,$record->Responsable,$record->Lengua,$record->Migracion_Soporte,$record->Mfn,$record->Formato_Ingreso,$record->Existencia_Localizacion,$record->Enlace,$record->Signatura_Ultima,$record->Signatura_Negativo,$record->Album_Positivo,$record->Fotografo,$record->Ruta_Visual,$record->Ruta_Impresa,$record->Imagen_Inicial,$record->Imagen_Asociada_1,$record->Imagen_Asociada_2,$record->Tipo_Ingreso,$record->Fondo_Ingreso,$record->Fotometrica,$record->Simbologia,$record->Genero_Instrumental,$record->Arreglista,$record->Fondo_Coleccion,$record->DescripGeograficos,$record->DescripOnomasticos,$record->DescripAsuntos,$record->Lugar,$record->DescripInstOrgan,$record->TituloTransferencia,$record->Siglas,$record->Folios\n";
				$invalid3 = "";
			}else{
				$CSVData .= "$record->Id_Registro,$record->Titulo,$record->Nombre_Productor_1,$record->Nombre_Productor_2,$record->Codigo,$record->Signatura_Inicial,$record->Signatura_Final,$record->Tomo_Folio,$record->Folio,$record->Escritura,$record->Fecha_Extrema_1,$record->Fecha_Extrema_2,$record->Fechas_Adicionales,$record->Alcance_Contenido,$record->Soporte,$record->Cantidad_Tipo,$record->Formato,$record->Tamano,$record->Dimensiones,$record->Escala,$record->Resolucion,$record->Escala_Color,$record->Modo_Color,$record->Disposicion,$record->Velocidad,$record->Duracion,$record->Notas,$record->Notas_Archivero,$record->Nivel_Descripcion,$record->Volumen,$record->Forma_Ingreso,$record->Originales_Copias,$record->Acceso,$record->Reproduccion,$record->serie,$record->Seccion,$record->Caja,$record->caracteristicas_fisicas,$record->Fecha_Descripcion,$record->Responsable,$record->Lengua,$record->Migracion_Soporte,$record->Mfn,$record->Formato_Ingreso,$record->Existencia_Localizacion,$record->Enlace,$record->Signatura_Ultima,$record->Signatura_Negativo,$record->Album_Positivo,$record->Fotografo,$record->Ruta_Visual,$record->Ruta_Impresa,$record->Imagen_Inicial,$record->Imagen_Asociada_1,$record->Imagen_Asociada_2,$record->Tipo_Ingreso,$record->Fondo_Ingreso,$record->Fotometrica,$record->Simbologia,$record->Genero_Instrumental,$record->Arreglista,$record->Fondo_Coleccion,$record->DescripGeograficos,$record->DescripOnomasticos,$record->DescripAsuntos,$record->Lugar,$record->DescripInstOrgan,$record->TituloTransferencia,$record->Siglas,$record->Folios\n";
				$invalid1 = "";
				$invalid2 = "";
			}
		}
                if($archivos <= 1000000 && $archivos >= 500001){
			if($invalid1 != "fallo" && $invalid2 != "fallo" && $invalid3 != "fallo"){
				$myfile = fopen('files2/file-'.$archivos.'.xml', 'w') or die('Unable to open file!');
                		fwrite($myfile, $xmlData);
                		fclose($myfile);
			}elseif($invalid3 == "fallo"){
				$CSVData2 .= "$record->Id_Registro,$record->Titulo,$record->Nombre_Productor_1,$record->Nombre_Productor_2,$record->Codigo,$record->Signatura_Inicial,$record->Signatura_Final,$record->Tomo_Folio,$record->Folio,$record->Escritura,$record->Fecha_Extrema_1,$record->Fecha_Extrema_2,$record->Fechas_Adicionales,$record->Alcance_Contenido,$record->Soporte,$record->Cantidad_Tipo,$record->Formato,$record->Tamano,$record->Dimensiones,$record->Escala,$record->Resolucion,$record->Escala_Color,$record->Modo_Color,$record->Disposicion,$record->Velocidad,$record->Duracion,$record->Notas,$record->Notas_Archivero,$record->Nivel_Descripcion,$record->Volumen,$record->Forma_Ingreso,$record->Originales_Copias,$record->Acceso,$record->Reproduccion,$record->serie,$record->Seccion,$record->Caja,$record->caracteristicas_fisicas,$record->Fecha_Descripcion,$record->Responsable,$record->Lengua,$record->Migracion_Soporte,$record->Mfn,$record->Formato_Ingreso,$record->Existencia_Localizacion,$record->Enlace,$record->Signatura_Ultima,$record->Signatura_Negativo,$record->Album_Positivo,$record->Fotografo,$record->Ruta_Visual,$record->Ruta_Impresa,$record->Imagen_Inicial,$record->Imagen_Asociada_1,$record->Imagen_Asociada_2,$record->Tipo_Ingreso,$record->Fondo_Ingreso,$record->Fotometrica,$record->Simbologia,$record->Genero_Instrumental,$record->Arreglista,$record->Fondo_Coleccion,$record->DescripGeograficos,$record->DescripOnomasticos,$record->DescripAsuntos,$record->Lugar,$record->DescripInstOrgan,$record->TituloTransferencia,$record->Siglas,$record->Folios\n";
                                $invalid3 = "";
                        }else{
				$CSVData .= "$record->Id_Registro,$record->Titulo,$record->Nombre_Productor_1,$record->Nombre_Productor_2,$record->Codigo,$record->Signatura_Inicial,$record->Signatura_Final,$record->Tomo_Folio,$record->Folio,$record->Escritura,$record->Fecha_Extrema_1,$record->Fecha_Extrema_2,$record->Fechas_Adicionales,$record->Alcance_Contenido,$record->Soporte,$record->Cantidad_Tipo,$record->Formato,$record->Tamano,$record->Dimensiones,$record->Escala,$record->Resolucion,$record->Escala_Color,$record->Modo_Color,$record->Disposicion,$record->Velocidad,$record->Duracion,$record->Notas,$record->Notas_Archivero,$record->Nivel_Descripcion,$record->Volumen,$record->Forma_Ingreso,$record->Originales_Copias,$record->Acceso,$record->Reproduccion,$record->serie,$record->Seccion,$record->Caja,$record->caracteristicas_fisicas,$record->Fecha_Descripcion,$record->Responsable,$record->Lengua,$record->Migracion_Soporte,$record->Mfn,$record->Formato_Ingreso,$record->Existencia_Localizacion,$record->Enlace,$record->Signatura_Ultima,$record->Signatura_Negativo,$record->Album_Positivo,$record->Fotografo,$record->Ruta_Visual,$record->Ruta_Impresa,$record->Imagen_Inicial,$record->Imagen_Asociada_1,$record->Imagen_Asociada_2,$record->Tipo_Ingreso,$record->Fondo_Ingreso,$record->Fotometrica,$record->Simbologia,$record->Genero_Instrumental,$record->Arreglista,$record->Fondo_Coleccion,$record->DescripGeograficos,$record->DescripOnomasticos,$record->DescripAsuntos,$record->Lugar,$record->DescripInstOrgan,$record->TituloTransferencia,$record->Siglas,$record->Folios\n";
				$invalid1 = "";
                                $invalid2 = "";
			}
		}
		if($archivos <= 1500000 && $archivos >= 1000001){
			if($invalid1 != "fallo" && $invalid2 != "fallo" && $invalid3 != "fallo"){
                		$myfile = fopen('files3/file-'.$archivos.'.xml', 'w') or die('Unable to open file!');
                		fwrite($myfile, $xmlData);
				fclose($myfile);
			}elseif($invalid3 == "fallo"){
 	                        $CSVData2 .= "$record->Id_Registro,$record->Titulo,$record->Nombre_Productor_1,$record->Nombre_Productor_2,$record->Codigo,$record->Signatura_Inicial,$record->Signatura_Final,$record->Tomo_Folio,$record->Folio,$record->Escritura,$record->Fecha_Extrema_1,$record->Fecha_Extrema_2,$record->Fechas_Adicionales,$record->Alcance_Contenido,$record->Soporte,$record->Cantidad_Tipo,$record->Formato,$record->Tamano,$record->Dimensiones,$record->Escala,$record->Resolucion,$record->Escala_Color,$record->Modo_Color,$record->Disposicion,$record->Velocidad,$record->Duracion,$record->Notas,$record->Notas_Archivero,$record->Nivel_Descripcion,$record->Volumen,$record->Forma_Ingreso,$record->Originales_Copias,$record->Acceso,$record->Reproduccion,$record->serie,$record->Seccion,$record->Caja,$record->caracteristicas_fisicas,$record->Fecha_Descripcion,$record->Responsable,$record->Lengua,$record->Migracion_Soporte,$record->Mfn,$record->Formato_Ingreso,$record->Existencia_Localizacion,$record->Enlace,$record->Signatura_Ultima,$record->Signatura_Negativo,$record->Album_Positivo,$record->Fotografo,$record->Ruta_Visual,$record->Ruta_Impresa,$record->Imagen_Inicial,$record->Imagen_Asociada_1,$record->Imagen_Asociada_2,$record->Tipo_Ingreso,$record->Fondo_Ingreso,$record->Fotometrica,$record->Simbologia,$record->Genero_Instrumental,$record->Arreglista,$record->Fondo_Coleccion,$record->DescripGeograficos,$record->DescripOnomasticos,$record->DescripAsuntos,$record->Lugar,$record->DescripInstOrgan,$record->TituloTransferencia,$record->Siglas,$record->Folios\n";
                                $invalid3 = "";
			}else{
				$CSVData .= "$record->Id_Registro,$record->Titulo,$record->Nombre_Productor_1,$record->Nombre_Productor_2,$record->Codigo,$record->Signatura_Inicial,$record->Signatura_Final,$record->Tomo_Folio,$record->Folio,$record->Escritura,$record->Fecha_Extrema_1,$record->Fecha_Extrema_2,$record->Fechas_Adicionales,$record->Alcance_Contenido,$record->Soporte,$record->Cantidad_Tipo,$record->Formato,$record->Tamano,$record->Dimensiones,$record->Escala,$record->Resolucion,$record->Escala_Color,$record->Modo_Color,$record->Disposicion,$record->Velocidad,$record->Duracion,$record->Notas,$record->Notas_Archivero,$record->Nivel_Descripcion,$record->Volumen,$record->Forma_Ingreso,$record->Originales_Copias,$record->Acceso,$record->Reproduccion,$record->serie,$record->Seccion,$record->Caja,$record->caracteristicas_fisicas,$record->Fecha_Descripcion,$record->Responsable,$record->Lengua,$record->Migracion_Soporte,$record->Mfn,$record->Formato_Ingreso,$record->Existencia_Localizacion,$record->Enlace,$record->Signatura_Ultima,$record->Signatura_Negativo,$record->Album_Positivo,$record->Fotografo,$record->Ruta_Visual,$record->Ruta_Impresa,$record->Imagen_Inicial,$record->Imagen_Asociada_1,$record->Imagen_Asociada_2,$record->Tipo_Ingreso,$record->Fondo_Ingreso,$record->Fotometrica,$record->Simbologia,$record->Genero_Instrumental,$record->Arreglista,$record->Fondo_Coleccion,$record->DescripGeograficos,$record->DescripOnomasticos,$record->DescripAsuntos,$record->Lugar,$record->DescripInstOrgan,$record->TituloTransferencia,$record->Siglas,$record->Folios\n";
				$invalid1 = "";
                                $invalid2 = "";
                        }
		}
		if($archivos >= 1500001){
			if($invalid1 != "fallo" && $invalid2 != "fallo"  && $invalid3 != "fallo"){
				$myfile = fopen('files4/file-'.$archivos.'.xml', 'w') or die('Unable to open file!');
                		fwrite($myfile, $xmlData);
				fclose($myfile);
			}elseif($invalid3 == "fallo"){
				$CSVData2 .= "$record->Id_Registro,$record->Titulo,$record->Nombre_Productor_1,$record->Nombre_Productor_2,$record->Codigo,$record->Signatura_Inicial,$record->Signatura_Final,$record->Tomo_Folio,$record->Folio,$record->Escritura,$record->Fecha_Extrema_1,$record->Fecha_Extrema_2,$record->Fechas_Adicionales,$record->Alcance_Contenido,$record->Soporte,$record->Cantidad_Tipo,$record->Formato,$record->Tamano,$record->Dimensiones,$record->Escala,$record->Resolucion,$record->Escala_Color,$record->Modo_Color,$record->Disposicion,$record->Velocidad,$record->Duracion,$record->Notas,$record->Notas_Archivero,$record->Nivel_Descripcion,$record->Volumen,$record->Forma_Ingreso,$record->Originales_Copias,$record->Acceso,$record->Reproduccion,$record->serie,$record->Seccion,$record->Caja,$record->caracteristicas_fisicas,$record->Fecha_Descripcion,$record->Responsable,$record->Lengua,$record->Migracion_Soporte,$record->Mfn,$record->Formato_Ingreso,$record->Existencia_Localizacion,$record->Enlace,$record->Signatura_Ultima,$record->Signatura_Negativo,$record->Album_Positivo,$record->Fotografo,$record->Ruta_Visual,$record->Ruta_Impresa,$record->Imagen_Inicial,$record->Imagen_Asociada_1,$record->Imagen_Asociada_2,$record->Tipo_Ingreso,$record->Fondo_Ingreso,$record->Fotometrica,$record->Simbologia,$record->Genero_Instrumental,$record->Arreglista,$record->Fondo_Coleccion,$record->DescripGeograficos,$record->DescripOnomasticos,$record->DescripAsuntos,$record->Lugar,$record->DescripInstOrgan,$record->TituloTransferencia,$record->Siglas,$record->Folios\n";
                                $invalid3 = "";
			}else{
				$CSVData .= "$record->Id_Registro,$record->Titulo,$record->Nombre_Productor_1,$record->Nombre_Productor_2,$record->Codigo,$record->Signatura_Inicial,$record->Signatura_Final,$record->Tomo_Folio,$record->Folio,$record->Escritura,$record->Fecha_Extrema_1,$record->Fecha_Extrema_2,$record->Fechas_Adicionales,$record->Alcance_Contenido,$record->Soporte,$record->Cantidad_Tipo,$record->Formato,$record->Tamano,$record->Dimensiones,$record->Escala,$record->Resolucion,$record->Escala_Color,$record->Modo_Color,$record->Disposicion,$record->Velocidad,$record->Duracion,$record->Notas,$record->Notas_Archivero,$record->Nivel_Descripcion,$record->Volumen,$record->Forma_Ingreso,$record->Originales_Copias,$record->Acceso,$record->Reproduccion,$record->serie,$record->Seccion,$record->Caja,$record->caracteristicas_fisicas,$record->Fecha_Descripcion,$record->Responsable,$record->Lengua,$record->Migracion_Soporte,$record->Mfn,$record->Formato_Ingreso,$record->Existencia_Localizacion,$record->Enlace,$record->Signatura_Ultima,$record->Signatura_Negativo,$record->Album_Positivo,$record->Fotografo,$record->Ruta_Visual,$record->Ruta_Impresa,$record->Imagen_Inicial,$record->Imagen_Asociada_1,$record->Imagen_Asociada_2,$record->Tipo_Ingreso,$record->Fondo_Ingreso,$record->Fotometrica,$record->Simbologia,$record->Genero_Instrumental,$record->Arreglista,$record->Fondo_Coleccion,$record->DescripGeograficos,$record->DescripOnomasticos,$record->DescripAsuntos,$record->Lugar,$record->DescripInstOrgan,$record->TituloTransferencia,$record->Siglas,$record->Folios\n";
				$invalid1 = "";
                                $invalid2 = "";
			}		
		}
		$archivos++;
	}
	$myfile2 = fopen('invalidos/date-error.csv', 'w') or die('Unable to open file!');
        fwrite($myfile2, $CSVData);
	fclose($myfile2);

	$myfile3 = fopen('invalidos-titulo/titulo-error.csv', 'w') or die('Unable to open file!');
        fwrite($myfile3, $CSVData2);
        fclose($myfile3);


return $xmlData; 
}
?> 
