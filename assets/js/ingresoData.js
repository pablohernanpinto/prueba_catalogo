(() => {
    const form = document.getElementById("addProductForm");
    const messageDiv = document.getElementById("formMessage");

    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();

            messageDiv.textContent = ""; // limpiar mensaje previo
            const formData = new FormData(form);

            fetch("api/add_products.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        form.reset();
                        window.location.reload();
                    } else {
                        alert("Error: " + data.message); // mensaje de error
                    }
                })
                .catch(err => {
                    alert("Error al conectar con el servidor");
                    console.error(err);
                });

        });

    }
})();
