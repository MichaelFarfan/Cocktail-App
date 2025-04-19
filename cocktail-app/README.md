<div class="installation-guide">
  <h1>Guía Completa de Instalación Laravel con MySQL</h1>
  
  <h2>📋 Requisitos Previos</h2>
  <ul>
    <li>PHP ≥ 8.1 con extensiones requeridas (pdo, mbstring, etc.)</li>
    <li>Composer 2.x instalado</li>
    <li>MySQL ≥ 5.7 en ejecución</li>
    <li>Node.js ≥ 16.x + npm</li>
    <li>Git (opcional pero recomendado)</li>
  </ul>

  <h2>🚀 1. Configuración Inicial</h2>
  <pre><code># Clonar repositorio (si aplica)
git clone https://github.com/tu-proyecto.git
cd tu-proyecto

# Instalar dependencias PHP
composer install

# Configurar archivo .env (asegúrate que MySQL esté configurado)
cp .env.example .env
nano .env  # Editar con tus credenciales MySQL

# Generar clave de aplicación
php artisan key:generate</code></pre>

  <h3>Configuración MySQL en .env</h3>
  <pre>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_bd
DB_USERNAME=usuario_mysql
DB_PASSWORD=tu_contraseña</pre>

  <h2>🗄 2. Base de Datos MySQL</h2>
  <pre><code># Crear la base de datos (desde MySQL CLI)
mysql -u root -p
CREATE DATABASE nombre_bd;
GRANT ALL PRIVILEGES ON nombre_bd.* TO 'usuario_mysql'@'localhost';
FLUSH PRIVILEGES;
exit

# Ejecutar migraciones y seeders
php artisan migrate --seed</code></pre>

  <h2>🛠 3. Configuración Adicional</h2>
  <pre><code># Instalar frontend
npm install
npm run dev

# Permisos necesarios
chmod -R 775 storage bootstrap/cache

# Generar enlace de almacenamiento
php artisan storage:link

# Limpiar caché (si es necesario)
php artisan optimize:clear</code></pre>

  <h2>⚙️ 4. Iniciar Servidor</h2>
  <pre><code># Para desarrollo
php artisan serve

# Para producción (configurar Nginx/Apache)
# Ejemplo configuración Nginx para MySQL:
location / {
    try_files $uri $uri/ /index.php?$query_string;
}</code></pre>

  <h2>🔧 Troubleshooting MySQL</h2>
  <h3>Error de conexión a MySQL</h3>
  <pre><code># Verificar servicio MySQL
sudo systemctl status mysql

# Verificar credenciales
mysql -u tu_usuario -p
USE nombre_bd;
SHOW TABLES;</code></pre>

  <h3>Resetear base de datos completa</h3>
  <pre><code>php artisan migrate:fresh --seed</code></pre>

  <h2>💾 Comandos Útiles con MySQL</h2>
  <pre><code># Ver conexiones activas MySQL
php artisan db:show

# Exportar/Importar datos
mysqldump -u usuario -p nombre_bd > backup.sql
mysql -u usuario -p nombre_bd < backup.sql

# Monitorizar consultas MySQL
php artisan db:monitor</code></pre>

  <div class="alert">
    <strong>Nota:</strong> Asegúrate que el servicio MySQL esté en ejecución antes de iniciar la aplicación Laravel.
  </div>
</div>