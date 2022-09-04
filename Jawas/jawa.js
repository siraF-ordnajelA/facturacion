///////////////////////////////////////ABM EMPLEADOS///////////////////////////////////////////////
function empleado_agrega(){
   var apellido = document.getElementById('txt_apellido').value;
   var nombre = document.getElementById('txt_nombre').value;
   var dni = document.getElementById('txt_dni').value;
   var cuil = document.getElementById('txt_cuil1').value + "-" + document.getElementById('txt_cuil2').value + "-" + document.getElementById('txt_cuil3').value;
   var domicilio = document.getElementById('txt_domicilio').value;
   var piso = document.getElementById('txt_piso').value;
   var depto = document.getElementById('txt_depto').value;
   var localidad = document.getElementById('txt_loca').value;
   var provincia = document.getElementById('cbo_provincia').value;
   var email = document.getElementById('txt_mail').value;
   var tel1 = document.getElementById('txt_tel1').value;
   var tel2 = document.getElementById('txt_tel2').value;
   var bruto = document.getElementById('txt_sbruto').value;
   var carga1 = document.getElementById('txt_carga1').value;
   var carga2 = document.getElementById('txt_carga2').value;
   var carga3 = document.getElementById('txt_carga3').value;
   var jornada = document.getElementById('cbo_jornada').value;
   var observaciones = document.getElementById('txt_obs').value;
   var permiso = document.getElementById('ddl_permisos').value;
   var sw = 0;

   if (bruto == ""){
      bruto = 0;
   }
   if (carga1 == ""){
      carga1 = 0;
   }
   if (carga2 == ""){
      carga2 = 0;
   }
   if (carga3 == ""){
      carga3 = 0;
   }
   if (piso == ""){
      piso = 0;
   }
   
   if (apellido == ""){
      alert("Debe completar el campo de apellido.");
      sw = 1;
   }
   if (nombre == ""){
      alert("Debe completar el campo nombre.");
      sw = 1;
   }
   if (dni == "") {
      alert("Debe completar el DNI.");
      sw = 1;
   }
   if (cuil == "") {
      alert("Debe completar el CUIL.");
      sw = 1;
   }
   if (domicilio == "" || piso == "" || depto == "" || localidad == "" || provincia == 0) {
      alert("Debe completar todos los datos del Domicilio.");
      sw = 1;
   }
   if (bruto == "" || carga1 == "" || carga2 == "" || carga3 == "" || jornada == 0) {
      alert("Debe completar todos los datos correspondientes al sueldo.");
      sw = 1;
   }
   if (permiso == 0) {
      alert("Debe seleccionar el tipo de permiso del usuario.");
      sw = 1;
   }
   
   if (sw == 0){
      $.ajax({
         url: "conexiones/empleados_add.php",
         method: 'POST',
         data: { ap: apellido, nom: nombre, docu: dni, cuilo: cuil, dom: domicilio, p: piso, d: depto, loc: localidad, prov: provincia, mail: email, c1: tel1, c2: tel2, brutus: bruto, car1: carga1, car2: carga2, car3: carga3, jornada: jornada, obs: observaciones, permiso: permiso },
         dataType: "html",
         success: function (datos) {
               alert(datos);
               location.reload();
            },
         error: function () {
               alert("Hubo un error en la carga!.");
            }
      });
   }
}

function empleado_edita(id){
   var apellido = document.getElementById('txt_apellido_'+id).innerHTML;
   var nombre = document.getElementById('txt_nombre_'+id).innerHTML;
   var dni = document.getElementById('txt_dni_'+id).innerHTML;
   var cuil = document.getElementById('txt_cuil_'+id).innerHTML;
   var direccion = document.getElementById('txt_direccion_'+id).innerHTML;
   var piso = document.getElementById('txt_piso_'+id).innerHTML;
   var depto = document.getElementById('txt_depto_'+id).innerHTML;
   var localidad = document.getElementById('txt_localidad_'+id).innerHTML;
   var provincia = document.getElementById('cbo_provincia_'+id).value;
   var contacto1 = document.getElementById('txt_contacto1_'+id).innerHTML;
   var contacto2 = document.getElementById('txt_contacto2_'+id).innerHTML;
   var email = document.getElementById('txt_email_'+id).innerHTML;
   var sbruto = document.getElementById('txt_sbruto_'+id).innerHTML;
   var carga1 = document.getElementById('txt_carga1_'+id).innerHTML;
   var carga2 = document.getElementById('txt_carga2_'+id).innerHTML;
   var carga3 = document.getElementById('txt_carga3_'+id).innerHTML;
   var jornada = document.getElementById('cbo_jornada_'+id).value;
   var observaciones = document.getElementById('txt_observaciones_'+id).innerHTML;
   /*
   alert(apellido);
   alert(nombre);
   alert(dni);
   alert(cuil);
   alert(direccion);
   alert(piso);
   alert(depto);
   alert(localidad);
   alert(contacto1);
   alert(contacto2);
   alert(email);
   alert(sbruto);
   alert(carga1);
   alert(carga2);
   alert(carga3);
   alert(observaciones);
   */
   if (sbruto == ""){
      sbruto = 0;
   }
   if (carga1 == ""){
      carga1 = 0;
   }
   if (carga2 == ""){
      carga2 = 0;
   }
   if (carga3 == ""){
      carga3 = 0;
   }
   if (piso == ""){
      piso = 0;
   }
   
   if (apellido == ""){
      alert("Debe completar el campo de apellido.");
   }
   else {
      if (nombre == ""){
         alert("Debe completar el campo nombre.");
      }
      else {
         if (dni == "") {
            alert("Debe completar el DNI.");
         }
         else {
            $.post('conexiones/empleados_update.php',
               { id_emp: id, ap: apellido, nom: nombre, docu: dni, cuilo: cuil, dom: direccion, p: piso, d: depto, loc: localidad, prov: provincia, brutus: sbruto, car1: carga1, car2: carga2, car3: carga3, jor: jornada, c1: contacto1, c2: contacto2, mail: email, obs: observaciones },
               function (data){
                  alert(data);
                  //alert ('Se modific\u00F3 correctamente el empleado');
                  location.reload(true);//Recarga la pagina
               }
            );
         }
      }
   }
}

