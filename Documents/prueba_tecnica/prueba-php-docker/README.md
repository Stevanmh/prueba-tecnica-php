# Prueba Técnica PHP - Gestor de Productos

Aplicación web para gestionar productos (CRUD) construida con PHP nativo, JavaScript y Docker.

## Requisitos

* Docker
* Docker Compose

## Instalación y Ejecución

1.  **Clona el repositorio.**

2.  **Levanta los contenedores:**
    Desde la raíz del proyecto, ejecuta el siguiente comando:
    ```sh
    docker-compose up -d
    ```

3.  **Crea la tabla en la base de datos:**
    Ejecuta el siguiente comando para acceder a MySQL:
    ```sh
    docker exec -it mysql_db mysql -u root -prootpassword
    ```
    Una vez dentro, pega el siguiente código SQL:
    ```sql
    USE products_db;
    CREATE TABLE products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        price DECIMAL(10, 2) NOT NULL
    );
    EXIT;
    ```

4.  **Abre la aplicación:**
    Navega a la carpeta `frontend` y abre el archivo `index.html` en tu navegador.