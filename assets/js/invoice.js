
function calculateMonth( date ) {
    console.log(date)
    $('#ModalLabel').append("Rozliczenie za {{month}}")
    $.ajax({
    type: 'POST',
    url: "/ajaxMonth" ,
    data: {date: date},
    dataType: 'json', 
    
    beforeSend:function () {
        document.getElementById('loader').classList.remove('d-none');
    },
    complete:function(){
        document.getElementById('loader').classList.add('d-none');
    },
    success:function(data){
        console.log(data)
           $('#tableModal').append("<thead><tr><th scope='col'>Nazwa</th><th scope='col'>Wartość zwykła</th><th scope='col'>Wartość specialna</th></tr></thead> ")
             for(i = 0; i < data.length; i++) {  
                category = data[i];  
                var e = $('<tbody><tr><td id = "name">  </td><td id = "value">  </td><td id = "specialValue">  </td></tr>');
                
                console.log(date[1]['name'])
                $('#name', e).html(category['name']);  
                $('#value', e).html(category['value']);  
                $('#specialValue', e).html(category['specialValue']);  
                $('#tableModal').append(e);  
             }
             $('#tableModal').append("</tbody>")
    },
    error:function(xhr, textStatus, errorThrown){
        alert('Ajax request failed.'); 
    }
    })
}

function calculateYear( date ) {
    console.log(date)
    $('#ModalLabel').append("Rozliczenie za {{year}}")
    $.ajax({
    type: 'POST',
    url: "/ajaxYear" ,
    data: {date: date},
    dataType: 'json', 
    
    beforeSend:function () {
        document.getElementById('loader').classList.remove('d-none');
    },
    complete:function(){
        document.getElementById('loader').classList.add('d-none');
    },
    success:function(data){
        console.log(data)
           $('#tableModal').append("<thead><tr><th scope='col'>Nazwa</th><th scope='col'>Wartość zwykła</th><th scope='col'>Wartość specialna</th></tr></thead> ")
             for(i = 0; i < data.length; i++) {  
                category = data[i];  
                var e = $('<tbody><tr><td id = "name">  </td><td id = "value">  </td><td id = "specialValue">  </td></tr>');
                
                console.log(date[1]['name'])
                $('#name', e).html(category['name']);  
                $('#value', e).html(category['value']);  
                $('#specialValue', e).html(category['specialValue']);  
                $('#tableModal').append(e);  
             }
             $('#tableModal').append("</tbody>")
    },
    error:function(xhr, textStatus, errorThrown){
        alert('Ajax request failed.'); 
    }
    })
}

 function erase() {
     $("#Modal").on("hidden.bs.modal", function(){
        $("#tableModal").html("");
        $("#ModalLabel").html("");
    });
 }

