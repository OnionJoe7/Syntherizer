// Handles button even for the Register button in login.php
// This button had to be handled by Javascrpt in order to seperate it from the PHP POST method at the same time as
// having it placed within the same holder. Purely for estethics.

let btn = document.getElementById("register-form-submit");

btn.addEventListener('click', () => {
  
    window.location.href='../Register/main.html'

    var cleaned = sequence.join('');
    // console.log(username); 
})