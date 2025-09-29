// -- eenvoudige set van SVG path-data (genormaliseerd, willekeurige eenvoudige icon-achtige paden)
const ICON_NAMES = [
  "user", "home", "heart", "star", "search", "menu", "check circle", "info", "warning", "check", "smiley", "car", "phone"
];
const ICONS = [
  "M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z", // user
  "M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z", // home
  "M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z", // heart
  "M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z", // star
  "M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z", // search
  "M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z", // menu
  "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z", // check circle
  "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z", // info
  "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h2v-2h-2v2zm0-4h2V7h-2v6z", // warning
  "M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z", // check
  "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.5 8.5c0 1.38-1.12 2.5-2.5 2.5s-2.5-1.12-2.5-2.5S11.62 8 13 8s2.5 1.12 2.5 2.5zm-7 0c0 1.38-1.12 2.5-2.5 2.5S3.5 11.88 3.5 10.5 4.62 8 6 8s2.5 1.12 2.5 2.5zM12 17.5c-2.33 0-4.31-1.46-5.11-3.5h10.22c-.8 2.04-2.78 3.5-5.11 3.5z", // smiley
  "M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z", // car
  "M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" // phone
];

const canvas = document.getElementById('c');
const ctx = canvas.getContext('2d');
const hintCheckbox = document.getElementById('hint');
const resultEl = document.getElementById('result');
const tolEl = document.getElementById('tol');

let chosenPath = null; // SVG path string
let chosenName = null; // name of the icon
let path2d = null;     // Path2D built from chosenPath
let transform = { sx:1, sy:1, tx:0, ty:0 };

// user drawing data
let drawing = false;
let userSegments = [];
let currentSegment = [];
let drawingStartTime = null;

// parameters
let tolerance = 18; // pixels
const targetArea = { x:10, y:10, w:400, h:400 }; // where to fit icon within canvas

// helpers: pick random icon
function pickIcon(){
  const idx = Math.floor(Math.random() * ICONS.length);
  return { path: ICONS[idx], name: ICON_NAMES[idx] };
}

// compute bbox using an offscreen SVG element
function computeBBox(pathD){
  const svgNS = 'http://www.w3.org/2000/svg';
  const svg = document.createElementNS(svgNS, 'svg');
  const p = document.createElementNS(svgNS, 'path');
  p.setAttribute('d', pathD);
  svg.appendChild(p);
  // Must be in DOM for getBBox to work in some browsers
  svg.style.position = 'absolute'; svg.style.left = '-9999px'; svg.style.top = '-9999px';
  document.body.appendChild(svg);
  const bb = p.getBBox();
  document.body.removeChild(svg);
  return bb; // { x, y, width, height }
}

function setNewIcon(){
  userPoints = [];
  resultEl.textContent = '';
  const icon = pickIcon();
  chosenPath = icon.path;
  chosenName = icon.name;
  path2d = new Path2D(chosenPath);

  console.log('Nieuw icoon geladen:', chosenName);

  // reset drawing data
  userSegments = [];
  currentSegment = [];
  drawingStartTime = null;

  // compute bbox and transform to fit targetArea
  const bb = computeBBox(chosenPath);
  const sx = targetArea.w / bb.width;
  const sy = targetArea.h / bb.height;
  const s = Math.min(sx, sy) * 0.9; // small padding
  const tx = (canvas.width - bb.width * s) / 2 - bb.x * s;
  const ty = (canvas.height - bb.height * s) / 2 - bb.y * s;
  transform = { sx: s, sy: s, tx: tx, ty: ty };

  redrawAll();
}

function clearUser(){
userSegments = [];
currentSegment = [];
drawingStartTime = null;
redrawAll();
}

