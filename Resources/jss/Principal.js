class Principal
{
    constructor(){}
    linkPrincipal(link)
    {
        if(link=="/Principal/principal"||link=="/Principal/principal/"){
            document.getElementById("enlace1").classList.add('active','blue','darken-3');
            document.getElementById("e1").classList.add('white-text');
            document.getElementById("i1").classList.add('white-text');
            getPrincipal(1);
        }
        else if(link=="/Inventario/inventario"||link=="/Inventario/inventario/"){
            document.getElementById("enlace2").classList.add('active','blue','darken-3');
            document.getElementById("e2").classList.add('white-text');
            document.getElementById("i2").classList.add('white-text');
            getAlumno(1);
            getArticulo(1);
        }
        else if(link=="/Usuarios/usuario"||link=="/Usuarios/usuario"){
            document.getElementById("enlace3").classList.add('active','blue','darken-3');
            document.getElementById("e3").classList.add('white-text');
            document.getElementById("i3").classList.add('white-text');
            getUsers(1);
        }
        else if(link=="/Reportes/reporte"||link=="/Reportes/reporte/"){
            document.getElementById("enlace4").classList.add('active','blue','darken-3');
            document.getElementById("e4").classList.add('white-text');
            document.getElementById("i4").classList.add('white-text');
        }
        else if(link=="/Respaldos/respaldo"||link=="/Respaldos/respaldo/"){
            document.getElementById("enlace5").classList.add('active','blue','darken-3');
            document.getElementById("e5").classList.add('white-text');
            document.getElementById("i5").classList.add('white-text');
        }
        //alert(link);
    }
}