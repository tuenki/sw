class Inventary{

    constructor(){
        
    }
    //obtener datos alumno
    getDataAlumno() {
        var data = new FormData();
        let nombre = document.getElementById('Nombre').value;
        let nControl= document.getElementById('NControl').value;
        let telefono = document.getElementById('Telefono').value;
        let carrera = document.getElementById('carreras').value;

        if(this.validation(nombre,1)){
            if(this.validation(nControl,1)){
                if (this.validation(telefono,1)) {
                    if (this.validation(carrera,2)) {
                        data.append("numcontrol",nControl);
                        data.append("nameA",nombre);
                        data.append("career",carrera);
                        data.append("phone",telefono);
                        return data;
                    }
                    document.getElementById('carreras').focus();
                    M.toast({ html: "Escoja una opcion", classes: 'rounded' });
                    return "";                    
                }
                else{
                    document.getElementById('Telefono').focus();
                    M.toast({ html: "Ingrese datos en el campo telefono", classes: 'rounded' });
                    return "";
                }
            }
            else{
                document.getElementById('NControl').focus();
                M.toast({ html: "Ingrese datos en el campo Numero de control!!", classes: 'rounded' });
                return ""; 
            }
        }
        else{
            document.getElementById('Nombre').focus();
            M.toast({ html: "Ingrese datos en el campo nombre!!", classes: 'rounded' });
            return "";
        }
    }

    //getDataArticulo

    getDataArticulo(id){
        var data = new FormData();
        let nserie=document.getElementById('serie').value;
        let nitap=document.getElementById('nitap').value;
        let nRM=document.getElementById('nRM').value;
        let bc=document.getElementById('bc').value;
        let modelo=document.getElementById('modelo').value;
        let categorias=document.getElementById('categorias').value;
        let ubicacion=document.getElementById('Ubicacion').value
        let imgi=document.getElementById('imgi').value;
        if (this.validation(nserie,1)) {
            if (this.validation(nitap,1)) {
                if (this.validation(nRM,1)) {
                    if (this.validation(modelo,1)) {
                        if (this.validation(categorias,2)) {
                            if(this.validation(bc,1)){
                                if (this.validation(ubicacion,1)) {
                                    //if (this.validation(imgi,1)) {
                                        if(id>0){
                                            data.append("idarticulo",id);
                                        }
                                        data.append("num_serie",nserie);
                                        data.append("num_itap",nitap);
                                        data.append("num_rm",nRM);
                                        data.append("modelo",modelo);
                                        data.append("categoria",categorias);
                                        data.append("bar_code",bc);
                                        data.append("ubicacion",ubicacion);
                                        data.append("photo",document.getElementById('imgi').files[0]);
                                        return data;
                                   // }
                                   /* else{
                                        document.getElementById('imgi').focus();
                                        M.toast({ html: "Tiene que subir una imagen!!", classes: 'rounded' });
                                        return "";
                                    } */  
                                }
                                else{
                                    document.getElementById('Ubicacion').focus();
                                    M.toast({ html: "Tiene que ingresar ubicacion!!", classes: 'rounded' });
                                     return "";
                                } 
 
                            }else{
                                document.getElementById('bc').focus();
                                M.toast({ html: "Ingrese un numero temporal!!", classes: 'rounded' });
                                return "";
                            }
                        } else {
                            document.getElementById('categorias').focus();
                            M.toast({ html: "Escoja una opcion en categorias!!", classes: 'rounded' });
                            return "";
                        }
                    } else {
                        document.getElementById('modelo').focus();
                        M.toast({ html: "Ingrese datos en el campo modelo!!", classes: 'rounded' });
                        return "";
                    }
                    
                } else {
                        document.getElementById('nRM').focus();
                     M.toast({ html: "Ingrese datos en el campo #RM", classes: 'rounded' });
                    return "";
                }
            } else {
                document.getElementById('nitap').focus();
                M.toast({ html: "Ingrese datos en el campo #itap!", classes: 'rounded' });
                return "";
            }
        } else {
            document.getElementById('serie').focus();
            M.toast({ html: "Ingrese datos en el campo #serie!!", classes: 'rounded' });
            return "";
        }

    }

    getDataPrestamo(){
        var data = new FormData();
        let f = new Date();
        let hoy= f.getFullYear()+"-"+(f.getMonth()+1)+"-"+f.getDate();
        let diaEntrega = f.getFullYear()+"-"+(f.getMonth()+1)+"-"+(f.getDate()+3);
        let ncontro= document.getElementById('Icontrol').value;
        let id= document.getElementById('Ibar').value;
        let coment= document.getElementById('comentario').value;
        if(this.validation(ncontro,1)){
            if(this.validation(id,1)){
                if(this.validation(coment,1))
                {
                    data.append("fecha_prestamo",hoy);
                    data.append("fecha_vencido",diaEntrega);
                    data.append("numero_control",ncontro);
                    data.append("codigo_barras",id);
                    data.append("comentario_prestamo",coment);
                    return data;
                }
                else{
                    document.getElementById('comentario').focus();
                    M.toast({ html: "Es obligatorio el campo comentario", classes: 'rounded' });
                    return "";
                }
            }
            else{
                document.getElementById('Ibar').focus();
                M.toast({ html: "Porfavor no borre los datos precargados", classes: 'rounded' });
                return "";
            }

        }
        else{
            document.getElementById('Icontrol').focus();
            M.toast({ html: "Ingrese datos en numero de control", classes: 'rounded' });
            return "";
        }
    }

    validation(val,type){
        if(type == 1)
        {
            if(val==""){
                return false;
            }
            else{
                return true;
            }
        }
        else if(type==2){
            if(val > 0){
                return true;
            }
            else{
                return false;
            }
        }

    }
    //obtener informacion del alumno y ponerla en el modal
    llenarForm(nombre,control,telefono){
        document.getElementById('Nombre').value=nombre;
        document.getElementById('NControl').value=control;
        document.getElementById('Telefono').value=telefono;
    }

    //limpiar modal alumnos
    restablecerAlumno() {
        document.getElementById('Nombre').value="";
        document.getElementById('NControl').value="";
        document.getElementById('Telefono').value="";
        document.getElementById('carreras').value="0";
    }
    //limpiar articulo
    restablecerArticulo(){
        document.getElementById('serie').value="";
        document.getElementById('nitap').value="";
        document.getElementById('nRM').value="";
        document.getElementById('bc').value="";
        document.getElementById('modelo').value="";
        document.getElementById('categorias').value="0";
        document.getElementById('Ubicacion').value="";
        document.getElementById('imgi').value="";
        document.getElementById('img').value="";
    }
    //llenar modal material
    llenarFormArticulo(data){
        document.getElementById('serie').value=data.num_serie;
        document.getElementById('nitap').value=data.num_itap;
        document.getElementById('nRM').value=data.num_rm;
        document.getElementById('bc').value=data.bar_code;
        document.getElementById('modelo').value=data.modelo;
        document.getElementById('Ubicacion').value=data.ubicacion;
    }
}