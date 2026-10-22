# Khella — Tienda Deportiva

Tienda online de ropa deportiva hecha en **PHP 8 + MySQL/MariaDB**, sin frameworks ni Composer.
Frontend en HTML + Bootstrap 5 + JavaScript vanilla; backend como API JSON con el patrón
controlador → modelo.

---

## Requisitos

| Componente | Versión |
|---|---|
| PHP | 8.0 o superior — extensiones `mysqli` (con `mysqlnd`) y `session` |
| Base de datos | MySQL 5.7+ o MariaDB 10.3+ |
| Servidor web | Apache o Nginx |

> El código usa `mysqli` con `get_result()`, que necesita **mysqlnd** (incluido por defecto desde PHP 7.4).

---

## ⚠️ Importante: nombre de la carpeta y DocumentRoot

El frontend tiene rutas **absolutas fijas** tipo `/ecommerce-tienda-deportiva/frontend/...` en:

- `frontend/components/navbar.php`
- los scripts JS (`index-script.js`, `catalogo-script.js`, `categoria-script.js`, `busqueda-script.js`, `favoritos-script.js`)
- `backend/config/directions.php` (`DIR_ROOT`)
- la URL de las imágenes subidas (`backend/controllers/ProductController.php`)

Por eso hay dos reglas que **no se pueden saltarse**:

1. La carpeta del proyecto debe llamarse **exactamente `ecommerce-tienda-deportiva`**.
2. El **DocumentRoot del servidor debe ser la carpeta padre** (la que contiene al proyecto),
   no el proyecto en sí.

Si no se cumple, los enlaces, las imágenes y el login responden `404`.

```
/var/www/html/                      <-- DocumentRoot
└── ecommerce-tienda-deportiva/     <-- el proyecto (no renombrar)
    ├── frontend/
    └── backend/
```

**URL de la aplicación:** `http://localhost/ecommerce-tienda-deportiva/frontend/index.php`

---

## Estructura

```
ecommerce-tienda-deportiva/
├── frontend/                  # Vistas y assets
│   ├── index.php              # Home
│   ├── pages/                 # catálogo, producto, categorías, carrito,
│   │                          # favoritos, login, register y dashboards
│   ├── components/            # navbar.php, footer.php
│   └── assets/                # css / js / img
├── backend/                   # API JSON
│   ├── index.php              # Router (switch sobre ?action=)
│   ├── controllers/           # Auth, Product, Favorito, Cart
│   ├── models/                # User, Product, Favorito
│   ├── config/                # main-config.php (credenciales)
│   │                          # directions.php  (DIR_ROOT)
│   └── uploads/               # imágenes de productos (requiere escritura)
├── database.sql               # esquema + datos iniciales
└── README.md
```

---

## Base de datos

La app usa la base `users_db` con tres tablas: `productos`, `users` y `favoritos`.
Todo está en `database.sql`, así que solo hay que importarlo.

**Desde la terminal** (Linux/Mac):

```bash
mysql -u root -p < database.sql
```

**Desde phpMyAdmin** (Windows/XAMPP):

1. Abre `http://localhost/phpmyadmin`
2. Pestaña **Importar** → **Seleccionar archivo** → elige `database.sql` → **Continuar**

> El script crea la base `users_db` y sus tablas. **Borra las tablas si ya existían**,
> está pensado para una instalación desde cero.

---

## Configuración de la conexión

Los datos de acceso están en `backend/config/main-config.php`:

```php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db_name = "users_db";
```

- En **XAMPP** los valores por defecto ya coinciden (`root` sin contraseña), no hay que tocar nada.
- En **Linux** conviene crear un usuario propio (ver más abajo) y editar estas cuatro líneas.

---

## Instalación en Windows (XAMPP)

1. **Copia la carpeta** `ecommerce-tienda-deportiva` dentro de `C:\xampp\htdocs\`.
   El nombre debe quedar tal cual: `C:\xampp\htdocs\ecommerce-tienda-deportiva`
2. Abre **XAMPP Control Panel** y dale a **Start** en **Apache** y en **MySQL**.
3. Importa `database.sql` desde `http://localhost/phpmyadmin` (ver *Base de datos*).
4. Abre `http://localhost/ecommerce-tienda-deportiva/frontend/index.php`

---

## Instalación en Linux (LAMP)

### 1. Instalar los paquetes

```bash
sudo apt update
sudo apt install -y apache2 libapache2-mod-php php-mysql mariadb-server
sudo systemctl enable --now apache2
sudo systemctl enable --now mariadb
```

### 2. Crear la base de datos y un usuario

```bash
sudo mariadb -u root -p
```

```sql
CREATE DATABASE users_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'khella'@'localhost' IDENTIFIED BY 'khella';
GRANT ALL PRIVILEGES ON users_db.* TO 'khella'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

> No uses `root` desde PHP: en Ubuntu/MariaDB la cuenta `root` autentica con `unix_socket`
> y Apache (que corre como `www-data`) no puede conectarse con ella.

### 3. Importar el esquema y los datos

```bash
cd /ruta/al/proyecto/ecommerce-tienda-deportiva
sudo mariadb -u root -p < database.sql
```

### 4. Publicar el código y ajustar permisos

```bash
sudo cp -r ecommerce-tienda-deportiva /var/www/html/
sudo chown -R www-data:www-data /var/www/html/ecommerce-tienda-deportiva/backend/uploads
sudo chmod -R 755 /var/www/html/ecommerce-tienda-deportiva
```

`backend/uploads/` necesita permiso de escritura para poder guardar las imágenes de los productos.

### 5. Permitir subidas de imágenes

En `php.ini` de Apache (`/etc/php/8.X/apache2/php.ini`):

```ini
upload_max_filesize = 8M
post_max_size = 12M
```

Y reinicia Apache:

```bash
sudo systemctl restart apache2
```

### 6. Abrir la tienda

`http://localhost/ecommerce-tienda-deportiva/frontend/index.php`

