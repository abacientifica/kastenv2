<template>

    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
                <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </ol>
            <div class="container-fluid">
                <!--Botonera-->
                <div class="card" v-if="listado == 2">
                    <div class="card-body">
                        <button class="btn btn-info" @click="editarPedido()"><i class="icon-pencil"></i>&nbsp;Editar</button>
                        <button class="btn btn-info" @click="imprimirPedido()"><i class="icon-printer"></i>&nbsp;Imprimir</button>
                    </div>
                </div>
                <div class="alert alert-danger" v-if="errorIngreso >0">
                    <ul>
                        <li v-for="val in errorMsgIngreso" :key="val.id" v-text="val"></li>
                    </ul>
                </div>
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Pedidos
                    </div>
                    <!--Listado de ingreso-->
                    <template v-if="listado == 1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="NroDocumento">Nro Documento</option>
                                      <option value="IdMovimiento">Id Movimeinto</option>
                                      <option value="Estado">Estado</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="ListarIngresos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="ListarIngresos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Id</th>
                                    <th>Nro</th>
                                    <th>Soporte</th>
                                    <th>Direccion</th>
                                    <th>Fecha</th>
                                    <th>Fecha Min. Entrega</th>
                                    <th>Fecha Max. Entrega</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Comentarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="pedido in arrayPedidos" :key="pedido.IdMovimiento">
                                    <td>
                                        <button type="button" @click="verPedido(pedido.IdMovimiento)" class="btn btn-success btn-sm">
                                        <i class="icon-eye"></i>
                                        </button> &nbsp;
                                        <template v-if="pedido.estado=='Registrado'">
                                            <button type="button" class="btn btn-danger btn-sm" @click="DesactivarIngreso(pedido.IdMovimiento)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="pedido.IdMovimiento"></td>
                                    <td v-text="pedido.NroDocumento"></td>
                                    <td v-text="pedido.Soporte"></td>
                                    <td v-text="pedido.NmDireccion"></td>
                                    <td v-text="pedido.Fecha"></td>
                                    <td v-text="pedido.Fecha1"></td>
                                    <td v-text="pedido.Fecha2"></td>
                                    <td v-text="'$'+FormatoMoneda(pedido.Total,2)"></td>
                                    <td v-text="pedido.Estado"></td>
                                    <td v-text="pedido.Comentarios"></td>
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
                    <!--Fin Listado Ingresos-->

                    <!--Nuevo Pedido-->
                    <template v-else-if="listado == 0">
                    <div class="card-body">
                        <!-- <div class="form-group row border">
                            <div class="col-md-3" v-if="usuario.Tipo != 2">
                                <div class="form-group">
                                    <label>Tercero </label>
                                    <span style="color:red" v-show="idtercero ==0">(Seleccione *)</span>
                                    <v-select
                                        @search="selectTerceros"
                                        label="NombreCorto"
                                        :options="arrayTerceros"
                                        placeholder="Buscar Tercero..."
                                        @input="getDatosTercero"                                 
                                    >
                                    </v-select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Direccion</label>
                                    <span style="color:red" v-show="id_direccion ==0">(Seleccione *)</span>
                                    <select class="form-control" v-model="id_direccion">
                                        <option value="0" selected>( Seleccione )</option>
                                        <option v-for="dir in arrayDirecciones" :key="dir.IdDireccion" :value="dir.IdDireccion" v-text="dir.NmDireccion"></option>
                                    </select>                                   
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Minima Entrega</label><span style="color:red" v-show="fecha_minima ==''">(Seleccione *)</span>
                                    <input type="date"  class="form-control" v-model="fecha_minima"/>      
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Fecha Maxima Entrega</label><span style="color:red" v-show="fecha_maxima ==''">(Seleccione *)</span>
                                    <input type="date"  class="form-control" v-model="fecha_maxima"/>  
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Numero Orden</label>
                                    <input type="text" v-model="num_orden" class="form-control" placeholder=" # Orden"> 
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Condicion Entrega</label><span style="color:red" v-show="condicion_entrega ==''">(Seleccione *)</span>
                                    <select class="form-control" v-model="condicion_entrega">
                                        <option value="0">SIN DEFINIR</option>
                                        <option value="1">VENTANILLA</option>
                                        <option value="2">DOMICILIO CLIENTE</option>
                                    </select>            
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Prioridad</label><span style="color:red" v-show="prioridad ==''">(Seleccione *)</span>
                                    <select class="form-control" v-model="prioridad">
                                        <option value="0">ALTA</option>
                                        <option value="1">NORMAL</option>
                                        <option value="2">MEDIA</option>
                                        <option value="3">BAJA</option>
                                    </select>              
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Comentarios</label>
                                    <textarea v-model="comentarios" class="form-control">
                                    </textarea>  
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div v-show="errorIngreso" class="form-group">
                                    <div class="text-center col-md-12 alert alert-danger">
                                        <ul v-for="error in errorMsgIngreso" :key="error">
                                            <li v-text="error"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <nuevomovimiento  :IdDocSeleccionado="id_documento" ></nuevomovimiento>

                        <div class="form-group row border" v-if="id_direccion>0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artículo <span style="color:red" v-show="idarticulo ==0">(Seleccione *)</span></label>
                                    <div class="form-inline">
                                            <input type="text" class="form-control" v-model="codigo" @keyup.enter="buscarArticulo()" placeholder="Ingrese artículo">
                                            <button class="btn btn-primary" @click="AbrirModal()" value="">...</button>
                                            <input type="text" readonly="" class="form-control" v-model="articulo">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Precio <span style="color:red" v-show="precio ==0">(Ingrese *)</span></label>
                                    <input type="number" value="0" step="any" class="form-control" v-model="precio" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cantidad <span style="color:red" v-show="cantidad ==0">(Ingrese *)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Iva</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button type="button" @click="eliminarDetalle(index)" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.articulo"></td>
                                            <td v-text="FormatoMoneda(detalle.precio,2)"></td>
                                            <td v-text="FormatoMoneda(detalle.iva,2)"></td>
                                            <td>
                                                <input type="number" v-model="detalle.cantidad" class="form-control">
                                            </td>
                                            <td v-text="FormatoMoneda((detalle.precio * detalle.cantidad),2)"> </td>
                                        </tr>
                                      
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Sub Total:</strong></td>
                                            <td>$ {{FormatoMoneda(total = (calcularTotal ),2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>$ {{FormatoMoneda(impuesto,2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{FormatoMoneda(TotalNeto = (total + impuesto))}}</td>
                                        </tr>
                                    </tbody>  
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">No hay articulos</td>
                                        </tr>
                                    </tbody>                                 
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarPedido()">Registrar Pedido</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!--Fin listado detalle-->

                    <!-- Ver ingreso-->
                    <template v-else-if="listado == 2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class='label-strong'>IdMovimiento</label>
                                    <!--label muestra el objeto o la columna en el select-->
                                    <p v-text="idmovimiento"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="" class='label-strong'>Nro Documento</label>
                                 <p v-text="nro_documento"></p>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class='label-strong'>Fecha Creación</label>
                                    <p v-text="fecha"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class='label-strong'>Condición Entrega</label>
                                    <p v-text="condicion_entrega"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class='label-strong'>Fecha Minima Entrega </label>
                                    <p v-text="fecha1"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class='label-strong'>Fecha Maxima Entrega </label>
                                    <p v-text="fecha2"></p>
                                </div>
                            </div>

                            

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class='label-strong'>Estado</label>
                                    <p v-text="estado"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class='label-strong'>Soporte</label>
                                    <p v-text="soporte"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class='label-strong'>Centro Costos / Dirección</label>
                                    <p v-text="direccion"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class='label-strong'>Asesor</label>
                                    <p v-text="asesor"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class='label-strong'>Forma Pago</label>
                                    <p v-text="forma_pago"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class='label-strong'>Comentarios</label>
                                    <p v-text="comentarios"></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Iva</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle) in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.Id_Item"></td>
                                            <td v-text="detalle.Descripcion"></td>
                                            <td v-text="FormatoMoneda(detalle.Precio,2)"></td>
                                            <td v-text="detalle.Cantidad"></td>
                                            <td v-text="detalle.PorIva"></td>
                                            <td v-text="FormatoMoneda(detalle.Precio * detalle.Cantidad)"> </td>
                                        </tr>
                                      
                                        
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Iva:</strong></td>
                                            <td>$ {{FormatoMoneda(impuesto)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Sub Total:</strong></td>
                                            <td>$ {{FormatoMoneda((total = calcularTotal),2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total:</strong></td>
                                            <td>$ {{FormatoMoneda((totalParcial = Number(total) + Number(impuesto)),2)}}</td>
                                        </tr>
                                    </tbody>  
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">No hay articulos</td>
                                        </tr>
                                    </tbody>                                 
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin ver ingreso-->

                    <!--Editar Pedido-->
                    <template v-else-if="listado == 3">
                    <div class="card-body">
                        <nuevomovimiento  :IdDocSeleccionado="id_documento" :Editar="editar" :IdMovimiento="idmovimiento"></nuevomovimiento>
                        <div class="form-group row border" v-if="id_direccion>0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Artículo <span style="color:red" v-show="idarticulo ==0">(Seleccione *)</span></label>
                                    <div class="form-inline">
                                            <input type="text" class="form-control" v-model="codigo" @keyup.enter="buscarArticulo()" placeholder="Ingrese artículo">
                                            <button class="btn btn-primary" @click="AbrirModal()" value="">...</button>
                                            <input type="text" readonly="" class="form-control" v-model="articulo">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Precio <span style="color:red" v-show="precio ==0">(Ingrese *)</span></label>
                                    <input type="number" value="0" step="any" class="form-control" v-model="precio" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cantidad <span style="color:red" v-show="cantidad ==0">(Ingrese *)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Iva</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button type="button" @click="eliminarDetalleEdit(index,detalle.IdMovimientoDet)" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.Descripcion"></td>
                                            <td v-text="FormatoMoneda(detalle.Precio,2)"></td>
                                            <td v-text="FormatoMoneda(detalle.PorIva,2)"></td>
                                            <td>
                                                <input type="number" v-model="detalle.Cantidad" class="form-control">
                                            </td>
                                            <td v-text="FormatoMoneda((detalle.Precio * detalle.Cantidad),2)"> </td>
                                        </tr>
                                      
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Sub Total:</strong></td>
                                            <td>$ {{FormatoMoneda(total = (calcularTotal ),2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Impuesto:</strong></td>
                                            <td>$ {{FormatoMoneda(impuesto,2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{FormatoMoneda(TotalNeto = (total + impuesto))}}</td>
                                        </tr>
                                    </tbody>  
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">No hay articulos</td>
                                        </tr>
                                    </tbody>                                 
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalleEdit()" class="btn btn-secondary">Cancelar</button>
                                <button type="button" class="btn btn-primary" @click="actualizarPedido()">Actualizar Pedido</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!--Fin Editar Pedido-->

                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
             <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="CerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                            <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioArt">
                                            <option value="Id_Item">Codigo</option>
                                            <option value="Descripcion">Descripción</option>
                                        </select>
                                        <input type="text" v-model="buscarArt" @keyup.enter="ListarArticulo(buscarArt,criterioArt)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="ListarArticulo(buscarArt,criterioArt)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Precio</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="articulo in arrayArticulos" :key="articulo.id">
                                            <td>
                                                <button type="button"  @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm" >
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="articulo.Id_Item"></td>
                                            <td v-text="articulo.Descripcion"></td>
                                            <td v-text="FormatoMoneda(articulo.Precio,2)"></td>
                                            <td v-text="articulo.Disponible"></td>
                                            <td>
                                                <div v-if="articulo.Inactivo == '0'">
                                                    <span class="badge badge-success" >Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger" >Inactivo</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page -1,buscarArt,criterioArt)">Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscarArt,criterioArt)" v-text="page"></a>
                                        </li>
                                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscarArt,criterioArt)">Sig</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="CerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            
            <!--Inicio Loader-->
            <loader :isLoading="isLoading"></loader>
</main>
 <!-- /Fin del contenido principal -->
 
</template>

<script>
    import Vue from "vue";
    import vSelect from "vue-select";

    Vue.component("v-select", vSelect);
    import "vue-select/dist/vue-select.css";
    import {mapState,mapActions} from 'vuex'
    export default {
        data() {
            return {
                //Para abrir el loader en el metodo que ejecutemos ponemos isLoading= true al iniciar el metodo y isLoading= false cuando termine.
                //Variables Encabezado Movimiento
                idmovimiento: 0,
                nro_documento:0,
                id_documento:61,
                fecha : '',
                fecha1 : '',
                fecha2 : '',
                estado:'',
                soporte:'',
                direccion:'',
                /*idtercero:0,
                nombre : '',
                fecha : '',
                fecha1 : '',
                fecha2 : '',
                condicion_entrega :'2',
                estado:'',
                soporte:'',
                id_direccion:0,
                direccion:'',
                asesor:'',
                forma_pago:'',
                total_iva:0,
                sub_total:0,
                total:0,
                comentarios:'',
                prioridad:'1',
                fecha_minima:'',
                fecha_maxima:'',
                num_orden:'',*/
                

                arrayPedidos : [],
                arrayDetalle : [],
                arrayTerceros :[],
                arrayCondicionEntrega:[],
                arrayDirecciones: [],

                //Variables de articulo
                arrayArticulo :[],
                idarticulo:0,
                precio:0,
                cantidad:0,
                iva:0,
                codigo:'',
                articulo:'',
                paginacionArt :0,

                //Totales ingreso
                total:0.0,
                impuesto:0,
                TotalNeto:0.0,
                SubTotal:0.0,
                

                listado:1,//Me va mostrar el listado ingreso activo
                editar :false,


                modal:0,//Cuando este en 1 se abre el modal
                tituloModal :'',//Pone el texto en el modal
                tipoAccion : 0,//1 es registrar , 2 es actualizar
                errorIngreso:0,//Es 1 cuando hay validaciones sin pasar
                errorMsgIngreso:[],//Guarda el array de las validaciones    
                pagination :{//Esta propiedad la envia laravel con el metodo paginate para utilizarla en la paginacion con vue
                    'total' :0,
                    'current_page' :0,
                    'per_page' :0,
                    'last_page' :0,
                    'from' :0,
                    'to':0,
                },
                offset : 4,//Esta variable hace referecia al paginate(3) del controlador
                criterio : 'NroDocumento', //Esta variable se inicializa con nombre por que es el primer criterio del combo
                buscar :'',//Esta es la cadena de busqueda

                //Variables de articulo modal 
                buscarArt : '',
                criterioArt :'codigo',
                arrayArticulos :[],
                isLoading: false,
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

            calcularTotal: function(){
                var resultado =0;
                var porIva = 0;
                for(var i=0;i< this.arrayDetalle.length;i++){
                    if(this.listado!=0){
                        var objeto = this.arrayDetalle[i];
                        porIva = porIva + (((objeto['Cantidad'] * objeto['Precio']) * objeto['PorIva'])/100);
                        resultado = resultado + (objeto['Cantidad'] * objeto['Precio']);
                    }
                    else{
                        var objeto = this.arrayDetalle[i];
                        porIva = porIva + (((objeto['cantidad'] * objeto['precio']) * objeto['iva'])/100);
                        resultado = resultado + (objeto['cantidad'] * objeto['precio']);
                    }

                }
                this.impuesto = porIva;
                return resultado;
            },
            
            //Obtenemos el usuario almacenado en el state de vuex
            ...mapState('Usuario',['usuario']),
            id_direccion:{
                get(){ 
                    return this.$store.state.NuevoMovimiento.id_direccion
                },
                set(value){
                    this.SET_VARIABLES({'id_direccion':value})
                }
            },

            idtercero:{
                get(){ 
                    return this.$store.state.NuevoMovimiento.idtercero
                },
                set(value){
                    this.SET_VARIABLES({'idtercero':value})
                }
            },

            fecha_minima:{
                get(){ 
                    return this.$store.state.NuevoMovimiento.fecha_minima
                },
                set(value){
                    this.SET_VARIABLES({'fecha_minima':value})
                }
            },

            fecha_maxima:{
                get(){ 
                    return this.$store.state.NuevoMovimiento.fecha_maxima
                },
                set(value){
                    this.SET_VARIABLES({'fecha_maxima':value})
                }
            },
            condicion_entrega:{
                get(){ 
                    return this.$store.state.NuevoMovimiento.condicion_entrega
                },
                set(value){
                    this.SET_VARIABLES({'condicion_entrega':value})
                }
            },
            prioridad:{
                get(){ 
                    return this.$store.state.NuevoMovimiento.prioridad
                },
                set(value){
                    this.SET_VARIABLES({'prioridad':value})
                }
            },
            comentarios:{
                get(){ 
                    return this.$store.state.NuevoMovimiento.comentarios
                },
                set(value){
                    this.SET_VARIABLES({'comentarios':value})
                }
            },

            forma_pago:{
                get(){ 
                    return this.$store.state.NuevoMovimiento.forma_pago
                },
                set(value){
                    this.SET_VARIABLES({'forma_pago':value})
                }
            },

            num_orden:{
                get(){ 
                    return this.$store.state.NuevoMovimiento.num_orden
                },
                set(value){
                    this.SET_VARIABLES({'num_orden':value})
                }
            },

            asesor:{
                get(){ 
                    return this.$store.state.NuevoMovimiento.asesor
                },
                set(value){
                    this.SET_VARIABLES({'asesor':value})
                } 
            },

        },

        
        methods: {
            ListarIngresos(page,buscar,criterio){//Lista el array categorias.
                let me = this;
                var url = '/pedidos?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                this.isLoading = true;
                axios.get(url).then(function (response) {
                    //Asi le asignamos al array categoria los datos de la respuesta
                    var respuesta = response.data;
                    me.arrayPedidos = respuesta.pedidos.data;
                    me.pagination = respuesta.pagination;
                    me.isLoading = false;
                })
                .catch(function (error) {
                    // handle error
                    me.isLoading = false;
                    console.log(error);
                });
            },

            cambiarPagina(page,buscar,criterio){//Cambia de pagina en el paginador
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                if(this.paginacionArt ==0){
                    me.ListarIngresos(page,buscar,criterio);
                } 
                else{
                    me.ListarArticulo(buscar,criterio,page);
                }
            },

            registrarPedido(){//Registra un nuevo pedido
                if(this.ValidarPedido()){
                    return false;
                } 
                Swal.fire({
                    title: 'Estas seguro(a) de Autorizar el pedido ?',
                    text: "Si lo autorizas no podras modificar ningún dato de los ingresados.",
                    icon: 'warning',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-warning'
                    },
                    buttonsStyling: false,
                    cancelButtonText: 'Validar',
                    confirmButtonText: 'Registrar !',
                    showLoaderOnConfirm: true,
                    }).then((result) => {
                        if (result.value) {
                            this.isLoading = true;
                            let me =this;
                            axios.post('/pedido/registrar', {
                                'idtercero':this.idtercero,
                                'fecha_minima': this.fecha_minima,
                                'fecha_maxima': this.fecha_maxima,
                                'id_direccion': this.id_direccion,
                                'condicion_entrega': this.condicion_entrega,
                                'prioridad':this.prioridad,
                                'comentarios':this.comentarios,
                                'sub_total':this.total,
                                'total':this.TotalNeto,
                                'total_iva':this.impuesto,
                                'data':this.arrayDetalle,
                            })
                            .then(function (response) {
                                var IdMovRegistrado = response.data.movimiento;
                                me.idmovimiento= 0;
                                me.nro_documento=0;
                                me.idtercero=0;
                                me.nombre = '';
                                me.fecha = '';
                                me.fecha1 = '';
                                me.fecha2 = '';
                                me.condicion_entrega ='2';
                                me.estado='';
                                me.soporte='';
                                me.id_direccion='0';
                                me.direccion='';
                                me.asesor='';
                                me.forma_pago='';
                                me.total_iva=0;
                                me.sub_total=0;
                                me.total=0;
                                me.comentarios='';
                                me.prioridad='1';
                                me.fecha_minima='';
                                me.fecha_maxima='';
                                me.num_orden='';
                                me.arrayDetalle =[];


                                me.CerrarModal();
                                me.verPedido(IdMovRegistrado);
                                me.isLoading = false;
                            })
                            .catch(function (error) {
                                me.isLoading = false;
                                //console.log(error);
                                console.log(error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Ocurrio un error al crear el pedido!'
                                })
                                console.log(error);
                            });
                        }
                    })
            },

            actualizarPedido(){//Registra un nuevo pedido
                if(this.ValidarPedido()){
                    return false;
                } 
                Swal.fire({
                    title: 'Estas seguro(a) de Autorizar el pedido ?',
                    text: "Si lo autorizas no podras modificar ningún dato de los ingresados.",
                    icon: 'warning',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-warning'
                    },
                    buttonsStyling: false,
                    cancelButtonText: 'Validar',
                    confirmButtonText: 'Actualizar !',
                    showLoaderOnConfirm: true,
                    }).then((result) => {
                        if (result.value) {
                            this.isLoading = true;
                            let me =this;
                            axios.put('/pedido/actualizar', {
                                'idmovimiento':me.idmovimiento,
                                'idtercero':me.idtercero,
                                'fecha_minima': me.fecha_minima,
                                'fecha_maxima': me.fecha_maxima,
                                'id_direccion': me.id_direccion,
                                'condicion_entrega': me.condicion_entrega,
                                'num_orden':me.num_orden,
                                'prioridad':me.prioridad,
                                'comentarios':me.comentarios,
                                'sub_total':me.total,
                                'total':me.TotalNeto,
                                'total_iva':me.impuesto,
                                'data':me.arrayDetalle,
                            })
                            .then(function (response) {
                                var IdMovRegistrado = response.data.movimiento;
                                me.idmovimiento= 0;
                                me.nro_documento=0;
                                me.idtercero=0;
                                me.nombre = '';
                                me.fecha = '';
                                me.fecha1 = '';
                                me.fecha2 = '';
                                me.condicion_entrega ='2';
                                me.estado='';
                                me.soporte='';
                                me.id_direccion='0';
                                me.direccion='';
                                me.asesor='';
                                me.forma_pago='';
                                me.total_iva=0;
                                me.sub_total=0;
                                me.total=0;
                                me.comentarios='';
                                me.prioridad='1';
                                me.fecha_minima='';
                                me.fecha_maxima='';
                                me.num_orden='';
                                me.arrayDetalle =[];

                                me.editar = false;
                                me.CerrarModal();
                                me.verPedido(IdMovRegistrado);
                                me.isLoading = false;
                            })
                            .catch(function (error) {
                                me.isLoading = false;
                                //console.log(error);
                                console.log(error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Ocurrio un error al crear el pedido!'
                                })
                                console.log(error);
                            });
                        }
                    })
            },

            verPedido(id){
                let me = this;
                me.listado = 2;
                this.isLoading = true;
                var url = '/pedido/obtenerPedido?id='+id;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    var objPedido = respuesta.pedido;
                    var objpedidosDet = response.data.detalles;
                    objPedido = objPedido[0];
                    var IdCondEntrega = objPedido.IdCondEntrega;
                    me.idmovimiento= objPedido.IdMovimiento;
                    me.nro_documento= objPedido.NroDocumento;
                    me.impuesto = objPedido.VrIva;
                    me.idtercero= objPedido.IdTercero;
                    me.nombre = objPedido.NombreCorto;
                    me.fecha = objPedido.Fecha;
                    me.fecha1 = objPedido.Fecha1;
                    me.fecha2 = objPedido.Fecha2;
                    me.condicion_entrega = me.arrayCondicionEntrega[IdCondEntrega];
                    me.estado=objPedido.Estado;
                    me.soporte=objPedido.Soporte;
                    me.direccion = objPedido.NmDireccion;
                    //me.asesor = objPedido.IdAsesor;
                    me.forma_pago= me.formaPago(objPedido.IdFormaPago);
                    me.comentarios = objPedido.Comentarios;
                    me.asesor = objPedido.Asesor;

                    me.arrayDetalle = [];
                    objpedidosDet.forEach(detalle => {
                        me.arrayDetalle.push(detalle);
                    });
                    me.isLoading = false;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },

            verPedidoEdit(id){
                this.obtenerDirecciones();
                let me = this;
                var url = '/pedido/obtenerPedido?id='+id;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    var objPedido = respuesta.pedido;
                    var objpedidosDet = response.data.detalles;
                    objPedido = objPedido[0];
                    var IdCondEntrega = objPedido.IdCondEntrega;
                    me.idmovimiento= objPedido.IdMovimiento;
                    me.nro_documento= objPedido.NroDocumento;
                    me.impuesto = objPedido.VrIva;
                    me.idtercero= objPedido.IdTercero;
                    me.nombre = objPedido.NombreCorto;
                    me.fecha = objPedido.Fecha;

                    me.fecha_minima = objPedido.Fecha1;
                    me.fecha_maxima = objPedido.Fecha2;
                    me.condicion_entrega = objPedido.IdCondEntrega;
                    me.estado=objPedido.Estado;
                    me.num_orden=objPedido.Soporte;
                    me.id_direccion = objPedido.IdDireccion;
                    me.asesor = objPedido.IdAsesor;
                    me.forma_pago= me.formaPago(objPedido.IdFormaPago);
                    me.comentarios = objPedido.Comentarios;

                    me.arrayDetalle = [];
                    objpedidosDet.forEach(detalle => {
                        me.arrayDetalle.push(detalle);
                    });
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },

            mostrarDetalle(){
                this.isLoading = true;
                this.listado = 0;
                this.idtercero = 0;
                this.tipo_comprobante='BOLETA';
                this.serie_comprobante='';
                this.num_comprobante='';
                this.impuesto=0;
                this.total=0.0;
                this.arrayDetalle=[];
                this.idarticulo=0;
                this.cantidad=0;
                this.precio =0;
                this.idmovimiento=0;
                this.estado='';
                this.fecha='';
                this.fecha1='';
                this.fecha2='';
                this.direccion='';
                this.obtenerDirecciones();
                this.isLoading = false;
            },

            ocultarDetalle(){
                this.listado = 1;
                this.arrayDetalle =[];
                this.idmovimiento= 0;
                this.nro_documento=0;
                this.idtercero=0;
                this.nombre = '';
                this.fecha = '';
                this.fecha1 = '';
                this.fecha2 = '';
                this.condicion_entrega ='2';
                this.estado='';
                this.soporte='';
                this.id_direccion='0';
                this.direccion='';
                this.asesor='';
                this.forma_pago='';
                this.total_iva=0;
                this.sub_total=0;
                this.total=0;
                this.comentarios='';
                this.prioridad='1';
                this.fecha_minima='';
                this.fecha_maxima='';
                this.num_orden='';
                this.arrayDetalle =[];
                this.paginacionArt=0;
                this.impuesto=0;
                this.ListarIngresos(1,'');
            },

            CerrarModal(){//Cierra el modal y limpia las variables 
                //Cerramos el modal y limpiamos los datos variantes
                this.modal=0;
                this.paginacionArt =0;
                this.tituloModal='';
                this.arrayArticulos = [];
            },

            selectTerceros(search,loading){
                let me=this;
                loading(true);
                var url= '/terceros/ObtenerTerceros?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search;
                    me.arrayTerceros = respuesta.terceros;
                    loading(false);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            ...mapActions('NuevoMovimiento',['SET_VARIABLES']),

            DesactivarIngreso(IdIngreso){//Desactiva una categoria y usa el swetalerts2 
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro(a) de anular el ingreso ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, anular!',
                cancelButtonText: 'No, cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {//Entramos al metodo desactivar  con axios
                    let me = this;
                    axios.put('/ingreso/desactivar', {
                        'id': IdIngreso
                    })
                    .then(function (response) {
                        me.ListarIngresos(1,'','num_comprobante');
                        //Mostramos el mensaje
                        swalWithBootstrapButtons.fire(
                            'Inactivado!',
                            'el ingreso a sido anulado.',
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

            ValidarPedido(){
                this.errorIngreso =0;
                this.errorMsgIngreso =[];
                if(this.id_direccion ==''){
                    this.errorMsgIngreso.push("La dirección obligatoria *");
                    this.errorIngreso = 1
                }
                if(this.fecha_minima == ''){
                    this.errorMsgIngreso.push("La fecha minima es obligatoria *");
                    this.errorIngreso =1;
                }
                if(this.fecha_maxima ==''){
                    this.errorMsgIngreso.push("La fecha maxima es obligatoria *");
                    this.errorIngreso =1;
                }
                if(this.prioridad ==''){
                    this.errorMsgIngreso.push("La prioridad es obligatorio *");
                    this.errorIngreso =1;
                }
                if(this.arrayDetalle.length ==0 ){
                    this.errorMsgIngreso.push("Debes ingresar un detalle *");
                    this.errorIngreso =1;
                }

                return this.errorIngreso;
            },

            AbrirModal(){//Abre el modal
                this.paginacionArt =1;
                this.ListarArticulo('','');
                this.tituloModal ='Seleccione uno o varios Articulos';
                this.modal = 1;
            },
            
            selectProveedor(search,loading){
                let me=this;
                loading(true)

                var url= '/selectprov?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search;
                    me.arrayTerceros = respuesta.proveedores;
                    loading(false);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            getDatosTercero(val1){
                let me = this;
                try{
                    me.loading = true;
                    me.idtercero = val1.IdTercero;
                    me.obtenerDirecciones();
                }
                catch(error){
                    me.idtercero = 0;
                    me.obtenerDirecciones();
                }
            },

            agregarDetalle(){
                let me = this;
                if(me.idarticulo == 0 || me.cantidad == 0 || me.precio ==0){

                }
                else{
                    if(me.editar == false){
                        if(!me.encuentra(me.idarticulo)){
                            me.arrayDetalle.push({
                                idarticulo: me.idarticulo,
                                articulo: me.articulo,
                                cantidad: me.cantidad,
                                precio: me.precio,
                                iva: me.iva
                            });
                            me.idarticulo=0,
                            me.articulo='',
                            me.cantidad=0,
                            me.precio=0,
                            me.iva=0;
                            me.codigo=''
                        }
                        else{
                            Swal.fire({
                                icon :'error',
                                type :'error',
                                title :'',
                                text:'El articulo '+me.articulo+' ya se encuentra en la lista"'
                            })
                            me.idarticulo=0,
                            me.articulo='',
                            me.cantidad=0,
                            me.precio=0,
                            me.iva=0;
                            me.codigo=''
                        }
                    }
                    else if(me.editar == true){
                        if(!me.encuentraId(me.Id_Item)){
                            me.arrayDetalle.push({
                                IdMovimientoDet:0,
                                Id_Item: me.idarticulo,
                                Descripcion: me.articulo,
                                Cantidad: me.cantidad,
                                Precio: me.precio,
                                PorIva: me.iva
                            });
                            me.idarticulo=0,
                            me.articulo='',
                            me.cantidad=0,
                            me.precio=0,
                            me.iva=0;
                            me.codigo=''
                        }
                        else{
                            Swal.fire({
                                icon :'error',
                                type :'error',
                                title :'',
                                text:'El articulo '+me.articulo+' ya se encuentra en la lista"'
                            })
                            me.idarticulo=0,
                            me.articulo='',
                            me.cantidad=0,
                            me.precio=0,
                            me.iva=0;
                            me.codigo=''
                        }
                    }
                }
            },
            encuentra(idart){
                let valida = false;
                for(let i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i]['idarticulo'] == idart){
                        valida = true;
                    }
                }
                return valida;
            },

            encuentraId(idart){
                let valida = false;
                for(let i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i]['Id_Item'] == idart){
                        valida = true;
                    }
                }
                return valida;
            },

            cargarCondiciones(){
                this.arrayCondicionEntrega.push('SIN DEFINIR');
                this.arrayCondicionEntrega.push('VENTANILLA');
                this.arrayCondicionEntrega.push('DOMICILIO CLIENTE');
            },

            eliminarDetalle(index){
                let producto = this.arrayDetalle[index]['articulo'];
                Swal.fire({
                    title: '',
                    text: "Estas seguro de eliminar "+producto+" de la lista ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Eliminar !',
                    }).then((result) => {
                    if (result.value) {
                        let me = this;
                        me.arrayDetalle.splice(index,1);

                        Swal.fire(
                        producto+' Eliminado!',
                        '',
                        'success'
                        )
                    }
                })
            },

            ListarArticulo(buscarArt,criterioArt,page=1){
                this.obtenerDirecciones();
                let me = this;
                var url = '/listaprecios/lista?Id='+this.id_direccion+'&filtro='+buscarArt+'&criterio='+criterioArt+'&page='+page;
                axios.get(url).then(function (response) {
                    //Asi le asignamos al array categoria los datos de la respuesta
                    var respuesta = response.data;
                    me.arrayArticulos = respuesta.productos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },

            buscarArticulo(){
                let me = this;
                var url = '/listaprecios/lista?Id='+this.id_direccion+'&filtro='+me.codigo+'&criterio=Id_Item';
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    me.arrayArticulo = respuesta.productos.data;
                    if(me.arrayArticulo.length >0){
                        me.articulo = me.arrayArticulo[0]['Descripcion'];
                        me.idarticulo = me.arrayArticulo[0]['Id_Item'];
                        me.precio = me.arrayArticulo[0]['Precio'];
                        me.iva = me.arrayArticulo[0]['Por_Iva'];
                        me.cantidad =1;
                    }
                    else{
                        me.articulo = 'No existe el articulo';
                        me.idarticulo = 0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            agregarDetalleModal(data=[]){
                let me = this;
                if(me.editar == false){
                    if(!me.encuentra(data.Id_Item)){
                        me.arrayDetalle.push({
                            idarticulo: data.Id_Item,
                            articulo: data.Descripcion,
                            cantidad: 1,
                            precio: data.Precio,
                            iva: data.Por_Iva
                        });
                        Swal.fire({
                            icon :'success',
                            type :'success',
                            title :'',
                            text:'El articulo '+data.Descripcion+' se agrego"'
                        })
                    }
                    else{
                        Swal.fire({
                            icon :'error',
                            type :'error',
                            title :'',
                            text:'El articulo '+data.Descripcion+' ya se encuentra en la lista"'
                        })
                    }
                }
                else if(me.editar == true){
                    if(!me.encuentraId(data.Id_Item)){
                        me.arrayDetalle.push({
                            IdMovimientoDet:0,
                            Id_Item: data.Id_Item,
                            Descripcion: data.Descripcion,
                            Cantidad: 1,
                            Precio: data.Precio,
                            PorIva: data.Por_Iva
                        });
                        Swal.fire({
                            icon :'success',
                            type :'success',
                            title :'',
                            text:'El articulo '+data.Descripcion+' se agrego"'
                        })
                    }
                    else{
                        Swal.fire({
                            icon :'error',
                            type :'error',
                            title :'',
                            text:'El articulo '+data.Descripcion+' ya se encuentra en la lista"'
                        })
                    }
                }
                
            },

            obtenerDirecciones(){
                let me = this;
                if(me.idtercero !=''){
                    var url = '/direcciones/tercero/'+me.idtercero;
                }
                else{
                    var url = '/direcciones/tercero/'+me.idtercero;
                }
                axios.get(url).then(function (response) {
                    //Asi le asignamos al array categoria los datos de la respuesta
                    var respuesta = response.data;
                    me.arrayDirecciones = respuesta.direcciones;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },

            FormatoMoneda(amount=0, decimals) {

                var sign = (amount.toString().substring(0, 1) == "-");

                amount += ''; // por si pasan un numero en vez de un string
                amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

                decimals = decimals || 0; // por si la variable no fue fue pasada

                // si no es un numero o es igual a cero retorno el mismo cero
                if (isNaN(amount) || amount === 0) 
                    return parseFloat(0).toFixed(decimals);

                // si es mayor o menor que cero retorno el valor formateado como numero
                amount = '' + amount.toFixed(decimals);

                var amount_parts = amount.split('.'),
                    regexp = /(\d+)(\d{3})/;

                while (regexp.test(amount_parts[0]))
                    amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

                return  sign ? '-' + amount_parts.join('.') : amount_parts.join('.');
            },

            formaPago(Id){
                let NmFormaPago ='';
                
                if(Id==1){
                    NmFormaPago = 'CONTADO';
                }
                else if(Id==1){
                    NmFormaPago = 'CREDITO';
                }
                else if(Id==1){
                    NmFormaPago = 'CONTRAENTREGA';
                }
                else if(Id==1){
                    NmFormaPago = 'CONTADO VENTANILLA';
                }
                else{
                    NmFormaPago = '';
                }
                return NmFormaPago;
            },

            editarPedido(){
                Swal.fire({
                    title: '',
                    text: "Estas seguro(a) de editar este pedido ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Editar !',
                    }).then((result) => {
                    if (result.value) {
                        let me = this;
                        this.editar =true;
                        this.listado = 3;
                        this.verPedidoEdit(this.idmovimiento)
                    }
                })
                
            },

            ocultarDetalleEdit(){
                this.editar =false;
                this.listado = 2;
                this.verPedido(this.idmovimiento)
            },

            eliminarDetalleEdit(index,Id){

                let producto = this.arrayDetalle[index]['Descripcion'];
                Swal.fire({
                    title: '',
                    text: "Estas seguro de eliminar "+producto+" de la lista ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Eliminar !',
                    }).then((result) => {
                    if (result.value) {
                        let me = this;
                        me.arrayDetalle.splice(index,1);
                        if(Id>0){
                            axios.delete('/pedido/eliminardet'+'?Id='+Id).then(function (response) {
                                var Respuesta = responde.data;
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                        }
                        Swal.fire(
                        producto+' Eliminado!',
                        '',
                        'success'
                        )
                    }
                })

               
            },

            imprimirPedido(){
                let me = this;
                axios({url: '/pedidos/imprimir'+'?Id='+me.idmovimiento, method: 'GET',responseType: 'blob', // important

                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', 'pedido'+me.nro_documento+'.pdf');
                    document.body.appendChild(link);
                    link.click();
                });
            }

        },

        

        mounted() {//Inicializa el constructor
            this.ListarIngresos(1,this.buscar,this.criterio);
            this.cargarCondiciones();
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

    .text-error{
        color: red !important;
        font-weight: bold;
    }

    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }
</style>
