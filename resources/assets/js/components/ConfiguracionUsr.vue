<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Configuración Cuenta
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Usuario</th>
                                    <th>Documento</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="usuario in arrayUsuario" :key="usuario.Usuario">
                                    <td>
                                        <button type="button"  @click="AbrirModal('usuario','actualizar',usuario)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                    </td>
                                    <td v-text="usuario.Nombres"></td>
                                    <td v-text="usuario.Apellidos"></td>
                                    <td v-text="usuario.Usuario"></td>
                                    <td v-text="usuario.IdTercero"></td>
                                    <td v-text="usuario.IdDireccion"></td>
                                    <td v-text="usuario.ExtensionTel"></td>
                                    <td v-text="usuario.Email"></td>
                                    <td v-text="usuario.Tipo"></td>
                                    <td>
                                        <div v-if="usuario.Inactivo ==1">
                                            <span class="badge badge-danger" >Inactivo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-success" >Activo</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="CerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Usuario:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Nombre de usuario" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Tipo:</label>
                                        <div class="col-md-9">
                                        <select class="form-control" v-model="tipo" disabled>
                                            <option value="0" >0</option>
                                            <option value="1" >1</option>
                                            <option value="2" >2</option>
                                            <option value="3" >3</option>
                                        </select>   
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Contraseña :</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="password" class="form-control" placeholder="Contraseña">
                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Contraseña:</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Contraseña">
                                        
                                    </div>
                                </div>

                                

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombres :</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombres" class="form-control" placeholder="Nombres">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellidos :</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellidos" class="form-control" placeholder="Apellidos">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Identificación :</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="idtercero" class="form-control" placeholder="Identificacion" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Email :</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cargo :</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="cargo" class="form-control" placeholder="Cargo">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="CerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion == 1" class="btn btn-primary" @click="RegistrarUsuario()">Registrar</button>
                            <button type="button" v-if="tipoAccion == 2" class="btn btn-primary" @click="ActualizarUsuario()">Actualizar</button>
                            
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
</main>
 <!-- /Fin del contenido principal -->
</template>

