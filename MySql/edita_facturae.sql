BEGIN
	IF tipo_factura = 2 THEN
	UPDATE facturas_emitidas
   SET fecha = fecha_ed,
       id_cliente = id_cliente_ed,
       importe = importe_ed,
       id_tipo = tipo_factura,
       nro_comprobante = nro_compro_ed,
       iva = iva_ed,
       saldo = importe_ed,
       observaciones = observaciones_ed
   WHERE id_factura_emitida = id_factura_ed;
   
   ELSE
   UPDATE facturas_emitidas
   SET fecha = fecha_ed,
       id_cliente = id_cliente_ed,
       importe = importe_ed,
       id_tipo = tipo_factura,
       nro_comprobante = nro_compro_ed,
       iva = iva_ed,
       saldo = importe_ed + iva_ed,
       observaciones = observaciones_ed
   WHERE id_factura_emitida = id_factura_ed;
   END IF;
END