### Alternativa: virtual host con el proyecto en tu carpeta personal

Si prefieres no copiar nada a `/var/www/html`, crea `/etc/apache2/sites-available/khella.conf`:

```apache
<VirtualHost *:80>
    ServerName khella.local
    DocumentRoot /home/TU_USUARIO/ruta/al/proyecto
    <Directory /home/TU_USUARIO/ruta/al/proyecto>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

```bash
sudo a2ensite khella
sudo systemctl restart apache2
echo "127.0.0.1 khella.local" | sudo tee -a /etc/hosts
```

Recuerda: el `DocumentRoot` apunta a la carpeta **padre** de `ecommerce-tienda-deportiva`.

---

## Primer arranque

1. Entra en `http://localhost/ecommerce-tienda-deportiva/frontend/index.php`
2. Inicia sesión en `http://localhost/ecommerce-tienda-deportiva/frontend/pages/login.php`

   | usuario | contraseña |
   |---|---|
   | `admin@khella.com` | `admin123` |

   > Cámbiala desde el panel de usuario en cuanto entres. También puedes crear el admin
   > registrándote en `pages/register.php` y eligiendo el rol **Administrador**.

3. El usuario `admin` entra al **panel de administración**
   (`pages/admin-dashboard.php`), donde puede crear, editar y eliminar productos con imagen.

---

## Rutas principales

| Ruta | Descripción |
|---|---|
| `/frontend/index.php` | Home |
| `/frontend/pages/catalogo.php` | Catálogo con paginación |
| `/frontend/pages/producto.php?id=N` | Detalle de un producto |
| `/frontend/pages/hombre.php` | Categoría hombre |
| `/frontend/pages/mujer.php` | Categoría mujer |
| `/frontend/pages/carrito.php` | Carrito (guardado en sesión) |
| `/frontend/pages/favoritos.php` | Favoritos (requiere sesión) |
| `/frontend/pages/login.php` | Iniciar sesión |
| `/frontend/pages/register.php` | Registrarse |
| `/frontend/pages/user-dashboard.php` | Panel de usuario |
| `/frontend/pages/admin-dashboard.php` | Panel de administración |

### API

Todas las respuestas son JSON. El backend es un único punto de entrada:

```
/backend/index.php?action=<acción>
```

| Acción | Método | Descripción |
|---|---|---|
| `login` | POST | Inicia sesión (JSON: `email`, `password`) |
| `register` | POST | Crea un usuario (JSON: `nombre`, `email`, `password`, `rol`) |
| `logout` | GET | Cierra la sesión |
| `getIndexProducts` | GET | Productos para el home |
| `getProducts` | GET | Catálogo paginado (`offset`, `limit=5`) |
| `getProductById` | GET | Un producto (`id`) |
| `getCategory` | GET | Productos por categoría (`category`) |
| `displaySearch` | GET | Búsqueda (`busqueda`) |
| `getCarousel` | GET | Últimos 5 productos para el carrusel |
| `addToCart` | GET | Agrega al carrito (`producto_id`) |
| `removeFromCart` | GET | Quita del carrito (`producto_id`) |
| `getCart` | GET | Contenido del carrito y total |
| `toggleFavorito` | GET | Marca/desmarca favorito (`producto_id`) |
| `getFavoritos` | GET | Favoritos del usuario en sesión |
| `checkFavs` | GET | Verifica si un producto es favorito (`prodId`) |
| `updateProfile` | POST | Actualiza nombre y email del usuario |
| `getAdminProducts` | GET | Listado completo para el panel admin |
| `createProduct` | POST | Crea un producto (multipart con `imagen`) |
| `updateProduct` | POST | Actualiza un producto |
| `deleteProduct` | GET | Elimina un producto (`idDelete`) |

---

## Problemas comunes

| Síntoma | Causa y solución |
|---|---|
| `error de conexion: ...` | MySQL está apagado, la base no existe, o las credenciales de `backend/config/main-config.php` no coinciden. |
| La página abre pero todo da `404` | La carpeta no se llama `ecommerce-tienda-deportiva` o el DocumentRoot no es la carpeta padre. |
| Las imágenes de los productos no cargan | Permisos de escritura en `backend/uploads/` y `upload_max_filesize` / `post_max_size` en `php.ini`. |
| "Debes iniciar sesión" apenas se inicia sesión | El `session.save_path` no es escribible, o se están borrando las cookies al cambiar de `localhost` a `127.0.0.1`. Usa siempre la misma URL. |
| El login responde `404` en `directions.php` | Rutas absolutas: revisa que el proyecto esté en `/ecommerce-tienda-deportiva` dentro del DocumentRoot. |

---

## Notas del repositorio

- `backend/uploads/` está en `.gitignore` (solo se versiona `.gitkeep`), por eso las imágenes
  que subas no se subirán a Git.
- `backend/config/database.php` también está en `.gitignore`, reservado por si prefieres
  mover ahí las credenciales y no versionarlas. Por ahora la app las lee de `main-config.php`.
- Bootstrap 5 y Font Awesome se cargan desde CDN, así que hace falta conexión a internet
  para que se vean bien los estilos.