<script>
    export default {
        data() {
            return {
                usuario:'',
                tipo:'',
                password:'',
                nombres:'',
                apellidos:'',
                idtercero:'',
                cargo:'',
                email:'',

                id:0,
                arrayUsuario:[],
                arrayRol:[],//Con este array vamos a listar los datos del componente
                arrayPersona:[],//Con este array vamos a listar los datos del componente
                modal:0,//Cuando este en 1 se abre el modal
                tituloModal :'',//Pone el texto en el modal
                tipoAccion : 0,//1 es registrar , 2 es actualizar
                errorRol:0,//Valida si al crear una roles los formularios le falta un dato
                errorDescRol:'',//Validamos el campo categoria    
                errorNmCategoria:'',//Validamos el campo nombre categoria
                pagination :{//Esta propiedad la envia laravel con el metodo paginate para utilizarla en la paginacion con vue
                    'total' :0,
                    'current_page' :0,
                    'per_page' :0,
                    'last_page' :0,
                    'from' :0,
                    'to':0,
                },
                offset : 4,//Esta variable hace referecia al paginate(3) del controlador
                criterio : 'Nombres', //Esta variable se inicializa con nombre por que es el primer criterio del combo
                buscar :''//Esta es la cadena de busqueda
            }
        },

        computed: {
            isActived : function(){//Retorna la pagina actual
                return this.pagination.current_page;
            },
            pagesNumber : function(){//Con este metodo obtenemos las paginas que hay
                if(!this.pagination.to){//Pregunta que si no es la ultima pagina
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if( from < 1){
                    from = 1;
                }
                var to = from +(this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray  = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;

            }
        },
        
        methods: {
            ListarUsuarios(page,buscar,criterio){//Lista el array categorias.
                let me = this;
                var url = '/usuario?page='+page+'&buscar=conf&criterio=1';
                axios.get(url).then(function (response) {
                    //Asi le asignamos al array categoria los datos de la respuesta
                    var respuesta = response.data;
                    me.arrayUsuario = respuesta.usuarios.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },

            cambiarPagina(page,buscar,criterio){//Cambia de pagina en el paginador
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.ListarUsuarios(page,buscar,criterio);
            },

            RegistrarUsuario(){//Registra una nueva categoria
                /* if(this.Validar()){
                    return false;
                } */
                let me =this;
                axios.post('/usuario/registrar', {
                    'id': this.id,
                    'usuario': this.usuario,
                    'password': this.password,
                    'idrol':this.idrol
                })
                .then(function (response) {
                    me.CerrarModal();
                    me.ListarUsuarios(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            ActualizarUsuario(){//Actualiza una categoria
                //Validamos los datos del formulario antes de actualizar
                /* if(this.Validar()){
                    return false;
                } */

                let me =this;
                axios.put('/usuario/actualizar', {
                    'usuario' : this.usuario,
                    'tipo' : this.tipo,
                    'password': this.password,
                    'nombres': this.nombres,
                    'apellidos': this.apellidos,
                    'idtercero':this.idtercero,
                    'cargo':this.cargo,
                    'email':this.email,
                })
                .then(function (response) {
                    me.CerrarModal();
                    me.ListarUsuarios(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            CerrarModal(){//Cierra el modal y limpia las variables 
                //Cerramos el modal y limpiamos los datos variantes
                this.modal =0;
                this.tituloModal ='';
                this.id =0,
                this.usuario='',
                this.password='',
                this.idrol=0
                this.errorRol = 0;
                this.errorDescRol ='';
                this.errorNmCategoria ='';

            },

            DesactivarUsuario(IdUsr){//Desactiva una categoria y usa el swetalerts2 
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro(a) de desactivar ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'No, cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {//Entramos al metodo desactivar  con axios
                    let me = this;
                    axios.put('/usuario/desactivar', {
                        'id': IdUsr
                    })
                    .then(function (response) {
                        me.ListarUsuarios(1,'','nombre');
                        //Mostramos el mensaje
                        swalWithBootstrapButtons.fire(
                            'Inactivado!',
                            'El usuario ha sido desactivado.',
                            'success'
                        )
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                    
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'Tansacción cancelada',
                        'error'
                    )
                }
                })
            },

            activarUsuario(IdUsr){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro(a) de activar esta categoria ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Activar!',
                cancelButtonText: 'No, cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {//Entramos al metodo desactivar  con axios
                    let me = this;
                    axios.put('/usuario/activar', {
                        'id': IdUsr
                    })
                    .then(function (response) {
                        me.ListarUsuarios(1,'','nombre');
                        //Mostramos el mensaje
                        swalWithBootstrapButtons.fire(
                            'Activada!',
                            'El usuario ha sido activado con éxito.',
                            'success'
                        )
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                    
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelado',
                        'Tansacción cancelada',
                        'error'
                    )
                }
                })
            },

            Validar(){
                this.errorRol =0;
                this.errorNmCategoria ='';
                this.errorDescRol ='';
                if(this.nombre ==''){
                    this.errorNmCategoria = ("El nombre de la categoria es obligatorio *");
                    this.errorRol =1;
                }
                if(this.descripcion == ''){
                    this.errorDescRol = ("La descripcion de la categoria es obligatorio *");
                    this.errorRol =1;
                }
                return this.errorRol;
            },

            AbrirModal(modelo,accion,data = []){//Abre el modal
                switch(modelo){
                    case "usuario":
                    {
                        switch(accion){
                            case "registrar":{
                                this.tituloModal ='Registrar Usuario';
                                this.modal = 1;
                                this.id='0';
                                this.usuario ='';
                                this.idrol=0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case "actualizar":{
                                this.tituloModal ='Actualizar Usuario';
                                this.modal = 1;
                                this.usuario = data.Usuario,
                                this.tipo = data.Tipo
                                this.password= data.Contrasena,
                                this.nombres= data.Nombres,
                                this.apellidos= data.Apellidos,
                                this.idtercero=data.IdTercero,
                                this.cargo=data.Cargo,
                                this.email=data.Email,
                                this.tipoAccion = 2;
                                break;
                            }
                        }
                    }
                }
            },

            
        },
        mounted() {//Inicializa el constructor
            this.ListarUsuarios(1,this.buscar,this.criterio);
        }
    }
</script>

<!--Se va ejecutar este codigo cuando se quiere abrir el modal-->
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
</style>
