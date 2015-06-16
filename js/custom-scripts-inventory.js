

$(document).ready(function(){
    // Initialize collapse button
    $(".button-collapse").sideNav();

    // Initialize Modal
    $('.modal-trigger').leanModal();

    //Initialize Flip
    $(".flip").flip({
        axis: 'y',
        trigger: 'click',
        speed: 300
    });

    $('#deleteInv').click(function(){
        confirmDelete();
    });

    $('#editInv').click(function(){
        editInventory();
    });

    $('#addInv').click(function(){
        addInventory();
    });

    $('#seeInv').click(function(){
        seeInventory();
    });

    $('input:checkbox').each(function(){
        $(this).prop('checked', false);
    });
});


function checkboxToggle(checkbox){
    if ($(checkbox).prop('checked')){
        $(checkbox).prop('checked',false);
        console.log($(checkbox).prop('checked'));
    }
    else{
        $(checkbox).prop('checked',true);
        console.log($(checkbox).prop('checked'));
    }
}

function addInventory(){
    var wrapper=$('#inventory-wrapper');
    $('.material-tooltip').each(function(){
        $(this).remove();
    });
    $('#action-button-wrapper').html('');
    wrapper.load('./../aux-html/addInv.html', function(){  });
}

function editInventory(){
    if ($("input:checkbox:checked").length == 1){
        var invName=$("input:checkbox:checked").parent('div.secondary-content').siblings('span.title').html();
        var invDesc=$("input:checkbox:checked").parent('div.secondary-content').siblings('p.description').html();
        var wrapper=$('#inventory-wrapper');
        $('.material-tooltip').each(function(){
            $(this).remove();
        });
        $('#action-button-wrapper').html('');
        wrapper.load('./../aux-html/editInv.html', function(){
            $('label[for=name]').addClass('active');
            $('#name').val(invName);
            $('label[for=desc]').addClass('active');
            $('#desc').val(invDesc);
            $('#old-name').val(invName);
        });
    }
    else if ($("input:checkbox:checked").length == 0){
        Materialize.toast('No se ha seleccionado ningun inventario.', 4000);
    }
    else{
        Materialize.toast('Por favor seleccione solo UN inventario para modificar.', 4000);
    }
}

function confirmDelete(){
    if ($("input:checkbox:checked").length > 0){
        $('#modal_delete').openModal();
    }
    else{
        Materialize.toast('No se ha seleccionado ningun inventario.', 4000);
    }
}

function seeInventory(){
    if ($("input:checkbox:checked").length == 1){
        var invName=$("input:checkbox:checked").parent('div.secondary-content').siblings('span.title').html();
        console.log(invName);
        window.location = "./../pages/fichas.php?see="+invName;
    }
    else if ($("input:checkbox:checked").length == 0){
        Materialize.toast('No se ha seleccionado ningun inventario.', 4000);
    }
    else{
        Materialize.toast('Por favor seleccione solo UN inventario para ver.', 4000);
    }
}