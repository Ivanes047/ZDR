const btn_data = document.getElementById('my_data');
const btn_pass = document.getElementById('my_pass');
const btn_review = document.getElementById('my_review');
const btn_ticket = document.getElementById('my_ticket');
const body = document.querySelector('body');

const form_data = document.getElementById('personal__data');
const form_pass = document.getElementById('personal__pass');
const form_review = document.getElementById('personal__review');
const form_ticket = document.getElementById('personal__ticket');

if (document.querySelector('#my_article')) {
    var btn_article = document.getElementById('my_article');
    var form_article = document.getElementById('personal__article');
};

var get = function (key) {
    return sessionStorage ? sessionStorage.getItem(key) : "#my_data";
}

var put = function (value) {
    if (sessionStorage) {
        sessionStorage.setItem('page', value);
    }
}

var click_btn = "";

body.onload = function hist() {
    if (get("page")) {
        click_btn = get("page");
        document.querySelector(click_btn).click(); 
    } else {
        put("#my_data");
    }
}

if (!btn_article) { 
    btn_data.addEventListener('click', () => {
        put("#my_data");
        btn_data.classList.add('active');
        btn_ticket.classList.remove('active');
        btn_pass.classList.remove('active');
        btn_review.classList.remove('active');
        form_data.classList.add('show-menu');
        form_pass.classList.remove('show-menu');
        form_review.classList.remove('show-menu');
        form_ticket.classList.remove('show-menu');
    })


    btn_pass.addEventListener('click', () => {
        put("#my_pass");
        btn_pass.classList.add('active');
        btn_ticket.classList.remove('active');
        btn_data.classList.remove('active');
        btn_review.classList.remove('active');
        form_pass.classList.add('show-menu');
        form_data.classList.remove('show-menu');
        form_review.classList.remove('show-menu');
        form_ticket.classList.remove('show-menu');
    })

    btn_review.addEventListener('click', () => {
        put("#my_review");
        btn_review.classList.add('active');
        btn_ticket.classList.remove('active');
        btn_data.classList.remove('active');
        btn_pass.classList.remove('active');
        form_review.classList.add('show-menu');
        form_data.classList.remove('show-menu');
        form_pass.classList.remove('show-menu');
        form_ticket.classList.remove('show-menu');
    })

    btn_ticket.addEventListener('click', () => {
        put("#my_ticket");
        btn_ticket.classList.add('active');
        btn_review.classList.remove('active');
        btn_data.classList.remove('active');
        btn_pass.classList.remove('active');
        form_ticket.classList.add('show-menu');
        form_data.classList.remove('show-menu');
        form_pass.classList.remove('show-menu');
        form_review.classList.remove('show-menu')
    })
} else {
    btn_data.addEventListener('click', () => {
        put("#my_data");
        btn_data.classList.add('active');
        form_data.classList.add('show-menu');
        btn_article.classList.remove('active');
        form_article.classList.remove('show-menu');
    })

    btn_article.addEventListener('click', () => {
        put("#my_article");
        btn_article.classList.add('active');
        btn_data.classList.remove('active');
        form_article.classList.add('show-menu');
        form_data.classList.remove('show-menu');
    })
}