<?php

/*
 * Yii es un framework PHP basado en componentes de alta performance para 
 * desarrollar aplicaciones Web de gran escala. El mismo permite la máxima 
 * reutilización en la programación web y puede acelerar el proceso de desarrollo. 
 * El nombre Yii (pronunciado /i:/) 
 * es por fácil (en inglés: easy), 
 * eficiente (en inglés: efficient) 
 * y extensible (en inglés: extensible).
 * 
 * 1. Requerimientos 
 * Para correr una aplicación Web Yii, 
 * usted necesita tener un servidor Web con soporte PHP 5.1.0 o superior.
 * Para desarrolladores que deseen utilizar Yii, 
 * el entendimiento de Programación Orientada a Objetos (OOP) 
 * será de grán ayuda ya que Yii es un framework totalmente basado en OOP.
 * 2. Para qué es bueno utilizar Yii? 
 * Yii es un framework generico de programación Web que puede ser utilzado 
 * para todo tipo de aplicaciones Web. Gracias a que es liviano de correr 
 * y está equipado con soluciones de cacheo sofisticadas, 
 * es adecuado para desarrollar aplicaciones de grán tráfico como portales, 
 * foros, sistemas de administración de contenidos (CMS), 
 * Sistemas de comercio electrónico (e-commerce), etc.
 * 3. Cómo se compara Yii con otros frameworks? 
 * Como la mayoría de los frameworks PHP, Yii es un framework MVC 
 * (modelo-vista-controlador).
 * Yii Yii sobresale frente a frameworks PHP en su eficiencia, 
 * su gran cantidad de características y su clara documentación. 
 * Yii ha sido diseñado cuidadosamente desde el principio para el desarrollo 
 * de aplicaciones de Web. No es ni un subproducto de un proyecto ni 
 * un conglomerado de trabajo de terceros. Es el resultado de la 
 * basta experiencia de los autores en desarrollo de aplicaciones Web 
 * y de la investigación y la reflexión de los más populares los frameworks 
 * de programación Web y aplicaciones.
 */

/*
 * Para instalar Yii solo debe seguir los siguientes 2 pasos:
 * Descargar el framework Yii de yiiframework.com.
 * Descomprimir el archivo a un directorio accesible por el servicio Web.
 * Tip: Yii no necesita ser instalado en un directorio accesible via web. 
 * La aplicacion Yii tiene un script de entrada la cual usualmente es el único 
 * archivo que debe ser expuesto a los usuarios Web. Otros scripts PHP , 
 * incluidos los de Yii, pueden (y se recomienda) estar protegidos del 
 * acceso Web ya que esos pueden intentar ser explotado para Hackeo.
 * 1. Requerimiento 
 * Luego de instalar Yii, ustede puede verificar si su server 
 * satisface todos los requerimientos para utilizar Yii. 
 * Para hacerlo debe hacer accesible el script de verificación de 
 * requerimientos para utilizar Yii. Usted puede acceder al script de 
 * verificación de requerimientos en la siguiente URL en un explorador Web:
 * http://hostname/path/to/yii/requirements/index.php
 * El requerimiento mínimo de Yii es que su server soporte PHP 5.1.0 o superior. 
 * Yii ha sido testeado con Apache HTTP server en los sistemas operativos 
 * Windows y Linux. 
 * También puede funcionar en otras plataformas que soporten PHP 5.
 */

/*
 * Creando primera aplicación Yii
 * Conectandose a Base de Datos
 * Implementando operaciones CRUD
 * Para ingresar al mundo de Yii, en esta scción le indicamos como crear 
 * nuestra primera aplicación Yii. Usaremos la poderosa herramienta yiic 
 * que puede ser utilizadapara automatizar la creación del códgo de ciertas tareas. 
 * Por conveniencia asumimos que YiiRoot es el directorio donde Yii 
 * se encuentra instalado y WebRoot es la ruta del documento de tu Web Server.
 * Ejecute yiic en la linea de comandos de la siguiente manera:
 * % YiiRoot/framework/yiic webapp WebRoot/testdrive
 * Nota: Cuando ejecuta yiic en Mac OS, Linux o Unix, usted deberá modificar 
 * los permisos del archivo yiic para poder ejecutarlo. Alternativamente 
 * puede correr la herramienta de la siguiente manera,
 * % cd WebRoot/testdrive
 * % php YiiRoot/framework/yiic.php webapp WebRoot/testdrive
 * Esto creará una aplicación Yii esqueleto en el directorio WebRoot/testdrive. 
 * Esta aplicación contiene la estructura de directorios requerida por la 
 * mayoría de las aplicaciones Yii.
 * Sin escribir ni una sola linea de código, nosotros podemos probar nuestra 
 * primera aplicación Yii ingresando a la siguiente URL en un explorador Web:
 * http://hostname/testdrive/index.php
 * Como vemos, la aplicación contiene tres páginas: homepage 
 * (la página inicial), contact (página de contacto) 
 * y login (página de login de usuario). 
 * La página inicial muestra información de la aplicación y 
 * del estado del usuario logueado, la página de contacto contiene un 
 * formulario para rellenar y enviar sus consultas y la página de login de 
 * usuario permite a los mismos autenticarse para acceder a contenidos que 
 * necesitan privilegios de acceso. Mire las siguientes pantallas 
 * para más detalles.
 */

