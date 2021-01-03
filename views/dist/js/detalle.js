$(document).ready(function() {


    $("#btmenos").click(function(e) {

        var cantidad = parseInt($("#amount").val());
        if (cantidad != 1)
            cantidad -= 1;
        else
            cantidad = 1;

        $("#amount").val(cantidad);
        price(cantidad);

    });

    $("#btmas").click(function(e) {
        var cantidad = parseInt($("#amount").val());
        cantidad += 1;
        $("#amount").val(cantidad);
        price(cantidad);

        var prod_name = $("#product_name").html();
        var subtotal = $("#subtotal-" + prod_name).html();

    });

    //FUNCION PARA UTILIZAR EN LA VISTA DETALLE.PHP
    function price(cantidad) {
        var precio = parseFloat($("#price").html().replace('$', '').replace(',', '').replace('.', ''));


        $("#total").html("Total: $" + parseFloat(precio * cantidad).toLocaleString(window.document.documentElement.lang));


        //$("#total").html("Total: $"+parseFloat(total).toLocaleString(window.document.documentElement.lang));

    }

    $('#agregar').on('click', function() {
        agregar();
    });

    function agregar() {

        var product_id = $("#product_id").html();
        var instructions = $("#instructions").val();
        var product_amount = parseInt($("#amount").val());
        var total = $("#total").html().replace('Total: $', '').replace('.', '').replace(',', '');
        var session_id = $("#session_id").html();

        $.ajax({
            url: "../controller/add_car.php",
            data: { product_id: product_id, instructions: instructions, product_amount: product_amount, total: total, session_id: session_id },
            type: "POST",
            dataType: "json",
            success: function(datos) {

                switch (datos.success) {
                    case "0":
                        toastr.error(datos.message);
                        break;
                    case "1":
                        toastr.success(datos.message);
                        $("#cantidad_carshop").html(Number($('#cantidad_carshop').html()) + 1).change();
                        break;
                    case "2":
                        toastr.warning(datos.message);
                        break;
                    case "3":
                        toastr.warning(datos.message);
                        break;
                }
            }
        });


    };

    /**METODOS PARA SALES */

    $("#new-address").click(function(e) {

        $(".new-address-form").show('1000');
        $(".vlr-domicilio").show('1000');

        $(".address-new").hide('1000');

    });

    /**FIN METODOS SALES */


});

//**INICIO DE FUNCIONES ***/

function btmas(product_id, item, session_id) {

    var cantidad = parseInt($("#amount-" + item).val());
    cantidad += 1;
    $("#amount-" + item).val(cantidad);
    price(cantidad, item, session_id);

    //console.log("Cantidad elementos car: " + $("#cantidad_carshop").html());

    //console.log("Cantidad elementos car: " + (parseInt($("#cantidad_carshop").html()) + 1) );

}

function btmenos(product_id, item, session_id) {

    var cantidad = parseInt($("#amount-" + item).val());
    if (cantidad != 1)
        cantidad -= 1;
    else
        cantidad = 1;

    $("#amount-" + item).val(cantidad);
    price(cantidad, item, session_id);
}

//FUNCION PARA UTILIZAR EN LA VISTA CARSHOP.PHP
function price(cantidad, item, session_id) {
    var precio = parseFloat($("#price-" + item).html().replace('$&nbsp;', '').replace(',', '').replace('.', ''));
    var total = 0,
        subtotal = 0;

    subtotal = precio * cantidad;
    $("#subtotal-" + item).html("Subtotal $" + parseFloat(subtotal).toLocaleString(window.document.documentElement.lang));

    $(".item-product-price-detail").each(function() {
        //console.log("Elemento: " + $(this).html() + ", valor: " + parseFloat($(this).html().replace('Subtotal $', '').replace(',', '').replace('.', '')));
        total += parseFloat($(this).html().replace('Subtotal $', '').replace(',', '').replace('.', ''));
    });

    $("#total").html("Total: $" + parseFloat(total).toLocaleString(window.document.documentElement.lang));

    update_car(cantidad, $("#instructions-" + item).val(), subtotal, item, session_id)

}

function bteliminar(product_id, session_id) {

    //console.log("Id elemento: " + product_id + ", session_id: " + session_id);

    $.ajax({
        url: "../controller/del_car.php",
        data: { product_id: product_id, session_id: session_id },
        type: "POST",
        dataType: "json",
        success: function(datos) {

            //console.log(datos);

            if (datos.success == "1") {
                toastr.success(datos.message);

                $("div").remove("#product-" + product_id);

                //console.log($("#cantidad_carshop").val());

                $("#cantidad_carshop").html((parseInt($("#cantidad_carshop").html()) - 1));

                var total = 0;
                $(".item-product-price-detail").each(function() {
                    //console.log("Elemento: " + $(this).html() + ", valor: " + parseFloat($(this).html().replace('Subtotal $', '').replace(',', '').replace('.', '')));
                    total += parseFloat($(this).html().replace('Subtotal $', '').replace(',', '').replace('.', ''));
                });

                $("#total").html("Total: $" + parseFloat(total).toLocaleString(window.document.documentElement.lang));
            }

            if (datos.success == "0") {
                toastr.error(datos.message);
            }

            if (datos.success == "2") {
                toastr.warning(datos.message);
            }
        }
    });

}

