<template>
<main class="main">
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Actualizaciones
                </div>
                <div class="form-control">
                        <div class="">
                        <ul class="timeline">
                            <li class="liteme" v-for="comit in ArrarComits" :key="comit.name" >
                                <a target="_blank" href="#" v-text="comit.author"></a>
                                <a href="#" class="float-right" v-text="FormatoFecha(comit.date)"></a>
                                <p v-text="comit.message"></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
</main>
</template>
<script>
export default {
    data() {
        return {
            ArrarComits:[]
        }
    },
    
    methods: {
        CargarComits() {
            let me = this;
            const user = 'abacientifica';
            const repo = 'kastenvs2';
            const startDate = '2019-05-06T00:00:00Z';
            const commitMessages = [];
            const token = 'ce74e7f975d37f47e9c5844d10a9dfbbbb5e5436';
            fetch(`https://api.github.com/repos/${user}/${repo}/commits`,{
                method: 'get',
                headers: { 'Content-Type': 'application/json', 'Authorization': `${token}` }
            }).then(res => res.json()).then(json => {
               json.forEach(commit => this.ArrarComits.push({ 'message': commit.commit.message, 'date':  commit.commit.author.date ,'author':commit.commit.author.name}));
            });
        },

        FormatoFecha(Fecha){
            var date = new Date(Fecha);
            var monthNames = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]; 
            var day = date.getDate(); 
            var monthIndex = date.getMonth(); 
            var year = date.getFullYear(); 
            return day + ' ' + monthNames[monthIndex] + ' ' + year;
        }
    },

    mounted() {
        this.CargarComits();
    },
}
</script>