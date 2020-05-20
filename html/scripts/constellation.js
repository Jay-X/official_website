var n = 5;
var astroids = [];

var border = 3;
var friction = 0;
var speed = 0.2;
var moveRange = 10;
var myCanvas;
var ratio = 8000/4500;
var canvasHeight = window.innerHeight;
var canvasWidth = canvasHeight * ratio;
var constellateDistance = 220;
var locations = [];
var diffuseRate = 1.4;
var canvasDefaultHeight = 800;
var globecover = JSON.parse("[{\"x\":0.5351617440225035,\"y\":0.52625},{\"x\":0.5766526019690577,\"y\":0.49},{\"x\":0.6019690576652602,\"y\":0.57375},{\"x\":0.5351617440225035,\"y\":0.6},{\"x\":0.49718706047819966,\"y\":0.57375},{\"x\":0.4268635724331927,\"y\":0.54875},{\"x\":0.49718706047819966,\"y\":0.47625},{\"x\":0.42756680731364277,\"y\":0.47},{\"x\":0.45639943741209565,\"y\":0.4625},{\"x\":0.4739803094233474,\"y\":0.3725},{\"x\":0.44585091420534456,\"y\":0.33875},{\"x\":0.430379746835443,\"y\":0.31125},{\"x\":0.4177215189873418,\"y\":0.3925},{\"x\":0.40787623066104084,\"y\":0.3325},{\"x\":0.3846694796061884,\"y\":0.46},{\"x\":0.3959212376933896,\"y\":0.51875},{\"x\":0.44796061884669475,\"y\":0.655},{\"x\":0.49367088607594933,\"y\":0.62375},{\"x\":0.519690576652602,\"y\":0.6925},{\"x\":0.5323488045007032,\"y\":0.735},{\"x\":0.5632911392405063,\"y\":0.68125},{\"x\":0.5731364275668073,\"y\":0.63375},{\"x\":0.6125175808720112,\"y\":0.60125},{\"x\":0.5872011251758087,\"y\":0.69},{\"x\":0.639943741209564,\"y\":0.615},{\"x\":0.6244725738396625,\"y\":0.51},{\"x\":0.6490857946554149,\"y\":0.55625},{\"x\":0.6540084388185654,\"y\":0.47},{\"x\":0.6434599156118143,\"y\":0.4025},{\"x\":0.620253164556962,\"y\":0.415},{\"x\":0.5668073136427567,\"y\":0.395},{\"x\":0.5372714486638537,\"y\":0.42625},{\"x\":0.4964838255977497,\"y\":0.3125},{\"x\":0.5372714486638537,\"y\":0.32375},{\"x\":0.5857946554149086,\"y\":0.3175},{\"x\":0.6160337552742616,\"y\":0.3525},{\"x\":0.6315049226441631,\"y\":0.30875},{\"x\":0.5949367088607594,\"y\":0.2875},{\"x\":0.5316455696202531,\"y\":0.2775},{\"x\":0.4887482419127989,\"y\":0.26125},{\"x\":0.43600562587904357,\"y\":0.2625},{\"x\":0.45710267229254575,\"y\":0.25375},{\"x\":0.5063291139240507,\"y\":0.21125},{\"x\":0.5478199718706048,\"y\":0.23},{\"x\":0.5351617440225035,\"y\":0.25},{\"x\":0.5942334739803093,\"y\":0.25625},{\"x\":0.5632911392405063,\"y\":0.25875},{\"x\":0.6111111111111112,\"y\":0.2975}]");
var connected = JSON.parse("{\"0\":[0,1,2,3,4,6,17,21,31,48],\"1\":[0,1,2,22,25,29,30,31],\"2\":[0,1,2,3,20,21,22,23,24,25,26],\"3\":[0,2,3,4,17,18,20,21,23,48],\"4\":[0,3,4,5,6,16,17,18,48],\"5\":[4,5,7,8,14,15,16],\"6\":[0,4,6,7,8,9,31,48],\"7\":[5,6,7,8,9,12,14,15],\"8\":[5,6,7,8,9,10,12,14,15,48],\"9\":[6,7,8,9,10,11,12,13,31,32,33,39,40,41],\"10\":[8,9,10,11,12,13,32,39,40,41],\"11\":[9,10,11,12,13,32,39,40,41],\"12\":[7,8,9,10,11,12,13,14],\"13\":[9,10,11,12,13,40,41],\"14\":[5,7,8,12,14,15],\"15\":[5,7,8,14,15],\"16\":[4,5,16,17],\"17\":[0,3,4,16,17,18,48],\"18\":[3,4,17,18,19,20,21,23],\"19\":[18,19,20,21,23],\"20\":[2,3,18,19,20,21,22,23],\"21\":[0,2,3,18,19,20,21,22,23,24],\"22\":[1,2,20,21,22,23,24,25,26],\"23\":[2,3,18,19,20,21,22,23,24],\"24\":[2,21,22,23,24,25,26],\"25\":[1,2,22,24,25,26,27,28,29],\"26\":[2,22,24,25,26,27],\"27\":[25,26,27,28,29],\"28\":[25,27,28,29,35,36,47],\"29\":[1,25,27,28,29,30,34,35,36,47],\"30\":[1,29,30,31,33,34,35,37,47],\"31\":[0,1,6,9,30,31,33,48],\"32\":[9,10,11,32,33,38,39,40,41,42,43,44],\"33\":[9,30,31,32,33,34,37,38,39,42,43,44,45,46],\"34\":[29,30,33,34,35,36,37,38,43,44,45,46,47],\"35\":[28,29,30,34,35,36,37,45,47],\"36\":[28,29,34,35,36,37,45,47],\"37\":[30,33,34,35,36,37,38,43,44,45,46,47],\"38\":[32,33,34,37,38,39,42,43,44,45,46],\"39\":[9,10,11,32,33,38,39,40,41,42,43,44],\"40\":[9,10,11,13,32,39,40,41],\"41\":[9,10,11,13,32,39,40,41,42],\"42\":[32,33,38,39,41,42,43,44,46],\"43\":[32,33,34,37,38,39,42,43,44,45,46],\"44\":[32,33,34,37,38,39,42,43,44,45,46],\"45\":[33,34,35,36,37,38,43,44,45,46,47],\"46\":[33,34,37,38,42,43,44,45,46,47],\"47\":[28,29,30,34,35,36,37,45,46,47],\"48\":[0,3,4,6,8,17,31,48]}");
function preload() {
  img = loadImage('images/polyplanet.png');
}
function setup() {
  myCanvas = createCanvas(canvasWidth, canvasHeight);
  //canvasWidth = canvasDefaultHeight*ratio;
  //canvasHeight = canvasDefaultHeight;
  var setUsed = globecover;
  for (let i = 0; i < setUsed.length; i++) {
    astroids.push(new Astroid(setUsed[i].x,setUsed[i].y,random(4,8)));
  }
  astroids.push(new Astroid(0.5,0.5,random(5,12)))
  myCanvas.parent('constellation');   
  frameRate(30);
}


