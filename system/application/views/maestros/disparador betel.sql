BLOCK1:BEGIN
DECLARE CPP_Codigo INT(11); 
DECLARE CPC_TipoOperacion CHAR(1); 
DECLARE CPC_TipoDocumento CHAR(1); 
DECLARE PRESUP_Codigo INT(11); 
DECLARE OCOMP_Codigo INT(11); 
DECLARE COMPP_Codigo INT(11); 
DECLARE CPC_Serie CHAR(4); 
DECLARE CPC_Numero VARCHAR(11); 
DECLARE CLIP_Codigo INT(11); 
DECLARE PROVP_Codigo INT(11); 
DECLARE CPC_NombreAuxiliar VARCHAR(25); 
DECLARE USUA_Codigo INT(11); 
DECLARE MONED_Codigo INT(11); 
DECLARE FORPAP_Codigo INT(11); 
DECLARE CPC_subtotal DOUBLE(10,2); 
DECLARE CPC_descuento DOUBLE(10,2); 
DECLARE CPC_igv DOUBLE(10,2); 
DECLARE CPC_total DOUBLE(10,2); 
DECLARE CPC_subtotal_conigv DOUBLE(10,2); 
DECLARE CPC_descuento_conigv DOUBLE(10,2); 
DECLARE CPC_igv100 INT(11); 
DECLARE CPC_descuento100 INT(11); 
DECLARE GUIAREMP_Codigo INT(11); 
DECLARE CPC_GuiaRemCodigo VARCHAR(50); 
DECLARE CPC_DocuRefeCodigo VARCHAR(50); 
DECLARE CPC_Observacion TEXT; 
DECLARE CPC_ModoImpresion CHAR(1); 
DECLARE CPC_Fecha DATE; 
DECLARE CPC_Vendedor INT(11); 
DECLARE CPC_TDC DOUBLE(10,2); 
DECLARE CPC_FlagMueveStock CHAR(1); 
DECLARE GUIASAP_Codigo INT(11); 
DECLARE GUIAINP_Codigo INT(11); 
DECLARE USUA_anula INT(11); 
DECLARE CPC_FechaRegistro TIMESTAMP; 
DECLARE CPC_FechaModificacion DATETIME; 
DECLARE CPC_FlagEstado CHAR(1); 
DECLARE CPC_Hora TIME; 
DECLARE ALMAP_Codigo INT(11); 
DECLARE CPP_Codigo_Canje INT(11);
DECLARE CPC_NumeroAutomatico INT(1);

DECLARE FACTURA_CURSOR cursor for 
SELECT 
			  gs.CPP_Codigo AS CPP_Codigo,
			  gs.CPC_TipoOperacion AS CPC_TipoOperacion,
			  gs.CPC_TipoDocumento AS CPC_TipoDocumento,
			  gs.PRESUP_Codigo AS PRESUP_Codigo,
			  gs.OCOMP_Codigo AS OCOMP_Codigo,
			  gs.COMPP_Codigo AS COMPP_Codigo,
			  gs.CPC_Serie AS CPC_Serie,
			  gs.CPC_Numero AS CPC_Numero,
			  gs.CLIP_Codigo AS CLIP_Codigo,
			  gs.PROVP_Codigo AS PROVP_Codigo,
			  gs.CPC_NombreAuxiliar AS CPC_NombreAuxiliar,
			  gs.USUA_Codigo AS USUA_Codigo,
			  gs.MONED_Codigo AS MONED_Codigo,
			  gs.FORPAP_Codigo AS FORPAP_Codigo,
			  gs.CPC_subtotal AS CPC_subtotal,
			  gs.CPC_descuento AS CPC_descuento,
			  gs.CPC_igv AS CPC_igv,
			  gs.CPC_total AS CPC_total,
			  gs.CPC_subtotal_conigv AS CPC_subtotal_conigv,
			  gs.CPC_descuento_conigv AS CPC_descuento_conigv,
			  gs.CPC_igv100 AS CPC_igv100, 
			  gs.CPC_descuento100 AS CPC_descuento100,
			  gs.GUIAREMP_Codigo AS GUIAREMP_Codigo,
			  gs.CPC_GuiaRemCodigo AS CPC_GuiaRemCodigo,
			  gs.CPC_DocuRefeCodigo AS CPC_DocuRefeCodigo,
			  gs.CPC_Observacion AS CPC_Observacion,
			  gs.CPC_ModoImpresion AS CPC_ModoImpresion,
			  gs.CPC_Fecha AS CPC_Fecha,
			  gs.CPC_Vendedor AS CPC_Vendedor,
			  gs.CPC_TDC AS CPC_TDC,
			  gs.CPC_FlagMueveStock AS CPC_FlagMueveStock,
			  gs.GUIASAP_Codigo AS GUIASAP_Codigo,
			  gs.GUIAINP_Codigo AS GUIAINP_Codigo,
			  gs.USUA_anula AS USUA_anula,
			  gs.CPC_FechaRegistro AS CPC_FechaRegistro,
			  gs.CPC_FechaModificacion AS CPC_FechaModificacion,
			  gs.CPC_FlagEstado AS CPC_FlagEstado,
			  gs.CPC_Hora AS CPC_Hora,
			  gs.ALMAP_Codigo AS ALMAP_Codigo,
			  gs.CPP_Codigo_Canje AS CPP_Codigo_Canje,
			  gs.CPC_NumeroAutomatico AS CPC_NumeroAutomatico
