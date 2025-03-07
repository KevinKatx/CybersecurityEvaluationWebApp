<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cybersecurity Evaluation</title>
    <link href="evaluation_p2styles.css" rel="stylesheet">
</head>
<body>

<div class="game-screen">
    <header>
        <h1>Resort Security Checkpoint</h1>
        <div id="score">Score: 0</div>
    </header>

    <div class="request-container">
        <div id="request-text">Waiting for Request...</div>
    </div>

    <div class="actions">
        <button onclick="chooseAction('approve')">✅ Approve</button>
        <button onclick="chooseAction('reject')">❌ Reject</button>
        <button onclick="chooseAction('report')">🚨 Report</button>
    </div>
</div>

<!-- Computer Modal -->
<div class="modal" id="computerModal">
    <div class="modal-content">
        <span onclick="closeModal()" class="close">&times;</span>
        <h2>Company Computer</h2>
        <div id="modal-text">Incoming Email...</div>
    </div>
</div>

<script src="game.js"></script>
</body>
</html>