function empleado_elimina(id){
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea eliminar?");

   if (resultado) {
      $.post('conexiones/empleados_delete.php',
         { id_emp: id },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
   
}
///////////////////////////////////FIN ABM EMPLEADOS///////////////////////////////////////////////

//////////////////////////////////ABM ADMINISTRADORES//////////////////////////////////////////////
function administrador_agrega(){
   var razon = document.getElementById('txt_razon').value;
   razon = razon.toUpperCase();
   var nombre = document.getElementById('txt_nombre').value;
   var domicilio = document.getElementById('txt_domicilio').value;
   var localidad = document.getElementById('txt_loca').value;
   var cp = document.getElementById('txt_cp').value;
   var provincia = document.getElementById('cbo_provincia').value;
   var cuit = document.getElementById('txt_cuit1').value + "-" + document.getElementById('txt_cuit2').value + "-" + document.getElementById('txt_cuit3').value;
   var porcentaje = document.getElementById('txt_abono').value;
   var empleados = 0;
   var observaciones = document.getElementById('txt_obs').value;
   
   var nombre1 = document.getElementById('txt_nombre_c1').value;
   var tel1 = document.getElementById('txt_contacto1').value;
   var email1 = document.getElementById('txt_mail1').value;
   var nombre2 = document.getElementById('txt_nombre_c2').value;
   var tel2 = document.getElementById('txt_contacto2').value;
   var email2 = document.getElementById('txt_mail2').value;
   var nombre3 = document.getElementById('txt_nombre_c3').value;
   var tel3 = document.getElementById('txt_contacto3').value;
   var email3 = document.getElementById('txt_mail3').value;
   var nombre4 = document.getElementById('txt_nombre_c4').value;
   var tel4 = document.getElementById('txt_contacto4').value;
   var email4 = document.getElementById('txt_mail4').value;
   var nombre5 = document.getElementById('txt_nombre_c5').value;
   var tel5 = document.getElementById('txt_contacto5').value;
   var email5 = document.getElementById('txt_mail5').value;
   var nombre6 = document.getElementById('txt_nombre_c6').value;
   var tel6 = document.getElementById('txt_contacto6').value;
   var email6 = document.getElementById('txt_mail6').value;
   var nombre7 = document.getElementById('txt_nombre_c7').value;
   var tel7 = document.getElementById('txt_contacto7').value;
   var email7 = document.getElementById('txt_mail7').value;
   var nombre8 = document.getElementById('txt_nombre_c8').value;
   var tel8 = document.getElementById('txt_contacto8').value;
   var email8 = document.getElementById('txt_mail8').value;
   var nombre9 = document.getElementById('txt_nombre_c9').value;
   var tel9 = document.getElementById('txt_contacto9').value;
   var email9 = document.getElementById('txt_mail9').value;
   var nombre10 = document.getElementById('txt_nombre_c10').value;
   var tel10 = document.getElementById('txt_contacto10').value;
   var email10 = document.getElementById('txt_mail10').value;

   if (cuit == ""){
      cuit = 0;
   }
   if (porcentaje == ""){
      porcentaje = 0;
   }
   
   if (razon == ""){
      alert("Debe completar el campo Razon.");
   }
   else {
      if (nombre == ""){
         alert("Debe completar el campo Nombre.");
      }
      else {
         if (domicilio == "" || provincia == 0){
            alert("Debe completar todos los datos del domicilio.");
         }
         else {
            $.ajax({
               url: "conexiones/administrador_add.php",
               method: 'POST',
               data: { razo: razon, nom: nombre, dom: domicilio, cp: cp, loc: localidad, prov: provincia, cuito: cuit, porc: porcentaje, emples: empleados, nombre1: nombre1, tel1: tel1, email1: email1, nombre2: nombre2, tel2: tel2, email2: email2, nombre3: nombre3, tel3: tel3, email3: email3, nombre4: nombre4, tel4: tel4, email4: email4, nombre5: nombre5, tel5: tel5, email5: email5, nombre6: nombre6, tel6: tel6, email6: email6, nombre7: nombre7, tel7: tel7, email7: email7, nombre8: nombre8, tel8: tel8, email8: email8, nombre9: nombre9, tel9: tel9, email9: email9, nombre10: nombre10, tel10: tel10, email10: email10, obs: observaciones },
               dataType: "html",
               success: function (datos) {
                  alert(datos);
                  location.reload();
               },
               error: function () {
                  alert("Hubo un error en la carga!.");
               }
            });
         }
      }
   }
}

function administrador_edita(id){
   var razon = document.getElementById('txt_razon_'+id).innerHTML;
   var nombre = document.getElementById('txt_nombre_'+id).innerHTML;
   var direccion = document.getElementById('txt_direccion_'+id).innerHTML;
   var cp = document.getElementById('txt_cp_'+id).innerHTML;
   var localidad = document.getElementById('txt_localidad_'+id).innerHTML;
   var provincia = document.getElementById('cbo_provincia_'+id).value;
   var cuit = document.getElementById('txt_cuit_'+id).innerHTML;
   var abono = document.getElementById('txt_abono_'+id).innerHTML;
   var observaciones = document.getElementById('txt_observaciones_'+id).innerHTML;

   if (abono == ""){
      abono = 0;
   }
   
   if (razon == "" || nombre == ""){
      alert("Debe completar el campo Razon y Nombre.");
   }
   else {
      $.post('conexiones/administrador_update.php',
         { id_admin: id, razo: razon, nom: nombre, dom: direccion, cp: cp, loc: localidad, prov: provincia, cuito: cuit, abon: abono, obs: observaciones },
         function (data){
            alert(data);
            //alert ('Se modific\u00F3 correctamente el empleado');
            location.reload(true);//Recarga la pagina
         }
      );
   }
}

function administrador_elimina(id){
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea eliminar?");

   if (resultado) {
      $.post('conexiones/administrador_delete.php',
         { id_admin: id },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
   
}
///////////////////////////////FIN ABM ADMINISTRADORES/////////////////////////////////////////////

////////////////////////////////////ABM CLIENTES///////////////////////////////////////////////////
function clientes_proveedores(tipo){
   window.location='clientes.php?tipo=' + tipo;
   //document.getElementById("form_clientes").submit();
   
   if (tipo == 2) {
      document.querySelector('#rd_clientes').checked = true;
   }
   else {
      document.querySelector('#rd_proveedores').checked = true;
   }
}

function cliente_agrega(tipo_cliente){
   var razon = document.getElementById('txt_razon').value;
   razon = razon.toUpperCase();
   var nombre = document.getElementById('txt_nombre').value;
   var domicilio = document.getElementById('txt_domicilio').value;
   var localidad = document.getElementById('txt_loca').value;
   var cp = document.getElementById('txt_cp').value;
   var provincia = document.getElementById('cbo_provincia').value;
   var cuit = document.getElementById('txt_cuit1').value + "-" + document.getElementById('txt_cuit2').value + "-" + document.getElementById('txt_cuit3').value;
   var abono = 0;//document.getElementById('txt_abono').value;
   var empleados = document.getElementById('txt_empleados').value;
   
   var nombre1 = document.getElementById('txt_nombre_c1').value;
   var tel1 = document.getElementById('txt_contacto1').value;
   var email1 = document.getElementById('txt_mail1').value;
   var nombre2 = document.getElementById('txt_nombre_c2').value;
   var tel2 = document.getElementById('txt_contacto2').value;
   var email2 = document.getElementById('txt_mail2').value;
   var nombre3 = document.getElementById('txt_nombre_c3').value;
   var tel3 = document.getElementById('txt_contacto3').value;
   var email3 = document.getElementById('txt_mail3').value;
   var nombre4 = document.getElementById('txt_nombre_c4').value;
   var tel4 = document.getElementById('txt_contacto4').value;
   var email4 = document.getElementById('txt_mail4').value;
   var nombre5 = document.getElementById('txt_nombre_c5').value;
   var tel5 = document.getElementById('txt_contacto5').value;
   var email5 = document.getElementById('txt_mail5').value;
   var nombre6 = document.getElementById('txt_nombre_c6').value;
   var tel6 = document.getElementById('txt_contacto6').value;
   var email6 = document.getElementById('txt_mail6').value;
   var nombre7 = document.getElementById('txt_nombre_c7').value;
   var tel7 = document.getElementById('txt_contacto7').value;
   var email7 = document.getElementById('txt_mail7').value;
   var nombre8 = document.getElementById('txt_nombre_c8').value;
   var tel8 = document.getElementById('txt_contacto8').value;
   var email8 = document.getElementById('txt_mail8').value;
   var nombre9 = document.getElementById('txt_nombre_c9').value;
   var tel9 = document.getElementById('txt_contacto9').value;
   var email9 = document.getElementById('txt_mail9').value;
   var nombre10 = document.getElementById('txt_nombre_c10').value;
   var tel10 = document.getElementById('txt_contacto10').value;
   var email10 = document.getElementById('txt_mail10').value;
   
   var observaciones = document.getElementById('txt_obs').value;

   if (abono == ""){
      abono = 0;
   }
   
   if (razon == "" || nombre == ""){
      alert("Debe completar el campo Razon y Nombre.");
   }
   else {
      if (domicilio == "" || localidad == "" || cp == "" || provincia == 0){
         alert("Debe completar todos los datos del domicilio.");
      }
      else {
         if (empleados == ""){
            alert("Debe completar la cantidad de empleados.");
         }
         else {
            /*
            alert(razon);
            alert(domicilio);
            alert(localidad);
            alert(cp);
            alert(provincia);
            alert(cuit);
            alert(abono);
            alert(empleados);
            alert(nombre1 + "-" + nombre2 + "-" + nombre3 + "-" + nombre4 + "-" + nombre5 + "-" + nombre6 + "-" + nombre7 + "-" + nombre8 + "-" + nombre9 + "-" + nombre10);
            alert(tel1 + "-" + tel2 + "-" + tel3 + "-" + tel4 + "-" + tel5 + "-" + tel6 + "-" + tel7 + "-" + tel8 + "-" + tel9 + "-" + tel10);
            alert(email1 + "-" + email2 + "-" + email3 + "-" + email4 + "-" + email5 + "-" + email6 + "-" + email7 + "-" + email8 + "-" + email9 + "-" + email10);
            alert(observaciones);
            */
            $.ajax({
               url: "conexiones/cliente_add.php",
               method: 'POST',
               data: { razo: razon, nom: nombre, tipo: tipo_cliente, dom: domicilio, loc: localidad, cp: cp, provincia: provincia, cuito: cuit, abo: abono, emples: empleados, nombre1: nombre1, tel1: tel1, email1: email1, nombre2: nombre2, tel2: tel2, email2: email2, nombre3: nombre3, tel3: tel3, email3: email3, nombre4: nombre4, tel4: tel4, email4: email4, nombre5: nombre5, tel5: tel5, email5: email5, nombre6: nombre6, tel6: tel6, email6: email6, nombre7: nombre7, tel7: tel7, email7: email7, nombre8: nombre8, tel8: tel8, email8: email8, nombre9: nombre9, tel9: tel9, email9: email9, nombre10: nombre10, tel10: tel10, email10: email10, obs: observaciones },
               dataType: "html",
               success: function (datos) {
                  alert(datos);
                  location.reload();
               },
               error: function () {
                  alert("Hubo un error en la carga!.");
               }
            });
         }
      }
   }
}

function cliente_edita(id){
   var razon = document.getElementById('txt_razon_'+id).innerHTML;
   var nombre = document.getElementById('txt_nombre_'+id).innerHTML;
   var direccion = document.getElementById('txt_direccion_'+id).innerHTML;
   var cp = document.getElementById('txt_cp_'+id).innerHTML;
   var localidad = document.getElementById('txt_localidad_'+id).innerHTML;
   var provincia = document.getElementById('cbo_provincia_'+id).value;
   var cuit = document.getElementById('txt_cuit_'+id).innerHTML;
   //var abono = document.getElementById('txt_abono_'+id).innerHTML;
   var empleados = document.getElementById('txt_empleados_'+id).innerHTML;
   var observaciones = document.getElementById('txt_observaciones_'+id).innerHTML;
   
   if (empleados == ""){
      empleados = 0;
   }
   
   if (razon == "" || nombre == ""){
      alert("Debe completar el campo Raz\u00F3n y Nombre.");
   }
   else {
      if (direccion == ""){
         alert("La direcci\u00F3n no debe quedar vac\u00EDa.");
      }
      else {
         if (localidad == ""){
            alert("Debe completar la localidad.");
         }
         else {
            $.post('conexiones/cliente_update.php',
               { id_cliente: id, razo: razon, nom: nombre, dom: direccion, cp: cp, loc: localidad, prov: provincia, cuito: cuit, emp: empleados, obs: observaciones },
               function (data){
                  alert(data);
                  location.reload(true);//Recarga la pagina
               }
            );
         }
      }
   }
}

function cliente_contactos_modifica(id){
   var nombre1 = document.getElementById('txt_nombre_1').value;
   var tel1 = document.getElementById('txt_contacto_1').value;
   var email1 = document.getElementById('txt_mail_1').value;
   var nombre2 = document.getElementById('txt_nombre_2').value;
   var tel2 = document.getElementById('txt_contacto_2').value;
   var email2 = document.getElementById('txt_mail_2').value;
   var nombre3 = document.getElementById('txt_nombre_3').value;
   var tel3 = document.getElementById('txt_contacto_3').value;
   var email3 = document.getElementById('txt_mail_3').value;
   var nombre4 = document.getElementById('txt_nombre_4').value;
   var tel4 = document.getElementById('txt_contacto_4').value;
   var email4 = document.getElementById('txt_mail_4').value;
   var nombre5 = document.getElementById('txt_nombre_5').value;
   var tel5 = document.getElementById('txt_contacto_5').value;
   var email5 = document.getElementById('txt_mail_5').value;
   var nombre6 = document.getElementById('txt_nombre_6').value;
   var tel6 = document.getElementById('txt_contacto_6').value;
   var email6 = document.getElementById('txt_mail_6').value;
   var nombre7 = document.getElementById('txt_nombre_7').value;
   var tel7 = document.getElementById('txt_contacto_7').value;
   var email7 = document.getElementById('txt_mail_7').value;
   var nombre8 = document.getElementById('txt_nombre_8').value;
   var tel8 = document.getElementById('txt_contacto_8').value;
   var email8 = document.getElementById('txt_mail_8').value;
   var nombre9 = document.getElementById('txt_nombre_9').value;
   var tel9 = document.getElementById('txt_contacto_9').value;
   var email9 = document.getElementById('txt_mail_9').value;
   var nombre10 = document.getElementById('txt_nombre_10').value;
   var tel10 = document.getElementById('txt_contacto_10').value;
   var email10 = document.getElementById('txt_mail_10').value;
   
   $.post('conexiones/cliente_update_contactos.php',
      { id_cliente: id, nombre1: nombre1, tel1: tel1, email1: email1, nombre2: nombre2, tel2: tel2, email2: email2, nombre3: nombre3, tel3: tel3, email3: email3, nombre4: nombre4, tel4: tel4, email4: email4, nombre5: nombre5, tel5: tel5, email5: email5, nombre6: nombre6, tel6: tel6, email6: email6, nombre7: nombre7, tel7: tel7, email7: email7, nombre8: nombre8, tel8: tel8, email8: email8, nombre9: nombre9, tel9: tel9, email9: email9, nombre10: nombre10, tel10: tel10, email10: email10 },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
   );
}

function cliente_elimina(id){
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea eliminar?");

   if (resultado) {
      $.post('conexiones/cliente_delete.php',
         { id_cliente: id },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
}
//////////////////////////////////FIN ABM CLIENTES/////////////////////////////////////////////////

///////////////////////////////ABM FACTURAS EMITIDAS///////////////////////////////////////////////
function facturae_agrega(){
   var cliente = document.getElementById('cbo_clientes').value;
   var fecha = document.getElementById('cal_date').value;
   var comprobante = document.getElementById('txt_comprobante').value;
   var importe = document.getElementById('txt_importe').value;
   var iva = document.getElementById('cbo_iva').value;
   var tipo_factura = document.getElementById('cbo_tipo').value;
   var observaciones = document.getElementById('txt_obs').value;
   var iva_importe = 0;
   var sw = 1;

   if (cliente == 0){
      alert("Debe seleccionar un cliente del combo desplegable.");
      sw = 0;
   }
   if (fecha == ""){
      alert("Debe seleccionar una fecha.");
      sw = 0;
   }
   if (comprobante == "") {
      alert("Debe completar el campo comprobante.");
      sw = 0;
   }
   if (importe == "") {
      alert("Debe completar el importe.");
      sw = 0;
   }
   if (tipo_factura == 0) {
      alert("Debe seleccionar un tipo de factura.");
      sw = 0;
   }
   /*
   if (iva == 0){
      iva_importe = 0;
   }
   else {
      iva_importe = (iva * importe) / 100;
   }
   */
   iva_importe = (iva * importe) / 100;
   
   if (sw == 1){
      // cobro: 0 Opcion de cobro cero cuando la factura no tuvo movimientos
      // cobro: 1 Opcion de cobro cero cuando la factura fue pagada en su totalidad
      // cobro: 2 Opcion de cobro cero cuando la factura fue pagada parcialmente
      $.ajax({
         url: "conexiones/facturae_add.php",
         method: 'POST',
         data: { id_cliente: cliente, fecha: fecha, compro: comprobante, importe: importe, iva: iva_importe, tipo_f: tipo_factura, cobro: 0, obs: observaciones },
         dataType: "html",
         success: function (datos) {
            alert(datos);
            location.reload();
         },
         error: function () {
            alert("Hubo un error en la carga!.");
         }
      });
   }
}

function facturae_edita(id){
   var cliente = document.getElementById('cbo_cliente_' + id).value;
   var fecha = document.getElementById('fecha_' + id).value;
   var comprobante = document.getElementById('txt_nro_comp_' + id).innerHTML;
   var importe = document.getElementById('txt_importe_' + id).innerHTML;
   var tipo_factura = document.getElementById('cbo_factura_' + id).value;
   var cbo_iva = document.getElementById('cbo_iva_' + id).value;
   var observaciones = document.getElementById('txt_observaciones_' + id).innerHTML;
   var iva_importe = 0;
   var sw = 1;

   if (fecha == ""){
      alert("Debe seleccionar una fecha.");
      sw = 0;
   }
   if (comprobante == "") {
      alert("Debe completar el campo comprobante.");
      sw = 0;
   }
   if (importe == "") {
      alert("Debe completar el importe.");
      sw = 0;
   }

   importe = importe.replace(".", "");
   importe = importe.replace(",", ".");
   iva_importe = (cbo_iva * importe) / 100;
   
   if (sw == 1){
      /*
      alert("ID cliente: " + cliente);
      alert("Fecha: " + fecha);
      alert("Comprobante numero: " + comprobante);
      alert("Importe: " + importe);
      alert("CBO IVA: " + cbo_iva);
      alert("IVA: " + iva_importe);
      alert("Tiop ABC: " + tipo_factura);
      alert("Observaciones: " + observaciones);
      */
      $.ajax({
         url: "conexiones/facturae_update.php",
         method: 'POST',
         data: { id_factura: id, id_cliente: cliente, fecha: fecha, compro: comprobante, importe: importe, iva: iva_importe, tipo_f: tipo_factura, obs: observaciones },
         dataType: "html",
         success: function (datos) {
            alert(datos);
            location.reload();
         },
         error: function () {
            alert("Hubo un error en la carga!.");
         }
      });
   }
}

function facturae_elimina(id){
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea eliminar?");

   if (resultado) {
      $.post('conexiones/facturae_delete.php',
         { id_facturae: id },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
}
/////////////////////////////FIN ABM FACTURAS EMITIDAS/////////////////////////////////////////////

function tipo_factura(seleccion, id){
   if (seleccion == 0){
      combo_iva = document.getElementById("cbo_iva");
      combo_tipo = document.getElementById("cbo_tipo").value;
      combo_iva.disabled = false;
      $('#cbo_iva').empty();
      
      if (combo_tipo == 1){
         $('#cbo_iva').append("<option value='0'>0%</option>");
         $('#cbo_iva').append("<option value='10.5'>10,5%</option>");
         $('#cbo_iva').append("<option value='21'>21%</option>");
      }
      if (combo_tipo == 2){
         $('#cbo_iva').append("<option value='21'>21%</option>");
      }
      if (combo_tipo == 3){
         $('#cbo_iva').append("<option value='0'>0%</option>");
      }
   }
   if (seleccion == 1){
      combo_iva = document.getElementById("cbo_iva_" + id);
      combo_tipo = document.getElementById("cbo_factura_" + id).value;
      combo_iva.disabled = false;
      $('#cbo_iva_' + id).empty();
      
      if (combo_tipo == 1){
         $('#cbo_iva_' + id).append("<option value='0'>0%</option>");
         $('#cbo_iva_' + id).append("<option value='10.5'>10,5%</option>");
         $('#cbo_iva_' + id).append("<option value='21'>21%</option>");
      }
      if (combo_tipo == 2){
         $('#cbo_iva_' + id).append("<option value='21'>21%</option>");
      }
      if (combo_tipo == 3){
         $('#cbo_iva_' + id).append("<option value='0'>0%</option>");
      }
   }
}

///////////////////////////////ABM FACTURAS RECIBIDAS//////////////////////////////////////////////
function facturar_agrega(){
   var cliente = document.getElementById('cbo_clientes').value;
   var fecha = document.getElementById('cal_date').value;
   var punto = document.getElementById('txt_punto').value;
   var comprobante = document.getElementById('txt_comprobante').value;
   var importe = document.getElementById('txt_importe').value;
   var iva = document.getElementById('cbo_iva').value;
   var tipo_factura = document.getElementById('cbo_tipo').value;
   var opc_cobro = document.getElementById('cbo_tipo_pago').value;
   var observaciones = document.getElementById('txt_obs').value;
   var iva_importe = 0;
   var sw = 1;

   if (cliente == 0){
      alert("Debe seleccionar un cliente del combo desplegable.");
      sw = 0;
   }
   if (fecha == ""){
      alert("Debe seleccionar una fecha.");
      sw = 0;
   }
   if (comprobante == "" || comprobante == 0) {
      alert("Debe completar el campo comprobante.");
      sw = 0;
   }
   if (punto == "" || punto == 0) {
      alert("Debe completar el campo punto de venta.");
      sw = 0;
   }
   if (importe == "") {
      alert("Debe completar el importe.");
      sw = 0;
   }
   if (tipo_factura == 0) {
      alert("Debe seleccionar un tipo de factura.");
      sw = 0;
   }
   if (opc_cobro == 0) {
      alert("Debe seleccionar una opci\u00F3n de cobro.");
      sw = 0;
   }
   /*
   if (iva == 0){
      iva_importe = importe;
   }
   else {
      iva_importe = (iva * importe) / 100;
   }*/
   iva_importe = (iva * importe) / 100;
   
   if (sw == 1){
      $.ajax({
         url: "conexiones/facturar_add.php",
         method: 'POST',
         data: { id_cliente: cliente, fecha: fecha, punto_venta: punto, compro: comprobante, importe: importe, iva: iva_importe, tipo_f: tipo_factura, cobro: opc_cobro, obs: observaciones },
         dataType: "html",
         success: function (datos) {
            alert(datos);
            location.reload();
         },
         error: function () {
            alert("Hubo un error en la carga!.");
         }
      });
   }
}

function facturar_edita(id){
   var cliente = document.getElementById('cbo_cliente_' + id).value;
   var fecha = document.getElementById('fecha_' + id).value;
   var pto_venta = document.getElementById('txt_pto_venta_' + id).innerHTML;
   var comprobante = document.getElementById('txt_nro_comp_' + id).innerHTML;
   var importe = document.getElementById('txt_importe_' + id).innerHTML;
   var tipo_factura = document.getElementById('cbo_factura_' + id).value;
   var cbo_iva = document.getElementById('cbo_iva_' + id).value;
   var opc_cobro = document.getElementById('cbo_cobro_' + id).value;
   var observaciones = document.getElementById('txt_observaciones_' + id).innerHTML;
   var iva_importe = 0;
   var sw = 1;

   if (fecha == ""){
      alert("Debe seleccionar una fecha.");
      sw = 0;
   }
   if (comprobante == "") {
      alert("Debe completar el campo comprobante.");
      sw = 0;
   }
   if (importe == "") {
      alert("Debe completar el importe.");
      sw = 0;
   }

   importe = importe.replace(".", "");
   importe = importe.replace(",", ".");
   iva_importe = (cbo_iva * importe) / 100;
   
   if (sw == 1){
      $.ajax({
         url: "conexiones/facturar_update.php",
         method: 'POST',
         data: { id_factura: id, id_cliente: cliente, fecha: fecha, punto: pto_venta, compro: comprobante, importe: importe, iva: iva_importe, tipo_f: tipo_factura, cobro: opc_cobro, obs: observaciones },
         dataType: "html",
         success: function (datos) {
            alert(datos);
            location.reload();
         },
         error: function () {
            alert("Hubo un error en la carga!.");
         }
      });
   }
}

function facturar_elimina(id){
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea eliminar?");

   if (resultado) {
      $.post('conexiones/facturar_delete.php',
         { id_facturar: id },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
}
/////////////////////////////FIN ABM FACTURAS RECIBIDAS////////////////////////////////////////////

///////////////////////////////ABM CHEQUES EMITIDOS////////////////////////////////////////////////
function chequee_agrega(){
   var fecha_emision = document.getElementById('cal_date_emision').value;
   var fecha_pago = document.getElementById('cal_date_pago').value;
   var banco = document.getElementById('cbo_bancos').value;
   var comprobante = document.getElementById('txt_comprobante').value;
   var importe = document.getElementById('txt_importe').value;
   var destinatario = document.getElementById('cbo_clientes').value;
   var observaciones = document.getElementById('txt_obs').value;
   var radio=document.getElementsByName("radio_cheque");
   for(i=0; i<radio.length; i++) {
      if(radio[i].checked) {
         var radio_check=radio[i].value;
         //alert(radio_check);
      }
   }
   var sw = 1;

   if (fecha_emision == ""){
      alert("Debe seleccionar una fecha de emisi\u00F3n.");
      sw = 0;
   }
   if (fecha_pago == ""){
      alert("Debe seleccionar una fecha de pago.");
      sw = 0;
   }
   if (banco == 0) {
      alert("Debe indicar el banco.");
      sw = 0;
   }
   if (comprobante == "") {
      alert("Debe completar el campo comprobante.");
      sw = 0;
   }
   if (importe == "") {
      alert("Debe completar el importe.");
      sw = 0;
   }
   if (radio_check == "") {
      alert("Debe seleccionar si el cheque es recibido o emitido.");
      sw = 0;
   }
   
   if (sw == 1){
      $.ajax({
         url: "conexiones/cheque_add.php",
         method: 'POST',
         data: { tipo: radio_check, fecha_e: fecha_emision, fecha_p: fecha_pago, banco: banco, compro: comprobante, importe: importe, dest: destinatario, obs: observaciones },
         dataType: "html",
         success: function (datos) {
            alert(datos);
            location.reload();
         },
         error: function () {
            alert("Hubo un error en la carga!.");
         }
      });
   }
}

function chequee_edita(id){
   var fecha_emision = document.getElementById('fecha_emision_' + id).value;
   var fecha_pago = document.getElementById('fecha_pago_' + id).value;
   var importe = document.getElementById('txt_importe_' + id).innerHTML;
   var nro_comprobante = document.getElementById('txt_nro_comp_' + id).innerHTML;
   var banco = document.getElementById('cbo_banco_' + id).value;
   var cliente = document.getElementById('cbo_clientes_' + id).value;
   var observaciones = document.getElementById('txt_observaciones_' + id).innerHTML;
   var tipo_cheque = document.getElementById("cbo_tipo_" + id).value;
   var sw = 0;
   
   if (importe == ""){
      sw = 1;
      alert("Debe completar el importe");
   }
   if (nro_comprobante == ""){
      sw = 1;
      alert("Debe completar el n\u00FAmero de cheque");
   }
   if (cliente == 0){
      sw = 1;
      alert("Debe debe seleccionar cliente o proveedor");
   }
   
   if (sw == 0){
      $.post('conexiones/cheque_update.php',
         { id_cheque: id,
            fecha_emi: fecha_emision,
            fecha_pag: fecha_pago,
            importe: importe,
            comprobante: nro_comprobante,
            banco: banco,
            razon: cliente,
            obs: observaciones,
            tipo_cheq: tipo_cheque },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
}

function chequee_elimina(id){
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea eliminar este cheque?");

   if (resultado) {
      $.post('conexiones/cheque_delete.php',
         { id_cheque: id },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
}

function tipo_cheque_select(opc, id_combo) {
   if (opc == 1){
      var radio=document.getElementsByName("radio_cheque");
      var combo = document.getElementById("cbo_clientes");
      
      for(i=0; i<radio.length; i++) {
         if(radio[i].checked) {
            var radio_check=radio[i].value;
            //alert(radio_check);
         }
      }
      
      $.post('conexiones/combo_clientes.php', { id_tipo: radio_check }, function (data){
         $('#cbo_clientes').html(data);}
      );
   }
   if (opc == 2){
      var tipo_cheque = document.getElementById("cbo_tipo_" + id_combo).value;
      var combo = document.getElementById("cbo_clientes_" + id_combo);

      $('#cbo_clientes_' + id_combo).empty();
      
      $.post('conexiones/combo_clientes.php', { id_tipo: tipo_cheque }, function (data){
         $('#cbo_clientes_' + id_combo).html(data);}
      );
   }   

   combo.disabled = false;
}
//////////////////////////////FIN ABM CHEQUES EMITIDOS/////////////////////////////////////////////

/////////////////////////////////////ABM NOTAS/////////////////////////////////////////////////////
function nota_agrega(){
   var detalle = document.getElementById('txt_detalle').value;
   var importe = document.getElementById('txt_importe').value;
   var id_factura = document.getElementById('cbo_facturas').value;
   var sw = 1;

   if (detalle == ""){
      alert("Debe indicar el detalle.");
      sw = 0;
   }
   if (importe == "") {
      alert("Debe completar el importe.");
      sw = 0;
   }
   if (id_factura == 0) {
      alert("Debe seleccionar la factura.");
      sw = 0;
   }
   
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea agregar la nota?. La factura emitida se cancelar\u00E1 y dejar\u00E1 de aparecer para los movimientos de caja");

   if (resultado && sw == 1) {
      $.ajax({
         url: "conexiones/nota_add.php",
         method: 'POST',
         data: { detalle: detalle, importe: importe, id_factura: id_factura },
         dataType: "html",
         success: function (datos) {
            alert(datos);
            location.reload();
         },
         error: function () {
            alert("Hubo un error en la carga!.");
         }
      });
   }
}

function nota_edita(id){
   var fecha = document.getElementById('fecha_'+id).value;
   var observaciones = document.getElementById('txt_detalle_'+id).innerHTML;
   var importe = document.getElementById('txt_importe_'+id).innerHTML;
   var sw = 1;

   if (importe == ""){
      alert("Debe completar el importe de la nota de cr\u00E9dito.");
      sw = 0;
   }
   
   if (sw == 1){
      $.post('conexiones/nota_update.php',
         { id_nota: id, fecha: fecha, obs: observaciones, importe: importe },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
}

function nota_elimina(id){
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea eliminar la nota?");

   if (resultado) {
      $.post('conexiones/nota_delete.php',
         { id_nota: id },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
}

function select_comprobante_nota(){
   var facturas = document.getElementById("cbo_facturas");
   var facturas_ajax = $('#cbo_facturas');
   
   facturas_ajax.empty();
   
   $.post('conexiones/consulta_comprobantes.php', { id_accion: 1, id_tipo_comprobante: 1, id_comprobante: 0 }, function (data){
      facturas_ajax.html(data);}
   );
}
///////////////////////////////////FIN ABM NOTAS///////////////////////////////////////////////////

//////////////////////////RELACIONES ADMINISTRADOR/CLIENTE/////////////////////////////////////////
function admin_relacion_agrega(id){
   var id_cliente = document.getElementById('cbo_clientes_' + id).value;

   if (id_cliente == 0){
      alert("Debe seleccionar un cliente para agregar.");
   }
   else {
      $.ajax({
         url: "conexiones/relacion_admin_agrega.php",
         method: 'POST',
         data: { id_administrador: id, id_cliente: id_cliente },
         dataType: "html",
         success: function (datos) {
            alert(datos);
         },
         error: function () {
            alert("Hubo un error en la carga!.");
         }
      });
   }
}

function admin_relacion_elimina(id_admin, id_cliente){
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea eliminar?");

   if (resultado) {
      $.post('conexiones/relacion_admin_delete.php',
         { id_admin: id_admin, id_cliente: id_cliente },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
}
////////////////////////FIN RELACIONES ADMINISTRADOR/CLIENTE///////////////////////////////////////

/////////////////////////////////////ABM BANCOS////////////////////////////////////////////////////
function banco_agrega(){
   var nombre = document.getElementById('txt_banco').value;
   nombre = nombre.toUpperCase();
   var sw = 1;

   if (nombre == ""){
      alert("Debe completar el nombre del banco.");
      sw = 0;
   }
   
   if (sw == 1){
      $.ajax({
         url: "conexiones/banco_add.php",
         method: 'POST',
         data: { nombre: nombre },
         dataType: "html",
         success: function (datos) {
            alert(datos);
            location.reload();
         },
         error: function () {
            alert("Hubo un error en la carga!.");
         }
      });
   }
}

function banco_edita(id){
   var nombre = document.getElementById('txt_banco_'+id).innerHTML;
   
   if (nombre == ""){
      alert("Debe completar el nombre del banco.");
   }
   else {
      $.post('conexiones/banco_update.php',
         { id_banco: id, nombre: nombre },
         function (data){
            alert(data);
            //alert ('Se modific\u00F3 correctamente el empleado');
            location.reload(true);//Recarga la pagina
         }
      );
   }
}

function banco_elimina(id){
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea eliminar?");

   if (resultado) {
      $.post('conexiones/banco_delete.php',
         { id_banco: id },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
}
///////////////////////////////////FIN ABM BANCOS//////////////////////////////////////////////////

/////////////////////////////////////ABM USUARIOS//////////////////////////////////////////////////
function modifica_user(id, accion){
   var usuario = document.getElementById('txt_usuario_' + id).innerHTML;
   var contra = document.getElementById('txt_pass_' + id).value;
   var tipo = document.getElementById('cbo_tipo_' + id).value;
   
   if (accion == 1){
      var resultado = confirm("\u00BFEst\u00E1 seguro que desea modificar el usuario?");
   }
   else {
      var resultado = confirm("\u00BFEst\u00E1 seguro que desea modificar la contrase\u00F1a?");
   }

   if (resultado) {
      // Actualiza usuario y privilegio
      if (accion == 1){
         $.post('conexiones/usuarios_update.php',
            { accion: accion, id_user: id, usuario: usuario, contra: contra, tipo: tipo },
            function (data){
               alert(data);
               location.reload(true);//Recarga la pagina
            }
         );
      }
      // Actualiza contraseña
      else {
         if (contra == "") {
            alert("Debe ingresar una contrase\u00F1a");
         }
         else {
            $.post('conexiones/usuarios_update.php',
               { accion: accion, id_user: id, usuario: usuario, contra: contra, tipo: tipo },
               function (data){
                  alert(data);
                  location.reload(true);//Recarga la pagina
               }
            );
         }
      }
   }
}

function elimina_user(id){
   var resultado = confirm("\u00BFEst\u00E1 seguro que desea eliminar este acceso?");

   if (resultado) {
      $.post('conexiones/usuarios_delete.php',
         { id_user: id },
         function (data){
            alert(data);
            location.reload(true);//Recarga la pagina
         }
      );
   }
}
///////////////////////////////////FIN ABM USUARIOS////////////////////////////////////////////////

///////////////////////////////FUNCIONES DE AGREGADO A CAJA////////////////////////////////////////
function select_comprobante(){
   var tipo_comprobante = document.getElementById('cbo_tipo').value;
   var txt_pagado = document.getElementById('txt_pagado');
   var txt_cobrado = document.getElementById('txt_cobrado');
   $('#txt_importe').empty();
   $('#txt_iva').empty();
   $('#txt_total').empty();
   
   if (tipo_comprobante > 0) {
      $.post('conexiones/consulta_comprobantes.php', { id_accion: 1, id_tipo_comprobante: tipo_comprobante, id_comprobante: 0 }, function (data){
         $('#cbo_comprobantes').html(data);}
      );
      document.getElementById("cbo_comprobantes").disabled = false;
   }
   else {
      $('#cbo_comprobantes').html('<option value="0">--Seleccione tipo Ingreso/Egreso--</option>');
      document.getElementById("cbo_comprobantes").disabled = true;
   }
   
   if (tipo_comprobante == "1"){
      txt_cobrado.disabled = false;
      txt_pagado.disabled = true;
      txt_cobrado.value = 0;
      txt_pagado.value = 0;
   }
   if (tipo_comprobante == "2"){
      txt_cobrado.disabled = true;
      txt_pagado.disabled = false;
      txt_cobrado.value = 0;
      txt_pagado.value = 0;
   }
}

function select_datos_comprobante(){
   var tipo_comprobante = document.getElementById('cbo_tipo').value;
   var nro_comprobante = document.getElementById('cbo_comprobantes').value;
   
   if (nro_comprobante > 0) {
      $.ajax({
         method:'POST',
         url:'conexiones/consulta_comprobantes.php',
         dataType: "json",
         data: { id_accion: 2, id_tipo_comprobante: tipo_comprobante, id_comprobante: nro_comprobante },
         success:function(datos){
            $('#txt_cliente').empty();
            $('#txt_importe').empty();
            $('#txt_iva').empty();
            $('#txt_total').empty();
            
            $('#txt_cliente').append(datos.id_cliente);
            $('#txt_importe').append(datos.importe);
            $('#txt_iva').append(datos.iva);
            $('#txt_total').append(datos.total);
            /*
            $(datos).each(function (index, item) {
               $('#txt_importe').append(item.importe);
               $('#txt_iva').append(item.iva);
               $('#txt_total').append(item.total);
            });
            */
         },
         error: function () {
            alert("Hubo un error al consultar comprobante!.");
         }
      });
   }
}

function guardar_caja(id_user){
   var id_cliente = document.getElementById('txt_cliente').innerHTML;
   var tipo_comprobante = document.getElementById('cbo_tipo').value;
   var nro_comprobante = document.getElementById('cbo_comprobantes').value;
   var cobrado = document.getElementById('txt_cobrado').value;
   var pagado = document.getElementById('txt_pagado').value;
   var fecha_pago = document.getElementById('cal_pago').value;
   
   var carga1 = document.getElementById('txt_carga1').value;
   var carga2 = document.getElementById('txt_carga2').value;
   var carga3 = document.getElementById('txt_carga3').value;
   var carga4 = document.getElementById('txt_carga4').value;
   var carga5 = document.getElementById('txt_carga5').value;
   var medio = document.getElementById('cbo_medio').value;
   var cbo_cheque = document.getElementById('cbo_cheque').value;
   var pago = document.getElementById('cbo_pago').value;
   var observaciones = document.getElementById('txt_obs').value;
   
   var sw = 0;
   /*
   alert("Id cliente: " + id_cliente);
   alert("Total facturado: " + total);
   alert("Pagado: " + pagado);
   alert("Saldo: " + saldo);
   alert("Tipo comprobante: " + tipo_comprobante);
   alert("Nro compr: " + nro_comprobante );
   alert("Cobrado: " + cobrado);
   alert("Pagado: " + pagado);
   alert("Carga 1: " + carga1);
   alert("Medio: " + medio);
   alert("Pago: " + pago);
   alert("Observaciones: " + observaciones);
   */
   if (tipo_comprobante > 0) {
      sw = sw + 1;
   }
   else {
      alert("Debe seleccionar el tipo de comprobante.");
      sw = 0;
   }
   if (nro_comprobante > 0) {
      sw = sw + 1;
   }
   else {
      alert("Debe seleccionar el comprobante.");
      sw = 0;
   }
   if (medio > 0) {
      sw = sw + 1;
   }
   else {
      alert("Debe seleccionar el medio de pago.");
      sw = 0;
   }
   if (medio == 2 && cbo_cheque == 0){
      alert("Debe seleccionar el cheque");
   }
   else {
      sw = sw + 1;
   }
   if (pago > 0) {
      sw = sw + 1;
   }
   else {
      alert("Debe seleccionar el pago.");
      sw = 0;
   }
   if (fecha_pago == "" || fecha_pago == null) {
      alert("Debe seleccionar la fecha de pago.");
      sw = 0;
   }
   else {
      sw = sw + 1;
   }

   // Coloco a cero los campos de cobrado/pagado y cargas en caso de dejar vacío
   if (cobrado == "") {
      cobrado = 0;
   }
   if (pagado == "") {
      pagado = 0;
   }
   if (carga1 == "") {
      carga1 = 0;
   }
   if (carga2 == "") {
      carga2 = 0;
   }
   if (carga3 == "") {
      carga3 = 0;
   }
   if (carga4 == "") {
      carga4 = 0;
   }
   if (carga5 == "") {
      carga5 = 0;
   }
/*
   if (cobrado == 0 && pagado == 0) {
      alert("Debe completar el valor del pago o el de cobro");
      sw = 0;
   }
   else {
      sw = sw + 1;
   }
*/
   if (sw == 6) {
      var resultado = confirm("\u00BFConfirma agregar estos datos?");
      if (resultado) {
         $.post('conexiones/guarda_caja.php', { id_cliente: id_cliente, id_tipo_comprobante: tipo_comprobante, nro_comprobante: nro_comprobante, cheque: cbo_cheque, cobrado: cobrado, pagado: pagado, f_pago: fecha_pago, carga1: carga1, carga2: carga2, carga3: carga3, carga4: carga4, carga5: carga5, medio: medio, pago: pago, obs: observaciones, id_user: id_user }, function (data){
            alert(data);
            location.reload();
         });
      }
   }
}

function guardar_caja_chica(id_user){
   var nro_factura = document.getElementById('txt_factura').value;
   var cobrado = document.getElementById('txt_cobrado').value;
   var pagado = document.getElementById('txt_pagado').value;
   var medio = document.getElementById('cbo_medio').value;
   var observaciones = document.getElementById('txt_obs').value;   
   var sw = 0;

   if (nro_factura == "") {
      sw = 1;
      alert("Debe agregar el n\u00FAmero de factura.");
   }
   if (observaciones == ""){
      alert("Debe completar las observaciones del movimiento de caja");
      sw = 1;
   }
   if ((cobrado == 0 && pagado == 0) || (cobrado == "" && pagado == "")) {
      alert("Debe completar el valor del pago o el de cobro");
      sw = 1;
   }
   // Coloco a cero los campos de cobrado/pagado y cargas en caso de dejar vacío
   if (cobrado == "") {
      cobrado = 0;
   }
   if (pagado == "") {
      pagado = 0;
   }
   
   if (sw == 0) {
      var resultado = confirm("\u00BFConfirma agregar estos datos?");
      if (resultado) {
         $.post('conexiones/guarda_caja_chica.php', { id_usuario: id_user, nro_fact: nro_factura, cobrado: cobrado, pagado: pagado, medio: medio, obs: observaciones }, function (data){
            alert(data);
            location.reload();
         });
      }
   }
}

function caja_aprueba(id, aprobacion){
   var resultado = confirm("\u00BFEst\u00E1 seguro?");
   if (resultado) {
      $.post('conexiones/aprueba_caja.php', { id_caja: id, aprueba: aprobacion }, function (data){
         alert(data);
         location.reload();
      });
   }
}

function caja_elimina(id_caja, id_tipo_factura, id_factura){
   //alert("ID caja: " + id_caja + " / " + "Tipo factura: " + id_tipo_factura + " / " + "ID factura: " + id_factura);
   var resultado = confirm("\u00BFEst\u00E1 seguro de eliminar el registro?");
   if (resultado) {
      $.post('conexiones/elimina_caja.php', { id_caja: id_caja, id_tipo_factura: id_tipo_factura, id_factura: id_factura }, function (data){
         alert(data);
         location.reload();
      });
   }
}

function caja_cheque(opc){
   var cbo_medio = document.getElementById('cbo_medio').value;
   var cbo_cheque = document.getElementById('cbo_cheque');
   
   if (cbo_medio == 2){
      $('#cbo_cheque').empty();
      
      $.post('conexiones/combo_cheques.php', { id_utilizado: opc }, function (data){
         $('#cbo_cheque').html(data);}
      );
      
      cbo_cheque.disabled = false;
   }
   else {
      $('#cbo_cheque').empty();
      $('#cbo_cheque').html("<option value=0>--Seleccione cheque--</option>");
      cbo_cheque.disabled = true;
   }
}
///////////////////////////FIN DE FUNCIONES DE AGREGADO A CAJA/////////////////////////////////////

///////////////////////////////////FUNCIONES DE BUSQUEDA///////////////////////////////////////////
function busca_factura(opc){   
   var boton_pdf = document.getElementById('btn_pdf');
   var color = 0;
   var resultados = $('#t1');
   resultados.empty(); //VACIA LA TABLA ANTES DE CARGAR UNA NUEVA
   
   var radio_comprobantes = document.getElementsByName('rd_comprobantes');
   for (i = 0; i < radio_comprobantes.length; i++) {
      if (radio_comprobantes[i].checked) {
         var valor_comprobante = radio_comprobantes[i].value;
      }
   }
   
   // Busca por fecha
   if(opc == 1){
      var fecha1 = document.getElementById('fecha1').value;
      var fecha2 = document.getElementById('fecha2').value;
      
      if (valor_comprobante && fecha1 != "" && fecha2 != ""){
         if (valor_comprobante == 1){
            $.ajax({
               url: "conexiones/busca_comprobante.php",
               method: 'post',
               data: { opc: opc, compr: valor_comprobante, fecha1: fecha1, fecha2: fecha2, nro_compro: 0 },
               dataType: "json",
               success: function (datos) {            
                  if (datos.respuesta == "No hay datos cargados"){
                     resultados.append('<h3>No hay registros</h3>');
                  }
                  else {
                     resultados.append('<caption><center><label>FACTURAS EMITIDAS</center></label></caption>');
                     resultados.append('<thead><tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">CLIENTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PTO. VENTA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO. FACTURA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">TIPO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OPC.PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SALDO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td></tr></thead>');
                     $(datos).each(function (index, item) {
                        if (color == 0){
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio1">' + item.razon + '</td>');
                           resultados.append('<td align="center" class="propio1">00001</td>');
                           resultados.append('<td align="center" class="propio1">' + item.nro_comprobante + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.tipo_factura + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.iva + '</td>');
                           if (item.opc_cobro_pago == null){
                              resultados.append('<td align="center" class="propio1">Sin movimiento</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio1">' + item.opc_cobro_pago + '</td>');
                           }
                           if (item.tipo_pago == null){
                              resultados.append('<td align="center" style="background-color:rgba(224, 0, 0, 0.6);">Sin movimiento</td>');
                           }
                           else if (item.tipo_pago == "Parcial"){
                              resultados.append('<td align="center" style="background-color:rgba(255, 190, 80, 0.8);">Pago Parcial</td>');
                           }
                           else if (item.tipo_pago == "Total"){
                              resultados.append('<td align="center" style="background-color:rgba(41, 217, 17, 0.6);">Pago Total</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio1">' + item.tipo_pago + '</td>');
                           }
                           resultados.append('<td align="center" class="propio1">' + item.saldo + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 1;
                        }
                        else {
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio2">' + item.razon + '</td>');
                           resultados.append('<td align="center" class="propio1">00001</td>');
                           resultados.append('<td align="center" class="propio2">' + item.nro_comprobante + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.tipo_factura + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.iva + '</td>');
                           if (item.opc_cobro_pago == null){
                              resultados.append('<td align="center" class="propio2">Sin movimiento</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio2">' + item.opc_cobro_pago + '</td>');
                           }
                           if (item.tipo_pago == null){
                              resultados.append('<td align="center" style="background-color:rgba(224, 0, 0, 0.6);">Sin movimiento</td>');
                           }
                           else if (item.tipo_pago == "Parcial"){
                              resultados.append('<td align="center" style="background-color:rgba(255, 190, 80, 0.8);">Pago Parcial</td>');
                           }
                           else if (item.tipo_pago == "Total"){
                              resultados.append('<td align="center" style="background-color:rgba(41, 217, 17, 0.6);">Pago Total</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio2">' + item.tipo_pago + '</td>');
                           }
                           resultados.append('<td align="center" class="propio2">' + item.saldo + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 0;
                        }
                     });
                  }
               },
               error: function (jqXHR, exception) {
                  //alert("Hubo un error al consultar detalle! ");
                  if (jqXHR.status === 0) {
                      alert('Not connect.n Verify Network.');
                  } else if (jqXHR.status == 404) {
                      alert('Requested page not found. [404]');
                  } else if (jqXHR.status == 500) {
                      alert('Internal Server Error [500].');
                  } else if (exception === 'parsererror') {
                      alert('Requested JSON parse failed.');
                  } else if (exception === 'timeout') {
                      alert('Time out error.');
                  } else if (exception === 'abort') {
                      alert('Ajax request aborted.');
                  } else {
                      alert('Uncaught Error.n' + jqXHR.responseText);
                  }
               }
            });
         }
         if (valor_comprobante == 2){
            $.ajax({
               url: "conexiones/busca_comprobante.php",
               method: 'post',
               data: { opc: opc, compr: valor_comprobante, fecha1: fecha1, fecha2: fecha2, nro_compro: 0 },
               dataType: "json",
               success: function (datos) {            
                  if (datos.respuesta == "No hay datos cargados"){
                     resultados.append('<h3>No hay registros</h3>');
                  }
                  else {
                     resultados.append('<caption><center><label>FACTURAS RECIBIDAS</center></label></caption>');
                     resultados.append('<thead><tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">CLIENTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PTO. VENTA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO. FACTURA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">TIPO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OPC.PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td></tr></thead>');
                     $(datos).each(function (index, item) {
                        if (color == 0){
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio1">' + item.razon + '</td>');
                           resultados.append('<td align="center" class="propio1">00001</td>');
                           resultados.append('<td align="center" class="propio1">' + item.nro_comprobante + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.tipo_factura + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.iva + '</td>');
                           if (item.opc_cobro_pago == null){
                              resultados.append('<td align="center" class="propio1">Sin movimiento</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio1">' + item.opc_cobro_pago + '</td>');
                           }
                           resultados.append('<td align="center" class="propio1">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 1;
                        }
                        else {
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio2">' + item.razon + '</td>');
                           resultados.append('<td align="center" class="propio1">00001</td>');
                           resultados.append('<td align="center" class="propio2">' + item.nro_comprobante + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.tipo_factura + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.iva + '</td>');
                           if (item.opc_cobro_pago == null){
                              resultados.append('<td align="center" class="propio2">Sin movimiento</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio2">' + item.opc_cobro_pago + '</td>');
                           }
                           resultados.append('<td align="center" class="propio2">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 0;
                        }
                     });
                  }
               },
               error: function (jqXHR, exception) {
                  //alert("Hubo un error al consultar detalle! ");
                  if (jqXHR.status === 0) {
                      alert('Not connect.n Verify Network.');
                  } else if (jqXHR.status == 404) {
                      alert('Requested page not found. [404]');
                  } else if (jqXHR.status == 500) {
                      alert('Internal Server Error [500].');
                  } else if (exception === 'parsererror') {
                      alert('Requested JSON parse failed.');
                  } else if (exception === 'timeout') {
                      alert('Time out error.');
                  } else if (exception === 'abort') {
                      alert('Ajax request aborted.');
                  } else {
                      alert('Uncaught Error.n' + jqXHR.responseText);
                  }
               }
            });
         }
         if (valor_comprobante == 3){
            $.ajax({
               url: "conexiones/busca_comprobante.php",
               method: 'post',
               data: { opc: opc, compr: valor_comprobante, fecha1: fecha1, fecha2: fecha2, nro_compro: 0 },
               dataType: "json",
               success: function (datos) {            
                  if (datos.respuesta == "No hay datos cargados"){
                     resultados.append('<h3>No hay registros</h3>');
                  }
                  else {
                     resultados.append('<caption><center><label>CHEQUES</center></label></caption>');
                     resultados.append('<thead><tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA EMISION</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO.CHEQUE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">BANCO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">DESTINATARIO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td></tr></thead>');
                     $(datos).each(function (index, item) {
                        if (color == 0){
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio1">' + item.fecha_emision + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.nro_cheque + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.nombre_banco + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.fecha_pago + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.destinatario + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 1;
                        }
                        else {
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio2">' + item.fecha_emision + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.nro_cheque + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.nombre_banco + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.fecha_pago + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.destinatario + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 0;
                        }
                     });
                  }
               },
               error: function (jqXHR, exception) {
                  //alert("Hubo un error al consultar detalle! ");
                  if (jqXHR.status === 0) {
                      alert('Not connect.n Verify Network.');
                  } else if (jqXHR.status == 404) {
                      alert('Requested page not found. [404]');
                  } else if (jqXHR.status == 500) {
                      alert('Internal Server Error [500].');
                  } else if (exception === 'parsererror') {
                      alert('Requested JSON parse failed.');
                  } else if (exception === 'timeout') {
                      alert('Time out error.');
                  } else if (exception === 'abort') {
                      alert('Ajax request aborted.');
                  } else {
                      alert('Uncaught Error.n' + jqXHR.responseText);
                  }
               }
            });
         }
         if (valor_comprobante == 4){
            $.ajax({
               url: "conexiones/busca_comprobante.php",
               method: 'post',
               data: { opc: opc, compr: valor_comprobante, fecha1: fecha1, fecha2: fecha2, nro_compro: 0 },
               dataType: "json",
               success: function (datos) {            
                  if (datos.respuesta == "No hay datos cargados"){
                     resultados.append('<h3>No hay registros</h3>');
                  }
                  else {
                     resultados.append('<caption><center><label>NOTAS</center></label></caption>');
                     resultados.append('<thead><tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO.DE NOTA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">DETALLE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td></tr></thead>');
                     $(datos).each(function (index, item) {
                        if (color == 0){
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio1">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.id_nota + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.detalle + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 1;
                        }
                        else {
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio2">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.id_nota + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.detalle + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 0;
                        }
                     });
                  }
               },
               error: function (jqXHR, exception) {
                  //alert("Hubo un error al consultar detalle! ");
                  if (jqXHR.status === 0) {
                      alert('Not connect.n Verify Network.');
                  } else if (jqXHR.status == 404) {
                      alert('Requested page not found. [404]');
                  } else if (jqXHR.status == 500) {
                      alert('Internal Server Error [500].');
                  } else if (exception === 'parsererror') {
                      alert('Requested JSON parse failed.');
                  } else if (exception === 'timeout') {
                      alert('Time out error.');
                  } else if (exception === 'abort') {
                      alert('Ajax request aborted.');
                  } else {
                      alert('Uncaught Error.n' + jqXHR.responseText);
                  }
               }
            });
         }

         boton_pdf.style.visibility = "visible";
      }
      else {
         alert ("Debe seleccionar el tipo de comprobante y rango de fechas a buscar.");
         boton_pdf.style.visibility = "hidden";
      }
   }
   
   // Busca por número de comprobante
   if(opc == 2){
      var nro_comprobante = document.getElementById('txt_comprobante').value;
      
      if (valor_comprobante && fecha1 != "" && fecha2 != ""){
         if (valor_comprobante == 1){
            $.ajax({
               url: "conexiones/busca_comprobante.php",
               method: 'post',
               data: { opc: opc, compr: valor_comprobante, fecha1: "20000101", fecha2: "20000101", nro_compro: nro_comprobante },
               dataType: "json",
               success: function (datos) {            
                  if (datos.respuesta == "No hay datos cargados"){
                     resultados.append('<h3>No hay registros</h3>');
                  }
                  else {
                     resultados.append('<caption><center><label>FACTURAS EMITIDAS</center></label></caption>');
                     resultados.append('<thead><tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">CLIENTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PTO. VENTA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO. FACTURA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">TIPO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OPC.PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">SALDO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td></tr></thead>');
                     $(datos).each(function (index, item) {
                        if (color == 0){
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio1">' + item.razon + '</td>');
                           resultados.append('<td align="center" class="propio1">00001</td>');
                           resultados.append('<td align="center" class="propio1">' + item.nro_comprobante + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.tipo_factura + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.iva + '</td>');
                           if (item.opc_cobro_pago == null){
                              resultados.append('<td align="center" class="propio1">Sin movimiento</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio1">' + item.opc_cobro_pago + '</td>');
                           }
                           if (item.tipo_pago == null){
                              resultados.append('<td align="center" style="background-color:rgba(224, 0, 0, 0.6);">Sin movimiento</td>');
                           }
                           else if (item.tipo_pago == "Parcial"){
                              resultados.append('<td align="center" style="background-color:rgba(255, 190, 80, 0.8);">Pago Parcial</td>');
                           }
                           else if (item.tipo_pago == "Total"){
                              resultados.append('<td align="center" style="background-color:rgba(41, 217, 17, 0.6);">Pago Total</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio1">' + item.tipo_pago + '</td>');
                           }
                           resultados.append('<td align="center" class="propio1">' + item.saldo + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 1;
                        }
                        else {
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio2">' + item.razon + '</td>');
                           resultados.append('<td align="center" class="propio1">00001</td>');
                           resultados.append('<td align="center" class="propio2">' + item.nro_comprobante + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.tipo_factura + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.iva + '</td>');
                           if (item.opc_cobro_pago == null){
                              resultados.append('<td align="center" class="propio2">Sin movimiento</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio2">' + item.opc_cobro_pago + '</td>');
                           }
                           if (item.tipo_pago == null){
                              resultados.append('<td align="center" style="background-color:rgba(224, 0, 0, 0.6);">Sin movimiento</td>');
                           }
                           else if (item.tipo_pago == "Parcial"){
                              resultados.append('<td align="center" style="background-color:rgba(255, 190, 80, 0.8);">Pago Parcial</td>');
                           }
                           else if (item.tipo_pago == "Total"){
                              resultados.append('<td align="center" style="background-color:rgba(41, 217, 17, 0.6);">Pago Total</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio2">' + item.tipo_pago + '</td>');
                           }
                           resultados.append('<td align="center" class="propio2">' + item.saldo + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 0;
                        }
                     });
                  }
               },
               error: function (jqXHR, exception) {
                  //alert("Hubo un error al consultar detalle! ");
                  if (jqXHR.status === 0) {
                      alert('Not connect.n Verify Network.');
                  } else if (jqXHR.status == 404) {
                      alert('Requested page not found. [404]');
                  } else if (jqXHR.status == 500) {
                      alert('Internal Server Error [500].');
                  } else if (exception === 'parsererror') {
                      alert('Requested JSON parse failed.');
                  } else if (exception === 'timeout') {
                      alert('Time out error.');
                  } else if (exception === 'abort') {
                      alert('Ajax request aborted.');
                  } else {
                      alert('Uncaught Error.n' + jqXHR.responseText);
                  }
               }
            });
         }
         if (valor_comprobante == 2){
            $.ajax({
               url: "conexiones/busca_comprobante.php",
               method: 'post',
               data: { opc: opc, compr: valor_comprobante, fecha1: "20000101", fecha2: "20000101", nro_compro: nro_comprobante },
               dataType: "json",
               success: function (datos) {            
                  if (datos.respuesta == "No hay datos cargados"){
                     resultados.append('<h3>No hay registros</h3>');
                  }
                  else {
                     resultados.append('<caption><center><label>FACTURAS RECIBIDAS</center></label></caption>');
                     resultados.append('<thead><tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">CLIENTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">PTO. VENTA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO. FACTURA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">TIPO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IVA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OPC.PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td></tr></thead>');
                     $(datos).each(function (index, item) {
                        if (color == 0){
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio1">' + item.razon + '</td>');
                           resultados.append('<td align="center" class="propio1">00001</td>');
                           resultados.append('<td align="center" class="propio1">' + item.nro_comprobante + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.tipo_factura + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.iva + '</td>');
                           if (item.opc_cobro_pago == null){
                              resultados.append('<td align="center" class="propio1">Sin movimiento</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio1">' + item.opc_cobro_pago + '</td>');
                           }
                           resultados.append('<td align="center" class="propio1">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 1;
                        }
                        else {
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio2">' + item.razon + '</td>');
                           resultados.append('<td align="center" class="propio1">00001</td>');
                           resultados.append('<td align="center" class="propio2">' + item.nro_comprobante + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.tipo_factura + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.iva + '</td>');
                           if (item.opc_cobro_pago == null){
                              resultados.append('<td align="center" class="propio2">Sin movimiento</td>');
                           }
                           else {
                              resultados.append('<td align="center" class="propio2">' + item.opc_cobro_pago + '</td>');
                           }
                           resultados.append('<td align="center" class="propio2">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 0;
                        }
                     });
                  }
               },
               error: function (jqXHR, exception) {
                  //alert("Hubo un error al consultar detalle! ");
                  if (jqXHR.status === 0) {
                      alert('Not connect.n Verify Network.');
                  } else if (jqXHR.status == 404) {
                      alert('Requested page not found. [404]');
                  } else if (jqXHR.status == 500) {
                      alert('Internal Server Error [500].');
                  } else if (exception === 'parsererror') {
                      alert('Requested JSON parse failed.');
                  } else if (exception === 'timeout') {
                      alert('Time out error.');
                  } else if (exception === 'abort') {
                      alert('Ajax request aborted.');
                  } else {
                      alert('Uncaught Error.n' + jqXHR.responseText);
                  }
               }
            });
         }
         if (valor_comprobante == 3){
            $.ajax({
               url: "conexiones/busca_comprobante.php",
               method: 'post',
               data: { opc: opc, compr: valor_comprobante, fecha1: "20000101", fecha2: "20000101", nro_compro: nro_comprobante },
               dataType: "json",
               success: function (datos) {            
                  if (datos.respuesta == "No hay datos cargados"){
                     resultados.append('<h3>No hay registros</h3>');
                  }
                  else {
                     resultados.append('<caption><center><label>CHEQUES</center></label></caption>');
                     resultados.append('<thead><tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA EMISION</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO.CHEQUE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">BANCO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA PAGO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">DESTINATARIO</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td></tr></thead>');
                     $(datos).each(function (index, item) {
                        if (color == 0){
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio1">' + item.fecha_emision + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.nro_cheque + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.nombre_banco + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.fecha_pago + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.destinatario + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 1;
                        }
                        else {
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio2">' + item.fecha_emision + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.nro_cheque + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.nombre_banco + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.fecha_pago + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.destinatario + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 0;
                        }
                     });
                  }
               },
               error: function (jqXHR, exception) {
                  //alert("Hubo un error al consultar detalle! ");
                  if (jqXHR.status === 0) {
                      alert('Not connect.n Verify Network.');
                  } else if (jqXHR.status == 404) {
                      alert('Requested page not found. [404]');
                  } else if (jqXHR.status == 500) {
                      alert('Internal Server Error [500].');
                  } else if (exception === 'parsererror') {
                      alert('Requested JSON parse failed.');
                  } else if (exception === 'timeout') {
                      alert('Time out error.');
                  } else if (exception === 'abort') {
                      alert('Ajax request aborted.');
                  } else {
                      alert('Uncaught Error.n' + jqXHR.responseText);
                  }
               }
            });
         }
         if (valor_comprobante == 4){
            $.ajax({
               url: "conexiones/busca_comprobante.php",
               method: 'post',
               data: { opc: opc, compr: valor_comprobante, fecha1: "20000101", fecha2: "20000101", nro_compro: nro_comprobante },
               dataType: "json",
               success: function (datos) {            
                  if (datos.respuesta == "No hay datos cargados"){
                     resultados.append('<h3>No hay registros</h3>');
                  }
                  else {
                     resultados.append('<caption><center><label>NOTAS</center></label></caption>');
                     resultados.append('<thead><tr><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">FECHA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">NRO.DE NOTA</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">IMPORTE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">DETALLE</td><td align="center" style="background-color:rgba(230, 52, 74, 0.8);">OBSERVACIONES</td></tr></thead>');
                     $(datos).each(function (index, item) {
                        if (color == 0){
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio1">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.id_nota + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.detalle + '</td>');
                           resultados.append('<td align="center" class="propio1">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 1;
                        }
                        else {
                           resultados.append('<tr>');
                           resultados.append('<td align="center" class="propio2">' + item.fecha + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.id_nota + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.importe + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.detalle + '</td>');
                           resultados.append('<td align="center" class="propio2">' + item.observaciones + '</td>');
                           resultados.append('</tr>');
                           color = 0;
                        }
                     });
                  }
               },
               error: function (jqXHR, exception) {
                  //alert("Hubo un error al consultar detalle! ");
                  if (jqXHR.status === 0) {
                      alert('Not connect.n Verify Network.');
                  } else if (jqXHR.status == 404) {
                      alert('Requested page not found. [404]');
                  } else if (jqXHR.status == 500) {
                      alert('Internal Server Error [500].');
                  } else if (exception === 'parsererror') {
                      alert('Requested JSON parse failed.');
                  } else if (exception === 'timeout') {
                      alert('Time out error.');
                  } else if (exception === 'abort') {
                      alert('Ajax request aborted.');
                  } else {
                      alert('Uncaught Error.n' + jqXHR.responseText);
                  }
               }
            });
         }
      }
      else {
         alert ("Debe seleccionar el tipo de comprobante y completar n\u00FAmero de comprobante.")
      }
   }
}
///////////////////////////////FIN DE FUNCIONES DE BUSQUEDA////////////////////////////////////////