FROM cji_comprobante gs WHERE gs.CPP_Codigo = CODIGO_FACTURA;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR = TRUE;
	OPEN FACTURA_CURSOR;
	LOOP1: LOOP
	FETCH FACTURA_CURSOR INTO 
			CPP_Codigo,
			  CPC_TipoOperacion,
			  CPC_TipoDocumento,
			  PRESUP_Codigo,
			  OCOMP_Codigo,
			  COMPP_Codigo,
			  CPC_Serie,
			  CPC_Numero,
			  CLIP_Codigo,
			  PROVP_Codigo,
			  CPC_NombreAuxiliar,
			  USUA_Codigo,
			  MONED_Codigo,
			  FORPAP_Codigo,
			  CPC_subtotal,
			  CPC_descuento,
			  CPC_igv,
			  CPC_total,
			  CPC_subtotal_conigv,
			  CPC_descuento_conigv,
			  CPC_igv100, 
			  CPC_descuento100,
			  GUIAREMP_Codigo,
			  CPC_GuiaRemCodigo,
			  CPC_DocuRefeCodigo,
			  CPC_Observacion,
			  CPC_ModoImpresion,
			  CPC_Fecha,
			  CPC_Vendedor,
			  CPC_TDC,
			  CPC_FlagMueveStock,
			  GUIASAP_Codigo,
			  GUIAINP_Codigo,
			  USUA_anula,
			  CPC_FechaRegistro,
			  CPC_FechaModificacion,
			  CPC_FlagEstado,
			  CPC_Hora,
			  ALMAP_Codigo,
			  CPP_Codigo_Canje,
			  CPC_NumeroAutomatico;
	IF @EJECUTAR THEN
		LEAVE LOOP1;
	END IF;
	SET CPC_Fecha=CURDATE();


		
		IF TRIM(CPC_FlagEstado)='1' THEN
			IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0) THEN
				SELECT "NO INGRESO";
			ELSE
				
				SET @DOCUP_Codigo=(SELECT CD.DOCUP_Codigo FROM cji_documento CD WHERE CD.DOCUC_ABREVI=TRIM(CPC_TipoDocumento) LIMIT 1);
				SET @CUE_TipoCuenta='2';
				IF TRIM(CPC_TipoOperacion)='V' THEN
					SET @CUE_TipoCuenta='1';
				END IF;
				
				SET @CUE_FlagEstadoPago='V';
				SET @CUE_FechaCanc=NULL;
				IF FORPAP_Codigo=1 THEN
					SET @CUE_FlagEstadoPago='C';
					SET @CUE_FechaCanc=NOW();
				END IF;
				
				SET @CUE_Codigo=(SELECT CC.CUE_Codigo FROM cji_cuentas CC WHERE CC.CUE_CodDocumento=CPP_Codigo LIMIT 1);
				
				IF (@CUE_Codigo IS NULL OR @CUE_Codigo=0) THEN
					CALL MANTENIMIENTO_CUENTA(@CUE_Codigo,@CUE_TipoCuenta,@DOCUP_Codigo,CPP_Codigo,MONED_Codigo,CPC_total,CPC_Fecha,@CUE_FlagEstadoPago,@CUE_FechaCanc,COMPP_Codigo,NOW(),NULL,1, 0, NULL, NULL, NULL, NULL, NULL);
				ELSE
					CALL MANTENIMIENTO_CUENTA (@CUE_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,@CUE_FlagEstadoPago,@CUE_FechaCanc,NULL,NOW(),NULL,1, 1, NULL, NULL, NULL, NULL, NULL);

				END IF;
				SET @PAGC_Obs='SALIDA GENERADA';
				IF TRIM(CPC_TipoOperacion)='V' THEN
					SET @PAGC_Obs='INGRESO GENERADO';
				END IF;
				SET @PAGC_Obs=CONCAT(@PAGC_Obs,"AUTOMATICAMENTE POR EL PAGO AL CONTADO");

				SET @PAGC_TDC=(SELECT CT.TIPCAMC_FactorConversion FROM cji_tipocambio CT WHERE CT.TIPCAMC_Fecha=CPC_Fecha AND CT.TIPCAMC_MonedaDestino='2' AND CT.COMPP_Codigo=COMPP_Codigo AND CT.TIPCAMC_FlagEstado='1' LIMIT 1);
				IF FORPAP_Codigo=1 THEN
					SET @PAGP_Codigo='';
					CALL MANTENIMIENTO_PAGO(@PAGP_Codigo,@CUE_TipoCuenta,CPC_Fecha,CLIP_Codigo,PROVP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,'1',NULL,NULL,NULL,NULL,NULL,NULL,'0',@PAGC_Obs,COMPP_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL);
					CALL MANTENIMIENTO_CUENTAPAGO('',@CUE_Codigo,@PAGP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL,NULL,NULL);
				END IF;
				LEAVE LOOP1;
			END IF;
			
		END IF;

		IF (CPC_FlagEstado='2' OR TRIM(CPC_TipoDocumento)='B') THEN
			SET @DOCUP_Codigo=(SELECT CD.DOCUP_Codigo FROM cji_documento CD WHERE CD.DOCUC_ABREVI=TRIM(CPC_TipoDocumento)  LIMIT 1);
			
			SET @NUMERO=0;
			SET @NUMEROAUMENTADO =0;
			SET @SERIECOMPROBANTE=NULL; 
			IF CPC_NumeroAutomatico=10 THEN 
				SELECT CF.CONFIC_Numero,CF.CONFIC_Serie INTO @NUMERO,@SERIECOMPROBANTE
				FROM cji_configuracion CF WHERE CF.COMPP_Codigo=COMPP_Codigo AND CF.DOCUP_Codigo=@DOCUP_Codigo;
				SET @NUMEROAUMENTADO =LPAD(@NUMERO+1,LENGTH(@NUMERO),'0') ;
			ELSE
				SET @NUMEROAUMENTADO=CPC_Numero;
				SET @SERIECOMPROBANTE=CPC_Serie;
			END IF;
			
			
			SET @ESTADOACTUALIZAR ='1';
			IF TRIM(CPC_TipoOperacion)='V' THEN
				CALL MANTENIMIENTO_COMPROBANTE(CODIGO_FACTURA, NULL, NULL, NULL, NULL, NULL,@SERIECOMPROBANTE,@NUMEROAUMENTADO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, @ESTADOACTUALIZAR, NULL, NULL, NULL, 1, NULL, NULL, NULL,NULL);
			END IF;
		
			
			IF TRIM(CPC_TipoOperacion)='V' AND CPC_NumeroAutomatico=1  THEN
				UPDATE  cji_configuracion CF SET CF.CONFIC_Numero=@NUMEROAUMENTADO WHERE CF.COMPP_Codigo=COMPP_Codigo AND  CF.DOCUP_Codigo=@DOCUP_Codigo;
			END IF;
			
			
			SET @CUE_TipoCuenta='2';
			IF TRIM(CPC_TipoOperacion)='V' THEN
				SET @CUE_TipoCuenta='1';
			END IF;
			
			SET @CUE_FlagEstadoPago='V';
			SET @CUE_FechaCanc=NULL;
			IF FORPAP_Codigo=1 THEN
				SET @CUE_FlagEstadoPago='C';
				SET @CUE_FechaCanc=NOW();
			END IF;
			
			SET @CUE_Codigo=(SELECT CC.CUE_Codigo FROM cji_cuentas CC WHERE CC.CUE_CodDocumento=CPP_Codigo LIMIT 1);
			
			IF (@CUE_Codigo IS NULL OR @CUE_Codigo=0)THEN
				CALL MANTENIMIENTO_CUENTA (@CUE_Codigo,@CUE_TipoCuenta,@DOCUP_Codigo,CPP_Codigo,MONED_Codigo,CPC_total,CPC_Fecha,@CUE_FlagEstadoPago,@CUE_FechaCanc,COMPP_Codigo,NOW(),NULL,1, 0, NULL, NULL, NULL, NULL, NULL);
			ELSE
				CALL MANTENIMIENTO_CUENTA (@CUE_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,@CUE_FlagEstadoPago,@CUE_FechaCanc,NULL,NOW(),NULL,1, 1, NULL, NULL, NULL, NULL, NULL);
			END IF;
			
			
			SET @PAGC_Obs='SALIDA GENERADA';
			IF TRIM(CPC_TipoOperacion)='V' THEN
				SET @PAGC_Obs='INGRESO GENERADO';
			END IF;
			SET @PAGC_Obs=CONCAT(@PAGC_Obs,"AUTOMATICAMENTE POR EL PAGO AL CONTADO");
			SET @PAGC_TDC=(SELECT CT.TIPCAMC_FactorConversion FROM cji_tipocambio CT WHERE CT.TIPCAMC_Fecha=CPC_Fecha AND CT.TIPCAMC_MonedaDestino='2' AND CT.COMPP_Codigo=COMPP_Codigo AND CT.TIPCAMC_FlagEstado='1' LIMIT 1);
			IF FORPAP_Codigo=1 THEN
				SET @PAGP_Codigo='';
				CALL MANTENIMIENTO_PAGO(@PAGP_Codigo,@CUE_TipoCuenta,CPC_Fecha,CLIP_Codigo,PROVP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,'1',NULL,NULL,NULL,NULL,NULL,NULL,'0',@PAGC_Obs,COMPP_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL);
				CALL MANTENIMIENTO_CUENTAPAGO('',@CUE_Codigo,@PAGP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL,NULL,NULL);
			END IF;
			
			
			SET @COUNTGUIAREM=(SELECT COUNT(*) FROM cji_comprobante_guiarem CPBGR WHERE CPBGR.CPP_Codigo=CODIGO_FACTURA AND CPBGR.COMPGUI_FlagEstado!=3);
			
			IF (@COUNTGUIAREM IS NOT NULL AND @COUNTGUIAREM<>0) THEN
				CALL MANTENIMIENTO_COMPROBANTE(CODIGO_FACTURA, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0,0,0,NULL, NULL, NULL, @ESTADOACTUALIZAR, NULL, NULL, NULL, 1, NULL, NULL, NULL,NULL);
				
			END IF;
			
			SET @NUMEROAUMENTADO=0;
			SET @CODIGODOCUMENTO=0;
			SET GUIASAP_Codigo='';
			SET GUIAINP_Codigo='';
			IF TRIM(CPC_TipoOperacion)='V' THEN 
				
				SET @CODIGODOCUMENTO=6;
				SET @NUMERO=(SELECT CF.CONFIC_Numero FROM cji_configuracion CF WHERE CF.COMPP_Codigo=COMPP_Codigo AND CF.DOCUP_Codigo=@CODIGODOCUMENTO LIMIT 1);
				SET @NUMEROAUMENTADO =@NUMERO+1;
				
				CALL MANTENIMIENTO_GUIASA(GUIASAP_Codigo,1,CPC_TipoOperacion,ALMAP_Codigo,USUA_Codigo,CLIP_Codigo,NULL,@DOCUP_Codigo,CPC_Fecha,@NUMEROAUMENTADO,CPC_Observacion,NULL,NULL,'',NULL,NULL,NULL,NULL,1,1,0,NULL,NULL,NULL);
				SET CPC_FlagMueveStock=1;
			ELSE
				SET @CODIGODOCUMENTO=5;
				SET @NUMERO=(SELECT CF.CONFIC_Numero FROM cji_configuracion CF WHERE CF.COMPP_Codigo=COMPP_Codigo AND CF.DOCUP_Codigo=@CODIGODOCUMENTO LIMIT 1);
				SET @NUMEROAUMENTADO=@NUMERO+1;
				
				CALL MANTENIMIENTO_GUIAIN(GUIAINP_Codigo,2,ALMAP_Codigo,USUA_Codigo,PROVP_Codigo,NULL,@DOCUP_Codigo,'',@NUMEROAUMENTADO,CPC_Fecha,'',CPC_Observacion,'','','','','',CURDATE(),NULL,1,1,0,NULL,NULL,NULL);
				SET CPC_FlagMueveStock=1;
			END IF;
			
			UPDATE  cji_configuracion CF SET CF.CONFIC_Numero=@NUMEROAUMENTADO WHERE CF.COMPP_Codigo=COMPP_Codigo AND  CF.DOCUP_Codigo=@CODIGODOCUMENTO;
			
			CALL MANTENIMIENTO_COMPROBANTE(CODIGO_FACTURA, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CPC_FlagMueveStock,GUIASAP_Codigo,GUIAINP_Codigo,NULL, NULL, NULL, @ESTADOACTUALIZAR, NULL, NULL, NULL, 1, NULL, NULL, NULL,NULL);
			
			
			BLOCK12:BEGIN
				DECLARE FLAG INT(1);
				DECLARE D_PROD_Codigo INT(11);
				DECLARE D_UNDMED_Codigo INT(11);
				DECLARE D_CPDEC_Cantidad DOUBLE(10,2);
				DECLARE D_CPDEC_GenInd CHAR(1);
				DECLARE D_CPDEC_Pu_ConIgv DOUBLE(10,2);
				DECLARE D_CPDEC_Costo DOUBLE(10,2);
				DECLARE D_CPDEC_Descripcion VARCHAR(150);
				DECLARE D_ALMAP_Codigo INT(11);
				DECLARE TOTALREGISTROD INT(11) DEFAULT (SELECT COUNT(*)	FROM cji_comprobantedetalle CCD	WHERE CCD.CPP_Codigo=CODIGO_FACTURA);
				DECLARE INDICEPOSICIOND INT(11) DEFAULT  0;
				DECLARE COMPROBANTED_CURSOR cursor for 
				SELECT 
				CCD.CPDEC_FlagEstado AS FLAG,
				CCD.PROD_Codigo AS PROD_Codigo,
				CCD.UNDMED_Codigo AS UNDMED_Codigo,
				CCD.CPDEC_Cantidad AS CPDEC_Cantidad,
				CCD.CPDEC_GenInd AS CPDEC_GenInd,
				CCD.CPDEC_Pu_ConIgv AS CPDEC_Pu_ConIgv,
				CCD.CPDEC_Costo AS CPDEC_Costo,
				CCD.CPDEC_Descripcion AS CPDEC_Descripcion,
				CCD.ALMAP_Codigo AS ALMAP_Codigo 
				
				FROM cji_comprobantedetalle CCD
				WHERE CCD.CPP_Codigo=CODIGO_FACTURA;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARDC1 = TRUE;
				OPEN COMPROBANTED_CURSOR;
				LOOP2: LOOP
				FETCH COMPROBANTED_CURSOR INTO FLAG,D_PROD_Codigo,D_UNDMED_Codigo,D_CPDEC_Cantidad,D_CPDEC_GenInd,D_CPDEC_Pu_ConIgv,D_CPDEC_Costo,D_CPDEC_Descripcion,D_ALMAP_Codigo;
				
				IF INDICEPOSICIOND=TOTALREGISTROD THEN
					LEAVE LOOP2;
				END IF;

				IF TRIM(CPC_TipoOperacion)='V' THEN 
					
					CALL MANTENIMIENTO_GUIASADETALLE('',GUIASAP_Codigo,D_PROD_Codigo,D_UNDMED_Codigo ,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Costo,D_CPDEC_Descripcion,NULL,NULL,1,0,NULL,NULL,NULL,D_ALMAP_Codigo);
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=D_PROD_Codigo AND  CPU.UNDMED_Codigo=D_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET D_CPDEC_Cantidad=D_CPDEC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',D_CPDEC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET D_CPDEC_Cantidad=ROUND(D_CPDEC_Cantidad, 3);
							END IF;
						END IF;
					END IF;
					
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=D_PROD_Codigo;
					IF (@ALMPROD_Codigo IS NOT NULL AND  @ALMPROD_Codigo<>0) THEN
					
						IF D_CPDEC_Cantidad<>@ALMPROD_Stock THEN 
							SET @CANTIDADTOTAL=@ALMPROD_Stock-D_CPDEC_Cantidad; 
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)-(D_CPDEC_Cantidad*D_CPDEC_Costo))/@CANTIDADTOTAL;
						END IF;
					
						IF FLAG=0 THEN 
							SET @CANTIDADTOTAL=@ALMPROD_Stock; 
							SET @COSTOPROMEDIO=@ALMPROD_CostoPromedio;
						END IF;
					
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					
						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=D_PROD_Codigo);
						CALL MANTENIMIENTO_PRODUCTO(D_PROD_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL-D_CPDEC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, D_CPDEC_Costo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
					
						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo 
						FROM cji_inventariodetalle CIND
						INNER JOIN cji_inventario CIN ON CIN.INVE_Codigo=CIND.INVE_Codigo
						WHERE CIND.PROD_Codigo=D_PROD_Codigo  AND CIN.ALMAP_Codigo=D_ALMAP_Codigo
						AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1 );
						
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
						
							SET @TIPOVALORIZACION=(SELECT COMP.COMPC_TipoValorizacion FROM cji_compania COMP WHERE COMP.COMPP_Codigo=COMPP_Codigo);
							IF @TIPOVALORIZACION=0 THEN
								SET @COUNTAPL =(SELECT COUNT(*) FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo);
															
								BLOCK2:BEGIN
									DECLARE INDICE INT(11) DEFAULT 0;
									DECLARE CANTIDADTOTAL DOUBLE(10,2) DEFAULT 0;
									DECLARE HECHO INT(1) DEFAULT 0;
									DECLARE ALMALOTP_Codigo INT(11);
									DECLARE LOTP_Codigo INT(11);
									DECLARE ALMALOTC_Cantidad DOUBLE(10,2);
									DECLARE ALMALOTC_Costo DOUBLE(10,2);
									DECLARE ALMACENPROLOTE_CURSOR CURSOR FOR SELECT APL.ALMALOTP_Codigo,APL.LOTP_Codigo,APL.ALMALOTC_Cantidad,APL.ALMALOTC_Costo
									FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo;
									DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR2 = TRUE;
									OPEN ALMACENPROLOTE_CURSOR;
									LOOP21: LOOP
									FETCH ALMACENPROLOTE_CURSOR INTO ALMALOTP_Codigo,LOTP_Codigo,ALMALOTC_Cantidad,ALMALOTC_Costo;
									
									IF (ALMALOTP_Codigo IS NULL OR ALMALOTP_Codigo=0) THEN
										LEAVE LOOP21;
									END IF;
									
									
									IF @EJECUTAR2 THEN
										LEAVE LOOP21;
									END IF;
									SET INDICE=INDICE+1;
								
									
									IF D_CPDEC_Cantidad >= ALMALOTC_Cantidad  THEN 
										SET @TOTALROWS=@COUNTAPL;
										IF @TOTALROWS=INDICE THEN
											SET CANTIDADTOTAL=D_CPDEC_Cantidad;
											SET HECHO=1;
										ELSE
											SET CANTIDADTOTAL=ALMALOTC_Cantidad;
											SET D_CPDEC_Cantidad=D_CPDEC_Cantidad-ALMALOTC_Cantidad;
											SET HECHO=0;
										END IF;
									ELSE 
										SET CANTIDADTOTAL=D_CPDEC_Cantidad;
										SET HECHO=1;
									END IF;
									
										SET @ALMALOTC_Cantidad=0;
										SET @ALMALOTP_Codigo=0;
										SELECT APL.ALMALOTP_Codigo,APL.ALMALOTC_Cantidad INTO @ALMALOTP_Codigo,@ALMALOTC_Cantidad
										FROM cji_almaprolote APL WHERE APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.COMPP_Codigo=COMPP_Codigo AND APL.LOTP_Codigo=LOTP_Codigo;
										
										SET @ALMALOTC_Cantidad=@ALMALOTC_Cantidad-CANTIDADTOTAL;
										CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,NULL,NULL,@ALMALOTC_Cantidad,NULL,'',NULL,1,NULL,NULL,NULL);
										
										IF CANTIDADTOTAL<>0 AND FLAG<>0 THEN 
											SET @CPC_FechaHora=CONCAT(CPC_Fecha,' ',curTime());
											CALL MANTENIMIENTO_KARDEX('',COMPP_Codigo,D_PROD_Codigo,6,2,LOTP_Codigo,GUIASAP_Codigo,'2',@CPC_FechaHora,CANTIDADTOTAL,D_CPDEC_Costo,0,NULL,NULL,NULL,@ALMPROD_Codigo,1);					
										
											IF HECHO=1 THEN
												LEAVE LOOP21;
											END IF;
										END IF;
										
										
									END LOOP LOOP21;
									CLOSE ALMACENPROLOTE_CURSOR;
								END BLOCK2;				
							END IF;
						
						END IF;
						
						
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIESV=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
						AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo);
										
						BLOCKSE1V:BEGIN
							DECLARE INDICESERV INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50);
							
							DECLARE SERIESV_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2V = TRUE;
							OPEN SERIESV_CURSOR;
							LOOPSE21V: LOOP
							FETCH SERIESV_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21V;
							END IF;
							
							IF @EJECUTARSERIE2V THEN
								LEAVE LOOPSE21V;
							END IF;
							SET INDICESERV=INDICESERV+1;
							
							
							SET @SERMOVP_Codigo=NULL;
							SET @ALMPRODSERP_Codigo=NULL;
							CALL MANTENIMIENTO_SERIEMOVIMIENTO(@SERMOVP_Codigo,SERIP_Codigo,2,NULL,GUIASAP_Codigo,0);
							CALL MANTENIMIENTO_ALMACENPRODUCTOSERIE(@ALMPRODSERP_Codigo,@ALMPROD_Codigo,SERIP_Codigo,3);
							
							IF @COUNTASERIESV=INDICESERV THEN
								LEAVE LOOPSE21V;
							END IF;
							
							END LOOP LOOPSE21V;
							CLOSE SERIESV_CURSOR;
						END BLOCKSE1V;	
						
					END IF;
						
					END IF;
				END IF;
					
				IF TRIM(CPC_TipoOperacion)='C' THEN
					
					CALL MANTENIMIENTO_GUIAINDETALLE('',GUIAINP_Codigo,D_PROD_Codigo,D_UNDMED_Codigo ,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu_ConIgv,@CPDEC_Descripcion,NULL,NULL,1,0,NULL,NULL,NULL,D_ALMAP_Codigo);
					
					SET @COSTOPRODUCTO=D_CPDEC_Pu_ConIgv;
					IF  MONED_Codigo<>NULL && MONED_Codigo<>1 THEN
						SET @FACTORCONVERSION=(SELECT TC.TIPCAMC_FactorConversion FROM cji_tipocambio TC WHERE TC.TIPCAMC_MonedaOrigen=1 AND TIPCAMC_MonedaDestino=MONED_Codigo AND TC.COMPP_Codigo=COMPP_Codigo AND TIPCAMC_FlagEstado=1 ORDER BY TIPCAMP_Codigo DESC LIMIT 0,1); 
						IF (@FACTORCONVERSION<>NULL AND  @FACTORCONVERSION<>0) THEN
							SET @COSTOPRODUCTO=D_CPDEC_Pu_ConIgv*@FACTORCONVERSION;
						END IF;	
					END IF;
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=D_PROD_Codigo AND  CPU.UNDMED_Codigo=D_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET D_CPDEC_Cantidad=D_CPDEC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',D_CPDEC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET D_CPDEC_Cantidad=ROUND(D_CPDEC_Cantidad, 3);
							END IF;
						END IF;

					END IF;
					
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=D_PROD_Codigo;
					IF (@ALMPROD_Codigo IS NOT NULL AND  @ALMPROD_Codigo<>0 )THEN
						SET @CANTIDADTOTAL=@ALMPROD_Stock+D_CPDEC_Cantidad;
						IF @CANTIDADTOTAL=0 THEN 
							SET @COSTOPROMEDIO=0;
						ELSE						
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)+(D_CPDEC_Cantidad*D_CPDEC_Pu_ConIgv))/@CANTIDADTOTAL;
						END IF;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					
						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=D_PROD_Codigo LIMIT 0,1);
						CALL MANTENIMIENTO_PRODUCTO(D_PROD_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL+D_CPDEC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, @COSTOPRODUCTO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
						
						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo 
						FROM cji_inventariodetalle CIND
						INNER JOIN cji_inventario CIN ON CIN.INVE_Codigo=CIND.INVE_Codigo
						WHERE CIND.PROD_Codigo=D_PROD_Codigo  AND CIN.ALMAP_Codigo=D_ALMAP_Codigo
						AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1  );
											
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
							SET @LOTP_Codigo='';	
							CALL MANTENIMIENTO_LOTE(@LOTP_Codigo,D_PROD_Codigo,D_CPDEC_Cantidad,@COSTOPRODUCTO,GUIAINP_Codigo,NOW(),NULL,1,0,NULL,NULL,NULL);
							
							SET @ALMALOTC_Cantidad=0;
							SET @ALMALOTP_Codigo=0;

							SELECT APL.ALMALOTC_Cantidad , APL.ALMALOTP_Codigo INTO @ALMALOTC_Cantidad, @ALMALOTP_Codigo
							FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.LOTP_Codigo=@LOTP_Codigo LIMIT 0,1;
							
							
							IF (@ALMALOTP_Codigo IS NOT NULL AND @ALMALOTP_Codigo<>0) THEN
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,
								NULL,NULL,(@ALMALOTC_Cantidad+D_CPDEC_Cantidad),@COSTOPRODUCTO,NOW(),1,1,NULL,NULL,NULL
								);
							ELSE
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,@ALMPROD_Codigo,@LOTP_Codigo,COMPP_Codigo,D_CPDEC_Cantidad,@COSTOPRODUCTO,NOW(),1,0,NULL,NULL,NULL);
							END IF;
							SET @CPC_FechaHora=CONCAT(CPC_Fecha,' ',curTime());
							CALL MANTENIMIENTO_KARDEX('',COMPP_Codigo,D_PROD_Codigo,5,2,@LOTP_Codigo,GUIAINP_Codigo,'1',@CPC_FechaHora,D_CPDEC_Cantidad,@COSTOPRODUCTO,0,NULL,NULL,NULL,@ALMPROD_Codigo,1);
							
						END IF;
					
					ELSE
						SET @CANTIDADTOTAL=D_CPDEC_Cantidad;
						SET @COSTOPROMEDIO=@COSTOPRODUCTO;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',0,NULL,NULL,NULL);
					END IF;
					
					
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIES=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
						AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo);	
						
						BLOCKSE1:BEGIN
							DECLARE INDICESER INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50)	;
							DECLARE SERIES_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2 = TRUE;
							OPEN SERIES_CURSOR;
							LOOPSE21: LOOP
							FETCH SERIES_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21;
							END IF;
							
							IF @EJECUTARSERIE2 THEN
								LEAVE LOOPSE21;
							END IF;
							SET INDICESER=INDICESER+1;
							
							
							SET @SERMOVP_Codigo=NULL;
							SET @ALMPRODSERP_Codigo=NULL;
							CALL MANTENIMIENTO_SERIEMOVIMIENTO(@SERMOVP_Codigo,SERIP_Codigo,1,GUIAINP_Codigo,NULL,0);
							CALL MANTENIMIENTO_ALMACENPRODUCTOSERIE(@ALMPRODSERP_Codigo,@ALMPROD_Codigo,SERIP_Codigo,0);
							
							IF @COUNTASERIES=INDICESER THEN
								LEAVE LOOPSE21;
							END IF;
							
							END LOOP LOOPSE21;
							CLOSE SERIES_CURSOR;
						END BLOCKSE1;	
						
					END IF;
					
					
				END IF;
				SET INDICEPOSICIOND=INDICEPOSICIOND+1;
				END LOOP LOOP2; 
				CLOSE COMPROBANTED_CURSOR;
			END BLOCK12;
			
			
			
		END IF;
	
	END LOOP LOOP1; 
	CLOSE FACTURA_CURSOR;
END BLOCK1