// Variable et constante
var fillStyle, font, text, textSize;
// Vérification si cercle déssiner
var circleIsDraw = false, otherIsDraw = false;
// Boutons
const btnUploadImg = document.getElementById('formPlanFile');
const btnCircle = document.getElementById('btn-check-circle-outlined');
const btnWarehouse = document.getElementById('btn-check-warehouse-outlined');
const btnRectangle = document.getElementById('btn-check-rectangle-outlined');
const btnPolygons = document.getElementById('btn-check-polygon-outlined');
const btnSave = document.getElementById('btn-save-coordonne');
const btnCancel = document.getElementById('btn-cancel-canvas');
// Input
const labelInputICPE = document.getElementById('labelInputICPE');
// Le plan
var canvasBorder = document.getElementById('canvasBorder');
var canvasPlan = document.getElementById('canvasPlan');
var width = 1081;
var height = 721;
var imageObj = new Image();
// Canvas context
var ctx = canvasPlan.getContext('2d');
// Text value
var getText = document.getElementById('listCoordonne');
// Zoom value
var zoomIntensity = 0.1;
var scale = 1;
var origineX = 0;
var origineY = 0;
var visibleWidth = width; 
var visibleHeight = height;



// Load canvas
document.addEventListener('DOMContentLoaded', () => {
    canvasPlan.width = width;
    canvasPlan.height = height;   
});

// Load image
btnUploadImg.addEventListener('change', (e) => {
    var url = URL.createObjectURL(e.target.files[0]);
    ctx.clearRect(0, 0, canvasPlan.width, canvasPlan.height);
    imageObj.onload = function () {
        ctx.drawImage(imageObj, origineX, origineY, imageObj.width / scale, imageObj.height / scale,
                0, 0, canvasPlan.width, canvasPlan.height);
    }
    imageObj.src = url;
})
// End load image

// Scroll effect function
canvasPlan.onwheel = function(e) {
    e.preventDefault();
    var x = e.clientX - canvasPlan.offsetLeft;
    var y = e.clientY - canvasPlan.offsetTop;
    var scroll = e.deltaY < 0 ? 1 : -2;

    var zoom = Math.exp(scroll * zoomIntensity);
    ctx.translate(origineX, origineY);

    origineX -= x / (scale * zoom) - x / scale;
    origineY -= y / (scale * zoom) - y / scale;

    ctx.scale(zoom, zoom);
    ctx.translate(-origineX, -origineY);

    // Updating scale and visible
    scale *= zoom;
    visibleWidth = width / scale;
    visibleHeight = height / scale;

    // Apply to image
    canvasPlan.style.transform = `scale(${scale})`;
}
// End scroll effect function

// Define canvas
canvasPlan.addEventListener('mousemove', getCoordonner, false);
var tableCoordonne = new Array();

// Draw in canvas
canvasPlan.addEventListener('click', function(e){
    getPosition(e);
});

function getPosition(event){
    var rect = canvasPlan.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top;
       
    drawCoordinates(x,y);
}

// Function draw element
function drawCoordinates(x,y){	
    if (this.fillStyle == null && this.font == null && this.text == null) {
        alert("Veuillez sélectionner un élément de la pannelle.");
    } else {
        if (labelInputICPE.value == 0 && btnCircle.checked == true) {
            alert("Veuillez sélectionner un code ICPE.")
        } else {
            // Define button is drawing
            if (btnCircle.checked == true) {
                circleIsDraw = true;
                disabledBtnOther();
            } else {
                otherIsDraw = true;
                disabledBtnCircle();
            }

            // Dra image
            ctx.fillStyle = this.fillStyle;
            ctx.font=this.font;
            ctx.textAlign = 'center';
            ctx.fillText(this.text,x,y);

            // Draw text
            ctx.font = '15pt Lato';
            ctx.fillStyle = '#797979';
            ctx.textAlign = 'center';
            ctx.fillText(this.labelInputICPE.value,x,y-25);

            // Add coordonner in table
            getCoordonnerSelect(x,y);
        }
    }
}

// Add coordonnee in table
function getCoordonnerSelect(x,y) {
    if (labelInputICPE.value.length != 0) {
        tableCoordonne.push([x,y, labelInputICPE.value])
    }
    getText.innerHTML = tableCoordonne;
}

// View live coordonnee
function getCoordonner(ev) {
    var bounding = ev.target.getBoundingClientRect();
    var x = ev.clientX - bounding.left;
    var y = ev.clientY - bounding.top;
    var getCoordText = document.getElementById('coordText');

    getCoordText.innerHTML = "Coordonné X : " + x + "; Coordonné Y = " + y +";";
}


// Function select image to draw
function functionDrawPoint (style, font, text) {
    this.fillStyle = style; // Red color
    this.font=font;
    this.text=text;
}
// End function select image ti draw

// Fonctionnalité des boutons
if(btnCircle.addEventListener('click', () => {
if(btnCircle.checked == true) {
    if(btnWarehouse.checked == true) {
        btnWarehouse.checked = false; 
    }
    // Define image to draw
    functionDrawPoint('#00FF00','25px FontAwesome','\uf111');
} else {
    functionDrawPoint(null,null,null);
}
}));

if(btnWarehouse.addEventListener('click', () => {
if(btnWarehouse.checked == true) {
    if(btnCircle.checked == true) {
        btnCircle.checked = false; 
    }
    // Define image to draw
    functionDrawPoint('#0d6efd','20px FontAwesome','\uF494');
    // Clear ICPE value
    labelInputICPE.value = null;
} else {
    // Clear image to draw
    functionDrawPoint(null,null,null);
}
}));
// Fin fonctionnalité des boutons

// Cancel and clear all draw an value
btnCancel.addEventListener('click', function() {
    tableCoordonne.length = 0;
    getText.innerHTML = tableCoordonne;
    circleIsDraw = false;
    otherIsDraw = false;
    activateAllFunction();
    ctx.clearRect(0, 0, canvasPlan.width, canvasPlan.height);
}, false);

function activateAllFunction() {
    // Activate textbox
    labelInputICPE.disabled = false;
    
    // Activate btn
    btnWarehouse.disabled = false;
    btnCircle.disabled = false;
}

function disabledBtnCircle() {
    btnCircle.disabled = true;
    labelInputICPE.disabled = true;
}

function disabledBtnOther() {
    btnWarehouse.disabled = true;
}

// Save data in database
btnSave.addEventListener("click", function () {
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "gere_localisation_icpe.php";
    var asynchronous = true;

    ajax.open(method, url, asynchronous);
    ajax.send();

    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
        }
    }
})