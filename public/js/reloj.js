window.addEventListener('DOMContentLoaded', () => {

    //VARIABLES
    const reloj = document.querySelector('.reloj');//0

    const relojDigital = () => {
       setInterval(() => {
        let tiempoActual = new Date();
        let hora = tiempoActual.getHours();
        let minutos = tiempoActual.getMinutes();
        let segundos = tiempoActual.getSeconds();

        if(hora < 10){
           hora = "0" + hora;
        }

        if(minutos < 10){
            minutos = "0" + minutos;
        }

        if(segundos < 10){
            segundos = "0" + segundos;
        }

        //minutos = checkTime(min);
        //segundos = checkTime(segundos);
        reloj.innerHTML = `${hora}:${minutos}`;
       }, 1000);
       
    }

    const checkTime = (i) => {
       if(i<10){
           i = "0" + 1;
       }
       return i;
    } 

    
    //EVENTOS
    window.addEventListener('load', relojDigital);
});
