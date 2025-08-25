(() => {
    const formPUT = document.getElementById("putProducto");
    const messageDivPUT = document.getElementById("formMessagePUT");
    const id = modalBody.getAttribute("data-id");

    console.log("El ID recibido es:", id);

    if (formPUT) {
        formPUT.addEventListener("submit", (e) => {
            e.preventDefault();
            console.log("prueba"); 
            
            messageDivPUT.textContent = ""; 
            const formData = new FormData(formPUT);
            formData.append("id", id);

            fetch("api/update_products.php", {
                method: "POST", 
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        formPUT.reset(); 
                        window.location.reload();

                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(err => {
                    alert("Error al conectar con el servidor");
                    console.error(err);
                });

        });
    }
})();

