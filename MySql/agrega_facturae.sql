BEGIN
	IF tipo_factura_add = 2 THEN
	INSERT INTO facturas_emitidas (id_cliente, fecha, importe, id_tipo, id_opc_pago, id_opc, nro_comprobante, iva, saldo, observaciones)
   VALUES (id_cliente_add,
        fecha_add,
        importe_add,
        tipo_factura_add,
        0,
        opc_cobro_add,
        comprobante_add,
        iva_add,
        importe_add,
        obs_add);
   
   ELSE
   INSERT INTO facturas_emitidas (id_cliente, fecha, importe, id_tipo, id_opc_pago, id_opc, nro_comprobante, iva, saldo, observaciones)
   VALUES (id_cliente_add,
        fecha_add,
        importe_add,
        tipo_factura_add,
        0,
        opc_cobro_add,
        comprobante_add,
        iva_add,
        importe_add + iva_add,
        obs_add);
   END IF;
END