/*
 * El siguiente diagrama muestra la estructura de directorios de nuestra aplicación. 
 * Por favor mire Convenciones para una explicación detallada acerca de esta estructura.

testdrive/
   index.php                 archivo de entrada de la aplicación Web
   assets/                   contiene archivos de recursos públicos
   css/                      contiene archivos CSS
   images/                   contiene archivos de imágenes
   themes/                   contiene temas de la aplicación
   protected/                contiene los archivos protegidos de la aplicación
      yiic                   script de linea de comandos yiic
      yiic.bat               script de linea de comandos yiic para Windows
      commands/              contiene comandos 'yiic' personalizados
         shell/              contiene comandos 'yiic shell' personalizados
      components/            contiene componentes reusables
         MainMenu.php        clase de widget 'MainMenu'
         Identity.php        clase 'Identity' utilizada para autenticación
         views/              contiene los archivos de vistas para los widgets
            mainMenu.php     el archivo vista para el widget 'MainMenu'
      config/                contiene archivos de configuración
         console.php         configuración aplicación consola
         main.php            configuración de la aplicación Web
      controllers/           contiene los archivos de clase de controladores
         SiteController.php  la clase controlador predeterminada
      extensions/            contiene extensiones de terceros
      messages/              contiene mensajes traducidos
      models/                contiene archivos clase de modeloscontaining model class files
         LoginForm.php       el formulario modelo para la acción 'login'
         ContactForm.php     el formulario modelo para la acción 'contact'
      runtime/               contiene archivos temporarios generados
      views/                 contiene archivos de vista de controladores y de diseño
         layouts/            contiene archivos de diseño
            main.php         el diseño default para todas las vistas
         site/               contiene archivos vista para el controlador 'site'
            contact.php      contiene la vista para la acción 'contact'
            index.php        contiene la vista para la acción 'index'
            login.php        contiene la vista para la acción 'login'
         system/             contiene archivos de vista del sistema
 */

/*
 * 2. Implementando operaciones CRUD 
 * Ahora comienza la parte divertida. 
 * Queremos implementar las operaciones CRUD para la tabla User que 
 * acabamos de crear. Esto es una práctica común en aplicaciónes prácticas.
 * En vez de estar lidiando con escribir el codigo actual podemos utilizar 
 * la poderosa herramienta yiic nuevamente para automaticar 
 * la generación de codigo por nosotros. Este proceso es tambien conocido 
 * como scaffolding. 
 * Abre una ventana de linea de comandos y executa los comando listados a continuación:

% cd WebRoot/testdrive
% protected/yiic shell
Yii Interactive Tool v1.0
Please type 'help' for help. Type 'exit' to quit.
>> model User
   generate User.php

The 'User' class has been successfully created in the following file:
    D:\wwwroot\testdrive\protected\models\User.php

If you have a 'db' database connection, you can test it now with:
    $model=User::model()->find();
    print_r($model);

>> crud User
   generate UserController.php
   generate create.php
      mkdir D:/wwwroot/testdrive/protected/views/user
   generate update.php
   generate list.php
   generate show.php

Crud 'user' has been successfully created. You may access it via:
http://hostname/path/to/index.php?r=user
En el código anterior utilizamos el comando yiic shell para interactuar con 
 * la aplicación esqueleto. Hemos ejecutado dos comandos: model User y crud User. 
 * El primero genera la clase Modelo para la tabla User mientras que 
 * el segundo lee el modelo User y genera el código necesario 
 * para las operaciones CRUD.
 */

