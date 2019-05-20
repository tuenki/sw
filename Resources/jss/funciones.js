//validar letras, numeros y espacios
var validarUs = (pat,type) =>{
    let p = pat.trim();
    if(type==1)
    {
        let patt = new RegExp(/^[A-Za-z\s]+$/g);
        let res = patt.test(p);
        return res;
    }
    else if(type==2)
    {
        let patt = new RegExp(/^[0-9]+$/g);
        let res = patt.test(p);
        return res;
    }
    
}
var mostrar=()=>{
    document.getElementById('menu-side').style.display='block';
}
var limpiar=()=>{
    document.getElementById('Nombre').value="";
    document.getElementById('usuario').value="";
    document.getElementById('contra').value="";
    document.getElementById('roles').value="";
}
//validar solo numeros
