<!DOCTYPE html>
<html>
<head>
    <title>Capstone Project</title>
	<link rel="icon" type="image/png" sizes="16x16" href="icono.png">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<!--
<body>
	
	<img src="esanlogo.jpg" alt="" width=auto height="80" style="margin-bottom: 50px; margin-top: 0px">
    <h1>Capstone Project - Clasificador de paltas</h1>
	<p>Clasificador de imagenes de paltas utilizanod tensorflow para el Capstone Project</p>
    <input type="file" id="imageUpload" accept="image/*">
	<button id="predictButton">Clasificar</button>
	<img id="imagePreview" />
	<p id="progressMessage"></p>
	<p id="predictionResult"></p>
<div id="bottomBar"></div>
</body>
-->
	
<body>
    <header>
        <img src="esanlogo.jpg" alt="Logo" id="logo">
        <h1>Capstone Project - Clasificador de paltas</h1>
    </header>
    
    <div id="content">
        <div id="imageSection">
            <input type="file" id="imageUpload" accept="image/*">
            <button id="predictButton">Clasificar</button>
			<img id="imagePreview" />
			<p id="progressMessage"></p>
			<p id="predictionResult"></p>
			
        </div>
        
        <div id="messageSection">
            <p id="message">Aquí aparecerán los mensajes.</p>
        </div>
    </div>

    <div id="bottomBar"></div>
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

    document.getElementById('predictionResult').innerText = 'Predicción: ' + predictedClassName;


    URL.revokeObjectURL(img.src);
}

//document.getElementById('predictButton').addEventListener('click', () => {
//    const imageUpload = document.getElementById('imageUpload');
//    const imageFile = imageUpload.files[0];
//    if (imageFile) {
//        predictImage(imageFile);
//    }
//});
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