function redrawAll(){
  ctx.setTransform(1,0,0,1,0,0);
  ctx.clearRect(0,0,canvas.width,canvas.height);

  // draw reference faint path if hint is on
  if (path2d){
    ctx.save();
    ctx.setTransform(transform.sx,0,0,transform.sy,transform.tx,transform.ty);
    ctx.lineWidth = 2 / transform.sx;
ctx.strokeStyle = 'red';
ctx.stroke(path2d);
    ctx.restore();
  }

  // draw user strokes (multiple segments)
  ctx.save();
  ctx.lineCap = 'round';
  ctx.lineJoin = 'round';
  ctx.strokeStyle = '#1a73e8';
  ctx.lineWidth = 4;
  for (let seg of userSegments) {
    if (seg.length > 1) {
      ctx.beginPath();
      ctx.moveTo(seg[0].x, seg[0].y);
      for (let i = 1; i < seg.length; i++) ctx.lineTo(seg[i].x, seg[i].y);
      ctx.stroke();
    }
  }
  // teken huidig segment
  if (currentSegment.length > 1) {
    ctx.beginPath();
    ctx.moveTo(currentSegment[0].x, currentSegment[0].y);
    for (let i = 1; i < currentSegment.length; i++) ctx.lineTo(currentSegment[i].x, currentSegment[i].y);
    ctx.stroke();
  }
  ctx.restore();

  // border/guide
  ctx.setTransform(1,0,0,1,0,0);
  ctx.strokeStyle = '#eee'; ctx.lineWidth = 1; ctx.strokeRect(10,10,400,400);
}

// input handling (mouse & touch)
function getPosFromEvent(e){
  const rect = canvas.getBoundingClientRect();
  if (e.touches && e.touches[0]) e = e.touches[0];
  return { x: e.clientX - rect.left, y: e.clientY - rect.top };
}

canvas.addEventListener('mousedown', (e)=>{
  drawing = true;
  const pos = getPosFromEvent(e);
  currentSegment = [{x: pos.x, y: pos.y, time: Date.now()}];
  if (!drawingStartTime) drawingStartTime = Date.now();
  redrawAll();
});
window.addEventListener('mousemove', (e)=>{
  if (!drawing) return;
  const pos = getPosFromEvent(e);
  currentSegment.push({x: pos.x, y: pos.y, time: Date.now()});
  redrawAll();
});
window.addEventListener('mouseup', ()=>{
  if (drawing && currentSegment.length > 0) {
    userSegments.push(currentSegment);
    currentSegment = [];
  }
  drawing = false;
});

canvas.addEventListener('touchstart', (ev)=>{
  ev.preventDefault();
  drawing = true;
  const pos = getPosFromEvent(ev);
  currentSegment = [{x: pos.x, y: pos.y, time: Date.now()}];
  if (!drawingStartTime) drawingStartTime = Date.now();
  redrawAll();
});
window.addEventListener('touchmove', (ev)=>{
  if (!drawing) return;
  ev.preventDefault();
  const pos = getPosFromEvent(ev);
  currentSegment.push({x: pos.x, y: pos.y, time: Date.now()});
  redrawAll();
}, {passive:false});
window.addEventListener('touchend', ()=>{
  if (drawing && currentSegment.length > 0) {
    userSegments.push(currentSegment);
    currentSegment = [];
  }
  drawing = false;
});

