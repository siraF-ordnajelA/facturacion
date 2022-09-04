BEGIN
	IF tipo_factura_add = 2 THEN
	INSERT INTO facturas_recibidas (id_cliente, fecha, importe, id_tipo, id_opc, pto_venta, nro_comprobante, iva, subtotal, observaciones)
   VALUES (id_cliente_add,
           fecha_add,
           importe_add,
           tipo_factura_add,
           opc_cobro_add,
           pto_venta_add,
           comprobante_add,
           iva_add,
           importe_add,
           obs_add);
   
   ELSE
   INSERT INTO facturas_recibidas (id_cliente, fecha, importe, id_tipo, id_opc, pto_venta, nro_comprobante, iva, subtotal, observaciones)
   VALUES (id_cliente_add,
           fecha_add,
           importe_add,
           tipo_factura_add,
           opc_cobro_add,
           pto_venta_add,
           comprobante_add,
           iva_add,
           importe_add + iva_add,
           obs_add);
   END IF;
END