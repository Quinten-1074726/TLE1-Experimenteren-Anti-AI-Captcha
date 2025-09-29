let profile_picture = document.getElementById("profile_picture")
let inputfile = document.getElementById("profile")

inputfile.onchange = function () {
    profile_picture.src= URl.createObjectURL(inputfile.files[0])
}

