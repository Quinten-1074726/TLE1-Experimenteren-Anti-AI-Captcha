let profile_picture = document.querySelector("#profile_picture");
let inputfile = document.querySelector("#input_file");

let option1
let option2

function init() {

    // inputfile.addEventListener("change", (e) =>
    //     profile_picture.src = URL.createObjectURL(inputfile.files[0])
    // )

    document.addEventListener("change", (e) =>

            changeProfilePicture()
        // profile_picture.src = getSelection()
)

}

init()

function changeProfilePicture(){
    option1 = document.querySelector("#cake")
    option2 = document.querySelector("#donut")

    // let value = document.querySelector("select").value

// console.log(value)

    profile_picture.src = ""
    if (document.querySelector("select").value === "donut"){

        profile_picture.src = "images/donut.png"
        console.log(profile_picture.src)
    } else if (document.querySelector("select").value === "cake") {
        profile_picture.src = "images/cake.png"
        console.log(profile_picture.src)
    }
    // console.log(option1)

    // if ()
    //
    //
}




function cleaner(){
    inputfile.onchange()
}



