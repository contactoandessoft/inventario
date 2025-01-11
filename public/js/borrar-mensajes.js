    setTimeout(function() {
        const successMessage = document.getElementById('mensaje-success');
        const errorMessage = document.getElementById('mensaje-error');

        function fadeOut(element) {
            element.style.transition = "opacity 1s ease-out";
            element.style.opacity = 0; 
            setTimeout(function() {
                element.style.display = 'none'; 
            }, 1000); 
        }

        if (successMessage) {
            fadeOut(successMessage);
        }

        if (errorMessage) {
            fadeOut(errorMessage);
        }
    }, 2000);  