function draw(){
  
  if (drawConstellation == true){
    clear();
    //background('#333844');
    //image(img, 0, 0, 400,canvasHeight, 0, 0, 400, canvasHeight, 0, 0);
    //8000 x 4500
    image(img, 0, 0, ratio * canvasHeight, canvasHeight);
    for (var i=0;i<astroids.length;i++){
        astroids[i].display();
        astroids[i].update();
        astroids[i].comeback();
        astroids[i].mouseConstellate();
        astroids[i].constellate(i);
    }
  }
}
let ratio2 = canvasHeight / canvasDefaultHeight;
function windowResized() {
  canvasWidth = canvasHeight*ratio;
  canvasHeight = window.innerHeight;
  ratio2 = canvasHeight / canvasDefaultHeight;
  for (let i = 0; i < astroids.length; i++) {
    astroids[i].pos.x = astroids[i].originalPos.x * canvasWidth;
    astroids[i].pos.y = astroids[i].originalPos.y * canvasHeight;
  }
  resizeCanvas(canvasWidth, canvasHeight);
}
var indicesConnecting = {};
function Astroid(x,y,s){
    this.velocityx = random(-speed,speed);
    this.velocityy = random(-speed,speed);
    this.pos = createVector(x*canvasWidth,y*canvasHeight);
    this.originalPos = {x:x,y:y};
    this.size = s;
    this.display = function() {
        fill(255,255,255,255);
        noStroke();
        ellipse(this.pos.x,this.pos.y, s*ratio2, s*ratio2);
    }
    this.update = function(){
        this.pos = this.pos.add(this.velocityx,this.velocityy)
      if (random(0,1) < 0.01) {
        //this.pos.x += random(-2,2)*1;
        //this.pos.y += random(-2,2)*1;
      }
    }
    this.comeback = function() {
      let diffx = this.originalPos.x*canvasWidth - this.pos.x;
      let diffy = this.originalPos.y*canvasHeight - this.pos.y;
      let dist = sqrt(pow(diffx,2) + pow(diffy,2))
      if (dist > moveRange + 1) {
        this.pos.x = this.originalPos.x * canvasWidth;
        this.pos.y = this.originalPos.y * canvasHeight;
      }
      else if (dist > moveRange) {
        //this.velocityx = random(-speed,speed);
        //this.velocityy = random(-speed,speed);
        this.velocityx*=-1;
        this.velocityy*=-1;
      }
    }
  
    this.mouseConstellate = function(){
        let diffx = mouseX - this.pos.x
        let diffy = mouseY - this.pos.y
        if (sqrt(pow(diffx,2) + pow(diffy,2)) <= constellateDistance){
           
            strokeWeight(1);
            stroke(255, 255, 255, 180-diffuseRate/ratio2*sqrt(pow(diffx,2) + pow(diffy,2)));
            line(this.pos.x, this.pos.y, mouseX, mouseY)
            line(mouseX, mouseY, this.pos.x, this.pos.y)
        }
        if (mouseIsPressed && sqrt(pow(diffx,2) + pow(diffy,2)) <= 200) {
            this.pos.x = this.pos.x + this.velocityx*5.5
            this.pos.y = this.pos.y + this.velocityy*5.5
        }
    }
    this.constellate = function(k){
        //indicesConnecting[k] = [];
      /*
        for (let t=0;t<astroids.length;t++){
            if (sqrt(pow((astroids[t].pos.x - this.pos.x),2) + pow((astroids[t].pos.y - this.pos.y),2)) <= constellateDistance){
                indicesConnecting[k].push(t);
                stroke(255, 255, 255, 150-diffuseRate/ratio2*sqrt(pow((astroids[t].pos.x - this.pos.x),2) + pow((astroids[t].pos.y - this.pos.y),2)));
                line(this.pos.x, this.pos.y, astroids[t].pos.x, astroids[t].pos.y)
        
                

            }

        }
        */
      for (let t = 0; t < connected[k].length; t++) {
        let oi = connected[k][t];
         stroke(255, 255, 255, 150-diffuseRate/ratio2*sqrt(pow((astroids[oi].pos.x - this.pos.x),2) + pow((astroids[oi].pos.y - this.pos.y),2)));
          line(this.pos.x, this.pos.y, astroids[oi].pos.x, astroids[oi].pos.y)
      }

        

        
    }
        
}
function keyTyped() {
  if (key === 'a') {
    //astroids.push(new Astroid(mouseX/canvasWidth,mouseY/canvasDefaultHeight,10));
    //locations.push({x:mouseX/canvasWidth,y:mouseY/canvasDefaultHeight});
  }
}
function mouseClicked(){
    return true;
}