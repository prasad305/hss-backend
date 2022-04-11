var data = 0;
var data1 = 0;
var data2 = 0;
document.getElementById("root").innerText = data;
document.getElementById("root1").innerText = data1;
document.getElementById("root2").innerText = data2;

function decrement() {
    data = data - 1;
    document.getElementById("root").innerText = data;
}

function increment() {
    data = data + 1;
    document.getElementById("root").innerText = data;
}

function decrement1() {
    data1 = data1 - 1;
    document.getElementById("root1").innerText = data1;
}

function increment1() {
    data1 = data1 + 1;
    document.getElementById("root1").innerText = data1;
}
function decrement2() {
    data2 = data2 - 1;
    document.getElementById("root2").innerText = data2;
}

function increment2() {
    data2 = data2 + 1;
    document.getElementById("root2").innerText = data2;
}
