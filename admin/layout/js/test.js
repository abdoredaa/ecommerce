let section = document.querySelectorAll(".cat");

section.forEach(el => {
    el.addEventListener("click", function () {
       el.parentElement()
    })
})

// section.addEventListener("click", function () {

//     document.querySelector('.cat .full-view').classList.toggle('dis');
// })





// dashboard 
let plus = document.querySelectorAll(".toggle-info i");

plus.forEach(el => {
    el.addEventListener("click", function () {
        console.log(this.classList);
    })
})