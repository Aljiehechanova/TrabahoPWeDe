<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trabaho PWeDe - Home</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body.grayscale {
      filter: grayscale(100%) !important;
      background-color: #bfbfbf !important;
      color: #333 !important;
    }

    body.grayscale * {
      background-color: transparent !important;
      color: #333 !important;
    }

    body.high-contrast {
      background-color: #000 !important;
      color: #FFFF00 !important;
    }

    body.high-contrast * {
      background-color: transparent !important;
      color: #FFFF00 !important;
    }

    body.high-contrast ::selection {
      background: #FFFF00 !important;
      color: #000 !important;
    }

    body.readable-font, body.readable-font * {
      font-family: Verdana, sans-serif !important;
      font-size: 18px !important;
      line-height: 1.6 !important;
    }

    body.magnifier-active * {
      cursor: zoom-in;
    }

    #access-btn {
      position: fixed;
      top: 50%;
      right: 20px;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      cursor: pointer;
      z-index: 10000;
    }

    #access-btn img {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      box-shadow: 0 0 10px #000;
    }

    #accessibility-panel {
      position: fixed;
      top: 50%;
      right: 90px;
      transform: translateY(-50%);
      background: #1a1a1a;
      color: white;
      padding: 15px;
      border-radius: 8px;
      width: 220px;
      z-index: 9999;
      font-size: 14px;
      display: none;
    }

    #accessibility-panel h3 {
      margin: 0 0 10px;
      font-size: 16px;
    }

    .accessibility-btn {
      display: block;
      background: none;
      border: none;
      color: #fff;
      padding: 8px;
      margin: 5px 0;
      width: 100%;
      text-align: left;
      cursor: pointer;
    }

    .accessibility-btn:hover {
      background: #333;
    }

    .magnifier {
      position: absolute;
      border: 3px solid #666;
      border-radius: 50%;
      width: 250px;
      height: 250px;
      overflow: hidden;
      display: none;
      pointer-events: none;
      z-index: 9998;
      box-shadow: 0 0 8px #000;
      background: white;
    }

    .navbar, .hero, .workshop-category, .footer {
      padding: 20px;
      text-align: center;
    }

    .hero {
      background: #e0f7fa;
      padding: 60px 20px;
    }

    .category-grid {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .category img {
      width: 150px;
      border-radius: 10px;
    }

    #tts-toggle {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 9999;
    }
  </style>
</head>
<body>

<button id="access-btn" onclick="togglePanel()" aria-label="PWD tools">
  <img src="https://assets.onecompiler.app/43kphgybr/43kqudnkt/icon-original.png" alt="PWD Icon">
</button>

<div id="accessibility-panel" role="dialog" aria-label="PWD Tools Panel">
  <h3>PWD Tools</h3>
  <button class="accessibility-btn" onclick="toggleGrayscale()">▌▌▌ Grayscale</button>
  <button class="accessibility-btn" onclick="toggleContrast()">👁 High Contrast</button>
  <button class="accessibility-btn" onclick="toggleMagnifier()">🔍 Magnifier</button>
  <button class="accessibility-btn" onclick="toggleReadableFont()">A Readable Font</button>
  <button class="accessibility-btn" onclick="resetView()">🧹 Reset View</button>
</div>

<canvas id="magnifier" class="magnifier" width="250" height="250"></canvas>

<button id="tts-toggle" class="btn btn-info" aria-pressed="false" aria-label="Toggle Text-to-Speech">
  🗣️ Text-to-Speech
</button>

<nav class="navbar" role="navigation">
  <div class="logo">
    <img src="../assets/images/TrabahoPWeDeLogo.png" alt="Trabaho PWeDe Logo">
    <span>Trabaho <strong style="color: blue;">PWeDe</strong></span>
  </div>
  <div class="nav-links">
    <a href="#">Why Trabaho PWeDe</a>
    <a href="#">What's New</a>
  </div>
  <div class="nav-buttons">
    <a href="login.php" class="btn btn-primary">Log in</a>
    <a href="RC.php" class="btn btn-success">Sign up</a>
  </div>
</nav>

