<template>
    <div class="form-group row">
        <div class="col-md-6">
            <div class="input-group">
                <select class="form-control col-md-3" v-model="criterio">
                    <option value="NroDocumento">Nro Documento</option>
                    <option value="IdMovimiento">Id Movimeinto</option>
                    <option value="Estado">Estado</option>
                </select>
                <input type="text" v-model="buscar" @keyup.enter="ListarMovimientos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                <button type="submit" @click="ListarMovimientos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            usuario:'',
            buscar:'',
            criterio:''
        }
    }
}
</script>