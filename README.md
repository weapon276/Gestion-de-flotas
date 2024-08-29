# Gestión de Flotas ANDUG

## Descripción
Este proyecto es una aplicación web para la gestión de flotas de camiones, seguimiento de rutas, control de gastos, y otras funciones relacionadas con la logística y el transporte.

## Actualizaciones del Proyecto

### 2024-08-20
- **Módulo:** Cotizaciones
  - **Descripción:**
    - Se implementó la funcionalidad de actualizar el estado del camión a "Ocupado" al seleccionar un camión en una cotización.
    - Se corrigió un error relacionado con la columna `Tipo_Camiones` en la base de datos, que arrojaba un valor `NULL` no permitido.
    - Se añadieron validaciones para asegurar que `Tipo_Camiones` tenga un valor válido antes de realizar la inserción en la base de datos.
    - Se solucionó un error en la función `obtenerCamionesLibres` al pasar el argumento de conexión a la base de datos.
    - Se resolvió el error de la función `obtenerCamionesLibres()` que no recibía el parámetro necesario en el archivo `cotizacion.php`.
    - Se corrigió la lógica para manejar el array de camiones libres al insertar en la tabla `cotizacion_camion`.
    - Se añadió la opción de notificar a usuarios con tipo "administrador" y "contabilidad" sobre nuevas cotizaciones.
    - Se mejoró la funcionalidad de manejo de rutas y detalles de la cotización utilizando datos en formato JSON.

- **Módulo:** Gestión de Camiones
  - **Descripción:**
    - Se creó la tabla `camion` en la base de datos con campos como `Placas`, `Peso`, `Unidad`, `Status`, y otros detalles específicos del camión.
    - Se añadieron triggers para actualizar automáticamente las fechas `fecha_inicio` y `fecha_final` en la tabla de camiones.

### 2024-08-21
- **Módulo:** Registro de Usuarios
  - **Descripción:**
    - Se corrigió un error en la inserción de nuevos usuarios en la base de datos que causaba un fallo por no reconocer la columna `vCorreo`. Ahora se ha asegurado que todos los campos necesarios se manejen correctamente en el proceso de registro.
    - Se añadió una validación para que las notificaciones solo sean visibles para el tipo de usuario "Recursos Humanos" con `id_TypeUser = 3`. Esto incluye la creación de una columna `ID_TypeUser` en la tabla `mensajes` para gestionar esta funcionalidad.

- **Módulo:** Notificaciones
  - **Descripción:**
    - Se implementó un mecanismo que permite que las notificaciones sobre nuevos registros de usuarios sean vistas únicamente por los usuarios del tipo "Recursos Humanos" (`id_TypeUser = 3`). Esta funcionalidad fue agregada para mejorar la seguridad y relevancia de las notificaciones en el sistema.

- **Módulo:** Base de Datos
  - **Descripción:**
    - Se añadió la columna `ID_TypeUser` en la tabla `mensajes` para relacionar los mensajes con tipos de usuarios específicos. Esto permite que ciertos mensajes sean visibles solo para los usuarios correspondientes.
    - Se revisaron y optimizaron los índices en las tablas `mensajes` y `usuarios` para mejorar la velocidad de consulta y asegurar la integridad referencial.

### 2024-08-22
- **Módulo:** Facturación
  - **Descripción:**
    - Se corrigió un error en la función que genera mensajes para la base de datos, específicamente en la línea de código que accede al nombre del cliente.
    - Se ajustó el manejo de errores y se resolvió el problema de intento de acceso a un índice nulo en el array.
    - Se actualizó el proceso de inserción de facturas para incluir la lógica correcta de descuento y actualización de crédito.
    - Se solucionaron errores en la creación de mensajes para la tabla `mensajes`, asegurando que se manejen correctamente los datos y se prevengan fallos de integridad referencial.
    - Se mejoró el archivo de configuración para manejar correctamente la base de datos y las actualizaciones de datos.

- **Módulo:** Diseño de Factura
  - **Descripción:**
    - Se mejoró el diseño del PDF de factura, incluyendo la incorporación del logo de la empresa y una estructura más profesional para la presentación de la información.

