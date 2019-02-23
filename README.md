# Jornada de almuerzo ¡gratis!

Un reconocido restaurante ha decidido tener una jornada de donación de comida a los residentes de la región con la única condición de que el plato que obtendrán los comensales será aleatorio. El administrador del restaurante requiere con urgencia un sistema que permita pedir platos a la cocina.

# Despliegue 
Clone el repositorio
```
git clone https://ariasantonio@bitbucket.org/ariasantonio/almuerzo.git alegra
```
Ingrese al directorio creado
```
cd  alegra
```
Copie y edite el archivo de configuraciòn acorde a sus necesidades
```
cp  backend/.env.example backend/.env
```

Construya las imagenes
```
docker-compose build
```
Inicie los contenedores
```
docker-compose up -d
```
# Base Datos
Para ejecutar las migraciones y los seed de los ingredientes y recetas use lo siguiente (asumiendo que el contenedor de php se llama alegra_php_1). Esto borra y crea las tablas de la base datos
```
docker exec alegra_php_1 php artisan migrate:fresh
```
```
docker exec alegra_php_1 php artisan db:seed
```
# Incidencias
En caso de algunas incidencias puede probar lo siguiente:
```
docker exec alegra_php_1 composer update
```
```
docker exec alegra_php_1 chmod 777 -R storage
```

# NOTAS
- Si edita datos referentes a la base datos en el archivo .env tenga esa consideracion en docker-compose.yml
- Asegurese que la ruta configurada en el docker-compose.yml para la persistencia de la base datos este disponible
