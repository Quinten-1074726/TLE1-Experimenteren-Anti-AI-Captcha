<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Teken Captcha — SVG icons</title>
  <style>
    body{font-family:Inter, system-ui, Arial;display:flex;flex-direction:column;align-items:center;padding:18px}
    h1{margin:6px 0 12px}
    #wrap{display:flex;gap:20px;align-items:flex-start}
    canvas{border-radius:8px;border:1px solid #bbb;touch-action:none}
    .controls{display:flex;flex-direction:column;gap:8px}
    button{padding:8px 12px;border-radius:6px;border:1px solid #888;background:white;cursor:pointer}
    .small{font-size:13px;color:#444}
    #result{font-weight:700;margin-top:8px}
  </style>
</head>
<body>
  <h1>Teken Captcha — SVG icons</h1>
  <div id="wrap">
    <canvas id="c" width="420" height="420"></canvas>
    <div class="controls">
      <button id="new">🎲 Nieuw icoon</button>
      <button id="clear">🧽 Wissen</button>
      <button id="check">✔️ Controleer</button>
      <label class="small"><input type="checkbox" id="hint"> Toon referentie (lichtgrijs)</label>
      <div id="result"></div>
      <div class="small">Tolerantie: <span id="tol">18</span> px</div>
    </div>
  </div>

  <script src="javascript/captcha.js"></script>
</body>
</html>