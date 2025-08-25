document.addEventListener("DOMContentLoaded", () => {
    const openModal = document.getElementById("openModal");
    const modal = document.getElementById("modal");
    const modalBody = document.getElementById("modalBody");
    const productGrid = document.querySelector(".productGrid");

    // Función para cargar productos desde el GET
    const cargarProductos = () => {
        fetch("api/get_products.php") 
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    productGrid.innerHTML = ""; 
                    data.data.forEach(producto => {
                        const productoDiv = document.createElement("div");
                        productoDiv.className = "producto";
                        productoDiv.innerHTML = `
                            <div class="tarjetas">
                            <div class="img-container">
                                <img src="uploads/${producto.imagen}" alt="${producto.nombre}" />
                                <div class="overlay">
                                    <button class = "btn-put" data-id = "${producto.id}">Editar</button>
                                    <button class="btn-eliminar" data-id="${producto.id}">Eliminar</button>
                                </div>
                            </div>
                            <div class = "textosTarjetas"> 
                                <h3>${producto.nombre}</h3>
                                <p>Precio: $${producto.precio}</p>
                            </div>
                            
                            </div>
                            `;
                        productGrid.appendChild(productoDiv);
                    });
                } else {
                    productGrid.innerHTML = `<p>Error: ${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error("Error al cargar productos:", error);
                productGrid.innerHTML = `<p>Error al cargar productos</p>`;
            });
    };

    // Cargar productos al iniciar la página
    cargarProductos();


    //Abrir modal de modificaion
    productGrid.addEventListener("click", (e) => {
        if (e.target.classList.contains("btn-put")) {
            const id = e.target.dataset.id;
            console.log('aquiiiiii', id)

            fetch("assets/modales/dataPUT.html")
            .then(response => response.text())
            .then(data => {
                modalBody.innerHTML = data;
                modal.style.display = "block";

                modalBody.setAttribute("data-id", id);

                const closeModal = document.getElementById("closeModal");
                if (closeModal) {
                    closeModal.addEventListener("click", () => {
                        modal.style.display = "none";
                    });
                }

                const script = document.createElement("script");
                script.src = "assets/js/dataPUT.js";
                script.defer = true;
                modalBody.appendChild(script);
            });

        }

    });

    //CRUD delete

    productGrid.addEventListener("click", (e) => {
        if (e.target.classList.contains("btn-eliminar")) {
            const id = e.target.dataset.id;
            if (confirm("¿Seguro que deseas eliminar este producto?")) {
                fetch("api/delete_products.php", {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ id: id })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert("Producto eliminado correctamente");
                            cargarProductos();
                        } else {
                            alert("Error al eliminar producto: " + data.message);
                        }
                    })
                    .catch(err => console.error("Error:", err));
            }
        }
    });




    //abrir modal de ingreso de data

    openModal.addEventListener("click", () => {
        fetch("assets/modales/ingresoData.html")
            .then(response => response.text())
            .then(data => {
                modalBody.innerHTML = data;
                modal.style.display = "block";

                const closeModal = document.getElementById("closeModal");
                if (closeModal) {
                    closeModal.addEventListener("click", () => {
                        modal.style.display = "none";
                    });
                }

                const script = document.createElement("script");
                script.src = "assets/js/ingresoData.js";
                script.defer = true;
                modalBody.appendChild(script);
            });
    });




    window.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
