<?php
class IMPRESIONES
{
	function ventas($archivo,$ciudad,$venta,$detalle,$impresora,$empresa,$guia="")
	{
		$IVA = $venta[VEN_ESTADO_DES];
		
		if($archivo == "notacreditoticketeraPROLI.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			
			printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
			printer_start_page($handle);
			$font = printer_create_font("Sans Serif", 11, 8, 300, false, false, false, 0);
			printer_select_font($handle, $font);
			$linea = 30;
			printer_draw_text($handle, $venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],500,$linea);
			$linea+=120;
			$ahora = $venta[VEN_FECHA];
			printer_draw_text($handle, $ahora, 120,$linea);
			printer_draw_text($handle, substr($venta[VEN_OBSERVACIONES], 0,26), 650,$linea);
			$linea+=20;
			printer_draw_text($handle, "$venta[CLI_NOMBRE]", 120,$linea);
			printer_draw_text($handle, "$venta[CLI_IDENTIFICACION]",750,$linea);
			$linea+=20;
			printer_draw_text($handle, "$venta[CLI_DIRECCION]", 150,$linea);
			printer_draw_text($handle, "$venta[CLI_TELEFONO]", 780,$linea);
			$linea+=20;
			printer_draw_text($handle, substr($venta[VEN_OBSERVACIONES],27), 250,$linea);			
			$linea+=30;
			$colCan = 60;
			$colDesc = 120;
			$colPVP = 750;
			$colTot = 850;
			for($i = 0; $i < count($detalle); $i++)
			{
				$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
			    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
			    $addDesc = (7 - strlen(number_format($detalle[$i][ITE_DESCRIPCION],2,'.',''))) * 10;
			    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),$colDesc + $addDesc,$linea);
			    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
			    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
			    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
			    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
			    $linea+=10;
			}
			$linea = 330;
			printer_draw_text($handle, "$IVA: ",800,$linea);
			$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),850 + $addTotales, $linea);
			$linea+=18;
			$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),850 + $addTotales, $linea);
			$linea+=18;
			printer_draw_text($handle, "$IVA %: ",800,$linea);
			$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),850 + $addTotales,$linea);
			$linea+=18;
			$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),850 + $addTotales,$linea);
			printer_end_page($handle);
			printer_end_doc($handle);
			printer_close($handle);
			return true;
		}
		
		if($archivo == "facturacionticketeraPROLI.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
			printer_start_page($handle);
			$font = printer_create_font("Sans Serif", 11, 8, 300, false, false, false, 0);
			printer_select_font($handle, $font);
			$linea = 5;
			printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],450,$linea);
			$linea+=90;
			$ahora = $venta[VEN_FECHA];
			printer_draw_text($handle, 'FECHA:        '.$ciudad.", ". $ahora."                      RUC: $venta[CLI_IDENTIFICACION]                 VENCE:     $venta[VEN_FECHAN]", 0,$linea);
			$linea+=10;
			printer_draw_text($handle, 'CLIENTE:      '. $venta[CLI_NOMBRE], 0,$linea);
			$linea+=10;
			if($venta[VDR_COMPLETO] == "Elejir un vendedor")
			{
				$venta[VDR_COMPLETO] = "";
			}
			printer_draw_text($handle, 'TELEFONO.:   '. $venta[CLI_TELEFONO]."                                              Distribuidor: $venta[VDR_COMPLETO]", 0,$linea);
			$linea+=10;
			printer_draw_text($handle, 'DIRECCION.:  '. $venta[CLI_DIRECCION], 0,$linea);
			$linea+=10;
			$colCan = 20;
			$colDesc = 70;
			$colPVP = 530;
			$colTot = 630;				
			printer_draw_text($handle, '_______________________________________________________________________________________', 0, $linea);
			$linea+=10;
			printer_draw_text($handle, 'Cant', 20, $linea);
			printer_draw_text($handle, 'Descripción', 70, $linea);
			printer_draw_text($handle, 'Precio', 530, $linea);
			printer_draw_text($handle, 'Subtotal', 630, $linea);
			$linea+=10;
			printer_draw_text($handle, '_______________________________________________________________________________________', 0, $linea);
			$linea+=10;
			for($i = 0; $i < count($detalle); $i++)
			{
				//$addCan = (3 - strlen($detalle[$i][VED_CANTIDAD])) * 10;
			    printer_draw_text($handle,number_format($detalle[$i][VED_CANTIDAD],4,'.',''),$colCan,$linea);
			    $addDesc = (7 - strlen(number_format($detalle[$i][ITE_DESCRIPCION],2,'.',''))) * 10;
			    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),$colDesc + $addDesc,$linea);
			    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
			    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
			    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
			    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
			    $linea+=10;
			}
			$linea = 470;
			printer_draw_text($handle, '_________________________________________________________________________________________', 0, $linea);
			$linea+=10;
			printer_draw_text($handle, "Subtotal 0",0,$linea);
			printer_draw_text($handle, "SubTotal IVA",150,$linea);
			printer_draw_text($handle, "Subtotal",300,$linea);
			printer_draw_text($handle, "Desc. ",400,$linea);
			printer_draw_text($handle, "IVA $IVA%. ",450,$linea);
			$font = printer_create_font("Sans Serif", 12, 9, 400, false, false, false, 0);
			printer_select_font($handle, $font);
			printer_draw_text($handle, "TOTAL ",600,$linea);
			$linea+=10;
			$font = printer_create_font("Sans Serif", 11, 8, 300, false, false, false, 0);
			printer_select_font($handle, $font);
			printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),0, $linea);
			printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),150, $linea);
			printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),300, $linea);
			printer_draw_text($handle, number_format($venta[VEN_DESCUENTO]+$venta[VEN_DESCUENTOG],2,'.',''),400, $linea);
			printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),450, $linea);
			$font3 = printer_create_font("Sans Serif", 14, 10, 300, false, false, false, 0);
			printer_select_font($handle, $font3);
			printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),600, $linea);
			printer_select_font($handle, $font);
			$linea+=10;
			printer_draw_text($handle, $venta[VEN_OBSERVACIONES],10, $linea);
			$linea+=10;
			printer_draw_text($handle, "Debo y pagaré; a la orden de PRODULIMPIE.",10,$linea);
			$linea+=10;
			printer_draw_text($handle, "Recibida la mercadería no se aceptan devoluciones.                         _______________     _______________",10,$linea);
			$linea+=10;
			printer_draw_text($handle, "De acuerdo a la disposición del SRI , no se aceptará; retenciones             Autorizada              Cliente",10,$linea);
			$linea+=10;
			printer_draw_text($handle, "pasado los 5 días de emitida la factura.",10,$linea);
			$linea += 125;
			$font2 = printer_create_font("Sans Serif", 9, 7, 400, false, false, false, 0);
			printer_select_font($handle, $font2);
			printer_draw_text($handle, $venta[VEN_FECHA]."                                                                 ".$venta[VEN_FECHA],180,$linea);
			$linea+=15;
			printer_draw_text($handle, "                                                         VENTA",0,$linea);
			$linea+=15;
			printer_draw_text($handle, "                                      $venta[VEN_FECHA]                                                CUENCA",0,$linea);
			$linea+=15;
			printer_draw_text($handle, "                                                                                                           $venta[CLI_IDENTIFICACION]",0,$linea);
			$linea+=15;
			printer_draw_text($handle, "                                                $venta[CLI_NOMBRE]",0,$linea);
			$linea+=15;
			printer_draw_text($handle, "                                                $venta[CLI_DIRECCION]",0,$linea);
			$linea+=10;
			//$transporte = explode("##",$venta[VEN_GUIA]);
			printer_draw_text($handle, "                                                                                                                                    ABC09634",0,$linea);
			$linea+=10;
			printer_draw_text($handle, "                                          FELIPE GALAN NAULA                                                            0102779238",0,$linea);
			$linea+=10;
			printer_draw_text($handle, "                                                           PRODULIMPIE - ALEXANDRA ABRIL",0,$linea);
			printer_end_page($handle);
			printer_end_doc($handle);
			printer_close($handle);
			return true;
		}
		
		
		if($archivo == "facturacionticketera76x280.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			for($j=0; $j < 2; $j++)
			{
				$linea = 60;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 210, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				
				$linea = 1140;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 1435;
				}else{
				    $linea = 1410;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}

		if($archivo == "facturacionticketera76x140comanda.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
				$venta[CLI_IDENTIFICACION] = "9999999999999";
				$venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
				$venta[CLI_DIRECCION] = "S/N";
				$venta[CLI_TELEFONO] = "";
			}

			for($j=0; $j < 1; $j++)
			{
				$linea = 0;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 20, 8, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = date("d/m/Y G:i:s", mktime((date('G')-date('I')),date('i'),date('s'),date("m"), date("d"), date("Y")));
				printer_draw_text($handle, 'FECHA Y HORA:'.$ciudad.",". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
					printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,25),0,$linea);
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
					printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
					$addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
					printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
					$addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
					printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
					$linea+=20;
				}

				$linea = 370;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA 12%: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
					$linea = 540;
				}else{
					$linea = 500;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);

			$handle = printer_open("COMANDAS");
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
				$venta[CLI_IDENTIFICACION] = "9999999999999";
				$venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
				$venta[CLI_DIRECCION] = "S/N";
				$venta[CLI_TELEFONO] = "";
			}

			for($j=0; $j < 1; $j++)
			{
				$linea = 50;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = date("d/m/Y G:i:s", mktime((date('G')-date('I')),date('i'),date('s'),date("m"), date("d"), date("Y")));
				printer_draw_text($handle, 'FECHA Y HORA:'.$ciudad.",". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
					printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,26)." - ".substr(utf8_decode($detalle[$i][ITE_COMPLEMENTARIO]),0,11),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
					printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
					$linea+=20;
				}
				if($j == 0)
				{
					$linea = 619;
				}else{
					$linea = 574;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}
		
		if($archivo == "facturacionticketera76x133_303.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			
			for($j=0; $j < 1; $j++)
			{
				$linea = 25;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=10;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA:'.$ciudad.",". $ahora, 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=10;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=10;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,16),0,$linea);
					//$linea+=10;
					//printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=10;
				}
				
				$linea = 185;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=10;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 309;
				}else{
				    $linea = 287;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}
		
		if($archivo == "facturacionticketera76x133.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			
			for($j=0; $j < 1; $j++)
			{
				$linea = 50;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA:'.$ciudad.",". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,16),0,$linea);
					//$linea+=20;
					//printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				
				$linea = 370;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 619;
				}else{
				    $linea = 574;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}
		
		
		if($archivo == "facturacionticketeraRestaurante76x133.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			
			for($j=0; $j < 1; $j++)
			{
				$linea = 50;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA:'.$ciudad.",". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,16),0,$linea);
					//$linea+=20;
					//printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				
				$linea = 370;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "SERV.: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SERVICIOS],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SERVICIOS],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 619;
				}else{
				    $linea = 574;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}
		
		if($archivo == "facturacionticketera76x133comanda.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			
			for($j=0; $j < 1; $j++)
			{
				$linea = 50;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA:'.$ciudad.",". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				
				$linea = 370;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 619;
				}else{
				    $linea = 574;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			
			$handle = printer_open("COMANDAS");
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			
			for($j=0; $j < 1; $j++)
			{
				$linea = 50;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA:'.$ciudad.",". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $linea+=20;
				}
				if($j == 0)
				{
				    $linea = 619;
				}else{
				    $linea = 574;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}
		
		
		if($archivo == "facturacionticketera76x185.php")
		{
			
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			
			for($j=0; $j < 2; $j++)
			{
				$linea = 60;
				$handle = printer_open($impresora);
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 210, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				
				$linea = 680;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 895;
				}else{
				    $linea = 865;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
				printer_close($handle);
			}
			return true;
		}
		
		if($archivo == "facturacionticketera76x185_303.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			
			for($j=0; $j < 2; $j++)
			{
				$linea = 30;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=10;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=10;
				$colCod = 0;
				$colCan = 80;
				$colPVP = 105;
				$colTot = 150;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 80, $linea);
				printer_draw_text($handle, 'PVP', 105, $linea);
				printer_draw_text($handle, 'TOTAL', 150, $linea);
				$linea+=10;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=10;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=10;
				}
				
				$linea = 340;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),140 + $addTotales,$linea);
				$linea+=10;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),140 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 390;
				}else{
				    $linea = 430;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}
		
		if($archivo == "facturacionticketera76x185_303.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			
			for($j=0; $j < 2; $j++)
			{
				$linea = 30;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=10;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=10;
				$colCod = 0;
				$colCan = 80;
				$colPVP = 105;
				$colTot = 150;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 80, $linea);
				printer_draw_text($handle, 'PVP', 105, $linea);
				printer_draw_text($handle, 'TOTAL', 150, $linea);
				$linea+=10;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=10;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=10;
				}
				
				$linea = 340;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),140 + $addTotales,$linea);
				$linea+=10;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),140 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 390;
				}else{
				    $linea = 430;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}

        //electronica
        if($archivo == "facturacionticketeramce76x189_3nstar.php")
        {

            //Realizo busquedas para obtener info
            if($venta[CLI_CODIGO] == 0)
            {
                $venta[CLI_IDENTIFICACION] = "9999999999999";
                $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
                $venta[CLI_DIRECCION] = "S/N";
                $venta[CLI_TELEFONO] = "";
            }

            for($j=0; $j < 1; $j++)
            {
                $linea = 15;
                $handle = printer_open($impresora);
                printer_start_doc($handle, "COMP - ".$venta[VEN_NUMERO]);
                printer_start_page($handle);
                $font = printer_create_font("FontB11", 16, 6, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                if($empresa[EMP_ARETENCION] > 0)
                {
                    printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                    $linea+=15;
                    printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001", 0,$linea);
                    $linea+=20;
                }
                printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
                $linea+=15;
                printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
                $linea+=15;
                printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
                $linea+=15;
                printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
                $linea+=15;
                if($empresa[EMP_CONTRIBUYENTE] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: ".$empresa[EMP_CONTRIBUYENTE], 0,$linea);
                    $linea+=15;
                }
                if($empresa[EMP_MICROEMPRESA] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                    $linea+=15;
                }
                printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);
                $linea+=15;
                printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
                $linea+=15;
                $ahora = $venta[VEN_FECHA];
                printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
                $linea+=15;
                printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
                $linea+=15;
                printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
                $linea+=15;
                printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
                $linea+=15;
                printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
                printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
                $linea+=15;
                printer_draw_text($handle, 'CLAVE DE ACCESO: ', 0,$linea);
                $linea+=15;
                printer_draw_text($handle, $venta[CLA_CLAVE], 0,$linea);
                $linea+=15;
                $colCod = 0;
                $colCan = 210;
                $colPVP = 250;
                $colTot = 330;
                printer_draw_text($handle, '-----------------------------------------------------------------------------------------', 0,$linea);
                $linea+=15;
                printer_draw_text($handle, 'DES', 0, $linea);
                printer_draw_text($handle, 'UNI   CAN', 120, $linea);
                printer_draw_text($handle, 'PVP', 270, $linea);
                printer_draw_text($handle, 'TOTAL', 350, $linea);
                $linea+=15;
                printer_draw_text($handle, '-----------------------------------------------------------------------------------------', 0,$linea);
                $linea+=15;
                for($i = 0; $i < count($detalle); $i++)
                {
                    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
                    $linea+=15;
                    printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
                    $addCan = (3 - strlen(number_format($detalle[$i][VED_CANTIDAD],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_CANTIDAD],2,'.',''),$colCan + $addCan,$linea);
                    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
                    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
                    $linea+=15;
                }
                $linea+=15;
                printer_draw_text($handle, '-----------------------------------------------------------------------------------------', 0,$linea);
                $linea+= 15;
                printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
                $linea+=15;
                printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
                $linea+=15;
                printer_draw_text($handle, "TOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
                $linea+=15;
                printer_draw_text($handle, "Revisa tu factura en www.acatha.com",0,$linea);
                printer_end_page($handle);
                printer_end_doc($handle);
                printer_close($handle);
            }
            return true;
        }

        //electronica
        if($archivo == "facturacionticketeramce76x189comandas.php")
        {

            //Realizo busquedas para obtener info
            if($venta[CLI_CODIGO] == 0) {
                $venta[CLI_IDENTIFICACION] = "9999999999999";
                $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
                $venta[CLI_DIRECCION] = "S/N";
                $venta[CLI_TELEFONO] = "";
            }

            for($j=0; $j < 1; $j++) {
                $linea = 20;
                $handle = printer_open($impresora);
                printer_start_doc($handle, "COMP - " . $venta[VEN_NUMERO]);
                printer_start_page($handle);
                $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                if($empresa[EMP_ARETENCION] > 0)
                {
                    printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                    $linea+=15;
                    printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001", 0,$linea);
                    $linea+=20;
                }
                printer_draw_text($handle, $empresa[EMP_NOMBRE], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, $empresa[EMP_RUC], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, $empresa[EMP_DIRECCION], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, $empresa[EMP_TELEFONO], 0, $linea);
                $linea += 20;
                if ($empresa[EMP_CONTRIBUYENTE] > 0) {
                    printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: " . $empresa[EMP_CONTRIBUYENTE], 0, $linea);
                    $linea += 20;
                }
                if($empresa[EMP_MICROEMPRESA] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                    $linea+=15;
                }
                $linea += 10;
                printer_draw_text($handle, "SUCURSAL: " . $empresa[dirSucursal], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, "AMBIENTE: " . $empresa[ambiente], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, "EMISION: " . $empresa[emision], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, "Obligado a llevar contabilidad: " . $empresa[obligado], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, $venta[VEN_TIPODOC_DES] . ": " . $venta[VEN_ESTABLECIMIENTO] . "-" . $venta[VEN_PTOEMISION] . "-" . $venta[VEN_NUMERO], 0, $linea);
                $linea += 20;
                $ahora = $venta[VEN_FECHA];
                printer_draw_text($handle, 'FECHA: ' . $ciudad . ", " . $ahora, 0, $linea);
                $linea += 25;
                printer_draw_text($handle, 'CLIENTE: ' . $venta[CLI_NOMBRE], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, 'CED./RUC: ' . $venta[CLI_IDENTIFICACION], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, 'DIR.: ' . $venta[CLI_DIRECCION], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, 'TEL.: ' . $venta[CLI_TELEFONO], 0, $linea);
                printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300, $linea);
                $linea += 25;
                printer_draw_text($handle, 'CLAVE DE ACCESO: ', 0, $linea);
                $linea += 20;
                printer_draw_text($handle, substr($venta[CLA_CLAVE], 0, 38), 0, $linea);
                $linea += 20;
                printer_draw_text($handle, substr($venta[CLA_CLAVE], 38), 0, $linea);
                $linea += 20;
                printer_draw_text($handle, 'FECHA AUT: ' . $venta[CLA_FECHA], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, 'VDR: ' . $venta[VDR_COMPLETO], 0, $linea);
                $linea += 20;
                printer_draw_text($handle, '_______________________________________________________________', 0, $linea);
                $linea += 20;
                $colCod = 0;
                $colCan = 210;
                $colPVP = 250;
                $colTot = 330;
                printer_draw_text($handle, 'COD', 0, $linea);
                printer_draw_text($handle, 'CAN', 210, $linea);
                printer_draw_text($handle, 'PVP', 250, $linea);
                printer_draw_text($handle, 'TOTAL', 330, $linea);
                $linea += 30;
                for ($i = 0; $i < count($detalle); $i++) {
                    printer_draw_text($handle, substr($detalle[$i][ITE_DESCRIPCION], 0, 40), 0, $linea);
                    $linea += 20;
                    printer_draw_text($handle, substr($detalle[$i][ITE_BARRAS], 0, 20), $colCod, $linea);
                    $addCan = (3 - strlen(number_format($detalle[$i][VED_CANTIDAD], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($detalle[$i][VED_CANTIDAD], 2, '.', ''), $colCan + $addCan, $linea);
                    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($detalle[$i][VED_PUNITARIO], 2, '.', ''), $colPVP + $addPVP, $linea);
                    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($detalle[$i][VED_VALOR], 2, '.', ''), $colTot + $addTot, $linea);
                    $linea += 20;
                }

                $linea += 40;
                if ($venta[VEN_SUBTOTAL0] > 0) {
                    printer_draw_text($handle, "SUBTOTAL NO IVA: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "SUBTOTAL IVA: ", 70, $linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12], 2, '.', ''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12], 2, '.', ''), 280 + $addTotales, $linea);
                $linea += 20;
                $descuento = $venta[VEN_DESCUENTO] + $venta[VEN_DESCUENTOG];
                if ($descuento > 0) {
                    printer_draw_text($handle, "DESC: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($descuento, 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($descuento, 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "SUBTOTAL: ", 70, $linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL], 2, '.', ''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL], 2, '.', ''), 280 + $addTotales, $linea);
                $linea += 20;
                if ($venta[VEN_ICE] > 0) {
                    printer_draw_text($handle, "ICE : ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_ICE], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_ICE], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "IVA $IVA %: ", 70, $linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_IVA], 2, '.', ''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_IVA], 2, '.', ''), 280 + $addTotales, $linea);
                $linea += 20;
                printer_draw_text($handle, "TOTAL: ", 70, $linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_TOTAL], 2, '.', ''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_TOTAL], 2, '.', ''), 280 + $addTotales, $linea);
                $linea += 30;
                printer_draw_text($handle, "Revisa tu factura: www.acatha.com", 0, $linea);
                $linea += 30;
                printer_draw_text($handle, "_", 0, $linea);
                printer_end_page($handle);
                printer_end_doc($handle);
                printer_close($handle);
            }

            for($j=0; $j < 1; $j++)
            {
                $handle = printer_open("COMANDAS");
                $linea = 50;
                printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
                printer_start_page($handle);
                $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
                $linea+=20;
                $ahora = $venta[VEN_FECHA];
                printer_draw_text($handle, 'FECHA:'.$ciudad.",". $ahora, 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
                printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
                $linea+=20;
                $colCod = 0;
                $colCan = 180;
                $colPVP = 220;
                $colTot = 302;
                printer_draw_text($handle, 'COD', 0, $linea);
                printer_draw_text($handle, 'CAN', 180, $linea);
                printer_draw_text($handle, 'PVP', 250, $linea);
                printer_draw_text($handle, 'TOTAL', 330, $linea);
                $linea+=20;
                for($i = 0; $i < count($detalle); $i++)
                {
                    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,40),0,$linea);
                    $linea+=20;
                    printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
                    $addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
                    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
                    $linea+=20;
                }
                if($j == 0)
                {
                    $linea = 619;
                }else{
                    $linea = 574;
                }
                printer_draw_text($handle, "_",70,$linea);
                printer_end_page($handle);
                printer_end_doc($handle);
                printer_close($handle);
            }
            return true;
        }


		//electronica
		if($archivo == "facturacionticketeramce76x189.php")
		{

			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}

			for($j=0; $j < 1; $j++)
			{
				$linea = 20;
				$handle = printer_open($impresora);
				printer_start_doc($handle, "COMP - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
                if($empresa[EMP_ARETENCION] > 0)
                {
                    printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001", 0,$linea);
                    $linea+=30;
                }
				printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
                $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
				$linea+=20;
				if($empresa[EMP_CONTRIBUYENTE] > 0)
				{
					printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: ".$empresa[EMP_CONTRIBUYENTE], 0,$linea);
					$linea+=20;
				}
                if($empresa[EMP_MICROEMPRESA] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                    $linea+=15;
                }
				$linea+=10;
				printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, "AMBIENTE: ".$empresa[ambiente], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, "EMISION: ".$empresa[emision], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, "Obligado a llevar contabilidad: ".$empresa[obligado], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=25;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=25;
				printer_draw_text($handle, 'CLAVE DE ACCESO: ', 0,$linea);
				$linea+=20;
				printer_draw_text($handle, substr($venta[CLA_CLAVE],0,38), 0,$linea);
				$linea+=20;
				printer_draw_text($handle, substr($venta[CLA_CLAVE],38), 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'FECHA AUT: '.$venta[CLA_FECHA], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'VDR: '.$venta[VDR_COMPLETO], 0,$linea);
				$linea+=20;
                printer_draw_text($handle, '_____________________________________________________________', 0,$linea);
                $linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 210, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=30;

				$vivienda = 0;
				$educacion = 0;
				$salud = 0;
				$alimentacion = 0;
				$vestimenta = 0;

				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(number_format($detalle[$i][VED_CANTIDAD],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_CANTIDAD],2,'.',''),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				    switch($detalle[$i]['ITE_TIPODEDUCIBLE'])
                    {
                        case "VIVIENDA":
                            $vivienda += $detalle[$i][VED_VALOR];
                            break;
                        case "EDUCACION":
                            $educacion += $detalle[$i][VED_VALOR];
                            break;
                        case "SALUD":
                            $salud += $detalle[$i][VED_VALOR];
                            break;
                        case "ALIMENTACION":
                            $alimentacion += $detalle[$i][VED_VALOR];
                            break;
                        case "VESTIMENTA":
                            $vestimenta += $detalle[$i][VED_VALOR];
                            break;
                    }
				}

				$linea+= 40;
				if($venta[VEN_SUBTOTAL0] > 0) {
                    printer_draw_text($handle, "SUBTOTAL NO IVA: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				$descuento = $venta[VEN_DESCUENTO]+$venta[VEN_DESCUENTOG];
				if($descuento > 0) {
                    printer_draw_text($handle, "DESC: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($descuento, 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($descuento, 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				if($venta[VEN_ICE] > 0) {
                    printer_draw_text($handle, "ICE : ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_ICE], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_ICE], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
                if($venta[VEN_SERVICIOS] > 0) {
                    printer_draw_text($handle, "SERVICIOS : ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_SERVICIOS], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_SERVICIOS], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				$linea+=30;
                for($i = 0; $i < count($venta[series]); $i++)
                {
                    printer_draw_text($handle, $venta[series][$i][ITE_BARRAS]." => ".$venta[series][$i][ITS_SERIE],0,$linea);
                    $linea+=20;
                }
                if($venta['SALDO'] > 0)
                {
                    printer_draw_text($handle, "CUPO DISPONIBLE => ".$venta['SALDO'],0,$linea);
                    $linea+=20;
                }
                $deducible = $vivienda+$educacion+$salud+$alimentacion+$vestimenta;
                if($deducible > 0)
                {
                    $linea += 10;
                    printer_draw_text($handle, " TOTAL DEDUCIBLE => ".$deducible,0,$linea);
                    $linea+=25;
                    printer_draw_text($handle, "VIVIENDA => ".$vivienda,0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "EDUCACION => ".$educacion,0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "SALUD => ".$salud,0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "ALIMENTACION => ".$alimentacion,0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "VESTIMENTA => ".$vestimenta,0,$linea);
                    $linea+=20;
                }
                $linea+=40;
				printer_draw_text($handle, "Revisa tu factura: www.acatha.com",0,$linea);
				$linea+=20;
				printer_draw_text($handle, '_____________________________________________________________', 0,$linea);
				$linea+=35;
				printer_draw_text($handle, "                 GRACIAS POR SU COMPRA",0,$linea);
				$linea+=35;
				printer_draw_text($handle, "TERMINOS Y CONDICIONES PARA CAMBIOS",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "-No realizamos reembolsos, se realizara nota de credito",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "con la factura registrada con datos.",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "-Cambio de producto maximo hasta 3 dias de realizada la",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "venta, no se recibira o cambiara el producto si no se",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "encuentra con todos sus accesorios y con daño en su",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "empaque original.",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "-Garantia de 30 dias solo aplica para productos",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "electronicos. No se recibira el producto pasado este",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "tiempo, la garantia no aplica si el producto presenta",0,$linea);
				$linea+=20;
                printer_draw_text($handle, "golpes o rayones.",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "-No hay cambio ni devolucion en ropa interior.",0,$linea);
				$linea+=30;
                $font = printer_create_font("control", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                printer_draw_text($handle, "A",0,$linea);

                printer_end_page($handle);
                printer_end_doc($handle);
                printer_close($handle);
			}
			return true;
		}

        if($archivo == "facturacionticketeramce76x189desc.php")
        {

            //Realizo busquedas para obtener info
            if($venta[CLI_CODIGO] == 0)
            {
                $venta[CLI_IDENTIFICACION] = "9999999999999";
                $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
                $venta[CLI_DIRECCION] = "S/N";
                $venta[CLI_TELEFONO] = "";
            }

            for($j=0; $j < 1; $j++)
            {
                $linea = 20;
                $handle = printer_open($impresora);
                printer_start_doc($handle, "COMP - ".$venta[VEN_NUMERO]);
                printer_start_page($handle);
                $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                if($empresa[EMP_ARETENCION] > 0)
                {
                    printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001", 0,$linea);
                    $linea+=30;
                }
                printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
                $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                $linea+=20;
                printer_draw_text($handle, $empresa[EMP_NOMBRE], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
                $linea+=20;
                if($empresa[EMP_CONTRIBUYENTE] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: ".$empresa[EMP_CONTRIBUYENTE], 0,$linea);
                    $linea+=20;
                }
                if($empresa[EMP_MICROEMPRESA] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                    $linea+=15;
                }
                $linea+=10;
                printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "AMBIENTE: ".$empresa[ambiente], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "EMISION: ".$empresa[emision], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "Obligado a llevar contabilidad: ".$empresa[obligado], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
                $linea+=20;
                $ahora = $venta[VEN_FECHA];
                printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
                $linea+=25;
                printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
                printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
                $linea+=25;
                printer_draw_text($handle, 'CLAVE DE ACCESO: ', 0,$linea);
                $linea+=20;
                printer_draw_text($handle, substr($venta[CLA_CLAVE],0,38), 0,$linea);
                $linea+=20;
                printer_draw_text($handle, substr($venta[CLA_CLAVE],38), 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'FECHA AUT: '.$venta[CLA_FECHA], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'VDR: '.$venta[VDR_COMPLETO], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, '_____________________________________________________________', 0,$linea);
                $linea+=20;
                $colCod = 0;
                $colCan = 210;
                $colPVP = 250;
                $colTot = 330;
                printer_draw_text($handle, 'COD', 0, $linea);
                printer_draw_text($handle, 'CAN', 210, $linea);
                printer_draw_text($handle, 'PVP', 250, $linea);
                printer_draw_text($handle, 'TOTAL', 330, $linea);
                $linea+=30;

                $vivienda = 0;
                $educacion = 0;
                $salud = 0;
                $alimentacion = 0;
                $vestimenta = 0;

                for($i = 0; $i < count($detalle); $i++)
                {
                    printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
                    $addCan = (3 - strlen(number_format($detalle[$i][VED_CANTIDAD],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_CANTIDAD],2,'.',''),$colCan + $addCan,$linea);
                    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
                    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
                    $linea+=20;
                    switch($detalle[$i]['ITE_TIPODEDUCIBLE'])
                    {
                        case "VIVIENDA":
                            $vivienda += $detalle[$i][VED_VALOR];
                            break;
                        case "EDUCACION":
                            $educacion += $detalle[$i][VED_VALOR];
                            break;
                        case "SALUD":
                            $salud += $detalle[$i][VED_VALOR];
                            break;
                        case "ALIMENTACION":
                            $alimentacion += $detalle[$i][VED_VALOR];
                            break;
                        case "VESTIMENTA":
                            $vestimenta += $detalle[$i][VED_VALOR];
                            break;
                    }
                }

                $linea+= 40;
                if($venta[VEN_SUBTOTAL0] > 0) {
                    printer_draw_text($handle, "SUBTOTAL NO IVA: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
                $linea+=20;
                $descuento = $venta[VEN_DESCUENTO]+$venta[VEN_DESCUENTOG];
                if($descuento > 0) {
                    printer_draw_text($handle, "DESC: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($descuento, 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($descuento, 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
                $linea+=20;
                if($venta[VEN_ICE] > 0) {
                    printer_draw_text($handle, "ICE : ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_ICE], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_ICE], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
                $linea+=20;
                printer_draw_text($handle, "TOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
                $linea+=30;
                for($i = 0; $i < count($venta[series]); $i++)
                {
                    printer_draw_text($handle, $venta[series][$i][ITE_BARRAS]." => ".$venta[series][$i][ITS_SERIE],0,$linea);
                    $linea+=20;
                }
                if($venta['SALDO'] > 0)
                {
                    printer_draw_text($handle, "CUPO DISPONIBLE => ".$venta['SALDO'],0,$linea);
                    $linea+=20;
                }
                $deducible = $vivienda+$educacion+$salud+$alimentacion+$vestimenta;
                if($deducible > 0)
                {
                    $linea += 10;
                    printer_draw_text($handle, " TOTAL DEDUCIBLE => ".$deducible,0,$linea);
                    $linea+=25;
                    printer_draw_text($handle, "VIVIENDA => ".$vivienda,0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "EDUCACION => ".$educacion,0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "SALUD => ".$salud,0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "ALIMENTACION => ".$alimentacion,0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "VESTIMENTA => ".$vestimenta,0,$linea);
                    $linea+=20;
                }
                $linea+=50;
                printer_draw_text($handle, "Firma:------------------------------",0,$linea);
                $linea+=20;
                printer_draw_text($handle, "Revisa tu factura: www.acatha.com",0,$linea);
                $linea+=30;
                $font = printer_create_font("control", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                printer_draw_text($handle, "A",0,$linea);

                printer_end_page($handle);
                printer_end_doc($handle);
                printer_close($handle);
            }
            return true;
        }

        //electronica generic text only
        if($archivo == "facturacionticketeramce76x189gen.php")
        {

            //Realizo busquedas para obtener info
            if($venta[CLI_CODIGO] == 0)
            {
                $venta[CLI_IDENTIFICACION] = "9999999999999";
                $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
                $venta[CLI_DIRECCION] = "S/N";
                $venta[CLI_TELEFONO] = "";
            }

            for($j=0; $j < 2; $j++)
            {
                $handle = printer_open($impresora);
                printer_set_option($handle, PRINTER_MODE, "RAW");
                printer_start_doc($handle, "COMP - ".$venta[VEN_NUMERO]);
                printer_start_page($handle);
                $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                if($empresa[EMP_ARETENCION] > 0)
                {
                    printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                    printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001 ", 0,$linea);
                    printer_draw_text($handle, "\n\n", 0,$linea);
                }
                printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
                $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, $empresa[EMP_NOMBRE], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                if($empresa[EMP_CONTRIBUYENTE] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: ".$empresa[EMP_CONTRIBUYENTE], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                }
                if($empresa[EMP_MICROEMPRESA] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                }
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, "AMBIENTE: ".$empresa[ambiente], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, "EMISION: ".$empresa[emision], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, "Obligado a llevar contabilidad: ".$empresa[obligado], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                $ahora = $venta[VEN_FECHA];
                printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
                printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, 'CLAVE DE ACCESO: ', 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, substr($venta[CLA_CLAVE],0,38), 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, substr($venta[CLA_CLAVE],38), 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, 'FECHA AUT: '.$venta[CLA_FECHA], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, 'VDR: '.$venta[VDR_COMPLETO], 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, '_____________________________________________________________', 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                $colCod = 0;
                $colCan = 210;
                $colPVP = 250;
                $colTot = 330;
                printer_draw_text($handle, 'COD', 0, $linea);
                printer_draw_text($handle, 'CAN', 210, $linea);
                printer_draw_text($handle, 'PVP', 250, $linea);
                printer_draw_text($handle, 'TOTAL', 330, $linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);

                $vivienda = 0;
                $educacion = 0;
                $salud = 0;
                $alimentacion = 0;
                $vestimenta = 0;

                for($i = 0; $i < count($detalle); $i++)
                {
                    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
                        printer_draw_text($handle, "\n", 0,$linea);
                    printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
                    $addCan = (3 - strlen(number_format($detalle[$i][VED_CANTIDAD],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_CANTIDAD],2,'.',''),$colCan + $addCan,$linea);
                    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
                    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
                        printer_draw_text($handle, "\n", 0,$linea);
                    switch($detalle[$i]['ITE_TIPODEDUCIBLE'])
                    {
                        case "VIVIENDA":
                            $vivienda += $detalle[$i][VED_VALOR];
                            break;
                        case "EDUCACION":
                            $educacion += $detalle[$i][VED_VALOR];
                            break;
                        case "SALUD":
                            $salud += $detalle[$i][VED_VALOR];
                            break;
                        case "ALIMENTACION":
                            $alimentacion += $detalle[$i][VED_VALOR];
                            break;
                        case "VESTIMENTA":
                            $vestimenta += $detalle[$i][VED_VALOR];
                            break;
                    }
                }

                    printer_draw_text($handle, "\n", 0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                if($venta[VEN_SUBTOTAL0] > 0) {
                    printer_draw_text($handle, "SUBTOTAL NO IVA: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0], 2, '.', ''), 280 + $addTotales, $linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                }
                printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                $descuento = $venta[VEN_DESCUENTO]+$venta[VEN_DESCUENTOG];
                if($descuento > 0) {
                    printer_draw_text($handle, "DESC: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($descuento, 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($descuento, 2, '.', ''), 280 + $addTotales, $linea);
                        printer_draw_text($handle, "\n", 0,$linea);
                }
                printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                if($venta[VEN_ICE] > 0) {
                    printer_draw_text($handle, "ICE : ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_ICE], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_ICE], 2, '.', ''), 280 + $addTotales, $linea);
                        printer_draw_text($handle, "\n", 0,$linea);
                }
                printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, "TOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                for($i = 0; $i < count($venta[series]); $i++)
                {
                    printer_draw_text($handle, $venta[series][$i][ITE_BARRAS]." => ".$venta[series][$i][ITS_SERIE],0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                }
                if($venta['SALDO'] > 0)
                {
                    printer_draw_text($handle, "CUPO DISPONIBLE => ".$venta['SALDO'],0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                }
                $deducible = $vivienda+$educacion+$salud+$alimentacion+$vestimenta;
                if($deducible > 0)
                {
                    printer_draw_text($handle, "\n", 0,$linea);
                    printer_draw_text($handle, " TOTAL DEDUCIBLE => ".$deducible,0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                    printer_draw_text($handle, "VIVIENDA => ".$vivienda,0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                    printer_draw_text($handle, "EDUCACION => ".$educacion,0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                    printer_draw_text($handle, "SALUD => ".$salud,0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                    printer_draw_text($handle, "ALIMENTACION => ".$alimentacion,0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                    printer_draw_text($handle, "VESTIMENTA => ".$vestimenta,0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                }
                    printer_draw_text($handle, "\n", 0,$linea);
                printer_draw_text($handle, "Revisa tu factura: www.acatha.com",0,$linea);
                    printer_draw_text($handle, "\n", 0,$linea);
                $font = printer_create_font("control", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                printer_draw_text($handle, "A",0,$linea);

                printer_end_page($handle);
                printer_end_doc($handle);
                printer_close($handle);
            }
            return true;
        }


        //electronica
        if($archivo == "facturacionticketeramce_guia76x189.php")
        {

            //Realizo busquedas para obtener info
            if($venta[CLI_CODIGO] == 0)
            {
                $venta[CLI_IDENTIFICACION] = "9999999999999";
                $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
                $venta[CLI_DIRECCION] = "S/N";
                $venta[CLI_TELEFONO] = "";
            }

            for($j=0; $j < 1; $j++)
            {
                $linea = 20;
                $handle = printer_open($impresora);
                printer_start_doc($handle, "COMP - ".$venta[VEN_NUMERO]);
                printer_start_page($handle);
                $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                if($empresa[EMP_ARETENCION] > 0)
                {
                    printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                    $linea+=15;
                    printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001 ", 0,$linea);
                    $linea+=20;
                }
                printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
                $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                $linea+=20;
                if($empresa[EMP_NOMBRE] != $empresa[EMP_NCOMERCIAL])
                {
                    printer_draw_text($handle, $empresa[EMP_NOMBRE], 0,$linea);
                    $linea+=20;
                }
                printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
                $linea+=20;
                if($empresa[EMP_CONTRIBUYENTE] > 0) {
                    printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: " . $empresa[EMP_CONTRIBUYENTE], 0, $linea);
                    $linea += 20;
                }
                if($empresa[EMP_MICROEMPRESA] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                    $linea+=15;
                }
                $linea+=10;
                printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "AMBIENTE: ".$empresa[ambiente], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "EMISION: ".$empresa[emision], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "Obligado a llevar contabilidad: ".$empresa[obligado], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
                $linea+=20;
                $ahora = $venta[VEN_FECHA];
                printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
                $linea+=25;
                printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
                printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
                $linea+=25;
                printer_draw_text($handle, 'CLAVE DE ACCESO: ', 0,$linea);
                $linea+=20;
                printer_draw_text($handle, substr($venta[CLA_CLAVE],0,38), 0,$linea);
                $linea+=20;
                printer_draw_text($handle, substr($venta[CLA_CLAVE],38), 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'FECHA AUT: '.$venta[CLA_FECHA], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'VDR: '.$venta[VDR_COMPLETO], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, '_____________________________________________________________', 0,$linea);
                $linea+=20;
                $colCod = 0;
                $colCan = 210;
                $colPVP = 250;
                $colTot = 330;
                printer_draw_text($handle, 'COD', 0, $linea);
                printer_draw_text($handle, 'CAN', 210, $linea);
                printer_draw_text($handle, 'PVP', 250, $linea);
                printer_draw_text($handle, 'TOTAL', 330, $linea);
                $linea+=30;
                for($i = 0; $i < count($detalle); $i++)
                {
                    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
                    $linea+=20;
                    printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
                    $addCan = (3 - strlen(number_format($detalle[$i][VED_CANTIDAD],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_CANTIDAD],2,'.',''),$colCan + $addCan,$linea);
                    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
                    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
                    $linea+=20;
                }

                $linea+= 40;
                if($venta[VEN_SUBTOTAL0] > 0) {
                    printer_draw_text($handle, "SUBTOTAL NO IVA: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
                $linea+=20;
                $descuento = $venta[VEN_DESCUENTO]+$venta[VEN_DESCUENTOG];
                if($descuento > 0) {
                    printer_draw_text($handle, "DESC: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($descuento, 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($descuento, 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
                $linea+=20;
                if($venta[VEN_ICE] > 0) {
                    printer_draw_text($handle, "ICE : ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_ICE], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_ICE], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
                $linea+=20;
                printer_draw_text($handle, "TOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
                $linea+=30;
                for($i = 0; $i < count($venta[series]); $i++)
                {
                    printer_draw_text($handle, $venta[series][$i][ITE_BARRAS]." => ".$venta[series][$i][ITS_SERIE],0,$linea);
                    $linea+=20;
                }
                $linea+=30;
                printer_draw_text($handle, "GUIA DE REMISION".": ".$guia[GRE_ESTABLECIMIENTO]."-".$guia[GRE_PTOEMISION]."-".$guia[GRE_NUMERO],0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'TRANSPORTISTA: '. $guia[PRV_NOMBRE], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'CED./RUC: '. $guia[PRV_IDENTIFICACION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'PLACA.: '. $guia[GRE_PLACA], 0,$linea);
                $linea+=25;

                printer_draw_text($handle, 'ORIGEN: '. $guia[GRE_PTOPARTIDA], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'DESTINO.: '. $guia[GRE_PTOLLEGADA], 0,$linea);
                $linea+=20;

                printer_draw_text($handle, 'CONTRAPARTE ARCH.: 104010005', 0,$linea);
                $linea+=25;

                printer_draw_text($handle, "Revisa tu factura: www.acatha.com",0,$linea);
                $linea+=30;
                $font = printer_create_font("control", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                printer_draw_text($handle, "A",0,$linea);

                printer_end_page($handle);
                printer_end_doc($handle);
                printer_close($handle);
            }
            return true;
        }

        if($archivo == "facturacionticketeramce76x189bt.php")
        {

            //Realizo busquedas para obtener info
            if($venta[CLI_CODIGO] == 0)
            {
                $venta[CLI_IDENTIFICACION] = "9999999999999";
                $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
                $venta[CLI_DIRECCION] = "S/N";
                $venta[CLI_TELEFONO] = "";
            }

            for($j=0; $j < 1; $j++)
            {
                $linea = 20;
                $handle = printer_open($impresora);
                printer_start_doc($handle, "COMP - ".$venta[VEN_NUMERO]);
                printer_start_page($handle);
                $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                if($empresa[EMP_ARETENCION] > 0)
                {
                    printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001 ", 0,$linea);
                    $linea+=30;
                }
                printer_draw_text($handle, $empresa[EMP_NOMBRE], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
                $linea+=20;
                if($empresa[EMP_CONTRIBUYENTE] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: ".$empresa[EMP_CONTRIBUYENTE], 0,$linea);
                    $linea+=20;
                }
                if($empresa[EMP_MICROEMPRESA] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                    $linea+=15;
                }
                $linea+=10;
                printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "AMBIENTE: ".$empresa[ambiente], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "EMISION: ".$empresa[emision], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "Obligado a llevar contabilidad: ".$empresa[obligado], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
                $linea+=20;
                $ahora = $venta[VEN_FECHA];
                printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
                $linea+=25;
                printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
                printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
                $linea+=25;
                printer_draw_text($handle, 'CLAVE DE ACCESO: ', 0,$linea);
                $linea+=20;
                printer_draw_text($handle, substr($venta[CLA_CLAVE],0,38), 0,$linea);
                $linea+=20;
                printer_draw_text($handle, substr($venta[CLA_CLAVE],38), 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'FECHA AUT: '.$venta[CLA_FECHA], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, 'VDR: '.$venta[VDR_COMPLETO], 0,$linea);
                $linea+=20;
                printer_draw_text($handle, '_______________________________________________________________', 0,$linea);
                $linea+=20;
                $colCod = 0;
                $colCan = 210;
                $colPVP = 250;
                $colTot = 330;
                printer_draw_text($handle, 'COD', 0, $linea);
                printer_draw_text($handle, 'CAN', 210, $linea);
                printer_draw_text($handle, 'PVP', 250, $linea);
                printer_draw_text($handle, 'TOTAL', 330, $linea);
                $linea+=30;
                for($i = 0; $i < count($detalle); $i++)
                {
                    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
                    $linea+=20;
                    printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
                    $addCan = (3 - strlen(number_format($detalle[$i][VED_CANTIDAD],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_CANTIDAD],2,'.',''),$colCan + $addCan,$linea);
                    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
                    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
                    $linea+=20;
                }

                $linea+= 40;
                if($venta[VEN_SUBTOTAL0] > 0) {
                    printer_draw_text($handle, "SUBTOTAL NO IVA: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
                $linea+=20;
                $descuento = $venta[VEN_DESCUENTO]+$venta[VEN_DESCUENTOG];
                if($descuento > 0) {
                    printer_draw_text($handle, "DESC: ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($descuento, 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($descuento, 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
                $linea+=20;
                if($venta[VEN_ICE] > 0) {
                    printer_draw_text($handle, "ICE : ", 70, $linea);
                    $addTotales = (8 - strlen(number_format($venta[VEN_ICE], 2, '.', ''))) * 10;
                    printer_draw_text($handle, number_format($venta[VEN_ICE], 2, '.', ''), 280 + $addTotales, $linea);
                    $linea += 20;
                }
                printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
                $linea+=20;
                printer_draw_text($handle, "TOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
                $linea+=30;
                for($i = 0; $i < count($venta[series]); $i++)
                {
                    printer_draw_text($handle, $venta[series][$i][ITE_BARRAS]." => ".$venta[series][$i][ITS_SERIE],0,$linea);
                    $linea+=20;
                }
                $linea+=30;
                printer_draw_text($handle, "Revisa tu factura: www.acatha.com",0,$linea);
                $linea+=30;
                printer_draw_text($handle, "_",0,$linea);
                printer_end_page($handle);
                printer_end_doc($handle);
                printer_close($handle);
            }
            return true;
        }

        //electronica
        if($archivo == "facturacionticketeramce76x189_star.php")
        {

            //Realizo busquedas para obtener info
            if($venta[CLI_CODIGO] == 0)
            {
                $venta[CLI_IDENTIFICACION] = "9999999999999";
                $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
                $venta[CLI_DIRECCION] = "S/N";
                $venta[CLI_TELEFONO] = "";
            }

            for($j=0; $j < 1; $j++)
            {
                $linea = 30;
                $handle = printer_open($impresora);
                printer_start_doc($handle, "COMP - ".$venta[VEN_NUMERO]);
                printer_start_page($handle);
                $font = printer_create_font("FontB11", 24, 9, 400, false, false, false, 0);
                printer_select_font($handle, $font);
                if($empresa[EMP_ARETENCION] > 0)
                {
                    printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                    $linea+=30;
                    printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001 ", 0,$linea);
                    $linea+=30;
                }
                printer_draw_text($handle, $empresa[EMP_NOMBRE], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
                $linea+=30;
                if($empresa[EMP_CONTRIBUYENTE] > 0) {
                    printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: " . $empresa[EMP_CONTRIBUYENTE], 0, $linea);
                    $linea += 30;
                }
                if($empresa[EMP_MICROEMPRESA] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                    $linea+=30;
                }
                printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, "AMBIENTE: ".$empresa[ambiente], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, "EMISION: ".$empresa[emision], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, "Obligado a llevar contabilidad: ".$empresa[obligado], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
                $linea+=30;
                $ahora = $venta[VEN_FECHA];
                printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
                $linea+=30;
                printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
                $linea+=30;
                printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
                printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
                $linea+=30;
                printer_draw_text($handle, 'CLAVE DE ACCESO: ', 0,$linea);
                $linea+=30;
                printer_draw_text($handle, substr($venta[CLA_CLAVE],0,38), 0,$linea);
                $linea+=20;
                printer_draw_text($handle, substr($venta[CLA_CLAVE],38), 0,$linea);
                $linea+=30;
                printer_draw_text($handle, 'FECHA AUTORIZACION: ', 0,$linea);
                $linea+=30;
                printer_draw_text($handle, $venta[CLA_FECHA], 0,$linea);
                $linea+=40;
                $colCod = 0;
                $colCan = 280;
                $colPVP = 320;
                $colTot = 400;
                printer_draw_text($handle, '-----------------------------------------------------------------', 0,$linea);
                $linea+=30;
                printer_draw_text($handle, 'DES', 0, $linea);
                printer_draw_text($handle, 'UNI   CAN', 120, $linea);
                printer_draw_text($handle, 'PVP', 270, $linea);
                printer_draw_text($handle, 'TOTAL', 350, $linea);
                $linea+=30;
                printer_draw_text($handle, '-----------------------------------------------------------------', 0,$linea);
                $linea+=40;
                for($i = 0; $i < count($detalle); $i++)
                {
                    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
                    $linea+=30;
                    printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
                    $addCan = (3 - strlen(number_format($detalle[$i][VED_CANTIDAD],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_CANTIDAD],2,'.',''),$colCan + $addCan,$linea);
                    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
                    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
                    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
                    $linea+=30;
                }
                $linea+=30;
                printer_draw_text($handle, '-----------------------------------------------------------------', 0,$linea);
                $linea+= 50;
                printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),400 + $addTotales, $linea);
                $linea+=30;
                printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),400 + $addTotales, $linea);
                $linea+=30;
                printer_draw_text($handle, "DESC: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),400 + $addTotales, $linea);
                $linea+=30;
                printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),400 + $addTotales, $linea);
                $linea+=30;
                printer_draw_text($handle, "ICE : ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_ICE],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_ICE],2,'.',''),400 + $addTotales,$linea);
                $linea+=30;
                printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),400 + $addTotales,$linea);
                $linea+=30;
                printer_draw_text($handle, "TOTAL: ",70,$linea);
                $addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
                printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),400 + $addTotales,$linea);
                $linea+=40;
                printer_draw_text($handle, "Puedes descargar tu factura en:",0,$linea);
                $linea+=20;
                printer_draw_text($handle, "www.acatha.com/edocs",0,$linea);
                printer_end_page($handle);
                printer_end_doc($handle);
                printer_close($handle);
            }
            return true;
        }

		//electronica
		if($archivo == "facturacionticketeramce76x189pagare.php")
		{

			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}

			for($j=0; $j < 1; $j++)
			{
				$linea = 20;
				$handle = printer_open($impresora);
				printer_start_doc($handle, "COMP - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
                if($empresa[EMP_ARETENCION] > 0)
                {
                    printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001 ", 0,$linea);
                    $linea+=25;
                }
				printer_draw_text($handle, $empresa[EMP_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
				$linea+=20;
				if($empresa[EMP_CONTRIBUYENTE] > 0)
				{
					printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: ".$empresa[EMP_CONTRIBUYENTE], 0,$linea);
					$linea+=20;
				}
                if($empresa[EMP_MICROEMPRESA] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                    $linea+=15;
                }
				printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, "AMBIENTE: ".$empresa[ambiente], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, "EMISION: ".$empresa[emision], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, "Obligado a llevar contabilidad: ".$empresa[obligado], 0,$linea);
				$linea+=30;
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLAVE DE ACCESO: ', 0,$linea);
				$linea+=20;
				printer_draw_text($handle, substr($venta[CLA_CLAVE],0,38), 0,$linea);
				$linea+=20;
				printer_draw_text($handle, substr($venta[CLA_CLAVE],38), 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'FECHA AUTORIZACION: ', 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $venta[CLA_FECHA], 0,$linea);
				$linea+=30;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, '--------------------------------------------', 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DES', 0, $linea);
				printer_draw_text($handle, 'UNI   CAN', 120, $linea);
				printer_draw_text($handle, 'PVP', 270, $linea);
				printer_draw_text($handle, 'TOTAL', 350, $linea);
				$linea+=20;
				printer_draw_text($handle, '--------------------------------------------', 0,$linea);

				$linea+=30;
				for($i = 0; $i < count($detalle); $i++)
				{
					printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,10)."  ".$detalle[$i][ITE_COMPLEMENTARIO],$colCod,$linea);
					$addCan = (3 - strlen(number_format($detalle[$i][VED_CANTIDAD],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_CANTIDAD],2,'.',''),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}

				$linea+= 40;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				$linea+=30;
				printer_draw_text($handle, '--------------------------------------------', 0,$linea);
				$linea+=20;
				printer_draw_text($handle, "Debo y pagaré al emisor incondicionalmen-",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "te y sin protesto el total de este paga-",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "ré más interéses y cargos por servicio.",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "En caso de mora pagaré la tasa máxima au-",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "torizada por el emisor.",0,$linea);
				$linea+=30;
				printer_draw_text($handle, "Puedes descargar tu factura en:",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "www.acatha.com/edocs",0,$linea);
				$linea+=50;
				printer_draw_text($handle, "Firma:------------------------------",0,$linea);
				$linea+=50;
				printer_draw_text($handle, "Nombre:------------------------------",0,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
				printer_close($handle);
			}
			return true;
		}

		if($archivo == "facturacionticketeramce_gas.php")
		{

			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}

			for($j=0; $j < 1; $j++)
			{
				$linea = 20;
				$handle = printer_open($impresora);
				printer_start_doc($handle, "COMP - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
                if($empresa[EMP_ARETENCION] > 0)
                {
                    printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                    $linea+=20;
                    printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001 ", 0,$linea);
                    $linea+=25;
                }
				printer_draw_text($handle, $empresa[EMP_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
				$linea+=20;
				if($empresa[EMP_CONTRIBUYENTE] > 0)
				{
					printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: ".$empresa[EMP_CONTRIBUYENTE], 0,$linea);
					$linea+=20;
				}
                if($empresa[EMP_MICROEMPRESA] > 0)
                {
                    printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                    $linea+=15;
                }
				printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, "AMBIENTE: ".$empresa[ambiente], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, "EMISION: ".$empresa[emision], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, "Obligado a llevar contabilidad: ".$empresa[obligado], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLAVE DE ACCESO: ', 0,$linea);
				$linea+=20;
				printer_draw_text($handle, substr($venta[CLA_CLAVE],0,38), 0,$linea);
				$linea+=20;
				printer_draw_text($handle, substr($venta[CLA_CLAVE],38), 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'AUTORIZACION: ', 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $venta[VEN_AUTORIZACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'FECHA AUTORIZACION: ', 0,$linea);
				$linea+=20;
				printer_draw_text($handle, $venta[CLA_FECHA], 0,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, 'SUB', 0, $linea);
				printer_draw_text($handle, 'CAN', 210, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				$valsubsidio = 0;
				$valprecio = 0;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
				    if(trim($detalle[$i][ITE_COMPLEMENTARIO]) != "")
				    {
				    	$valsubsidio += $detalle[$i][ITE_COMPLEMENTARIO] * $detalle[$i][VED_CANTIDAD];
				    	$valprecio += $detalle[$i][VED_VALOR];
				    }
					$linea+=20;
					printer_draw_text($handle,$detalle[$i][ITE_COMPLEMENTARIO],$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}

				$linea+= 40;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "ICE : ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_ICE],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_ICE],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				$linea+=30;
				if($valsubsidio > 0)
				{
					printer_draw_text($handle, "----------------------------------",0,$linea);
					$linea+=20;
					printer_draw_text($handle, "VALOR TOTAL SIN SUBSIDIO: $  ".number_format($valsubsidio,2,'.',''),0, $linea);
					$linea+=20;
					printer_draw_text($handle, "AHORRO POR SUBSIDIO     : $  ".number_format($valsubsidio-$valprecio,2,'.',''),0, $linea);
					$linea+=20;
					printer_draw_text($handle, "----------------------------------",0,$linea);
				}
				$linea+=20;
				$linea+=30;
				printer_draw_text($handle, "Puedes descargar tu factura en:",0,$linea);
				$linea+=20;
				printer_draw_text($handle, "www.acatha.com/edocs",0,$linea);
				$linea+=30;
				printer_draw_text($handle, "------------------------------------",0,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
				printer_close($handle);
			}
			return true;
		}

		if($archivo == "facturacionticketera76x189.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			for($j=0; $j < 2; $j++)
			{
				$linea = 60;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 210, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				$linea = 800;
				printer_draw_text($handle, "SUBTOT NO IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				if($venta[VEN_SERVICIOS] > 0)
				{
					printer_draw_text($handle, "SERV 10%.: ",130,$linea);
					$addTotales = (8 - strlen(number_format($venta[VEN_SERVICIOS],2,'.',''))) * 10;
					printer_draw_text($handle, number_format($venta[VEN_SERVICIOS],2,'.',''),280 + $addTotales,$linea);
					$linea+=20;
				}
				printer_draw_text($handle, "TOTAL: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    //$linea = 1100;
				    $linea = 1070;
				}else{
				    //$linea = 1020;
				    $linea = 1040;
				}
				sleep(4);
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
				sleep(4);
			}
			printer_close($handle);
			return true;
		}

		if($archivo == "facturacionticketera76x189comandas.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			for($j=0; $j < 2; $j++)
			{
				$linea = 60;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 210, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				$linea = 800;
				printer_draw_text($handle, "SUBTOT NO IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    //$linea = 1100;
				    $linea = 1070;
				}else{
				    //$linea = 1020;
				    $linea = 1040;
				}
				sleep(4);
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
				sleep(4);
			}
			printer_close($handle);

			$handle = printer_open("COMANDAS");
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}

			for($j=0; $j < 1; $j++)
			{
				$linea = 50;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA:'.$ciudad.",". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $linea+=20;
				}
				if($j == 0)
				{
				    $linea = 619;
				}else{
				    $linea = 574;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}

		if($archivo == "facturacionticketeraPREFACTURA.php")
		{
			$handle = printer_open($impresora);
			$linea = 10;
			printer_start_doc($handle, "ORDEN NRO".$venta[ORD_NUMERO]);
			printer_start_page($handle);
			$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
			printer_select_font($handle, $font);
			printer_draw_text($handle, "Orden Nro: ".$venta[ORD_NUMERO],0,$linea);
			$linea+=20;
			printer_draw_text($handle, "Mesa Nro: ".$venta[MES_NUMERO],0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'FECHA: '.$venta[FECHA], 0,$linea);
			$linea+=20;
			//printer_draw_text($handle, 'CED./RUC: '. $detCliente->CLI_IDENTIFICACION, 0,$linea);
			$linea+=20;
			$colCod = 0;
			$colCan = 210;
			$colPVP = 250;
			$colTot = 330;
			printer_draw_text($handle, 'COD', 0, $linea);
			printer_draw_text($handle, 'CAN', 210, $linea);
			printer_draw_text($handle, 'PVP', 285, $linea);
			printer_draw_text($handle, 'TOTAL', 350, $linea);
			$linea+=20;
			for($i = 0; $i < count($detalle); $i++)
			{
			    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
				$linea+=20;
				//printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
				$addCan = (3 - strlen(intval($detalle[$i][ODE_CANTIDAD]))) * 10;
			    printer_draw_text($handle,intval($detalle[$i][ODE_CANTIDAD]),$colCan + $addCan,$linea);
			    $addPVP = (7 - strlen(number_format($detalle[$i][ODE_PRECIO],2,'.',''))) * 10;
			    printer_draw_text($handle,number_format($detalle[$i][ODE_PRECIO],2,'.',''),$colPVP + $addPVP,$linea);
			    $addTot = (7 - strlen(number_format($detalle[$i][ODE_VALOR],2,'.',''))) * 10;
			    printer_draw_text($handle,number_format($detalle[$i][ODE_VALOR],2,'.',''),$colTot+$addTot,$linea);
			    $linea+=20;
			}

			$linea += 20;
			printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[SUBTOTAL0],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
			$linea+=20;
			printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[SUBTOTAL12],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
			$linea+=20;
			printer_draw_text($handle, "DESC: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[DESCUENTO],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[DESCUENTO],2,'.',''),280 + $addTotales, $linea);
			$linea+=20;
			printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[SUBTOTAL],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
			$linea+=20;
			printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[SUBTOTALIVA],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[SUBTOTALIVA],2,'.',''),280 + $addTotales,$linea);
			$linea+=20;
			printer_draw_text($handle, "SERVICIOS: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[SERVICIOS],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[SERVICIOS],2,'.',''),280 + $addTotales,$linea);
			$linea+=20;
			printer_draw_text($handle, "TOTAL: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[TOTAL],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[TOTAL],2,'.',''),280 + $addTotales,$linea);
			$linea+=40;
			printer_draw_text($handle, "NOMBRE: __________________________",0,$linea);
			$linea+=20;
			printer_draw_text($handle, "CED/RUC: _________________________",0,$linea);
			$linea+=20;
			printer_draw_text($handle, "DIRECCION: _______________________ ",0,$linea);
			$linea+=20;
			printer_draw_text($handle, "TELEFONO: ________________________",0,$linea);
			$linea+=20;
			printer_draw_text($handle, "MAIL: ____________________________",0,$linea);
			$linea+=20;
			/*printer_draw_text($handle,"OBSERVACIONES : ",0,$linea);
			$cadena = wordwrap($venta[OBSERVACIONES],40,'\r\n',true);
			$cadena2 = array();
			$cadena2 = explode('\r\n',$cadena);
			for ($k = 0;$k<count($cadena2);$k++)
			{
				printer_draw_text($handle,$cadena2[$k],0,$linea+20);
				$linea +=20;
			}*/
			printer_end_page($handle);
			printer_end_doc($handle);
			printer_close($handle);
			return true;
		}

		if($archivo == "facturacionticketeraCOMANDAS.php")
		{
			$agrupadas = array();
			$linActual = "";
			$existeCom = 0;
			$existeBeb = 0;
			for($i = 0; $i < count($detalle); $i++)
			{
				if($detalle[$i][IMPRESO] == "")
				{
					if($linActual != $detalle[$i][ITE_LINEA_DES])
					{
						if((stripos($linActual,"BEBIDA") !== false || stripos($linActual,"DESAYUNOS") !== false || stripos($linActual,"ALMUERZOS") !== false))
						{
							$existeBeb++;
						}
						if(stripos($linActual,"BEBIDA") === false)
						{
							$existeCom++;
						}
						$temp = array();
						$linActual = $detalle[$i][ITE_LINEA_DES];
						$temp[LINEA] = $linActual;
						array_push($agrupadas,$temp);
					}
				}
			}
			$fecha = getdate();
			$hora = $fecha[hours].":".str_pad($fecha[minutes],2,"0",STR_PAD_LEFT).":".str_pad($fecha[seconds],2,"0",STR_PAD_LEFT);
			//Impresora COMANDAS
			if($existeCom > 0)
			{
				$handle = printer_open("COMANDAS");
				$linea = 30;
				printer_start_doc($handle, "COMANDA".$venta[ORD_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, "Pedido Nro: ".$venta[ORD_NUMERO],0,$linea);
				$linea+=20;
				/*printer_draw_text($handle, "Mesa Nro: ".$venta[MES_NUMERO],0,$linea);
				$linea+=20;*/
				printer_draw_text($handle, "Vdr: ".$venta[USU_NOMBRE],0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'Fecha: '.$venta[FECHA], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'Hora: '.$hora, 0,$linea);
				$linea+=20;
				//printer_draw_text($handle, 'CED./RUC: '. $detCliente->CLI_IDENTIFICACION, 0,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;


				$linActual = "";
				for($a=0; $a < count($agrupadas); $a++)
				{
					if($linActual != $agrupadas[$a][LINEA])
					{
						$linActual = $agrupadas[$a][LINEA];
						if(stripos($agrupadas[$a][LINEA],"BEBIDA") === false)
						{
							printer_draw_text($handle,"___________________________________________",0,$linea);
							$linea+=20;
							printer_draw_text($handle,substr($agrupadas[$a][LINEA],0,40),0,$linea);
							$linea+=20;
						}
					}
					for($i = 0; $i < count($detalle); $i++)
					{
						if($agrupadas[$a][LINEA] == $detalle[$i][ITE_LINEA_DES] && stripos($agrupadas[$a][LINEA],"BEBIDA") === false && $detalle[$i][IMPRESO] == "")
						{
						    printer_draw_text($handle,"(".intval($detalle[$i][ODE_CANTIDAD]).")",0,$linea);
							printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],00,100),40,$linea);
							$linea+=20;
							printer_draw_text($handle,substr($detalle[$i][OBS],0,100),0,$linea);
						    $linea+=20;
						}
					}
				}

				$linea += 40;
				printer_draw_text($handle,"OBSERVACIONES : ",0,$linea);
				$cadena = wordwrap($venta[OBSERVACIONES],40,'\r\n',true);
				$cadena2 = array();
				$cadena2 = explode('\r\n',$cadena);
				for ($k = 0;$k<count($cadena2);$k++)
				{
					printer_draw_text($handle,$cadena2[$k],0,$linea+20);
					$linea +=20;
				}
				$linea +=60;
				printer_draw_text($handle,"___________________________",0,$linea+20);
				printer_end_page($handle);
				printer_end_doc($handle);
				printer_close($handle);
			}
			return true;
		}

		if($archivo == "facturacionticketeraBEBIDAS.php")
		{
			$agrupadas = array();
			$linActual = "";
			$existeCom = 0;
			$existeBeb = 0;
			for($i = 0; $i < count($detalle); $i++)
			{
				if($detalle[$i][IMPRESO] == "")
				{
					if($linActual != $detalle[$i][ITE_LINEA_DES])
					{
						if(stripos($detalle[$i][ITE_LINEA_DES],"BEBIDA") !== false)
						{
							$existeBeb++;
						}
						if(stripos($detalle[$i][ITE_LINEA_DES],"DESAYUNOS") !== false)
						{
							$existeBeb++;
						}
						if(stripos($detalle[$i][ITE_LINEA_DES],"ALMUERZOS") !== false)
						{
							$existeBeb++;
						}
						if(stripos($linActual,"BEBIDA") === false)
						{
							$existeCom++;
						}
						$temp = array();
						$linActual = $detalle[$i][ITE_LINEA_DES];
						$temp[LINEA] = $linActual;
						array_push($agrupadas,$temp);
					}
				}
			}
			$fecha = getdate();
			$hora = $fecha[hours].":".str_pad($fecha[minutes],2,"0",STR_PAD_LEFT).":".str_pad($fecha[seconds],2,"0",STR_PAD_LEFT);
			//Impresora BEBIDAS
			if($existeBeb > 0)
			{
				$handle = printer_open("BEBIDAS");
				$linea = 30;
				printer_start_doc($handle, "BEBIDA".$venta[ORD_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, "Comanda Nro: ".$venta[ORD_NUMERO],0,$linea);
				$linea+=20;
				printer_draw_text($handle, "Mesa Nro: ".$venta[MES_NUMERO],0,$linea);
				$linea+=20;
				printer_draw_text($handle, "Mesero: ".$venta[USU_NOMBRE],0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'Fecha: '.$venta[FECHA], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'Hora: '.$hora, 0,$linea);
				$linea+=20;
				$linActual = "";
				for($a=0; $a < count($agrupadas); $a++)
				{
					if($linActual != $agrupadas[$a][LINEA])
					{
						$linActual = $agrupadas[$a][LINEA];
						if(stripos($agrupadas[$a][LINEA],"BEBIDA") !== false)
						{
							printer_draw_text($handle,substr($agrupadas[$a][LINEA],0,40),0,$linea);
							$linea+=20;
						}
					}
					for($i = 0; $i < count($detalle); $i++)
					{
						if($agrupadas[$a][LINEA] == $detalle[$i][ITE_LINEA_DES] && stripos($agrupadas[$a][LINEA],"BEBIDA") !== false  && $detalle[$i][IMPRESO] == "")
						{
						    printer_draw_text($handle,"(".intval($detalle[$i][ODE_CANTIDAD]).")",0,$linea);
							printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],00,100),40,$linea);
							$linea+=20;
							printer_draw_text($handle,substr($detalle[$i][OBS],0,100),0,$linea);
						    $linea+=20;
						}
						if($agrupadas[$a][LINEA] == $detalle[$i][ITE_LINEA_DES] && stripos($agrupadas[$a][LINEA],"DESAYUNO") !== false  && $detalle[$i][IMPRESO] == "")
						{
						    printer_draw_text($handle,"(".intval($detalle[$i][ODE_CANTIDAD]).")",0,$linea);
							printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],00,100),40,$linea);
							$linea+=20;
							printer_draw_text($handle,substr($detalle[$i][OBS],0,100),0,$linea);
						    $linea+=20;
						}
						if($agrupadas[$a][LINEA] == $detalle[$i][ITE_LINEA_DES] && stripos($agrupadas[$a][LINEA],"ALMUERZO") !== false  && $detalle[$i][IMPRESO] == "")
						{
						    printer_draw_text($handle,"(".intval($detalle[$i][ODE_CANTIDAD]).")",0,$linea);
							printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],00,100),40,$linea);
							$linea+=20;
							printer_draw_text($handle,substr($detalle[$i][OBS],0,100),0,$linea);
						    $linea+=20;
						}
					}
				}
				$linea+=40;
				printer_draw_text($handle,"OBSERVACIONES : ",0,$linea);
				$cadena = wordwrap($venta[OBSERVACIONES],40,'\r\n',true);
				$cadena2 = array();
				$cadena2 = explode('\r\n',$cadena);
				for ($k = 0;$k<count($cadena2);$k++)
				{
					printer_draw_text($handle,$cadena2[$k],0,$linea+20);
					$linea +=20;
				}
				$linea +=60;
				printer_draw_text($handle,"___________________________",0,$linea+20);
				printer_end_page($handle);
				printer_end_doc($handle);
				printer_close($handle);
			}
		}

		if($archivo == "ticketeraAlerta.php")
		{
			$handle = printer_open("COMANDAS");
			$linea = 30;
			printer_start_doc($handle, "ALERTA".$venta[ORD_NUMERO]);
			printer_start_page($handle);
			$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
			printer_select_font($handle, $font);
			printer_draw_text($handle, "Comanda Nro: ".$venta[ORD_NUMERO],0,$linea);
			$linea+=20;
			printer_draw_text($handle, "Mesa Nro: ".$venta[MES_NUMERO],0,$linea);
			$linea+=20;
			printer_draw_text($handle, "Mesero: ".$venta[USU_NOMBRE],0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'Fecha: '.$venta[FECHA], 0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'Hora: '.$hora, 0,$linea);
			$linea+=20;
			printer_draw_text($handle,"OBSERVACIONES : ",0,$linea);
			$cadena = wordwrap($venta[OBSERVACIONES],40,'\r\n',true);
			$cadena2 = array();
			$cadena2 = explode('\r\n',$cadena);
			for ($k = 0;$k<count($cadena2);$k++)
			{
				printer_draw_text($handle,$cadena2[$k],0,$linea+20);
				$linea +=20;
			}
			$linea +=60;
			printer_draw_text($handle,"___________________________",0,$linea+20);
			printer_end_page($handle);
			printer_end_doc($handle);
			printer_close($handle);
			return true;
		}

		if($archivo == "ticketeraPreimpresion.php")
		{
			$handle = printer_open($impresora);

			for($j=0; $j < 1; $j++)
			{
			$linea = 10;
			printer_start_doc($handle, "COMANDA".$venta[ORD_NUMERO]);
			printer_start_page($handle);
			$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
			printer_select_font($handle, $font);
			printer_draw_text($handle, "Comanda Nro: ".$venta[ORD_NUMERO],0,$linea);
			$linea+=20;
			printer_draw_text($handle, "Mesa Nro: ".$venta[MES_NUMERO],0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'FECHA: '.$venta[FECHA], 0,$linea);
			$linea+=20;
			//printer_draw_text($handle, 'CED./RUC: '. $detCliente->CLI_IDENTIFICACION, 0,$linea);
			$linea+=20;
			$colCod = 0;
			$colCan = 210;
			$colPVP = 250;
			$colTot = 330;
			printer_draw_text($handle, 'COD', 0, $linea);
			printer_draw_text($handle, 'CAN', 210, $linea);
			printer_draw_text($handle, 'PVP', 285, $linea);
			printer_draw_text($handle, 'TOTAL', 350, $linea);
			$linea+=20;
			for($i = 0; $i < count($detalle); $i++)
			{
			    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
				$linea+=20;
				//printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
				$addCan = (3 - strlen(intval($detalle[$i][ODE_CANTIDAD]))) * 10;
			    printer_draw_text($handle,intval($detalle[$i][ODE_CANTIDAD]),$colCan + $addCan,$linea);
			    $addPVP = (7 - strlen(number_format($detalle[$i][ODE_PRECIO],2,'.',''))) * 10;
			    printer_draw_text($handle,number_format($detalle[$i][ODE_PRECIO],2,'.',''),$colPVP + $addPVP,$linea);
			    $addTot = (7 - strlen(number_format($detalle[$i][ODE_VALOR],2,'.',''))) * 10;
			    printer_draw_text($handle,number_format($detalle[$i][ODE_VALOR],2,'.',''),$colTot+$addTot,$linea);
			    $linea+=20;
			}

			$linea += 20;
			printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[SUBTOTAL0],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
			$linea+=20;
			printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[SUBTOTAL12],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
			$linea+=20;
			printer_draw_text($handle, "DESC: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[DESCUENTO],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[DESCUENTO],2,'.',''),280 + $addTotales, $linea);
			$linea+=20;
			printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[SUBTOTAL],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
			$linea+=20;
			printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[SUBTOTALIVA],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[SUBTOTALIVA],2,'.',''),280 + $addTotales,$linea);
			$linea+=20;
			printer_draw_text($handle, "SERVICIOS: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[SERVICIOS],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[SERVICIOS],2,'.',''),280 + $addTotales,$linea);
			$linea+=20;
			printer_draw_text($handle, "TOTAL: ",70,$linea);
			$addTotales = (8 - strlen(number_format($venta[TOTAL],2,'.',''))) * 10;
			printer_draw_text($handle, number_format($venta[TOTAL],2,'.',''),280 + $addTotales,$linea);
			$linea+=40;

			printer_draw_text($handle,"OBSERVACIONES : ",0,$linea);
			$cadena = wordwrap($venta[OBSERVACIONES],40,'\r\n',true);
			$cadena2 = array();
			$cadena2 = explode('\r\n',$cadena);
			for ($k = 0;$k<count($cadena2);$k++)
			{
				printer_draw_text($handle,$cadena2[$k],0,$linea+20);
				$linea +=20;
			}
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}

		if($archivo == "facturacionticketeraFMARKET.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}

//			for($j=0; $j < 2; $j++)
			{
				$linea = 30;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=10;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=10;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=10;
				$colCod = 0;
				$colCan = 80;
				$colPVP = 105;
				$colTot = 150;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 80, $linea);
				printer_draw_text($handle, 'PVP', 105, $linea);
				printer_draw_text($handle, 'TOTAL', 150, $linea);
				$linea+=10;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=10;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=10;
				}

				$linea = 340;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),140 + $addTotales, $linea);
				$linea+=10;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),140 + $addTotales,$linea);
				$linea+=10;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),140 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 390;
				}else{
				    $linea = 430;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}


		if($archivo == "facturacionticketera76x140.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}

			for($j=0; $j < 1; $j++)
			{
				$linea = 70;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA:'. $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,16),0,$linea);
					//$linea+=20;
					//printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}

				$linea = 470;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 629;
				}else{
				    $linea = 574;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}

		if($archivo == "facturacionticketera76x140pvp.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}

			for($j=0; $j < 1; $j++)
			{
				$linea = 70;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA:'. $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,16),0,$linea);
					//$linea+=20;
					//printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIOIVA],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIOIVA],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIOIVA]*$detalle[$i][VED_CANTIDAD],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}

				$linea = 470;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 629;
				}else{
				    $linea = 574;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}

		if($archivo == "facturacionticketera76x215.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			for($j=0; $j < 2; $j++)
			{
				$linea = 60;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 210, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				$linea = 800;
				printer_draw_text($handle, "SUBTOT NO IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA 14%: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				if($venta[VEN_SERVICIOS] > 0)
				{
					printer_draw_text($handle, "SERV 10%.: ",130,$linea);
					$addTotales = (8 - strlen(number_format($venta[VEN_SERVICIOS],2,'.',''))) * 10;
					printer_draw_text($handle, number_format($venta[VEN_SERVICIOS],2,'.',''),280 + $addTotales,$linea);
					$linea+=20;
				}
				printer_draw_text($handle, "TOTAL: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    //$linea = 1100;  1070
				    $linea = 1020;
				}else{
				    //$linea = 1020; 1040
				    $linea = 1020;
				}
				sleep(4);
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
				sleep(4);
			}
			printer_close($handle);
			return true;
		}

			if($archivo == "facturacionticketera76x215_SI.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			for($j=0; $j < 1; $j++)
			{
				$linea = 60;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 25, 6, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = date("d/m/Y G:i:s", mktime((date('G')-date('I')),date('i'),date('s'),date("m"), date("d"), date("Y")));
				printer_draw_text($handle, 'FECHA Y HORA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 210, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				$linea = 800;
				printer_draw_text($handle, "SUBTOT NO IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA 14%: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				if($venta[VEN_SERVICIOS] > 0)
				{
					printer_draw_text($handle, "SERV 10%.: ",130,$linea);
					$addTotales = (8 - strlen(number_format($venta[VEN_SERVICIOS],2,'.',''))) * 10;
					printer_draw_text($handle, number_format($venta[VEN_SERVICIOS],2,'.',''),280 + $addTotales,$linea);
					$linea+=20;
				}
				printer_draw_text($handle, "TOTAL: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 0,$linea);
				if($j == 0)
				{
				    //$linea = 1100;  1070
				    $linea = 1020;
				}else{
				    //$linea = 1020; 1040
				    $linea = 1020;
				}
				sleep(4);
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
				sleep(4);
			}
			printer_close($handle);
			return true;
		}

		if($archivo == "facturacionticketera76x215_SIzoom.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			for($j=0; $j < 1; $j++)
			{
				$linea = 60;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 25, 6, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA];
				printer_draw_text($handle, 'FECHA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 210, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				$linea = 800;
				printer_draw_text($handle, "SUBTOT NO IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA 14%: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				if($venta[VEN_SERVICIOS] > 0)
				{
					printer_draw_text($handle, "SERV 10%.: ",130,$linea);
					$addTotales = (8 - strlen(number_format($venta[VEN_SERVICIOS],2,'.',''))) * 10;
					printer_draw_text($handle, number_format($venta[VEN_SERVICIOS],2,'.',''),280 + $addTotales,$linea);
					$linea+=20;
				}
				printer_draw_text($handle, "TOTAL: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    //$linea = 1100;  1070
				    $linea = 1020;
				}else{
				    //$linea = 1020; 1040
				    $linea = 1020;
				}
				sleep(4);
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
				sleep(4);
			}
			printer_close($handle);
			return true;
		}

		if($archivo == "facturacionticketera76x185comanda.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			$fecha = getdate();
			$hora = $fecha[hours]-1 . ":".str_pad($fecha[minutes],2,"0",STR_PAD_LEFT).":".str_pad($fecha[seconds],2,"0",STR_PAD_LEFT);
			for($j=0; $j < 1; $j++)
			{
				$linea = 50;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);

				$font2 = printer_create_font("FontB11", 20, 10, 400, false, false, false, 0);
				printer_select_font($handle, $font2);
				printer_draw_text($handle,"ORDEN: ".$venta[ORD_NUMERO],0,$linea);
				$linea+=30;
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA]." ".$hora;
				printer_draw_text($handle, 'FECHA:'.$ciudad.",". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,26)." - ".substr(utf8_decode($detalle[$i][ITE_COMPLEMENTARIO]),0,11),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_PREPARACION],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}

				$linea = 680;
				printer_draw_text($handle, "SUBTOTAL NO IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL IVA: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA %: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				printer_draw_text($handle, "TOTAL: ",70,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    $linea = 895;
				}else{
				    $linea = 865;
				}
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);

			$handle = printer_open("COMANDAS");
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}

			for($j=0; $j < 1; $j++)
			{
				$linea = 50;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);

				$font2 = printer_create_font("FontB11", 20, 10, 400, false, false, false, 0);
				printer_select_font($handle, $font2);
				printer_draw_text($handle,"ORDEN: ".$venta[ORD_NUMERO],0,$linea);
				$linea+=30;
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = $venta[VEN_FECHA]." ".$hora;
				printer_draw_text($handle, 'FECHA:'.$ciudad.",". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 180;
				$colPVP = 220;
				$colTot = 302;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 180, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr(utf8_decode($detalle[$i][ITE_DESCRIPCION]),0,26)." - ".substr(utf8_decode($detalle[$i][ITE_COMPLEMENTARIO]),0,11),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_PREPARACION],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $linea+=20;
				}

				printer_end_page($handle);
				printer_end_doc($handle);
			}
			printer_close($handle);
			return true;
		}

		if($archivo == "facturacionticketera76x275.php")
		{
			$handle = printer_open($impresora);
			//Realizo busquedas para obtener info
			if($venta[CLI_CODIGO] == 0)
			{
			     $venta[CLI_IDENTIFICACION] = "9999999999999";
			     $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
			     $venta[CLI_DIRECCION] = "S/N";
			     $venta[CLI_TELEFONO] = "";
			}
			for($j=0; $j < 2; $j++)
			{
				$linea = 60;
				printer_start_doc($handle, "COMPROBANTE - ".$venta[VEN_NUMERO]);
				printer_start_page($handle);
				$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
				printer_select_font($handle, $font);
				printer_draw_text($handle, $venta[VEN_TIPODOC_DES].": ".$venta[VEN_ESTABLECIMIENTO]."-".$venta[VEN_PTOEMISION]."-".$venta[VEN_NUMERO],0,$linea);
				$linea+=20;
				$ahora = date("d/m/Y G:i:s", mktime((date('G')-date('I')),date('i'),date('s'),date("m"), date("d"), date("Y")));
				printer_draw_text($handle, 'FECHA Y HORA: '.$ciudad.", ". $ahora, 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CLIENTE: '. $venta[CLI_NOMBRE], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'CED./RUC: '. $venta[CLI_IDENTIFICACION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'DIR.: '. $venta[CLI_DIRECCION], 0,$linea);
				$linea+=20;
				printer_draw_text($handle, 'TEL.: '. $venta[CLI_TELEFONO], 0,$linea);
				printer_draw_text($handle, $venta[VEN_FPAGO_DES], 300,$linea);
				$linea+=20;
				$colCod = 0;
				$colCan = 210;
				$colPVP = 250;
				$colTot = 330;
				printer_draw_text($handle, 'COD', 0, $linea);
				printer_draw_text($handle, 'CAN', 210, $linea);
				printer_draw_text($handle, 'PVP', 250, $linea);
				printer_draw_text($handle, 'TOTAL', 330, $linea);
				$linea+=20;
				for($i = 0; $i < count($detalle); $i++)
				{
				    printer_draw_text($handle,substr($detalle[$i][ITE_DESCRIPCION],0,40),0,$linea);
					$linea+=20;
					printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
					$addCan = (3 - strlen(intval($detalle[$i][VED_CANTIDAD]))) * 10;
				    printer_draw_text($handle,intval($detalle[$i][VED_CANTIDAD]),$colCan + $addCan,$linea);
				    $addPVP = (7 - strlen(number_format($detalle[$i][VED_PUNITARIO],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_PUNITARIO],2,'.',''),$colPVP + $addPVP,$linea);
				    $addTot = (7 - strlen(number_format($detalle[$i][VED_VALOR],2,'.',''))) * 10;
				    printer_draw_text($handle,number_format($detalle[$i][VED_VALOR],2,'.',''),$colTot+$addTot,$linea);
				    $linea+=20;
				}
				$linea = 1131;
				printer_draw_text($handle, "SUBTOT NO IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL0],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL0],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT IVA: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL12],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL12],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "DESC: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_DESCUENTO],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_DESCUENTO],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "SUBTOT: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_SUBTOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_SUBTOTAL],2,'.',''),280 + $addTotales, $linea);
				$linea+=20;
				printer_draw_text($handle, "IVA $IVA%: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_IVA],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_IVA],2,'.',''),280 + $addTotales,$linea);
				$linea+=20;
				if($venta[VEN_SERVICIOS] > 0)
				{
					printer_draw_text($handle, "SERV 10%.: ",130,$linea);
					$addTotales = (8 - strlen(number_format($venta[VEN_SERVICIOS],2,'.',''))) * 10;
					printer_draw_text($handle, number_format($venta[VEN_SERVICIOS],2,'.',''),280 + $addTotales,$linea);
					$linea+=20;
				}
				printer_draw_text($handle, "TOTAL: ",130,$linea);
				$addTotales = (8 - strlen(number_format($venta[VEN_TOTAL],2,'.',''))) * 10;
				printer_draw_text($handle, number_format($venta[VEN_TOTAL],2,'.',''),280 + $addTotales,$linea);
				if($j == 0)
				{
				    //$linea = 1100;  1070
				    $linea = 1420;
				}else{
				    //$linea = 1020; 1040
				    $linea = 1410;
				}
				sleep(4);
				printer_draw_text($handle, "_",70,$linea);
				printer_end_page($handle);
				printer_end_doc($handle);
				sleep(4);
			}
			printer_close($handle);
			return true;
		}

		if($archivo == "ebovedaticketera.php")
		{
			$handle = printer_open("pos");
			$linea = 30;
			printer_start_doc($handle, "EGRESO DE BOVEDA.".$venta[EGR_CODIGO]);
			printer_start_page($handle);
			$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
			printer_select_font($handle, $font);
			printer_draw_text($handle, 'Egreso Boveda #: '. $venta[EGR_CODIGO], 0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'Fecha de Cierre: '. $venta[EGR_FECHA], 0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'Punto de Venta: '. $venta[BOV_ORIGEN_NOM],0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'Aceptado por: '. $venta[EGR_ACEPTADO],0,$linea);
			$linea+=20;
			$linea +=20;
			printer_draw_text($handle, 'DENOMINACION',0,$linea);
			$linea +=20;
			$linea +=20;
			printer_draw_text($handle, 'Billetes',0,$linea);
			printer_draw_text($handle, 'Monedas ',150,$linea);
			$linea +=20;
			printer_draw_text($handle, '$100 :'. $venta[BOV_100],0,$linea);
			printer_draw_text($handle, '0.50 ctvs :'. $venta[BOV_50],150,$linea);
			$linea+=20;
			printer_draw_text($handle, '$50 :'. $venta[BOV_50],0,$linea);
			printer_draw_text($handle, '0.25 ctvs :'. $venta[BOV_025],150,$linea);
			$linea+=20;
			printer_draw_text($handle, '$20 :'. $venta[BOV_20],0,$linea);
			printer_draw_text($handle, '0.10 ctvs :'. $venta[BOV_010],150,$linea);
			$linea+=20;
			printer_draw_text($handle, '$10 :'. $venta[BOV_10],0,$linea);
			printer_draw_text($handle, '0.05 ctvs :'. $venta[BOV_005],150,$linea);
			$linea+=20;
			printer_draw_text($handle, '$5 :'. $venta[BOV_5],0,$linea);
			printer_draw_text($handle, '0.01 ctvs :'. $venta[BOV_001],150,$linea);
			$linea+=20;
			printer_draw_text($handle, '$1 :'. $venta[BOV_1],0,$linea);
			$linea+=20;

			$linea+=20;
			printer_draw_text($handle, 'Total Egresado : $'. $venta[EGR_VALOR],0,$linea);
			printer_end_page($handle);
			printer_end_doc($handle);
			printer_close($handle);

		}
		if($archivo == "Denominacionticketera.php")
		{
			$handle = printer_open($impresora);
			$linea = 10;
			printer_start_doc($handle, "DENOMINACION CIERRE CAJA.".$venta[EGR_CODIGO]);
			printer_start_page($handle);
			$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
			printer_select_font($handle, $font);
			printer_draw_text($handle, 'Cierre de Caja '. $venta[EGR_CONCEPTO], 0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'Fecha de Cierre: '. $venta[EGR_FECHA], 0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'Cajero: '. $venta[EGR_ACEPTADO],0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'Valor Cierre : $'. $venta[EGR_VALOR],0,$linea);
			$linea+=20;
			//printer_draw_text($handle, 'Cierre Total : $'. $venta[BOV_025],0,$linea);
			//$linea+=20;
			printer_draw_text($handle, $venta[BOV_ORIGEN_NOM].' : $'. $venta[BOV_050],0,$linea);
			//printer_draw_text($handle, ' '. $venta[BOV_ORIGEN_NOM],170,$linea);
			printer_end_page($handle);
			printer_end_doc($handle);
			printer_close($handle);

		}
		return false;
	}

	function cuadres($archivo, $host, $cabecera, $totales, $detalle, $impresora, $totalresumen)
	{
		if($archivo == "cuadrecajaTticketeraFact.php")
		{
			$handle = printer_open($impresora);
			$linea = 30;
			printer_start_doc($handle, "CUADRE DE CAJA FACT.".$host);
			printer_start_page($handle);
			$font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
			printer_select_font($handle, $font);
			printer_draw_text($handle, 'Fecha de Cierre: '. $cabecera[fecha], 0,$linea);
			$linea+=20;
			printer_draw_text($handle, 'Punto de Venta: '. $host,0,$linea);
			$linea+=20;
			$colFp = 0;
			$colTot = 300;
			printer_draw_text($handle, 'F.PAGO', $colFp, $linea);
			printer_draw_text($handle, 'TOTAL', $colTot, $linea);
			$linea+=40;

			for($i=0; $i < count($totales); $i++)
			{
				printer_draw_text($handle,$totales[$i][SUB_VALOR],$colFp,$linea);
				$addTot = (7 - strlen(number_format($totales[$i][CCD_VALOR],2,'.',''))) * 10;
			    printer_draw_text($handle,number_format($totales[$i][CCD_VALOR],2,'.',''),$colTot+$addTot,$linea);
			    $linea+=20;
			}
			$linea+=40;

			//Facturas
            printer_draw_text($handle,"TOT. FACTURAS:",$colFp,$linea);
            $addTot = (7 - strlen(number_format($totalresumen[0]['FACTURAS'],2,'.',''))) * 10;
            printer_draw_text($handle,number_format($totalresumen[0]['FACTURAS'],2,'.',''),$colTot+$addTot,$linea);
            $linea+=20;
            //Anticipos
            printer_draw_text($handle,"TOT. ANTICIPOS:",$colFp,$linea);
            $addTot = (7 - strlen(number_format($totalresumen[0]['ANTICIPOS'],2,'.',''))) * 10;
            printer_draw_text($handle,number_format($totalresumen[0]['ANTICIPOS'],2,'.',''),$colTot+$addTot,$linea);
            $linea+=20;

            //Cobros
            printer_draw_text($handle,"TOT. COBROS:",$colFp,$linea);
            $addTot = (7 - strlen(number_format($totalresumen[0]['COBROS'],2,'.',''))) * 10;
            printer_draw_text($handle,number_format($totalresumen[0]['COBROS'],2,'.',''),$colTot+$addTot,$linea);
            $linea+=20;

            //NC
            printer_draw_text($handle,"TOT. NOT CREDITO:",$colFp,$linea);
            $addTot = (7 - strlen(number_format($totalresumen[0]['NC'],2,'.',''))) * 10;
            printer_draw_text($handle,number_format($totalresumen[0]['NC'],2,'.',''),$colTot+$addTot,$linea);
            $linea+=20;

            //Retenciones
            printer_draw_text($handle,"TOT. RETENCIONES:",$colFp,$linea);
            $addTot = (7 - strlen(number_format($totalresumen[0]['RETENCIONES'],2,'.',''))) * 10;
            printer_draw_text($handle,number_format($totalresumen[0]['RETENCIONES'],2,'.',''),$colTot+$addTot,$linea);
            $linea+=20;

            //COMPRAS
            printer_draw_text($handle,"TOT. COMPRAS:",$colFp,$linea);
            $addTot = (7 - strlen(number_format($totalresumen[0]['COMPRAS'],2,'.',''))) * 10;
            printer_draw_text($handle,number_format($totalresumen[0]['COMPRAS'],2,'.',''),$colTot+$addTot,$linea);
            $linea+=20;

			printer_end_page($handle);
			printer_start_page($handle);
			$linea=30;
			printer_draw_text($handle, 'Detalle Facturas',0,$linea);
			$linea+=20;

			/*for($i=0; $i < count($detalle); $i++)
			{
				if($i==65 || $i == 130 || $i == 195)
				{
					printer_end_page($handle);
					printer_start_page($handle);
					$linea=0;
				}
				printer_draw_text($handle,substr($detalle[$i][VEN_TIPODOC_DES],0,10)."   ".$detalle[$i][VEN_NUMERO],$colFp,$linea);
				$addTot = (7 - strlen(number_format($detalle[$i][VEN_TOTAL],2,'.',''))) * 10;
			    printer_draw_text($handle,number_format($detalle[$i][VEN_TOTAL],2,'.','').$detalle[$i][VEN_ESTADO],$colTot+$addTot,$linea);
			    $linea+=20;
			}
			printer_end_page($handle);
			printer_start_page($handle);
			$linea=20;
			printer_draw_text($handle, '(*) Facturas Anuladas',0,$linea);
			$linea+=50;
			printer_draw_text($handle, '___________________',0,$linea);*/
			$linea+=20;
			printer_draw_text($handle, 'Responsable',0,$linea);
			$linea+=20;
			printer_end_page($handle);
			printer_end_doc($handle);
			printer_close($handle);
			return true;
		}
		return false;
	}

	function tarjetas($datos, $impresora)
	{
		$handle = printer_open($impresora);
		$linea = 5;
		printer_start_doc($handle, "TARJETA");
		printer_start_page($handle);
		$font = printer_create_font("Verdana", 60, 20, 1000, false, false, false, 0);
		printer_select_font($handle, $font);

		$linea+=10;
		printer_draw_text($handle,"|1".$datos[GIF_NUMERO]."(".str_replace("�","",$datos[BENEFICIADO]).")".$datos[GIF_HASTA]."|",0,$linea);
		//die("|1".$_POST[GIF_NUMERO]."(".$_POST[BENEFICIADO].")".$_POST[GIF_HASTA]."|");
		$linea+=15;
		if($datos[GIF_TIPO] == 2)
		{
			printer_draw_text($handle,$datos[BENEFICIADO],160,300);
			$beneficiados = "";
			if($datos[NINO] > 0)
			{
				$beneficiados .= $datos[NINO]." Niños ";
			}
			if($datos[ADULTO] > 0)
			{
				$beneficiados .= $datos[ADULTO]." Adultos ";
			}
			printer_draw_text($handle,$beneficiados,150,330);
			$beneficiados = "";
			if($datos[DISCAPACITADO] > 0)
			{
				$beneficiados .= $datos[DISCAPACITADO]." Discapacitados ";
			}
			if($datos[TERCERA] > 0)
			{
				$beneficiados .= $datos[TERCERA]." Ter. Edad ";
			}
			printer_draw_text($handle,$beneficiados,30,360);
		}
		$linea+=30;
		printer_draw_text($handle,$datos[GIF_NUMERO],40,530);
		printer_draw_text($handle,$datos[GIF_HASTA],680,530);

		printer_draw_text($handle, "_",70,$linea);
		printer_end_page($handle);
		printer_end_doc($handle);

		printer_close($handle);
		return true;
	}

	function pedidos($orden, $detalle, $empresa)
    {
        $handle = printer_open("pos");
        //Realizo busquedas para obtener info
        if($orden[CLI_CODIGO] == 0)
        {
            $orden[CLI_IDENTIFICACION] = "9999999999999";
            $orden[CLI_NOMBRE] = "COMSUMIDOR FINAL";
            $orden[CLI_DIRECCION] = "S/N";
            $orden[CLI_TELEFONO] = "";
        }
        for($j=0; $j < 1; $j++)
        {
            $linea = 60;
            printer_start_doc($handle, "COMPROBANTE - ".$orden[ORD_NUMERO]);
            printer_start_page($handle);
            $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
            printer_select_font($handle, $font);
            printer_draw_text($handle, $orden[ORD_NUMERO],0,$linea);
            $linea+=20;
            $ahora = date("d/m/Y G:i:s", mktime((date('G')-date('I')),date('i'),date('s'),date("m"), date("d"), date("Y")));
            printer_draw_text($handle, 'FECHA Y HORA: '.$ahora, 0,$linea);
            $linea+=20;
            printer_draw_text($handle, 'CLIENTE: '. $orden[CLI_NOMBRE], 0,$linea);
            $linea+=20;
            printer_draw_text($handle, 'REF: '. $orden[CLI_RCOMERCIAL], 0,$linea);
            $linea+=20;
            printer_draw_text($handle, 'CED./RUC: '. $orden[CLI_IDENTIFICACION], 0,$linea);
            $linea+=20;
            printer_draw_text($handle, 'DIR.: '. $orden[CLI_DIRECCION], 0,$linea);
            $linea+=20;
            printer_draw_text($handle, 'TEL.: '. $orden[CLI_TELEFONO], 0,$linea);
            $linea+=50;
            printer_draw_text($handle, '-----------------------------------------------', 0,$linea);
            $linea+=20;
            $colCod = 0;
            $colUni = 110;
            $colCan = 200;
            $colPVP = 240;
            $colTot = 330;
            printer_draw_text($handle, 'COD', 0, $linea);
            printer_draw_text($handle, 'UNI', 110, $linea);
            printer_draw_text($handle, 'CAN', 200, $linea);
            printer_draw_text($handle, 'PVP', 280, $linea);
            printer_draw_text($handle, 'TOTAL', 350, $linea);
            $linea+=20;
            printer_draw_text($handle, '-----------------------------------------------', 0,$linea);
            $linea+=20;
            for($i = 0; $i < count($detalle); $i++)
            {
                printer_draw_text($handle,substr($detalle[$i][ITE_BARRAS],0,20),$colCod,$linea);
                $addUni = (3 - strlen(intval(number_format($detalle[$i][ODE_CUENTA],2)))) * 10;
                printer_draw_text($handle,intval(number_format($detalle[$i][ODE_CUENTA],2)),$colUni + $addUni,$linea);
                $addCan = (3 - strlen(number_format($detalle[$i][ODE_CANTIDAD],2))) * 10;
                printer_draw_text($handle,number_format($detalle[$i][ODE_CANTIDAD],2),$colCan + $addCan,$linea);
                $addPVP = (7 - strlen(number_format($detalle[$i][ODE_PRECIO],2,'.',''))) * 10;
                printer_draw_text($handle,number_format($detalle[$i][ODE_PRECIO],2,'.',''),$colPVP + $addPVP,$linea);
                $addTot = (7 - strlen(number_format($detalle[$i][ODE_VALOR],2,'.',''))) * 10;
                printer_draw_text($handle,number_format($detalle[$i][ODE_VALOR],2,'.',''),$colTot+$addTot,$linea);
                $linea+=20;
            }
            $linea +=50;
            printer_draw_text($handle, "TOTAL: ",130,$linea);
            $addTotales = (8 - strlen(number_format($orden[ORD_TOTAL],2,'.',''))) * 10;
            printer_draw_text($handle, number_format($orden[ORD_TOTAL],2,'.',''),280 + $addTotales, $linea);
            $linea+=100;
            printer_draw_text($handle, "Firma:------------------------------",0,$linea);
            $linea+=50;
            printer_draw_text($handle, "Nombre:------------------------------",0,$linea);
            printer_end_page($handle);
            printer_end_doc($handle);
            sleep(4);
        }
        printer_close($handle);
        return true;
    }

    function retenciones($archivo,$venta,$detalle,$impresora,$empresa)
    {
        $IVA = $venta[VEN_ESTADO_DES];
        $linea = 0;
        if ($archivo == "retencionticketeramce.php")
        {
            $handle = printer_open($impresora);
            printer_start_doc($handle, "COMPROBANTE - " . $venta[REC_NUMEROCOMPLETO]);
            printer_start_page($handle);
            $font = printer_create_font("FontB11", 9, 4, 400, false, false, false, 0);
            printer_select_font($handle, $font);
            if($empresa[EMP_ARETENCION] > 0)
            {
                printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001 ", 0,$linea);
                $linea+=30;
            }
            $linea += 20;
            printer_draw_text($handle, "COMPROBANTE DE RETENCION", 0, $linea);
            $linea += 20;
            printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
            $linea+=20;
            printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
            $linea+=20;
            printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
            $linea+=20;
            printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
            $linea+=20;
            if($empresa[EMP_CONTRIBUYENTE] > 0)
            {
                printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: ".$empresa[EMP_CONTRIBUYENTE], 0,$linea);
                $linea+=20;
            }
            if($empresa[EMP_MICROEMPRESA] > 0)
            {
                printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                $linea+=20;
            }
            printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);

            $linea += 20;
            printer_draw_text($handle, "Comprobante Nro:".$venta[REC_NUMEROCOMPLETO], 0, $linea);
            $linea += 20;
            printer_draw_text($handle, "Compra: ". $venta[COM_NUMEROCOMPLETO], 0, $linea);
            $linea += 20;
            printer_draw_text($handle, "Proveedor: ".$venta[PRV_NOMBRE], 0, $linea);
            $linea += 20;
            printer_draw_text($handle, "Identificación:". $venta[PRV_IDENTIFICACION], 0, $linea);
            $linea += 20;
            printer_draw_text($handle, "Aut: $venta[REC_AUTORIZACION]", 0, $linea);
            $linea += 20;
            printer_draw_text($handle, "Fecha: ".$venta[REC_FECHA], 0, $linea);
            $linea += 30;
            $colEje = 0;
            $colBase = 80;
            $colCod = 110;
            $colImp = 200;
            $colPor = 260;
            $colVal = 330;

            $addEje = (3 - strlen("AÑO")) * 10;
            printer_draw_text($handle, "AÑO", $colEje + $addEje, $linea);
            $addBase = (7 - strlen("BASE")) * 10;
            printer_draw_text($handle, "BASE", $colBase + $addBase, $linea);
            $addCod = (7 - strlen("IMPUESTO")) * 10;
            printer_draw_text($handle, "IMPUESTO", $colCod + $addCod, $linea);
            $addImp = (7 - strlen("CODIGO")) * 10;
            printer_draw_text($handle, "CODIGO", $colImp + $addImp, $linea);
            $addPor = (7 - strlen("%")) * 10;
            printer_draw_text($handle, "%", $colPor + $addPor, $linea);
            $addVal = (7 - strlen("VALOR")) * 10;
            printer_draw_text($handle, "VALOR", $colVal + $addVal, $linea);
            $linea += 20;


            for ($i = 0; $i < count($detalle); $i++) {
                if ($detalle[$i][CON_CODIGO] > 10) {
                    $detalle[$i][CON_IMPUESTO] = "RENTA";
                } else {
                    $detalle[$i][CON_IMPUESTO] = "IVA";
                }
                $addEje = (3 - strlen(intval($detalle[$i][EFISCAL]))) * 10;
                printer_draw_text($handle, intval($detalle[$i][EFISCAL]), $colEje + $addEje, $linea);
                $addBase = (7 - strlen(number_format($detalle[$i][BASE], 2, '.', ''))) * 10;
                printer_draw_text($handle, number_format($detalle[$i][BASE], 2, '.', ''), $colBase + $addBase, $linea);
                $addCod = (7 - strlen(number_format($detalle[$i][CON_IMPUESTO], 2, '.', ''))) * 10;
                printer_draw_text($handle, $detalle[$i][CON_IMPUESTO], $colCod + $addCod, $linea);
                $addImp = (7 - strlen(number_format($detalle[$i][CON_CODIGO], 2, '.', ''))) * 10;
                printer_draw_text($handle, $detalle[$i][CON_CODIGO], $colImp + $addImp, $linea);
                $addPor = (7 - strlen(round($detalle[$i][PORCENTAJE], 2) . "%")) * 10;
                printer_draw_text($handle, round($detalle[$i][PORCENTAJE], 2) . "%", $colPor + $addPor, $linea);
                $addVal = (7 - strlen(number_format($detalle[$i][VALOR], 2, '.', ''))) * 10;
                printer_draw_text($handle, number_format($detalle[$i][VALOR], 2, '.', ''), $colVal + $addVal, $linea);
                $linea += 20;
            }
            $linea += 20;
            $addTotales = (8 - strlen(number_format($venta[REC_TOTAL], 2, '.', ''))) * 10;
            printer_draw_text($handle, number_format($venta[REC_TOTAL], 2, '.', ''), 330 + $addTotales, $linea);
            printer_end_page($handle);
            printer_end_doc($handle);
            printer_close($handle);
            return true;
        }

        if ($archivo == "retencionticketeramce3n_star.php")
        {
            $handle = printer_open($impresora);
            printer_start_doc($handle, "COMPROBANTE - " . $venta[REC_NUMEROCOMPLETO]);
            printer_start_page($handle);
            $font = printer_create_font("FontB11", 16, 7, 400, false, false, false, 0);
            printer_select_font($handle, $font);
            if($empresa[EMP_ARETENCION] > 0)
            {
                printer_draw_text($handle, "AGENTE DE RETENCION ", 0,$linea);
                $linea+=20;
                printer_draw_text($handle, "Resolucion Nro. NAC-DNCRASC20-00000001 ", 0,$linea);
                $linea+=25;
            }
            $linea += 20;
            printer_draw_text($handle, "COMPROBANTE DE RETENCION", 0, $linea);
            $linea += 20;
            printer_draw_text($handle, $empresa[EMP_NCOMERCIAL], 0,$linea);
            $linea+=15;
            printer_draw_text($handle, $empresa[EMP_RUC], 0,$linea);
            $linea+=15;
            printer_draw_text($handle, $empresa[EMP_DIRECCION], 0,$linea);
            $linea+=15;
            printer_draw_text($handle, $empresa[EMP_TELEFONO], 0,$linea);
            $linea+=15;
            if($empresa[EMP_CONTRIBUYENTE] > 0)
            {
                printer_draw_text($handle, "CONTRIBUYENTE ESPECIAL: ".$empresa[EMP_CONTRIBUYENTE], 0,$linea);
                $linea+=15;
            }
            if($empresa[EMP_MICROEMPRESA] > 0)
            {
                printer_draw_text($handle, "CONTRIBUYENTE REGIMEN MICROEMPRESA", 0,$linea);
                $linea+=15;
            }
            printer_draw_text($handle, "SUCURSAL: ".$empresa[dirSucursal], 0,$linea);

            $linea += 20;
            printer_draw_text($handle, "Comprobante Nro:".$venta[REC_NUMEROCOMPLETO], 0, $linea);
            $linea += 20;
            printer_draw_text($handle, "Compra: ". $venta[COM_NUMEROCOMPLETO], 0, $linea);
            $linea += 20;
            printer_draw_text($handle, "Proveedor: ".$venta[PRV_NOMBRE], 0, $linea);
            $linea += 20;
            printer_draw_text($handle, "Identificación:". $venta[PRV_IDENTIFICACION], 0, $linea);
            $linea += 20;
            printer_draw_text($handle, "Aut: $venta[REC_AUTORIZACION]", 0, $linea);
            $linea += 20;
            printer_draw_text($handle, "Fecha: ".$venta[REC_FECHA], 0, $linea);
            $linea += 30;
            $colEje = 0;
            $colBase = 80;
            $colCod = 110;
            $colImp = 200;
            $colPor = 260;
            $colVal = 330;

            $addEje = (3 - strlen("AÑO")) * 10;
            printer_draw_text($handle, "AÑO", $colEje + $addEje, $linea);
            $addBase = (7 - strlen("BASE")) * 10;
            printer_draw_text($handle, "BASE", $colBase + $addBase, $linea);
            $addCod = (7 - strlen("IMPUESTO")) * 10;
            printer_draw_text($handle, "IMPUESTO", $colCod + $addCod, $linea);
            $addImp = (7 - strlen("CODIGO")) * 10;
            printer_draw_text($handle, "CODIGO", $colImp + $addImp, $linea);
            $addPor = (7 - strlen("%")) * 10;
            printer_draw_text($handle, "%", $colPor + $addPor, $linea);
            $addVal = (7 - strlen("VALOR")) * 10;
            printer_draw_text($handle, "VALOR", $colVal + $addVal, $linea);
            $linea += 20;


            for ($i = 0; $i < count($detalle); $i++) {
                if ($detalle[$i][CON_CODIGO] > 10) {
                    $detalle[$i][CON_IMPUESTO] = "RENTA";
                } else {
                    $detalle[$i][CON_IMPUESTO] = "IVA";
                }
                $addEje = (3 - strlen(intval($detalle[$i][EFISCAL]))) * 10;
                printer_draw_text($handle, intval($detalle[$i][EFISCAL]), $colEje + $addEje, $linea);
                $addBase = (7 - strlen(number_format($detalle[$i][BASE], 2, '.', ''))) * 10;
                printer_draw_text($handle, number_format($detalle[$i][BASE], 2, '.', ''), $colBase + $addBase, $linea);
                $addCod = (7 - strlen(number_format($detalle[$i][CON_IMPUESTO], 2, '.', ''))) * 10;
                printer_draw_text($handle, $detalle[$i][CON_IMPUESTO], $colCod + $addCod, $linea);
                $addImp = (7 - strlen(number_format($detalle[$i][CON_CODIGO], 2, '.', ''))) * 10;
                printer_draw_text($handle, $detalle[$i][CON_CODIGO], $colImp + $addImp, $linea);
                $addPor = (7 - strlen(round($detalle[$i][PORCENTAJE], 2) . "%")) * 10;
                printer_draw_text($handle, round($detalle[$i][PORCENTAJE], 2) . "%", $colPor + $addPor, $linea);
                $addVal = (7 - strlen(number_format($detalle[$i][VALOR], 2, '.', ''))) * 10;
                printer_draw_text($handle, number_format($detalle[$i][VALOR], 2, '.', ''), $colVal + $addVal, $linea);
                $linea += 20;
            }
            $linea += 20;
            $addTotales = (8 - strlen(number_format($venta[REC_TOTAL], 2, '.', ''))) * 10;
            printer_draw_text($handle, number_format($venta[REC_TOTAL], 2, '.', ''), 330 + $addTotales, $linea);
            printer_end_page($handle);
            printer_end_doc($handle);
            printer_close($handle);
            return true;
        }

        if ($archivo == "retencionticketeraPROLI.php") {
            $handle = printer_open($impresora);
            //Realizo busquedas para obtener info
            if ($venta[CLI_CODIGO] == 0) {
                $venta[CLI_IDENTIFICACION] = "9999999999999";
                $venta[CLI_NOMBRE] = "COMSUMIDOR FINAL";
                $venta[CLI_DIRECCION] = "S/N";
                $venta[CLI_TELEFONO] = "";
            }

            printer_start_doc($handle, "COMPROBANTE - " . $venta[REC_NUMEROCOMPLETO]);
            printer_start_page($handle);
            $font = printer_create_font("Sans Serif", 11, 8, 300, false, false, false, 0);
            printer_select_font($handle, $font);
            $linea = 30;
            printer_draw_text($handle, $venta[REC_NUMEROCOMPLETO], 500, $linea);
            $linea += 95;
            $ahora = $venta[REC_FECHA];
            printer_draw_text($handle, $venta[PRV_NOMBRE], 120, $linea);
            printer_draw_text($handle, $ahora, 650, $linea);
            $linea += 20;
            printer_draw_text($handle, "$venta[PRV_IDENTIFICACION]", 120, $linea);
            printer_draw_text($handle, "$venta[REC_AUTORIZACION]", 750, $linea);
            $linea += 25;
            printer_draw_text($handle, "$venta[CLA_CLAVE]", 150, $linea);
            $linea += 20;
            printer_draw_text($handle, $venta[COM_NUMEROCOMPLETO], 250, $linea);
            $linea += 70;
            $colEje = 80;
            $colBase = 190;
            $colCod = 350;
            $colImp = 600;
            $colPor = 700;
            $colVal = 850;
            for ($i = 0; $i < count($detalle); $i++) {
                if ($detalle[$i][CON_CODIGO] > 10) {
                    $detalle[$i][CON_IMPUESTO] = "RENTA";
                } else {
                    $detalle[$i][CON_IMPUESTO] = "IVA";
                }
                $addEje = (3 - strlen(intval($detalle[$i][EFISCAL]))) * 10;
                printer_draw_text($handle, intval($detalle[$i][EFISCAL]), $colEje + $addEje, $linea);
                $addBase = (7 - strlen(number_format($detalle[$i][BASE], 2, '.', ''))) * 10;
                printer_draw_text($handle, number_format($detalle[$i][BASE], 2, '.', ''), $colBase + $addBase, $linea);
                $addCod = (7 - strlen(number_format($detalle[$i][CON_IMPUESTO], 2, '.', ''))) * 10;
                printer_draw_text($handle, $detalle[$i][CON_IMPUESTO], $colCod + $addCod, $linea);
                $addImp = (7 - strlen(number_format($detalle[$i][CON_CODIGO], 2, '.', ''))) * 10;
                printer_draw_text($handle, $detalle[$i][CON_CODIGO], $colImp + $addImp, $linea);
                $addPor = (7 - strlen(round($detalle[$i][PORCENTAJE], 2) . "%")) * 10;
                printer_draw_text($handle, round($detalle[$i][PORCENTAJE], 2) . "%", $colPor + $addPor, $linea);
                $addVal = (7 - strlen(number_format($detalle[$i][VALOR], 2, '.', ''))) * 10;
                printer_draw_text($handle, number_format($detalle[$i][VALOR], 2, '.', ''), $colVal + $addVal, $linea);
                $linea += 10;
            }
            $linea = 340;
            $addTotales = (8 - strlen(number_format($venta[REC_TOTAL], 2, '.', ''))) * 10;
            printer_draw_text($handle, number_format($venta[REC_TOTAL], 2, '.', ''), 850 + $addTotales, $linea);
            printer_end_page($handle);
            printer_end_doc($handle);
            printer_close($handle);
            return true;
        }
    }
}
?>