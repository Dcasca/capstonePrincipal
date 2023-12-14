<!DOCTYPE html>
<html>
<head>
    <title>Capstone Project</title>
	<link rel="icon" type="image/png" sizes="16x16" href="icono.png">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <header>
		<div class="header-content">
			<img src="logouniversidad.jpg" alt="Logo" id="logo">
			<h1>Capstone Project - Clasificador de paltas</h1>
			<p>Clasificador de imagenes de paltas utilizando tensorflow</p>
		</div>
    </header>
	
    <div id="content">
        <div id="imageSection" style="margin-top: 10px;">
            <input type="file" id="imageUpload" accept="image/*">
            <button id="predictButton">Clasificar</button>
			<div style="margin-top: 50px;"></div>
			<img  id="imagePreview" />
			
			
			<h4 style="margin-top: 90px;">Predicción: </h4>
			<p id="progressMessage"></p>
			<p id="predictionResult"></p>
			
        </div>
        
        <div id="messageSection" style="background-color: azure; height: 700px; ">
			<h3 style="margin-left: 20px;">Recomendaciónes</h3>
			<div style="margin-left: 20px;" id="recom"></div>
        </div>
    </div>

    <div id="bottomBar">
		<h3 style="color: white; text-align: center; margin-top: 50px;"> La página web para clasificar la salud de las paltas mediante imágenes es esencial para la agricultura al permitir la detección temprana de enfermedades, reducir pérdidas y promover prácticas sostenibles. Beneficiaría a agricultores y la seguridad alimentaria al mejorar la gestión de cultivos.</h3> <p style="visibility: hidden">Creditos: Daniel Pedro Jose Castillo Carlin</p>
	</div>
</body>
	
</html>
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
<script src="script.js"></script>

Creditos: Daniel Pedro Jose Castillo Carlin