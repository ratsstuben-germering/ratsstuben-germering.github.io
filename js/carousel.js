
previous_btn =  document.getElementById('previous_bt');
next_btn =      document.getElementById('next_bt');

prviSlide =    document.getElementById('prvi_slide_');
drugiSlide =    document.getElementById('drugi_slide_');
treciSlide =    document.getElementById('treci_slide_');

prvaSignalnaNaznaka = document.getElementById('prva_signalna_naznaka_')
drugaSignalnaNaznaka = document.getElementById('druga_signalna_naznaka_')
trecaSignalnaNaznaka = document.getElementById('treca_signalna_naznaka_')

previous_btn.addEventListener('click', function() {
    
    if(prviSlide.classList.contains("active")){
        prviSlide.classList.remove("active");
        treciSlide.classList.add("active")
        prvaSignalnaNaznaka.classList.remove("active")
        trecaSignalnaNaznaka.classList.add("active")
    }
    else if(drugiSlide.classList.contains("active")){
        drugiSlide.classList.remove("active");
        prviSlide.classList.add("active")
        drugaSignalnaNaznaka.classList.remove("active")
        prvaSignalnaNaznaka.classList.add("active")
    }
    else{
        treciSlide.classList.remove("active")
        drugiSlide.classList.add("active")
        trecaSignalnaNaznaka.classList.remove("active")
        drugaSignalnaNaznaka.classList.add("active")
    }
});


next_btn.addEventListener('click', function(){
    
    if(prviSlide.classList.contains("active")){
        prviSlide.classList.remove("active");
        drugiSlide.classList.add("active")
        prvaSignalnaNaznaka.classList.remove("active")
        drugaSignalnaNaznaka.classList.add("active")
    }
    else if(drugiSlide.classList.contains("active")){
        
        drugiSlide.classList.remove("active");
        treciSlide.classList.add("active")
        drugaSignalnaNaznaka.classList.remove("active")
        trecaSignalnaNaznaka.classList.add("active")
    }
    else{
        treciSlide.classList.remove("active")
        prviSlide.classList.add("active")
        trecaSignalnaNaznaka.classList.remove("active")
        prvaSignalnaNaznaka.classList.add("active")
    }
   
});