// scoring: use ctx.isPointInStroke with a widened lineWidth (tolerance) and same transform
function checkDrawing(){
  if (!path2d) return;
  // Verzamel alle punten van alle segmenten
  let allPoints = userSegments.flat().concat(currentSegment);
  if (allPoints.length < 6){ resultEl.textContent = 'Teken iets voordat je controleert.'; return; }

  ctx.setTransform(transform.sx,0,0,transform.sy,transform.tx,transform.ty);
  ctx.lineWidth = tolerance * 2 / transform.sx;

  // 1. Check of gebruiker genoeg punten op de lijn heeft gezet
  let hits = 0;
  for (let p of allPoints){
    if (ctx.isPointInStroke(path2d, p.x, p.y)) hits++;
  }
  const score = hits / allPoints.length;

  // 2. Check of gebruiker langs (bijna) alle delen van de lijn is gegaan
  function samplePath(path2d, n){
    const tempCanvas = document.createElement('canvas');
    tempCanvas.width = canvas.width;
    tempCanvas.height = canvas.height;
    const tempCtx = tempCanvas.getContext('2d');
    tempCtx.setTransform(transform.sx,0,0,transform.sy,transform.tx,transform.ty);
    tempCtx.lineWidth = 2;
    tempCtx.strokeStyle = 'black';
    tempCtx.stroke(path2d);
    const imgData = tempCtx.getImageData(0,0,tempCanvas.width,tempCanvas.height).data;
    let points = [];
    for(let y=0;y<tempCanvas.height;y+=2){
      for(let x=0;x<tempCanvas.width;x+=2){
        const idx = (y*tempCanvas.width + x)*4;
        if(imgData[idx+3]>128){
          points.push({x:x,y:y});
        }
      }
    }
    if(points.length>n){
      let sampled = [];
      for(let i=0;i<n;i++){
        sampled.push(points[Math.floor(Math.random()*points.length)]);
      }
      return sampled;
    }
    return points;
  }

  const refPoints = samplePath(path2d, 60);
  let refHits = 0;
  for(let rp of refPoints){
    let close = allPoints.some(up => {
      const dx = up.x - rp.x;
      const dy = up.y - rp.y;
      return (dx*dx + dy*dy) < (tolerance*tolerance);
    });
    if(close) refHits++;
  }
  const refScore = refHits / refPoints.length;

  // 3. Human-like checks: speed variation and straightness
  function calculateHumanScore(points) {
    if (points.length < 2) return 0;
    const totalTime = points[points.length-1].time - points[0].time;
    if (totalTime < 500) return 0; // too fast

    // Speed variation
    let speeds = [];
    for (let i = 1; i < points.length; i++) {
      const dt = points[i].time - points[i-1].time;
      if (dt === 0) continue;
      const dx = points[i].x - points[i-1].x;
      const dy = points[i].y - points[i-1].y;
      const dist = Math.sqrt(dx*dx + dy*dy);
      const speed = dist / dt; // pixels per ms
      speeds.push(speed);
    }
    if (speeds.length < 1) return 0;
    const avgSpeed = speeds.reduce((a,b)=>a+b,0) / speeds.length;
    const variance = speeds.reduce((a,b)=>a + (b-avgSpeed)**2, 0) / speeds.length;
    const stdDev = Math.sqrt(variance);
    const speedScore = avgSpeed > 0 ? Math.min(stdDev / avgSpeed, 1) : 0; // variation relative to average

    // Straightness per segment
    let straightness = 0;
    let segmentCount = 0;
    for (let seg of userSegments) {
      if (seg.length < 3) continue;
      const start = seg[0];
      const end = seg[seg.length-1];
      const dx = end.x - start.x;
      const dy = end.y - start.y;
      const length = Math.sqrt(dx*dx + dy*dy);
      if (length === 0) continue;
      let totalDev = 0;
      for (let i = 1; i < seg.length-1; i++) {
        const p = seg[i];
        const num = Math.abs(dy * (p.x - start.x) - dx * (p.y - start.y));
        const dev = num / length;
        totalDev += dev;
      }
      const avgDev = totalDev / (seg.length - 2);
      straightness += Math.max(0, 1 - avgDev / 10); // normalize, lower dev is straighter, but we want some deviation
      segmentCount++;
    }
    const straightScore = segmentCount > 0 ? straightness / segmentCount : 0;

    // Combine scores
    const humanScore = (speedScore * 0.6 + straightScore * 0.4);
    return humanScore;
  }

  const humanScore = calculateHumanScore(allPoints);

  if (score >= 0.72 && refScore >= 0.8 && humanScore >= 0.2){
    resultEl.textContent = `✅ Geslaagd — ${Math.round(score*100)}% op lijn, ${Math.round(refScore*100)}% gevolgd.`;
  } else {
    resultEl.textContent = `❌ Niet goed genoeg — ${Math.round(score*100)}% op lijn, ${Math.round(refScore*100)}% gevolgd.`;
  }

  ctx.setTransform(1,0,0,1,0,0);
}

// UI wiring
document.getElementById('new').addEventListener('click', ()=>{ setNewIcon(); });
document.getElementById('clear').addEventListener('click', ()=>{ clearUser(); });
document.getElementById('check').addEventListener('click', ()=>{ checkDrawing(); });
hintCheckbox.addEventListener('change', ()=>{ redrawAll(); });

// small control to change tolerance with keyboard +/- 
window.addEventListener('keydown', (e)=>{
  if (e.key === '+' || e.key === '='){ tolerance = Math.min(60, tolerance+2); tolEl.textContent = tolerance; }
  if (e.key === '-') { tolerance = Math.max(4, tolerance-2); tolEl.textContent = tolerance; }
});

// init
setNewIcon();