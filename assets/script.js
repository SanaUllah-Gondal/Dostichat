document.addEventListener('DOMContentLoaded', () => {
  const home = document.getElementById('home');
  const chat = document.getElementById('chat');
  const messages = document.getElementById('messages');
  const input = document.getElementById('messageInput');
  const sendBtn = document.getElementById('sendBtn');
  const startBtn = document.getElementById('startTextChat');
  const endBtn = document.getElementById('endChat');
  const reportBtn = document.getElementById('reportBtn');
  const themeBtn = document.getElementById('themeToggle');

  let sessionId = null;

  // Theme toggle
  themeBtn.onclick = () => {
    const isDark = document.body.classList.contains('dark');
    document.body.className = isDark ? 'light' : 'dark';
    themeBtn.textContent = isDark ? '🌙' : '☀️';
    document.cookie = 	heme=; path=/;
  };

  // Start chat
  startBtn.onclick = async () => {
    const interests = document.getElementById('interests').value || 'general';
    const res = await fetch('/api/join.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ interests })
    });
    const data = await res.json();
    if (data.success) {
      sessionId = data.sessionId;
      home.style.display = 'none';
      chat.style.display = 'block';
      document.getElementById('partnerRegion').textContent = Math.random() > 0.5 ? 'India' : 'Pakistan';
      simulateReply();
    }
  };

  function simulateReply() {
    const replies = [
      'Hi! 👋 How’s your day?',
      'Love biryani! Hyderabadi or Sindhi?',
      'Cricket fan? Who’s your legend?',
      'Our chai may be from different sides — but it tastes the same 😉',
      'Ever read Faiz? His words give me chills.'
    ];
    setTimeout(() => {
      if (!sessionId) return;
      const msg = replies[Math.floor(Math.random() * replies.length)];
      addMessage(msg, 'them');
    }, 2000 + Math.random() * 3000);
  }

  function addMessage(text, sender) {
    const div = document.createElement('div');
    div.className = message ;
    div.textContent = text;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
  }

  sendBtn.onclick = () => {
    const text = input.value.trim();
    if (!text) return;
    addMessage(text, 'you');
    input.value = '';
    simulateReply();
  };

  endBtn.onclick = () => {
    chat.style.display = 'none';
    home.style.display = 'block';
    messages.innerHTML = '';
    sessionId = null;
  };

  reportBtn.onclick = () => {
    alert('Chat reported. Thank you for keeping DostiChat safe ❤️');
    endBtn.click();
  };
});
