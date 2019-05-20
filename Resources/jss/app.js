/**codigo de usuarios */
var data_u = null;
var id_edit = 0;
var users = new Users();
var inventary = new Inventary();
var reports= new Reports();
var fun = new Functions();
var principal = new Principal();

$().ready(() => {
    var URLactual = window.location.pathname;
    users.userData(URLactual);
    principal.linkPrincipal(URLactual);
    $("#validate").validate();
    /*$('.sidenav').sidenav();
    $('.modal').modal();
    $('select').formSelect();
    $('.collapsible').collapsible();
    $('.datepicker').datepicker();*/
    M.AutoInit();
    $(".datepicker").datepicker({format:"yyyy-mm-dd"});

    //codigo para el stick nav
    if ( $(".nav").length > 0 ) {
        var stickyNavTop = $('.nav').offset().top;
      }
    
    var stickyNav = function () {
        var scrollTop = $(window).scrollTop(); // our current vertical position from the top                
        if (scrollTop > stickyNavTop) {
            $('.nav').addClass('sticky');
        } else {
            $('.nav').removeClass('sticky');
        }
    };
    stickyNav();
    $(window).scroll(function () {
        stickyNav();
    });
});

var loginuser = () => {
    var usuario = document.getElementById("user").value;
    var contra = document.getElementById("pass").value;
    users.loginuser(usuario, contra);
}
//termina la session
var sessionClose = () => {
    users.sessionClose();
}
//limpia y actualiza tabla
var restablecerUser = () => {
    users.restablecerUser();
}
//registra nuevo usuario
var registrarUser = () => {
    let idU = document.getElementById('idU').value;
    let nombre = document.getElementById('Nombre').value;
    let usuario = document.getElementById('usuario').value;
    let contra = document.getElementById('contra').value;
    let rol = document.getElementById('roles').value;
    users.insertUser(idU, nombre, usuario, contra, rol);
    //alert(nombre+usuario+pass+rol);
}
//limpia
var clear = () => {
    users.limpiar();
}
//usuario
var getUsers = (page) => {
    let val = document.getElementById('filtrarUser').value;
    users.getUser(val, page);
}
//obtiene datos del usuario
var dataUser = (data) => {
    users.editUser(data);
    //console.log(data);
}
//elimina usuarios
var deleteUser = (data) => {
    document.getElementById('nameD').innerHTML = data.name;
    data_u = data;
}

//elimina usuario
$('#btnDelete').click(function () {
    users.deleteUse(data_u);
    data_u = null;
});

//////////////////AREA DE ALUMNO////////////////
//tabla alumno 
var getAlumno = (page) => {
    let val = document.getElementById('filtrarAlumno').value;
    fun.getTable(val, page, 2);
    //inventary.getAlumno(val,page);
}
//editar alumno
var dataAlumno = (data) => {
    id_edit = data.numcontrol;
    fun.getSelect(data.short_name, 2, 1);
    inventary.llenarForm(data.nameA, data.numcontrol, data.phone);
    //inventary.getAlumno(val,page);
}
//manda campos de alumno
var deleteAlumno = (data) => {
    document.getElementById("nmAlumno").innerHTML = data.nameA;
    id_edit = data.numcontrol;
}
//abre modal. blanquea campos y llena el select de alumno
$('#nuevoAlumno').click(function () {
    fun.getSelect(null, 1, 1);
    inventary.restablecerAlumno();
});
//registra nuevo alumno
$('#btnnuevoAlumno').click(function () {
    if (inventary.getDataAlumno() != "") {
        fun.insertData(inventary.getDataAlumno(), 1, id_edit);
        inventary.restablecerAlumno();
        id_edit = 0;
    }
});
//Elimina alumno
$('#btnEliminarAlumno').click(function () {
    fun.deleteData(id_edit, 1);
    getAlumno(1);
    document.getElementById("nmAlumno").innerHTML = "";
    id_edit = 0;

});

//blanquea campos del modal alumno
$('#btnCancelarAlumno').click(function () {
    inventary.restablecerAlumno();
    id_edit = 0;
});

//////////////////////////----MATERIAL---///////////////////////////////////

//obtiene select categorias al aplastar nuevo
$('#nuevoMaterial').click(function () {
    fun.getSelect(null, 1, 2);
    inventary.restablecerArticulo();
    id_edit = 0;
});

