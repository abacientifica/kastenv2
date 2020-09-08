<template>
    <div class="vld-parent">
        <loading :active.sync="isLoading" 
        :can-cancel="false" 
        :on-cancel="onCancel"
        color ='#007bff'
        loader ="dots"
        :is-full-page="true"></loading>
    </div>
</template>
<script>

    // Import component loading
import Loading from 'vue-loading-overlay';
    // Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    props :{//Son las variables que le voy a pasar al componente :isLoading = ? desde donde lo invoque
        isLoading :false,
        fullPage : true,
    },
    

    methods: {
        onCancel(){
            console.log("Usuario cancelo");
        }
    },

    components:{
        Loading
    },
}
</script>