let eye_tag = document.querySelector(".fas.fa-eye-slash");
let password_tags = document.querySelectorAll("input[type='password']");

console.log(password_tags);

eye_tag.addEventListener('click', (e) => {
    let input_password1 = password_tags[0];
    let input_password2 = password_tags[1];
    console.log(input_password1);
    console.log(input_password2);
    if(input_password1.type === "password"){
        input_password1.type = "text";

        if(input_password2 !== null) {input_password2.type = "text";}

        i_tag.classList.remove("fas", "fa-eye-slash");
        i_tag.classList.add("fa-solid", "fa-eye");
        i_tag.style.color = "#000"

    }else  {
        input_password1.type = "password";

        if(input_password2 !== null) {input_password2.type = "password";}


        i_tag.classList.remove("fa-solid", "fa-eye");
        i_tag.classList.add("fas", "fa-eye-slash");
        i_tag.style.color = "#ccc"


    }
})


let disable_btns = document.querySelectorAll('.disable_btn');


if(disable_btns){
    disable_btns.forEach(btn => btn.addEventListener('click', e => {
        e.preventDefault();
    }));
}