<main role="main">
  <section class="hero" aria-label="Introduction">
    <h1>Empower and Enhance Your Capabilities</h1>
    <p>Your gateway to inclusive employment and training opportunities.</p>
    <a href="#" class="btn btn-warning">Get Started</a>
  </section>

  <section class="workshop-category" aria-labelledby="featured-jobs">
    <h2 id="featured-jobs">Featured Opportunities</h2>
    <div class="category-grid">
      <div class="category">
        <img src="assets/typing-job.png" alt="Home-Based Typing Job">
        <p>Remote Typing Job (for mobility-impaired)</p>
      </div>
      <div class="category">
        <img src="assets/callcenter.png" alt="Call Center Job">
        <p>Inclusive Call Center Hiring</p>
      </div>
      <div class="category">
        <img src="assets/tech-job.png" alt="IT Support Job">
        <p>IT Support (Visual assistance tools available)</p>
      </div>
    </div>
  </section>
</main>

<footer class="footer">
  <p>&copy; 2025 Trabaho PWeDe. All rights reserved.</p>
</footer>

<script>
  function togglePanel() {
    const panel = document.getElementById('accessibility-panel');
    panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
  }

  function toggleGrayscale() {
    document.body.classList.remove('high-contrast');
    document.body.classList.toggle('grayscale');
  }

  function toggleContrast() {
    document.body.classList.remove('grayscale');
    document.body.classList.toggle('high-contrast');
  }

  function toggleReadableFont() {
    document.body.classList.toggle('readable-font');
  }

  function resetView() {
    document.body.classList.remove('grayscale', 'high-contrast', 'readable-font', 'magnifier-active');
    magnifier.style.display = 'none';
    snapshotCanvas = null;
    document.removeEventListener('mousemove', moveMagnifier);
  }

  let magnifierEnabled = false;
  const magnifier = document.getElementById("magnifier");
  let snapshotCanvas;

  function toggleMagnifier() {
    magnifierEnabled = !magnifierEnabled;
    if (magnifierEnabled) {
      html2canvas(document.body).then(canvas => {
        snapshotCanvas = canvas;
        document.body.classList.add('magnifier-active');
        magnifier.style.display = 'block';
        document.addEventListener('mousemove', moveMagnifier);
      });
    } else {
      document.body.classList.remove('magnifier-active');
      magnifier.style.display = 'none';
      snapshotCanvas = null;
      document.removeEventListener('mousemove', moveMagnifier);
    }
  }

  function moveMagnifier(e) {
    if (!snapshotCanvas) return;
    const zoom = 1.5;
    const size = 250;
    magnifier.style.left = (e.pageX - size / 2) + "px";
    magnifier.style.top = (e.pageY - size / 2) + "px";
    const ctx = magnifier.getContext('2d');
    ctx.clearRect(0, 0, size, size);
    ctx.drawImage(snapshotCanvas,
      e.pageX - size / (2 * zoom), e.pageY - size / (2 * zoom),
      size / zoom, size / zoom,
      0, 0, size, size
    );
  }

  // TEXT TO SPEECH
  let ttsEnabled = false;
  let selectedVoice = null;

  // Load voices
  window.speechSynthesis.onvoiceschanged = () => {
    const voices = window.speechSynthesis.getVoices();
    selectedVoice = voices.find(v => v.lang.includes("en") || v.lang.includes("fil")) || voices[0];
  };

  document.getElementById("tts-toggle").addEventListener("click", (e) => {
    ttsEnabled = !ttsEnabled;
    e.target.setAttribute("aria-pressed", ttsEnabled.toString());
    alert("Text-to-Speech is now " + (ttsEnabled ? "ON" : "OFF"));
  });

  document.addEventListener("mouseup", () => {
    if (!ttsEnabled) return;
    const selection = window.getSelection().toString().trim();
    if (selection.length > 0) {
      const utterance = new SpeechSynthesisUtterance(selection);
      if (selectedVoice) utterance.voice = selectedVoice;
      speechSynthesis.cancel();
      speechSynthesis.speak(utterance);
    }
  });
</script>

</body>
</html>
