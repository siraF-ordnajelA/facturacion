BEGIN
    DECLARE total1 DECIMAL(11,2) DEFAULT 0;
    DECLARE total2 DECIMAL(11,2) DEFAULT 0;
    DECLARE total_cheque DECIMAL(11,2) DEFAULT 0;
    DECLARE saldo_cobrado DECIMAL(11,2) DEFAULT 0;

	IF tipo_comprobante = 1 and id_cheque_add = 0 THEN
   SET total1 = (SELECT saldo FROM facturas_emitidas WHERE id_factura_emitida = id_comprobante);
   SET total2 = (SELECT SUM(saldo) FROM facturas_emitidas WHERE id_cliente = id_razon);
   
	UPDATE facturas_emitidas
   SET saldo = saldo - (cobrado_add + carga1_add + carga2_add + carga3_add),
         id_opc_pago = medio_add,
         id_opc = pago_add
   WHERE id_factura_emitida = id_comprobante;
   
   SET saldo_cobrado = total2 - (cobrado_add + carga1_add + carga2_add + carga3_add);
   
   ELSEIF (tipo_comprobante = 2 and id_cheque_add = 0) THEN
   SET total1 = (SELECT subtotal FROM facturas_recibidas WHERE id_factura_recibida = id_comprobante);
   SET saldo_cobrado = total1 - pagado_add;
   
   UPDATE facturas_recibidas
   SET subtotal = saldo_cobrado, pagado = 1
   WHERE id_factura_recibida = id_comprobante;

   ELSEIF (tipo_comprobante = 1 and id_cheque_add > 0) THEN
   SET total1 = (SELECT saldo FROM facturas_emitidas WHERE id_factura_emitida = id_comprobante);
   SET total2 = (SELECT SUM(saldo) FROM facturas_emitidas WHERE id_cliente = id_razon);
   SET total_cheque = (SELECT importe FROM cheques_emitidos WHERE id_cheque = id_cheque_add);
   
	UPDATE facturas_emitidas
   SET saldo = saldo - total_cheque,
         id_opc_pago = medio_add,
         id_opc = pago_add
   WHERE id_factura_emitida = id_comprobante;
   
   UPDATE cheques_emitidos
   SET utilizado = 1
   WHERE id_cheque = id_cheque_add;
   
   SET saldo_cobrado = total2 - total_cheque;
   SET cobrado_add = total_cheque;

   ELSEIF (tipo_comprobante = 2 and id_cheque_add > 0) THEN
   SET total1 = (SELECT subtotal FROM facturas_recibidas WHERE id_factura_recibida = id_comprobante);
   SET total_cheque = (SELECT importe FROM cheques_emitidos WHERE id_cheque = id_cheque_add);
   SET saldo_cobrado = total1 - total_cheque;
   
   UPDATE facturas_recibidas
   SET subtotal = saldo_cobrado, pagado = 1
   WHERE id_factura_recibida = id_comprobante;
   
   UPDATE cheques_emitidos
   SET utilizado = 1
   WHERE id_cheque = id_cheque_add;
   
   SET pagado_add = total_cheque;
   
   ELSEIF (tipo_comprobante = 4) THEN
   SET total1 = (SELECT importe FROM nota_credito WHERE id_nota = id_comprobante);
   END IF;

   INSERT INTO caja (fecha_ingreso,
                  id_cliente,
                  id_tipo_factura,
                  id_factura,
                  id_cheque,
                  facturado,
                  cobrado,
                  pagado,
                  saldo,
                  medio,
                  carga1,
                  carga2,
                  carga3,
                  id_tipo_ingreso_egreso,
                  observaciones,
                  id_empleado,
                  confirmacion)
   VALUES (now(),
            id_razon,
            tipo_comprobante,
            id_comprobante,
            id_cheque_add,
            total1,
            cobrado_add,
            pagado_add,
            saldo_cobrado,
            medio_add,
            carga1_add,
            carga2_add,
            carga3_add,
            pago_add,
            obs,
            id_empleado_add,
            0);
END