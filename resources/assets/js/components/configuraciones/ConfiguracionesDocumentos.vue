<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <button type="button" @click="AbrirModal('usuario','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Configuración Documentos
                    </div>
                    <template v-if="listado=1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                            <option value="Nombre" selected>Nombre</option>
                                            <option value="IdDocumento">Id Documento</option>
                                        </select>
                                        <input type="text" id="txtBuscar" v-model="buscar" @keyup.enter="ListarDocumentos(1,buscar,criterio)" v-on:change="ListarDocumentos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="ListarDocumentos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Consecutivo</th>
                                        <th>Tipo Documento</th>
                                        <th>Inactivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="config in arrayDocumentos" :key="config.IdDocumento">
                                        <td>
                                            <button type="button"  @click="AbrirModal('documento','agregar',config)" class="btn btn-warning btn-sm" >
                                            <i class="icon-pencil"></i>
                                            </button> &nbsp;
                                            <template v-if="config.Inactivo == 0">
                                                <button type="button" class="btn btn-danger btn-sm" @click="DesactivarUsuario(usuconfigario.Usuario)" >
                                                <i class="icon-trash"></i>
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button type="button" class="btn btn-info btn-sm" @click="activarUsuario(config.Usuario)" >
                                                <i class="icon-check"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="config.IdDocumento"></td>
                                        <td v-text="config.Nombre"></td>
                                        <td v-text="config.Consecutivo"></td>
                                        <td v-text="config.Tp"></td>
                                        <td>
                                            <div v-if="config.Inactivo ==1">
                                                <span class="badge badge-danger" >Inactivo</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-success" >Activo</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page -1,buscar,criterio)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                    </li>
                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </template>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Campo</th>
                                            <th>Ejemplo</th>
                                            <th>Alias</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="dato in arrayCampos" :key="dato.IdCampo">
                                            
                                            <td v-text="dato.IdCampo"></td>
                                            <td v-text="dato.NmEjemplo"></td>
                                            <td><input type="text" v-model="dato.NmEjemplo" v-if="dato.Existe == null"><input type="text" v-model="dato.Existe" disabled v-else></td>
                                            <td>
                                                <button type="button"  @click="agregarDetalleModal(dato)" v-if="dato.Existe == null" class="btn btn-success btn-sm" >
                                                    <i class="icon-check"></i>
                                                </button>
                                                <button type="button"  @click="quitarDetalleModal(dato)" v-if="dato.Existe != null" class="btn btn-danger btn-sm" >
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="CerrarModal()" >Cerrar</button>
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
                listado:1,
                IdDocumento:0,
                Nombre:'',
                Tp:'',
                Consecutivo:0,
                modal:0,

                tituloModal:'',

                arrayDocumentos:[],
                arrayDetalle:[],
                arrayCampos:[],

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

            },

        },
        
        methods: {
            ListarDocumentos:function(page,buscar,criterio){//Lista documetnos
                let me = this;
                var url = '/documentos/ObtenerDocTp/?Tp='+null+'&page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayDocumentos = respuesta.documentos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            cambiarPagina(page,buscar,criterio){//Cambia de pagina en el paginador
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.ListarDocumentos(page,buscar,criterio);
            },

           

            CerrarModal(){//Cierra el modal y limpia las variables 
                //Cerramos el modal y limpiamos los datos variantes
                this.modal =0;
                this.tituloModal ='';
                this.IdDocumento =0;
                this.arrayCampos=[];

            },

            AbrirModal(modelo,accion,IdDoc){//Abre el modal
                switch(modelo){
                    case "documento":
                    {
                        switch(accion){
                            case "agregar":{
                                this.tituloModal ='Registrar Campos '+IdDoc.Nombre;
                                this.modal = 1;
                                this.IdDocumento = IdDoc.IdDocumento;
                                this.CargarCampos();
                                break;
                            }
                        }
                    }
                }
            },

            CargarCampos(){
                let me = this;
                var url = '/documentos/campos?IdDoc='+me.IdDocumento;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayCampos = respuesta.campos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            agregarDetalleModal(dato){
                let campo = dato.IdCampo;
                let alias = dato.NmEjemplo;
                let me =this;
                axios.post('/documentos/GuardarConfig', {
                    'IdDoc': me.IdDocumento,
                    'IdCampo': campo,
                    'AliasCampo': alias,
                })
                .then(function (response) {
                    me.CargarCampos();
                })
                .catch(function (error) {
                    console.log(error);
                });  
            },

            quitarDetalleModal(dato){
                let campo = dato.IdCampo;
                let alias = dato.NmEjemplo;
                let me =this;
                axios.put('/documentos/campos/delete', {
                    'IdDoc': me.IdDocumento,
                    'IdCampo': campo
                })
                .then(function (response) {
                    me.CargarCampos();
                })
                .catch(function (error) {
                    console.log(error);
                });  
            }

            
        },
        mounted() {//Inicializa el constructor
            this.ListarDocumentos(1,this.buscar,this.criterio);
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
        position: fixed !important;
        background-color: #3c29297a !important;
    }
</style>
