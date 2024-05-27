function msenha() {
    let senha;
    senha=document.getElementById("senha");
    if (senha.type==="password"){
        senha.type="text";
    }else {
        senha.type="password";
    }
}