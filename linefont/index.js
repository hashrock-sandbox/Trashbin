var running;
var interval = 4;
var mousePoint = {x: -999, y: 0};
var MAX_DIST = 75;

var canvas = document.createElement('canvas');
canvas.width = 512;
canvas.height = 512;
var context = canvas.getContext('2d');
document.body.appendChild(canvas);
canvas.addEventListener('mousemove', mouseMove, false);
canvas.addEventListener('mouseout', mouseOut, false);

function mouseMove(e) {
    mousePoint.x = e.offsetX;
    mousePoint.y = e.offsetY;
    //mousePoint.x = e.clientX;
    //mousePoint.y = e.clientY;
}

function mouseOut(e) {
    mousePoint.x = mousePoint.y = -999;
}

var lines;
var geometries, i, geometry;
var vertices;
var scale = 10;

var text = 'static planning by 181'.toUpperCase();
lines = text.split(' ');
newtext();

// changetext();


function newtext() {
    geometries = [];
    var maxWidth = 0;
    for (i=0;i<lines.length;i++) {
        geometry = Text(lines[i]);
        geometries.push(geometry);
        geometry.computeBoundingBox();
        maxWidth = Math.max(geometry.boundingBox.max.x, maxWidth);
    }
    
    var height = 6;
    var left;
    vertices = [];
    
    for (i=0;i<lines.length;i++) {
        geometry = geometries[i];
        left = (maxWidth - geometry.boundingBox.max.x) / 2;
        
        geometry.applyMatrix(new THREE.Matrix4().makeTranslation(left, -(i+1) * height, 0));
        
        geometry.vertices.delay = Math.random() * 1;
        geometry.vertices.multiplier = 0.5 + Math.random() * 1;
        vertices = vertices.concat(geometry.vertices);
    }
    
    
    context.lineWidth = 1.5 / scale;
    
    for (var vi=0, vl=vertices.length;vi<vl;vi+=2) {
        var v1 = vertices[vi];
        v1.delay = Math.random() * 4;
        v1.multiplier = 0.5 +  Math.random() * 2.5;
    }
    
}

var progress = 0;
var amp = 0.5;

function draw() {
    context.clearRect(0,0,canvas.width, canvas.height);
    context.save();
    context.translate(40, 10);
    context.scale(scale, -scale);
    
    draw0();
    
    context.restore();
    
}

function distance(p1, p2) {
    var a = p1.x - p2.x,
        b = p1.y - p2.y;
    return Math.sqrt(Math.pow(a, 2) + Math.pow(b, 2));
}

function draw0() {
    
    progress += 0.04;
    if (progress > 1) progress = 1;
    
    for (var vi=0, vl=vertices.length;vi<vl;vi+=2) {
        var v1 = vertices[vi];
        var v2 = vertices[vi+1];

        var dx = (v2.x - v1.x) * progress + v1.x;
        var dy = (v2.y - v1.y) * progress + v1.y;

        var dd = distance(v1, mousePoint)/ 100;

        context.beginPath();
        context.arc(v1.x, v1.y, dd, 0, Math.PI*2, true); 
        context.closePath();
        context.stroke();
        //context.fill();
        
        context.beginPath();
        context.circle
        context.moveTo(v1.x, v1.y);
        context.lineTo(dx, dy);
        context.stroke();
        context.closePath();
        
    }
}

running = setInterval(draw, interval);
