// Color changing heading every 5 seconds
const heading = document.getElementById("changing-heading");

// Define colors to cycle through
const colors = ["#ff5733", "#33ff57", "#3357ff", "#ff33a6", "#f39c12"];
let currentColor = 0;

setInterval(() => {
    heading.style.color = colors[currentColor];
    currentColor = (currentColor + 1) % colors.length;
}, 5000); // 5000ms = 5 seconds
