function mascara(o,f){
    v_obj=o;
    v_fun=f;
    setTimeout("execmascara()",1);
}

function execmascara(){
    switch(v_fun){
        case "soNumeros":
            v_obj.value = soNumeros(v_obj.value);
        break;
        
        case "data":
            v_obj.value = data(v_obj.value);
        break;
        
        case "hora":
            v_obj.value = hora(v_obj.value);
        break;
        
        case "cep":
            v_obj.value = cep(v_obj.value);
        break;
        
        case "cpf":
            v_obj.value = cpf(v_obj.value);
        break;
        
        case "cnpj":
            v_obj.value = cnpj(v_obj.value);
        break;
        
        case "telefone":
            v_obj.value = telefone(v_obj.value);
        break;
        
        case "placa":
            v_obj.value = placa(v_obj.value);
        break;
        
        case "valor":
            v_obj.value = valor(v_obj.value);
        break;
    }
}

function leech(v){
    v=v.replace(/o/gi,"0");
    v=v.replace(/i/gi,"1");
    v=v.replace(/z/gi,"2");
    v=v.replace(/e/gi,"3");
    v=v.replace(/a/gi,"4");
    v=v.replace(/s/gi,"5");
    v=v.replace(/t/gi,"7");
    return v;
}

function soNumeros(v){
    return v.replace(/\D/g,"");
}

function data(v){
    v=v.replace(/D/g,""); //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d{2})(\d{4})/,"$1/$2/$3"); //Esse é tão fácil que não merece explicações
    return v;
}

function telefone(v){
    v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}

function cpf(v){
    v=v.replace(/\D/g,"");                //Remove tudo o que não é dígito
    v=v.replace(/(\d{3})(\d)/,"$1.$2");      //Coloca um ponto entre o terceiro e o quarto dígitos
    v=v.replace(/(\d{3})(\d)/,"$1.$2");      //Coloca um ponto entre o terceiro e o quarto dígitos
                                             //de novo (para o segundo bloco de números)
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2"); //Coloca um hífen entre o terceiro e o quarto dígitos
    return v;
}

function cep(v){
    v=v.replace(/\D/g,"");               //Remove tudo o que não é dígito
    v=v.replace(/^(\d{5})(\d)/,"$1-$2"); //Esse é tão fácil que não merece explicações
    return v;
}

function cnpj(v){
    v=v.replace(/\D/g,"");                           //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2");             //Coloca ponto entre o segundo e o terceiro dígitos
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3"); //Coloca ponto entre o quinto e o sexto dígitos
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2");           //Coloca uma barra entre o oitavo e o nono dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2");              //Coloca um hífen depois do bloco de quatro dígitos
    return v;
}

function romanos(v){
    v=v.toUpperCase();             //Maiúsculas
    v=v.replace(/[^IVXLCDM]/g,""); //Remove tudo o que não for I, V, X, L, C, D ou M
    //Essa é complicada! Copiei daqui: http://www.diveintopython.org/refactoring/refactoring.html
    while(v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/,"")!="")
        v=v.replace(/.$/,"");
    return v;
}

function site(v){
    //Esse sem comentarios para que você entenda sozinho ;-)
    v=v.replace(/^http:\/\/?/,"");
    dominio=v;
    caminho="";
    if(v.indexOf("/")>-1)
        dominio=v.split("/")[0];
        caminho=v.replace(/[^\/]*/,"");
    dominio=dominio.replace(/[^\w\.\+-:@]/g,"");
    caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"");
    caminho=caminho.replace(/([\?&])=/,"$1");
    if(caminho!="")dominio=dominio.replace(/\.+$/,"");
    v="http://"+dominio+caminho;
    return v;
}

function placa(v){

    v=v.toUpperCase();
    v=v.replace(/^(\w{3})(\w)/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    console.info(v);
    return v;
}

function valor(v){
    v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
    v=v.replace(/(\d+)(\d{2})/,"$1,$2"); //Insere a vírgula
    v=v.replace(/(\d+)(\d{3},\d{2})$/g,"$1.$2"); //Coloca o primeiro ponto
    var qtdLoop = (v.length-3)/3;
    var count = 0;
    while (qtdLoop > count)
    {
        count++;
        v=v.replace(/(\d+)(\d{3}.*)/,"$1.$2"); //Coloca o resto dos pontos
    }
    v=v.replace(/^(0+)(\d)/g,"$2"); //remove "0" à esquerda
    return v
}