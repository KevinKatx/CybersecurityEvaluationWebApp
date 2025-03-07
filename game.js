let score = 0;
let currentRequest = 0;
const requests = [
    { type: "computer", text: "Email: Your password will expire. Click here to reset.", correct: "report" },
    { type: "real", text: "Delivery guy asks to charge his phone at the reception.", correct: "reject" },
    { type: "computer", text: "USB request from unknown employee.", correct: "reject" },
    { type: "real", text: "Visitor asks for WiFi password.", correct: "reject" }
];

function startGame() {
    showRequest();
}

function showRequest() {
    let request = requests[currentRequest];
    document.getElementById("request-text").innerText = request.text;

    if (request.type === "computer") {
        openModal();
    }
}

function chooseAction(action) {
    let request = requests[currentRequest];
    if (action === request.correct) {
        score += 2;
        alert("✅ Correct!");
    } else {
        alert("❌ Wrong!");
    }

    currentRequest++;
    if (currentRequest >= requests.length) {
        alert(`Game Over! Your Score: ${score}`);
    } else {
        showRequest();
    }
    document.getElementById("score").innerText = `Score: ${score}`;
}

function openModal() {
    document.getElementById("computerModal").style.display = "block";
}

function closeModal() {
    document.getElementById("computerModal").style.display = "none";
}

window.onload = startGame;
