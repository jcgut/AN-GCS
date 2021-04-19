<?php
$servername = "localhost";
$username = "greencore";
$password = "greencore";
$conn = new mysqli($servername, $username, $password);
$result = mysqli_query($conn, "SELECT * from isad_g_clean.unidades_descriptivas_h2 where Codigo='CR-AN-AH-PREP-DPRES-EXPFTG'");
sqlToCSV($result);


function sqlToCSV($queryResult){
        $CSVData = "identifier,filename\n";
        while($record = mysqli_fetch_object($queryResult)){
			
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


			if(!empty($record->Signatura_Inicial) && empty($record->Signatura_Final)){
				foreach(glob("/home/adminatom/FedericoTinocoGranados/$record->Signatura_Inicial/*.*") as $filename){
					if($filename != "/home/adminatom/FedericoTinocoGranados/$record->Signatura_Inicial/Thumbs.db")
					$CSVData .= "$identificador,$filename\n";
 				}
			}
                        elseif(!empty($record->Signatura_Inicial) && !empty($record->Signatura_Final)){
				$c = $record->Signatura_Inicial;
				$d = $record->Signatura_Final;
				$a = (int)$c;
				$b = (int)$d;
				for($i=$a; $i<=$b; $i++) {
					$num = str_pad($i,6,"0",STR_PAD_LEFT);
					foreach(glob("/home/adminatom/FedericoTinocoGranados/$num/*.*") as $filename){
                                        $CSVData .= "$identificador,$filename\n";
                               		}
				}


                        }else

                                $identificador .= "";

			$identificador = "";

		}	

                        $myfile = fopen('/home/adminatom/directorio-cargas-objetos-digitales/outputs/file-CR-AN-AH-PREP-DPRES-EXPFTG.csv', 'w') or die('Unable to open file!');
                        fwrite($myfile, $CSVData);
                        fclose($myfile);

}

