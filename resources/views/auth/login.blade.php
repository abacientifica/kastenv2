@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card-group mb-0">
        <div class="card p-4">
        <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
            {{ csrf_field() }}
              <div class="card-body">
              <h1>Acceder</h1>
              <p class="text-muted">Control de acceso al sistema</p>
              <div class="form-group mb-3{{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="row">
                <div class="col-6">
                  <button type="submit" class="btn btn-primary px-4">Acceder</button><hr>
                  Recuerdame <input type="checkbox" name="recuerda" id="recuerda">
                </div>
              </div>
            </div>
        </form>
        </div>
        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
        <div class="card-body text-center">
            <div>
            <h2>Sistema de Ventas KastenV2</h2>
            <p>Sistema de inventario</p>
            <p>Desarrollado por  ABA Cientifica S.A.S todos los derechos reservados</p>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
<script type="text/javascript">
  window.onload = function() {
    let usuario = document.getElementById('usuario')
    let Storage = window.localStorage.getItem("UsuarioReg")
    let check = document.getElementById('recuerda').checked;
    //Validamos si hay un usuario guardado en el storage
    if(Storage===null){
      usuario.value = ''
    }
    else{
      usuario.value = Storage;
      document.getElementById('recuerda').checked = true
    }
    //Guardamos o eliminamos el usuario en el storage
    $('#recuerda').click(function(){
      let check = document.getElementById('recuerda').checked;
      if(check){
        window.localStorage.setItem("UsuarioReg", usuario.value);
      }
      else{
        window.localStorage.removeItem("UsuarioReg")
      }
    })
  };
</script>
@endsection
