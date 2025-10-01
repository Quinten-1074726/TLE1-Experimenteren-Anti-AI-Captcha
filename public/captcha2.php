
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Teken Captcha — SVG icons</title>
  <link rel="stylesheet" href="styling/style.css">
  <link rel="stylesheet" href="styling/header.css">
  <link rel="stylesheet" href="styling/upload.css">
</head>
<body class="upload-page">
  <main style="display:flex;justify-content:center;align-items:center;min-height:80vh;">
    <div id="wrap" style="background:linear-gradient(135deg, rgb(219, 217, 217) 0%, rgb(178, 178, 178) 100%);padding:32px 40px 24px 40px;border-radius:18px;box-shadow:0 8px 32px rgba(0,0,0,0.35);display:flex;flex-direction:column;align-items:center;justify-content:center;min-width:340px;max-width:90vw;">
      <canvas id="c" width="420" height="420" style="border-radius:12px;border:1px solid #d1d1d1;box-shadow:0 2px 12px rgba(0,0,0,0.08);margin-bottom:24px;"></canvas>
      <div class="controls" style="width:100%;display:flex;flex-direction:column;align-items:center;">
        <div class="captcha-btn-row" style="display:flex;flex-direction:row;gap:18px;width:100%;justify-content:center;margin-bottom:20px;">
          <button id="new" class="upload-btn-primary" style="background:linear-gradient(90deg, rgb(77, 90, 102) 0%, rgb(107, 123, 136) 100%);min-width:120px;">🎲 Nieuw icoon</button>
          <button id="clear" class="upload-btn-primary" style="background:linear-gradient(90deg, rgb(55, 82, 104) 0%, rgb(74, 107, 130) 100%);min-width:120px;">🧽 Wissen</button>
        </div>
        <button id="check" class="upload-btn-primary" style="background:linear-gradient(90deg, rgb(37, 53, 68) 0%, rgb(26, 37, 48) 100%);min-width:120px;">✔️ Controleer</button>
        <label class="small"><input type="checkbox" id="hint" hidden></label>
      </div>
    </div>
  </main>
  <script src="javascript/captcha.js"></script>
</body>
</html>