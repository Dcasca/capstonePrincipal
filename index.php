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
			<img id="imagePreview" />
			<h4>Predicción: </h4>
			<p id="progressMessage"></p>
			<p id="predictionResult"></p>
			
        </div>
        
        <div id="messageSection" style="background-color: azure; height: 700px; ">
			<h3 style="margin-left: 20px;">Recomendaciónes</h3>
<!--            <p id="message">Aquí aparecerán los mensajes.</p>-->
        </div>
    </div>

    <div id="bottomBar">
		<h3 style="color: white; text-align: center; margin-top: 50px;"> La página web para clasificar la salud de las paltas mediante imágenes es esencial para la agricultura al permitir la detección temprana de enfermedades, reducir pérdidas y promover prácticas sostenibles. Beneficiaría a agricultores y la seguridad alimentaria al mejorar la gestión de cultivos.</h3>
	</div>
</body>
	
</html>

<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>

<script>
    let model;
	
	const classMapping = {
    0: 'Anthracnose',
    1: 'Healthy',
    2: 'Scab'
	};
	
    window.onload = async () => {
        model = await tf.loadLayersModel('model.json');
    };

    async function predictImage(imageFile) {
   
    let img = new Image();
    img.src = URL.createObjectURL(imageFile);

   
    await new Promise((resolve) => {
        img.onload = resolve;
    });


    let tensor = tf.browser.fromPixels(img)
        .resizeNearestNeighbor([150, 150])
        .toFloat()
        .expandDims();

    let prediction = await model.predict(tensor).data();


    let predictedClassIndex = Array.from(prediction).indexOf(Math.max(...prediction));


    let predictedClassName = classMapping[predictedClassIndex];

    document.getElementById('predictionResult').innerText = predictedClassName;


    URL.revokeObjectURL(img.src);
}


document.getElementById('predictButton').addEventListener('click', async () => {
    const imageUpload = document.getElementById('imageUpload');
    const imageFile = imageUpload.files[0];
    if (imageFile) {
        // Mostrar mensaje de progreso
        const progressMessage = document.getElementById('progressMessage');
        progressMessage.innerText = "Cargando...";

        // Proceder con la predicción
        await predictImage(imageFile);

        // Una vez completada la predicción, limpiar el mensaje de progreso
        progressMessage.innerText = "";
    }
});

	
document.getElementById('imageUpload').addEventListener('change', (event) => {
    const imageFile = event.target.files[0];
    if (imageFile) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = URL.createObjectURL(imageFile);
        imagePreview.onload = () => {
            URL.revokeObjectURL(imagePreview.src);
        };
    }
});


	
</script>

