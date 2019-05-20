class Functions {
    constructor() {
        this.IsEdit = 0;
        this.IsId = 0;
    }
    //obtener tablas
    getTable(val, page, table) {
        let control = null;
        if (table == 2) {
            control = "Inventario/getAlumnos";
        }
        else if (table == 3) {
            control = "Inventario/getMateriales";
        }
        else if(table == 4){
            control = "Principal/getPrincipal";
        }
        let v = val != null ? val : "";
        $.post(
            URL + control,
            {
                filter: v,
                page: page
            },
            (Response) => {
                if (table == 2) {
                    try {
                        let item = JSON.parse(Response);
                        $("#filterTableAlumno").html(item.dataFilter);
                        $("#paginadorAlumno").html(item.paginador);
                    } catch (error) {
                        $("#paginadorAlumno").html(Response);
                    }
                }
                else if (table == 3) {
                    try {
                        let item = JSON.parse(Response);
                        $("#filterTableMaterial").html(item.dataFilter);
                        $("#paginadorMaterial").html(item.paginador);
                    } catch (error) {
                        $("#paginadorMaterial").html(Response);
                    }
                }
                else if(table==4){
                    try {
                        let item = JSON.parse(Response);
                        $("#filtrarTablePrincipal").html(item.dataFilter);
                        $("#paginadorPrincipal").html(item.paginador);
                    } catch (error) {
                        $("#paginadorPrincipal").html(Response);
                    }    
                }
            });
    }

    //obtener selects

    getSelect(inf, op, sel) {
        let control = null;
        let campo = null;
        let count = 1;
        if (sel == 1) {
            control = "Inventario/getCarreras";
            campo = "carreras";
        }
        else if (sel == 2) {
            control = "Inventario/getCategorias";
            campo = "categorias";
        }
        $.post(
            URL + control,
            {},
            (Response) => {
                try {
                    var item = JSON.parse(Response);
                    document.getElementById(campo).options[0] = new Option("Seleccione una opcion", 0);
                    if (item.result.length > 0) {
                        for (let i = 0; i < item.result.length; i++) {
                            switch (op) {
                                case 1:
                                    if (sel == 1) {
                                        document.getElementById(campo).options[count] = new Option(item.result[i].short_name, item.result[i].idcarrera);
                                    }
                                    else if (sel == 2) {
                                        document.getElementById(campo).options[count] = new Option(item.result[i].name, item.result[i].id_categoria);
                                    }

                                    count++;
                                    $('select').formSelect();
                                    break;
                                case 2:
                                    if (sel == 1) {
                                        document.getElementById(campo).options[count] = new Option(item.result[i].short_name, item.result[i].idcarrera);
                                        if (item.result[i].short_name == inf) {
                                            i++;
                                            document.getElementById(campo).selectedIndex = i;
                                            i--;
                                        }

                                    }
                                    else if (sel == 2) {
                                        document.getElementById(campo).options[count] = new Option(item.result[i].name, item.result[i].id_categoria);
                                        if (item.result[i].short_name == inf) {
                                            i++;
                                            document.getElementById(campo).selectedIndex = i;
                                            i--;
                                        }
                                    }
                                    count++;
                                    $('select').formSelect();
                                    break;
                            }

                        }
                    }
                } catch (error) {
                    console.log("YA QUIERO DORMIR! " + error);
                }

            }
        );
    }

    //insertar datos 
    insertData(frm, table, edit) {
        var im = null;
        var data = frm;
        console.log(data);
        if (table == 1) {
            var url = edit == 0 ? "Inventario/insertAlumno" : "Inventario/updateAlumno";
            im = M.Modal.getInstance($('#modal1'));
        }
        else if (table == 2) {
            var url = edit == 0 ? "Inventario/insertArticulo" : "Inventario/updateArticulo";
            im = M.Modal.getInstance($('#modal2'));
        }

        $.ajax({
            url: URL + url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            success: (Response) => {
                console.log(Response);
                if (Response == 0) {
                    M.toast({ html: "Se guardo correctamente perro!!" });
                    if (table == 1) {
                        this.getTable(null, 1, 2);
                        im.close();
                    }
                    else if (table == 2) {
                        this.getTable(null, 1, 3);
                        im.close();
                    }
                }
                else {
                    if (Response == 1) {
                        M.toast({ html: "Datos existentes!!", classes: 'rounded' });
                    }
                    else {
                        M.toast({ html: Response, classes: 'rounded' });
                    }
                }
            }
        });
    }

    //elimina datos
    deleteData(id, table) {
        let url = null;
        if (table == 1) {
            url = "Inventario/deleteAlumno";
        }
        else if (table == 2) {
            url = "Inventario/deleteArticulo";
        }
        $.post(
            URL + url,
            {
                idData: id
            },
            (response) => {
                if (response == 0) {
                    M.toast({ html: "Se elimino correctamente perro!!" });
                }
                else {
                    M.toast({ html: response, classes: 'rounded' });
                }
                console.log(response);
            });
    }

    //insertar o actualizar prestamo
    insertPrestamo(data,op)
    {
        var url = op == 0 ? "Inventario/insertPrestamo" : "Inventario/updatePrestamo"; 
        var im = op == 0 ? M.Modal.getInstance($('#modal4')) : M.Modal.getInstance($('#modal10'));
        $.ajax({
            url: URL + url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            success: (Response) => {
                console.log(Response);
                if (Response == 0) {
                    M.toast({ html: "Se guardo correctamente perro!!" });
                    this.getTable(null,1,3);
                    im.close();
                }
                else if(Response==1) {
                    M.toast({ html: "Alumno no registrado!!", classes: 'rounded' });
                }
                else if(Response==2){
                    M.toast({ html: "Material no Disponible!!", classes: 'rounded' });
                }
                else{
                    M.toast({ html: Response, classes: 'rounded' });
                    console.log(Response);
                }
            }
        });
    }
}