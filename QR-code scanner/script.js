// Select DOM elements
const fileInput = document.getElementById("fileInput"), 
image = document.getElementById("qrImage"), 
qrCodeView = document.querySelector(".qrCodeView"),
iconGroup = document.querySelector(".iconGroup"),
textarea = document.querySelector("textarea"),
displayMessage = document.querySelector(".iconGroup p"),
qrTextDetails = document.querySelector(".qrTextDetails"),
stopScan = document.getElementById("stopScan"), 
copyButton = document.querySelector(".copy"),
closeButton = document.querySelector(".close");

// Initialize stopScan as hidden
stopScan.style.display = "none";

// Listen for file input change
fileInput.addEventListener("change", e => {
    let file = e.target.files[0];
    if (!file) return;
    
    //later added---------------------
    image.src = URL.createObjectURL(file);
    image.onload = () => {
        URL.revokeObjectURL(image.src);
    };
    //--------------------------------

    image.style.display = "block";
    iconGroup.style.display = "none";
    stopScan.style.display = "none"; // Hide stop button when uploading

    fetchQRCodeResponse(file);
});

// Add event listeners for Copy and Close buttons
copyButton.addEventListener("click", copyQRCodeText);
closeButton.addEventListener("click", closeQRCodeReader);

// Add event listener for Stop Scan button
stopScan.addEventListener("click", closeQRCodeReader);

// Fetch QR code response from API
function fetchQRCodeResponse(file) {
    let formData = new FormData();
    formData.append("file", file);

    fetch("https://api.qrserver.com/v1/read-qr-code/", {
        method: "POST",
        body: formData,
    })  
    .then((response) => response.json())
    .then((data) => {
        let result = data[0].symbol[0].data;

        if (!result){
            displayMessage.innerText = "Kan de QR-code niet lezen. Probeer het opnieuw.";
            return;
        }
        
        qrTextDetails.style.display="block";
        textarea.value = result;

        image.style.display = "block";
        image.src= URL.createObjectURL(file);

        iconGroup.style.display = "none";
        qrCodeView.style.display="flex";
    })

    // Handle errors
    .catch((error) => {
        console.error(error);
        displayMessage.innerText = "Er is een fout opgetreden bij het lezen van de QR-code. Probeer het opnieuw.";
    });
}

// Copy QR code text to clipboard
function copyQRCodeText(){
    let text = textarea.value;
    navigator.clipboard.writeText(text);
}

// Close QR code reader and reset UI
function closeQRCodeReader(){
    displayMessage.innerText = "Upload of Scan QR Code";
    iconGroup.style.display = "block";
    image.style.display = "none";
    qrTextDetails.style.display = "none";
    textarea.value = "";
    fileInput.value="";
    stopScan.style.display = "none"; // Always hide stop button when closing
    
    // Stop camera if it's running
    if (html5QrCode && html5QrCode.isScanning) {
        html5QrCode.stop().then(() => {
            document.querySelector("#reader").innerHTML = "";
            //stopScan.style.display = "none";
        }).catch(err => console.error(err));
    }
}

//QR code scanning using camera
let html5QrCode;

function ScanQRImage() {

    displayMessage.innerText = "Camera laden...";

    document.querySelector("#reader").style.display = "block";
    iconGroup.style.display = "none";

    stopScan.style.display = "inline-block";

    html5QrCode = new Html5Qrcode("reader");

    Html5Qrcode.getCameras().then(devices => {

        if (devices && devices.length) {

            let cameraId = devices[0].id;

            html5QrCode.start(
                cameraId,
                {
                    fps: 10,
                    qrbox: 250
                },
                (decodedText) => {

                    textarea.value = decodedText;

                    qrTextDetails.style.display = "block";

                    displayMessage.innerText = "QR-code gescand!";
                },
                (errorMessage) => {
                    // ignore scan errors
                }
            );
        }

    }).catch(err => {
        console.error(err);
        displayMessage.innerText = "Camera kon niet worden geopend.";
    });
}
