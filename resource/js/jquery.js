let vendedor = document.getElementById('show2');
let producto = document.getElementById('show1');
let disp = document.getElementById('show3');
let caja1 = document.getElementById('div1');
let caja2 = document.getElementById('div2');
let caja3 = document.getElementById('div3');
let tabla1 = document.getElementById('producto');
let tabla2 = document.getElementById('vendedor')

vendedor.addEventListener('click', function(){
    mostrar(event);
});
producto.addEventListener('click', function(){
    mostrar(event);
});
disp.addEventListener('click', function(){
    mostrar(event);
});
function mostrar(ev){
    if(ev.target == vendedor){
        caja1.style.display ='block';
        caja2.style.display= 'none';
        caja3.style.display= 'none';
        tabla2.style.display='block';
        tabla1.style.display='none';
    }
    if(ev.target == producto){
        caja2.style.display ='block';
        caja1.style.display= 'none';
        caja3.style.display= 'none';
        tabla1.style.display='block';
        tabla2.style.display='none';
    }
    if(ev.target == disp){
        caja3.style.display ='block';
        caja2.style.display= 'none';
        caja1.style.display= 'none';
        tabla1.style.display='block';
        tabla2.style.display='none';
    }
}
window.addEventListener('load', function(){
    mostrar(ev);
});