window.onload = Consult
var global;
var contador = 1;


function selectProducts(id, idSelect) {
    var result;
    $.ajax({
        type: "POST",
        data: "idProduct=" + id,
        url: "Select_Products.php",
        dataType: "json",
        success: function(r) {
            console.log(r, id);
            $('#idProduct_' + idSelect).val(r[0][1]);
            $('#price_' + idSelect).val(r[0][0]);
        }
    });
    return result;

}

function selectClient(value) {
    if (value == null) {
        alert("Por favor ingresa un cliente");
    }
}

function validateQuantity(cantidad, idSelect) {
    let value = document.getElementById('idProduct_' + idSelect).value;
    if (Number(cantidad) > Number(value)) {
        console.log(cantidad + "     valor: " + value);
        alert('Cantidad ingresada no valida. Cantidad disponible: ' + value);
        $('#quantity_' + idSelect).val(1);
    }
}

function ChargeAllConsult(count) {
    for (i = 1; i < count + 1; i++) {
        $(document).ready(function() {
            $('#productCode_' + i).select2();
        });
    };
}

function Consult() {
    name = "hola"
    $.ajax({
        type: "POST",
        data: "table=" + name,
        url: "Select_Products.php",
        dataType: "json",
        success: function(r) {
            global = r;
            ChargeAllConsult(r.length);
        }
    });
    return global;
}
$(document).ready(function() {
    $(document).on('click', '#checkAll', function() {
        $(".itemRow").prop("checked", this.checked);
    });
    $(document).on('click', '.itemRow', function() {
        if ($('.itemRow:checked').length == $('.itemRow').length) {
            $('#checkAll').prop('checked', true);
        } else {
            $('#checkAll').prop('checked', false);
        }
    });
    var count = $(".itemRow").length;


    $(document).on('click', '#addRows', function() {
        count++;
        var datos;
        for (i = 1; i <= global.length; i++) {
            items = global[i - 1];
            datos += '<option value="' + items[0] + '">' + items[1] + '</option>';
        }
        var htmlRows = '';
        htmlRows += '<tr>';
        htmlRows += '<td><input class="itemRow" type="checkbox"></td>';
        htmlRows += '<td><input type="text" style="display: none;" name="productName[]" id="productName_' + count + '" class="form-control" autocomplete="off" readonly="readonly"><select name="productCode[]" id="productCode_' + count + '" class="form-control" onchange="javascript:selectProducts(this.value,' + count + ');"><option selected>Seleccione alguno</option>' + datos + '</select></td>';
        htmlRows += '<td><input type="number" style="display: none;" id="idProduct_' + count + '"><input type="number" name="quantity[]" id="quantity_' + count + '" class="form-control quantity" autocomplete="off" onchange="javascript:validateQuantity(this.value,' + count + ');"></td>';
        htmlRows += '<td><input type="number" name="price[]" id="price_' + count + '" class="form-control price" ></td>';
        htmlRows += '<td><input type="number" name="descuento[]" id="descuento_' + count + '" class="form-control total" autocomplete="off"></td>';
        htmlRows += '<td><input type="number" name="total[]" id="total_' + count + '" class="form-control total" autocomplete="off" readonly="readonly"></td>';
        htmlRows += '</tr>';
        $('#invoiceItem').append(htmlRows);
        $('#productCode_' + count).select2();
    });
    $(document).on('click', '#removeRows', function() {
        $(".itemRow:checked").each(function() {

            if (this.checked) {
                selected = $(this).val();
                if (confirm("¿Seguro que desea eliminar el producto seleccionado?")) {
                    $.ajax({
                        url: "Delete_Invoice.php",
                        method: "POST",
                        data: "idDFactura=" + selected,
                        success: function(response) {}
                    });
                } else {
                    return false;
                }

            }

            $(this).closest('tr').remove();

        });
        $('#checkAll').prop('checked', false);
        calculateTotal();
    });
    $(document).on('blur', "[id^=descuento_]", function() {
        calculateTotal();
    });
    $(document).on('blur', "[id^=price_]", function() {
        calculateTotal();
    });
    $(document).on('blur', "#taxRate", function() {
        calculateTotal();
    });
    $(document).on('blur', "#amountPaid", function() {
        var amountPaid = $(this).val();
        var totalAftertax = $('#totalAftertax').val();
        if (amountPaid && totalAftertax) {
            totalAftertax = totalAftertax - amountPaid;
            $('#amountDue').val(totalAftertax);
        } else {
            $('#amountDue').val(totalAftertax);
        }
    });
    $(document).on('click', '.deleteInvoice', function() {
        var id = 7;
        id = $(this).attr("id");
        if (confirm("¿Seguro que desea eliminar la factura selecionada?")) {
            $.ajax({
                url: "Delete_Invoice.php",
                method: "POST",
                data: 'id=' + id,
                success: function(response) {
                    if (response != 0) {
                        $('#' + id).closest("tr").remove();
                    } else {
                        alert("Ya han pasado dos horas desde la creación de la factura");
                    }
                }
            });
        } else {
            return false;
        }
    });
});





function calculateTotal() {
    var totalAmount = 0;
    $("[id^='price_']").each(function() {
        var id = $(this).attr('id');
        id = id.replace("price_", '');
        var price = $('#price_' + id).val();
        var quantity = $('#quantity_' + id).val();
        var descuento = $('#descuento_' + id).val();
        if (!quantity) {
            quantity = 0;
            $('#quantity_' + id).val(0);
        }
        var aux = (price * descuento) / 100;
        aux = aux * quantity;
        var total = (price * quantity) - aux;
        $('#total_' + id).val(parseFloat(total));
        totalAmount += total;
    });
    $('#subTotal').val(parseFloat(totalAmount));
    var taxRate = $("#taxRate").val();
    var subTotal = $('#subTotal').val();
    if (subTotal) {
        var taxAmount = subTotal * taxRate / 100;
        $('#taxAmount').val(taxAmount);
        subTotal = parseFloat(subTotal) + parseFloat(taxAmount);
        $('#totalAftertax').val(subTotal);
        var amountPaid = $('#amountPaid').val();
        var totalAftertax = $('#totalAftertax').val();
        if (amountPaid && totalAftertax) {
            totalAftertax = totalAftertax - amountPaid;
            $('#amountDue').val(totalAftertax);
        } else {
            $('#amountDue').val(subTotal);
        }
    }
}