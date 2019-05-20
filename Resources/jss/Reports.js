class Reports
{
    constructor(){

    }

    getMaterialF()
    {
        let f1 = document.getElementById('datetime1').value;
        let f2 = document.getElementById('datetime2').value;
        let e=this.evalFech(f1,f2);
        if(e==0)
        {
            let url=URL+"Reportes/materialFaltante&fmf1="+f1+"&fmf2="+f2;
            return url;
        }
        else
        {
            if(e==1){
                document.getElementById('datetime1').focus();
                M.toast({ html: "no se aceptan datos vacios!!", classes: 'rounded' });
                return false;
            }
            else if(e==2){
                M.toast({ html: "no se aceptan datos vacios!!", classes: 'rounded' });
                document.getElementById('datetime2').focus();
                return false;
            }
        }
    }
    evalFech(f1,f2)
    {
        if(f1=="")
        {
            return 1;
        }
        else if(f2=="")
        {
            return 2;
        }
        else
        {
            return 0;
        }
    }
}