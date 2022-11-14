function alertThankyou(){
    alert("Muchas gracias!");
}

window.onload = function(){
    document.getElementById("formulario").onsubmit = alertThankyou;
}