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
    <h1>Historico Pedidos</h1>
</template>
<template v-if="menu==9">
    <usuarios></usuarios>
</template>

<template v-if="menu==13">
    <configuracion></configuracion>
</template>
@endsection