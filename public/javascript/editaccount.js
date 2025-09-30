document.addEventListener('load', init)

let profile_picture = document.getElementById("profile_picture")
let inputfile = document.getElementById("inputfile")

function init(){
    inputfile.onchange = function () {
        profile_picture.src= URL.createObjectURL(inputfile.files[0])
    }
}


