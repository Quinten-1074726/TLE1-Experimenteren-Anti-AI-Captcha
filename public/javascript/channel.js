let home
let trending
let subscriptions

let subscribedChannel

function makeLeftTaskBar(){
    let body = document.getElementById('body')
    let div = document.createElement('div')

    home = document.createElement('a')
    trending = document.createElement('a')
    subscriptions = document.createElement('a')
    subscribedChannel = document.createElement('a')
    div.innerHTML = "hi"

    body.append(div)


}
makeLeftTaskBar()
