"use strict";

const container = document.getElementById("container");
let lights = document.getElementsByClassName("light");

let level = 0;
let levels = [
    [0,1,0,1,1,1,0,1],
    [1,1,0,0,1,0,1,0],
    [2,1,1,0,1,2,1,1],
    [2,2,1,1,1,2,1,1],
    [1,1,1,0,1,2,2,1],
    [2,1,1,0,2,2,0,1]
];

loadLevel(0);

function swap(i){
    toggle(i);
    toggle(i-1);
    toggle(i+1);

    let red = false;
    for(let light of lights){
        if(light.style.backgroundColor != "green"){
            red = true;
            return;
        }
    }

    if(!red){
        console.log("You win");
        level++;
        if(level >= levels.length){
            alert("All levels completed!");
            level = 0;
        }else{
            alert("You win!");
        }
        loadLevel();
    }

}

function loadLevel(){
    container.innerHTML = "";
    let current = levels[level];
    for(let i = 0; i < current.length; i++){
        addLight(current[i], i);
    }
    for(let i = 0; i < lights.length; i++){
        formatLight(lights[i]);
    }
}

function formatLight(light){
    let width = container.clientWidth / lights.length - 12;
    if(width > container.clientHeight){
        width = container.clientHeight - 12;
    }
    let widthFactor = ((width / container.clientWidth) * 100);
    light.style.width = widthFactor + "%";
    if(width > container.clientHeight){
        light.style.height = (container.clientHeight - 12) + "px";
    }else{
        light.style.height = width + "px";
        let padding = container.clientHeight - width;
        padding /= 2;
        light.style.margin = padding + "px" + " 5px";
    }
}

function addLight(type, number){
    let light = document.createElement("div");
    light.className = "light";
    switch(type){
        case 0:
            light.style.backgroundColor = "green";
            break;
        case 1:
            light.style.backgroundColor = "red";
            break;
        case 2:
            light.style.backgroundColor = "yellow";
            break;
    }
    light.addEventListener("click", (e)=>{
        swap(parseInt(number));
    });

    container.appendChild(light);
}

function toggle(i){
    if(i >= lights.length){return;}
    if(i < 0){return;}

    let color = lights[i].style.backgroundColor;
    if(color == "red"){
        lights[i].style.backgroundColor = "green";
    }else{
        lights[i].style.backgroundColor = "red";
    }
}