class Users {
    constructor() {
        this.IsEdit = 0;
    }

    //metod filter user
    getUser(val,page) {
        let v = val != null ? val : "";
        $.post(
            URL + "Usuarios/getUsers",
            {
                filter: v,
                page:page
            },
            (Response) => {
                try {
                    let item = JSON.parse(Response);
                    $("#filterTable").html(item.dataFilter);
                    $("#paginador").html(item.paginador);
                    console.log(item);
                } catch (error) {
                    $("#paginador").html(Response);
                }
            });
    }
    //metodo de validacion de login
    loginuser(user, pass) {
        if (user == "") {
            document.getElementById("user").focus();
            M.toast({ html: 'Ingrese su usuario' });
        }
        else {
            if (pass == "") {
                document.getElementById("pass").focus();
                M.toast({ html: 'Ingrese su contraseña' });
            }
            else {
                if (validarUs(user,1)) {
                    if (pass.length < 6) {
                        document.getElementById("pass").focus();
                        M.toast({ html: 'Ingrese almenos 6 caracteres' });
                        console.log(pass.length);
                    }
                    else {
                        $.post(
                            "Index/userLogin",
                            { user, pass },
                            (Response) => {
                                if(Response.includes("xdebug-error")){
                                    if(Response.includes("Undefined offset: 0")){
                                        document.getElementById("dErrorL").style.backgroundColor = "#C40D0A";
                                        document.getElementById("indexMessage").innerHTML ="Usuario o Contraseña incorrectos";
                                    }
                                }
                                else{
                                    console.log(Response);
                                    var item = JSON.parse(Response);
                                    if (item.iduser > 0) {
                                        localStorage.setItem("user", Response);
                                        window.location.href = URL + "Principal/principal";
                                    }
                                    else {
                                        if (item.iduser == 0) {
                                            document.getElementById("dErrorL").style.backgroundColor = "#C40D0A";
                                            document.getElementById("indexMessage").innerHTML = "Usuario o Contraseña incorrectos";
                                        }
                                        else{
                                            document.getElementById("dErrorL").style.backgroundColor = "#C40D0A";
                                            document.getElementById("indexMessage").innerHTML = "Error al tratar conectar con el servido";
                                        }
                                    }
                                }
                                /**/
                                // }
                                /* catch (error) {
                                     document.getElementById("indexMessage").innerHTML = JSON.parse(Response);
                                 }*/
                            }
                        );
                    }

                }
                else {
                    document.getElementById("user").focus();
                    M.toast({ html: 'Caracteres no validos' });
                }
            }

        }
    }
    //metodo de insercion de user
    insertUser(idU, nombre, user, pass, priv) {
        nombre = nombre.trim();
        user = user.trim();

        if (nombre == "") {
            document.getElementById("Nombre").focus();
            M.toast({ html: 'Ingrese un Nombre' });
        }
        else {
            if (user == "") {
                document.getElementById("usuario").focus();
                M.toast({ html: 'Ingrese un Usuario' });
            }
            else {
                if (pass == "" && this.IsEdit==0) {
                    document.getElementById("contra").focus();
                    M.toast({ html: 'Ingrese una Contraseña' });
                }
                else {
                    if (priv == 0) {
                        document.getElementById("roles").focus();
                        M.toast({ html: 'Seleccione un Privilegio' });
                    }
                    else {
                        var data = new FormData();
                        /* 
                        $.each($('input[type=file]')[0].files, (i, file)=>{
                            data.append('file',file);
                        });
                        */
                        var url = this.IsEdit == 0 ? "Usuarios/insertUser" : "Usuarios/editUser";
                        data.append('idU', idU);
                        data.append('nombre', nombre);
                        data.append('user', user);
                        data.append('pass', pass);
                        data.append('priv', priv);
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
                                    var im = M.Modal.getInstance($('#modal1'));
                                    im.close();
                                    M.toast({ html: "Se guardo correctamente perro!!" });
                                    this.getUser(null,1);
                                    this.restablecerUser();
                                }
                                else {
                                    M.toast({ html: Response, classes: 'rounded' });
                                }
                            }
                        });
                    }
                }
            }
        }

    }

    deleteUse(data){
        $.post(
            URL + "Usuarios/deleteUser",
            {
                idUser: data.iduser
            },
            (response) => {
                if(response==0){
                    M.toast({ html: "Se elimino correctamente perro!!" });
                    this.getUser(null,1);
                }
                else {
                    M.toast({ html: response, classes: 'rounded' });
                }
                console.log(response);
            });
    }


    //metodo inf user
    userData(URLactual) {
        if (PATHNAME == URLactual) {
            localStorage.removeItem("user");
        }
        else {
            if (localStorage.getItem("user") != null) {
                let user = JSON.parse(localStorage.getItem("user"));
                if (user.iduser > 0) {
                    document.getElementById('menuNavbar').style.display = 'block';
                    document.getElementById('name1').innerHTML = "HOLA: " + user.name;
                    document.getElementById('role1').innerHTML = user.priv;
                    //console.log(user.iduser);
                }
            }
        }
    }
    // metodo user rol
    getRoles(inf, fun) {
        let count = 1;
        $.post(
            URL + "Usuarios/getRoles",
            {},
            (Response) => {
                try {
                    var item = JSON.parse(Response);
                    document.getElementById('roles').options[0] = new Option("Seleccione un rol", 0);
                    if (item.result.length > 0) {
                        for (let i = 0; i < item.result.length; i++) {
                            switch (fun) {
                                case 1:
                                    document.getElementById('roles').options[count] = new Option(item.result[i].privilegio, item.result[i].idp);
                                    count++;
                                    $('select').formSelect();
                                    break;
                                case 2:
                                    document.getElementById('roles').options[count] = new Option(item.result[i].privilegio, item.result[i].idp);
                                    if (item.result[i].privilegio == inf) {
                                        i++;
                                        document.getElementById('roles').selectedIndex = i;
                                        i--;
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

    //edit user
    editUser(data) {
        this.IsEdit = 1;
        document.getElementById('idU').value = data.iduser;
        document.getElementById('Nombre').value = data.name;
        document.getElementById('usuario').value = data.user;
        this.getRoles(data.privilegio, 2);
    }

    limpiar() {
        document.getElementById('contra').value = "";
        document.getElementById('Nombre').value = "";
        document.getElementById('usuario').value = "";
    }
    //clean user
    restablecerUser() {
        this.IsEdit = 0;
        document.getElementById('idU').value = "";
        limpiar();
        this.getRoles(null, 1);
    }
    //session close
    sessionClose() {
        localStorage.removeItem("user");
        document.getElementById('menu-side').style.display = 'none';
        document.getElementById('menuNavbar').style.display = 'none';
    }

}