function update_car(carshop_product_amount, carshop_instructions, carshop_total, product_id, session_id) {

    //console.log("Datos: " + carshop_product_amount + ", " + carshop_instructions + ", " + carshop_total + ", " + product_id + ", " + session_id);

    $.ajax({
        url: "../controller/update_car.php",
        data: { carshop_product_amount: carshop_product_amount, carshop_instructions: carshop_instructions, carshop_total: carshop_total, product_id: product_id, session_id: session_id },
        type: "POST",
        dataType: "json",
        success: function(datos) {

            //console.log(datos);

            if (datos.success == "1") {
                //toastr.success(datos.message);
                //console.log(datos.message);
            }

            if (datos.success == "0") {
                toastr.error(datos.message);
            }

            if (datos.success == "2") {
                toastr.warning(datos.message);
            }
        }
    });

}

/**FIN METODOS CARSHOP */

/**INICIO METODOS SALES */

function domicilio(total, session_id) {

    $(".address-new").show('1000');
    $(".vlr-domi").show('1000');
    $(".new-address-form").hide('1000');

    $('#direcciones').empty();

    var domicilio = $("#domicilio").html().replace('Domicilio: $', '').replace(',', '').replace('.', '');
    $("#total").html("Total: $" + (parseFloat(total) + parseFloat(domicilio)).toLocaleString(window.document.documentElement.lang));

    //console.log("Datos: " + session_id);

    $.ajax({
        url: "../controller/get_address.php",
        data: { session_id: session_id },
        type: "POST",
        dataType: "json",
        success: function(datos) {

            //console.log("Datos: " + Object.keys(datos).length + " - Estado: " + datos[0].success);

            if (datos[0].success == "1") {

                //Limpio el select porque se ejecuta dos veces la peticion ajax
                //$('select').empty().append('Seleccionar');

                for (var i = 0; i < parseInt(Object.keys(datos).length); i++)
                    $('#direcciones').append('<option value="' + datos[i].cl_id + '">' + datos[i].cl_alias_address + '</option>');


                /***OTRA FORMA DE LLENAR EL SELECT */
                /*
                $(datos).each(function(i, v) { // indice, valor
                    $('#direcciones').append('<option value="' + datos[i].cl_address + '">' + datos[i].cl_alias_address + '</option>');
                })
                */
            } else {
                $('#direcciones').append('<option value="0">Agregue una dirección</option>');
            }
        }
    });

}

function sitio(total) {

    $(".new-address-form").hide('1000');
    $(".address-new").hide('1000');
    $(".vlr-domi").hide('1000');

    $(".new-address-form").hide('1000');
    $(".vlr-domicilio").hide('1000');

    $("#total").html("Total: $" + parseFloat(total).toLocaleString(window.document.documentElement.lang));
}

function guardar_address(session_id, total) {

    var email = $("#email").val();
    var name = $("#name").val();
    var phone = $("#phone").val();
    var address = $("#direccion").val();
    var tipo_domicilio = $('#type option:selected').text();
    var detail_address = $("#detail_address").val();
    var alias_address = $("#alias_address").val();
    var instructions_address = $("#details").val();

    //VALIDAMOS EL FORMULARIO ANTES DE GUARDARLO CON ESTA LINEA...
    //$("#form-address-new").validate();

    if (validar_form_dir())
        $.ajax({
            url: "../controller/add_cliente.php",
            data: { email: email, name: name, phone: phone, address: address, type_address: tipo_domicilio, detail_address: detail_address, alias_address: alias_address, instructions_address: instructions_address, session_id: session_id },
            type: "POST",
            dataType: "json",
            success: function(datos) {

                if (datos.success == "1") {
                    toastr.success(datos.message);
                    domicilio(total, session_id);
                    limpiar_form_dir();
                }

                if (datos.success == "0") {
                    toastr.error(datos.message);
                }

                if (datos.success == "2") {
                    toastr.warning(datos.message);
                }
            }
        });


}

function validar_form_dir() {

    var email = $("#email").val();
    var name = $("#name").val();
    var phone = $("#phone").val();
    var address = $("#direccion").val();
    var tipo_domicilio = $('#type option:selected').text();
    var detail_address = $("#detail_address").val();
    var alias_address = $("#alias_address").val();
    var instructions_address = $("#details").val();

    console.log();


    if (email == "" || !email.includes("@")) {
        toastr.warning("Ingrese un correo valido.");
        $("#email").focus();
        return false;
    }

    if (name == "") {
        toastr.warning("Ingrese un nombre valido.");
        $("#name").focus();
        return false;
    }

    if (phone == "0" || phone == "" || phone.length < 5) {
        toastr.warning("Ingrese un telefono valido.");
        $("#phone").focus();
        return false;
    }

    if (address == "") {
        toastr.warning("Ingrese una direccion valida.");
        $("#direccion").focus();
        return false;
    }

    return true;
}

function limpiar_form_dir() {
    $("#email").val('');
    $("#name").val('');
    $("#phone").val('');
    $("#direccion").val('');
    $('#type').val('');
    $("#detail_address").val('');
    $("#alias_address").val('');
    $("#details").val('');
}




function pagar(session_id) {
    console.log("Datos: " + session_id);





}

/**FIN METODOS SALES */