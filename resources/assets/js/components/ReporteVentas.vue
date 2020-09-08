<template>
    <main class="main">
        <ol class="breadcrumb">
        </ol>
        <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Reportes
            </div>
                <div class="card-body">
                    <div class="form-group row border">
                        <div class="col-md-3" v-if="usuario.Tipo != 2">
                            <div class="form-group">
                                <label class='label-strong' >Tercero </label>
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
                        <div class="col-md-3" v-if="usuario.Tipo != 2">
                            <div class="form-group">
                                <label class='label-strong' >Año </label>
                                <span style="color:red" v-show="anio_filtro ==''">(Seleccione *)</span>
                                <select class="form-control" v-model="anio_filtro">
                                    <option  v-for="Anio in AniosFiltro" :key="Anio" :value="Anio" v-text="Anio" ></option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" @click="getVentas()" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div> 
                    <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Año {{anio_filtro -1}} </h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ventasant">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Ventas {{anio_filtro -1}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4> Año {{anio_filtro}}</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ventas">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Ventas {{anio_filtro}}</p>
                            </div>
                        </div>
                    </div>
                </div>    
                </div>
            </div>
        </div>
        <loader :isLoading="isLoading"></loader>
    </main>
</template>
<script>

import {mapState} from 'vuex'
export default {
    
    data() {
        return{
            ventas:[],
            ventasAnt:[],
            VarMeses : [],
            Anio : [],
            VarTotales:[],

            VarMesesAnt : [],
            VarTotalesAnt:[],

            //Filtros
            AniosFiltro:[],
            arrayTerceros:[],
            idtercero:0,
            anio_filtro:'',
            myChart:'',
            myChartAnt:'',
            isLoading:false
        }
    },
    methods: {

        limpiarDatos(){
            var me =this;
            this.isLoading = true;
            me.VarMeses =[]
            me.Anio =[]
            me.VarTotales=[]
            this.isLoading = false;
        },

        getVentas(AnioAnt=''){
            let me=this;
            this.isLoading = true;
            if(AnioAnt ==''){
                me.limpiarDatos();
                me.ventas=[]
                var url= '/reporte/ventas?anio='+this.anio_filtro+'&Idtercero='+this.idtercero;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    if(respuesta){
                        me.ventas = respuesta.ventas;
                        //cargamos los datos del chart
                        me.ventas.map(function(x){
                            me.VarMeses.push(x.Mes);
                            me.VarTotales.push(x.Total);
                        });
                        me.loadVentas();
                    }
                    else{
                        me.limpiarDatos();
                        me.VarMeses =[]
                        me.Anio =[]
                        me.VarTotales=[]
                    }
                    me.isLoading = false;
                })
                .catch(function (error) {
                    me.isLoading = false;
                    console.log(error);
                });
            }
            else{
                me.ventasAnt=[]
                me.VarMesesAnt=[];
                me.VarTotalesAnt=[];
                var url= '/reporte/ventas?anio='+AnioAnt+'&Idtercero='+this.idtercero;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    if(respuesta){
                        me.ventasAnt = respuesta.ventas;
                        //cargamos los datos del chart
                        me.ventasAnt.map(function(x){
                            me.VarMesesAnt.push(x.Mes);
                            me.VarTotalesAnt.push(x.Total);
                        });
                        me.loadVentasAnt();
                        me.isLoading = false;
                    }
                })
                .catch(function (error) {
                    me.isLoading = false;
                    console.log(error);
                });
            }
        },

        selectTerceros : _.debounce(function(search,loading){
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
            })
        },500),

        getDatosTercero(val1){
            let me = this;
            try{
                me.loading = true;
                me.idtercero = val1.IdTercero;
            }
            catch(error){
                me.idtercero = 0;
            }
        },

        loadVentas(){
            let me=this;
            //Destruimos el chart cada que realicemos un filtro
            if(me.myChart  instanceof Chart){
                me.myChart.destroy();
                console.log("destruido");
            }
            var graficsVentas = document.getElementById('ventas').getContext('2d');
            me.myChart = new Chart(graficsVentas, {
                type: 'bar',
                data: {
                    labels: me.VarMeses,
                    datasets: [{
                        label: 'Año Actual',
                        data: me.VarTotales,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    if(parseInt(value) >= 1000){
                                        return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    } else {
                                        return '$' + value.toFixed(2);
                                    }
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var valor = tooltipItem.yLabel
                                valor = new Intl.NumberFormat('es-CO', {
                                    style: 'currency',
                                    currency: 'COP',
                                }).format(valor)

                                return data.datasets[tooltipItem.datasetIndex].label+": "+ valor;
                            }
                        }
                    }
                }
                
            });
            this.getVentas(this.anio_filtro-1);
        },

        loadVentasAnt(){
            var me = this;
            if(me.myChartAnt  instanceof Chart){
                me.myChartAnt.destroy();
                console.log("destruido");
            }
            var graficsVentas = document.getElementById('ventasant').getContext('2d');
            me.myChartAnt = new Chart(graficsVentas, {
                type: 'bar',
                data: {
                    labels: me.VarMesesAnt,
                    datasets: [{
                        label: 'Año Anterior',
                        data: me.VarTotalesAnt,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value, index, values) {
                                    if(value > 1000){
                                        return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                    } else {
                                        return '$' + value.toFixed(2);
                                    }
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var valor = tooltipItem.yLabel
                                valor = new Intl.NumberFormat('es-CO', {
                                    style: 'currency',
                                    currency: 'COP',
                                }).format(valor)

                                return data.datasets[tooltipItem.datasetIndex].label+": "+ valor;
                            }
                        }
                    }
                }
                
            });
        },
        ObtAnios(){
            var i =0;
            var AnioActual = new Date();
            var AnioAct = AnioActual.getFullYear();
            for(i=2010;i<=AnioAct;i++){
                this.AniosFiltro.push(i)
            }
        }
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

    computed: {
        ...mapState('Usuario',['usuario'])
    },
    
    mounted() {
        var Anio = new Date();
        this.anio_filtro = Anio.getFullYear();
        this.ObtAnios();
        this.getVentas();
        console.log(_.random(10))
    },
}
</script>