### 2024-08-26
- **Módulo:** Cotizaciones
  - **Descripción:**
    - Se creó el archivo `rutas.php` para consultar la API del INEGI de México y obtener rutas, costos de combustible y distancias entre puntos. Además, se implementó la funcionalidad para almacenar estas rutas en la base de datos.
    - Se corrigió un problema en la función que calculaba el costo total de una ruta, ajustando la fórmula para considerar correctamente todos los parámetros relevantes.
    - Se mejoró el manejo de errores en la interacción con la API del INEGI, asegurando que el sistema responda adecuadamente ante fallos de red o datos incompletos.

- **Módulo:** Diseño de Interface
  - **Descripción:**
    - Se actualizó el diseño del formulario de inicio de sesión, incorporando los colores especificados (#e03c12, #285de2, #ee7755, #f4c0b2, #323232) y añadiendo una imagen de fondo difuminada para mejorar la experiencia del usuario.
    - Se añadieron iconos a los botones de acciones en la tabla (Pago, Prórroga, Cancelar, Descargar PDF) y se configuró para que muestren descripciones al pasar el cursor sobre ellos. Además, todos los botones fueron uniformizados en tamaño utilizando Bootstrap y W3Schools.

- **Módulo:** Base de Datos
  - **Descripción:**
    - Se implementaron vistas y `JOIN` logs para las tablas, permitiendo un mejor rastreo y auditoría de las modificaciones realizadas por los usuarios.
    - Se optimizó el almacenamiento y registro de movimientos en el `log_movimientos`, asegurando que se registren todos los movimientos realizados por cualquier usuario y que se almacene el ID del usuario que realiza bajas de clientes.

- **Módulo:** Facturación
  - **Descripción:**
    - Se mejoró la estructura del PDF de la factura, incorporando el logo de la empresa y refinando el diseño general para un aspecto más profesional y claro.
    - Se implementó la funcionalidad para que el modal de información del cliente liste todas las facturas asociadas, permitiendo la descarga de cada factura de manera sencilla.

### 2024-08-27
- **Módulo:** Registro de Empleados
  - **Descripción:**
    - Se corrigió la función `registrarEmpleado()` para aceptar el número correcto de argumentos y se actualizó el manejo de errores en la inserción de datos de empleados.
    - Se revisó y ajustó el manejo de parámetros en el archivo `registrar_empleado.php` para asegurar que se pasen los argumentos correctos a la función.

### 2024-08-28
- **Módulo:** Registro de Usuarios
  - **Descripción:**
    - Se solucionó el error relacionado con el número de parámetros en la función `registrarUsuario()` y se corrigió la declaración SQL para la inserción de datos de usuario.
    - Se actualizó el archivo `registrar_empleado.php` para asegurar que la función `registrarEmpleado()` se llame con los parámetros correctos.

## Instalación y Configuración
1. Clona el repositorio: `git clone https://github.com/tu-usuario/gestion-de-flotas-andug.git`
2. Configura la base de datos utilizando el archivo SQL proporcionado en `/database/`.
3. Configura el entorno local (recomendado: Laragon) y asegúrate de tener PHP, MySQL y otras dependencias instaladas.

## Contacto
Para cualquier duda o sugerencia, puedes contactar a través del correo [soportetecnico@techpromx.com].

## Licencia
Este proyecto está licenciado bajo los términos de [MIT License](LICENSE).


## Instalación y Configuración
1. Clona el repositorio: `git clone https://github.com/tu-usuario/gestión-de-flotas-andug.git`
2. Configura la base de datos utilizando el archivo SQL proporcionado en `/database/`.
3. Configura el entorno local (recomendado: Laragon) y asegúrate de tener PHP, MySQL y otras dependencias instaladas.

## Contacto
Para cualquier duda o sugerencia, puedes contactar a través del correo [soportetecnico@techpromx.com].

## Licencia
Este proyecto está licenciado bajo los términos de [MIT License](LICENSE).
