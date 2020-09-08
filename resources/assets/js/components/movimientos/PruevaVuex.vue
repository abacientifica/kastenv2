<template>
    <main class="main">
        <h1>Prueba {{useract}}</h1>
        <input type="text" v-model="contador" :change="prueba()"><br>
        <button  @click="aumentarContador(1)" >+</button>
    </main>
</template>
<script>
import {mapState,mapMutations} from 'vuex'
export default {
    computed: {
        ...mapState(
            'NuevoMovimiento',['useract','contador']
        )
    },
    methods: {
        ...mapMutations('NuevoMovimiento',['aumentarContador']),
        prueba(){
            console.log("Prueba")
        }
    },
}
</script>