    let model;
	
	const classMapping = {
    0: 'Antracnosis',
    1: 'Saludable',
    2: 'Sarna'
	};
	const classMessages = {
    'Saludable': {
        text: '<p> Muy Buen Trabajo! Tus paltas estan saludables y no tienen ninguna enfermedad! Pero no te descuides que las enfermedades pueden amenazar tus plantas en cualquier momento, para evitar ello sigue estos consejos: </p><ol>   <li>Monitoreo Regular: Inspeccione regularmente los árboles en busca de signos de enfermedades y tome medidas de inmediato si se detectan.</li>   <li>Poda y Nutrición: Realice podas regulares y asegúrese de que los árboles reciban nutrientes adecuados.</li>   <li>Riego: Mantenga un programa de riego adecuado para evitar el estrés hídrico.</li>   <li>Control de Plagas: Controle las plagas que pueden debilitar los árboles y hacerlos más susceptibles a enfermedades.</li> </ol> <div style="margin-top: 50px"></div>',
        imageUrl: 'paltaSaludable.jpg' 
    },
    'Sarna': {
        text: '<p>La Sarna o Roña del palto, es una enfermedad fúngica que afecta frutos, hojas y ramas jóvenes. Causa una reducción de la calidad comercial de la fruta.  Para combatirlo sigue estos consejos: </p><ol>  <li>Monitoreo Regular: Inspeccione regularmente los árboles en busca de signos de enfermedades y tome medidas de inmediato si se detectan.</li>  <li>Poda y Nutrición: Realice podas regulares y asegúrese de que los árboles reciban nutrientes adecuados.</li>   <li>Riego: Mantenga un programa de riego adecuado para evitar el estrés hídrico.</li>  <li>Control de Plagas: Controle las plagas que pueden debilitar los árboles y hacerlos más susceptibles a enfermedades.</li> </ol> <div style="margin-top: 50px"></div>',
        imageUrl: 'paltaSarna.jpg'
    },
    'Antracnosis': {
        text: '<p>La antracnosis es causada por dos agentes patógenos: Colletotrichum gloeosporioides (Penz) Penz & Sacc. y Colletotrichum acutatum de la familia de los Ascomicetos. Para combatirlo sigue estos consejos: </p><ol>  <li>Fungicidas: Utilice fungicidas específicos para antracnosis según las recomendaciones del fabricante.</li>   <li>Poda y Sanación de Heridas: Pode las ramas afectadas y asegúrese de que las heridas estén bien sanadas.</li>   <li>Mantenimiento: Mantenga el huerto limpio y elimine los restos de plantas infectadas.</li>   <li>Riego Controlado: Evite el riego por aspersión que puede propagar esporas de la enfermedad.</li> </ol> <div style="margin-top: 50px"></div>',
        imageUrl: 'paltaAnt.jpg'
    }
};

	function updateMessageSection(className) {
		const messageDiv = document.getElementById('recom');
		const messageInfo = classMessages[className];


		const messageContent = `
			<p>${messageInfo.text}</p>
			<img src="${messageInfo.imageUrl}" alt="${className}" style="max-width:600px;height:auto;">
		`;


		messageDiv.innerHTML = messageContent;
	}

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

	let creditos= "Daniel Pedro José Castillo Carlin"
    let predictedClassName = classMapping[predictedClassIndex];

    document.getElementById('predictionResult').innerText = predictedClassName;
	updateMessageSection(predictedClassName);

    URL.revokeObjectURL(img.src);
}

document.getElementById('predictButton').addEventListener('click', async () => {
    const imageUpload = document.getElementById('imageUpload');
    const imageFile = imageUpload.files[0];
    if (imageFile) {

        const progressMessage = document.getElementById('progressMessage');
        progressMessage.innerText = "Cargando...";

        
        await predictImage(imageFile);

        
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
let creditos= "Daniel Pedro José Castillo Carlin"
