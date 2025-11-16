<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>🪷 DostiChat — Where borders fade</title>
  <link rel='stylesheet' href='assets/style.css'>
</head>
<body class='light'>
  <header>
    <div class='container'>
      <h1>🪷 DostiChat</h1>
      <button id='themeToggle'>🌙</button>
    </div>
  </header>

  <main class='container'>
    <div id='home'>
      <h2>Chat with Friends Across Borders</h2>
      <p>Connect anonymously with people from India & Pakistan — over cricket, food, music, and more.</p>
      <div class='btn-group'>
        <button id='startTextChat'>💬 Start Text Chat</button>
      </div>
      <label>
        Interests (optional):
        <input type='text' id='interests' placeholder='e.g., biryani, cricket, poetry'>
      </label>
      <p class='note'>ℹ️ Anonymous, moderated, and kind.</p>
    </div>

    <div id='chat' style='display:none;'>
      <div id='chatHeader'>
        <span>🗨️ Chatting with a friend from <span id='partnerRegion'>somewhere nearby</span></span>
        <button id='endChat'>🚪 End</button>
      </div>
      <div id='messages'></div>
      <div id='inputArea'>
        <input type='text' id='messageInput' placeholder='Type a message...' maxlength='200'>
        <button id='sendBtn'>➤</button>
      </div>
      <div class='report'><button id='reportBtn'>🚩 Report</button></div>
    </div>
  </main>

  <script src='assets/script.js'></script>
</body>
</html>
