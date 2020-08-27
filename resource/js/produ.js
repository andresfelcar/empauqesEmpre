let form1 = document.getElementById('regproducto');
let form2 = document.getElementById('regproducto2');

function forms(){
	let desplazamiento_actual = window.pageYOffset;
	if(desplazamiento_actual>=65){
        form1.style.position = 'fixed';
        form1.style.top = '10px';
        form2.style.position = 'fixed';
        form2.style.top = '290px';
	} else{
        form1.style.position = 'absolute';
        form1.style.top = '70px';
        form2.style.position = 'absolute';
        form2.style.top = '350px';
    }
}

window.addEventListener('scroll',function(){
	forms();
});