/*
 * Modelo-Vista-Controlador (Model-View-Controller MVC)
 * Un flujo de tareas típico
 * Yii implementa el diseño de patron modelo-vista controlador 
 * (model-view-controller MVC) 
 * el cual es adoptado ampliamente en la programación Web. 
 * MVC tiene por objeto separar la lógica del negocio de las 
 * consideraciones de la interfaz de usuario para que los 
 * desarrolladores puedan modificar cada parte más fácilmente 
 * sin afectar a la otra. En MVC el modelo representa la información 
 * (los datos) y las reglas del negocio; la vista contiene elementos 
 * de la interfaz de usuario como textos, formularios de entrada;
 *  y el controlador administra la comunicación entre la vista y el modelo.
 * 
 * Más alla del MVC, Yii tambien introduce un front-controller llamado 
 * aplicación el cual representa el contexto de ejecución del procesamiento 
 * del pedido. La aplicación resuelve el pedido del usuario y la dispara al
 *  controlador apropiado para tratamiento futuro.
 */

/*
 * Un usuario realiza un pedido con la siguiente URL 
 * http://www.example.com/index.php?r=post/show&id=1 y el servidor Web se 
 * encarga de la solicitud mediante la ejecución del script de arranque 
 * en index.php.
El script de entrada crea una instancia de applicación y la ejecuta.
La aplicación obtiene la información detallada del pedido del usuario del 
 * componente de aplicación request.
El controlador determina le controlador y la acción pedido con ayuda del 
 * componente de aplicación llamado urlManager. Para este ejemplo el 
 * controlador es post que refiere a la clase PostController y la acción 
 * es show que su significado es determinado por el controlador.
La aplicación crea una instancia del controlador pedido para resolver el 
 * pedido del usuario. El controlador determina que la acción show 
 * refiere al nombre de método actionShow en la clase controlador. 
 * Entonces crea y ejecuta los filtros asociados con esta acción 
 * (ejemplo: control de acceso, benchmarking). 
 * La acción es ejecutado si los filtros lo permiten.
La acción lee el modelo Post cuyo ID es 1 de la base de datos.
La acción realiza la vista llamada show con el modelo Post
La vista lee y muestra los atributos del modelo Post.
La vista ejecuta algunos widgets.
El resultado realizado es embebido en un esquema (layout).
La acción completa la vista realizada y se la muestra al usuario.
 */

/*
 * 4. Componentes del nucleo de Application 
 * Yii predefine un juego de compoenentes de aplicación que proveen caracteristicas
 *  comunes en toda la aplicación Web. Por ejemplo, el componente 
 * request es usado para resolver pedidos de usuarios y proveer de 
 * información como URL, cookies. Configurando las propiedades de 
 * estos componentes podemos cambiar el comportamiento de casi todos 
 * los aspectos de Yii.

Abajo se encuentra la lista de componentes predeclarados por CWebApplication.

assetManager: CAssetManager - administra la publicación de archivos privados.
authManager: CAuthManager - Administra el control de acceso basado en roles (role-based access control - RBAC).
cache: CCache - provee funcionalidad de cacheo de datos. Nota: se debe especificar la clase actual (ejemplo: CMemCache, CDbCache) o Null será retornado cuando se acceda a este componente.
clientScript: CClientScript - Administra los scripts de cliente (javascripts y CSS).
coreMessages: CPhpMessageSource - provee de los mensajes de nucleo traducidos utilizados por Yii framework.
db: CDbConnection - provee la conexión a la base de datos. Nota: debe configurar la propiedad connectionString para poder utilizar este componente.
errorHandler: CErrorHandler - maneja los errores y excepciones PHP no advertidas.
messages: CPhpMessageSource - Provee mensajes traducidos utilizados por la aplicación Yii.
request: CHttpRequest - Provee información relacionada con el request.
securityManager: CSecurityManager - provee servicios relacionados con seguridad como son hashing y encriptación.
session: CHttpSession - provee funcionalidades relacionadas con la sesión.
statePersister: CStatePersister - provee métodos globles de persistencia de estado.
urlManager: CUrlManager - provee funcionalidad para parseo de URL y creación.
user: CWebUser - representa la información de identidad del usuario actual.
themeManager: CThemeManager - maneja temas (themes).
5. Ciclos de vida de la Aplicación 
Cuando se maneja un un pedido de usuario, la aplicación realizará el siguiente ciclo de vida:

Configurará el autocargado de clases y el manejador de errores;
Registrará los componentes del nucleo de la aplicación;
Cargará la configuración de la aplicación;
Inicializará la aplicación mediante CApplication::init()
Carga de compoenentes de aplicación static;
Ejecuta el evento onBeginRequest;
Procesa el pedido de usuario:;
Resuelve el pedido de usuario;
Crea el controlador
Ejecuta el controlador;
7.Ejecuta el evento onEndRequest;
 */

