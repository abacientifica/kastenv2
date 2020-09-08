<template>
    <li class="nav-item d-md-down-none">
        <a class="nav-link" href="#" data-toggle="dropdown">
            <i class="icon-bell"></i>
            <span class="badge badge-pill badge-danger">{{notifications.length}}</span>
        </a>  
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
                <strong>Notificaciones</strong>
            </div>
            <div v-if="notifications.length">
            <li v-for="item in listar" :key="item.id">
            <a class="dropdown-item" href="#"  v-if="item.pedidos.Num" @click="VerNotificaciones(1,item.pedidos.msj)">
                <i class="fa fa-envelope-o"></i> {{item.pedidos.msj}}
                <span class="badge badge-success" >{{item.pedidos.Num}}</span>
            </a>
            <a class="dropdown-item" href="#" v-if="item.facturas.Num" @click="VerNotificaciones(1,item.facturas.msj)">
                <i class="fa fa-tasks"></i> {{item.facturas.msj}}
                <span class="badge badge-danger">{{item.facturas.Num}}</span>
            </a>
            </li>
            </div>
            <div v-else>
                <a><span>No tiene notificaciones</span></a> 
            </div>
        </div>
    </li>
</template>
<script>
export default {     
	props : ['notifications'],
    data (){         
        return {
            arrayNotifications:[],
            menu:0
        } 
    },
    
    computed:{
        listar: function()  {
            //return this.notifications[0];
             this.arrayNotifications = Object.values(this.notifications[0]);
            if (this.notifications == '') {
                    return this.arrayNotifications = []; 
            } else {
                //Capturo la ultima notificación agregada 
                this.arrayNotifications = Object.values(this.notifications[0]); 
                //Validación por indice fuera de rango
                if (this.arrayNotifications.length > 3) { 
                    //Si el tamaño es > 3 Es cuando las notificaciones son obtenidas desde el mismo servidor, es decir por la consulta con AXIOS 
                    return Object.values(this.arrayNotifications[4]); 
                } else { 
                    //Si el tamaño es < 3 Es cuando las notificaciones son obtenidas desde el canal privado, es decir mediante Laravel Echo y Pusher 
                    return Object.values(this.arrayNotifications[0]);
                } 
            }
        },
    },
    methods: {

        VerNotificaciones(Val,info){
            let me = this;
            let menus=0;
            axios.get('/notification/leer?Datos='+info).then(function (response) {
                me.menu = response.data.menu
                me.$emit("input",me.menu);
                me.listar;
            })
            .catch(function (error) {
                console.log(error);
            });
            
        }
    },
    mounted() {

    },
}
</script>