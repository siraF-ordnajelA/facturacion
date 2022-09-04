BEGIN
	IF tipo_factura = 2 THEN
	UPDATE facturas_recibidas
   SET fecha = fecha_ed,
       id_cliente = id_cliente_ed,
       importe = importe_ed,
       id_tipo = tipo_factura,
       id_opc = opc_cobro,
       pto_venta = pto_venta_ed,
       nro_comprobante = nro_compro_ed,
       iva = iva_ed,
       subtotal = importe_ed,
       observaciones = observaciones_ed
   WHERE id_factura_recibida = id_factura_ed;
   
   ELSE
   UPDATE facturas_recibidas
   SET fecha = fecha_ed,
       id_cliente = id_cliente_ed,
       importe = importe_ed,
       id_tipo = tipo_factura,
       id_opc = opc_cobro,
       pto_venta = pto_venta_ed,
       nro_comprobante = nro_compro_ed,
       iva = iva_ed,
       subtotal = importe_ed + iva_ed,
       observaciones = observaciones_ed
   WHERE id_factura_recibida = id_factura_ed;
   END IF;
END