const API_URL = 'http://localhost:8000/api.php';
const form = document.getElementById('product-form');
const productList = document.getElementById('product-list');

// Función para obtener y mostrar todos los productos
async function fetchProducts() {
    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        const products = await response.json();
        
        productList.innerHTML = ''; // Limpiar lista
        products.forEach(product => {
            const li = document.createElement('li');
            li.innerHTML = `
                <span>${product.name} - $${product.price}</span>
                <div>
                    <button class="edit-btn" onclick="editProduct(${product.id}, '${product.name}', ${product.price})">Editar</button>
                    <button class="delete-btn" onclick="deleteProduct(${product.id})">Eliminar</button>
                </div>
            `;
            productList.appendChild(li);
        });
    } catch (error) {
        console.error("Error fetching products:", error);
        productList.innerHTML = '<li>Error al cargar los productos. Revisa la consola.</li>';
    }
}

// Manejar envío del formulario (Crear o Actualizar)
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = document.getElementById('product-id').value;
    const name = document.getElementById('name').value;
    const price = document.getElementById('price').value;

    const product = { name, price };
    
    let url = API_URL;
    let method = 'POST';

    if (id) {
        url += `?id=${id}`;
        method = 'PUT';
    }

    await fetch(url, {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(product)
    });

    form.reset();
    document.getElementById('product-id').value = '';
    fetchProducts();
});

// Función para poblar el formulario para editar
function editProduct(id, name, price) {
    document.getElementById('product-id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('price').value = price;
    window.scrollTo(0, 0); // Sube al inicio de la página para ver el formulario
}

// Función para eliminar un producto
async function deleteProduct(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
        await fetch(`${API_URL}?id=${id}`, {
            method: 'DELETE'
        });
        fetchProducts();
    }
}

// Cargar productos al iniciar la página
fetchProducts();