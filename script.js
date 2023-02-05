const $d = document,
    $estrellas = $d.querySelector("#estrellas")
    
// let values = []
// let estrella
$estrellas.addEventListener("click", event => {
    // values = []
    // let valor = event.target.id
    // values.push(valor)
    // estrella = values[values.length-1]

    let estrella = event.target.id

    for (let i = 5; i >= 1; i--) {
        $d.getElementById(i).classList.remove('pintadas')
    } 

    for (let i = estrella; i >= 1; i--) {
        $d.getElementById(i).classList.add('pintadas')
    }

    $d.querySelector(".valoracion").value = estrella
})

// $estrellas.addEventListener("mouseover", event => {
//     let estrella = event.target.id

//     for (let i = estrella; i >= 1; i--) {
//         $d.getElementById(i).classList.add('pintadas')
//     }
// })

// $estrellas.addEventListener("mouseout", event => {
//     console.log(event.target.id)
//     console.log(estrella)
//     if(values.length == 0 || (parseInt(estrella) > parseInt(values[length-1]))) {
//         for (let i = 5; i >= 1; i--) {
//             $d.getElementById(i).classList.remove('pintadas')
//         }
//     } 
// })
