# prueba_catalogo

instalaciones necesarias 

sudo apt update
sudo apt install apache2 php libapache2-mod-php mysql-server php-mysql unzip -y


sudo systemctl enable apache2 --now
sudo systemctl enable mysql --now

Script para inciar base de datos y conexion se encuentran en 

sql/schema.sql
