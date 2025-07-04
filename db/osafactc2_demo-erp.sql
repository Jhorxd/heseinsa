-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2023 at 09:35 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osafactc2_demo-erp`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`osafactc2`@`localhost` PROCEDURE `COMPROBANTE_DISPARADOR` (IN `CODIGO_FACTURA` INT(11))  BLOCK1:BEGIN
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
                SET @PAGC_Obs=CONCAT(@PAGC_Obs," AUTOMATICAMENTE POR EL PAGO AL CONTADO");

                SET @PAGC_TDC=(SELECT CT.TIPCAMC_FactorConversion FROM cji_tipocambio CT WHERE CT.TIPCAMC_Fecha=CPC_Fecha AND CT.TIPCAMC_MonedaDestino='2' AND CT.COMPP_Codigo=COMPP_Codigo AND CT.TIPCAMC_FlagEstado='1' LIMIT 1);
                IF FORPAP_Codigo=1 THEN
                    SET @PAGP_Codigo='';
                    CALL MANTENIMIENTO_PAGO(@PAGP_Codigo,@CUE_TipoCuenta,CPC_Fecha,CLIP_Codigo,PROVP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,'1',NULL,NULL,NULL,NULL,NULL,NULL,'0',@PAGC_Obs,COMPP_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL);
                    CALL MANTENIMIENTO_CUENTAPAGO('',@CUE_Codigo,@PAGP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL,NULL,NULL);
                END IF;
                LEAVE LOOP1;
            END IF;
            
        END IF;

        IF (CPC_FlagEstado='2') THEN
            SET @DOCUP_Codigo=(SELECT CD.DOCUP_Codigo FROM cji_documento CD WHERE CD.DOCUC_ABREVI=TRIM(CPC_TipoDocumento) LIMIT 1);
            
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
                CALL MANTENIMIENTO_CUENTA(@CUE_Codigo,@CUE_TipoCuenta,@DOCUP_Codigo,CPP_Codigo,MONED_Codigo,CPC_total,CPC_Fecha,@CUE_FlagEstadoPago,@CUE_FechaCanc,COMPP_Codigo,NOW(),NULL,1, 0, NULL, NULL, NULL, NULL, NULL);
            ELSE
                CALL MANTENIMIENTO_CUENTA(@CUE_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,@CUE_FlagEstadoPago,@CUE_FechaCanc,NULL,NOW(),NULL,1, 1, NULL, NULL, NULL, NULL, NULL);
            END IF;
            
            
            SET @PAGC_Obs='SALIDA GENERADA';
            IF TRIM(CPC_TipoOperacion)='V' THEN
                SET @PAGC_Obs='INGRESO GENERADO';
            END IF;
            SET @PAGC_Obs=CONCAT(@PAGC_Obs," AUTOMATICAMENTE POR EL PAGO AL CONTADO");
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
                SET CPC_FlagMueveStock=1;
            ELSE
                SET @CODIGODOCUMENTO=5;
                SET @NUMERO=(SELECT CF.CONFIC_Numero FROM cji_configuracion CF WHERE CF.COMPP_Codigo=COMPP_Codigo AND CF.DOCUP_Codigo=@CODIGODOCUMENTO LIMIT 1);
                SET @NUMEROAUMENTADO=@NUMERO+1;
                SET CPC_FlagMueveStock=1;
            END IF;
            
            UPDATE  cji_configuracion CF SET CF.CONFIC_Numero=@NUMEROAUMENTADO WHERE CF.COMPP_Codigo=COMPP_Codigo AND  CF.DOCUP_Codigo=@CODIGODOCUMENTO;
            
            CALL MANTENIMIENTO_COMPROBANTE(CODIGO_FACTURA, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CPC_FlagMueveStock,GUIASAP_Codigo,GUIAINP_Codigo,NULL, NULL, NULL, @ESTADOACTUALIZAR, NULL, NULL, NULL, 1, NULL, NULL, NULL,NULL);
            
        END IF;
    
    END LOOP LOOP1; 
    CLOSE FACTURA_CURSOR;
END BLOCK1$$

CREATE DEFINER=`osafactc2`@`localhost` PROCEDURE `MANTENIMIENTO_COMPROBANTE` (IN `CPP_Codigo` INT(11), IN `CPC_TipoOperacion` CHAR(1), IN `CPC_TipoDocumento` CHAR(1), IN `PRESUP_Codigo` INT(11), IN `OCOMP_Codigo` INT(11), IN `COMPP_Codigo` INT(11), IN `CPC_Serie` CHAR(4), IN `CPC_Numero` VARCHAR(11), IN `CLIP_Codigo` INT(11), IN `PROVP_Codigo` INT(11), IN `CPC_NombreAuxiliar` VARCHAR(25), IN `USUA_Codigo` INT(11), IN `MONED_Codigo` INT(11), IN `FORPAP_Codigo` INT(11), IN `CPC_subtotal` DOUBLE(10,2), IN `CPC_descuento` DOUBLE(10,2), IN `CPC_igv` DOUBLE(10,2), IN `CPC_total` DOUBLE(10,2), IN `CPC_subtotal_conigv` DOUBLE(10,2), IN `CPC_descuento_conigv` DOUBLE(10,2), IN `CPC_igv100` INT(11), IN `CPC_descuento100` INT(11), IN `GUIAREMP_Codigo` INT(11), IN `CPC_GuiaRemCodigo` VARCHAR(50), IN `CPC_DocuRefeCodigo` VARCHAR(50), IN `CPC_Observacion` TEXT, IN `CPC_ModoImpresion` CHAR(1), IN `CPC_Fecha` DATE, IN `CPC_Vendedor` INT(11), IN `CPC_TDC` DOUBLE(10,2), IN `CPC_FlagMueveStock` CHAR(1), IN `GUIASAP_Codigo` INT(11), IN `GUIAINP_Codigo` INT(11), IN `USUA_anula` INT(11), IN `CPC_FechaRegistro` TIMESTAMP, IN `CPC_FechaModificacion` DATETIME, IN `CPC_FlagEstado` CHAR(1), IN `CPC_Hora` TIME, IN `ALMAP_Codigo` INT(11), IN `CPP_Codigo_Canje` INT(11), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `CPC_NumeroAutomatico` INT)  BEGIN
  IF REALIZACION=0 THEN
  INSERT INTO cji_comprobante(`CPC_TipoOperacion`,`CPC_TipoDocumento`,`PRESUP_Codigo`,`OCOMP_Codigo`,`COMPP_Codigo`,`CPC_Serie`,`CPC_Numero`,`CLIP_Codigo`,`PROVP_Codigo`,`CPC_NombreAuxiliar`,`USUA_Codigo`,`MONED_Codigo`,`FORPAP_Codigo`,`CPC_subtotal`,`CPC_descuento`,`CPC_igv`,`CPC_total`,`CPC_subtotal_conigv`,`CPC_descuento_conigv`,`CPC_igv100`,`CPC_descuento100`,`GUIAREMP_Codigo`,`CPC_GuiaRemCodigo`,`CPC_DocuRefeCodigo`,`CPC_Observacion`,`CPC_ModoImpresion`,`CPC_Fecha`,`CPC_Vendedor`,`CPC_TDC`,`CPC_FlagMueveStock`,`GUIASAP_Codigo`,`GUIAINP_Codigo`,`USUA_anula`,`CPC_FechaRegistro`,`CPC_FechaModificacion`,`CPC_FlagEstado`,`CPC_Hora`,`ALMAP_Codigo`,`CPP_Codigo_Canje`,`CPC_NumeroAutomatico`,`PROYP_Codigo`,`IMPOR_Nombre`) VALUES (
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
          CURDATE(),
          CPC_FechaModificacion,
          CPC_FlagEstado,
          CPC_Hora,
          ALMAP_Codigo,
          CPP_Codigo_Canje,
          CPC_NumeroAutomatico
          );

  
  
    
    ELSEIF REALIZACION=1 THEN
        IF (CPP_Codigo IS NULL OR CPP_Codigo=0 ) THEN
            SELECT "INGRESAR CPP_Codigo";
        ELSE    
            SET @SQLREALIZAR="UPDATE cji_comprobante gs SET ";
        
            IF (CPC_TipoOperacion IS NULL OR TRIM(CPC_TipoOperacion)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");

            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TipoOperacion='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_TipoOperacion));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (CPC_TipoDocumento IS NULL OR TRIM(CPC_TipoDocumento)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TipoDocumento='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_TipoDocumento));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PRESUP_Codigo IS NULL OR PRESUP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PRESUP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PRESUP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
        
            IF (OCOMP_Codigo IS NULL OR OCOMP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.OCOMP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,OCOMP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
        
            IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
        
            IF (CPC_Serie IS NULL OR TRIM(CPC_Serie)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Serie='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_Serie));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
        
            IF (CPC_Numero IS NULL OR TRIM(CPC_Numero)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Numero='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_Numero));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_NombreAuxiliar IS NULL OR TRIM(CPC_NombreAuxiliar)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_NombreAuxiliar='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_NombreAuxiliar));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (USUA_Codigo IS NULL OR USUA_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (FORPAP_Codigo IS NULL OR FORPAP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.FORPAP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FORPAP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_subtotal IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_subtotal=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_subtotal);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_descuento IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_descuento=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_descuento);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_igv IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_igv=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_igv);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_total IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_total=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_total);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_subtotal_conigv IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_subtotal_conigv=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_subtotal_conigv);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_descuento_conigv IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_descuento_conigv=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_descuento_conigv);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_igv100 IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_igv100=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_igv100);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_descuento100 IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_descuento100=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_descuento100);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (CPC_GuiaRemCodigo IS NULL OR TRIM(CPC_GuiaRemCodigo)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_GuiaRemCodigo='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_GuiaRemCodigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (CPC_DocuRefeCodigo IS NULL OR TRIM(CPC_DocuRefeCodigo)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_DocuRefeCodigo='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_DocuRefeCodigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (CPC_Observacion IS NULL OR TRIM(CPC_Observacion)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Observacion='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_Observacion);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (CPC_ModoImpresion IS NULL OR TRIM(CPC_ModoImpresion)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_ModoImpresion='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_ModoImpresion);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (CPC_Fecha IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Fecha='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_Fecha);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            IF (CPC_Vendedor IS NULL OR CPC_Vendedor=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Vendedor=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_Vendedor);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_TDC IS NULL OR CPC_TDC=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TDC=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_TDC);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (CPC_FlagMueveStock IS NULL OR TRIM(CPC_FlagMueveStock)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FlagMueveStock='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_FlagMueveStock);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIASAP_Codigo IS NULL OR GUIASAP_Codigo=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (USUA_anula IS NULL OR USUA_anula=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_anula=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_anula);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (CPC_FechaRegistro IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FechaRegistro='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_FechaRegistro);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,now());
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            
            IF (CPC_FlagEstado IS NULL OR TRIM(CPC_FlagEstado)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_FlagEstado);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            IF (CPC_Hora IS NULL )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Hora='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_Hora);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            IF (ALMAP_Codigo IS NULL OR ALMAP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPP_Codigo_Canje IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPP_Codigo_Canje=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo_Canje);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPC_NumeroAutomatico IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_NumeroAutomatico=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_NumeroAutomatico);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            
            
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo);
           
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
        
    ELSEIF REALIZACION=2 THEN
        IF (CPP_Codigo IS NULL OR CPP_Codigo=0 ) THEN
            SELECT "INGRESAR CPP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_comprobante gs SET ";
            IF (CPC_FlagEstado IS NULL OR TRIM(CPC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
        
        ELSEIF REALIZACION=3 THEN     
        IF (CPP_Codigo IS NULL OR CPP_Codigo=0 ) THEN
            SELECT "INGRESAR CPP_Codigo";
        ELSE
            SELECT  gs.CPP_Codigo AS CPP_Codigo,
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
              gs.CPP_Codigo_Canje AS CPP_Codigo_Canje
            FROM cji_comprobante gs
            WHERE gs.CPP_Codigo=CPP_Codigo;
        END IF;  
        
        ELSEIF REALIZACION=4 THEN     
        
           SET @SQLREALIZAR="SELECT 
              gs.CPP_Codigo AS CPP_Codigo,
              gs.CPC_TipoOperacion AS CPC_TipoOperacion ,
              gs.CPC_TipoDocumento AS CPC_TipoDocumento ,
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
              gs.CPP_Codigo_Canje AS CPP_Codigo_Canje
            FROM cji_comprobante gs
            WHERE gs.CPC_FlagEstado !=0 ";
            
            
            
            
            IF (CPC_TipoOperacion IS NULL OR TRIM(CPC_TipoOperacion)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TipoOperacion='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_TipoOperacion));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
            
            IF (CPC_TipoDocumento IS NULL OR TRIM(CPC_TipoDocumento)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TipoDocumento='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_TipoDocumento));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
            
            IF (PRESUP_Codigo IS NULL OR PRESUP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PRESUP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PRESUP_Codigo);
            END IF;
        
            IF (OCOMP_Codigo IS NULL OR OCOMP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.OCOMP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,OCOMP_Codigo);
            END IF;
        
            IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
            END IF;
        
            IF (CPC_Serie IS NULL OR TRIM(CPC_Serie)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Serie='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_Serie));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
        
            IF (CPC_Numero IS NULL OR TRIM(CPC_Numero)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Numero='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_Numero));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
            
            IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
            END IF;
            
            IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
            END IF;
            
            IF (CPC_NombreAuxiliar IS NULL OR TRIM(CPC_NombreAuxiliar)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"UPPER(gs.CPC_NombreAuxiliar) LIKE '%");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UPPER(CPC_NombreAuxiliar));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%' ");
            END IF;
            
            IF (USUA_Codigo IS NULL OR USUA_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_Codigo);
            END IF;
            
            IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
            END IF;

            
            IF (FORPAP_Codigo IS NULL OR FORPAP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.FORPAP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FORPAP_Codigo);
            END IF;
            
            
            

            IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMP_Codigo);
            END IF;

            IF (CPC_GuiaRemCodigo IS NULL OR TRIM(CPC_GuiaRemCodigo)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_GuiaRemCodigo='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_GuiaRemCodigo);
            END IF;
            
            IF (CPC_DocuRefeCodigo IS NULL OR TRIM(CPC_DocuRefeCodigo)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_DocuRefeCodigo='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_DocuRefeCodigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
            
            IF (CPC_Observacion IS NULL OR TRIM(CPC_Observacion)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"UPPER(gs.CPC_Observacion) LIKE '%");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UPPER(CPC_Observacion));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%' ");
            END IF;
            
            IF (CPC_ModoImpresion IS NULL OR TRIM(CPC_ModoImpresion)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_ModoImpresion='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_ModoImpresion);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
            
            
            IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Fecha>='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Fecha<='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            
            IF (CPC_Vendedor IS NULL OR CPC_Vendedor=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Vendedor=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_Vendedor);
            END IF;
            
            IF (CPC_TDC IS NULL OR CPC_TDC=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TDC=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_TDC);
            END IF;

            IF (CPC_FlagMueveStock IS NULL OR TRIM(CPC_FlagMueveStock)="" )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FlagMueveStock='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_FlagMueveStock);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
            
            IF (GUIASAP_Codigo IS NULL OR GUIASAP_Codigo=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAP_Codigo);
            END IF;
            
            IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
            END IF;
            
            IF (USUA_anula IS NULL OR USUA_anula=0 )  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_anula=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_anula);
            END IF;
    


            IF (ALMAP_Codigo IS NULL OR ALMAP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
            END IF;
            
            IF (CPP_Codigo_Canje IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPP_Codigo_Canje=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo_Canje);
            END IF;
            
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.CPP_Codigo ASC;");
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
      
  END IF;
END$$

CREATE DEFINER=`osafactc2`@`localhost` PROCEDURE `MANTENIMIENTO_COMPROBANTEDETALLE` (IN `CPDEP_Codigo` INT(11), IN `CPP_Codigo` INT(11), IN `PROD_Codigo` INT(11), IN `CPDEC_GenInd` CHAR(1), IN `UNDMED_Codigo` INT(11), IN `CPDEC_Cantidad` DOUBLE, IN `CPDEC_Pu` DOUBLE, IN `CPDEC_Subtotal` DOUBLE, IN `CPDEC_Descuento` DOUBLE, IN `CPDEC_Igv` DOUBLE, IN `CPDEC_Total` DOUBLE, IN `CPDEC_Pu_ConIgv` DOUBLE, IN `CPDEC_Subtotal_ConIgv` DOUBLE, IN `CPDEC_Descuento_ConIgv` DOUBLE, IN `CPDEC_Igv100` INT(11), IN `CPDEC_Descuento100` INT(11), IN `CPDEC_Costo` DOUBLE, IN `CPDEC_Descripcion` VARCHAR(250), IN `CPDEC_Observacion` VARCHAR(250), IN `CPDEC_FechaRegistro` TIMESTAMP, IN `CPDEC_FechaModificacion` DATETIME, IN `CPDEC_FlagEstado` CHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `ALMAP_Codigo` INT(11), IN `GUIAREMP_Codigo` INT(11))  BEGIN
    IF REALIZACION=0 THEN
        INSERT INTO cji_comprobantedetalle(`CPP_Codigo`,`PROD_Codigo`,`CPDEC_GenInd`,`UNDMED_Codigo`,`CPDEC_Cantidad`,`CPDEC_Pu`,`CPDEC_Subtotal`,`CPDEC_Descuento`,`CPDEC_Igv`,`CPDEC_Total`,`CPDEC_Pu_ConIgv`,`CPDEC_Subtotal_ConIgv`,`CPDEC_Descuento_ConIgv`,`CPDEC_Igv100`,`CPDEC_Descuento100`,`CPDEC_Costo`,`CPDEC_Descripcion`,`CPDEC_Observacion`,`CPDEC_FechaRegistro`,`CPDEC_FechaModificacion`,`CPDEC_FlagEstado`,`ALMAP_Codigo`,`GUIAREMP_Codigo`) VALUES (
            CPP_Codigo,
            PROD_Codigo,
            CPDEC_GenInd,
            UNDMED_Codigo,
            CPDEC_Cantidad,
            CPDEC_Pu,
            CPDEC_Subtotal,
            CPDEC_Descuento,
            CPDEC_Igv,
            CPDEC_Total,
            CPDEC_Pu_ConIgv,
            CPDEC_Subtotal_ConIgv,
            CPDEC_Descuento_ConIgv,
            CPDEC_Igv100,
            CPDEC_Descuento100,
            CPDEC_Costo,
            CPDEC_Descripcion,
            CPDEC_Observacion,
            CPDEC_FechaRegistro,
            CPDEC_FechaModificacion,
            CPDEC_FlagEstado,
            ALMAP_Codigo,
            GUIAREMP_Codigo
            );
        
    ELSEIF REALIZACION=1 THEN
        IF (CPDEP_Codigo IS NULL OR CPDEP_Codigo=0 ) THEN
            SELECT "INGRESAR CPDEP_Codigo";
        ELSE    
            SET @SQLREALIZAR="UPDATE cji_comprobantedetalle gs SET ";
            
            IF (CPP_Codigo IS NULL OR CPP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PROD_Codigo IS NULL OR PROD_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            
            IF (CPDEC_GenInd IS NULL OR TRIM(CPDEC_GenInd)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_GenInd='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_GenInd);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            
            IF (UNDMED_Codigo IS NULL OR UNDMED_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.UNDMED_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UNDMED_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPDEC_Cantidad IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Cantidad=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Cantidad);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPDEC_Pu IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Pu=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Pu);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            
            IF (CPDEC_Subtotal IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Subtotal=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Subtotal);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            
            IF (CPDEC_Descuento IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Descuento=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Descuento);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPDEC_Igv IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Igv=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Igv);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;         

            IF (CPDEC_Total IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Total=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Total);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;         
            
            IF (CPDEC_Pu_ConIgv IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Pu_ConIgv=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Pu_ConIgv);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;         
            
            IF (CPDEC_Subtotal_ConIgv IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Subtotal_ConIgv=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Subtotal_ConIgv);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPDEC_Descuento_ConIgv IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Descuento_ConIgv=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Descuento_ConIgv);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

IF (CPDEC_Igv100 IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Igv100=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Igv100);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPDEC_Descuento100 IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Descuento100=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Descuento100);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

IF (CPDEC_Costo IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Costo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Costo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
IF (CPDEC_Descripcion IS NULL OR TRIM(CPDEC_Descripcion)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Descripcion='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Descripcion);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
        
            IF (CPDEC_Observacion IS NULL OR TRIM(CPDEC_Observacion)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Observacion='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Observacion);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
                        
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            
            IF (CPDEC_FlagEstado IS NULL OR TRIM(CPDEC_FlagEstado)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_FlagEstado);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

    SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPDEP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
    ELSEIF REALIZACION=2 THEN
            IF (CPDEP_Codigo IS NULL OR CPDEP_Codigo=0 ) THEN
                SELECT "INGRESAR CPDEP_Codigo";
            ELSE
                SET @SQLREALIZAR="UPDATE cji_comprobantedetalle gs SET ";
                IF (CPDEC_FlagEstado IS NULL OR TRIM(CPDEC_FlagEstado)='')  THEN
                    SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
                ELSE
                    SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FlagEstado='");
                    SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPDEC_FlagEstado));
                    SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
                END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPDEP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
    ELSEIF REALIZACION=3 THEN
        IF (CPDEP_Codigo IS NULL OR CPDEP_Codigo=0 ) THEN
            SELECT "INGRESAR CPDEP_Codigo";
        ELSE
            SELECT    
            gs.CPDEP_Codigo AS CPDEP_Codigo,
            gs.CPP_Codigo AS CPP_Codigo,
            gs.PROD_Codigo AS PROD_Codigo,
            gs.CPDEC_GenInd AS CPDEC_GenInd,
            gs.UNDMED_Codigo AS UNDMED_Codigo,
            gs.CPDEC_Cantidad AS CPDEC_Cantidad,
            gs.CPDEC_Pu AS CPDEC_Pu,
            gs.CPDEC_Subtotal AS CPDEC_Subtotal,
            gs.CPDEC_Descuento AS CPDEC_Descuento,
            gs.CPDEC_Igv AS CPDEC_Igv,
            gs.CPDEC_Total AS CPDEC_Total,
            gs.CPDEC_Pu_ConIgv AS CPDEC_Pu_ConIgv,
            gs.CPDEC_Subtotal_ConIgv AS CPDEC_Subtotal_ConIgv,
            gs.CPDEC_Descuento_ConIgv AS CPDEC_Descuento_ConIgv,
            gs.CPDEC_Igv100 AS CPDEC_Igv100,
            gs.CPDEC_Descuento100 AS CPDEC_Descuento100,
            gs.CPDEC_Costo AS CPDEC_Costo,
            gs.CPDEC_Descripcion AS CPDEC_Descripcion,
            gs.CPDEC_Observacion AS CPDEC_Observacion,
            gs.CPDEC_FechaRegistro AS CPDEC_FechaRegistro,
            gs.CPDEC_FechaModificacion AS CPDEC_FechaModificacion,
            gs.CPDEC_FlagEstado AS CPDEC_FlagEstado
            FROM cji_comprobantedetalle gs
            WHERE gs.CPDEP_Codigo=CPDEP_Codigo;
        END IF;
    ELSEIF REALIZACION=4 THEN
        
        SET @SQLREALIZAR="SELECT    
            gs.CPDEP_Codigo AS CPDEP_Codigo,
            gs.CPP_Codigo AS CPP_Codigo,
            gs.PROD_Codigo AS PROD_Codigo,
            gs.CPDEC_GenInd AS CPDEC_GenInd,
            gs.UNDMED_Codigo AS UNDMED_Codigo,
            gs.CPDEC_Cantidad AS CPDEC_Cantidad,
            gs.CPDEC_Pu AS CPDEC_Pu,
            gs.CPDEC_Subtotal AS CPDEC_Subtotal,
            gs.CPDEC_Descuento AS CPDEC_Descuento,
            gs.CPDEC_Igv AS CPDEC_Igv,
            gs.CPDEC_Total AS CPDEC_Total,
            gs.CPDEC_Pu_ConIgv AS CPDEC_Pu_ConIgv,
            gs.CPDEC_Subtotal_ConIgv AS CPDEC_Subtotal_ConIgv,
            gs.CPDEC_Descuento_ConIgv AS CPDEC_Descuento_ConIgv,
            gs.CPDEC_Igv100 AS CPDEC_Igv100,
            gs.CPDEC_Descuento100 AS CPDEC_Descuento100,
            gs.CPDEC_Costo AS CPDEC_Costo,
            gs.CPDEC_Descripcion AS CPDEC_Descripcion,
            gs.CPDEC_Observacion AS CPDEC_Observacion,
            gs.CPDEC_FechaRegistro AS CPDEC_FechaRegistro,
            gs.CPDEC_FechaModificacion AS CPDEC_FechaModificacion,
            gs.CPDEC_FlagEstado AS CPDEC_FlagEstado
            FROM cji_comprobantedetalle gs WHERE gs.CPDEC_FlagEstado!=0";
            
        IF (CPP_Codigo IS NULL OR CPP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo);
            END IF;
            
            IF (PROD_Codigo IS NULL OR PROD_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);
            END IF;
            
            
            IF (CPDEC_GenInd IS NULL OR TRIM(CPDEC_GenInd)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_GenInd='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_GenInd);
            END IF;
            

            
            IF (UNDMED_Codigo IS NULL OR UNDMED_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.UNDMED_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UNDMED_Codigo);
            END IF;
            

            IF (CPDEC_Descripcion IS NULL OR TRIM(CPDEC_Descripcion)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Descripcion LIKE '%");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Descripcion);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%'");
            END IF;
        
            IF (CPDEC_Observacion IS NULL OR TRIM(CPDEC_Observacion)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Observacion LIKE '%");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Observacion);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%'");
            END IF;
                        
            
            IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FechaRegistro>='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FechaRegistro<='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.CPDEP_Codigo ASC;");

            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
                
    END IF;
END$$

CREATE DEFINER=`osafactc2`@`localhost` PROCEDURE `MANTENIMIENTO_CUENTA` (INOUT `CUE_Codigo` INT(11), IN `CUE_TipoCuenta` INT(11), IN `DOCUP_Codigo` INT(1), IN `CUE_CodDocumento` INT(11), IN `MONED_Codigo` INT(11), IN `CUE_Monto` DOUBLE, IN `CUE_FechaOper` DATE, IN `CUE_FlagEstadoPago` VARCHAR(1), IN `CUE_FechaCanc` DATE, IN `COMPP_Codigo` INT(11), IN `CUE_FechaRegistro` TIMESTAMP, IN `CUE_FechaModificacion` DATETIME, IN `CUE_FlagEstado` VARCHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `FECHAINICIOC` DATE, IN `FECHAFINC` DATE)  BEGIN
    IF REALIZACION=0 THEN
        INSERT INTO cji_cuentas(`CUE_TipoCuenta`,`DOCUP_Codigo`,`CUE_CodDocumento`,`MONED_Codigo`,`CUE_Monto`,`CUE_FechaOper`,`CUE_FlagEstadoPago`,`CUE_FechaCanc`,`COMPP_Codigo`,`CUE_FechaRegistro`,`CUE_FechaModificacion`,`CUE_FlagEstado`) VALUES (
            CUE_TipoCuenta,
            DOCUP_Codigo,
            CUE_CodDocumento,
            MONED_Codigo,
            CUE_Monto,
            CUE_FechaOper,
            CUE_FlagEstadoPago,
            CUE_FechaCanc,
            COMPP_Codigo,
            NOW(),
            CUE_FechaModificacion,
            CUE_FlagEstado
         );
        SET CUE_Codigo=last_insert_id();
    ELSEIF REALIZACION=1 THEN
        IF (CUE_Codigo IS NULL OR CUE_Codigo=0 ) THEN
            SELECT "INGRESAR CUE_Codigo";
        ELSE    
            SET @SQLREALIZAR="UPDATE cji_cuentas gs SET ";
            
            IF (CUE_TipoCuenta IS NULL OR CUE_TipoCuenta=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_TipoCuenta=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_TipoCuenta);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (CUE_CodDocumento IS NULL OR CUE_CodDocumento=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_CodDocumento=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_CodDocumento);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

            IF (CUE_Monto IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_Monto=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_Monto);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (CUE_FechaOper IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaOper='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_FechaOper);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;

            IF (CUE_FlagEstadoPago IS NULL OR TRIM(CUE_FlagEstadoPago)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FlagEstadoPago='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CUE_FlagEstadoPago));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (CUE_FechaCanc IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaCanc='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_FechaCanc);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;

            IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");

            IF (CUE_FlagEstado IS NULL OR TRIM(CUE_FlagEstado)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CUE_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CUE_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_Codigo);
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
    ELSEIF REALIZACION=2 THEN
        IF (CUE_Codigo IS NULL OR CUE_Codigo=0 ) THEN
            SELECT "INGRESAR CUE_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_cuentas gs SET ";
            IF (CUE_FlagEstado IS NULL OR TRIM(CUE_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CUE_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CUE_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
        
        ELSEIF REALIZACION=3 THEN     
        IF (CUE_Codigo IS NULL OR CUE_Codigo=0 ) THEN
            SELECT "INGRESAR CUE_Codigo";
        ELSE
            SELECT  gs.CUE_Codigo AS CUE_Codigo,
                    gs.CUE_TipoCuenta AS CUE_TipoCuenta,
                    gs.DOCUP_Codigo AS DOCUP_Codigo,
                    gs.CUE_CodDocumento AS CUE_CodDocumento,
                    gs.MONED_Codigo AS MONED_Codigo,
                    gs.CUE_Monto AS CUE_Monto,
                    gs.CUE_FechaOper AS CUE_FechaOper,
                    gs.CUE_FlagEstadoPago AS CUE_FlagEstadoPago,
                    gs.CUE_FechaCanc AS CUE_FechaCanc,
                    gs.COMPP_Codigo AS COMPP_Codigo,
                    gs.CUE_FechaRegistro AS CUE_FechaRegistro,
                    gs.CUE_FechaModificacion AS CUE_FechaModificacion,
                    gs.CUE_FlagEstado AS CUE_FlagEstado
            FROM cji_cuentas gs
            WHERE gs.CUE_Codigo=CUE_Codigo;
        END IF;  
        ELSEIF REALIZACION=4 THEN  
            SET @SQLREALIZAR="SELECT 
                    gs.CUE_Codigo AS CUE_Codigo,
                    gs.CUE_TipoCuenta AS CUE_TipoCuenta,
                    gs.DOCUP_Codigo AS DOCUP_Codigo,
                    gs.CUE_CodDocumento AS CUE_CodDocumento,
                    gs.MONED_Codigo AS MONED_Codigo,
                    gs.CUE_Monto AS CUE_Monto,
                    gs.CUE_FechaOper AS CUE_FechaOper,
                    gs.CUE_FlagEstadoPago AS CUE_FlagEstadoPago,
                    gs.CUE_FechaCanc AS CUE_FechaCanc,
                    gs.COMPP_Codigo AS COMPP_Codigo,
                    gs.CUE_FechaRegistro AS CUE_FechaRegistro,
                    gs.CUE_FechaModificacion AS CUE_FechaModificacion,
                    gs.CUE_FlagEstado AS CUE_FlagEstado
            FROM cji_cuentas gs
            WHERE gs.CUE_FlagEstado !=0 ";
            
            IF (CUE_TipoCuenta IS NULL OR CUE_TipoCuenta=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_TipoCuenta=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_TipoCuenta);
            END IF;
            
            IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
            END IF;
            
            IF (CUE_CodDocumento IS NULL OR CUE_CodDocumento=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_CodDocumento=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_CodDocumento);
            END IF;
            
            IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
            END IF;

            
            IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )   THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaOper>='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaOper<='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
                    
            IF (CUE_FlagEstadoPago IS NULL OR TRIM(CUE_FlagEstadoPago)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FlagEstadoPago='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CUE_FlagEstadoPago));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"'");
            END IF;
            
            IF (FECHAINICIOC IS NULL OR TRIM(FECHAINICIOC)='0000-00-00' )   THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaCanc>='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIOC);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFINC IS NULL OR TRIM(FECHAFINC)='0000-00-00')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaCanc<='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFINC);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            
            
            IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
            END IF;
            
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.CUE_Codigo=");
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        
END IF;

END$$

CREATE DEFINER=`osafactc2`@`localhost` PROCEDURE `MANTENIMIENTO_CUENTAPAGO` (IN `CPAGP_Codigo` INT(11), IN `CUE_Codigo` INT(11), IN `PAGP_Codigo` INT(11), IN `CPAGC_TDC` DOUBLE(10,2), IN `CPAGC_Monto` DOUBLE, IN `MONED_Codigo` INT(11), IN `CPAGC_FechaRegistro` TIMESTAMP, IN `CPAGC_FechaModificacion` DATETIME, IN `CPAGC_FlagEstado` VARCHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `FECHAINICIOC` DATE, IN `FECHAFINC` DATE)  BEGIN
    IF REALIZACION=0 THEN
        INSERT INTO cji_cuentaspago(`CUE_Codigo`,`PAGP_Codigo`,`CPAGC_TDC`,`CPAGC_Monto`,`MONED_Codigo`,`CPAGC_FechaRegistro`,`CPAGC_FechaModificacion`,`CPAGC_FlagEstado`) VALUES (
        CUE_Codigo ,
        PAGP_Codigo,


        CPAGC_TDC,
        CPAGC_Monto,
        MONED_Codigo,
        NOW(),
        ' ',
        CPAGC_FlagEstado
         );
        
    ELSEIF REALIZACION=1 THEN
        IF (CPAGP_Codigo IS NULL OR CPAGP_Codigo=0 ) THEN
            SELECT "INGRESAR CPAGP_Codigo";
        ELSE    
            SET @SQLREALIZAR="UPDATE cji_cuentaspago gs SET ";
            
            IF (CUE_Codigo IS NULL OR CUE_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PAGP_Codigo IS NULL OR PAGP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPAGC_TDC IS NULL OR CPAGC_TDC=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_TDC=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_TDC);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPAGC_Monto IS NULL OR CPAGC_Monto=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_Monto=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_Monto);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CPAGC_FechaRegistro IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FechaRegistro='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_FechaRegistro);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            IF (CPAGC_FechaModificacion IS NULL OR TRIM(CPAGC_FechaModificacion)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FechaModificacion='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPAGC_FechaModificacion));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (CPAGC_FlagEstado IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_FlagEstado);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPAGP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGP_Codigo);
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;

    ELSEIF REALIZACION=2 THEN
        IF (CPAGP_Codigo IS NULL OR CPAGP_Codigo=0 ) THEN
            SELECT "INGRESAR CPAGP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_cuentaspago gs SET ";
            IF (CPAGC_FlagEstado IS NULL OR TRIM(CPAGC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPAGC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPAGP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
        
        ELSEIF REALIZACION=3 THEN     
        IF (CPAGP_Codigo IS NULL OR CPAGP_Codigo=0 ) THEN
            SELECT "INGRESAR CPAGP_Codigo";
        ELSE
            SELECT  gs.CPAGP_Codigo AS CPAGP_Codigo,
                    gs.CUE_Codigo AS CUE_Codigo,
                    gs.PAGP_Codigo AS PAGP_Codigo,
                    gs.CPAGC_TDC AS CPAGC_TDC,
                    gs.CPAGC_Monto AS CPAGC_Monto,
                    gs.MONED_Codigo AS MONED_Codigo,
                    gs.CPAGC_FechaRegistro AS CPAGC_FechaRegistro,
                    gs.CPAGC_FechaModificacion AS CPAGC_FechaModificacion,
                    gs.CPAGC_FlagEstado AS CPAGC_FlagEstado
            FROM cji_cuentaspago gs
            WHERE gs.CPAGP_Codigo=CPAGP_Codigo;
        END IF;  
        ELSEIF REALIZACION=4 THEN  
            SET @SQLREALIZAR="SELECT 
                    gs.CPAGP_Codigo AS CPAGP_Codigo,
                    gs.CUE_Codigo AS CUE_Codigo,
                    gs.PAGP_Codigo AS PAGP_Codigo,
                    gs.CPAGC_TDC AS CPAGC_TDC,
                    gs.CPAGC_Monto AS CPAGC_Monto,
                    gs.MONED_Codigo AS MONED_Codigo,
                    gs.CPAGC_FechaRegistro AS CPAGC_FechaRegistro,
                    gs.CPAGC_FechaModificacion AS CPAGC_FechaModificacion,
                    gs.CPAGC_FlagEstado AS CPAGC_FlagEstado
            FROM cji_cuentaspago gs
            WHERE gs.CPAGC_FlagEstado !=0 ";
            
            IF (CUE_Codigo IS NULL OR CUE_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_Codigo);
            END IF;
            
            IF (PAGP_Codigo IS NULL OR PAGP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGP_Codigo);
            END IF;
            
            IF (CPAGC_TDC IS NULL OR CPAGC_TDC=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_TDC=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_TDC);
            END IF;
            
            IF (CPAGC_Monto IS NULL OR CPAGC_Monto=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_Monto=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_Monto);
            END IF;

            IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
            END IF;
            
            IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )   THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FechaRegistro>='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FechaRegistro<='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.CPAGP_Codigo=");
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        
END IF;

END$$

CREATE DEFINER=`osafactc2`@`localhost` PROCEDURE `MANTENIMIENTO_PAGO` (INOUT `PAGP_Codigo` INT(11), IN `PAGC_TipoCuenta` INT(11), IN `PAGC_FechaOper` DATE, IN `CLIP_Codigo` INT(11), IN `PROVP_Codigo` INT(11), IN `PAGC_TDC` DOUBLE(10,2), IN `PAGC_Monto` DOUBLE, IN `MONED_Codigo` INT(11), IN `PAGC_FormaPago` INT(11), IN `PAGC_DepoNro` VARCHAR(50), IN `PAGC_DepoCta` VARCHAR(50), IN `CHEP_Codigo` INT(11), IN `PAGC_Factura` INT(11), IN `PAGC_NotaCredito` INT(11), IN `PAGC_DescObs` TEXT, IN `PAGC_Saldo` DOUBLE(10,2), IN `PAGC_Obs` TEXT, IN `COMPP_Codigo` INT(11), IN `PAGC_FechaRegistro` TIMESTAMP, IN `PAGC_FechaModificacion` DATETIME, IN `PAGC_FlagEstado` VARCHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)  BEGIN
    IF REALIZACION=0 THEN
        INSERT INTO cji_pago(`PAGC_TipoCuenta`,`PAGC_FechaOper`,`CLIP_Codigo`,`PROVP_Codigo`,`PAGC_TDC`,`PAGC_Monto`,`MONED_Codigo`,`PAGC_FormaPago`,`PAGC_DepoNro`,`PAGC_DepoCta`,`CHEP_Codigo`,`PAGC_Factura`,`PAGC_NotaCredito`,`PAGC_DescObs`,`PAGC_Trans`,`PAGC_Saldo`,`PAGC_Obs`,`COMPP_Codigo`,`PAGC_FechaRegistro`,`PAGC_FechaModificacion`,`PAGC_FlagEstado`) VALUES (
              PAGC_TipoCuenta,
              PAGC_FechaOper,
              CLIP_Codigo,
              PROVP_Codigo,
              PAGC_TDC,
              PAGC_Monto,
              MONED_Codigo,
              PAGC_FormaPago,
              PAGC_DepoNro,
              PAGC_DepoCta,
              CHEP_Codigo,
              PAGC_Factura,
              PAGC_NotaCredito,
              PAGC_DescObs,
              '',
              PAGC_Saldo,
              PAGC_Obs,
              COMPP_Codigo,
              NOW(),
              PAGC_FechaModificacion,
              PAGC_FlagEstado
         );
        SET PAGP_Codigo=last_insert_id();
    ELSEIF REALIZACION=1 THEN
        IF (PAGP_Codigo IS NULL OR PAGP_Codigo=0 ) THEN
            SELECT "INGRESAR PAGP_Codigo";
        ELSE    
            SET @SQLREALIZAR="UPDATE cji_pago gs SET ";
            
            IF (PAGC_TipoCuenta IS NULL OR PAGC_TipoCuenta=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_TipoCuenta=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_TipoCuenta);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (PAGC_FechaOper IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FechaOper='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_FechaOper);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

            IF (PAGC_TDC IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_TDC=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_TDC);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (PAGC_Monto IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_Monto=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_Monto);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

            IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (PAGC_FormaPago IS NULL OR PAGC_FormaPago=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FormaPago=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_FormaPago);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (PAGC_DepoNro IS NULL OR TRIM(PAGC_DepoNro)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_DepoNro='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_DepoNro);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (PAGC_DepoCta IS NULL OR TRIM(PAGC_DepoCta)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_DepoCta='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_DepoCta);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (CHEP_Codigo IS NULL OR CHEP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CHEP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CHEP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (PAGC_Factura IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_Factura=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_Factura);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (PAGC_NotaCredito IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_NotaCredito=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_NotaCredito);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

            IF (PAGC_DescObs IS NULL OR TRIM(PAGC_DescObs)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_DescObs='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_DescObs);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (PAGC_Saldo IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_Saldo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_Saldo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (PAGC_Obs IS NULL OR TRIM(PAGC_Obs)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_Obs='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_Obs);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");

            IF (PAGC_FlagEstado IS NULL OR TRIM(PAGC_FlagEstado)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(PAGC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF; 
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.PAGP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGP_Codigo);
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
    ELSEIF REALIZACION=2 THEN
        IF (PAGP_Codigo IS NULL OR PAGP_Codigo=0 ) THEN
            SELECT "INGRESAR PAGP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_pago gs SET ";
            IF (PAGC_FlagEstado IS NULL OR TRIM(PAGC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(PAGC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.PAGP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
        
        ELSEIF REALIZACION=3 THEN     
        IF (PAGP_Codigo IS NULL OR PAGP_Codigo=0 ) THEN
            SELECT "INGRESAR PAGP_Codigo";
        ELSE
            SELECT  
              gs.PAGP_Codigo AS PAGP_Codigo,
              gs.PAGC_TipoCuenta AS PAGC_TipoCuenta,
              gs.PAGC_FechaOper AS PAGC_FechaOper,
              gs.CLIP_Codigo AS CLIP_Codigo,
              gs.PROVP_Codigo AS PROVP_Codigo,
              gs.PAGC_TDC AS PAGC_TDC,
              gs.PAGC_Monto AS PAGC_Monto,
              gs.MONED_Codigo AS MONED_Codigo,
              gs.PAGC_FormaPago AS PAGC_FormaPago,
              gs.PAGC_DepoNro AS PAGC_DepoNro,
              gs.PAGC_DepoCta AS PAGC_DepoCta,
              gs.CHEP_Codigo AS CHEP_Codigo,
              gs.PAGC_Factura AS PAGC_Factura,
              gs.PAGC_NotaCredito AS PAGC_NotaCredito,
              gs.PAGC_DescObs AS PAGC_DescObs,
              gs.PAGC_Saldo AS PAGC_Saldo, 
              gs.PAGC_Obs AS PAGC_Obs,
              gs.COMPP_Codigo AS COMPP_Codigo,
              gs.PAGC_FechaRegistro AS PAGC_FechaRegistro,
              gs.PAGC_FechaModificacion AS PAGC_FechaModificacion,
              gs.PAGC_FlagEstado AS PAGC_FlagEstado
            FROM cji_pago gs
            WHERE gs.PAGP_Codigo=PAGP_Codigo;
        END IF;  
        ELSEIF REALIZACION=4 THEN  
            SET @SQLREALIZAR="SELECT 
                    gs.PAGP_Codigo AS PAGP_Codigo,
                    gs.PAGC_TipoCuenta AS PAGC_TipoCuenta,
                    gs.PAGC_FechaOper AS PAGC_FechaOper,
                    gs.CLIP_Codigo AS CLIP_Codigo,
                    gs.PROVP_Codigo AS PROVP_Codigo,
                    gs.PAGC_TDC AS PAGC_TDC,
                    gs.PAGC_Monto AS PAGC_Monto,
                    gs.MONED_Codigo AS MONED_Codigo,
                    gs.PAGC_FormaPago AS PAGC_FormaPago,
                    gs.PAGC_DepoNro AS PAGC_DepoNro,
                    gs.PAGC_DepoCta AS PAGC_DepoCta,
                    gs.CHEP_Codigo AS CHEP_Codigo,
                    gs.PAGC_Factura AS PAGC_Factura,
                    gs.PAGC_NotaCredito AS PAGC_NotaCredito,
                    gs.PAGC_DescObs AS PAGC_DescObs,
                    gs.PAGC_Saldo AS PAGC_Saldo, 
                    gs.PAGC_Obs AS PAGC_Obs,
                    gs.COMPP_Codigo AS COMPP_Codigo,
                    gs.PAGC_FechaRegistro AS PAGC_FechaRegistro,
                    gs.PAGC_FechaModificacion AS PAGC_FechaModificacion,
                    gs.PAGC_FlagEstado AS PAGC_FlagEstado
            FROM cji_pago gs
            WHERE gs.PAGC_FlagEstado !=0 ";
            
            
            
            
            
            IF (PAGC_TipoCuenta IS NULL OR PAGC_TipoCuenta=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_TipoCuenta=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_TipoCuenta);
            END IF;
            
            
            IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )   THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FechaOper>='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FechaOper<='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
            
            
            IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
            END IF;
            
            IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
            END IF;

            IF (PAGC_TDC IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_TDC=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_TDC);
            END IF;
            

            IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
            END IF;

            
            
            IF (PAGC_FormaPago IS NULL OR PAGC_FormaPago=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FormaPago=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_FormaPago);
            END IF;
            
            IF (PAGC_DepoNro IS NULL OR TRIM(PAGC_DepoNro)="")  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"UPPER(gs.PAGC_DepoNro) LIKE '%");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UPPER(PAGC_DepoNro));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%', ");
            END IF;
            
            
            
            IF (CHEP_Codigo IS NULL OR CHEP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CHEP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CHEP_Codigo);
            END IF;
            
            IF (PAGC_Factura IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_Factura=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_Factura);
            END IF;
            
            IF (PAGC_NotaCredito IS NULL)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_NotaCredito=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_NotaCredito);
            END IF;

            
            IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
            END IF;
            
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.PAGP_Codigo=");
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;

    END IF;
END$$

CREATE DEFINER=`osafactc2`@`localhost` PROCEDURE `MANTENIMIENTO_PRODUCTO` (IN `PROD_Codigo` INT(11), IN `PROD_FlagBienServicio` CHAR(1), IN `FAMI_Codigo` INT(11), IN `TIPPROD_Codigo` INT(11), IN `MARCP_Codigo` INT(11), IN `LINP_Codigo` INT(11), IN `FABRIP_Codigo` INT(11), IN `PROD_PadreCodigo` INT(11), IN `PROD_Nombre` VARCHAR(100), IN `PROD_NombreCorto` VARCHAR(50), IN `PROD_DescripcionBreve` VARCHAR(200), IN `PROD_EspecificacionPDF` VARCHAR(100), IN `PROD_Comentario` TEXT, IN `PROD_Stock` DOUBLE, IN `PROD_StockMinimo` DOUBLE, IN `PROD_StockMaximo` DOUBLE, IN `PROD_CodigoInterno` VARCHAR(100), IN `PROD_CodigoUsuario` VARCHAR(50), IN `PROD_Imagen` VARCHAR(100), IN `PROD_CostoPromedio` DOUBLE, IN `PROD_UltimoCosto` DOUBLE, IN `PROD_Modelo` VARCHAR(150), IN `PROD_Presentacion` VARCHAR(150), IN `PROD_GenericoIndividual` CHAR(1), IN `PROD_FechaUltimaCompra` DATETIME, IN `PROD_FechaRegistro` TIMESTAMP, IN `PROD_FechaModificacion` DATETIME, IN `PROD_FlagActivo` CHAR(1), IN `PROD_FlagEstado` CHAR(1), IN `PROP_Codigo` INT(11), IN `PROD_CodigoOriginal` VARCHAR(50), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)  BEGIN
    IF REALIZACION=0  THEN
        SELECT "FALTA IMPLEMENTAR";
    ELSEIF REALIZACION=1 THEN
        IF (PROD_Codigo IS NULL OR PROD_Codigo=0 ) THEN
            SELECT "INGRESAR PROD_Codigo";
        ELSE    
            SET @SQLREALIZAR="UPDATE cji_producto gs SET ";

            IF (PROD_FlagBienServicio IS NULL OR TRIM(PROD_FlagBienServicio)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_FlagBienServicio='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_FlagBienServicio);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (FAMI_Codigo IS NULL OR FAMI_Codigo=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.FAMI_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FAMI_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (TIPPROD_Codigo IS NULL OR TIPPROD_Codigo=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.TIPPROD_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TIPPROD_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (MARCP_Codigo IS NULL OR MARCP_Codigo=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MARCP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MARCP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (LINP_Codigo IS NULL OR LINP_Codigo=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LINP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LINP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (FABRIP_Codigo IS NULL OR FABRIP_Codigo=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.FABRIP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FABRIP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PROD_PadreCodigo IS NULL OR PROD_PadreCodigo=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_PadreCodigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_PadreCodigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PROD_Nombre IS NULL OR TRIM(PROD_Nombre)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Nombre='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Nombre);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROD_NombreCorto IS NULL OR TRIM(PROD_NombreCorto)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_NombreCorto='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_NombreCorto);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            IF (PROD_DescripcionBreve IS NULL OR TRIM(PROD_DescripcionBreve)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_DescripcionBreve='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_DescripcionBreve);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROD_EspecificacionPDF IS NULL OR TRIM(PROD_EspecificacionPDF)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_EspecificacionPDF='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_EspecificacionPDF);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROD_Comentario IS NULL OR TRIM(PROD_Comentario)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Comentario='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Comentario);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROD_Stock IS NULL OR PROD_Stock=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Stock=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Stock);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PROD_StockMinimo IS NULL OR PROD_StockMinimo=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_StockMinimo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_StockMinimo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PROD_StockMaximo IS NULL OR PROD_StockMaximo=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_StockMaximo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_StockMaximo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PROD_CodigoInterno IS NULL OR TRIM(PROD_CodigoInterno)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_CodigoInterno='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_CodigoInterno);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROD_CodigoUsuario IS NULL OR TRIM(PROD_CodigoUsuario)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_CodigoUsuario='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_CodigoUsuario);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            IF (PROD_Imagen IS NULL OR TRIM(PROD_Imagen)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Imagen='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Imagen);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROD_CostoPromedio IS NULL OR PROD_CostoPromedio=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_CostoPromedio=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_CostoPromedio);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (PROD_UltimoCosto IS NULL OR PROD_UltimoCosto=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_UltimoCosto=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_UltimoCosto);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PROD_Modelo IS NULL OR TRIM(PROD_Modelo)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Modelo='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Modelo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROD_Presentacion IS NULL OR TRIM(PROD_Presentacion)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Presentacion='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Presentacion);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROD_GenericoIndividual IS NULL OR TRIM(PROD_GenericoIndividual)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_GenericoIndividual='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_GenericoIndividual);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROD_FechaUltimaCompra IS NULL OR PROD_FechaUltimaCompra='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_FechaUltimaCompra='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_FechaUltimaCompra);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            IF (PROD_FlagActivo IS NULL OR PROD_FlagActivo='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_FlagActivo='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_FlagActivo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROD_FlagEstado IS NULL OR PROD_FlagEstado='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_FlagEstado);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (PROP_Codigo IS NULL OR PROP_Codigo=0 ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROP_Codigo=");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROP_Codigo);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PROD_CodigoOriginal IS NULL OR TRIM(PROD_CodigoOriginal)='' ) THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_CodigoOriginal='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_CodigoOriginal);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.PROD_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);

            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
            
        END IF;
    ELSEIF REALIZACION=2 THEN
        SELECT "FALTA IMPLEMENTAR";
    ELSEIF REALIZACION=3 THEN
        IF (PROD_Codigo IS NULL OR PROD_Codigo=0 ) THEN
            SELECT "INGRESAR PROD_Codigo";
        ELSE    
            SELECT
              gs.PROD_Codigo AS PROD_Codigo,
              gs.PROD_FlagBienServicio AS PROD_FlagBienServicio,
              gs.FAMI_Codigo AS FAMI_Codigo,
              gs.TIPPROD_Codigo AS TIPPROD_Codigo,
              gs.MARCP_Codigo AS MARCP_Codigo,
              gs.LINP_Codigo AS LINP_Codigo,
              gs.FABRIP_Codigo AS FABRIP_Codigo,
              gs.PROD_PadreCodigo AS PROD_PadreCodigo,
              gs.PROD_Nombre AS PROD_Nombre,
              gs.PROD_NombreCorto AS PROD_NombreCorto,
              gs.PROD_DescripcionBreve AS PROD_DescripcionBreve,
              gs.PROD_EspecificacionPDF AS PROD_EspecificacionPDF,
              gs.PROD_Comentario AS PROD_Comentario,
              gs.PROD_Stock AS PROD_Stock,
              gs.PROD_StockMinimo AS PROD_StockMinimo,
              gs.PROD_StockMaximo AS PROD_StockMaximo,
              gs.PROD_CodigoInterno AS PROD_CodigoInterno,
              gs.PROD_CodigoUsuario AS PROD_CodigoUsuario,
              gs.PROD_Imagen AS PROD_Imagen,
              gs.PROD_CostoPromedio AS PROD_CostoPromedio,
              gs.PROD_UltimoCosto AS PROD_UltimoCosto,
              gs.PROD_Modelo AS PROD_Modelo,
              gs.PROD_Presentacion AS PROD_Presentacion,
              gs.PROD_GenericoIndividual AS PROD_GenericoIndividual,
              gs.PROD_FechaUltimaCompra AS PROD_FechaUltimaCompra,
              gs.PROD_FechaRegistro AS PROD_FechaRegistro,
              gs.PROD_FechaModificacion AS PROD_FechaModificacion,
              gs.PROD_FlagActivo AS PROD_FlagActivo,
              gs.PROD_FlagEstado AS PROD_FlagEstado,
              gs.PROP_Codigo AS PROP_Codigo,
              gs.PROD_CodigoOriginal AS PROD_CodigoOriginal
            FROM cji_producto gs
            WHERE gs.PROD_Codigo=PROD_Codigo;
        END IF;
    ELSEIF REALIZACION=4 THEN
    SELECT "FALTA IMPLEMENTAR";
END IF;
END$$

CREATE DEFINER=`osafactc2`@`localhost` PROCEDURE `MANTENIMIENTO_SERIEDOCUMENTO` (IN `SERDOC_Codigo` INT(11), IN `SERIP_Codigo` INT(11), IN `DOCUP_Codigo` INT(2), IN `SERDOC_NumeroRef` INT(11), IN `TIPOMOV_Tipo` CHAR(1), IN `SERDOC_FechaRegistro` TIMESTAMP, IN `SERDOC_FlagEstado` CHAR(1), IN `REALIZACION` INT(1))  BEGIN
    IF REALIZACION=0  THEN
        INSERT INTO cji_seriedocumento(`SERIP_Codigo`,`DOCUP_Codigo`,`SERDOC_NumeroRef`,`TIPOMOV_Tipo`,`SERDOC_FechaRegistro`,`SERDOC_FlagEstado`) VALUES (
                  SERIP_Codigo,
                  DOCUP_Codigo,
                  SERDOC_NumeroRef,
                  TIPOMOV_Tipo,
                  NOW(),
                  SERDOC_FlagEstado
         );
        SET SERDOC_Codigo=last_insert_id();
    ELSEIF REALIZACION=1 THEN
        SELECT "IMPLEMENTAR";
    ELSEIF REALIZACION=2 THEN
        SELECT "IMPLEMENTAR";
    ELSEIF REALIZACION=3 THEN
        SELECT "IMPLEMENTAR";
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cji_almacen`
--

CREATE TABLE `cji_almacen` (
  `ALMAP_Codigo` int(11) NOT NULL,
  `TIPALM_Codigo` int(11) NOT NULL,
  `EESTABP_Codigo` int(11) NOT NULL,
  `CENCOSP_Codigo` int(11) NOT NULL,
  `ALMAC_Descripcion` varchar(250) DEFAULT NULL,
  `ALMAC_Direccion` varchar(250) DEFAULT NULL,
  `ALMAC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ALMAC_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `ALMAC_FlagEstado` char(1) DEFAULT '1',
  `ALMAC_CodigoUsuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_almacen`
--

INSERT INTO `cji_almacen` (`ALMAP_Codigo`, `TIPALM_Codigo`, `EESTABP_Codigo`, `CENCOSP_Codigo`, `ALMAC_Descripcion`, `ALMAC_Direccion`, `ALMAC_FechaRegistro`, `ALMAC_FechaModificacion`, `COMPP_Codigo`, `ALMAC_FlagEstado`, `ALMAC_CodigoUsuario`) VALUES
(1, 3, 1, 1, 'ALMACEN PRINCIPAL', '', '2023-10-05 22:50:57', NULL, 1, '1', '01'),
(2, 3, 6, 1, 'SUCURSAL', '', '2023-10-09 17:11:16', NULL, 2, '1', '01');

-- --------------------------------------------------------

--
-- Table structure for table `cji_almacenproducto`
--

CREATE TABLE `cji_almacenproducto` (
  `ALMPROD_Codigo` int(11) NOT NULL,
  `ALMAC_Codigo` int(11) DEFAULT NULL,
  `PROD_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `ALMPROD_Stock` double DEFAULT '0',
  `ALMPROD_CostoPromedio` double NOT NULL,
  `ALMPROD_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ALMPROD_FechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_almacenproducto`
--

INSERT INTO `cji_almacenproducto` (`ALMPROD_Codigo`, `ALMAC_Codigo`, `PROD_Codigo`, `COMPP_Codigo`, `ALMPROD_Stock`, `ALMPROD_CostoPromedio`, `ALMPROD_FechaRegistro`, `ALMPROD_FechaModificacion`) VALUES
(1, 1, 2, 1, 50, 0, '2023-10-05 22:51:18', '2023-10-06 12:32:10'),
(2, 1, 3, 1, 35, 0, '2023-10-06 16:10:54', '2023-10-06 16:43:33'),
(3, 1, 4, 1, 10, 0, '2023-10-09 15:11:27', NULL),
(4, 2, 4, 2, 23, 0, '2023-10-09 17:13:28', NULL),
(5, 2, 3, 2, 47, 0, '2023-10-09 17:13:28', '2023-10-09 12:18:33'),
(6, 2, 2, 2, 15, 0, '2023-10-09 17:13:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cji_almacenproductoserie`
--

CREATE TABLE `cji_almacenproductoserie` (
  `ALMPRODSERP_Codigo` int(11) NOT NULL,
  `ALMPROD_Codigo` int(11) NOT NULL,
  `SERIP_Codigo` int(11) NOT NULL,
  `ALMPRODSERC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ALMPRODSERC_Seleccion` varchar(1) NOT NULL,
  `ALMPRODSERC_FechaSeleccion` datetime NOT NULL,
  `ALMPRODSERC_FlagEstado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_almacenproducto_carga`
--

CREATE TABLE `cji_almacenproducto_carga` (
  `ALMAP_Codigo` int(11) DEFAULT NULL,
  `INVE_Codigo` int(11) DEFAULT NULL,
  `PROD_Codigo` int(11) DEFAULT NULL,
  `PROD_CodigoUsuario` varchar(50) NOT NULL,
  `PROD_Nombre` varchar(300) NOT NULL,
  `PROD_Modelo` varchar(150) DEFAULT NULL,
  `PROD_Marca` varchar(50) DEFAULT NULL,
  `ALMPC_Cantidad` float NOT NULL DEFAULT '0',
  `ALMPC_FlagEstado` char(1) NOT NULL DEFAULT '3' COMMENT '1 = Aprobado, 2 = Pendiente, 3 = Por evaluar, 4 = Con error'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla intermedia para carga de productos al almacen';

--
-- Dumping data for table `cji_almacenproducto_carga`
--

INSERT INTO `cji_almacenproducto_carga` (`ALMAP_Codigo`, `INVE_Codigo`, `PROD_Codigo`, `PROD_CodigoUsuario`, `PROD_Nombre`, `PROD_Modelo`, `PROD_Marca`, `ALMPC_Cantidad`, `ALMPC_FlagEstado`) VALUES
(1, 45, 2, 'a001', 'test', '', '', 20, '1'),
(1, 45, 3, 'a002', 'producto test', '', '', 10, '1'),
(1, 48, 2, 'a001', 'test', '', '', 50, '1'),
(1, 48, 3, 'a002', 'producto test', '', '', 35, '1'),
(1, 49, 2, 'a001', 'test', '', '', 50, '1'),
(1, 49, 3, 'a002', 'producto test', '', '', 35, '1'),
(1, 50, 2, 'a001', 'test', '', '', 50, '1'),
(1, 50, 3, 'a002', 'producto test', '', '', 35, '1'),
(1, 51, 2, 'a001', 'test', '', '', 50, '1'),
(1, 51, 3, 'a002', 'producto test', '', '', 35, '1'),
(1, 51, 4, 'a003', 'producto de prueba', '', '', 10, '1'),
(1, 52, 2, 'a001', 'test', '', '', 50, '1'),
(1, 52, 3, 'a002', 'producto test', '', '', 35, '1'),
(1, 52, 4, 'a003', 'producto de prueba', '', '', 10, '1'),
(1, 53, 2, 'a001', 'test', '', '', 15, '1'),
(1, 53, 3, 'a002', 'producto test', '', '', 70, '1'),
(1, 53, 4, 'a003', 'producto de prueba', '', '', 23, '1'),
(2, 55, 2, 'a001', 'test', '', '', 15, '1'),
(2, 55, 3, 'a002', 'producto test', '', '', 70, '1'),
(2, 55, 4, 'a003', 'producto de prueba', '', '', 23, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_almaprolote`
--

CREATE TABLE `cji_almaprolote` (
  `ALMALOTP_Codigo` int(11) NOT NULL,
  `ALMPROD_Codigo` int(11) NOT NULL,
  `LOTP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) DEFAULT '0',
  `ALMALOTC_Cantidad` double DEFAULT '0',
  `ALMALOTC_Costo` double DEFAULT '0',
  `ALMALOTC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ALMALOTC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `ALMALOTC_CantidadDisponible` int(11) DEFAULT NULL COMMENT 'Cuando se asignan lotes en el ERP, este campo guarda cantidad disponible para asignar.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_area`
--

CREATE TABLE `cji_area` (
  `AREAP_Codigo` int(11) NOT NULL,
  `AREAC_Descripcion` varchar(150) DEFAULT NULL,
  `AREAC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AREAC_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `AREAC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_area`
--

INSERT INTO `cji_area` (`AREAP_Codigo`, `AREAC_Descripcion`, `AREAC_FechaRegistro`, `AREAC_FechaModificacion`, `COMPP_Codigo`, `AREAC_FlagEstado`) VALUES
(1, 'ALMACEN', '2010-12-17 03:02:47', NULL, 1, '1'),
(2, 'COMPRAS', '2010-12-24 17:25:30', NULL, 1, '1'),
(3, 'VENTAS', '2011-01-01 17:38:17', NULL, 1, '1'),
(4, 'CONTABILIDAD', '2011-01-01 17:45:40', NULL, 1, '1'),
(5, 'ADMINISTRACION', '2011-01-01 17:46:18', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_atributo`
--

CREATE TABLE `cji_atributo` (
  `ATRIB_Codigo` int(11) NOT NULL,
  `ATRIB_FlagBienServicio` char(1) NOT NULL DEFAULT 'B' COMMENT 'B: Bien, S: Servicio',
  `ATRIB_Descripcion` varchar(150) DEFAULT NULL,
  `ATRIB_TipoAtributo` int(1) DEFAULT NULL COMMENT '1::Numerico,2::Date,3::String',
  `ATRIB_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ATRIB_FechaModificacion` datetime DEFAULT NULL,
  `ATRIB_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_atributo`
--

INSERT INTO `cji_atributo` (`ATRIB_Codigo`, `ATRIB_FlagBienServicio`, `ATRIB_Descripcion`, `ATRIB_TipoAtributo`, `ATRIB_FechaRegistro`, `ATRIB_FechaModificacion`, `ATRIB_FlagEstado`) VALUES
(1, 'B', 'PESO', 1, '2011-01-07 18:08:49', NULL, '1'),
(2, 'B', 'TAMANO', 1, '2011-01-07 18:08:59', NULL, '1'),
(3, 'B', 'COLOR', 3, '2011-01-07 18:09:13', NULL, '1'),
(4, 'B', 'POTENCIA', 1, '2011-01-07 18:09:33', NULL, '1'),
(5, 'B', 'MODELO', 3, '2011-01-07 18:13:33', NULL, '1'),
(6, 'B', 'DIAMETRO EXTERIOR', 1, '2011-01-16 13:44:01', NULL, '1'),
(7, 'B', 'DIAMETRO INTERIOR', 1, '2011-01-13 03:03:32', NULL, '1'),
(8, 'B', 'ESPESOR DE PARED', 1, '2011-01-13 03:03:58', NULL, '1'),
(9, 'B', 'PRESION', 1, '2011-01-13 03:03:58', NULL, '1'),
(10, 'B', 'TOLERANCIA ESPESOR', 1, '2011-01-13 03:42:54', NULL, '1'),
(11, 'B', 'PESO TEORICO', 1, '2011-01-13 03:42:54', NULL, '1'),
(12, 'B', 'SISTEMA INGLES', 1, '2011-01-13 03:43:08', NULL, '1'),
(13, 'B', 'MODELO', 1, '2011-01-21 15:39:06', NULL, '1'),
(14, 'S', 'TIEMPO', 1, '2012-09-28 09:36:34', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_banco`
--

CREATE TABLE `cji_banco` (
  `BANP_Codigo` int(11) NOT NULL,
  `BANC_Nombre` varchar(100) NOT NULL,
  `BANC_Siglas` varchar(20) NOT NULL,
  `BANC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `BANC_FechaModificacion` datetime DEFAULT NULL,
  `BANC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_banco`
--

INSERT INTO `cji_banco` (`BANP_Codigo`, `BANC_Nombre`, `BANC_Siglas`, `BANC_FechaRegistro`, `BANC_FechaModificacion`, `BANC_FlagEstado`) VALUES
(1, 'BANCO DE CREDITO', 'BCP', '2012-11-04 21:07:47', NULL, '1'),
(2, 'BANCO CONTINENTAL', 'BBVA', '2012-11-04 21:07:47', NULL, '1'),
(3, 'INTERBANK', 'INTERBANK', '2012-11-04 21:08:11', NULL, '1'),
(4, 'SCOTIABANK', 'SCOTIABANK', '2014-11-04 21:08:11', NULL, '1'),
(5, 'HSBC', 'HSBC', '2014-11-04 21:08:11', NULL, '1'),
(6, 'CITIBANK', 'CITIBANK', '2014-11-04 21:08:11', NULL, '1'),
(7, 'BANCO DE LA NACION', 'BANCO DE LA NACION', '2014-11-04 21:08:11', NULL, '1'),
(8, 'BANCO INTERAMERICANO DE FINANZAS', 'BANBIF', '2014-11-04 21:08:11', NULL, '1'),
(9, 'BANCO DE COMERCIO', 'BANCO DE COMERCIO', '2014-11-04 21:08:11', NULL, '1'),
(10, 'BANCO FINANCIERO', 'BANCO FINANCIERO', '2014-11-04 21:08:11', NULL, '1'),
(11, 'MIBANCO', 'MIBANCO', '2014-11-04 21:08:11', NULL, '1'),
(12, 'BANCO GNB PERU', 'BANCO GNB PERU', '2014-11-04 21:08:11', NULL, '1'),
(13, 'BANCO FALABELLA', 'BANCO FALABELLA', '2014-11-04 21:08:11', NULL, '1'),
(14, 'BANCO RIPLEY', 'BANCO RIPLEY', '2014-11-04 21:08:11', NULL, '1'),
(15, 'BANCO SANTANDER PERU', 'BANCO SANTANDER PERU', '2014-11-04 21:08:11', NULL, '1'),
(16, 'BANCO AZTECA', 'BANCO AZTECA', '2014-11-04 21:08:11', NULL, '1'),
(17, 'Deutsche Bank', 'Deutsche Bank', '2014-11-04 21:08:11', NULL, '1'),
(18, 'BANCO CENCOSUD', 'BANCO CENCOSUD', '2014-11-04 21:08:11', NULL, '1'),
(19, 'ICBC Perú Bank', 'ICBC Perú Bank', '2014-11-04 21:08:11', NULL, '1'),
(20, 'AGROBANCO', 'AGROBANCO', '2014-11-04 21:08:11', NULL, '1'),
(21, 'COFIDE', 'COFIDE', '2014-11-04 21:08:11', NULL, '1'),
(22, 'FONDO MIVIVIENDA', 'FONDO MIVIVIENDA', '2014-11-04 21:08:11', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_bancocta`
--

CREATE TABLE `cji_bancocta` (
  `CTAP_Codigo` int(11) NOT NULL,
  `BANP_Codigo` int(11) NOT NULL,
  `CTAC_Nro` varchar(50) NOT NULL,
  `CTAC_Tipo` varchar(1) NOT NULL COMMENT 'S: Soles; D: Dólares',
  `CTAC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CTAC_FechaModificacion` datetime DEFAULT NULL,
  `CTAC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_caja`
--

CREATE TABLE `cji_caja` (
  `CAJA_Codigo` int(11) NOT NULL,
  `CAJA_Nombre` varchar(200) NOT NULL,
  `tipCa_codigo` int(11) NOT NULL,
  `CAJA_Observaciones` text NOT NULL,
  `CAJA_tipo` char(1) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `CAJA_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CAJA_FechaModificacion` datetime NOT NULL,
  `CAJA_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CAJA_CodigoUsuario` varchar(30) DEFAULT NULL,
  `CODIGO_Directorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_cajamovimiento`
--

CREATE TABLE `cji_cajamovimiento` (
  `CAJAMOV_Codigo` int(11) NOT NULL,
  `CAJA_Codigo` int(11) NOT NULL,
  `PAGP_Codigo` int(11) DEFAULT NULL,
  `RESPMOV_Codigo` int(11) DEFAULT NULL,
  `CUENT_Codigo` int(11) DEFAULT NULL,
  `MONED_Codigo` int(11) NOT NULL,
  `CAJAMOV_Monto` double(10,2) NOT NULL,
  `CAJAMOV_MovDinero` int(1) NOT NULL COMMENT '1::INGRESO, 2 :SALIDA',
  `FORPAP_Codigo` int(11) NOT NULL,
  `CAJAMOV_FechaRecep` date NOT NULL,
  `CAJAMOV_Justificacion` text NOT NULL,
  `CAJAMOV_Observacion` text NOT NULL,
  `CAJAMOV_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CAJAMOV_FechaModificacion` datetime NOT NULL,
  `CAJAMOV_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CAJAMOV_CodigoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_cajamovimiento`
--

INSERT INTO `cji_cajamovimiento` (`CAJAMOV_Codigo`, `CAJA_Codigo`, `PAGP_Codigo`, `RESPMOV_Codigo`, `CUENT_Codigo`, `MONED_Codigo`, `CAJAMOV_Monto`, `CAJAMOV_MovDinero`, `FORPAP_Codigo`, `CAJAMOV_FechaRecep`, `CAJAMOV_Justificacion`, `CAJAMOV_Observacion`, `CAJAMOV_FechaRegistro`, `CAJAMOV_FechaModificacion`, `CAJAMOV_FlagEstado`, `CAJAMOV_CodigoUsuario`) VALUES
(1, 0, NULL, NULL, NULL, 1, 46.00, 1, 1, '2023-10-06', 'INGRESO POR VENTA FPP1 - 0001', '', '2023-10-06 15:52:56', '0000-00-00 00:00:00', '1', 1),
(2, 0, NULL, NULL, NULL, 1, 312.00, 1, 1, '2023-10-06', 'INGRESO POR VENTA FPP1 - 0002', '', '2023-10-06 16:12:24', '0000-00-00 00:00:00', '1', 1),
(3, 0, NULL, NULL, NULL, 1, 468.00, 1, 1, '2023-10-06', 'INGRESO POR VENTA FPP1 - 0003', '', '2023-10-06 16:14:19', '0000-00-00 00:00:00', '1', 1),
(4, 0, NULL, NULL, NULL, 1, 8.00, 1, 1, '2023-10-06', 'INGRESO POR VENTA FPP1 - 0005', '', '2023-10-06 17:32:10', '0000-00-00 00:00:00', '1', 1),
(5, 0, NULL, NULL, NULL, 1, 120.00, 1, 1, '2023-10-06', 'INGRESO POR VENTA CPP1 - 0001', '', '2023-10-06 21:43:33', '0000-00-00 00:00:00', '1', 1),
(6, 0, NULL, NULL, NULL, 1, 69.00, 1, 1, '2023-10-09', 'INGRESO POR VENTA FPP2 - 0001', '', '2023-10-09 17:18:33', '0000-00-00 00:00:00', '1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cji_caja_chekera`
--

CREATE TABLE `cji_caja_chekera` (
  `CAJCHEK_Codigo` int(20) NOT NULL,
  `CAJCHEK_Descripcion` varchar(200) NOT NULL,
  `CAJA_Codigo` int(11) NOT NULL,
  `CHEK_Codigo` int(11) NOT NULL,
  `TIPOING_Codigo` int(11) NOT NULL,
  `CAJCHEK_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_caja_cuenta`
--

CREATE TABLE `cji_caja_cuenta` (
  `CAJCUENT_Codigo` int(20) NOT NULL,
  `CAJA_Codigo` int(11) NOT NULL,
  `CUENT_Codigo` int(11) NOT NULL,
  `TIPOING_Codigo` int(11) NOT NULL,
  `CAJCUENT_LIMITE` varchar(20) NOT NULL,
  `CAJCUENT_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_cargo`
--

CREATE TABLE `cji_cargo` (
  `CARGP_Codigo` int(11) NOT NULL,
  `CARGC_Nombre` varchar(100) NOT NULL,
  `CARGC_Descripcion` text,
  `CARGC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CARGC_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `CARGC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_cargo`
--

INSERT INTO `cji_cargo` (`CARGP_Codigo`, `CARGC_Nombre`, `CARGC_Descripcion`, `CARGC_FechaRegistro`, `CARGC_FechaModificacion`, `COMPP_Codigo`, `CARGC_FlagEstado`) VALUES
(1, 'ADMINISTRADORA', 'ADMINISTRADOR DEL SISTEMA', '2013-03-21 18:45:19', NULL, 1, '1'),
(2, 'VENDEDOR', 'VENDEDOR', '2013-03-21 18:48:06', NULL, 1, '1'),
(3, 'GERENTE GENERAL', 'GERENTE GENERAL', '2017-09-21 03:14:57', NULL, 1, '1'),
(4, 'FINANZAS', 'FINANZAS', '2017-09-21 03:15:14', NULL, 1, '1'),
(5, 'PROYECTOS', 'PROYECTOS', '2017-09-21 03:16:27', NULL, 1, '1'),
(6, 'ALMACEN', 'ALMACEN', '2018-04-05 13:34:05', NULL, 1, '1'),
(7, 'INFORMATICO', 'PROGRAMADOR E INFORMATICO', '2023-09-19 15:09:19', NULL, 0, '0'),
(8, 'INFORMATICO', 'PROGRAMADOR DE SOFTWARE', '2023-09-19 15:45:33', NULL, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `cji_categoriapublicacion`
--

CREATE TABLE `cji_categoriapublicacion` (
  `CATPUBP_Codigo` int(11) NOT NULL,
  `CATPUBC_Descripcion` varchar(100) NOT NULL,
  `CATPUBC_Orden` int(11) NOT NULL DEFAULT '0',
  `CATPUBC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CATPUBC_FechaModificacion` datetime DEFAULT NULL,
  `CATPUBC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_centrocosto`
--

CREATE TABLE `cji_centrocosto` (
  `CENCOSP_Codigo` int(11) NOT NULL,
  `CENCOSC_Descripcion` varchar(250) DEFAULT NULL,
  `CENCOSC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CENCOSC_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `CENCOSC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_centrocosto`
--

INSERT INTO `cji_centrocosto` (`CENCOSP_Codigo`, `CENCOSC_Descripcion`, `CENCOSC_FechaRegistro`, `CENCOSC_FechaModificacion`, `COMPP_Codigo`, `CENCOSC_FlagEstado`) VALUES
(1, 'FINANZAS', '2011-01-17 13:12:33', NULL, 1, '1'),
(2, 'GERENCIA GENERAL', '2011-01-17 13:12:33', NULL, 1, '1'),
(3, 'ADMINISTRACION', '2011-01-17 13:12:33', NULL, 1, '1'),
(4, 'VENTAS', '2011-01-17 13:12:33', NULL, 1, '1'),
(5, 'CONTABILIDAD', '2011-01-17 13:12:33', NULL, 1, '1'),
(6, 'COMPRAS', '2011-01-17 13:12:33', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_chekera`
--

CREATE TABLE `cji_chekera` (
  `CHEK_Codigo` int(11) NOT NULL,
  `SERIP_Codigo` varchar(20) DEFAULT NULL,
  `CHEK_Numero` varchar(10) NOT NULL,
  `CUENT_Codigo` int(11) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `PERSP_Codigo` int(11) DEFAULT NULL,
  `CHEK_FechaRegistro` date DEFAULT NULL,
  `CHEK_FechaModificacion` date DEFAULT NULL,
  `CHEK_UsuarioRegistro` int(11) DEFAULT NULL,
  `CHEK_UsuarioModificado` int(11) DEFAULT NULL,
  `CHEK_FlagEstado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_cheque`
--

CREATE TABLE `cji_cheque` (
  `CHEP_Codigo` int(11) NOT NULL,
  `CHEC_Nro` varchar(50) NOT NULL,
  `CHEC_FechaEmision` date NOT NULL,
  `CHEC_FechaVencimiento` date NOT NULL,
  `CHEC_FechaOperacion` date DEFAULT NULL COMMENT 'Fecha de cobro o deposito',
  `CHEC_Observacion` text,
  `COMPP_Codigo` int(11) NOT NULL,
  `CHEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CHEC_FechaModificacion` datetime DEFAULT NULL,
  `CHEC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_cliente`
--

CREATE TABLE `cji_cliente` (
  `CLIP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `CLIC_CodigoUsuario` varchar(10) DEFAULT NULL,
  `CLIC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CLIC_FechaModificacion` datetime DEFAULT NULL,
  `CLIC_TipoPersona` char(1) DEFAULT NULL,
  `TIPCLIP_Codigo` int(11) DEFAULT NULL,
  `CLIC_Vendedor` int(11) DEFAULT NULL,
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `CLIC_Digemin` char(1) DEFAULT '0',
  `CLIC_flagCalifica` int(11) NOT NULL COMMENT '0:Excelente; 1:bueno; 2:regular; 3:malo; 4:negativo',
  `CLIC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_cliente`
--

INSERT INTO `cji_cliente` (`CLIP_Codigo`, `EMPRP_Codigo`, `PERSP_Codigo`, `CLIC_CodigoUsuario`, `CLIC_FechaRegistro`, `CLIC_FechaModificacion`, `CLIC_TipoPersona`, `TIPCLIP_Codigo`, `CLIC_Vendedor`, `FORPAP_Codigo`, `CLIC_Digemin`, `CLIC_flagCalifica`, `CLIC_FlagEstado`) VALUES
(1, 2, 0, 'CL01', '2023-10-06 15:51:23', NULL, '1', 0, 0, 0, '', 1, '1'),
(2, 3, 0, 'CL02', '2023-10-06 16:19:13', NULL, '1', 0, 0, 0, '', 1, '1'),
(3, 0, 7, 'CL03', '2023-10-06 20:37:17', NULL, '0', 0, 0, 0, '', 1, '1'),
(4, 6, 0, 'CL04', '2023-10-09 17:17:58', NULL, '1', 0, 0, 0, '', 1, '1'),
(5, 0, 8, 'CL05', '2023-10-09 17:54:56', NULL, '0', 0, 0, 0, '', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_clientecompania`
--

CREATE TABLE `cji_clientecompania` (
  `CLIP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_clientecompania`
--

INSERT INTO `cji_clientecompania` (`CLIP_Codigo`, `COMPP_Codigo`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(4, 2),
(5, 1),
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cji_compadocumenitem`
--

CREATE TABLE `cji_compadocumenitem` (
  `COMPADOCUITEM_Codigo` int(11) NOT NULL,
  `COMPADOCUITEM_Descripcion` varchar(250) DEFAULT NULL,
  `COMPADOCUITEM_Abreviatura` varchar(250) DEFAULT NULL,
  `COMPADOCUITEM_Valor` varchar(250) DEFAULT NULL,
  `COMPADOCUITEM_UsuCrea` varchar(220) DEFAULT NULL,
  `COMPADOCUITEM_UsuModi` varchar(220) DEFAULT NULL,
  `COMPADOCUITEM_FechaModi` datetime DEFAULT NULL,
  `COMPADOCUITEM_FechaIng` datetime DEFAULT NULL,
  `COMPADOCUITEM_Estado` char(1) DEFAULT NULL,
  `DOCUITEM_Codigo` int(11) NOT NULL,
  `COMPCONFIDOCP_Codigo` int(11) NOT NULL,
  `COMPADOCUITEM_Width` double DEFAULT NULL,
  `COMPADOCUITEM_Height` double DEFAULT NULL,
  `COMPADOCUITEM_Activacion` varchar(200) DEFAULT NULL,
  `COMPADOCUITEM_PosicionX` double DEFAULT NULL,
  `COMPADOCUITEM_PosicionY` double DEFAULT NULL,
  `COMPADOCUITEM_Variable` varchar(200) DEFAULT NULL,
  `COMPADOCUITEM_TamanioLetra` int(11) DEFAULT NULL,
  `COMPADOCUITEM_TipoLetra` varchar(250) DEFAULT NULL,
  `COMPADOCUITEM_Nombre` varchar(50) DEFAULT NULL,
  `COMPADOCUITEM_Listado` int(1) NOT NULL,
  `COMPADOCUITEM_VGrupo` varchar(50) NOT NULL,
  `COMPADOCUITEM_Alineamiento` varchar(2) NOT NULL,
  `COMPADOCUITEM_Convertiraletras` int(2) NOT NULL COMMENT 'el numero debe ser convertido a letra'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_compadocumenitem`
--

INSERT INTO `cji_compadocumenitem` (`COMPADOCUITEM_Codigo`, `COMPADOCUITEM_Descripcion`, `COMPADOCUITEM_Abreviatura`, `COMPADOCUITEM_Valor`, `COMPADOCUITEM_UsuCrea`, `COMPADOCUITEM_UsuModi`, `COMPADOCUITEM_FechaModi`, `COMPADOCUITEM_FechaIng`, `COMPADOCUITEM_Estado`, `DOCUITEM_Codigo`, `COMPCONFIDOCP_Codigo`, `COMPADOCUITEM_Width`, `COMPADOCUITEM_Height`, `COMPADOCUITEM_Activacion`, `COMPADOCUITEM_PosicionX`, `COMPADOCUITEM_PosicionY`, `COMPADOCUITEM_Variable`, `COMPADOCUITEM_TamanioLetra`, `COMPADOCUITEM_TipoLetra`, `COMPADOCUITEM_Nombre`, `COMPADOCUITEM_Listado`, `COMPADOCUITEM_VGrupo`, `COMPADOCUITEM_Alineamiento`, `COMPADOCUITEM_Convertiraletras`) VALUES
(1, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(2, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(3, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(4, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(5, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(6, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(7, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(8, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(9, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(10, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(11, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(12, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(13, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(14, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(15, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(16, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(17, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(18, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-05 17:48:11', '2023-10-05 17:48:11', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(19, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(20, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(21, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(22, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(23, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(24, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(25, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(26, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(27, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(28, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(29, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(30, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(31, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(32, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(33, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(34, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(35, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(36, '', '', '', 'PERSONA PRINCIPAL ', '', '2023-10-09 11:40:47', '2023-10-09 11:40:47', '1', 1, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cji_compania`
--

CREATE TABLE `cji_compania` (
  `COMPP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `EESTABP_Codigo` int(11) NOT NULL DEFAULT '0',
  `COMPC_Logo` varchar(250) NOT NULL,
  `COMPC_TipoValorizacion` char(1) NOT NULL DEFAULT '0' COMMENT '0:FIFO, 1:LIFO',
  `COMPC_FlagEstado` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_compania`
--

INSERT INTO `cji_compania` (`COMPP_Codigo`, `EMPRP_Codigo`, `EESTABP_Codigo`, `COMPC_Logo`, `COMPC_TipoValorizacion`, `COMPC_FlagEstado`) VALUES
(1, 1, 1, '', '0', 1),
(2, 1, 6, '', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cji_companiaconfidocumento`
--

CREATE TABLE `cji_companiaconfidocumento` (
  `COMPCONFIDOCP_Codigo` int(11) NOT NULL,
  `COMPCONFIP_Codigo` int(11) NOT NULL,
  `DOCUP_Codigo` int(11) NOT NULL,
  `COMPCONFIDOCP_Tipo` char(1) NOT NULL DEFAULT '1' COMMENT '1: código númerico secuencial, 2: serie y número secuencial, 3: código propio',
  `COMPCONFIDOCP_Serie` varchar(10) DEFAULT NULL,
  `COMPCONFIDOCP_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `COMPCONFIDOCP_FechaModificacion` datetime DEFAULT NULL,
  `COMPCONFIDOCP_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `COMPCONFIDOCP_Imagen` varchar(255) DEFAULT NULL,
  `COMPCONFIDOCP_ImagenCompra` varchar(255) DEFAULT NULL,
  `COMPCONFIDOCP_PosicionGeneralX` int(3) DEFAULT NULL,
  `COMPCONFIDOCP_PosicionGeneralY` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_companiaconfidocumento`
--

INSERT INTO `cji_companiaconfidocumento` (`COMPCONFIDOCP_Codigo`, `COMPCONFIP_Codigo`, `DOCUP_Codigo`, `COMPCONFIDOCP_Tipo`, `COMPCONFIDOCP_Serie`, `COMPCONFIDOCP_FechaRegistro`, `COMPCONFIDOCP_FechaModificacion`, `COMPCONFIDOCP_FlagEstado`, `COMPCONFIDOCP_Imagen`, `COMPCONFIDOCP_ImagenCompra`, `COMPCONFIDOCP_PosicionGeneralX`, `COMPCONFIDOCP_PosicionGeneralY`) VALUES
(1, 1, 1, '2', NULL, '2023-10-05 22:48:10', NULL, '1', 'reporte.jpg', 'pedido.jpg', 0, 0),
(2, 1, 2, '2', NULL, '2023-10-05 22:48:10', NULL, '1', NULL, '0', 0, 0),
(3, 1, 3, '2', NULL, '2023-10-05 22:48:10', NULL, '1', NULL, '0', 0, 0),
(4, 1, 4, '2', NULL, '2023-10-05 22:48:10', NULL, '1', 'guia1.jpg', 'guia1.jpg', 0, 0),
(5, 1, 5, '2', NULL, '2023-10-05 22:48:10', NULL, '1', 'guia1.jpg', 'guia1.jpg', 0, 0),
(6, 1, 6, '2', NULL, '2023-10-05 22:48:10', NULL, '1', 'guia1.jpg', 'guiacompra.jpg', 0, 0),
(7, 1, 7, '2', NULL, '2023-10-05 22:48:10', NULL, '1', NULL, '0', 0, 0),
(8, 1, 8, '2', NULL, '2023-10-05 22:48:10', NULL, '1', 'factura.jpg', 'factura1.jpg', 10, 10),
(9, 1, 9, '2', NULL, '2023-10-05 22:48:10', NULL, '1', 'boleta.jpg', 'boleta.jpg', 45, 60),
(10, 1, 10, '2', NULL, '2023-10-05 22:48:10', NULL, '1', 'guia.jpg', 'guia_remision1.jpg', 0, 0),
(11, 1, 11, '2', NULL, '2023-10-05 22:48:10', NULL, '1', 'notacredito.jpg', '0', 0, 0),
(12, 1, 12, '2', NULL, '2023-10-05 22:48:10', NULL, '1', 'notadebito.jpg', '0', 0, 0),
(13, 1, 13, '2', NULL, '2023-10-05 22:48:10', NULL, '1', NULL, '0', 0, 0),
(14, 1, 14, '2', NULL, '2023-10-05 22:48:10', NULL, '1', 'menbrete1.jpg', 'comprobantecompra.jpg', 0, 0),
(15, 1, 15, '2', NULL, '2023-10-05 22:48:10', NULL, '1', NULL, '0', 0, 0),
(16, 2, 1, '2', NULL, '2023-10-09 16:40:46', NULL, '1', 'reporte.jpg', 'pedido.jpg', 0, 0),
(17, 2, 2, '2', NULL, '2023-10-09 16:40:46', NULL, '1', NULL, '0', 0, 0),
(18, 2, 3, '2', NULL, '2023-10-09 16:40:46', NULL, '1', NULL, '0', 0, 0),
(19, 2, 4, '2', NULL, '2023-10-09 16:40:46', NULL, '1', 'guia1.jpg', 'guia1.jpg', 0, 0),
(20, 2, 5, '2', NULL, '2023-10-09 16:40:46', NULL, '1', 'guia1.jpg', 'guia1.jpg', 0, 0),
(21, 2, 6, '2', NULL, '2023-10-09 16:40:46', NULL, '1', 'guia1.jpg', 'guiacompra.jpg', 0, 0),
(22, 2, 7, '2', NULL, '2023-10-09 16:40:46', NULL, '1', NULL, '0', 0, 0),
(23, 2, 8, '2', NULL, '2023-10-09 16:40:46', NULL, '1', 'factura.jpg', 'factura1.jpg', 10, 10),
(24, 2, 9, '2', NULL, '2023-10-09 16:40:46', NULL, '1', 'boleta.jpg', 'boleta.jpg', 45, 60),
(25, 2, 10, '2', NULL, '2023-10-09 16:40:46', NULL, '1', 'guia.jpg', 'guia_remision1.jpg', 0, 0),
(26, 2, 11, '2', NULL, '2023-10-09 16:40:46', NULL, '1', 'notacredito.jpg', '0', 0, 0),
(27, 2, 12, '2', NULL, '2023-10-09 16:40:46', NULL, '1', 'notadebito.jpg', '0', 0, 0),
(28, 2, 13, '2', NULL, '2023-10-09 16:40:46', NULL, '1', NULL, '0', 0, 0),
(29, 2, 14, '2', NULL, '2023-10-09 16:40:46', NULL, '1', 'menbrete1.jpg', 'comprobantecompra.jpg', 0, 0),
(30, 2, 15, '2', NULL, '2023-10-09 16:40:46', NULL, '1', NULL, '0', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cji_companiaconfiguracion`
--

CREATE TABLE `cji_companiaconfiguracion` (
  `COMPCONFIP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `COMPCONFIC_Igv` int(11) NOT NULL DEFAULT '18',
  `COMPCONFIC_PrecioContieneIgv` char(1) NOT NULL DEFAULT '1' COMMENT '1: Los precios de los artículos contienne IGV, 0: No',
  `COMPCONFIC_DeterminaPrecio` char(1) NOT NULL DEFAULT '0' COMMENT '0: Los árticulos tienen un único precio, 1: El precio depende del tipo de cliente, 2: El precio depende de la tienda, 3: El precio depedente de la combinación de las dos últimas',
  `COMPCONFIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `COMPCONFIC_FechaModificacion` datetime DEFAULT NULL,
  `COMPCONFIC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `COMPCONFIC_Cliente` char(1) NOT NULL COMMENT '1 = compartir, 0 = no compartir',
  `COMPCONFIC_Proveedor` char(1) NOT NULL COMMENT '1 = compartir, 0 = no compartir',
  `COMPCONFIC_Producto` char(1) NOT NULL COMMENT '1 = compartir, 0 = no compartir',
  `COMPCONFIC_Familia` char(1) NOT NULL COMMENT '1 = compartir, 0 = no compartir',
  `COMPCONFIC_StockComprobante` char(1) DEFAULT NULL COMMENT '0: no mueve stock; 1: mueve stock',
  `COMPCONFIC_StockGuia` char(1) DEFAULT '1' COMMENT '0: no mueve stock; 1: mueve stock',
  `COMPCONFIC_InventarioInicial` char(1) NOT NULL DEFAULT '0' COMMENT '0:deshabilitado el llenado de inventario por menu articulos; 1: habilitado llenado de inventario por aticulo.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_companiaconfiguracion`
--

INSERT INTO `cji_companiaconfiguracion` (`COMPCONFIP_Codigo`, `COMPP_Codigo`, `COMPCONFIC_Igv`, `COMPCONFIC_PrecioContieneIgv`, `COMPCONFIC_DeterminaPrecio`, `COMPCONFIC_FechaRegistro`, `COMPCONFIC_FechaModificacion`, `COMPCONFIC_FlagEstado`, `COMPCONFIC_Cliente`, `COMPCONFIC_Proveedor`, `COMPCONFIC_Producto`, `COMPCONFIC_Familia`, `COMPCONFIC_StockComprobante`, `COMPCONFIC_StockGuia`, `COMPCONFIC_InventarioInicial`) VALUES
(1, 1, 18, '1', '1', '2023-10-05 10:48:10', NULL, '1', '0', '0', '0', '0', '1', '1', '1'),
(2, 2, 18, '1', '1', '2023-10-09 16:40:47', NULL, '1', '0', '0', '0', '0', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_comparativo`
--

CREATE TABLE `cji_comparativo` (
  `COMP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `COMP_FechaRegistro` datetime NOT NULL,
  `COMP_FechaModificacion` datetime NOT NULL,
  `COMP_Observacion` text NOT NULL,
  `COMC_FlagEstado` char(1) NOT NULL DEFAULT 'A',
  `PEDIP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_comparativodetalle`
--

CREATE TABLE `cji_comparativodetalle` (
  `CUACOMP_Codigo` int(11) NOT NULL,
  `PRESUP_Codigo` int(11) NOT NULL,
  `CUACOMC_Ganador` tinyint(1) NOT NULL,
  `CUACOMC_Observacion` text,
  `COMP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_comprobante`
--

CREATE TABLE `cji_comprobante` (
  `CPP_Codigo` int(11) NOT NULL,
  `CPC_TipoOperacion` char(1) NOT NULL DEFAULT 'V' COMMENT 'V: venta, C: compra',
  `CPC_TipoDocumento` char(1) NOT NULL DEFAULT 'F' COMMENT 'F: factura, B: boleta, N: nunguno de los dos',
  `PRESUP_Codigo` int(11) DEFAULT NULL,
  `OCOMP_Codigo` int(11) DEFAULT NULL,
  `CPP_Compracliente` varchar(20) DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `CPC_Serie` char(6) NOT NULL,
  `CPC_Numero` varchar(20) NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `CPC_NombreAuxiliar` varchar(250) DEFAULT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `FORPAP_Monto` float DEFAULT NULL,
  `CPC_subtotal` double(10,2) DEFAULT NULL,
  `CPC_descuento` double(10,2) DEFAULT NULL,
  `CPC_igv` double(10,2) DEFAULT NULL,
  `CPC_total` double(10,2) NOT NULL DEFAULT '0.00',
  `CPC_subtotal_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `CPC_descuento_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `CPC_igv100` int(11) NOT NULL DEFAULT '0',
  `CPC_descuento100` float NOT NULL DEFAULT '0',
  `GUIAREMP_Codigo` int(11) DEFAULT NULL,
  `CPC_GuiaRemCodigo` varchar(50) DEFAULT NULL,
  `CPC_DocuRefeCodigo` varchar(50) DEFAULT NULL,
  `CPC_Observacion` text,
  `CPC_ModoImpresion` char(1) NOT NULL DEFAULT '1',
  `CPC_Fecha` date NOT NULL,
  `CPC_FechaVencimiento` date DEFAULT NULL,
  `CPC_Vendedor` int(11) DEFAULT NULL,
  `CPC_TDC` double(10,3) DEFAULT NULL,
  `CPC_TDC_opcional` double(10,3) DEFAULT NULL,
  `CPC_FlagMueveStock` char(1) NOT NULL DEFAULT '0',
  `GUIASAP_Codigo` int(11) DEFAULT NULL,
  `GUIAINP_Codigo` int(11) DEFAULT NULL,
  `USUA_anula` int(11) DEFAULT NULL,
  `CPC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CPC_FechaModificacion` datetime DEFAULT NULL,
  `CPC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CPC_Hora` time NOT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `CPP_Codigo_Canje` int(11) DEFAULT '0',
  `CPC_NumeroAutomatico` int(1) DEFAULT NULL,
  `PROYP_Codigo` int(11) NOT NULL,
  `IMPOR_Nombre` int(11) NOT NULL,
  `CPC_FlagUsaAdelanto` bit(1) NOT NULL DEFAULT b'0',
  `CPC_Direccion` varchar(250) DEFAULT NULL,
  `CPC_Compra` int(10) DEFAULT NULL,
  `CPC_Retencion` varchar(40) DEFAULT NULL,
  `CPC_RetencionPorc` float DEFAULT '0',
  `CAJA_Codigo` int(11) NOT NULL,
  `CPC_Tipo_venta` int(2) NOT NULL DEFAULT '1',
  `CPC_Tipodetraccion` int(3) DEFAULT NULL,
  `CPC_Pordetraccion` float DEFAULT NULL,
  `CPC_Pagodetraccion` int(3) DEFAULT NULL,
  `CPC_Percepcion` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_comprobante`
--

INSERT INTO `cji_comprobante` (`CPP_Codigo`, `CPC_TipoOperacion`, `CPC_TipoDocumento`, `PRESUP_Codigo`, `OCOMP_Codigo`, `CPP_Compracliente`, `COMPP_Codigo`, `CPC_Serie`, `CPC_Numero`, `CLIP_Codigo`, `PROVP_Codigo`, `CPC_NombreAuxiliar`, `USUA_Codigo`, `MONED_Codigo`, `FORPAP_Codigo`, `FORPAP_Monto`, `CPC_subtotal`, `CPC_descuento`, `CPC_igv`, `CPC_total`, `CPC_subtotal_conigv`, `CPC_descuento_conigv`, `CPC_igv100`, `CPC_descuento100`, `GUIAREMP_Codigo`, `CPC_GuiaRemCodigo`, `CPC_DocuRefeCodigo`, `CPC_Observacion`, `CPC_ModoImpresion`, `CPC_Fecha`, `CPC_FechaVencimiento`, `CPC_Vendedor`, `CPC_TDC`, `CPC_TDC_opcional`, `CPC_FlagMueveStock`, `GUIASAP_Codigo`, `GUIAINP_Codigo`, `USUA_anula`, `CPC_FechaRegistro`, `CPC_FechaModificacion`, `CPC_FlagEstado`, `CPC_Hora`, `ALMAP_Codigo`, `CPP_Codigo_Canje`, `CPC_NumeroAutomatico`, `PROYP_Codigo`, `IMPOR_Nombre`, `CPC_FlagUsaAdelanto`, `CPC_Direccion`, `CPC_Compra`, `CPC_Retencion`, `CPC_RetencionPorc`, `CAJA_Codigo`, `CPC_Tipo_venta`, `CPC_Tipodetraccion`, `CPC_Pordetraccion`, `CPC_Pagodetraccion`, `CPC_Percepcion`) VALUES
(1, 'V', 'F', NULL, 1, NULL, 1, 'FPP1', '1', 1, NULL, '', 1, 1, 1, 0, 38.98, 0.00, 7.02, 46.00, 0.00, 0.00, 18, 0, NULL, '', '', '', '1', '2023-10-06', '2023-10-06', 1, 3.700, NULL, '1', NULL, NULL, NULL, '2023-10-06 15:52:23', NULL, '1', '10:52:23', 1, 0, 1, 0, 0, b'0', 'AV. GRAL.GARZON NRO. 2320 URB. FUNDO OYAGUE, LIMA - LIMA - JESUS MARIA', NULL, '', 3, 0, 1, NULL, NULL, NULL, NULL),
(2, 'V', 'F', NULL, 2, NULL, 1, 'FPP1', '2', 1, NULL, NULL, 1, 1, 1, NULL, 264.41, 0.00, 47.59, 312.00, NULL, NULL, 18, 0, 0, '', '', '', '1', '2023-10-06', '2023-10-06', NULL, 3.700, 0.000, '1', NULL, NULL, NULL, '2023-10-06 16:11:56', NULL, '1', '11:11:56', 1, 0, 1, 0, 0, b'0', 'AV. GRAL.GARZON NRO. 2320 URB. FUNDO OYAGUE, LIMA - LIMA - JESUS MARIA', NULL, NULL, 0, 0, 1, NULL, NULL, NULL, NULL),
(3, 'V', 'F', NULL, 3, NULL, 1, 'FPP1', '3', 1, NULL, 'efectivo', 1, 1, 1, 468, 396.61, 0.00, 71.39, 468.00, NULL, NULL, 18, 0, NULL, '', '', '', '1', '2023-10-06', '2023-10-06', 1, 3.700, NULL, '1', NULL, NULL, NULL, '2023-10-06 16:14:01', NULL, '1', '11:14:01', 1, 0, 1, 0, 0, b'0', '', NULL, '', 3, 0, 1, NULL, NULL, NULL, NULL),
(4, 'V', 'F', NULL, NULL, NULL, 1, 'FPP1', '4', 2, NULL, 'efectivo', 1, 1, 1, 8, 6.78, 0.00, 1.22, 8.00, 0.00, 0.00, 18, 0, NULL, '', '', '', '1', '2023-10-06', '2023-10-06', 1, 3.700, NULL, '0', NULL, NULL, NULL, '2023-10-06 17:02:02', NULL, '2', '12:02:02', 1, 0, 1, 0, 0, b'0', '', NULL, '', 3, 0, 1, NULL, NULL, NULL, NULL),
(5, 'V', 'F', NULL, NULL, NULL, 1, 'FPP1', '5', 2, NULL, 'efectivo', 1, 1, 1, 8, 6.78, 0.00, 1.22, 8.00, NULL, NULL, 18, 0, NULL, '', '', '', '1', '2023-10-06', '2023-10-06', 1, 3.700, NULL, '1', NULL, NULL, NULL, '2023-10-06 17:32:00', NULL, '1', '12:32:00', 1, 0, 1, 0, 0, b'0', '', NULL, '', 3, 0, 1, NULL, NULL, NULL, NULL),
(6, 'V', 'B', NULL, NULL, NULL, 1, 'BPP1', '1', 2, NULL, 'efectivo', 1, 1, 1, 8, 6.78, 0.00, 1.22, 8.00, NULL, NULL, 18, 0, NULL, '', '', '', '1', '2023-10-06', '2023-10-06', 1, 3.700, NULL, '0', NULL, NULL, NULL, '2023-10-06 17:42:21', NULL, '2', '12:42:21', 1, 0, 1, 0, 0, b'0', '', NULL, '', 3, 0, 1, NULL, NULL, NULL, NULL),
(7, 'V', 'N', NULL, NULL, NULL, 1, 'CPP1', '1', 1, NULL, 'efectivo', 1, 1, 1, 120, 101.69, 0.00, 18.31, 120.00, NULL, NULL, 18, 0, NULL, '', '', '', '1', '2023-10-06', '2023-10-06', 1, 3.700, NULL, '1', NULL, NULL, NULL, '2023-10-06 21:43:28', NULL, '1', '16:43:28', 1, 8, 1, 0, 0, b'0', '', NULL, '', 3, 0, 1, NULL, NULL, NULL, NULL),
(8, 'V', 'F', NULL, NULL, NULL, 1, 'FPP1', '6', 1, NULL, 'efectivo', 1, 1, 1, NULL, 101.69, 0.00, 18.31, 120.00, NULL, NULL, 18, 0, NULL, '', '7', ' ', '1', '2023-10-06', NULL, 1, 3.700, NULL, '1', NULL, NULL, NULL, '2023-10-06 21:43:28', NULL, '1', '16:43:28', 1, 0, 1, 0, 0, b'0', NULL, NULL, NULL, 0, 0, 1, NULL, NULL, NULL, NULL),
(9, 'C', 'F', NULL, 4, NULL, 1, 'f001', '0001', NULL, 1, 'efectivo', 1, 1, 1, 390, 330.51, 0.00, 59.49, 390.00, NULL, NULL, 18, 0, NULL, '', '', '', '1', '2023-10-06', '2023-10-06', 1, 3.700, NULL, '0', NULL, NULL, NULL, '2023-10-06 21:53:38', NULL, '2', '16:53:38', 1, 0, 0, 0, 0, b'0', NULL, NULL, '', 3, 0, 0, NULL, NULL, NULL, NULL),
(10, 'C', 'F', NULL, 5, NULL, 1, 'f001', '0002', NULL, 2, 'efectivo', 1, 1, 1, 23, 19.49, 0.00, 3.51, 23.00, 0.00, 0.00, 18, 0, NULL, '', '', '', '1', '2023-10-07', '2023-10-07', 1, 3.700, NULL, '0', NULL, NULL, NULL, '2023-10-07 15:14:45', NULL, '2', '10:14:45', 1, 0, 0, 0, 0, b'0', NULL, NULL, '', 3, 0, 0, NULL, NULL, NULL, NULL),
(11, 'C', 'B', NULL, 6, NULL, 1, 'b001', '0001', NULL, 2, 'efectivo', 1, 1, 1, 30, 25.42, 0.00, 4.58, 30.00, NULL, NULL, 18, 0, NULL, '', '', '', '1', '2023-10-07', '2023-10-07', 1, 3.700, NULL, '0', NULL, NULL, NULL, '2023-10-07 15:28:52', NULL, '2', '10:28:52', 1, 0, 0, 0, 0, b'0', NULL, NULL, '', 3, 0, 0, NULL, NULL, NULL, NULL),
(12, 'C', 'N', NULL, 7, NULL, 1, 'n001', '0001', NULL, 1, 'efectivo', 1, 1, 1, 69, 58.47, 0.00, 10.53, 69.00, 0.00, 0.00, 18, 0, NULL, '', '', '', '1', '2023-10-07', '2023-10-07', 1, 3.700, NULL, '0', NULL, NULL, NULL, '2023-10-07 15:31:59', NULL, '2', '10:31:59', 1, 0, 0, 0, 0, b'0', NULL, NULL, '', 3, 0, 0, NULL, NULL, NULL, NULL),
(13, 'V', 'F', NULL, NULL, NULL, 1, 'FPP1', '7', 1, NULL, 'efectivo', 2, 1, 1, 60, 50.85, 0.00, 9.15, 60.00, NULL, NULL, 18, 0, NULL, '', '', '', '1', '2023-10-09', '2023-10-09', 2, 3.700, NULL, '0', NULL, NULL, NULL, '2023-10-09 17:15:04', NULL, '2', '12:15:04', 1, 0, 1, 0, 0, b'0', '', NULL, '', 3, 0, 1, NULL, NULL, NULL, NULL),
(14, 'V', 'F', NULL, NULL, NULL, 2, 'FPP2', '1', 4, NULL, 'efectivo', 2, 1, 1, 69, 58.47, 0.00, 10.53, 69.00, NULL, NULL, 18, 0, NULL, '', '', '', '1', '2023-10-09', '2023-10-09', 2, 3.700, NULL, '1', NULL, NULL, NULL, '2023-10-09 17:18:24', NULL, '1', '12:18:24', 2, 0, 1, 0, 0, b'0', '', NULL, '', 3, 0, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cji_comprobantedetalle`
--

CREATE TABLE `cji_comprobantedetalle` (
  `CPDEP_Codigo` int(11) NOT NULL,
  `CPP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `CPDEC_GenInd` char(1) DEFAULT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `LOTP_Codigo` int(11) NOT NULL,
  `AFECT_Codigo` int(11) NOT NULL DEFAULT '1',
  `CPDEC_Cantidad` double DEFAULT '0',
  `CPDEC_Pendiente` double NOT NULL,
  `CPDEC_Pu` double DEFAULT '0',
  `CPDEC_Subtotal` double DEFAULT NULL,
  `CPDEC_Descuento` double DEFAULT '0',
  `CPDEC_Igv` double DEFAULT '0',
  `CPDEC_Total` double NOT NULL DEFAULT '0',
  `CPDEC_Pu_ConIgv` double DEFAULT '0' COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CPDEC_Subtotal_ConIgv` double DEFAULT '0' COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CPDEC_Descuento_ConIgv` double DEFAULT '0' COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CPDEC_Igv100` int(11) DEFAULT '0',
  `CPDEC_Descuento100` int(11) DEFAULT '0',
  `CPDEC_Costo` double DEFAULT NULL,
  `CPDEC_Descripcion` varchar(250) DEFAULT NULL,
  `CPDEC_Observacion` varchar(250) DEFAULT NULL,
  `CPDEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CPDEC_FechaModificacion` datetime DEFAULT NULL,
  `CPDEC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `ALMAP_Codigo` int(11) NOT NULL,
  `GUIAREMP_Codigo` int(11) NOT NULL COMMENT 'si el producto esta asociado a una guiaremision  de diferente almacenes',
  `OCOMP_Codigo_VC` int(11) NOT NULL,
  `CPDEC_ITEMS` int(10) DEFAULT NULL,
  `CPDEC_Anticipo` char(1) NOT NULL DEFAULT '0',
  `CPDEC_AntSerie` varchar(50) DEFAULT NULL,
  `CPDEC_AntNumero` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_comprobantedetalle`
--

INSERT INTO `cji_comprobantedetalle` (`CPDEP_Codigo`, `CPP_Codigo`, `PROD_Codigo`, `CPDEC_GenInd`, `UNDMED_Codigo`, `LOTP_Codigo`, `AFECT_Codigo`, `CPDEC_Cantidad`, `CPDEC_Pendiente`, `CPDEC_Pu`, `CPDEC_Subtotal`, `CPDEC_Descuento`, `CPDEC_Igv`, `CPDEC_Total`, `CPDEC_Pu_ConIgv`, `CPDEC_Subtotal_ConIgv`, `CPDEC_Descuento_ConIgv`, `CPDEC_Igv100`, `CPDEC_Descuento100`, `CPDEC_Costo`, `CPDEC_Descripcion`, `CPDEC_Observacion`, `CPDEC_FechaRegistro`, `CPDEC_FechaModificacion`, `CPDEC_FlagEstado`, `ALMAP_Codigo`, `GUIAREMP_Codigo`, `OCOMP_Codigo_VC`, `CPDEC_ITEMS`, `CPDEC_Anticipo`, `CPDEC_AntSerie`, `CPDEC_AntNumero`) VALUES
(1, 1, 2, '', 1, 0, 1, 2, 2, 19.491525423728813, 38.983050847457626, 0, 7.016949152542374, 46, 23, NULL, NULL, 18, 0, 0, 'TEST', '', '2023-10-06 15:52:24', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(2, 2, 3, '', 1, 0, 1, 4, 0, 66.10169491525424, 264.40677966101697, 0, 47.59322033898303, 312, 78, 0, 0, 18, 0, 0, 'PRODUCTO TEST', '', '2023-10-06 16:11:56', NULL, '1', 1, 0, 0, NULL, '0', NULL, NULL),
(3, 3, 3, '', 1, 0, 1, 6, 6, 66.10169491525424, 396.6101694915254, 0, 71.38983050847455, 468, 78, 0, 0, 18, 0, 0, 'PRODUCTO TEST', '', '2023-10-06 16:14:01', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(4, 4, 2, '', 1, 0, 1, 2, 2, 3.3898305084745766, 6.779661016949153, 0, 1.2203389830508469, 8, 4, NULL, NULL, 18, 0, 0, 'TEST', '', '2023-10-06 17:02:03', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(5, 5, 2, '', 1, 0, 1, 2, 2, 3.3898305084745766, 6.779661016949153, 0, 1.2203389830508469, 8, 4, 0, 0, 18, 0, 0, 'TEST', '', '2023-10-06 17:32:01', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(6, 6, 2, '', 1, 0, 1, 2, 2, 3.3898305084745766, 6.779661016949153, 0, 1.2203389830508469, 8, 4, 0, 0, 18, 0, 0, 'TEST', '', '2023-10-06 17:42:21', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(7, 7, 3, '', 1, 0, 1, 10, 10, 10.16949152542373, 101.6949152542373, 0, 18.3050847457627, 120, 12, 0, 0, 18, 0, 30, 'PRODUCTO TEST', '', '2023-10-06 21:43:28', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(8, 8, 3, '', 1, 0, 1, 10, 0, 10.16949152542373, 101.6949152542373, 0, 18.3050847457627, 120, 12, 0, 0, 18, 0, 30, 'PRODUCTO TEST', '', '2023-10-06 21:44:10', NULL, '1', 1, 0, 0, NULL, '0', NULL, NULL),
(9, 9, 3, '', 1, 0, 1, 13, 13, 25.423728813559322, 330.50847457627117, 0, 59.49152542372882, 390, 30, 0, 0, 18, 0, 30, 'PRODUCTO TEST', '', '2023-10-06 21:53:38', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(10, 10, 2, '', 1, 0, 1, 1, 1, 19.491525423728813, 19.491525423728813, 0, 3.508474576271187, 23, 23, NULL, NULL, 18, 0, 23, 'TEST', '', '2023-10-07 15:14:45', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(11, 11, 3, '', 1, 0, 1, 1, 1, 25.423728813559322, 25.423728813559322, 0, 4.576271186440678, 30, 30, 0, 0, 18, 0, 30, 'PRODUCTO TEST', '', '2023-10-07 15:28:53', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(12, 12, 2, '', 1, 0, 1, 3, 3, 19.491525423728813, 58.474576271186436, 0, 10.52542372881356, 69, 23, NULL, NULL, 18, 0, 23, 'TEST', '', '2023-10-07 15:31:59', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(13, 13, 2, '', 1, 0, 1, 20, 20, 2.5423728813559325, 50.84745762711865, 0, 9.15254, 60, 3, 0, 0, 18, 0, 23, 'TEST', '', '2023-10-09 17:15:04', NULL, '1', 1, 0, 0, 0, '0', '', ''),
(14, 14, 3, '', 1, 0, 1, 23, 23, 2.5423728813559325, 58.47457627118645, 0, 10.525423728813552, 69, 3, 0, 0, 18, 0, 30, 'PRODUCTO TEST', '', '2023-10-09 17:18:24', NULL, '1', 2, 0, 0, 0, '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `cji_comprobante_formaspago`
--

CREATE TABLE `cji_comprobante_formaspago` (
  `idcji_compro_forPa` int(11) NOT NULL,
  `CPP_Codigo` int(11) NOT NULL,
  `FORPAP_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL,
  `monto` float NOT NULL,
  `compro_forPa_flag` int(11) NOT NULL DEFAULT '1',
  `compro_flag_FechaRegistro` datetime NOT NULL,
  `compro_flag_FechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cji_comprobante_formaspago`
--

INSERT INTO `cji_comprobante_formaspago` (`idcji_compro_forPa`, `CPP_Codigo`, `FORPAP_Codigo`, `MONED_Codigo`, `monto`, `compro_forPa_flag`, `compro_flag_FechaRegistro`, `compro_flag_FechaModificacion`) VALUES
(1, 1, 2, 1, 4, 1, '2022-09-26 10:04:29', NULL),
(2, 8, 2, 1, 1000, 1, '2022-10-12 04:40:23', NULL),
(3, 8, 1, 1, 12, 1, '2022-10-12 04:40:23', NULL),
(4, 13, 3, 1, 616, 1, '2022-10-21 12:42:17', NULL),
(5, 29, 1, 1, 150, 1, '2023-01-07 10:55:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cji_comprobante_guiarem`
--

CREATE TABLE `cji_comprobante_guiarem` (
  `COMPGUI_Codigo` int(11) NOT NULL,
  `CPP_Codigo` int(11) NOT NULL COMMENT 'Codigo del comprobante',
  `GUIAREMP_Codigo` int(11) NOT NULL COMMENT 'Codigo de Guia remision',
  `COMPGUI_FlagEstado` int(2) NOT NULL,
  `COMPGU_FechaRegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_comprobante_guiarem`
--

INSERT INTO `cji_comprobante_guiarem` (`COMPGUI_Codigo`, `CPP_Codigo`, `GUIAREMP_Codigo`, `COMPGUI_FlagEstado`, `COMPGU_FechaRegistro`) VALUES
(2, 5, 1, 1, '2023-10-06 12:32:00'),
(3, 6, 1, 1, '2023-10-06 12:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `cji_comprobante_letra`
--

CREATE TABLE `cji_comprobante_letra` (
  `CPLET_Codigo` int(11) NOT NULL,
  `LET_Codigo` int(11) NOT NULL COMMENT 'ID LETRA',
  `CPP_Codigo` int(11) NOT NULL COMMENT 'ID COMPROBANTE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cji_condicionentrega`
--

CREATE TABLE `cji_condicionentrega` (
  `CONENP_Codigo` int(11) NOT NULL,
  `CONENC_Descripcion` varchar(250) DEFAULT NULL,
  `CONENC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CONENC_FechaModificacion` datetime DEFAULT NULL,
  `CONENC_FlagEstado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_configuracion`
--

CREATE TABLE `cji_configuracion` (
  `CONFIP_Codigo` int(11) NOT NULL,
  `DOCUP_Codigo` int(11) NOT NULL,
  `CONFIC_Serie` char(10) DEFAULT NULL,
  `CONFIC_Numero` char(11) DEFAULT NULL,
  `CONF_Descripcion` varchar(100) DEFAULT NULL,
  `CONFIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `COMPP_Codigo` int(11) NOT NULL,
  `CONFIC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_configuracion`
--

INSERT INTO `cji_configuracion` (`CONFIP_Codigo`, `DOCUP_Codigo`, `CONFIC_Serie`, `CONFIC_Numero`, `CONF_Descripcion`, `CONFIC_FechaRegistro`, `COMPP_Codigo`, `CONFIC_FlagEstado`) VALUES
(1, 1, '0001', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(2, 2, 'OC01', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(3, 3, '0001', '5', NULL, '2023-10-05 22:48:11', 1, '1'),
(4, 4, '0001', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(5, 5, '0001', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(6, 6, '0001', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(7, 7, '0001', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(8, 8, 'FPP1', '6', NULL, '2023-10-05 22:48:11', 1, '1'),
(9, 9, 'BPP1', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(10, 10, 'TPP1', NULL, NULL, '2023-10-05 22:48:11', 1, '1'),
(11, 11, 'PP1', '1', NULL, '2023-10-05 22:48:11', 1, '1'),
(12, 12, 'PP1', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(13, 13, '0001', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(14, 14, 'CPP1', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(15, 15, '0001', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(16, 16, 'LET1', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(17, 17, '0001', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(18, 18, 'COT1', '5', NULL, '2023-10-05 22:48:11', 1, '1'),
(19, 20, '0001', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(20, 21, '0001', '0', NULL, '2023-10-05 22:48:11', 1, '1'),
(21, 1, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(22, 2, 'OC02', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(23, 3, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(24, 4, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(25, 5, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(26, 6, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(27, 7, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(28, 8, 'FPP2', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(29, 9, 'BPP2', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(30, 10, 'TPP2', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(31, 11, 'PP2', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(32, 12, 'PP2', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(33, 13, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(34, 14, 'CPP2', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(35, 15, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(36, 16, 'LET2', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(37, 17, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(38, 18, 'COT2', '2', NULL, '2023-10-09 16:40:47', 2, '1'),
(39, 20, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1'),
(40, 21, '0002', '0', NULL, '2023-10-09 16:40:47', 2, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_correlativo`
--

CREATE TABLE `cji_correlativo` (
  `CORRP_Codigo` int(11) NOT NULL,
  `CORRC_Siglas` varchar(10) DEFAULT NULL,
  `CORRC_Numero` int(11) DEFAULT NULL,
  `CORRC_Descripcion` varchar(250) DEFAULT NULL,
  `CORRC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CORRC_FechaModificacion` datetime DEFAULT NULL,
  `CORRC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_correlativo`
--

INSERT INTO `cji_correlativo` (`CORRP_Codigo`, `CORRC_Siglas`, `CORRC_Numero`, `CORRC_Descripcion`, `CORRC_FechaRegistro`, `CORRC_FechaModificacion`, `CORRC_FlagEstado`) VALUES
(1, 'OI', 0, 'ORDEN DE INGRESO', '2011-01-17 13:42:23', NULL, '1'),
(2, 'OP', 0, 'ORDEN DE PEDIDO', '2011-01-17 13:42:57', NULL, '1'),
(3, 'COT', 0, 'COTIZACION', '2011-01-17 13:43:07', NULL, '1'),
(4, 'OC', 0, 'ORDEN DE COMPRA', '2011-01-17 13:43:21', NULL, '1'),
(5, 'GI', 0, 'GUIA DE INGRESO', '2011-01-17 13:43:45', NULL, '1'),
(6, 'GS', 0, 'GUIA DE SALIDA', '2011-01-17 13:43:54', NULL, '1'),
(7, 'VS', 0, 'VALE DE SALIDA', '2011-01-17 13:44:21', NULL, '1'),
(8, 'INV', 0, 'INVENTARIO', '2011-01-17 13:44:36', NULL, '1'),
(9, 'BOL', 0, 'BOLETA DE VENTA', '2011-01-17 13:44:52', NULL, '1'),
(10, 'FAC', 0, 'FACTURA', '2011-01-17 13:45:02', NULL, '1'),
(11, 'GR', 0, 'GUIA DE REMISION', '2011-01-17 13:45:19', NULL, '1'),
(12, 'NC', 0, 'NOTA DE CREDITO', '2011-01-17 13:45:37', NULL, '1'),
(13, 'ND', 0, 'NOTA DE DEBITO', '2011-01-17 13:46:07', NULL, '1'),
(14, 'LC', 0, 'LETRA DE CAMBIO', '2014-04-12 23:24:14', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_correoenviar`
--

CREATE TABLE `cji_correoenviar` (
  `CE_Codigo` int(11) NOT NULL,
  `PRESUP_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `CE_FechaEnvio` date NOT NULL,
  `CE_CorreoRemitente` varchar(250) NOT NULL,
  `CE_CorreoReceptor` varchar(250) NOT NULL,
  `CE_NombreRemitente` varchar(250) NOT NULL,
  `CE_NombreReceptor` varchar(250) NOT NULL,
  `CE_Mensaje` varchar(250) NOT NULL,
  `CE_Excel` int(11) NOT NULL,
  `CE_Pdf` int(11) NOT NULL,
  `CE_Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_cotizacion`
--

CREATE TABLE `cji_cotizacion` (
  `COTIP_Codigo` int(11) NOT NULL,
  `PEDIP_Codigo` int(11) NOT NULL,
  `COTIC_Numero` int(11) NOT NULL,
  `COTIC_Serie` char(3) NOT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `CONENP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) DEFAULT NULL,
  `CENCOSP_Codigo` int(11) DEFAULT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `COTIC_Observacion` varchar(250) DEFAULT NULL,
  `COTIC_TiempoOferta` int(11) DEFAULT NULL,
  `COTIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `COTIC_FechaModificacion` datetime DEFAULT NULL,
  `COTIC_FlagCompra` char(1) DEFAULT '0',
  `COTIC_FlagIngreso` char(1) DEFAULT '0',
  `COMPP_Codigo` int(11) NOT NULL,
  `COTIC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_cotizaciondetalle`
--

CREATE TABLE `cji_cotizaciondetalle` (
  `COTDEP_Codigo` int(10) NOT NULL,
  `COTIP_Codigo` int(11) NOT NULL,
  `PEDIP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) NOT NULL,
  `COTDEC_Cantidad` double DEFAULT NULL,
  `COTDEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `COTDEC_FechaModificacion` datetime DEFAULT NULL,
  `COTDEC_Observacion` varchar(250) DEFAULT NULL,
  `COTDEC_FlagOcompra` char(1) DEFAULT '0',
  `COTDEC_FlagIngreso` char(1) DEFAULT '0',
  `COTDEC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_cuentacontable`
--

CREATE TABLE `cji_cuentacontable` (
  `CUNTCONTBL_Codigo` int(11) NOT NULL,
  `CUNTCONTBL_Descripcion` varchar(200) NOT NULL,
  `CUNTCONTBL_Abreviatura` varchar(200) NOT NULL,
  `CUNTCONTBL_Nombre` varchar(200) NOT NULL,
  `CUNTCONTBL_CodigoPadre` int(11) NOT NULL,
  `CUNTCONTBL_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CUNTCONTBL_FechaModificacion` datetime NOT NULL,
  `CUNTCONTBL_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CUNTCONTBL_CodigoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_cuentacontable`
--

INSERT INTO `cji_cuentacontable` (`CUNTCONTBL_Codigo`, `CUNTCONTBL_Descripcion`, `CUNTCONTBL_Abreviatura`, `CUNTCONTBL_Nombre`, `CUNTCONTBL_CodigoPadre`, `CUNTCONTBL_FechaRegistro`, `CUNTCONTBL_FechaModificacion`, `CUNTCONTBL_FlagEstado`, `CUNTCONTBL_CodigoUsuario`) VALUES
(1, 'Alimentacion', '', 'Alimentacion', 0, '2016-12-15 15:54:44', '0000-00-00 00:00:00', '1', 1),
(2, 'Vacaciones', '', 'Vacaciones', 0, '2016-12-15 15:54:44', '0000-00-00 00:00:00', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cji_cuentas`
--

CREATE TABLE `cji_cuentas` (
  `CUE_Codigo` int(11) NOT NULL,
  `CUE_TipoCuenta` int(11) NOT NULL COMMENT '1: Cuenta por cobrar, 2: Cuenta por pagar',
  `DOCUP_Codigo` int(1) NOT NULL,
  `CUE_CodDocumento` int(11) NOT NULL COMMENT 'Código del documento (factura, boleta, etc)',
  `MONED_Codigo` int(11) NOT NULL,
  `CUE_Monto` double(10,2) NOT NULL,
  `CUE_FechaOper` date DEFAULT NULL,
  `CUE_FlagEstadoPago` varchar(1) NOT NULL DEFAULT 'V' COMMENT 'V: No pago nada, A: avance, C: cancelado',
  `CUE_FechaCanc` date DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `CUE_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CUE_FechaModificacion` datetime DEFAULT NULL,
  `CUE_FlagEstado` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_cuentasempresas`
--

CREATE TABLE `cji_cuentasempresas` (
  `CUENT_Codigo` int(11) NOT NULL,
  `EMPRE_Codigo` int(11) DEFAULT NULL,
  `PERSP_Codigo` int(11) DEFAULT NULL,
  `BANP_Codigo` int(11) DEFAULT NULL,
  `MONED_Codigo` int(11) DEFAULT NULL,
  `CUENT_NumeroEmpresa` varchar(100) DEFAULT NULL,
  `CUENT_Titular` varchar(100) DEFAULT NULL,
  `CUENT_TipoCuenta` char(1) DEFAULT NULL COMMENT '1 Ahorros | 2 Corriente',
  `CUENT_TipoPersona` char(1) DEFAULT NULL COMMENT '0 Natural | 1 Juridico',
  `CUENT_FechaRegistro` date DEFAULT NULL,
  `CUENT_FechaModificacion` datetime DEFAULT NULL,
  `CUENT_UsuarioRegistro` int(11) DEFAULT NULL,
  `CUENT_Oficina` varchar(50) DEFAULT NULL,
  `CUENT_Sectoriza` varchar(50) DEFAULT NULL,
  `CUENT_Interbancaria` varchar(50) DEFAULT NULL,
  `CUENT_UsuarioModificaion` int(11) DEFAULT NULL,
  `CUENT_FlagEstado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_cuentaspago`
--

CREATE TABLE `cji_cuentaspago` (
  `CPAGP_Codigo` int(11) NOT NULL,
  `CUE_Codigo` int(11) NOT NULL,
  `PAGP_Codigo` int(11) NOT NULL,
  `CPAGC_TDC` double(10,2) DEFAULT NULL,
  `CPAGC_Monto` double NOT NULL,
  `MONED_Codigo` int(11) NOT NULL,
  `CPAGC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CPAGC_FechaModificacion` datetime NOT NULL,
  `CPAGC_FlagEstado` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_despacho`
--

CREATE TABLE `cji_despacho` (
  `DESP_Codigo` int(11) NOT NULL,
  `DESC_Serie` varchar(11) NOT NULL,
  `DESC_Numero` varchar(11) NOT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL,
  `DESC_FechaRegistro` datetime NOT NULL,
  `DESC_FechaDespacho` date NOT NULL,
  `DESC_Entregado` char(1) DEFAULT NULL,
  `DESC_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_despachodetalle`
--

CREATE TABLE `cji_despachodetalle` (
  `DESPD_Codigo` int(11) NOT NULL,
  `DESP_Codigo` int(11) NOT NULL,
  `GUIAREMP_Codigo` int(11) DEFAULT NULL,
  `GTRANP_Codigo` int(11) DEFAULT NULL,
  `DESPD_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_direccion`
--

CREATE TABLE `cji_direccion` (
  `DIRECC_Codigo` int(11) UNSIGNED NOT NULL,
  `DIRECC_Descrip` varchar(200) NOT NULL,
  `DIRECC_Referen` varchar(200) NOT NULL,
  `UBIGP_Domicilio` char(6) NOT NULL,
  `PROYP_Codigo` int(11) NOT NULL,
  `DIRECC_Mapa` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DIRECC_StreetView` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DIRECC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DIRECC_FechaModificacion` datetime DEFAULT NULL,
  `DIRECC_FlagEstado` char(1) DEFAULT NULL,
  `DIRECC_FlagUno` char(1) DEFAULT NULL,
  `DIRECC_FlagDos` char(1) DEFAULT NULL,
  `DIRECC_CodigoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_directivo`
--

CREATE TABLE `cji_directivo` (
  `DIREP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `CARGP_Codigo` int(11) NOT NULL,
  `TIPCLIP_Codigo` int(11) NOT NULL,
  `DIREC_FechaInicio` date NOT NULL,
  `DIREC_FechaFin` date NOT NULL,
  `DIREC_NroContrato` varchar(100) CHARACTER SET utf8 NOT NULL,
  `DIREC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DIREC_FechaModificacion` datetime DEFAULT NULL,
  `DIREC_FlagEstado` char(1) DEFAULT '1',
  `DIREC_Imagen` varchar(250) CHARACTER SET utf8 NOT NULL,
  `DIREC_CodigoEmpleado` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_directivo`
--

INSERT INTO `cji_directivo` (`DIREP_Codigo`, `EMPRP_Codigo`, `PERSP_Codigo`, `CARGP_Codigo`, `TIPCLIP_Codigo`, `DIREC_FechaInicio`, `DIREC_FechaFin`, `DIREC_NroContrato`, `DIREC_FechaRegistro`, `DIREC_FechaModificacion`, `DIREC_FlagEstado`, `DIREC_Imagen`, `DIREC_CodigoEmpleado`) VALUES
(1, 1, 1, 1, 0, '2019-02-09', '2099-02-09', '', '2019-10-11 17:30:58', NULL, '1', '', 'RON-007');

-- --------------------------------------------------------

--
-- Table structure for table `cji_documento`
--

CREATE TABLE `cji_documento` (
  `DOCUP_Codigo` int(11) NOT NULL,
  `DOCUC_Descripcion` varchar(250) DEFAULT '0',
  `DOCUC_Inicial` varchar(25) NOT NULL,
  `DOCUC_FlagComprobante` char(1) NOT NULL DEFAULT '0',
  `DOCUC_FlagEstado` int(1) DEFAULT '1',
  `DOCUC_ABREVI` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_documento`
--

INSERT INTO `cji_documento` (`DOCUP_Codigo`, `DOCUC_Descripcion`, `DOCUC_Inicial`, `DOCUC_FlagComprobante`, `DOCUC_FlagEstado`, `DOCUC_ABREVI`) VALUES
(1, 'ORDEN DE PEDIDO', 'O.P.', '0', 1, ''),
(2, 'COTIZACION', 'Cot.', '0', 1, ''),
(3, 'ORDEN DE COMPRA', 'O.C.', '0', 1, ''),
(4, 'INVENTARIO', 'Inv.', '0', 1, ''),
(5, 'GUIA DE INGRESO', 'C.Ing.', '0', 1, ''),
(6, 'GUIA DE SALIDA', 'C.Sa.', '0', 1, ''),
(7, 'VALE DE SALIDA', '', '0', 1, ''),
(8, 'FACTURA', 'Fact.', '1', 1, 'F'),
(9, 'BOLETA', 'Bol.', '1', 1, 'B'),
(10, 'GUIA DE REMISION', 'G.Rem.', '0', 1, 'GR'),
(11, 'NOTA DE CREDITO', 'N.C.', '0', 1, ''),
(12, 'NOTA DE DEBITO', 'N.D.', '0', 1, ''),
(13, 'PRESUPUESTO', 'Pres.', '0', 1, ''),
(14, 'COMPROBANTE GENERAL', 'Comp', '0', 1, 'N'),
(15, 'GUIA DE TRANSFERENCIA', 'G.T.', '0', 1, ''),
(16, 'LETRA DE CAMBIO', 'L.C.', '0', 1, ''),
(17, 'Orden de servicio', '0001', '0', 1, 'OS'),
(18, 'ORDEN DE VENTA', 'OV', '0', 1, 'OV'),
(20, 'PRODUCCION', 'PR', '0', 1, 'PR'),
(21, 'DESPACHO', 'D', '0', 1, 'DP');

-- --------------------------------------------------------

--
-- Table structure for table `cji_documentoitem`
--

CREATE TABLE `cji_documentoitem` (
  `DOCUITEM_Codigo` int(11) NOT NULL,
  `ITEM_Codigo` int(11) NOT NULL,
  `DOCUP_Codigo` int(11) NOT NULL,
  `DOCUITEM_Width` double DEFAULT NULL,
  `DOCUITEM_Height` double DEFAULT NULL,
  `DOCUITEM_Activacion` char(1) DEFAULT NULL,
  `DOCUITEM_PosicionX` double DEFAULT NULL,
  `DOCUITEM_PosicionY` double DEFAULT NULL,
  `DOCUITEM_Estado` char(1) DEFAULT NULL,
  `DOCUITEM_Variable` varchar(250) DEFAULT NULL,
  `DOCUITEM_TamanioLetra` int(11) DEFAULT NULL,
  `DOCUITEM_TipoLetra` varchar(250) DEFAULT NULL,
  `COMPADOCUITEM_VGrupo` varchar(50) NOT NULL,
  `COMPADOCUITEM_Alineamiento` varchar(2) NOT NULL,
  `COMPADOCUITEM_Activacion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_documentoitem`
--

INSERT INTO `cji_documentoitem` (`DOCUITEM_Codigo`, `ITEM_Codigo`, `DOCUP_Codigo`, `DOCUITEM_Width`, `DOCUITEM_Height`, `DOCUITEM_Activacion`, `DOCUITEM_PosicionX`, `DOCUITEM_PosicionY`, `DOCUITEM_Estado`, `DOCUITEM_Variable`, `DOCUITEM_TamanioLetra`, `DOCUITEM_TipoLetra`, `COMPADOCUITEM_VGrupo`, `COMPADOCUITEM_Alineamiento`, `COMPADOCUITEM_Activacion`) VALUES
(11, 8, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(12, 9, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(13, 10, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(14, 11, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(15, 12, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(16, 13, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(17, 14, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(18, 15, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(19, 16, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(20, 17, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(21, 18, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(22, 19, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(23, 20, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(24, 21, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(25, 22, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(26, 23, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(43, 2, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(44, 3, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(45, 6, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(46, 8, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(47, 9, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(48, 10, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(49, 11, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(50, 12, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(51, 13, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(52, 14, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(53, 15, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(54, 16, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(55, 17, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(56, 18, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(57, 19, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(58, 20, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(59, 21, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(60, 22, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(61, 23, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(62, 2, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(63, 3, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(64, 6, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(65, 8, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(66, 9, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(67, 10, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(68, 11, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(69, 12, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(70, 13, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(71, 14, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(72, 15, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(73, 16, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(74, 17, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(75, 18, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(76, 19, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(77, 20, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(78, 21, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(79, 22, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(80, 23, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(81, 2, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(82, 3, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(83, 6, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(84, 8, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(85, 9, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(86, 10, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(87, 11, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(88, 12, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(89, 13, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(90, 14, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(91, 15, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(92, 16, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(93, 17, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(94, 18, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(95, 19, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(96, 20, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(97, 21, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(98, 22, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(99, 23, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(100, 2, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(101, 3, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(102, 6, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(103, 8, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(104, 9, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(105, 10, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(106, 11, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(107, 12, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(108, 13, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(109, 14, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(110, 15, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(111, 16, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(112, 17, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(113, 18, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(114, 19, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(115, 20, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(116, 21, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(117, 22, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(118, 23, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(119, 2, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(120, 3, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(121, 6, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(122, 8, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(123, 9, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(124, 10, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(125, 11, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(126, 12, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(127, 13, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(128, 14, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(129, 15, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(130, 16, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(131, 17, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(132, 18, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(133, 19, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(134, 20, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(135, 21, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(136, 22, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(137, 23, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(138, 2, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(139, 3, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(140, 6, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(141, 8, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(142, 9, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(143, 10, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(144, 11, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(145, 12, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(146, 13, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(147, 14, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(148, 15, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(149, 16, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(150, 17, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(151, 18, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(152, 19, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(153, 20, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(154, 21, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(155, 22, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(156, 23, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(157, 2, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(158, 3, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(159, 6, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(160, 8, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(161, 9, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(162, 10, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(163, 11, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(164, 12, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(165, 13, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(166, 14, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(167, 15, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(168, 16, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(169, 17, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(170, 18, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(171, 19, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(172, 20, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(173, 21, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(174, 22, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(175, 23, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(176, 2, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(177, 3, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(178, 6, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(179, 8, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(180, 9, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(181, 10, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(182, 11, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(183, 12, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(184, 13, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(185, 14, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(186, 15, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(187, 16, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(188, 17, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(189, 18, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(190, 19, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(191, 20, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(192, 21, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(193, 22, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(194, 23, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(195, 2, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(196, 3, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(197, 6, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(198, 8, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(199, 9, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(200, 10, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(201, 11, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(202, 12, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(203, 13, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(204, 14, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(205, 15, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(206, 16, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(207, 17, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(208, 18, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(209, 19, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(210, 20, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(211, 21, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(212, 22, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(213, 23, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(214, 2, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(215, 3, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(216, 6, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(217, 8, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(218, 9, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(219, 10, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(220, 11, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(221, 12, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(222, 13, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(223, 14, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(224, 15, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(225, 16, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(226, 17, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(227, 18, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(228, 19, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(229, 20, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(230, 21, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(231, 22, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(232, 23, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(233, 2, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(234, 3, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(235, 6, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(236, 8, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(237, 9, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(238, 10, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(239, 11, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(240, 12, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(241, 13, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(242, 14, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(243, 15, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(244, 16, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(245, 17, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(246, 18, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(247, 19, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(248, 20, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(249, 21, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(250, 22, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(251, 23, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(252, 2, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(253, 3, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(254, 6, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(255, 8, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(256, 9, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(257, 10, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(258, 11, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(259, 12, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(260, 13, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(261, 14, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(262, 15, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(263, 16, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(264, 17, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(265, 18, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(266, 19, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(267, 20, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(268, 21, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(269, 22, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(270, 23, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(271, 2, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(272, 3, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(273, 6, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(274, 8, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(275, 9, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(276, 10, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(277, 11, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(278, 12, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(279, 13, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(280, 14, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(281, 15, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(282, 16, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(283, 17, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(284, 18, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(285, 19, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(286, 20, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(287, 21, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(288, 22, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(289, 23, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(290, 2, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(291, 3, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(292, 6, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(293, 8, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(294, 9, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(295, 10, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(296, 11, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(297, 12, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(298, 13, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(299, 14, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(300, 15, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(301, 16, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(302, 17, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(303, 18, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(304, 19, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(305, 20, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(306, 21, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(307, 22, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(308, 23, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(309, 2, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(310, 3, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(311, 6, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(312, 8, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(313, 9, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(314, 10, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(315, 11, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(316, 12, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(317, 13, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(318, 14, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(319, 15, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(320, 16, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(321, 17, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(322, 18, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(323, 19, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(324, 20, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(325, 21, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(326, 22, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(327, 23, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cji_documentosentenica`
--

CREATE TABLE `cji_documentosentenica` (
  `DOCSENT_Codigo` int(11) NOT NULL,
  `DOCSENT_Tipo` int(1) NOT NULL,
  `DOCSENT_Select` longtext NOT NULL,
  `DOCSENT_CodigoRelacion` varchar(50) NOT NULL,
  `COMPCONFIDOCP_Codigo` int(11) NOT NULL,
  `DOCSENT_VariableCodigoRelacion` varchar(50) NOT NULL,
  `DOCSENT_VariableGrupo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_documentosentenica`
--

INSERT INTO `cji_documentosentenica` (`DOCSENT_Codigo`, `DOCSENT_Tipo`, `DOCSENT_Select`, `DOCSENT_CodigoRelacion`, `COMPCONFIDOCP_Codigo`, `DOCSENT_VariableCodigoRelacion`, `DOCSENT_VariableGrupo`) VALUES
(26, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI, c.FORPAP_Codigo, c.MONED_Codigo, CONCAT (c.CPC_Serie,\' \',c.CPC_Numero) as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 29, '$CodigoPrincipal', ''),
(27, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 29, '$ccliente', ''),
(28, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO FROM cji_comprobantedetalle cd INNER JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo WHERE cd.CPP_Codigo=$ccomp', 'CPP_Codigo', 29, '$ccomp', 'grupo'),
(29, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 29, '$forpap', ''),
(30, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 29, '$monedcodigo', ''),
(345, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI, c.FORPAP_Codigo, c.MONED_Codigo, CONCAT (c.CPC_Serie,\' \',c.CPC_Numero) as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 24, '$CodigoPrincipal', ''),
(346, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO FROM cji_comprobantedetalle cd INNER JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo WHERE cd.CPP_Codigo=$ccomp', 'CPP_Codigo', 24, '$ccomp', ''),
(347, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 24, '$forpap', ''),
(348, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 24, '$monedcodigo', ''),
(349, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 24, '$ccliente', ''),
(488, 1, 'SELECT GUIAREMC_PuntoPartida as PUNTOPARTI,\ng.GUIAREMP_Codigo,\n CONCAT(g.GUIAREMC_Serie,  \' \',  g.GUIAREMC_Numero\n  ) AS GUIA,\n  g.GUIAREMC_PuntoLlegada AS DESTINO,\n  g.CLIP_Codigo AS CODCLIEG,\n  GUIAREMC_Marca AS MARCAVIHEC,\n  GUIAREMC_Placa AS PLACASS,\nGUIAREMC_Certificado as CERINS,\n  GUIAREMC_RegistroMTC,\n  GUIAREMC_Certificado,\n  GUIAREMC_Licencia AS LICENCIACO,\n  GUIAREMC_NombreConductor AS CONDUCTOR2,\n  GUIAREMC_Observacion AS OBSERVACIO,\nGUIAREMC_FechaTraslado as FECHATRAS,\nGUIAREMC_FechaRegistro as FECHAEMI,\nGUIAREMC_total AS PRECIOT\nFROM\n  cji_guiarem g\nWHERE\n  g.GUIAREMP_Codigo =$CodigoPrincipal', '', 25, '$CodigoPrincipal', ''),
(489, 2, 'SELECT gd.GUIAREMDETC_Descripcion as DESCRIP, gd.GUIAREMDETC_Cantidad as CANTIDAD, gd.PRODCTOP_Codigo as PRODCOD, und.UNDMED_Descripcion as UNIDAD,\ngd.GUIAREMDETC_Total as PRECIO\n from cji_guiaremdetalle gd INNER JOIN cji_unidadmedida und ON und.UNDMED_Codigo=gd.UNDMED_Codigo WHERE gd.GUIAREMP_Codigo= $guiaremcod\n', 'GUIAREMP_Codigo', 25, '$guiaremcod', 'grupo'),
(490, 2, 'SELECT g.CPC_TipoOperacion, g.CLIP_Codigo, g.PROVP_Codigo , CASE g.GUIAREMC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as NOMBRE, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as DIRECCION, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo )END as RUC FROM cji_guiarem g WHERE g.GUIAREMP_Codigo = $ccliente', 'GUIAREMP_Codigo', 25, '$ccliente', ''),
(491, 2, 'SELECT PROD_Codigo as PRODCODSERIE, GROUP_CONCAT( SERIC_Numero) as NUEVOSS FROM cji_serie s JOIN cji_seriedocumento cd on cd.SERIP_Codigo=s.SERIP_Codigo WHERE cd.DOCUP_Codigo=10 AND SERDOC_NumeroRef=$variableNuevo\n', 'GUIAREMP_Codigo', 25, '$variableNuevo', 'grupo2'),
(1918, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI,\nsubstr(c.CPC_Fecha,-10,4) as anio ,substr(c.CPC_Fecha,-5,2) as mes ,substr(c.CPC_Fecha,-2,2) as UNIDAD\n, c.FORPAP_Codigo, c.MONED_Codigo, c.CPC_Numero as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 24, '$CodigoPrincipal', ''),
(1919, 2, 'SELECT com.CPP_Codigo , det.CPDEC_Descripcion as NOMBREP , det.CPDEC_Cantidad as CANTIDAD,det.CPDEC_Pu_ConIgv as PUNIT, det.CPDEC_Total as TOTALP\nFROM cji_comprobante com \ninner join cji_comprobantedetalle det on det.CPP_Codigo = com.CPP_Codigo\nwhere com.CPP_Codigo = $ccomp', 'CPP_Codigo', 24, '$ccomp', 'grupo'),
(1920, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 24, '$forpap', ''),
(1921, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 24, '$monedcodigo', ''),
(1922, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 24, '$ccliente', ''),
(1923, 1, 'SELECT GUIAREMC_PuntoPartida as PUNTOPARTI, GUIAREMC_PuntoLlegada as LLEGADA,\ng.GUIAREMP_Codigo,\n CONCAT(g.GUIAREMC_Serie,  \' \',  g.GUIAREMC_Numero\n  ) AS GUIA,\n  g.GUIAREMC_PuntoLlegada AS DESTINO,\n  g.CLIP_Codigo AS CODCLIEG,\n  GUIAREMC_Marca AS MARCAVIHEC,\n  GUIAREMC_Placa AS PLACASS,\nGUIAREMC_Certificado as CERINS,\n  GUIAREMC_RegistroMTC,\n  GUIAREMC_Certificado,\n  GUIAREMC_Licencia AS LICENCIACO,\n  GUIAREMC_NombreConductor AS CONDUCTOR2,\n  GUIAREMC_Observacion AS OBSERVACIO,\nDATE_FORMAT(GUIAREMC_FechaTraslado,\'%d/%m/%Y\') as FECHATRAS, DATE_FORMAT(GUIAREMC_FechaRegistro,\'%d/%m/%Y\') as FECHAEMI,\nSUBSTRING( GUIAREMC_FechaRegistro,  -19, 4 ) as fechaAnioB ,\nSUBSTRING( GUIAREMC_FechaRegistro,  -14, 2 ) as fechaMesB,\n SUBSTRING( GUIAREMC_FechaRegistro,  -11, 2 ) as fechaDiaB,\nGUIAREMC_total AS PRECIOT , TIPOMOVP_Codigo as MONTRANS\nFROM\n  cji_guiarem g\nWHERE\n  g.GUIAREMP_Codigo =$CodigoPrincipal', '', 25, '$CodigoPrincipal', ''),
(1924, 2, 'SELECT CONCAT( g.CPC_Serie,  \'-\', g.CPC_Numero ) AS NUMFACTU\nFROM cji_guiarem c\nINNER JOIN cji_comprobante_guiarem cg ON cg.GUIAREMP_Codigo = c.GUIAREMP_Codigo\nINNER JOIN cji_comprobante g ON g.CPP_Codigo = cg.CPP_Codigo\nWHERE c.GUIAREMP_Codigo =$guiaremcodigo', 'GUIAREMP_Codigo', 25, '$guiaremcodigo', ''),
(1925, 2, 'SELECT g.CPC_TipoOperacion, g.CLIP_Codigo, g.PROVP_Codigo , CASE g.GUIAREMC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as NOMBRE, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as DIRECCION, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo )END as RUC FROM cji_guiarem g WHERE g.GUIAREMP_Codigo = $ccliente', 'GUIAREMP_Codigo', 25, '$ccliente', ''),
(1926, 2, 'SELECT PROD_Codigo as PRODCODSERIE, GROUP_CONCAT( SERIC_Numero) as NUEVOSS FROM cji_serie s JOIN cji_seriedocumento cd on cd.SERIP_Codigo=s.SERIP_Codigo WHERE cd.DOCUP_Codigo=10 AND SERDOC_NumeroRef=$variableNuevo\n', 'GUIAREMP_Codigo', 25, '$variableNuevo', 'grupo2'),
(1927, 2, 'SELECT gd.GUIAREMDETC_Descripcion  as DESCRIP, gd.GUIAREMDETC_Cantidad as CANTIDAD, gd.PRODCTOP_Codigo as PRODCOD, und.UNDMED_Descripcion as UNIDAD,\ngd.GUIAREMDETC_Total as PRECIO ,  gd.GUIAREMDETC_ITEM as ITEM\nfrom cji_guiaremdetalle gd\nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=gd.UNDMED_Codigo \nINNER JOIN cji_guiarem g  ON g.GUIAREMP_Codigo=gd.GUIAREMP_Codigo\nWHERE gd.GUIAREMP_Codigo=$guiaremcod\n', 'GUIAREMP_Codigo', 25, '$guiaremcod', 'grupo'),
(1928, 1, 'SELECT\n  c.CPP_Codigo,\n  c.CLIP_Codigo AS CCLIENTE,\n  CPC_Vendedor AS CCVendedor,\n  c.CPC_total AS MONTOLETRA,\n  c.CPC_Direccion AS DIRECCION,\nCONCAT(m.MONED_Simbolo, \' \', c.CPC_total) AS TOTAL,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_igv) AS IGV,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_subtotal) AS SUBTOTAL,\n  SUBSTRING( CPC_Fecha,  -10, 4 ) as fechaAnioB ,\nSUBSTRING( CPC_Fecha,  -5, 2 ) as fechaMesB,\n SUBSTRING( CPC_Fecha,  -2, 2 ) as fechaDiaB,\n  c.FORPAP_Codigo,\n  c.MONED_Codigo,m.MONED_Descripcion as MONLETR,\n  CONCAT(c.CPC_Serie, \' \', c.CPC_Numero) AS COMPROBANTE,\nCPC_igv100 AS IGV100, CPC_Compra AS COMPRA\nFROM cji_comprobante c\nJOIN cji_moneda m on m.MONED_Codigo = c.MONED_Codigo where CPP_Codigo=$CodigoPrincipal', '', 38, '$CodigoPrincipal', ''),
(1929, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo ,c.CPC_Direccion AS DIRECCION ,\nCASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, \n\n    \n    CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 38, '$ccliente', ''),
(1930, 2, 'SELECT p.PERSC_Nombre as VENDEDOR\nFROM cji_usuario u  JOIN cji_persona p on p.PERSP_Codigo=u.PERSP_Codigo\nWHERE  p.PERSP_Codigo=$vendedor', 'CCVendedor', 38, '$vendedor', ''),
(1931, 2, 'select concat(GUIAREMC_Serie,\'-\',GUIAREMC_Numero) as NUMEROGIA1\nfrom cji_comprobante c \ninner join cji_comprobante_guiarem cg on cg.CPP_Codigo = c.CPP_Codigo\ninner join cji_guiarem g on g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo\nwhere c.CPP_Codigo =$numeroguia', 'CPP_Codigo', 38, '$numeroguia', ''),
(1932, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu_ConIgv as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO , cd.CPDEC_ITEMS as ITEM\nFROM cji_comprobantedetalle cd \nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo  \ninner join cji_comprobante c on c.CPP_Codigo = cd.CPP_Codigo WHERE cd.CPP_Codigo=$ccomp and CPDEC_FlagEstado=1', 'CPP_Codigo', 38, '$ccomp', 'grupo'),
(1933, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 38, '$forpap', ''),
(1934, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 38, '$monedcodigo', ''),
(1935, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI,\nsubstr(c.CPC_Fecha,-10,4) as anio ,substr(c.CPC_Fecha,-5,2) as mes ,substr(c.CPC_Fecha,-2,2) as UNIDAD\n, c.FORPAP_Codigo, c.MONED_Codigo, c.CPC_Numero as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 39, '$CodigoPrincipal', ''),
(1936, 2, 'SELECT com.CPP_Codigo , det.CPDEC_Descripcion as NOMBREP , det.CPDEC_Cantidad as CANTIDAD,det.CPDEC_Pu_ConIgv as PUNIT, det.CPDEC_Total as TOTALP\nFROM cji_comprobante com \ninner join cji_comprobantedetalle det on det.CPP_Codigo = com.CPP_Codigo\nwhere com.CPP_Codigo = $ccomp', 'CPP_Codigo', 39, '$ccomp', 'grupo'),
(1937, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 39, '$forpap', ''),
(1938, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 39, '$monedcodigo', ''),
(1939, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 39, '$ccliente', ''),
(1940, 1, 'SELECT GUIAREMC_PuntoPartida as PUNTOPARTI, GUIAREMC_PuntoLlegada as LLEGADA,\ng.GUIAREMP_Codigo,\n CONCAT(g.GUIAREMC_Serie,  \' \',  g.GUIAREMC_Numero\n  ) AS GUIA,\n  g.GUIAREMC_PuntoLlegada AS DESTINO,\n  g.CLIP_Codigo AS CODCLIEG,\n  GUIAREMC_Marca AS MARCAVIHEC,\n  GUIAREMC_Placa AS PLACASS,\nGUIAREMC_Certificado as CERINS,\n  GUIAREMC_RegistroMTC,\n  GUIAREMC_Certificado,\n  GUIAREMC_Licencia AS LICENCIACO,\n  GUIAREMC_NombreConductor AS CONDUCTOR2,\n  GUIAREMC_Observacion AS OBSERVACIO,\nDATE_FORMAT(GUIAREMC_FechaTraslado,\'%d/%m/%Y\') as FECHATRAS, DATE_FORMAT(GUIAREMC_FechaRegistro,\'%d/%m/%Y\') as FECHAEMI,\nSUBSTRING( GUIAREMC_FechaRegistro,  -19, 4 ) as fechaAnioB ,\nSUBSTRING( GUIAREMC_FechaRegistro,  -14, 2 ) as fechaMesB,\n SUBSTRING( GUIAREMC_FechaRegistro,  -11, 2 ) as fechaDiaB,\nGUIAREMC_total AS PRECIOT , TIPOMOVP_Codigo as MONTRANS\nFROM\n  cji_guiarem g\nWHERE\n  g.GUIAREMP_Codigo =$CodigoPrincipal', '', 40, '$CodigoPrincipal', ''),
(1941, 2, 'SELECT CONCAT( g.CPC_Serie,  \'-\', g.CPC_Numero ) AS NUMFACTU\nFROM cji_guiarem c\nINNER JOIN cji_comprobante_guiarem cg ON cg.GUIAREMP_Codigo = c.GUIAREMP_Codigo\nINNER JOIN cji_comprobante g ON g.CPP_Codigo = cg.CPP_Codigo\nWHERE c.GUIAREMP_Codigo =$guiaremcodigo', 'GUIAREMP_Codigo', 40, '$guiaremcodigo', ''),
(1942, 2, 'SELECT g.CPC_TipoOperacion, g.CLIP_Codigo, g.PROVP_Codigo , CASE g.GUIAREMC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as NOMBRE, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as DIRECCION, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo )END as RUC FROM cji_guiarem g WHERE g.GUIAREMP_Codigo = $ccliente', 'GUIAREMP_Codigo', 40, '$ccliente', ''),
(1943, 2, 'SELECT PROD_Codigo as PRODCODSERIE, GROUP_CONCAT( SERIC_Numero) as NUEVOSS FROM cji_serie s JOIN cji_seriedocumento cd on cd.SERIP_Codigo=s.SERIP_Codigo WHERE cd.DOCUP_Codigo=10 AND SERDOC_NumeroRef=$variableNuevo\n', 'GUIAREMP_Codigo', 40, '$variableNuevo', 'grupo2'),
(1944, 2, 'SELECT gd.GUIAREMDETC_Descripcion  as DESCRIP, gd.GUIAREMDETC_Cantidad as CANTIDAD, gd.PRODCTOP_Codigo as PRODCOD, und.UNDMED_Descripcion as UNIDAD,\ngd.GUIAREMDETC_Total as PRECIO ,  gd.GUIAREMDETC_ITEM as ITEM\nfrom cji_guiaremdetalle gd\nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=gd.UNDMED_Codigo \nINNER JOIN cji_guiarem g  ON g.GUIAREMP_Codigo=gd.GUIAREMP_Codigo\nWHERE gd.GUIAREMP_Codigo=$guiaremcod\n', 'GUIAREMP_Codigo', 40, '$guiaremcod', 'grupo'),
(1952, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI,\nsubstr(c.CPC_Fecha,-10,4) as anio ,substr(c.CPC_Fecha,-5,2) as mes ,substr(c.CPC_Fecha,-2,2) as UNIDAD\n, c.FORPAP_Codigo, c.MONED_Codigo, c.CPC_Numero as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 54, '$CodigoPrincipal', ''),
(1953, 2, 'SELECT com.CPP_Codigo , det.CPDEC_Descripcion as NOMBREP , det.CPDEC_Cantidad as CANTIDAD,det.CPDEC_Pu_ConIgv as PUNIT, det.CPDEC_Total as TOTALP\nFROM cji_comprobante com \ninner join cji_comprobantedetalle det on det.CPP_Codigo = com.CPP_Codigo\nwhere com.CPP_Codigo = $ccomp', 'CPP_Codigo', 54, '$ccomp', 'grupo'),
(1954, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 54, '$forpap', ''),
(1955, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 54, '$monedcodigo', ''),
(1956, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 54, '$ccliente', ''),
(1962, 1, 'SELECT\n  c.CPP_Codigo,\n  c.CLIP_Codigo AS CCLIENTE,\n  CPC_Vendedor AS CCVendedor,\n  c.CPC_total AS MONTOLETRA,\n  c.CPC_Direccion AS DIRECCION,\nCONCAT(m.MONED_Simbolo, \' \', c.CPC_total) AS TOTAL,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_igv) AS IGV,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_subtotal) AS SUBTOTAL,\n  SUBSTRING( CPC_Fecha,  -10, 4 ) as fechaAnioB ,\nSUBSTRING( CPC_Fecha,  -5, 2 ) as fechaMesB,\n SUBSTRING( CPC_Fecha,  -2, 2 ) as fechaDiaB,\n  c.FORPAP_Codigo,\n  c.MONED_Codigo,m.MONED_Descripcion as MONLETR,\n  CONCAT(c.CPC_Serie, \' \', c.CPC_Numero) AS COMPROBANTE,\nCPC_igv100 AS IGV100, CPC_Compra AS COMPRA\nFROM cji_comprobante c\nJOIN cji_moneda m on m.MONED_Codigo = c.MONED_Codigo where CPP_Codigo=$CodigoPrincipal', '', 68, '$CodigoPrincipal', ''),
(1963, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo ,c.CPC_Direccion AS DIRECCION ,\nCASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, \n\n    \n    CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 68, '$ccliente', ''),
(1964, 2, 'SELECT p.PERSC_Nombre as VENDEDOR\nFROM cji_usuario u  JOIN cji_persona p on p.PERSP_Codigo=u.PERSP_Codigo\nWHERE  p.PERSP_Codigo=$vendedor', 'CCVendedor', 68, '$vendedor', ''),
(1965, 2, 'select concat(GUIAREMC_Serie,\'-\',GUIAREMC_Numero) as NUMEROGIA1\nfrom cji_comprobante c \ninner join cji_comprobante_guiarem cg on cg.CPP_Codigo = c.CPP_Codigo\ninner join cji_guiarem g on g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo\nwhere c.CPP_Codigo =$numeroguia', 'CPP_Codigo', 68, '$numeroguia', ''),
(1966, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu_ConIgv as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO , cd.CPDEC_ITEMS as ITEM\nFROM cji_comprobantedetalle cd \nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo  \ninner join cji_comprobante c on c.CPP_Codigo = cd.CPP_Codigo WHERE cd.CPP_Codigo=$ccomp and CPDEC_FlagEstado=1', 'CPP_Codigo', 68, '$ccomp', 'grupo'),
(1967, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 68, '$forpap', ''),
(1968, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 68, '$monedcodigo', ''),
(1969, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI,\nsubstr(c.CPC_Fecha,-10,4) as anio ,substr(c.CPC_Fecha,-5,2) as mes ,substr(c.CPC_Fecha,-2,2) as UNIDAD\n, c.FORPAP_Codigo, c.MONED_Codigo, c.CPC_Numero as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 69, '$CodigoPrincipal', ''),
(1970, 2, 'SELECT com.CPP_Codigo , det.CPDEC_Descripcion as NOMBREP , det.CPDEC_Cantidad as CANTIDAD,det.CPDEC_Pu_ConIgv as PUNIT, det.CPDEC_Total as TOTALP\nFROM cji_comprobante com \ninner join cji_comprobantedetalle det on det.CPP_Codigo = com.CPP_Codigo\nwhere com.CPP_Codigo = $ccomp', 'CPP_Codigo', 69, '$ccomp', 'grupo'),
(1971, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 69, '$forpap', ''),
(1972, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 69, '$monedcodigo', ''),
(1973, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 69, '$ccliente', ''),
(1974, 1, 'SELECT GUIAREMC_PuntoPartida as PUNTOPARTI, GUIAREMC_PuntoLlegada as LLEGADA,\ng.GUIAREMP_Codigo,\n CONCAT(g.GUIAREMC_Serie,  \' \',  g.GUIAREMC_Numero\n  ) AS GUIA,\n  g.GUIAREMC_PuntoLlegada AS DESTINO,\n  g.CLIP_Codigo AS CODCLIEG,\n  GUIAREMC_Marca AS MARCAVIHEC,\n  GUIAREMC_Placa AS PLACASS,\nGUIAREMC_Certificado as CERINS,\n  GUIAREMC_RegistroMTC,\n  GUIAREMC_Certificado,\n  GUIAREMC_Licencia AS LICENCIACO,\n  GUIAREMC_NombreConductor AS CONDUCTOR2,\n  GUIAREMC_Observacion AS OBSERVACIO,\nDATE_FORMAT(GUIAREMC_FechaTraslado,\'%d/%m/%Y\') as FECHATRAS, DATE_FORMAT(GUIAREMC_FechaRegistro,\'%d/%m/%Y\') as FECHAEMI,\nSUBSTRING( GUIAREMC_FechaRegistro,  -19, 4 ) as fechaAnioB ,\nSUBSTRING( GUIAREMC_FechaRegistro,  -14, 2 ) as fechaMesB,\n SUBSTRING( GUIAREMC_FechaRegistro,  -11, 2 ) as fechaDiaB,\nGUIAREMC_total AS PRECIOT , TIPOMOVP_Codigo as MONTRANS\nFROM\n  cji_guiarem g\nWHERE\n  g.GUIAREMP_Codigo =$CodigoPrincipal', '', 70, '$CodigoPrincipal', ''),
(1975, 2, 'SELECT CONCAT( g.CPC_Serie,  \'-\', g.CPC_Numero ) AS NUMFACTU\nFROM cji_guiarem c\nINNER JOIN cji_comprobante_guiarem cg ON cg.GUIAREMP_Codigo = c.GUIAREMP_Codigo\nINNER JOIN cji_comprobante g ON g.CPP_Codigo = cg.CPP_Codigo\nWHERE c.GUIAREMP_Codigo =$guiaremcodigo', 'GUIAREMP_Codigo', 70, '$guiaremcodigo', ''),
(1976, 2, 'SELECT g.CPC_TipoOperacion, g.CLIP_Codigo, g.PROVP_Codigo , CASE g.GUIAREMC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as NOMBRE, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as DIRECCION, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo )END as RUC FROM cji_guiarem g WHERE g.GUIAREMP_Codigo = $ccliente', 'GUIAREMP_Codigo', 70, '$ccliente', ''),
(1977, 2, 'SELECT PROD_Codigo as PRODCODSERIE, GROUP_CONCAT( SERIC_Numero) as NUEVOSS FROM cji_serie s JOIN cji_seriedocumento cd on cd.SERIP_Codigo=s.SERIP_Codigo WHERE cd.DOCUP_Codigo=10 AND SERDOC_NumeroRef=$variableNuevo\n', 'GUIAREMP_Codigo', 70, '$variableNuevo', 'grupo2'),
(1978, 2, 'SELECT gd.GUIAREMDETC_Descripcion  as DESCRIP, gd.GUIAREMDETC_Cantidad as CANTIDAD, gd.PRODCTOP_Codigo as PRODCOD, und.UNDMED_Descripcion as UNIDAD,\ngd.GUIAREMDETC_Total as PRECIO ,  gd.GUIAREMDETC_ITEM as ITEM\nfrom cji_guiaremdetalle gd\nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=gd.UNDMED_Codigo \nINNER JOIN cji_guiarem g  ON g.GUIAREMP_Codigo=gd.GUIAREMP_Codigo\nWHERE gd.GUIAREMP_Codigo=$guiaremcod\n', 'GUIAREMP_Codigo', 70, '$guiaremcod', 'grupo'),
(1979, 1, 'SELECT\n  c.CPP_Codigo,\n  c.CLIP_Codigo AS CCLIENTE,\n  CPC_Vendedor AS CCVendedor,\n  c.CPC_total AS MONTOLETRA,\n  c.CPC_Direccion AS DIRECCION,\nCONCAT(m.MONED_Simbolo, \' \', c.CPC_total) AS TOTAL,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_igv) AS IGV,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_subtotal) AS SUBTOTAL,\n  SUBSTRING( CPC_Fecha,  -10, 4 ) as fechaAnioB ,\nSUBSTRING( CPC_Fecha,  -5, 2 ) as fechaMesB,\n SUBSTRING( CPC_Fecha,  -2, 2 ) as fechaDiaB,\n  c.FORPAP_Codigo,\n  c.MONED_Codigo,m.MONED_Descripcion as MONLETR,\n  CONCAT(c.CPC_Serie, \' \', c.CPC_Numero) AS COMPROBANTE,\nCPC_igv100 AS IGV100, CPC_Compra AS COMPRA\nFROM cji_comprobante c\nJOIN cji_moneda m on m.MONED_Codigo = c.MONED_Codigo where CPP_Codigo=$CodigoPrincipal', '', 83, '$CodigoPrincipal', ''),
(1980, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo ,c.CPC_Direccion AS DIRECCION ,\nCASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, \n\n    \n    CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 83, '$ccliente', ''),
(1981, 2, 'SELECT p.PERSC_Nombre as VENDEDOR\nFROM cji_usuario u  JOIN cji_persona p on p.PERSP_Codigo=u.PERSP_Codigo\nWHERE  p.PERSP_Codigo=$vendedor', 'CCVendedor', 83, '$vendedor', ''),
(1982, 2, 'select concat(GUIAREMC_Serie,\'-\',GUIAREMC_Numero) as NUMEROGIA1\nfrom cji_comprobante c \ninner join cji_comprobante_guiarem cg on cg.CPP_Codigo = c.CPP_Codigo\ninner join cji_guiarem g on g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo\nwhere c.CPP_Codigo =$numeroguia', 'CPP_Codigo', 83, '$numeroguia', ''),
(1983, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu_ConIgv as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO , cd.CPDEC_ITEMS as ITEM\nFROM cji_comprobantedetalle cd \nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo  \ninner join cji_comprobante c on c.CPP_Codigo = cd.CPP_Codigo WHERE cd.CPP_Codigo=$ccomp and CPDEC_FlagEstado=1', 'CPP_Codigo', 83, '$ccomp', 'grupo'),
(1984, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 83, '$forpap', ''),
(1985, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 83, '$monedcodigo', ''),
(1986, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI,\nsubstr(c.CPC_Fecha,-10,4) as anio ,substr(c.CPC_Fecha,-5,2) as mes ,substr(c.CPC_Fecha,-2,2) as UNIDAD\n, c.FORPAP_Codigo, c.MONED_Codigo, c.CPC_Numero as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 84, '$CodigoPrincipal', ''),
(1987, 2, 'SELECT com.CPP_Codigo , det.CPDEC_Descripcion as NOMBREP , det.CPDEC_Cantidad as CANTIDAD,det.CPDEC_Pu_ConIgv as PUNIT, det.CPDEC_Total as TOTALP\nFROM cji_comprobante com \ninner join cji_comprobantedetalle det on det.CPP_Codigo = com.CPP_Codigo\nwhere com.CPP_Codigo = $ccomp', 'CPP_Codigo', 84, '$ccomp', 'grupo'),
(1988, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 84, '$forpap', ''),
(1989, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 84, '$monedcodigo', '');
INSERT INTO `cji_documentosentenica` (`DOCSENT_Codigo`, `DOCSENT_Tipo`, `DOCSENT_Select`, `DOCSENT_CodigoRelacion`, `COMPCONFIDOCP_Codigo`, `DOCSENT_VariableCodigoRelacion`, `DOCSENT_VariableGrupo`) VALUES
(1990, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 84, '$ccliente', ''),
(1991, 1, 'SELECT GUIAREMC_PuntoPartida as PUNTOPARTI, GUIAREMC_PuntoLlegada as LLEGADA,\ng.GUIAREMP_Codigo,\n CONCAT(g.GUIAREMC_Serie,  \' \',  g.GUIAREMC_Numero\n  ) AS GUIA,\n  g.GUIAREMC_PuntoLlegada AS DESTINO,\n  g.CLIP_Codigo AS CODCLIEG,\n  GUIAREMC_Marca AS MARCAVIHEC,\n  GUIAREMC_Placa AS PLACASS,\nGUIAREMC_Certificado as CERINS,\n  GUIAREMC_RegistroMTC,\n  GUIAREMC_Certificado,\n  GUIAREMC_Licencia AS LICENCIACO,\n  GUIAREMC_NombreConductor AS CONDUCTOR2,\n  GUIAREMC_Observacion AS OBSERVACIO,\nDATE_FORMAT(GUIAREMC_FechaTraslado,\'%d/%m/%Y\') as FECHATRAS, DATE_FORMAT(GUIAREMC_FechaRegistro,\'%d/%m/%Y\') as FECHAEMI,\nSUBSTRING( GUIAREMC_FechaRegistro,  -19, 4 ) as fechaAnioB ,\nSUBSTRING( GUIAREMC_FechaRegistro,  -14, 2 ) as fechaMesB,\n SUBSTRING( GUIAREMC_FechaRegistro,  -11, 2 ) as fechaDiaB,\nGUIAREMC_total AS PRECIOT , TIPOMOVP_Codigo as MONTRANS\nFROM\n  cji_guiarem g\nWHERE\n  g.GUIAREMP_Codigo =$CodigoPrincipal', '', 85, '$CodigoPrincipal', ''),
(1992, 2, 'SELECT CONCAT( g.CPC_Serie,  \'-\', g.CPC_Numero ) AS NUMFACTU\nFROM cji_guiarem c\nINNER JOIN cji_comprobante_guiarem cg ON cg.GUIAREMP_Codigo = c.GUIAREMP_Codigo\nINNER JOIN cji_comprobante g ON g.CPP_Codigo = cg.CPP_Codigo\nWHERE c.GUIAREMP_Codigo =$guiaremcodigo', 'GUIAREMP_Codigo', 85, '$guiaremcodigo', ''),
(1993, 2, 'SELECT g.CPC_TipoOperacion, g.CLIP_Codigo, g.PROVP_Codigo , CASE g.GUIAREMC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as NOMBRE, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as DIRECCION, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo )END as RUC FROM cji_guiarem g WHERE g.GUIAREMP_Codigo = $ccliente', 'GUIAREMP_Codigo', 85, '$ccliente', ''),
(1994, 2, 'SELECT PROD_Codigo as PRODCODSERIE, GROUP_CONCAT( SERIC_Numero) as NUEVOSS FROM cji_serie s JOIN cji_seriedocumento cd on cd.SERIP_Codigo=s.SERIP_Codigo WHERE cd.DOCUP_Codigo=10 AND SERDOC_NumeroRef=$variableNuevo\n', 'GUIAREMP_Codigo', 85, '$variableNuevo', 'grupo2'),
(1995, 2, 'SELECT gd.GUIAREMDETC_Descripcion  as DESCRIP, gd.GUIAREMDETC_Cantidad as CANTIDAD, gd.PRODCTOP_Codigo as PRODCOD, und.UNDMED_Descripcion as UNIDAD,\ngd.GUIAREMDETC_Total as PRECIO ,  gd.GUIAREMDETC_ITEM as ITEM\nfrom cji_guiaremdetalle gd\nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=gd.UNDMED_Codigo \nINNER JOIN cji_guiarem g  ON g.GUIAREMP_Codigo=gd.GUIAREMP_Codigo\nWHERE gd.GUIAREMP_Codigo=$guiaremcod\n', 'GUIAREMP_Codigo', 85, '$guiaremcod', 'grupo'),
(2003, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI,\nsubstr(c.CPC_Fecha,-10,4) as anio ,substr(c.CPC_Fecha,-5,2) as mes ,substr(c.CPC_Fecha,-2,2) as UNIDAD\n, c.FORPAP_Codigo, c.MONED_Codigo, c.CPC_Numero as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 99, '$CodigoPrincipal', ''),
(2004, 2, 'SELECT com.CPP_Codigo , det.CPDEC_Descripcion as NOMBREP , det.CPDEC_Cantidad as CANTIDAD,det.CPDEC_Pu_ConIgv as PUNIT, det.CPDEC_Total as TOTALP\nFROM cji_comprobante com \ninner join cji_comprobantedetalle det on det.CPP_Codigo = com.CPP_Codigo\nwhere com.CPP_Codigo = $ccomp', 'CPP_Codigo', 99, '$ccomp', 'grupo'),
(2005, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 99, '$forpap', ''),
(2006, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 99, '$monedcodigo', ''),
(2007, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 99, '$ccliente', ''),
(2008, 1, 'SELECT GUIAREMC_PuntoPartida as PUNTOPARTI, GUIAREMC_PuntoLlegada as LLEGADA,\ng.GUIAREMP_Codigo,\n CONCAT(g.GUIAREMC_Serie,  \' \',  g.GUIAREMC_Numero\n  ) AS GUIA,\n  g.GUIAREMC_PuntoLlegada AS DESTINO,\n  g.CLIP_Codigo AS CODCLIEG,\n  GUIAREMC_Marca AS MARCAVIHEC,\n  GUIAREMC_Placa AS PLACASS,\nGUIAREMC_Certificado as CERINS,\n  GUIAREMC_RegistroMTC,\n  GUIAREMC_Certificado,\n  GUIAREMC_Licencia AS LICENCIACO,\n  GUIAREMC_NombreConductor AS CONDUCTOR2,\n  GUIAREMC_Observacion AS OBSERVACIO,\nDATE_FORMAT(GUIAREMC_FechaTraslado,\'%d/%m/%Y\') as FECHATRAS, DATE_FORMAT(GUIAREMC_FechaRegistro,\'%d/%m/%Y\') as FECHAEMI,\nSUBSTRING( GUIAREMC_FechaRegistro,  -19, 4 ) as fechaAnioB ,\nSUBSTRING( GUIAREMC_FechaRegistro,  -14, 2 ) as fechaMesB,\n SUBSTRING( GUIAREMC_FechaRegistro,  -11, 2 ) as fechaDiaB,\nGUIAREMC_total AS PRECIOT , TIPOMOVP_Codigo as MONTRANS\nFROM\n  cji_guiarem g\nWHERE\n  g.GUIAREMP_Codigo =$CodigoPrincipal', '', 100, '$CodigoPrincipal', ''),
(2009, 2, 'SELECT CONCAT( g.CPC_Serie,  \'-\', g.CPC_Numero ) AS NUMFACTU\nFROM cji_guiarem c\nINNER JOIN cji_comprobante_guiarem cg ON cg.GUIAREMP_Codigo = c.GUIAREMP_Codigo\nINNER JOIN cji_comprobante g ON g.CPP_Codigo = cg.CPP_Codigo\nWHERE c.GUIAREMP_Codigo =$guiaremcodigo', 'GUIAREMP_Codigo', 100, '$guiaremcodigo', ''),
(2010, 2, 'SELECT g.CPC_TipoOperacion, g.CLIP_Codigo, g.PROVP_Codigo , CASE g.GUIAREMC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as NOMBRE, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as DIRECCION, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo )END as RUC FROM cji_guiarem g WHERE g.GUIAREMP_Codigo = $ccliente', 'GUIAREMP_Codigo', 100, '$ccliente', ''),
(2011, 2, 'SELECT PROD_Codigo as PRODCODSERIE, GROUP_CONCAT( SERIC_Numero) as NUEVOSS FROM cji_serie s JOIN cji_seriedocumento cd on cd.SERIP_Codigo=s.SERIP_Codigo WHERE cd.DOCUP_Codigo=10 AND SERDOC_NumeroRef=$variableNuevo\n', 'GUIAREMP_Codigo', 100, '$variableNuevo', 'grupo2'),
(2012, 2, 'SELECT gd.GUIAREMDETC_Descripcion  as DESCRIP, gd.GUIAREMDETC_Cantidad as CANTIDAD, gd.PRODCTOP_Codigo as PRODCOD, und.UNDMED_Descripcion as UNIDAD,\ngd.GUIAREMDETC_Total as PRECIO ,  gd.GUIAREMDETC_ITEM as ITEM\nfrom cji_guiaremdetalle gd\nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=gd.UNDMED_Codigo \nINNER JOIN cji_guiarem g  ON g.GUIAREMP_Codigo=gd.GUIAREMP_Codigo\nWHERE gd.GUIAREMP_Codigo=$guiaremcod\n', 'GUIAREMP_Codigo', 100, '$guiaremcod', 'grupo'),
(2034, 1, 'SELECT\n  c.CPP_Codigo,\n  c.CLIP_Codigo AS CCLIENTE,\n  CPC_Vendedor AS CCVendedor,\n  c.CPC_total AS MONTOLETRA,\n  c.CPC_Direccion AS DIRECCION,\nCONCAT(m.MONED_Simbolo, \' \', c.CPC_total) AS TOTAL,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_igv) AS IGV,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_subtotal) AS SUBTOTAL,\n  SUBSTRING( CPC_Fecha,  -10, 4 ) as fechaAnioB ,\nSUBSTRING( CPC_Fecha,  -5, 2 ) as fechaMesB,\n SUBSTRING( CPC_Fecha,  -2, 2 ) as fechaDiaB,\n  c.FORPAP_Codigo,\n  c.MONED_Codigo,m.MONED_Descripcion as MONLETR,\n  CONCAT(c.CPC_Serie, \' \', c.CPC_Numero) AS COMPROBANTE,\nCPC_igv100 AS IGV100, CPC_Compra AS COMPRA\nFROM cji_comprobante c\nJOIN cji_moneda m on m.MONED_Codigo = c.MONED_Codigo where CPP_Codigo=$CodigoPrincipal', '', 98, '$CodigoPrincipal', ''),
(2035, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo ,c.CPC_Direccion AS DIRECCION ,\nCASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, \n\n    \n    CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 98, '$ccliente', ''),
(2036, 2, 'SELECT p.PERSC_Nombre as VENDEDOR\nFROM cji_usuario u  JOIN cji_persona p on p.PERSP_Codigo=u.PERSP_Codigo\nWHERE  p.PERSP_Codigo=$vendedor', 'CCVendedor', 98, '$vendedor', ''),
(2037, 2, 'select concat(GUIAREMC_Serie,\'-\',GUIAREMC_Numero) as NUMEROGIA1\nfrom cji_comprobante c \ninner join cji_comprobante_guiarem cg on cg.CPP_Codigo = c.CPP_Codigo\ninner join cji_guiarem g on g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo\nwhere c.CPP_Codigo =$numeroguia', 'CPP_Codigo', 98, '$numeroguia', ''),
(2038, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu_ConIgv as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO , cd.CPDEC_ITEMS as ITEM\nFROM cji_comprobantedetalle cd \nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo  \ninner join cji_comprobante c on c.CPP_Codigo = cd.CPP_Codigo WHERE cd.CPP_Codigo=$ccomp and CPDEC_FlagEstado=1', 'CPP_Codigo', 98, '$ccomp', 'grupo'),
(2039, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 98, '$forpap', ''),
(2040, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 98, '$monedcodigo', ''),
(2041, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,CPC_Vendedor as CCVendedor,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI, c.FORPAP_Codigo, c.MONED_Codigo, CONCAT (c.CPC_Serie,\' \',c.CPC_Numero) as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 23, '$CodigoPrincipal', ''),
(2042, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO FROM cji_comprobantedetalle cd INNER JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo WHERE cd.CPP_Codigo=$ccomp', 'CPP_Codigo', 23, '$ccomp', 'grupo'),
(2043, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 23, '$forpap', ''),
(2044, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 23, '$monedcodigo', ''),
(2045, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 23, '$ccliente', ''),
(2046, 2, 'SELECT p.PERSC_Nombre as VENDEDOR\nFROM cji_usuario u  JOIN cji_persona p on p.PERSP_Codigo=u.PERSP_Codigo\nWHERE  p.PERSP_Codigo=$vendedor', 'CCVendedor', 23, '$vendedor', ''),
(2047, 2, 'select concat(GUIAREMC_Serie,\'-\',GUIAREMC_Numero) as NUMEROGIA1\nfrom cji_comprobante c \ninner join cji_comprobante_guiarem cg on cg.CPP_Codigo = c.CPP_Codigo\ninner join cji_guiarem g on g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo\nwhere  c.CPP_Codigo =$numeroguia', 'CPP_Codigo', 23, '$numeroguia', ''),
(2395, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI,\nsubstr(c.CPC_Fecha,-10,4) as anio ,substr(c.CPC_Fecha,-5,2) as mes ,substr(c.CPC_Fecha,-2,2) as UNIDAD\n, c.FORPAP_Codigo, c.MONED_Codigo, c.CPC_Numero as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 9, '$CodigoPrincipal', ''),
(2396, 2, 'SELECT com.CPP_Codigo , det.CPDEC_Descripcion as NOMBREP , det.CPDEC_Cantidad as CANTIDAD,det.CPDEC_Pu_ConIgv as PUNIT, det.CPDEC_Total as TOTALP\nFROM cji_comprobante com \ninner join cji_comprobantedetalle det on det.CPP_Codigo = com.CPP_Codigo\nwhere com.CPP_Codigo = $ccomp', 'CPP_Codigo', 9, '$ccomp', 'grupo'),
(2397, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 9, '$forpap', ''),
(2398, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 9, '$monedcodigo', ''),
(2399, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 9, '$ccliente', ''),
(2587, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI, c.FORPAP_Codigo, c.MONED_Codigo, CONCAT (c.CPC_Serie,\' \',c.CPC_Numero) as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 14, '$CodigoPrincipal', ''),
(2588, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 14, '$ccliente', ''),
(2589, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO FROM cji_comprobantedetalle cd INNER JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo WHERE cd.CPP_Codigo=$ccomp', 'CPP_Codigo', 14, '$ccomp', 'grupo'),
(2590, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 14, '$forpap', ''),
(2591, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 14, '$monedcodigo', ''),
(2592, 1, 'SELECT GUIAREMC_PuntoPartida as PUNTOPARTI, GUIAREMC_PuntoLlegada as LLEGADA,\ng.GUIAREMP_Codigo,\n CONCAT(g.GUIAREMC_Serie,  \' \',  g.GUIAREMC_Numero\n  ) AS GUIA,\n  g.GUIAREMC_PuntoLlegada AS DESTINO,\n  g.CLIP_Codigo AS CODCLIEG,\n  GUIAREMC_Marca AS MARCAVIHEC,\n  CONCAT(g.GUIAREMC_Marca,\' \',g.GUIAREMC_Placa) AS PLACASS,\nGUIAREMC_Certificado as CERINS,\n  GUIAREMC_RegistroMTC,\n  GUIAREMC_Certificado,\n  GUIAREMC_Licencia AS LICENCIACO,\n  GUIAREMC_NombreConductor AS CONDUCTOR2,\n  GUIAREMC_Observacion AS OBS,\nDATE_FORMAT(GUIAREMC_FechaTraslado,\'%d/%m/%Y\') as FECHATRAS, DATE_FORMAT(GUIAREMC_FechaRegistro,\'%d/%m/%Y\') as FECHAEMI,\nSUBSTRING( GUIAREMC_FechaRegistro,  -19, 4 ) as fechaAnioB ,\nSUBSTRING( GUIAREMC_FechaRegistro,  -14, 2 ) as fechaMesB,\n SUBSTRING( GUIAREMC_FechaRegistro,  -11, 2 ) as fechaDiaB,\nGUIAREMC_total AS PRECIOT , TIPOMOVP_Codigo as MONTRANS\nFROM\n  cji_guiarem g\nWHERE\n  g.GUIAREMP_Codigo =$CodigoPrincipal', '', 10, '$CodigoPrincipal', ''),
(2593, 2, 'SELECT CONCAT( g.CPC_Serie,  \'-\', g.CPC_Numero ) AS NUMFACTU\nFROM cji_guiarem c\nINNER JOIN cji_comprobante_guiarem cg ON cg.GUIAREMP_Codigo = c.GUIAREMP_Codigo\nINNER JOIN cji_comprobante g ON g.CPP_Codigo = cg.CPP_Codigo\nWHERE c.GUIAREMP_Codigo =$guiaremcodigo', 'GUIAREMP_Codigo', 10, '$guiaremcodigo', ''),
(2594, 2, 'SELECT g.CPC_TipoOperacion, g.CLIP_Codigo, g.PROVP_Codigo , CASE g.GUIAREMC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as NOMBRE, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as DIRECCION, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo )END as RUC FROM cji_guiarem g WHERE g.GUIAREMP_Codigo = $ccliente', 'GUIAREMP_Codigo', 10, '$ccliente', ''),
(2595, 2, 'SELECT PROD_Codigo as PRODCODSERIE, GROUP_CONCAT( SERIC_Numero) as NUEVOSS FROM cji_serie s JOIN cji_seriedocumento cd on cd.SERIP_Codigo=s.SERIP_Codigo WHERE cd.DOCUP_Codigo=10 AND SERDOC_NumeroRef=$variableNuevo\n', 'GUIAREMP_Codigo', 10, '$variableNuevo', 'grupo2'),
(2596, 2, 'SELECT gd.GUIAREMDETC_Descripcion  as DESCRIP, gd.GUIAREMDETC_Cantidad as CANTIDAD, gd.PRODCTOP_Codigo as PRODCOD, und.UNDMED_Descripcion as UNIDAD,\ngd.GUIAREMDETC_Total as PRECIO ,  gd.GUIAREMDETC_ITEM as ITEM\nfrom cji_guiaremdetalle gd\nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=gd.UNDMED_Codigo \nINNER JOIN cji_guiarem g  ON g.GUIAREMP_Codigo=gd.GUIAREMP_Codigo\nWHERE gd.GUIAREMP_Codigo=$guiaremcod\n', 'GUIAREMP_Codigo', 10, '$guiaremcod', 'grupo'),
(2597, 1, 'SELECT GUIAREMC_PuntoPartida as PUNTOPARTI, GUIAREMC_PuntoLlegada as LLEGADA,\ng.GUIAREMP_Codigo,\n CONCAT(g.GUIAREMC_Serie,  \' \',  g.GUIAREMC_Numero\n  ) AS GUIA,\n  g.GUIAREMC_PuntoLlegada AS DESTINO,\n  g.CLIP_Codigo AS CODCLIEG,\n  GUIAREMC_Marca AS MARCAVIHEC,\n  CONCAT(g.GUIAREMC_Marca,\' \',g.GUIAREMC_Placa) AS PLACASS,\nGUIAREMC_Certificado as CERINS,\n  GUIAREMC_RegistroMTC,\n  GUIAREMC_Certificado,\n  GUIAREMC_Licencia AS LICENCIACO,\n  GUIAREMC_NombreConductor AS CONDUCTOR2,\n  GUIAREMC_Observacion AS OBS,\nDATE_FORMAT(GUIAREMC_FechaTraslado,\'%d/%m/%Y\') as FECHATRAS, DATE_FORMAT(GUIAREMC_FechaRegistro,\'%d/%m/%Y\') as FECHAEMI,\nSUBSTRING( GUIAREMC_FechaRegistro,  -19, 4 ) as fechaAnioB ,\nSUBSTRING( GUIAREMC_FechaRegistro,  -14, 2 ) as fechaMesB,\n SUBSTRING( GUIAREMC_FechaRegistro,  -11, 2 ) as fechaDiaB,\nGUIAREMC_total AS PRECIOT , TIPOMOVP_Codigo as MONTRANS\nFROM\n  cji_guiarem g\nWHERE\n  g.GUIAREMP_Codigo =$CodigoPrincipal', '', 55, '$CodigoPrincipal', ''),
(2598, 2, 'SELECT CONCAT( g.CPC_Serie,  \'-\', g.CPC_Numero ) AS NUMFACTU\nFROM cji_guiarem c\nINNER JOIN cji_comprobante_guiarem cg ON cg.GUIAREMP_Codigo = c.GUIAREMP_Codigo\nINNER JOIN cji_comprobante g ON g.CPP_Codigo = cg.CPP_Codigo\nWHERE c.GUIAREMP_Codigo =$guiaremcodigo', 'GUIAREMP_Codigo', 55, '$guiaremcodigo', ''),
(2599, 2, 'SELECT g.CPC_TipoOperacion, g.CLIP_Codigo, g.PROVP_Codigo , CASE g.GUIAREMC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as NOMBRE, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as DIRECCION, CASE g.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo )END as RUC FROM cji_guiarem g WHERE g.GUIAREMP_Codigo = $ccliente', 'GUIAREMP_Codigo', 55, '$ccliente', ''),
(2600, 2, 'SELECT PROD_Codigo as PRODCODSERIE, GROUP_CONCAT( SERIC_Numero) as NUEVOSS FROM cji_serie s JOIN cji_seriedocumento cd on cd.SERIP_Codigo=s.SERIP_Codigo WHERE cd.DOCUP_Codigo=10 AND SERDOC_NumeroRef=$variableNuevo\n', 'GUIAREMP_Codigo', 55, '$variableNuevo', 'grupo2'),
(2601, 2, 'SELECT gd.GUIAREMDETC_Descripcion  as DESCRIP, gd.GUIAREMDETC_Cantidad as CANTIDAD, gd.PRODCTOP_Codigo as PRODCOD, und.UNDMED_Descripcion as UNIDAD,\ngd.GUIAREMDETC_Total as PRECIO ,  gd.GUIAREMDETC_ITEM as ITEM\nfrom cji_guiaremdetalle gd\nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=gd.UNDMED_Codigo \nINNER JOIN cji_guiarem g  ON g.GUIAREMP_Codigo=gd.GUIAREMP_Codigo\nWHERE gd.GUIAREMP_Codigo=$guiaremcod\n', 'GUIAREMP_Codigo', 55, '$guiaremcod', 'grupo'),
(2693, 1, 'SELECT\n  c.CPP_Codigo,\n  c.CLIP_Codigo AS CCLIENTE,\n  CPC_Vendedor AS CCVendedor,\n  c.CPC_total AS MONTOLETRA,\n  c.CPC_Direccion AS DIRECCION,\nCONCAT(m.MONED_Simbolo, \' \', c.CPC_total) AS TOTAL,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_igv) AS IGV,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_subtotal) AS SUBTOTAL,\n  SUBSTRING( CPC_Fecha,  -10, 4 ) as fechaAnioB ,\nSUBSTRING( CPC_Fecha,  -5, 2 ) as fechaMesB,\n SUBSTRING( CPC_Fecha,  -2, 2 ) as fechaDiaB,\n  c.FORPAP_Codigo,\n  c.MONED_Codigo,m.MONED_Descripcion as MONLETR,\n  CONCAT(c.CPC_Serie, \' \', c.CPC_Numero) AS COMPROBANTE,\nCPC_igv100 AS IGV100, CPC_Compra AS COMPRA,CONCAT(c.CPC_Serie, \'- \',c.CPP_Compracliente) AS oventa\nFROM cji_comprobante c\nJOIN cji_moneda m on m.MONED_Codigo = c.MONED_Codigo \nleft JOIN cji_ordencompra oc on oc.OCOMP_Codigo = c.OCOMP_Codigo\nwhere CPP_Codigo=$CodigoPrincipal', '', 8, '$CodigoPrincipal', ''),
(2694, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo ,c.CPC_Direccion AS DIRECCION ,\nCASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, \n\n    \n    CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 8, '$ccliente', ''),
(2695, 2, 'SELECT p.PERSC_Nombre as VENDEDOR\nFROM cji_usuario u  JOIN cji_persona p on p.PERSP_Codigo=u.PERSP_Codigo\nWHERE  p.PERSP_Codigo=$vendedor', 'CCVendedor', 8, '$vendedor', ''),
(2696, 2, 'select concat(GUIAREMC_Serie,\'-\',GUIAREMC_Numero) as NUMEROGIA1\nfrom cji_comprobante c \ninner join cji_comprobante_guiarem cg on cg.CPP_Codigo = c.CPP_Codigo\ninner join cji_guiarem g on g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo\nwhere c.CPP_Codigo =$numeroguia', 'CPP_Codigo', 8, '$numeroguia', ''),
(2697, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu_ConIgv as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO , cd.CPDEC_ITEMS as ITEM\nFROM cji_comprobantedetalle cd \nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo  \ninner join cji_comprobante c on c.CPP_Codigo = cd.CPP_Codigo WHERE cd.CPP_Codigo=$ccomp and CPDEC_FlagEstado=1', 'CPP_Codigo', 8, '$ccomp', 'grupo'),
(2698, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 8, '$forpap', ''),
(2699, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 8, '$monedcodigo', ''),
(2700, 1, 'SELECT\n  c.CPP_Codigo,\n  c.CLIP_Codigo AS CCLIENTE,\n  CPC_Vendedor AS CCVendedor,\n  c.CPC_total AS MONTOLETRA,\n  c.CPC_Direccion AS DIRECCION,\nCONCAT(m.MONED_Simbolo, \' \', c.CPC_total) AS TOTAL,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_igv) AS IGV,\n  CONCAT(m.MONED_Simbolo, \' \', c.CPC_subtotal) AS SUBTOTAL,\n  SUBSTRING( CPC_Fecha,  -10, 4 ) as fechaAnioB ,\nSUBSTRING( CPC_Fecha,  -5, 2 ) as fechaMesB,\n SUBSTRING( CPC_Fecha,  -2, 2 ) as fechaDiaB,\n  c.FORPAP_Codigo,\n  c.MONED_Codigo,m.MONED_Descripcion as MONLETR,\n  CONCAT(c.CPC_Serie, \' \', c.CPC_Numero) AS COMPROBANTE,\nCPC_igv100 AS IGV100, CPC_Compra AS COMPRA\nFROM cji_comprobante c\nJOIN cji_moneda m on m.MONED_Codigo = c.MONED_Codigo where CPP_Codigo=$CodigoPrincipal', '', 53, '$CodigoPrincipal', ''),
(2701, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo ,c.CPC_Direccion AS DIRECCION ,\nCASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,\' \',pe.PERSC_ApellidoPaterno,\' \',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, \n\n    \n    CASE c.CPC_TipoOperacion WHEN \'V\' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 53, '$ccliente', ''),
(2702, 2, 'SELECT p.PERSC_Nombre as VENDEDOR\nFROM cji_usuario u  JOIN cji_persona p on p.PERSP_Codigo=u.PERSP_Codigo\nWHERE  p.PERSP_Codigo=$vendedor', 'CCVendedor', 53, '$vendedor', ''),
(2703, 2, 'select concat(GUIAREMC_Serie,\'-\',GUIAREMC_Numero) as NUMEROGIA1\nfrom cji_comprobante c \ninner join cji_comprobante_guiarem cg on cg.CPP_Codigo = c.CPP_Codigo\ninner join cji_guiarem g on g.GUIAREMP_Codigo = cg.GUIAREMP_Codigo\nwhere c.CPP_Codigo =$numeroguia', 'CPP_Codigo', 53, '$numeroguia', ''),
(2704, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu_ConIgv as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO , cd.CPDEC_ITEMS as ITEM\nFROM cji_comprobantedetalle cd \nleft JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo  \ninner join cji_comprobante c on c.CPP_Codigo = cd.CPP_Codigo WHERE cd.CPP_Codigo=$ccomp and CPDEC_FlagEstado=1', 'CPP_Codigo', 53, '$ccomp', 'grupo'),
(2705, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 53, '$forpap', ''),
(2706, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 53, '$monedcodigo', '');

-- --------------------------------------------------------

--
-- Table structure for table `cji_emprarea`
--

CREATE TABLE `cji_emprarea` (
  `EAREAP_Codigo` int(11) NOT NULL,
  `AREAP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `DIREP_Codigo` int(11) NOT NULL,
  `EAREAC_Descripcion` varchar(45) DEFAULT NULL,
  `EAREAC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `EAREAC_FechaModificacion` datetime DEFAULT NULL,
  `EAREAC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_emprcontacto`
--

CREATE TABLE `cji_emprcontacto` (
  `ECONP_Contacto` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `PERSP_Contacto` int(11) NOT NULL DEFAULT '0',
  `ECONC_Descripcion` varchar(250) DEFAULT NULL,
  `ECONC_Area` varchar(100) DEFAULT NULL,
  `ECONC_Cargo` varchar(100) DEFAULT NULL,
  `ECONC_Telefono` varchar(50) DEFAULT NULL,
  `ECONC_Movil` varchar(50) DEFAULT NULL,
  `ECONC_Fax` varchar(50) DEFAULT NULL,
  `ECONC_Email` varchar(80) DEFAULT NULL,
  `ECONC_Persona` int(11) DEFAULT NULL,
  `ECONC_TipoContacto` char(1) NOT NULL DEFAULT '1' COMMENT '0:: Persona , 1:: Empresa',
  `ECONC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ECONC_FechaModificacion` datetime DEFAULT NULL,
  `ECONC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_empresa`
--

CREATE TABLE `cji_empresa` (
  `EMPRP_Codigo` int(11) NOT NULL,
  `CIIUP_Codigo` int(11) NOT NULL DEFAULT '0',
  `TIPCOD_Codigo` int(11) NOT NULL DEFAULT '1',
  `SECCOMP_Codigo` int(11) DEFAULT NULL,
  `EMPRC_Ruc` varchar(11) DEFAULT NULL,
  `EMPRC_RazonSocial` varchar(150) DEFAULT NULL,
  `EMPRC_Telefono` varchar(50) DEFAULT NULL,
  `EMPRC_Movil` varchar(50) DEFAULT NULL,
  `EMPRC_Fax` varchar(50) DEFAULT NULL,
  `EMPRC_Web` varchar(250) DEFAULT NULL,
  `EMPRC_Email` varchar(250) DEFAULT NULL,
  `EMPRC_CtaCteSoles` varchar(50) DEFAULT NULL,
  `EMPRC_CtaCteDolares` varchar(50) DEFAULT NULL,
  `EMPRC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `EMPRC_FechaModificacion` datetime DEFAULT NULL,
  `EMPRC_FlagEstado` char(1) DEFAULT '1',
  `EMPRC_Direccion` varchar(350) NOT NULL,
  `EMPRC_EmpCod` int(11) NOT NULL DEFAULT '1',
  `EMPRC_NumeroPago` varchar(100) DEFAULT NULL,
  `EMPRC_EstadoPago` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_empresa`
--

INSERT INTO `cji_empresa` (`EMPRP_Codigo`, `CIIUP_Codigo`, `TIPCOD_Codigo`, `SECCOMP_Codigo`, `EMPRC_Ruc`, `EMPRC_RazonSocial`, `EMPRC_Telefono`, `EMPRC_Movil`, `EMPRC_Fax`, `EMPRC_Web`, `EMPRC_Email`, `EMPRC_CtaCteSoles`, `EMPRC_CtaCteDolares`, `EMPRC_FechaRegistro`, `EMPRC_FechaModificacion`, `EMPRC_FlagEstado`, `EMPRC_Direccion`, `EMPRC_EmpCod`, `EMPRC_NumeroPago`, `EMPRC_EstadoPago`) VALUES
(1, 0, 1, 1, '20523262816', 'CCAPA TECNOLOGIAS DE INFORMACION SAC', '', '', '', '', '', '', '', '2023-10-05 10:47:46', NULL, '1', 'AV. METROPOLITANA MZ. L LT. 5 URB. TILDA, LIMA - LIMA - ATE', 1, NULL, 1),
(2, 0, 6, 0, '20538856674', 'ARTROSCOPICTRAUMA S.A.C.', '', '', '', '', '', '', '', '2023-10-06 15:51:23', NULL, '1', 'AV. GRAL.GARZON NRO. 2320 URB. FUNDO OYAGUE, LIMA - LIMA - JESUS MARIA', 1, NULL, 1),
(3, 0, 6, 0, '20553856451', 'BI GRAND CONFECCIONES S.A.C.', '', '', '', '', '', '', '', '2023-10-06 16:19:13', NULL, '1', 'JR. SAN GABRIEL NRO. 284 URB. SAN CARLOS COMAS, LIMA - LIMA - COMAS', 1, NULL, 1),
(4, 0, 6, 0, '20570892291', '\"ALFARO & CONTADORES\" SOCIEDAD ANONIMA CERRADA', '', '', '', '', '', '', '', '2023-10-06 17:28:40', NULL, '1', 'CAL. MARISCAL SUCRE NRO. 1513 SEC. PUEBLO NUEVO, CAJAMARCA - JAEN - JAEN', 1, NULL, 1),
(5, 0, 6, 0, '20603049684', '\" ESTUDIO CONTABLE O & RM S.A.C.\"', '', '', '', '', '', '', '', '2023-10-06 22:19:24', NULL, '1', 'JR. JUAN SIMONS NRO. SN, SAN MARTIN - RIOJA - RIOJA', 1, NULL, 1),
(6, 0, 6, 0, '20408113891', '\"ASAP GROUP\" SAC ENGINEERING AND CONSTRUCTION', '', '', '', '', '', '', '', '2023-10-09 17:17:58', NULL, '1', 'JR. ALFONSO UGARTE NRO. 159  BARRIO LAS PALMERAS, ANCASH - HUAYLAS - CARAZ', 1, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cji_empresatipoproveedor`
--

CREATE TABLE `cji_empresatipoproveedor` (
  `EMPTIPOP_Codigo` int(11) NOT NULL,
  `FAMI_Codigo` int(11) NOT NULL,
  `PROVP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_emprestablecimiento`
--

CREATE TABLE `cji_emprestablecimiento` (
  `EESTABP_Codigo` int(11) NOT NULL,
  `TESTP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `UBIGP_Codigo` char(6) NOT NULL,
  `EESTABC_Descripcion` varchar(150) DEFAULT NULL,
  `EESTAC_Direccion` varchar(200) DEFAULT NULL,
  `EESTABC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `EESTABC_FechaModificacion` datetime DEFAULT NULL,
  `EESTABC_FlagTipo` char(1) DEFAULT '0' COMMENT '1::Principal, 0::Secundarios',
  `EESTABC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_emprestablecimiento`
--

INSERT INTO `cji_emprestablecimiento` (`EESTABP_Codigo`, `TESTP_Codigo`, `EMPRP_Codigo`, `UBIGP_Codigo`, `EESTABC_Descripcion`, `EESTAC_Direccion`, `EESTABC_FechaRegistro`, `EESTABC_FechaModificacion`, `EESTABC_FlagTipo`, `EESTABC_FlagEstado`) VALUES
(1, 1, 1, '150101', 'LOCAL PRINCIPAL', 'AV. METROPOLITANA MZ. L LT. 5 URB. TILDA, LIMA - LIMA - ATE', '2023-10-05 10:48:10', NULL, '1', '1'),
(2, 1, 2, '150113', 'PRINCIPAL', 'AV. GRAL.GARZON NRO. 2320 URB. FUNDO OYAGUE, LIMA - LIMA - JESUS MARIA', '2023-10-06 15:51:23', NULL, '1', '1'),
(3, 1, 3, '150110', 'PRINCIPAL', 'JR. SAN GABRIEL NRO. 284 URB. SAN CARLOS COMAS, LIMA - LIMA - COMAS', '2023-10-06 16:19:13', NULL, '1', '1'),
(4, 1, 4, '060801', 'PRINCIPAL', 'CAL. MARISCAL SUCRE NRO. 1513 SEC. PUEBLO NUEVO, CAJAMARCA - JAEN - JAEN', '2023-10-06 17:28:40', NULL, '1', '1'),
(5, 1, 5, '220801', 'PRINCIPAL', 'JR. JUAN SIMONS NRO. SN, SAN MARTIN - RIOJA - RIOJA', '2023-10-06 22:19:24', NULL, '1', '1'),
(6, 1, 1, '150103', 'SUCURSAL 1', 'AV. METROPOLITANA MZ. L LT. 5 URB. TILDA, ', '2023-10-09 16:40:46', NULL, '1', '1'),
(7, 1, 6, '021201', 'PRINCIPAL', 'JR. ALFONSO UGARTE NRO. 159  BARRIO LAS PALMERAS, ANCASH - HUAYLAS - CARAZ', '2023-10-09 17:17:58', NULL, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_entregacliente`
--

CREATE TABLE `cji_entregacliente` (
  `ENTRECLI_Codigo` int(11) NOT NULL,
  `GARAN_Codigo` int(11) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL,
  `CLIP_Codigo` int(11) NOT NULL,
  `ENTRECLI_Descripcion` varchar(250) DEFAULT NULL,
  `ENTRECLI_Observacion` varchar(350) DEFAULT NULL,
  `ENTRECLI_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ENTRECLI_TipoSolucion` varchar(150) DEFAULT NULL,
  `ENTRECLI_CodigoProducto` varchar(150) DEFAULT NULL,
  `ENTRECLI_NombreProducto` varchar(150) DEFAULT NULL,
  `ENTRECLI_FechaModificacion` datetime DEFAULT NULL,
  `ENTRECLI_FlagEstado` varchar(1) DEFAULT '1',
  `ENTRECLI_NumeroCredito` int(30) NOT NULL,
  `ENTRECLI_SerieCredito` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_envioproveedor`
--

CREATE TABLE `cji_envioproveedor` (
  `ENVIPRO_Codigo` int(11) NOT NULL,
  `GARAN_Codigo` int(11) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `ENVIPRO_Descripcion` varchar(250) DEFAULT NULL,
  `ENVIPRO_Observacion` varchar(350) DEFAULT NULL,
  `ENVIPRO_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ENVIPRO_FechaModificacion` datetime DEFAULT NULL,
  `ENVIPRO_FlagEstado` varchar(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_estadocivil`
--

CREATE TABLE `cji_estadocivil` (
  `ESTCP_Codigo` int(11) NOT NULL,
  `ESTCC_Descripcion` varchar(150) DEFAULT NULL,
  `ESTCC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ESTCC_FechaModificacion` datetime DEFAULT NULL,
  `ESTCC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_estadocivil`
--

INSERT INTO `cji_estadocivil` (`ESTCP_Codigo`, `ESTCC_Descripcion`, `ESTCC_FechaRegistro`, `ESTCC_FechaModificacion`, `ESTCC_FlagEstado`) VALUES
(1, 'SOLTERO', '2010-12-17 19:05:18', NULL, '1'),
(2, 'CASADO', '2010-12-17 19:05:27', NULL, '1'),
(3, 'VIUDO', '2010-12-17 19:05:33', NULL, '1'),
(4, 'DIVORCIADO', '2010-12-17 19:05:39', NULL, '1'),
(5, 'CONVIVIENTE', '2010-12-17 19:05:45', NULL, '1'),
(7, 'NO REGISTRADO', '2010-12-27 12:05:42', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_fabricante`
--

CREATE TABLE `cji_fabricante` (
  `FABRIP_Codigo` int(11) NOT NULL,
  `FABRIC_Descripcion` varchar(150) DEFAULT NULL,
  `FABRIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `FABRIC_FechaModificacion` datetime DEFAULT NULL,
  `FABRIC_FlagEstado` char(1) DEFAULT '1',
  `FABRIC_CodigoUsuario` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_fabricante`
--

INSERT INTO `cji_fabricante` (`FABRIP_Codigo`, `FABRIC_Descripcion`, `FABRIC_FechaRegistro`, `FABRIC_FechaModificacion`, `FABRIC_FlagEstado`, `FABRIC_CodigoUsuario`) VALUES
(1, 'EXTRANJERO', '2020-03-14 17:48:18', NULL, '1', 'EXT01'),
(2, 'NACIONAL', '2020-03-14 17:51:52', NULL, '1', 'NAC01'),
(3, 'PROVINCIAL (DEPARTAMENTAL)', '2020-03-14 17:52:33', '2020-03-14 12:52:33', '0', 'PR01'),
(4, 'ALIBABAS', '2023-09-19 15:51:03', '2023-09-19 10:51:03', '0', 'INT012');

-- --------------------------------------------------------

--
-- Table structure for table `cji_familia`
--

CREATE TABLE `cji_familia` (
  `FAMI_Codigo` int(11) NOT NULL,
  `FAMI_FlagBienServicio` char(1) NOT NULL DEFAULT 'B' COMMENT 'B: Bien, S: Servicio',
  `FAMI_Descripcion` varchar(350) DEFAULT NULL,
  `FAMI_Codigo2` int(11) DEFAULT NULL,
  `FAMI_CodigoInterno` char(3) DEFAULT NULL,
  `FAMI_CodigoUsuario` varchar(20) DEFAULT NULL,
  `FAMI_Numeracion` int(11) DEFAULT '0',
  `FAMI_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FAMI_FechaModificacion` datetime DEFAULT NULL,
  `FAMI_FlagEstado` char(1) DEFAULT '1',
  `FAMI_IMAGEN` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_familiacompania`
--

CREATE TABLE `cji_familiacompania` (
  `FAMI_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_flujocaja`
--

CREATE TABLE `cji_flujocaja` (
  `FLUCAJ_Codigo` int(11) NOT NULL,
  `CUE_Codigo` int(1) NOT NULL,
  `FLUCAJ_FechaOperacion` date NOT NULL,
  `MONED_Codigo` int(11) NOT NULL,
  `FLUCAJ_Importe` double(10,2) NOT NULL,
  `FLUCAJ_TDC` double(10,2) NOT NULL,
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `FLUCAJ_NumeroDoc` varchar(50) DEFAULT NULL,
  `FLUCAJ_Observacion` varchar(250) DEFAULT NULL,
  `FLUCAJ_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FLUCAJ_FechaModificacion` datetime DEFAULT NULL,
  `FLUCAJ_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_formapago`
--

CREATE TABLE `cji_formapago` (
  `FORPAP_Codigo` int(11) NOT NULL,
  `FORPAC_Descripcion` varchar(250) DEFAULT NULL,
  `FORPAC_Orden` int(11) NOT NULL DEFAULT '0',
  `FORPAC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FORPAC_FechaModificacion` datetime DEFAULT NULL,
  `FORPAC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_formapago`
--

INSERT INTO `cji_formapago` (`FORPAP_Codigo`, `FORPAC_Descripcion`, `FORPAC_Orden`, `FORPAC_FechaRegistro`, `FORPAC_FechaModificacion`, `FORPAC_FlagEstado`) VALUES
(1, 'EFECTIVO', 0, '2019-10-25 20:51:27', '2021-09-16 14:56:35', '1'),
(2, 'DEPOSITO', 0, '2019-10-25 20:51:27', NULL, '1'),
(3, 'TRANSFERENCIA', 0, '2019-10-25 20:51:50', NULL, '1'),
(4, 'CREDITO POR PAGAR', 0, '2020-02-07 22:52:24', NULL, '1'),
(5, 'LETRA', 0, '2020-02-07 22:52:36', NULL, '1'),
(6, 'TARJETA DE DEBITO', 0, '2021-04-15 18:59:23', '2023-09-19 10:48:24', '1'),
(7, 'YAPE', 0, '2021-06-24 16:48:06', NULL, '1'),
(8, 'CREDITO 30 DIAS', 0, '2021-11-17 22:31:05', NULL, '1'),
(11, 'PLIN', 0, '2023-09-13 17:30:45', NULL, '1'),
(12, 'ARRIENDO POR CADA ME', 0, '2023-09-19 14:49:11', '2023-09-19 10:49:35', '0');

-- --------------------------------------------------------

--
-- Table structure for table `cji_garantia`
--

CREATE TABLE `cji_garantia` (
  `GARAN_Codigo` int(11) NOT NULL,
  `CLIP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `PROVP_Codigo` int(11) NOT NULL,
  `CPP_Codigo` int(11) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL,
  `GARAN_Descripcion` varchar(150) DEFAULT NULL,
  `GARAN_Nombrecontacto` varchar(150) DEFAULT NULL,
  `GARAN_Nextel` varchar(50) DEFAULT NULL,
  `GARAN_Telefono` varchar(50) DEFAULT NULL,
  `GARAN_Celular` varchar(50) DEFAULT NULL,
  `GARAN_Email` varchar(250) DEFAULT NULL,
  `GARAN_DescripcionAccesorios` varchar(500) DEFAULT NULL,
  `GARAN_DescripcionFalla` varchar(500) DEFAULT NULL,
  `GARAN_Comentario` varchar(500) DEFAULT NULL,
  `GARAN_FechaRegistro` date NOT NULL,
  `GARAN_FechaModificacion` datetime DEFAULT NULL,
  `GARAN_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `GARAN_Estado` char(1) NOT NULL,
  `GARAN_SerieMalogrado` varchar(40) NOT NULL,
  `GARAN_SerieNuevo` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_guiain`
--

CREATE TABLE `cji_guiain` (
  `GUIAINP_Codigo` int(11) NOT NULL,
  `TIPOMOVP_Codigo` int(11) NOT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `OCOMP_Codigo` int(11) DEFAULT NULL,
  `DOCUP_Codigo` int(11) NOT NULL,
  `GUIAINC_NumeroRef` varchar(50) NOT NULL,
  `GUIAINC_Numero` varchar(10) DEFAULT NULL,
  `GUIAINC_Fecha` date DEFAULT NULL,
  `GUIAINC_FechaEmision` datetime NOT NULL,
  `GUIAINC_Observacion` varchar(45) DEFAULT NULL,
  `GUIAINC_MarcaPlaca` varchar(100) NOT NULL,
  `GUIAINC_Certificado` varchar(100) NOT NULL,
  `GUIAINC_Licencia` varchar(100) NOT NULL,
  `GUIAINC_RucTransportista` varchar(11) NOT NULL,
  `GUIAINC_NombreTransportista` varchar(150) NOT NULL,
  `GUIAINC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIAINC_FechaModificacion` datetime DEFAULT NULL,
  `GUIAINC_Automatico` int(11) DEFAULT '0',
  `GUIAINC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_guiaindetalle`
--

CREATE TABLE `cji_guiaindetalle` (
  `GUIAINDETP_Codigo` int(11) NOT NULL,
  `GUIAINP_Codigo` int(11) NOT NULL,
  `PRODCTOP_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `GUIIAINDETC_GenInd` char(1) DEFAULT 'I' COMMENT 'G:Generico; I indiviual',
  `GUIAINDETC_Cantidad` double DEFAULT '0',
  `GUIAINDETC_Costo` double DEFAULT '0',
  `GUIAINDETC_Descripcion` varchar(300) DEFAULT NULL,
  `GUIAINDETC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIAINDET_FechaModificacion` datetime DEFAULT NULL,
  `GUIAINDETC_FlagEstado` char(1) DEFAULT NULL,
  `ALMAP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_guiarem`
--

CREATE TABLE `cji_guiarem` (
  `GUIAREMP_Codigo` int(11) NOT NULL,
  `GUIAREMC_TipoOperacion` char(1) NOT NULL DEFAULT 'V',
  `TIPOMOVP_Codigo` int(11) NOT NULL,
  `ALMAP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) DEFAULT NULL,
  `DOCUP_Codigo` varchar(250) DEFAULT NULL COMMENT 'Documento Referencia',
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `GUIAREMC_PersReceNombre` varchar(150) DEFAULT NULL,
  `GUIAREMC_PersReceDNI` char(8) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL COMMENT 'Empresa de Transporte',
  `GUIASAP_Codigo` int(11) DEFAULT NULL,
  `GUIAINP_Codigo` int(11) DEFAULT NULL,
  `PRESUP_Codigo` int(11) DEFAULT NULL,
  `OCOMP_Codigo` int(11) DEFAULT NULL,
  `GUIAREMC_OtroMotivo` varchar(250) DEFAULT NULL,
  `GUIAREMC_Fecha` date NOT NULL,
  `GUIAREMC_NumeroRef` varchar(50) DEFAULT NULL,
  `GUIAREMC_OCompra` varchar(50) DEFAULT NULL,
  `GUIAREMC_Serie` varchar(10) DEFAULT NULL,
  `GUIAREMC_Numero` varchar(11) DEFAULT NULL,
  `GUIAREMC_CodigoUsuario` varchar(50) DEFAULT NULL,
  `GUIAREMC_FechaTraslado` date DEFAULT NULL,
  `GUIAREMC_UbigeoPartida` varchar(10) DEFAULT NULL,
  `GUIAREMC_PuntoPartida` varchar(250) DEFAULT NULL,
  `GUIAREMC_UbigeoLlegada` varchar(10) DEFAULT 'NULL',
  `GUIAREMC_PuntoLlegada` varchar(250) DEFAULT NULL,
  `GUIAREMC_Observacion` text,
  `GUIAREMC_Marca` varchar(100) DEFAULT NULL,
  `GUIAREMC_Placa` varchar(20) DEFAULT NULL,
  `GUIAREMC_RegistroMTC` varchar(20) DEFAULT NULL,
  `GUIAREMC_Certificado` varchar(100) DEFAULT NULL,
  `GUIAREMC_Licencia` varchar(100) DEFAULT NULL,
  `GUIAREMC_NombreConductor` varchar(150) DEFAULT NULL,
  `GUIAREMC_subtotal` double(10,2) NOT NULL DEFAULT '0.00',
  `GUIAREMC_descuento` double(10,2) NOT NULL DEFAULT '0.00',
  `GUIAREMC_igv` double(10,2) NOT NULL DEFAULT '0.00',
  `GUIAREMC_total` double(10,2) NOT NULL DEFAULT '0.00',
  `GUIAREMC_igv100` int(11) NOT NULL DEFAULT '0',
  `GUIAREMC_descuento100` float NOT NULL DEFAULT '0',
  `COMPP_Codigo` int(11) NOT NULL,
  `GUIAREMC_FlagMueveStock` char(1) NOT NULL DEFAULT '0',
  `USUA_Anula` int(11) DEFAULT NULL,
  `GUIAREMC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIAREMC_FechaModificacion` datetime DEFAULT NULL,
  `GUIAREMC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CPC_TipoOperacion` char(1) NOT NULL DEFAULT 'V',
  `GUIAREMC_TipoGuia` int(1) NOT NULL,
  `GUIAREMC_NumeroAutomatico` int(1) DEFAULT NULL,
  `PROYP_Codigo` int(11) DEFAULT NULL,
  `GUIAREMC_ModTransporte` int(2) NOT NULL,
  `GUIAREMC_NumBultos` float NOT NULL,
  `GUIAREMC_PesoTotal` double(11,4) NOT NULL,
  `GUIAREMC_EmpresaTransp` varchar(250) NOT NULL,
  `GUIAREMC_RucEmpresaTransp` varchar(20) NOT NULL,
  `GUIAREMC_TipoDocTransp` int(1) NOT NULL,
  `GUIAREMC_TipoDeclara` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_guiarem`
--

INSERT INTO `cji_guiarem` (`GUIAREMP_Codigo`, `GUIAREMC_TipoOperacion`, `TIPOMOVP_Codigo`, `ALMAP_Codigo`, `USUA_Codigo`, `MONED_Codigo`, `DOCUP_Codigo`, `CLIP_Codigo`, `PROVP_Codigo`, `GUIAREMC_PersReceNombre`, `GUIAREMC_PersReceDNI`, `EMPRP_Codigo`, `GUIASAP_Codigo`, `GUIAINP_Codigo`, `PRESUP_Codigo`, `OCOMP_Codigo`, `GUIAREMC_OtroMotivo`, `GUIAREMC_Fecha`, `GUIAREMC_NumeroRef`, `GUIAREMC_OCompra`, `GUIAREMC_Serie`, `GUIAREMC_Numero`, `GUIAREMC_CodigoUsuario`, `GUIAREMC_FechaTraslado`, `GUIAREMC_UbigeoPartida`, `GUIAREMC_PuntoPartida`, `GUIAREMC_UbigeoLlegada`, `GUIAREMC_PuntoLlegada`, `GUIAREMC_Observacion`, `GUIAREMC_Marca`, `GUIAREMC_Placa`, `GUIAREMC_RegistroMTC`, `GUIAREMC_Certificado`, `GUIAREMC_Licencia`, `GUIAREMC_NombreConductor`, `GUIAREMC_subtotal`, `GUIAREMC_descuento`, `GUIAREMC_igv`, `GUIAREMC_total`, `GUIAREMC_igv100`, `GUIAREMC_descuento100`, `COMPP_Codigo`, `GUIAREMC_FlagMueveStock`, `USUA_Anula`, `GUIAREMC_FechaRegistro`, `GUIAREMC_FechaModificacion`, `GUIAREMC_FlagEstado`, `CPC_TipoOperacion`, `GUIAREMC_TipoGuia`, `GUIAREMC_NumeroAutomatico`, `PROYP_Codigo`, `GUIAREMC_ModTransporte`, `GUIAREMC_NumBultos`, `GUIAREMC_PesoTotal`, `GUIAREMC_EmpresaTransp`, `GUIAREMC_RucEmpresaTransp`, `GUIAREMC_TipoDocTransp`, `GUIAREMC_TipoDeclara`) VALUES
(1, 'V', 1, 1, 1, 1, NULL, 2, NULL, '', '-', NULL, NULL, NULL, NULL, NULL, '', '2023-10-06', '', '', 'TPP1', '1', NULL, '2023-10-06', '010115', 'AV. METROPOLITANA MZ. L LT. 5 URB. TILDA, LIMA - LIMA - ATE', '010514', 'JR. SAN GABRIEL NRO. 284 URB. SAN CARLOS COMAS, LIMA - LIMA - COMAS', '', '-', '-', '-', '-', '-', '-', 6.78, 0.00, 1.22, 8.00, 18, 0, 1, '0', NULL, '2023-10-06 16:20:39', NULL, '1', 'V', 0, NULL, 0, 1, 3, 30.0000, 'FIZAR CARGO PERU E.I.R.L', '20603571429', 6, NULL),
(2, 'V', 1, 1, 1, 1, NULL, 3, NULL, '', '-', NULL, NULL, NULL, NULL, NULL, '', '2023-10-06', '', '', 'TPP1', '3', NULL, '2023-10-06', '040123', 'AV. METROPOLITANA MZ. L LT. 5 URB. TILDA, LIMA - LIMA - ATE', '100321', 'JR. SAN GABRIEL NRO. 284 URB. SAN CARLOS COMAS, LIMA - LIMA - COMAS', '', '-', '-', '-', '-', '-', '-', 2.54, 0.00, 0.46, 3.00, 18, 0, 1, '0', NULL, '2023-10-06 20:38:32', NULL, '1', 'V', 0, NULL, 0, 1, 3, 30.0000, 'FIZAR CARGO PERU E.I.R.L', '20603571429', 6, NULL),
(3, 'C', 1, 1, 2, 1, NULL, NULL, 2, '', '-', NULL, NULL, NULL, NULL, 10, '', '2023-10-07', '', '0001-5', 'TPP1', '4', NULL, '2023-10-07', '010115', 'AV. METROPOLITANA MZ. L LT. 5 URB. TILDA, LIMA - LIMA - ATE', '010115', 'JR. SAN GABRIEL NRO. 284 URB. SAN CARLOS COMAS, LIMA - LIMA - COMAS', '', '-', '-', '-', '-', '-', '-', 305.08, 0.00, 54.92, 360.00, 18, 0, 1, '0', NULL, '2023-10-07 17:46:42', NULL, '2', 'V', 0, NULL, 0, 1, 3, 30.0000, 'EMPRESA DE TRANSPORTES PERU S.A.C.', '20109841812', 6, NULL),
(4, 'C', 1, 1, 2, 1, NULL, NULL, 2, '', '-', NULL, NULL, NULL, NULL, NULL, '', '2023-10-07', '', '', 'TPP1', '5', NULL, '2023-10-07', '010112', 'AV. METROPOLITANA MZ. L LT. 5 URB. TILDA, LIMA - LIMA - ATE', '010121', 'JR. SAN GABRIEL NRO. 284 URB. SAN CARLOS COMAS, LIMA - LIMA - COMAS', '', '-', '-', '-', '-', '-', '-', 233.90, 0.00, 42.10, 276.00, 18, 0, 1, '0', NULL, '2023-10-07 17:49:01', NULL, '1', 'V', 0, NULL, 0, 1, 3, 30.0000, 'FIZAR CARGO PERU E.I.R.L', '20603571429', 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cji_guiaremdetalle`
--

CREATE TABLE `cji_guiaremdetalle` (
  `GUIAREMDETP_Codigo` int(11) NOT NULL,
  `PRODCTOP_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `LOTP_Codigo` int(11) NOT NULL,
  `AFECT_Codigo` int(11) NOT NULL DEFAULT '1',
  `GUIAREMP_Codigo` int(11) NOT NULL,
  `GUIAREMDETC_GenInd` char(1) NOT NULL DEFAULT 'I' COMMENT 'G:Generico; I indiviual',
  `GUIAREMDETC_Cantidad` varchar(45) NOT NULL DEFAULT '0',
  `GUIAREMDETC_Pu` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Subtotal` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Descuento` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Igv` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Total` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Pu_ConIgv` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Igv100` int(11) NOT NULL DEFAULT '0',
  `GUIAREMDETC_Descuento100` int(11) NOT NULL DEFAULT '0',
  `GUIAREMDETC_Costo` double DEFAULT NULL,
  `GUIAREMDETC_Venta` double DEFAULT NULL,
  `GUIAREMDETC_Peso` double DEFAULT NULL,
  `GUIAREMDETC_Descripcion` varchar(250) DEFAULT NULL,
  `GUIAREMDETC_Observacion` varchar(1000) DEFAULT NULL,
  `GUIAREMDETC_DireccionEntrega` varchar(250) DEFAULT NULL,
  `GUIAREMDETC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIAREMDET_FechaModificacion` datetime DEFAULT NULL,
  `GUIAREMDETC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `ALMAP_Codigo` int(11) NOT NULL,
  `GUIAREMDETC_ITEM` int(10) DEFAULT NULL,
  `GUIAREMC_CodigoDam` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_guiaremdetalle`
--

INSERT INTO `cji_guiaremdetalle` (`GUIAREMDETP_Codigo`, `PRODCTOP_Codigo`, `UNDMED_Codigo`, `LOTP_Codigo`, `AFECT_Codigo`, `GUIAREMP_Codigo`, `GUIAREMDETC_GenInd`, `GUIAREMDETC_Cantidad`, `GUIAREMDETC_Pu`, `GUIAREMDETC_Subtotal`, `GUIAREMDETC_Descuento`, `GUIAREMDETC_Igv`, `GUIAREMDETC_Total`, `GUIAREMDETC_Pu_ConIgv`, `GUIAREMDETC_Igv100`, `GUIAREMDETC_Descuento100`, `GUIAREMDETC_Costo`, `GUIAREMDETC_Venta`, `GUIAREMDETC_Peso`, `GUIAREMDETC_Descripcion`, `GUIAREMDETC_Observacion`, `GUIAREMDETC_DireccionEntrega`, `GUIAREMDETC_FechaRegistro`, `GUIAREMDET_FechaModificacion`, `GUIAREMDETC_FlagEstado`, `ALMAP_Codigo`, `GUIAREMDETC_ITEM`, `GUIAREMC_CodigoDam`) VALUES
(4, 2, 1, 0, 1, 1, '', '2', 3.3898305084745766, 6.779661016949153, 0, 1.2203389830508469, 8, 4, 18, 0, 0, NULL, 0, 'TEST', '', NULL, '2023-10-06 16:23:07', NULL, '1', 1, 1, NULL),
(5, 2, 1, 0, 1, 2, '', '1', 2.5423728813559325, 2.5423728813559325, 0, 0.45762711864406747, 3, 3, 18, 0, 0, NULL, 0, 'TEST', '', NULL, '2023-10-06 20:38:33', NULL, '1', 1, 1, NULL),
(6, 3, 1, 0, 1, 3, '', '12', 25.423728813559322, 305.08474576271186, 0, 54.91525423728814, 360, 30, 18, 0, 0, NULL, 0, 'PRODUCTO TEST', '', NULL, '2023-10-07 17:46:43', NULL, '1', 1, 1, NULL),
(8, 2, 1, 0, 1, 4, '', '12', 19.491525423728813, 233.89830508474574, 0, 42.10169491525424, 276, 23, 18, 0, 0, NULL, 0, 'TEST', '', NULL, '2023-10-07 17:49:10', NULL, '1', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cji_guiasa`
--

CREATE TABLE `cji_guiasa` (
  `GUIASAP_Codigo` int(11) NOT NULL,
  `TIPOMOVP_Codigo` int(11) NOT NULL,
  `GUIASAC_TipoOperacion` char(1) NOT NULL DEFAULT 'V',
  `ALMAP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `DOCUP_Codigo` int(11) DEFAULT NULL,
  `GUIASAC_Fecha` date DEFAULT NULL,
  `GUIASAC_Numero` varchar(10) DEFAULT NULL,
  `GUIASAC_Observacion` varchar(45) DEFAULT NULL,
  `GUIASAC_MarcaPlaca` varchar(100) DEFAULT NULL,
  `GUIASAC_Certificado` varchar(100) DEFAULT NULL,
  `GUIASAC_Licencia` varchar(100) NOT NULL,
  `GUIASAC_RucTransportista` char(11) DEFAULT NULL,
  `GUIASAC_NombreTransportista` varchar(150) DEFAULT NULL,
  `GUIASAC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIASAC_FechaModificacion` datetime DEFAULT NULL,
  `GUIASAC_Automatico` int(11) DEFAULT '0',
  `GUIASAC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_guiasadetalle`
--

CREATE TABLE `cji_guiasadetalle` (
  `GUIASADETP_Codigo` int(11) NOT NULL,
  `GUIASAP_Codigo` int(11) NOT NULL,
  `PRODCTOP_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `GUIASADETC_GenInd` char(1) DEFAULT 'I' COMMENT 'G:Generico; I indiviual',
  `GUIASADETC_Cantidad` varchar(45) DEFAULT NULL,
  `GUIASADETC_Costo` varchar(45) DEFAULT NULL,
  `GUIASADETC_Descripcion` varchar(300) DEFAULT NULL,
  `GUIASADETC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIASADET_FechaModificacion` datetime DEFAULT NULL,
  `GUIASADETC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `ALMAP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_guiatrans`
--

CREATE TABLE `cji_guiatrans` (
  `GTRANP_Codigo` int(11) NOT NULL,
  `GTRANC_Serie` varchar(10) DEFAULT NULL,
  `GTRANC_Numero` varchar(11) DEFAULT NULL,
  `GTRANC_CodigoUsuario` varchar(50) DEFAULT NULL,
  `GTRANC_AlmacenOrigen` int(11) NOT NULL,
  `GTRANC_AlmacenDestino` int(11) NOT NULL,
  `GTRANC_PersonalRecep` int(11) NOT NULL,
  `GTRANC_Fecha` date NOT NULL,
  `GTRANC_Observacion` text,
  `COMPP_Codigo` int(11) NOT NULL,
  `GUIASAP_Codigo` int(11) NOT NULL,
  `GUIAINP_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `GTRANC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GTRANC_FechaModificacion` datetime DEFAULT NULL,
  `GTRANC_EstadoTrans` int(11) NOT NULL COMMENT '0: pendiente; 1:asignado; 2:cancelado',
  `GTRANC_FlagEstado` varchar(1) NOT NULL DEFAULT '1',
  `EMPRP_Codigo` varchar(250) DEFAULT NULL,
  `GTRANC_Placa` varchar(64) DEFAULT NULL,
  `GTRANC_Licencia` varchar(64) DEFAULT NULL,
  `GTRANC_Chofer` varchar(64) DEFAULT NULL,
  `PEDIP_Codigo` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_guiatransdetalle`
--

CREATE TABLE `cji_guiatransdetalle` (
  `GTRANDETP_Codigo` int(11) NOT NULL,
  `GTRANP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `GTRANDETC_GenInd` varchar(1) DEFAULT 'I',
  `GTRANDETC_Cantidad` int(11) NOT NULL,
  `GTRANDETC_Costo` varchar(21) DEFAULT NULL,
  `GTRANDETC_Descripcion` varchar(250) DEFAULT NULL,
  `GTRANDETC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GTRANDETC_FechaModificacion` datetime DEFAULT NULL,
  `GTRANDETC_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_importacion`
--

CREATE TABLE `cji_importacion` (
  `IMPOR_Codigo` int(11) NOT NULL,
  `IMPOR_TipoOperacion` char(1) DEFAULT NULL,
  `IMPOR_TipoDocumento` char(1) DEFAULT NULL,
  `PRESUP_Codigo` int(11) DEFAULT NULL,
  `OCOMP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL,
  `IMPOR_Serie` char(10) DEFAULT NULL,
  `IMPOR_Numero` int(11) DEFAULT NULL,
  `IMPOR_Nombre` varchar(250) NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `IMPOR_NombreAuxiliar` varchar(25) DEFAULT NULL,
  `USUA_Codigo` int(11) DEFAULT NULL,
  `MONED_Codigo` int(11) DEFAULT NULL,
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `IMPOR_subtotal` double(10,2) DEFAULT NULL,
  `IMPOR_descuento` double(10,2) DEFAULT NULL,
  `IMPOR_igv` double(10,2) DEFAULT NULL,
  `IMPOR_total` double(10,2) DEFAULT NULL,
  `IMPOR_subtotal_conigv` double(10,2) DEFAULT NULL,
  `IMPOR_descuento_conigv` double(10,2) DEFAULT NULL,
  `IMPOR_igv100` int(11) DEFAULT NULL,
  `IMPOR_descuento100` int(11) DEFAULT NULL,
  `GUIAREMP_Codigo` int(11) DEFAULT NULL,
  `IMPOR_GuiaRemCodigo` varchar(11) DEFAULT NULL,
  `IMPOR_DocuRefeCodigo` varchar(11) DEFAULT NULL,
  `IMPOR_Observacion` text,
  `IMPOR_ModoImpresion` char(1) DEFAULT NULL,
  `IMPOR_Liquidada` bit(1) NOT NULL DEFAULT b'0',
  `IMPOR_Fecha` date DEFAULT NULL,
  `IMPOR_Vendedor` int(11) DEFAULT NULL,
  `IMPOR_TDC` double(10,3) DEFAULT NULL,
  `IMPOR_TDC_opcional` double(10,3) DEFAULT NULL,
  `IMPOR_FlagMueveStock` char(1) DEFAULT NULL,
  `GUIASAP_Codigo` int(11) DEFAULT NULL,
  `GUIAINP_Codigo` int(11) DEFAULT NULL,
  `USUA_anula` int(11) DEFAULT NULL,
  `IMPOR_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IMPOR_FechaModificacion` datetime DEFAULT NULL,
  `IMPOR_FlagEstado` char(1) DEFAULT '1',
  `IMPOR_Hora` time DEFAULT NULL,
  `ALMAP_Codigo` int(11) DEFAULT NULL,
  `IMPOR_Codigo_Canje` int(11) DEFAULT NULL,
  `IMPOR_NumeroAutomatico` int(11) DEFAULT NULL,
  `PROYP_Codigo` int(11) DEFAULT NULL,
  `IMPOR_fobDUA` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `IMPOR_fleteDUA` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `IMPOR_seguroDUA` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `IMPOR_advalorem` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `IMPOR_tsaservicios` decimal(15,5) NOT NULL DEFAULT '0.00000',
  `IMPOR_percepcion` decimal(15,5) NOT NULL DEFAULT '0.00000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_importaciondetalle`
--

CREATE TABLE `cji_importaciondetalle` (
  `IMPORDEP_Codigo` int(11) NOT NULL,
  `IMPOR_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) DEFAULT NULL,
  `IMPORDEC_GenInd` char(1) DEFAULT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `IMPORDEC_Cantidad` double DEFAULT NULL,
  `IMPORDEC_Pu` double DEFAULT NULL,
  `IMPORDEC_Subtotal` double DEFAULT NULL,
  `IMPORDEC_Descuento` double DEFAULT NULL,
  `IMPORDEC_Igv` double DEFAULT NULL,
  `IMPORDEC_Total` double DEFAULT NULL,
  `IMPORDEC_Pu_ConIgv` double DEFAULT NULL,
  `IMPORDEC_Subtotal_ConIgv` double DEFAULT NULL,
  `IMPORDEC_Descuento_ConIgv` double DEFAULT NULL,
  `IMPORDEC_Igv100` int(11) DEFAULT NULL,
  `IMPORDEC_Descuento100` int(11) DEFAULT NULL,
  `IMPORDEC_Costo` double DEFAULT NULL,
  `IMPORDEC_Costo_uni_liquidado` double DEFAULT NULL,
  `IMPORDEC_Descripcion` varchar(250) DEFAULT NULL,
  `IMPORDEC_Observacion` varchar(250) DEFAULT NULL,
  `IMPORDEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IMPORDEC_FechaModificacion` datetime DEFAULT NULL,
  `IMPORDEC_FlagEstado` char(1) DEFAULT '1',
  `ALMAP_Codigo` int(11) DEFAULT NULL,
  `GUIAREMP_Codigo` int(11) DEFAULT NULL,
  `OCOMDEP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_inventario`
--

CREATE TABLE `cji_inventario` (
  `INVE_Codigo` int(11) NOT NULL,
  `INVE_Titulo` varchar(500) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `INVE_Serie` varchar(20) NOT NULL,
  `INVE_Numero` int(11) NOT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `INVE_FechaInicio` datetime NOT NULL,
  `INVE_FechaFin` date NOT NULL,
  `INVE_FechaRegistro` datetime NOT NULL,
  `INVE_FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `INVE_FlagEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_inventario`
--

INSERT INTO `cji_inventario` (`INVE_Codigo`, `INVE_Titulo`, `COMPP_Codigo`, `INVE_Serie`, `INVE_Numero`, `ALMAP_Codigo`, `INVE_FechaInicio`, `INVE_FechaFin`, `INVE_FechaRegistro`, `INVE_FechaModificacion`, `INVE_FlagEstado`) VALUES
(1, 'INVENTARIO ALMACEN PRINCIPAL', 1, 'INV', 1, 1, '2023-10-05 17:50:58', '0000-00-00', '2023-10-05 17:50:58', '2023-10-05 22:51:18', 1),
(2, 'INVENTARIO PRODUCTO TEST', 1, 'INV01', 2, 1, '2023-10-06 11:10:54', '0000-00-00', '2023-10-06 11:10:54', '2023-10-06 16:10:54', 1),
(7, 'INVENTARIO OCTUBRE', 1, 'INV01', 3, 1, '0000-00-00 00:00:00', '0000-00-00', '2023-10-08 00:00:00', '2023-10-08 15:35:35', 1),
(8, 'INVENTARIO SEPTIEMBRE', 1, 'INV01', 4, 1, '0000-00-00 00:00:00', '0000-00-00', '2023-10-08 00:00:00', '2023-10-08 15:45:54', 1),
(9, 'INVENTARIO NOVIEMBRE', 1, 'INV01', 5, 1, '2023-10-08 00:00:00', '0000-00-00', '2023-10-08 00:00:00', '2023-10-08 15:54:44', 1),
(10, 'INVENTARIO DICIEMBRE', 1, 'INV01', 6, 1, '2023-10-08 10:57:31', '0000-00-00', '2023-10-08 10:57:31', '2023-10-08 15:57:31', 1),
(11, 'INVENTARIO JULIO', 1, 'INV01', 7, 1, '2023-10-08 10:59:20', '0000-00-00', '2023-10-08 10:59:20', '2023-10-08 15:59:20', 1),
(12, 'INVENTARIO TEST1', 1, 'INV01', 8, 1, '2023-10-08 11:13:38', '0000-00-00', '2023-10-08 11:13:38', '2023-10-08 16:13:38', 1),
(13, 'INVENTARIO TEST2', 1, 'INV01', 9, 1, '2023-10-08 11:56:31', '0000-00-00', '2023-10-08 11:56:31', '2023-10-08 16:56:31', 1),
(14, 'INVENTARIO TEST3', 1, 'INV01', 10, 1, '2023-10-08 11:56:58', '0000-00-00', '2023-10-08 11:56:58', '2023-10-08 16:56:58', 1),
(15, 'INVENTARIO TEST4', 1, 'INV01', 11, 1, '2023-10-08 11:59:29', '0000-00-00', '2023-10-08 11:59:29', '2023-10-08 16:59:29', 1),
(16, 'INVENTARIO TEST5', 1, 'INV01', 12, 1, '2023-10-08 12:01:05', '0000-00-00', '2023-10-08 12:01:05', '2023-10-08 17:01:05', 1),
(17, 'INVENTARIO TEST6', 1, 'INV01', 13, 1, '2023-10-08 12:08:35', '0000-00-00', '2023-10-08 12:08:35', '2023-10-08 17:08:35', 1),
(18, 'INVENTARIO TEST7', 1, 'INV01', 14, 1, '2023-10-08 12:09:28', '0000-00-00', '2023-10-08 12:09:28', '2023-10-08 17:09:28', 1),
(19, 'INVENTARIO TEST8', 1, 'INV01', 15, 1, '2023-10-08 12:20:01', '0000-00-00', '2023-10-08 12:20:01', '2023-10-08 17:20:01', 1),
(20, 'INVENTARIO TEST9', 1, 'INV01', 16, 1, '2023-10-08 12:22:44', '0000-00-00', '2023-10-08 12:22:44', '2023-10-08 17:22:44', 1),
(21, 'INVENTARIO TEST10', 1, 'INV01', 17, 1, '2023-10-08 12:25:35', '0000-00-00', '2023-10-08 12:25:35', '2023-10-08 17:25:35', 1),
(22, 'INVENTARIO TEST11', 1, 'INV01', 18, 1, '2023-10-08 12:48:05', '0000-00-00', '2023-10-08 12:48:05', '2023-10-08 17:48:05', 1),
(23, 'INVENTARIO TEST12', 1, 'INV01', 19, 1, '2023-10-08 12:49:06', '0000-00-00', '2023-10-08 12:49:06', '2023-10-08 17:49:06', 1),
(24, 'INVENTARIO TEST13', 1, 'INV01', 20, 1, '2023-10-08 12:50:17', '0000-00-00', '2023-10-08 12:50:17', '2023-10-08 17:50:17', 1),
(25, 'INVENTARIO TEST14', 1, 'INV01', 21, 1, '2023-10-08 12:54:09', '0000-00-00', '2023-10-08 12:54:09', '2023-10-08 17:54:09', 1),
(26, 'INVENTARIO TEST15', 1, 'INV01', 22, 1, '2023-10-08 12:57:22', '0000-00-00', '2023-10-08 12:57:22', '2023-10-08 17:57:22', 1),
(27, 'INVENTARIO TEST16', 1, 'INV01', 23, 1, '2023-10-08 14:50:20', '0000-00-00', '2023-10-08 14:50:20', '2023-10-08 19:50:20', 1),
(28, 'INVENTARIO TEST17', 1, 'INV01', 24, 1, '2023-10-08 14:51:39', '0000-00-00', '2023-10-08 14:51:39', '2023-10-08 19:51:39', 1),
(29, 'INVENTARIO TEST18', 1, 'INV01', 25, 1, '2023-10-08 14:55:00', '0000-00-00', '2023-10-08 14:55:00', '2023-10-08 19:55:00', 1),
(30, 'INVENTARIO TEST19', 1, 'INV01', 26, 1, '2023-10-08 15:06:36', '0000-00-00', '2023-10-08 15:06:36', '2023-10-08 20:06:36', 1),
(31, 'INVENTARIO TEST20', 1, 'INV01', 27, 1, '2023-10-08 15:07:28', '0000-00-00', '2023-10-08 15:07:28', '2023-10-08 20:07:28', 1),
(32, 'INVENTARIO TEST21', 1, 'INV01', 28, 1, '2023-10-08 15:09:29', '0000-00-00', '2023-10-08 15:09:29', '2023-10-08 20:09:29', 1),
(33, 'INVENTARIO TEST22', 1, 'INV01', 29, 1, '2023-10-08 15:16:24', '0000-00-00', '2023-10-08 15:16:24', '2023-10-08 20:16:24', 1),
(34, 'INVENTARIO TEST23', 1, 'INV01', 30, 1, '2023-10-08 15:20:16', '0000-00-00', '2023-10-08 15:20:16', '2023-10-08 20:20:16', 1),
(35, 'INVENTARIO TEST24', 1, 'INV01', 31, 1, '2023-10-08 15:22:05', '0000-00-00', '2023-10-08 15:22:05', '2023-10-08 20:22:05', 1),
(36, 'INVENTARIO TEST25', 1, 'INV01', 32, 1, '2023-10-08 15:25:45', '0000-00-00', '2023-10-08 15:25:45', '2023-10-08 20:25:45', 1),
(37, 'INVENTARIO TEST26', 1, 'INV01', 33, 1, '2023-10-08 15:26:17', '0000-00-00', '2023-10-08 15:26:17', '2023-10-08 20:26:17', 1),
(38, 'INVENTARIO TEST27', 1, 'INV01', 34, 1, '2023-10-08 15:38:55', '0000-00-00', '2023-10-08 15:38:55', '2023-10-08 20:38:55', 1),
(39, 'INVENTARIO TEST28', 1, 'INV01', 35, 1, '2023-10-08 15:41:22', '0000-00-00', '2023-10-08 15:41:22', '2023-10-08 20:41:22', 1),
(45, 'INVENTARIO TEST29', 1, 'INV01', 36, 1, '2023-10-08 15:59:59', '0000-00-00', '2023-10-08 15:59:59', '2023-10-08 20:59:59', 1),
(46, 'prueba', 1, 'INV01', 37, 1, '2023-10-08 17:32:40', '0000-00-00', '2023-10-08 17:32:40', '2023-10-08 22:32:40', 1),
(48, 'INVENTARIO TEST30', 1, 'INV01', 38, 1, '2023-10-08 18:01:56', '0000-00-00', '2023-10-08 18:01:56', '2023-10-08 23:02:06', 1),
(49, 'INVENTARIO TEST31', 1, 'INV01', 39, 1, '2023-10-09 10:01:00', '0000-00-00', '2023-10-09 10:01:00', '2023-10-09 15:01:15', 1),
(50, 'INVENTARIO TEST32', 1, 'INV01', 40, 1, '2023-10-09 10:07:31', '0000-00-00', '2023-10-09 10:07:31', '2023-10-09 15:07:41', 1),
(51, 'INVENTARIO TEST33', 1, 'INV01', 41, 1, '2023-10-09 10:11:18', '0000-00-00', '2023-10-09 10:11:18', '2023-10-09 15:11:27', 1),
(52, 'INVENTARIO TEST34', 1, 'INV01', 42, 1, '2023-10-09 10:39:33', '0000-00-00', '2023-10-09 10:39:33', '2023-10-09 16:08:47', 1),
(53, 'INVENTARIO TEST35', 1, 'INV01', 43, 1, '2023-10-09 11:29:56', '0000-00-00', '2023-10-09 11:29:56', '2023-10-09 16:29:56', 1),
(54, 'INVENTARIO SUCURSAL', 2, 'INV', 1, 2, '2023-10-09 12:11:16', '0000-00-00', '2023-10-09 12:11:16', '2023-10-09 17:11:16', 1),
(55, 'INVENTARIO TEST35', 2, 'INV02', 2, 2, '2023-10-09 12:11:36', '0000-00-00', '2023-10-09 12:11:36', '2023-10-09 17:13:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cji_inventarioajuste`
--

CREATE TABLE `cji_inventarioajuste` (
  `INVA_Codigo` int(11) NOT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `INVA_Serie` varchar(6) NOT NULL,
  `INVA_Numero` int(11) NOT NULL,
  `INVA_FechaRegistro` datetime NOT NULL,
  `INVA_FechaModificacion` datetime DEFAULT NULL,
  `INVA_TipoMovimiento` char(1) NOT NULL DEFAULT '1' COMMENT '1 = Reemplazar, 2 = Actualizar ''suma''',
  `INVA_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cji_inventarioajuste`
--

INSERT INTO `cji_inventarioajuste` (`INVA_Codigo`, `ALMAP_Codigo`, `COMPP_Codigo`, `INVA_Serie`, `INVA_Numero`, `INVA_FechaRegistro`, `INVA_FechaModificacion`, `INVA_TipoMovimiento`, `INVA_FlagEstado`) VALUES
(1, 1, 1, 'AJ001', 1, '2023-09-25 00:00:00', '2023-09-25 11:56:19', '2', '1'),
(2, 1, 1, 'AJ001', 2, '2023-09-25 00:00:00', '2023-09-25 12:23:12', '2', '1'),
(3, 1, 1, 'AJ001', 3, '2023-09-25 00:00:00', '2023-09-25 12:54:59', '1', '1'),
(4, 1, 1, 'AJ001', 4, '2023-09-25 00:00:00', '2023-09-25 12:56:08', '1', '1'),
(5, 1, 1, 'AJ001', 5, '2023-09-25 00:00:00', '2023-09-25 16:13:31', '1', '2'),
(6, 1, 1, 'AJ001', 6, '2023-09-25 00:00:00', '2023-09-25 16:20:02', '2', '2'),
(9, 1, 1, 'AJ001', 7, '2023-09-29 00:00:00', NULL, '2', '2'),
(10, 1, 1, 'AJ001', 8, '2023-10-07 00:00:00', NULL, '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `cji_inventarioajustedetalle`
--

CREATE TABLE `cji_inventarioajustedetalle` (
  `INVADET_Codigo` int(11) NOT NULL,
  `INVA_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `INVADET_Stock` float DEFAULT NULL,
  `INVADET_StockAjuste` float NOT NULL,
  `INVADET_FechaRegistro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `INVADET_FechaModificacion` datetime DEFAULT NULL,
  `INVADET_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cji_inventarioajustedetalle`
--

INSERT INTO `cji_inventarioajustedetalle` (`INVADET_Codigo`, `INVA_Codigo`, `PERSP_Codigo`, `PROD_Codigo`, `INVADET_Stock`, `INVADET_StockAjuste`, `INVADET_FechaRegistro`, `INVADET_FechaModificacion`, `INVADET_FlagEstado`) VALUES
(1, 1, 1, 1, 49, 60, '2023-09-25 11:51:07', NULL, '1'),
(2, 2, 7, 2, 99, 100, '2023-09-25 12:22:49', NULL, '1'),
(3, 3, 1, 1, 109, 2, '2023-09-25 12:53:40', '2023-09-25 12:54:31', '1'),
(4, 4, 1, 1, 2, 0, '2023-09-25 12:56:05', NULL, '1'),
(5, 5, 1, 1, 0, 50, '2023-09-25 14:45:38', '2023-09-25 16:13:31', '1'),
(6, 6, 1, 2, 199, 50, '2023-09-25 15:33:51', '2023-09-25 16:20:02', '1'),
(7, 5, 1, 5, 0, 40, '2023-09-25 16:13:31', NULL, '1'),
(8, 6, 1, 4, 0, 1000, '2023-09-25 16:18:12', '2023-09-25 16:20:02', '0'),
(9, 6, 1, 2, 199, 1000, '2023-09-25 16:20:18', NULL, '1'),
(10, 9, 1, 1, 0, 50, '2023-09-29 12:13:35', NULL, '1'),
(11, 9, 1, 2, 199, 10, '2023-09-29 12:13:35', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_inventarioajusteresp`
--

CREATE TABLE `cji_inventarioajusteresp` (
  `INVAR_Codigo` int(11) NOT NULL,
  `INVA_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `INVAR_FechaRegistro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `INVAR_Observacion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Responsables de los documentos de ajuste en inventario';

--
-- Dumping data for table `cji_inventarioajusteresp`
--

INSERT INTO `cji_inventarioajusteresp` (`INVAR_Codigo`, `INVA_Codigo`, `PERSP_Codigo`, `INVAR_FechaRegistro`, `INVAR_Observacion`) VALUES
(1, 1, 1, '2022-09-16 10:35:47', 'Ajuste por balance'),
(2, 1, 1, '2022-09-16 10:35:55', 'Ajuste de inventario aprobado.'),
(3, 2, 1, '2022-10-12 15:26:36', ''),
(4, 2, 1, '2022-10-12 15:27:03', 'ingreso interno del proveedor'),
(5, 2, 1, '2022-10-12 15:27:07', 'Ajuste de inventario aprobado.'),
(6, 3, 1, '2022-10-14 11:32:03', ''),
(7, 3, 1, '2022-10-14 11:32:08', 'Ajuste de inventario aprobado.'),
(8, 4, 2, '2022-10-25 15:58:44', ''),
(9, 4, 2, '2022-10-25 15:59:04', 'Ajuste de inventario aprobado.'),
(10, 5, 1, '2022-11-18 12:36:39', 'Ajuste por fecha navideña'),
(11, 5, 1, '2022-11-18 12:36:57', 'Ajuste de inventario aprobado.'),
(12, 6, 1, '2023-04-24 21:42:30', ''),
(13, 6, 1, '2023-04-24 21:42:40', 'Ajuste de inventario aprobado.'),
(14, 7, 1, '2023-04-27 17:27:38', ''),
(15, 7, 1, '2023-04-27 17:27:44', 'Ajuste de inventario aprobado.'),
(16, 8, 1, '2023-05-16 16:15:58', ''),
(17, 8, 1, '2023-05-16 16:16:09', 'Ajuste de inventario aprobado.'),
(18, 9, 1, '2023-08-16 17:52:02', 'Ingresando stock'),
(19, 10, 1, '2023-08-16 17:52:09', 'Ingresando stock'),
(20, 11, 1, '2023-08-16 17:56:30', 'Ingreso de productos'),
(21, 12, 1, '2023-08-16 17:58:15', 'Ingreso de productos'),
(22, 13, 1, '2023-09-08 12:26:06', 'Carga masiva de stock'),
(23, 13, 1, '2023-09-08 12:26:50', 'Carga masiva de stock'),
(24, 14, 1, '2023-09-08 12:28:50', 'Carga masiva de stock'),
(25, 15, 1, '2023-09-08 12:38:04', 'Carga masiva de stock'),
(26, 16, 1, '2023-09-08 12:39:34', 'Carga masiva de stock'),
(27, 16, 1, '2023-09-08 12:42:27', 'Ajuste de inventario aprobado.'),
(28, 17, 1, '2023-09-08 12:57:42', 'Carga masiva de stock'),
(29, 18, 1, '2023-09-08 13:00:09', 'Carga masiva de stock'),
(30, 19, 1, '2023-09-08 13:00:41', 'Carga masiva de stock'),
(31, 20, 1, '2023-09-08 13:01:28', 'Carga masiva de stock'),
(32, 20, 1, '2023-09-08 13:01:52', 'Ajuste de inventario aprobado.'),
(33, 21, 1, '2023-09-16 10:52:14', 'Este es un cambio casi continuo.'),
(34, 22, 1, '2023-09-16 10:52:57', ''),
(35, 23, 1, '2023-09-16 10:54:04', ''),
(36, 22, 1, '2023-09-16 10:54:53', ''),
(37, 22, 1, '2023-09-16 10:55:33', 'Ajuste de inventario aprobado.'),
(38, 1, 1, '2023-09-25 11:51:07', 'Sumando stock de prueba'),
(39, 1, 1, '2023-09-25 11:56:19', 'Ajuste de inventario aprobado.'),
(40, 2, 7, '2023-09-25 12:22:48', 'Prueba de sumar stock con el usuario Juana María '),
(41, 2, 7, '2023-09-25 12:23:12', 'Ajuste de inventario aprobado.'),
(42, 3, 1, '2023-09-25 12:53:40', 'Prueba de reemplazar stock'),
(43, 3, 1, '2023-09-25 12:54:00', ''),
(44, 3, 1, '2023-09-25 12:54:31', 'prueba de reemplazo de stock'),
(45, 3, 1, '2023-09-25 12:54:59', 'Ajuste de inventario aprobado.'),
(46, 4, 1, '2023-09-25 12:56:05', 'reedafdsfs'),
(47, 4, 1, '2023-09-25 12:56:08', 'Ajuste de inventario aprobado.'),
(48, 5, 1, '2023-09-25 14:45:38', 'Prueba 512 suma de stock'),
(49, 5, 1, '2023-09-25 15:31:52', 'Prueba 512 suma de stock fgffgfgff'),
(50, 5, 1, '2023-09-25 15:32:04', 'Prueba 512 suma de stock'),
(51, 6, 1, '2023-09-25 15:33:50', 'Sumar stock ultima prueba'),
(52, 5, 1, '2023-09-25 16:13:31', 'Prueba 512 suma de stock'),
(53, 6, 1, '2023-09-25 16:18:12', 'Carga masiva de stock'),
(54, 6, 1, '2023-09-25 16:20:02', 'Carga masiva de stock'),
(55, 6, 1, '2023-09-25 16:20:18', 'Carga masiva de stock'),
(56, 6, 1, '2023-09-25 17:37:29', 'Carga masiva de stock'),
(57, 6, 1, '2023-09-25 17:58:02', 'Carga masiva de stock'),
(60, 9, 1, '2023-09-29 12:13:35', 'Carga masiva de stock'),
(61, 10, 2, '2023-10-07 12:42:27', 'Carga masiva de stock');

-- --------------------------------------------------------

--
-- Table structure for table `cji_inventariodetalle`
--

CREATE TABLE `cji_inventariodetalle` (
  `INVD_Codigo` int(11) NOT NULL,
  `INVE_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `INVD_Cantidad` varchar(20) NOT NULL,
  `INVD_Pcosto` double(10,2) DEFAULT '0.00',
  `PERSP_Codigo` int(11) NOT NULL,
  `INVD_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `INVD_FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `INVD_FlagActivacion` int(11) NOT NULL,
  `LOTC_Numero` varchar(60) DEFAULT NULL,
  `LOTC_FechaVencimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_inventariodetalle`
--

INSERT INTO `cji_inventariodetalle` (`INVD_Codigo`, `INVE_Codigo`, `PROD_Codigo`, `INVD_Cantidad`, `INVD_Pcosto`, `PERSP_Codigo`, `INVD_FechaRegistro`, `INVD_FechaModificacion`, `INVD_FlagActivacion`, `LOTC_Numero`, `LOTC_FechaVencimiento`) VALUES
(1, 1, 2, '10', 0.00, 0, '2023-10-05 22:51:18', '2023-10-05 22:51:18', 1, NULL, NULL),
(2, 2, 3, '50', 0.00, 0, '2023-10-06 16:10:54', '2023-10-06 16:10:54', 1, NULL, NULL),
(3, 14, 2, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(4, 14, 3, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(5, 15, 2, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(6, 15, 3, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(7, 16, 2, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(8, 16, 3, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(9, 17, 2, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(10, 17, 3, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(11, 18, 2, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(12, 18, 3, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(13, 19, 2, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(14, 19, 3, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(15, 20, 2, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(16, 20, 3, '0', NULL, 2, '2023-10-08 17:22:45', '2023-10-08 17:22:45', 1, NULL, NULL),
(18, 21, 2, '20', NULL, 2, '2023-10-08 17:25:35', '2023-10-08 17:25:35', 1, NULL, NULL),
(19, 21, 3, '10', NULL, 2, '2023-10-08 17:25:35', '2023-10-08 17:25:35', 1, NULL, NULL),
(21, 31, 2, '20', NULL, 2, '2023-10-08 20:07:28', '2023-10-08 20:07:28', 1, NULL, NULL),
(22, 31, 3, '10', NULL, 2, '2023-10-08 20:07:28', '2023-10-08 20:07:28', 1, NULL, NULL),
(23, 31, 2, '20', NULL, 2, '2023-10-08 20:07:28', '2023-10-08 20:07:28', 1, NULL, NULL),
(24, 31, 3, '10', NULL, 2, '2023-10-08 20:07:28', '2023-10-08 20:07:28', 1, NULL, NULL),
(25, 31, 2, '20', NULL, 2, '2023-10-08 20:07:28', '2023-10-08 20:07:28', 1, NULL, NULL),
(26, 31, 3, '10', NULL, 2, '2023-10-08 20:07:28', '2023-10-08 20:07:28', 1, NULL, NULL),
(27, 31, 2, '20', NULL, 2, '2023-10-08 20:07:28', '2023-10-08 20:07:28', 1, NULL, NULL),
(28, 31, 3, '10', NULL, 2, '2023-10-08 20:07:28', '2023-10-08 20:07:28', 1, NULL, NULL),
(36, 32, 2, '20', NULL, 2, '2023-10-08 20:09:29', '2023-10-08 20:09:29', 1, NULL, NULL),
(37, 32, 3, '10', NULL, 2, '2023-10-08 20:09:29', '2023-10-08 20:09:29', 1, NULL, NULL),
(39, 33, 2, '20', NULL, 2, '2023-10-08 20:16:24', '2023-10-08 20:16:24', 1, NULL, NULL),
(40, 33, 3, '10', NULL, 2, '2023-10-08 20:16:24', '2023-10-08 20:16:24', 1, NULL, NULL),
(42, 34, 2, '20', NULL, 2, '2023-10-08 20:20:17', '2023-10-08 20:20:17', 1, NULL, NULL),
(43, 34, 3, '10', NULL, 2, '2023-10-08 20:20:17', '2023-10-08 20:20:17', 1, NULL, NULL),
(75, 45, 2, '20', NULL, 2, '2023-10-08 21:00:00', '2023-10-08 21:00:00', 1, NULL, NULL),
(76, 45, 3, '10', NULL, 2, '2023-10-08 21:00:00', '2023-10-08 21:00:00', 1, NULL, NULL),
(78, 46, 3, '15', 0.00, 0, '2023-10-08 22:32:40', '2023-10-08 22:32:40', 1, NULL, NULL),
(79, 48, 2, '100', NULL, 1, '2023-10-08 23:01:56', '2023-10-08 23:02:07', 1, NULL, NULL),
(80, 48, 3, '70', NULL, 1, '2023-10-08 23:01:56', '2023-10-08 23:02:07', 1, NULL, NULL),
(81, 49, 2, '100', NULL, 1, '2023-10-09 15:01:01', '2023-10-09 15:01:15', 1, NULL, NULL),
(82, 49, 3, '70', NULL, 1, '2023-10-09 15:01:01', '2023-10-09 15:01:15', 1, NULL, NULL),
(84, 50, 2, '50', NULL, 1, '2023-10-09 15:07:33', '2023-10-09 15:07:33', 1, NULL, NULL),
(85, 50, 3, '35', NULL, 1, '2023-10-09 15:07:33', '2023-10-09 15:07:33', 1, NULL, NULL),
(87, 51, 2, '50', NULL, 1, '2023-10-09 15:11:18', '2023-10-09 15:11:18', 1, NULL, NULL),
(88, 51, 3, '35', NULL, 1, '2023-10-09 15:11:18', '2023-10-09 15:11:18', 1, NULL, NULL),
(89, 51, 4, '10', NULL, 1, '2023-10-09 15:11:18', '2023-10-09 15:11:18', 1, NULL, NULL),
(90, 52, 2, '50', NULL, 1, '2023-10-09 15:39:34', '2023-10-09 15:39:34', 1, NULL, NULL),
(91, 52, 3, '35', NULL, 1, '2023-10-09 15:39:34', '2023-10-09 15:39:34', 1, NULL, NULL),
(92, 52, 4, '10', NULL, 1, '2023-10-09 15:39:34', '2023-10-09 15:39:34', 1, NULL, NULL),
(93, 53, 2, '15', NULL, 1, '2023-10-09 16:29:56', '2023-10-09 16:29:56', 1, NULL, NULL),
(94, 53, 3, '70', NULL, 1, '2023-10-09 16:29:56', '2023-10-09 16:29:56', 1, NULL, NULL),
(95, 53, 4, '23', NULL, 1, '2023-10-09 16:29:56', '2023-10-09 16:29:56', 1, NULL, NULL),
(96, 55, 2, '15', NULL, 2, '2023-10-09 17:11:37', '2023-10-09 17:11:37', 1, NULL, NULL),
(97, 55, 3, '70', NULL, 2, '2023-10-09 17:11:37', '2023-10-09 17:11:37', 1, NULL, NULL),
(98, 55, 4, '23', NULL, 2, '2023-10-09 17:11:37', '2023-10-09 17:11:37', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cji_inventarioresp`
--

CREATE TABLE `cji_inventarioresp` (
  `INVAR_Codigo` int(11) NOT NULL,
  `INVE_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `INVER_FechaRegistro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `INVER_Observacion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Responsables de los documentos de ingreso en inventario';

--
-- Dumping data for table `cji_inventarioresp`
--

INSERT INTO `cji_inventarioresp` (`INVAR_Codigo`, `INVE_Codigo`, `PERSP_Codigo`, `INVER_FechaRegistro`, `INVER_Observacion`) VALUES
(1, 1, 1, '2022-08-12 11:15:58', ''),
(2, 1, 1, '2022-11-22 18:05:02', ''),
(3, 4, 1, '2023-04-24 21:45:21', ''),
(4, 7, 1, '2023-08-17 10:08:55', 'fssddsf'),
(5, 8, 1, '2023-08-17 10:13:38', 'Prueba de ingreso de productos'),
(6, 9, 1, '2023-08-17 10:23:57', 'Prueba de ingreso'),
(7, 10, 1, '2023-08-17 10:28:36', 'Prueba de Ingreso de productos'),
(8, 3, 1, '2023-08-17 10:33:53', 'Prueba de Ingreso'),
(9, 3, 1, '2023-08-17 10:39:09', 'Prueba de ingreso de productos para punto de venta'),
(10, 3, 1, '2023-08-17 10:52:39', ''),
(11, 3, 1, '2023-08-17 10:55:17', ''),
(12, 3, 1, '2023-08-17 10:59:26', 'Ingresando productos'),
(13, 11, 1, '2023-08-17 11:00:58', 'Ingreso de prueba'),
(14, 11, 1, '2023-08-17 11:05:05', ''),
(15, 11, 1, '2023-08-17 11:09:15', ''),
(16, 11, 1, '2023-08-17 11:13:00', ''),
(17, 11, 1, '2023-08-17 11:15:23', ''),
(18, 11, 1, '2023-08-17 11:19:46', ''),
(19, 11, 1, '2023-08-17 11:21:08', ''),
(20, 11, 1, '2023-08-17 11:24:51', ''),
(21, 11, 1, '2023-08-17 11:28:11', ''),
(22, 11, 1, '2023-08-17 11:33:39', ''),
(23, 11, 1, '2023-08-17 11:37:59', ''),
(24, 11, 1, '2023-08-17 11:38:34', ''),
(25, 12, 1, '2023-08-17 11:43:18', 'Ingresando productos nuevos'),
(26, 12, 1, '2023-08-17 11:47:02', ''),
(27, 12, 1, '2023-08-17 11:49:24', ''),
(28, 12, 1, '2023-08-17 11:56:14', ''),
(29, 12, 1, '2023-08-17 12:08:41', ''),
(30, 12, 1, '2023-08-17 12:12:49', ''),
(31, 12, 1, '2023-08-17 12:16:08', ''),
(32, 12, 1, '2023-08-17 12:19:53', ''),
(33, 12, 1, '2023-08-17 12:23:24', ''),
(34, 12, 1, '2023-08-17 12:26:28', ''),
(35, 12, 1, '2023-08-17 12:30:06', ''),
(36, 12, 1, '2023-08-17 12:32:17', ''),
(37, 12, 1, '2023-08-17 12:35:51', ''),
(38, 12, 1, '2023-08-17 12:39:54', ''),
(39, 12, 1, '2023-08-17 12:43:50', ''),
(40, 12, 1, '2023-08-17 12:47:46', ''),
(41, 12, 1, '2023-08-17 12:51:06', ''),
(42, 12, 1, '2023-08-17 12:54:22', ''),
(43, 12, 1, '2023-08-17 12:57:50', ''),
(44, 12, 1, '2023-08-17 13:01:18', ''),
(45, 6, 1, '2023-08-17 15:05:35', ''),
(46, 6, 1, '2023-08-17 15:09:13', ''),
(47, 6, 1, '2023-08-17 15:15:20', ''),
(48, 6, 1, '2023-08-17 15:18:38', ''),
(49, 6, 1, '2023-08-17 15:22:32', ''),
(50, 13, 1, '2023-08-17 15:26:45', ''),
(51, 13, 1, '2023-08-17 15:30:57', ''),
(52, 13, 1, '2023-08-17 15:38:44', ''),
(53, 13, 1, '2023-08-17 15:50:09', ''),
(54, 13, 1, '2023-08-17 15:54:31', ''),
(55, 13, 1, '2023-08-17 15:58:08', ''),
(56, 13, 1, '2023-08-17 16:42:43', ''),
(57, 13, 1, '2023-08-17 16:46:10', ''),
(58, 14, 1, '2023-08-17 16:48:01', ''),
(59, 14, 1, '2023-08-17 16:51:28', ''),
(60, 14, 1, '2023-08-17 16:55:11', ''),
(61, 14, 1, '2023-08-17 16:57:34', ''),
(62, 14, 8, '2023-08-17 16:59:08', ''),
(63, 14, 8, '2023-08-17 17:01:32', ''),
(64, 14, 8, '2023-08-17 17:03:12', ''),
(65, 14, 8, '2023-08-17 17:04:07', ''),
(66, 14, 8, '2023-08-17 17:04:37', ''),
(67, 14, 8, '2023-08-17 17:08:09', ''),
(68, 15, 1, '2023-08-18 10:39:55', ''),
(69, 15, 1, '2023-08-19 23:26:08', ''),
(70, 15, 1, '2023-08-21 09:20:16', ''),
(71, 15, 1, '2023-08-21 09:32:34', ''),
(72, 2, 1, '2023-08-21 09:41:46', ''),
(73, 4, 1, '2023-08-21 09:46:43', ''),
(74, 10, 1, '2023-08-21 09:52:09', ''),
(75, 14, 1, '2023-08-21 09:56:55', ''),
(76, 16, 1, '2023-08-21 10:02:08', ''),
(77, 10, 1, '2023-08-21 10:14:15', ''),
(78, 4, 1, '2023-08-21 10:19:12', ''),
(79, 17, 1, '2023-08-21 10:19:55', ''),
(80, 12, 1, '2023-08-21 10:27:56', ''),
(81, 18, 1, '2023-08-21 10:31:46', ''),
(82, 2, 1, '2023-08-21 10:42:53', ''),
(83, 19, 1, '2023-08-21 10:57:07', ''),
(84, 15, 1, '2023-08-21 11:08:41', ''),
(85, 15, 1, '2023-08-21 11:27:44', ''),
(86, 19, 1, '2023-08-21 11:32:09', ''),
(87, 15, 1, '2023-09-12 16:29:46', ''),
(88, 15, 1, '2023-09-16 11:06:09', ''),
(89, 7, 1, '2023-09-16 11:09:12', ''),
(90, 1, 1, '2023-09-22 15:35:39', ''),
(91, 1, 1, '2023-10-05 17:51:18', ''),
(92, 2, 1, '2023-10-06 11:10:54', ''),
(93, 12, 2, '2023-10-08 11:13:38', 'Carga masiva de stock'),
(94, 13, 2, '2023-10-08 11:56:31', 'Carga masiva de stock'),
(95, 14, 2, '2023-10-08 11:56:58', 'Carga masiva de stock'),
(96, 15, 2, '2023-10-08 11:59:29', 'Carga masiva de stock'),
(97, 16, 2, '2023-10-08 12:01:06', 'Carga masiva de stock'),
(98, 17, 2, '2023-10-08 12:08:35', 'Carga masiva de stock'),
(99, 18, 2, '2023-10-08 12:09:28', 'Carga masiva de stock'),
(100, 19, 2, '2023-10-08 12:20:01', 'Carga masiva de stock'),
(101, 20, 2, '2023-10-08 12:22:45', 'Carga masiva de stock'),
(102, 21, 2, '2023-10-08 12:25:35', 'Carga masiva de stock'),
(103, 22, 2, '2023-10-08 12:48:05', 'Carga masiva de stock'),
(104, 23, 2, '2023-10-08 12:49:06', 'Carga masiva de stock'),
(105, 24, 2, '2023-10-08 12:50:17', 'Carga masiva de stock'),
(106, 25, 2, '2023-10-08 12:54:09', 'Carga masiva de stock'),
(107, 26, 2, '2023-10-08 12:57:22', 'Carga masiva de stock'),
(108, 27, 2, '2023-10-08 14:50:20', 'Carga masiva de stock'),
(109, 28, 2, '2023-10-08 14:51:39', 'Carga masiva de stock'),
(110, 29, 2, '2023-10-08 14:55:00', 'Carga masiva de stock'),
(111, 30, 2, '2023-10-08 15:06:36', 'Carga masiva de stock'),
(112, 31, 2, '2023-10-08 15:07:28', 'Carga masiva de stock'),
(113, 32, 2, '2023-10-08 15:09:29', 'Carga masiva de stock'),
(114, 33, 2, '2023-10-08 15:16:24', 'Carga masiva de stock'),
(115, 34, 2, '2023-10-08 15:20:17', 'Carga masiva de stock'),
(116, 35, 2, '2023-10-08 15:22:05', 'Carga masiva de stock'),
(117, 36, 2, '2023-10-08 15:25:45', 'Carga masiva de stock'),
(118, 37, 2, '2023-10-08 15:26:17', 'Carga masiva de stock'),
(119, 38, 2, '2023-10-08 15:38:55', 'Carga masiva de stock'),
(120, 39, 2, '2023-10-08 15:41:22', 'Carga masiva de stock'),
(121, 40, 2, '2023-10-08 15:46:01', 'Carga masiva de stock'),
(122, 41, 2, '2023-10-08 15:50:56', 'Carga masiva de stock'),
(123, 42, 2, '2023-10-08 15:54:16', 'Carga masiva de stock'),
(124, 43, 2, '2023-10-08 15:55:29', 'Carga masiva de stock'),
(125, 44, 2, '2023-10-08 15:58:28', 'Carga masiva de stock'),
(126, 45, 2, '2023-10-08 15:59:59', 'Carga masiva de stock'),
(127, 46, 1, '2023-10-08 17:32:40', ''),
(128, 47, 1, '2023-10-08 17:42:15', 'Carga masiva de stock'),
(129, 48, 1, '2023-10-08 18:01:56', 'Carga masiva de stock'),
(130, 48, 1, '2023-10-08 18:02:06', 'Carga masiva de stock'),
(131, 49, 1, '2023-10-09 10:01:00', 'Carga masiva de stock'),
(132, 49, 1, '2023-10-09 10:01:15', 'Carga masiva de stock'),
(133, 50, 1, '2023-10-09 10:07:31', 'Carga masiva de stock'),
(134, 50, 1, '2023-10-09 10:07:41', 'Carga masiva de stock'),
(135, 51, 1, '2023-10-09 10:11:18', 'Carga masiva de stock'),
(136, 51, 1, '2023-10-09 10:11:27', 'Carga masiva de stock'),
(137, 52, 1, '2023-10-09 10:39:33', 'Carga masiva de stock'),
(138, 52, 1, '2023-10-09 10:39:40', 'Carga masiva de stock'),
(139, 52, 1, '2023-10-09 10:41:20', 'Carga masiva de stock'),
(140, 52, 1, '2023-10-09 10:42:23', 'Carga masiva de stock'),
(141, 52, 1, '2023-10-09 10:42:46', 'Carga masiva de stock'),
(142, 52, 1, '2023-10-09 10:43:37', 'Carga masiva de stock'),
(143, 52, 1, '2023-10-09 10:48:54', 'Carga masiva de stock'),
(144, 52, 1, '2023-10-09 10:52:45', 'Carga masiva de stock'),
(145, 52, 1, '2023-10-09 11:06:50', 'Carga masiva de stock'),
(146, 52, 1, '2023-10-09 11:07:51', 'Carga masiva de stock'),
(147, 52, 1, '2023-10-09 11:08:47', 'Carga masiva de stock'),
(148, 53, 1, '2023-10-09 11:29:56', 'Carga masiva de stock'),
(149, 55, 2, '2023-10-09 12:11:36', 'Carga masiva de stock'),
(150, 55, 2, '2023-10-09 12:13:28', 'Carga masiva de stock');

-- --------------------------------------------------------

--
-- Table structure for table `cji_item`
--

CREATE TABLE `cji_item` (
  `ITEM_Codigo` int(11) NOT NULL,
  `ITEM_Descripcion` varchar(250) DEFAULT NULL,
  `ITEM_Abreviatura` varchar(250) DEFAULT NULL,
  `ITEM_Valor` varchar(250) DEFAULT NULL,
  `ITEM_UsuCrea` varchar(220) DEFAULT NULL,
  `ITEM_UsuModi` varchar(220) DEFAULT NULL,
  `ITEM_FechaModi` datetime DEFAULT NULL,
  `ITEM_FechaIngr` datetime DEFAULT NULL,
  `ITEM_Estado` char(1) DEFAULT NULL,
  `ITEM_Nombre` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_item`
--

INSERT INTO `cji_item` (`ITEM_Codigo`, `ITEM_Descripcion`, `ITEM_Abreviatura`, `ITEM_Valor`, `ITEM_UsuCrea`, `ITEM_UsuModi`, `ITEM_FechaModi`, `ITEM_FechaIngr`, `ITEM_Estado`, `ITEM_Nombre`) VALUES
(2, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Nombre'),
(3, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Ruc'),
(6, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Direccion'),
(8, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Cantidad'),
(9, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'DestinoNombre'),
(10, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'DestinoRuc'),
(11, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'FechaEmision'),
(12, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'FechaRecepcion'),
(13, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'DescripcionProducto'),
(14, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'PrecioUnitario'),
(15, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'ImporteProducto'),
(16, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'TotalProducto'),
(17, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'NroOrdenVenta'),
(18, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Vendedor'),
(19, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'GuiaRemision'),
(20, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'SubTotal'),
(21, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'IGV'),
(22, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Total'),
(23, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'MontoEnLetras'),
(24, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'FormaDePago'),
(25, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Moneda');

-- --------------------------------------------------------

--
-- Table structure for table `cji_kardex`
--

CREATE TABLE `cji_kardex` (
  `KARDP_Codigo` int(11) NOT NULL,
  `KARD_Fecha` datetime NOT NULL,
  `DOCUP_Codigo` varchar(11) NOT NULL,
  `KARDC_CodigoDoc` int(50) DEFAULT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `PROD_Descripcion` varchar(250) DEFAULT NULL,
  `KARDC_Cantidad` double DEFAULT '0',
  `KARDC_Serie` varchar(30) NOT NULL,
  `KARDC_Numero` varchar(30) NOT NULL,
  `KARDC_AlmacenDesc` varchar(30) DEFAULT NULL,
  `MONED_Codigo` int(11) DEFAULT NULL,
  `KARDC_ProdAfectacion` int(11) DEFAULT NULL,
  `KARDC_Costo` double DEFAULT '0',
  `KARDC_PrecioConIgv` double DEFAULT '0',
  `KARDC_Subtotal` double DEFAULT '0',
  `KARDC_Total` double DEFAULT '0',
  `COMPP_Codigo` int(11) NOT NULL,
  `TIPOMOVP_Codigo` int(11) NOT NULL COMMENT '1: Salida 2: Ingreso',
  `LOTP_Codigo` int(11) DEFAULT NULL,
  `KARDC_TipoIngreso` varchar(250) DEFAULT NULL,
  `Denominacion` varchar(250) DEFAULT NULL,
  `NumDocRuc` varchar(250) DEFAULT NULL,
  `ALMPROD_Codigo` int(11) DEFAULT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `KARDP_FlagEstado` char(1) NOT NULL,
  `USUA_Codigo` int(11) DEFAULT NULL,
  `KARDC_FlagValida` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_kardex`
--

INSERT INTO `cji_kardex` (`KARDP_Codigo`, `KARD_Fecha`, `DOCUP_Codigo`, `KARDC_CodigoDoc`, `PROD_Codigo`, `PROD_Descripcion`, `KARDC_Cantidad`, `KARDC_Serie`, `KARDC_Numero`, `KARDC_AlmacenDesc`, `MONED_Codigo`, `KARDC_ProdAfectacion`, `KARDC_Costo`, `KARDC_PrecioConIgv`, `KARDC_Subtotal`, `KARDC_Total`, `COMPP_Codigo`, `TIPOMOVP_Codigo`, `LOTP_Codigo`, `KARDC_TipoIngreso`, `Denominacion`, `NumDocRuc`, `ALMPROD_Codigo`, `CLIP_Codigo`, `PROVP_Codigo`, `KARDP_FlagEstado`, `USUA_Codigo`, `KARDC_FlagValida`) VALUES
(1, '2023-10-05 17:51:18', 'I', 1, 2, NULL, 10, 'INV', '000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(2, '2023-10-06 10:52:56', 'F', 1, 2, NULL, 2, 'FPP1', '1', '', 1, 1, 19.491525423728813, 23, 38.983050847457626, 46, 1, 1, NULL, 'SALIDA POR VENTA', '', '', 1, 1, NULL, '1', 1, NULL),
(3, '2023-10-06 11:10:54', 'I', 2, 3, NULL, 50, 'INV01', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(4, '2023-10-06 11:12:24', 'F', 2, 3, NULL, 4, 'FPP1', '2', '', 1, 1, 66.10169491525424, 78, 264.40677966101697, 312, 1, 1, NULL, 'SALIDA POR VENTA', '', '', 1, 1, NULL, '1', 1, NULL),
(5, '2023-10-06 11:14:19', 'F', 3, 3, NULL, 6, 'FPP1', '3', '', 1, 1, 66.10169491525424, 78, 396.6101694915254, 468, 1, 1, NULL, 'SALIDA POR VENTA', '', '', 1, 1, NULL, '1', 1, NULL),
(6, '2023-10-06 12:32:10', 'F', 5, 2, NULL, 2, 'FPP1', '5', '', 1, 1, 3.3898305084745766, 4, 6.779661016949153, 8, 1, 1, NULL, 'SALIDA POR VENTA', '', '', 1, 2, NULL, '1', 1, NULL),
(7, '2023-10-06 16:43:33', 'N', 7, 3, NULL, 10, 'CPP1', '1', '', 1, 1, 10.16949152542373, 12, 101.6949152542373, 120, 1, 1, NULL, 'SALIDA POR VENTA', '', '', 1, 1, NULL, '1', 1, NULL),
(8, '2023-10-08 17:32:40', 'I', 46, 3, NULL, 15, 'INV01', '37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(9, '2023-10-08 18:02:07', 'I', 48, 3, NULL, 35, 'INV01', '000038', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'SUMA POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(10, '2023-10-08 18:02:07', 'I', 48, 2, NULL, 50, 'INV01', '000038', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'SUMA POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(11, '2023-10-09 10:01:15', 'I', 49, 3, NULL, 35, 'INV01', '000039', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'SUMA POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(12, '2023-10-09 10:01:15', 'I', 49, 2, NULL, 50, 'INV01', '000039', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'SUMA POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(13, '2023-10-09 10:07:41', 'I', 50, 3, NULL, 35, 'INV01', '000040', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'SUMA POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(14, '2023-10-09 10:07:41', 'I', 50, 2, NULL, 50, 'INV01', '000040', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'SUMA POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(15, '2023-10-09 10:11:27', 'I', 51, 4, NULL, 10, 'INV01', '000041', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(16, '2023-10-09 10:11:27', 'I', 51, 3, NULL, 35, 'INV01', '000041', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(17, '2023-10-09 10:11:27', 'I', 51, 2, NULL, 50, 'INV01', '000041', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(18, '2023-10-09 10:39:40', 'I', 52, 4, NULL, 10, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(19, '2023-10-09 10:39:40', 'I', 52, 3, NULL, 35, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(20, '2023-10-09 10:39:40', 'I', 52, 2, NULL, 50, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(21, '2023-10-09 10:41:20', 'I', 52, 4, NULL, 10, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(22, '2023-10-09 10:41:21', 'I', 52, 3, NULL, 35, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(23, '2023-10-09 10:41:21', 'I', 52, 2, NULL, 50, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(24, '2023-10-09 10:42:23', 'I', 52, 4, NULL, 10, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(25, '2023-10-09 10:42:23', 'I', 52, 3, NULL, 35, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(26, '2023-10-09 10:42:24', 'I', 52, 2, NULL, 50, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(27, '2023-10-09 10:42:46', 'I', 52, 4, NULL, 10, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(28, '2023-10-09 10:42:46', 'I', 52, 3, NULL, 35, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(29, '2023-10-09 10:42:46', 'I', 52, 2, NULL, 50, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(30, '2023-10-09 10:43:37', 'I', 52, 4, NULL, 10, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(31, '2023-10-09 10:43:37', 'I', 52, 3, NULL, 35, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(32, '2023-10-09 10:43:37', 'I', 52, 2, NULL, 50, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(33, '2023-10-09 10:48:54', 'I', 52, 4, NULL, 10, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(34, '2023-10-09 10:48:54', 'I', 52, 3, NULL, 35, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(35, '2023-10-09 10:48:54', 'I', 52, 2, NULL, 50, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(36, '2023-10-09 10:52:45', 'I', 52, 4, NULL, 10, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(37, '2023-10-09 10:52:45', 'I', 52, 3, NULL, 35, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(38, '2023-10-09 10:52:46', 'I', 52, 2, NULL, 50, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(39, '2023-10-09 11:06:51', 'I', 52, 4, NULL, 10, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(40, '2023-10-09 11:06:51', 'I', 52, 3, NULL, 35, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(41, '2023-10-09 11:06:51', 'I', 52, 2, NULL, 50, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(42, '2023-10-09 11:07:51', 'I', 52, 4, NULL, 10, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(43, '2023-10-09 11:07:51', 'I', 52, 3, NULL, 35, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(44, '2023-10-09 11:07:51', 'I', 52, 2, NULL, 50, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(45, '2023-10-09 11:08:47', 'I', 52, 4, NULL, 10, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(46, '2023-10-09 11:08:47', 'I', 52, 3, NULL, 35, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(47, '2023-10-09 11:08:47', 'I', 52, 2, NULL, 50, 'INV01', '000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 1, NULL, NULL, '1', 1, NULL),
(48, '2023-10-09 12:13:28', 'I', 55, 4, NULL, 23, 'INV02', '000002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 2, NULL, NULL, '1', 2, NULL),
(49, '2023-10-09 12:13:28', 'I', 55, 3, NULL, 70, 'INV02', '000002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 2, NULL, NULL, '1', 2, NULL),
(50, '2023-10-09 12:13:29', 'I', 55, 2, NULL, 15, 'INV02', '000002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, NULL, 'INGRESO POR INVENTARIO', NULL, NULL, 2, NULL, NULL, '1', 2, NULL),
(51, '2023-10-09 12:18:33', 'F', 14, 3, NULL, 23, 'FPP2', '1', '', 1, 1, 2.5423728813559325, 3, 58.47457627118645, 69, 2, 1, NULL, 'SALIDA POR VENTA', '', '', 2, 4, NULL, '1', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cji_letra`
--

CREATE TABLE `cji_letra` (
  `LET_Codigo` int(11) NOT NULL,
  `LET_TipoOperacion` char(1) NOT NULL DEFAULT 'V' COMMENT 'V: venta, C: compra',
  `COMPP_Codigo` int(11) NOT NULL,
  `LET_Serie` char(4) NOT NULL,
  `LET_Numero` varchar(11) NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `LET_Total` float NOT NULL,
  `LET_Observacion` varchar(250) DEFAULT NULL,
  `LET_Fecha` date NOT NULL,
  `LET_FechaVenc` date NOT NULL,
  `LET_Vendedor` int(11) DEFAULT NULL,
  `USUA_anula` int(11) DEFAULT NULL,
  `LET_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LET_FechaModificacion` datetime DEFAULT NULL,
  `LET_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `BANP_Codigo` int(11) DEFAULT NULL,
  `LET_Representante` varchar(200) DEFAULT NULL,
  `LET_Oficina` varchar(200) DEFAULT NULL,
  `LET_NumeroCuenta` varchar(200) DEFAULT NULL,
  `LET_Direccion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_linea`
--

CREATE TABLE `cji_linea` (
  `LINP_Codigo` int(11) NOT NULL,
  `LINC_CodigoUsuario` varchar(20) DEFAULT NULL,
  `LINC_Descripcion` varchar(150) DEFAULT NULL,
  `LINC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LINC_FechaModificacion` datetime DEFAULT NULL,
  `LINC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_linea`
--

INSERT INTO `cji_linea` (`LINP_Codigo`, `LINC_CodigoUsuario`, `LINC_Descripcion`, `LINC_FechaRegistro`, `LINC_FechaModificacion`, `LINC_FlagEstado`) VALUES
(1, '001', 'MATERIAL ELECTRICO', '2020-03-16 16:23:21', '2020-03-16 11:23:21', '1'),
(2, '002', 'CABLES', '2019-05-21 21:43:47', NULL, '1'),
(3, '003', 'LIMPIEZA', '2019-05-21 21:28:55', NULL, '1'),
(4, '004', 'ILUMINACION', '2019-05-21 21:29:07', NULL, '1'),
(5, '005', 'EEPP', '2019-05-21 21:29:16', NULL, '1'),
(6, '006', 'PRODUCTOS QUIMICOS', '2019-05-21 21:29:30', NULL, '1'),
(7, 'LB01', 'LINEA BLANCA', '2020-03-16 16:24:01', '2020-03-16 11:24:01', '0');

-- --------------------------------------------------------

--
-- Table structure for table `cji_log`
--

CREATE TABLE `cji_log` (
  `LOGP_Codigo` int(11) NOT NULL,
  `LOGC_Tabla` varchar(35) NOT NULL,
  `LOGC_Registro` int(11) NOT NULL,
  `LOGC_Categoria` varchar(20) NOT NULL,
  `LOGC_Valor` varchar(25) NOT NULL,
  `LOGC_Fecha` datetime NOT NULL,
  `USUA_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_lote`
--

CREATE TABLE `cji_lote` (
  `LOTP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `LOTC_Numero` varchar(60) NOT NULL,
  `LOTC_Cantidad` double NOT NULL DEFAULT '0',
  `LOTC_Costo` double NOT NULL DEFAULT '0',
  `GUIAINP_Codigo` int(11) NOT NULL DEFAULT '0' COMMENT 'SI EL VALOR ES 0, EL LOTE FUE AGREGADO SIN INVENTARIO NI COMPRAS',
  `LOTC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LOTC_FechaModificacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LOTC_FechaVencimiento` date NOT NULL,
  `LOTC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_loteprorrateo`
--

CREATE TABLE `cji_loteprorrateo` (
  `LOTPROP_Codigo` int(11) NOT NULL,
  `LOTP_Codigo` int(11) NOT NULL,
  `LOTPROC_CostoAnterior` double NOT NULL,
  `LOTPROC_CantActual` int(11) NOT NULL,
  `LOTPROC_Fecha` date NOT NULL,
  `LOTPROC_Tipo` int(11) NOT NULL,
  `LOTPROC_CantidadAdi` int(11) DEFAULT NULL,
  `LOTPROC_Valor` double DEFAULT NULL,
  `LOTPROC_Obs` text,
  `LOTPROC_CostoNuevo` double NOT NULL,
  `GUIAREMDETP_Codigo` int(11) DEFAULT NULL,
  `CPDEP_Codigo` int(11) DEFAULT NULL,
  `LOTPROC_FlagRecepProdu` char(1) NOT NULL,
  `LOTPROC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LOTPROC_FechaModificacion` datetime DEFAULT NULL,
  `LOTPROC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_marca`
--

CREATE TABLE `cji_marca` (
  `MARCP_Codigo` int(11) NOT NULL,
  `MARCC_CodigoUsuario` varchar(20) DEFAULT NULL,
  `MARCC_Descripcion` varchar(150) DEFAULT NULL,
  `MARCC_Imagen` varchar(100) DEFAULT NULL,
  `MARCC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MARCC_FechaModificacion` datetime DEFAULT NULL,
  `MARCC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_menu`
--

CREATE TABLE `cji_menu` (
  `MENU_Codigo` int(11) NOT NULL,
  `MENU_Codigo_Padre` int(11) NOT NULL DEFAULT '0',
  `MENU_Descripcion` varchar(150) DEFAULT NULL,
  `MENU_Titulo` varchar(50) DEFAULT NULL,
  `MENU_Url` varchar(250) DEFAULT NULL,
  `MENU_Icon` longtext,
  `MENU_AccesoRapido` set('0','1') DEFAULT '0',
  `MENU_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `MENU_FechaModificacion` datetime DEFAULT NULL,
  `MENU_OrderBy` int(3) NOT NULL,
  `MENU_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_menu`
--

INSERT INTO `cji_menu` (`MENU_Codigo`, `MENU_Codigo_Padre`, `MENU_Descripcion`, `MENU_Titulo`, `MENU_Url`, `MENU_Icon`, `MENU_AccesoRapido`, `MENU_FechaRegistro`, `MENU_FechaModificacion`, `MENU_OrderBy`, `MENU_FlagEstado`) VALUES
(2, 0, 'Principal', NULL, NULL, 'iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyQzg3RTU1RENGNjUxMUU5OUE2NkY3NEI1OTc5RUE2QyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyQzg3RTU1RUNGNjUxMUU5OUE2NkY3NEI1OTc5RUE2QyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJDODdFNTVCQ0Y2NTExRTk5QTY2Rjc0QjU5NzlFQTZDIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJDODdFNTVDQ0Y2NTExRTk5QTY2Rjc0QjU5NzlFQTZDIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+6iIn3wAABuRJREFUeNrEWXtMU1cYP+fePijvNyVGBhPFRavMOjWTBAdRhGomhgqObRrnfCzL2HQxskeyVzb9x7AsxmXJjAZxareRLUNZXDAo2QjDqYMQnGAZG8gUsKWVwoV7z75TkCm2vfe2t+xLCs3td+79fud8z9/FSAHpKsxL5tSqHAYhIyLIgDFKg8uJBKPQSRUXJvg2QsQqINLKENSsRvhCiqWmJ9BnY38Xtm3IjdOotaUIM6UYEyPcipWznhAiwMOvwJcqHgkn5llq78wIgDbYba1atR9WboPl4UqcIIAZhpM7xiP0cYbMU5EMoNloVMekJ+0lCL+NFTLcC5ADIyj04EKLhVMMQPvGNfPVKs0J0DaimZFrAOb59DM1rWKKjJjCjeKCZ9UqddMMGk9lMXwaO82mooAAdJjX7QJ3+QZhHIFmWDDGYZDFTneYTWV+uRA1HmFyGG7EoP9RwJUg7NAb6adrPpUMgLoN3XksMzVOPrFBlZRoDVtmrNbMSr7OhIUNwjWWH3IkcN1/GZyNvxYJDmcsaGbJSbnw2TzXcvaMKICJgKU+L99tsFZ7PnZzUXnU2pLLvvQGqg4X2n/4sQwsy5aToTARVsyxnGt58Do7PVWGxUefBeNT/TjtBv2+1wsjstZZxRRDFy1r5xhX92hL2zxw0dkSY0INf7NenT3n6GcdHbzHIKZ53t9sw8bG9IQuXmWXqp+0cVtdj21QLwiCnMg2sBFsuccsRCssLVL+BpsqPq5b7hqOxVyPbQDJAUEYtO9G8ZrZjwCg7UEgFRazLC97DcPwLo5DckCAjTqGqN95CABtzCZ6G/9FcI3IBi9wYzp3qyoTBNSHF1rNBfopAO6uMsD+hrfZ9LIBjE0AkAuCnkIIxi/+50LQEgdacHiHM0GOvq2l/pENk3kSbpsZOoxM9POBSeTqZ47I0Y82ZDtjMxfVegVBBLEudKG1OC+VoZMU8qfiThN1QrzsLKRL1nd4uu4GcVcEBLQ4ggBToHsMVEBGO62y72Nv/8NrOzEFwpc7YbKUoTOsEgCcvzQVDZ23ZEqe7CreK3PctPrUF48JbGAmB3Al2sbs/qOVFcNXL0SJqVpPHTH9Wf3dfmgPRDOXTxAYp9EslKhg75s9cLyqQkyt41hlhRTjRUEQFM88QH0oImO9femutgaNt9+7v/0yhx+RX/Q8gSCIqJUfVjDOQuO8VwDC+Dj9Te/PrT2BoABcCkNoCOaENg3EODPBmCni/w04RFurSUu9qluU7fSmpo2L7QlPS63FKpbWjb5AQMCQ0487N5l+gmPPDWTHQxY8UR+9Lu9Q6JO5g3IW9tZ+Zbx56sxHDmtXppygniqeKtXPbNmCjCVQl1f45e4wQia8vGV3/JbXLOrkx2W7YkS64VbKhpIqxDtv321pXUY7ElnNoMCfg0ImNPtjPKPT1SaX78mPWFV4PVDvm7v9zUrDvr0bwRNk0YoCIs0MZYnp1C/PeqY+sWxXScj8p3mlgnNW/nNNGTu37wRb+qSFHCEhjKqOoRS3myWW4fPR6/MPhWbm2JXOMGklu2sSVyyvlhbcuC33wuVOZhJOlZzhPXbzru+DlSaNBz9/BatUosQuFLGTUwMN5efdzLCE3Y9cnfNFsNm4pKyVJ0X8Z1TgyPEpAO6XCwQdk3LzmMKtdcEGkLB8abXv3Ucn1zde63mIlaAvF6ScQu+RAzuCDeBWXf1LvnafJcKHHqnFDrPpXczgD0Siv+GOw54wGhXZF/5YSksoTFVQXbs10VF9qrBwO6vVOBmNxsWoVRxmWQ5S42TOIyzheVYY43Q8N6YTRkd1YzBHczabfqR/IGW491aGs6vLQL/jiTV6z88XPim4eO0tjwBazWaNjnE1oQl+3hcIBCDQ3XtOhDFGMyXw3HYn179kU+PfLo8A3KewybQQ/jVSfl4MRL9jCA3ec8wICHjeCCb8yvxLLb95pBbvC32tgwnaKlbcqNHxEZEoLjzSDSbIxhN43o7pxnsEQGWOpeZrCPU9RMQyCiIuPMINJJjGMwiX59dfqfRCr/gY/YpNZQDkkJS3NANOB3yGgmL82otXDvrgh3zLzWKTWYAaASBER08aDzQuFPN56jZedl4yACqd5nwDwkwV5efFdGlmohkq0GwDAVvqyeclxcCjMXGuhR/in4Jc/j70ID77/piwcJQYGeWv5aM0z9NUKcV4ySfwoNCXC5SfpxQ3ZYm9sm7D99A/QzbphkN7QCts3qXfrXLs8TuBU35+kuIupUQr8hDodheAsNu8BihtiWlXSRuz+72N7KlQiYCjLDElWilXSek+yphR0onyNg7XMOobso3D9wE4Mdhd0konKQzDSAH084E++18BBgC0G0bXhqoSjQAAAABJRU5ErkJggg==', '0', '2019-09-04 22:42:11', NULL, 0, '1'),
(3, 0, 'Almacen', NULL, NULL, 'iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAAArVJREFUaIHtWL2O2kAQ/oazXZ3W6U403BskL5B3SOUukVJZyo8okHVXWqRBOVkUKD8SVYrrqPIOeYG8Ao3vKpB1ssSRMClgibOxYTHr+FD4JEvWzs7OfMu341mAIzaCVk+lAYzD87yT8/Pz1wAuAYCZr8bj8cfRaPTTdCzjBDqdztNGo/GBiJ5kx5n5+2KxeNvv97+ZjGeMQLvdPnMc5z2AF0TUyJvDzAsiumbmyyiKbkzE3ZtARi7viOiRjg8zT5k5NCGrvQgUyUUXJmRVioCOXHTBzAtmviaiUrLaiYDneSetVusNEXV15aKLsrLSJiDlAuAxEVVW23eV1dZE2u32mW3bV0T0fF+56EJWq9lsdjEYDG43zS0kUKVcdKEjq1wC+1YX09gkqz8I1CEXXUhZWZZ10ev11rJaEwiC4BmAL3XJRRfMPAXwMoqirwAgd5kAfHroyQPAKsfPWG1+ViaVtr1VQRJgAK8A3DAz15jPRvASt1jmyoCy677v20KIOyJyVg73SZKcDofD+b9PVy8fy2Qw+d5sNrnb7f7I2sMwtOI4Xm+YqU0xViqFEHfySdN0miUUhqGVpuk0O8dUXJO13iYih4gcZrazhjiOiZnXdikJE3hQH6syOHgCxg6xAlsIMQuCoKLlf6MSAlXeF1QcvISOBOrGkUDdMFmF5nU0ssYIJElyamqtXaBNINucAdu7SdWu+u+7voTWGfB933ZddyI7Sdd1J2rAbKep2sMwtLL+ajeqs34RtH8B2U2u3vOm2PILrNrjOCYhhL2pC9VYPxf/bRUiALbv+6UDKxLRkkseyhKwhBCTskGB5ZlRhkqRKEVgpfW9blWmbmUHfwaOBOrGkUDd+KsKEdG6qySied74NmT9gOU/dWmalvIvymdtVweKmird3kT1K1pX179sk3cw+AUZUWL9SszmnQAAAABJRU5ErkJggg==', '0', '2019-09-04 22:17:09', NULL, 0, '1'),
(4, 0, 'Ventas', NULL, NULL, 'iVBORw0KGgoAAAANSUhEUgAAADAAAAAmCAYAAACCjRgBAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpFMkZCRDkwRkNGRUMxMUU5OEUwRkUyQjk5MEVFNTI2RSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpFMkZCRDkxMENGRUMxMUU5OEUwRkUyQjk5MEVFNTI2RSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkUyRkJEOTBEQ0ZFQzExRTk4RTBGRTJCOTkwRUU1MjZFIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkUyRkJEOTBFQ0ZFQzExRTk4RTBGRTJCOTkwRUU1MjZFIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+N3Bx5wAAB6tJREFUeNrMWQlsFFUY/mdm73bb3W0VLIVW8ACNVGNUghchErCgLWpiNBokRo3xiAQ1Jh6VRI3RmHjFA5USoqAYpE1pKJpYomJtpaVUitVSikAPemy7O7szs3M9/zft7s4sRWx3q7zkpZ3/zXvv+/5r/veWIYRAvDEMA+m2rq6uKziOexPXZXVdfx5FMVVV35BlmYtGo88tWrSoOd09zJhtkOGmadoWQRCuxL+ARIpdLlcE21UInm78BfYFqCiSqf0ySmD//v12BFuMGofxfn4gEMiKjyOJwr1799LnSKb2ZDO1UH19vQ01/lksFsvleV4PhUJSOBx+CS3xMg6L2HWv1+vJz8+vRCvYzykCCIjx+XzvIfj7RVE8gf1q7IWrVq16t6Sk5BOUFyKREoyJLvz/rvb29k8rKioysjeTiSBuaWmhQfo0ukg/AryltLT08ETv1dXVXeR0Or9HS8x2OBwfLFy48HHKP50gTlsLzc3NL0uS9DS6zTCCX3km8LStWLHiCFpmBcZJPxJ+tK2t7XWqt//NhTBo1yPoF1HzPAK7HcEfONscShCzVCkSHsG5zyCJF/4XF2pqanoYtfghgpEQ/G1lZWXfT2ZjdKfF6E516E5Zdrt9PcbK21NxoSkRQPD3KYpSiVrU0H3uLC8vr52K9vbs2bMUY6EmOzvbhWQexZjYOO0EGhsbVyP4bQieQwvci5r/Oh0XqK2tXeV2u3egJVgkswYtsXXagrihoWEZ+u1WBG9Dt3kkXfC0rVy5chfG0Br8ZgAqpLK1tfW2tGLgvu0dF3J2WyD1xTJ/qCiPiWzhI5GsvyTnpia2+INMfsUX23rXzvOoj+XmeKWg6lq7td/deRpYIAObV1984owudP+Ow+VzZwa2O+2s3exMeZwK8yJdIEXCcMx2PoT9RTAdLZfvg/lMEDzeHDhsL4BTMpd0G+xCTJO6e0OlX9w9v37CWogl+tJjfUP2qKQkZPkOAlflR0AUwtAScUGbilMGe2C62pCThRsgBJdkEThw0gZ9YlLBOR6nixB1Ga1cJiQwMBJiUoPiOr8CSpSHAyEOGkUX1QNMZ2sUOSBqDG6cEYYleVmwqVNNjImiQC3BnLEalUQe48BKoea4DkUOgDbBhpOnF3y8/SABhGISnJRVEGOpGegfymnM6aHUwoRC7k3899+1n2n9CvIEKRSGz0ggOiK8xbq5AH5VluPXcS6cQw1T7B8xWa5TdPajs5YSd287+AAQpvJcIoBIy7+6p6T6Xx0po7qyy6GzGtLhUscUPCpquICD44AdJ6zjs0yPkPhs55JT8DBspD+XLbmNqutGt7MscCybSJH0XfrksE0AiYFoLKp/N6libvXmX/fixJstaRbHn7phDuR5HNB0YgSq2oeATll2cQCWzM2DoCjDhw0nQFB0KPA64KHrZoMNQX55sAfaTwk4H+Chawthjs8Nh07xsK2131j3+qIcuHX+DJBUDd756S/gY5rV7wF2Vq255o5JHeo1Xd2JlCwEbDbM0ReeZ7BcMCMXdncMEhHBLi7Ko8+GfF/3KNl3LAhXz/JBSYHfkC2NyKSt9ygU+t2w/NKZifmfN/cQCmb9zZckNOdz9ZBRISV4CVRN+jygEbUGD+V4ElQh3oWYDL1hKUF/dq7TkIdNH74cJ2fIdKJZEFBZjiO53dHhKKGyLLu1gDwejIB5T+y4q7x70gRqH7yxW9fUgymLwbHh5IUCdQUqGxGSyTrHNU4A/dxscoOAK2nwUXQ3KpvjcyXBjwhEkmXLfqjEn+oevGlwKicygsFWTe93zP2oiUCR32PIgiYCPpfdkJn9dIyAZlgn3ihpKqNKiLduQ/vW/VRdq57ykVLTSDUuoFsIDIUT48WBcQJRswVshux0C2gGuXijc6isOHlthGvzKQRUVdbUXVMmUP/E0jZc46h50SODSQILMUgJ0WE4IiZkfrdjjAA5nUCu20RAkE4j0IVrW7Sv6a0/Prm8e+qHeoYhaIBqzEgQ770jvOWVgMcOQRMBHyWA7xGLBXRD5jMTiEiYpXW4/AJfIoqPDIyCeS80fVXatxKyptA4IHGt0Ez050CyZJqDcTBkIjDL52HGLJCMAX3cAtQ68TaMBPKznZa9+kNRiwViagYINAmt+zCZDljdKJQYn5vnhSHeWujZ8YtFJooBTxLwUESwuE973wgRY7KZwJ+/PlfWnv690IYNuq6qNRYCp0aTBPK9wKfUvLkYyJYg1scIzMxxJ9xlEElT8hb3Me2hqP+cfSZ1qMdMVGXOze29wcRYoT9r/PvAJ3zGaWOM2ihxEFFULClSTl7hKBT4PInnw7imeQ9FV3Zm7Hp9QOfr84kniFFnHPZ/6eqBZ3c2kJm5WfDbyUEMOA2e/WYfLJpXQHhJhs7+IPRgsOuYBGgt9O2hboydGKzf8TOZ5c+Gjr4giPjB2tLwO3QNh3GOAjUtncY64zX/8UP9wv6M3swteGHzBhx96T8onCmidb+/8sA7Gf2FhuE8rxI5cgWWlKunFz35vKNz9/vTczdaUcFeKhevY1iyDuuzAiYTP6qNgaYgjhNgXv/jtbUfn+3KPe270csqtjvUWKQEjzvejPzKQmC0Y0j5DTY+okz2bvRvAQYAEPssRcASuWoAAAAASUVORK5CYII=', '0', '2019-09-05 14:53:30', NULL, 0, '1'),
(5, 0, 'Compras', NULL, NULL, 'iVBORw0KGgoAAAANSUhEUgAAADAAAAAmCAYAAACCjRgBAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo3QUIxQkZCN0NGRUQxMUU5ODE2MUQ2QzA2RENERENCMiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo3QUIxQkZCOENGRUQxMUU5ODE2MUQ2QzA2RENERENCMiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjdBQjFCRkI1Q0ZFRDExRTk4MTYxRDZDMDZEQ0REQ0IyIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjdBQjFCRkI2Q0ZFRDExRTk4MTYxRDZDMDZEQ0REQ0IyIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+cZT8bQAABLtJREFUeNrMWFlsVVUUPef2FV5BsASQIQIBGSMRFByqBAmjfEEgQJAPEoiJfKpA/Hb4MyTEH6LGD/0wMdiI0SCkDGEeTBkCKSVQhgqFkmKB0PZ1eIe1713Xnty8V94d+tqdrN77eu859+yz915776ObV00vU+EkC2TkprzyiuprSQF7Q7zvADeAT4Em1Q9EFHg/5Jg3gJ+Bqv6ggBNhzGAqoR6tnt4vLNBYwHsl4vK8iiwAvjVGtfYHBRYW8N5Q4DtgJn/PAaYAF/tcATDJ5Z5eAEuprHaUY7KnLQVeAt4TBQz+6D5UoKBvixKQzcD31pjfgXVAOzAOeAUwfeFChcpx4A7wMn/PBsYCNxnUPwEDiqiEENC1MArUAf9YCsjiZ1GBS0JKtEQxpaogGmXGFVfZb/1bdnuZ9hxKLHO5yItvBv5MhRwkbvQAGMnf80Clo3G9B+wCbrHUSFpkzkmyYVbukg2rDqvAbeC6pcBkxsLfsNIeXPckvs2SLL2o+hxYbj06AjxMRTDbIeAd/pZCcK4o0LziNVBCpiRRVjXYeePuvmT/JdaTDuCsCvsx0uki7vRgP5CAlcBTYC2wHuhKgN5bgK+AWmAacJDEIXKN67idijD5eeAKs7FPp/KBairxAZBOYP+F9fxS5S1glPXsBMzzb9g8QLOaJqX1WUuBEaxoq2lWKc8nxgzmErpqA1zIgT2WWHVYl8eGOivsGEoBGUA3OgZ8ZE0qH9iVHtfe2FY/YCPuS2MmNHGhNtfXtZqAa4X17D7zkYpmAU9OkfvH87fUSGOw+Doo+SSO3/y38vVuLRzXg94GJliv1AD1cRUQOj1pKTCaLlUHCw3B9WMWfBGs0Co8f6qzrG13qiUttphHi/qy3wtwE00BulEHJ1rDxCIfWKqV2W2Uln75XTJTVNmWanUXX06a9uUhcNhbR20sCyhaoJG772VlpcfStf4ic0SJgxaPZVx5lfDlEl1IxXUhEaGxq5YCk+hGosAv5O0oSa0TuMv7RWymfJHdfxJbAe1trUx0AJhvFXdvAn8YbZ4O+622LnL54DHdkEC3mPGzr32cE0mBF7vpVLj6M2uXpNg6qY1ux/M4JYXkkDHAjEBiq47T0OSSi6wKK6xeuTLBbtFmn6OIsQYdCKtUvPmzaGLcrFxhdUkDe6GcdlkPizfB00An6ozllTV+jB7jB3pTGoBzcXvifHIU2CGhYdFmF++dkJuUJexxDnuQu5FPJUKyRxmDT8rtW+jY6tF2mp4OgjmulA3SSLfe0Vi0UZ3PO0B2El68HK38QHqVTF2FxW+SxfF5vnHCYl+S1fa5V6O+ECrNNy5RBfgR6QG+Bj7kMWSap3c72CPkHGeMW3V/AmxlzZ8mhW4Htuju+XvXAnSbxXmOJZeXtrC/DfqwdkaxpirJ0ROsQyANL4oLQV6g/+eSER2DsKDcldFAjs1Jdj3MmbgCN3iskksuCDOZ3JzRxL4337gHRVFAKy3F3U7gceCR5Ilf5WZYZU3QfxT76G/YYwQ3ROIn0xMT6YRZqJQBu4G98hnlHcvfDBZh9rgsXMvRbg8h7ehUWuRHFm+mKAr83xKumoFJTYpJMvO8BQQ2wGFVK5m9q5BxzwQYACOIVFeXZRhOAAAAAElFTkSuQmCC', '0', '2019-09-05 14:57:46', NULL, 0, '1'),
(6, 0, 'Tesoreria', NULL, NULL, 'iVBORw0KGgoAAAANSUhEUgAAACkAAAAwCAYAAACMuVOlAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo2RURCQjQ5NkNGNjgxMUU5QkQ4Q0ZCQ0VBODYzNzRGNiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo2RURCQjQ5N0NGNjgxMUU5QkQ4Q0ZCQ0VBODYzNzRGNiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjZFREJCNDk0Q0Y2ODExRTlCRDhDRkJDRUE4NjM3NEY2IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjZFREJCNDk1Q0Y2ODExRTlCRDhDRkJDRUE4NjM3NEY2Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+1LwijgAABGpJREFUeNrsWW1MW1UYfs+5ty21QAtsIIKObckmY2RqFzOyNbMzkjHDNkMgIWbOxB+LusUfOiNmTiSQ6PaPGN0Sf0jioiFRs2EGi2ZLx4C5LySsOBSQOUo36cdue7G29/Zcz2nXWIjLaOkHS3r+3POe857c577f575IURRY6oMHAQHo6WwcVLBakUKrTqSlFECu4gvRE5R+FEDCGA4froT+i8uA4xb2cS6nA7yCAAihmIAhjBW1Wh2gU8IDpo+/4WnQQBOdNdzj6b73fC5CExnB9ydLYdiqB3o+6dJTCFGkQOAMx3HtfEiaBN6jYOujeLbO/SzY6r6rgu4fi0EUVSkByQYh5BlqjhYmR6bYogcdkIMYfP9wEKPWFjtUFKQax2QnaXIcDA/ByIDMgMyAzICMN73R5ERTPmAUni85kAxUSYHc2/KKc0vLXueWx+g8HqB88vIugiBBdxu2iZ82fuTtY2tDE8tPnzibY1LRCiqW9MonSYJ3VjwxO2zc4Prh1XdudkbW6zaLX1BpTnSez94/7eBNCwWacJD0xfbtz9s/e/fQSOv8vY37fI6NAJ3LmnNtH3YUXCBKGmySqfhZo/Pb/wO4uMo8gUObFZzYtcN2JEJbLxu0Pd9p9wh2ScdKKCplIsmg7r2urw0SgJSrm3mtPlf6a5N55lZkrf34mhMX+gIvzYrCnEKPw0vAcaLrz0iMpJ8BzAQxgpgLZz6BDgOCR1U4cG55WZV5ZpKtvfX6aOO2CtUm2RUgXj82XP1NY/75Rla114crcLokSa8Xq06dLnm7ygwHGF1uFPzlRrBEsXT1HM0ub/s677jNyZsWCjSh3s0uaJeuFtQdaV136H482w+Kv77f6N6XoyXWhWafhNskfXFx90/F+0dGq0zrywVLwOHx+d0+8uQK6UpjsyeUeWoo0JMDRT1nrjxSwaE0OQ61z6LJP3XVf9zUVbucavAIAmjUMJmtyd5Z2yQOM55CQ9CmKCjkUGnz7sjdnIUbnuZqSUZlwizO/0/kaQxBzM6Yp6vVJBSCsugzoFLAkEMuriyWx+LAmFiQSjjrjNXtvNVqfMrdhZBC5CmJyDNBHQXpWrvH74/w/m5TVdL91INkuXv1SvHSa2+Md8zb8kQTxw4adg2O5Zk5nIYQxNTsdGseH72mV92P5+ib+Xs/79K3yUEoS4u6MVWf/XaWqfmT9efWra3s/aBluCmyd6C+sO2XcY1p2qlfRcmSWFIjTkL4genb2s2XB/NrRwfDErV+qdH1j2hfnAoXuiVpy93Rg4UdUeQr2o+t+ao0u7T/2lC+kYafDVycIklqFWS9oW8475AaRK8A3CJ0ltTbIgvo7Lc1Rov76Zr5OZABmQGZARljeZVokKxVd+eBUZ8jrAyDFLciJYRQgGUcmUL9GMicNo1lnggteQYJdrxgh45vymB2lk9F00lBGLO23VC4t6iDQRiDl6MYauYdqMG8Arvrp2Dweh70DSy8ARp3oRJqgGpCDVD0MLSS/xVgABunmIK6hF7aAAAAAElFTkSuQmCC', '0', '2019-09-05 14:49:05', NULL, 0, '1'),
(7, 0, 'Configuracion', NULL, NULL, 'iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpBMjQyODkzOUNGNUUxMUU5QTFFREI0M0VCMzA4NDdEMyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpBMjQyODkzQUNGNUUxMUU5QTFFREI0M0VCMzA4NDdEMyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkEyNDI4OTM3Q0Y1RTExRTlBMUVEQjQzRUIzMDg0N0QzIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkEyNDI4OTM4Q0Y1RTExRTlBMUVEQjQzRUIzMDg0N0QzIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+xdhpEAAADNtJREFUeNrsXV1sXEcVnllvYjtRknXSpGki0Lpqw0+oYlcySEhFG+ABxEtM1AfUtLKJwwug7ApBAgg5FoLa5WE3KrwQi13VjkAgs+4TL6AY+gSRaldtWkFLsmqVP/Jj59d2sr7DnNl1sz/3rvfe+blz786RNqsk9p25c75z5pw5P4MJIchQ61LELIEBgCEDAEMGAIYMAAwZABgyADBkAGDIAMBQa1DU7S9gjLV+ofRkfgARK97sz1+5ftPN2xfGUkM5nd/f7ckudv0LGgMgMzE1SyfY4+Z33AGALjBCc2PJod6wACA0WwCTfJfM90IU/j3H0uMDxgbQDvrNq30Bg8UNADQjujPtUzeYwrEMAJqmmDr+45gBgH46IKFwsIQBgE4GYDavXCKH09mYAYAuFEU9qodcQsUeAwBttD/ywSrHcQOAlnQBw+UKhgIA2A+3LCSuYFi8gJh6/mNjBLaoCxgqVzDwAPDDBQyTKxh8DeCDCxgmVzAqXUIn87BI8JlLHeqfC4cLKNcV/En6tz0r1MZoQ2Thl6nvzEl9A5n5AJmJqSz9hYFHnhOZIzhyEj1E06nB/gUuYP0+H8dFa7jq+R7IbT6AjTuYIyQ6MpYaLPBuJ0to5QAF9FGMKrUayY0mjww2PRtdEkLSE/kExuSMwzQXEEHTAAa3WkEU48UBgA8IIO0WxkcpFw44eRaUR/vHUkdmAgUAKv0X6A/Hm5hxU1qBGXtRK0nHHxapAsUB4GMGjHSgaGYkNbjgXtodn1qgWqA7MABIT0wBo9Iul85RKzBtgqxsU4DyGQCrDKPLOlgrtc1Iu/MjcWo0dTijPQBAUvE66wLiOSip0Ap4HQGJT8oyguQAoPwaiGQ66LbgTtodn7VAn9XdSLN4AYBwN7DEMM5TMox7MCJZ+qx5mcyX7iMgnFzGK/NUZrI8zC8/K7aEi8PC5yhSA4DLRxk3GyQmydQAUg5uiNXbyDX0VQPQfTqNDEklC0eErrEwAKRfyx/w6Uy+1Sjx4/T4Ae0AgLGRflVEMElrBQDq9p2Q4aIZchS3+LH0qRNaGIHsZG7FmkUBjY8HzQisdAsRifbWnjwqNwLZsWyI8uQD5GLGsAC3kEsDND7v14eWlx+gW3fuoLv376N79FMsrrDvSurs7Cx9d3Sg9vXr2d8jEf2j5bVxArf85AoHU8NvmJVLasr0G/Pz6Or1G3XMtqPFxcWqbyAAQmzLFrRx40ZtwVCOjcwo1wBQjQundToy/sOLlyjjr4vzlSnzAQjw0REIpbhDqW+BkliAkPN+wVRcWUGXrlxlzJdFwPytXV0MCJpBoNBODUKIE6gxAqNWUifmg4qfe+ddqcwHsiwLXb9xA128fJnaEUWt3MIlVPQUM3GtATJ/mKZuH7mgy6v/j+7x/zm/5nTOwh97n+p+Y+/TT/4jvnvnWxs6O29X/sD9xcXNhYtX9p17//yXzn1w4bnyP/c10gZP7NzJjEZ9toK27tHkQEGqEVjOxtHihUHln//wo4aMB6YnvvDsa4nPP/vWGo+72ffMZwvPf+3Lr8NfZv715r6Zf775UhkMfXba4OKlS+jx7dvRpk2bNDEImVs4KFUDnDyd16K/PKj7BiqfMf75r3/lF/Sb66SHAmDrn/7yt586AQFIJxC8fPQwlqoBWOaOz/s/qH0H5p/d2Nlx+7svHBwCaRYxFgBo7/eHfnD27Xfjvzk9NX5vcWlzLRCuXruG1re3M7fR1y2A8calYetB0eT8Nvgc9vyz8d1PvJMb/dlXRTG/kuCZ8GwYY9WmqCTYDmBb8Jly0gGQPPTNFCQ++uXqvff+fx2Z/6sffe/bsucAY9iBAJh/+epVHw1AMjKWPJJSoAEQSr148AQheD/yoHJ4jb6l5WXfmL8WCOAU8c6dO8rVfvk4+ISnsw2vA6de7J8hbZFeSOBU8aKrJ3y1BHu+SuZXggDGrnMl5ueVbQXQtLIUEWyuZkAoABgIvtVfIMXIfgoC6XaBk9EHBp9farc8dpUWeFgsooVbt1SwP9dB2vbzViRx1waWizkG05P5v8uKDYD0253tg6snw+BzYxjCHKiLWOUVwDYAR8by9ntWcyBE6IRFNlKH+nMEYdgShDMEonp20g9+vt9md3kOdVrg3r17MlhfgKxgkQ2rhYa2oKKHbgm9dKIzIp8LIV076ec95BF2TkDnYueuCqYZCPiIrhYWHtuELSF56CD1EFBGxPNA/dss5tlvJL74KtKE4Ki5VgvcFagBoMJoNDm0f62qIC0AUHVeYOF+XlfxloNb5efeXwcAmzgDeALLDx5wu3iYoH4v/r3vAGDa4KX+afoWXIy6a6NK7VSuBltB3Zwqs4u8ES68nBqaljlv+ektnD387fZSCOlqBwCbOfGeB/DWE+oBAE6CBM5agni+bvPcvjVWp+kWl5Z0X179AWCnAWqTOfQAQNdHKIBkbg1rcZIKAKgaMkvcwgCAWIFZYrMFcNGWzfWpVpDAqds8r92c/0Td4gagsiiQNgBk7+oHgIW67c7vFDE9AMCZL7DFJtkSUrd1W0i7Oa2L8gVbWbw/0EYgdA3hbOW6ccOG+sV+lLevDwBs5gSJopzSExfZDUQpADKTf07jCMnzZhDb2QBAkLevC/Pt5gLSz7sFQAk4wSh/LHMqHRgAQN1gZnIKSsaFtHeLtrXZaYE+KNrQBgCluVQlhayWm4sgaDd3PDN+RkZ7eqEAYG3ioqxbSELkc3fvfNxW5ULRhgaqf6ud+pdQKJJYxsVZ6DaqJQDK5eKzMnoFbe2KMU1QqwWgYsdvAJTn0Fer/uXUDOK4hSOzIi+v5gYAU/kTU1mZvQKA+bsctABU7PjFfBjbTvpl5gMyGGCUPZ45lRWxJXABgDWIilpnRLVub0QAADstAOVafgGgPHad9KupE8QDS3jlzLF0Nu4LAFh/IOgOxhnvd6MFPrl7V92/Q63eD1/59e9UMx/GLNcJVtGOHTuUzYHlC1C74Fj6VEIpAKAvYKk5lNoiUdACNm5hX+Hi5c+pBAGMBWPWSj90DlHdL6DULQyf8do30DUAmH8v+NIGN7Snu9t2K1AFAifmg88ve+9vbBfgYS/nBR40ABlAPlJ7+3r0mT1P2f0XA8HA8Z//VYZhCM+EZ9sxH4I+oPo1CP645o2Hw2r/ewNBfGDPk912ZeJ9dF9Gr4yf/qOqBhHA9N27dmkR+PFym6l7AEAdoAKrfy3a8dg29u3QK6APyrXOvTr+nIsWMVW0VosY3ZhfZk7ONWiC3iQKcgbffu/frHdAIw0Of6w2iYIEztocPojnQ0i32SZRwHRQ+zqFfL00ifLWJ5B5Af4ZgrVUahzxAbp1W01tPlj7YPDplPDBGkSkjpxQ0yewGMmobg6x1hnBM5/+FLMLOrhDsM4Ehzyg8h/btk0v5sOFUijqqRQvdK1iVzuGQiMpm24inhkPEq9LJ7B66VfcKvbRmQCEffW9JubG/AK6ST9QXr6GjWDLdAjpAtN1agZpZ69C4WjFViDbDaxEXmQEY6ItALZ1xdjnaRRnxiLYCACEyoLTBw+LH1v0YNAB43Vo+eZm7+dyHXlvDKm7IDpgFNQbQ1bdvtqLpZXfGEKikRGdDMJWoVJ3sCh3uz5uALBGUQSdNCxRjoCTvA2ihGwBFVvBhSDeHBbMLcD5NnHfbg6lBmHKiKUawgQLW2txXcKgG4jg5lCG7N0+kV1DhB5nEWS0gGyKEEvoGgtvE6eia2gLW3457dvEkSJoAU63kJA5gvAgeYghxSYTWHYhkmknbV1wVMtb5wduXzuJCtewwryASkpPTCXpz7lMT4KrUNE0wZGTTJNUPS+fwMjKyvAy5HgBpFBu51plE0FRh4XxUbriB1wnb1DDbzR1OLO27BD/AeDKLQRpp0xHD9F0ue+wPaiy+RjcViY6DC0aAHA0C5G5Rk0dIZ9/Ca1A4ezR5jqBObt92gKg8bWyztK+5nOhFqF0cdWAXgAgOTiZc3s404xWqL0eNhAAKGuB6jhBk9KuEgj8APDG+Oa1Qv15f2AAwBg1me+h0h6jL7bgVtqbfD5XXgIPACrj8CIJtMIKivS0IWvOrdWvNBzctGso19Qu+Hd/tfjW+EBlpiu5iSX4fQKLahbKjqixNxf05Qs8AHhtCR6S0b7dAMCbKp7xYdCZMKxcWFrFKpdEEpIkmFAAgBq+6ruH+zGmAYCTbxop+DBowQBAGxWAfGAGMQBoZVcwDC5gaADghysYBhcwTF6AaldwJiyrFqYbQ5RJJAlRHURoAKDUFQyJCxguDaDUFQyHC8jeRHY4WCVlJqZc9y10Gw6G3L6x5FCvvpqQtC4AgCA/ABErLgcAuCAj/h8oABgKF5l7Aw0ADBkAGDIAMGQAYMgAwJABgCEDAEMGAIZahP4vwADTfWFVHwgkwAAAAABJRU5ErkJggg==', '0', '2019-09-04 22:53:37', NULL, 0, '1'),
(8, 0, 'Base de Datos', NULL, NULL, 'iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAxFJREFUaIHtlj9vFEcYh5/fziqgIEUIucCS4WyjWIlDHYXG5/NSUDkfIGUkPgAtUVBQUqThC0Tp8gXiiuI267Ui8aeGIwKhwwgpFBZCSESAbvZNcRvh2Dt3jjmfsbOPdM3OzO7vnbmZeaCm5p3QLsa4JEnOmNk8MAc0JE0CE+XvBPAhcASIyzE94DXwF/AM2AA2zOxPYB24L6mTpulDwI+8gGaz+Ylz7ktJiaTPzewjSbspPoiZmaQXZnbbzFLv/a95nv8xbNzAEEmSXDCzbyV9MerAw7A+NyVdTdP0eqifCzUsLS1dkfRTFEWnxh0eQH1OAV/NzMzQ7Xbzqn7RgBdc2o/gFTkk6VKoPViAmV0zM9ubWDun3BvXQu3Bv1C3281nZ2dvmdkZYGof98DFNE1/DvULhpqfn/+g0+m8AVhYWPg0juPlcZ5CvV5vZW1t7d7WLFuJqx4CTE5OXul0OpcByhfdA36kvAeKovgM+JjwPXCUtyvsgVeE74EHku622+3Ke2Bzlq0EZzFJkkJS3uv1vl9dXf0NGPd+0OLi4lIcx9+YWTNN08r9GlyBksU4jptJkqyb2QrQ9t7fyPN8Y/R5odlsTjjnzgHnJS0DDfoHUXDMsBXY1m5mBfDYzO7QV4BHZvZE0tOiKJ5Jeu69fwm8yvPcl8EccNQ5d8zMjkdRdMLMTkqaMrNpYE7SWeC0pMqZbrfblVmHrcD2ivsfmJY0vekZAM45zMziOP5nEraNj6JIm8e861nwnwsYxriP2+BFdlA4vAVIej3OIIMws2CWQS509X1xIeC7UPsgF/q90WisRlE0ZWbT++BChaTUe/91lmW/hPrtyIVarVYjiqJl4DxwDpjYCxeirxg3gHZRFCtZlq1vzbLjApIk+SFN0yr/UKvVOm1mZ51zc+XqTAEn6XvQceAY1S70EnhO34eelhfgI0n3vfd3six7TIWyDMhSu9BIqV1oJ9QuNGIOr0ocFGoX2mtqF4LahaB2odqF3lK7UO1C/+bwqsRBoXahveb/60Kb2W8XGsRuQozdhQbxN4Jlny/1LaUVAAAAAElFTkSuQmCC', '0', '2020-01-08 14:37:12', NULL, 0, '1'),
(9, 0, 'Reportes', NULL, '', 'iVBORw0KGgoAAAANSUhEUgAAADAAAAAnCAYAAABJ0cukAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAABN1JREFUWIXtWF1sFFUYPefO7JZfWxUTiBZBiJCt0E5pbTsloeAvPBAiWdpdNGpsjMFAeMIYXlAfiE+EGI2G4IOBbZsa0JgoBlNopNsWWrYt0JC4NEAqIESkYKXbnZnPh1LZtlPajoSWpCeZh/vNud93Tr57J3MvMQGRa4abQCwbHBfbWR1rqDyUGlMPTtbokbS4Thw5NxruhDRw6vj+TrHt9SLijMTVH4SgsWJx/rrHla7vBaEACAAOx9WNorI9ACBUPS3RyGaPNWkUhbdByStJB5tO11ec9ZgHOcuDT9DRD4PIFpFOCspBfAXyaTe+olLlVKqclDe9FFy69PXphhmuAmUnwZU+8tfc4g2FXnIF8oOz6ehHSGYDckHBKTlZX/FzsperROSiqwEvhfqRXVA6T5tpHyMRBNkjkBYSs0S0X3LM0Jox5SoMPpnm8x0hmSWCDttySpqjVecA4FRTpON2oqfQ0lXjfTOQXVBaomnqOMEcEekUx1pxXfcXichBktMJfJdTXDaqrmbllWZS6UdJLHZE4r29dklrY9X5VM7Z5oOXTx2L/DV4rqdNnFtU9r6Qu0D6RCSaSFrr209UXwGACwgGc0ztc4LvUvi1URSeHauPfDpcruyC0nlKUzUk54vgLCEvnGmqurRkefhR9iYzAMB2lHWmqaoTfRt6AMbUgUAg6DeKyvYI+RkAXUT2Jm5YK/vF96HabolWvgfBxwBIJTsNM7QLLl8SozC4UGmqluR8gZxOJJMrY9HKS4YZ2q47ck33+Tp0n68jLU27aJjh5kBh8DHPBgL5wdlpGXoNlSoHYIHYEotWlLe3V/e68WP1FTsA2SQCm+RWwwztDwSC/v73S8yNi6D0oyTnikirdFur2k9UX1m2LJgOYAdJLTUfCWOK0t8ZXGdUS8gwy/IAHiCZCZFrDljaWhc5MtK8WLTyS6M4fFWAfSRDaRn6rEXm2vVTktPmKjiHSc6BoDnhWC+3t1RfBwDH78sg3XU5glmDYyN2INsMbQRYSzJTRFotyypojbqKJ1yWSawuckBsWS0iN0i+NA0zapWfNSTniEij3d39YntDn3gvuGcHsszSBQr4hqQSkW/tv7W32toqulM5OWboEwKbAUy9E+oB5ItYtPLDfk5LQ0WtUVC2QjT8SNIACBGpu2WpNfHW7296FQ+M0IHE1a5OCiIQ2RaLVmxoa9s3QLxhluUR2E4ynaT/zvMIwA8MM1SUyo01VrZBWOxAmkTkp8QN69X48f3/SzwwQgfi8UMJxPHGcO8dB5maxiHLhiQBJxNAfWo8Vh+5ACDfq1g3TMi/0bHAtQNL8sLP6H7ZDXB+X0QEkJMqYW9pbq7u8lJokbl25nTM2C2QfKC/a3IejrY11rAv7k3+MAZ0v+wlWXI3QgB8zvazC8AWL4WmyowdUHibAz5UzBJlZwBY7iUnMPwSCriS6R4fFSjDzKX3nBjegOsBQu5xsBgJxNDNfj/w0G/iSQPjjUkD441JA+ONSQPjjUkD441JA+MN1/PAP+heYCdnDvl7nNZzzU4dt6Zd/mHh7afS3XLE7d9up45V4uZrXVq6S70/B4xi9ZGLC5/f6Joz+cfvQ+6gmFscFgAQyK1Y3bMZwEducycs7hoQEQCut2wTGf+1tO8mAWnjqMUTHvpN/C8CN9a4a2C0vgAAAABJRU5ErkJggg==', '0', '2019-09-04 22:23:11', NULL, 0, '1'),
(10, 2, 'Proveedores', NULL, 'compras/proveedor/proveedores', NULL, '0', '2020-03-11 17:31:19', NULL, 3, '1'),
(11, 2, 'Clientes', NULL, 'ventas/cliente/clientes', NULL, '0', '2020-03-11 17:31:13', NULL, 1, '1'),
(12, 3, 'Artículos', NULL, 'almacen/producto/productos/B', NULL, '0', '2017-01-26 14:04:44', NULL, 1, '1'),
(13, 3, 'Familias de Artí­culos', NULL, 'almacen/familia/familias/B', NULL, '0', '2020-03-11 17:32:27', NULL, 2, '1'),
(14, 3, 'C.Ingreso', NULL, 'almacen/guiain/listar', NULL, '0', '2020-03-11 17:36:36', NULL, 15, '1'),
(15, 3, 'C.Salida', NULL, 'almacen/guiasa/listar', NULL, '0', '2020-03-11 17:36:30', NULL, 14, '1'),
(16, 4, 'Guia de Remision Venta', 'Venta<br>Guía de Remisión', 'almacen/guiarem/listar/V', 'iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAgRQTFRFAAAAUVFRUlJSU1NTS0tLQUFBPz8/Ojo6NDQ0MjIyMzMzPT09TExMT09PTU1NOTk5CQkJUlJSUlJSUlJSUlJSUVFRUlJSUlJSUlJSUlJSUlJSUlJSUVFRUlJSUlJSUlJSUlJSUlJSUlJSUlJSUVFRUlJSUlJSUVFRU1NTSkpKS0tLVFRUS0tLQkJCQ0NDTk5OUlJSQUFBPz8/QUFBUFBQUlJSPz8/Q0NDPj4+QEBAOTk5Ojo6Ojo6NDQ0NDQ0MjIyMTExMzMzPT09MDAwPT09PDw8TExMTk5OT09PT09PTU1NT09POjo6TExMS0tLOTk5AAAAPT09Tk5OOTk5AAAAAAAADQ0NQ0NDTk5OQUFBDAwMAAAADQ0NNzc3SUlJTU1NTU1NSUlJNjY2DAwMAAAAAAAAAAAAAQEBDw8PHR0dICAgHR0dDg4OAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUlJSUVFRUFBQS0tLREREQkJCQUFBR0dHQEBAPz8/SEhITk5OPj4+RkZGT09PRUVFfHx8tbW1xsbGycnJs7Ozd3d3Q0NDmZmZ2NjY3t7e3d3d1tbWk5OT3NzccXFxPT09sLCwOjo6NTU1NDQ0MjIyxcXFODg4MTExyMjIMDAwMzMzubm5zMzMy8vLTExMXV1dYGBgPDw8////Nvf8NwAAAHl0Uk5TAAAAAAAAAAAAAAAAAAAAAAAMGx4LCmXB3OG+WwiT9/WKCvZTDMC44R7h4R4e4eQ5HR7h++TgHuHhHuHhHuEe4R7h4R4eHh7hHuEb3A/EvQ4FdfZrBAYzofeWMis6dMbj58NxOQImMzE8SUtIOzEkEjIPGzQZECUsLevG9TMAAAABYktHRKvJAWcoAAAACXBIWXMAAOw4AADsOAFxK8o4AAACsUlEQVR42u3V6VcSURjA4YFUXNIM1Gi13TRbpLIsF2xxbSGLNitbiFYMszIQEGFmQKVMMJpkxg0t669sJo8nO6eZueO5t/zw/j7Pue9z7rm8UBQEQRAEQRC0qtLp1htNqhmLdDoy8/XFJRvMG1Uzb9q8hYhAV7x1mwep0u079ATmrynZiTZfFOzS478D3e49Ho+3HyGvx7O3CP8V6I1mr88fGFAt4Pd5zUYCAFNZcDCE1GC4zEQAsK8ccb4oqNiPH5BReQB1fih08NBh9YWhcX9kVlnQAUeOHlNfGBr3R1a1BsBAP+ovFn1//AOA8v7QBqBRFoa2/aEJEFJfF5r3hzbAilLeH38CGIwtEyjtj+UAhl3ZI/trEfY34XhlBgKAiQ4Nj8SwNfL+w+gSwVKViQCIfhyLJzAWH//kXwJUZ6kDmKGxRBJrifHPHCKAYTguOhzHOz+ZjH/xc5z0GtUAEymeF6KTmC9ABExGBZ5PTagATkwJYtPsDHZAYoadls6eUgTUnJS+EWbZGNYn+OsZxthZ6ez0qRp5gKG2TvwileKDc/NfMTc/F+RTqbQg1NUaZAHZ9Q1pLuz75qMXvmNvgRYPDv9IN9RnywJyrI2jdESKJtDiwYFGa44sINdqWfyMYPTpM7mygLyzFaTnRyLl5/JkAWubmskDmpvk/4zyW1rJA1pb8gEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgNULKGhrJw9obyuQBRjOXyAPuHhpnSyg0Ha5g/T8jitXC2UBlP3a9RuE59+8ZZefT9k6b9+523WPWF33HzzstCkAHI+cj588fUas5y9czm6HAoB66XK63S5iud1OV4/SfMrxytXrJFiv67XiBYiCN2/73hGrr7tHZb5EsNmJZVMfD0EQBEHQf+gn1q7eiRaKMMYAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTgtMDMtMjNUMTg6NDI6MjQrMDE6MDDgbg78AAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE4LTAzLTIzVDE4OjQyOjI0KzAxOjAwkTO2QAAAAEZ0RVh0c29mdHdhcmUASW1hZ2VNYWdpY2sgNi43LjgtOSAyMDE2LTA2LTE2IFExNiBodHRwOi8vd3d3LmltYWdlbWFnaWNrLm9yZ+a/NLYAAAAYdEVYdFRodW1iOjpEb2N1bWVudDo6UGFnZXMAMaf/uy8AAAAYdEVYdFRodW1iOjpJbWFnZTo6aGVpZ2h0ADUxMsDQUFEAAAAXdEVYdFRodW1iOjpJbWFnZTo6V2lkdGgANTEyHHwD3AAAABl0RVh0VGh1bWI6Ok1pbWV0eXBlAGltYWdlL3BuZz+yVk4AAAAXdEVYdFRodW1iOjpNVGltZQAxNTIxODI2OTQ0APj7LAAAABN0RVh0VGh1bWI6OlNpemUANS42NEtCQoAMxlUAAABBdEVYdFRodW1iOjpVUkkAZmlsZTovLy4vdXBsb2Fkcy81Ni9Qb0lPSGdBLzEzNzkvZm9sZGVyYmxhY2tfOTMwOTkucG5nhvnUFwAAAABJRU5ErkJggg==', '0', '2020-02-15 17:58:30', NULL, 5, '1'),
(17, 4, 'Presupuestos', NULL, 'ventas/presupuesto/presupuestos', NULL, '0', '2020-02-15 17:58:20', NULL, 3, '1'),
(18, 4, 'Facturas', 'Venta<br>Facturas', 'ventas/comprobante/comprobantes/V/F', 'iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAgRQTFRFAAAAUVFRUlJSU1NTS0tLQUFBPz8/Ojo6NDQ0MjIyMzMzPT09TExMT09PTU1NOTk5CQkJUlJSUlJSUlJSUlJSUVFRUlJSUlJSUlJSUlJSUlJSUlJSUVFRUlJSUlJSUlJSUlJSUlJSUlJSUlJSUVFRUlJSUlJSUVFRU1NTSkpKS0tLVFRUS0tLQkJCQ0NDTk5OUlJSQUFBPz8/QUFBUFBQUlJSPz8/Q0NDPj4+QEBAOTk5Ojo6Ojo6NDQ0NDQ0MjIyMTExMzMzPT09MDAwPT09PDw8TExMTk5OT09PT09PTU1NT09POjo6TExMS0tLOTk5AAAAPT09Tk5OOTk5AAAAAAAADQ0NQ0NDTk5OQUFBDAwMAAAADQ0NNzc3SUlJTU1NTU1NSUlJNjY2DAwMAAAAAAAAAAAAAQEBDw8PHR0dICAgHR0dDg4OAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUlJSUVFRUFBQS0tLREREQkJCQUFBR0dHQEBAPz8/SEhITk5OPj4+RkZGT09PRUVFfHx8tbW1xsbGycnJs7Ozd3d3Q0NDmZmZ2NjY3t7e3d3d1tbWk5OT3NzccXFxPT09sLCwOjo6NTU1NDQ0MjIyxcXFODg4MTExyMjIMDAwMzMzubm5zMzMy8vLTExMXV1dYGBgPDw8////Nvf8NwAAAHl0Uk5TAAAAAAAAAAAAAAAAAAAAAAAMGx4LCmXB3OG+WwiT9/WKCvZTDMC44R7h4R4e4eQ5HR7h++TgHuHhHuHhHuEe4R7h4R4eHh7hHuEb3A/EvQ4FdfZrBAYzofeWMis6dMbj58NxOQImMzE8SUtIOzEkEjIPGzQZECUsLevG9TMAAAABYktHRKvJAWcoAAAACXBIWXMAAOw4AADsOAFxK8o4AAACsUlEQVR42u3V6VcSURjA4YFUXNIM1Gi13TRbpLIsF2xxbSGLNitbiFYMszIQEGFmQKVMMJpkxg0t669sJo8nO6eZueO5t/zw/j7Pue9z7rm8UBQEQRAEQRC0qtLp1htNqhmLdDoy8/XFJRvMG1Uzb9q8hYhAV7x1mwep0u079ATmrynZiTZfFOzS478D3e49Ho+3HyGvx7O3CP8V6I1mr88fGFAt4Pd5zUYCAFNZcDCE1GC4zEQAsK8ccb4oqNiPH5BReQB1fih08NBh9YWhcX9kVlnQAUeOHlNfGBr3R1a1BsBAP+ovFn1//AOA8v7QBqBRFoa2/aEJEFJfF5r3hzbAilLeH38CGIwtEyjtj+UAhl3ZI/trEfY34XhlBgKAiQ4Nj8SwNfL+w+gSwVKViQCIfhyLJzAWH//kXwJUZ6kDmKGxRBJrifHPHCKAYTguOhzHOz+ZjH/xc5z0GtUAEymeF6KTmC9ABExGBZ5PTagATkwJYtPsDHZAYoadls6eUgTUnJS+EWbZGNYn+OsZxthZ6ez0qRp5gKG2TvwileKDc/NfMTc/F+RTqbQg1NUaZAHZ9Q1pLuz75qMXvmNvgRYPDv9IN9RnywJyrI2jdESKJtDiwYFGa44sINdqWfyMYPTpM7mygLyzFaTnRyLl5/JkAWubmskDmpvk/4zyW1rJA1pb8gEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgNULKGhrJw9obyuQBRjOXyAPuHhpnSyg0Ha5g/T8jitXC2UBlP3a9RuE59+8ZZefT9k6b9+523WPWF33HzzstCkAHI+cj588fUas5y9czm6HAoB66XK63S5iud1OV4/SfMrxytXrJFiv67XiBYiCN2/73hGrr7tHZb5EsNmJZVMfD0EQBEHQf+gn1q7eiRaKMMYAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTgtMDMtMjNUMTg6NDI6MjQrMDE6MDDgbg78AAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE4LTAzLTIzVDE4OjQyOjI0KzAxOjAwkTO2QAAAAEZ0RVh0c29mdHdhcmUASW1hZ2VNYWdpY2sgNi43LjgtOSAyMDE2LTA2LTE2IFExNiBodHRwOi8vd3d3LmltYWdlbWFnaWNrLm9yZ+a/NLYAAAAYdEVYdFRodW1iOjpEb2N1bWVudDo6UGFnZXMAMaf/uy8AAAAYdEVYdFRodW1iOjpJbWFnZTo6aGVpZ2h0ADUxMsDQUFEAAAAXdEVYdFRodW1iOjpJbWFnZTo6V2lkdGgANTEyHHwD3AAAABl0RVh0VGh1bWI6Ok1pbWV0eXBlAGltYWdlL3BuZz+yVk4AAAAXdEVYdFRodW1iOjpNVGltZQAxNTIxODI2OTQ0APj7LAAAABN0RVh0VGh1bWI6OlNpemUANS42NEtCQoAMxlUAAABBdEVYdFRodW1iOjpVUkkAZmlsZTovLy4vdXBsb2Fkcy81Ni9Qb0lPSGdBLzEzNzkvZm9sZGVyYmxhY2tfOTMwOTkucG5nhvnUFwAAAABJRU5ErkJggg==', '1', '2020-02-15 17:58:35', NULL, 6, '1'),
(19, 5, 'Solicitudes de Cotizaciones', NULL, 'compras/cotizaciones/presupuestos', NULL, '0', '2020-03-11 17:39:23', NULL, 14, '1'),
(20, 5, 'Ordenes de Compras', '', 'compras/ocompra/ocompras/C', '', '0', '2020-09-21 15:11:14', '2020-09-21 10:11:14', 1, '1'),
(21, 6, 'Cuentas por Cobrar', 'Cuentas por Cobrar', 'tesoreria/cuentas/listar/1', 'iVBORw0KGgoAAAANSUhEUgAAAEgAAABICAYAAABV7bNHAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGNDg2MDJEN0U2RTUxMUU5OTg2Q0ExOThCRTQ3RURGQSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGNDg2MDJEOEU2RTUxMUU5OTg2Q0ExOThCRTQ3RURGQSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkY0ODYwMkQ1RTZFNTExRTk5ODZDQTE5OEJFNDdFREZBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkY0ODYwMkQ2RTZFNTExRTk5ODZDQTE5OEJFNDdFREZBIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+cEqOIQAAEWRJREFUeNrcXAl8TOf6frLvmyyyTOy1XKSIpUSqivZvSW+pFiFK02tNrXWpSkpS/3Kt7W2LXtxWuaS2onq5lNqyEbFcVCWSkFUiiewr932/OTMmycxkm5D09Xt+MzFnzjnf8737953R8/T0xDMSa8KLhP6EfoQ/EVoRzGv4XiEhkXCDEEUII1wl5DfGTebn52Pu3LmYOXOm+NuwkUmxJ7xK8CF4EVoTDOp4Diawi4SxhApCPOEC4TDhNCG7sQbQWAT1JbxH+DPBWcfnZoI7SHiXkEL4kbCdEK3rgejr+HyDCT8RIgjTG4EcdeJKmCWZHxPl3RQJ8iAcIJwijCTo4dmLvqSxZwmhko977gSZElZIGjMaTUfeIUQSlhGMnxdBvQhnCEEEMzQ9sSSESFrt8awJmiqpcl80feHoeY4w8VkR9P9SxLBA8xHOwXYSPmlMgvjYbYSP0HxlOeHrxsiDmJwd9VXTJiYzJcf9vi416Js/CDkK8Sd8WW8NKioqwuPHj2FqagpDQ8PgJ0+e+Dc3Bvj+GRUVFQL8nkVPTw/m5ub8Opv+TCZ8VmuCiAjo6+tj8eLFcHV1xdGjR31PnjwZaGJi0qxIMDIyEiTY2NjCwdERri4ucJPJ4OLsgozMDOzY8R0e0/FEEgec21KSWzuCmOHRo0ezFnUJCQnZTBrUZEkwMyMSbG3g6OAIFxdXyNxlcHd3h8xNBmeXlrC3t4eVpWW1c0ZHR+PSxShhISRbCVcId2tlYgYGBnjw4IFhcHDw1szMTCszs8bNAXlSGEoCGPQ3VytGRoYwI02wZU1wcCASXCAjTZApSXCGA5NgZVmna7Zyb4XIiHDFn3aEfxCG8XzUSJCxsTE2bdo0//LlywN0RY4ggbVARRMU2mpkZAxzCzkJjmQOzkyCm0xog5ubG5xbSppQAwll5eXIyc5BRkYGUlJSERcXi06dO+OVQS9XO9ZN5iauryKvSgXvl1oJYv9TWFjYlvxOkC78Dt8EO3wm3cLCEnZ2dnB0clL6BNYG9nUtiYQWLexgYW5e4znz8wtw89YtpKWmIjPzIe4n3UdKcjLS09ORlZWFvPw8lBSX0HUL0d3jRXgP9BJWoSp8XZ6cKhJMOCg5bs0aRIMKIb9jqQtyWGbP/gAD6SadiBgmyNRUO/ElJaXIzs5mM8fvd+7A0tKatMBb+T0+a1pqGr7/ficiIsKEHzExMabJNRBE8CSbm5sJxMbeQUjISixa9CFN0FPyeVJ40hRarGJqnGlP00ZQT8J4XZhVOam8TOZOBM1U+3kazTgPNDklBUlJSUi6n0SmkSyIyc7OQlpaOoYOew2Byz6uRKqVpQXeeGMUfHxGYU9oKNatXSOupS6YmJOL2Ls3FNGXL6F7dw/4jBqF/v1fQkuaLHMLC9K04qqaxA24DYRbmghajLq3RNVnoPp6bK402BzSHNtKn2VlZcNvkh+RkCoGp5hJAwN9giGKioswYuRIbNywQZxHrlklyHn0SAxOns8AE8aPIx/ljAUL5ovoxtpTVdiP3ktMxJWYGFSUVwiCWrRoATtbOyQnJ1X9jjFp6CKpG1otk+6oy54Oq/wjGlA6aURVSSH/kZ6eJkK1Bc2kJYVifjU1lQeF1q3aYMXy5UpyWHbt2o0RI0YiMvIiHuXmPm1hDh6EadNniMnQJHwdGxsb8lkZ8iYWaSQHBA4WanzDeDK/1uoImtrQ5pKqsEYUkwqzA60qO3Z8LzRH3YyzpkycNKmS1iUk3sPBgweQ9TADEyf64q0xY5GT8+ipXUz2Q5s2bVFWVqa8Np+fVyj4Va6dIn1Baan8GE4Z1BFEwcksKirq3W3btoFhqNIZHA8dy+PHFbh//77SacfGxmHb9u34+egRkemqSwptyZEPGzpU+X8ZmZmYPm06UlOT8ec3x8CJZp6dvWoKwg55yJChNKB/CG1hUjhx9PLyQlh4GFLJz/FksG/LogDg3NJJRNEqoV5BEMLDw33PnDnDJUiZoUpTqY2uCWIDuU/Ol6WwsAgBAQGIj78La2trjY69ffsOFGVclP938eIl/HbrJnr17k0+ab3Ga/Xp2wfffrtdWUvOnDULb5AjP/6fE5g3d46YENYo1iImyJ0IUtc6Z9LIxDoRuBl4QaHjPo3SRSe15sikmGVr8gOq+RWreGlpaaW/7ciBqkYWLh2srK1w5/fb8J04CZ9/8XdERV2qdi3Obbj04AFyRIuMjKTJSEB4WLgwLz4nXyslJUUZ6lnbtIiPwgexFg1uDIL4xjiBY9PhG3R2dlbaPZcU7DjbtWtfyRdUVfvu3bpi6cfLyKk6ISoyAn9bvQqTyecEBS2v9D2uuTgnevJE3oX46chhjBs3jnzXfkXNJe6DUwoWTk550hS1nRoZImKNFL066pIYvvFiCtUcWdLS0iia5SpnjW9IhHW69IYNn2Pfvn3wGugtzIIJzXr4UJQkquI7YTx+PHQI3363A/PnLyQTtULoD3tw7dr1p8RK/1QjV3l5WSUtEX7wTqx4z+ULT5AWgngltzVrTz/JSTdYeJAsLewd0KFDB/Tq2Qt9+vQRYVxhLk8HJNcwQ0N5Bsw3yq+JlLMkJyWjVSv3Sue2IVIGeg0QOHv2jKi58gsKlJ9zHVZEE6Knp1+pdFJENTYvzrHatJG7WktKOO0dHMn5p0JDx4J77r0MdbEywTPDIX2g9yC8PXYsPDy6U2nhqKaKdlf6AzaxhQsXwMbWFteuXqFi1FpEJx74iZMn4f/eVOX3fv73MRw7dkwkicmUNvz22y30e6k/evbooTzmxo2bIhDwwKsVshT++TrBwSGVilc2+atXYrQNrTcT1F0XmjNt+kyKFh9oPY41iBPCCopWTFRCQjycyBd8MGcuhg4ZQtW7q8iyfzn1KwoKCpX100MqSn/99bTIhIupCB0xygfLKZFUJePoz0eFNmqKjsuWBVar7GVubtpMTLhA1sF2DSGH/QxrTk3kCLt3cBBdPm5NFJB5jHlrLA4cOIgPAmajS5fOIvy3adOaEsE3cer0r8rv+flNxLmz57Bq1WoUFhXTQF+BfQu7pxr28zFERkQonbFCq9kXFhTkk7m2xquDX1ET+dxrSlTasgY5NaTbx6F1wYIFtVucsrKELal6QmICln60DFOnTlZ7nK2tDfbv30emUYoxo9+U+yAba7z++jD8sHcvFZ7dKuVJQZ8ECodcUKDoM+mLCp9bLPbkD0ePGaPWz7SmydAe6p+0NGxIccpaMG3aDHTu9EKtjs/Ny6faLAOBgcsx2c9X43Gl5DPSKfot+3gp7t69S4XtJArLTqJFwf0d+bULcfjIT9iyebOISD1e7CGiJGuFaLbRe26xcGHKZKmt0QyNRNVbpe1RaU71PD09n9SHHI4Krm7u+CE0lEyj5vZRHpHz178uoYy3L97ToDkKOX36DN4jJ80mw1rasWMnjPLxwfDhw8nRu4ljklPSkERljJuMiHBk8rQmfRRESpR9Ji6WExIS8J/jx0Vmr63vXu+OfFlZOebMmVMrcs6fD8PWbdupGh+Od95+S+uxqaQ5a9etpaJ0Eoa9NgwuFGnYNzFZqk7ZzdVZoHKwKBZdRe4gpCSniG4jJ4Zci8n7TNnCJ5XQ5HILmDXL2NhEbU3WIIIKCwswaNBgjBj+ulaNOXf+PIXn4yijCnrBgnnwUPEd6iQsPBI7d+7CXCL+tdeGaWy5PmQSKEPnsoEbbUnJchI4RcjOyUYhmT5r+NM+kzzXMtDXF6+qrV1t5NSLILljtsC8+fPUdwrT0rHlm61C/d1btcIEyoL7v9RP6zkfkF9av36j8AefhqwQ/emEhETRbeS8h7WAX+V96EzkPMoR0bOcfFU1EkTyaVhTnVVrMayPY54y1Z8cc0eNOUe/fn0xb94ckf3WJJdjrmLjxi/gM2ok3n57DG7cvIX3/zIN9xLjhd/g6KTIihUE8HsTIsDEWGftK42dY3bS5bWNZDx4G1s77Kf6ycHBvsFXv0q11Pr1nyMocCnat5enY+PG+SIm5pIoT9Q11J6xZPEdZNYlY/bzm6wTcrgjuG7dBgrlHynJOX78JJUM10Qx2gTI4UQxne8ivnZRqxRt27XH+HHv6OTS7KdeftkbL7zQXvx97dp/sXLlp1K5oIcmIgnsg7hn8JK2QlRPWq+aMmWq2mKwrpJBtdX1a9dEB5Cj0o8/HsbBgwcp8j0igozQhOS/rEFRmpOrYhFZ8ilr9fDoQTWSbhY9Tp86jdu3b1E1/yFmzJxFxOTh3SlTagy5z0GiWYN4u2wJ96tVtYb7t1yELpg/H9evX6dq+d+iW6eLZtoZKjw/+WQ5VfJO6NK5i1jvCqCCtYbK+llLETERzRr0GyFWxaiEM/b19cOmr79C165dMH78O2KFIDBoRcO1h8qIvLxcUb1z+2Lzli14/31/3I2LRRPbh8S8xBtQgcfT1pUXBhQ1y1+oAF2yeFGlRf/evXvh5MlTiIu9S+/r94QQa8iq1WtEozeeEsHikhL09vSEiakZrsRcrrbJ4DnLbsIxRaLIT83Mku8wM9CY5q9YHoQZM2ajXbu2dMzQul9xzw8iw127Zr3QFi4Njhw5SgXvbp1lvjqUwyLQS8+LWUgqJWPHPMDLG19/9aXaDl1ycirmzpuPTz8N1phNq5OkpBRM8J0gOoJ2di1E0z6bt6uQufEiYNPIe5TCu834WY8SNjGR5nBHlNCf65jff7+NgsJieHt7VW+QUBLHje/PVq3GkKFDYGZac7+/iMx2HpEaF3tH7BrjqFWQnyeCAWuShl7M8xTeS32C3ygIEpMM+d4YfW5MRV+6CEcnZ3TrWv2hGe4dV1Q8xvZ/fovhVNFrGyDnT4sXf4SzZ0+LfjQngawtbMpNkBhIEZ15yKpKEG994AdUOiuq4/MXLqBnT0/I3FyrnaVbtz+JWur8hTC1msaSkpKGDxctosh1Urn00wxkL+R7FuVFcpUPV0G+ZCUIqqDyYsmSJcJ/qJMliz/EvXv3sHt3aLXG1Z7QvZg0aSLCw841J3J4qfZvqv+hqkHCB0P+6FAX0QuhyJKdTWXB9RtkSiOE/6hUypGmDfAaIIpOK0sr8jXF2LfvAFavXo0D+/eitLQEjb1LVsfyL8KmSmNU89Rzp/Ly8hhy1mZyEoDc3DyMHjMWqz5bqfasd+7EYcrUKcjLzRWksA8zbvxeja4lX1KOeI0axFGFzOFh3759DePi4l5RNLM50ly9eoVezeHp2avame3tWyAsLBz3ExOEI25iCV9tJZBwtOp/6let3HmZNiAgYFW3bt1iRLEqCQ/8i79vxIkTp6qdeeeuPYihTNi0eZmTqvCucrWbj/TVdQ1lMlnJmjVr/G1tbYsVW0xEy5MQFLQMN2/dlh9Ln61evRYrVwYzu001bNckvAOCH40qV/dhVSctBslk5ObmpmVlZT1ISkryUZgMmxw3yyMiIlBaUoYtW77BoUMHxCpBE8uE6yJMzi8ae4rqfpqCSZCvXpgxKevJ9OarEsjdRS5qmTBTU1M0Y+F9iEu1HaB2VcO88rrRQsgf3h+n8FPc9bO0NEIzl+9qIketD1IjnDjyWvEh/HEkFDp+JLNU0qC9fwBy+OnnSZqccn0JUhRxvJf6q2ZMDodyv9qSU1eCRFOQEECYJ7VImovw5PJTNQvr+sX6xubPCdxSvNEMyOEfY+Jtzpvr8+WGJC/80xReElkVTZAY1vA1hIFSplwrUeyI5VUdhp6OfqJrAORP7A1pIuQcg/zhuKi6fpHJ6d+/P6ge1ZwH1UPCJJPj3+/hDYsvPydi+Oe61qkrOmvtrEpKBDn+/v4NNjF1wrnSIImsPYRHz4CUHMIuyc+82hByVE1MayatA/lFAj9S83+QPxjCu6ha6uj8aZD/qBMvzRyH/HfMGkUa+1cDeCFgqwQmp5fkr9jxdZJKmJqKuSKJAF6WipbM+TLkPfRGl/8JMAB+NwUsHaskXQAAAABJRU5ErkJggg==', '1', '2019-10-04 20:32:52', NULL, 1, '1'),
(22, 6, 'Cuentas por Pagar', NULL, 'tesoreria/cuentas/listar/2', NULL, '0', '2020-02-21 16:40:45', NULL, 3, '1'),
(23, 6, 'Caja Diaria', NULL, 'tesoreria/caja/cajas', NULL, '0', '2020-02-21 16:42:15', NULL, 5, '1'),
(24, 6, 'Libro Diario', NULL, NULL, NULL, '0', '2020-02-21 16:43:01', NULL, 11, '1'),
(25, 7, 'Configuracion del sistema', NULL, 'maestros/configuracion/editar_configuracion', NULL, '0', '2020-03-11 17:43:58', NULL, 18, '1'),
(26, 7, 'Cargos', NULL, 'maestros/cargo/cargos', NULL, '0', '2020-03-11 17:41:07', NULL, 3, '1'),
(27, 7, 'Areas', NULL, 'maestros/area/areas', NULL, '0', '2020-03-11 17:41:04', NULL, 2, '1'),
(28, 7, 'Usuarios', NULL, 'seguridad/usuario/usuarios', NULL, '0', '2020-03-11 17:43:32', NULL, 13, '1'),
(29, 7, 'Establecimientos', NULL, 'maestros/establecimiento/establecimientos', NULL, '0', '2020-03-11 17:41:11', NULL, 4, '1'),
(30, 7, 'Almacenes', NULL, 'almacen/almacen/listar', NULL, '0', '2020-03-11 17:40:57', NULL, 1, '1'),
(31, 7, 'Unidad Medida', NULL, 'almacen/unidadmedida/listar', NULL, '0', '2020-03-11 17:43:05', NULL, 9, '1'),
(32, 7, 'Forma de pago', NULL, 'maestros/formapago/listar', NULL, '0', '2020-03-11 17:42:18', NULL, 5, '1'),
(33, 7, 'Fabricante', NULL, 'almacen/fabricante/listar', NULL, '0', '2020-03-11 17:42:24', NULL, 6, '1'),
(34, 7, 'Marcas', NULL, 'almacen/marca/listar', NULL, '0', '2020-03-11 17:42:54', NULL, 7, '1'),
(35, 7, 'Lí­nea', NULL, 'almacen/linea/listar', NULL, '0', '2020-03-11 17:43:00', NULL, 8, '1'),
(36, 8, 'Opciones DB', '', 'basedatos/basedatos/basedatos_principal', '', '0', '2020-03-13 21:41:20', '2020-03-13 16:41:20', 2, '1'),
(37, 3, 'Tipos de Artículo', NULL, 'almacen/tipoproducto/tipoproductos/B', NULL, '0', '2020-03-11 17:36:26', NULL, 13, '1'),
(38, 5, 'Seguimiento de O. de Compras', NULL, 'compras/ocompra/seguimiento_ocompras/0/C/1', NULL, '0', '2020-03-11 17:38:43', NULL, 2, '1'),
(39, 3, 'Stock almacen', 'Stock', 'almacen/almacenproducto/listar', 'iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAAHtpJREFUeJzNm2msrVle1n9rrXfY895nn/lOp+69desOVbe6a+oWG0x3axNDKyoEQuSLkURjjERjIolBEvoDUT4YJTFIwgc1iICCKCB02xZNNWD1UNV0zXeoO5152vPe77jW8sN6331OVZc0ICDvzck595zzDus/PM/zf9Z7BH88R+VHvv9b/u7aSuvvCMRmnGR3++Po1vb+4M5L72zfvvNouAlkf0z3+mM9xP/j+f4/+Z4X/tb1S8s/vLzQvGCxYIsLCwECsixnNE1nUZo+zDJzK0713YPe8NbD3dHtF9/evnN0NNtjftaf/vFHDYD6h9/1/N+8cX7hR5Y7tcetNQghEUoilUIqOf9FC2BtcSu3TiHcbaMks6NpMkwz826a61uzOL2z3x/feePdw1tfubf57nBIHwiKS6V/xGf9fY8/bADED/6NZ//6UxdXPnN2tf2UtSCwGG2wxmCMweSaMiDS81B+gFQSaw3WmuIq4lTOLdaCtRaLRQqBsTCaxGbnaHKw2K4mlcBfnaXpI1dB+d3+aHbr4cHozotfvXdnpx/vAPpPPAD/4Luff+ZDl1Z+6txK6wVjLC6nFotwGRYnn4UQWOvawVqLEAJjzPz/RmusMQil3HUEICQIMMYyi1LSXLPcaYAsr1s+rKskISBOtR1N40mSmvuZ1reiOLmz35vcfnd7cPvl1/bv7k0mR3yT9voDBeAHvuPpv/z8tfUfV1LdNNYSeMpVNVCreFRCn1roYazLJtYWd7VFML7xmtZYjHHVY6xBa0tu4Hg4ZbEZUvEkFhdQKSXSU0ilOGklgbHGtdOpG5TtNY1SO46S4zQ195Lc3Irj9Pbu8eju7727f+v113bu9WH4TQPwt7/9yU88f+PsZ86ttL9VSDHPoLu5xRjDLM4YTGKS3CCFQClFnufUKgFLnRrNqk+uNULI4lzK0LhqMBZtLPu9CQrL2ZXWvJq01u6eWqO1wWhX6crzkJ6H5/uurUTxXMXiTzDnNAYVyQAms0RHSbb/0tce/WPvgxb+/Z+8/m0fubr2mQtrnY9LKcAYEBIhBEI4gJOAlYpWXdJqhFjrMqO1QWvNNMl5sNNjOE3JtCHwXdXUKj4rC3UWGhUCTzKaxowmMeuLDcLQp8yKxQUTAN/De197WeMwRUjlAmPAYuY/E1IAAlECcrF4rKVRCdReb3YmSnXjPRXwfR+/8tGPPb3xmQurnU9JgdBZjjUGnedY47InPa/IQIn27nGtOZUBwBQYgMBlz1ry3DCaJeweTzjoT0lyw2OrbaI0RwiQQhIGimYtZK1bp1ULEEKgtSkSenL9DwZUl3JjClAuwLkMhFSKNM24fzAiTjVfemPr+zyA7/sLjz/zsQ8/9qMXVjt/xfOUmHeZlAjBvI+ttdiiFK0xWARSeRidIaTEGFeiQgqHXUV7SikQVoAH7XqIkoKzS02WOjWUku6hi/YwxjKNUvaOJ9zbyQh8D19JPE9Rq/gsNCqEvgQr0cV5wp6KjcBhhZIon3lSJDCaxNzb7mGka8c4Swbej/+9T37PJ5+/9HNCCJnmmuk0IUkyBz6FmClbV0oJUqJ87xTQaaQSBYW5C+dJhjXW9aUUICQWSHJDlGQ0awH1angKzyyyxHglaDVCWvUQY0yRBIHRmiw3HA0mpJnB8xSeJ5FSoI2lVQ9pVgOssWhjXPTLoFhLbzhjpz/DihON0h9nAy9P0kqAS3WlFrDcbiCUJI5TslyTZDlp5gJjjHG9ZIuyKmrFIty9lEBgCbwQa8Fog9aGTDuwFFhWOnWwljxO0TpHeR5CCrdQ6YJuEa7ypCr7CVVUQSX0oADQ8shyzWwac9yfIoQgCDyMMbTqFdr1kPubR0zSvOiYAsAtHPdmA284TUfxfp949xghBF6jSmWlg8k1fqdOsxoStD38Mz55lpNkObmxTKOEySQmTVz5nzyPqwYLGCFIjSVKc1r1gCDw5rQlPYmHj9EGrMXkuQuqlEgpsUJgjUH5PlZol80CBE/TnrXg+4q2r2jbOQyAtWRZzv3tKdNUu4QUmgQsWa7Zn+Vj73Ac9YWvwFN47TrZ8QhZDYm3DrFpRtBp0HnuClmm3YMLQSgl1UaV9W4TFXjMZq5tktwwmUTMZim5NsQFuC23qyfRN467RQFgUrkSV/4JIRnjKBWpEAisFeRphslzLGVbuFaUUqKL50IUmGgsBri900ciqIReodEEVliEgVwbE0XR2Hu03+9nswRrLZO7O1TWu2SjKf5SC2EsQbvuwM++h1kdAKU5MtNIC7UgoB7CSruGkJJca964d8i1cwtoY4iThCzXZBrGsxStTQGw0l2zlITWOqyZl6tGKAi8AGM8jNYO3bUhnUWYPEcoJ5KUp/B9nyjNubPdJ9MGaynaxlWFLbAr1zoFZt6drfGYWgUZpVTPr+DVQmYP9jBZTmNjleDMYlFxp+Ru8XDWWKwscMA6JMgyjRDuAWdJxnCSMJ4ldFpV6tUQT0kWmznGgjaQZjkGyyzOmE5jrHDZdZXqMltipZSOyooan8vtkj2EtQwnCY+Ox5hT3y8Xb061jjF2DGivNzPjSGtrj0YCownaDYKlNl6jSj6cEu/18btNlK+K61iH+sVDmFw7mivJUxR4IATGWJIs592dPvH9AwJP0WlWscDNy6soD2q+K/NOvYpZaOAHPnGSkWvDZJYQpzlJAWCUYDsfO06Q3peCR/sDBpNs/mzWOg0CYDg5hABjGQN44/F4nCovq9zYCKqeRB8Nkb5CxynZeEo+nuEfN2g9uXHSR8UN3IUsWIHEIasUJ/pcSYGnFI2Kz8Zah3rFJ80024cjtDZIKZDSLWJ0bw/pe/jtOl69Qhj6VEMf31dYY8i1YRalLjgW4tSxEwiUNby702eW6qJdTzLtKYk2loe7fc4ulzIbhLUjAA9Ip7M42ovzQBaiJxCwvNzBX+tSMRZmEcY6cJHS5UEWqZCyRP1iVihaReBoECwXL6yRJRFYR4tXN5aL84rSFeAvtbFRQjaJmL67jV+roGexq8ZaBb9Vo1oNqVYCBIIgUFghGI0jXvraA3JdMI/WIDnBLCnY3B/SbdVQUuII3GKgXwYAY+yoUw/baa6RUjKNUnYOR0gpqIY+szijuz9ECFho1ahVfJzytQ7E5tBg5/VZZkEAFz76XdDeILQR8fFD4t4jpjtvgzXzgKlGBdGokOWGWRCQZTlBu8FkliD3+jQnEQynCE8RLLXJBPjdNsYKtLUYa9yy5nR50vP1il9MsKVkFOTaDk4FgPHaUnOOwNY6UMq04bA/5dLZLoGnGM8S0iynGvpzQYHRbiawppCddo6XupDLxsIbr7/G+voZao2LrF/9ONtf+EnioweO5gBhncDyPcX6YgtjtBNIQJJpZnFG3mpgtUHPYnwh6MYp6SkgxDrNX47kxhikdOJpGqdUKwGBp5hEKYNJPDoJAHZQto02BimgFvpIT9Jt1ZDSCdV2s+r4tnxoQSFYXLSLYnCTYqEU3UyhOHvuPNPpFGMlvh9ii9HWAhiLxjiIyzOsOqEthKASeIS+KqZRgZRtstw9ZzaYYoVrwnnvF1RnLSgp0MbgKYWvnCTfPR4jRAGCALmxfa313ExAirnVJaUsxIvLkpEgSz/oNB2JAmoFjhqtwRTzgDGGX/6vv8Rit8vS8gq1egOt07komreOsEjpYa0bq33ffW3mkXJfGOMW5oJRToNlLbnECMoKdMxVKVSoNpZmNWAcpSctkOX5sAQjUY7/pVqz1nVNUdbSClxhU5S9+1n5cAjpuLfsBgvjzdf5zk9+hHEeMpqlbG0+ZCXP55K1ZA1byGgEeJ56b4BK2jsJl6tYfYL4+n3WkzagpESJkxOEEPiBx8MHB2fnAUgyPS7pw2GA6x035xcny8KI0K7nhRXzn0upEDhNX0QPIQS51k6Pv/kVuq038AWsN7s0Vi4xmg2w2kleKy2imAeNdZOhOZGexbjrvjdvsSJomXZUOJrGTKOUpXaNMvraGHxPEsc5OncZzDLD1sGIq+cXOy+++qjAgMwMt48npFnOY2sLSIHz26wAWVRDUSEI4eitMDAQlvaFp9nzLpId3aEtp6jpLiaPqVRChJL0xxG1is/RYErQm5Lcvc/51Ta+km5RznA68VbLUi6o1QDCWoR0c4EtMln+Xn8U0R9HnFtpzdvOGSnWiTQpSCI34m8djHjq4jJbh4MRRTCJk6y/0KhSC33iNCdKcwbjGG2M4/9SQxduS2l+lp/zNCKOY1691+flLcHR2l+isrhBFCdY68SIEIJMmwJkBfu9iWOaXBfjqTNHjXE9bk1Z+e6fNu5cW0ha5/Ywf47FdvXEjcbZAWnuhFGmDVJJdvZHPHVp2WFMbk9AcH846y0Pp7RrIUEheZWSREmO71uyzMndwFMEvkLKQpsXDTncepOWfIdvv/Y4WbiMbVTREydfbdHH1lpC30MpyfJClTw3aGPxEFgD2hpX3koVc0UBKciSuk91fqlALXleGKVS0h9FNOshAugPZsySzFl62rJzOObJi0uYcqSznIDg2W4t+8iNcxwOZ4wmMdZCnOV4BQUF1aAAFWdXBb4zMZQQ+J6b3HSec/f1rwLQbVWxtdCpPSHmkjnXZbbB81zP2xL8rINAkwtUgVpukHGSuaSBUtyUFItSNGsBw0lMJfSQQhCnOf1xhLUQJTlb+0M+/MQqaXriI8Z5fqIEe5N4MtvtEc4SVqSgstLBr1dACPZ6EyZxRp47S6pZ9Qm8YgYv7Cgh4Ggwc3zrqbnENRZ0rplGKZ1GZZ5Ba90egCrp1ikXoFi8BSvsHO6NORFoSImwpfgWZFlOnOZ4ylWnsZbcGGoVn+NxzMO9Ac9eXSv8wxMGSeN8OA/AaBj1LZD0xwhtmN7dof7YKvkkotGqs7S2gF+voJRkOInpF/iQ5w4PFppVVhbqWAtJlp8YqG65ZIUrnGQ5CMHO4Yj1pVaxMFGAn1tgiRElq8uin0udUmyXOGaQgizXc7FTziaeUvieoj+K+NjN804LYJHKaRqAONMnGLB5FA2ySYRNcmQtIFjvOvHhK+KdI2yeo66cw1pNLfSoV5pzcNTGstebMJ4Z8mK3p17xsVi8YnK8dGYBay2L7RpRkjONMw76Yyq+j+dJOs3KXL4qSge6wI5THsRcF5yaied7B7asOsM0SjnoT7mw2sYr1N/cQ8AxRJydEkJv7/cG1CoEa5L0cIDyPca3NglXuwTLHWqXz7i4W6eU5iNFMc6eW2nNt7q0tYynCXu9KVuHI6aR29QNfMXGapvGQp1lmMvnJNMnC8aVKbbQB7i6LTdNv/DKfZY6NVqNCisLDeoVn7xQe0mmiVLnK+4ej7m2sci93eHcXSqrstQavdGpABzuTidJlqO3jpBK4ClJ/dIZbJIhPIWVskDzQhEWQFIe82AIgQIW2zUWWlXGs5Rziw2Wuw3Gs4TN/RFxb+qMVW3pNCqcWW7OZe58x6e8sAGUawtVgOksyQo6tlw+0yXP9XzjRSDYOx5z4+IyWaYxxuLJE9wpAdBaw25/dioAs9koDQJdv3JWqVyjJ5HjWWC2fUQ2nBIstqieW/qGhZf6oDQ2SnNSWoHnSTRw+L/forLa4YKFyrkuXr2C7ysOelO2DodEiaPMNNOsLzZY7tQLMXOiDBFw/bFlksw5xFrbAodcBSml2D0ccfV8d55tYyxKCbLcMJzENOsh1hmipLNTGADEo1kc78Z5XSmB5/ksdKs0lSSImggLJk6LPrRzWrLlzDC3qJhvkQkp8KUkzzV+NSSfxOSjGdO7OzSunHVBbVS4sbqA324glZPPm/tD7u0OnIzODZ4UbKx1aNZCFjt1jLGkmXa9LJ08TnPN8WDGk5eWyTNTyGjh2sPC5v6AlW6jeFZLpo05ms3eEwBjrR3XKn7dgatg+2BIteKjhCAMffxmHTNL517ASR3MK4sSjWRhO3lKoC2kR0NndbVq0KxihUBVA5LDIXoS037mcYx2BsvZxQbnVlpgLZ5SaGO5u91jtzfFYoninEbF58JqGywcDiKOB1Oubyw7F3gOeO4ZxtOYVr2C753sTkdxFgOz0wHAWMYba+01gRs0kqTGcJpgjWU0jbl4psssTtk8GLCx1qVW8ectcKorTjS6BSUcT3cun0GPZ1ggH05JDoeEKx38bpP6lbPz35/vMBk7H2eFEFw51y2MHoHnKUbThHd3emTaMI1Trl9cKWYApyR1qaWLqdICw0lCq1FhPI0ZR+moQJiTACAYmoKKhLCEgWI1qCOV5LyUIAT1SsBSu16Mr26TwQEM85HZClvM6RAEHqNJTHI0wqaZ8xuXO0hfYeMMir1GN0BaJG4Ik1I5sDKFySJO/MYsd1T89KUVrLaEnuTe5nFhvIj5MFTubQa+IknzecImUYYSYlIue75TmOZmkOcaXbywYIyjJK2dI2uKYcSUbkvBxa7/i/eDbLE/b818Oz3XBv/8Ms1r55HVgHwS4TXrJL0x6WDK+O1HRFuH86GGU1trJeboYmCyRZYtpaorhrRygizqv9xTKIHVAr5y+w3NWojy1OvluucVkOe6r7V7sUAIMIWqOtkALR5NOC0mKUSJOe24lw3oTBMp3d7+w1HswLBep9Oq4lUCapfX0eMIVQnI+hOq55cLW53CSHGVWDJM6WeWw1VpjphTt7XWzM2ZEgaULHe5HZPkWt/9td9+++8Xa9fzAExmyXiaZAgg9D13spJOkFhHaw78yiy73Vxr3BAjBHPRUSoliZOqldAjqPgYazkeTBlOIqQQyDCkXa8QdhrkuXGqbW73OESYM04pxOa2lxuY0kyfsstOvpSFhScKNoiSjDQzO7/yO299z6Oj2biofjMPQJLlo0f7Q5I059LZLp50Lycp6YBHFpGUwr3sIK1Fakd3WMvKs3+No+17hPEeenqEEMpF3FgeW1+YK7DRzG2794Yz6tWAw/6EpU6d4WTAJEpZW2yy3KnPrfYSU0qjpMRbYy02zyn8ebYPR6x2G0WixalzwGiLlVb/j9+9/U/fejjsAdWiePJ5AHrDaFCvOVNhvzdBFdls1kJqVd95a0riFS2ipHs5QRqBFJZINPjC2z2UqnH14ke51EwRw5fJtS326VxGW/UQKWBloY4UgjQ31CqBs+PEyd69AMzcC7Tzki8lslOfkjTXHPUn+J4qfub639oTDKtVfL58Z1+FjcpPfeszj90+HEx/9Nb9w98CsnkAjpIsnGwdM4syQk/RbVZo1kJGs4RK4EZgv3hNpRK4aUspOQ9E7yv/iU9dv0rfNBjqkDho4SlJpjV5sX9YagRTCBIKk0WfwpH5i1hlGwgxfyHqNN9K3O+Np27XuVmvUJAY1lomUYoUFiGwdw9GzLJctGpBWK8Fl7/y+qMVoAlMPYDv/fYrH/qB7/7wP5JBjUdbPe5vD9jdH3F4OCbPcgIpWGxVaVQDqhUfT0rq1YDQdwHxlUTKjMM3v+R6vlIhi86SZoY0y8m1RtrCAJFynlGL210WBY5YIRwFFm95ueHFzD0+rMUUeGalmQNkoxYQJRnGWCqhz2F/WnSG4O7u0H7x9x7ljZpvu61a+uKX7n0+yc0u4ANCAeLNd3tHP/2LX/s3Xp79zre9cOmpj330yuqzNy9w7co6a2tdpCfpT1MOhxE7R2P6o4hpnBY7t3ruI/aGzoVJsxxfpAgheLDTZ3WhPjcjHFXCvEEpXq48rS3n9vcJIdry+6ekt1KSh7sDothZ7GGgUFLSG0fUKz63dwbc3x+Kbrum1pda8tW3N/9XfxT/HLADDICJV6ChD9if/KWvvfrpTz3z8Iryb375zUc82D7msfUun/jzV2m3ahz3p2zt9Xm0dczW3pAHR1PSZIAvBUutKq16SJK7Kcz3FEHgzV9WUFJwYbXtaElalLUo4d4QkcUQJWQBrgWHy4KCpQoIGx2y8QEIiRYCpSRGW7LckOaaMPCQQiIQLLZqDKJUHwxn+WKnJs6tdbwvf/3hW4f96NeBPWACJCULlFZ79RPPP/bDR73xd0ynEb4n2dob8to7O+b2wyPTrIfq6avr4omNZV740Abf+akWx4MZu4cj7j84ZHN3wL2jMXmmCYSgN4poNUIOelMWmlWyXHM4mOIp5ba6AoVfvNWhBMVWuQuGEAYpZCEUJbWlDXrt5xnauyz6M2rpAXp2jBf6ZHnuXOeyqAREWc6X39lTzVpFSSHNr/7mm79XZP4WMMbNASmFDhCA/LEf/Is/s3s0/UR/MGUwTskyzVFvytdv74pZlNqd/VF8f6tnl7tNsbT4jr/UqavHziyIcysNnr95jk9/8jr9YcTO4YiH20O29wbcO5zQj1LefHDIQqNCpg31SoAxlnYjJCy2q+oVn0rgFfZ5yTCmoGFLPB1ivQMOhin3xlMWlzb4c09+lOk7v4EuKMNVgkFKab7+8FgsdetCSMFsmgz6o/g3gK/j3g+eABHuDzhsGYDgc7977/DGldVDi1i482BXDWeZGE4TVhebItPGl0L4SgpybczW7iB75+5++hXfs0uLDbHYuRMsdurqzFJDnF9t8fyNNT798asMxgnb+wPuPTxmc+eYh0djslSjhGChEbLQqlKv+AyUxFNyvglaDQMqoVewjCA92EQdbvF42KB19TpDW8HkKVI4j09JyTRJaTYqfPaVB2ztD7Nq6Jlq6I9eeXP7vwEvAyNgWmQ/LgMgiv4PgBawBnxopVv/yDPXzj57/fGVq49vrDQa9Yo66E/F1naP/eMxUZLPd4fSNDf90SwbTWId+J5d7NTkQrvi/8Q/+24lrBGbu31q1YBGLaA3jNjZH/Bg85jtgwmDUUySZHjgAtKsuWqoePhSUq+GBL6jX18J9ntTAk9Rr/osL9QJA4/PvXyHTBuUknzh9S2G05Rq6LHabaT/5fOv/Qet7a8CB0UAyuzHZRAEoAoMUDh9HAAhUANWgKc3znReePqJ9eeevHrm8vVLazWlhNo5HLG55QIyi1J0MYVFSWaOe9PsF/7l93udZkW9+NUHvPLGFmmaISVc3ejyzM0LXDi7RG8Us30w5uFmj83dPr3+hDhKEMbSbYR0WzXqVZ9a6DOLU8LAI/Dcu8Qr3TqVwOPFr9wlDD1eemM73evPOLPSVu1GKH79t97+/H5/+u+Bh6dKf1aAX1piwHzPpQiCeN9nVXyEQAM4Azx3ZWPphaefWH/25vWzG5fPLVSwVm7ujXj34RH7vQnDccS/+qG/SrMe8PLrW3zxq/f44iv3s1mU6OVuXawutbylTl1evrAkHjvb5ca1c6ytdBiMIjZ3+zzaPObR9jHH/QlpkoExdOshi+0ajaprj+WOG6xeu7XN7b0RL7+1jaekyTMdvXZ397ezzPxn4E5Bd+P3LT7D/ZWJ+QZj531fn/6QpyizglNSj3lSPn/t8vILTz2+9szNa2fOnF1pBcejRF69sMBCzedLb+7wH3/1a4AlDDyssWYSpVmUZDr0FauLTbG62AgWOnV5fr0rzq8vcP3KGVZXWhwcDNnvTXi4ecTm9oDjwZQ0ThHWcHaxwYevrPH5V+/z+oMjsNBpVdk/Gt368htb/xp4q8h8ufj4/YsvMeCbHeIDPpfB8IqAVIEO8Ljvixc+9MTZ525cXn368sbSSrdd9cfTWBwejdg9HDOaJuS6+JsiIUiyXA/GUTaNMl0LA7uy3FBLnXpQrwbyzEpLXFjr8qmP38BoS38UsX/oGObgaMxkEpmf+ZVX0no9tBfWFqSxpv/Z37n9U8BvA72i7CfvW3xeLv79Gf+DHqcDcToYihNAbQBd4Eq96j938/HV565dXr5x84n17vJC3ZvMUrF9OGFrd8i4mA7LnaRZlOr+cJpNo0xXAo+Fdl399Ge+K2h36vL+Zo+j4ykb5xfpT2J+6J//MtZaqqFnx7P0wVff3P7ZYvFHuMyXqJ8VASgzb96/mD/q8fsF4zSo1oAF4Ea7Eb7woSfWn3/yidVrT18711pebKn+KBb3No/Z3u0xmiQkae62w7VhOI70v/ux7xULjUDe2RnxuS++w/bewD7aGxIEnsjzjE69kvzaF2/9bJzqXwL2OaG8iG/M/HscnA/8k5k/xGFPfRbM3xIi5734McRR0Z3hJPnsS68+qL306oNl+NLTq0vNj3746vqzN66sX/n4tzxRb1RDtXc0EncfHrK50yfNtJrNEnwpiKOMw96EL776IMszrRuN0Fw82+U3v/rgxTjVnwUOOcn8N118mbk/qeP9gArvZZgSUE8zzDMX1tsvPH3lzLPXr6xdfOLiaiXNtDq/2qRdVdzd6vNvf/5LKCWphj7rSw37i59//ReSVP934F2KAYf3Ll4XH6d8ow9+yD+N4/cDVIVrlwrQBi4Azz5+YfG5m1fWP3z5wvK5C2c6YeB78ngwYTRJ+Pzv3n7tlbe2fgL4Gg70pjiqK7NeLvwDF3/6Qf5/Hh9EtSV+lIKsA2x4Uj5z9dLyM089vnYz1yb9xf/5+r8AXsJlPuVk0WW5/18Xfvrmf5aODwpGSbenQTXALXCEozjDexf9TRd++oZ/Fo/3s8vpDzhZ5Puz/AdeeHn8H3u2bus1x2azAAAAAElFTkSuQmCC', '1', '2020-03-11 17:32:30', NULL, 3, '1'),
(40, 3, 'Kardex producto', '', 'almacen/kardex/listar', '', '0', '2020-03-13 22:25:48', '2020-03-13 17:25:48', 4, '1');
INSERT INTO `cji_menu` (`MENU_Codigo`, `MENU_Codigo_Padre`, `MENU_Descripcion`, `MENU_Titulo`, `MENU_Url`, `MENU_Icon`, `MENU_AccesoRapido`, `MENU_FechaRegistro`, `MENU_FechaModificacion`, `MENU_OrderBy`, `MENU_FlagEstado`) VALUES
(42, 9, 'Almacén', NULL, NULL, NULL, '0', '2019-08-31 18:41:03', NULL, 0, '1'),
(43, 9, 'Reporte de Venta Productos', '', 'reportes/ventas/reportes/V', '', '0', '2022-07-27 22:35:30', '2022-07-27 17:35:30', 0, '1'),
(44, 9, 'Reporte de Compra Productos', NULL, 'reportes/ventas/reportes/C', NULL, '0', '2022-11-15 14:24:15', NULL, 0, '1'),
(45, 9, 'Tesorería', NULL, NULL, NULL, '0', '2019-08-31 18:41:03', NULL, 0, '1'),
(46, 7, 'Categorias de Precio', '', 'ventas/tipocliente/', '', '0', '2021-09-17 21:20:40', '2021-09-17 16:20:40', 3, '1'),
(47, 2, 'Personas', NULL, 'maestros/persona/personas', NULL, '0', '2020-03-11 17:30:50', NULL, 5, '1'),
(48, 2, 'Empresas', NULL, 'maestros/empresa/empresas', NULL, '0', '2020-03-11 17:30:38', NULL, 2, '1'),
(49, 7, 'Roles', NULL, 'seguridad/rol/listar', NULL, '0', '2020-03-11 17:43:23', NULL, 12, '1'),
(50, 6, 'Tipo de Cambio Divisa', NULL, 'maestros/tipocambio/listar', NULL, '0', '2020-02-21 16:43:04', NULL, 12, '1'),
(51, 7, 'Proyectos', '', 'maestros/proyecto/', '', '0', '2020-03-17 00:41:55', '2020-03-16 19:41:55', 11, '1'),
(52, 4, 'Boletas', 'Venta<br>Boletas', 'ventas/comprobante/comprobantes/V/B', 'iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAgRQTFRFAAAAUVFRUlJSU1NTS0tLQUFBPz8/Ojo6NDQ0MjIyMzMzPT09TExMT09PTU1NOTk5CQkJUlJSUlJSUlJSUlJSUVFRUlJSUlJSUlJSUlJSUlJSUlJSUVFRUlJSUlJSUlJSUlJSUlJSUlJSUlJSUVFRUlJSUlJSUVFRU1NTSkpKS0tLVFRUS0tLQkJCQ0NDTk5OUlJSQUFBPz8/QUFBUFBQUlJSPz8/Q0NDPj4+QEBAOTk5Ojo6Ojo6NDQ0NDQ0MjIyMTExMzMzPT09MDAwPT09PDw8TExMTk5OT09PT09PTU1NT09POjo6TExMS0tLOTk5AAAAPT09Tk5OOTk5AAAAAAAADQ0NQ0NDTk5OQUFBDAwMAAAADQ0NNzc3SUlJTU1NTU1NSUlJNjY2DAwMAAAAAAAAAAAAAQEBDw8PHR0dICAgHR0dDg4OAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUlJSUVFRUFBQS0tLREREQkJCQUFBR0dHQEBAPz8/SEhITk5OPj4+RkZGT09PRUVFfHx8tbW1xsbGycnJs7Ozd3d3Q0NDmZmZ2NjY3t7e3d3d1tbWk5OT3NzccXFxPT09sLCwOjo6NTU1NDQ0MjIyxcXFODg4MTExyMjIMDAwMzMzubm5zMzMy8vLTExMXV1dYGBgPDw8////Nvf8NwAAAHl0Uk5TAAAAAAAAAAAAAAAAAAAAAAAMGx4LCmXB3OG+WwiT9/WKCvZTDMC44R7h4R4e4eQ5HR7h++TgHuHhHuHhHuEe4R7h4R4eHh7hHuEb3A/EvQ4FdfZrBAYzofeWMis6dMbj58NxOQImMzE8SUtIOzEkEjIPGzQZECUsLevG9TMAAAABYktHRKvJAWcoAAAACXBIWXMAAOw4AADsOAFxK8o4AAACsUlEQVR42u3V6VcSURjA4YFUXNIM1Gi13TRbpLIsF2xxbSGLNitbiFYMszIQEGFmQKVMMJpkxg0t669sJo8nO6eZueO5t/zw/j7Pue9z7rm8UBQEQRAEQRC0qtLp1htNqhmLdDoy8/XFJRvMG1Uzb9q8hYhAV7x1mwep0u079ATmrynZiTZfFOzS478D3e49Ho+3HyGvx7O3CP8V6I1mr88fGFAt4Pd5zUYCAFNZcDCE1GC4zEQAsK8ccb4oqNiPH5BReQB1fih08NBh9YWhcX9kVlnQAUeOHlNfGBr3R1a1BsBAP+ovFn1//AOA8v7QBqBRFoa2/aEJEFJfF5r3hzbAilLeH38CGIwtEyjtj+UAhl3ZI/trEfY34XhlBgKAiQ4Nj8SwNfL+w+gSwVKViQCIfhyLJzAWH//kXwJUZ6kDmKGxRBJrifHPHCKAYTguOhzHOz+ZjH/xc5z0GtUAEymeF6KTmC9ABExGBZ5PTagATkwJYtPsDHZAYoadls6eUgTUnJS+EWbZGNYn+OsZxthZ6ez0qRp5gKG2TvwileKDc/NfMTc/F+RTqbQg1NUaZAHZ9Q1pLuz75qMXvmNvgRYPDv9IN9RnywJyrI2jdESKJtDiwYFGa44sINdqWfyMYPTpM7mygLyzFaTnRyLl5/JkAWubmskDmpvk/4zyW1rJA1pb8gEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgNULKGhrJw9obyuQBRjOXyAPuHhpnSyg0Ha5g/T8jitXC2UBlP3a9RuE59+8ZZefT9k6b9+523WPWF33HzzstCkAHI+cj588fUas5y9czm6HAoB66XK63S5iud1OV4/SfMrxytXrJFiv67XiBYiCN2/73hGrr7tHZb5EsNmJZVMfD0EQBEHQf+gn1q7eiRaKMMYAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTgtMDMtMjNUMTg6NDI6MjQrMDE6MDDgbg78AAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE4LTAzLTIzVDE4OjQyOjI0KzAxOjAwkTO2QAAAAEZ0RVh0c29mdHdhcmUASW1hZ2VNYWdpY2sgNi43LjgtOSAyMDE2LTA2LTE2IFExNiBodHRwOi8vd3d3LmltYWdlbWFnaWNrLm9yZ+a/NLYAAAAYdEVYdFRodW1iOjpEb2N1bWVudDo6UGFnZXMAMaf/uy8AAAAYdEVYdFRodW1iOjpJbWFnZTo6aGVpZ2h0ADUxMsDQUFEAAAAXdEVYdFRodW1iOjpJbWFnZTo6V2lkdGgANTEyHHwD3AAAABl0RVh0VGh1bWI6Ok1pbWV0eXBlAGltYWdlL3BuZz+yVk4AAAAXdEVYdFRodW1iOjpNVGltZQAxNTIxODI2OTQ0APj7LAAAABN0RVh0VGh1bWI6OlNpemUANS42NEtCQoAMxlUAAABBdEVYdFRodW1iOjpVUkkAZmlsZTovLy4vdXBsb2Fkcy81Ni9Qb0lPSGdBLzEzNzkvZm9sZGVyYmxhY2tfOTMwOTkucG5nhvnUFwAAAABJRU5ErkJggg==', '1', '2020-02-15 17:58:38', NULL, 7, '1'),
(53, 4, 'Nota de Venta', 'Nota de Venta', 'ventas/comprobante/comprobantes/V/N', 'iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAgRQTFRFAAAAUVFRUlJSU1NTS0tLQUFBPz8/Ojo6NDQ0MjIyMzMzPT09TExMT09PTU1NOTk5CQkJUlJSUlJSUlJSUlJSUVFRUlJSUlJSUlJSUlJSUlJSUlJSUVFRUlJSUlJSUlJSUlJSUlJSUlJSUlJSUVFRUlJSUlJSUVFRU1NTSkpKS0tLVFRUS0tLQkJCQ0NDTk5OUlJSQUFBPz8/QUFBUFBQUlJSPz8/Q0NDPj4+QEBAOTk5Ojo6Ojo6NDQ0NDQ0MjIyMTExMzMzPT09MDAwPT09PDw8TExMTk5OT09PT09PTU1NT09POjo6TExMS0tLOTk5AAAAPT09Tk5OOTk5AAAAAAAADQ0NQ0NDTk5OQUFBDAwMAAAADQ0NNzc3SUlJTU1NTU1NSUlJNjY2DAwMAAAAAAAAAAAAAQEBDw8PHR0dICAgHR0dDg4OAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUlJSUVFRUFBQS0tLREREQkJCQUFBR0dHQEBAPz8/SEhITk5OPj4+RkZGT09PRUVFfHx8tbW1xsbGycnJs7Ozd3d3Q0NDmZmZ2NjY3t7e3d3d1tbWk5OT3NzccXFxPT09sLCwOjo6NTU1NDQ0MjIyxcXFODg4MTExyMjIMDAwMzMzubm5zMzMy8vLTExMXV1dYGBgPDw8////Nvf8NwAAAHl0Uk5TAAAAAAAAAAAAAAAAAAAAAAAMGx4LCmXB3OG+WwiT9/WKCvZTDMC44R7h4R4e4eQ5HR7h++TgHuHhHuHhHuEe4R7h4R4eHh7hHuEb3A/EvQ4FdfZrBAYzofeWMis6dMbj58NxOQImMzE8SUtIOzEkEjIPGzQZECUsLevG9TMAAAABYktHRKvJAWcoAAAACXBIWXMAAOw4AADsOAFxK8o4AAACsUlEQVR42u3V6VcSURjA4YFUXNIM1Gi13TRbpLIsF2xxbSGLNitbiFYMszIQEGFmQKVMMJpkxg0t669sJo8nO6eZueO5t/zw/j7Pue9z7rm8UBQEQRAEQRC0qtLp1htNqhmLdDoy8/XFJRvMG1Uzb9q8hYhAV7x1mwep0u079ATmrynZiTZfFOzS478D3e49Ho+3HyGvx7O3CP8V6I1mr88fGFAt4Pd5zUYCAFNZcDCE1GC4zEQAsK8ccb4oqNiPH5BReQB1fih08NBh9YWhcX9kVlnQAUeOHlNfGBr3R1a1BsBAP+ovFn1//AOA8v7QBqBRFoa2/aEJEFJfF5r3hzbAilLeH38CGIwtEyjtj+UAhl3ZI/trEfY34XhlBgKAiQ4Nj8SwNfL+w+gSwVKViQCIfhyLJzAWH//kXwJUZ6kDmKGxRBJrifHPHCKAYTguOhzHOz+ZjH/xc5z0GtUAEymeF6KTmC9ABExGBZ5PTagATkwJYtPsDHZAYoadls6eUgTUnJS+EWbZGNYn+OsZxthZ6ez0qRp5gKG2TvwileKDc/NfMTc/F+RTqbQg1NUaZAHZ9Q1pLuz75qMXvmNvgRYPDv9IN9RnywJyrI2jdESKJtDiwYFGa44sINdqWfyMYPTpM7mygLyzFaTnRyLl5/JkAWubmskDmpvk/4zyW1rJA1pb8gEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgNULKGhrJw9obyuQBRjOXyAPuHhpnSyg0Ha5g/T8jitXC2UBlP3a9RuE59+8ZZefT9k6b9+523WPWF33HzzstCkAHI+cj588fUas5y9czm6HAoB66XK63S5iud1OV4/SfMrxytXrJFiv67XiBYiCN2/73hGrr7tHZb5EsNmJZVMfD0EQBEHQf+gn1q7eiRaKMMYAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTgtMDMtMjNUMTg6NDI6MjQrMDE6MDDgbg78AAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE4LTAzLTIzVDE4OjQyOjI0KzAxOjAwkTO2QAAAAEZ0RVh0c29mdHdhcmUASW1hZ2VNYWdpY2sgNi43LjgtOSAyMDE2LTA2LTE2IFExNiBodHRwOi8vd3d3LmltYWdlbWFnaWNrLm9yZ+a/NLYAAAAYdEVYdFRodW1iOjpEb2N1bWVudDo6UGFnZXMAMaf/uy8AAAAYdEVYdFRodW1iOjpJbWFnZTo6aGVpZ2h0ADUxMsDQUFEAAAAXdEVYdFRodW1iOjpJbWFnZTo6V2lkdGgANTEyHHwD3AAAABl0RVh0VGh1bWI6Ok1pbWV0eXBlAGltYWdlL3BuZz+yVk4AAAAXdEVYdFRodW1iOjpNVGltZQAxNTIxODI2OTQ0APj7LAAAABN0RVh0VGh1bWI6OlNpemUANS42NEtCQoAMxlUAAABBdEVYdFRodW1iOjpVUkkAZmlsZTovLy4vdXBsb2Fkcy81Ni9Qb0lPSGdBLzEzNzkvZm9sZGVyYmxhY2tfOTMwOTkucG5nhvnUFwAAAABJRU5ErkJggg==', '1', '2022-08-05 21:15:41', '2022-08-05 16:15:41', 8, '1'),
(54, 5, 'Facturas', NULL, 'ventas/comprobante/comprobantes/C/F', NULL, '0', '2020-03-11 17:38:58', NULL, 5, '1'),
(55, 5, 'Boletas', NULL, 'ventas/comprobante/comprobantes/C/B', NULL, '0', '2020-03-11 17:39:02', NULL, 6, '1'),
(56, 5, 'Nota de Ingreso', '', 'ventas/comprobante/comprobantes/C/N', '', '0', '2022-08-05 21:16:01', '2022-08-05 16:16:01', 7, '1'),
(57, 4, 'Cotización', 'Venta<br>Cotización', 'compras/ocompra/ocompras/V', 'iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAMAAAD04JH5AAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAgRQTFRFAAAAUVFRUlJSU1NTS0tLQUFBPz8/Ojo6NDQ0MjIyMzMzPT09TExMT09PTU1NOTk5CQkJUlJSUlJSUlJSUlJSUVFRUlJSUlJSUlJSUlJSUlJSUlJSUVFRUlJSUlJSUlJSUlJSUlJSUlJSUlJSUVFRUlJSUlJSUVFRU1NTSkpKS0tLVFRUS0tLQkJCQ0NDTk5OUlJSQUFBPz8/QUFBUFBQUlJSPz8/Q0NDPj4+QEBAOTk5Ojo6Ojo6NDQ0NDQ0MjIyMTExMzMzPT09MDAwPT09PDw8TExMTk5OT09PT09PTU1NT09POjo6TExMS0tLOTk5AAAAPT09Tk5OOTk5AAAAAAAADQ0NQ0NDTk5OQUFBDAwMAAAADQ0NNzc3SUlJTU1NTU1NSUlJNjY2DAwMAAAAAAAAAAAAAQEBDw8PHR0dICAgHR0dDg4OAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAUlJSUVFRUFBQS0tLREREQkJCQUFBR0dHQEBAPz8/SEhITk5OPj4+RkZGT09PRUVFfHx8tbW1xsbGycnJs7Ozd3d3Q0NDmZmZ2NjY3t7e3d3d1tbWk5OT3NzccXFxPT09sLCwOjo6NTU1NDQ0MjIyxcXFODg4MTExyMjIMDAwMzMzubm5zMzMy8vLTExMXV1dYGBgPDw8////Nvf8NwAAAHl0Uk5TAAAAAAAAAAAAAAAAAAAAAAAMGx4LCmXB3OG+WwiT9/WKCvZTDMC44R7h4R4e4eQ5HR7h++TgHuHhHuHhHuEe4R7h4R4eHh7hHuEb3A/EvQ4FdfZrBAYzofeWMis6dMbj58NxOQImMzE8SUtIOzEkEjIPGzQZECUsLevG9TMAAAABYktHRKvJAWcoAAAACXBIWXMAAOw4AADsOAFxK8o4AAACsUlEQVR42u3V6VcSURjA4YFUXNIM1Gi13TRbpLIsF2xxbSGLNitbiFYMszIQEGFmQKVMMJpkxg0t669sJo8nO6eZueO5t/zw/j7Pue9z7rm8UBQEQRAEQRC0qtLp1htNqhmLdDoy8/XFJRvMG1Uzb9q8hYhAV7x1mwep0u079ATmrynZiTZfFOzS478D3e49Ho+3HyGvx7O3CP8V6I1mr88fGFAt4Pd5zUYCAFNZcDCE1GC4zEQAsK8ccb4oqNiPH5BReQB1fih08NBh9YWhcX9kVlnQAUeOHlNfGBr3R1a1BsBAP+ovFn1//AOA8v7QBqBRFoa2/aEJEFJfF5r3hzbAilLeH38CGIwtEyjtj+UAhl3ZI/trEfY34XhlBgKAiQ4Nj8SwNfL+w+gSwVKViQCIfhyLJzAWH//kXwJUZ6kDmKGxRBJrifHPHCKAYTguOhzHOz+ZjH/xc5z0GtUAEymeF6KTmC9ABExGBZ5PTagATkwJYtPsDHZAYoadls6eUgTUnJS+EWbZGNYn+OsZxthZ6ez0qRp5gKG2TvwileKDc/NfMTc/F+RTqbQg1NUaZAHZ9Q1pLuz75qMXvmNvgRYPDv9IN9RnywJyrI2jdESKJtDiwYFGa44sINdqWfyMYPTpM7mygLyzFaTnRyLl5/JkAWubmskDmpvk/4zyW1rJA1pb8gEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgNULKGhrJw9obyuQBRjOXyAPuHhpnSyg0Ha5g/T8jitXC2UBlP3a9RuE59+8ZZefT9k6b9+523WPWF33HzzstCkAHI+cj588fUas5y9czm6HAoB66XK63S5iud1OV4/SfMrxytXrJFiv67XiBYiCN2/73hGrr7tHZb5EsNmJZVMfD0EQBEHQf+gn1q7eiRaKMMYAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTgtMDMtMjNUMTg6NDI6MjQrMDE6MDDgbg78AAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE4LTAzLTIzVDE4OjQyOjI0KzAxOjAwkTO2QAAAAEZ0RVh0c29mdHdhcmUASW1hZ2VNYWdpY2sgNi43LjgtOSAyMDE2LTA2LTE2IFExNiBodHRwOi8vd3d3LmltYWdlbWFnaWNrLm9yZ+a/NLYAAAAYdEVYdFRodW1iOjpEb2N1bWVudDo6UGFnZXMAMaf/uy8AAAAYdEVYdFRodW1iOjpJbWFnZTo6aGVpZ2h0ADUxMsDQUFEAAAAXdEVYdFRodW1iOjpJbWFnZTo6V2lkdGgANTEyHHwD3AAAABl0RVh0VGh1bWI6Ok1pbWV0eXBlAGltYWdlL3BuZz+yVk4AAAAXdEVYdFRodW1iOjpNVGltZQAxNTIxODI2OTQ0APj7LAAAABN0RVh0VGh1bWI6OlNpemUANS42NEtCQoAMxlUAAABBdEVYdFRodW1iOjpVUkkAZmlsZTovLy4vdXBsb2Fkcy81Ni9Qb0lPSGdBLzEzNzkvZm9sZGVyYmxhY2tfOTMwOTkucG5nhvnUFwAAAABJRU5ErkJggg==', '1', '2020-09-21 15:08:50', '2020-09-21 10:08:50', 1, '1'),
(58, 5, 'Guía de  Remisión Compra', NULL, 'almacen/guiarem/listar/C', NULL, '0', '2020-03-11 17:38:49', NULL, 3, '1'),
(59, 5, 'Tipos de Proveedor', NULL, 'almacen/tipoproveedor/familias', NULL, '0', '2020-03-11 17:39:10', NULL, 8, '1'),
(60, 4, 'Seguimiento de Cotizaciones', NULL, 'compras/ocompra/seguimiento_ocompras/0/V/1', NULL, '0', '2020-02-15 17:57:36', NULL, 2, '1'),
(61, 4, 'Órdenes de Pedidos', NULL, 'compras/pedido/pedidos', NULL, '0', '2020-02-15 17:58:24', NULL, 4, '1'),
(62, 5, 'Cotizaciones', NULL, 'compras/presupuesto/presupuestos', NULL, '0', '2019-08-31 18:41:03', NULL, 9, '1'),
(63, 5, 'Cuadros Comparativos', NULL, 'compras/cuadrocom/cuadros', NULL, '0', '2019-08-31 18:41:03', NULL, 10, '1'),
(64, 3, 'Servicios', NULL, 'almacen/producto/productos/S', NULL, '0', '2020-03-11 17:34:27', NULL, 5, '1'),
(65, 3, 'Tipo de Servicio', NULL, 'almacen/tipoproducto/tipoproductos/S', NULL, '0', '2020-03-11 17:34:35', NULL, 7, '1'),
(66, 3, 'Familias de Servicios', NULL, 'almacen/familia/familias/S', NULL, '0', '2020-03-11 17:34:30', NULL, 6, '1'),
(67, 9, 'Ventas por Vendedor', NULL, 'reportes/ventas/filtroVendedor', NULL, '0', '2019-05-27 18:18:53', NULL, 0, '1'),
(68, 9, 'Ventas por Marcas', NULL, 'reportes/ventas/filtroMarca', NULL, '0', '2019-12-03 14:39:47', NULL, 0, '1'),
(69, 9, 'Ventas por Familia', NULL, 'reportes/ventas/filtroFamilia', NULL, '0', '2019-08-31 18:41:03', NULL, 0, '1'),
(70, 9, 'Ventas Diarias', NULL, 'reportes/ventas/filtroDiario', NULL, '0', '2017-02-13 23:45:08', NULL, 0, '1'),
(71, 3, 'Stock General', NULL, 'almacen/almacenproducto/listar_general', NULL, '0', '2020-03-11 17:35:12', NULL, 9, '1'),
(72, 6, 'Cheques', NULL, 'tesoreria/cheque/listar/', NULL, '0', '2020-02-21 16:42:56', NULL, 10, '1'),
(73, 9, 'Planilla Cobranza', NULL, 'reportes/cobros/planilla', NULL, '0', '2019-08-31 18:41:03', NULL, 0, '1'),
(74, 3, 'G. Transferencia', NULL, 'almacen/guiatrans/listar	', NULL, '0', '2020-03-11 17:34:59', NULL, 8, '1'),
(75, 9, 'Reporte de Ganancias', NULL, 'reportes/ventas/ganancia', NULL, '0', '2020-03-13 22:11:13', NULL, 0, '1'),
(76, 3, 'Artí­culos - Precio de Venta', NULL, 'almacen/producto/productos_precios', NULL, '0', '2020-03-11 17:36:21', NULL, 12, '1'),
(77, 9, 'Estado de Cuenta', NULL, 'reportes/ventas/estado_cuenta	', NULL, '0', '2019-08-31 18:41:03', NULL, 0, '1'),
(78, 3, 'Envio Proveedor', NULL, 'almacen/envioproveedor/listar ', NULL, '0', '2020-03-11 17:36:41', NULL, 16, '1'),
(79, 3, 'Recepcion Proveedor', NULL, 'almacen/recepcionproveedor/listar  ', NULL, '0', '2019-11-14 16:09:29', NULL, 20, '1'),
(80, 3, 'Entrega Cliente', NULL, 'almacen/entregacliente/listar  ', NULL, '0', '2019-11-14 16:09:35', NULL, 21, '1'),
(81, 3, 'Garantia', NULL, 'almacen/garantia/listar  ', NULL, '0', '2020-03-11 17:36:13', NULL, 11, '1'),
(82, 4, 'Nota de Credito', NULL, 'ventas/notacredito/comprobantes/V/C', NULL, '0', '2020-02-15 17:59:10', NULL, 10, '1'),
(83, 5, 'Nota de Credito', NULL, 'ventas/notacredito/comprobantes/C/C', NULL, '0', '2019-06-27 16:47:18', NULL, 11, '1'),
(84, 7, 'Usuarios Web', NULL, 'seguridad/impactousuario/listar', NULL, '0', '2020-03-11 17:43:43', NULL, 14, '1'),
(85, 9, 'Valorizacion Actual', NULL, 'reportes/valorizacion/valor', NULL, '0', '2019-08-31 18:41:03', NULL, 0, '1'),
(86, 9, 'Reporte de Ventas', NULL, 'reportes/rventas/reporte_ventas', NULL, '0', '2019-08-31 18:41:03', NULL, 0, '1'),
(87, 2, 'Personal', NULL, 'maestros/directivo/directivos', NULL, '0', '2020-03-11 17:30:29', NULL, 4, '1'),
(88, 9, 'Valorizacion x Producto', NULL, 'reportes/valorizacion/valorizacion_producto', NULL, '0', '2019-08-31 18:41:03', NULL, 0, '1'),
(89, 9, 'Ventas del dia', NULL, 'reportes/ventas/ventasdiario', NULL, '0', '2013-04-08 22:41:41', NULL, 0, '1'),
(90, 3, 'Ingreso de Inventario', NULL, 'almacen/inventario/listar', NULL, '0', '2020-03-11 17:35:28', NULL, 10, '1'),
(93, 0, 'Contabilidad', NULL, '', 'iVBORw0KGgoAAAANSUhEUgAAAC8AAAAwCAYAAACBpyPiAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAABGJJREFUaIHlmk9sFHUUxz/fma0FSkzBYoxyoqXGEm0nRUKHRD14IJGEmKiwRRMTFBKjRw96M1FPagwcTECjidryJxo56U05bCFK2aqIQjDRwEHjxajIv+58PdTilu5uZ6YDkvC97Zv3fu+T2d97vzezK+ZQFJfPSLpjLr9rLZtaKaXjacOnVxsorYQfAHWnggeOT4yNbL+aQFkUxeX3gNTwLbUq3tTdTri3iLUA0OSzRyv7Ds/lVgh8aC8kYNDmtOVf864ja6nEipp1cxr/QuD/k9+cqIy+kTc6ijdtgnBPWv9C4W09MhBv7s2/QtCdxbsQeAWBbS5KDEIwOJ+1bC6qJqfxLQT+68qe7wYHBxcXsRbA+Pj4ZBq/tPDL++PNT7dySJUtpfrjlS2v2+6VlA5eYlVIsKsQsiKkqRM2+L855qPMe952IlRN7Y+7JXVOxVJD/lZWLVNOuVNoVifKU7Dnj46N3Auk6gjRUPkTxMZ/MT6oVkafzJ7y0TCK236R6Kq35u42A2vL9xNouLmHJybGRt+qtwg2RnH5bZPtzoO7wLeAZljzt8qAvkBsa5ou4QAwAx6pU7BVjUNaqHHEjVWw85L9u+Ej44zHgpYJHpY04yu4pvCGA9Wx0aeyR04VLBRUsPmkx6Ohcr+DbAeyYImuAIdrDC8RIg1kL9jGukELdnLyIGFb0+faRMlPV9qMf7R5Pch4wiJ3GV6SNIM3N/zEl/uPA8czBSUcmzg0uQv2Z4LvHSx3dbTzPNBZb1cUl5O5gutblO1UY0GT+DzhsximFqJWkiTjE7YONgzCW4COZovMk2FeKgHIHquOjTbcv1Fcfog6+OtJufa87d+SWvJYIv9RNFAjSeGyUHwsaVG9PRf89Bff5lJxe6BlQjecv/N1G2lZWAo/nx9RpoQN58ob85CyXSPTQ4UFlKbbje0ElGHGcVshU2Vi/+yzfw+USmfOpo05d26FbuoMdwhtB7A4Gp4/EafOuaD3e2DGc2wu+AC6kkULt05qZepu096mAFgz/VnG4+Pjl/rXDq8jSPpa5KpWx/YciYZ6Z23yvAXbEUivZYoJm8AFybAUPNMsLLFfBo40jM0EcJ0p7yFlxElZf6WOwQHQJ6k9T85GyrltOFmtjN5Fync304ri8qvAC7lyNlA+eKsnissfGv2ZNkS2gA258jVRvvFAhKByptmgwGlyWjdiwVID71OGbWMnAdIGSbfNsCeuKGjFoYZtEnIXrE9VK6Mt3lM2VjQ0/ArixXrbxOG9I8BIHoySzUUTLGzhs2CWxfRG68o/GDIULAF4Vd17x76BdeWvUpOaK/5C4Esl8DHEfT0969tPnfrsQv3lKN68Glg6C2RqQLozW8HOWqNDsDpvvMWxwPKOAN2++NYlu3t61l8+QO5es2U56N1CHzqLk6mxU0y9QdgtaavtMzJfWF4MwYMShf3CV6BseKdaGdl2+a5GQ8NPID8H3FPkEV6UbF8AvsHJzuqhve8D/ANewGf23WHzcQAAAABJRU5ErkJggg==', '0', '2019-09-04 22:55:46', NULL, 0, '1'),
(94, 93, 'Registro de Compras', NULL, 'reportes/ventas/registro_ventas/C', NULL, '0', '2013-05-13 09:26:00', NULL, 0, '1'),
(95, 93, 'Registro de Ventas', NULL, 'reportes/ventas/registro_ventas/V', NULL, '0', '2013-05-13 09:26:19', NULL, 0, '1'),
(96, 4, 'Letra de Cambio', NULL, 'ventas/letracambio/comprobantes/V/F', NULL, '0', '2020-02-15 17:59:28', NULL, 14, '1'),
(97, 5, 'Letra de Cambio', NULL, 'ventas/letracambio/comprobantes/C/F', NULL, '0', '2019-08-31 18:41:03', NULL, 12, '1'),
(98, 4, 'Nota de Debito', NULL, 'ventas/notacredito/comprobantes/V/D', NULL, '0', '2020-02-15 17:59:13', NULL, 11, '1'),
(99, 5, 'Nota de Debito Compra', NULL, 'ventas/notacredito/comprobantes/C/D', NULL, '0', '2019-08-31 18:41:03', NULL, 13, '1'),
(100, 7, 'Terminales', NULL, 'maestros/terminal/terminales', NULL, '0', '2020-03-11 17:43:47', NULL, 15, '1'),
(101, 6, 'Tipo Caja', NULL, 'tesoreria/tipocaja/tipocajas', NULL, '0', '2020-02-21 16:42:43', NULL, 7, '1'),
(102, 7, 'Configuracion Impresion', NULL, 'maestros/configuracionimpresion/configuracion_index', NULL, '0', '2020-03-11 17:43:51', NULL, 16, '1'),
(103, 6, 'Caja Movimiento', NULL, 'tesoreria/movimiento/movimientos/0', NULL, '0', '2020-02-21 16:42:03', NULL, 6, '1'),
(104, 7, 'Sector comercial', NULL, 'maestros/comercial/sector_comercial', NULL, '0', '2020-03-11 17:45:37', NULL, 17, '1'),
(105, 9, 'Reporte por tienda', NULL, 'reportes/ventas/filtroTienda', NULL, '0', '2019-08-31 18:41:03', NULL, 0, '1'),
(106, 9, 'Ventas por Cliente', NULL, 'reportes/ventas/filtrocliente', NULL, '0', '2018-06-20 18:56:19', NULL, 0, '1'),
(107, 4, 'Reporte de Servicio', NULL, 'compras/servicio/pedidos', NULL, '0', '2020-02-15 17:59:17', NULL, 12, '1'),
(108, 6, 'Prestamo Personal', NULL, 'tesoreria/prestamo/listar', NULL, '0', '2020-02-21 16:42:53', NULL, 9, '1'),
(109, 0, 'Importacion', NULL, NULL, 'iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAACQ1JREFUaIHVWm2MHVUZfp5zz/R2d724BEvdEJQvQ0JjAEsXunSdvTMXTSslRi0fbkWFAhJLLCLBHxSJTZQSNFVJEwTRxG4DfkQoWpHembvjvdFSPjQRUBSByleg0S6UXTp7557XHzu3zt7OvXunW374/Jtz3ve8zzvnzDnved8hjgKGh4cHtNYjSqlzSS4RkZMBLCLZCwAiMgVgH8kXRORpko+GYTherVZfm69tHqniihUrjs3n82sBjAI4h2Qui76INAA8DmAsDMNttVpt/5HwyOyA4ziLAdxEch3JwpEYbYWIHBCRewBs9n3/9Sy6XTtg27ZWSm1QSm0keUwLgUmSVWNMVUT+bIx5Pp/PvzE9Pb0sl8utBGADWELSmsORt0huqtfrW4IgiI6aA7Ztn6a13kby3IQxAfBHAFujKHowCIK3m31DQ0OFnp6eHwK4hGSqDRF5C8DVAIokPw9gYaJvTxRFo0EQPDdvBxzHWUlyO8n+hIEnjTE3GmOe1FpfJSKXkXwfgBeNMTdXKpXfA6DruuMkP5oy7EFjzMW+7z8EALZtn2RZ1m0icnHTYRGZMMaMViqVnZ34qU6druteQXJHC/lnRWSnUuoGy7JeI3m7UupskieSHFZK/bwpCuDN5HgichDAgySXN8kDQBAEL5bL5UsBrBKRvQBAsj+Xyz3ouu4VnTjqTuQB3E1ylpMkTyd5c4cxI8y8GGJm7UNE9gG4leRYuVx+s61iFI3ncrmA5OUJfne7rgvP8+5N00mdAcdxVgK4q5V8J4hIJCJ3isggAAOgAWCLiPyVpOt53tZO5AEgl8ttVkpdnmwjqUjeVSwWV6XpHPYNxB/sY8ll06UDIiI/azQaa7vdQQBgcHDwmEKh8BHP88ZLpdIXAaS+aRGZiKJoWeuHPesN27at490mE3kAIEml1CW5XG5dtzq2betCobADwCOO46wWkfd0GL9faz1m2/asZT/LAaXUhuRWeSQgmTrVaWg0GgUAfweglVI7SH5/jrEHLcvakGw75IDjOIuVUhuzEgYAEfkPgOtF5GUR6fpwrNVq+z3Pu5rkGxlsbYyjAQCzZ+Cm1hO2ywGfBrCsXC5vmZycPDOXy12ZRd9xnAtE5O25JWcQc7zp0DNwKDDbmzW2EZEHSH5hrt2lHVzXvZ7kd5AxJhORA2EYfrBWq+3XAJDP59dmJB8ZY77m+/73shhOIVLoEGpMA3iT5LFoOa9IFuJI+AfNJTSawagRkXXzJR8Teai1TUQaxph1ExMTx3qed/zk5OQJIvJVEXm0RXQUADg8PDywYMGCl7qN50Vki+d518+XvG3bC7XWVZLntPYZY/5N8j4R+ZNS6h0ROQXAWpKnJ3g0pqenT9Ra65F25EWkLiI/BfAsSYfkWUqpTmFE19BafzuNPAAopY4D8OXm6kpbZSRz+Xy+qJVSbfd9EbnO9/274sc7SqXSyl27dk3Ol/zIyMj5AK6b7zgiMqhILkm0XSEi1YTAeKLPlMvl38zXKABorW/LegVNA8klWkRObk5RGIYP5/P5EMBwLHCl67oKQJ/nedfO1yAALF++/HgRGWqz+WSCiJysACxqNiil9pfL5e3GmMsA3Bvfe28A8BnXdY+bt0UAfX19i7NEuXNgkWqmPgAgCIJpAPB9/75yuXxlGIanAtgO4DgRueVoWBSRV+OMxLxBspelUqmO+KCo1+tWWijsOM56ktdEUbRGa70GwIUiQpKPGmN+UqlUnshi2HXdHSRXHwUfIhUnnQAAlmX1pUn5vn/n9PT0RZZlbST5TZKDSqllJNcrpR5zXfd3ruue0q1VEblWRP42X/YiMqUA7Gs21Ov1gXbC1Wr1BWOM39rOGXyM5J5isZh2gT8Mvu+/EkXR2QA+bYy51hizptFofEJEvIw+7GOpVNoFoBQ3XNhuqzzvvPN6+vr6niF5UocBDxpj1vu+/6OMRAAApVLpAyLyfIaowFNxOAwAMMac1U64p6dn5RzkAWAhybtd133EcZzVZ5xxxoKumMcol8v/AvBIBpWnFMlDQVKbHA4AQCnVVbQaL6kLlFI7BgYGfpuBDABARH7crSzJPSoMw/HEtrZiaGgolaiIlEUkzEKG5KK5pWZjamrq1yIyZ1JARBphGFZUnOJ+PDbYm8/nP5mm4Pv+KyJyS5xS7ArGmK1dM4/R29v7IQDdfAOPV6vV15on4lizVSn1pXYavu/fDqArUiLyTqPR2NaNbIve0naXnBaMAfGdOAzDbSJyIO5YPjIyYrfT8jxvfRxiz4VnkwnfbqGUmp5LJr5SbgNiB2q12v44Pw+SzOVy30KHeyrJr2MmhdjJyK4sxJswxuwWEdNJhuQ9zYJIMqjaHKe8QXLIcZy2SdVyufzqHCdpbWpq6htZiDdRqVT+CSBo1y8ibxljNjefDzng+/7rJDc1n0l+t1gsntrB1jNtDEyEYfjZ3bt3v5ON+qwxNrXbLEhuSlZxZoW19Xp9i4jsiQWPUUr90rbtdum+w5JRcX70xmq1+tKRkgcA3/crAB5OGX9PvV7fkmyb5UAQBFEURaMiMgEAJM/UWv8i7UQlmfaB/sH3/dTkbFY0Go3NyVmIk7ujrdHyYReLIAieM8aMIv5ISX58YGDgV0uXLu1NyhljXk4+x+mQr2AmtT4v2LZ9ltb6/sR2GhljUktOqTejSqWyU0Suae4GJFf19/f7juOckCD8jxa17VnvBWlwHGe1ZVnjABbHdoyIXNOu1NT2ahdXRK7C/2biXJJPuK57IQDU6/XHmiFInEW7dT7Ebdte6LruHSQfAPDeuDkCcFW76gzQRU6yWCyuUkqNNWsG8bq8P4qiG7XW95E8X0S2eZ73uSPkTtd1PwVgM8lDu163Rb62NbImKpXKTtu2l2mtx0gOxuvyUq31RQD2xmKvZGVt23a/ZVlrRGQ9gA8nw4ejWmZNGNSWZW0QkbRC99uYieNrAP5Sr9f3Hjx48PWenp6pIAhkcHCwr1AovN8YcxrJs0naJIeRqA3H47w7he4kuv3VoPUg6hSgicgBkvcYY969Xw1a8X/7s0cahoeHB/L5fFFEBtnhdxsALwJ4iuSeMAwrR+N3m/8CwDxynP7cM1kAAAAASUVORK5CYII=', '0', '2019-09-04 22:59:47', NULL, 0, '1'),
(110, 109, 'Importacion', NULL, 'ventas/importacion/comprobantes/C/F', NULL, '0', '2020-03-13 22:08:22', NULL, 0, '1'),
(111, 5, 'Ordenes de servicio', NULL, 'ventas/oservicio/oservicios/0/C', NULL, '0', '2020-03-11 17:38:53', NULL, 4, '1'),
(112, 6, 'Movimiento Bancos', NULL, 'tesoreria/banco/movimientos', NULL, '0', '2020-02-21 16:42:48', NULL, 8, '1'),
(113, 4, 'Letras', NULL, 'ventas/letra/comprobantes/V/F', NULL, '0', '2020-02-15 17:59:23', NULL, 13, '1'),
(114, 9, 'Compras por proveedor', NULL, '	\r\nreportes/ventas/filtroproveedor', NULL, '0', '2019-05-30 23:05:53', NULL, 0, '1'),
(115, 3, 'Recetas', 'Recetas', 'almacen/produccion/receta_index/0', NULL, '0', '2019-11-14 16:09:44', NULL, 22, '1'),
(116, 3, 'Producción', 'Produccion', 'almacen/produccion/produccion_index/0', NULL, '0', '2019-11-14 16:09:47', NULL, 23, '1'),
(117, 3, 'Programación de despacho', 'Despacho', 'almacen/produccion/despacho_index/', 'iVBORw0KGgoAAAANSUhEUgAAAEgAAABICAYAAABV7bNHAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAOxAAADsQBlSsOGwAABnpJREFUeJztmm2IXFcZx///M3c3s1litAVZiy8JLCYundnce0sEEaX5IH5IW7X4VrMgWKgtSKuk+sVAqEIJKo1CI1R8oUJaazdUuxXTL2Klr3rvnbmbjG+L2VBtXqza/RCbycw9fz90ppmOs3Pnbradbvb+YGHPeZ7nPM/8uefcc+69QE5OTk5OTk5OTk5OTk5OTk5OTk5OzipBAPB9/yOSrgMwNuR6XoOkxSRJ7ovj+OywaqDrul8keYgkh1VEPySdOH/+/DW1Wu3fw8hvSH79zSoOAJDcOjY2tmdY+Q2Aq4aVfFAkDa1G82a+ejoYWo1mWInXCrlAKeQCpZALlEIuUAq5QCk4wy5gJUxNTU1s2LDhJpJvzxInyQI4Wa/Xfz7oznzNCTQ9Pb2lUCg8TXIia2x7y1csFvd7nrc7DMMgLWbNTTFjzB0rEaeTVvzRcrn83tR8l5JoGJDcskrjXOk4ziPbtm3b1M9vzQmEVTx2kHzf+Pj4oX4+a1Gg1eZzvu/fvJxxzS3SaUj6URiGX+hlK5VKb3Mc535jzO52X+uw/l3XdZ+LoijujllXV9D8/Px/rLUzkv7WZdpI8sFe69G6EggAqtXqS9baGQCNzv7WenRvt/+6EwgAKpXKU9bauySpy7Snez1alwIBQBRFdwN4orOPJCUddF233O5btwIBSOr1+oykf3V2khwn+YDv+xuB9S0Qjh8//rykW7qnGskpSXuBdS4QAERRNAvgBz1Me7dv337luhcIAJrN5lck/bGzj+Sm8fHxz+cCAYjj+Jy19tbW45BOPna5CsSsf5VK5QkAz3QOIql82R01AHzW87zd6W49eUtXe9NlJxDJMazSRxgkeblOsVUjFyiFXKAUcoFSyAVKIRcohRXd5luHu0VJv5D0HIAXWqarSO4keQOALcP49qhVWyhpjmQVwIuSRiVtIflBkteTvGLQ8TILJGkRwNfCMJwFkPRweQDAXs/zbpR0YLVe0wxY21OS9kZR9PQyLj8sl8vjjuPcBmAfyb6vfICMU8xaO5ckiRuG4UPoLU6bJAzDh5IkcSU9miXHSpAka+3dYRh+qI84AF45d4Vh+K1ms3kNgD+ljT3wFWStnTPGfCKKotc8yy2Xy1tHRkYmAaDRaCzEcXyibatWqy/5vn+jpFmS1w2aKwutKbU/iqK7ukymXC5PGWPeLem/juMcC4LgxbYxjuO/TE1NXVssFn9HcnK58Qe6giQtGmP2BEHwqjie5+3yff8Zx3EWADwO4HHHcRY8z3vW87xdbb8gCBokZ1pT8/VgLgzDb3S0uWPHjps9z1twHCcuFAqPOY7zG0n/cF33SOfr5lqtdrrZbH5KUn25wU2PB9f/B8mvBkGw1G57nnc7gKMA3t95XCFpSO4EcNTzvDva/UEQLFlr7xwk1zKo1/+S6s1m8/aOvoLruj81xtxHcmvnTYLkqDHm447jPOv7/rXt/jiOI0nf75lUkgHQ9yt2SSeCIJhtt13X/SiA75Bcdnq2bN9u+QIAKpXKLIATy8Wk1HC21/8kZzuntOu6+0je1O/uSfKtkh4ulUrv7Og+KKnZw/2skXRPv+JIHgFgLzZ5gGQh7UeRLJA8gIvv0iXpSFpcN5LO1Ov1w+22tfaQpJdbtofb/b7vv8MYc+cgWwuSV4yMjOxrt6MoOgng9z1y3+NEUXTA9/3nJV2PHo8JrLWv3oVKpdLVAEoZfl/J9/2rgyCYbyWck5T6yUm7PpKLSZIcrNVqp9ud1Wq1Mj09/YFCoXBrs9l8sqPOG4wxGzPU9kkAt6F1N5Z0P4B/tmwvk/xlFEWHM23kXNf9tDHmwSwx1trPRFH0sywxK8HzvO+R/FKWmAsXLrxrfn7+7/18Mu2D+q07qxmzElaSxxiTGpNJoCRJ/pq1CJKZY1aCtTZTHknnGo3GC2l+mQSqVquhpJMZijgZBEGYJccl8Ogyd6KekPxVrVa7kOaX9TTfBLB/kP1Me4fbinndiaJoQdKPB/GVdL7RaHTvvHuS+XFHGIY/AXBvP5H0Codavm8YSZJ8WdKTKW4Na+0tcRwfG2TM1P1ML06dOvXriYmJ0wB2khzvtEk62zpRf3MlY18KZ86caYyOjh4uFotjALzuhVvSMUkzlUrlkUHHvKTnNZOTkxs2b978YWvtNgAwxvx5aWnptwsLC8uebd4oWp/b7QLwHgDnrLVRtVr9Ay5uegfif/6RxIFWQ8wOAAAAAElFTkSuQmCC', '1', '2020-03-13 22:24:00', '2020-03-13 17:24:00', 24, '1'),
(118, 3, 'Lotes', 'Lotes', 'almacen/lote/lote_index', NULL, '0', '2019-11-14 16:09:55', NULL, 25, '1'),
(119, 6, 'Cuotas - Ventas', 'Cuotas', 'tesoreria/cuota/cuotas/V', NULL, '0', '2020-02-21 16:40:39', NULL, 2, '1'),
(120, 6, 'Cuotas - Compras', 'Cuotas', 'tesoreria/cuota/cuotas/C', NULL, '0', '2020-02-21 16:40:30', NULL, 4, '1'),
(121, 8, 'Menu', 'Menu', 'basedatos/menu/', '', '0', '2020-03-13 21:37:23', NULL, 1, '1'),
(123, 8, 'Alumnos', 'Alumnos', 'alumno/listar', '', '0', '2020-04-15 01:45:27', '2020-04-14 20:45:27', 3, '1'),
(124, 3, 'Ajuste de Inventario', 'Ajuste de Inventario', 'almacen/inventario/reajuste', '', '0', '2021-03-08 21:08:29', NULL, 7, '1'),
(125, 4, 'Orden de Servicio', '', 'servicio/servicio/servicios/V', '', '0', '2021-05-26 13:17:35', '2021-05-25 15:30:14', 0, '0'),
(126, 9, 'Productos mas vendidos', 'Productos mas vendidos', 'reportes/ventas/masVendidos', '', '0', '2022-05-03 21:26:14', NULL, 6, '1'),
(127, 9, 'Reporte compras por producto', 'Reporte compras por producto', 'reportes/ventas/reportes/C', '', '0', '2022-07-27 22:53:45', NULL, 3, '1'),
(128, 9, 'Reporte compras por producto', 'Reporte compras por producto', 'reportes/ventas/reportes/C', '', '0', '2022-08-01 16:23:37', NULL, 3, '0'),
(129, 4, 'Punto de venta', 'Punto de venta', 'index/pos', NULL, '1', '2023-08-04 13:45:21', NULL, 0, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_moneda`
--

CREATE TABLE `cji_moneda` (
  `MONED_Codigo` int(11) NOT NULL,
  `MONED_Descripcion` varchar(250) DEFAULT NULL,
  `MONED_smallName` varchar(10) DEFAULT NULL,
  `MONED_Simbolo` varchar(100) NOT NULL,
  `MONED_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MONED_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `MONED_Orden` int(11) NOT NULL DEFAULT '0',
  `MONED_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_moneda`
--

INSERT INTO `cji_moneda` (`MONED_Codigo`, `MONED_Descripcion`, `MONED_smallName`, `MONED_Simbolo`, `MONED_FechaRegistro`, `MONED_FechaModificacion`, `COMPP_Codigo`, `MONED_Orden`, `MONED_FlagEstado`) VALUES
(1, 'SOLES', 'SOL', 'S/', '2011-01-14 16:13:10', NULL, 1, 1, '1'),
(2, 'DOLARES AMERICANOS', 'DOLAME', 'US$', '2011-01-14 16:13:18', NULL, 1, 2, '1'),
(4, 'EURO', 'EUR', '€', '2017-11-25 02:51:32', NULL, 1, 3, '0');

-- --------------------------------------------------------

--
-- Table structure for table `cji_nacionalidad`
--

CREATE TABLE `cji_nacionalidad` (
  `NACP_Codigo` int(11) NOT NULL,
  `NACC_Descripcion` varchar(150) DEFAULT NULL,
  `NACC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `NACC_FechaModificacion` datetime DEFAULT NULL,
  `NACC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_nacionalidad`
--

INSERT INTO `cji_nacionalidad` (`NACP_Codigo`, `NACC_Descripcion`, `NACC_FechaRegistro`, `NACC_FechaModificacion`, `NACC_FlagEstado`) VALUES
(1, 'BOUVET ISLAND', '2010-12-17 18:53:48', NULL, '1'),
(2, 'COTE D IVOIRE', '2010-12-17 18:53:48', NULL, '1'),
(3, 'FALKLAND ISLANDS (MALVINAS)', '2010-12-17 18:53:48', NULL, '1'),
(4, 'FRANCE, METROPOLITAN', '2010-12-17 18:53:48', NULL, '1'),
(5, 'FRENCH SOUTHERN TERRITORIES', '2010-12-17 18:53:48', NULL, '1'),
(6, 'HEARD AND MC DONALD ISLANDS', '2010-12-17 18:53:48', NULL, '1'),
(7, 'MAYOTTE', '2010-12-17 18:53:48', NULL, '1'),
(8, 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', '2010-12-17 18:53:48', NULL, '1'),
(9, 'SVALBARD AND JAN MAYEN ISLANDS', '2010-12-17 18:53:48', NULL, '1'),
(10, 'UNITED STATES MINOR OUTLYING ISLANDS', '2010-12-17 18:53:48', NULL, '1'),
(11, 'OTROS PAISES O LUGARES', '2010-12-17 18:53:48', NULL, '1'),
(12, 'AFGANISTAN', '2010-12-17 18:53:48', NULL, '1'),
(13, 'ALBANIA', '2010-12-17 18:53:48', NULL, '1'),
(14, 'ALDERNEY', '2010-12-17 18:53:48', NULL, '1'),
(15, 'ALEMANIA', '2010-12-17 18:53:48', NULL, '1'),
(16, 'ARMENIA', '2010-12-17 18:53:48', NULL, '1'),
(17, 'ARUBA', '2010-12-17 18:53:48', NULL, '1'),
(18, 'ASCENCION', '2010-12-17 18:53:48', NULL, '1'),
(19, 'BOSNIA-HERZEGOVINA', '2010-12-17 18:53:48', NULL, '1'),
(20, 'BURKINA FASO', '2010-12-17 18:53:48', NULL, '1'),
(21, 'ANDORRA', '2010-12-17 18:53:48', NULL, '1'),
(22, 'ANGOLA', '2010-12-17 18:53:48', NULL, '1'),
(23, 'ANGUILLA', '2010-12-17 18:53:48', NULL, '1'),
(24, 'ANTIGUA Y BARBUDA', '2010-12-17 18:53:48', NULL, '1'),
(25, 'ANTILLAS HOLANDESAS', '2010-12-17 18:53:48', NULL, '1'),
(26, 'ARABIA SAUDITA', '2010-12-17 18:53:48', NULL, '1'),
(27, 'ARGELIA', '2010-12-17 18:53:48', NULL, '1'),
(28, 'ARGENTINA', '2010-12-17 18:53:48', NULL, '1'),
(29, 'AUSTRALIA', '2010-12-17 18:53:48', NULL, '1'),
(30, 'AUSTRIA', '2010-12-17 18:53:48', NULL, '1'),
(31, 'AZERBAIJÃN', '2010-12-17 18:53:48', NULL, '1'),
(32, 'BAHAMAS', '2010-12-17 18:53:48', NULL, '1'),
(33, 'BAHREIN', '2010-12-17 18:53:48', NULL, '1'),
(34, 'BANGLA DESH', '2010-12-17 18:53:48', NULL, '1'),
(35, 'BARBADOS', '2010-12-17 18:53:48', NULL, '1'),
(36, 'BÃ‰LGICA', '2010-12-17 18:53:48', NULL, '1'),
(37, 'BELICE', '2010-12-17 18:53:48', NULL, '1'),
(38, 'BERMUDAS', '2010-12-17 18:53:48', NULL, '1'),
(39, 'BELARUS', '2010-12-17 18:53:48', NULL, '1'),
(40, 'MYANMAR', '2010-12-17 18:53:48', NULL, '1'),
(41, 'BOLIVIA', '2010-12-17 18:53:48', NULL, '1'),
(42, 'BOTSWANA', '2010-12-17 18:53:48', NULL, '1'),
(43, 'BRASIL', '2010-12-17 18:53:48', NULL, '1'),
(44, 'BRUNEI DARUSSALAM', '2010-12-17 18:53:48', NULL, '1'),
(45, 'BULGARIA', '2010-12-17 18:53:48', NULL, '1'),
(46, 'BURUNDI', '2010-12-17 18:53:48', NULL, '1'),
(47, 'BUTÃN', '2010-12-17 18:53:48', NULL, '1'),
(48, 'CABO VERDE', '2010-12-17 18:53:48', NULL, '1'),
(49, 'CAIMÃN, ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(50, 'CAMBOYA', '2010-12-17 18:53:48', NULL, '1'),
(51, 'CAMERÃšN, REPUBLICA UNIDA DEL', '2010-12-17 18:53:48', NULL, '1'),
(52, 'CAMPIONE D TALIA', '2010-12-17 18:53:48', NULL, '1'),
(53, 'CANADÃ', '2010-12-17 18:53:48', NULL, '1'),
(54, 'CANAL (NORMANDAS), ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(55, 'CANTÃ“N Y ENDERBURRY', '2010-12-17 18:53:48', NULL, '1'),
(56, 'SANTA SEDE', '2010-12-17 18:53:48', NULL, '1'),
(57, 'COCOS (KEELING),ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(58, 'COLOMBIA', '2010-12-17 18:53:48', NULL, '1'),
(59, 'COMORAS', '2010-12-17 18:53:48', NULL, '1'),
(60, 'CONGO', '2010-12-17 18:53:48', NULL, '1'),
(61, 'COOK, ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(62, 'COREA (NORTE), REPUBLICA POPULAR DEMOCRATICA DE', '2010-12-17 18:53:48', NULL, '1'),
(63, 'COREA (SUR), REPUBLICA DE', '2010-12-17 18:53:48', NULL, '1'),
(64, 'COSTA DE MARFIL', '2010-12-17 18:53:48', NULL, '1'),
(65, 'COSTA RICA', '2010-12-17 18:53:48', NULL, '1'),
(66, 'CROACIA', '2010-12-17 18:53:48', NULL, '1'),
(67, 'CUBA', '2010-12-17 18:53:48', NULL, '1'),
(68, 'CHAD', '2010-12-17 18:53:48', NULL, '1'),
(69, 'CHECOSLOVAQUIA', '2010-12-17 18:53:48', NULL, '1'),
(70, 'CHILE', '2010-12-17 18:53:48', NULL, '1'),
(71, 'CHINA', '2010-12-17 18:53:48', NULL, '1'),
(72, 'TAIWAN (FORMOSA)', '2010-12-17 18:53:48', NULL, '1'),
(73, 'CHIPRE', '2010-12-17 18:53:48', NULL, '1'),
(74, 'BENIN', '2010-12-17 18:53:48', NULL, '1'),
(75, 'DINAMARCA', '2010-12-17 18:53:48', NULL, '1'),
(76, 'DOMINICA', '2010-12-17 18:53:48', NULL, '1'),
(77, 'ECUADOR', '2010-12-17 18:53:48', NULL, '1'),
(78, 'EGIPTO', '2010-12-17 18:53:48', NULL, '1'),
(79, 'EL SALVADOR', '2010-12-17 18:53:48', NULL, '1'),
(80, 'ERITREA', '2010-12-17 18:53:48', NULL, '1'),
(81, 'EMIRATOS ARABES UNIDOS', '2010-12-17 18:53:48', NULL, '1'),
(82, 'ESPANA', '2010-12-17 18:53:48', NULL, '1'),
(83, 'ESLOVAQUIA', '2010-12-17 18:53:48', NULL, '1'),
(84, 'ESLOVENIA', '2010-12-17 18:53:48', NULL, '1'),
(85, 'ESTADOS UNIDOS', '2010-12-17 18:53:48', NULL, '1'),
(86, 'ESTONIA', '2010-12-17 18:53:48', NULL, '1'),
(87, 'ETIOPIA', '2010-12-17 18:53:48', NULL, '1'),
(88, 'FEROE, ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(89, 'FILIPINAS', '2010-12-17 18:53:48', NULL, '1'),
(90, 'FINLANDIA', '2010-12-17 18:53:48', NULL, '1'),
(91, 'FRANCIA', '2010-12-17 18:53:48', NULL, '1'),
(92, 'GABON', '2010-12-17 18:53:48', NULL, '1'),
(93, 'GAMBIA', '2010-12-17 18:53:48', NULL, '1'),
(94, 'GAZA Y JERICO', '2010-12-17 18:53:48', NULL, '1'),
(95, 'GEORGIA', '2010-12-17 18:53:48', NULL, '1'),
(96, 'GHANA', '2010-12-17 18:53:48', NULL, '1'),
(97, 'GIBRALTAR', '2010-12-17 18:53:48', NULL, '1'),
(98, 'GRANADA', '2010-12-17 18:53:48', NULL, '1'),
(99, 'GRECIA', '2010-12-17 18:53:48', NULL, '1'),
(100, 'GROENLANDIA', '2010-12-17 18:53:48', NULL, '1'),
(101, 'GUADALUPE', '2010-12-17 18:53:48', NULL, '1'),
(102, 'GUAM', '2010-12-17 18:53:48', NULL, '1'),
(103, 'GUATEMALA', '2010-12-17 18:53:48', NULL, '1'),
(104, 'GUAYANA FRANCESA', '2010-12-17 18:53:48', NULL, '1'),
(105, 'GUERNSEY', '2010-12-17 18:53:48', NULL, '1'),
(106, 'GUINEA', '2010-12-17 18:53:48', NULL, '1'),
(107, 'GUINEA ECUATORIAL', '2010-12-17 18:53:48', NULL, '1'),
(108, 'GUINEA-BISSAU', '2010-12-17 18:53:48', NULL, '1'),
(109, 'GUYANA', '2010-12-17 18:53:48', NULL, '1'),
(110, 'HAITI', '2010-12-17 18:53:48', NULL, '1'),
(111, 'HONDURAS', '2010-12-17 18:53:48', NULL, '1'),
(112, 'HONDURAS BRITANICAS', '2010-12-17 18:53:48', NULL, '1'),
(113, 'HONG KONG', '2010-12-17 18:53:48', NULL, '1'),
(114, 'HUNGRIA', '2010-12-17 18:53:48', NULL, '1'),
(115, 'INDIA', '2010-12-17 18:53:48', NULL, '1'),
(116, 'INDONESIA', '2010-12-17 18:53:48', NULL, '1'),
(117, 'IRAK', '2010-12-17 18:53:48', NULL, '1'),
(118, 'IRAN, REPUBLICA ISLAMICA DEL', '2010-12-17 18:53:48', NULL, '1'),
(119, 'IRLANDA (EIRE)', '2010-12-17 18:53:48', NULL, '1'),
(120, 'ISLA AZORES', '2010-12-17 18:53:48', NULL, '1'),
(121, 'ISLA DEL MAN', '2010-12-17 18:53:48', NULL, '1'),
(122, 'ISLANDIA', '2010-12-17 18:53:48', NULL, '1'),
(123, 'ISLAS CANARIAS', '2010-12-17 18:53:48', NULL, '1'),
(124, 'ISLAS DE CHRISTMAS', '2010-12-17 18:53:48', NULL, '1'),
(125, 'ISLAS QESHM', '2010-12-17 18:53:48', NULL, '1'),
(126, 'ISRAEL', '2010-12-17 18:53:48', NULL, '1'),
(127, 'ITALIA', '2010-12-17 18:53:48', NULL, '1'),
(128, 'JAMAICA', '2010-12-17 18:53:48', NULL, '1'),
(129, 'JONSTON, ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(130, 'JAPON', '2010-12-17 18:53:48', NULL, '1'),
(131, 'JERSEY', '2010-12-17 18:53:48', NULL, '1'),
(132, 'JORDANIA', '2010-12-17 18:53:48', NULL, '1'),
(133, 'KAZAJSTAN', '2010-12-17 18:53:48', NULL, '1'),
(134, 'KENIA', '2010-12-17 18:53:48', NULL, '1'),
(135, 'KIRIBATI', '2010-12-17 18:53:48', NULL, '1'),
(136, 'KIRGUIZISTAN', '2010-12-17 18:53:48', NULL, '1'),
(137, 'KUWAIT', '2010-12-17 18:53:48', NULL, '1'),
(138, 'LABUN', '2010-12-17 18:53:48', NULL, '1'),
(139, 'LAOS, REPUBLICA POPULAR DEMOCRATICA DE', '2010-12-17 18:53:48', NULL, '1'),
(140, 'LESOTHO', '2010-12-17 18:53:48', NULL, '1'),
(141, 'LETONIA', '2010-12-17 18:53:48', NULL, '1'),
(142, 'LIBANO', '2010-12-17 18:53:48', NULL, '1'),
(143, 'LIBERIA', '2010-12-17 18:53:48', NULL, '1'),
(144, 'LIBIA', '2010-12-17 18:53:48', NULL, '1'),
(145, 'LIECHTENSTEIN', '2010-12-17 18:53:48', NULL, '1'),
(146, 'LITUANIA', '2010-12-17 18:53:48', NULL, '1'),
(147, 'LUXEMBURGO', '2010-12-17 18:53:48', NULL, '1'),
(148, 'MACAO', '2010-12-17 18:53:48', NULL, '1'),
(149, 'MACEDONIA', '2010-12-17 18:53:48', NULL, '1'),
(150, 'MADAGASCAR', '2010-12-17 18:53:48', NULL, '1'),
(151, 'MADEIRA', '2010-12-17 18:53:48', NULL, '1'),
(152, 'MALAYSIA', '2010-12-17 18:53:48', NULL, '1'),
(153, 'MALAWI', '2010-12-17 18:53:48', NULL, '1'),
(154, 'MALDIVAS', '2010-12-17 18:53:48', NULL, '1'),
(155, 'MALI', '2010-12-17 18:53:48', NULL, '1'),
(156, 'MALTA', '2010-12-17 18:53:48', NULL, '1'),
(157, 'MARIANAS DEL NORTE, ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(158, 'MARSHALL, ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(159, 'MARRUECOS', '2010-12-17 18:53:48', NULL, '1'),
(160, 'MARTINICA', '2010-12-17 18:53:48', NULL, '1'),
(161, 'MAURICIO', '2010-12-17 18:53:48', NULL, '1'),
(162, 'MAURITANIA', '2010-12-17 18:53:48', NULL, '1'),
(163, 'MEXICO', '2010-12-17 18:53:48', NULL, '1'),
(164, 'MICRONESIA, ESTADOS FEDERADOS DE', '2010-12-17 18:53:48', NULL, '1'),
(165, 'MIDWAY ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(166, 'MOLDAVIA', '2010-12-17 18:53:48', NULL, '1'),
(167, 'MONGOLIA', '2010-12-17 18:53:48', NULL, '1'),
(168, 'MONACO', '2010-12-17 18:53:48', NULL, '1'),
(169, 'MONTSERRAT, ISLA', '2010-12-17 18:53:48', NULL, '1'),
(170, 'MOZAMBIQUE', '2010-12-17 18:53:48', NULL, '1'),
(171, 'NAMIBIA', '2010-12-17 18:53:48', NULL, '1'),
(172, 'NAURU', '2010-12-17 18:53:48', NULL, '1'),
(173, 'NAVIDAD (CHRISTMAS), ISLA', '2010-12-17 18:53:48', NULL, '1'),
(174, 'NEPAL', '2010-12-17 18:53:48', NULL, '1'),
(175, 'NICARAGUA', '2010-12-17 18:53:48', NULL, '1'),
(176, 'NIGER', '2010-12-17 18:53:48', NULL, '1'),
(177, 'NIGERIA', '2010-12-17 18:53:48', NULL, '1'),
(178, 'NIUE, ISLA', '2010-12-17 18:53:48', NULL, '1'),
(179, 'NORFOLK, ISLA', '2010-12-17 18:53:48', NULL, '1'),
(180, 'NORUEGA', '2010-12-17 18:53:48', NULL, '1'),
(181, 'NUEVA CALEDONIA', '2010-12-17 18:53:48', NULL, '1'),
(182, 'PAPUASIA NUEVA GUINEA', '2010-12-17 18:53:48', NULL, '1'),
(183, 'NUEVA ZELANDA', '2010-12-17 18:53:48', NULL, '1'),
(184, 'VANUATU', '2010-12-17 18:53:48', NULL, '1'),
(185, 'OMAN', '2010-12-17 18:53:48', NULL, '1'),
(186, 'PACIFICO, ISLAS DEL', '2010-12-17 18:53:48', NULL, '1'),
(187, 'PAISES BAJOS', '2010-12-17 18:53:48', NULL, '1'),
(188, 'PAKISTAN', '2010-12-17 18:53:48', NULL, '1'),
(189, 'PALAU, ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(190, 'TERRITORIO AUTONOMO DE PALESTINA.', '2010-12-17 18:53:48', NULL, '1'),
(191, 'PANAMA', '2010-12-17 18:53:48', NULL, '1'),
(192, 'PARAGUAY', '2010-12-17 18:53:48', NULL, '1'),
(193, 'PERU', '2010-12-17 18:53:48', NULL, '1'),
(194, 'PITCAIRN, ISLA', '2010-12-17 18:53:48', NULL, '1'),
(195, 'POLINESIA FRANCESA', '2010-12-17 18:53:48', NULL, '1'),
(196, 'POLONIA', '2010-12-17 18:53:48', NULL, '1'),
(197, 'PORTUGAL', '2010-12-17 18:53:48', NULL, '1'),
(198, 'PUERTO RICO', '2010-12-17 18:53:48', NULL, '1'),
(199, 'QATAR', '2010-12-17 18:53:48', NULL, '1'),
(200, 'REINO UNIDO', '2010-12-17 18:53:48', NULL, '1'),
(201, 'ESCOCIA', '2010-12-17 18:53:48', NULL, '1'),
(202, 'REPUBLICA ARABE UNIDA', '2010-12-17 18:53:48', NULL, '1'),
(203, 'REPUBLICA CENTROAFRICANA', '2010-12-17 18:53:48', NULL, '1'),
(204, 'REPUBLICA CHECA', '2010-12-17 18:53:48', NULL, '1'),
(205, 'REPUBLICA DE SWAZILANDIA', '2010-12-17 18:53:48', NULL, '1'),
(206, 'REPUBLICA DE TUNEZ', '2010-12-17 18:53:48', NULL, '1'),
(207, 'REPUBLICA DOMINICANA', '2010-12-17 18:53:48', NULL, '1'),
(208, 'REUNION', '2010-12-17 18:53:48', NULL, '1'),
(209, 'ZIMBABWE', '2010-12-17 18:53:48', NULL, '1'),
(210, 'RUMANIA', '2010-12-17 18:53:48', NULL, '1'),
(211, 'RUANDA', '2010-12-17 18:53:48', NULL, '1'),
(212, 'RUSIA', '2010-12-17 18:53:48', NULL, '1'),
(213, 'SALOMON, ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(214, 'SAHARA OCCIDENTAL', '2010-12-17 18:53:48', NULL, '1'),
(215, 'SAMOA OCCIDENTAL', '2010-12-17 18:53:48', NULL, '1'),
(216, 'SAMOA NORTEAMERICANA', '2010-12-17 18:53:48', NULL, '1'),
(217, 'SAN CRISTOBAL Y NIEVES', '2010-12-17 18:53:48', NULL, '1'),
(218, 'SAN MARINO', '2010-12-17 18:53:48', NULL, '1'),
(219, 'SAN PEDRO Y MIQUELON', '2010-12-17 18:53:48', NULL, '1'),
(220, 'SAN VICENTE Y LAS GRANADINAS', '2010-12-17 18:53:48', NULL, '1'),
(221, 'SANTA ELENA', '2010-12-17 18:53:48', NULL, '1'),
(222, 'SANTA LUCIA', '2010-12-17 18:53:48', NULL, '1'),
(223, 'SANTO TOME Y PRINCIPE', '2010-12-17 18:53:48', NULL, '1'),
(224, 'SENEGAL', '2010-12-17 18:53:48', NULL, '1'),
(225, 'SEYCHELLES', '2010-12-17 18:53:48', NULL, '1'),
(226, 'SIERRA LEONA', '2010-12-17 18:53:48', NULL, '1'),
(227, 'SINGAPUR', '2010-12-17 18:53:48', NULL, '1'),
(228, 'SIRIA, REPUBLICA ARABE DE', '2010-12-17 18:53:48', NULL, '1'),
(229, 'SOMALIA', '2010-12-17 18:53:48', NULL, '1'),
(230, 'SRI LANKA', '2010-12-17 18:53:48', NULL, '1'),
(231, 'SUDAFRICA, REPUBLICA DE', '2010-12-17 18:53:48', NULL, '1'),
(232, 'SUDAN', '2010-12-17 18:53:48', NULL, '1'),
(233, 'SUECIA', '2010-12-17 18:53:48', NULL, '1'),
(234, 'SUIZA', '2010-12-17 18:53:48', NULL, '1'),
(235, 'SURINAM', '2010-12-17 18:53:48', NULL, '1'),
(236, 'SAWSILANDIA', '2010-12-17 18:53:48', NULL, '1'),
(237, 'TADJIKISTAN', '2010-12-17 18:53:48', NULL, '1'),
(238, 'TAILANDIA', '2010-12-17 18:53:48', NULL, '1'),
(239, 'TANZANIA, REPUBLICA UNIDA DE', '2010-12-17 18:53:48', NULL, '1'),
(240, 'DJIBOUTI', '2010-12-17 18:53:48', NULL, '1'),
(241, 'TERRITORIO ANTARTICO BRITANICO', '2010-12-17 18:53:48', NULL, '1'),
(242, 'TERRITORIO BRITANICO DEL OCEANO INDICO', '2010-12-17 18:53:48', NULL, '1'),
(243, 'TIMOR DEL ESTE', '2010-12-17 18:53:48', NULL, '1'),
(244, 'TOGO', '2010-12-17 18:53:48', NULL, '1'),
(245, 'TOKELAU', '2010-12-17 18:53:48', NULL, '1'),
(246, 'TONGA', '2010-12-17 18:53:48', NULL, '1'),
(247, 'TRINIDAD Y TOBAGO', '2010-12-17 18:53:48', NULL, '1'),
(248, 'TRISTAN DA CUNHA', '2010-12-17 18:53:48', NULL, '1'),
(249, 'TUNICIA', '2010-12-17 18:53:48', NULL, '1'),
(250, 'TURCAS Y CAICOS, ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(251, 'TURKMENISTAN', '2010-12-17 18:53:48', NULL, '1'),
(252, 'TURQUIA', '2010-12-17 18:53:48', NULL, '1'),
(253, 'TUVALU', '2010-12-17 18:53:48', NULL, '1'),
(254, 'UCRANIA', '2010-12-17 18:53:48', NULL, '1'),
(255, 'UGANDA', '2010-12-17 18:53:48', NULL, '1'),
(256, 'URSS', '2010-12-17 18:53:48', NULL, '1'),
(257, 'URUGUAY', '2010-12-17 18:53:48', NULL, '1'),
(258, 'UZBEKISTAN', '2010-12-17 18:53:48', NULL, '1'),
(259, 'VENEZUELA', '2010-12-17 18:53:48', NULL, '1'),
(260, 'VIET NAM', '2010-12-17 18:53:48', NULL, '1'),
(261, 'VIETNAM (DEL NORTE)', '2010-12-17 18:53:48', NULL, '1'),
(262, 'VIRGENES, ISLAS (BRITANICAS)', '2010-12-17 18:53:48', NULL, '1'),
(263, 'VIRGENES, ISLAS (NORTEAMERICANAS)', '2010-12-17 18:53:48', NULL, '1'),
(264, 'FIJI', '2010-12-17 18:53:48', NULL, '1'),
(265, 'WAKE, ISLA', '2010-12-17 18:53:48', NULL, '1'),
(266, 'WALLIS Y FORTUNA, ISLAS', '2010-12-17 18:53:48', NULL, '1'),
(267, 'YEMEN', '2010-12-17 18:53:48', NULL, '1'),
(268, 'YUGOSLAVIA', '2010-12-17 18:53:48', NULL, '1'),
(269, 'ZAIRE', '2010-12-17 18:53:48', NULL, '1'),
(270, 'ZAMBIA', '2010-12-17 18:53:48', NULL, '1'),
(271, 'ZONA DEL CANAL DE PANAMA', '2010-12-17 18:53:48', NULL, '1'),
(272, 'ZONA LIBRE OSTRAVA', '2010-12-17 18:53:48', NULL, '1'),
(273, 'ZONA NEUTRAL (PALESTINA)', '2010-12-17 18:53:48', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_nota`
--

CREATE TABLE `cji_nota` (
  `CRED_Codigo` int(11) NOT NULL,
  `CRED_TipoOperacion` char(1) NOT NULL DEFAULT 'V' COMMENT 'V: venta, C: compra',
  `CRED_TipoDocumento_inicio` char(1) DEFAULT NULL COMMENT 'F: factura, B: boleta, N:comprobante, A: nunguno de los dos',
  `COMPP_Codigo` int(11) NOT NULL,
  `CRED_Serie` char(10) NOT NULL,
  `CRED_Numero` varchar(11) NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `CRED_subtotal` double DEFAULT NULL,
  `CRED_descuento` double DEFAULT NULL,
  `CRED_igv` double DEFAULT NULL,
  `CRED_total` double NOT NULL DEFAULT '0',
  `CRED_subtotal_conigv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `CRED_descuento_conigv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `CRED_igv100` int(11) NOT NULL DEFAULT '0',
  `CRED_descuento100` int(11) NOT NULL DEFAULT '0',
  `DOCUP_Codigo` int(11) DEFAULT NULL,
  `CRED_Observacion` varchar(250) DEFAULT NULL,
  `CRED_Fecha` date NOT NULL,
  `CRED_Vendedor` int(11) DEFAULT NULL,
  `CRED_TDC` double(10,2) DEFAULT NULL,
  `CRED_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CRED_FechaModificacion` datetime DEFAULT NULL,
  `CRED_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CRED_TipoNota` char(1) NOT NULL COMMENT 'C: Nota creadiro, D: Nota Debito',
  `CRED_ComproInicio` int(11) DEFAULT NULL,
  `CRED_TipoDocumento_fin` char(1) DEFAULT NULL COMMENT 'F: factura, B: boleta, C:comprobante, N: nunguno de los dos',
  `CRED_ComproFin` int(11) DEFAULT NULL,
  `CRED_Flag` int(11) DEFAULT NULL COMMENT 'Programacion',
  `CRED_NumeroInicio` varchar(200) DEFAULT NULL COMMENT 'Serie y Numero Comp. Inicio',
  `CRED_NumeroFin` varchar(200) DEFAULT NULL COMMENT 'Serie y Numero Comp. Fin',
  `CRED_FormaPago` int(11) NOT NULL,
  `CRED_Fecha_vencimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_nota`
--

INSERT INTO `cji_nota` (`CRED_Codigo`, `CRED_TipoOperacion`, `CRED_TipoDocumento_inicio`, `COMPP_Codigo`, `CRED_Serie`, `CRED_Numero`, `CLIP_Codigo`, `PROVP_Codigo`, `USUA_Codigo`, `ALMAP_Codigo`, `MONED_Codigo`, `CRED_subtotal`, `CRED_descuento`, `CRED_igv`, `CRED_total`, `CRED_subtotal_conigv`, `CRED_descuento_conigv`, `CRED_igv100`, `CRED_descuento100`, `DOCUP_Codigo`, `CRED_Observacion`, `CRED_Fecha`, `CRED_Vendedor`, `CRED_TDC`, `CRED_FechaRegistro`, `CRED_FechaModificacion`, `CRED_FlagEstado`, `CRED_TipoNota`, `CRED_ComproInicio`, `CRED_TipoDocumento_fin`, `CRED_ComproFin`, `CRED_Flag`, `CRED_NumeroInicio`, `CRED_NumeroFin`, `CRED_FormaPago`, `CRED_Fecha_vencimiento`) VALUES
(1, 'V', 'F', 1, 'FPP1', '1', 1, NULL, 1, 1, 1, 38.98, 0, 7.02, 46, NULL, NULL, 18, 0, 1, '', '2023-10-06', NULL, 3.70, '2023-10-06 21:30:11', NULL, '2', 'C', 1, NULL, NULL, 1, 'FPP1 - 1', NULL, 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `cji_notadetalle`
--

CREATE TABLE `cji_notadetalle` (
  `CREDET_Codigo` int(11) NOT NULL,
  `CRED_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `CREDET_GenInd` char(1) NOT NULL DEFAULT 'I',
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `LOTP_Codigo` int(11) NOT NULL,
  `AFECT_Codigo` int(11) NOT NULL DEFAULT '1',
  `CREDET_Cantidad` float NOT NULL DEFAULT '0',
  `CREDET_Pu` double DEFAULT NULL,
  `CREDET_Subtotal` double DEFAULT NULL,
  `CREDET_Descuento` double DEFAULT NULL,
  `CREDET_Igv` double DEFAULT NULL,
  `CREDET_Total` double NOT NULL DEFAULT '0',
  `CREDET_Pu_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CREDET_Subtotal_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CREDET_Descuento_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CREDET_Igv100` int(11) DEFAULT '0',
  `CREDET_Descuento100` int(11) DEFAULT '0',
  `CREDET_Costo` double DEFAULT NULL,
  `CREDET_Descripcion` varchar(250) DEFAULT NULL,
  `CREDET_Observacion` varchar(250) DEFAULT NULL,
  `CREDET_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREDET_FechaModificacion` datetime DEFAULT NULL,
  `CREDET_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CREDET_FlagICBPER` char(1) NOT NULL DEFAULT '0' COMMENT 'Flag de impuesto a la bolsa ICBPER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_notadetalle`
--

INSERT INTO `cji_notadetalle` (`CREDET_Codigo`, `CRED_Codigo`, `PROD_Codigo`, `CREDET_GenInd`, `UNDMED_Codigo`, `LOTP_Codigo`, `AFECT_Codigo`, `CREDET_Cantidad`, `CREDET_Pu`, `CREDET_Subtotal`, `CREDET_Descuento`, `CREDET_Igv`, `CREDET_Total`, `CREDET_Pu_ConIgv`, `CREDET_Subtotal_ConIgv`, `CREDET_Descuento_ConIgv`, `CREDET_Igv100`, `CREDET_Descuento100`, `CREDET_Costo`, `CREDET_Descripcion`, `CREDET_Observacion`, `CREDET_FechaRegistro`, `CREDET_FechaModificacion`, `CREDET_FlagEstado`, `CREDET_FlagICBPER`) VALUES
(1, 1, 2, 'I', 1, 0, 1, 2, 19.491525423728813, 38.983050847457626, 0, 7.016949152542374, 46, 23, NULL, NULL, 18, 0, 0, 'TEST', '', '2023-10-06 21:30:11', NULL, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `cji_ocompradetalle`
--

CREATE TABLE `cji_ocompradetalle` (
  `OCOMDEP_Codigo` int(11) NOT NULL,
  `OCOMP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `OCOMDEC_GenInd` char(1) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `LOTP_Codigo` int(11) NOT NULL,
  `AFECT_Codigo` int(11) NOT NULL DEFAULT '1',
  `OCOMDEC_Pu` double NOT NULL DEFAULT '0',
  `OCOMDEC_Igv100` int(11) NOT NULL DEFAULT '0',
  `OCOMDEC_Descuento100` int(11) NOT NULL DEFAULT '0',
  `OCOMDEC_Cantidad` double DEFAULT '0',
  `OCOMDEC_Pendiente` double DEFAULT '0',
  `OCOMDEC_Pendiente_pago` double NOT NULL,
  `OCOMDEC_Subtotal` double NOT NULL DEFAULT '0',
  `OCOMDEC_Descuento` double NOT NULL DEFAULT '0',
  `OCOMDEC_Descuento2` double NOT NULL DEFAULT '0',
  `OCOMDEC_Igv` double NOT NULL DEFAULT '0',
  `OCOMDEC_Total` double NOT NULL DEFAULT '0',
  `OCOMDEC_Pu_ConIgv` double NOT NULL,
  `OCOMDEC_Costo` double DEFAULT NULL,
  `OCOMDEC_Descripcion` varchar(250) DEFAULT NULL,
  `OCOMDEC_Observacion` varchar(250) DEFAULT NULL,
  `OCOMDEC_FechaModificacion` datetime DEFAULT NULL,
  `OCOMDEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `OCOMDEC_FlagIngreso` char(1) NOT NULL DEFAULT '0',
  `OCOMDEC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `OCOMP_Codigo_venta` int(11) DEFAULT NULL,
  `OCOMDEC_CantidadReal` int(11) NOT NULL,
  `OCOMDEC_flete` double UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_ocompradetalle`
--

INSERT INTO `cji_ocompradetalle` (`OCOMDEP_Codigo`, `OCOMP_Codigo`, `PROD_Codigo`, `OCOMDEC_GenInd`, `UNDMED_Codigo`, `LOTP_Codigo`, `AFECT_Codigo`, `OCOMDEC_Pu`, `OCOMDEC_Igv100`, `OCOMDEC_Descuento100`, `OCOMDEC_Cantidad`, `OCOMDEC_Pendiente`, `OCOMDEC_Pendiente_pago`, `OCOMDEC_Subtotal`, `OCOMDEC_Descuento`, `OCOMDEC_Descuento2`, `OCOMDEC_Igv`, `OCOMDEC_Total`, `OCOMDEC_Pu_ConIgv`, `OCOMDEC_Costo`, `OCOMDEC_Descripcion`, `OCOMDEC_Observacion`, `OCOMDEC_FechaModificacion`, `OCOMDEC_FechaRegistro`, `OCOMDEC_FlagIngreso`, `OCOMDEC_FlagEstado`, `OCOMP_Codigo_venta`, `OCOMDEC_CantidadReal`, `OCOMDEC_flete`) VALUES
(1, 1, 2, '', 1, 0, 1, 19.491525423728813, 18, 0, 2, 4, 3, 38.983050847457626, 0, 0, 7.01695, 46, 23, 0, 'TEST', '', NULL, '2023-10-06 15:51:57', '0', '1', 0, 0, 0),
(2, 2, 3, '', 1, 0, 1, 66.10169491525424, 18, 0, 4, 4, 4, 264.40677966101697, 0, 0, 47.59322033898303, 312, 78, 0, 'PRODUCTO TEST', '', NULL, '2023-10-06 16:11:43', '0', '1', 0, 0, 0),
(3, 3, 3, '', 1, 0, 1, 66.10169491525424, 18, 0, 6, 6, 6, 396.6101694915254, 0, 0, 71.38983050847455, 468, 78, 0, 'PRODUCTO TEST', '', NULL, '2023-10-06 16:13:15', '0', '1', 0, 0, 0),
(4, 4, 3, '', 1, 0, 1, 25.423728813559322, 18, 0, 13, 13, 13, 330.50847457627117, 0, 0, 59.49152542372882, 390, 30, 30, 'PRODUCTO TEST', '', NULL, '2023-10-06 21:52:50', '0', '1', 0, 0, 0),
(5, 5, 2, '', 1, 0, 1, 19.491525423728813, 18, 0, 1, 1, 1, 19.491525423728813, 0, 0, 3.508474576271187, 23, 23, 23, 'TEST', '', NULL, '2023-10-06 22:20:07', '0', '1', 0, 0, 0),
(6, 6, 3, '', 1, 0, 1, 25.423728813559322, 18, 0, 1, 1, 1, 25.423728813559322, 0, 0, 4.576271186440678, 30, 30, 30, 'PRODUCTO TEST', '', NULL, '2023-10-07 15:28:14', '0', '1', 0, 0, 0),
(7, 7, 2, '', 1, 0, 1, 19.491525423728813, 18, 0, 3, 3, 3, 58.474576271186436, 0, 0, 10.52542, 69, 23, 23, 'TEST', '', NULL, '2023-10-07 15:30:58', '0', '1', 0, 0, 0),
(8, 8, 3, '', 1, 0, 1, 2.5423728813559325, 18, 0, 11, 11, 11, 27.96610169491526, 0, 0, 5.033898305084742, 33, 3, 30, 'PRODUCTO TEST', '', NULL, '2023-10-07 16:44:54', '0', '1', 0, 0, 0),
(9, 9, 3, '', 1, 0, 1, 28.8135593220339, 18, 0, 12, 12, 12, 345.7627118644068, 0, 0, 62.237288135593204, 408, 34, 30, 'PRODUCTO TEST', '', NULL, '2023-10-07 17:33:15', '0', '1', 0, 0, 0),
(10, 10, 3, '', 1, 0, 1, 25.423728813559322, 18, 0, 12, 12, 12, 305.08474576271186, 0, 0, 54.91525, 360, 30, 30, 'PRODUCTO TEST', '', NULL, '2023-10-07 17:45:09', '0', '1', 0, 0, 0),
(11, 11, 2, '', 1, 0, 1, 1.6949152542372883, 18, 0, 1, 1, 1, 1.6949152542372883, 0, 0, 0.3050847457627117, 2, 2, 23, 'TEST', '', NULL, '2023-10-09 17:48:09', '0', '1', 0, 0, 0),
(12, 12, 3, '', 1, 0, 1, 2.5423728813559325, 18, 0, 14, 14, 14, 35.59322033898306, 0, 0, 6.4067796610169445, 42, 3, 30, 'PRODUCTO TEST', '', NULL, '2023-10-09 17:55:39', '0', '1', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cji_ocompra_importacion`
--

CREATE TABLE `cji_ocompra_importacion` (
  `OCOMP_Codigo` int(11) UNSIGNED NOT NULL,
  `IMPOR_Codigo` int(11) UNSIGNED NOT NULL,
  `OCOMPIMP_fechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `OCOMPIMP_fechaModificacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OCOMPIMP_usuario` int(10) UNSIGNED NOT NULL,
  `OCOMPIMP_flagEstado` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cji_ordencompra`
--

CREATE TABLE `cji_ordencompra` (
  `OCOMP_Codigo` int(11) NOT NULL,
  `OCOMC_TipoOperacion` char(1) NOT NULL DEFAULT 'C' COMMENT 'V: venta, C: compra',
  `PRESUP_Codigo` int(11) DEFAULT NULL,
  `COTIP_Codigo` int(11) DEFAULT NULL,
  `PEDIP_Codigo` int(11) DEFAULT NULL,
  `OCOMC_Serie` char(6) NOT NULL,
  `OCOMC_Numero` int(11) NOT NULL,
  `OCOMC_CodigoUsuario` varchar(50) DEFAULT NULL,
  `OCOMC_descuento100` float NOT NULL DEFAULT '0',
  `OCOMC_igv100` int(11) NOT NULL DEFAULT '0',
  `OCOMC_percepcion100` double NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `CENCOSP_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `PROYP_Codigo` int(11) DEFAULT NULL,
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `ALMAP_Codigo` int(11) DEFAULT NULL,
  `OCOMC_subtotal` double(10,2) NOT NULL DEFAULT '0.00',
  `OCOMC_descuento` double(10,2) NOT NULL DEFAULT '0.00',
  `OCOMC_igv` double(10,2) NOT NULL DEFAULT '0.00',
  `OCOMC_percepcion` double(10,2) NOT NULL DEFAULT '0.00',
  `OCOMC_total` double(10,2) NOT NULL DEFAULT '0.00',
  `OCOMC_CtaCteSoles` varchar(50) DEFAULT NULL,
  `OCOMC_CtaCteDolares` varchar(50) DEFAULT NULL,
  `OCOMC_Observacion` text,
  `OCOMC_EnvioDireccion` varchar(250) DEFAULT NULL,
  `OCOMC_FactDireccion` varchar(250) DEFAULT NULL,
  `OCOMC_PersonaAutorizada` varchar(250) DEFAULT NULL,
  `OCOMC_Fecha` date NOT NULL,
  `OCOMC_FechaEntrega` date DEFAULT NULL,
  `OCOMC_NumeroFactura` int(11) DEFAULT NULL,
  `OCOMC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `OCOMC_FechaModificacion` datetime DEFAULT NULL,
  `OCOMC_FlagIngreso` char(1) NOT NULL DEFAULT '0',
  `OCOMC_Personal` int(11) DEFAULT NULL,
  `OCOMC_MiPersonal` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `OCOMC_FlagAprobado` char(1) NOT NULL DEFAULT '0' COMMENT '0: No evaluado, 1: aprobado, 2: desaprobado',
  `OCOMC_FlagMueveStock` char(1) NOT NULL DEFAULT '0',
  `GUIASAP_Codigo` int(11) DEFAULT NULL,
  `OCOMC_Entrega` varchar(100) DEFAULT NULL,
  `OCOMC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `OCOMC_FlagTerminado` char(1) NOT NULL DEFAULT '0' COMMENT '0 = NO TERMINADO, 1=TERMINADO',
  `OCOMC_FlagBS` char(1) NOT NULL DEFAULT 'B',
  `OCOMP_CodigoVenta` int(11) DEFAULT NULL,
  `OCOMC_FlagTerminadoProceso` char(1) NOT NULL DEFAULT '0',
  `OCOMP_FlagImportado` bit(1) NOT NULL DEFAULT b'0',
  `OCOMP_TDC` decimal(10,3) NOT NULL,
  `OCOMP_TDC_opcional` decimal(10,3) NOT NULL,
  `CPC_TipoDocumento` char(1) NOT NULL DEFAULT 'F' COMMENT 'F: factura, B: boleta, N: nunguno de los dos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_ordencompra`
--

INSERT INTO `cji_ordencompra` (`OCOMP_Codigo`, `OCOMC_TipoOperacion`, `PRESUP_Codigo`, `COTIP_Codigo`, `PEDIP_Codigo`, `OCOMC_Serie`, `OCOMC_Numero`, `OCOMC_CodigoUsuario`, `OCOMC_descuento100`, `OCOMC_igv100`, `OCOMC_percepcion100`, `CLIP_Codigo`, `PROVP_Codigo`, `USUA_Codigo`, `CENCOSP_Codigo`, `MONED_Codigo`, `PROYP_Codigo`, `FORPAP_Codigo`, `ALMAP_Codigo`, `OCOMC_subtotal`, `OCOMC_descuento`, `OCOMC_igv`, `OCOMC_percepcion`, `OCOMC_total`, `OCOMC_CtaCteSoles`, `OCOMC_CtaCteDolares`, `OCOMC_Observacion`, `OCOMC_EnvioDireccion`, `OCOMC_FactDireccion`, `OCOMC_PersonaAutorizada`, `OCOMC_Fecha`, `OCOMC_FechaEntrega`, `OCOMC_NumeroFactura`, `OCOMC_FechaRegistro`, `OCOMC_FechaModificacion`, `OCOMC_FlagIngreso`, `OCOMC_Personal`, `OCOMC_MiPersonal`, `COMPP_Codigo`, `OCOMC_FlagAprobado`, `OCOMC_FlagMueveStock`, `GUIASAP_Codigo`, `OCOMC_Entrega`, `OCOMC_FlagEstado`, `OCOMC_FlagTerminado`, `OCOMC_FlagBS`, `OCOMP_CodigoVenta`, `OCOMC_FlagTerminadoProceso`, `OCOMP_FlagImportado`, `OCOMP_TDC`, `OCOMP_TDC_opcional`, `CPC_TipoDocumento`) VALUES
(1, 'V', NULL, NULL, NULL, 'COT1', 1, '', 0, 18, 0, 1, NULL, 1, 1, 1, 0, 1, 1, 38.98, 0.00, 7.02, 0.00, 46.00, '', '', '', '', '', NULL, '2023-10-06', NULL, NULL, '2023-10-06 15:51:56', NULL, '0', NULL, NULL, 1, '0', '0', NULL, '', '1', '0', '', 0, '0', b'0', '3.700', '0.000', 'N'),
(2, 'V', NULL, NULL, NULL, 'COT1', 2, '', 0, 18, 0, 1, NULL, 1, 1, 1, 0, 1, 1, 264.41, 0.00, 47.59, 0.00, 312.00, '', '', '', '', '', NULL, '2023-10-06', NULL, NULL, '2023-10-06 16:11:43', NULL, '0', NULL, NULL, 1, '0', '0', NULL, '', '1', '0', '', 0, '0', b'0', '3.700', '0.000', 'N'),
(3, 'V', NULL, NULL, NULL, 'COT1', 3, '', 0, 18, 0, 1, NULL, 1, 1, 1, 0, 1, 1, 396.61, 0.00, 71.39, 0.00, 468.00, '', '', '', '', '', NULL, '2023-10-06', NULL, NULL, '2023-10-06 16:13:14', NULL, '0', NULL, NULL, 1, '0', '0', NULL, '', '1', '0', '', 0, '1', b'0', '3.700', '0.000', 'N'),
(4, 'C', NULL, NULL, NULL, '0001', 1, '', 0, 18, 0, NULL, 1, 1, 1, 1, 0, 1, 1, 330.51, 0.00, 59.49, 0.00, 390.00, '', '', '', 'CAL. MARISCAL SUCRE NRO. 1513 SEC. PUEBLO NUEVO, CAJAMARCA - JAEN - JAEN', 'CAL. MARISCAL SUCRE NRO. 1513 SEC. PUEBLO NUEVO, CAJAMARCA - JAEN - JAEN', NULL, '2023-10-06', '2023-10-13', NULL, '2023-10-06 21:52:50', NULL, '0', NULL, NULL, 1, '0', '0', NULL, '', '1', '0', 'B', 0, '1', b'0', '3.700', '0.000', 'F'),
(5, 'C', NULL, NULL, NULL, '0001', 2, '', 0, 18, 0, NULL, 2, 1, 1, 1, 0, 1, 1, 19.49, 0.00, 3.51, 0.00, 23.00, '', '', '', '', '', NULL, '2023-10-06', NULL, NULL, '2023-10-06 22:20:06', NULL, '0', NULL, NULL, 1, '0', '0', NULL, '', '1', '0', 'B', 0, '1', b'0', '3.700', '0.000', 'F'),
(6, 'C', NULL, NULL, NULL, '0001', 3, '', 0, 18, 0, NULL, 2, 1, 1, 1, 0, 1, 1, 25.42, 0.00, 4.58, 0.00, 30.00, '', '', '', '', '', NULL, '2023-10-07', NULL, NULL, '2023-10-07 15:28:13', NULL, '0', NULL, NULL, 1, '0', '0', NULL, '', '1', '0', 'B', 0, '1', b'0', '3.700', '0.000', 'F'),
(7, 'C', NULL, NULL, NULL, '0001', 4, '', 0, 18, 0, NULL, 1, 1, 1, 1, 0, 1, 1, 58.47, 0.00, 10.53, 0.00, 69.00, '', '', '', '', '', NULL, '2023-10-07', NULL, NULL, '2023-10-07 15:30:58', NULL, '0', NULL, NULL, 1, '0', '0', NULL, '', '1', '0', 'B', 0, '1', b'0', '3.700', '0.000', 'F'),
(8, 'V', NULL, NULL, NULL, 'COT1', 4, '', 0, 18, 0, 1, NULL, 1, 1, 1, 0, 1, 1, 27.97, 0.00, 5.03, 0.00, 33.00, '', '', '', '', '', NULL, '2023-10-07', NULL, NULL, '2023-10-07 16:44:54', NULL, '0', NULL, NULL, 1, '0', '0', NULL, '', '1', '0', '', 0, '0', b'0', '3.700', '0.000', 'N'),
(9, 'V', NULL, NULL, NULL, 'COT1', 5, '', 0, 18, 0, 1, NULL, 1, 1, 1, 0, 1, 1, 345.76, 0.00, 62.24, 0.00, 408.00, '', '', '', '', '', NULL, '2023-10-07', NULL, NULL, '2023-10-07 17:33:14', NULL, '0', NULL, NULL, 1, '0', '0', NULL, '', '1', '0', '', 0, '0', b'0', '3.700', '0.000', 'N'),
(10, 'C', NULL, NULL, NULL, '0001', 5, '', 0, 18, 0, NULL, 2, 2, 1, 1, 0, 1, 1, 305.08, 0.00, 54.92, 0.00, 360.00, '', '', '', '', '', NULL, '2023-10-07', NULL, NULL, '2023-10-07 17:45:09', NULL, '0', NULL, NULL, 1, '0', '0', NULL, '', '1', '0', 'B', 0, '1', b'0', '3.700', '0.000', 'F'),
(11, 'V', NULL, NULL, NULL, 'COT2', 1, '', 0, 18, 0, 4, NULL, 2, 1, 1, 0, 1, 2, 1.69, 0.00, 0.31, 0.00, 2.00, '', '', '', '', '', NULL, '2023-10-09', NULL, NULL, '2023-10-09 17:48:09', NULL, '0', NULL, NULL, 2, '0', '0', NULL, '', '1', '0', '', 0, '0', b'0', '3.700', '0.000', 'N'),
(12, 'V', NULL, NULL, NULL, 'COT2', 2, '', 0, 18, 0, 5, NULL, 2, 1, 1, 0, 1, 2, 35.59, 0.00, 6.41, 0.00, 42.00, '', '', '', '', '', NULL, '2023-10-09', NULL, NULL, '2023-10-09 17:55:39', NULL, '0', NULL, NULL, 2, '0', '0', NULL, '', '1', '0', '', 0, '0', b'0', '3.700', '0.000', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `cji_pago`
--

CREATE TABLE `cji_pago` (
  `PAGP_Codigo` int(11) NOT NULL,
  `PAGC_TipoCuenta` int(11) NOT NULL COMMENT '1: Cuenta por cobrar, 2: Cuenta por pagar',
  `PAGC_FechaOper` date NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `PAGC_TDC` double(10,2) DEFAULT NULL,
  `PAGC_Monto` double NOT NULL,
  `MONED_Codigo` int(11) NOT NULL,
  `PAGC_FormaPago` int(11) NOT NULL,
  `CUENT_CodigoCP` int(11) DEFAULT NULL COMMENT 'Cuenta bancaria del cliente | proveedor',
  `CUENT_CodigoEmpresa` int(11) DEFAULT NULL COMMENT 'MI CUENTA DE EMPRESA',
  `PAGC_DepoNro` varchar(50) DEFAULT NULL,
  `CHEP_Codigo` int(11) DEFAULT NULL,
  `PAGC_NotaCredito` int(11) DEFAULT NULL,
  `PAGC_Trans` varchar(100) NOT NULL,
  `PAGC_Saldo` double(10,2) NOT NULL DEFAULT '0.00',
  `PAGC_Obs` text,
  `COMPP_Codigo` int(11) NOT NULL,
  `PAGC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PAGC_FechaModificacion` datetime DEFAULT NULL,
  `PAGC_FlagEstado` varchar(1) NOT NULL DEFAULT '1',
  `PAGP_Serie` int(11) DEFAULT NULL,
  `PAGP_Numero` int(11) DEFAULT NULL,
  `PAGC_DescObs` varchar(20) DEFAULT NULL,
  `PAGC_Factura` varchar(20) DEFAULT NULL,
  `PAGC_DepoCta` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_pedido`
--

CREATE TABLE `cji_pedido` (
  `PEDIP_Codigo` int(11) NOT NULL,
  `PEDIC_TipoDocume` varchar(250) DEFAULT NULL COMMENT 'V:venta ; C:compra',
  `PEDIC_Numero` int(11) DEFAULT NULL,
  `PEDIC_Serie` int(11) NOT NULL,
  `PEDIC_FechaSistema` timestamp NULL DEFAULT NULL,
  `MONED_Codigo` int(11) NOT NULL,
  `PROYP_Codigo` int(11) NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PERSP_Codigo` int(11) DEFAULT NULL,
  `ECONP_Contacto` int(11) DEFAULT NULL,
  `OCOMP_Codigo` int(11) DEFAULT NULL,
  `PEDIC_IGV` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `PEDIC_ImporteBruto` double(10,2) DEFAULT NULL,
  `PEDIC_Descuento100` double(10,2) NOT NULL,
  `PEDIC_DescuentoTotal` double(10,2) DEFAULT NULL,
  `PEDIC_ValorVenta` double(10,2) DEFAULT NULL,
  `PEDIC_IGVTotal` double(10,2) DEFAULT NULL,
  `PEDIC_PrecioTotal` double(10,2) DEFAULT NULL,
  `PEDIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PEDIC_FechaModificacion` datetime DEFAULT NULL,
  `PEDIC_FlagEstado` char(1) DEFAULT '1',
  `PEDIC_EstadoPresupuesto` int(11) NOT NULL,
  `PRESUP_Codigo` int(11) NOT NULL,
  `PEDIC_Observacion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_pedidodetalle`
--

CREATE TABLE `cji_pedidodetalle` (
  `PEDIDETP_Codigo` int(11) NOT NULL,
  `PEDIP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) NOT NULL,
  `PEDIDETC_Cantidad` double DEFAULT NULL,
  `PEDIDETC_Descuento` double(10,2) NOT NULL,
  `PEDIDETC_Descuento100` double(10,2) NOT NULL,
  `PEDIDETC_PCIGV` double(10,2) NOT NULL,
  `PEDIDETC_PSIGV` double(10,2) NOT NULL,
  `PEDIDETC_Precio` double(10,2) NOT NULL,
  `PEDIDETC_IGV` double(10,2) NOT NULL,
  `PEDIDETC_Importe` double(10,2) NOT NULL,
  `PEDIDETC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PEDIDETC_FechaModificacion` datetime DEFAULT NULL,
  `PEDIDETC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_permiso`
--

CREATE TABLE `cji_permiso` (
  `PERM_Codigo` int(11) NOT NULL,
  `ROL_Codigo` int(11) NOT NULL,
  `MENU_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `PERM_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_permiso`
--

INSERT INTO `cji_permiso` (`PERM_Codigo`, `ROL_Codigo`, `MENU_Codigo`, `COMPP_Codigo`, `PERM_FlagEstado`) VALUES
(38, 7000, 2, 1, '1'),
(39, 7000, 3, 1, '1'),
(40, 7000, 4, 1, '1'),
(41, 7000, 5, 1, '1'),
(42, 7000, 6, 1, '1'),
(43, 7000, 7, 1, '1'),
(44, 7000, 8, 1, '1'),
(45, 7000, 9, 1, '1'),
(46, 7000, 10, 1, '1'),
(47, 7000, 11, 1, '1'),
(48, 7000, 12, 1, '1'),
(49, 7000, 13, 1, '1'),
(50, 7000, 14, 1, '1'),
(51, 7000, 15, 1, '1'),
(52, 7000, 16, 1, '1'),
(53, 7000, 17, 1, '1'),
(54, 7000, 18, 1, '1'),
(55, 7000, 19, 1, '1'),
(56, 7000, 20, 1, '1'),
(57, 7000, 21, 1, '1'),
(58, 7000, 22, 1, '1'),
(59, 7000, 23, 1, '1'),
(60, 7000, 24, 1, '1'),
(61, 7000, 25, 1, '1'),
(62, 7000, 26, 1, '1'),
(63, 7000, 27, 1, '1'),
(64, 7000, 28, 1, '1'),
(65, 7000, 29, 1, '1'),
(66, 7000, 30, 1, '1'),
(67, 7000, 31, 1, '1'),
(68, 7000, 32, 1, '1'),
(69, 7000, 33, 1, '1'),
(70, 7000, 34, 1, '1'),
(71, 7000, 35, 1, '1'),
(72, 7000, 36, 1, '1'),
(73, 7000, 37, 1, '1'),
(74, 7000, 38, 1, '1'),
(75, 7000, 39, 1, '1'),
(76, 7000, 40, 1, '1'),
(77, 7000, 42, 1, '1'),
(78, 7000, 43, 1, '1'),
(79, 7000, 44, 1, '1'),
(80, 7000, 45, 1, '1'),
(81, 7000, 46, 1, '1'),
(82, 7000, 47, 1, '1'),
(83, 7000, 48, 1, '1'),
(84, 7000, 49, 1, '1'),
(85, 7000, 50, 1, '1'),
(86, 7000, 51, 1, '1'),
(87, 7000, 52, 1, '1'),
(88, 7000, 53, 1, '1'),
(89, 7000, 54, 1, '1'),
(90, 7000, 55, 1, '1'),
(91, 7000, 56, 1, '1'),
(92, 7000, 57, 1, '1'),
(93, 7000, 58, 1, '1'),
(94, 7000, 59, 1, '1'),
(95, 7000, 60, 1, '1'),
(96, 7000, 61, 1, '1'),
(97, 7000, 62, 1, '1'),
(98, 7000, 63, 1, '1'),
(99, 7000, 64, 1, '1'),
(100, 7000, 65, 1, '1'),
(101, 7000, 66, 1, '1'),
(102, 7000, 67, 1, '1'),
(103, 7000, 68, 1, '1'),
(104, 7000, 69, 1, '1'),
(105, 7000, 70, 1, '1'),
(106, 7000, 71, 1, '1'),
(107, 7000, 72, 1, '1'),
(108, 7000, 73, 1, '1'),
(109, 7000, 74, 1, '1'),
(111, 7000, 76, 1, '1'),
(112, 7000, 77, 1, '1'),
(113, 7000, 78, 1, '1'),
(114, 7000, 79, 1, '1'),
(115, 7000, 80, 1, '1'),
(116, 7000, 81, 1, '1'),
(117, 7000, 82, 1, '1'),
(118, 7000, 83, 1, '1'),
(119, 7000, 84, 1, '1'),
(120, 7000, 85, 1, '1'),
(121, 7000, 86, 1, '1'),
(122, 7000, 87, 1, '1'),
(123, 7000, 88, 1, '1'),
(124, 7000, 89, 1, '1'),
(125, 7000, 90, 1, '1'),
(126, 7000, 91, 1, '1'),
(127, 7000, 92, 1, '1'),
(128, 7000, 93, 1, '1'),
(129, 7000, 94, 1, '1'),
(130, 7000, 95, 1, '1'),
(131, 7000, 96, 1, '1'),
(132, 7000, 97, 1, '1'),
(133, 7000, 98, 1, '1'),
(134, 7000, 99, 1, '1'),
(135, 7000, 100, 1, '1'),
(136, 7000, 101, 1, '1'),
(137, 7000, 102, 1, '1'),
(138, 7000, 103, 1, '1'),
(139, 7000, 104, 1, '1'),
(140, 7000, 105, 1, '1'),
(141, 7000, 106, 1, '1'),
(142, 7000, 107, 1, '1'),
(143, 7000, 108, 1, '1'),
(144, 7000, 109, 1, '1'),
(146, 7000, 111, 1, '1'),
(147, 7000, 112, 1, '1'),
(148, 7000, 113, 1, '1'),
(149, 7000, 114, 1, '1'),
(150, 7000, 115, 1, '1'),
(151, 7000, 116, 1, '1'),
(152, 7000, 117, 1, '1'),
(288, 7000, 118, 1, '1'),
(480, 7000, 119, 1, '1'),
(481, 7000, 120, 1, '1'),
(600, 7000, 121, 1, '1'),
(602, 7000, 110, 1, '1'),
(603, 7000, 75, 1, '1'),
(605, 7000, 123, 1, '1'),
(789, 7000, 124, 1, '1'),
(1239, 7000, 126, 1, '1'),
(1240, 1, 2, 1, '1'),
(1241, 1, 10, 1, '1'),
(1242, 1, 11, 1, '1'),
(1243, 1, 87, 1, '1'),
(1244, 1, 3, 1, '1'),
(1245, 1, 12, 1, '1'),
(1246, 1, 13, 1, '1'),
(1247, 1, 39, 1, '1'),
(1248, 1, 40, 1, '1'),
(1249, 1, 64, 1, '1'),
(1250, 1, 66, 1, '1'),
(1251, 1, 71, 1, '1'),
(1252, 1, 74, 1, '1'),
(1253, 1, 90, 1, '1'),
(1255, 1, 4, 1, '1'),
(1256, 1, 16, 1, '1'),
(1257, 1, 18, 1, '1'),
(1258, 1, 52, 1, '1'),
(1259, 1, 53, 1, '1'),
(1260, 1, 57, 1, '1'),
(1261, 1, 82, 1, '1'),
(1262, 1, 98, 1, '1'),
(1263, 1, 5, 1, '1'),
(1264, 1, 20, 1, '1'),
(1265, 1, 54, 1, '1'),
(1266, 1, 55, 1, '1'),
(1267, 1, 56, 1, '1'),
(1268, 1, 58, 1, '1'),
(1269, 1, 83, 1, '1'),
(1270, 1, 6, 1, '1'),
(1271, 1, 21, 1, '1'),
(1272, 1, 22, 1, '1'),
(1273, 1, 23, 1, '1'),
(1274, 1, 101, 1, '1'),
(1275, 1, 103, 1, '1'),
(1276, 1, 119, 1, '1'),
(1277, 1, 120, 1, '1'),
(1278, 1, 7, 1, '1'),
(1279, 1, 25, 1, '1'),
(1280, 1, 26, 1, '1'),
(1281, 1, 28, 1, '1'),
(1282, 1, 30, 1, '1'),
(1283, 1, 32, 1, '1'),
(1284, 1, 33, 1, '1'),
(1285, 1, 34, 1, '1'),
(1286, 1, 46, 1, '1'),
(1287, 1, 49, 1, '1'),
(1288, 1, 104, 1, '1'),
(1289, 1, 9, 1, '1'),
(1290, 1, 43, 1, '1'),
(1291, 1, 67, 1, '1'),
(1292, 1, 68, 1, '1'),
(1293, 1, 69, 1, '1'),
(1294, 1, 70, 1, '1'),
(1295, 1, 75, 1, '1'),
(1296, 1, 106, 1, '1'),
(1297, 1, 93, 1, '1'),
(1298, 1, 94, 1, '1'),
(1299, 1, 95, 1, '1'),
(1324, 7000, 127, 1, '1'),
(1349, 7003, 2, 3, '1'),
(1350, 7003, 10, 3, '1'),
(1351, 7003, 11, 3, '1'),
(1352, 7003, 3, 3, '1'),
(1353, 7003, 12, 3, '1'),
(1354, 7003, 13, 3, '1'),
(1355, 7003, 39, 3, '1'),
(1356, 7003, 40, 3, '1'),
(1357, 7003, 64, 3, '1'),
(1358, 7003, 66, 3, '1'),
(1359, 7003, 71, 3, '1'),
(1360, 7003, 74, 3, '1'),
(1361, 7003, 90, 3, '1'),
(1365, 7000, 129, 1, '1'),
(1366, 1, 129, 1, '1'),
(1369, 7002, 2, 1, '1'),
(1370, 7002, 11, 1, '1'),
(1371, 7002, 4, 1, '1'),
(1372, 7002, 18, 1, '1'),
(1373, 7002, 52, 1, '1'),
(1376, 7005, 3, 1, '1'),
(1377, 7005, 12, 1, '1'),
(1378, 7005, 4, 1, '1'),
(1379, 7005, 18, 1, '1'),
(1380, 7005, 52, 1, '1'),
(1394, 7006, 4, 1, '1'),
(1395, 7006, 16, 1, '1'),
(1396, 7006, 18, 1, '1'),
(1397, 7006, 52, 1, '1'),
(1398, 7006, 53, 1, '1'),
(1399, 7006, 57, 1, '1'),
(1400, 7006, 82, 1, '1'),
(1401, 7006, 98, 1, '1'),
(1402, 7006, 129, 1, '1'),
(1403, 7004, 4, 1, '1'),
(1404, 7004, 16, 1, '1'),
(1405, 7004, 18, 1, '1'),
(1406, 7004, 52, 1, '1'),
(1407, 7004, 129, 1, '1'),
(1408, 7001, 3, 1, '1'),
(1409, 7001, 12, 1, '1'),
(1410, 7001, 13, 1, '1'),
(1411, 7001, 39, 1, '1'),
(1412, 7001, 40, 1, '1'),
(1413, 7001, 64, 1, '1'),
(1414, 7001, 66, 1, '1'),
(1415, 7001, 71, 1, '1'),
(1416, 7001, 74, 1, '1'),
(1417, 7001, 90, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_persona`
--

CREATE TABLE `cji_persona` (
  `PERSP_Codigo` int(11) NOT NULL,
  `UBIGP_LugarNacimiento` char(6) NOT NULL,
  `UBIGP_Domicilio` char(6) NOT NULL,
  `ESTCP_EstadoCivil` int(11) DEFAULT NULL,
  `NACP_Nacionalidad` int(11) NOT NULL,
  `PERSC_TipoDocIdentidad` int(11) DEFAULT NULL,
  `PERSC_Nombre` varchar(150) DEFAULT NULL,
  `PERSC_ApellidoPaterno` varchar(150) DEFAULT NULL,
  `PERSC_ApellidoMaterno` varchar(150) DEFAULT NULL,
  `PERSC_Ruc` varchar(11) DEFAULT NULL,
  `PERSC_NumeroDocIdentidad` varchar(50) DEFAULT NULL,
  `PERSC_FechaNac` date NOT NULL,
  `PERSC_Direccion` varchar(250) DEFAULT NULL,
  `PERSC_Telefono` varchar(20) DEFAULT NULL,
  `PERSC_Movil` varchar(20) DEFAULT NULL,
  `PERSC_Fax` varchar(20) DEFAULT NULL,
  `PERSC_Email` varchar(200) DEFAULT NULL,
  `PERSC_Domicilio` varchar(250) DEFAULT NULL,
  `PERSC_Web` varchar(250) DEFAULT NULL,
  `PERSC_Sexo` char(1) DEFAULT NULL COMMENT 'M = MASCULINO, F = FEMENINO',
  `BANP_Codigo` int(11) DEFAULT NULL,
  `PERSC_CtaCteSoles` varchar(50) DEFAULT NULL,
  `PERSC_CtaCteDolares` varchar(50) DEFAULT NULL,
  `PERSC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `PERSC_FechaModificacion` datetime DEFAULT NULL,
  `PERSC_FlagEstado` char(1) DEFAULT '1',
  `PERSC_FechaNacz` date NOT NULL,
  `PERSC_EmpCod` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_persona`
--

INSERT INTO `cji_persona` (`PERSP_Codigo`, `UBIGP_LugarNacimiento`, `UBIGP_Domicilio`, `ESTCP_EstadoCivil`, `NACP_Nacionalidad`, `PERSC_TipoDocIdentidad`, `PERSC_Nombre`, `PERSC_ApellidoPaterno`, `PERSC_ApellidoMaterno`, `PERSC_Ruc`, `PERSC_NumeroDocIdentidad`, `PERSC_FechaNac`, `PERSC_Direccion`, `PERSC_Telefono`, `PERSC_Movil`, `PERSC_Fax`, `PERSC_Email`, `PERSC_Domicilio`, `PERSC_Web`, `PERSC_Sexo`, `BANP_Codigo`, `PERSC_CtaCteSoles`, `PERSC_CtaCteDolares`, `PERSC_FechaRegistro`, `PERSC_FechaModificacion`, `PERSC_FlagEstado`, `PERSC_FechaNacz`, `PERSC_EmpCod`) VALUES
(1, '000000', '000000', 1, 265, 1, 'ADMIN', 'ADMIN', 'GENERAL', '', '69999991', '0000-00-00', '-', '', '', '', 'default@osa-fact.com', '-', '', 'M', 0, '', '', '2019-10-11 20:30:57', NULL, '1', '2000-01-01', 1),
(2, '00', '00', NULL, 0, 0, 'CCAPASISTEMAS', 'TECNOLOGIA', 'DE INFORMACION', NULL, NULL, '2019-03-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-10-11 20:31:01', NULL, '0', '2019-03-08', 1),
(5, '000000', '150101', 1, 193, 2, 'CLIENTES', 'VARIOS', '-', '', '-', '0000-00-00', '-', '', '', '', '', '-', '', 'M', NULL, NULL, NULL, '2022-08-19 15:16:06', NULL, '1', '0000-00-00', 1),
(6, '000000', '150101', 0, 0, 1, 'EMERSON RAMON', 'CANCHOS', 'CHAVEZ', '', '47904249', '0000-00-00', '-', '', '', '', '', '-', '', '0', NULL, NULL, NULL, '2022-09-02 21:17:51', NULL, '1', '0000-00-00', 1),
(7, '000000', '150102', 1, 193, 4, 'YANERLY CHIQUINQUIRá', ' RODRíGUEZ', 'RODRíGUEZ', '', '005898593', '0000-00-00', '-', '', '', '', '', '-', '', 'F', NULL, NULL, NULL, '2023-10-06 20:37:17', NULL, '1', '0000-00-00', 1),
(8, '000000', '150101', 1, 193, 1, 'ERICK JORDAN', 'CARRILLO', 'SILVA', '', '74279274', '1997-06-09', '-', '', '', '', '', '-', '', 'M', NULL, NULL, NULL, '2023-10-09 17:54:56', NULL, '1', '1997-06-09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cji_plantilla`
--

CREATE TABLE `cji_plantilla` (
  `PLANT_Codigo` int(11) NOT NULL,
  `ATRIB_Codigo` int(11) DEFAULT NULL,
  `TIPPROD_Codigo` int(11) DEFAULT NULL,
  `PRODTIP_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODTIP_FechaModificacion` datetime DEFAULT NULL,
  `PLANT_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_prestamo`
--

CREATE TABLE `cji_prestamo` (
  `PRES_Codigo` int(11) NOT NULL,
  `PRES_Nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `PRES_Apellido` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `PRES_Dni` int(10) DEFAULT NULL,
  `PRES_Cargo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `PRES_Forma` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `PRES_Precio` int(10) DEFAULT NULL,
  `PRES_Observacion` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `PRES_Fecha` date DEFAULT NULL,
  `PRES_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `PRES_FlagEstado` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cji_presupuesto`
--

CREATE TABLE `cji_presupuesto` (
  `PRESUP_Codigo` int(11) NOT NULL,
  `PRESUC_TipoDocumento` char(1) NOT NULL DEFAULT 'F',
  `COMPP_Codigo` int(11) NOT NULL DEFAULT '0',
  `PRESUC_Serie` varchar(10) DEFAULT '003',
  `PRESUC_Numero` int(11) DEFAULT NULL,
  `PRESUC_CodigoUsuario` varchar(50) DEFAULT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PRESUC_NombreAuxiliar` varchar(25) DEFAULT 'CLIENTE',
  `USUA_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `PRESUC_subtotal` double(10,2) DEFAULT NULL,
  `PRESUC_descuento` double(10,2) DEFAULT NULL,
  `PRESUC_igv` double(10,2) DEFAULT NULL,
  `PRESUC_total` double(10,2) NOT NULL DEFAULT '0.00',
  `PRESUC_subtotal_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `PRESUC_descuento_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `PRESUC_igv100` int(11) NOT NULL DEFAULT '0',
  `PRESUC_descuento100` int(11) NOT NULL DEFAULT '0',
  `PRESUC_Observacion` varchar(250) DEFAULT NULL,
  `PERSP_Codigo` int(11) DEFAULT NULL,
  `AREAP_Codigo` int(11) DEFAULT NULL,
  `PRESUC_VendedorPersona` int(11) DEFAULT NULL,
  `PRESUC_VenedorArea` int(11) DEFAULT NULL,
  `PRESUC_LugarEntrega` varchar(250) DEFAULT NULL,
  `PRESUC_TiempoEntrega` varchar(100) DEFAULT NULL,
  `PRESUC_Garantia` varchar(100) DEFAULT NULL,
  `PRESUC_Validez` varchar(100) DEFAULT NULL,
  `PRESUC_ModoImpresion` char(1) NOT NULL DEFAULT '1',
  `PRESUC_Fecha` date NOT NULL,
  `PRESUC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRESUC_FechaModificacion` datetime DEFAULT NULL,
  `PRESUC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CPC_TipoOperacion` char(1) NOT NULL DEFAULT 'P' COMMENT 'P: Presupuesto, C : Cotizacion',
  `PEDIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `PRESUP_Seleccion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_presupuestodetalle`
--

CREATE TABLE `cji_presupuestodetalle` (
  `PRESDEP_Codigo` int(11) NOT NULL,
  `PRESUP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `PRESDEC_Cantidad` double DEFAULT '0',
  `PRESDEC_Pu` double DEFAULT NULL,
  `PRESDEC_Subtotal` double DEFAULT NULL,
  `PRESDEC_Descuento` double DEFAULT NULL,
  `PRESDEC_Igv` double DEFAULT NULL,
  `PRESDEC_Total` double NOT NULL DEFAULT '0',
  `PRESDEC_Pu_ConIgv` double NOT NULL DEFAULT '0' COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `PRESDEC_Subtotal_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `PRESDEC_Descuento_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `PRESDEC_Igv100` int(11) DEFAULT '0',
  `PRESDEC_Descuento100` int(11) DEFAULT '0',
  `PRESDEC_Descripcion` varchar(250) DEFAULT NULL,
  `PRESDEC_Observacion` varchar(250) DEFAULT NULL,
  `PRESDEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRESDEC_FechaModificacion` datetime DEFAULT NULL,
  `PRESDEC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_procedencia`
--

CREATE TABLE `cji_procedencia` (
  `PROP_Codigo` int(11) NOT NULL,
  `PROC_Descripcion` varchar(50) DEFAULT NULL,
  `PROC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PROC_FechaModificacion` datetime DEFAULT NULL,
  `PROC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_produccion`
--

CREATE TABLE `cji_produccion` (
  `PR_Codigo` int(11) NOT NULL,
  `PR_Serie` int(11) NOT NULL,
  `PR_Numero` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `PR_AlmaOrigen` int(11) NOT NULL,
  `PR_AlmaDestino` int(11) NOT NULL,
  `PEDIP_Codigo` int(11) DEFAULT NULL,
  `PR_FechaRecepcion` date NOT NULL,
  `PR_FechaFinalizado` date DEFAULT NULL,
  `PR_Observacion` text,
  `PR_FlagTerminado` char(1) NOT NULL,
  `PR_FlagEstado` char(1) NOT NULL,
  `PR_FlagOC` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_producciondetalle`
--

CREATE TABLE `cji_producciondetalle` (
  `PRD_Codigo` int(11) NOT NULL,
  `PR_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `PRD_Cantidad` int(11) NOT NULL,
  `PRD_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_producto`
--

CREATE TABLE `cji_producto` (
  `PROD_Codigo` int(11) NOT NULL,
  `PROD_FlagBienServicio` char(1) NOT NULL DEFAULT 'B' COMMENT 'B: Bien, S: Servicio',
  `AFECT_Codigo` int(11) NOT NULL,
  `FAMI_Codigo` int(11) DEFAULT NULL,
  `TIPPROD_Codigo` int(11) DEFAULT NULL,
  `MARCP_Codigo` int(11) DEFAULT NULL,
  `LINP_Codigo` int(11) DEFAULT NULL,
  `FABRIP_Codigo` int(11) DEFAULT NULL,
  `PROD_PadreCodigo` int(11) DEFAULT NULL,
  `PROD_Nombre` varchar(300) DEFAULT NULL,
  `PROD_NombreCorto` varchar(300) DEFAULT NULL,
  `PROD_DescripcionBreve` varchar(200) DEFAULT NULL,
  `PROD_EspecificacionPDF` varchar(100) DEFAULT NULL,
  `PROD_Comentario` text,
  `PROD_Stock` double DEFAULT '0',
  `PROD_StockMinimo` double NOT NULL DEFAULT '0',
  `PROD_StockMaximo` double NOT NULL DEFAULT '0',
  `PROD_CodigoInterno` varchar(100) DEFAULT NULL,
  `PROD_CodigoUsuario` varchar(50) DEFAULT NULL,
  `PROD_Imagen` varchar(100) DEFAULT NULL,
  `PROD_CostoPromedio` double DEFAULT '0',
  `PROD_UltimoCosto` double DEFAULT '0',
  `PROD_Modelo` varchar(150) DEFAULT NULL,
  `PROD_Presentacion` varchar(150) DEFAULT NULL,
  `PROD_GenericoIndividual` char(1) DEFAULT NULL COMMENT 'G: producto de tipo genérico  (no va a tener número de serie), I: producto de tipo individual (va a tener número de serie)',
  `PROD_FechaUltimaCompra` datetime DEFAULT NULL,
  `PROD_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PROD_FechaModificacion` datetime DEFAULT NULL,
  `PROD_FlagActivo` char(1) DEFAULT '1',
  `PROD_FlagEstado` char(1) DEFAULT '1',
  `PROP_Codigo` int(11) DEFAULT NULL,
  `PROD_CodigoOriginal` varchar(50) DEFAULT NULL,
  `PROD_PartidaArancelaria` char(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_producto`
--

INSERT INTO `cji_producto` (`PROD_Codigo`, `PROD_FlagBienServicio`, `AFECT_Codigo`, `FAMI_Codigo`, `TIPPROD_Codigo`, `MARCP_Codigo`, `LINP_Codigo`, `FABRIP_Codigo`, `PROD_PadreCodigo`, `PROD_Nombre`, `PROD_NombreCorto`, `PROD_DescripcionBreve`, `PROD_EspecificacionPDF`, `PROD_Comentario`, `PROD_Stock`, `PROD_StockMinimo`, `PROD_StockMaximo`, `PROD_CodigoInterno`, `PROD_CodigoUsuario`, `PROD_Imagen`, `PROD_CostoPromedio`, `PROD_UltimoCosto`, `PROD_Modelo`, `PROD_Presentacion`, `PROD_GenericoIndividual`, `PROD_FechaUltimaCompra`, `PROD_FechaRegistro`, `PROD_FechaModificacion`, `PROD_FlagActivo`, `PROD_FlagEstado`, `PROP_Codigo`, `PROD_CodigoOriginal`, `PROD_PartidaArancelaria`) VALUES
(1, 'S', 1, 0, NULL, 0, NULL, 0, NULL, 'servicio test', 'servicio test', '', NULL, NULL, 0, 0, 0, 'E001', 'E001', NULL, 0, 0, '', '', 'G', NULL, '2023-10-05 22:49:13', NULL, '1', '1', NULL, '', NULL),
(2, 'B', 1, 0, NULL, 0, NULL, 0, NULL, 'test', 'test', '', NULL, NULL, 0, 0, 0, 'a001', 'a001', NULL, 0, 23, '', '', 'G', NULL, '2023-10-05 22:49:58', NULL, '1', '1', NULL, '', NULL),
(3, 'B', 1, 0, NULL, 0, NULL, 0, NULL, 'producto test', 'producto test', '', NULL, NULL, 0, 0, 0, 'a002', 'a002', NULL, 0, 30, '', '', 'G', NULL, '2023-10-06 16:10:24', NULL, '1', '1', NULL, '', NULL),
(4, 'B', 1, 0, NULL, 0, NULL, 0, NULL, 'producto de prueba', 'producto de prueba', '', NULL, NULL, 0, 0, 0, 'a003', 'a003', NULL, 0, 0, '', '', 'G', NULL, '2023-10-09 15:09:26', NULL, '1', '1', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cji_productoatributo`
--

CREATE TABLE `cji_productoatributo` (
  `PRODATRIB_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `ATRIB_Codigo` int(11) NOT NULL,
  `PRODATRIB_Numerico` double DEFAULT NULL,
  `PRODATRIB_Date` datetime DEFAULT NULL,
  `PRODATRIB_String` varchar(250) DEFAULT NULL,
  `PRODATRIB_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODATRIB_FechaModificacion` datetime DEFAULT NULL,
  `PRODATRIB_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_productocompania`
--

CREATE TABLE `cji_productocompania` (
  `PROD_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_productocompania`
--

INSERT INTO `cji_productocompania` (`PROD_Codigo`, `COMPP_Codigo`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cji_productoprecio`
--

CREATE TABLE `cji_productoprecio` (
  `PRODPREP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `TIPCLIP_Codigo` int(11) DEFAULT '0',
  `EESTABP_Codigo` int(11) DEFAULT '0',
  `MONED_Codigo` int(11) DEFAULT NULL,
  `PRODUNIP_Codigo` int(11) DEFAULT NULL,
  `PRODPREC_PorcGanancia` double DEFAULT NULL,
  `PRODPREC_Precio` double DEFAULT NULL,
  `PRODPREC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODPREC_FechaModificacion` datetime DEFAULT NULL,
  `PRODPREC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_productoprecio`
--

INSERT INTO `cji_productoprecio` (`PRODPREP_Codigo`, `PROD_Codigo`, `TIPCLIP_Codigo`, `EESTABP_Codigo`, `MONED_Codigo`, `PRODUNIP_Codigo`, `PRODPREC_PorcGanancia`, `PRODPREC_Precio`, `PRODPREC_FechaRegistro`, `PRODPREC_FechaModificacion`, `PRODPREC_FlagEstado`) VALUES
(1, 1, 3, 1, 1, 32, NULL, 0, '2023-10-05 22:49:14', NULL, '1'),
(2, 1, 3, 1, 2, 32, NULL, 0, '2023-10-05 22:49:14', NULL, '1'),
(7, 3, 3, 1, 1, 1, NULL, 0, '2023-10-06 17:30:45', NULL, '1'),
(8, 3, 3, 1, 2, 1, NULL, 0, '2023-10-06 17:30:45', NULL, '1'),
(9, 2, 3, 1, 1, 1, NULL, 0, '2023-10-06 21:25:58', NULL, '1'),
(10, 2, 3, 1, 2, 1, NULL, 0, '2023-10-06 21:25:58', NULL, '1'),
(11, 4, 3, 1, 1, 1, NULL, 0, '2023-10-09 15:09:26', NULL, '1'),
(12, 4, 3, 1, 2, 1, NULL, 0, '2023-10-09 15:09:26', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_productoproveedor`
--

CREATE TABLE `cji_productoproveedor` (
  `PRODPROVP_Codigo` int(11) NOT NULL,
  `PROVP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `PRODPROVC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODPROVC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_productopublicacion`
--

CREATE TABLE `cji_productopublicacion` (
  `PRODPUBP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `CATPUBP_Codigo` int(11) NOT NULL,
  `PRODPUBC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODPUBC_FechaModificacion` datetime DEFAULT NULL,
  `PRODPUBC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CATE_Codigo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_productounidad`
--

CREATE TABLE `cji_productounidad` (
  `PRODUNIP_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `PRODUNIC_Factor` varchar(250) DEFAULT NULL,
  `PRODUNIC_flagPrincipal` char(1) DEFAULT '0',
  `PRODUNIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODUNIC_FechaModificacion` datetime DEFAULT NULL,
  `PRODUNIC_flagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_productounidad`
--

INSERT INTO `cji_productounidad` (`PRODUNIP_Codigo`, `UNDMED_Codigo`, `PROD_Codigo`, `PRODUNIC_Factor`, `PRODUNIC_flagPrincipal`, `PRODUNIC_FechaRegistro`, `PRODUNIC_FechaModificacion`, `PRODUNIC_flagEstado`) VALUES
(1, 32, 1, '1', '1', '2023-10-05 22:49:14', NULL, '1'),
(4, 1, 3, '1', '1', '2023-10-06 17:30:45', NULL, '1'),
(5, 1, 2, '1', '1', '2023-10-06 21:25:57', NULL, '1'),
(6, 1, 4, '1', '1', '2023-10-09 15:09:26', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_proveedor`
--

CREATE TABLE `cji_proveedor` (
  `PROVP_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `PROVC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `PROVC_FechaModificacion` datetime DEFAULT NULL,
  `PROVC_TipoPersona` char(1) DEFAULT NULL COMMENT '0::Persona Natural, 1 :Persona Juridica',
  `PROVC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_proveedor`
--

INSERT INTO `cji_proveedor` (`PROVP_Codigo`, `PERSP_Codigo`, `EMPRP_Codigo`, `PROVC_FechaRegistro`, `PROVC_FechaModificacion`, `PROVC_TipoPersona`, `PROVC_FlagEstado`) VALUES
(1, 0, 4, '2023-10-06 17:28:40', NULL, '1', '1'),
(2, 0, 5, '2023-10-06 22:19:24', NULL, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_proveedorcompania`
--

CREATE TABLE `cji_proveedorcompania` (
  `PROVP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_proveedorcompania`
--

INSERT INTO `cji_proveedorcompania` (`PROVP_Codigo`, `COMPP_Codigo`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cji_proveedormarca`
--

CREATE TABLE `cji_proveedormarca` (
  `EMPMARP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `MARCP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_proyecto`
--

CREATE TABLE `cji_proyecto` (
  `PROYP_Codigo` int(11) NOT NULL,
  `PROYC_Nombre` varchar(200) NOT NULL,
  `PROYC_Descripcion` text,
  `PROYC_FechaInicio` date DEFAULT NULL,
  `PROYC_FechaFin` date DEFAULT NULL,
  `DIREP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `PROYC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PROYC_FechaModificacion` datetime DEFAULT NULL,
  `PROYC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `PROYC_CodigoUsuario` int(11) NOT NULL,
  `CLIP_Codigo` int(11) NOT NULL,
  `DIRECC_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_recepcionproveedor`
--

CREATE TABLE `cji_recepcionproveedor` (
  `RECEPRO_Codigo` int(11) NOT NULL,
  `GARAN_Codigo` int(11) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `RECEPRO_Descripcion` varchar(250) DEFAULT NULL,
  `RECEPRO_Observacion` varchar(350) DEFAULT NULL,
  `RECEPRO_TipoSolucion` varchar(150) DEFAULT NULL,
  `RECEPRO_CodigoProducto` varchar(150) DEFAULT NULL,
  `RECEPRO_NombreProducto` varchar(150) DEFAULT NULL,
  `RECEPRO_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `RECEPRO_FechaModificacion` datetime DEFAULT NULL,
  `RECEPRO_FlagEstado` varchar(1) DEFAULT '1',
  `RECEPRO_NumeroCredito` int(30) NOT NULL,
  `RECEPRO_SerieCredito` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_receta`
--

CREATE TABLE `cji_receta` (
  `REC_Codigo` int(11) NOT NULL,
  `REC_CodigoUsuario` varchar(100) NOT NULL,
  `REC_Descripcion` varchar(250) NOT NULL,
  `REC_Costo` float NOT NULL,
  `REC_CostoMateriaP` float NOT NULL DEFAULT '0',
  `REC_CostoGastosP` float NOT NULL DEFAULT '0',
  `REC_CostoManoO` float NOT NULL DEFAULT '0',
  `REC_CostoAdicional` float NOT NULL DEFAULT '0',
  `PROD_Codigo` int(11) NOT NULL,
  `REC_FlagEstado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_recetadetalle`
--

CREATE TABLE `cji_recetadetalle` (
  `RECDET_Codigo` int(11) NOT NULL,
  `REC_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `RECDET_Cantidad` int(11) NOT NULL,
  `RECDET_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_reponsblmoviminto`
--

CREATE TABLE `cji_reponsblmoviminto` (
  `RESPNMOV_Codigo` int(11) NOT NULL,
  `DIREP_Codigo` varchar(200) NOT NULL,
  `CLIP_Codigo` int(11) NOT NULL,
  `PROVP_Codigo` int(11) NOT NULL,
  `CAJA_Codigo` int(11) NOT NULL,
  `RESPNMOV_TipBenefi` char(1) NOT NULL COMMENT 'GIRADOR: G ; BENEFICIARIO : B',
  `RESPNMOV_FechaIngreso` datetime NOT NULL,
  `RESPNMOV_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RESPNMOV_FechaModificacion` datetime NOT NULL,
  `RESPNMOV_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `RESPNMOV_CodigoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_respuestasunat`
--

CREATE TABLE `cji_respuestasunat` (
  `respuestas_codigo` int(10) NOT NULL,
  `CPP_codigo` int(11) NOT NULL,
  `respuestas_compañia` int(1) NOT NULL,
  `respuestas_GuiaRem` varchar(20) NOT NULL,
  `respuestas_serie` varchar(4) DEFAULT NULL,
  `respuestas_numero` int(10) DEFAULT NULL,
  `respuestas_tipoDocumento` varchar(1) DEFAULT NULL,
  `respuestas_enlace` varchar(250) DEFAULT NULL,
  `respuestas_aceptadaporsunat` double DEFAULT NULL,
  `respuestas_sunatdescription` varchar(100) DEFAULT NULL,
  `respuestas_sunatnote` varchar(100) DEFAULT NULL,
  `respuestas_sunatresponsecode` varchar(100) DEFAULT NULL,
  `respuestas_sunatsoaperror` varchar(100) DEFAULT NULL,
  `respuestas_pdfzipbase64` varchar(200) DEFAULT NULL,
  `respuestas_xmlzipbase64` varchar(200) DEFAULT NULL,
  `respuestas_cdrzipbase64` varchar(200) DEFAULT NULL,
  `respuestas_cadenaparacodigoqr` varchar(250) DEFAULT NULL,
  `respuestas_codigohash` varchar(100) DEFAULT NULL,
  `respuestas_enlacepdf` varchar(500) DEFAULT NULL,
  `respuestas_enlacexml` varchar(800) DEFAULT NULL,
  `respuestas_enlacecdr` varchar(150) DEFAULT NULL,
  `respuestas_deta` varchar(250) NOT NULL,
  `respuesta_jsonenviado` int(1) NOT NULL DEFAULT '0' COMMENT '0: no enviado con error 1: aceptado 2: anulacion no aceptada o en obs'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_respuestasunat`
--

INSERT INTO `cji_respuestasunat` (`respuestas_codigo`, `CPP_codigo`, `respuestas_compañia`, `respuestas_GuiaRem`, `respuestas_serie`, `respuestas_numero`, `respuestas_tipoDocumento`, `respuestas_enlace`, `respuestas_aceptadaporsunat`, `respuestas_sunatdescription`, `respuestas_sunatnote`, `respuestas_sunatresponsecode`, `respuestas_sunatsoaperror`, `respuestas_pdfzipbase64`, `respuestas_xmlzipbase64`, `respuestas_cdrzipbase64`, `respuestas_cadenaparacodigoqr`, `respuestas_codigohash`, `respuestas_enlacepdf`, `respuestas_enlacexml`, `respuestas_enlacecdr`, `respuestas_deta`, `respuesta_jsonenviado`) VALUES
(1, 1, 1, '', 'FPP1', 1, '1', 'https://osafact.pse.pe/cpe/93f431d4-ae27-435d-9abc-da2c8dc15c76', 1, 'La Factura Electrónica FPP1-1 ha sido ACEPTADA', NULL, '0', NULL, NULL, NULL, NULL, '10102442623|01|FPP1|000001|7.02|46.00|06/10/2023|6|20538856674|cp+8WIeyca9HDGjv8zsg/Mq1DzXnOpV+ulThdacJmWA=|', 'cp+8WIeyca9HDGjv8zsg/Mq1DzXnOpV+ulThdacJmWA=', 'https://osafact.pse.pe/cpe/93f431d4-ae27-435d-9abc-da2c8dc15c76.pdf', 'https://osafact.pse.pe/cpe/93f431d4-ae27-435d-9abc-da2c8dc15c76.xml', 'https://osafact.pse.pe/cpe/93f431d4-ae27-435d-9abc-da2c8dc15c76.cdr', '', 1),
(2, 2, 1, '', 'FPP1', 2, '1', 'https://osafact.pse.pe/cpe/58830b68-fab9-4282-847f-44d3045d806e', 1, 'La Factura Electrónica FPP1-2 ha sido ACEPTADA', NULL, '0', NULL, NULL, NULL, NULL, '10102442623|01|FPP1|000002|47.59|312.00|06/10/2023|6|20538856674|9YysTbQt4Wx0jq4zWw5z2pucjeNX2YuhDUO4EKMG5HA=|', '9YysTbQt4Wx0jq4zWw5z2pucjeNX2YuhDUO4EKMG5HA=', 'https://osafact.pse.pe/cpe/58830b68-fab9-4282-847f-44d3045d806e.pdf', 'https://osafact.pse.pe/cpe/58830b68-fab9-4282-847f-44d3045d806e.xml', 'https://osafact.pse.pe/cpe/58830b68-fab9-4282-847f-44d3045d806e.cdr', '', 1),
(3, 3, 1, '', 'FPP1', 3, '1', 'https://osafact.pse.pe/cpe/2010f0ab-b1ab-4b24-8c22-a027a1beb5ab', 1, 'La Factura Electrónica FPP1-3 ha sido ACEPTADA', NULL, '0', NULL, NULL, NULL, NULL, '10102442623|01|FPP1|000003|71.39|468.00|06/10/2023|6|20538856674|iQbpibCe6gdPrDX7tiTeJtVDML4C1P8UnTp3ukaSq3Q=|', 'iQbpibCe6gdPrDX7tiTeJtVDML4C1P8UnTp3ukaSq3Q=', 'https://osafact.pse.pe/cpe/2010f0ab-b1ab-4b24-8c22-a027a1beb5ab.pdf', 'https://osafact.pse.pe/cpe/2010f0ab-b1ab-4b24-8c22-a027a1beb5ab.xml', 'https://osafact.pse.pe/cpe/2010f0ab-b1ab-4b24-8c22-a027a1beb5ab.cdr', '', 1),
(5, 0, 1, '1', 'TPP1', 1, '7', 'https://www.pse.pe/guia/0344cc2b-fbca-44c1-a744-119efc3b7150', 1, 'ACEPTADA', NULL, '0', '', NULL, NULL, NULL, 'https://url-test?hashqr=test', NULL, 'https://www.pse.pe/guia/0344cc2b-fbca-44c1-a744-119efc3b7150.pdf', 'https://www.pse.pe/guia/0344cc2b-fbca-44c1-a744-119efc3b7150.xml', 'https://www.pse.pe/guia/0344cc2b-fbca-44c1-a744-119efc3b7150.cdr', '', 1),
(6, 5, 1, '', 'FPP1', 5, '1', 'https://osafact.pse.pe/cpe/4785d954-4cd5-4114-9dde-666b76e7728e', 1, 'La Factura Electrónica FPP1-5 ha sido ACEPTADA', NULL, '0', NULL, NULL, NULL, NULL, '10102442623|01|FPP1|000005|1.22|8.00|06/10/2023|6|20553856451|0AUWlra+H77IZcVYTOw+H9A7vX6tGewS3RB6hlM9+5Y=|', '0AUWlra+H77IZcVYTOw+H9A7vX6tGewS3RB6hlM9+5Y=', 'https://osafact.pse.pe/cpe/4785d954-4cd5-4114-9dde-666b76e7728e.pdf', 'https://osafact.pse.pe/cpe/4785d954-4cd5-4114-9dde-666b76e7728e.xml', 'https://osafact.pse.pe/cpe/4785d954-4cd5-4114-9dde-666b76e7728e.cdr', '', 1),
(7, 6, 1, '', 'BPP1', 1, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Este documento ya existe en [PSE]', 0),
(9, 0, 1, '2', 'TPP1', 3, '7', 'https://www.pse.pe/guia/b9c86a02-06ac-4e99-95ad-3e2f1a6b3487', 1, 'ACEPTADA', NULL, '0', '', NULL, NULL, NULL, 'https://url-test?hashqr=test', NULL, 'https://www.pse.pe/guia/b9c86a02-06ac-4e99-95ad-3e2f1a6b3487.pdf', 'https://www.pse.pe/guia/b9c86a02-06ac-4e99-95ad-3e2f1a6b3487.xml', 'https://www.pse.pe/guia/b9c86a02-06ac-4e99-95ad-3e2f1a6b3487.cdr', '', 1),
(10, 8, 1, '', 'FPP1', 6, '1', 'https://osafact.pse.pe/cpe/a3bc77e8-b4a9-42f1-ac88-ad24e10eac2b', 1, 'La Factura Electrónica FPP1-6 ha sido ACEPTADA', NULL, '0', NULL, NULL, NULL, NULL, '10102442623|01|FPP1|000006|18.31|120.00|06/10/2023|6|20538856674|NuC1DW9QfEmFWwOMVQNeGdII5oEaIG+CYz5F4Uf2w4g=|', 'NuC1DW9QfEmFWwOMVQNeGdII5oEaIG+CYz5F4Uf2w4g=', 'https://osafact.pse.pe/cpe/a3bc77e8-b4a9-42f1-ac88-ad24e10eac2b.pdf', 'https://osafact.pse.pe/cpe/a3bc77e8-b4a9-42f1-ac88-ad24e10eac2b.xml', 'https://osafact.pse.pe/cpe/a3bc77e8-b4a9-42f1-ac88-ad24e10eac2b.cdr', '', 1),
(11, 14, 2, '', 'FPP2', 1, '1', 'https://osafact.pse.pe/cpe/117b06c9-ed39-43fd-9539-963889353647', 0, 'No se pudo obtener la constancia | 10102442623-01-FPP2-1 Documento no existe', NULL, '0125', '[Excepción SOAP] Los documentos no aceptados por la SUNAT se consideran como documentos ANULADOS par', NULL, NULL, NULL, '10102442623|01|FPP2|000001|10.53|69.00|09/10/2023|6|20408113891|4f0/Eon5WqgDdCLZvhaeH3aZinsR5dL/N0PwRSCjgXE=|', '4f0/Eon5WqgDdCLZvhaeH3aZinsR5dL/N0PwRSCjgXE=', 'https://osafact.pse.pe/cpe/117b06c9-ed39-43fd-9539-963889353647.pdf', 'https://osafact.pse.pe/cpe/117b06c9-ed39-43fd-9539-963889353647.xml', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cji_rol`
--

CREATE TABLE `cji_rol` (
  `ROL_Codigo` int(11) NOT NULL,
  `ROL_Descripcion` varchar(150) DEFAULT NULL,
  `ROL_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ROL_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `ROL_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_rol`
--

INSERT INTO `cji_rol` (`ROL_Codigo`, `ROL_Descripcion`, `ROL_FechaRegistro`, `ROL_FechaModificacion`, `COMPP_Codigo`, `ROL_FlagEstado`) VALUES
(1, 'ADMINISTRADOR', '2022-06-01 14:51:35', '2022-06-01 09:51:35', 1, '1'),
(7000, 'SISTEMAS', '2019-10-11 17:31:01', NULL, 1, '1'),
(7001, 'ALMACEN', '2023-09-25 17:03:35', '2023-09-25 12:03:35', 1, '1'),
(7002, 'VENTAS', '2023-08-16 22:00:53', '2023-08-16 17:00:53', 1, '1'),
(7003, 'JEFE DE VENTAS', '2023-05-23 16:27:39', '2023-05-23 11:27:39', 3, '1'),
(7004, 'VENDEDOR JUNIOR', '2023-09-11 16:50:51', '2023-09-11 11:50:51', 1, '1'),
(7005, 'SUPERVISOR DE VENTAS', '2023-08-18 15:29:40', '2023-08-18 10:29:40', 1, '1'),
(7006, 'VENDEDOR SENIOR', '2023-09-11 14:20:12', NULL, 1, '1'),
(7007, 'CIENTIFICO', '2023-09-19 16:00:18', '2023-09-19 11:00:06', 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `cji_sectorcomercial`
--

CREATE TABLE `cji_sectorcomercial` (
  `SECCOMP_Codigo` int(11) NOT NULL,
  `SECCOMC_Descripcion` varchar(200) NOT NULL,
  `SECCOMC_FechaRegistro` date DEFAULT NULL,
  `SECCOMC_FechaModificacion` datetime DEFAULT NULL,
  `SECCOMC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_sectorcomercial`
--

INSERT INTO `cji_sectorcomercial` (`SECCOMP_Codigo`, `SECCOMC_Descripcion`, `SECCOMC_FechaRegistro`, `SECCOMC_FechaModificacion`, `SECCOMC_FlagEstado`) VALUES
(1, 'EMPRESA DE TRANSPORTE', '2019-06-13', NULL, '1'),
(2, 'MANUFACTURA DE HIERRO', '2023-09-18', NULL, '1'),
(3, 'ELECTRICIDAD INDUSTRIAL', '2023-09-18', NULL, '1'),
(4, 'ESTRUCTURAS COMPLEJAS', '2023-09-18', NULL, '1'),
(5, 'EQUIPOS PESADOS INDUSTRIALES', '2023-09-18', NULL, '1'),
(6, 'TECNOLOGIA', '2023-09-22', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_serie`
--

CREATE TABLE `cji_serie` (
  `SERIP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `SERIC_Numero` varchar(50) DEFAULT NULL,
  `SERIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SERIC_FechaModificacion` datetime DEFAULT NULL,
  `SERIC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `ALMAP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_seriedocumento`
--

CREATE TABLE `cji_seriedocumento` (
  `SERDOC_Codigo` int(11) NOT NULL,
  `SERIP_Codigo` int(11) NOT NULL,
  `DOCUP_Codigo` int(2) NOT NULL,
  `SERDOC_NumeroRef` int(11) NOT NULL,
  `TIPOMOV_Tipo` char(1) NOT NULL COMMENT '1:Ingreso, 2:Salida',
  `SERDOC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SERDOC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_seriemov`
--

CREATE TABLE `cji_seriemov` (
  `SERMOVP_Codigo` int(11) NOT NULL,
  `SERIP_Codigo` int(11) NOT NULL,
  `SERMOVP_TipoMov` char(1) NOT NULL COMMENT '1: Ingreso, 2:Salida',
  `GUIAINP_Codigo` int(11) DEFAULT NULL,
  `GUIASAP_Codigo` int(11) DEFAULT NULL,
  `SERMOVC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SERMOVC_FechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_servicio`
--

CREATE TABLE `cji_servicio` (
  `SERV_Codigo` int(11) NOT NULL,
  `SERV_TipoDocume` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `SERV_Serie` int(11) DEFAULT NULL,
  `SERV_Numero` int(11) DEFAULT NULL,
  `SERV_FechaSistema` timestamp NULL DEFAULT NULL,
  `PROYP_Codigo` int(11) NOT NULL,
  `CLIP_Codigo` int(11) NOT NULL,
  `ECONP_Contacto` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `SERV_Descripcion` varchar(1000) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SERV_Observacion` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SERV_FechaTermino` date DEFAULT NULL,
  `SERV_FechaRegistro` timestamp NULL DEFAULT NULL,
  `SERV_FechaModificacion` datetime NOT NULL,
  `SERV_FlagEstado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cji_terminal`
--

CREATE TABLE `cji_terminal` (
  `TERMINAL_Codigo` int(11) UNSIGNED NOT NULL,
  `ARDUINO_Codigo` int(11) NOT NULL,
  `PROYP_Codigo` int(11) NOT NULL,
  `DIRECC_Codigo` int(11) NOT NULL,
  `TERMINAL_Nombre` varchar(200) NOT NULL,
  `TERMINAL_Modelo` varchar(200) NOT NULL,
  `TERMINAL_Serie` text NOT NULL,
  `TERMINAL_NroLed` int(20) NOT NULL,
  `TERMINAL_Mapa` text NOT NULL,
  `TERMINAL_StreetView` text NOT NULL,
  `TERMINAL_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `TERMINAL_FechaModificacion` datetime DEFAULT NULL,
  `TERMINAL_FlagEstado` char(1) DEFAULT NULL,
  `TERMINAL_FlagUno` char(1) DEFAULT NULL,
  `TERMINAL_FlagDos` char(1) DEFAULT NULL,
  `TERMINAL_CodigoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipdocumento`
--

CREATE TABLE `cji_tipdocumento` (
  `TIPDOCP_Codigo` int(11) NOT NULL,
  `TIPDOCC_Descripcion` varchar(150) DEFAULT NULL,
  `TIPOCC_Inciales` varchar(150) DEFAULT NULL,
  `TIPOCC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPOCC_FechaModificacion` datetime DEFAULT NULL,
  `TIPOCC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_tipdocumento`
--

INSERT INTO `cji_tipdocumento` (`TIPDOCP_Codigo`, `TIPDOCC_Descripcion`, `TIPOCC_Inciales`, `TIPOCC_FechaRegistro`, `TIPOCC_FechaModificacion`, `TIPOCC_FlagEstado`) VALUES
(1, 'Documento Nacional de Identidad', 'D.N.I.', '2010-12-20 13:49:54', NULL, '1'),
(2, 'VARIOS', 'VARIOS', '2021-03-29 15:02:59', NULL, '1'),
(4, 'Carnet de Extranjeria', 'C.E.', '2010-12-20 13:49:58', NULL, '1'),
(7, 'PASAPORTE', 'PSPT', '2021-03-26 18:02:19', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipoalmacen`
--

CREATE TABLE `cji_tipoalmacen` (
  `TIPALMP_Codigo` int(11) NOT NULL,
  `TIPALM_Descripcion` varchar(250) DEFAULT NULL,
  `TIPALM_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPALM_FechaModificacion` datetime DEFAULT NULL,
  `TIPALM_flagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_tipoalmacen`
--

INSERT INTO `cji_tipoalmacen` (`TIPALMP_Codigo`, `TIPALM_Descripcion`, `TIPALM_FechaRegistro`, `TIPALM_FechaModificacion`, `TIPALM_flagEstado`) VALUES
(1, 'ALMACEN DE PRODUCTOS TERMINADOS', '2011-01-17 13:25:33', NULL, '1'),
(2, 'ALMACEN DE PRODUCTOS EN PROCESO', '2011-01-17 13:25:44', NULL, '1'),
(3, 'ALMACEN DE MERCADERIAS', '2011-01-17 13:25:55', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipocaja`
--

CREATE TABLE `cji_tipocaja` (
  `tipCa_codigo` int(11) NOT NULL,
  `tipCa_Descripcion` varchar(100) DEFAULT NULL,
  `tipCa_Abreviaturas` char(2) DEFAULT NULL,
  `tipCa_Tipo` char(1) DEFAULT NULL,
  `UsuarioRegistro` varchar(100) DEFAULT NULL,
  `UsuarioModificado` varchar(100) DEFAULT NULL,
  `tipCa_fechaModificacion` date DEFAULT NULL,
  `tipCa_FechaRegistro` datetime DEFAULT CURRENT_TIMESTAMP,
  `COMPP_Codigo` int(11) NOT NULL,
  `tipCa_FlagEstado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipocambio`
--

CREATE TABLE `cji_tipocambio` (
  `TIPCAMP_Codigo` int(11) NOT NULL,
  `TIPCAMC_MonedaOrigen` int(11) NOT NULL,
  `TIPCAMC_MonedaDestino` int(11) DEFAULT NULL,
  `TIPCAMC_Fecha` date NOT NULL,
  `TIPCAMC_FactorConversion` double(10,3) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `TIPCAMC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPCAMC_FechaModificacion` datetime DEFAULT NULL,
  `TIPCAMC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_tipocambio`
--

INSERT INTO `cji_tipocambio` (`TIPCAMP_Codigo`, `TIPCAMC_MonedaOrigen`, `TIPCAMC_MonedaDestino`, `TIPCAMC_Fecha`, `TIPCAMC_FactorConversion`, `COMPP_Codigo`, `TIPCAMC_FechaRegistro`, `TIPCAMC_FechaModificacion`, `TIPCAMC_FlagEstado`) VALUES
(1, 1, 2, '2022-08-11', 4.000, 1, '2022-08-11 17:41:59', NULL, '1'),
(2, 1, 2, '2022-08-11', 4.000, 2, '2022-08-11 17:41:59', NULL, '1'),
(3, 1, 2, '2022-08-12', 3.960, 1, '2022-08-12 16:11:04', NULL, '1'),
(4, 1, 2, '2022-08-12', 3.960, 2, '2022-08-12 16:11:04', NULL, '1'),
(5, 1, 2, '2022-08-15', 4.000, 1, '2022-08-15 17:00:57', NULL, '1'),
(6, 1, 2, '2022-08-15', 4.000, 2, '2022-08-15 17:00:57', NULL, '1'),
(7, 1, 2, '2022-08-16', 4.000, 1, '2022-08-16 20:59:53', NULL, '1'),
(8, 1, 2, '2022-08-16', 4.000, 2, '2022-08-16 20:59:53', NULL, '1'),
(9, 1, 2, '2022-08-17', 4.000, 1, '2022-08-17 14:59:36', NULL, '1'),
(10, 1, 2, '2022-08-17', 4.000, 2, '2022-08-17 14:59:36', NULL, '1'),
(11, 1, 2, '2022-08-18', 4.000, 1, '2022-08-18 19:39:12', NULL, '1'),
(12, 1, 2, '2022-08-18', 4.000, 3, '2022-08-18 19:39:12', NULL, '1'),
(13, 1, 2, '2022-08-18', 4.000, 2, '2022-08-18 19:39:12', NULL, '1'),
(14, 1, 2, '2022-08-19', 4.000, 1, '2022-08-19 15:13:05', NULL, '1'),
(15, 1, 2, '2022-08-19', 4.000, 3, '2022-08-19 15:13:05', NULL, '1'),
(16, 1, 2, '2022-08-19', 4.000, 2, '2022-08-19 15:13:05', NULL, '1'),
(17, 1, 2, '2022-08-20', 4.000, 1, '2022-08-20 15:21:11', NULL, '1'),
(18, 1, 2, '2022-08-20', 4.000, 3, '2022-08-20 15:21:12', NULL, '1'),
(19, 1, 2, '2022-08-20', 4.000, 2, '2022-08-20 15:21:12', NULL, '1'),
(20, 1, 2, '2022-08-22', 4.000, 1, '2022-08-22 14:52:00', NULL, '1'),
(21, 1, 2, '2022-08-22', 4.000, 3, '2022-08-22 14:52:00', NULL, '1'),
(22, 1, 2, '2022-08-22', 4.000, 2, '2022-08-22 14:52:00', NULL, '1'),
(23, 1, 2, '2022-08-24', 4.000, 1, '2022-08-24 22:25:43', NULL, '1'),
(24, 1, 2, '2022-08-24', 4.000, 3, '2022-08-24 22:25:43', NULL, '1'),
(25, 1, 2, '2022-08-24', 4.000, 2, '2022-08-24 22:25:43', NULL, '1'),
(26, 1, 2, '2022-08-26', 4.000, 1, '2022-08-26 19:30:24', NULL, '1'),
(27, 1, 2, '2022-08-26', 4.000, 3, '2022-08-26 19:30:24', NULL, '1'),
(28, 1, 2, '2022-08-26', 4.000, 2, '2022-08-26 19:30:25', NULL, '1'),
(29, 1, 2, '2022-09-01', 4.000, 1, '2022-09-01 15:35:40', NULL, '1'),
(30, 1, 2, '2022-09-01', 4.000, 3, '2022-09-01 15:35:40', NULL, '1'),
(31, 1, 2, '2022-09-01', 4.000, 2, '2022-09-01 15:35:41', NULL, '1'),
(32, 1, 2, '2022-09-02', 4.000, 1, '2022-09-02 15:55:51', NULL, '1'),
(33, 1, 2, '2022-09-02', 4.000, 3, '2022-09-02 15:55:51', NULL, '1'),
(34, 1, 2, '2022-09-02', 4.000, 2, '2022-09-02 15:55:51', NULL, '1'),
(35, 1, 2, '2022-09-03', 3.800, 1, '2022-09-03 16:35:18', NULL, '1'),
(36, 1, 2, '2022-09-03', 3.800, 3, '2022-09-03 16:35:18', NULL, '1'),
(37, 1, 2, '2022-09-03', 3.800, 2, '2022-09-03 16:35:18', NULL, '1'),
(38, 1, 2, '2022-09-05', 4.300, 1, '2022-09-05 16:00:19', NULL, '1'),
(39, 1, 2, '2022-09-05', 4.300, 3, '2022-09-05 16:00:19', NULL, '1'),
(40, 1, 2, '2022-09-05', 4.300, 2, '2022-09-05 16:00:19', NULL, '1'),
(41, 1, 2, '2022-09-06', 3.000, 1, '2022-09-06 16:28:27', NULL, '1'),
(42, 1, 2, '2022-09-06', 3.000, 3, '2022-09-06 16:28:27', NULL, '1'),
(43, 1, 2, '2022-09-06', 3.000, 2, '2022-09-06 16:28:27', NULL, '1'),
(44, 1, 2, '2022-09-07', 3.000, 1, '2022-09-07 14:26:04', NULL, '1'),
(45, 1, 2, '2022-09-07', 3.000, 3, '2022-09-07 14:26:04', NULL, '1'),
(46, 1, 2, '2022-09-07', 3.000, 2, '2022-09-07 14:26:04', NULL, '1'),
(47, 1, 2, '2022-09-08', 3.000, 1, '2022-09-08 22:04:32', NULL, '1'),
(48, 1, 2, '2022-09-08', 3.000, 3, '2022-09-08 22:04:32', NULL, '1'),
(49, 1, 2, '2022-09-08', 3.000, 2, '2022-09-08 22:04:32', NULL, '1'),
(50, 1, 2, '2022-09-10', 3.000, 1, '2022-09-10 16:14:57', NULL, '1'),
(51, 1, 2, '2022-09-10', 3.000, 3, '2022-09-10 16:14:57', NULL, '1'),
(52, 1, 2, '2022-09-10', 3.000, 2, '2022-09-10 16:14:57', NULL, '1'),
(53, 1, 2, '2022-09-15', 3.000, 1, '2022-09-15 21:10:02', NULL, '1'),
(54, 1, 2, '2022-09-15', 3.000, 3, '2022-09-15 21:10:02', NULL, '1'),
(55, 1, 2, '2022-09-15', 3.000, 2, '2022-09-15 21:10:02', NULL, '1'),
(56, 1, 2, '2022-09-16', 3.870, 1, '2022-09-16 14:38:17', NULL, '1'),
(57, 1, 2, '2022-09-16', 3.870, 3, '2022-09-16 14:38:17', NULL, '1'),
(58, 1, 2, '2022-09-16', 3.870, 2, '2022-09-16 14:38:17', NULL, '1'),
(59, 1, 2, '2022-09-17', 3.000, 1, '2022-09-17 17:58:21', NULL, '1'),
(60, 1, 2, '2022-09-17', 3.000, 3, '2022-09-17 17:58:21', NULL, '1'),
(61, 1, 2, '2022-09-17', 3.000, 2, '2022-09-17 17:58:21', NULL, '1'),
(62, 1, 2, '2022-09-19', 3.000, 1, '2022-09-19 15:07:01', NULL, '1'),
(63, 1, 2, '2022-09-19', 3.000, 3, '2022-09-19 15:07:01', NULL, '1'),
(64, 1, 2, '2022-09-19', 3.000, 2, '2022-09-19 15:07:01', NULL, '1'),
(65, 1, 2, '2022-09-21', 3.000, 1, '2022-09-21 16:44:00', NULL, '1'),
(66, 1, 2, '2022-09-22', 3.000, 1, '2022-09-22 17:51:52', NULL, '1'),
(67, 1, 2, '2022-09-26', 3.870, 1, '2022-09-26 14:57:06', NULL, '1'),
(68, 1, 2, '2022-09-27', 3.880, 1, '2022-09-27 15:59:02', NULL, '1'),
(69, 1, 2, '2022-09-27', 3.880, 2, '2022-09-27 15:59:02', NULL, '1'),
(70, 1, 2, '2022-09-27', 3.880, 3, '2022-09-27 15:59:02', NULL, '1'),
(71, 1, 2, '2022-09-28', 0.000, 1, '2022-09-28 17:45:03', NULL, '1'),
(72, 1, 2, '2022-09-28', 0.000, 2, '2022-09-28 17:45:03', NULL, '1'),
(73, 1, 2, '2022-09-28', 0.000, 3, '2022-09-28 17:45:03', NULL, '1'),
(74, 1, 2, '2022-09-30', 3.000, 1, '2022-09-30 14:31:09', NULL, '1'),
(75, 1, 2, '2022-09-30', 3.000, 2, '2022-09-30 14:31:09', NULL, '1'),
(76, 1, 2, '2022-09-30', 3.000, 3, '2022-09-30 14:31:09', NULL, '1'),
(77, 1, 2, '2022-10-06', 0.000, 1, '2022-10-06 19:47:50', NULL, '1'),
(78, 1, 2, '2022-10-06', 0.000, 2, '2022-10-06 19:47:50', NULL, '1'),
(79, 1, 2, '2022-10-06', 0.000, 3, '2022-10-06 19:47:50', NULL, '1'),
(80, 1, 2, '2022-10-10', 3.900, 1, '2022-10-10 14:59:43', NULL, '1'),
(81, 1, 2, '2022-10-10', 3.900, 2, '2022-10-10 14:59:43', NULL, '1'),
(82, 1, 2, '2022-10-10', 3.900, 3, '2022-10-10 14:59:43', NULL, '1'),
(83, 1, 2, '2022-10-12', 3.000, 1, '2022-10-12 20:14:35', NULL, '1'),
(84, 1, 2, '2022-10-12', 3.000, 2, '2022-10-12 20:14:35', NULL, '1'),
(85, 1, 2, '2022-10-12', 3.000, 3, '2022-10-12 20:14:35', NULL, '1'),
(86, 1, 2, '2022-10-13', 0.000, 1, '2022-10-13 13:58:51', NULL, '1'),
(87, 1, 2, '2022-10-13', 0.000, 2, '2022-10-13 13:58:51', NULL, '1'),
(88, 1, 2, '2022-10-13', 0.000, 3, '2022-10-13 13:58:51', NULL, '1'),
(89, 1, 2, '2022-10-14', 4.000, 1, '2022-10-14 16:07:12', NULL, '1'),
(90, 1, 2, '2022-10-14', 4.000, 2, '2022-10-14 16:07:12', NULL, '1'),
(91, 1, 2, '2022-10-14', 4.000, 3, '2022-10-14 16:07:12', NULL, '1'),
(92, 1, 2, '2022-10-20', 0.000, 1, '2022-10-20 15:36:31', NULL, '1'),
(93, 1, 2, '2022-10-20', 0.000, 2, '2022-10-20 15:36:31', NULL, '1'),
(94, 1, 2, '2022-10-20', 0.000, 3, '2022-10-20 15:36:31', NULL, '1'),
(95, 1, 2, '2022-10-21', 3.000, 1, '2022-10-21 17:31:27', NULL, '1'),
(96, 1, 2, '2022-10-21', 3.000, 2, '2022-10-21 17:31:27', NULL, '1'),
(97, 1, 2, '2022-10-21', 3.000, 3, '2022-10-21 17:31:27', NULL, '1'),
(98, 1, 2, '2022-10-25', 4.000, 1, '2022-10-25 15:51:13', NULL, '1'),
(99, 1, 2, '2022-10-25', 4.000, 2, '2022-10-25 15:51:13', NULL, '1'),
(100, 1, 2, '2022-10-25', 4.000, 3, '2022-10-25 15:51:13', NULL, '1'),
(101, 1, 2, '2022-10-26', 0.000, 1, '2022-10-26 14:55:28', NULL, '1'),
(102, 1, 2, '2022-10-26', 0.000, 2, '2022-10-26 14:55:28', NULL, '1'),
(103, 1, 2, '2022-10-26', 0.000, 3, '2022-10-26 14:55:28', NULL, '1'),
(104, 1, 2, '2022-10-28', 4.000, 1, '2022-10-28 17:14:28', NULL, '1'),
(105, 1, 2, '2022-10-28', 4.000, 2, '2022-10-28 17:14:28', NULL, '1'),
(106, 1, 2, '2022-10-28', 4.000, 3, '2022-10-28 17:14:28', NULL, '1'),
(107, 1, 2, '2022-10-31', 4.000, 1, '2022-10-31 15:29:11', NULL, '1'),
(108, 1, 2, '2022-10-31', 4.000, 2, '2022-10-31 15:29:11', NULL, '1'),
(109, 1, 2, '2022-10-31', 4.000, 3, '2022-10-31 15:29:11', NULL, '1'),
(110, 1, 2, '2022-11-02', 4.000, 1, '2022-11-02 19:54:11', NULL, '1'),
(111, 1, 2, '2022-11-02', 4.000, 2, '2022-11-02 19:54:11', NULL, '1'),
(112, 1, 2, '2022-11-02', 4.000, 3, '2022-11-02 19:54:11', NULL, '1'),
(113, 1, 2, '2022-11-18', 4.000, 1, '2022-11-18 15:49:29', NULL, '1'),
(114, 1, 2, '2022-11-18', 4.000, 2, '2022-11-18 15:49:29', NULL, '1'),
(115, 1, 2, '2022-11-18', 4.000, 3, '2022-11-18 15:49:29', NULL, '1'),
(116, 1, 2, '2022-11-21', 3.870, 1, '2022-11-21 17:39:36', NULL, '1'),
(117, 1, 2, '2022-11-21', 3.870, 2, '2022-11-21 17:39:36', NULL, '1'),
(118, 1, 2, '2022-11-21', 3.870, 3, '2022-11-21 17:39:36', NULL, '1'),
(119, 1, 2, '2022-11-22', 3.840, 1, '2022-11-22 22:18:12', NULL, '1'),
(120, 1, 2, '2022-11-22', 3.840, 2, '2022-11-22 22:18:12', NULL, '1'),
(121, 1, 2, '2022-11-22', 3.840, 3, '2022-11-22 22:18:12', NULL, '1'),
(122, 1, 2, '2022-11-23', 3.865, 1, '2022-11-23 22:14:35', NULL, '1'),
(123, 1, 2, '2022-11-23', 3.865, 2, '2022-11-23 22:14:35', NULL, '1'),
(124, 1, 2, '2022-11-23', 3.865, 3, '2022-11-23 22:14:35', NULL, '1'),
(125, 1, 2, '2022-12-01', 3.000, 1, '2022-12-01 17:17:52', NULL, '1'),
(126, 1, 2, '2022-12-01', 3.000, 2, '2022-12-01 17:17:52', NULL, '1'),
(127, 1, 2, '2022-12-01', 3.000, 3, '2022-12-01 17:17:52', NULL, '1'),
(128, 1, 2, '2022-12-10', 0.000, 1, '2022-12-10 16:17:53', NULL, '1'),
(129, 1, 2, '2022-12-10', 0.000, 2, '2022-12-10 16:17:53', NULL, '1'),
(130, 1, 2, '2022-12-10', 0.000, 3, '2022-12-10 16:17:53', NULL, '1'),
(131, 1, 2, '2022-12-14', 0.000, 1, '2022-12-15 03:54:29', NULL, '1'),
(132, 1, 2, '2022-12-14', 0.000, 2, '2022-12-15 03:54:29', NULL, '1'),
(133, 1, 2, '2022-12-14', 0.000, 3, '2022-12-15 03:54:29', NULL, '1'),
(134, 1, 2, '2022-12-16', 3.855, 1, '2022-12-16 22:27:33', NULL, '1'),
(135, 1, 2, '2022-12-16', 3.855, 2, '2022-12-16 22:27:33', NULL, '1'),
(136, 1, 2, '2022-12-16', 3.855, 3, '2022-12-16 22:27:33', NULL, '1'),
(137, 1, 2, '2022-12-20', 3.845, 1, '2022-12-20 16:40:37', NULL, '1'),
(138, 1, 2, '2022-12-20', 3.845, 2, '2022-12-20 16:40:37', NULL, '1'),
(139, 1, 2, '2022-12-20', 3.845, 3, '2022-12-20 16:40:37', NULL, '1'),
(140, 1, 2, '2022-12-26', 3.890, 1, '2022-12-26 15:38:51', NULL, '1'),
(141, 1, 2, '2022-12-26', 3.890, 2, '2022-12-26 15:38:51', NULL, '1'),
(142, 1, 2, '2022-12-26', 3.890, 3, '2022-12-26 15:38:51', NULL, '1'),
(143, 1, 2, '2023-01-07', 4.000, 1, '2023-01-07 15:45:51', NULL, '1'),
(144, 1, 2, '2023-01-07', 4.000, 2, '2023-01-07 15:45:51', NULL, '1'),
(145, 1, 2, '2023-01-07', 4.000, 3, '2023-01-07 15:45:51', NULL, '1'),
(146, 1, 2, '2023-01-12', 0.000, 1, '2023-01-13 04:09:55', NULL, '1'),
(147, 1, 2, '2023-01-12', 0.000, 2, '2023-01-13 04:09:55', NULL, '1'),
(148, 1, 2, '2023-01-12', 0.000, 3, '2023-01-13 04:09:55', NULL, '1'),
(149, 1, 2, '2023-01-15', 0.000, 1, '2023-01-15 14:17:35', NULL, '1'),
(150, 1, 2, '2023-01-15', 0.000, 2, '2023-01-15 14:17:35', NULL, '1'),
(151, 1, 2, '2023-01-15', 0.000, 3, '2023-01-15 14:17:35', NULL, '1'),
(152, 1, 2, '2023-01-31', 0.000, 1, '2023-01-31 21:42:27', NULL, '1'),
(153, 1, 2, '2023-01-31', 0.000, 2, '2023-01-31 21:42:27', NULL, '1'),
(154, 1, 2, '2023-01-31', 0.000, 3, '2023-01-31 21:42:27', NULL, '1'),
(155, 1, 2, '2023-02-03', 0.000, 1, '2023-02-04 02:41:28', NULL, '1'),
(156, 1, 2, '2023-02-03', 0.000, 2, '2023-02-04 02:41:29', NULL, '1'),
(157, 1, 2, '2023-02-03', 0.000, 3, '2023-02-04 02:41:29', NULL, '1'),
(158, 1, 2, '2023-02-04', 3.890, 1, '2023-02-04 20:42:57', NULL, '1'),
(159, 1, 2, '2023-02-04', 3.890, 2, '2023-02-04 20:42:57', NULL, '1'),
(160, 1, 2, '2023-02-04', 3.890, 3, '2023-02-04 20:42:57', NULL, '1'),
(161, 1, 2, '2023-02-09', 3.000, 1, '2023-02-09 19:39:56', NULL, '1'),
(162, 1, 2, '2023-02-09', 3.000, 2, '2023-02-09 19:39:56', NULL, '1'),
(163, 1, 2, '2023-02-09', 3.000, 3, '2023-02-09 19:39:56', NULL, '1'),
(164, 1, 2, '2023-03-02', 3.000, 1, '2023-03-02 20:14:09', NULL, '1'),
(165, 1, 2, '2023-03-02', 3.000, 2, '2023-03-02 20:14:09', NULL, '1'),
(166, 1, 2, '2023-03-02', 3.000, 3, '2023-03-02 20:14:09', NULL, '1'),
(167, 1, 2, '2023-03-06', 3.800, 1, '2023-03-06 16:11:42', NULL, '1'),
(168, 1, 2, '2023-03-06', 3.800, 2, '2023-03-06 16:11:42', NULL, '1'),
(169, 1, 2, '2023-03-06', 3.800, 3, '2023-03-06 16:11:42', NULL, '1'),
(170, 1, 2, '2023-03-07', 4.000, 1, '2023-03-07 15:33:17', NULL, '1'),
(171, 1, 2, '2023-03-07', 4.000, 2, '2023-03-07 15:33:17', NULL, '1'),
(172, 1, 2, '2023-03-07', 4.000, 3, '2023-03-07 15:33:17', NULL, '1'),
(173, 1, 2, '2023-04-11', 4.000, 1, '2023-04-11 16:04:30', NULL, '1'),
(174, 1, 2, '2023-04-11', 4.000, 2, '2023-04-11 16:04:30', NULL, '1'),
(175, 1, 2, '2023-04-11', 4.000, 3, '2023-04-11 16:04:30', NULL, '1'),
(176, 1, 2, '2023-04-12', 3.795, 1, '2023-04-12 20:50:45', NULL, '1'),
(177, 1, 2, '2023-04-12', 3.795, 2, '2023-04-12 20:51:24', NULL, '1'),
(178, 1, 2, '2023-04-12', 3.795, 3, '2023-04-12 20:51:24', NULL, '1'),
(179, 1, 2, '2023-04-14', 0.000, 1, '2023-04-14 14:24:08', NULL, '1'),
(180, 1, 2, '2023-04-14', 0.000, 2, '2023-04-14 14:24:08', NULL, '1'),
(181, 1, 2, '2023-04-14', 0.000, 3, '2023-04-14 14:24:08', NULL, '1'),
(182, 1, 2, '2023-04-18', 3.580, 1, '2023-04-18 21:46:02', NULL, '1'),
(183, 1, 2, '2023-04-18', 3.580, 2, '2023-04-18 21:46:02', NULL, '1'),
(184, 1, 2, '2023-04-18', 3.580, 3, '2023-04-18 21:46:02', NULL, '1'),
(185, 1, 2, '2023-04-19', 3.890, 1, '2023-04-19 22:17:36', NULL, '1'),
(186, 1, 2, '2023-04-19', 3.890, 2, '2023-04-19 22:17:36', NULL, '1'),
(187, 1, 2, '2023-04-19', 3.890, 3, '2023-04-19 22:17:36', NULL, '1'),
(188, 1, 2, '2023-04-20', 3.780, 1, '2023-04-20 20:21:50', NULL, '1'),
(189, 1, 2, '2023-04-20', 3.780, 2, '2023-04-20 20:21:50', NULL, '1'),
(190, 1, 2, '2023-04-20', 3.780, 3, '2023-04-20 20:21:50', NULL, '1'),
(191, 1, 2, '2023-04-22', 3.770, 1, '2023-04-22 18:20:08', NULL, '1'),
(192, 1, 2, '2023-04-22', 3.770, 2, '2023-04-22 18:20:08', NULL, '1'),
(193, 1, 2, '2023-04-22', 3.770, 3, '2023-04-22 18:20:08', NULL, '1'),
(194, 1, 2, '2023-04-23', 0.000, 1, '2023-04-23 18:07:54', NULL, '1'),
(195, 1, 2, '2023-04-23', 0.000, 2, '2023-04-23 18:07:54', NULL, '1'),
(196, 1, 2, '2023-04-23', 0.000, 3, '2023-04-23 18:07:54', NULL, '1'),
(197, 1, 2, '2023-04-24', 4.000, 1, '2023-04-24 20:10:52', NULL, '1'),
(198, 1, 2, '2023-04-24', 4.000, 2, '2023-04-24 20:10:52', NULL, '1'),
(199, 1, 2, '2023-04-24', 4.000, 3, '2023-04-24 20:10:52', NULL, '1'),
(200, 1, 2, '2023-04-25', 40.000, 1, '2023-04-25 22:02:37', NULL, '1'),
(201, 1, 2, '2023-04-25', 40.000, 2, '2023-04-25 22:02:37', NULL, '1'),
(202, 1, 2, '2023-04-25', 40.000, 3, '2023-04-25 22:02:37', NULL, '1'),
(203, 1, 2, '2023-04-26', 4.000, 1, '2023-04-26 15:14:56', NULL, '1'),
(204, 1, 2, '2023-04-26', 4.000, 2, '2023-04-26 15:14:56', NULL, '1'),
(205, 1, 2, '2023-04-26', 4.000, 3, '2023-04-26 15:14:56', NULL, '1'),
(206, 1, 2, '2023-04-27', 4.000, 1, '2023-04-27 18:02:53', NULL, '1'),
(207, 1, 2, '2023-04-27', 4.000, 2, '2023-04-27 18:02:56', NULL, '1'),
(208, 1, 2, '2023-04-27', 4.000, 3, '2023-04-27 18:02:56', NULL, '1'),
(209, 1, 2, '2023-04-28', 4.000, 1, '2023-04-28 16:40:30', NULL, '1'),
(210, 1, 2, '2023-04-28', 4.000, 2, '2023-04-28 16:40:30', NULL, '1'),
(211, 1, 2, '2023-04-28', 4.000, 3, '2023-04-28 16:40:30', NULL, '1'),
(212, 1, 2, '2023-04-29', 0.000, 1, '2023-04-29 17:40:47', NULL, '1'),
(213, 1, 2, '2023-04-29', 0.000, 2, '2023-04-29 17:40:47', NULL, '1'),
(214, 1, 2, '2023-04-29', 0.000, 3, '2023-04-29 17:40:47', NULL, '1'),
(215, 1, 2, '2023-05-01', 3.800, 1, '2023-05-01 14:17:52', NULL, '1'),
(216, 1, 2, '2023-05-01', 3.800, 2, '2023-05-01 14:17:52', NULL, '1'),
(217, 1, 2, '2023-05-01', 3.800, 3, '2023-05-01 14:17:52', NULL, '1'),
(218, 1, 2, '2023-05-02', 4.000, 1, '2023-05-02 19:42:25', NULL, '1'),
(219, 1, 2, '2023-05-02', 4.000, 2, '2023-05-02 19:42:25', NULL, '1'),
(220, 1, 2, '2023-05-02', 4.000, 3, '2023-05-02 19:42:25', NULL, '1'),
(221, 1, 2, '2023-05-03', 4.000, 1, '2023-05-03 16:14:03', NULL, '1'),
(222, 1, 2, '2023-05-03', 4.000, 2, '2023-05-03 16:14:03', NULL, '1'),
(223, 1, 2, '2023-05-03', 4.000, 3, '2023-05-03 16:14:03', NULL, '1'),
(224, 1, 2, '2023-05-04', 4.000, 1, '2023-05-04 15:10:59', NULL, '1'),
(225, 1, 2, '2023-05-04', 4.000, 2, '2023-05-04 15:10:59', NULL, '1'),
(226, 1, 2, '2023-05-04', 4.000, 3, '2023-05-04 15:10:59', NULL, '1'),
(227, 1, 2, '2023-05-05', 4.000, 1, '2023-05-05 20:59:52', NULL, '1'),
(228, 1, 2, '2023-05-05', 4.000, 2, '2023-05-05 20:59:52', NULL, '1'),
(229, 1, 2, '2023-05-05', 4.000, 3, '2023-05-05 20:59:52', NULL, '1'),
(230, 1, 2, '2023-05-06', 4.000, 1, '2023-05-06 12:08:57', NULL, '1'),
(231, 1, 2, '2023-05-06', 4.000, 2, '2023-05-06 12:08:57', NULL, '1'),
(232, 1, 2, '2023-05-06', 4.000, 3, '2023-05-06 12:08:57', NULL, '1'),
(233, 1, 2, '2023-05-07', 3.800, 1, '2023-05-07 22:08:41', NULL, '1'),
(234, 1, 2, '2023-05-07', 3.800, 2, '2023-05-07 22:08:41', NULL, '1'),
(235, 1, 2, '2023-05-07', 3.800, 3, '2023-05-07 22:08:41', NULL, '1'),
(236, 1, 2, '2023-05-08', 3.800, 1, '2023-05-08 20:53:24', NULL, '1'),
(237, 1, 2, '2023-05-08', 3.800, 2, '2023-05-08 20:53:24', NULL, '1'),
(238, 1, 2, '2023-05-08', 3.800, 3, '2023-05-08 20:53:24', NULL, '1'),
(239, 1, 2, '2023-05-09', 3.880, 1, '2023-05-09 15:05:34', NULL, '1'),
(240, 1, 2, '2023-05-09', 3.880, 2, '2023-05-09 15:05:34', NULL, '1'),
(241, 1, 2, '2023-05-09', 3.880, 3, '2023-05-09 15:05:34', NULL, '1'),
(242, 1, 2, '2023-05-10', 3.780, 1, '2023-05-10 16:09:52', NULL, '1'),
(243, 1, 2, '2023-05-10', 3.780, 2, '2023-05-10 16:09:52', NULL, '1'),
(244, 1, 2, '2023-05-10', 3.780, 3, '2023-05-10 16:09:52', NULL, '1'),
(245, 1, 2, '2023-05-12', 1.000, 1, '2023-05-12 17:48:55', NULL, '1'),
(246, 1, 2, '2023-05-12', 1.000, 2, '2023-05-12 17:48:55', NULL, '1'),
(247, 1, 2, '2023-05-12', 1.000, 3, '2023-05-12 17:48:55', NULL, '1'),
(248, 1, 2, '2023-05-13', 0.000, 1, '2023-05-13 14:42:47', NULL, '1'),
(249, 1, 2, '2023-05-13', 0.000, 2, '2023-05-13 14:42:47', NULL, '1'),
(250, 1, 2, '2023-05-13', 0.000, 3, '2023-05-13 14:42:47', NULL, '1'),
(251, 1, 2, '2023-05-15', 3.650, 1, '2023-05-15 16:12:02', NULL, '1'),
(252, 1, 2, '2023-05-15', 3.650, 2, '2023-05-15 16:12:02', NULL, '1'),
(253, 1, 2, '2023-05-15', 3.650, 3, '2023-05-15 16:12:02', NULL, '1'),
(254, 1, 2, '2023-05-16', 3.610, 1, '2023-05-16 14:24:24', NULL, '1'),
(255, 1, 2, '2023-05-16', 3.610, 2, '2023-05-16 14:24:24', NULL, '1'),
(256, 1, 2, '2023-05-16', 3.610, 3, '2023-05-16 14:24:24', NULL, '1'),
(257, 1, 2, '2023-05-17', 3.720, 1, '2023-05-17 14:35:57', NULL, '1'),
(258, 1, 2, '2023-05-17', 3.720, 2, '2023-05-17 14:35:57', NULL, '1'),
(259, 1, 2, '2023-05-17', 3.720, 3, '2023-05-17 14:35:57', NULL, '1'),
(260, 1, 2, '2023-05-18', 3.700, 1, '2023-05-18 14:39:12', NULL, '1'),
(261, 1, 2, '2023-05-18', 3.700, 2, '2023-05-18 14:39:12', NULL, '1'),
(262, 1, 2, '2023-05-18', 3.700, 3, '2023-05-18 14:39:12', NULL, '1'),
(263, 1, 2, '2023-05-19', 3.000, 1, '2023-05-19 13:53:01', NULL, '1'),
(264, 1, 2, '2023-05-19', 3.000, 2, '2023-05-19 13:53:01', NULL, '1'),
(265, 1, 2, '2023-05-19', 3.000, 3, '2023-05-19 13:53:01', NULL, '1'),
(266, 1, 2, '2023-05-20', 3.630, 1, '2023-05-20 14:56:39', NULL, '1'),
(267, 1, 2, '2023-05-20', 3.630, 2, '2023-05-20 14:56:39', NULL, '1'),
(268, 1, 2, '2023-05-20', 3.630, 3, '2023-05-20 14:56:39', NULL, '1'),
(269, 1, 2, '2023-05-22', 4.000, 1, '2023-05-22 15:18:48', NULL, '1'),
(270, 1, 2, '2023-05-22', 4.000, 2, '2023-05-22 15:18:48', NULL, '1'),
(271, 1, 2, '2023-05-22', 4.000, 3, '2023-05-22 15:18:48', NULL, '1'),
(272, 1, 2, '2023-05-23', 3.700, 1, '2023-05-23 15:01:08', NULL, '1'),
(273, 1, 2, '2023-05-23', 3.700, 2, '2023-05-23 15:01:08', NULL, '1'),
(274, 1, 2, '2023-05-23', 3.700, 3, '2023-05-23 15:01:08', NULL, '1'),
(275, 1, 2, '2023-05-24', 4.000, 1, '2023-05-24 21:24:23', NULL, '1'),
(276, 1, 2, '2023-05-24', 4.000, 2, '2023-05-24 21:24:23', NULL, '1'),
(277, 1, 2, '2023-05-24', 4.000, 3, '2023-05-24 21:24:23', NULL, '1'),
(278, 1, 2, '2023-05-25', 0.000, 1, '2023-05-25 15:10:24', NULL, '1'),
(279, 1, 2, '2023-05-25', 0.000, 2, '2023-05-25 15:10:24', NULL, '1'),
(280, 1, 2, '2023-05-25', 0.000, 3, '2023-05-25 15:10:24', NULL, '1'),
(281, 1, 2, '2023-05-30', 0.000, 1, '2023-05-30 17:02:15', NULL, '1'),
(282, 1, 2, '2023-05-30', 0.000, 2, '2023-05-30 17:02:15', NULL, '1'),
(283, 1, 2, '2023-05-30', 0.000, 3, '2023-05-30 17:02:15', NULL, '1'),
(284, 1, 2, '2023-06-23', 3.000, 1, '2023-06-23 17:44:03', NULL, '1'),
(285, 1, 2, '2023-06-23', 3.000, 2, '2023-06-23 17:44:03', NULL, '1'),
(286, 1, 2, '2023-06-23', 3.000, 3, '2023-06-23 17:44:03', NULL, '1'),
(287, 1, 2, '2023-06-23', 3.000, 4, '2023-06-23 17:44:03', NULL, '1'),
(288, 1, 2, '2023-06-23', 3.000, 5, '2023-06-23 17:44:03', NULL, '1'),
(289, 1, 2, '2023-06-23', 3.000, 6, '2023-06-23 17:44:03', NULL, '1'),
(290, 1, 2, '2023-07-07', 3.640, 1, '2023-07-07 20:16:11', NULL, '1'),
(291, 1, 2, '2023-07-07', 3.640, 2, '2023-07-07 20:16:11', NULL, '1'),
(292, 1, 2, '2023-07-07', 3.640, 3, '2023-07-07 20:16:11', NULL, '1'),
(293, 1, 2, '2023-07-07', 3.640, 4, '2023-07-07 20:16:11', NULL, '1'),
(294, 1, 2, '2023-07-07', 3.640, 5, '2023-07-07 20:16:11', NULL, '1'),
(295, 1, 2, '2023-07-07', 3.640, 6, '2023-07-07 20:16:11', NULL, '1'),
(296, 1, 2, '2023-07-19', 0.000, 1, '2023-07-19 14:45:43', NULL, '1'),
(297, 1, 2, '2023-07-19', 0.000, 2, '2023-07-19 14:45:43', NULL, '1'),
(298, 1, 2, '2023-07-19', 0.000, 3, '2023-07-19 14:45:43', NULL, '1'),
(299, 1, 2, '2023-07-19', 0.000, 4, '2023-07-19 14:45:43', NULL, '1'),
(300, 1, 2, '2023-07-19', 0.000, 5, '2023-07-19 14:45:43', NULL, '1'),
(301, 1, 2, '2023-07-19', 0.000, 6, '2023-07-19 14:45:43', NULL, '1'),
(302, 1, 2, '2023-07-21', 3.700, 1, '2023-07-21 23:19:49', NULL, '1'),
(303, 1, 2, '2023-07-21', 3.700, 2, '2023-07-21 23:19:49', NULL, '1'),
(304, 1, 2, '2023-07-21', 3.700, 3, '2023-07-21 23:19:49', NULL, '1'),
(305, 1, 2, '2023-07-21', 3.700, 4, '2023-07-21 23:19:49', NULL, '1'),
(306, 1, 2, '2023-07-21', 3.700, 5, '2023-07-21 23:19:49', NULL, '1'),
(307, 1, 2, '2023-07-21', 3.700, 6, '2023-07-21 23:19:49', NULL, '1'),
(308, 1, 2, '2023-07-22', 0.000, 1, '2023-07-22 15:20:53', NULL, '1'),
(309, 1, 2, '2023-07-22', 0.000, 2, '2023-07-22 15:20:53', NULL, '1'),
(310, 1, 2, '2023-07-22', 0.000, 3, '2023-07-22 15:20:53', NULL, '1'),
(311, 1, 2, '2023-07-22', 0.000, 4, '2023-07-22 15:20:53', NULL, '1'),
(312, 1, 2, '2023-07-22', 0.000, 5, '2023-07-22 15:20:53', NULL, '1'),
(313, 1, 2, '2023-07-22', 0.000, 6, '2023-07-22 15:20:53', NULL, '1'),
(314, 1, 2, '2023-07-23', 0.000, 1, '2023-07-24 02:42:31', NULL, '1'),
(315, 1, 2, '2023-07-23', 0.000, 2, '2023-07-24 02:42:31', NULL, '1'),
(316, 1, 2, '2023-07-23', 0.000, 3, '2023-07-24 02:42:31', NULL, '1'),
(317, 1, 2, '2023-07-23', 0.000, 4, '2023-07-24 02:42:31', NULL, '1'),
(318, 1, 2, '2023-07-23', 0.000, 5, '2023-07-24 02:42:31', NULL, '1'),
(319, 1, 2, '2023-07-23', 0.000, 6, '2023-07-24 02:42:31', NULL, '1'),
(320, 1, 2, '2023-07-24', 0.000, 1, '2023-07-24 15:47:19', NULL, '1'),
(321, 1, 2, '2023-07-24', 0.000, 2, '2023-07-24 15:47:19', NULL, '1'),
(322, 1, 2, '2023-07-24', 0.000, 3, '2023-07-24 15:47:19', NULL, '1'),
(323, 1, 2, '2023-07-24', 0.000, 4, '2023-07-24 15:47:19', NULL, '1'),
(324, 1, 2, '2023-07-24', 0.000, 5, '2023-07-24 15:47:19', NULL, '1'),
(325, 1, 2, '2023-07-24', 0.000, 6, '2023-07-24 15:47:19', NULL, '1'),
(326, 1, 2, '2023-07-25', 0.000, 1, '2023-07-25 19:08:47', NULL, '1'),
(327, 1, 2, '2023-07-25', 0.000, 2, '2023-07-25 19:08:47', NULL, '1'),
(328, 1, 2, '2023-07-25', 0.000, 3, '2023-07-25 19:08:47', NULL, '1'),
(329, 1, 2, '2023-07-25', 0.000, 4, '2023-07-25 19:08:47', NULL, '1'),
(330, 1, 2, '2023-07-25', 0.000, 5, '2023-07-25 19:08:47', NULL, '1'),
(331, 1, 2, '2023-07-25', 0.000, 6, '2023-07-25 19:08:47', NULL, '1'),
(332, 1, 2, '2023-08-02', 0.000, 1, '2023-08-02 19:14:32', NULL, '1'),
(333, 1, 2, '2023-08-02', 0.000, 2, '2023-08-02 19:14:32', NULL, '1'),
(334, 1, 2, '2023-08-02', 0.000, 3, '2023-08-02 19:14:32', NULL, '1'),
(335, 1, 2, '2023-08-02', 0.000, 4, '2023-08-02 19:14:32', NULL, '1'),
(336, 1, 2, '2023-08-02', 0.000, 5, '2023-08-02 19:14:32', NULL, '1'),
(337, 1, 2, '2023-08-02', 0.000, 6, '2023-08-02 19:14:32', NULL, '1'),
(338, 1, 2, '2023-08-03', 0.000, 1, '2023-08-04 00:06:56', NULL, '1'),
(339, 1, 2, '2023-08-03', 0.000, 2, '2023-08-04 00:06:56', NULL, '1'),
(340, 1, 2, '2023-08-03', 0.000, 3, '2023-08-04 00:06:56', NULL, '1'),
(341, 1, 2, '2023-08-03', 0.000, 4, '2023-08-04 00:06:56', NULL, '1'),
(342, 1, 2, '2023-08-03', 0.000, 5, '2023-08-04 00:06:56', NULL, '1'),
(343, 1, 2, '2023-08-03', 0.000, 6, '2023-08-04 00:06:56', NULL, '1'),
(344, 1, 2, '2023-08-04', 0.000, 1, '2023-08-04 17:07:11', NULL, '1'),
(345, 1, 2, '2023-08-04', 0.000, 2, '2023-08-04 17:07:11', NULL, '1'),
(346, 1, 2, '2023-08-04', 0.000, 3, '2023-08-04 17:07:11', NULL, '1'),
(347, 1, 2, '2023-08-04', 0.000, 4, '2023-08-04 17:07:11', NULL, '1'),
(348, 1, 2, '2023-08-04', 0.000, 5, '2023-08-04 17:07:11', NULL, '1'),
(349, 1, 2, '2023-08-04', 0.000, 6, '2023-08-04 17:07:11', NULL, '1'),
(350, 1, 2, '2023-08-15', 0.000, 1, '2023-08-15 22:05:00', NULL, '1'),
(351, 1, 2, '2023-08-15', 0.000, 2, '2023-08-15 22:05:00', NULL, '1'),
(352, 1, 2, '2023-08-15', 0.000, 3, '2023-08-15 22:05:00', NULL, '1'),
(353, 1, 2, '2023-08-15', 0.000, 4, '2023-08-15 22:05:00', NULL, '1'),
(354, 1, 2, '2023-08-15', 0.000, 5, '2023-08-15 22:05:00', NULL, '1'),
(355, 1, 2, '2023-08-15', 0.000, 6, '2023-08-15 22:05:00', NULL, '1'),
(356, 1, 2, '2023-08-16', 0.000, 1, '2023-08-16 16:44:13', NULL, '1'),
(357, 1, 2, '2023-08-16', 0.000, 2, '2023-08-16 16:44:13', NULL, '1'),
(358, 1, 2, '2023-08-16', 0.000, 3, '2023-08-16 16:44:13', NULL, '1'),
(359, 1, 2, '2023-08-16', 0.000, 4, '2023-08-16 16:44:13', NULL, '1'),
(360, 1, 2, '2023-08-16', 0.000, 5, '2023-08-16 16:44:13', NULL, '1'),
(361, 1, 2, '2023-08-16', 0.000, 6, '2023-08-16 16:44:13', NULL, '1'),
(362, 1, 2, '2023-08-17', 3.000, 1, '2023-08-17 15:02:44', NULL, '1'),
(363, 1, 2, '2023-08-17', 3.000, 2, '2023-08-17 15:02:44', NULL, '1'),
(364, 1, 2, '2023-08-17', 3.000, 3, '2023-08-17 15:02:44', NULL, '1'),
(365, 1, 2, '2023-08-17', 3.000, 4, '2023-08-17 15:02:44', NULL, '1'),
(366, 1, 2, '2023-08-17', 3.000, 5, '2023-08-17 15:02:44', NULL, '1'),
(367, 1, 2, '2023-08-17', 3.000, 6, '2023-08-17 15:02:44', NULL, '1'),
(368, 1, 2, '2023-08-18', 0.000, 1, '2023-08-18 15:08:09', NULL, '1'),
(369, 1, 2, '2023-08-18', 0.000, 2, '2023-08-18 15:08:09', NULL, '1'),
(370, 1, 2, '2023-08-18', 0.000, 3, '2023-08-18 15:08:09', NULL, '1'),
(371, 1, 2, '2023-08-18', 0.000, 4, '2023-08-18 15:08:09', NULL, '1'),
(372, 1, 2, '2023-08-18', 0.000, 5, '2023-08-18 15:08:09', NULL, '1'),
(373, 1, 2, '2023-08-18', 0.000, 6, '2023-08-18 15:08:09', NULL, '1'),
(374, 1, 2, '2023-08-19', 0.000, 1, '2023-08-20 01:25:25', NULL, '1'),
(375, 1, 2, '2023-08-19', 0.000, 2, '2023-08-20 01:25:25', NULL, '1'),
(376, 1, 2, '2023-08-19', 0.000, 3, '2023-08-20 01:25:25', NULL, '1'),
(377, 1, 2, '2023-08-19', 0.000, 4, '2023-08-20 01:25:25', NULL, '1'),
(378, 1, 2, '2023-08-19', 0.000, 5, '2023-08-20 01:25:25', NULL, '1'),
(379, 1, 2, '2023-08-19', 0.000, 6, '2023-08-20 01:25:25', NULL, '1'),
(380, 1, 2, '2023-08-21', 3.700, 1, '2023-08-21 14:17:25', NULL, '1'),
(381, 1, 2, '2023-08-21', 3.700, 2, '2023-08-21 14:17:25', NULL, '1'),
(382, 1, 2, '2023-08-21', 3.700, 3, '2023-08-21 14:17:25', NULL, '1'),
(383, 1, 2, '2023-08-21', 3.700, 4, '2023-08-21 14:17:25', NULL, '1'),
(384, 1, 2, '2023-08-21', 3.700, 5, '2023-08-21 14:17:25', NULL, '1'),
(385, 1, 2, '2023-08-21', 3.700, 6, '2023-08-21 14:17:25', NULL, '1'),
(386, 1, 2, '2023-08-23', 3.000, 1, '2023-08-23 20:39:50', NULL, '1'),
(387, 1, 2, '2023-08-23', 3.000, 2, '2023-08-23 20:39:50', NULL, '1'),
(388, 1, 2, '2023-08-23', 3.000, 3, '2023-08-23 20:39:50', NULL, '1'),
(389, 1, 2, '2023-08-23', 3.000, 4, '2023-08-23 20:39:50', NULL, '1'),
(390, 1, 2, '2023-08-23', 3.000, 5, '2023-08-23 20:39:50', NULL, '1'),
(391, 1, 2, '2023-08-23', 3.000, 6, '2023-08-23 20:39:50', NULL, '1'),
(392, 1, 2, '2023-08-28', 0.000, 1, '2023-08-28 15:54:29', NULL, '1'),
(393, 1, 2, '2023-08-28', 0.000, 2, '2023-08-28 15:54:29', NULL, '1'),
(394, 1, 2, '2023-08-28', 0.000, 3, '2023-08-28 15:54:29', NULL, '1'),
(395, 1, 2, '2023-08-28', 0.000, 4, '2023-08-28 15:54:29', NULL, '1'),
(396, 1, 2, '2023-08-28', 0.000, 5, '2023-08-28 15:54:29', NULL, '1'),
(397, 1, 2, '2023-08-28', 0.000, 6, '2023-08-28 15:54:29', NULL, '1'),
(398, 1, 2, '2023-08-29', 3.000, 1, '2023-08-29 16:03:24', NULL, '1'),
(399, 1, 2, '2023-08-29', 3.000, 2, '2023-08-29 16:03:24', NULL, '1'),
(400, 1, 2, '2023-08-29', 3.000, 3, '2023-08-29 16:03:24', NULL, '1'),
(401, 1, 2, '2023-08-29', 3.000, 4, '2023-08-29 16:03:24', NULL, '1'),
(402, 1, 2, '2023-08-29', 3.000, 5, '2023-08-29 16:03:24', NULL, '1'),
(403, 1, 2, '2023-08-29', 3.000, 6, '2023-08-29 16:03:24', NULL, '1'),
(404, 1, 2, '2023-08-31', 3.000, 1, '2023-08-31 16:20:52', NULL, '1'),
(405, 1, 2, '2023-08-31', 3.000, 2, '2023-08-31 16:20:52', NULL, '1'),
(406, 1, 2, '2023-08-31', 3.000, 3, '2023-08-31 16:20:52', NULL, '1'),
(407, 1, 2, '2023-08-31', 3.000, 4, '2023-08-31 16:20:52', NULL, '1'),
(408, 1, 2, '2023-08-31', 3.000, 5, '2023-08-31 16:20:52', NULL, '1'),
(409, 1, 2, '2023-08-31', 3.000, 6, '2023-08-31 16:20:52', NULL, '1'),
(410, 1, 2, '2023-09-04', 3.000, 1, '2023-09-04 15:00:48', NULL, '1'),
(411, 1, 2, '2023-09-04', 3.000, 2, '2023-09-04 15:00:48', NULL, '1'),
(412, 1, 2, '2023-09-04', 3.000, 3, '2023-09-04 15:00:48', NULL, '1'),
(413, 1, 2, '2023-09-04', 3.000, 4, '2023-09-04 15:00:48', NULL, '1'),
(414, 1, 2, '2023-09-04', 3.000, 5, '2023-09-04 15:00:48', NULL, '1'),
(415, 1, 2, '2023-09-04', 3.000, 6, '2023-09-04 15:00:48', NULL, '1'),
(416, 1, 2, '2023-09-06', 0.000, 1, '2023-09-06 16:23:00', NULL, '1'),
(417, 1, 2, '2023-09-06', 0.000, 2, '2023-09-06 16:23:00', NULL, '1'),
(418, 1, 2, '2023-09-06', 0.000, 3, '2023-09-06 16:23:00', NULL, '1'),
(419, 1, 2, '2023-09-06', 0.000, 4, '2023-09-06 16:23:00', NULL, '1'),
(420, 1, 2, '2023-09-06', 0.000, 5, '2023-09-06 16:23:00', NULL, '1'),
(421, 1, 2, '2023-09-06', 0.000, 6, '2023-09-06 16:23:00', NULL, '1'),
(422, 1, 2, '2023-09-07', 3.700, 1, '2023-09-07 14:27:50', NULL, '1'),
(423, 1, 2, '2023-09-07', 3.700, 2, '2023-09-07 14:27:50', NULL, '1'),
(424, 1, 2, '2023-09-07', 3.700, 3, '2023-09-07 14:27:50', NULL, '1'),
(425, 1, 2, '2023-09-07', 3.700, 4, '2023-09-07 14:27:50', NULL, '1'),
(426, 1, 2, '2023-09-07', 3.700, 5, '2023-09-07 14:27:50', NULL, '1'),
(427, 1, 2, '2023-09-07', 3.700, 6, '2023-09-07 14:27:50', NULL, '1'),
(428, 1, 2, '2023-09-08', 0.000, 1, '2023-09-08 16:55:32', NULL, '1'),
(429, 1, 2, '2023-09-08', 0.000, 2, '2023-09-08 16:55:32', NULL, '1'),
(430, 1, 2, '2023-09-08', 0.000, 3, '2023-09-08 16:55:32', NULL, '1'),
(431, 1, 2, '2023-09-08', 0.000, 4, '2023-09-08 16:55:32', NULL, '1'),
(432, 1, 2, '2023-09-08', 0.000, 5, '2023-09-08 16:55:32', NULL, '1'),
(433, 1, 2, '2023-09-08', 0.000, 6, '2023-09-08 16:55:32', NULL, '1'),
(434, 1, 2, '2023-09-11', 3.000, 1, '2023-09-11 14:28:19', NULL, '1'),
(435, 1, 2, '2023-09-11', 3.000, 2, '2023-09-11 14:28:19', NULL, '1'),
(436, 1, 2, '2023-09-11', 3.000, 3, '2023-09-11 14:28:19', NULL, '1'),
(437, 1, 2, '2023-09-11', 3.000, 4, '2023-09-11 14:28:19', NULL, '1'),
(438, 1, 2, '2023-09-11', 3.000, 5, '2023-09-11 14:28:19', NULL, '1'),
(439, 1, 2, '2023-09-11', 3.000, 6, '2023-09-11 14:28:19', NULL, '1'),
(440, 1, 2, '2023-09-12', 3.000, 1, '2023-09-12 15:09:30', NULL, '1'),
(441, 1, 2, '2023-09-12', 3.000, 2, '2023-09-12 15:09:30', NULL, '1'),
(442, 1, 2, '2023-09-12', 3.000, 3, '2023-09-12 15:09:30', NULL, '1'),
(443, 1, 2, '2023-09-12', 3.000, 4, '2023-09-12 15:09:30', NULL, '1'),
(444, 1, 2, '2023-09-12', 3.000, 5, '2023-09-12 15:09:30', NULL, '1'),
(445, 1, 2, '2023-09-12', 3.000, 6, '2023-09-12 15:09:30', NULL, '1'),
(446, 1, 2, '2023-09-13', 45.000, 1, '2023-09-13 15:00:19', NULL, '1'),
(447, 1, 2, '2023-09-13', 45.000, 2, '2023-09-13 15:00:19', NULL, '1'),
(448, 1, 2, '2023-09-13', 45.000, 3, '2023-09-13 15:00:19', NULL, '1'),
(449, 1, 2, '2023-09-13', 45.000, 4, '2023-09-13 15:00:19', NULL, '1'),
(450, 1, 2, '2023-09-13', 45.000, 5, '2023-09-13 15:00:19', NULL, '1'),
(451, 1, 2, '2023-09-13', 45.000, 6, '2023-09-13 15:00:19', NULL, '1'),
(452, 1, 2, '2023-09-14', 3.000, 1, '2023-09-14 15:07:53', NULL, '1'),
(453, 1, 2, '2023-09-14', 3.000, 2, '2023-09-14 15:07:53', NULL, '1'),
(454, 1, 2, '2023-09-14', 3.000, 3, '2023-09-14 15:07:53', NULL, '1'),
(455, 1, 2, '2023-09-14', 3.000, 4, '2023-09-14 15:07:53', NULL, '1'),
(456, 1, 2, '2023-09-14', 3.000, 5, '2023-09-14 15:07:53', NULL, '1'),
(457, 1, 2, '2023-09-14', 3.000, 6, '2023-09-14 15:07:53', NULL, '1'),
(458, 1, 2, '2023-09-15', 3.700, 1, '2023-09-15 15:51:36', NULL, '1'),
(459, 1, 2, '2023-09-15', 3.700, 2, '2023-09-15 15:51:36', NULL, '1'),
(460, 1, 2, '2023-09-15', 3.700, 3, '2023-09-15 15:51:36', NULL, '1'),
(461, 1, 2, '2023-09-15', 3.700, 4, '2023-09-15 15:51:36', NULL, '1'),
(462, 1, 2, '2023-09-15', 3.700, 5, '2023-09-15 15:51:36', NULL, '1'),
(463, 1, 2, '2023-09-15', 3.700, 6, '2023-09-15 15:51:36', NULL, '1'),
(464, 1, 2, '2023-09-16', 9.000, 1, '2023-09-16 14:11:02', NULL, '1'),
(465, 1, 2, '2023-09-16', 9.000, 2, '2023-09-16 14:11:02', NULL, '1'),
(466, 1, 2, '2023-09-16', 9.000, 3, '2023-09-16 14:11:02', NULL, '1'),
(467, 1, 2, '2023-09-16', 9.000, 4, '2023-09-16 14:11:02', NULL, '1'),
(468, 1, 2, '2023-09-16', 9.000, 5, '2023-09-16 14:11:02', NULL, '1'),
(469, 1, 2, '2023-09-16', 9.000, 6, '2023-09-16 14:11:02', NULL, '1'),
(470, 1, 2, '2023-09-18', 3.000, 1, '2023-09-18 14:09:49', NULL, '1'),
(471, 1, 2, '2023-09-18', 3.000, 2, '2023-09-18 14:09:49', NULL, '1'),
(472, 1, 2, '2023-09-18', 3.000, 3, '2023-09-18 14:09:49', NULL, '1'),
(473, 1, 2, '2023-09-18', 3.000, 4, '2023-09-18 14:09:49', NULL, '1'),
(474, 1, 2, '2023-09-18', 3.000, 5, '2023-09-18 14:09:49', NULL, '1'),
(475, 1, 2, '2023-09-18', 3.000, 6, '2023-09-18 14:09:49', NULL, '1'),
(476, 1, 2, '2023-09-19', 3.000, 1, '2023-09-19 14:32:41', NULL, '1'),
(477, 1, 2, '2023-09-19', 3.000, 2, '2023-09-19 14:32:41', NULL, '1'),
(478, 1, 2, '2023-09-19', 3.000, 3, '2023-09-19 14:32:41', NULL, '1'),
(479, 1, 2, '2023-09-19', 3.000, 4, '2023-09-19 14:32:41', NULL, '1'),
(480, 1, 2, '2023-09-19', 3.000, 5, '2023-09-19 14:32:41', NULL, '1'),
(481, 1, 2, '2023-09-19', 3.000, 6, '2023-09-19 14:32:41', NULL, '1'),
(482, 1, 2, '2023-09-22', 0.000, 1, '2023-09-22 20:32:23', NULL, '1'),
(483, 1, 2, '2023-09-25', 0.000, 1, '2023-09-25 16:36:47', NULL, '1'),
(484, 1, 2, '2023-09-26', 0.000, 1, '2023-09-26 16:58:09', NULL, '1'),
(485, 1, 2, '2023-10-02', 3.000, 1, '2023-10-02 15:38:06', NULL, '1'),
(486, 1, 2, '2023-10-05', 3.700, 1, '2023-10-05 22:11:08', NULL, '1'),
(487, 1, 2, '2023-10-06', 3.700, 1, '2023-10-06 14:30:47', NULL, '1'),
(488, 1, 2, '2023-10-07', 3.700, 1, '2023-10-07 14:18:40', NULL, '1'),
(489, 1, 2, '2023-10-08', 3.700, 1, '2023-10-08 14:09:35', NULL, '1'),
(490, 1, 2, '2023-10-09', 3.700, 1, '2023-10-09 14:28:04', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipocliente`
--

CREATE TABLE `cji_tipocliente` (
  `TIPCLIP_Codigo` int(11) NOT NULL,
  `TIPCLIC_Descripcion` varchar(150) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `TIPCLIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPCLIC_FechaModificacion` datetime DEFAULT NULL,
  `TIPCLIC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_tipocliente`
--

INSERT INTO `cji_tipocliente` (`TIPCLIP_Codigo`, `TIPCLIC_Descripcion`, `COMPP_Codigo`, `TIPCLIC_FechaRegistro`, `TIPCLIC_FechaModificacion`, `TIPCLIC_FlagEstado`) VALUES
(1, 'PRECIO UNIDAD', 1, '2021-09-17 21:20:11', '2023-09-22 15:23:25', '0'),
(2, 'PRECIO MENOR', 1, '2022-06-28 19:43:00', '2023-09-22 15:23:28', '0'),
(3, 'PRECIO DE VENTA', 1, '2023-03-06 16:22:24', '2023-09-22 15:23:42', '1'),
(4, 'POR TONELADAS', 1, '2023-09-19 14:47:06', '2023-09-19 10:47:21', '0');

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipocodigo`
--

CREATE TABLE `cji_tipocodigo` (
  `TIPCOD_Codigo` int(11) NOT NULL,
  `TIPCOD_Descripcion` varchar(150) DEFAULT NULL,
  `TIPCOD_Inciales` varchar(150) DEFAULT NULL,
  `TIPCOD_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPCOD_FechaModificacion` datetime DEFAULT NULL,
  `TIPCOD_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_tipocodigo`
--

INSERT INTO `cji_tipocodigo` (`TIPCOD_Codigo`, `TIPCOD_Descripcion`, `TIPCOD_Inciales`, `TIPCOD_FechaRegistro`, `TIPCOD_FechaModificacion`, `TIPCOD_FlagEstado`) VALUES
(0, 'NO DOMICILIADO', 'NO DOMICILIADO', '2016-12-01 12:32:53', NULL, '1'),
(2, 'NIC', 'N.I.C.', '2011-07-08 17:32:59', NULL, '1'),
(6, 'Registro Unico de Contribuyente', 'R.U.C.', '2011-07-08 17:32:59', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipoestablecimiento`
--

CREATE TABLE `cji_tipoestablecimiento` (
  `TESTP_Codigo` int(11) NOT NULL,
  `TESTC_Descripcion` varchar(150) DEFAULT NULL,
  `TESTC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TESTC_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `TESTC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_tipoestablecimiento`
--

INSERT INTO `cji_tipoestablecimiento` (`TESTP_Codigo`, `TESTC_Descripcion`, `TESTC_FechaRegistro`, `TESTC_FechaModificacion`, `COMPP_Codigo`, `TESTC_FlagEstado`) VALUES
(1, 'DOMICILIO LEGAL', '2010-12-18 00:33:12', NULL, 1, '1'),
(2, 'LOCAL COMERCIAL O DE SERV.', '2011-01-02 13:28:04', NULL, 1, '1'),
(3, 'OFICINA ADMINISTRATIVA', '2015-11-07 19:06:16', NULL, 1, '1'),
(4, 'SUCURSAL', '2015-11-07 19:08:06', NULL, 1, '1'),
(5, 'AGENCIA', '2015-11-07 19:08:28', NULL, 1, '1'),
(6, 'DEPOSITO(ALMACEN)', '2015-11-14 18:28:58', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipomovimiento`
--

CREATE TABLE `cji_tipomovimiento` (
  `TIPOMOVP_Codigo` int(11) NOT NULL,
  `TIPOMOVC_Descripcion` varchar(100) DEFAULT NULL,
  `TIPOMOVC_Tipo` char(1) NOT NULL COMMENT '1:Ingreso, 2:Salida',
  `TIPOMOVC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `TIPOMOVC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_tipomovimiento`
--

INSERT INTO `cji_tipomovimiento` (`TIPOMOVP_Codigo`, `TIPOMOVC_Descripcion`, `TIPOMOVC_Tipo`, `TIPOMOVC_FechaRegistro`, `TIPOMOVC_FlagEstado`) VALUES
(1, 'VENTA', '2', '2011-09-20 16:24:45', '1'),
(2, 'COMPRA', '2', '2021-08-16 17:53:54', '1'),
(4, 'TRASL. ENTRE ESTAB. DE LA MISMA EMPRESA', '2', '2019-09-11 19:37:13', '1'),
(8, 'IMPORTACION', '2', '2021-08-16 17:54:19', '1'),
(9, 'EXPORTACION', '2', '2021-08-16 17:54:50', '1'),
(13, 'OTROS', '2', '2021-08-16 17:55:44', '1'),
(14, 'VENTA SUJETA A CONF. DEL COMPRADOR', '2', '2021-08-16 17:55:44', '1'),
(18, 'TRASLADO EMISOR ITINERANTE CP', '2', '2021-08-16 17:56:19', '1'),
(19, 'TRASL. ZONA PRIMARIA', '2', '2021-08-16 17:56:19', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipoproducto`
--

CREATE TABLE `cji_tipoproducto` (
  `TIPPROD_Codigo` int(11) NOT NULL,
  `TIPPROD_FlagBienServicio` char(1) NOT NULL DEFAULT 'B' COMMENT 'B: Bien, S: Servicio',
  `TIPPROD_Descripcion` varchar(250) DEFAULT NULL,
  `TIPPROD_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPPROD_FechaModificacion` datetime DEFAULT NULL,
  `TIPPROD_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipoproveedor`
--

CREATE TABLE `cji_tipoproveedor` (
  `FAMI_Codigo` int(11) NOT NULL,
  `FAMI_Descripcion` varchar(350) DEFAULT NULL,
  `FAMI_Codigo2` int(11) DEFAULT NULL,
  `FAMI_CodigoInterno` char(3) DEFAULT NULL,
  `FAMI_CodigoUsuario` varchar(20) DEFAULT NULL,
  `FAMI_Numeracion` int(11) DEFAULT '0',
  `FAMI_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FAMI_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `FAMI_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cji_tipo_afectacion`
--

CREATE TABLE `cji_tipo_afectacion` (
  `AFECT_Codigo` int(11) NOT NULL,
  `AFECT_Numero` varchar(3) NOT NULL,
  `AFECT_Descripcion` varchar(65) NOT NULL,
  `AFECT_DescripcionSmall` varchar(70) DEFAULT NULL,
  `AFECT_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AFECT_FechaModificacion` datetime NOT NULL,
  `AFECT_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cji_tipo_afectacion`
--

INSERT INTO `cji_tipo_afectacion` (`AFECT_Codigo`, `AFECT_Numero`, `AFECT_Descripcion`, `AFECT_DescripcionSmall`, `AFECT_FechaRegistro`, `AFECT_FechaModificacion`, `AFECT_FlagEstado`) VALUES
(1, '1', 'Gravado - Operación Onerosa [10]', '[GRAVADO] - Operación Onerosa', '2019-10-15 19:42:11', '0000-00-00 00:00:00', '1'),
(2, '2', '[GRATUITO] Gravado – Retiro por premio [11]', '[GRATUITO] - Retiro por premio', '2019-10-15 19:46:05', '2019-10-15 14:46:05', '1'),
(3, '3', '[GRATUITO] Gravado – Retiro por donación [12]', '[GRATUITO] - Retiro por donación', '2019-10-15 19:46:22', '2019-10-15 14:46:22', '1'),
(4, '4', '[GRATUITO] Gravado – Retiro [13]', '[GRATUITO] - Retiro', '2019-10-15 19:46:36', '2019-10-15 14:46:36', '1'),
(5, '5', '[GRATUITO] Gravado – Retiro por publicidad [14]', '[GRATUITO] - Retiro por publicidad', '2019-10-15 19:46:47', '2019-10-15 14:46:47', '1'),
(6, '6', '[GRATUITO] Gravado – Bonificaciones [15]', '[GRATUITO] - Bonificaciones', '2019-10-15 19:46:59', '2019-10-15 14:46:59', '1'),
(7, '7', '[GRATUITO] Gravado – Retiro por entrega a trabajadores [16]', '[GRATUITO] - Retiro por entrega a trabajadores', '2019-10-15 19:47:08', '2019-10-15 14:47:08', '1'),
(8, '8', 'Exonerado - Operación Onerosa [20]', '[EXONERADO]', '2019-10-15 19:47:21', '2019-10-15 14:47:21', '1'),
(9, '9', 'Inafecto - Operación Onerosa [30]', '[INAFECTO]', '2019-10-15 19:47:36', '2019-10-15 14:47:36', '1'),
(10, '10', '[GRATUITO] Inafecto – Retiro por Bonificación [31]', '[GRATUITO] Inafecto – Retiro por Bonificación', '2019-10-15 19:48:11', '2019-10-15 14:48:11', '1'),
(11, '11', '[GRATUITO] Inafecto – Retiro [32]', '[GRATUITO] Inafecto – Retiro', '2019-10-15 19:48:22', '2019-10-15 14:48:22', '1'),
(12, '12', '[GRATUITO] Inafecto – Retiro por Muestras Médicas [33]', '[GRATUITO] Inafecto – Retiro por Muestras Médicas', '2019-10-15 19:48:33', '2019-10-15 14:48:33', '1'),
(13, '13', '[GRATUITO] Inafecto - Retiro por Convenio Colectivo [34]', '[GRATUITO] Inafecto - Retiro por Convenio Colectivo', '2019-10-15 19:48:46', '2019-10-15 14:48:46', '1'),
(14, '14', '[GRATUITO] Inafecto – Retiro por premio [35]', '[GRATUITO] Inafecto – Retiro por premio', '2019-10-15 19:48:57', '2019-10-15 14:48:57', '1'),
(15, '15', '[GRATUITO] Inafecto - Retiro por publicidad [36]', '[GRATUITO] Inafecto - Retiro por publicidad', '2019-10-15 19:49:08', '2019-10-15 14:49:08', '1'),
(16, '16', 'Exportación [40]', '[EXPORTACIÓN]', '2019-10-15 19:49:18', '2019-10-15 14:49:18', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_ubigeo`
--

CREATE TABLE `cji_ubigeo` (
  `UBIGP_Codigo` int(11) NOT NULL,
  `UBIGC_CodDist` char(6) DEFAULT NULL,
  `UBIGC_Descripcion` varchar(150) DEFAULT 'NULL',
  `UBIGC_CodProv` char(6) DEFAULT NULL,
  `UBIGC_DescripcionProv` varchar(150) DEFAULT NULL,
  `UBIGC_CodDpto` char(6) DEFAULT NULL,
  `UBIGC_DescripcionDpto` varchar(150) DEFAULT NULL,
  `UBIGC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UBIGC_FechaModificacion` datetime DEFAULT NULL,
  `UBIGC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_ubigeo`
--

INSERT INTO `cji_ubigeo` (`UBIGP_Codigo`, `UBIGC_CodDist`, `UBIGC_Descripcion`, `UBIGC_CodProv`, `UBIGC_DescripcionProv`, `UBIGC_CodDpto`, `UBIGC_DescripcionDpto`, `UBIGC_FechaRegistro`, `UBIGC_FechaModificacion`, `UBIGC_FlagEstado`) VALUES
(10101, '010101', 'CHACHAPOYAS', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10102, '010102', 'ASUNCION', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10103, '010103', 'BALSAS', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10104, '010104', 'CHETO', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10105, '010105', 'CHILIQUIN', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10106, '010106', 'CHUQUIBAMBA', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10107, '010107', 'GRANADA', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10108, '010108', 'HUANCAS', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10109, '010109', 'LA JALCA', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10110, '010110', 'LEIMEBAMBA', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10111, '010111', 'LEVANTO', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10112, '010112', 'MAGDALENA', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10113, '010113', 'MARISCAL CASTILLA', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10114, '010114', 'MOLINOPAMPA', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10115, '010115', 'MONTEVIDEO', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10116, '010116', 'OLLEROS', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10117, '010117', 'QUINJALCA', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10118, '010118', 'SAN FRANCISCO DE DAGUAS', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10119, '010119', 'SAN ISIDRO DE MAINO', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10120, '010120', 'SOLOCO', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10121, '010121', 'SONCHE', '0101', 'CHACHAPOYAS', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10201, '010201', 'BAGUA', '0102', 'BAGUA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10202, '010202', 'ARAMANGO', '0102', 'BAGUA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10203, '010203', 'COPALLIN', '0102', 'BAGUA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10204, '010204', 'EL PARCO', '0102', 'BAGUA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10205, '010205', 'IMAZA', '0102', 'BAGUA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10206, '010206', 'LA PECA', '0102', 'BAGUA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10301, '010301', 'JUMBILLA', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10302, '010302', 'CHISQUILLA', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10303, '010303', 'CHURUJA', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10304, '010304', 'COROSHA', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10305, '010305', 'CUISPES', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10306, '010306', 'FLORIDA', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10307, '010307', 'JAZAN', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10308, '010308', 'RECTA', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10309, '010309', 'SAN CARLOS', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10310, '010310', 'SHIPASBAMBA', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10311, '010311', 'VALERA', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10312, '010312', 'YAMBRASBAMBA', '0103', 'BONGARA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10401, '010401', 'NIEVA', '0104', 'CONDORCANQUI', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10402, '010402', 'EL CENEPA', '0104', 'CONDORCANQUI', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10403, '010403', 'RIO SANTIAGO', '0104', 'CONDORCANQUI', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10501, '010501', 'LAMUD', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10502, '010502', 'CAMPORREDONDO', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10503, '010503', 'COCABAMBA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10504, '010504', 'COLCAMAR', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10505, '010505', 'CONILA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10506, '010506', 'INGUILPATA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10507, '010507', 'LONGUITA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10508, '010508', 'LONYA CHICO', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10509, '010509', 'LUYA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10510, '010510', 'LUYA VIEJO', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10511, '010511', 'MARIA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10512, '010512', 'OCALLI', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10513, '010513', 'OCUMAL', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10514, '010514', 'PISUQUIA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10515, '010515', 'PROVIDENCIA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10516, '010516', 'SAN CRISTOBAL', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10517, '010517', 'SAN FRANCISCO DEL YESO', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10518, '010518', 'SAN JERONIMO', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10519, '010519', 'SAN JUAN DE LOPECANCHA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10520, '010520', 'SANTA CATALINA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10521, '010521', 'SANTO TOMAS', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10522, '010522', 'TINGO', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10523, '010523', 'TRITA', '0105', 'LUYA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10601, '010601', 'SAN NICOLAS', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10602, '010602', 'CHIRIMOTO', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10603, '010603', 'COCHAMAL', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10604, '010604', 'HUAMBO', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10605, '010605', 'LIMABAMBA', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10606, '010606', 'LONGAR', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10607, '010607', 'MARISCAL BENAVIDES', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10608, '010608', 'MILPUC', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10609, '010609', 'OMIA', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10610, '010610', 'SANTA ROSA', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10611, '010611', 'TOTORA', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10612, '010612', 'VISTA ALEGRE', '0106', 'RODRIGUEZ DE MENDOZA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10701, '010701', 'BAGUA GRANDE', '0107', 'UTCUBAMBA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10702, '010702', 'CAJARURO', '0107', 'UTCUBAMBA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10703, '010703', 'CUMBA', '0107', 'UTCUBAMBA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10704, '010704', 'EL MILAGRO', '0107', 'UTCUBAMBA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10705, '010705', 'JAMALCA', '0107', 'UTCUBAMBA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10706, '010706', 'LONYA GRANDE', '0107', 'UTCUBAMBA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(10707, '010707', 'YAMON', '0107', 'UTCUBAMBA', '01', 'DEPARTAMENTO AMAZONAS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20101, '020101', 'HUARAZ', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20102, '020102', 'COCHABAMBA', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20103, '020103', 'COLCABAMBA', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20104, '020104', 'HUANCHAY', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20105, '020105', 'INDEPENDENCIA', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20106, '020106', 'JANGAS', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20107, '020107', 'LA LIBERTAD', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20108, '020108', 'OLLEROS', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20109, '020109', 'PAMPAS', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20110, '020110', 'PARIACOTO', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20111, '020111', 'PIRA', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20112, '020112', 'TARICA', '0201', 'HUARAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20201, '020201', 'AIJA', '0202', 'AIJA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20202, '020202', 'CORIS', '0202', 'AIJA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20203, '020203', 'HUACLLAN', '0202', 'AIJA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20204, '020204', 'LA MERCED', '0202', 'AIJA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20205, '020205', 'SUCCHA', '0202', 'AIJA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20301, '020301', 'LLAMELLIN', '0203', 'ANTONIO RAYMONDI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20302, '020302', 'ACZO', '0203', 'ANTONIO RAYMONDI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20303, '020303', 'CHACCHO', '0203', 'ANTONIO RAYMONDI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20304, '020304', 'CHINGAS', '0203', 'ANTONIO RAYMONDI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20305, '020305', 'MIRGAS', '0203', 'ANTONIO RAYMONDI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20306, '020306', 'SAN JUAN DE RONTOY', '0203', 'ANTONIO RAYMONDI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20401, '020401', 'CHACAS', '0204', 'ASUNCION', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20402, '020402', 'ACOCHACA', '0204', 'ASUNCION', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20501, '020501', 'CHIQUIAN', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20502, '020502', 'ABELARDO PARDO LEZAMETA', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20503, '020503', 'ANTONIO RAYMONDI', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20504, '020504', 'AQUIA', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20505, '020505', 'CAJACAY', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20506, '020506', 'CANIS', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20507, '020507', 'COLQUIOC', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20508, '020508', 'HUALLANCA', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20509, '020509', 'HUASTA', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20510, '020510', 'HUAYLLACAYAN', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20511, '020511', 'LA PRIMAVERA', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20512, '020512', 'MANGAS', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20513, '020513', 'PACLLON', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20514, '020514', 'SAN MIGUEL DE CORPANQUI', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20515, '020515', 'TICLLOS', '0205', 'BOLOGNESI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20601, '020601', 'CARHUAZ', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20602, '020602', 'ACOPAMPA', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20603, '020603', 'AMASHCA', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20604, '020604', 'ANTA', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20605, '020605', 'ATAQUERO', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20606, '020606', 'MARCARA', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20607, '020607', 'PARIAHUANCA', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20608, '020608', 'SAN MIGUEL DE ACO', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20609, '020609', 'SHILLA', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20610, '020610', 'TINCO', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20611, '020611', 'YUNGAR', '0206', 'CARHUAZ', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20701, '020701', 'SAN LUIS', '0207', 'CARLOS FERMIN FITZCARRALD', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20702, '020702', 'SAN NICOLAS', '0207', 'CARLOS FERMIN FITZCARRALD', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20703, '020703', 'YAUYA', '0207', 'CARLOS FERMIN FITZCARRALD', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20801, '020801', 'CASMA', '0208', 'CASMA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20802, '020802', 'BUENA VISTA ALTA', '0208', 'CASMA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20803, '020803', 'COMANDANTE NOEL', '0208', 'CASMA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20804, '020804', 'YAUTAN', '0208', 'CASMA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20901, '020901', 'CORONGO', '0209', 'CORONGO', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20902, '020902', 'ACO', '0209', 'CORONGO', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20903, '020903', 'BAMBAS', '0209', 'CORONGO', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20904, '020904', 'CUSCA', '0209', 'CORONGO', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20905, '020905', 'LA PAMPA', '0209', 'CORONGO', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20906, '020906', 'YANAC', '0209', 'CORONGO', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(20907, '020907', 'YUPAN', '0209', 'CORONGO', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21001, '021001', 'HUARI', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21002, '021002', 'ANRA', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21003, '021003', 'CAJAY', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21004, '021004', 'CHAVIN DE HUANTAR', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21005, '021005', 'HUACACHI', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21006, '021006', 'HUACCHIS', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21007, '021007', 'HUACHIS', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21008, '021008', 'HUANTAR', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21009, '021009', 'MASIN', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21010, '021010', 'PAUCAS', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21011, '021011', 'PONTO', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21012, '021012', 'RAHUAPAMPA', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21013, '021013', 'RAPAYAN', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21014, '021014', 'SAN MARCOS', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21015, '021015', 'SAN PEDRO DE CHANA', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21016, '021016', 'UCO', '0210', 'HUARI', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21101, '021101', 'HUARMEY', '0211', 'HUARMEY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21102, '021102', 'COCHAPETI', '0211', 'HUARMEY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21103, '021103', 'CULEBRAS', '0211', 'HUARMEY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21104, '021104', 'HUAYAN', '0211', 'HUARMEY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21105, '021105', 'MALVAS', '0211', 'HUARMEY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21201, '021201', 'CARAZ', '0212', 'HUAYLAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21202, '021202', 'HUALLANCA', '0212', 'HUAYLAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21203, '021203', 'HUATA', '0212', 'HUAYLAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21204, '021204', 'HUAYLAS', '0212', 'HUAYLAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21205, '021205', 'MATO', '0212', 'HUAYLAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21206, '021206', 'PAMPAROMAS', '0212', 'HUAYLAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21207, '021207', 'PUEBLO LIBRE  / 1', '0212', 'HUAYLAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21208, '021208', 'SANTA CRUZ', '0212', 'HUAYLAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21209, '021209', 'SANTO TORIBIO', '0212', 'HUAYLAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21210, '021210', 'YURACMARCA', '0212', 'HUAYLAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21301, '021301', 'PISCOBAMBA', '0213', 'MARISCAL LUZURIAGA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21302, '021302', 'CASCA', '0213', 'MARISCAL LUZURIAGA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21303, '021303', 'ELEAZAR GUZMAN BARRON', '0213', 'MARISCAL LUZURIAGA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21304, '021304', 'FIDEL OLIVAS ESCUDERO', '0213', 'MARISCAL LUZURIAGA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21305, '021305', 'LLAMA', '0213', 'MARISCAL LUZURIAGA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21306, '021306', 'LLUMPA', '0213', 'MARISCAL LUZURIAGA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21307, '021307', 'LUCMA', '0213', 'MARISCAL LUZURIAGA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21308, '021308', 'MUSGA', '0213', 'MARISCAL LUZURIAGA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21401, '021401', 'OCROS', '0214', 'OCROS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21402, '021402', 'ACAS', '0214', 'OCROS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21403, '021403', 'CAJAMARQUILLA', '0214', 'OCROS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21404, '021404', 'CARHUAPAMPA', '0214', 'OCROS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21405, '021405', 'COCHAS', '0214', 'OCROS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21406, '021406', 'CONGAS', '0214', 'OCROS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21407, '021407', 'LLIPA', '0214', 'OCROS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21408, '021408', 'SAN CRISTOBAL DE RAJAN', '0214', 'OCROS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21409, '021409', 'SAN PEDRO', '0214', 'OCROS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21410, '021410', 'SANTIAGO DE CHILCAS', '0214', 'OCROS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21501, '021501', 'CABANA', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21502, '021502', 'BOLOGNESI', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21503, '021503', 'CONCHUCOS', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21504, '021504', 'HUACASCHUQUE', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21505, '021505', 'HUANDOVAL', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21506, '021506', 'LACABAMBA', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21507, '021507', 'LLAPO', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21508, '021508', 'PALLASCA', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21509, '021509', 'PAMPAS', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21510, '021510', 'SANTA ROSA', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21511, '021511', 'TAUCA', '0215', 'PALLASCA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21601, '021601', 'POMABAMBA', '0216', 'POMABAMBA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21602, '021602', 'HUAYLLAN', '0216', 'POMABAMBA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21603, '021603', 'PAROBAMBA', '0216', 'POMABAMBA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21604, '021604', 'QUINUABAMBA', '0216', 'POMABAMBA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21701, '021701', 'RECUAY', '0217', 'RECUAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21702, '021702', 'CATAC', '0217', 'RECUAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21703, '021703', 'COTAPARACO', '0217', 'RECUAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21704, '021704', 'HUAYLLAPAMPA', '0217', 'RECUAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21705, '021705', 'LLACLLIN', '0217', 'RECUAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21706, '021706', 'MARCA', '0217', 'RECUAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21707, '021707', 'PAMPAS CHICO', '0217', 'RECUAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21708, '021708', 'PARARIN', '0217', 'RECUAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21709, '021709', 'TAPACOCHA', '0217', 'RECUAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21710, '021710', 'TICAPAMPA', '0217', 'RECUAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21801, '021801', 'CHIMBOTE', '0218', 'SANTA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21802, '021802', 'CACERES DEL PERU', '0218', 'SANTA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21803, '021803', 'COISHCO', '0218', 'SANTA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21804, '021804', 'MACATE', '0218', 'SANTA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21805, '021805', 'MORO', '0218', 'SANTA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21806, '021806', 'NEPEÑA', '0218', 'SANTA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21807, '021807', 'SAMANCO', '0218', 'SANTA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21808, '021808', 'SANTA', '0218', 'SANTA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21809, '021809', 'NUEVO CHIMBOTE', '0218', 'SANTA', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21901, '021901', 'SIHUAS', '0219', 'SIHUAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21902, '021902', 'ACOBAMBA', '0219', 'SIHUAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21903, '021903', 'ALFONSO UGARTE', '0219', 'SIHUAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21904, '021904', 'CASHAPAMPA', '0219', 'SIHUAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21905, '021905', 'CHINGALPO', '0219', 'SIHUAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21906, '021906', 'HUAYLLABAMBA', '0219', 'SIHUAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21907, '021907', 'QUICHES', '0219', 'SIHUAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21908, '021908', 'RAGASH', '0219', 'SIHUAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21909, '021909', 'SAN JUAN', '0219', 'SIHUAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(21910, '021910', 'SICSIBAMBA', '0219', 'SIHUAS', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(22001, '022001', 'YUNGAY', '0220', 'YUNGAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(22002, '022002', 'CASCAPARA', '0220', 'YUNGAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(22003, '022003', 'MANCOS', '0220', 'YUNGAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(22004, '022004', 'MATACOTO', '0220', 'YUNGAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(22005, '022005', 'QUILLO', '0220', 'YUNGAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(22006, '022006', 'RANRAHIRCA', '0220', 'YUNGAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(22007, '022007', 'SHUPLUY', '0220', 'YUNGAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(22008, '022008', 'YANAMA', '0220', 'YUNGAY', '02', 'DEPARTAMENTO ANCASH', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30101, '030101', 'ABANCAY', '0301', 'ABANCAY', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30102, '030102', 'CHACOCHE', '0301', 'ABANCAY', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30103, '030103', 'CIRCA', '0301', 'ABANCAY', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30104, '030104', 'CURAHUASI', '0301', 'ABANCAY', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30105, '030105', 'HUANIPACA', '0301', 'ABANCAY', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30106, '030106', 'LAMBRAMA', '0301', 'ABANCAY', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30107, '030107', 'PICHIRHUA', '0301', 'ABANCAY', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30108, '030108', 'SAN PEDRO DE CACHORA', '0301', 'ABANCAY', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30109, '030109', 'TAMBURCO', '0301', 'ABANCAY', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30201, '030201', 'ANDAHUAYLAS', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30202, '030202', 'ANDARAPA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30203, '030203', 'CHIARA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30204, '030204', 'HUANCARAMA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30205, '030205', 'HUANCARAY', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30206, '030206', 'HUAYANA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30207, '030207', 'KISHUARA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30208, '030208', 'PACOBAMBA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30209, '030209', 'PACUCHA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30210, '030210', 'PAMPACHIRI', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30211, '030211', 'POMACOCHA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30212, '030212', 'SAN ANTONIO DE CACHI', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30213, '030213', 'SAN JERONIMO', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30214, '030214', 'SAN MIGUEL DE CHACCRAMPA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30215, '030215', 'SANTA MARIA DE CHICMO', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30216, '030216', 'TALAVERA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30217, '030217', 'TUMAY HUARACA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30218, '030218', 'TURPO', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30219, '030219', 'KAQUIABAMBA', '0302', 'ANDAHUAYLAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30301, '030301', 'ANTABAMBA', '0303', 'ANTABAMBA', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30302, '030302', 'EL ORO', '0303', 'ANTABAMBA', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30303, '030303', 'HUAQUIRCA', '0303', 'ANTABAMBA', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30304, '030304', 'JUAN ESPINOZA MEDRANO', '0303', 'ANTABAMBA', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30305, '030305', 'OROPESA', '0303', 'ANTABAMBA', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30306, '030306', 'PACHACONAS', '0303', 'ANTABAMBA', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30307, '030307', 'SABAINO', '0303', 'ANTABAMBA', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30401, '030401', 'CHALHUANCA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30402, '030402', 'CAPAYA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30403, '030403', 'CARAYBAMBA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30404, '030404', 'CHAPIMARCA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30405, '030405', 'COLCABAMBA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30406, '030406', 'COTARUSE', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30407, '030407', 'HUAYLLO', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30408, '030408', 'JUSTO APU SAHUARAURA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30409, '030409', 'LUCRE', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30410, '030410', 'POCOHUANCA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30411, '030411', 'SAN JUAN DE CHACÑA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30412, '030412', 'SAÑAYCA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30413, '030413', 'SORAYA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30414, '030414', 'TAPAIRIHUA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30415, '030415', 'TINTAY', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30416, '030416', 'TORAYA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30417, '030417', 'YANACA', '0304', 'AYMARAES', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30501, '030501', 'TAMBOBAMBA', '0305', 'COTABAMBAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30502, '030502', 'COTABAMBAS', '0305', 'COTABAMBAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30503, '030503', 'COYLLURQUI', '0305', 'COTABAMBAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30504, '030504', 'HAQUIRA', '0305', 'COTABAMBAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30505, '030505', 'MARA', '0305', 'COTABAMBAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30506, '030506', 'CHALLHUAHUACHO', '0305', 'COTABAMBAS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30601, '030601', 'CHINCHEROS', '0306', 'CHINCHEROS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30602, '030602', 'ANCO-HUALLO', '0306', 'CHINCHEROS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30603, '030603', 'COCHARCAS', '0306', 'CHINCHEROS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30604, '030604', 'HUACCANA', '0306', 'CHINCHEROS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30605, '030605', 'OCOBAMBA', '0306', 'CHINCHEROS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30606, '030606', 'ONGOY', '0306', 'CHINCHEROS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30607, '030607', 'URANMARCA', '0306', 'CHINCHEROS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30608, '030608', 'RANRACANCHA', '0306', 'CHINCHEROS', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30701, '030701', 'CHUQUIBAMBILLA', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30702, '030702', 'CURPAHUASI', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30703, '030703', 'GAMARRA', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30704, '030704', 'HUAYLLATI', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30705, '030705', 'MAMARA', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30706, '030706', 'MICAELA BASTIDAS', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30707, '030707', 'PATAYPAMPA', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30708, '030708', 'PROGRESO', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30709, '030709', 'SAN ANTONIO', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30710, '030710', 'SANTA ROSA', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30711, '030711', 'TURPAY', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30712, '030712', 'VILCABAMBA', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30713, '030713', 'VIRUNDO', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(30714, '030714', 'CURASCO', '0307', 'GRAU', '03', 'DEPARTAMENTO APURIMAC', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40101, '040101', 'AREQUIPA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40102, '040102', 'ALTO SELVA ALEGRE', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40103, '040103', 'CAYMA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40104, '040104', 'CERRO COLORADO', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40105, '040105', 'CHARACATO', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40106, '040106', 'CHIGUATA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40107, '040107', 'JACOBO HUNTER', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40108, '040108', 'LA JOYA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40109, '040109', 'MARIANO MELGAR', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40110, '040110', 'MIRAFLORES', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40111, '040111', 'MOLLEBAYA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40112, '040112', 'PAUCARPATA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40113, '040113', 'POCSI', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40114, '040114', 'POLOBAYA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40115, '040115', 'QUEQUEÑA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40116, '040116', 'SABANDIA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40117, '040117', 'SACHACA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40118, '040118', 'SAN JUAN DE SIGUAS /1', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40119, '040119', 'SAN JUAN DE TARUCANI', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40120, '040120', 'SANTA ISABEL DE SIGUAS', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40121, '040121', 'SANTA RITA DE SIGUAS', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40122, '040122', 'SOCABAYA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40123, '040123', 'TIABAYA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40124, '040124', 'UCHUMAYO', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40125, '040125', 'VITOR', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40126, '040126', 'YANAHUARA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40127, '040127', 'YARABAMBA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40128, '040128', 'YURA', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40129, '040129', 'JOSE LUIS BUSTAMANTE Y RIVERO', '0401', 'AREQUIPA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40201, '040201', 'CAMANA', '0402', 'CAMANA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40202, '040202', 'JOSE MARIA QUIMPER', '0402', 'CAMANA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40203, '040203', 'MARIANO NICOLAS VALCARCEL', '0402', 'CAMANA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40204, '040204', 'MARISCAL CACERES', '0402', 'CAMANA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40205, '040205', 'NICOLAS DE PIEROLA', '0402', 'CAMANA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40206, '040206', 'OCOÑA', '0402', 'CAMANA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40207, '040207', 'QUILCA', '0402', 'CAMANA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40208, '040208', 'SAMUEL PASTOR', '0402', 'CAMANA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40301, '040301', 'CARAVELI', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40302, '040302', 'ACARI', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40303, '040303', 'ATICO', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40304, '040304', 'ATIQUIPA', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40305, '040305', 'BELLA UNION', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40306, '040306', 'CAHUACHO', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40307, '040307', 'CHALA', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40308, '040308', 'CHAPARRA', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40309, '040309', 'HUANUHUANU', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40310, '040310', 'JAQUI', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40311, '040311', 'LOMAS', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1');
INSERT INTO `cji_ubigeo` (`UBIGP_Codigo`, `UBIGC_CodDist`, `UBIGC_Descripcion`, `UBIGC_CodProv`, `UBIGC_DescripcionProv`, `UBIGC_CodDpto`, `UBIGC_DescripcionDpto`, `UBIGC_FechaRegistro`, `UBIGC_FechaModificacion`, `UBIGC_FlagEstado`) VALUES
(40312, '040312', 'QUICACHA', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40313, '040313', 'YAUCA', '0403', 'CARAVELI', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40401, '040401', 'APLAO', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40402, '040402', 'ANDAGUA', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40403, '040403', 'AYO', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40404, '040404', 'CHACHAS', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40405, '040405', 'CHILCAYMARCA', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40406, '040406', 'CHOCO', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40407, '040407', 'HUANCARQUI', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40408, '040408', 'MACHAGUAY', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40409, '040409', 'ORCOPAMPA', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40410, '040410', 'PAMPACOLCA', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40411, '040411', 'TIPAN', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40412, '040412', 'UÑON', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40413, '040413', 'URACA', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40414, '040414', 'VIRACO', '0404', 'CASTILLA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40501, '040501', 'CHIVAY', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40502, '040502', 'ACHOMA', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40503, '040503', 'CABANACONDE', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40504, '040504', 'CALLALLI', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40505, '040505', 'CAYLLOMA', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40506, '040506', 'COPORAQUE', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40507, '040507', 'HUAMBO', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40508, '040508', 'HUANCA', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40509, '040509', 'ICHUPAMPA', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40510, '040510', 'LARI', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40511, '040511', 'LLUTA', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40512, '040512', 'MACA', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40513, '040513', 'MADRIGAL', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40514, '040514', 'SAN ANTONIO DE CHUCA  2/', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40515, '040515', 'SIBAYO', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40516, '040516', 'TAPAY', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40517, '040517', 'TISCO', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40518, '040518', 'TUTI', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40519, '040519', 'YANQUE', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40520, '040520', 'MAJES', '0405', 'CAYLLOMA', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40601, '040601', 'CHUQUIBAMBA', '0406', 'CONDESUYOS', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40602, '040602', 'ANDARAY', '0406', 'CONDESUYOS', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40603, '040603', 'CAYARANI', '0406', 'CONDESUYOS', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40604, '040604', 'CHICHAS', '0406', 'CONDESUYOS', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40605, '040605', 'IRAY', '0406', 'CONDESUYOS', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40606, '040606', 'RIO GRANDE', '0406', 'CONDESUYOS', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40607, '040607', 'SALAMANCA', '0406', 'CONDESUYOS', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40608, '040608', 'YANAQUIHUA', '0406', 'CONDESUYOS', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40701, '040701', 'MOLLENDO', '0407', 'ISLAY', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40702, '040702', 'COCACHACRA', '0407', 'ISLAY', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40703, '040703', 'DEAN VALDIVIA', '0407', 'ISLAY', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40704, '040704', 'ISLAY', '0407', 'ISLAY', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40705, '040705', 'MEJIA', '0407', 'ISLAY', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40706, '040706', 'PUNTA DE BOMBON', '0407', 'ISLAY', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40801, '040801', 'COTAHUASI', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40802, '040802', 'ALCA', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40803, '040803', 'CHARCANA', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40804, '040804', 'HUAYNACOTAS', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40805, '040805', 'PAMPAMARCA', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40806, '040806', 'PUYCA', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40807, '040807', 'QUECHUALLA', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40808, '040808', 'SAYLA', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40809, '040809', 'TAURIA', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40810, '040810', 'TOMEPAMPA', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(40811, '040811', 'TORO', '0408', 'LA UNION', '04', 'DEPARTAMENTO AREQUIPA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50101, '050101', 'AYACUCHO', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50102, '050102', 'ACOCRO', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50103, '050103', 'ACOS VINCHOS', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50104, '050104', 'CARMEN ALTO', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50105, '050105', 'CHIARA', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50106, '050106', 'OCROS', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50107, '050107', 'PACAYCASA', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50108, '050108', 'QUINUA', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50109, '050109', 'SAN JOSE DE TICLLAS', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50110, '050110', 'SAN JUAN BAUTISTA', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50111, '050111', 'SANTIAGO DE PISCHA', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50112, '050112', 'SOCOS', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50113, '050113', 'TAMBILLO', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50114, '050114', 'VINCHOS', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50115, '050115', 'JESUS NAZARENO', '0501', 'HUAMANGA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50201, '050201', 'CANGALLO', '0502', 'CANGALLO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50202, '050202', 'CHUSCHI', '0502', 'CANGALLO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50203, '050203', 'LOS MOROCHUCOS', '0502', 'CANGALLO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50204, '050204', 'MARIA PARADO DE BELLIDO', '0502', 'CANGALLO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50205, '050205', 'PARAS', '0502', 'CANGALLO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50206, '050206', 'TOTOS', '0502', 'CANGALLO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50301, '050301', 'SANCOS', '0503', 'HUANCA SANCOS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50302, '050302', 'CARAPO', '0503', 'HUANCA SANCOS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50303, '050303', 'SACSAMARCA', '0503', 'HUANCA SANCOS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50304, '050304', 'SANTIAGO DE LUCANAMARCA', '0503', 'HUANCA SANCOS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50401, '050401', 'HUANTA', '0504', 'HUANTA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50402, '050402', 'AYAHUANCO', '0504', 'HUANTA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50403, '050403', 'HUAMANGUILLA', '0504', 'HUANTA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50404, '050404', 'IGUAIN', '0504', 'HUANTA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50405, '050405', 'LURICOCHA', '0504', 'HUANTA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50406, '050406', 'SANTILLANA', '0504', 'HUANTA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50407, '050407', 'SIVIA', '0504', 'HUANTA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50408, '050408', 'LLOCHEGUA', '0504', 'HUANTA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50501, '050501', 'SAN MIGUEL', '0505', 'LA MAR', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50502, '050502', 'ANCO', '0505', 'LA MAR', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50503, '050503', 'AYNA', '0505', 'LA MAR', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50504, '050504', 'CHILCAS', '0505', 'LA MAR', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50505, '050505', 'CHUNGUI', '0505', 'LA MAR', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50506, '050506', 'LUIS CARRANZA', '0505', 'LA MAR', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50507, '050507', 'SANTA ROSA', '0505', 'LA MAR', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50508, '050508', 'TAMBO', '0505', 'LA MAR', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50601, '050601', 'PUQUIO', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50602, '050602', 'AUCARA', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50603, '050603', 'CABANA', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50604, '050604', 'CARMEN SALCEDO', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50605, '050605', 'CHAVIÑA', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50606, '050606', 'CHIPAO', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50607, '050607', 'HUAC-HUAS', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50608, '050608', 'LARAMATE', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50609, '050609', 'LEONCIO PRADO', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50610, '050610', 'LLAUTA', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50611, '050611', 'LUCANAS', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50612, '050612', 'OCAÑA', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50613, '050613', 'OTOCA', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50614, '050614', 'SAISA', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50615, '050615', 'SAN CRISTOBAL', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50616, '050616', 'SAN JUAN', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50617, '050617', 'SAN PEDRO', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50618, '050618', 'SAN PEDRO DE PALCO', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50619, '050619', 'SANCOS', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50620, '050620', 'SANTA ANA DE HUAYCAHUACHO', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50621, '050621', 'SANTA LUCIA', '0506', 'LUCANAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50701, '050701', 'CORACORA', '0507', 'PARINACOCHAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50702, '050702', 'CHUMPI', '0507', 'PARINACOCHAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50703, '050703', 'CORONEL CASTAÑEDA', '0507', 'PARINACOCHAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50704, '050704', 'PACAPAUSA', '0507', 'PARINACOCHAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50705, '050705', 'PULLO', '0507', 'PARINACOCHAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50706, '050706', 'PUYUSCA', '0507', 'PARINACOCHAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50707, '050707', 'SAN FRANCISCO DE RAVACAYCO', '0507', 'PARINACOCHAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50708, '050708', 'UPAHUACHO', '0507', 'PARINACOCHAS', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50801, '050801', 'PAUSA', '0508', 'PAUCAR DEL SARA SARA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50802, '050802', 'COLTA', '0508', 'PAUCAR DEL SARA SARA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50803, '050803', 'CORCULLA', '0508', 'PAUCAR DEL SARA SARA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50804, '050804', 'LAMPA', '0508', 'PAUCAR DEL SARA SARA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50805, '050805', 'MARCABAMBA', '0508', 'PAUCAR DEL SARA SARA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50806, '050806', 'OYOLO', '0508', 'PAUCAR DEL SARA SARA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50807, '050807', 'PARARCA', '0508', 'PAUCAR DEL SARA SARA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50808, '050808', 'SAN JAVIER DE ALPABAMBA', '0508', 'PAUCAR DEL SARA SARA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50809, '050809', 'SAN JOSE DE USHUA', '0508', 'PAUCAR DEL SARA SARA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50810, '050810', 'SARA SARA', '0508', 'PAUCAR DEL SARA SARA', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50901, '050901', 'QUEROBAMBA', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50902, '050902', 'BELEN', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50903, '050903', 'CHALCOS', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50904, '050904', 'CHILCAYOC', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50905, '050905', 'HUACAÑA', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50906, '050906', 'MORCOLLA', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50907, '050907', 'PAICO', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50908, '050908', 'SAN PEDRO DE LARCAY', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50909, '050909', 'SAN SALVADOR DE QUIJE', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50910, '050910', 'SANTIAGO DE PAUCARAY', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(50911, '050911', 'SORAS', '0509', 'SUCRE', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51001, '051001', 'HUANCAPI', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51002, '051002', 'ALCAMENCA', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51003, '051003', 'APONGO', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51004, '051004', 'ASQUIPATA', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51005, '051005', 'CANARIA', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51006, '051006', 'CAYARA', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51007, '051007', 'COLCA', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51008, '051008', 'HUAMANQUIQUIA', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51009, '051009', 'HUANCARAYLLA', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51010, '051010', 'HUAYA', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51011, '051011', 'SARHUA', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51012, '051012', 'VILCANCHOS', '0510', 'VICTOR FAJARDO', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51101, '051101', 'VILCAS HUAMAN', '0511', 'VILCAS HUAMAN', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51102, '051102', 'ACCOMARCA', '0511', 'VILCAS HUAMAN', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51103, '051103', 'CARHUANCA', '0511', 'VILCAS HUAMAN', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51104, '051104', 'CONCEPCION', '0511', 'VILCAS HUAMAN', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51105, '051105', 'HUAMBALPA', '0511', 'VILCAS HUAMAN', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51106, '051106', 'INDEPENDENCIA /1', '0511', 'VILCAS HUAMAN', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51107, '051107', 'SAURAMA', '0511', 'VILCAS HUAMAN', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(51108, '051108', 'VISCHONGO', '0511', 'VILCAS HUAMAN', '05', 'DEPARTAMENTO AYACUCHO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60101, '060101', 'CAJAMARCA', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60102, '060102', 'ASUNCION', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60103, '060103', 'CHETILLA', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60104, '060104', 'COSPAN', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60105, '060105', 'ENCAÑADA', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60106, '060106', 'JESUS', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60107, '060107', 'LLACANORA', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60108, '060108', 'LOS BAÑOS DEL INCA', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60109, '060109', 'MAGDALENA', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60110, '060110', 'MATARA', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60111, '060111', 'NAMORA', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60112, '060112', 'SAN JUAN', '0601', 'CAJAMARCA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60201, '060201', 'CAJABAMBA', '0602', 'CAJABAMBA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60202, '060202', 'CACHACHI', '0602', 'CAJABAMBA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60203, '060203', 'CONDEBAMBA', '0602', 'CAJABAMBA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60204, '060204', 'SITACOCHA', '0602', 'CAJABAMBA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60301, '060301', 'CELENDIN', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60302, '060302', 'CHUMUCH', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60303, '060303', 'CORTEGANA', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60304, '060304', 'HUASMIN', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60305, '060305', 'JORGE CHAVEZ', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60306, '060306', 'JOSE GALVEZ', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60307, '060307', 'MIGUEL IGLESIAS', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60308, '060308', 'OXAMARCA', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60309, '060309', 'SOROCHUCO', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60310, '060310', 'SUCRE', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60311, '060311', 'UTCO', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60312, '060312', 'LA LIBERTAD DE PALLAN', '0603', 'CELENDIN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60401, '060401', 'CHOTA', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60402, '060402', 'ANGUIA', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60403, '060403', 'CHADIN', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60404, '060404', 'CHIGUIRIP', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60405, '060405', 'CHIMBAN', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60406, '060406', 'CHOROPAMPA', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60407, '060407', 'COCHABAMBA', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60408, '060408', 'CONCHAN', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60409, '060409', 'HUAMBOS', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60410, '060410', 'LAJAS', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60411, '060411', 'LLAMA', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60412, '060412', 'MIRACOSTA', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60413, '060413', 'PACCHA', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60414, '060414', 'PION', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60415, '060415', 'QUEROCOTO', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60416, '060416', 'SAN JUAN DE LICUPIS', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60417, '060417', 'TACABAMBA', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60418, '060418', 'TOCMOCHE', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60419, '060419', 'CHALAMARCA', '0604', 'CHOTA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60501, '060501', 'CONTUMAZA', '0605', 'CONTUMAZA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60502, '060502', 'CHILETE', '0605', 'CONTUMAZA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60503, '060503', 'CUPISNIQUE', '0605', 'CONTUMAZA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60504, '060504', 'GUZMANGO', '0605', 'CONTUMAZA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60505, '060505', 'SAN BENITO', '0605', 'CONTUMAZA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60506, '060506', 'SANTA CRUZ DE TOLED', '0605', 'CONTUMAZA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60507, '060507', 'TANTARICA', '0605', 'CONTUMAZA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60508, '060508', 'YONAN', '0605', 'CONTUMAZA', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60601, '060601', 'CUTERVO', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60602, '060602', 'CALLAYUC', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60603, '060603', 'CHOROS', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60604, '060604', 'CUJILLO', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60605, '060605', 'LA RAMADA', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60606, '060606', 'PIMPINGOS', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60607, '060607', 'QUEROCOTILLO', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60608, '060608', 'SAN ANDRES DE CUTERVO', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60609, '060609', 'SAN JUAN DE CUTERVO', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60610, '060610', 'SAN LUIS DE LUCMA', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60611, '060611', 'SANTA CRUZ', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60612, '060612', 'SANTO DOMINGO DE LA CAPILLA', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60613, '060613', 'SANTO TOMAS', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60614, '060614', 'SOCOTA', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60615, '060615', 'TORIBIO CASANOVA', '0606', 'CUTERVO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60701, '060701', 'BAMBAMARCA', '0607', 'HUALGAYOC', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60702, '060702', 'CHUGUR', '0607', 'HUALGAYOC', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60703, '060703', 'HUALGAYOC', '0607', 'HUALGAYOC', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60801, '060801', 'JAEN', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60802, '060802', 'BELLAVISTA', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60803, '060803', 'CHONTALI', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60804, '060804', 'COLASAY', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60805, '060805', 'HUABAL', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60806, '060806', 'LAS PIRIAS', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60807, '060807', 'POMAHUACA', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60808, '060808', 'PUCARA', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60809, '060809', 'SALLIQUE', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60810, '060810', 'SAN FELIPE', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60811, '060811', 'SAN JOSE DEL ALTO', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60812, '060812', 'SANTA ROSA', '0608', 'JAEN', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60901, '060901', 'SAN IGNACIO', '0609', 'SAN IGNACIO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60902, '060902', 'CHIRINOS', '0609', 'SAN IGNACIO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60903, '060903', 'HUARANGO', '0609', 'SAN IGNACIO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60904, '060904', 'LA COIPA', '0609', 'SAN IGNACIO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60905, '060905', 'NAMBALLE', '0609', 'SAN IGNACIO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60906, '060906', 'SAN JOSE DE LOURDES', '0609', 'SAN IGNACIO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(60907, '060907', 'TABACONAS', '0609', 'SAN IGNACIO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61001, '061001', 'PEDRO GALVEZ', '0610', 'SAN MARCOS', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61002, '061002', 'CHANCAY', '0610', 'SAN MARCOS', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61003, '061003', 'EDUARDO VILLANUEVA', '0610', 'SAN MARCOS', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61004, '061004', 'GREGORIO PITA', '0610', 'SAN MARCOS', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61005, '061005', 'ICHOCAN', '0610', 'SAN MARCOS', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61006, '061006', 'JOSE MANUEL QUIROZ', '0610', 'SAN MARCOS', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61007, '061007', 'JOSE SABOGAL', '0610', 'SAN MARCOS', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61101, '061101', 'SAN MIGUEL', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61102, '061102', 'BOLIVAR', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61103, '061103', 'CALQUIS', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61104, '061104', 'CATILLUC', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61105, '061105', 'EL PRADO', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61106, '061106', 'LA FLORIDA', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61107, '061107', 'LLAPA', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61108, '061108', 'NANCHOC', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61109, '061109', 'NIEPOS', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61110, '061110', 'SAN GREGORIO', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61111, '061111', 'SAN SILVESTRE DE COCHAN', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61112, '061112', 'TONGOD', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61113, '061113', 'UNION AGUA BLANCA', '0611', 'SAN MIGUEL', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61201, '061201', 'SAN PABLO', '0612', 'SAN PABLO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61202, '061202', 'SAN BERNARDINO', '0612', 'SAN PABLO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61203, '061203', 'SAN LUIS', '0612', 'SAN PABLO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61204, '061204', 'TUMBADEN', '0612', 'SAN PABLO', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61301, '061301', 'SANTA CRUZ', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61302, '061302', 'ANDABAMBA', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61303, '061303', 'CATACHE', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61304, '061304', 'CHANCAYBAÑOS', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61305, '061305', 'LA ESPERANZA', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61306, '061306', 'NINABAMBA', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61307, '061307', 'PULAN', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61308, '061308', 'SAUCEPAMPA', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61309, '061309', 'SEXI', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61310, '061310', 'UTICYACU', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(61311, '061311', 'YAUYUCAN', '0613', 'SANTA CRUZ', '06', 'DEPARTAMENTO CAJAMARCA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(70101, '070101', 'CALLAO', '0701', 'PROV. CONST. DEL CALLAO', '07', 'PROV. CONST. DEL CALLAO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(70102, '070102', 'BELLAVISTA', '0701', 'PROV. CONST. DEL CALLAO', '07', 'PROV. CONST. DEL CALLAO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(70103, '070103', 'CARMEN DE LA LEGUA REYNOSO', '0701', 'PROV. CONST. DEL CALLAO', '07', 'PROV. CONST. DEL CALLAO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(70104, '070104', 'LA PERLA', '0701', 'PROV. CONST. DEL CALLAO', '07', 'PROV. CONST. DEL CALLAO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(70105, '070105', 'LA PUNTA', '0701', 'PROV. CONST. DEL CALLAO', '07', 'PROV. CONST. DEL CALLAO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(70106, '070106', 'VENTANILLA', '0701', 'PROV. CONST. DEL CALLAO', '07', 'PROV. CONST. DEL CALLAO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80101, '080101', 'CUSCO', '0801', 'CUSCO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80102, '080102', 'CCORCA', '0801', 'CUSCO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80103, '080103', 'POROY', '0801', 'CUSCO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80104, '080104', 'SAN JERONIMO', '0801', 'CUSCO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80105, '080105', 'SAN SEBASTIAN', '0801', 'CUSCO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80106, '080106', 'SANTIAGO', '0801', 'CUSCO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80107, '080107', 'SAYLLA', '0801', 'CUSCO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80108, '080108', 'WANCHAQ', '0801', 'CUSCO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80201, '080201', 'ACOMAYO', '0802', 'ACOMAYO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80202, '080202', 'ACOPIA', '0802', 'ACOMAYO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80203, '080203', 'ACOS', '0802', 'ACOMAYO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80204, '080204', 'MOSOC LLACTA', '0802', 'ACOMAYO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80205, '080205', 'POMACANCHI', '0802', 'ACOMAYO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80206, '080206', 'RONDOCAN', '0802', 'ACOMAYO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80207, '080207', 'SANGARARA', '0802', 'ACOMAYO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80301, '080301', 'ANTA', '0803', 'ANTA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80302, '080302', 'ANCAHUASI', '0803', 'ANTA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80303, '080303', 'CACHIMAYO', '0803', 'ANTA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80304, '080304', 'CHINCHAYPUJIO', '0803', 'ANTA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80305, '080305', 'HUAROCONDO', '0803', 'ANTA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80306, '080306', 'LIMATAMBO', '0803', 'ANTA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80307, '080307', 'MOLLEPATA', '0803', 'ANTA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80308, '080308', 'PUCYURA', '0803', 'ANTA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80309, '080309', 'ZURITE', '0803', 'ANTA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80401, '080401', 'CALCA', '0804', 'CALCA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80402, '080402', 'COYA', '0804', 'CALCA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80403, '080403', 'LAMAY', '0804', 'CALCA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80404, '080404', 'LARES', '0804', 'CALCA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80405, '080405', 'PISAC', '0804', 'CALCA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80406, '080406', 'SAN SALVADOR', '0804', 'CALCA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80407, '080407', 'TARAY', '0804', 'CALCA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80408, '080408', 'YANATILE', '0804', 'CALCA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80501, '080501', 'YANAOCA', '0805', 'CANAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80502, '080502', 'CHECCA', '0805', 'CANAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80503, '080503', 'KUNTURKANKI', '0805', 'CANAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80504, '080504', 'LANGUI', '0805', 'CANAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80505, '080505', 'LAYO', '0805', 'CANAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80506, '080506', 'PAMPAMARCA', '0805', 'CANAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80507, '080507', 'QUEHUE', '0805', 'CANAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80508, '080508', 'TUPAC AMARU', '0805', 'CANAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80601, '080601', 'SICUANI', '0806', 'CANCHIS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80602, '080602', 'CHECACUPE', '0806', 'CANCHIS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80603, '080603', 'COMBAPATA', '0806', 'CANCHIS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80604, '080604', 'MARANGANI', '0806', 'CANCHIS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80605, '080605', 'PITUMARCA', '0806', 'CANCHIS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80606, '080606', 'SAN PABLO', '0806', 'CANCHIS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80607, '080607', 'SAN PEDRO', '0806', 'CANCHIS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80608, '080608', 'TINTA', '0806', 'CANCHIS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80701, '080701', 'SANTO TOMAS', '0807', 'CHUMBIVILCAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80702, '080702', 'CAPACMARCA', '0807', 'CHUMBIVILCAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80703, '080703', 'CHAMACA', '0807', 'CHUMBIVILCAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80704, '080704', 'COLQUEMARCA', '0807', 'CHUMBIVILCAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80705, '080705', 'LIVITACA', '0807', 'CHUMBIVILCAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80706, '080706', 'LLUSCO', '0807', 'CHUMBIVILCAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80707, '080707', 'QUIÑOTA', '0807', 'CHUMBIVILCAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80708, '080708', 'VELILLE', '0807', 'CHUMBIVILCAS', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80801, '080801', 'ESPINAR', '0808', 'ESPINAR', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80802, '080802', 'CONDOROMA', '0808', 'ESPINAR', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80803, '080803', 'COPORAQUE', '0808', 'ESPINAR', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80804, '080804', 'OCORURO', '0808', 'ESPINAR', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80805, '080805', 'PALLPATA', '0808', 'ESPINAR', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80806, '080806', 'PICHIGUA', '0808', 'ESPINAR', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80807, '080807', 'SUYCKUTAMBO 3/', '0808', 'ESPINAR', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80808, '080808', 'ALTO PICHIGUA', '0808', 'ESPINAR', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80901, '080901', 'SANTA ANA', '0809', 'LA CONVENCION', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80902, '080902', 'ECHARATE', '0809', 'LA CONVENCION', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80903, '080903', 'HUAYOPATA /1', '0809', 'LA CONVENCION', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80904, '080904', 'MARANURA', '0809', 'LA CONVENCION', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80905, '080905', 'OCOBAMBA  /2', '0809', 'LA CONVENCION', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80906, '080906', 'QUELLOUNO', '0809', 'LA CONVENCION', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80907, '080907', 'KIMBIRI', '0809', 'LA CONVENCION', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1');
INSERT INTO `cji_ubigeo` (`UBIGP_Codigo`, `UBIGC_CodDist`, `UBIGC_Descripcion`, `UBIGC_CodProv`, `UBIGC_DescripcionProv`, `UBIGC_CodDpto`, `UBIGC_DescripcionDpto`, `UBIGC_FechaRegistro`, `UBIGC_FechaModificacion`, `UBIGC_FlagEstado`) VALUES
(80908, '080908', 'SANTA TERESA', '0809', 'LA CONVENCION', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80909, '080909', 'VILCABAMBA', '0809', 'LA CONVENCION', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(80910, '080910', 'PICHARI', '0809', 'LA CONVENCION', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81001, '081001', 'PARURO', '0810', 'PARURO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81002, '081002', 'ACCHA', '0810', 'PARURO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81003, '081003', 'CCAPI', '0810', 'PARURO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81004, '081004', 'COLCHA', '0810', 'PARURO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81005, '081005', 'HUANOQUITE', '0810', 'PARURO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81006, '081006', 'OMACHA', '0810', 'PARURO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81007, '081007', 'PACCARITAMBO', '0810', 'PARURO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81008, '081008', 'PILLPINTO', '0810', 'PARURO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81009, '081009', 'YAURISQUE', '0810', 'PARURO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81101, '081101', 'PAUCARTAMBO', '0811', 'PAUCARTAMBO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81102, '081102', 'CAICAY', '0811', 'PAUCARTAMBO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81103, '081103', 'CHALLABAMBA', '0811', 'PAUCARTAMBO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81104, '081104', 'COLQUEPATA', '0811', 'PAUCARTAMBO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81105, '081105', 'HUANCARANI', '0811', 'PAUCARTAMBO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81106, '081106', 'KOSÑIPATA', '0811', 'PAUCARTAMBO', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81201, '081201', 'URCOS', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81202, '081202', 'ANDAHUAYLILLAS', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81203, '081203', 'CAMANTI', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81204, '081204', 'CCARHUAYO', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81205, '081205', 'CCATCA', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81206, '081206', 'CUSIPATA', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81207, '081207', 'HUARO', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81208, '081208', 'LUCRE', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81209, '081209', 'MARCAPATA', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81210, '081210', 'OCONGATE', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81211, '081211', 'OROPESA', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81212, '081212', 'QUIQUIJANA', '0812', 'QUISPICANCHI', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81301, '081301', 'URUBAMBA', '0813', 'URUBAMBA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81302, '081302', 'CHINCHERO', '0813', 'URUBAMBA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81303, '081303', 'HUAYLLABAMBA', '0813', 'URUBAMBA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81304, '081304', 'MACHUPICCHU', '0813', 'URUBAMBA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81305, '081305', 'MARAS', '0813', 'URUBAMBA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81306, '081306', 'OLLANTAYTAMBO', '0813', 'URUBAMBA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(81307, '081307', 'YUCAY', '0813', 'URUBAMBA', '08', 'DEPARTAMENTO CUSCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90101, '090101', 'HUANCAVELICA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90102, '090102', 'ACOBAMBILLA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90103, '090103', 'ACORIA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90104, '090104', 'CONAYCA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90105, '090105', 'CUENCA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90106, '090106', 'HUACHOCOLPA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90107, '090107', 'HUAYLLAHUARA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90108, '090108', 'IZCUCHACA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90109, '090109', 'LARIA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90110, '090110', 'MANTA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90111, '090111', 'MARISCAL CACERES', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90112, '090112', 'MOYA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90113, '090113', 'NUEVO OCCORO', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90114, '090114', 'PALCA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90115, '090115', 'PILCHACA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90116, '090116', 'VILCA', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90117, '090117', 'YAULI', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90118, '090118', 'ASCENSION', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90119, '090119', 'HUANDO', '0901', 'HUANCAVELICA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90201, '090201', 'ACOBAMBA', '0902', 'ACOBAMBA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90202, '090202', 'ANDABAMBA', '0902', 'ACOBAMBA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90203, '090203', 'ANTA', '0902', 'ACOBAMBA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90204, '090204', 'CAJA', '0902', 'ACOBAMBA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90205, '090205', 'MARCAS', '0902', 'ACOBAMBA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90206, '090206', 'PAUCARA', '0902', 'ACOBAMBA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90207, '090207', 'POMACOCHA', '0902', 'ACOBAMBA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90208, '090208', 'ROSARIO', '0902', 'ACOBAMBA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90301, '090301', 'LIRCAY', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90302, '090302', 'ANCHONGA', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90303, '090303', 'CALLANMARCA', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90304, '090304', 'CCOCHACCASA', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90305, '090305', 'CHINCHO', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90306, '090306', 'CONGALLA', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90307, '090307', 'HUANCA-HUANCA', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90308, '090308', 'HUAYLLAY GRANDE', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90309, '090309', 'JULCAMARCA', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90310, '090310', 'SAN ANTONIO DE ANTAPARCO', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90311, '090311', 'SANTO TOMAS DE PATA', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90312, '090312', 'SECCLLA', '0903', 'ANGARAES', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90401, '090401', 'CASTROVIRREYNA', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90402, '090402', 'ARMA', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90403, '090403', 'AURAHUA', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90404, '090404', 'CAPILLAS', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90405, '090405', 'CHUPAMARCA', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90406, '090406', 'COCAS', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90407, '090407', 'HUACHOS', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90408, '090408', 'HUAMATAMBO', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90409, '090409', 'MOLLEPAMPA', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90410, '090410', 'SAN JUAN', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90411, '090411', 'SANTA ANA', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90412, '090412', 'TANTARA', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90413, '090413', 'TICRAPO', '0904', 'CASTROVIRREYNA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90501, '090501', 'CHURCAMPA', '0905', 'CHURCAMPA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90502, '090502', 'ANCO', '0905', 'CHURCAMPA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90503, '090503', 'CHINCHIHUASI', '0905', 'CHURCAMPA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90504, '090504', 'EL CARMEN', '0905', 'CHURCAMPA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90505, '090505', 'LA MERCED', '0905', 'CHURCAMPA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90506, '090506', 'LOCROJA', '0905', 'CHURCAMPA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90507, '090507', 'PAUCARBAMBA', '0905', 'CHURCAMPA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90508, '090508', 'SAN MIGUEL DE MAYOCC', '0905', 'CHURCAMPA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90509, '090509', 'SAN PEDRO DE CORIS', '0905', 'CHURCAMPA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90510, '090510', 'PACHAMARCA', '0905', 'CHURCAMPA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90601, '090601', 'HUAYTARA', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90602, '090602', 'AYAVI', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90603, '090603', 'CORDOVA', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90604, '090604', 'HUAYACUNDO ARMA', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90605, '090605', 'LARAMARCA', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90606, '090606', 'OCOYO', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90607, '090607', 'PILPICHACA', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90608, '090608', 'QUERCO', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90609, '090609', 'QUITO-ARMA', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90610, '090610', 'SAN ANTONIO DE CUSICANCHA', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90611, '090611', 'SAN FRANCISCO DE SANGAYAICO', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90612, '090612', 'SAN ISIDRO', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90613, '090613', 'SANTIAGO DE CHOCORVOS', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90614, '090614', 'SANTIAGO DE QUIRAHUARA', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90615, '090615', 'SANTO DOMINGO DE CAPILLAS', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90616, '090616', 'TAMBO', '0906', 'HUAYTARA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90701, '090701', 'PAMPAS', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90702, '090702', 'ACOSTAMBO', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90703, '090703', 'ACRAQUIA', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90704, '090704', 'AHUAYCHA', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90705, '090705', 'COLCABAMBA', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90706, '090706', 'DANIEL HERNANDEZ', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90707, '090707', 'HUACHOCOLPA', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90709, '090709', 'HUARIBAMBA', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90710, '090710', 'ÑAHUIMPUQUIO', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90711, '090711', 'PAZOS', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90713, '090713', 'QUISHUAR', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90714, '090714', 'SALCABAMBA', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90715, '090715', 'SALCAHUASI', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90716, '090716', 'SAN MARCOS DE ROCCHAC', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90717, '090717', 'SURCUBAMBA', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(90718, '090718', 'TINTAY PUNCU', '0907', 'TAYACAJA', '09', 'DEPARTAMENTO HUANCAVELICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100101, '100101', 'HUANUCO', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100102, '100102', 'AMARILIS', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100103, '100103', 'CHINCHAO', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100104, '100104', 'CHURUBAMBA', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100105, '100105', 'MARGOS', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100106, '100106', 'QUISQUI', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100107, '100107', 'SAN FRANCISCO DE CAYRAN', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100108, '100108', 'SAN PEDRO DE CHAULAN', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100109, '100109', 'SANTA MARIA DEL VALLE', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100110, '100110', 'YARUMAYO', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100111, '100111', 'PILLCO MARCA', '1001', 'HUANUCO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100201, '100201', 'AMBO', '1002', 'AMBO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100202, '100202', 'CAYNA', '1002', 'AMBO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100203, '100203', 'COLPAS', '1002', 'AMBO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100204, '100204', 'CONCHAMARCA', '1002', 'AMBO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100205, '100205', 'HUACAR', '1002', 'AMBO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100206, '100206', 'SAN FRANCISCO', '1002', 'AMBO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100207, '100207', 'SAN RAFAEL', '1002', 'AMBO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100208, '100208', 'TOMAY KICHWA', '1002', 'AMBO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100301, '100301', 'LA UNION', '1003', 'DOS DE MAYO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100307, '100307', 'CHUQUIS', '1003', 'DOS DE MAYO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100311, '100311', 'MARIAS', '1003', 'DOS DE MAYO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100313, '100313', 'PACHAS', '1003', 'DOS DE MAYO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100316, '100316', 'QUIVILLA', '1003', 'DOS DE MAYO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100317, '100317', 'RIPAN', '1003', 'DOS DE MAYO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100321, '100321', 'SHUNQUI', '1003', 'DOS DE MAYO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100322, '100322', 'SILLAPATA', '1003', 'DOS DE MAYO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100323, '100323', 'YANAS', '1003', 'DOS DE MAYO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100401, '100401', 'HUACAYBAMBA', '1004', 'HUACAYBAMBA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100402, '100402', 'CANCHABAMBA', '1004', 'HUACAYBAMBA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100403, '100403', 'COCHABAMBA', '1004', 'HUACAYBAMBA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100404, '100404', 'PINRA', '1004', 'HUACAYBAMBA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100501, '100501', 'LLATA', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100502, '100502', 'ARANCAY', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100503, '100503', 'CHAVIN DE PARIARCA', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100504, '100504', 'JACAS GRANDE', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100505, '100505', 'JIRCAN', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100506, '100506', 'MIRAFLORES', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100507, '100507', 'MONZON', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100508, '100508', 'PUNCHAO', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100509, '100509', 'PUÑOS', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100510, '100510', 'SINGA', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100511, '100511', 'TANTAMAYO', '1005', 'HUAMALIES', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100601, '100601', 'RUPA-RUPA', '1006', 'LEONCIO PRADO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100602, '100602', 'DANIEL ALOMIA ROBLES', '1006', 'LEONCIO PRADO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100603, '100603', 'HERMILIO VALDIZAN', '1006', 'LEONCIO PRADO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100604, '100604', 'JOSE CRESPO Y CASTILLO', '1006', 'LEONCIO PRADO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100605, '100605', 'LUYANDO 1/', '1006', 'LEONCIO PRADO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100606, '100606', 'MARIANO DAMASO BERAUN', '1006', 'LEONCIO PRADO', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100701, '100701', 'HUACRACHUCO', '1007', 'MARAÑON', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100702, '100702', 'CHOLON', '1007', 'MARAÑON', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100703, '100703', 'SAN BUENAVENTURA', '1007', 'MARAÑON', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100801, '100801', 'PANAO', '1008', 'PACHITEA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100802, '100802', 'CHAGLLA', '1008', 'PACHITEA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100803, '100803', 'MOLINO', '1008', 'PACHITEA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100804, '100804', 'UMARI', '1008', 'PACHITEA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100901, '100901', 'PUERTO INCA', '1009', 'PUERTO INCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100902, '100902', 'CODO DEL POZUZO', '1009', 'PUERTO INCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100903, '100903', 'HONORIA', '1009', 'PUERTO INCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100904, '100904', 'TOURNAVISTA', '1009', 'PUERTO INCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(100905, '100905', 'YUYAPICHIS', '1009', 'PUERTO INCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101001, '101001', 'JESUS', '1010', 'LAURICOCHA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101002, '101002', 'BAÑOS', '1010', 'LAURICOCHA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101003, '101003', 'JIVIA', '1010', 'LAURICOCHA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101004, '101004', 'QUEROPALCA', '1010', 'LAURICOCHA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101005, '101005', 'RONDOS', '1010', 'LAURICOCHA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101006, '101006', 'SAN FRANCISCO DE ASIS', '1010', 'LAURICOCHA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101007, '101007', 'SAN MIGUEL DE CAURI', '1010', 'LAURICOCHA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101101, '101101', 'CHAVINILLO', '1011', 'YAROWILCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101102, '101102', 'CAHUAC', '1011', 'YAROWILCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101103, '101103', 'CHACABAMBA', '1011', 'YAROWILCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101104, '101104', 'APARICIO POMARES', '1011', 'YAROWILCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101105, '101105', 'JACAS CHICO', '1011', 'YAROWILCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101106, '101106', 'OBAS', '1011', 'YAROWILCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101107, '101107', 'PAMPAMARCA', '1011', 'YAROWILCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(101108, '101108', 'CHORAS', '1011', 'YAROWILCA', '10', 'DEPARTAMENTO HUANUCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110101, '110101', 'ICA', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110102, '110102', 'LA TINGUIÑA', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110103, '110103', 'LOS AQUIJES', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110104, '110104', 'OCUCAJE', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110105, '110105', 'PACHACUTEC', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110106, '110106', 'PARCONA', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110107, '110107', 'PUEBLO NUEVO', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110108, '110108', 'SALAS', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110109, '110109', 'SAN JOSE DE LOS MOLINOS', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110110, '110110', 'SAN JUAN BAUTISTA', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110111, '110111', 'SANTIAGO', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110112, '110112', 'SUBTANJALLA', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110113, '110113', 'TATE', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110114, '110114', 'YAUCA DEL ROSARIO  1/', '1101', 'ICA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110201, '110201', 'CHINCHA ALTA', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110202, '110202', 'ALTO LARAN', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110203, '110203', 'CHAVIN', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110204, '110204', 'CHINCHA BAJA', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110205, '110205', 'EL CARMEN', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110206, '110206', 'GROCIO PRADO', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110207, '110207', 'PUEBLO NUEVO', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110208, '110208', 'SAN JUAN DE YANAC', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110209, '110209', 'SAN PEDRO DE HUACARPANA', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110210, '110210', 'SUNAMPE', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110211, '110211', 'TAMBO DE MORA', '1102', 'CHINCHA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110301, '110301', 'NAZCA', '1103', 'NAZCA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110302, '110302', 'CHANGUILLO', '1103', 'NAZCA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110303, '110303', 'EL INGENIO', '1103', 'NAZCA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110304, '110304', 'MARCONA', '1103', 'NAZCA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110305, '110305', 'VISTA ALEGRE', '1103', 'NAZCA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110401, '110401', 'PALPA', '1104', 'PALPA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110402, '110402', 'LLIPATA', '1104', 'PALPA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110403, '110403', 'RIO GRANDE', '1104', 'PALPA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110404, '110404', 'SANTA CRUZ', '1104', 'PALPA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110405, '110405', 'TIBILLO', '1104', 'PALPA', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110501, '110501', 'PISCO', '1105', 'PISCO', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110502, '110502', 'HUANCANO', '1105', 'PISCO', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110503, '110503', 'HUMAY', '1105', 'PISCO', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110504, '110504', 'INDEPENDENCIA', '1105', 'PISCO', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110505, '110505', 'PARACAS', '1105', 'PISCO', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110506, '110506', 'SAN ANDRES', '1105', 'PISCO', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110507, '110507', 'SAN CLEMENTE', '1105', 'PISCO', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(110508, '110508', 'TUPAC AMARU INCA', '1105', 'PISCO', '11', 'DEPARTAMENTO ICA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120101, '120101', 'HUANCAYO', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120104, '120104', 'CARHUACALLANGA', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120105, '120105', 'CHACAPAMPA', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120106, '120106', 'CHICCHE', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120107, '120107', 'CHILCA', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120108, '120108', 'CHONGOS ALTO', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120111, '120111', 'CHUPURO', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120112, '120112', 'COLCA', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120113, '120113', 'CULLHUAS', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120114, '120114', 'EL TAMBO', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120116, '120116', 'HUACRAPUQUIO', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120117, '120117', 'HUALHUAS', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120119, '120119', 'HUANCAN', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120120, '120120', 'HUASICANCHA', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120121, '120121', 'HUAYUCACHI', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120122, '120122', 'INGENIO', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120124, '120124', 'PARIAHUANCA   1/', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120125, '120125', 'PILCOMAYO', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120126, '120126', 'PUCARA', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120127, '120127', 'QUICHUAY', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120128, '120128', 'QUILCAS', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120129, '120129', 'SAN AGUSTIN', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120130, '120130', 'SAN JERONIMO DE TUNAN', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120132, '120132', 'SAÑO', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120133, '120133', 'SAPALLANGA', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120134, '120134', 'SICAYA', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120135, '120135', 'SANTO DOMINGO DE ACOBAMBA', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120136, '120136', 'VIQUES', '1201', 'HUANCAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120201, '120201', 'CONCEPCION', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120202, '120202', 'ACO', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120203, '120203', 'ANDAMARCA', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120204, '120204', 'CHAMBARA', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120205, '120205', 'COCHAS', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120206, '120206', 'COMAS', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120207, '120207', 'HEROINAS TOLEDO', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120208, '120208', 'MANZANARES', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120209, '120209', 'MARISCAL CASTILLA', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120210, '120210', 'MATAHUASI', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120211, '120211', 'MITO', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120212, '120212', 'NUEVE DE JULIO', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120213, '120213', 'ORCOTUNA', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120214, '120214', 'SAN JOSE DE QUERO', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120215, '120215', 'SANTA ROSA DE OCOPA', '1202', 'CONCEPCION', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120301, '120301', 'CHANCHAMAYO', '1203', 'CHANCHAMAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120302, '120302', 'PERENE', '1203', 'CHANCHAMAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120303, '120303', 'PICHANAQUI', '1203', 'CHANCHAMAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120304, '120304', 'SAN LUIS DE SHUARO', '1203', 'CHANCHAMAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120305, '120305', 'SAN RAMON', '1203', 'CHANCHAMAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120306, '120306', 'VITOC', '1203', 'CHANCHAMAYO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120401, '120401', 'JAUJA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120402, '120402', 'ACOLLA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120403, '120403', 'APATA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120404, '120404', 'ATAURA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120405, '120405', 'CANCHAYLLO', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120406, '120406', 'CURICACA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120407, '120407', 'EL MANTARO', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120408, '120408', 'HUAMALI', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120409, '120409', 'HUARIPAMPA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120410, '120410', 'HUERTAS', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120411, '120411', 'JANJAILLO', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120412, '120412', 'JULCAN', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120413, '120413', 'LEONOR ORDOÑEZ', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120414, '120414', 'LLOCLLAPAMPA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120415, '120415', 'MARCO', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120416, '120416', 'MASMA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120417, '120417', 'MASMA CHICCHE', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120418, '120418', 'MOLINOS', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120419, '120419', 'MONOBAMBA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120420, '120420', 'MUQUI', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120421, '120421', 'MUQUIYAUYO', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120422, '120422', 'PACA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120423, '120423', 'PACCHA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120424, '120424', 'PANCAN', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120425, '120425', 'PARCO', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120426, '120426', 'POMACANCHA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120427, '120427', 'RICRAN', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120428, '120428', 'SAN LORENZO', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120429, '120429', 'SAN PEDRO DE CHUNAN', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120430, '120430', 'SAUSA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120431, '120431', 'SINCOS', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120432, '120432', 'TUNAN MARCA', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120433, '120433', 'YAULI', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120434, '120434', 'YAUYOS', '1204', 'JAUJA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120501, '120501', 'JUNIN', '1205', 'JUNIN', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120502, '120502', 'CARHUAMAYO', '1205', 'JUNIN', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120503, '120503', 'ONDORES', '1205', 'JUNIN', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120504, '120504', 'ULCUMAYO', '1205', 'JUNIN', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120601, '120601', 'SATIPO', '1206', 'SATIPO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120602, '120602', 'COVIRIALI', '1206', 'SATIPO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120603, '120603', 'LLAYLLA', '1206', 'SATIPO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120604, '120604', 'MAZAMARI', '1206', 'SATIPO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120605, '120605', 'PAMPA HERMOSA', '1206', 'SATIPO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120606, '120606', 'PANGOA', '1206', 'SATIPO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120607, '120607', 'RIO NEGRO', '1206', 'SATIPO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120608, '120608', 'RIO TAMBO', '1206', 'SATIPO', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120701, '120701', 'TARMA', '1207', 'TARMA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120702, '120702', 'ACOBAMBA', '1207', 'TARMA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120703, '120703', 'HUARICOLCA', '1207', 'TARMA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120704, '120704', 'HUASAHUASI', '1207', 'TARMA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120705, '120705', 'LA UNION', '1207', 'TARMA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120706, '120706', 'PALCA', '1207', 'TARMA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120707, '120707', 'PALCAMAYO', '1207', 'TARMA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120708, '120708', 'SAN PEDRO DE CAJAS', '1207', 'TARMA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120709, '120709', 'TAPO', '1207', 'TARMA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120801, '120801', 'LA OROYA', '1208', 'YAULI', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120802, '120802', 'CHACAPALPA', '1208', 'YAULI', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120803, '120803', 'HUAY-HUAY', '1208', 'YAULI', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120804, '120804', 'MARCAPOMACOCHA', '1208', 'YAULI', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120805, '120805', 'MOROCOCHA', '1208', 'YAULI', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120806, '120806', 'PACCHA', '1208', 'YAULI', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120807, '120807', 'SANTA BARBARA DE CARHUACAYAN', '1208', 'YAULI', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120808, '120808', 'SANTA ROSA DE SACCO', '1208', 'YAULI', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120809, '120809', 'SUITUCANCHA', '1208', 'YAULI', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120810, '120810', 'YAULI', '1208', 'YAULI', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120901, '120901', 'CHUPACA', '1209', 'CHUPACA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120902, '120902', 'AHUAC', '1209', 'CHUPACA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120903, '120903', 'CHONGOS BAJO', '1209', 'CHUPACA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120904, '120904', 'HUACHAC', '1209', 'CHUPACA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120905, '120905', 'HUAMANCACA CHICO', '1209', 'CHUPACA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120906, '120906', 'SAN JUAN DE ISCOS', '1209', 'CHUPACA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120907, '120907', 'SAN JUAN DE JARPA', '1209', 'CHUPACA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120908, '120908', 'TRES DE DICIEMBRE', '1209', 'CHUPACA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(120909, '120909', 'YANACANCHA', '1209', 'CHUPACA', '12', 'DEPARTAMENTO JUNIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130101, '130101', 'TRUJILLO', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130102, '130102', 'EL PORVENIR', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130103, '130103', 'FLORENCIA DE MORA', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1');
INSERT INTO `cji_ubigeo` (`UBIGP_Codigo`, `UBIGC_CodDist`, `UBIGC_Descripcion`, `UBIGC_CodProv`, `UBIGC_DescripcionProv`, `UBIGC_CodDpto`, `UBIGC_DescripcionDpto`, `UBIGC_FechaRegistro`, `UBIGC_FechaModificacion`, `UBIGC_FlagEstado`) VALUES
(130104, '130104', 'HUANCHACO', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130105, '130105', 'LA ESPERANZA', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130106, '130106', 'LAREDO', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130107, '130107', 'MOCHE', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130108, '130108', 'POROTO', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130109, '130109', 'SALAVERRY', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130110, '130110', 'SIMBAL', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130111, '130111', 'VICTOR LARCO HERRERA', '1301', 'TRUJILLO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130201, '130201', 'ASCOPE', '1302', 'ASCOPE', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130202, '130202', 'CHICAMA', '1302', 'ASCOPE', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130203, '130203', 'CHOCOPE', '1302', 'ASCOPE', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130204, '130204', 'MAGDALENA DE CAO', '1302', 'ASCOPE', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130205, '130205', 'PAIJAN', '1302', 'ASCOPE', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130206, '130206', 'RAZURI', '1302', 'ASCOPE', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130207, '130207', 'SANTIAGO DE CAO', '1302', 'ASCOPE', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130208, '130208', 'CASA GRANDE', '1302', 'ASCOPE', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130301, '130301', 'BOLIVAR', '1303', 'BOLIVAR', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130302, '130302', 'BAMBAMARCA', '1303', 'BOLIVAR', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130303, '130303', 'CONDORMARCA /1', '1303', 'BOLIVAR', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130304, '130304', 'LONGOTEA', '1303', 'BOLIVAR', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130305, '130305', 'UCHUMARCA', '1303', 'BOLIVAR', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130306, '130306', 'UCUNCHA', '1303', 'BOLIVAR', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130401, '130401', 'CHEPEN', '1304', 'CHEPEN', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130402, '130402', 'PACANGA', '1304', 'CHEPEN', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130403, '130403', 'PUEBLO NUEVO', '1304', 'CHEPEN', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130501, '130501', 'JULCAN', '1305', 'JULCAN', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130502, '130502', 'CALAMARCA', '1305', 'JULCAN', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130503, '130503', 'CARABAMBA', '1305', 'JULCAN', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130504, '130504', 'HUASO', '1305', 'JULCAN', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130601, '130601', 'OTUZCO', '1306', 'OTUZCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130602, '130602', 'AGALLPAMPA', '1306', 'OTUZCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130604, '130604', 'CHARAT', '1306', 'OTUZCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130605, '130605', 'HUARANCHAL', '1306', 'OTUZCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130606, '130606', 'LA CUESTA', '1306', 'OTUZCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130608, '130608', 'MACHE', '1306', 'OTUZCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130610, '130610', 'PARANDAY', '1306', 'OTUZCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130611, '130611', 'SALPO', '1306', 'OTUZCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130613, '130613', 'SINSICAP', '1306', 'OTUZCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130614, '130614', 'USQUIL', '1306', 'OTUZCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130701, '130701', 'SAN PEDRO DE LLOC', '1307', 'PACASMAYO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130702, '130702', 'GUADALUPE', '1307', 'PACASMAYO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130703, '130703', 'JEQUETEPEQUE', '1307', 'PACASMAYO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130704, '130704', 'PACASMAYO', '1307', 'PACASMAYO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130705, '130705', 'SAN JOSE', '1307', 'PACASMAYO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130801, '130801', 'TAYABAMBA', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130802, '130802', 'BULDIBUYO', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130803, '130803', 'CHILLIA', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130804, '130804', 'HUANCASPATA', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130805, '130805', 'HUAYLILLAS', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130806, '130806', 'HUAYO', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130807, '130807', 'ONGON', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130808, '130808', 'PARCOY', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130809, '130809', 'PATAZ', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130810, '130810', 'PIAS', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130811, '130811', 'SANTIAGO DE CHALLAS', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130812, '130812', 'TAURIJA', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130813, '130813', 'URPAY', '1308', 'PATAZ', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130901, '130901', 'HUAMACHUCO', '1309', 'SANCHEZ CARRION', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130902, '130902', 'CHUGAY', '1309', 'SANCHEZ CARRION', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130903, '130903', 'COCHORCO', '1309', 'SANCHEZ CARRION', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130904, '130904', 'CURGOS', '1309', 'SANCHEZ CARRION', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130905, '130905', 'MARCABAL', '1309', 'SANCHEZ CARRION', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130906, '130906', 'SANAGORAN', '1309', 'SANCHEZ CARRION', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130907, '130907', 'SARIN', '1309', 'SANCHEZ CARRION', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(130908, '130908', 'SARTIMBAMBA', '1309', 'SANCHEZ CARRION', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131001, '131001', 'SANTIAGO DE CHUCO', '1310', 'SANTIAGO DE CHUCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131002, '131002', 'ANGASMARCA', '1310', 'SANTIAGO DE CHUCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131003, '131003', 'CACHICADAN', '1310', 'SANTIAGO DE CHUCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131004, '131004', 'MOLLEBAMBA', '1310', 'SANTIAGO DE CHUCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131005, '131005', 'MOLLEPATA', '1310', 'SANTIAGO DE CHUCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131006, '131006', 'QUIRUVILCA', '1310', 'SANTIAGO DE CHUCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131007, '131007', 'SANTA CRUZ DE CHUCA', '1310', 'SANTIAGO DE CHUCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131008, '131008', 'SITABAMBA', '1310', 'SANTIAGO DE CHUCO', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131101, '131101', 'CASCAS', '1311', 'GRAN CHIMU', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131102, '131102', 'LUCMA', '1311', 'GRAN CHIMU', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131103, '131103', 'COMPIN', '1311', 'GRAN CHIMU', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131104, '131104', 'SAYAPULLO', '1311', 'GRAN CHIMU', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131201, '131201', 'VIRU', '1312', 'VIRU', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131202, '131202', 'CHAO', '1312', 'VIRU', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(131203, '131203', 'GUADALUPITO', '1312', 'VIRU', '13', 'DEPARTAMENTO LA LIBERTAD', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140101, '140101', 'CHICLAYO', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140102, '140102', 'CHONGOYAPE', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140103, '140103', 'ETEN', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140104, '140104', 'ETEN PUERTO', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140105, '140105', 'JOSE LEONARDO ORTIZ', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140106, '140106', 'LA VICTORIA', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140107, '140107', 'LAGUNAS', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140108, '140108', 'MONSEFU', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140109, '140109', 'NUEVA ARICA', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140110, '140110', 'OYOTUN', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140111, '140111', 'PICSI', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140112, '140112', 'PIMENTEL', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140113, '140113', 'REQUE', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140114, '140114', 'SANTA ROSA', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140115, '140115', 'SAÑA', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140116, '140116', 'CAYALTI', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140117, '140117', 'PATAPO', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140118, '140118', 'POMALCA', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140119, '140119', 'PUCALA', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140120, '140120', 'TUMAN', '1401', 'CHICLAYO', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140201, '140201', 'FERREÑAFE', '1402', 'FERREÑAFE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140202, '140202', 'CAÑARIS', '1402', 'FERREÑAFE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140203, '140203', 'INCAHUASI', '1402', 'FERREÑAFE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140204, '140204', 'MANUEL ANTONIO MESONES MURO', '1402', 'FERREÑAFE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140205, '140205', 'PITIPO', '1402', 'FERREÑAFE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140206, '140206', 'PUEBLO NUEVO', '1402', 'FERREÑAFE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140301, '140301', 'LAMBAYEQUE', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140302, '140302', 'CHOCHOPE', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140303, '140303', 'ILLIMO', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140304, '140304', 'JAYANCA', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140305, '140305', 'MOCHUMI', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140306, '140306', 'MORROPE', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140307, '140307', 'MOTUPE', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140308, '140308', 'OLMOS', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140309, '140309', 'PACORA', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140310, '140310', 'SALAS', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140311, '140311', 'SAN JOSE', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(140312, '140312', 'TUCUME', '1403', 'LAMBAYEQUE', '14', 'DEPARTAMENTO LAMBAYEQUE', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150101, '150101', 'LIMA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150102, '150102', 'ANCON', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150103, '150103', 'ATE', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150104, '150104', 'BARRANCO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150105, '150105', 'BREÑA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150106, '150106', 'CARABAYLLO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150107, '150107', 'CHACLACAYO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150108, '150108', 'CHORRILLOS', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150109, '150109', 'CIENEGUILLA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150110, '150110', 'COMAS', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150111, '150111', 'EL AGUSTINO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150112, '150112', 'INDEPENDENCIA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150113, '150113', 'JESUS MARIA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150114, '150114', 'LA MOLINA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150115, '150115', 'LA VICTORIA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150116, '150116', 'LINCE', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150117, '150117', 'LOS OLIVOS', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150118, '150118', 'LURIGANCHO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150119, '150119', 'LURIN', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150120, '150120', 'MAGDALENA DEL MAR', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150121, '150121', 'PUEBLO LIBRE', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150122, '150122', 'MIRAFLORES', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150123, '150123', 'PACHACAMAC', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150124, '150124', 'PUCUSANA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150125, '150125', 'PUENTE PIEDRA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150126, '150126', 'PUNTA HERMOSA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150127, '150127', 'PUNTA NEGRA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150128, '150128', 'RIMAC', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150129, '150129', 'SAN BARTOLO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150130, '150130', 'SAN BORJA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150131, '150131', 'SAN ISIDRO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150132, '150132', 'SAN JUAN DE LURIGANCHO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150133, '150133', 'SAN JUAN DE MIRAFLORES', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150134, '150134', 'SAN LUIS', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150135, '150135', 'SAN MARTIN DE PORRES', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150136, '150136', 'SAN MIGUEL', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150137, '150137', 'SANTA ANITA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150138, '150138', 'SANTA MARIA DEL MAR', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150139, '150139', 'SANTA ROSA', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150140, '150140', 'SANTIAGO DE SURCO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150141, '150141', 'SURQUILLO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150142, '150142', 'VILLA EL SALVADOR', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150143, '150143', 'VILLA MARIA DEL TRIUNFO', '1501', 'LIMA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150201, '150201', 'BARRANCA', '1502', 'BARRANCA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150202, '150202', 'PARAMONGA', '1502', 'BARRANCA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150203, '150203', 'PATIVILCA', '1502', 'BARRANCA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150204, '150204', 'SUPE', '1502', 'BARRANCA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150205, '150205', 'SUPE PUERTO', '1502', 'BARRANCA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150301, '150301', 'CAJATAMBO', '1503', 'CAJATAMBO', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150302, '150302', 'COPA', '1503', 'CAJATAMBO', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150303, '150303', 'GORGOR', '1503', 'CAJATAMBO', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150304, '150304', 'HUANCAPON', '1503', 'CAJATAMBO', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150305, '150305', 'MANAS', '1503', 'CAJATAMBO', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150401, '150401', 'CANTA', '1504', 'CANTA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150402, '150402', 'ARAHUAY', '1504', 'CANTA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150403, '150403', 'HUAMANTANGA', '1504', 'CANTA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150404, '150404', 'HUAROS', '1504', 'CANTA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150405, '150405', 'LACHAQUI', '1504', 'CANTA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150406, '150406', 'SAN BUENAVENTURA', '1504', 'CANTA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150407, '150407', 'SANTA ROSA DE QUIVES', '1504', 'CANTA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150501, '150501', 'SAN VICENTE DE CAÑETE', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150502, '150502', 'ASIA', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150503, '150503', 'CALANGO', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150504, '150504', 'CERRO AZUL', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150505, '150505', 'CHILCA', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150506, '150506', 'COAYLLO', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150507, '150507', 'IMPERIAL', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150508, '150508', 'LUNAHUANA', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150509, '150509', 'MALA', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150510, '150510', 'NUEVO IMPERIAL', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150511, '150511', 'PACARAN', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150512, '150512', 'QUILMANA', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150513, '150513', 'SAN ANTONIO', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150514, '150514', 'SAN LUIS', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150515, '150515', 'SANTA CRUZ DE FLORES', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150516, '150516', 'ZUÑIGA', '1505', 'CAÑETE', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150601, '150601', 'HUARAL', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150602, '150602', 'ATAVILLOS ALTO', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150603, '150603', 'ATAVILLOS BAJO', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150604, '150604', 'AUCALLAMA', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150605, '150605', 'CHANCAY', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150606, '150606', 'IHUARI', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150607, '150607', 'LAMPIAN', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150608, '150608', 'PACARAOS', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150609, '150609', 'SAN MIGUEL DE ACOS', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150610, '150610', 'SANTA CRUZ DE ANDAMARCA', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150611, '150611', 'SUMBILCA', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150612, '150612', 'VEINTISIETE DE NOVIEMBRE', '1506', 'HUARAL', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150701, '150701', 'MATUCANA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150702, '150702', 'ANTIOQUIA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150703, '150703', 'CALLAHUANCA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150704, '150704', 'CARAMPOMA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150705, '150705', 'CHICLA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150706, '150706', 'CUENCA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150707, '150707', 'HUACHUPAMPA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150708, '150708', 'HUANZA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150709, '150709', 'HUAROCHIRI', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150710, '150710', 'LAHUAYTAMBO', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150711, '150711', 'LANGA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150712, '150712', 'LARAOS', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150713, '150713', 'MARIATANA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150714, '150714', 'RICARDO PALMA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150715, '150715', 'SAN ANDRES DE TUPICOCHA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150716, '150716', 'SAN ANTONIO', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150717, '150717', 'SAN BARTOLOME', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150718, '150718', 'SAN DAMIAN', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150719, '150719', 'SAN JUAN DE IRIS', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150720, '150720', 'SAN JUAN DE TANTARANCHE', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150721, '150721', 'SAN LORENZO DE QUINTI', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150722, '150722', 'SAN MATEO', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150723, '150723', 'SAN MATEO DE OTAO', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150724, '150724', 'SAN PEDRO DE CASTA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150725, '150725', 'SAN PEDRO DE HUANCAYRE', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150726, '150726', 'SANGALLAYA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150727, '150727', 'SANTA CRUZ DE COCACHACRA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150728, '150728', 'SANTA EULALIA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150729, '150729', 'SANTIAGO DE ANCHUCAYA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150730, '150730', 'SANTIAGO DE TUNA', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150731, '150731', 'SANTO DOMINGO DE LOS OLLEROS', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150732, '150732', 'SURCO', '1507', 'HUAROCHIRI', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150801, '150801', 'HUACHO', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150802, '150802', 'AMBAR', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150803, '150803', 'CALETA DE CARQUIN', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150804, '150804', 'CHECRAS', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150805, '150805', 'HUALMAY', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150806, '150806', 'HUAURA', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150807, '150807', 'LEONCIO PRADO', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150808, '150808', 'PACCHO', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150809, '150809', 'SANTA LEONOR', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150810, '150810', 'SANTA MARIA', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150811, '150811', 'SAYAN', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150812, '150812', 'VEGUETA', '1508', 'HUAURA', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150901, '150901', 'OYON', '1509', 'OYON', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150902, '150902', 'ANDAJES', '1509', 'OYON', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150903, '150903', 'CAUJUL', '1509', 'OYON', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150904, '150904', 'COCHAMARCA', '1509', 'OYON', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150905, '150905', 'NAVAN', '1509', 'OYON', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(150906, '150906', 'PACHANGARA', '1509', 'OYON', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151001, '151001', 'YAUYOS', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151002, '151002', 'ALIS', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151003, '151003', 'ALLAUCA', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151004, '151004', 'AYAVIRI', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151005, '151005', 'AZANGARO', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151006, '151006', 'CACRA', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151007, '151007', 'CARANIA', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151008, '151008', 'CATAHUASI', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151009, '151009', 'CHOCOS', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151010, '151010', 'COCHAS', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151011, '151011', 'COLONIA', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151012, '151012', 'HONGOS', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151013, '151013', 'HUAMPARA', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151014, '151014', 'HUANCAYA', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151015, '151015', 'HUANGASCAR', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151016, '151016', 'HUANTAN', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151017, '151017', 'HUAÑEC', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151018, '151018', 'LARAOS', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151019, '151019', 'LINCHA', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151020, '151020', 'MADEAN', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151021, '151021', 'MIRAFLORES', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151022, '151022', 'OMAS', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151023, '151023', 'PUTINZA', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151024, '151024', 'QUINCHES', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151025, '151025', 'QUINOCAY', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151026, '151026', 'SAN JOAQUIN', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151027, '151027', 'SAN PEDRO DE PILAS', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151028, '151028', 'TANTA', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151029, '151029', 'TAURIPAMPA', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151030, '151030', 'TOMAS', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151031, '151031', 'TUPE', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151032, '151032', 'VIÑAC', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(151033, '151033', 'VITIS', '1510', 'YAUYOS', '15', 'DEPARTAMENTO LIMA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160101, '160101', 'IQUITOS', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160102, '160102', 'ALTO NANAY', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160103, '160103', 'FERNANDO LORES', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160104, '160104', 'INDIANA', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160105, '160105', 'LAS AMAZONAS', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160106, '160106', 'MAZAN', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160107, '160107', 'NAPO', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160108, '160108', 'PUNCHANA', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160109, '160109', 'PUTUMAYO', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160110, '160110', 'TORRES CAUSANA', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160112, '160112', 'BELEN', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160113, '160113', 'SAN JUAN BAUTISTA', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160114, '160114', 'TENIENTE MANUEL CLAVERO', '1601', 'MAYNAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160201, '160201', 'YURIMAGUAS', '1602', 'ALTO AMAZONAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160202, '160202', 'BALSAPUERTO', '1602', 'ALTO AMAZONAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160205, '160205', 'JEBEROS', '1602', 'ALTO AMAZONAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160206, '160206', 'LAGUNAS', '1602', 'ALTO AMAZONAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160210, '160210', 'SANTA CRUZ', '1602', 'ALTO AMAZONAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160211, '160211', 'TENIENTE CESAR LOPEZ ROJAS', '1602', 'ALTO AMAZONAS', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160301, '160301', 'NAUTA', '1603', 'LORETO', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160302, '160302', 'PARINARI', '1603', 'LORETO', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160303, '160303', 'TIGRE', '1603', 'LORETO', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160304, '160304', 'TROMPETEROS', '1603', 'LORETO', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160305, '160305', 'URARINAS', '1603', 'LORETO', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160401, '160401', 'RAMON CASTILLA', '1604', 'MARISCAL RAMON CASTILLA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160402, '160402', 'PEBAS', '1604', 'MARISCAL RAMON CASTILLA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160403, '160403', 'YAVARI  /1', '1604', 'MARISCAL RAMON CASTILLA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160404, '160404', 'SAN PABLO', '1604', 'MARISCAL RAMON CASTILLA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160501, '160501', 'REQUENA', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160502, '160502', 'ALTO TAPICHE', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160503, '160503', 'CAPELO', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160504, '160504', 'EMILIO SAN MARTIN', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160505, '160505', 'MAQUIA', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160506, '160506', 'PUINAHUA', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160507, '160507', 'SAQUENA', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160508, '160508', 'SOPLIN', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160509, '160509', 'TAPICHE', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160510, '160510', 'JENARO HERRERA', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160511, '160511', 'YAQUERANA', '1605', 'REQUENA', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160601, '160601', 'CONTAMANA', '1606', 'UCAYALI', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160602, '160602', 'INAHUAYA', '1606', 'UCAYALI', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160603, '160603', 'PADRE MARQUEZ', '1606', 'UCAYALI', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160604, '160604', 'PAMPA HERMOSA', '1606', 'UCAYALI', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160605, '160605', 'SARAYACU', '1606', 'UCAYALI', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160606, '160606', 'VARGAS GUERRA', '1606', 'UCAYALI', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160701, '160701', 'BARRANCA', '1607', 'DATEM DEL MARAÑON', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160702, '160702', 'CAHUAPANAS', '1607', 'DATEM DEL MARAÑON', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160703, '160703', 'MANSERICHE', '1607', 'DATEM DEL MARAÑON', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160704, '160704', 'MORONA', '1607', 'DATEM DEL MARAÑON', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160705, '160705', 'PASTAZA', '1607', 'DATEM DEL MARAÑON', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(160706, '160706', 'ANDOAS', '1607', 'DATEM DEL MARAÑON', '16', 'DEPARTAMENTO LORETO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170101, '170101', 'TAMBOPATA', '1701', 'TAMBOPATA', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170102, '170102', 'INAMBARI', '1701', 'TAMBOPATA', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170103, '170103', 'LAS PIEDRAS', '1701', 'TAMBOPATA', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170104, '170104', 'LABERINTO', '1701', 'TAMBOPATA', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170201, '170201', 'MANU', '1702', 'MANU', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170202, '170202', 'FITZCARRALD', '1702', 'MANU', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170203, '170203', 'MADRE DE DIOS', '1702', 'MANU', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170204, '170204', 'HUEPETUHE', '1702', 'MANU', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170301, '170301', 'IÑAPARI', '1703', 'TAHUAMANU', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170302, '170302', 'IBERIA', '1703', 'TAHUAMANU', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(170303, '170303', 'TAHUAMANU', '1703', 'TAHUAMANU', '17', 'DEPARTAMENTO MADRE DE DIOS', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180101, '180101', 'MOQUEGUA', '1801', 'MARISCAL NIETO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180102, '180102', 'CARUMAS', '1801', 'MARISCAL NIETO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180103, '180103', 'CUCHUMBAYA', '1801', 'MARISCAL NIETO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180104, '180104', 'SAMEGUA', '1801', 'MARISCAL NIETO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180105, '180105', 'SAN CRISTOBAL', '1801', 'MARISCAL NIETO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180106, '180106', 'TORATA', '1801', 'MARISCAL NIETO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180201, '180201', 'OMATE', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180202, '180202', 'CHOJATA', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180203, '180203', 'COALAQUE', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180204, '180204', 'ICHUÑA', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180205, '180205', 'LA CAPILLA', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180206, '180206', 'LLOQUE', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180207, '180207', 'MATALAQUE', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180208, '180208', 'PUQUINA', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180209, '180209', 'QUINISTAQUILLAS', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180210, '180210', 'UBINAS', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180211, '180211', 'YUNGA', '1802', 'GENERAL SANCHEZ CERRO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180301, '180301', 'ILO', '1803', 'ILO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180302, '180302', 'EL ALGARROBAL', '1803', 'ILO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(180303, '180303', 'PACOCHA', '1803', 'ILO', '18', 'DEPARTAMENTO MOQUEGUA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190101, '190101', 'CHAUPIMARCA', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190102, '190102', 'HUACHON', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190103, '190103', 'HUARIACA', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190104, '190104', 'HUAYLLAY', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190105, '190105', 'NINACACA', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1');
INSERT INTO `cji_ubigeo` (`UBIGP_Codigo`, `UBIGC_CodDist`, `UBIGC_Descripcion`, `UBIGC_CodProv`, `UBIGC_DescripcionProv`, `UBIGC_CodDpto`, `UBIGC_DescripcionDpto`, `UBIGC_FechaRegistro`, `UBIGC_FechaModificacion`, `UBIGC_FlagEstado`) VALUES
(190106, '190106', 'PALLANCHACRA', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190107, '190107', 'PAUCARTAMBO', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190108, '190108', 'SAN FRANCISCO DE ASIS DE YARUSYACAN', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190109, '190109', 'SIMON BOLIVAR', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190110, '190110', 'TICLACAYAN', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190111, '190111', 'TINYAHUARCO', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190112, '190112', 'VICCO', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190113, '190113', 'YANACANCHA', '1901', 'PASCO', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190201, '190201', 'YANAHUANCA', '1902', 'DANIEL ALCIDES CARRION', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190202, '190202', 'CHACAYAN', '1902', 'DANIEL ALCIDES CARRION', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190203, '190203', 'GOYLLARISQUIZGA', '1902', 'DANIEL ALCIDES CARRION', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190204, '190204', 'PAUCAR', '1902', 'DANIEL ALCIDES CARRION', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190205, '190205', 'SAN PEDRO DE PILLAO', '1902', 'DANIEL ALCIDES CARRION', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190206, '190206', 'SANTA ANA DE TUSI', '1902', 'DANIEL ALCIDES CARRION', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190207, '190207', 'TAPUC', '1902', 'DANIEL ALCIDES CARRION', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190208, '190208', 'VILCABAMBA', '1902', 'DANIEL ALCIDES CARRION', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190301, '190301', 'OXAPAMPA', '1903', 'OXAPAMPA', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190302, '190302', 'CHONTABAMBA', '1903', 'OXAPAMPA', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190303, '190303', 'HUANCABAMBA', '1903', 'OXAPAMPA', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190304, '190304', 'PALCAZU', '1903', 'OXAPAMPA', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190305, '190305', 'POZUZO', '1903', 'OXAPAMPA', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190306, '190306', 'PUERTO BERMUDEZ', '1903', 'OXAPAMPA', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(190307, '190307', 'VILLA RICA', '1903', 'OXAPAMPA', '19', 'DEPARTAMENTO PASCO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200101, '200101', 'PIURA', '2001', 'PIURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200104, '200104', 'CASTILLA', '2001', 'PIURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200105, '200105', 'CATACAOS', '2001', 'PIURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200107, '200107', 'CURA MORI', '2001', 'PIURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200108, '200108', 'EL TALLAN', '2001', 'PIURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200109, '200109', 'LA ARENA', '2001', 'PIURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200110, '200110', 'LA UNION', '2001', 'PIURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200111, '200111', 'LAS LOMAS', '2001', 'PIURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200114, '200114', 'TAMBO GRANDE', '2001', 'PIURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200201, '200201', 'AYABACA', '2002', 'AYABACA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200202, '200202', 'FRIAS', '2002', 'AYABACA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200203, '200203', 'JILILI', '2002', 'AYABACA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200204, '200204', 'LAGUNAS', '2002', 'AYABACA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200205, '200205', 'MONTERO', '2002', 'AYABACA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200206, '200206', 'PACAIPAMPA', '2002', 'AYABACA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200207, '200207', 'PAIMAS', '2002', 'AYABACA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200208, '200208', 'SAPILLICA', '2002', 'AYABACA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200209, '200209', 'SICCHEZ', '2002', 'AYABACA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200210, '200210', 'SUYO', '2002', 'AYABACA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200301, '200301', 'HUANCABAMBA', '2003', 'HUANCABAMBA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200302, '200302', 'CANCHAQUE', '2003', 'HUANCABAMBA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200303, '200303', 'EL CARMEN DE LA FRONTERA', '2003', 'HUANCABAMBA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200304, '200304', 'HUARMACA', '2003', 'HUANCABAMBA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200305, '200305', 'LALAQUIZ', '2003', 'HUANCABAMBA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200306, '200306', 'SAN MIGUEL DE EL FAIQUE', '2003', 'HUANCABAMBA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200307, '200307', 'SONDOR', '2003', 'HUANCABAMBA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200308, '200308', 'SONDORILLO', '2003', 'HUANCABAMBA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200401, '200401', 'CHULUCANAS', '2004', 'MORROPON', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200402, '200402', 'BUENOS AIRES', '2004', 'MORROPON', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200403, '200403', 'CHALACO', '2004', 'MORROPON', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200404, '200404', 'LA MATANZA', '2004', 'MORROPON', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200405, '200405', 'MORROPON', '2004', 'MORROPON', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200406, '200406', 'SALITRAL', '2004', 'MORROPON', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200407, '200407', 'SAN JUAN DE BIGOTE', '2004', 'MORROPON', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200408, '200408', 'SANTA CATALINA DE MOSSA', '2004', 'MORROPON', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200409, '200409', 'SANTO DOMINGO', '2004', 'MORROPON', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200410, '200410', 'YAMANGO', '2004', 'MORROPON', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200501, '200501', 'PAITA', '2005', 'PAITA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200502, '200502', 'AMOTAPE', '2005', 'PAITA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200503, '200503', 'ARENAL', '2005', 'PAITA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200504, '200504', 'COLAN', '2005', 'PAITA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200505, '200505', 'LA HUACA', '2005', 'PAITA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200506, '200506', 'TAMARINDO', '2005', 'PAITA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200507, '200507', 'VICHAYAL', '2005', 'PAITA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200601, '200601', 'SULLANA', '2006', 'SULLANA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200602, '200602', 'BELLAVISTA', '2006', 'SULLANA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200603, '200603', 'IGNACIO ESCUDERO', '2006', 'SULLANA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200604, '200604', 'LANCONES', '2006', 'SULLANA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200605, '200605', 'MARCAVELICA', '2006', 'SULLANA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200606, '200606', 'MIGUEL CHECA', '2006', 'SULLANA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200607, '200607', 'QUERECOTILLO', '2006', 'SULLANA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200608, '200608', 'SALITRAL', '2006', 'SULLANA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200701, '200701', 'PARIÑAS', '2007', 'TALARA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200702, '200702', 'EL ALTO', '2007', 'TALARA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200703, '200703', 'LA BREA', '2007', 'TALARA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200704, '200704', 'LOBITOS', '2007', 'TALARA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200705, '200705', 'LOS ORGANOS', '2007', 'TALARA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200706, '200706', 'MANCORA', '2007', 'TALARA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200801, '200801', 'SECHURA', '2008', 'SECHURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200802, '200802', 'BELLAVISTA DE LA UNION', '2008', 'SECHURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200803, '200803', 'BERNAL', '2008', 'SECHURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200804, '200804', 'CRISTO NOS VALGA', '2008', 'SECHURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200805, '200805', 'VICE', '2008', 'SECHURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(200806, '200806', 'RINCONADA LLICUAR', '2008', 'SECHURA', '20', 'DEPARTAMENTO PIURA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210101, '210101', 'PUNO', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210102, '210102', 'ACORA', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210103, '210103', 'AMANTANI', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210104, '210104', 'ATUNCOLLA', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210105, '210105', 'CAPACHICA', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210106, '210106', 'CHUCUITO', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210107, '210107', 'COATA', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210108, '210108', 'HUATA', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210109, '210109', 'MAÑAZO', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210110, '210110', 'PAUCARCOLLA', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210111, '210111', 'PICHACANI', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210112, '210112', 'PLATERIA', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210113, '210113', 'SAN ANTONIO  /1', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210114, '210114', 'TIQUILLACA', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210115, '210115', 'VILQUE', '2101', 'PUNO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210201, '210201', 'AZANGARO', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210202, '210202', 'ACHAYA', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210203, '210203', 'ARAPA', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210204, '210204', 'ASILLO', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210205, '210205', 'CAMINACA', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210206, '210206', 'CHUPA', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210207, '210207', 'JOSE DOMINGO CHOQUEHUANCA', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210208, '210208', 'MUÑANI', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210209, '210209', 'POTONI', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210210, '210210', 'SAMAN', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210211, '210211', 'SAN ANTON', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210212, '210212', 'SAN JOSE', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210213, '210213', 'SAN JUAN DE SALINAS', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210214, '210214', 'SANTIAGO DE PUPUJA', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210215, '210215', 'TIRAPATA', '2102', 'AZANGARO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210301, '210301', 'MACUSANI', '2103', 'CARABAYA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210302, '210302', 'AJOYANI', '2103', 'CARABAYA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210303, '210303', 'AYAPATA', '2103', 'CARABAYA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210304, '210304', 'COASA', '2103', 'CARABAYA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210305, '210305', 'CORANI', '2103', 'CARABAYA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210306, '210306', 'CRUCERO', '2103', 'CARABAYA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210307, '210307', 'ITUATA   2/', '2103', 'CARABAYA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210308, '210308', 'OLLACHEA', '2103', 'CARABAYA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210309, '210309', 'SAN GABAN', '2103', 'CARABAYA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210310, '210310', 'USICAYOS', '2103', 'CARABAYA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210401, '210401', 'JULI', '2104', 'CHUCUITO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210402, '210402', 'DESAGUADERO', '2104', 'CHUCUITO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210403, '210403', 'HUACULLANI', '2104', 'CHUCUITO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210404, '210404', 'KELLUYO', '2104', 'CHUCUITO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210405, '210405', 'PISACOMA', '2104', 'CHUCUITO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210406, '210406', 'POMATA', '2104', 'CHUCUITO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210407, '210407', 'ZEPITA', '2104', 'CHUCUITO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210501, '210501', 'ILAVE', '2105', 'EL COLLAO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210502, '210502', 'CAPAZO', '2105', 'EL COLLAO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210503, '210503', 'PILCUYO', '2105', 'EL COLLAO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210504, '210504', 'SANTA ROSA', '2105', 'EL COLLAO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210505, '210505', 'CONDURIRI', '2105', 'EL COLLAO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210601, '210601', 'HUANCANE', '2106', 'HUANCANE', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210602, '210602', 'COJATA', '2106', 'HUANCANE', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210603, '210603', 'HUATASANI', '2106', 'HUANCANE', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210604, '210604', 'INCHUPALLA', '2106', 'HUANCANE', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210605, '210605', 'PUSI', '2106', 'HUANCANE', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210606, '210606', 'ROSASPATA', '2106', 'HUANCANE', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210607, '210607', 'TARACO', '2106', 'HUANCANE', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210608, '210608', 'VILQUE CHICO', '2106', 'HUANCANE', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210701, '210701', 'LAMPA', '2107', 'LAMPA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210702, '210702', 'CABANILLA', '2107', 'LAMPA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210703, '210703', 'CALAPUJA', '2107', 'LAMPA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210704, '210704', 'NICASIO', '2107', 'LAMPA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210705, '210705', 'OCUVIRI', '2107', 'LAMPA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210706, '210706', 'PALCA', '2107', 'LAMPA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210707, '210707', 'PARATIA', '2107', 'LAMPA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210708, '210708', 'PUCARA', '2107', 'LAMPA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210709, '210709', 'SANTA LUCIA', '2107', 'LAMPA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210710, '210710', 'VILAVILA', '2107', 'LAMPA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210801, '210801', 'AYAVIRI', '2108', 'MELGAR', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210802, '210802', 'ANTAUTA', '2108', 'MELGAR', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210803, '210803', 'CUPI', '2108', 'MELGAR', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210804, '210804', 'LLALLI', '2108', 'MELGAR', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210805, '210805', 'MACARI', '2108', 'MELGAR', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210806, '210806', 'NUÑOA', '2108', 'MELGAR', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210807, '210807', 'ORURILLO', '2108', 'MELGAR', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210808, '210808', 'SANTA ROSA', '2108', 'MELGAR', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210809, '210809', 'UMACHIRI', '2108', 'MELGAR', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210901, '210901', 'MOHO', '2109', 'MOHO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210902, '210902', 'CONIMA', '2109', 'MOHO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210903, '210903', 'HUAYRAPATA', '2109', 'MOHO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(210904, '210904', 'TILALI', '2109', 'MOHO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211001, '211001', 'PUTINA', '2110', 'SAN ANTONIO DE PUTINA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211002, '211002', 'ANANEA', '2110', 'SAN ANTONIO DE PUTINA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211003, '211003', 'PEDRO VILCA APAZA', '2110', 'SAN ANTONIO DE PUTINA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211004, '211004', 'QUILCAPUNCU', '2110', 'SAN ANTONIO DE PUTINA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211005, '211005', 'SINA', '2110', 'SAN ANTONIO DE PUTINA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211101, '211101', 'JULIACA', '2111', 'SAN ROMAN', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211102, '211102', 'CABANA', '2111', 'SAN ROMAN', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211103, '211103', 'CABANILLAS', '2111', 'SAN ROMAN', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211104, '211104', 'CARACOTO', '2111', 'SAN ROMAN', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211201, '211201', 'SANDIA', '2112', 'SANDIA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211202, '211202', 'CUYOCUYO', '2112', 'SANDIA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211203, '211203', 'LIMBANI', '2112', 'SANDIA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211204, '211204', 'PATAMBUCO', '2112', 'SANDIA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211205, '211205', 'PHARA', '2112', 'SANDIA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211206, '211206', 'QUIACA', '2112', 'SANDIA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211207, '211207', 'SAN JUAN DEL ORO', '2112', 'SANDIA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211208, '211208', 'YANAHUAYA', '2112', 'SANDIA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211209, '211209', 'ALTO INAMBARI', '2112', 'SANDIA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211210, '211210', 'SAN PEDRO DE PUTINA PUNCO', '2112', 'SANDIA', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211301, '211301', 'YUNGUYO', '2113', 'YUNGUYO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211302, '211302', 'ANAPIA', '2113', 'YUNGUYO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211303, '211303', 'COPANI', '2113', 'YUNGUYO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211304, '211304', 'CUTURAPI', '2113', 'YUNGUYO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211305, '211305', 'OLLARAYA', '2113', 'YUNGUYO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211306, '211306', 'TINICACHI', '2113', 'YUNGUYO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(211307, '211307', 'UNICACHI', '2113', 'YUNGUYO', '21', 'DEPARTAMENTO PUNO', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220101, '220101', 'MOYOBAMBA', '2201', 'MOYOBAMBA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220102, '220102', 'CALZADA', '2201', 'MOYOBAMBA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220103, '220103', 'HABANA', '2201', 'MOYOBAMBA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220104, '220104', 'JEPELACIO', '2201', 'MOYOBAMBA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220105, '220105', 'SORITOR', '2201', 'MOYOBAMBA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220106, '220106', 'YANTALO', '2201', 'MOYOBAMBA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220201, '220201', 'BELLAVISTA', '2202', 'BELLAVISTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220202, '220202', 'ALTO BIAVO', '2202', 'BELLAVISTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220203, '220203', 'BAJO BIAVO', '2202', 'BELLAVISTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220204, '220204', 'HUALLAGA', '2202', 'BELLAVISTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220205, '220205', 'SAN PABLO', '2202', 'BELLAVISTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220206, '220206', 'SAN RAFAEL', '2202', 'BELLAVISTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220301, '220301', 'SAN JOSE DE SISA', '2203', 'EL DORADO', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220302, '220302', 'AGUA BLANCA', '2203', 'EL DORADO', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220303, '220303', 'SAN MARTIN', '2203', 'EL DORADO', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220304, '220304', 'SANTA ROSA', '2203', 'EL DORADO', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220305, '220305', 'SHATOJA', '2203', 'EL DORADO', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220401, '220401', 'SAPOSOA', '2204', 'HUALLAGA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220402, '220402', 'ALTO SAPOSOA', '2204', 'HUALLAGA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220403, '220403', 'EL ESLABON', '2204', 'HUALLAGA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220404, '220404', 'PISCOYACU', '2204', 'HUALLAGA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220405, '220405', 'SACANCHE', '2204', 'HUALLAGA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220406, '220406', 'TINGO DE SAPOSOA', '2204', 'HUALLAGA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220501, '220501', 'LAMAS', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220502, '220502', 'ALONSO DE ALVARADO', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220503, '220503', 'BARRANQUITA', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220504, '220504', 'CAYNARACHI   1/', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220505, '220505', 'CUÑUMBUQUI', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220506, '220506', 'PINTO RECODO', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220507, '220507', 'RUMISAPA', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220508, '220508', 'SAN ROQUE DE CUMBAZA', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220509, '220509', 'SHANAO', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220510, '220510', 'TABALOSOS', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220511, '220511', 'ZAPATERO', '2205', 'LAMAS', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220601, '220601', 'JUANJUI', '2206', 'MARISCAL CACERES', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220602, '220602', 'CAMPANILLA', '2206', 'MARISCAL CACERES', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220603, '220603', 'HUICUNGO', '2206', 'MARISCAL CACERES', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220604, '220604', 'PACHIZA', '2206', 'MARISCAL CACERES', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220605, '220605', 'PAJARILLO', '2206', 'MARISCAL CACERES', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220701, '220701', 'PICOTA', '2207', 'PICOTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220702, '220702', 'BUENOS AIRES', '2207', 'PICOTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220703, '220703', 'CASPISAPA', '2207', 'PICOTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220704, '220704', 'PILLUANA', '2207', 'PICOTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220705, '220705', 'PUCACACA', '2207', 'PICOTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220706, '220706', 'SAN CRISTOBAL', '2207', 'PICOTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220707, '220707', 'SAN HILARION', '2207', 'PICOTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220708, '220708', 'SHAMBOYACU', '2207', 'PICOTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220709, '220709', 'TINGO DE PONASA', '2207', 'PICOTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220710, '220710', 'TRES UNIDOS', '2207', 'PICOTA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220801, '220801', 'RIOJA', '2208', 'RIOJA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220802, '220802', 'AWAJUN', '2208', 'RIOJA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220803, '220803', 'ELIAS SOPLIN VARGAS', '2208', 'RIOJA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220804, '220804', 'NUEVA CAJAMARCA', '2208', 'RIOJA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220805, '220805', 'PARDO MIGUEL', '2208', 'RIOJA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220806, '220806', 'POSIC', '2208', 'RIOJA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220807, '220807', 'SAN FERNANDO', '2208', 'RIOJA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220808, '220808', 'YORONGOS', '2208', 'RIOJA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220809, '220809', 'YURACYACU', '2208', 'RIOJA', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220901, '220901', 'TARAPOTO', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220902, '220902', 'ALBERTO LEVEAU', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220903, '220903', 'CACATACHI', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220904, '220904', 'CHAZUTA', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220905, '220905', 'CHIPURANA', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220906, '220906', 'EL PORVENIR', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220907, '220907', 'HUIMBAYOC', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220908, '220908', 'JUAN GUERRA', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220909, '220909', 'LA BANDA DE SHILCAYO', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220910, '220910', 'MORALES', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220911, '220911', 'PAPAPLAYA', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220912, '220912', 'SAN ANTONIO', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220913, '220913', 'SAUCE', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(220914, '220914', 'SHAPAJA', '2209', 'SAN MARTIN', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(221001, '221001', 'TOCACHE', '2210', 'TOCACHE', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(221002, '221002', 'NUEVO PROGRESO', '2210', 'TOCACHE', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(221003, '221003', 'POLVORA', '2210', 'TOCACHE', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(221004, '221004', 'SHUNTE  2/', '2210', 'TOCACHE', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(221005, '221005', 'UCHIZA', '2210', 'TOCACHE', '22', 'DEPARTAMENTO SAN MARTIN', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230101, '230101', 'TACNA', '2301', 'TACNA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230102, '230102', 'ALTO DE LA ALIANZA', '2301', 'TACNA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230103, '230103', 'CALANA', '2301', 'TACNA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230104, '230104', 'CIUDAD NUEVA', '2301', 'TACNA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230105, '230105', 'INCLAN', '2301', 'TACNA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230106, '230106', 'PACHIA', '2301', 'TACNA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230107, '230107', 'PALCA', '2301', 'TACNA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230108, '230108', 'POCOLLAY', '2301', 'TACNA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230109, '230109', 'SAMA', '2301', 'TACNA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230110, '230110', 'CORONEL GREGORIO ALBARRACIN LANCHIPA', '2301', 'TACNA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230201, '230201', 'CANDARAVE', '2302', 'CANDARAVE', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230202, '230202', 'CAIRANI', '2302', 'CANDARAVE', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230203, '230203', 'CAMILACA', '2302', 'CANDARAVE', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230204, '230204', 'CURIBAYA', '2302', 'CANDARAVE', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230205, '230205', 'HUANUARA', '2302', 'CANDARAVE', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230206, '230206', 'QUILAHUANI', '2302', 'CANDARAVE', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230301, '230301', 'LOCUMBA', '2303', 'JORGE BASADRE', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230302, '230302', 'ILABAYA', '2303', 'JORGE BASADRE', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230303, '230303', 'ITE', '2303', 'JORGE BASADRE', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230401, '230401', 'TARATA', '2304', 'TARATA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230402, '230402', 'HEROES ALBARRACIN', '2304', 'TARATA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230403, '230403', 'ESTIQUE', '2304', 'TARATA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230404, '230404', 'ESTIQUE-PAMPA', '2304', 'TARATA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230405, '230405', 'SITAJARA', '2304', 'TARATA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230406, '230406', 'SUSAPAYA', '2304', 'TARATA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230407, '230407', 'TARUCACHI', '2304', 'TARATA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(230408, '230408', 'TICACO', '2304', 'TARATA', '23', 'DEPARTAMENTO TACNA', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240101, '240101', 'TUMBES', '2401', 'TUMBES', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240102, '240102', 'CORRALES', '2401', 'TUMBES', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240103, '240103', 'LA CRUZ', '2401', 'TUMBES', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240104, '240104', 'PAMPAS DE HOSPITAL', '2401', 'TUMBES', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240105, '240105', 'SAN JACINTO', '2401', 'TUMBES', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240106, '240106', 'SAN JUAN DE LA VIRGEN', '2401', 'TUMBES', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240201, '240201', 'ZORRITOS', '2402', 'CONTRALMIRANTE VILLAR', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240202, '240202', 'CASITAS', '2402', 'CONTRALMIRANTE VILLAR', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240203, '240203', 'CANOAS DE PUNTA SAL', '2402', 'CONTRALMIRANTE VILLAR', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240301, '240301', 'ZARUMILLA', '2403', 'ZARUMILLA', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240302, '240302', 'AGUAS VERDES', '2403', 'ZARUMILLA', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240303, '240303', 'MATAPALO', '2403', 'ZARUMILLA', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(240304, '240304', 'PAPAYAL', '2403', 'ZARUMILLA', '24', 'DEPARTAMENTO TUMBES', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250101, '250101', 'CALLERIA', '2501', 'CORONEL PORTILLO', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250102, '250102', 'CAMPOVERDE', '2501', 'CORONEL PORTILLO', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250103, '250103', 'IPARIA', '2501', 'CORONEL PORTILLO', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250104, '250104', 'MASISEA', '2501', 'CORONEL PORTILLO', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250105, '250105', 'YARINACOCHA', '2501', 'CORONEL PORTILLO', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250106, '250106', 'NUEVA REQUENA', '2501', 'CORONEL PORTILLO', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250107, '250107', 'MANANTAY', '2501', 'CORONEL PORTILLO', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250201, '250201', 'RAYMONDI', '2502', 'ATALAYA', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250202, '250202', 'SEPAHUA', '2502', 'ATALAYA', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250203, '250203', 'TAHUANIA', '2502', 'ATALAYA', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250204, '250204', 'YURUA', '2502', 'ATALAYA', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250301, '250301', 'PADRE ABAD', '2503', 'PADRE ABAD', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250302, '250302', 'IRAZOLA', '2503', 'PADRE ABAD', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250303, '250303', 'CURIMANA', '2503', 'PADRE ABAD', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1'),
(250401, '250401', 'PURUS', '2504', 'PURUS', '25', 'DEPARTAMENTO UCAYALI', '2019-09-11 05:00:00', '2019-09-11 00:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_unidadmedida`
--

CREATE TABLE `cji_unidadmedida` (
  `UNDMED_Codigo` int(11) NOT NULL,
  `UNDMED_Descripcion` varchar(250) DEFAULT NULL,
  `UNDMED_Simbolo` varchar(30) DEFAULT NULL,
  `UNDMED_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UNDMED_FechaModificacion` datetime DEFAULT NULL,
  `UNDMED_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_unidadmedida`
--

INSERT INTO `cji_unidadmedida` (`UNDMED_Codigo`, `UNDMED_Descripcion`, `UNDMED_Simbolo`, `UNDMED_FechaRegistro`, `UNDMED_FechaModificacion`, `UNDMED_FlagEstado`) VALUES
(1, 'UNIDAD', 'NIU', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(2, 'PAQUETE', 'PK', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(3, 'KILOGRAMO', 'KGM', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(4, 'ROLLO', 'RO', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(5, 'KIT', 'KT', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(6, 'SACO', 'SA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(7, 'CAJA', 'BX', '2017-01-30 07:46:13', NULL, '1'),
(8, 'PAR', 'PR', '2017-03-01 05:32:32', NULL, '1'),
(9, 'METRO CUBICO', 'MTQ', '2017-04-18 09:35:44', NULL, '1'),
(10, 'BOLSA', 'BG', '2017-04-29 10:20:29', NULL, '1'),
(11, 'METRO', 'MTR', '2017-04-29 10:20:51', NULL, '1'),
(12, 'GALON INGLES', 'GLI', '2017-04-29 10:21:02', NULL, '1'),
(13, 'LITRO', 'LTR', '2017-06-23 15:38:48', NULL, '1'),
(14, 'PULGADA', 'INH', '2017-06-23 15:40:11', NULL, '1'),
(15, 'PIES', 'FOT', '2017-06-23 15:43:51', NULL, '1'),
(16, 'PIE CUADRADO', 'FTK', '2017-06-23 15:47:49', NULL, '1'),
(17, 'PIE CUBICO', 'FTQ', '2017-06-23 15:48:16', NULL, '1'),
(18, 'LIBRA', 'LBR', '2017-06-23 15:48:36', NULL, '1'),
(19, 'GRAMO', 'GRM', '2017-06-23 15:50:00', NULL, '1'),
(20, 'PIEZA', 'C62', '2017-07-08 23:42:22', NULL, '1'),
(21, 'CIENTO DE UNIDADES', 'CEN', '2017-07-11 03:03:49', NULL, '1'),
(22, 'JUEGO', 'SET', '2017-07-11 03:18:38', NULL, '1'),
(23, 'LATAS', 'CA', '2017-07-11 03:20:12', NULL, '1'),
(24, 'MILLARES', 'MLL', '2017-07-11 03:22:45', NULL, '1'),
(25, 'METRO CUADRADO', 'MTK', '2017-07-11 03:23:37', NULL, '1'),
(26, 'TONELADAS', 'TNE', '2017-07-11 03:27:18', NULL, '1'),
(27, 'VARILLA', 'Var', '2017-07-11 03:29:18', NULL, '0'),
(28, 'GALON', 'WG', '2019-04-08 09:00:00', NULL, '1'),
(29, 'BOTELLA', 'BO', '2019-04-08 09:00:00', NULL, '1'),
(30, 'DOCENA', 'DZN', '2019-04-16 09:00:00', NULL, '1'),
(31, 'MIL', 'MIL', '2019-04-16 09:00:00', NULL, '1'),
(32, 'SERVICIOS (OTROS)', 'ZZ', '2020-03-05 19:02:21', NULL, '1'),
(33, 'MegaBits', 'MBPS', '2023-09-23 05:00:00', NULL, '1'),
(34, 'GigaBits', 'GBPS', '2023-09-23 05:00:00', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_usuario`
--

CREATE TABLE `cji_usuario` (
  `USUA_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `ROL_Codigo` int(11) NOT NULL,
  `USUA_usuario` varchar(50) DEFAULT NULL,
  `USUA_Password` varchar(50) DEFAULT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `USUA_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `USUA_FechaModificacion` datetime DEFAULT NULL,
  `USUA_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_usuario`
--

INSERT INTO `cji_usuario` (`USUA_Codigo`, `PERSP_Codigo`, `ROL_Codigo`, `USUA_usuario`, `USUA_Password`, `EMPRP_Codigo`, `USUA_FechaRegistro`, `USUA_FechaModificacion`, `USUA_FlagEstado`) VALUES
(1, 1, 0, 'administrador', '81fccaf9f00a8441b77b18fa2c8010f4', 0, '2021-12-10 16:52:28', NULL, '1'),
(2, 2, 7, 'ccapasistemas', '413ec182e1c90b98b57e1558736b4dd1', 0, '2023-06-12 17:36:57', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cji_usuario_compania`
--

CREATE TABLE `cji_usuario_compania` (
  `USUCOMP_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `ROL_Codigo` int(11) NOT NULL,
  `CARGP_Codigo` int(10) NOT NULL,
  `USUCOMC_Default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cji_usuario_compania`
--

INSERT INTO `cji_usuario_compania` (`USUCOMP_Codigo`, `USUA_Codigo`, `COMPP_Codigo`, `ROL_Codigo`, `CARGP_Codigo`, `USUCOMC_Default`) VALUES
(1, 2, 1, 7000, 0, 1),
(2, 1, 1, 1, 1, 1),
(3, 2, 2, 7000, 0, 0),
(4, 1, 2, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cji_usuario_terminal`
--

CREATE TABLE `cji_usuario_terminal` (
  `USUTERMINAL_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `ROL_Codigo` int(11) NOT NULL,
  `TERMINAL_Codigo` int(11) NOT NULL,
  `USUTERMINAL_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `USUTERMINAL_FechaModificacion` datetime NOT NULL,
  `USUTERMINAL_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `USUTERMINAL_CodigoUsuario` int(11) DEFAULT NULL,
  `USUTERMINAL_Default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comprobantes_cuotas`
--

CREATE TABLE `comprobantes_cuotas` (
  `CUOT_Codigo` bigint(20) UNSIGNED NOT NULL,
  `CUOT_Numero` smallint(5) UNSIGNED NOT NULL,
  `CPP_Codigo` int(10) UNSIGNED NOT NULL,
  `CUOT_Monto` double(15,2) NOT NULL,
  `CUOT_FechaInicio` date DEFAULT NULL,
  `CUOT_Fecha` date DEFAULT NULL,
  `CUOT_FlagFisica` bit(1) NOT NULL DEFAULT b'0',
  `CUOT_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CUOT_FlagPagado` bit(1) NOT NULL DEFAULT b'0',
  `CUOT_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CUOT_FechaModificacion` datetime DEFAULT NULL,
  `CUOT_UsuarioRegistro` int(10) UNSIGNED NOT NULL,
  `CUOT_UsuarioModifica` int(10) UNSIGNED NOT NULL,
  `CUOT_TipoCuenta` tinyint(4) UNSIGNED NOT NULL,
  `CUOT_TipoTributo` enum('r','d') DEFAULT NULL,
  `PROVP_Codigo` int(11) UNSIGNED DEFAULT NULL,
  `CUOT_NumBanco` varchar(30) DEFAULT NULL,
  `CUOT_Observacion` varchar(600) DEFAULT NULL,
  `CAJA_Codigo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comprobantes_cuotas_notas`
--

CREATE TABLE `comprobantes_cuotas_notas` (
  `CUOT_Codigo` bigint(20) UNSIGNED NOT NULL,
  `CUOT_Numero` smallint(5) UNSIGNED NOT NULL,
  `CPP_Codigo` int(10) UNSIGNED NOT NULL,
  `CUOT_Monto` double(15,2) NOT NULL,
  `CUOT_FechaInicio` date DEFAULT NULL,
  `CUOT_Fecha` date DEFAULT NULL,
  `CUOT_FlagFisica` bit(1) NOT NULL DEFAULT b'0',
  `CUOT_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CUOT_FlagPagado` bit(1) NOT NULL DEFAULT b'0',
  `CUOT_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CUOT_FechaModificacion` datetime DEFAULT NULL,
  `CUOT_UsuarioRegistro` int(10) UNSIGNED NOT NULL,
  `CUOT_UsuarioModifica` int(10) UNSIGNED NOT NULL,
  `CUOT_TipoCuenta` tinyint(4) UNSIGNED NOT NULL,
  `CUOT_TipoTributo` enum('r','d') DEFAULT NULL,
  `PROVP_Codigo` int(11) UNSIGNED DEFAULT NULL,
  `CUOT_NumBanco` varchar(30) DEFAULT NULL,
  `CUOT_Observacion` varchar(600) DEFAULT NULL,
  `CAJA_Codigo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comprobantes_cuotas_notas`
--

INSERT INTO `comprobantes_cuotas_notas` (`CUOT_Codigo`, `CUOT_Numero`, `CPP_Codigo`, `CUOT_Monto`, `CUOT_FechaInicio`, `CUOT_Fecha`, `CUOT_FlagFisica`, `CUOT_FlagEstado`, `CUOT_FlagPagado`, `CUOT_FechaRegistro`, `CUOT_FechaModificacion`, `CUOT_UsuarioRegistro`, `CUOT_UsuarioModifica`, `CUOT_TipoCuenta`, `CUOT_TipoTributo`, `PROVP_Codigo`, `CUOT_NumBanco`, `CUOT_Observacion`, `CAJA_Codigo`) VALUES
(1, 1, 2, 300.00, '0000-00-00', '2023-05-31', b'1', '1', b'1', '2023-05-01 16:09:12', NULL, 1, 0, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detraccion_tipo`
--

CREATE TABLE `detraccion_tipo` (
  `DTT_Codigo` int(11) NOT NULL,
  `DTT_CodigoSunat` int(11) NOT NULL,
  `DTT_Descripcion` varchar(250) NOT NULL,
  `DTT_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DTT_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detraccion_tipo`
--

INSERT INTO `detraccion_tipo` (`DTT_Codigo`, `DTT_CodigoSunat`, `DTT_Descripcion`, `DTT_FechaRegistro`, `DTT_FlagEstado`) VALUES
(1, 1, '001 AZUCAR Y MELAZA DE CAÑA', '2022-02-11 05:00:00', '1'),
(2, 2, '002 ARROZ', '2022-02-11 05:00:00', '1'),
(3, 3, '003 ALCOHOL ETILICO', '2022-02-11 05:00:00', '1'),
(4, 4, '004 RECURSOS HIDROBIOLOGICOS', '2022-02-11 05:00:00', '1'),
(5, 5, '005 MAIZ AMARILLO DURO', '2022-02-11 05:00:00', '1'),
(6, 7, '007 CAÑA DE AZUCAR', '2022-02-11 05:00:00', '1'),
(7, 8, '008 MADERA', '2022-02-11 05:00:00', '1'),
(8, 9, '009 ARENA Y PIEDRA', '2022-02-11 05:00:00', '1'),
(9, 10, '010 RESIDUOS, SUBPRODUCTOS, DESECHOS, RECORTES Y DESPERDICIOS', '2022-02-11 05:00:00', '1'),
(10, 11, '011 BIENES GRAVADOS CON EL IGV O RENUNCIA A LA EXONERACION', '2022-02-11 05:00:00', '1'),
(11, 12, '0012 INTERMEDIACION LABORAL Y TERCERIZACION', '2022-02-11 20:55:45', '1'),
(12, 13, '014 CARNES Y DESPOJOS COMESTIBLES', '2022-02-11 20:55:45', '1'),
(13, 14, '016 ACEITE DE PESCADO', '2022-02-11 20:56:59', '1'),
(14, 15, '017 HARINA, POLVO Y PELLETS DE PESCADO, CRUSTÁCEOS, MOLUSCOS Y DEMAS INVERTEBRADOS ACUATICOS', '2022-02-11 20:56:59', '1'),
(15, 17, '019 ARRENDAMIENTO DE BIENES MUEBLES', '2022-02-11 21:05:44', '1'),
(16, 18, '020 MANTENIMIENTO Y REPARACION DE BIENES MUEBLES', '2022-02-11 21:05:44', '1'),
(17, 19, '021 MOVIMIENTO DE CARGA', '2022-02-11 21:05:44', '1'),
(18, 20, '022 OTROS SERVICIOS EMPRESARIALES', '2022-02-11 21:05:44', '1'),
(19, 21, '023 LECHE', '2022-02-11 21:05:44', '1'),
(20, 22, '024 COMISION MERCANTIL', '2022-02-11 21:05:44', '1'),
(21, 23, '025 FABRICACION DE BIENES POR ENCARGO', '2022-02-11 21:05:44', '1'),
(22, 24, '026 SERVICIO DE TRANSPORTE DE PERSONAS', '2022-02-11 21:05:44', '1'),
(23, 25, '027 SERVICIO DE TRANSPORTE DE CARGA', '2022-02-11 21:05:44', '1'),
(24, 26, '028 TRANSPORTE DE PASAJEROS', '2022-02-11 21:05:44', '1'),
(25, 28, '030 CONTRATOS DE CONSTRUCCION', '2022-02-11 21:05:44', '1'),
(26, 29, '031 OTRO GRAVADO CON EL IGV', '2022-02-11 21:05:44', '1'),
(27, 30, '032 PAPRIKA Y OTROS FRUTOS DE LOS GENEROS CAPSICUM O PIMINETA', '2022-02-11 21:05:44', '1'),
(28, 32, '034 MINERALES METALICOS NO AURIFEROS', '2022-02-11 21:05:44', '1'),
(29, 33, '035 BIENES EXONERADOS DEL IGV', '2022-02-11 21:05:44', '1'),
(30, 34, '036 ORO Y DEMAS MINERALES METALICOS EXONERADOS DEL IGV', '2022-02-11 21:05:44', '1'),
(31, 35, '037 DEMAS SERVICIOS GRAVADOS DEL IGV', '2022-02-11 21:05:44', '1'),
(32, 37, '039 MINERALES NO METALICOS', '2022-02-11 21:05:44', '1'),
(33, 38, '040 BIEN INMUEBLE GRAVADO CON IGV', '2022-02-11 21:05:44', '1'),
(34, 39, '041 PLOMO', '2022-02-11 21:05:44', '1'),
(35, 42, '099 099 LEY 30737', '2022-02-11 21:05:44', '1');

-- --------------------------------------------------------

--
-- Table structure for table `impactousuario`
--

CREATE TABLE `impactousuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(25) CHARACTER SET utf8 NOT NULL,
  `password` varchar(25) CHARACTER SET utf8 NOT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechamodificacion` date NOT NULL,
  `flagestado` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `impacto_documento`
--

CREATE TABLE `impacto_documento` (
  `IMPDOC_Codigo` int(11) NOT NULL,
  `IMPDOC_Nombre` varchar(500) CHARACTER SET utf8 NOT NULL,
  `IMPDOC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `impacto_publicacion`
--

CREATE TABLE `impacto_publicacion` (
  `IMPPUB_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `IMPPUB_Descripcion` text,
  `IMPPUB_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IMPPUB_FechaModificacion` datetime DEFAULT NULL,
  `IMPPUB_FlagEstado` char(1) DEFAULT '1',
  `SEC_Codigo` int(11) NOT NULL,
  `SEC_Descripcion` varchar(100) DEFAULT NULL,
  `COL1_FIL1` varchar(100) DEFAULT NULL,
  `COL1_FIL2` varchar(100) DEFAULT NULL,
  `COL1_FIL3` varchar(100) DEFAULT NULL,
  `COL1_FIL4` varchar(100) DEFAULT NULL,
  `COL1_FIL5` varchar(100) DEFAULT NULL,
  `COL2_FIL1` varchar(100) DEFAULT NULL,
  `COL2_FIL2` varchar(100) DEFAULT NULL,
  `COL2_FIL3` varchar(100) DEFAULT NULL,
  `COL2_FIL4` varchar(100) DEFAULT NULL,
  `COL2_FIL5` varchar(100) DEFAULT NULL,
  `IMAGEN_1` varchar(500) DEFAULT NULL,
  `IMAGEN_2` varchar(100) DEFAULT NULL,
  `IMAGEN_3` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `medio_de_pago_detraccion`
--

CREATE TABLE `medio_de_pago_detraccion` (
  `MDP_Codigo` int(11) NOT NULL,
  `MDP_CodigoSunat` int(11) NOT NULL,
  `MDP_Descripcion` varchar(250) NOT NULL,
  `MDP_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MDP_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medio_de_pago_detraccion`
--

INSERT INTO `medio_de_pago_detraccion` (`MDP_Codigo`, `MDP_CodigoSunat`, `MDP_Descripcion`, `MDP_FechaRegistro`, `MDP_FlagEstado`) VALUES
(1, 1, '001 DEPOSITO EN CUENTA', '2022-02-11 21:06:55', '1'),
(2, 2, '002 GIRO', '2022-02-11 21:06:55', '1'),
(3, 3, '003 - TRANSFERENCIA DE FONDOS', '2022-02-11 21:12:05', '1'),
(4, 4, '004 - ORDEN DE PAGO', '2022-02-11 21:12:05', '1'),
(5, 5, '005 - TARJETA DE DÉBITO', '2022-02-11 21:12:05', '1'),
(6, 6, '006 - TARJETA DE CRÉDITO EMITIDA EN EL PAÍS POR UNA EMPRESA DEL SISTEMA FINANCIERO', '2022-02-11 21:12:05', '1'),
(7, 7, '007 - CHEQUES CON LA CLÁUSULA DE NO NEGOCIABLE, INTRANSFERIBLES, NO A LA ORDEN U OTRA EQUIVALENTE, A QUE SE REFIERE EL INCISO G) DEL ARTÍCULO 5 DE LA LEY', '2022-02-11 21:12:05', '1'),
(8, 8, '008 - EFECTIVO, POR OPERACIONES EN LAS QUE NO EXISTE OBLIGACIÓN DE UTILIZAR MEDIO DE PAGO', '2022-02-11 21:12:05', '1'),
(9, 9, '009 - EFECTIVO, EN LOS DEMÁS CASOS', '2022-02-11 21:12:05', '1'),
(10, 10, '010 - MEDIOS DE PAGO USADOS EN COMERCIO EXTERIOR', '2022-02-11 21:12:05', '1'),
(11, 11, '011 - DOCUMENTOS EMITIDOS POR LAS EDPYMES Y LAS COOPERATIVAS DE AHORRO Y CRÉDITO NO AUTORIZADAS A CAPTAR DEPÓSITOS DEL PÚBLICO', '2022-02-11 21:12:05', '1'),
(12, 12, '012 - TARJETA DE CRÉDITO EMITIDA EN EL PAÍS O EN EL EXTERIOR POR UNA EMPRESA NO PERTENECIENTE AL SISTEMA FINANCIERO, CUYO OBJETO PRINCIPAL SEA LA EMISIÓN Y ADMINISTRACIÓN DE TARJETAS DE CRÉDITO', '2022-02-11 21:12:05', '1'),
(13, 13, '013 - TARJETAS DE CRÉDITO EMITIDAS EN EL EXTERIOR POR EMPRESAS BANCARIAS O FINANCIERAS NO DOMICILIADAS', '2022-02-11 21:12:05', '1'),
(14, 14, '101 - TRANSFERENCIAS – COMERCIO EXTERIOR', '2022-02-11 21:12:05', '1'),
(15, 15, '102 - CHEQUES BANCARIOS - COMERCIO EXTERIOR', '2022-02-11 21:12:05', '1'),
(16, 16, '103 - ORDEN DE PAGO SIMPLE - COMERCIO EXTERIOR', '2022-02-11 21:12:05', '1'),
(17, 17, '104 - ORDEN DE PAGO DOCUMENTARIO - COMERCIO EXTERIOR', '2022-02-11 21:12:05', '1'),
(18, 18, '105 - REMESA SIMPLE - COMERCIO EXTERIOR', '2022-02-11 21:12:05', '1'),
(19, 19, '106 - REMESA DOCUMENTARIA - COMERCIO EXTERIOR', '2022-02-11 21:12:05', '1'),
(20, 20, '107 - CARTA DE CRÉDITO SIMPLE - COMERCIO EXTERIOR', '2022-02-11 21:12:05', '1'),
(21, 21, '108 - CARTA DE CRÉDITO DOCUMENTARIO - COMERCIO EXTERIOR', '2022-02-11 21:12:05', '1'),
(22, 22, '999 - OTROS MEDIOS DE PAGO', '2022-02-11 21:12:05', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sunat_transaction`
--

CREATE TABLE `sunat_transaction` (
  `TXP_Codigo` int(11) NOT NULL,
  `TXC_CodigoSunat` int(11) NOT NULL,
  `TXC_Descripcion` varchar(250) NOT NULL,
  `TXC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TXC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sunat_transaction`
--

INSERT INTO `sunat_transaction` (`TXP_Codigo`, `TXC_CodigoSunat`, `TXC_Descripcion`, `TXC_FechaRegistro`, `TXC_FlagEstado`) VALUES
(1, 1, 'VENTA INTERNA', '2022-02-11 05:00:00', '1'),
(2, 2, 'EXPORTACION', '2022-02-11 05:00:00', '1'),
(3, 4, 'VENTA INTERNA - ANTICIPOS', '2022-02-11 05:00:00', '1'),
(4, 29, 'VENTAS NO DOMICILIADOS QUE NO CALIFICAN COMO EXPORTACION', '2022-02-11 05:00:00', '1'),
(5, 30, 'OPERACION SUJETA A DETRACCION', '2022-02-11 05:00:00', '1'),
(6, 33, 'DETRACCION - SERVICIOS DE TRANSPORTE DE CARGA', '2022-02-11 05:00:00', '0'),
(7, 34, 'OPERACION SUJETA A PERCEPCION', '2022-02-11 05:00:00', '1'),
(8, 32, 'DETRACCION - SERVICIOS DE TRANSPORTE DE PASAJEROS', '2022-02-11 05:00:00', '0'),
(9, 31, 'DETRACCION - RECURSOS HIDROBIOLOGICOS', '2022-02-11 05:00:00', '0');

-- --------------------------------------------------------

--
-- Table structure for table `temporal_detalle`
--

CREATE TABLE `temporal_detalle` (
  `TEMPDE_Codigo` int(11) NOT NULL,
  `TEMPDE_SESSION` varchar(50) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `ALMAP_Codigo` int(11) DEFAULT '1',
  `LOTP_Codigo` int(11) DEFAULT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `TEMPDE_Costo` double DEFAULT '0',
  `TEMPDE_Stock` decimal(10,0) DEFAULT NULL,
  `TEMPDE_Cantidad` double DEFAULT '0',
  `TEMPDE_Pendiente` double NOT NULL DEFAULT '0',
  `TEMPDE_Precio` double DEFAULT '0',
  `TEMPDE_Subtotal` double DEFAULT '0',
  `TEMPDE_Descuento` double DEFAULT '0',
  `TEMPDE_Igv` double DEFAULT '0',
  `TEMPDE_TipoIgv` tinyint(3) NOT NULL,
  `TEMPDE_Total` double NOT NULL DEFAULT '0',
  `TEMPDE_Igv100` int(11) DEFAULT '0',
  `TEMPDE_Descuento100` int(11) DEFAULT '0',
  `TEMPDE_Descripcion` varchar(250) DEFAULT NULL,
  `TEMPDE_Observacion` varchar(250) DEFAULT NULL,
  `TEMPDE_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TEMPDE_FechaModificacion` datetime DEFAULT NULL,
  `TEMPDE_FlagBs` varchar(5) DEFAULT NULL,
  `TEMPDE_CodComprobante` int(11) DEFAULT NULL COMMENT 'ID de comp,fact,guia,oc, ...etc',
  `TEMPDE_CodDetalle` int(11) DEFAULT NULL COMMENT 'Se guardaran los id de los detalles, comprobante,ocompra,expo',
  `TEMPDE_ICBPER` char(1) NOT NULL DEFAULT '0' COMMENT 'Flag de impuesto a la bolsa plastica',
  `TEMPDE_Anticipo` char(1) NOT NULL DEFAULT '0',
  `TEMPDE_AntSerie` varchar(50) DEFAULT NULL,
  `TEMPDE_AntNumero` varchar(50) DEFAULT NULL,
  `TEMPDE_codigodam` varchar(100) DEFAULT NULL,
  `TEMPDE_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `temporal_detalle`
--

INSERT INTO `temporal_detalle` (`TEMPDE_Codigo`, `TEMPDE_SESSION`, `PROD_Codigo`, `UNDMED_Codigo`, `ALMAP_Codigo`, `LOTP_Codigo`, `MONED_Codigo`, `TEMPDE_Costo`, `TEMPDE_Stock`, `TEMPDE_Cantidad`, `TEMPDE_Pendiente`, `TEMPDE_Precio`, `TEMPDE_Subtotal`, `TEMPDE_Descuento`, `TEMPDE_Igv`, `TEMPDE_TipoIgv`, `TEMPDE_Total`, `TEMPDE_Igv100`, `TEMPDE_Descuento100`, `TEMPDE_Descripcion`, `TEMPDE_Observacion`, `TEMPDE_FechaRegistro`, `TEMPDE_FechaModificacion`, `TEMPDE_FlagBs`, `TEMPDE_CodComprobante`, `TEMPDE_CodDetalle`, `TEMPDE_ICBPER`, `TEMPDE_Anticipo`, `TEMPDE_AntSerie`, `TEMPDE_AntNumero`, `TEMPDE_codigodam`, `TEMPDE_FlagEstado`) VALUES
(1, '16966074974531990', 2, 1, 1, 0, 1, 0, '10', 1, 1, 23, 19.49153, 0, 3.50847, 1, 23, 0, 0, 'test', '', '2023-10-06 15:51:52', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(2, '16966075259397570', 2, 1, 1, 0, 1, 0, '10', 2, 2, 23, 38.98305, 0, 7.01695, 1, 46, 0, 0, 'TEST', '', '2023-10-06 15:52:06', NULL, '', NULL, 1, '0', '0', '', '', NULL, '1'),
(3, '16966075583013250', 2, 1, 1, 0, 1, 0, '2', 2, 0, 23, 38.983050847457626, 0, 7.01695, 1, 46, 18, 0, 'TEST', '', '2023-10-06 15:52:39', NULL, 'B', NULL, 1, '0', '0', NULL, NULL, NULL, '1'),
(4, '16966086801180620', 3, 1, 1, 0, 1, 0, '50', 4, 4, 78, 264.40678, 0, 47.59322, 1, 312, 0, 0, 'producto test', '', '2023-10-06 16:11:37', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(5, '16966087753590280', 3, 1, 1, 0, 1, 0, '46', 6, 6, 78, 396.61017, 0, 71.38983, 1, 468, 0, 0, 'producto test', '', '2023-10-06 16:13:12', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(6, '16966088047408890', 3, 1, 1, 0, 1, 0, '6', 6, 6, 78, 396.6101694915254, 0, 71.38983050847455, 1, 468, 18, 0, 'PRODUCTO TEST', '', '2023-10-06 16:13:50', NULL, 'B', 3, 3, '0', '0', NULL, NULL, NULL, '1'),
(7, '16966091600971370', 2, 1, 1, 0, 1, 0, '8', 2, 2, 4, 6.77966, 0, 1.22034, 1, 8, 0, 0, 'test', '', '2023-10-06 16:19:32', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(8, '16966092546038370', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 16:20:57', NULL, 'B', NULL, 1, '0', '0', NULL, NULL, NULL, '1'),
(9, '16966092744099330', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 16:21:15', NULL, 'B', NULL, 2, '0', '0', NULL, NULL, NULL, '1'),
(10, '16966093357772950', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 16:22:16', NULL, 'B', NULL, 3, '0', '0', NULL, NULL, NULL, '1'),
(11, '16966115807506020', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 16:59:51', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(12, '16966117272090560', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:02:08', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(13, '16966117457416030', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:02:26', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(16, '16966119302564370', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:05:30', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(19, '16966119948998090', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:06:35', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(20, '16966119948998090', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:14:36', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(21, '16966124831651340', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:14:44', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(22, '16966124831651340', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:14:46', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(23, '16966124962375530', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:14:56', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(24, '16966124962375530', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:14:59', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(26, '16966125200291950', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:15:25', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(28, '16966125761982120', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:16:23', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(30, '16966126201656830', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:17:05', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(31, '16966126749403270', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:17:55', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(32, '16966126749403270', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:18:28', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(34, '16966127273265760', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:19:01', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(35, '16966127717810270', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:19:32', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(36, '16966127717810270', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:19:36', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(38, '16966127859370910', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:19:51', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(40, '16966128036109790', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:21:42', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(41, '16966129323734730', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:22:14', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(42, '16966129323734730', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:22:22', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(44, '16966129481809790', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:22:33', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(46, '16966129607786760', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:22:45', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(48, '16966130996550990', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:25:05', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(50, '16966131180708640', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:25:26', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(51, '16966131453383920', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:25:54', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(52, '16966131672117320', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:26:07', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(53, '16966131672117320', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:26:17', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(55, '16966131956906190', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:26:41', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(56, '16966132176317670', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:27:06', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(57, '16966132176317670', 3, 1, 1, 0, 1, 0, '40', 15, 15, 7, 88.98305, 0, 16.01695, 1, 105, 0, 0, 'producto test', '', '2023-10-06 17:27:17', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(58, '16966132490048450', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:27:40', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(59, '16966135024391530', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:31:55', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(60, '16966138222288300', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:37:13', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(61, '16966138879313230', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:38:53', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(62, '16966139556264660', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:39:30', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(63, '16966140176100890', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:40:26', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(64, '16966140683419030', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-06 17:41:25', NULL, 'B', 1, 4, '0', '0', NULL, NULL, NULL, '1'),
(65, '16966246574038280', 2, 1, 1, 0, 1, 0, '6', 1, 1, 3, 2.54237, 0, 0.45763, 1, 3, 0, 0, 'test', '', '2023-10-06 20:37:49', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(66, '16966277995812430', 2, 1, 1, 0, 1, 0, '2', 2, 2, 23, 38.983050847457626, 0, 7.016949152542374, 1, 46, 18, 0, 'TEST', '', '2023-10-06 21:30:08', NULL, 'B', NULL, 1, '0', '0', '', '', NULL, '1'),
(67, '16966285802749640', 3, 1, 1, 0, 1, 30, '40', 10, 10, 12, 101.69492, 0, 18.30508, 1, 120, 0, 0, 'producto test', '', '2023-10-06 21:43:21', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(68, '16966291381136040', 3, 1, 1, 0, 1, 30, '30', 13, 13, 30, 330.50847, 0, 59.49153, 1, 390, 0, 0, 'producto test', '', '2023-10-06 21:52:29', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(69, '16966291782579880', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-06 21:53:07', NULL, 'B', 4, 4, '0', '0', NULL, NULL, NULL, '1'),
(70, '16966292277341970', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-06 21:53:48', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(71, '16966292615345020', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-06 21:54:21', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(72, '16966307952267600', 2, 1, 1, 0, 1, 23, '6', 1, 1, 23, 19.49153, 0, 3.50847, 1, 23, 0, 0, 'test', '', '2023-10-06 22:20:04', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(73, '16966327085203510', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-06 22:51:56', NULL, 'B', 5, 5, '0', '0', NULL, NULL, NULL, '1'),
(74, '16966327967289820', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-06 22:53:29', NULL, 'B', 5, 5, '0', '0', NULL, NULL, NULL, '1'),
(75, '16966329729617520', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-06 22:56:13', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(76, '16966884963740730', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 14:21:45', NULL, 'B', 5, 5, '0', '0', NULL, NULL, NULL, '1'),
(77, '16966893702766100', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 14:36:11', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(78, '16966894876942940', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 14:38:20', NULL, 'B', 5, 5, '0', '0', NULL, NULL, NULL, '1'),
(79, '16966895527145200', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 14:39:24', NULL, 'B', 5, 5, '0', '0', NULL, NULL, NULL, '1'),
(80, '16966903511056710', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 14:52:31', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(81, '16966903747647830', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 14:52:55', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(82, '16966904256431240', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 14:53:46', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(83, '16966910205950490', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 15:03:41', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(85, '16966910813369540', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 15:04:41', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(86, '16966914496106370', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 15:10:58', NULL, 'B', 5, 5, '0', '0', NULL, NULL, NULL, '1'),
(87, '16966916061285330', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 15:13:26', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(88, '16966916250269890', 3, 1, 1, 0, 1, 30, '13', 13, 13, 30, 330.50847457627117, 0, 59.49152542372882, 1, 390, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 15:13:45', NULL, 'B', NULL, 9, '0', '0', '', '', NULL, '1'),
(89, '16966916376293050', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 15:14:16', NULL, 'B', 5, 5, '0', '0', NULL, NULL, NULL, '1'),
(90, '16966916915586960', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 15:14:52', NULL, 'B', NULL, 10, '0', '0', '', '', NULL, '1'),
(91, '16966917116063240', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 15:15:12', NULL, 'B', NULL, 10, '0', '0', '', '', NULL, '1'),
(92, '16966917177641130', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 15:15:18', NULL, 'B', NULL, 10, '0', '0', '', '', NULL, '1'),
(93, '16966917282623390', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 15:15:28', NULL, 'B', NULL, 10, '0', '0', '', '', NULL, '1'),
(94, '16966917374796080', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 15:15:38', NULL, 'B', NULL, 10, '0', '0', '', '', NULL, '1'),
(95, '16966917442165200', 3, 1, 1, 0, 1, 30, '30', 1, 1, 30, 25.42373, 0, 4.57627, 1, 30, 0, 0, 'producto test', '', '2023-10-07 15:15:54', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(96, '16966921180783060', 2, 1, 1, 0, 1, 23, '1', 1, 1, 23, 19.491525423728813, 0, 3.508474576271187, 1, 23, 18, 0, 'TEST', '', '2023-10-07 15:21:58', NULL, 'B', NULL, 10, '0', '0', '', '', NULL, '1'),
(97, '16966924766684150', 3, 1, 1, 0, 1, 30, '30', 1, 1, 30, 25.42373, 0, 4.57627, 1, 30, 0, 0, 'producto test', '', '2023-10-07 15:28:05', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(98, '16966924998612490', 3, 1, 1, 0, 1, 30, '1', 1, 1, 30, 25.423728813559322, 0, 4.576271186440678, 1, 30, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 15:28:29', NULL, 'B', 6, 6, '0', '0', NULL, NULL, NULL, '1'),
(99, '16966925375584100', 3, 1, 1, 0, 1, 30, '1', 1, 1, 30, 25.423728813559322, 0, 4.576271186440678, 1, 30, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 15:28:58', NULL, 'B', NULL, 11, '0', '0', '', '', NULL, '1'),
(100, '16966926317509540', 2, 1, 1, 0, 1, 23, '6', 3, 3, 23, 58.47458, 0, 10.52542, 1, 69, 0, 0, 'test', '', '2023-10-07 15:30:46', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(101, '16966926913137660', 2, 1, 1, 0, 1, 23, '3', 3, 3, 23, 58.474576271186436, 0, 10.52542, 1, 69, 18, 0, 'TEST', '', '2023-10-07 15:31:41', NULL, 'B', 7, 7, '0', '0', NULL, NULL, NULL, '1'),
(102, '16966927246543610', 2, 1, 1, 0, 1, 23, '3', 3, 3, 23, 58.474576271186436, 0, 10.52542372881356, 1, 69, 18, 0, 'TEST', '', '2023-10-07 15:32:05', NULL, 'B', NULL, 12, '0', '0', '', '', NULL, '1'),
(103, '16966927327153050', 2, 1, 1, 0, 1, 23, '3', 3, 3, 23, 58.474576271186436, 0, 10.52542372881356, 1, 69, 18, 0, 'TEST', '', '2023-10-07 15:32:13', NULL, 'B', NULL, 12, '0', '0', '', '', NULL, '1'),
(104, '16966970592165550', 2, 1, 1, 0, 1, 0, '2', 2, 2, 4, 6.779661016949153, 0, 1.2203389830508469, 1, 8, 18, 0, 'TEST', '', '2023-10-07 16:44:19', NULL, 'B', NULL, 4, '0', '0', '', '', NULL, '1'),
(105, '16966970683580500', 3, 1, 1, 0, 1, 30, '30', 11, 11, 3, 27.9661, 0, 5.0339, 1, 33, 0, 0, 'producto test', '', '2023-10-07 16:44:51', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(106, '16966970996563300', 3, 1, 1, 0, 1, 30, '11', 11, 11, 3, 27.96610169491526, 0, 5.033898305084742, 1, 33, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 16:45:00', NULL, 'B', NULL, 8, '0', '0', NULL, NULL, NULL, '1'),
(107, '16966999786807100', 3, 1, 1, 0, 1, 30, '30', 12, 12, 34, 345.76271, 0, 62.23729, 1, 408, 0, 0, 'producto test', '', '2023-10-07 17:33:12', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(108, '16967006565779100', 2, 1, 1, 0, 1, 23, '1', 1, 1, 3, 2.5423728813559325, 0, 0.45762711864406747, 1, 3, 18, 0, 'TEST', '', '2023-10-07 17:44:25', NULL, 'B', 2, 5, '0', '0', NULL, NULL, NULL, '1'),
(109, '16967006918185860', 3, 1, 1, 0, 1, 30, '30', 12, 12, 30, 305.08475, 0, 54.91525, 1, 360, 0, 0, 'producto test', '', '2023-10-07 17:45:00', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(110, '16967007176254350', 3, 1, 1, 0, 1, 30, '12', 12, 12, 30, 305.08474576271186, 0, 54.91525, 1, 360, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 17:45:33', NULL, 'B', 10, 10, '0', '0', NULL, NULL, NULL, '1'),
(111, '16967008570653990', 3, 1, 1, 0, 1, 30, '12', 12, 12, 30, 305.08474576271186, 0, 54.91525423728814, 1, 360, 18, 0, 'PRODUCTO TEST', '', '2023-10-07 17:47:43', NULL, 'B', 3, 6, '0', '0', NULL, NULL, NULL, '1'),
(112, '16967008961744500', 2, 1, 1, 0, 1, 23, '6', 12, 12, 23, 233.89831, 0, 42.10169, 1, 276, 0, 0, 'test', '', '2023-10-07 17:48:24', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(113, '16967009464409580', 2, 1, 1, 0, 1, 23, '12', 12, 12, 23, 233.89830508474574, 0, 42.10169491525424, 1, 276, 18, 0, 'TEST', '', '2023-10-07 17:49:07', NULL, 'B', NULL, 7, '0', '0', NULL, NULL, NULL, '1'),
(114, '16967009557938380', 2, 1, 1, 0, 1, 23, '12', 12, 12, 23, 233.89830508474574, 0, 42.10169491525424, 1, 276, 18, 0, 'TEST', '', '2023-10-07 17:49:28', NULL, 'B', 4, 8, '0', '0', NULL, NULL, NULL, '1'),
(115, '16967009958527080', 2, 1, 1, 0, 1, 23, '12', 12, 12, 23, 233.89830508474574, 0, 42.10169491525424, 1, 276, 18, 0, 'TEST', '', '2023-10-07 17:50:05', NULL, 'B', 4, 8, '0', '0', NULL, NULL, NULL, '1'),
(116, '16968716783194310', 2, 1, 1, 0, 1, 23, '50', 20, 20, 3, 50.84746, 0, 9.15254, 1, 60, 0, 0, 'test', '', '2023-10-09 17:14:50', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(117, '16968718848752110', 3, 1, 2, 0, 1, 30, '70', 23, 23, 3, 58.47458, 0, 10.52542, 1, 69, 0, 0, 'producto test', '', '2023-10-09 17:18:17', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(118, '16968736748338210', 2, 1, 2, 0, 1, 23, '15', 1, 1, 2, 1.69492, 0, 0.30508, 1, 2, 0, 0, 'test', '', '2023-10-09 17:48:06', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1'),
(119, '16968741126134570', 3, 1, 2, 0, 1, 30, '47', 14, 14, 3, 35.59322, 0, 6.40678, 1, 42, 0, 0, 'producto test', '', '2023-10-09 17:55:31', NULL, 'B', NULL, NULL, '0', '0', '', '', NULL, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cji_almacen`
--
ALTER TABLE `cji_almacen`
  ADD PRIMARY KEY (`ALMAP_Codigo`),
  ADD KEY `FK_cji_almacen_cji_tipoalmacen` (`TIPALM_Codigo`),
  ADD KEY `FK_cji_almacen_cji_centrocosto` (`CENCOSP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `EESTABP_Codigo` (`EESTABP_Codigo`);

--
-- Indexes for table `cji_almacenproducto`
--
ALTER TABLE `cji_almacenproducto`
  ADD PRIMARY KEY (`ALMPROD_Codigo`),
  ADD KEY `FK_cji_almacenproducto_cji_almacen` (`ALMAC_Codigo`),
  ADD KEY `FK_cji_almacenproducto_cji_producto` (`PROD_Codigo`),
  ADD KEY `FK_cji_almacenproducto_cji_compania` (`COMPP_Codigo`);

--
-- Indexes for table `cji_almacenproductoserie`
--
ALTER TABLE `cji_almacenproductoserie`
  ADD PRIMARY KEY (`ALMPRODSERP_Codigo`),
  ADD KEY `fk_cji_almacenproductoserie_cji_almacenproducto1` (`ALMPROD_Codigo`),
  ADD KEY `fk_cji_almacenproductoserie_cji_serie1` (`SERIP_Codigo`);

--
-- Indexes for table `cji_almaprolote`
--
ALTER TABLE `cji_almaprolote`
  ADD PRIMARY KEY (`ALMALOTP_Codigo`),
  ADD KEY `fk_cji_almaprolote_cji_almacenproducto1` (`ALMPROD_Codigo`),
  ADD KEY `fk_cji_almaprolote_cji_lote1` (`LOTP_Codigo`),
  ADD KEY `FK_cji_almaprolote_cji_compania` (`COMPP_Codigo`);

--
-- Indexes for table `cji_area`
--
ALTER TABLE `cji_area`
  ADD PRIMARY KEY (`AREAP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indexes for table `cji_atributo`
--
ALTER TABLE `cji_atributo`
  ADD PRIMARY KEY (`ATRIB_Codigo`);

--
-- Indexes for table `cji_banco`
--
ALTER TABLE `cji_banco`
  ADD PRIMARY KEY (`BANP_Codigo`);

--
-- Indexes for table `cji_bancocta`
--
ALTER TABLE `cji_bancocta`
  ADD PRIMARY KEY (`CTAP_Codigo`);

--
-- Indexes for table `cji_caja`
--
ALTER TABLE `cji_caja`
  ADD PRIMARY KEY (`CAJA_Codigo`),
  ADD KEY `compania` (`COMPP_Codigo`);

--
-- Indexes for table `cji_cajamovimiento`
--
ALTER TABLE `cji_cajamovimiento`
  ADD PRIMARY KEY (`CAJAMOV_Codigo`);

--
-- Indexes for table `cji_caja_chekera`
--
ALTER TABLE `cji_caja_chekera`
  ADD PRIMARY KEY (`CAJCHEK_Codigo`);

--
-- Indexes for table `cji_caja_cuenta`
--
ALTER TABLE `cji_caja_cuenta`
  ADD PRIMARY KEY (`CAJCUENT_Codigo`);

--
-- Indexes for table `cji_cargo`
--
ALTER TABLE `cji_cargo`
  ADD PRIMARY KEY (`CARGP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indexes for table `cji_categoriapublicacion`
--
ALTER TABLE `cji_categoriapublicacion`
  ADD PRIMARY KEY (`CATPUBP_Codigo`);

--
-- Indexes for table `cji_centrocosto`
--
ALTER TABLE `cji_centrocosto`
  ADD PRIMARY KEY (`CENCOSP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indexes for table `cji_chekera`
--
ALTER TABLE `cji_chekera`
  ADD PRIMARY KEY (`CHEK_Codigo`);

--
-- Indexes for table `cji_cheque`
--
ALTER TABLE `cji_cheque`
  ADD PRIMARY KEY (`CHEP_Codigo`);

--
-- Indexes for table `cji_cliente`
--
ALTER TABLE `cji_cliente`
  ADD PRIMARY KEY (`CLIP_Codigo`),
  ADD KEY `fk_CJ_CLIENTE_CJ_EMPRESA1` (`EMPRP_Codigo`),
  ADD KEY `fk_CJ_CLIENTE_CJ_PERSONA1` (`PERSP_Codigo`),
  ADD KEY `fk_CJ_CLIENTE_CJ_TIPOCLIENTE` (`TIPCLIP_Codigo`),
  ADD KEY `FORPAP_Codigo` (`FORPAP_Codigo`),
  ADD KEY `CLIC_CodigoUsuario` (`CLIC_CodigoUsuario`) USING BTREE;

--
-- Indexes for table `cji_clientecompania`
--
ALTER TABLE `cji_clientecompania`
  ADD PRIMARY KEY (`CLIP_Codigo`,`COMPP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indexes for table `cji_compadocumenitem`
--
ALTER TABLE `cji_compadocumenitem`
  ADD PRIMARY KEY (`COMPADOCUITEM_Codigo`);

--
-- Indexes for table `cji_compania`
--
ALTER TABLE `cji_compania`
  ADD PRIMARY KEY (`COMPP_Codigo`),
  ADD KEY `FK_cji_compania_cji_empresa` (`EMPRP_Codigo`),
  ADD KEY `EESTABP_Codigo` (`EESTABP_Codigo`);

--
-- Indexes for table `cji_companiaconfidocumento`
--
ALTER TABLE `cji_companiaconfidocumento`
  ADD PRIMARY KEY (`COMPCONFIDOCP_Codigo`),
  ADD KEY `DOCUP_Codigo` (`DOCUP_Codigo`),
  ADD KEY `COMPCONFIP_Codigo` (`COMPCONFIP_Codigo`);

--
-- Indexes for table `cji_companiaconfiguracion`
--
ALTER TABLE `cji_companiaconfiguracion`
  ADD PRIMARY KEY (`COMPCONFIP_Codigo`),
  ADD UNIQUE KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indexes for table `cji_comparativo`
--
ALTER TABLE `cji_comparativo`
  ADD PRIMARY KEY (`COMP_Codigo`);

--
-- Indexes for table `cji_comparativodetalle`
--
ALTER TABLE `cji_comparativodetalle`
  ADD PRIMARY KEY (`CUACOMP_Codigo`);

--
-- Indexes for table `cji_comprobante`
--
ALTER TABLE `cji_comprobante`
  ADD PRIMARY KEY (`CPP_Codigo`),
  ADD KEY `FK_cji_factura_cji_presupuesto` (`PRESUP_Codigo`),
  ADD KEY `FK_cji_factura_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_factura_cji_cliente` (`CLIP_Codigo`),
  ADD KEY `FK_cji_factura_cji_usuario` (`USUA_Codigo`),
  ADD KEY `FK_cji_factura_cji_moneda` (`MONED_Codigo`),
  ADD KEY `FK_cji_factura_cji_formapago` (`FORPAP_Codigo`),
  ADD KEY `FK_cji_comprobante_proveedor` (`PROVP_Codigo`),
  ADD KEY `FK_cji_comprobante_ocompra` (`OCOMP_Codigo`),
  ADD KEY `GUIAREMP_Codigo` (`GUIAREMP_Codigo`),
  ADD KEY `CPC_Vendedor` (`CPC_Vendedor`),
  ADD KEY `GUIASAP_Codigo` (`GUIASAP_Codigo`),
  ADD KEY `GUIAINP_Codigo` (`GUIAINP_Codigo`),
  ADD KEY `caja` (`CAJA_Codigo`);

--
-- Indexes for table `cji_comprobantedetalle`
--
ALTER TABLE `cji_comprobantedetalle`
  ADD PRIMARY KEY (`CPDEP_Codigo`),
  ADD KEY `FK_Reference_64` (`PROD_Codigo`),
  ADD KEY `FK_cji_facturadetalle_cji_unidadmedida` (`UNDMED_Codigo`),
  ADD KEY `CPP_Codigo` (`CPP_Codigo`);

--
-- Indexes for table `cji_comprobante_formaspago`
--
ALTER TABLE `cji_comprobante_formaspago`
  ADD PRIMARY KEY (`idcji_compro_forPa`);

--
-- Indexes for table `cji_comprobante_guiarem`
--
ALTER TABLE `cji_comprobante_guiarem`
  ADD PRIMARY KEY (`COMPGUI_Codigo`);

--
-- Indexes for table `cji_comprobante_letra`
--
ALTER TABLE `cji_comprobante_letra`
  ADD PRIMARY KEY (`CPLET_Codigo`),
  ADD KEY `LET_Codigo` (`LET_Codigo`),
  ADD KEY `CPP_Codigo` (`CPP_Codigo`);

--
-- Indexes for table `cji_condicionentrega`
--
ALTER TABLE `cji_condicionentrega`
  ADD PRIMARY KEY (`CONENP_Codigo`);

--
-- Indexes for table `cji_configuracion`
--
ALTER TABLE `cji_configuracion`
  ADD PRIMARY KEY (`CONFIP_Codigo`),
  ADD KEY `FK_cji_correlativo_cji_documento` (`DOCUP_Codigo`),
  ADD KEY `FK_cji_correlativo_cji_compania` (`COMPP_Codigo`);

--
-- Indexes for table `cji_correlativo`
--
ALTER TABLE `cji_correlativo`
  ADD PRIMARY KEY (`CORRP_Codigo`);

--
-- Indexes for table `cji_correoenviar`
--
ALTER TABLE `cji_correoenviar`
  ADD PRIMARY KEY (`CE_Codigo`);

--
-- Indexes for table `cji_cotizacion`
--
ALTER TABLE `cji_cotizacion`
  ADD PRIMARY KEY (`COTIP_Codigo`),
  ADD KEY `FK_Reference_39` (`PEDIP_Codigo`),
  ADD KEY `FK_Reference_41` (`PROVP_Codigo`),
  ADD KEY `FK_Reference_42` (`FORPAP_Codigo`),
  ADD KEY `FK_Reference_43` (`CONENP_Codigo`),
  ADD KEY `FK_Reference_44` (`USUA_Codigo`),
  ADD KEY `FK_Reference_51` (`CENCOSP_Codigo`),
  ADD KEY `FK_cji_cotizacion_cji_cotizacion` (`COMPP_Codigo`),
  ADD KEY `FK_cji_cotizacion_cji_almacen` (`ALMAP_Codigo`);

--
-- Indexes for table `cji_cotizaciondetalle`
--
ALTER TABLE `cji_cotizaciondetalle`
  ADD PRIMARY KEY (`COTDEP_Codigo`),
  ADD KEY `FK_Reference_46` (`PROD_Codigo`),
  ADD KEY `FK_cji_cotizaciondetalle_cji_unidadmedida` (`UNDMED_Codigo`),
  ADD KEY `FK_cji_cotizaciondetalle_cotizacion` (`COTIP_Codigo`);

--
-- Indexes for table `cji_cuentacontable`
--
ALTER TABLE `cji_cuentacontable`
  ADD PRIMARY KEY (`CUNTCONTBL_Codigo`);

--
-- Indexes for table `cji_cuentas`
--
ALTER TABLE `cji_cuentas`
  ADD PRIMARY KEY (`CUE_Codigo`),
  ADD KEY `DOCUP_Codigo` (`DOCUP_Codigo`);

--
-- Indexes for table `cji_cuentasempresas`
--
ALTER TABLE `cji_cuentasempresas`
  ADD PRIMARY KEY (`CUENT_Codigo`);

--
-- Indexes for table `cji_cuentaspago`
--
ALTER TABLE `cji_cuentaspago`
  ADD PRIMARY KEY (`CPAGP_Codigo`);

--
-- Indexes for table `cji_despacho`
--
ALTER TABLE `cji_despacho`
  ADD PRIMARY KEY (`DESP_Codigo`);

--
-- Indexes for table `cji_despachodetalle`
--
ALTER TABLE `cji_despachodetalle`
  ADD PRIMARY KEY (`DESPD_Codigo`);

--
-- Indexes for table `cji_direccion`
--
ALTER TABLE `cji_direccion`
  ADD PRIMARY KEY (`DIRECC_Codigo`),
  ADD KEY `UBIGP_Domicilio` (`UBIGP_Domicilio`),
  ADD KEY `PROYP_Codigo` (`PROYP_Codigo`);

--
-- Indexes for table `cji_directivo`
--
ALTER TABLE `cji_directivo`
  ADD PRIMARY KEY (`DIREP_Codigo`),
  ADD KEY `fk_CJ_DIRECTIVO_CJ_EMPRESA1` (`EMPRP_Codigo`),
  ADD KEY `fk_CJ_DIRECTIVO_CJ_PERSONA1` (`PERSP_Codigo`),
  ADD KEY `fk_CJ_DIRECTIVO_CJ_CARGO1` (`CARGP_Codigo`);

--
-- Indexes for table `cji_documento`
--
ALTER TABLE `cji_documento`
  ADD PRIMARY KEY (`DOCUP_Codigo`);

--
-- Indexes for table `cji_documentoitem`
--
ALTER TABLE `cji_documentoitem`
  ADD PRIMARY KEY (`DOCUITEM_Codigo`);

--
-- Indexes for table `cji_documentosentenica`
--
ALTER TABLE `cji_documentosentenica`
  ADD PRIMARY KEY (`DOCSENT_Codigo`);

--
-- Indexes for table `cji_emprarea`
--
ALTER TABLE `cji_emprarea`
  ADD PRIMARY KEY (`EAREAP_Codigo`),
  ADD KEY `fk_CJ_EMPAREA_CJ_AREA1` (`AREAP_Codigo`),
  ADD KEY `fk_CJ_EMPAREA_CJ_EMPRESA1` (`EMPRP_Codigo`),
  ADD KEY `fk_CJ_EMPAREA_CJ_DIRECTIVO1` (`DIREP_Codigo`);

--
-- Indexes for table `cji_emprcontacto`
--
ALTER TABLE `cji_emprcontacto`
  ADD PRIMARY KEY (`ECONP_Contacto`),
  ADD KEY `fk_CJ_EMPRCONTACTO_CJ_EMPRESA1` (`EMPRP_Codigo`),
  ADD KEY `FK_cji_emprcontacto_cji_persona` (`ECONC_Persona`);

--
-- Indexes for table `cji_empresa`
--
ALTER TABLE `cji_empresa`
  ADD PRIMARY KEY (`EMPRP_Codigo`),
  ADD KEY `FK_cji_empresa_cji_ciiu` (`CIIUP_Codigo`),
  ADD KEY `FK_cji_empresa_cji_tipocodigo` (`TIPCOD_Codigo`),
  ADD KEY `SECCOMP_Codigo` (`SECCOMP_Codigo`);

--
-- Indexes for table `cji_empresatipoproveedor`
--
ALTER TABLE `cji_empresatipoproveedor`
  ADD PRIMARY KEY (`EMPTIPOP_Codigo`);

--
-- Indexes for table `cji_emprestablecimiento`
--
ALTER TABLE `cji_emprestablecimiento`
  ADD PRIMARY KEY (`EESTABP_Codigo`),
  ADD KEY `fk_CJ_EMPRESTABLECIMIENTO_CJ_TIPOESTABLECIMIENTO1` (`TESTP_Codigo`),
  ADD KEY `fk_CJ_EMPRESTABLECIMIENTO_CJ_EMPRESA1` (`EMPRP_Codigo`),
  ADD KEY `fk_CJ_EMPRESTABLECIMIENTO_CJ_UBIGEO1` (`UBIGP_Codigo`);

--
-- Indexes for table `cji_entregacliente`
--
ALTER TABLE `cji_entregacliente`
  ADD PRIMARY KEY (`ENTRECLI_Codigo`),
  ADD KEY `FK_cji_entregacliente_cji_garantia` (`GARAN_Codigo`),
  ADD KEY `FK_cji_entregacliente_cji_empresa` (`EMPRP_Codigo`),
  ADD KEY `FK_cji_entregacliente_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_entregacliente_cji_cliente` (`CLIP_Codigo`);

--
-- Indexes for table `cji_envioproveedor`
--
ALTER TABLE `cji_envioproveedor`
  ADD PRIMARY KEY (`ENVIPRO_Codigo`),
  ADD KEY `FK_cji_envioproveedor_cji_garantia` (`GARAN_Codigo`),
  ADD KEY `FK_cji_envioproveedor_cji_empresa` (`EMPRP_Codigo`),
  ADD KEY `FK_cji_envioproveedor_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_envioproveedor_cji_proveedor` (`PROVP_Codigo`);

--
-- Indexes for table `cji_estadocivil`
--
ALTER TABLE `cji_estadocivil`
  ADD PRIMARY KEY (`ESTCP_Codigo`);

--
-- Indexes for table `cji_fabricante`
--
ALTER TABLE `cji_fabricante`
  ADD PRIMARY KEY (`FABRIP_Codigo`);

--
-- Indexes for table `cji_familia`
--
ALTER TABLE `cji_familia`
  ADD PRIMARY KEY (`FAMI_Codigo`);

--
-- Indexes for table `cji_familiacompania`
--
ALTER TABLE `cji_familiacompania`
  ADD PRIMARY KEY (`FAMI_Codigo`,`COMPP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indexes for table `cji_flujocaja`
--
ALTER TABLE `cji_flujocaja`
  ADD PRIMARY KEY (`FLUCAJ_Codigo`),
  ADD KEY `CUE_Codigo` (`CUE_Codigo`),
  ADD KEY `FORPAP_Codigo` (`FORPAP_Codigo`),
  ADD KEY `MONED_Codigo` (`MONED_Codigo`);

--
-- Indexes for table `cji_formapago`
--
ALTER TABLE `cji_formapago`
  ADD PRIMARY KEY (`FORPAP_Codigo`);

--
-- Indexes for table `cji_garantia`
--
ALTER TABLE `cji_garantia`
  ADD PRIMARY KEY (`GARAN_Codigo`),
  ADD KEY `FK_cji_garantia_cji_cliente` (`CLIP_Codigo`),
  ADD KEY `FK_cji_garantia_cji_empresa` (`EMPRP_Codigo`),
  ADD KEY `FK_cji_garantia_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_garantia_cji_producto` (`PROD_Codigo`),
  ADD KEY `FK_cji_garantia_cji_comprobante` (`CPP_Codigo`);

--
-- Indexes for table `cji_guiain`
--
ALTER TABLE `cji_guiain`
  ADD PRIMARY KEY (`GUIAINP_Codigo`),
  ADD KEY `fk_almacen` (`ALMAP_Codigo`),
  ADD KEY `fk_usuario` (`USUA_Codigo`),
  ADD KEY `fk_cji_guiain_cji_tipomovimiento1` (`TIPOMOVP_Codigo`),
  ADD KEY `FK_cji_guiain_cji_ordencompra` (`OCOMP_Codigo`),
  ADD KEY `FK_cji_guiain_cji_proveedor` (`PROVP_Codigo`),
  ADD KEY `DOCUP_Codigo` (`DOCUP_Codigo`);

--
-- Indexes for table `cji_guiaindetalle`
--
ALTER TABLE `cji_guiaindetalle`
  ADD PRIMARY KEY (`GUIAINDETP_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_cji_guiain1` (`GUIAINP_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_cji_producto` (`PRODCTOP_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_cji_unidadmedida` (`UNDMED_Codigo`);

--
-- Indexes for table `cji_guiarem`
--
ALTER TABLE `cji_guiarem`
  ADD PRIMARY KEY (`GUIAREMP_Codigo`),
  ADD KEY `index2` (`ALMAP_Codigo`),
  ADD KEY `fk_usuario` (`USUA_Codigo`),
  ADD KEY `fk_cji_guiain_cji_tipomovimiento1` (`TIPOMOVP_Codigo`),
  ADD KEY `fk_cji_guiain_cji_documento1` (`DOCUP_Codigo`),
  ADD KEY `fk_cji_guiarem_cji_cliente1` (`CLIP_Codigo`),
  ADD KEY `fk_cji_guiarem_cji_guiasa` (`GUIASAP_Codigo`),
  ADD KEY `EMPRP_Codigo` (`EMPRP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `MONED_Codigo` (`MONED_Codigo`),
  ADD KEY `PRESUP_Codigo` (`PRESUP_Codigo`),
  ADD KEY `PROVP_Codigo` (`PROVP_Codigo`),
  ADD KEY `GUIAINP_Codigo` (`GUIAINP_Codigo`),
  ADD KEY `OCOMP_Codigo` (`OCOMP_Codigo`);

--
-- Indexes for table `cji_guiaremdetalle`
--
ALTER TABLE `cji_guiaremdetalle`
  ADD PRIMARY KEY (`GUIAREMDETP_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_cji_producto` (`PRODCTOP_Codigo`),
  ADD KEY `fk_cji_unidadmedida` (`UNDMED_Codigo`),
  ADD KEY `fk_cji_guiaremdetalle_cji_guiarem1` (`GUIAREMP_Codigo`);

--
-- Indexes for table `cji_guiasa`
--
ALTER TABLE `cji_guiasa`
  ADD PRIMARY KEY (`GUIASAP_Codigo`),
  ADD KEY `index2` (`ALMAP_Codigo`),
  ADD KEY `fk_usuario` (`USUA_Codigo`),
  ADD KEY `fk_cji_guiain_cji_tipomovimiento1` (`TIPOMOVP_Codigo`),
  ADD KEY `fk_cji_guiasa_cji_cliente1` (`CLIP_Codigo`),
  ADD KEY `DOCUP_Codigo` (`DOCUP_Codigo`);

--
-- Indexes for table `cji_guiasadetalle`
--
ALTER TABLE `cji_guiasadetalle`
  ADD PRIMARY KEY (`GUIASADETP_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_cji_producto` (`PRODCTOP_Codigo`),
  ADD KEY `fk_cji_unidadmedida` (`UNDMED_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_copy1_cji_guiasa1` (`GUIASAP_Codigo`);

--
-- Indexes for table `cji_guiatrans`
--
ALTER TABLE `cji_guiatrans`
  ADD PRIMARY KEY (`GTRANP_Codigo`);

--
-- Indexes for table `cji_guiatransdetalle`
--
ALTER TABLE `cji_guiatransdetalle`
  ADD PRIMARY KEY (`GTRANDETP_Codigo`);

--
-- Indexes for table `cji_importacion`
--
ALTER TABLE `cji_importacion`
  ADD PRIMARY KEY (`IMPOR_Codigo`);

--
-- Indexes for table `cji_importaciondetalle`
--
ALTER TABLE `cji_importaciondetalle`
  ADD PRIMARY KEY (`IMPORDEP_Codigo`);

--
-- Indexes for table `cji_inventario`
--
ALTER TABLE `cji_inventario`
  ADD PRIMARY KEY (`INVE_Codigo`);

--
-- Indexes for table `cji_inventarioajuste`
--
ALTER TABLE `cji_inventarioajuste`
  ADD PRIMARY KEY (`INVA_Codigo`);

--
-- Indexes for table `cji_inventarioajustedetalle`
--
ALTER TABLE `cji_inventarioajustedetalle`
  ADD PRIMARY KEY (`INVADET_Codigo`);

--
-- Indexes for table `cji_inventarioajusteresp`
--
ALTER TABLE `cji_inventarioajusteresp`
  ADD PRIMARY KEY (`INVAR_Codigo`);

--
-- Indexes for table `cji_inventariodetalle`
--
ALTER TABLE `cji_inventariodetalle`
  ADD PRIMARY KEY (`INVD_Codigo`);

--
-- Indexes for table `cji_inventarioresp`
--
ALTER TABLE `cji_inventarioresp`
  ADD PRIMARY KEY (`INVAR_Codigo`);

--
-- Indexes for table `cji_item`
--
ALTER TABLE `cji_item`
  ADD PRIMARY KEY (`ITEM_Codigo`);

--
-- Indexes for table `cji_kardex`
--
ALTER TABLE `cji_kardex`
  ADD PRIMARY KEY (`KARDP_Codigo`),
  ADD KEY `FK_cji_kardex_cji_producto` (`PROD_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `fk_cji_kardex_cji_documento1` (`DOCUP_Codigo`),
  ADD KEY `fk_cji_kardex_cji_tipomovimiento1` (`TIPOMOVP_Codigo`),
  ADD KEY `fk_cji_kardex_cji_lote` (`LOTP_Codigo`);

--
-- Indexes for table `cji_letra`
--
ALTER TABLE `cji_letra`
  ADD PRIMARY KEY (`LET_Codigo`),
  ADD KEY `FK_cji_letra_cji_proveedor` (`PROVP_Codigo`),
  ADD KEY `FK_cji_letra_cji_directivo` (`LET_Vendedor`),
  ADD KEY `FK_cji_letra_cji_cliente` (`CLIP_Codigo`),
  ADD KEY `FK_cji_letra_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_letra_cji_formapago` (`FORPAP_Codigo`),
  ADD KEY `FK_cji_letra_cji_moneda` (`MONED_Codigo`),
  ADD KEY `FK_cji_letra_cji_usuario` (`USUA_Codigo`);

--
-- Indexes for table `cji_linea`
--
ALTER TABLE `cji_linea`
  ADD PRIMARY KEY (`LINP_Codigo`);

--
-- Indexes for table `cji_log`
--
ALTER TABLE `cji_log`
  ADD PRIMARY KEY (`LOGP_Codigo`);

--
-- Indexes for table `cji_lote`
--
ALTER TABLE `cji_lote`
  ADD PRIMARY KEY (`LOTP_Codigo`),
  ADD KEY `fk_cji_lote_cji_producto1` (`PROD_Codigo`),
  ADD KEY `GUIAINP_Codigo` (`GUIAINP_Codigo`);

--
-- Indexes for table `cji_loteprorrateo`
--
ALTER TABLE `cji_loteprorrateo`
  ADD PRIMARY KEY (`LOTPROP_Codigo`),
  ADD KEY `LOTP_Codigo` (`LOTP_Codigo`);

--
-- Indexes for table `cji_marca`
--
ALTER TABLE `cji_marca`
  ADD PRIMARY KEY (`MARCP_Codigo`);

--
-- Indexes for table `cji_menu`
--
ALTER TABLE `cji_menu`
  ADD PRIMARY KEY (`MENU_Codigo`);

--
-- Indexes for table `cji_moneda`
--
ALTER TABLE `cji_moneda`
  ADD PRIMARY KEY (`MONED_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `MONED_smallName` (`MONED_smallName`);

--
-- Indexes for table `cji_nacionalidad`
--
ALTER TABLE `cji_nacionalidad`
  ADD PRIMARY KEY (`NACP_Codigo`);

--
-- Indexes for table `cji_nota`
--
ALTER TABLE `cji_nota`
  ADD PRIMARY KEY (`CRED_Codigo`),
  ADD KEY `FK_cji_credito_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_credito_cji_cliente` (`CLIP_Codigo`),
  ADD KEY `FK_cji_credito_cji_usuario` (`USUA_Codigo`),
  ADD KEY `FK_cji_credito_cji_moneda` (`MONED_Codigo`),
  ADD KEY `FK_cji_credito_proveedor` (`PROVP_Codigo`),
  ADD KEY `CRED_Vendedor` (`CRED_Vendedor`);

--
-- Indexes for table `cji_notadetalle`
--
ALTER TABLE `cji_notadetalle`
  ADD PRIMARY KEY (`CREDET_Codigo`),
  ADD KEY `FK_Reference_64` (`PROD_Codigo`),
  ADD KEY `FK_cji_facturadetalle_cji_unidadmedida` (`UNDMED_Codigo`),
  ADD KEY `CRED_Codigo` (`CRED_Codigo`);

--
-- Indexes for table `cji_ocompradetalle`
--
ALTER TABLE `cji_ocompradetalle`
  ADD PRIMARY KEY (`OCOMDEP_Codigo`),
  ADD KEY `FK_Reference_52` (`OCOMP_Codigo`),
  ADD KEY `FK_Reference_53` (`PROD_Codigo`),
  ADD KEY `FK_cji_ocompradetalle_cji_unidadmedida` (`UNDMED_Codigo`);

--
-- Indexes for table `cji_ocompra_importacion`
--
ALTER TABLE `cji_ocompra_importacion`
  ADD PRIMARY KEY (`OCOMP_Codigo`,`IMPOR_Codigo`);

--
-- Indexes for table `cji_ordencompra`
--
ALTER TABLE `cji_ordencompra`
  ADD PRIMARY KEY (`OCOMP_Codigo`),
  ADD KEY `FK_Reference_40` (`COTIP_Codigo`),
  ADD KEY `FK_Reference_47` (`PROVP_Codigo`),
  ADD KEY `FK_Reference_48` (`USUA_Codigo`),
  ADD KEY `FK_Reference_50` (`CENCOSP_Codigo`),
  ADD KEY `FK_Reference_54` (`MONED_Codigo`),
  ADD KEY `FK_cji_ordencompra_cji_ordencompra` (`COMPP_Codigo`),
  ADD KEY `FORPAP_Codigo` (`FORPAP_Codigo`),
  ADD KEY `ALMAP_Codigo` (`ALMAP_Codigo`),
  ADD KEY `FK_cji_ordencompra_pedido` (`PEDIP_Codigo`),
  ADD KEY `OCOMC_Comprador` (`OCOMC_MiPersonal`),
  ADD KEY `OCOMC_Personal` (`OCOMC_Personal`),
  ADD KEY `GUIASAP_Codigo` (`GUIASAP_Codigo`);

--
-- Indexes for table `cji_pago`
--
ALTER TABLE `cji_pago`
  ADD PRIMARY KEY (`PAGP_Codigo`),
  ADD KEY `cuenta_cliente` (`CUENT_CodigoCP`),
  ADD KEY `mi cuenta bancaria` (`CUENT_CodigoEmpresa`);

--
-- Indexes for table `cji_pedido`
--
ALTER TABLE `cji_pedido`
  ADD PRIMARY KEY (`PEDIP_Codigo`),
  ADD KEY `FK_cji_pedido_cji_compania` (`COMPP_Codigo`);

--
-- Indexes for table `cji_pedidodetalle`
--
ALTER TABLE `cji_pedidodetalle`
  ADD PRIMARY KEY (`PEDIDETP_Codigo`,`PEDIP_Codigo`,`PROD_Codigo`),
  ADD KEY `FK_Reference_37` (`PEDIP_Codigo`),
  ADD KEY `FK_Reference_38` (`PROD_Codigo`),
  ADD KEY `FK_cji_pedidodetalle_cji_unidadmedida` (`UNDMED_Codigo`);

--
-- Indexes for table `cji_permiso`
--
ALTER TABLE `cji_permiso`
  ADD PRIMARY KEY (`PERM_Codigo`),
  ADD KEY `FK_cji_permiso_cji_menu` (`MENU_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `ROL_Codigo_MENU_Codigo` (`ROL_Codigo`,`MENU_Codigo`) USING BTREE;

--
-- Indexes for table `cji_persona`
--
ALTER TABLE `cji_persona`
  ADD PRIMARY KEY (`PERSP_Codigo`),
  ADD KEY `fk_CJ_PERSONA_CJ_UBIGEO` (`UBIGP_LugarNacimiento`),
  ADD KEY `fk_CJ_PERSONA_CJ_UBIGEO1` (`UBIGP_Domicilio`),
  ADD KEY `fk_CJ_PERSONA_CJ_ESTADOCIVIL1` (`ESTCP_EstadoCivil`),
  ADD KEY `fk_CJ_PERSONA_CJ_NACIONALIDAD1` (`NACP_Nacionalidad`),
  ADD KEY `FK_cji_persona_cji_tipdocumento` (`PERSC_TipoDocIdentidad`),
  ADD KEY `banco` (`BANP_Codigo`);
ALTER TABLE `cji_persona` ADD FULLTEXT KEY `cji_persona_search` (`PERSC_Nombre`,`PERSC_ApellidoPaterno`,`PERSC_ApellidoMaterno`);

--
-- Indexes for table `cji_plantilla`
--
ALTER TABLE `cji_plantilla`
  ADD PRIMARY KEY (`PLANT_Codigo`),
  ADD UNIQUE KEY `ATRIB_Codigo_TIPPROD_Codigo` (`ATRIB_Codigo`,`TIPPROD_Codigo`),
  ADD KEY `FK_cji_plantilla_cji_tipoproducto` (`TIPPROD_Codigo`);

--
-- Indexes for table `cji_prestamo`
--
ALTER TABLE `cji_prestamo`
  ADD PRIMARY KEY (`PRES_Codigo`);

--
-- Indexes for table `cji_presupuesto`
--
ALTER TABLE `cji_presupuesto`
  ADD PRIMARY KEY (`PRESUP_Codigo`),
  ADD KEY `FK_cji_factura_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_factura_cji_cliente` (`CLIP_Codigo`),
  ADD KEY `FK_cji_factura_cji_usuario` (`USUA_Codigo`),
  ADD KEY `FK_cji_factura_cji_moneda` (`MONED_Codigo`),
  ADD KEY `FK_cji_factura_cji_formapago` (`FORPAP_Codigo`),
  ADD KEY `PERSP_Codigo` (`PERSP_Codigo`),
  ADD KEY `AREAP_Codigo` (`AREAP_Codigo`),
  ADD KEY `PRESUC_VenedorArea` (`PRESUC_VenedorArea`),
  ADD KEY `PRESUC_VendedorPersona` (`PRESUC_VendedorPersona`);

--
-- Indexes for table `cji_presupuestodetalle`
--
ALTER TABLE `cji_presupuestodetalle`
  ADD PRIMARY KEY (`PRESDEP_Codigo`),
  ADD KEY `FK_cji_presupuestodetalle_presu` (`PRESUP_Codigo`),
  ADD KEY `FK_cji_presupuestodetalle_prod` (`PROD_Codigo`),
  ADD KEY `FK_cji_presupuestodetalle_unidad` (`UNDMED_Codigo`);

--
-- Indexes for table `cji_procedencia`
--
ALTER TABLE `cji_procedencia`
  ADD PRIMARY KEY (`PROP_Codigo`);

--
-- Indexes for table `cji_produccion`
--
ALTER TABLE `cji_produccion`
  ADD PRIMARY KEY (`PR_Codigo`);

--
-- Indexes for table `cji_producciondetalle`
--
ALTER TABLE `cji_producciondetalle`
  ADD PRIMARY KEY (`PRD_Codigo`);

--
-- Indexes for table `cji_producto`
--
ALTER TABLE `cji_producto`
  ADD PRIMARY KEY (`PROD_Codigo`),
  ADD KEY `FK_cji_producto_cji_familia` (`FAMI_Codigo`),
  ADD KEY `FK_cji_producto_cji_tipoproducto` (`TIPPROD_Codigo`),
  ADD KEY `MARCP_Codigo` (`MARCP_Codigo`),
  ADD KEY `LINP_Codigo` (`LINP_Codigo`),
  ADD KEY `FABRIP_Codigo` (`FABRIP_Codigo`),
  ADD KEY `PROD_PadreCodigo` (`PROD_PadreCodigo`),
  ADD KEY `PROD_PartidaArancelaria` (`PROD_PartidaArancelaria`);
ALTER TABLE `cji_producto` ADD FULLTEXT KEY `PROD_CodigoUsuario` (`PROD_Nombre`,`PROD_CodigoUsuario`);

--
-- Indexes for table `cji_productoatributo`
--
ALTER TABLE `cji_productoatributo`
  ADD PRIMARY KEY (`PRODATRIB_Codigo`),
  ADD KEY `FK_cji_productoatributo_cji_producto` (`PROD_Codigo`),
  ADD KEY `FK_cji_productoatributo_cji_atributo` (`ATRIB_Codigo`);

--
-- Indexes for table `cji_productoprecio`
--
ALTER TABLE `cji_productoprecio`
  ADD PRIMARY KEY (`PRODPREP_Codigo`),
  ADD UNIQUE KEY `PROD_Codigo` (`PROD_Codigo`,`TIPCLIP_Codigo`,`EESTABP_Codigo`,`MONED_Codigo`,`PRODUNIP_Codigo`),
  ADD KEY `FK_cji_productoprecio_tipocliente` (`TIPCLIP_Codigo`),
  ADD KEY `FK_cji_productoprecio_empresaestableci` (`EESTABP_Codigo`),
  ADD KEY `FK_cji_productoprecio_moneda` (`MONED_Codigo`),
  ADD KEY `FK_cji_productoprecio_produni` (`PRODUNIP_Codigo`);

--
-- Indexes for table `cji_productoproveedor`
--
ALTER TABLE `cji_productoproveedor`
  ADD PRIMARY KEY (`PRODPROVP_Codigo`),
  ADD KEY `fk_cji_productoproveedor_cji_producto1` (`PROD_Codigo`),
  ADD KEY `fk_cji_productoproveedor_cji_proveedor1` (`PROVP_Codigo`);

--
-- Indexes for table `cji_productopublicacion`
--
ALTER TABLE `cji_productopublicacion`
  ADD PRIMARY KEY (`PRODPUBP_Codigo`);

--
-- Indexes for table `cji_productounidad`
--
ALTER TABLE `cji_productounidad`
  ADD PRIMARY KEY (`PRODUNIP_Codigo`),
  ADD KEY `FK_Reference_61` (`UNDMED_Codigo`),
  ADD KEY `PROD_Codigo` (`PROD_Codigo`,`PRODUNIC_Factor`) USING BTREE;

--
-- Indexes for table `cji_proveedor`
--
ALTER TABLE `cji_proveedor`
  ADD PRIMARY KEY (`PROVP_Codigo`),
  ADD KEY `fk_CJ_PROVEEDOR_CJ_PERSONA1` (`PERSP_Codigo`),
  ADD KEY `fk_CJ_PROVEEDOR_CJ_EMPRESA1` (`EMPRP_Codigo`);

--
-- Indexes for table `cji_proveedorcompania`
--
ALTER TABLE `cji_proveedorcompania`
  ADD PRIMARY KEY (`PROVP_Codigo`,`COMPP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indexes for table `cji_proveedormarca`
--
ALTER TABLE `cji_proveedormarca`
  ADD PRIMARY KEY (`EMPMARP_Codigo`);

--
-- Indexes for table `cji_proyecto`
--
ALTER TABLE `cji_proyecto`
  ADD PRIMARY KEY (`PROYP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `DIREP_Codigo` (`DIREP_Codigo`),
  ADD KEY `PROYC_CodigoUsuario` (`PROYC_CodigoUsuario`),
  ADD KEY `DIRECC_Codigo` (`DIRECC_Codigo`);

--
-- Indexes for table `cji_recepcionproveedor`
--
ALTER TABLE `cji_recepcionproveedor`
  ADD PRIMARY KEY (`RECEPRO_Codigo`),
  ADD KEY `FK_cji_recepcionproveedor_cji_garantia` (`GARAN_Codigo`),
  ADD KEY `FK_cji_recepcionproveedor_cji_empresa` (`EMPRP_Codigo`),
  ADD KEY `FK_cji_recepcionproveedor_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_garantia_cji_proveedor` (`PROVP_Codigo`);

--
-- Indexes for table `cji_receta`
--
ALTER TABLE `cji_receta`
  ADD PRIMARY KEY (`REC_Codigo`),
  ADD UNIQUE KEY `PROD_Codigo` (`PROD_Codigo`);

--
-- Indexes for table `cji_recetadetalle`
--
ALTER TABLE `cji_recetadetalle`
  ADD PRIMARY KEY (`RECDET_Codigo`);

--
-- Indexes for table `cji_reponsblmoviminto`
--
ALTER TABLE `cji_reponsblmoviminto`
  ADD PRIMARY KEY (`RESPNMOV_Codigo`);

--
-- Indexes for table `cji_respuestasunat`
--
ALTER TABLE `cji_respuestasunat`
  ADD PRIMARY KEY (`respuestas_codigo`);

--
-- Indexes for table `cji_rol`
--
ALTER TABLE `cji_rol`
  ADD PRIMARY KEY (`ROL_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indexes for table `cji_sectorcomercial`
--
ALTER TABLE `cji_sectorcomercial`
  ADD PRIMARY KEY (`SECCOMP_Codigo`);

--
-- Indexes for table `cji_serie`
--
ALTER TABLE `cji_serie`
  ADD PRIMARY KEY (`SERIP_Codigo`),
  ADD KEY `fk_cji_serie_cji_producto1` (`PROD_Codigo`);

--
-- Indexes for table `cji_seriedocumento`
--
ALTER TABLE `cji_seriedocumento`
  ADD PRIMARY KEY (`SERDOC_Codigo`);

--
-- Indexes for table `cji_seriemov`
--
ALTER TABLE `cji_seriemov`
  ADD PRIMARY KEY (`SERMOVP_Codigo`),
  ADD KEY `SERIP_Codigo` (`SERIP_Codigo`),
  ADD KEY `GUIAINP_Codigo` (`GUIAINP_Codigo`),
  ADD KEY `GUIASAP_Codigo` (`GUIASAP_Codigo`);

--
-- Indexes for table `cji_servicio`
--
ALTER TABLE `cji_servicio`
  ADD PRIMARY KEY (`SERV_Codigo`);

--
-- Indexes for table `cji_terminal`
--
ALTER TABLE `cji_terminal`
  ADD PRIMARY KEY (`TERMINAL_Codigo`);

--
-- Indexes for table `cji_tipdocumento`
--
ALTER TABLE `cji_tipdocumento`
  ADD PRIMARY KEY (`TIPDOCP_Codigo`);

--
-- Indexes for table `cji_tipoalmacen`
--
ALTER TABLE `cji_tipoalmacen`
  ADD PRIMARY KEY (`TIPALMP_Codigo`);

--
-- Indexes for table `cji_tipocaja`
--
ALTER TABLE `cji_tipocaja`
  ADD PRIMARY KEY (`tipCa_codigo`);

--
-- Indexes for table `cji_tipocambio`
--
ALTER TABLE `cji_tipocambio`
  ADD PRIMARY KEY (`TIPCAMP_Codigo`),
  ADD KEY `FK_cji_tipocambio_moneda1` (`TIPCAMC_MonedaOrigen`),
  ADD KEY `FK_cji_tipocambio_conmpania` (`COMPP_Codigo`);

--
-- Indexes for table `cji_tipocliente`
--
ALTER TABLE `cji_tipocliente`
  ADD PRIMARY KEY (`TIPCLIP_Codigo`),
  ADD KEY `FK_cji_tipocliente_compania` (`COMPP_Codigo`);

--
-- Indexes for table `cji_tipocodigo`
--
ALTER TABLE `cji_tipocodigo`
  ADD PRIMARY KEY (`TIPCOD_Codigo`);

--
-- Indexes for table `cji_tipoestablecimiento`
--
ALTER TABLE `cji_tipoestablecimiento`
  ADD PRIMARY KEY (`TESTP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indexes for table `cji_tipomovimiento`
--
ALTER TABLE `cji_tipomovimiento`
  ADD PRIMARY KEY (`TIPOMOVP_Codigo`);

--
-- Indexes for table `cji_tipoproducto`
--
ALTER TABLE `cji_tipoproducto`
  ADD PRIMARY KEY (`TIPPROD_Codigo`);

--
-- Indexes for table `cji_tipoproveedor`
--
ALTER TABLE `cji_tipoproveedor`
  ADD PRIMARY KEY (`FAMI_Codigo`);

--
-- Indexes for table `cji_tipo_afectacion`
--
ALTER TABLE `cji_tipo_afectacion`
  ADD PRIMARY KEY (`AFECT_Codigo`);

--
-- Indexes for table `cji_ubigeo`
--
ALTER TABLE `cji_ubigeo`
  ADD PRIMARY KEY (`UBIGP_Codigo`);
ALTER TABLE `cji_ubigeo` ADD FULLTEXT KEY `search` (`UBIGC_Descripcion`,`UBIGC_DescripcionProv`,`UBIGC_DescripcionDpto`);

--
-- Indexes for table `cji_unidadmedida`
--
ALTER TABLE `cji_unidadmedida`
  ADD PRIMARY KEY (`UNDMED_Codigo`);

--
-- Indexes for table `cji_usuario`
--
ALTER TABLE `cji_usuario`
  ADD PRIMARY KEY (`USUA_Codigo`),
  ADD KEY `FK_cji_usuario_cji_persona` (`PERSP_Codigo`),
  ADD KEY `FK_cji_usuario_cji_rol` (`ROL_Codigo`);

--
-- Indexes for table `cji_usuario_compania`
--
ALTER TABLE `cji_usuario_compania`
  ADD PRIMARY KEY (`USUCOMP_Codigo`),
  ADD KEY `USUA_Codigo` (`USUA_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `ROL_Codigo` (`ROL_Codigo`),
  ADD KEY `CARGP_Codigo` (`CARGP_Codigo`);

--
-- Indexes for table `cji_usuario_terminal`
--
ALTER TABLE `cji_usuario_terminal`
  ADD PRIMARY KEY (`USUTERMINAL_Codigo`);

--
-- Indexes for table `comprobantes_cuotas`
--
ALTER TABLE `comprobantes_cuotas`
  ADD PRIMARY KEY (`CUOT_Codigo`),
  ADD KEY `Caja` (`CAJA_Codigo`);

--
-- Indexes for table `comprobantes_cuotas_notas`
--
ALTER TABLE `comprobantes_cuotas_notas`
  ADD PRIMARY KEY (`CUOT_Codigo`);

--
-- Indexes for table `detraccion_tipo`
--
ALTER TABLE `detraccion_tipo`
  ADD PRIMARY KEY (`DTT_Codigo`);

--
-- Indexes for table `impactousuario`
--
ALTER TABLE `impactousuario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `impacto_documento`
--
ALTER TABLE `impacto_documento`
  ADD PRIMARY KEY (`IMPDOC_Codigo`);

--
-- Indexes for table `impacto_publicacion`
--
ALTER TABLE `impacto_publicacion`
  ADD PRIMARY KEY (`IMPPUB_Codigo`);

--
-- Indexes for table `medio_de_pago_detraccion`
--
ALTER TABLE `medio_de_pago_detraccion`
  ADD PRIMARY KEY (`MDP_Codigo`);

--
-- Indexes for table `sunat_transaction`
--
ALTER TABLE `sunat_transaction`
  ADD PRIMARY KEY (`TXP_Codigo`);

--
-- Indexes for table `temporal_detalle`
--
ALTER TABLE `temporal_detalle`
  ADD PRIMARY KEY (`TEMPDE_Codigo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cji_almacen`
--
ALTER TABLE `cji_almacen`
  MODIFY `ALMAP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cji_almacenproducto`
--
ALTER TABLE `cji_almacenproducto`
  MODIFY `ALMPROD_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cji_almacenproductoserie`
--
ALTER TABLE `cji_almacenproductoserie`
  MODIFY `ALMPRODSERP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_almaprolote`
--
ALTER TABLE `cji_almaprolote`
  MODIFY `ALMALOTP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_area`
--
ALTER TABLE `cji_area`
  MODIFY `AREAP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cji_atributo`
--
ALTER TABLE `cji_atributo`
  MODIFY `ATRIB_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cji_banco`
--
ALTER TABLE `cji_banco`
  MODIFY `BANP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cji_bancocta`
--
ALTER TABLE `cji_bancocta`
  MODIFY `CTAP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_caja`
--
ALTER TABLE `cji_caja`
  MODIFY `CAJA_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_cajamovimiento`
--
ALTER TABLE `cji_cajamovimiento`
  MODIFY `CAJAMOV_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cji_caja_chekera`
--
ALTER TABLE `cji_caja_chekera`
  MODIFY `CAJCHEK_Codigo` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_caja_cuenta`
--
ALTER TABLE `cji_caja_cuenta`
  MODIFY `CAJCUENT_Codigo` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_cargo`
--
ALTER TABLE `cji_cargo`
  MODIFY `CARGP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cji_categoriapublicacion`
--
ALTER TABLE `cji_categoriapublicacion`
  MODIFY `CATPUBP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_centrocosto`
--
ALTER TABLE `cji_centrocosto`
  MODIFY `CENCOSP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cji_chekera`
--
ALTER TABLE `cji_chekera`
  MODIFY `CHEK_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_cheque`
--
ALTER TABLE `cji_cheque`
  MODIFY `CHEP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_cliente`
--
ALTER TABLE `cji_cliente`
  MODIFY `CLIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cji_compadocumenitem`
--
ALTER TABLE `cji_compadocumenitem`
  MODIFY `COMPADOCUITEM_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `cji_compania`
--
ALTER TABLE `cji_compania`
  MODIFY `COMPP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cji_companiaconfidocumento`
--
ALTER TABLE `cji_companiaconfidocumento`
  MODIFY `COMPCONFIDOCP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `cji_companiaconfiguracion`
--
ALTER TABLE `cji_companiaconfiguracion`
  MODIFY `COMPCONFIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cji_comparativo`
--
ALTER TABLE `cji_comparativo`
  MODIFY `COMP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_comparativodetalle`
--
ALTER TABLE `cji_comparativodetalle`
  MODIFY `CUACOMP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_comprobante`
--
ALTER TABLE `cji_comprobante`
  MODIFY `CPP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cji_comprobantedetalle`
--
ALTER TABLE `cji_comprobantedetalle`
  MODIFY `CPDEP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cji_comprobante_formaspago`
--
ALTER TABLE `cji_comprobante_formaspago`
  MODIFY `idcji_compro_forPa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cji_comprobante_guiarem`
--
ALTER TABLE `cji_comprobante_guiarem`
  MODIFY `COMPGUI_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cji_comprobante_letra`
--
ALTER TABLE `cji_comprobante_letra`
  MODIFY `CPLET_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_condicionentrega`
--
ALTER TABLE `cji_condicionentrega`
  MODIFY `CONENP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_configuracion`
--
ALTER TABLE `cji_configuracion`
  MODIFY `CONFIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `cji_correlativo`
--
ALTER TABLE `cji_correlativo`
  MODIFY `CORRP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cji_correoenviar`
--
ALTER TABLE `cji_correoenviar`
  MODIFY `CE_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_cotizacion`
--
ALTER TABLE `cji_cotizacion`
  MODIFY `COTIP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_cotizaciondetalle`
--
ALTER TABLE `cji_cotizaciondetalle`
  MODIFY `COTDEP_Codigo` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_cuentacontable`
--
ALTER TABLE `cji_cuentacontable`
  MODIFY `CUNTCONTBL_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cji_cuentas`
--
ALTER TABLE `cji_cuentas`
  MODIFY `CUE_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_cuentasempresas`
--
ALTER TABLE `cji_cuentasempresas`
  MODIFY `CUENT_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_cuentaspago`
--
ALTER TABLE `cji_cuentaspago`
  MODIFY `CPAGP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_despacho`
--
ALTER TABLE `cji_despacho`
  MODIFY `DESP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_despachodetalle`
--
ALTER TABLE `cji_despachodetalle`
  MODIFY `DESPD_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_direccion`
--
ALTER TABLE `cji_direccion`
  MODIFY `DIRECC_Codigo` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_directivo`
--
ALTER TABLE `cji_directivo`
  MODIFY `DIREP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cji_documento`
--
ALTER TABLE `cji_documento`
  MODIFY `DOCUP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cji_documentoitem`
--
ALTER TABLE `cji_documentoitem`
  MODIFY `DOCUITEM_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- AUTO_INCREMENT for table `cji_documentosentenica`
--
ALTER TABLE `cji_documentosentenica`
  MODIFY `DOCSENT_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2707;

--
-- AUTO_INCREMENT for table `cji_emprarea`
--
ALTER TABLE `cji_emprarea`
  MODIFY `EAREAP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_emprcontacto`
--
ALTER TABLE `cji_emprcontacto`
  MODIFY `ECONP_Contacto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_empresa`
--
ALTER TABLE `cji_empresa`
  MODIFY `EMPRP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cji_empresatipoproveedor`
--
ALTER TABLE `cji_empresatipoproveedor`
  MODIFY `EMPTIPOP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_emprestablecimiento`
--
ALTER TABLE `cji_emprestablecimiento`
  MODIFY `EESTABP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cji_entregacliente`
--
ALTER TABLE `cji_entregacliente`
  MODIFY `ENTRECLI_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_envioproveedor`
--
ALTER TABLE `cji_envioproveedor`
  MODIFY `ENVIPRO_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_estadocivil`
--
ALTER TABLE `cji_estadocivil`
  MODIFY `ESTCP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cji_fabricante`
--
ALTER TABLE `cji_fabricante`
  MODIFY `FABRIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cji_familia`
--
ALTER TABLE `cji_familia`
  MODIFY `FAMI_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_flujocaja`
--
ALTER TABLE `cji_flujocaja`
  MODIFY `FLUCAJ_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_formapago`
--
ALTER TABLE `cji_formapago`
  MODIFY `FORPAP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cji_garantia`
--
ALTER TABLE `cji_garantia`
  MODIFY `GARAN_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_guiain`
--
ALTER TABLE `cji_guiain`
  MODIFY `GUIAINP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_guiaindetalle`
--
ALTER TABLE `cji_guiaindetalle`
  MODIFY `GUIAINDETP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_guiarem`
--
ALTER TABLE `cji_guiarem`
  MODIFY `GUIAREMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cji_guiaremdetalle`
--
ALTER TABLE `cji_guiaremdetalle`
  MODIFY `GUIAREMDETP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cji_guiasa`
--
ALTER TABLE `cji_guiasa`
  MODIFY `GUIASAP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_guiasadetalle`
--
ALTER TABLE `cji_guiasadetalle`
  MODIFY `GUIASADETP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_guiatrans`
--
ALTER TABLE `cji_guiatrans`
  MODIFY `GTRANP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_guiatransdetalle`
--
ALTER TABLE `cji_guiatransdetalle`
  MODIFY `GTRANDETP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_importacion`
--
ALTER TABLE `cji_importacion`
  MODIFY `IMPOR_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_importaciondetalle`
--
ALTER TABLE `cji_importaciondetalle`
  MODIFY `IMPORDEP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_inventario`
--
ALTER TABLE `cji_inventario`
  MODIFY `INVE_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `cji_inventarioajuste`
--
ALTER TABLE `cji_inventarioajuste`
  MODIFY `INVA_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cji_inventarioajustedetalle`
--
ALTER TABLE `cji_inventarioajustedetalle`
  MODIFY `INVADET_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cji_inventarioajusteresp`
--
ALTER TABLE `cji_inventarioajusteresp`
  MODIFY `INVAR_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `cji_inventariodetalle`
--
ALTER TABLE `cji_inventariodetalle`
  MODIFY `INVD_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `cji_inventarioresp`
--
ALTER TABLE `cji_inventarioresp`
  MODIFY `INVAR_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `cji_item`
--
ALTER TABLE `cji_item`
  MODIFY `ITEM_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cji_kardex`
--
ALTER TABLE `cji_kardex`
  MODIFY `KARDP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `cji_letra`
--
ALTER TABLE `cji_letra`
  MODIFY `LET_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_linea`
--
ALTER TABLE `cji_linea`
  MODIFY `LINP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cji_log`
--
ALTER TABLE `cji_log`
  MODIFY `LOGP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_lote`
--
ALTER TABLE `cji_lote`
  MODIFY `LOTP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_loteprorrateo`
--
ALTER TABLE `cji_loteprorrateo`
  MODIFY `LOTPROP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_marca`
--
ALTER TABLE `cji_marca`
  MODIFY `MARCP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_menu`
--
ALTER TABLE `cji_menu`
  MODIFY `MENU_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `cji_moneda`
--
ALTER TABLE `cji_moneda`
  MODIFY `MONED_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cji_nacionalidad`
--
ALTER TABLE `cji_nacionalidad`
  MODIFY `NACP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `cji_nota`
--
ALTER TABLE `cji_nota`
  MODIFY `CRED_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cji_notadetalle`
--
ALTER TABLE `cji_notadetalle`
  MODIFY `CREDET_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cji_ocompradetalle`
--
ALTER TABLE `cji_ocompradetalle`
  MODIFY `OCOMDEP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cji_ordencompra`
--
ALTER TABLE `cji_ordencompra`
  MODIFY `OCOMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cji_pago`
--
ALTER TABLE `cji_pago`
  MODIFY `PAGP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_pedido`
--
ALTER TABLE `cji_pedido`
  MODIFY `PEDIP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_pedidodetalle`
--
ALTER TABLE `cji_pedidodetalle`
  MODIFY `PEDIDETP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_permiso`
--
ALTER TABLE `cji_permiso`
  MODIFY `PERM_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1418;

--
-- AUTO_INCREMENT for table `cji_persona`
--
ALTER TABLE `cji_persona`
  MODIFY `PERSP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cji_plantilla`
--
ALTER TABLE `cji_plantilla`
  MODIFY `PLANT_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_prestamo`
--
ALTER TABLE `cji_prestamo`
  MODIFY `PRES_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_presupuesto`
--
ALTER TABLE `cji_presupuesto`
  MODIFY `PRESUP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_presupuestodetalle`
--
ALTER TABLE `cji_presupuestodetalle`
  MODIFY `PRESDEP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_procedencia`
--
ALTER TABLE `cji_procedencia`
  MODIFY `PROP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_produccion`
--
ALTER TABLE `cji_produccion`
  MODIFY `PR_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_producciondetalle`
--
ALTER TABLE `cji_producciondetalle`
  MODIFY `PRD_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_producto`
--
ALTER TABLE `cji_producto`
  MODIFY `PROD_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cji_productoatributo`
--
ALTER TABLE `cji_productoatributo`
  MODIFY `PRODATRIB_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_productoprecio`
--
ALTER TABLE `cji_productoprecio`
  MODIFY `PRODPREP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cji_productoproveedor`
--
ALTER TABLE `cji_productoproveedor`
  MODIFY `PRODPROVP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_productopublicacion`
--
ALTER TABLE `cji_productopublicacion`
  MODIFY `PRODPUBP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_productounidad`
--
ALTER TABLE `cji_productounidad`
  MODIFY `PRODUNIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cji_proveedor`
--
ALTER TABLE `cji_proveedor`
  MODIFY `PROVP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cji_proveedormarca`
--
ALTER TABLE `cji_proveedormarca`
  MODIFY `EMPMARP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_proyecto`
--
ALTER TABLE `cji_proyecto`
  MODIFY `PROYP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_recepcionproveedor`
--
ALTER TABLE `cji_recepcionproveedor`
  MODIFY `RECEPRO_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_receta`
--
ALTER TABLE `cji_receta`
  MODIFY `REC_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_recetadetalle`
--
ALTER TABLE `cji_recetadetalle`
  MODIFY `RECDET_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_reponsblmoviminto`
--
ALTER TABLE `cji_reponsblmoviminto`
  MODIFY `RESPNMOV_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_respuestasunat`
--
ALTER TABLE `cji_respuestasunat`
  MODIFY `respuestas_codigo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cji_rol`
--
ALTER TABLE `cji_rol`
  MODIFY `ROL_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7008;

--
-- AUTO_INCREMENT for table `cji_sectorcomercial`
--
ALTER TABLE `cji_sectorcomercial`
  MODIFY `SECCOMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cji_serie`
--
ALTER TABLE `cji_serie`
  MODIFY `SERIP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_seriedocumento`
--
ALTER TABLE `cji_seriedocumento`
  MODIFY `SERDOC_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_seriemov`
--
ALTER TABLE `cji_seriemov`
  MODIFY `SERMOVP_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_servicio`
--
ALTER TABLE `cji_servicio`
  MODIFY `SERV_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_terminal`
--
ALTER TABLE `cji_terminal`
  MODIFY `TERMINAL_Codigo` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_tipdocumento`
--
ALTER TABLE `cji_tipdocumento`
  MODIFY `TIPDOCP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cji_tipoalmacen`
--
ALTER TABLE `cji_tipoalmacen`
  MODIFY `TIPALMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cji_tipocaja`
--
ALTER TABLE `cji_tipocaja`
  MODIFY `tipCa_codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_tipocambio`
--
ALTER TABLE `cji_tipocambio`
  MODIFY `TIPCAMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=491;

--
-- AUTO_INCREMENT for table `cji_tipocliente`
--
ALTER TABLE `cji_tipocliente`
  MODIFY `TIPCLIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cji_tipocodigo`
--
ALTER TABLE `cji_tipocodigo`
  MODIFY `TIPCOD_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cji_tipoestablecimiento`
--
ALTER TABLE `cji_tipoestablecimiento`
  MODIFY `TESTP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cji_tipomovimiento`
--
ALTER TABLE `cji_tipomovimiento`
  MODIFY `TIPOMOVP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `cji_tipoproducto`
--
ALTER TABLE `cji_tipoproducto`
  MODIFY `TIPPROD_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_tipoproveedor`
--
ALTER TABLE `cji_tipoproveedor`
  MODIFY `FAMI_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cji_tipo_afectacion`
--
ALTER TABLE `cji_tipo_afectacion`
  MODIFY `AFECT_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cji_ubigeo`
--
ALTER TABLE `cji_ubigeo`
  MODIFY `UBIGP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250402;

--
-- AUTO_INCREMENT for table `cji_unidadmedida`
--
ALTER TABLE `cji_unidadmedida`
  MODIFY `UNDMED_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `cji_usuario`
--
ALTER TABLE `cji_usuario`
  MODIFY `USUA_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cji_usuario_compania`
--
ALTER TABLE `cji_usuario_compania`
  MODIFY `USUCOMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cji_usuario_terminal`
--
ALTER TABLE `cji_usuario_terminal`
  MODIFY `USUTERMINAL_Codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comprobantes_cuotas`
--
ALTER TABLE `comprobantes_cuotas`
  MODIFY `CUOT_Codigo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comprobantes_cuotas_notas`
--
ALTER TABLE `comprobantes_cuotas_notas`
  MODIFY `CUOT_Codigo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detraccion_tipo`
--
ALTER TABLE `detraccion_tipo`
  MODIFY `DTT_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `medio_de_pago_detraccion`
--
ALTER TABLE `medio_de_pago_detraccion`
  MODIFY `MDP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `sunat_transaction`
--
ALTER TABLE `sunat_transaction`
  MODIFY `TXP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `temporal_detalle`
--
ALTER TABLE `temporal_detalle`
  MODIFY `TEMPDE_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
