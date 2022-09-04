IF opc = 1 THEN
SELECT clientes.razon,
		LPAD (facturas_emitidas.nro_comprobante, 8, '0') as nro_comprobante,
        facturas_emitidas.fecha as fecha_factura,
        caja.fecha_ingreso as fecha_pago,
        facturas_emitidas.importe,
        facturas_emitidas.iva,
        facturas_emitidas.importe + facturas_emitidas.iva as monto_facturado,
        caja.cobrado as cobrado_caja,
        facturas_emitidas.saldo as saldo_factura,
        caja.saldo as saldo_cliente,
        (SELECT saldo FROM caja WHERE id_cliente = id_cliente_busca ORDER BY fecha_ingreso DESC LIMIT 1) as saldo_final

FROM facturas_emitidas LEFT JOIN caja
ON facturas_emitidas.id_factura_emitida = caja.id_factura JOIN clientes
ON facturas_emitidas.id_cliente = clientes.id_cliente
WHERE facturas_emitidas.id_cliente = id_cliente_busca
GROUP BY clientes.razon,
			facturas_emitidas.nro_comprobante,
            facturas_emitidas.fecha,
            caja.fecha_ingreso,
            facturas_emitidas.importe,
            facturas_emitidas.iva,
            caja.cobrado,
            facturas_emitidas.saldo,
            caja.saldo
ORDER BY clientes.razon, facturas_emitidas.fecha DESC, caja.fecha_ingreso DESC;

ELSEIF (opc = 2) THEN
SELECT clientes.razon,
		LPAD (facturas_recibidas.pto_venta, 5, '0') as pto_venta,
        LPAD (facturas_recibidas.nro_comprobante, 8, '0') as nro_comprobante,
        facturas_recibidas.fecha as fecha_factura,
        caja.fecha_ingreso as fecha_pago,
        facturas_recibidas.importe,
        facturas_recibidas.iva,
        facturas_recibidas.subtotal as monto_facturado,
        CASE WHEN caja.pagado IS NULL THEN 0 ELSE caja.pagado END as pagado_caja,
        CASE WHEN caja.pagado IS NULL THEN facturas_recibidas.subtotal ELSE facturas_recibidas.subtotal - caja.pagado END as saldo_cliente

FROM facturas_recibidas LEFT JOIN caja
ON facturas_recibidas.id_factura_recibida = caja.id_factura JOIN clientes
ON facturas_recibidas.id_cliente = clientes.id_cliente
WHERE facturas_recibidas.id_cliente = id_cliente_busca
GROUP BY clientes.razon,
			facturas_recibidas.nro_comprobante,
            facturas_recibidas.fecha,
            caja.fecha_ingreso,
            facturas_recibidas.importe,
            facturas_recibidas.iva,
            caja.cobrado,
            facturas_recibidas.subtotal
ORDER BY clientes.razon, facturas_recibidas.fecha DESC, caja.fecha_ingreso DESC;
END IF