/*
 * Controlador (Controller)

Ruta (Route)
Instanciación de Controlador
Accion (Action)
Filtros
Un controlador es una instancia de CController o una de las clases que lo 
 * heredan. Es creado por la aplicación cuando un usuario realiza un pedido 
 * para ese controlador. Cuando un controlador se ejecuta se realizar el 
 * pedido de la acción que utiliza los modelos necesarios y muestra la 
 * información a travez de la vista apropiada. Una acción, en su forma 
 * más simple, es un m;etodo de la clase controlador 
 * cuyo nombre comienza con action.

Un controlador tiene un a acción predeterminada. Cuando el usuario 
 * no especifica que acción se debe ejecutar, esta será la que se ejecute. 
 * Por predeterminado la acción default tiene el nombre de index. 
 * Puede ser personalizada modificando la configuración 
 * CController::defaultAction.
 */

/*
 * 2. Instanciación de Controlador 
 * Una instancia de controlador es creada cuando CWebApplication maneja 
 * un pedido de usuario. Dado el ID del controlador, 
 * la aplicación utilizará las siguientes reglas para determinar cual 
 * es la clase del controlador y cual la ruta al archivo de clase.

 * Si CWebApplication::catchAllRequest se encuentra especificado,
 *  el controlador será creado basado en esta propiedad y se ignorará 
 * el ID de controlador especificado por el usuario. Esto es usado 
 * mayoritariamente para dejar la aplicación en un modo de mantenimiento 
 * y muestre una página con información estática.
Si el ID se encuentra en CWebApplication::controllerMap, la configuración 
 * de controlador correspondiente se utilizará para crear la instancia 
 * del controlador.
Si el ID se encuentra en el formato 'path/to/xyz', la clase de 
 * controlador assumida será XyzCOntroller y el archivo de clase 
 * correspondiente será protected/controllers/path/to/XyzController.php. 
 * Por ejemplo si el ID del controlador es admin/user será resuelto por 
 * el controlador UserController y el archivo de 
 * clase protected/controllers/admin/UserController.php. 
 * En caso de que el archivo de clase no exista, 
 * un error 404 CHttpException será lanzado.
 * En el caso que se utilizen modules (disponibles desde la versión 1.0.3), 
 * El proceso descripto anteriormente es ligeramente diferente. 
 * En particular, la aplicación verificará si el ID refiere a un controlador 
 * dentro de un módulo y si esto es así, el módulo será instanciado y 
 * luego se instanciará el controlador.
 * 
 * 3. Accion (Action) 
 * Como lo mencionamos anteriormente una acción puede ser definida 
 * mediante su nombre y comenzando con la palabra action. 
 * Una forma más avanzada de realizar esto es definir una clase acción y 
 * pedirle al controlador que la instancie cuando es requerida. 
 * Esto permite que las acciones sean reusadas y genera más reusabilidad.
 */

/**
 * This is the model class for table "contenedor".
 *
 * The followings are the available columns in table 'contenedor':
 * @property string $id
 * @property string $deposito_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $ubicacion
 * @property integer $estado
 */
class Contenedor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contenedor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('nombre, descripcion, ubicacion, estado, deposito_id', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('deposito_id', 'length', 'max'=>10),
			array('nombre', 'length', 'max'=>100),
			array('descripcion', 'length', 'max'=>100),
			array('ubicacion', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, deposito_id, nombre, descripcion, ubicacion, estado', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'deposito' => array(self::BELONGS_TO, 'Deposito', 'deposito_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'deposito_id' => 'Depósito',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripción',
			'ubicacion' => 'Ubicación',
			'estado' => 'Estado',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('deposito_id',$this->deposito_id,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('ubicacion',$this->ubicacion,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contenedor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getNombreEstado($estado = '')
        {
            $nombre_estado = 'Desconocido';
            switch($estado)
            {
                case 1:
                    $nombre_estado = 'Activo';
                    break;
                case 0:
                    $nombre_estado = 'Inactivo';
                    break;
            }
            return $nombre_estado;
        }
}
