// let section = document.querySelectorAll(".cat");

// let arr = Array.from(section);
// arr.forEach(el => {
//     el.addEventListener("click", function () {
//         this.document.querySelector('.cat .full-view').classList.toggle('dis');
//     })
// })

// section.addEventListener("click", function () {

//     document.querySelector('.cat .full-view').classList.toggle('dis');
// })





// dashboard 
// let plus = document.querySelector(".toggle-info i");
// plus.onclick = function () {
//     this.classList.toggle("select");

//     if(plus.classList.contains("select")) {

//         document.querySelector(".card-body").style.display = "none";
//         plus.classList.remove("fa-plus");
//         plus.classList.add("fa-minus");
        
//     } else {
//         plus.classList.add("fa-plus");
//         plus.classList.remove("fa-minus");

//         document.querySelector(".card-body").style.display = "block";
        
//     }
// }
// start lognin page 
let spanBtn = document.querySelectorAll(".login-page h1 span");

spanBtn.forEach(el => {
    el.addEventListener("click", function () {
        document.querySelectorAll(".login-page h1 span").forEach(el => {
            el.classList.remove("active");
        })
        this.classList.add("active");
        document.querySelector('.login-page form').style.display = 'none';
        // this.getAttribute("data-class");
        if(this.getAttribute("data-class") == 'login') {
            document.querySelector('.login-page .login').style.display = 'block';
            document.querySelector('.login-page .signup').style.display = 'none';
        } else {
            document.querySelector('.login-page .signup').style.display = 'block';
            document.querySelector('.login-page .login').style.display = 'none';
        }
        
    })
})
document.querySelector(".card .card-body .name").onkeyup = function () {
    document.querySelector(".live-prev h5").textContent = this.value;
}
document.querySelector(".card .card-body .des").onkeyup = function () {
    document.querySelector(".live-prev p").textContent = this.value;
}
document.querySelector(".card .card-body .price").onkeyup = function () {
    document.querySelector(".card span").textContent = this.value;
}

// document.querySelector(".live-prev .title")