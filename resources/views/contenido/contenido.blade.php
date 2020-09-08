@extends('principal')

@section('contenido')
<template v-if="menu==0">
    <dashboard></dashboard>
</template>
<template v-if="menu==1">
    <h1></h1>
</template>

<template v-if="menu==2">
    <h1></h1>
</template>

<template v-if="menu==3">
    <h1></h1>
</template>

<template v-if="menu==4">
    <h1></h1>
</template>

<template v-if="menu==5">
    <h1></h1>
</template>

<template v-if="menu==6">
    <h1></h1>
</template>

<template v-if="menu==7">
    <pedidos></pedidos>
</template>

<template v-if="menu==8">
        <historicomov></historicomov>
</template>
<template v-if="menu==9">
    <usuarios></usuarios>
</template>

<template v-if="menu==12">
    <reporte-ventas></reporte-ventas>
</template>

<template v-if="menu==13">
    <configuracion></configuracion>
</template>

<template v-if="menu==14">
    <facturacion></facturacion>
</template>

<template v-if="menu==15">
    <solicitud-devolucion></solicitud-devolucion>
</template>

<template v-if="menu==16">
    <commits><commits>
</template>

<template v-if="menu==17">
    <configuracionesdoc><configuracionesdoc>
</template>

<template v-if="menu==18">
    <main class="main">
        <nuevomovimiento :IdDocSeleccionado="3"></nuevomovimiento>
    </main>
</template>
@endsection