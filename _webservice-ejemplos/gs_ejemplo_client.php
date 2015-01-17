<?php

$options = array('login' => 'gobRE','password' => 'go2dk\'3dk?');
$clienteSOAP = new SoapClient('gabinete_social.wsdl',$options);
/*$clienteSOAP = new SoapClient(null, array('location' => "http://10.1.6.242/~gustavo/gabinete_social/index.php?controler=Server",
											'uri'=>'http://10.1.6.242/~gustavo/gabinete_social/'
											,'style' =>  SOAP_RPC
											,'use'      => SOAP_LITERAL
											,'compression'=> SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP |SOAP_COMPRESSION_DEFLATE
											));*/

echo '<!DOCTYPE html>
		<html>
		<head>
			<meta charset="UTF-8">
		</head>
		<body>';
try {
	$e = $clienteSOAP->getEjesTrabajo();
	print_r($e);
	/**
	* return:
	* stdClass Object
					(
						[item] => Array
							(
								[0] => stdClass Object
									(
										[etr_id] => 1
										[etr_nombre] => Infraestructura y habitat
										[etr_nro_orden] => 1
									)

								[1] => stdClass Object
									(
										[etr_id] => 2
										[etr_nombre] => Convivencia y participación
										[etr_nro_orden] => 2
									)

							)

					)	 
	*/

	/**
	* getLineasAccion( $etr_id );
	*/
	$e = $clienteSOAP->getLineasAccion($etr_id=1);
	print_r($e);
	/**
	* return:
	* >stdClass Object
					(
						[item] => Array
							(
								[0] => stdClass Object
									(
										[lac_id] => 1
										[lac_nombre] => Infraestructuras estrategicas
										[lac_nro_orden] => 1
									)

								[1] => stdClass Object
									(
										[lac_id] => 2
										[lac_nombre] => Mi Tierra, Mi Casa
										[lac_nro_orden] => 2
									)

								[2] => stdClass Object
									(
										[lac_id] => 3
										[lac_nombre] => Mejoramiento barrial en complejos de vivienda social
										[lac_nro_orden] => 3
									)

								[3] => stdClass Object
									(
										[lac_id] => 4
										[lac_nombre] => Proyectos urbanos en asentamientos irregulares
										[lac_nro_orden] => 4
									)

								[4] => stdClass Object
									(
										[lac_id] => 5
										[lac_nombre] => Saneamiento urbano
										[lac_nro_orden] => 5
									)

								[5] => stdClass Object
									(
										[lac_id] => 6
										[lac_nombre] => Luz y Agua Segura, para la inclusion social
										[lac_nro_orden] => 6
									)

							)

					)
	*/

	/**
	* getIntervenciones( $lac_id );
	*/
	$e = $clienteSOAP->getIntervenciones($lac_id=2);
	print_r($e);
	/**
	* return:
	* stdClass Object
					(
						[item] => stdClass Object
							(
								[int_id] => 11
								[int_nombre] => Mi Tierra, Mi Casa
								[int_nro_orden] => 1
							)

					)
	*/

	$e = $clienteSOAP->getLocalidades();
	print_r($e);
	/**
	* return:
	* stdClass Object
					(
						[item] => Array
							(
								[0] => stdClass Object
									(
										[loc_id] => 212
										[loc_nombre] => Rosario
										[loc_comu] => 863
									)

								[1] => stdClass Object
									(
										[loc_id] => 150
										[loc_nombre] => Santa Fe
										[loc_comu] => 792
									)

								[2] => stdClass Object
									(
										[loc_id] => 151
										[loc_nombre] => Santo Tome
										[loc_comu] => 793
									)

								[3] => stdClass Object
									(
										[loc_id] => 213
										[loc_nombre] => Villa Gobernador Galvez
										[loc_comu] => 864
									)

							)

					) 
	*/

	/**
	* getBarrios( $loc_id )
	*/
	$e = $clienteSOAP->getBarrios($loc_id=151);
	print_r($e);
	/**
	* return:
	* stdClass Object
					(
						[item] => Array
							(
								[0] => stdClass Object
									(
										[bar_id] => 34
										[bar_nombre] => SANTO TOMAS DE AQUINO
										[bar_nro] => 1
									)

								[1] => stdClass Object
									(
										[bar_id] => 35
										[bar_nombre] => Villa LIBERTAD
										[bar_nro] => 2
									)

								[2] => stdClass Object
									(
										[bar_id] => 36
										[bar_nombre] => EL CHAPARRAL
										[bar_nro] => 3
									)

								[3] => stdClass Object
									(
										[bar_id] => 37
										[bar_nombre] => LOS HORNOS
										[bar_nro] => 4
									)

								[4] => stdClass Object
									(
										[bar_id] => 38
										[bar_nombre] => LAS VEGAS
										[bar_nro] => 5
									)

								[5] => stdClass Object
									(
										[bar_id] => 39
										[bar_nombre] => 12 DE SEPTIEMBRE
										[bar_nro] => 6
									)

								[6] => stdClass Object
									(
										[bar_id] => 40
										[bar_nombre] => LAS ADELINAS
										[bar_nro] => 6
									)

							)

					)
	*/

	/**
	* getDistritos( $loc_id )
	*/
	$e = $clienteSOAP->getDistritos($loc_id = 151);
	print_r($e);
	/**
	* return:
	* stdClass Object
					(
						[item] => Array
							(
								[0] => stdClass Object
									(
										[dis_id] => 16
										[dis_nombre] => NORTE
										[dis_nro] => 1
									)

								[1] => stdClass Object
									(
										[dis_id] => 17
										[dis_nombre] => NOROESTE
										[dis_nro] => 2
									)

								[2] => stdClass Object
									(
										[dis_id] => 18
										[dis_nombre] => NORESTE
										[dis_nro] => 3
									)

								[3] => stdClass Object
									(
										[dis_id] => 19
										[dis_nombre] => OESTE
										[dis_nro] => 4
									)

								[4] => stdClass Object
									(
										[dis_id] => 20
										[dis_nombre] => ESTE
										[dis_nro] => 5
									)

								[5] => stdClass Object
									(
										[dis_id] => 21
										[dis_nombre] => SUR
										[dis_nro] => 6
									)

							)

					)
	*/

	/** getProyectos( 	'loc_id' => $loc_id		// campo obligatorio
						array(
							[,'etr_id' => $etr_id]  // campo opcional
							[,'lac_id' => $lac_id]  // campo opcional
							[,'int_id' => $int_id]  // campo opcional
							[,'dis_id' => $dis_id]  // campo opcional
							[,'bar_id' => $bar_id]  // campo opcional
						) 
					)
	*/
	$e = $clienteSOAP->getProyectos($loc_id=151,array('etr_id'=>1));
	var_dump($e);
	/**
	* return:
	* object(stdClass)#2 (1) {
							["item"]=>
								array(2) {
									[0]=>
									object(stdClass)#3 (10) {
									["pro_id"]=>
									int(151)
									["pro_nombre"]=>
									string(9) "Prueba ST"
									["pro_nro_orden"]=>
									int(4)
									["pro_observacion"]=>
									string(0) ""
									["pro_fecha"]=>
									object(stdClass)#4 (3) {
										["date"]=>
										string(19) "2014-10-03 10:17:03"
										["timezone_type"]=>
										int(3)
										["timezone"]=>
										string(30) "America/Argentina/Buenos_Aires"
									}
									["ejes_trabajo"]=>
									object(stdClass)#5 (3) {
										["etr_id"]=>
										int(1)
										["etr_nombre"]=>
										string(25) "Infraestructura y habitat"
										["etr_nro_orden"]=>
										int(1)
									}
									["linea_accion"]=>
									object(stdClass)#6 (3) {
										["lac_id"]=>
										int(1)
										["lac_nombre"]=>
										string(29) "Infraestructuras estrategicas"
										["lac_nro_orden"]=>
										int(1)
									}
									["intervencion"]=>
									object(stdClass)#7 (3) {
										["int_id"]=>
										int(1)
										["int_nombre"]=>
										string(20) "Infraestructura Vial"
										["int_nro_orden"]=>
										int(1)
									}
									["dato_geografico"]=>
									object(stdClass)#8 (3) {
										["pge_descripcion"]=>
										string(0) ""
										["pge_geo_id"]=>
										int(18)
										["pge_geo_char"]=>
										string(15) "18_comisaria_33"
									}
									["detalles"]=>
									object(stdClass)#9 (1) {
										["item"]=>
										object(stdClass)#10 (8) {
										["pde_id"]=>
										int(192)
										["pde_nombre"]=>
										string(13) "prueba det st"
										["pde_nro_orden"]=>
										string(1) "1"
										["pde_fecha"]=>
										object(stdClass)#11 (3) {
											["date"]=>
											string(19) "2014-10-03 10:17:36"
											["timezone_type"]=>
											int(3)
											["timezone"]=>
											string(30) "America/Argentina/Buenos_Aires"
										}
										["pde_monto_inversion"]=>
										string(8) "43400.00"
										["pde_plazo_desde"]=>
										object(stdClass)#12 (3) {
											["date"]=>
											string(19) "2014-10-01 00:00:00"
											["timezone_type"]=>
											int(3)
											["timezone"]=>
											string(30) "America/Argentina/Buenos_Aires"
										}
										["pde_plazo_hasta"]=>
										object(stdClass)#13 (3) {
											["date"]=>
											string(19) "2014-10-31 00:00:00"
											["timezone_type"]=>
											int(3)
											["timezone"]=>
											string(30) "America/Argentina/Buenos_Aires"
										}
										["estado"]=>
										object(stdClass)#14 (2) {
											["pes_id"]=>
											int(1)
											["pes_nombre"]=>
											string(41) "En ejecución de acuerdo a lo planificado"
										}
										}
									}
									}
									[1]=>
									object(stdClass)#15 (8) {
									["pro_id"]=>
									int(152)
									["pro_nombre"]=>
									string(23) "prueba sin intervencion"
									["pro_nro_orden"]=>
									int(3)
									["pro_observacion"]=>
									string(10) "una prueba"
									["pro_fecha"]=>
									object(stdClass)#16 (3) {
										["date"]=>
										string(19) "2014-10-29 08:03:40"
										["timezone_type"]=>
										int(3)
										["timezone"]=>
										string(30) "America/Argentina/Buenos_Aires"
									}
									["ejes_trabajo"]=>
									object(stdClass)#17 (3) {
										["etr_id"]=>
										int(1)
										["etr_nombre"]=>
										string(25) "Infraestructura y habitat"
										["etr_nro_orden"]=>
										int(1)
									}
									["linea_accion"]=>
									object(stdClass)#18 (3) {
										["lac_id"]=>
										int(2)
										["lac_nombre"]=>
										string(18) "Mi Tierra, Mi Casa"
										["lac_nro_orden"]=>
										int(2)
									}
									["detalles"]=>
									object(stdClass)#19 (1) {
										["item"]=>
										object(stdClass)#20 (8) {
										["pde_id"]=>
										int(196)
										["pde_nombre"]=>
										string(23) "prueba sin intervencion"
										["pde_nro_orden"]=>
										string(1) "1"
										["pde_fecha"]=>
										object(stdClass)#21 (3) {
											["date"]=>
											string(19) "2014-10-29 08:04:02"
											["timezone_type"]=>
											int(3)
											["timezone"]=>
											string(30) "America/Argentina/Buenos_Aires"
										}
										["pde_monto_inversion"]=>
										string(4) "0.00"
										["pde_plazo_desde"]=>
										object(stdClass)#22 (3) {
											["date"]=>
											string(19) "2014-10-01 00:00:00"
											["timezone_type"]=>
											int(3)
											["timezone"]=>
											string(30) "America/Argentina/Buenos_Aires"
										}
										["pde_plazo_hasta"]=>
										object(stdClass)#23 (3) {
											["date"]=>
											string(19) "2014-10-31 00:00:00"
											["timezone_type"]=>
											int(3)
											["timezone"]=>
											string(30) "America/Argentina/Buenos_Aires"
										}
										["estado"]=>
										object(stdClass)#24 (2) {
											["pes_id"]=>
											int(1)
											["pes_nombre"]=>
											string(41) "En ejecución de acuerdo a lo planificado"
										}
										}
									}
									}
							}
	*/

} catch (Exception $e) {
	echo $e->getMessage();
	echo "\nDumping request:\n".$clienteSOAP->__getLastRequest();
}
echo '</body></html>';
