
    // Check for Secure Context
    if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
        const resultDiv = document.getElementById('result-message');
        resultDiv.style.display = 'block';
        resultDiv.className = 'alert alert-warning';
        resultDiv.innerHTML = '<b>Warning:</b> Camera access usually requires HTTPS or Localhost. You seem to be connected via HTTP (' + location.protocol + '). If the camera fails, please use HTTPS.';
    }

    async function onScanSuccess(decodedText, decodedResult) {
        // Handle on success condition with the decoded text or result.
        
        // Stop scanning is not strictly necessary with Html5QrcodeScanner as it pauses, 
        // but we want to prevent multiple triggers for the same code.
        html5QrcodeScanner.clear(); 

        try {
            const data = JSON.parse(decodedText);
            if(data.registration_id && data.event_id) {
                await processCheckIn(data);
            } else {
                showResult('error', 'Invalid QR Code Format');
                // Restart scanning after delay
                setTimeout(() => html5QrcodeScanner.render(onScanSuccess), 3000);
            }
        } catch (e) {
            showResult('error', 'Invalid QR Code Data');
             // Restart scanning after delay
             setTimeout(() => html5QrcodeScanner.render(onScanSuccess), 3000);
        }
    }

    const processCheckIn = async (data) => {
        const resultDiv = document.getElementById('result-message');
        resultDiv.style.display = 'block';
        resultDiv.className = 'mt-3 alert alert-info';
        resultDiv.innerHTML = 'Processing...';

        try {
            const response = await fetch('/organizer/check-in', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });
            const res = await response.json();

            if(res.success) {
                showResult('success', `<b>Success!</b> ${res.message} <br> Attendee: ${res.user_name}`);
            } else {
                showResult('error', `<b>Error:</b> ${res.message}`);
            }
        } catch(err) {
            showResult('error', 'Network Error');
        }
        
        // Show restart button
        document.getElementById('reset-scan').style.display = 'inline-block';
    };

    const showResult = (type, message) => {
        const resultDiv = document.getElementById('result-message');
        
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = message;
        resultDiv.className = type === 'success' ? 'mt-3 alert alert-success' : 'mt-3 alert alert-danger';
    };

    document.getElementById('reset-scan').addEventListener('click', () => {
         document.getElementById('result-message').style.display = 'none';
         document.getElementById('reset-scan').style.display = 'none';
         html5QrcodeScanner.render(onScanSuccess);
    });

    // Initialize the Scanner UI
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", 
        { 
            fps: 10, 
            qrbox: {width: 250, height: 250},
            rememberLastUsedCamera: true
        }, 
        /* verbose= */ false
    );
    html5QrcodeScanner.render(onScanSuccess);