//registra nuevo material btnNuevoArticulo
$('#btnNuevoArticulo').click(function () {
    if (inventary.getDataArticulo(id_edit) != "") {
        fun.insertData(inventary.getDataArticulo(id_edit), 2, id_edit);
        inventary.restablecerArticulo();
        id_edit = 0;
    }
});

//elimina articulo btnEliminarArticulo
$('#btnEliminarArticulo').click(function () {
    fun.deleteData(id_edit, 2);
    getArticulo(1);
    document.getElementById("nCat").innerHTML = "";
    document.getElementById("nCod").innerHTML = "";
    id_edit = 0;
});

//material
var getArticulo = (page) => {
    let val = document.getElementById('filtrarMaterial').value;
    fun.getTable(val, page, 3);
    //inventary.getAlumno(val,page);
}
//cargar datos en modal
var dataMaterial = (data) => {
    inventary.llenarFormArticulo(data);
    fun.getSelect(data.categoria, 2, 2);
    id_edit = data.idarticulo;
}
//cargar datos en modal eliminar
var deleteMaterial = (data) => {
    document.getElementById("nCat").innerHTML = data.name;
    document.getElementById("nCod").innerHTML = data.bar_code;
    id_edit = data.idarticulo;
}

//////////////prestamo////////////

//cargar datos en modal prestamo
var dataPrestamo = (data) => {
    document.getElementById('Ibar').value=data.idarticulo;
}

$('#btnPrestamo').click(function () {
    if(inventary.getDataPrestamo()!="")
    {
        fun.insertPrestamo(inventary.getDataPrestamo(),0);
        document.getElementById('Ibar').value="";
        document.getElementById('Icontrol').value="";
        document.getElementById('comentario').value="";
    }  
});
$('#btnCancelarPrestamo').click(function () {  
        document.getElementById('Ibar').value="";
        document.getElementById('Icontrol').value="";
        document.getElementById('comentario').value="";
});

$('#btnPrestamoU').click(function () {  
    let data = new FormData();
    let f = new Date();
    let hoy= f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
    data.append("comentario_entrega",document.getElementById('comentario').value);
    data.append("fecha_entrega",hoy);
    data.append("codigo_barras",document.getElementById('codeP').value)
    data.append("id",id_edit);
    fun.insertPrestamo(data,1);
    id_edit=0;
    getPrincipal(1);
});

//////principal/////
var getPrincipal = (page) => {
    let val = document.getElementById('filtrarPrincipal').value;
    fun.getTable(val, page, 4);
    //inventary.getAlumno(val,page);
}

var dataNewPrestamo =(data) =>{
    document.getElementById('Ibar').value=data.idarticulo;
    if(data.prestado ==1)
    {
        $('#btnPrestamo').attr('disabled', true);
        $('#nosepuede').attr('hidden', false);
    }
    else
    {
        $('#btnPrestamo').attr('disabled', false);
        $('#nosepuede').attr('hidden', true);
    }
}

var dataPrestamo = (data) => {
    id_edit=data.id;
    document.getElementById('codeP').value=data.codigo_barras;
    document.getElementById('materialP').value=data.name;
    document.getElementById('fpP').value=data.fecha_prestamo;
    document.getElementById('fdP').value=data.fecha_vencido;
    document.getElementById('nombreP').value=data.nameA;
    document.getElementById('phone').value=data.phone;
    document.getElementById('comentario').value="";

    //fun.getTable(val, page, 4);
    //inventary.getAlumno(val,page);
}
//////////////////////////// Reportes ///////////////////////////

$('#btnMaterialF').click(function () {     
    window.open(URL+"Reportes/materialFaltante", '_blank');    
});
$('#btnMaterialA').click(function(){
    window.open(URL+"Reportes/materialUbicacion", '_blank'); 
});
$('#btnCodeBar').click(function(){
    window.open(URL+"Reportes/codeBar", '_blank'); 
});

/////////////// Respaldos ///////////////

$('#btnSubirBack').click(function () {     
let miarchivo =document.getElementById('miarchivo').files[0];
    if(miarchivo!="")
    {
        let data= new FormData();
        data.append("myfile",document.getElementById('miarchivo').files[0]);
        $.ajax({
            url: URL + "Respaldos/restore",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            success: (Response) => {
                if (Response == 0) {
                    M.toast({ html: "Se guardo correctamente!" });
                }
                else {
                    console.log(Response);
                    M.toast({ html: Response, classes: 'rounded' });
                }
            }
        });
    }
    else
    {
        M.toast({ html: "Datos vacios!!", classes: 'rounded' });
        document.getElementById('miarchivo').focus();
    }
});


